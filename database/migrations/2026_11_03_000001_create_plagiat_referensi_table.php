<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plagiat_referensi', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('sumber')->nullable();
            $table->longText('isi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plagiat_referensi');
    }
};
