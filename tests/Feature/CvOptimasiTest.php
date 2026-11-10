<?php

namespace Tests\Feature;

use App\Models\Cv;
use App\Services\CvOptimizer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CvOptimasiTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_pratinjau_optimasi_cv_dapat_diakses(): void
    {
        $response = $this->get(route('cv.optimasi'));

        $response->assertOk();
        $response->assertSee('Kami sedang memoles CV kamu');
        $response->assertSee('Product Designer');
        $response->assertSee('Ini contoh tampilan proses');
    }

    public function test_formulir_menyimpan_file_cv_dan_hasil_optimasi(): void
    {
        Storage::fake('local');
        $optimizer = $this->mock(CvOptimizer::class);
        $optimizer->shouldReceive('run')->once()->andReturn([
            'cv' => ['name' => 'Budi', 'headline' => 'Staff Administrasi'],
            'ats_score' => 80,
            'keywords_matched' => ['Administrasi'],
            'keywords_missing' => [],
            'suggestions' => [],
        ]);
        $optimizer->shouldReceive('plainText')->once()->andReturn("Budi\nStaff Administrasi");

        $response = $this->post(route('cv.store'), [
            'file_cv' => UploadedFile::fake()->createWithContent('budi.txt', 'Nama: Budi\nPengalaman: Administrasi'),
            'target_posisi' => 'Data Analyst',
            'level_pengalaman' => 'Fresh Graduate',
            'bahasa_output' => 'Bahasa Indonesia',
            'template' => 'Klasik',
        ]);

        $cv = Cv::firstOrFail();
        $response->assertRedirect(route('cv.result', $cv));
        $this->assertDatabaseHas('cvs', [
            'id' => $cv->id,
            'target_posisi' => 'Data Analyst',
            'hasil_optimasi_teks' => "Budi\nStaff Administrasi",
            'skor_ats' => 80,
            'status' => 'selesai',
        ]);
        $this->assertNotSame((string) $cv->id, $cv->kode_pesanan);
        Storage::disk('local')->assertExists($cv->file_asli_path);
        $this->get(route('cv.result', $cv))
            ->assertOk()
            ->assertSee('CV kamu sudah siap')
            ->assertSee('Staff Administrasi');
    }

    public function test_formulir_menerima_teks_cv_tanpa_file(): void
    {
        $optimizer = $this->mock(CvOptimizer::class);
        $optimizer->shouldReceive('run')->once()->andReturn(['cv' => ['name' => 'Budi']]);
        $optimizer->shouldReceive('plainText')->once()->andReturn('Budi');

        $response = $this->post(route('cv.store'), [
            'teks_cv_asli' => 'Nama: Budi, pengalaman administrasi.',
            'target_posisi' => 'Staff Administrasi',
            'level_pengalaman' => 'Fresh Graduate',
            'bahasa_output' => 'Bahasa Indonesia',
            'template' => 'Klasik',
        ]);

        $cv = Cv::firstOrFail();
        $response->assertRedirect(route('cv.result', $cv));
        $this->assertNull($cv->file_asli_path);
        $this->assertSame('Nama: Budi, pengalaman administrasi.', $cv->teks_cv_asli);
    }

    public function test_formulir_mewajibkan_file_atau_teks_cv(): void
    {
        $response = $this->from(route('cv.create'))->post(route('cv.store'), [
            'target_posisi' => 'Staff Administrasi',
            'level_pengalaman' => 'Fresh Graduate',
            'bahasa_output' => 'Bahasa Indonesia',
            'template' => 'Klasik',
        ]);

        $response->assertSessionHasErrors(['file_cv', 'teks_cv_asli']);
    }

    public function test_file_cv_dibatasi_maksimal_10_mb(): void
    {
        $response = $this->from(route('cv.create'))->post(route('cv.store'), [
            'file_cv' => UploadedFile::fake()->create('budi.txt', 10241, 'text/plain'),
            'target_posisi' => 'Staff Administrasi',
            'level_pengalaman' => 'Fresh Graduate',
            'bahasa_output' => 'Bahasa Indonesia',
            'template' => 'Klasik',
        ]);

        $response->assertSessionHasErrors(['file_cv']);
    }

    public function test_file_tetap_tersimpan_jika_analisis_gemini_gagal(): void
    {
        Storage::fake('local');
        $this->mock(CvOptimizer::class)
            ->shouldReceive('run')
            ->once()
            ->andThrow(new \RuntimeException('Koneksi gagal'));

        $response = $this->post(route('cv.store'), [
            'file_cv' => UploadedFile::fake()->createWithContent('budi.txt', 'Nama: Budi'),
            'target_posisi' => 'Staff Administrasi',
            'level_pengalaman' => 'Fresh Graduate',
            'bahasa_output' => 'Bahasa Indonesia',
            'template' => 'Klasik',
        ]);

        $cv = Cv::firstOrFail();
        $response->assertRedirect(route('cv.result', $cv));
        $this->assertSame('draft', $cv->status);
        Storage::disk('local')->assertExists($cv->file_asli_path);

        $this->get(route('cv.result', $cv))
            ->assertOk()
            ->assertSee('File CV kamu tersimpan')
            ->assertSee('Analisis AI belum berhasil');
    }
}
