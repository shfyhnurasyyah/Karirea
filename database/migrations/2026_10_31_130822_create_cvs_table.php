<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cvs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pesanan')->unique()->nullable();

            $table->longText('teks_cv_asli');
            $table->string('file_asli_path')->nullable();
            $table->string('target_posisi');
            $table->enum('level_pengalaman', ['Fresh Graduate', 'Career Switch', 'Experienced'])->nullable();
            $table->enum('bahasa_output', ['Bahasa Indonesia', 'English'])->default('Bahasa Indonesia');

            $table->boolean('pakai_lowongan_spesifik')->default(false);
            $table->longText('deskripsi_lowongan')->nullable();
            $table->string('file_lowongan_path')->nullable();
            $table->text('teks_lowongan_hasil_ekstrak')->nullable();

            $table->enum('template', ['Klasik', 'Modern', 'Elegan'])->default('Klasik');
            $table->string('foto_path')->nullable();
            $table->json('pengaturan_tampilan')->nullable();

            $table->longText('hasil_optimasi_teks')->nullable();
            $table->longText('hasil_optimasi_html')->nullable();
            $table->json('feedback_ai')->nullable();
            $table->integer('skor_ats')->nullable();
            $table->integer('skor_kata_kunci')->nullable();

            $table->enum('status', ['draft', 'diproses', 'selesai', 'dibayar'])->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cvs');
    }
};