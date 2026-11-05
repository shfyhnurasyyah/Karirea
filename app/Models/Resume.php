<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    protected $fillable = [
        'posisi',
        'nama_depan',
        'nama_belakang',
        'email',
        'foto',
    ];
}