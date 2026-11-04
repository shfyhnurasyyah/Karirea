<?php

namespace Tests\Feature;

use App\Models\PlagiatCek;
use App\Models\PlagiatReferensi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlagiatTest extends TestCase
{
    use RefreshDatabase;
    public function test_halaman_create_plagiat_dapat_diakses(): void
    {
        $response = $this->get(route('plagiat.create'));
        $response->assertStatus(200);
        $response->assertSee('Cek kemiripan surat lamaran Anda');
    }

    public function test_cek_plagiat_berhasil_dan_redirect_ke_halaman_hasil(): void
    {
        $teks = 'Dengan hormat, Berdasarkan informasi lowongan pekerjaan yang saya peroleh, saya bermaksud mengajukan diri untuk mengisi posisi yang tersedia di perusahaan Bapak/Ibu. Saya adalah lulusan yang memiliki semangat belajar tinggi dan mampu bekerja sama dalam tim maupun secara mandiri. Besar harapan saya untuk dapat diberi kesempatan wawancara agar dapat menjelaskan lebih lanjut mengenai kemampuan saya.';

        $response = $this->post(route('plagiat.store'), [
            'teks_lamaran' => $teks,
        ]);

        $this->assertDatabaseCount('plagiat_cek', 1);

        $cek = PlagiatCek::first();
        $this->assertNotNull($cek);
        $response->assertRedirect(route('plagiat.show', $cek));

        $showResponse = $this->get(route('plagiat.show', $cek));
        $showResponse->assertStatus(200);
        $showResponse->assertSee((string) $cek->skor_kemiripan . '%');
        $showResponse->assertSee('Teks Anda');
    }
}
