<?php

namespace App\Console\Commands;

use App\Services\CvOptimizer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CvTry extends Command
{
    protected $signature = 'cv:try {file : nama file CV contoh di folder samples} {--posisi= : target posisi} {--level= : level pengalaman} {--bahasa= : id atau en}';
    protected $description = 'Uji CvOptimizer dengan CV contoh';

    public function handle(CvOptimizer $optimizer): int
    {
        $path = Storage::path('samples/' . $this->argument('file'));

        if (! File::exists($path)) {
            $this->error("File tidak ditemukan: {$path}");
            return self::FAILURE;
        }

        $result = $optimizer->run(
            File::get($path),
            $this->option('posisi') ?: 'Staff Administrasi',
            $this->option('level') ?: 'fresh_graduate',
            $this->option('bahasa') ?: 'id',
        );

        $this->line(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        return self::SUCCESS;
    }
}
