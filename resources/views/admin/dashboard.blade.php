<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Panel Dasbor Admin — KARIREA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet" />
    @vite('resources/css/app.css')
    <script src="https://code.iconify.design/iconify-icon/3.0.0/iconify-icon.min.js"></script>
</head>
<body class="theme-landing bg-[#F8FAFA] text-[#16313A] min-h-screen flex flex-col font-sans selection:bg-[#1F8A8C] selection:text-white">
    <!-- Navbar Admin -->
    <header class="w-full border-b border-[#D9E6E6] bg-white sticky top-0 z-20">
        <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-6 py-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 font-heading text-xl font-bold text-[#16313A]">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#1F8A8C] text-white shadow-sm">
                        <iconify-icon icon="lucide:sparkles" class="text-lg"></iconify-icon>
                    </span>
                    <span>KARIREA <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-[#E8F4F4] text-[#1F8A8C] ml-1">Admin</span></span>
                </a>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('landing') }}" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 text-xs font-semibold text-[#62757B] hover:text-[#1F8A8C] px-3 py-2 rounded-lg border border-[#D9E6E6] hover:bg-[#F5F8F8] transition">
                    <iconify-icon icon="lucide:external-link" class="text-sm"></iconify-icon>
                    Lihat Web Publik
                </a>

                <div class="flex items-center gap-3 pl-2 border-l border-[#D9E6E6]">
                    <div class="text-right hidden sm:block">
                        <div class="text-xs font-bold text-[#16313A]">{{ Auth::user()->name }}</div>
                        <div class="text-[11px] text-[#62757B]">{{ Auth::user()->email }}</div>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 transition">
                            <iconify-icon icon="lucide:log-out" class="text-sm"></iconify-icon>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Admin Dashboard -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-6 py-8">
        <!-- Notifikasi Status -->
        @if (session('status'))
            <div class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50/90 p-4 text-sm text-emerald-800">
                <iconify-icon icon="lucide:check-circle-2" class="text-lg text-emerald-600 mt-0.5 shrink-0"></iconify-icon>
                <div class="font-medium">{{ session('status') }}</div>
            </div>
        @endif

        <!-- Header Ringkasan -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="font-heading text-2xl sm:text-3xl font-extrabold text-[#16313A]">
                    Dasbor Administrator
                </h1>
                <p class="text-sm text-[#62757B] mt-1">
                    Ringkasan performa dan pemantauan aktivitas aplikasi KARIREA.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('plagiat.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold bg-white border border-[#D9E6E6] hover:bg-[#F5F8F8] text-[#16313A] transition shadow-sm">
                    <iconify-icon icon="lucide:file-search" class="text-sm text-[#1F8A8C]"></iconify-icon>
                    Uji Cek Plagiat
                </a>
                <a href="{{ route('cv.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold bg-[#1F8A8C] text-white hover:bg-[#167072] transition shadow-sm">
                    <iconify-icon icon="lucide:plus" class="text-sm"></iconify-icon>
                    Formulir CV
                </a>
            </div>
        </div>

        <!-- Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
            <!-- Card 1: Plagiat Cek -->
            <div class="rounded-2xl border border-[#D9E6E6] bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#62757B]">Total Cek Plagiat</span>
                    <span class="h-9 w-9 rounded-xl bg-[#E8F4F4] text-[#1F8A8C] flex items-center justify-center">
                        <iconify-icon icon="lucide:file-text" class="text-lg"></iconify-icon>
                    </span>
                </div>
                <div class="mt-4 flex items-baseline gap-2">
                    <span class="font-heading text-3xl font-extrabold text-[#16313A]">{{ $totalPlagiatCek }}</span>
                    <span class="text-xs text-[#62757B]">dokumen dicek</span>
                </div>
            </div>

            <!-- Card 2: CV Dibuat -->
            <div class="rounded-2xl border border-[#D9E6E6] bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#62757B]">Total Entri CV</span>
                    <span class="h-9 w-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                        <iconify-icon icon="lucide:user-check" class="text-lg"></iconify-icon>
                    </span>
                </div>
                <div class="mt-4 flex items-baseline gap-2">
                    <span class="font-heading text-3xl font-extrabold text-[#16313A]">{{ $totalCv }}</span>
                    <span class="text-xs text-[#62757B]">draf & terproses</span>
                </div>
            </div>

            <!-- Card 3: Referensi Plagiat -->
            <div class="rounded-2xl border border-[#D9E6E6] bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#62757B]">Basis Dokumen Referensi</span>
                    <span class="h-9 w-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                        <iconify-icon icon="lucide:database" class="text-lg"></iconify-icon>
                    </span>
                </div>
                <div class="mt-4 flex items-baseline gap-2">
                    <span class="font-heading text-3xl font-extrabold text-[#16313A]">{{ $totalReferensi }}</span>
                    <span class="text-xs text-[#62757B]">korpus teks referensi</span>
                </div>
            </div>
        </div>

        <!-- Content Grid: Aktivitas Terbaru -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Riwayat Cek Plagiat Terbaru -->
            <div class="rounded-2xl border border-[#D9E6E6] bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-heading font-bold text-base text-[#16313A] flex items-center gap-2">
                        <iconify-icon icon="lucide:clock" class="text-[#1F8A8C]"></iconify-icon>
                        Riwayat Cek Plagiat Terbaru
                    </h2>
                </div>

                @if ($recentPlagiat->isEmpty())
                    <div class="text-center py-10 border border-dashed border-[#D9E6E6] rounded-xl">
                        <iconify-icon icon="lucide:file-x" class="text-3xl text-[#62757B]/40 mb-2"></iconify-icon>
                        <p class="text-xs text-[#62757B]">Belum ada riwayat pengecekan plagiat.</p>
                    </div>
                @else
                    <div class="divide-y divide-[#D9E6E6] text-xs">
                        @foreach ($recentPlagiat as $cek)
                            <div class="py-3 flex items-center justify-between">
                                <div>
                                    <div class="font-mono font-bold text-[#16313A]">{{ $cek->kode_cek }}</div>
                                    <div class="text-[11px] text-[#62757B] mt-0.5">
                                        {{ $cek->jumlah_kata }} kata &bull; {{ $cek->created_at?->diffForHumans() ?? 'Baru saja' }}
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full font-semibold {{ $cek->skor_kemiripan > 30 ? 'bg-rose-50 text-rose-700' : 'bg-emerald-50 text-emerald-700' }}">
                                        Kemiripan: {{ $cek->skor_kemiripan }}%
                                    </span>
                                    <a href="{{ route('plagiat.show', $cek) }}" class="text-[#1F8A8C] hover:underline font-semibold">
                                        Hasil &rarr;
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Riwayat Entri CV Terbaru -->
            <div class="rounded-2xl border border-[#D9E6E6] bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-heading font-bold text-base text-[#16313A] flex items-center gap-2">
                        <iconify-icon icon="lucide:file-badge" class="text-[#1F8A8C]"></iconify-icon>
                        Entri CV Terbaru
                    </h2>
                </div>

                @if ($recentCvs->isEmpty())
                    <div class="text-center py-10 border border-dashed border-[#D9E6E6] rounded-xl">
                        <iconify-icon icon="lucide:folder-closed" class="text-3xl text-[#62757B]/40 mb-2"></iconify-icon>
                        <p class="text-xs text-[#62757B]">Belum ada data CV yang tersimpan.</p>
                    </div>
                @else
                    <div class="divide-y divide-[#D9E6E6] text-xs">
                        @foreach ($recentCvs as $cv)
                            <div class="py-3 flex items-center justify-between">
                                <div>
                                    <div class="font-semibold text-[#16313A]">{{ $cv->target_posisi }}</div>
                                    <div class="text-[11px] text-[#62757B] mt-0.5">
                                        Bahasa: {{ $cv->bahasa_output }} &bull; Template: {{ $cv->template }}
                                    </div>
                                </div>
                                <div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-gray-100 text-gray-700">
                                        {{ ucfirst($cv->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </main>
</body>
</html>

