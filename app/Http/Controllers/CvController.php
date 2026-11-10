<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use App\Services\CvOptimizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use RuntimeException;
use Throwable;

class CvController extends Controller
{
    public function store(Request $request, CvOptimizer $optimizer): RedirectResponse
    {
        $validated = $request->validate([
            'file_cv' => ['nullable', 'required_without:teks_cv_asli', 'file', 'max:10240', 'mimetypes:application/pdf,text/plain,image/jpeg,image/png,image/webp'],
            'teks_cv_asli' => ['nullable', 'required_without:file_cv', 'string', 'max:4000'],
            'target_posisi' => ['required', 'string', 'max:120'],
            'level_pengalaman' => ['required', 'in:Fresh Graduate,Career Switch,Experienced'],
            'bahasa_output' => ['required', 'in:Bahasa Indonesia,English'],
            'pakai_lowongan_spesifik' => ['nullable', 'boolean'],
            'deskripsi_lowongan' => ['nullable', 'string', 'max:3000'],
            'file_lowongan' => ['nullable', 'file', 'max:10240', 'mimetypes:application/pdf,image/jpeg,image/png,image/webp'],
            'template' => ['required', 'in:Klasik,Modern,Elegan'],
            'tema_warna' => ['nullable', 'in:#1D4ED8,#15803D,#B91C1C,#111827'],
            'sertakan_foto' => ['nullable', 'boolean'],
            'foto_profil' => ['nullable', 'image', 'max:2048'],
            'bentuk_foto' => ['nullable', 'in:Lingkaran,Kotak'],
        ], [
            'file_cv.required_without' => 'Unggah file CV atau tempel teks CV terlebih dahulu.',
            'teks_cv_asli.required_without' => 'Unggah file CV atau tempel teks CV terlebih dahulu.',
            'file_cv.max' => 'Ukuran file CV maksimal 10 MB.',
            'file_cv.mimetypes' => 'Format CV harus PDF, TXT, JPG, PNG, atau WEBP.',
        ]);

        $disk = Storage::disk('local');
        $cvFile = $request->file('file_cv');
        $cvPath = $cvFile?->store('cvs/original', 'local');

        if ($cvFile && ! $cvPath) {
            throw new RuntimeException('File CV gagal disimpan.');
        }

        $originalText = trim($validated['teks_cv_asli'] ?? '');
        $document = null;

        if ($cvFile) {
            $mime = $cvFile->getMimeType();
            $contents = $disk->get($cvPath);

            if ($mime === 'text/plain') {
                $originalText = trim($originalText . "\n\n" . $contents);
            } else {
                $document = ['contents' => $contents, 'mime' => $mime];
            }
        }

        $lowonganPath = $request->file('file_lowongan')?->store('cvs/job-postings', 'local');
        $photoPath = $request->file('foto_profil')?->store('cvs/photos', 'local');

        $cv = Cv::create([
            'kode_pesanan' => Str::upper(Str::random(32)),
            'teks_cv_asli' => $originalText,
            'file_asli_path' => $cvPath,
            'target_posisi' => $validated['target_posisi'],
            'level_pengalaman' => $validated['level_pengalaman'],
            'bahasa_output' => $validated['bahasa_output'],
            'pakai_lowongan_spesifik' => $request->boolean('pakai_lowongan_spesifik'),
            'deskripsi_lowongan' => $validated['deskripsi_lowongan'] ?? null,
            'file_lowongan_path' => $lowonganPath,
            'template' => $validated['template'],
            'foto_path' => $photoPath,
            'pengaturan_tampilan' => [
                'tema_warna' => $validated['tema_warna'] ?? '#1D4ED8',
                'sertakan_foto' => $request->boolean('sertakan_foto'),
                'bentuk_foto' => $validated['bentuk_foto'] ?? 'Lingkaran',
            ],
            'status' => 'diproses',
        ]);

        try {
            $result = $optimizer->run(
                $originalText,
                $cv->target_posisi,
                $cv->level_pengalaman,
                $cv->bahasa_output === 'Bahasa Indonesia' ? 'id' : 'en',
                $cv->pakai_lowongan_spesifik ? $cv->deskripsi_lowongan : null,
                document: $document
            );

            $cv->update([
                'hasil_optimasi_teks' => $optimizer->plainText($result['cv']),
                'feedback_ai' => [
                    'cv' => $result['cv'],
                    'keywords_matched' => $result['keywords_matched'] ?? [],
                    'keywords_missing' => $result['keywords_missing'] ?? [],
                    'suggestions' => $result['suggestions'] ?? [],
                ],
                'skor_ats' => isset($result['ats_score']) ? (int) $result['ats_score'] : null,
                'skor_kata_kunci' => count($result['keywords_matched'] ?? []),
                'status' => 'selesai',
            ]);
        } catch (Throwable $exception) {
            Log::warning('CV optimization failed', [
                'cv_id' => $cv->id,
                'exception' => $exception::class,
            ]);

            $cv->update(['status' => 'draft']);

            return redirect()
                ->route('cv.result', $cv)
                ->with('ai_error', 'File CV sudah disimpan, tetapi analisis AI gagal. Periksa koneksi dan konfigurasi Gemini, lalu coba lagi.');
        }

        return redirect()->route('cv.result', $cv);
    }

    public function show(Cv $cv): View
    {
        return view('cv.hasil', compact('cv'));
    }
}