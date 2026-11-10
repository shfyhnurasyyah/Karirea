<!DOCTYPE html>
<html lang="id" class="theme-optimasi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#f4f8f8" />
    <title>Optimasi CV — KARIREA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
    @vite('resources/css/app.css')
    <script src="https://code.iconify.design/iconify-icon/3.0.0/iconify-icon.min.js"></script>
  </head>
  <body class="min-h-screen bg-[var(--surface)] antialiased">
    <header class="border-b border-[var(--border)] bg-white">
      <div class="mx-auto flex min-h-12 max-w-5xl items-center justify-between px-5 py-2 sm:px-7">
        <a href="{{ route('landing') }}" class="flex items-center gap-2 font-heading text-base font-bold tracking-tight text-black" aria-label="KARIREA, kembali ke beranda">
          <span class="flex h-6 w-6 items-center justify-center rounded-full bg-[var(--teal)] text-white">
            <iconify-icon icon="lucide:sparkles" class="text-sm"></iconify-icon>
          </span>
          KARIREA
        </a>
        <span class="text-xs font-medium text-slate-500 sm:text-sm">Optimasi CV</span>
      </div>
    </header>

    <main class="mx-auto flex min-h-[calc(100vh-3rem)] w-full max-w-3xl flex-col items-center justify-center px-4 py-10 sm:px-6 sm:py-12">
      <section class="w-full rounded-xl bg-white p-5 text-center shadow-[0_2px_5px_rgba(22,49,58,0.12)] sm:p-8" aria-labelledby="page-title">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-[#e8f4f4] text-[var(--teal)]" aria-hidden="true">
          <iconify-icon icon="lucide:loader" class="spin text-3xl"></iconify-icon>
        </div>

        <div class="mt-4 text-center">
          <p class="text-xs font-semibold uppercase tracking-wide text-[var(--teal)]">Analisis sedang berjalan</p>
          <h1 id="page-title" class="mt-2 text-2xl font-bold tracking-tight sm:text-3xl">Kami sedang memoles CV kamu</h1>
          <p class="mx-auto mt-3 max-w-xl text-sm leading-6 text-slate-500">
            KARIREA akan menyesuaikan pengalamanmu dengan target posisi
            <span class="font-semibold text-slate-700">{{ $targetPosisi }}</span>.
          </p>
        </div>

        <ol class="mx-auto mt-8 max-w-xl space-y-3 text-left" aria-label="Tahapan optimasi CV">
          <li class="flex items-center gap-3 rounded-xl bg-[#e8f4f4] p-3 sm:gap-4 sm:p-4">
            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[var(--teal)] text-white" aria-hidden="true">
              <iconify-icon icon="lucide:check"></iconify-icon>
            </span>
            <div class="min-w-0 flex-1">
              <p class="text-sm font-semibold">Membaca struktur CV</p>
              <p class="text-xs leading-5 text-slate-500">Pengalaman, pendidikan, dan keahlian akan ditinjau.</p>
            </div>
            <span class="shrink-0 text-xs font-semibold text-[var(--teal)]">Selesai</span>
          </li>

          <li class="flex items-center gap-3 rounded-xl border border-[var(--teal)] bg-white p-3 sm:gap-4 sm:p-4" aria-current="step">
            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[var(--teal)] text-white" aria-hidden="true">
              <iconify-icon icon="lucide:loader"></iconify-icon>
            </span>
            <div class="min-w-0 flex-1">
              <p class="text-sm font-semibold">Mencocokkan kata kunci ATS</p>
              <p class="text-xs leading-5 text-slate-500">Kata kunci relevan akan diselaraskan dengan target posisi.</p>
            </div>
            <span class="shrink-0 text-xs font-semibold text-[var(--teal)]">Berjalan</span>
          </li>

          <li class="flex items-center gap-3 rounded-xl bg-[var(--surface)] p-3 sm:gap-4 sm:p-4">
            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white text-slate-400" aria-hidden="true">
              <iconify-icon icon="lucide:sparkles"></iconify-icon>
            </span>
            <div class="min-w-0 flex-1">
              <p class="text-sm font-semibold">Merumuskan rekomendasi</p>
              <p class="text-xs leading-5 text-slate-500">Saran perbaikan akan ditampilkan setelah analisis.</p>
            </div>
          </li>
        </ol>

        <div class="mx-auto mt-8 max-w-xl" role="progressbar" aria-label="Contoh progres analisis" aria-valuemin="0" aria-valuemax="100" aria-valuenow="68">
          <div class="flex items-center justify-between text-sm text-slate-500">
            <span>Contoh progres analisis</span>
            <span class="font-semibold text-[var(--teal)]">68%</span>
          </div>
          <div class="mt-2 h-3 overflow-hidden rounded-full bg-[var(--surface)]">
            <div class="h-full w-[68%] rounded-full bg-[var(--teal)]"></div>
          </div>
        </div>

        <button id="sampleButton" type="button" aria-expanded="false" aria-controls="sampleResult"
          class="mt-8 inline-flex min-h-11 items-center justify-center gap-2 rounded-lg bg-[var(--teal)] px-6 text-sm font-semibold text-white transition-colors hover:bg-[#176f71] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[var(--teal)]">
          Lihat contoh hasil
          <iconify-icon icon="lucide:arrow-down" aria-hidden="true"></iconify-icon>
        </button>

        <div id="sampleResult" class="mt-4 hidden rounded-lg border border-[var(--border)] bg-white p-4 text-left" aria-live="polite">
          <p class="text-sm font-semibold">Contoh rekomendasi untuk {{ $targetPosisi }}</p>
          <ul class="mt-2 space-y-2 text-xs leading-5 text-slate-600">
            <li class="flex gap-2"><iconify-icon icon="lucide:check" class="mt-0.5 shrink-0 text-[var(--teal)]"></iconify-icon>Gunakan kata kerja aktif untuk menjelaskan pengalaman.</li>
            <li class="flex gap-2"><iconify-icon icon="lucide:check" class="mt-0.5 shrink-0 text-[var(--teal)]"></iconify-icon>Tambahkan angka atau dampak yang terukur pada pencapaian.</li>
            <li class="flex gap-2"><iconify-icon icon="lucide:check" class="mt-0.5 shrink-0 text-[var(--teal)]"></iconify-icon>Sesuaikan keahlian dengan kebutuhan posisi yang dituju.</li>
          </ul>
        </div>

        <p class="mt-4 text-center text-[10px] leading-4 text-slate-500">
          Ini contoh tampilan proses. Unggah CV dari formulir untuk menjalankan analisis yang sebenarnya.
        </p>
      </section>

      <a href="{{ route('cv.create') }}" class="mt-5 inline-flex min-h-10 items-center gap-2 rounded-lg px-4 text-xs font-semibold text-slate-600 transition-colors hover:bg-white hover:text-[var(--teal)] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[var(--teal)]">
        <iconify-icon icon="lucide:arrow-left" aria-hidden="true"></iconify-icon>
        Kembali ke formulir CV
      </a>
    </main>

    <script>
      const sampleButton = document.getElementById('sampleButton');
      const sampleResult = document.getElementById('sampleResult');

      sampleButton.addEventListener('click', () => {
        const isExpanded = sampleButton.getAttribute('aria-expanded') === 'true';
        sampleButton.setAttribute('aria-expanded', String(!isExpanded));
        sampleResult.classList.toggle('hidden', isExpanded);
        sampleButton.innerHTML = isExpanded
          ? 'Lihat contoh hasil <iconify-icon icon="lucide:arrow-down" aria-hidden="true"></iconify-icon>'
          : 'Tutup contoh hasil <iconify-icon icon="lucide:arrow-up" aria-hidden="true"></iconify-icon>';
      });
    </script>
  </body>
</html>
