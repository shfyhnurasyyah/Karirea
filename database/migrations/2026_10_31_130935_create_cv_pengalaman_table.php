<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cv_pengalaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cv_id')->constrained('cvs')->onDelete('cascade');
            $table->string('posisi');
            $table->string('perusahaan');
            $table->string('periode_mulai')->nullable();
            $table->string('periode_selesai')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cv_pengalaman');
    }
};