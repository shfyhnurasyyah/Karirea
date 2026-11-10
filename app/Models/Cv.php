<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    protected $fillable = [
        'kode_pesanan',
        'teks_cv_asli',
        'file_asli_path',
        'target_posisi',
        'level_pengalaman',
        'bahasa_output',
        'pakai_lowongan_spesifik',
        'deskripsi_lowongan',
        'file_lowongan_path',
        'template',
        'foto_path',
        'pengaturan_tampilan',
        'hasil_optimasi_teks',
        'hasil_optimasi_html',
        'feedback_ai',
        'skor_ats',
        'skor_kata_kunci',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'pakai_lowongan_spesifik' => 'boolean',
            'pengaturan_tampilan' => 'array',
            'feedback_ai' => 'array',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'kode_pesanan';
    }
}