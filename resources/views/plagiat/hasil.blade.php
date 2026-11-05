@extends('plagiat.layout')

@section('title', 'Hasil Cek Plagiat')

@php
    $detail  = $cek->hasil_detail ?? [];
    $segmen  = $detail['segmen'] ?? [];
    $sumber  = $detail['sumber'] ?? [];
    $skor    = (int) $cek->skor_kemiripan;

    $tema = [
        'orisinal' => [
            'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'judul' => 'Cukup orisinal',
            'saran' => 'Surat Anda sebagian besar ditulis dengan kata-kata sendiri. Periksa kalimat yang ditandai (jika ada) lalu kirim.',
        ],
        'sedang' => [
            'badge' => 'bg-amber-50 text-amber-700 border-amber-200',
            'judul' => 'Perlu revisi ringan',
            'saran' => 'Beberapa kalimat terdengar seperti template. Ganti dengan contoh nyata: proyek, angka, atau nama perusahaan yang dilamar.',
        ],
        'tinggi' => [
            'badge' => 'bg-rose-50 text-rose-700 border-rose-200',
            'judul' => 'Terlalu mirip template',
            'saran' => 'Sebagian besar surat mirip kalimat umum. Tulis ulang dengan pengalaman dan alasan Anda sendiri agar menonjol di mata HRD.',
        ],
    ][$cek->status_hasil] ?? null;
    $tema ??= ['badge' => 'bg-slate-50 text-slate-700 border-slate-200', 'judul' => '-', 'saran' => ''];
@endphp

@section('content')
    <a href="{{ route('plagiat.create') }}" class="text-sm font-medium text-primary hover:underline">&larr; Cek surat lain</a>

    <div class="mt-4 grid gap-6 md:grid-cols-[260px_1fr]">
        {{-- Skor --}}
        <aside class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="plagiarism-score plagiarism-score--{{ $skor }} mx-auto flex size-40 items-center justify-center rounded-full"
                 data-score="{{ $skor }}"
                 data-status="{{ $cek->status_hasil }}"
                 role="img" aria-label="Kemiripan {{ $skor }} persen">
                <div class="flex size-32 flex-col items-center justify-center rounded-full bg-white">
                    <span class="text-4xl font-bold text-dark">{{ $skor }}%</span>
                    <span class="text-xs text-slate-500">kemiripan</span>
                </div>
            </div>

            <p class="mt-5 text-center">
                <span class="inline-block rounded-full border px-3 py-1 text-sm font-semibold {{ $tema['badge'] }}">{{ $tema['judul'] }}</span>
            </p>

            <dl class="mt-6 space-y-2 text-sm">
                <div class="flex justify-between"><dt class="text-slate-500">Orisinal</dt><dd class="font-semibold text-dark">{{ $cek->skor_orisinal }}%</dd></div>
                <div class="flex justify-between"><dt class="text-slate-500">Jumlah kata</dt><dd class="font-semibold text-dark">{{ $cek->jumlah_kata }}</dd></div>
                <div class="flex justify-between"><dt class="text-slate-500">Kalimat ditandai</dt><dd class="font-semibold text-dark">{{ $detail['kalimat_mirip'] ?? 0 }} dari {{ $detail['jumlah_kalimat'] ?? 0 }}</dd></div>
            </dl>
        </aside>

        {{-- Teks dengan sorotan --}}
        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-7">
            <p class="text-[15px] leading-relaxed text-slate-600">{{ $tema['saran'] }}</p>

            <h2 class="mt-6 text-sm font-semibold text-dark">Teks Anda</h2>
            <p class="mt-1 text-xs text-slate-500">Kalimat yang disorot mirip dengan korpus referensi. Arahkan kursor untuk melihat sumbernya.</p>

            <div class="mt-4 max-w-prose text-[15px] leading-8 text-slate-800">
                @foreach ($segmen as $s)
                    @if ($s['mirip'])
                        <mark class="rounded bg-amber-100 px-0.5 text-slate-900 underline decoration-amber-500 decoration-2 underline-offset-4"
                              title="Mirip {{ $s['kemiripan'] }}% dengan: {{ $s['sumber'] }}">{{ $s['teks'] }}</mark>
                    @else
                        <span>{{ $s['teks'] }}</span>
                    @endif
                @endforeach
            </div>

            @if (count($sumber))
                <h2 class="mt-8 text-sm font-semibold text-dark">Mirip dengan</h2>
                <ul class="mt-2 divide-y divide-slate-100 text-sm">
                    @foreach ($sumber as $s)
                        <li class="flex justify-between gap-4 py-2">
                            <span class="text-slate-700">{{ $s['judul'] }}</span>
                            <span class="shrink-0 text-slate-500">{{ $s['jumlah_kalimat'] }} kalimat</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="mt-8 rounded-xl bg-emerald-50 p-4 text-sm text-emerald-800">Tidak ada kalimat yang cocok dengan korpus referensi.</p>
            @endif

            <div class="mt-8 flex flex-wrap gap-3 border-t border-slate-100 pt-6">
                <a href="{{ route('plagiat.create') }}" class="rounded-xl bg-primary px-5 py-2.5 text-sm font-semibold text-white hover:bg-dark focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">Cek surat baru</a>
                <a href="{{ route('cv.create') }}" class="rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 hover:border-primary hover:text-primary">Perbaiki CV saya</a>
            </div>
        </section>
    </div>
@endsection
