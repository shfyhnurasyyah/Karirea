<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class GeminiClient
{
    /**
     * Kirim permintaan ke Gemini.
     * Otomatis mencoba ulang saat server sibuk (429/500/503),
     * lalu pindah ke model cadangan bila diisi di .env.
     */
    public function generate(array $parts, ?string $system = null, bool $json = false): string
    {
        $payload = [
            'contents' => [['role' => 'user', 'parts' => $parts]],
            'generationConfig' => ['temperature' => 0.4],
        ];

        if ($system) {
            $payload['systemInstruction'] = ['parts' => [['text' => $system]]];
        }

        if ($json) {
            $payload['generationConfig']['responseMimeType'] = 'application/json';
        }

        // Model utama dulu, lalu cadangan (kalau diisi)
        $models = array_values(array_filter([
            config('services.gemini.model'),
            config('services.gemini.fallback_model'),
        ]));

        $last = null;

        foreach ($models as $model) {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent";

            $res = Http::withHeaders(['x-goog-api-key' => config('services.gemini.key')])
                ->timeout(60)
                ->retry(
                    3,
                    2000, // jeda 2 detik antar percobaan
                    when: fn ($e) => $e instanceof ConnectionException
                        || ($e instanceof RequestException
                            && in_array($e->response->status(), [429, 500, 503])),
                    throw: false
                )
                ->post($url, $payload);

            if ($res->successful()) {
                return $this->extractText($res->json('candidates.0.content.parts', []));
            }

            Log::warning('Gemini error', [
                'model'  => $model,
                'status' => $res->status(),
                'body'   => $res->body(),
            ]);
            $last = $res;

            // Error selain ini (misalnya 400/403) tidak akan membaik dengan ganti model
            if (! in_array($res->status(), [404, 429, 500, 503])) {
                break;
            }
        }

        throw new RuntimeException(
            'Layanan AI error (' . ($last?->status() ?? 'tanpa respons') . '): ' . ($last?->body() ?? '')
        );
    }

    /**
     * OCR untuk gambar atau PDF hasil scan.
     */
    public function ocr(string $binary, string $mime): string
    {
        return $this->generate([
            ['inline_data' => ['mime_type' => $mime, 'data' => base64_encode($binary)]],
            ['text' => 'Salin seluruh teks pada dokumen ini apa adanya. Jangan menambah komentar.'],
        ]);
    }

    /**
     * Gabungkan semua bagian teks jawaban, abaikan bagian "thought" bila ada.
     */
    private function extractText(array $parts): string
    {
        return collect($parts)
            ->reject(fn ($p) => ! empty($p['thought']))
            ->pluck('text')
            ->filter()
            ->implode('');
    }
}
