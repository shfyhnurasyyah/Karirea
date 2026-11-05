<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GeminiModels extends Command
{
    protected $signature = 'gemini:models';
    protected $description = 'Tes model Gemini mana yang menjawab';

    public function handle(): int
    {
        $key = config('services.gemini.key');

        $names = collect(
            Http::withHeaders(['x-goog-api-key' => $key])
                ->get('https://generativelanguage.googleapis.com/v1beta/models', ['pageSize' => 100])
                ->json('models', [])
        )
            ->filter(fn ($m) => in_array('generateContent', $m['supportedGenerationMethods'] ?? []))
            ->pluck('name')
            ->filter(fn ($n) => str_contains($n, 'flash')
                && ! preg_match('/tts|image|live|audio|native|embedding/', $n));

        foreach ($names as $name) {
            $start = microtime(true);
            try {
                $res = Http::withHeaders(['x-goog-api-key' => $key])
                    ->timeout(45)
                    ->post("https://generativelanguage.googleapis.com/v1beta/{$name}:generateContent", [
                        'contents' => [['parts' => [['text' => 'Balas dengan kata: halo']]]],
                    ]);
                $status = $res->status();
            } catch (\Throwable $e) {
                $status = 'TIMEOUT';
            }
            $this->line(str_pad($name, 50) . ' => ' . $status . ' (' . round(microtime(true) - $start, 1) . ' dtk)');
        }

        return self::SUCCESS;
    }
}
