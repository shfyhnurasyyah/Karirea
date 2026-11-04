<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plagiat_cek', function (Blueprint $table) {
            $table->id();
            $table->string('kode_cek', 12)->unique();
            $table->longText('teks_lamaran');
            $table->unsignedSmallInteger('jumlah_kata')->default(0);
            $table->unsignedTinyInteger('skor_kemiripan')->default(0); // 0-100
            $table->unsignedTinyInteger('skor_orisinal')->default(100); // 0-100
            $table->string('status_hasil', 20); // orisinal | sedang | tinggi
            $table->json('hasil_detail')->nullable(); // segmen kalimat + daftar sumber
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plagiat_cek');
    }
};
