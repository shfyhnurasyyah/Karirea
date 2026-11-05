<?php

namespace Tests\Feature;

use Tests\TestCase;

class CvOptimasiTest extends TestCase
{
    public function test_halaman_pratinjau_optimasi_cv_dapat_diakses(): void
    {
        $response = $this->get(route('cv.optimasi'));

        $response->assertOk();
        $response->assertSee('Kami sedang memoles CV kamu');
        $response->assertSee('Product Designer');
        $response->assertSee('Fitur analisis AI belum terhubung');
    }

    public function test_formulir_cv_meneruskan_target_posisi_ke_halaman_optimasi(): void
    {
        $response = $this->post(route('cv.store'), [
            'target_posisi' => 'Data Analyst',
        ]);

        $response->assertOk();
        $response->assertSee('Data Analyst');
    }
}
