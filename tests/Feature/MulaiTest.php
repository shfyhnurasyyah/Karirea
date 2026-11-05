<?php

namespace Tests\Feature;

use Tests\TestCase;

class MulaiTest extends TestCase
{
    public function test_halaman_mulai_gratis_dapat_diakses(): void
    {
        $response = $this->get(route('mulai'));

        $response->assertOk();
        $response->assertViewIs('mulai');
        $response->assertSee('<html lang="id">', false);
        $response->assertSee('Mulai gratis — KARIREA');
        $response->assertSee('Anda ingin mulai dari mana?');
        $response->assertSee('Buat CV baru');
        $response->assertSee('AI memandu Anda langkah demi langkah');
        $response->assertSee('Unggah CV Anda');
        $response->assertSee('AI mengimpor dan memperbaiki teks Anda');
        $response->assertSee('Sudah punya akun?');
        $response->assertSee('Masuk');
        $response->assertSee(route('landing'));
        $response->assertSee(route('cv.create'));
        $response->assertSee(route('cv.create', ['mode' => 'unggah']));
        $response->assertSee(route('admin.login'));
        $response->assertSee('Syarat dan ketentuan');
        $response->assertSee('Kebijakan privasi');
        $response->assertDontSee('membuat akun');

        // Verify there is exactly one h1 tag
        $content = $response->getContent();
        $this->assertSame(1, substr_count($content, '<h1'));

        // Verify brand color usage and absence of orange CV maker colors
        $this->assertStringContainsString('#1F8A8C', $content);
        $this->assertStringContainsString('#16313A', $content);
        $this->assertStringNotContainsString('orange', strtolower($content));
    }

    public function test_landing_page_mengarahkan_mulai_gratis_ke_halaman_mulai(): void
    {
        $response = $this->get(route('landing'));

        $response->assertOk();
        $response->assertSee(route('mulai'));
        $response->assertSee('Mulai gratis');

        // Ensure other actions on landing remain intact
        $response->assertSee(route('cv.create'));
        $response->assertSee('Perbaiki CV');
        $response->assertSee(route('plagiat.create'));
        $response->assertSee('Cek Plagiat');
    }

    public function test_halaman_cv_create_mendukung_mode_unggah(): void
    {
        $response = $this->get(route('cv.create', ['mode' => 'unggah']));

        $response->assertOk();
        $response->assertSee("new URLSearchParams(location.search).get('mode') === 'unggah'", false);
        $response->assertSee("document.querySelector('input[type=\"file\"]')", false);
    }
}
