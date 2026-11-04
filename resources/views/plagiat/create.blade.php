@extends('plagiat.layout')

@section('title', 'Cek Plagiat Surat Lamaran')

@section('content')
    <div class="max-w-2xl">
        <h1 class="text-3xl font-bold tracking-tight text-dark sm:text-4xl">Cek kemiripan surat lamaran Anda</h1>
        <p class="mt-3 text-base leading-relaxed text-slate-600">
            Tempel surat lamaran. Kami menandai kalimat yang terlalu mirip dengan kalimat klise yang dipakai banyak pelamar,
            supaya Anda bisa menulis ulang dengan gaya sendiri sebelum dikirim ke HRD.
        </p>
    </div>

    <form action="{{ route('plagiat.store') }}" method="POST" class="mt-8 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
        @csrf

        <label for="teks_lamaran" class="block text-sm font-semibold text-dark">Teks surat lamaran</label>
        <textarea
            id="teks_lamaran"
            name="teks_lamaran"
            rows="14"
            maxlength="30000"
            placeholder="Tempel surat lamaran Anda di sini…"
            class="mt-2 w-full rounded-xl border bg-slate-50 p-4 text-[15px] leading-relaxed text-slate-800 placeholder:text-slate-400 focus:border-primary focus:bg-white focus:outline-2 focus:outline-primary/30 @error('teks_lamaran') border-rose-400 @else border-slate-300 @enderror"
        >{{ old('teks_lamaran') }}</textarea>

        <div class="mt-2 flex items-start justify-between gap-4 text-sm">
            <div>
                @error('teks_lamaran')
                    <p class="font-medium text-rose-600" role="alert">{{ $message }}</p>
                @else
                    <p class="text-slate-500">Minimal 100 karakter.</p>
                @enderror
            </div>
            <p class="shrink-0 text-slate-500"><span id="jumlah-kata">0</span> kata</p>
        </div>

        <div class="mt-6 flex flex-wrap items-center gap-4">
            <button type="submit" class="rounded-xl bg-primary px-6 py-3 text-sm font-semibold text-white transition hover:bg-dark focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">
                Cek kemiripan
            </button>
            <p class="text-sm text-slate-500">Tanpa login. Teks disimpan agar hasil bisa dibuka lagi lewat tautan.</p>
        </div>
    </form>

    <section class="mt-10 grid gap-6 text-sm leading-relaxed text-slate-600 sm:grid-cols-3">
        <div>
            <h2 class="font-semibold text-dark">Dipecah per kalimat</h2>
            <p class="mt-1">Setiap kalimat dibandingkan satu per satu, jadi Anda tahu persis bagian mana yang bermasalah.</p>
        </div>
        <div>
            <h2 class="font-semibold text-dark">Frasa yang disalin ikut terdeteksi</h2>
            <p class="mt-1">Selain kalimat yang identik, rangkaian tiga kata yang sama dengan template juga dihitung.</p>
        </div>
        <div>
            <h2 class="font-semibold text-dark">Skor dari kalimat yang ditandai</h2>
            <p class="mt-1">Skor kemiripan adalah persentase kata Anda yang berada di kalimat yang ditandai.</p>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const area = document.getElementById('teks_lamaran');
    const hitung = document.getElementById('jumlah-kata');
    const update = () => {
        const t = area.value.trim();
        hitung.textContent = t ? t.split(/\s+/).length : 0;
    };
    area.addEventListener('input', update);
    update();
</script>
@endpush
