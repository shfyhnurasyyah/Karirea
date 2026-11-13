@php
  $feedback = $cv->feedback_ai ?? [];
  $result = $feedback['cv'] ?? [];
  $contact = $result['contact'] ?? [];
  $skills = $result['skills'] ?? [];
  $hardSkills = is_array($skills['hard'] ?? null) ? $skills['hard'] : [];
  $softSkills = is_array($skills['soft'] ?? null) ? $skills['soft'] : [];
  $toolSkills = is_array($skills['tools'] ?? null) ? $skills['tools'] : [];
  $allSkills = array_values(array_filter(
      array_merge($hardSkills, $softSkills, $toolSkills),
      fn ($skill) => is_string($skill) && trim($skill) !== ''
  ));
  $matchedKeywords = is_array($feedback['keywords_matched'] ?? null) ? $feedback['keywords_matched'] : [];
  $missingKeywords = is_array($feedback['keywords_missing'] ?? null) ? $feedback['keywords_missing'] : [];
  $suggestions = is_array($feedback['suggestions'] ?? null) ? $feedback['suggestions'] : [];
  $settings = $cv->pengaturan_tampilan ?? [];
  $accent = $settings['tema_warna'] ?? '#1D4ED8';
  $score = is_numeric($cv->skor_ats) ? min(100, max(0, (int) $cv->skor_ats)) : null;
  $structureSections = count(array_filter([
      $result['summary'] ?? null,
      $result['experience'] ?? null,
      $result['education'] ?? null,
      $allSkills,
  ], fn ($section) => ! empty($section)));
  $improvementCount = count($suggestions) + count($missingKeywords);

  if ($score === null) {
      $scoreStatus = 'Belum tersedia';
  } elseif ($score >= 80) {
      $scoreStatus = 'Sangat kompetitif';
  } elseif ($score >= 60) {
      $scoreStatus = 'Cukup kompetitif';
  } else {
      $scoreStatus = 'Perlu ditingkatkan';
  }
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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
  <body class="theme-optimasi min-h-screen bg-[var(--surface)] antialiased">
    <header class="no-print border-b border-[var(--border)] bg-white">
      <div class="mx-auto flex min-h-16 max-w-7xl items-center justify-between px-5 py-3 sm:px-7 lg:px-8">
        <a href="{{ route('landing') }}" class="flex items-center gap-2 font-heading text-base font-bold text-[var(--ink)]" aria-label="KARIREA, kembali ke beranda">
          <span class="flex h-8 w-8 items-center justify-center rounded-full bg-primary text-primary-foreground" aria-hidden="true">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="m12 3 1.9 5.8L20 11l-6.1 2.2L12 19l-2-5.8L4 11l6-2.2L12 3Z" />
              <path d="m19 14 1 2.5 2.5 1-2.5 1L19 21l-1-2.5-2.5-1 2.5-1 1-2.5Z" />
            </svg>
          </span>
          KARIREA
        </a>
        <a href="{{ route('cv.create') }}" class="inline-flex min-h-10 items-center gap-1.5 rounded-lg px-3 text-sm font-semibold text-primary transition hover:bg-secondary focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">
          <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="m12 19-7-7 7-7" />
            <path d="M19 12H5" />
          </svg>
          Ubah data
        </a>
      </div>
    </header>

    <main class="mx-auto w-full max-w-7xl px-4 py-7 sm:px-6 sm:py-9 lg:px-8">
      @if (session('ai_error'))
        <div class="no-print mb-6 rounded-xl border border-amber-300 bg-amber-50 p-4 text-sm text-amber-900" role="alert">
          <p class="font-semibold">Analisis AI belum berhasil</p>
          <p class="mt-1">{{ session('ai_error') }}</p>
        </div>
      @endif

      @if ($cv->status === 'selesai')
        <section class="no-print mb-7 flex flex-col justify-between gap-5 lg:flex-row lg:items-end">
          <div>
            <p class="text-xs font-bold tracking-wider text-primary">HASIL OPTIMASI</p>
            <h1 class="mt-2 font-heading text-2xl font-bold tracking-tight text-[var(--ink)] sm:text-3xl">CV kamu siap ditinjau</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-[var(--muted)]">
              Kami menemukan {{ $improvementCount }} perbaikan yang paling berdampak untuk target posisi {{ $cv->target_posisi ?: 'posisi pilihanmu' }}.
            </p>
          </div>
          <a href="{{ route('cv.checkout', $cv) }}" class="inline-flex min-h-11 shrink-0 items-center justify-center gap-2 rounded-lg bg-primary px-5 text-sm font-semibold text-primary-foreground shadow-sm transition hover:brightness-95 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">
            Lanjut untuk unduh
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M5 12h14" />
              <path d="m12 5 7 7-7 7" />
            </svg>
          </a>
        </section>

        <div class="grid grid-cols-1 items-start gap-5 lg:grid-cols-[minmax(0,1.55fr)_minmax(18rem,0.95fr)] lg:gap-6">
          <section class="rounded-xl bg-white p-5 shadow-sm sm:p-7">
            <div class="no-print flex items-center justify-between gap-4 border-b border-[var(--border)] pb-4">
              <div>
                <h2 class="font-heading text-lg font-semibold text-[var(--ink)]">Preview CV</h2>
                <p class="text-sm text-[var(--muted)]">{{ $cv->template ?: 'Teal Professional' }} · {{ $cv->bahasa_output ?: 'Bahasa Indonesia' }}</p>
              </div>
              <a href="{{ route('cv.create') }}" class="inline-flex min-h-9 items-center gap-1.5 rounded-lg border border-[var(--border)] px-3 text-sm font-semibold text-[var(--ink)] transition hover:bg-[var(--surface)] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <path d="m16 4 4 4L9 19l-5 1 1-5L16 4Z" />
                  <path d="m14 6 4 4" />
                </svg>
                Edit
              </a>
            </div>

            <article class="cv-document {{ strtolower($cv->template ?? '') }} mx-auto mt-5 max-w-3xl rounded-xl border border-[var(--border)] bg-white p-5 shadow-sm sm:p-7" aria-label="CV hasil optimasi">
              <header class="border-b-2 border-[var(--cv-accent)] pb-4">
                <div class="flex items-start justify-between gap-4">
                  <div class="min-w-0">
                    <h2 class="cv-name font-heading text-2xl font-bold">{{ $result['name'] ?? 'Nama belum tersedia' }}</h2>
                    <p class="mt-1 font-medium text-primary">{{ $result['headline'] ?? ($cv->target_posisi ?: 'Posisi belum tersedia') }}</p>
                  </div>
                  <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-secondary text-primary" aria-hidden="true">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <circle cx="12" cy="8" r="4" />
                      <path d="M5 21v-2a7 7 0 0 1 14 0v2" />
                    </svg>
                  </span>
                </div>
                @if (is_array($contact))
                  <div class="mt-2 flex flex-wrap gap-x-3 gap-y-1 text-xs text-[var(--muted)]">
                    @foreach (['location', 'email', 'phone'] as $field)
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
                <section class="mt-5">
                  <h3 class="text-xs font-bold uppercase tracking-wide text-primary">Ringkasan</h3>
                  <p class="mt-2 whitespace-pre-line text-sm leading-6 text-[var(--muted)]">{{ $result['summary'] }}</p>
                </section>
              @endif

              @if (is_array($result['experience'] ?? null) && count($result['experience']))
                <section class="mt-5">
                  <h3 class="text-xs font-bold uppercase tracking-wide text-primary">Pengalaman</h3>
                  <div class="mt-3 space-y-4">
                    @foreach ($result['experience'] as $experience)
                      <div>
                        <div class="flex flex-wrap justify-between gap-x-4 gap-y-1">
                          <p class="text-sm font-semibold text-[var(--ink)]">{{ $experience['role'] ?? '' }}{{ ! empty($experience['company']) ? ' · ' . $experience['company'] : '' }}</p>
                          @if (! empty($experience['period']))
                            <span class="text-xs text-[var(--muted)]">{{ $experience['period'] }}</span>
                          @endif
                        </div>
                        @if (is_array($experience['bullets'] ?? null) && count($experience['bullets']))
                          <ul class="mt-1 list-disc space-y-1 pl-4 text-sm leading-5 text-[var(--muted)]">
                            @foreach ($experience['bullets'] as $bullet) <li>{{ $bullet }}</li> @endforeach
                          </ul>
                        @endif
                      </div>
                    @endforeach
                  </div>
                </section>
              @endif

              @if (is_array($result['education'] ?? null) && count($result['education']))
                <section class="mt-5">
                  <h3 class="text-xs font-bold uppercase tracking-wide text-primary">Pendidikan</h3>
                  <div class="mt-3 space-y-3">
                    @foreach ($result['education'] as $education)
                      <div>
                        <div class="flex flex-wrap justify-between gap-x-4 gap-y-1">
                          <p class="text-sm font-semibold text-[var(--ink)]">{{ $education['school'] ?? '' }}</p>
                          @if (! empty($education['period']))
                            <span class="text-xs text-[var(--muted)]">{{ $education['period'] }}</span>
                          @endif
                        </div>
                        @if (! empty($education['degree']) || ! empty($education['notes']))
                          <p class="text-sm text-[var(--muted)]">{{ $education['degree'] ?? '' }}{{ ! empty($education['notes']) ? ' · ' . $education['notes'] : '' }}</p>
                        @endif
                      </div>
                    @endforeach
                  </div>
                </section>
              @endif

              @if (count($allSkills))
                <section class="mt-5">
                  <h3 class="text-xs font-bold uppercase tracking-wide text-primary">Keahlian</h3>
                  <div class="mt-2 flex flex-wrap gap-2">
                    @foreach ($allSkills as $skill)
                      <span class="rounded-full bg-secondary px-3 py-1 text-xs font-semibold text-primary">{{ $skill }}</span>
                    @endforeach
                  </div>
                </section>
              @endif

              @foreach (['certifications' => 'Sertifikasi', 'projects' => 'Proyek'] as $field => $heading)
                @if (is_array($result[$field] ?? null) && count($result[$field]))
                  <section class="mt-5">
                    <h3 class="text-xs font-bold uppercase tracking-wide text-primary">{{ $heading }}</h3>
                    <ul class="mt-2 list-disc space-y-1 pl-4 text-sm leading-5 text-[var(--muted)]">
                      @foreach ($result[$field] as $item)
                        <li>{{ is_array($item) ? implode(' · ', array_filter($item, 'is_string')) : $item }}</li>
                      @endforeach
                    </ul>
                  </section>
                @endif
              @endforeach
            </article>
          </section>

          <aside class="no-print space-y-5">
            <section class="rounded-xl bg-white p-5 text-center shadow-sm sm:p-6" aria-labelledby="ats-score-heading">
              <div class="mx-auto flex h-28 w-28 items-center justify-center rounded-full p-[7px] sm:h-32 sm:w-32" style="background: conic-gradient(var(--teal) {{ $score ?? 0 }}%, #E8F4F4 0)" role="img" aria-label="Skor ATS {{ $score ?? 'belum tersedia' }} dari 100">
                <div class="flex h-full w-full flex-col items-center justify-center rounded-full bg-white">
                  <p class="font-heading text-4xl font-bold text-primary">{{ $score ?? '—' }}</p>
                  <h2 id="ats-score-heading" class="text-[10px] font-semibold tracking-wide text-[var(--muted)]">SKOR ATS</h2>
                </div>
              </div>
              <p class="mt-4 font-heading text-base font-semibold text-[var(--ink)]">{{ $scoreStatus }}</p>
              <p class="mt-1 text-xs leading-5 text-[var(--muted)]">Estimasi berdasarkan CV hasil optimasi.</p>
              <div class="mt-5 grid grid-cols-3 gap-2 text-left">
                <div class="rounded-lg bg-secondary p-2.5">
                  <p class="text-[11px] text-secondary-foreground">Struktur</p>
                  <p class="mt-0.5 text-sm font-semibold text-primary">{{ $structureSections }}/4</p>
                </div>
                <div class="rounded-lg bg-secondary p-2.5">
                  <p class="text-[11px] text-secondary-foreground">Kata kunci</p>
                  <p class="mt-0.5 text-sm font-semibold text-primary">{{ $cv->skor_kata_kunci ?? count($matchedKeywords) }}</p>
                </div>
                <div class="rounded-lg bg-accent p-2.5">
                  <p class="text-[11px] text-accent-foreground">Dampak</p>
                  <p class="mt-0.5 text-sm font-semibold text-accent-foreground">—</p>
                </div>
              </div>
            </section>

            <section class="rounded-xl bg-white p-5 shadow-sm sm:p-6" aria-labelledby="priorities-heading">
              <h2 id="priorities-heading" class="font-heading text-base font-semibold text-[var(--ink)]">Prioritas perbaikan</h2>
              <ul class="mt-4 space-y-4">
                @forelse ($suggestions as $suggestion)
                  <li class="flex gap-2.5">
                    <span class="mt-0.5 shrink-0 text-primary" aria-hidden="true">
                      <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="9" />
                        <path d="m8 12 2.5 2.5L16 9" />
                      </svg>
                    </span>
                    <p class="text-sm leading-5 text-[var(--ink)]">{{ $suggestion }}</p>
                  </li>
                @empty
                  @if (count($missingKeywords))
                    <li class="flex gap-2.5">
                      <span class="mt-0.5 shrink-0 text-primary" aria-hidden="true">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <circle cx="12" cy="12" r="9" />
                          <path d="m8 12 2.5 2.5L16 9" />
                        </svg>
                      </span>
                      <p class="text-sm leading-5 text-[var(--ink)]">Kata kunci yang belum tercantum: {{ implode(', ', $missingKeywords) }}.</p>
                    </li>
                  @else
                    <li class="text-sm leading-5 text-[var(--muted)]">Belum ada prioritas perbaikan tambahan dari analisis AI.</li>
                  @endif
                @endforelse
                @if (count($suggestions) && count($missingKeywords))
                  <li class="flex gap-2.5">
                    <span class="mt-0.5 shrink-0 text-primary" aria-hidden="true">
                      <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="9" />
                        <path d="m8 12 2.5 2.5L16 9" />
                      </svg>
                    </span>
                    <p class="text-sm leading-5 text-[var(--ink)]">Kata kunci yang belum tercantum: {{ implode(', ', $missingKeywords) }}.</p>
                  </li>
                @endif
              </ul>
            </section>
          </aside>
        </div>
      @else
        <section class="mx-auto max-w-2xl rounded-xl bg-white p-6 text-center shadow-sm sm:p-10">
          <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-amber-50 text-amber-700" aria-hidden="true">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="m10.3 3.9-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.7-3.1l-8-14a2 2 0 0 0-3.4 0Z" />
              <path d="M12 9v4" />
              <path d="M12 17h.01" />
            </svg>
          </span>
          <h1 class="mt-4 font-heading text-xl font-bold text-[var(--ink)]">File CV kamu tersimpan</h1>
          <p class="mt-2 text-sm leading-6 text-[var(--muted)]">Analisis belum selesai. Periksa koneksi Gemini atau API key, lalu kirim ulang CV dari formulir.</p>
          <a href="{{ route('cv.create') }}" class="no-print mt-5 inline-flex min-h-10 items-center rounded-lg border border-[var(--border)] px-4 text-sm font-semibold text-primary transition hover:bg-secondary">
            Ubah data
          </a>
        </section>
      @endif
    </main>
  </body>
</html>
