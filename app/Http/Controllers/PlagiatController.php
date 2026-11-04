<?php

namespace App\Http\Controllers;

use App\Models\PlagiatCek;
use App\Models\PlagiatReferensi;
use App\Services\PlagiarismChecker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PlagiatController extends Controller
{
    public function create(): View
    {
        return view('plagiat.create');
    }

    public function store(Request $request, PlagiarismChecker $checker): RedirectResponse
    {
        $data = $request->validate([
            'teks_lamaran' => ['required', 'string', 'min:100', 'max:30000'],
        ], [
            'teks_lamaran.required' => 'Tempel teks surat lamaran Anda terlebih dahulu.',
            'teks_lamaran.min' => 'Teks terlalu pendek. Minimal 100 karakter agar hasilnya bermakna.',
            'teks_lamaran.max' => 'Teks terlalu panjang. Maksimal 30.000 karakter.',
        ]);

        $hasil = $checker->cek($data['teks_lamaran'], PlagiatReferensi::all());

        $cek = PlagiatCek::create([
            'kode_cek' => Str::upper(Str::random(10)),
            'teks_lamaran' => $data['teks_lamaran'],
            'jumlah_kata' => $hasil['jumlah_kata'],
            'skor_kemiripan' => $hasil['skor_kemiripan'],
            'skor_orisinal' => $hasil['skor_orisinal'],
            'status_hasil' => $hasil['status'],
            'hasil_detail' => [
                'segmen' => $hasil['segmen'],
                'sumber' => $hasil['sumber'],
                'jumlah_kalimat' => $hasil['jumlah_kalimat'],
                'kalimat_mirip' => $hasil['kalimat_mirip'],
            ],
        ]);

        return redirect()->route('plagiat.show', $cek);
    }

    public function show(PlagiatCek $cek): View
    {
        return view('plagiat.hasil', ['cek' => $cek]);
    }
}
