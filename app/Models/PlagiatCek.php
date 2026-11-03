<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlagiatCek extends Model
{
    protected $table = 'plagiat_cek';

    protected $fillable = [
        'kode_cek',
        'teks_lamaran',
        'jumlah_kata',
        'skor_kemiripan',
        'skor_orisinal',
        'status_hasil',
        'hasil_detail',
    ];

    protected $casts = [
        'hasil_detail' => 'array',
    ];

    // Route model binding memakai kode_cek, bukan id (id mudah ditebak).
    public function getRouteKeyName(): string
    {
        return 'kode_cek';
    }
}
