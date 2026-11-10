@php
  $feedback = $cv->feedback_ai ?? [];
  $result = $feedback['cv'] ?? [];
  $contact = $result['contact'] ?? [];
  $skills = $result['skills'] ?? [];
  $settings = $cv->pengaturan_tampilan ?? [];
  $accent = $settings['tema_warna'] ?? '#1D4ED8';
@endphp
<!DOCTYPE html>
<html lang="id" class="theme-optimasi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#f4f8f8" />
    <title>Hasil Optimasi CV — KARIREA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
    @vite('resources/css/app.css')
    <script src="https://code.iconify.design/iconify-icon/3.0.0/iconify-icon.min.js"></script>
    <style>
      .cv-document { --cv-accent: {{ $accent }}; }
      .cv-document h2, .cv-document .cv-name { color: var(--cv-accent); }
      .cv-document.modern { border-top: 8px solid var(--cv-accent); }
      .cv-document.elegan .cv-name { font-family: Georgia, serif; }
      @media print {
        body { background: white !important; }
        .no-print { display: none !important; }
        .cv-document { box-shadow: none !important; border: 0 !important; max-width: none !important; }
      }
    </style>
  </head>
  <body class="min-h-screen bg-[var(--surface)] antialiased">
    <header class="no-print border-b border-[var(--border)] bg-white">
      <div class="mx-auto flex min-h-12 max-w-5xl items-center justify-between px-5 py-2 sm:px-7">
        <a href="{{ route('landing') }}" class="flex items-center gap-2 font-heading text-base font-bold text-black" aria-label="KARIREA, kembali ke beranda">
          <span class="flex h-6 w-6 items-center justify-center rounded-full bg-[var(--teal)] text-white"><iconify-icon icon="lucide:sparkles"></iconify-icon></span>
          KARIREA
        </a>
        <div class="flex items-center gap-3">
          <span class="text-xs text-slate-500 sm:text-sm">Hasil optimasi CV</span>
          @if ($cv->status === 'selesai')
            <button type="button" onclick="window.print()" class="inline-flex min-h-9 items-center gap-2 rounded-lg border border-slate-200 px-3 text-xs font-semibold hover:bg-slate-50">
              <iconify-icon icon="lucide:printer" aria-hidden="true"></iconify-icon> Cetak
            </button>
          @endif
        </div>
      </div>
    </header>

    <main class="mx-auto w-full max-w-5xl px-4 py-8 sm:px-6 sm:py-10">
      @if (session('ai_error'))
        <div class="no-print mb-5 rounded-lg border border-amber-300 bg-amber-50 p-4 text-sm text-amber-900" role="alert">
          <p class="font-semibold">Analisis AI belum berhasil</p>
          <p class="mt-1">{{ session('ai_error') }}</p>
        </div>
      @endif

      @if ($cv->status === 'selesai')
        <div class="no-print mb-6 flex flex-wrap items-end justify-between gap-4">
          <div>
            <p class="text-xs font-semibold uppercase text-[var(--teal)]">CV untuk {{ $cv->target_posisi }}</p>
            <h1 class="mt-1 text-2xl font-bold text-slate-900">CV kamu sudah siap</h1>
          </div>
          @if ($cv->skor_ats !== null)
            <p class="text-sm font-semibold text-slate-700">Skor ATS <span class="ml-1 text-xl text-[var(--teal)]">{{ $cv->skor_ats }}</span><span class="text-slate-500">/100</span></p>
          @endif
        </div>

        <article class="cv-document {{ strtolower($cv->template) }} mx-auto max-w-3xl rounded-xl bg-white p-6 shadow-sm sm:p-10" aria-label="CV hasil optimasi">
          <header class="border-b border-slate-200 pb-5">
            <h1 class="cv-name text-3xl font-bold">{{ $result['name'] ?? 'CV' }}</h1>
            @if (! empty($result['headline']))
              <p class="mt-1 text-lg font-semibold text-slate-700">{{ $result['headline'] }}</p>
            @endif
            @if (is_array($contact))
              <div class="mt-3 flex flex-wrap gap-x-4 gap-y-1 text-xs text-slate-600">
                @foreach (['email', 'phone', 'location'] as $field)
                  @if (! empty($contact[$field])) <span>{{ $contact[$field] }}</span> @endif
                @endforeach
                @if (is_array($contact['links'] ?? null))
                  @foreach ($contact['links'] as $link)
                    @if (is_string($link) && $link !== '') <span>{{ $link }}</span> @endif
                  @endforeach
                @endif
              </div>
            @endif
          </header>

          @if (! empty($result['summary']))
            <section class="mt-6">
              <h2 class="border-b border-slate-200 pb-1 text-sm font-bold uppercase">Profil</h2>
              <p class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-700">{{ $result['summary'] }}</p>
            </section>
          @endif

          @if (is_array($result['experience'] ?? null) && count($result['experience']))
            <section class="mt-6">
              <h2 class="border-b border-slate-200 pb-1 text-sm font-bold uppercase">Pengalaman</h2>
              <div class="mt-3 space-y-4">
                @foreach ($result['experience'] as $experience)
                  <div>
                    <div class="flex flex-wrap justify-between gap-x-4">
                      <p class="font-semibold text-slate-800">{{ $experience['role'] ?? '' }}{{ ! empty($experience['company']) ? ' · ' . $experience['company'] : '' }}</p>
                      <span class="text-xs text-slate-500">{{ $experience['period'] ?? '' }}</span>
                    </div>
                    @if (is_array($experience['bullets'] ?? null))
                      <ul class="mt-1 list-disc space-y-1 pl-5 text-sm leading-5 text-slate-700">
                        @foreach ($experience['bullets'] as $bullet) <li>{{ $bullet }}</li> @endforeach
                      </ul>
                    @endif
                  </div>
                @endforeach
              </div>
            </section>
          @endif

          @if (is_array($result['education'] ?? null) && count($result['education']))
            <section class="mt-6">
              <h2 class="border-b border-slate-200 pb-1 text-sm font-bold uppercase">Pendidikan</h2>
              <div class="mt-3 space-y-3">
                @foreach ($result['education'] as $education)
                  <div>
                    <div class="flex flex-wrap justify-between gap-x-4">
                      <p class="font-semibold text-slate-800">{{ $education['school'] ?? '' }}</p>
                      <span class="text-xs text-slate-500">{{ $education['period'] ?? '' }}</span>
                    </div>
                    <p class="text-sm text-slate-600">{{ $education['degree'] ?? '' }}{{ ! empty($education['notes']) ? ' · ' . $education['notes'] : '' }}</p>
                  </div>
                @endforeach
              </div>
            </section>
          @endif

          @if (is_array($skills))
            @php($allSkills = array_merge($skills['hard'] ?? [], $skills['soft'] ?? [], $skills['tools'] ?? []))
            @if (count($allSkills))
              <section class="mt-6">
                <h2 class="border-b border-slate-200 pb-1 text-sm font-bold uppercase">Keahlian</h2>
                <p class="mt-2 text-sm leading-6 text-slate-700">{{ implode(' · ', $allSkills) }}</p>
              </section>
            @endif
          @endif

          @foreach (['certifications' => 'Sertifikasi', 'projects' => 'Proyek'] as $field => $heading)
            @if (is_array($result[$field] ?? null) && count($result[$field]))
              <section class="mt-6">
                <h2 class="border-b border-slate-200 pb-1 text-sm font-bold uppercase">{{ $heading }}</h2>
                <ul class="mt-2 list-disc space-y-1 pl-5 text-sm leading-5 text-slate-700">
                  @foreach ($result[$field] as $item)
                    <li>{{ is_array($item) ? implode(' · ', array_filter($item, 'is_string')) : $item }}</li>
                  @endforeach
                </ul>
              </section>
            @endif
          @endforeach
        </article>

        @if (count($feedback['suggestions'] ?? []) || count($feedback['keywords_missing'] ?? []))
          <section class="no-print mx-auto mt-6 max-w-3xl rounded-lg border border-slate-200 bg-white p-5">
            <h2 class="font-semibold text-slate-900">Saran pengembangan</h2>
            @if (count($feedback['suggestions'] ?? []))
              <ul class="mt-2 list-disc space-y-1 pl-5 text-sm leading-6 text-slate-600">
                @foreach ($feedback['suggestions'] as $suggestion) <li>{{ $suggestion }}</li> @endforeach
              </ul>
            @endif
            @if (count($feedback['keywords_missing'] ?? []))
              <p class="mt-3 text-sm text-slate-600">Kata kunci yang belum tercantum: {{ implode(', ', $feedback['keywords_missing']) }}</p>
            @endif
          </section>
        @endif
      @else
        <section class="mx-auto max-w-2xl rounded-xl bg-white p-6 text-center shadow-sm sm:p-10">
          <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-amber-50 text-amber-700"><iconify-icon icon="lucide:triangle-alert" class="text-xl"></iconify-icon></span>
          <h1 class="mt-4 text-xl font-bold text-slate-900">File CV kamu tersimpan</h1>
          <p class="mt-2 text-sm leading-6 text-slate-600">Analisis belum selesai. Periksa koneksi Gemini atau API key, lalu kirim ulang CV dari formulir.</p>
        </section>
      @endif

      <a href="{{ route('cv.create') }}" class="no-print mx-auto mt-6 flex min-h-10 w-fit items-center gap-2 rounded-lg px-4 text-xs font-semibold text-slate-600 hover:bg-white hover:text-[var(--teal)]">
        <iconify-icon icon="lucide:arrow-left" aria-hidden="true"></iconify-icon>Kembali ke formulir CV
      </a>
    </main>
  </body>
</html>