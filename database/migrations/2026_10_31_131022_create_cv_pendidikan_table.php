<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cv_pendidikan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cv_id')->constrained('cvs')->onDelete('cascade');
            $table->string('institusi');
            $table->string('jurusan')->nullable();
            $table->string('periode_mulai')->nullable();
            $table->string('periode_selesai')->nullable();
            $table->string('nilai')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cv_pendidikan');
    }
};