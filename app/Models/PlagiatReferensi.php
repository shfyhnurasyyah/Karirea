<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlagiatReferensi extends Model
{
    protected $table = 'plagiat_referensi';

    protected $fillable = ['judul', 'sumber', 'isi'];
}
