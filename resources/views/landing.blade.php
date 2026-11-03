<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>KARIREA — Asisten Karier AI untuk Indonesia</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/iconify-icon/3.0.0/iconify-icon.min.js"></script>
    <style type="text/tailwindcss">
      @import "tailwindcss";
      @theme inline {
        --color-background: var(--background);
        --color-foreground: var(--foreground);
        --color-primary: var(--primary);
        --color-primary-foreground: var(--primary-foreground);
        --color-secondary: var(--secondary);
        --color-secondary-foreground: var(--secondary-foreground);
        --color-tertiary: var(--tertiary);
        --color-tertiary-foreground: var(--tertiary-foreground);
        --color-muted: var(--muted);
        --color-muted-foreground: var(--muted-foreground);
        --color-accent: var(--accent);
        --color-accent-foreground: var(--accent-foreground);
        --color-destructive: var(--destructive);
        --color-destructive-foreground: var(--destructive-foreground);
        --color-card: var(--card);
        --color-card-foreground: var(--card-foreground);
        --color-border: var(--border);
        --font-family-sans: var(--font-sans);
        --font-family-heading: var(--font-heading);
        --radius-lg: var(--radius);
      }
      :root {
        --background: #FFFFFF;
        --foreground: #16313A;
        --primary: #1F8A8C;
        --primary-foreground: #121212;
        --secondary: #E8F4F4;
        --secondary-foreground: #16313A;
        --tertiary: #0F766E;
        --muted: #F5F8F8;
        --muted-foreground: #62757B;
        --accent: #FFF4DF;
        --accent-foreground: #6B4B14;
        --card: #FFFFFF;
        --card-foreground: #16313A;
        --border: #D9E6E6;
        --radius: 0.875rem;
        --font-sans: Inter, ui-sans-serif, sans-serif;
        --font-heading: 'Plus Jakarta Sans', Inter, ui-sans-serif, sans-serif;
      }
      .text-primary { color: var(--primary); }
    </style>
  </head>
  <body>
    <div class="min-h-screen w-full bg-background flex flex-col relative">
      <header class="border-b border-border bg-background">
        <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-6 py-4">
          <div class="flex items-center gap-2 font-heading text-xl font-bold">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary text-primary-foreground">
              <iconify-icon icon="lucide:sparkles" class="text-lg"></iconify-icon>
            </span>KARIREA
          </div>
          <nav class="hidden items-center gap-7 text-sm font-medium lg:flex">
            <a href="#cara">Cara kerja</a>
            <a href="#template">Template</a>
            <a href="#faq">FAQ</a>
            <a href="{{ route('admin.login') }}" class="min-h-11 rounded-lg px-3 flex items-center">Masuk Admin</a>
            <a href="{{ route('cv.create') }}" class="min-h-11 rounded-lg bg-primary px-5 font-semibold text-primary-foreground shadow-md flex items-center">Mulai gratis</a>
          </nav>
        </div>
      </header>
      <main>
        <section class="mx-auto grid w-full max-w-7xl grid-cols-1 items-center gap-12 px-6 py-16 lg:grid-cols-2 lg:py-24">
          <div>
            <div class="mb-5 inline-flex items-center gap-2 rounded-full bg-secondary px-4 py-2 text-sm font-semibold text-primary">
              <iconify-icon icon="lucide:zap"></iconify-icon>Asisten karier AI untuk Indonesia
            </div>
            <h1 class="font-heading text-4xl font-bold leading-tight lg:text-6xl">CV yang siap dibaca ATS, lamaran yang tetap orisinal.</h1>
            <p class="mt-6 max-w-xl text-lg leading-8 text-muted-foreground">KARIREA membantu kamu merapikan CV dan mengecek kemiripan teks lamaran—tanpa membuat akun terlebih dahulu.</p>
            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
              <a href="{{ route('cv.create') }}" class="min-h-11 rounded-lg bg-primary px-6 font-semibold text-primary-foreground shadow-md flex items-center justify-center">Perbaiki CV <iconify-icon icon="lucide:arrow-right" class="ml-2"></iconify-icon></a>
              <a href="{{ route('plagiat.create') }}" class="min-h-11 rounded-lg border border-border px-6 font-semibold flex items-center justify-center">Cek Plagiat</a>
            </div>
            <div class="mt-8 flex flex-wrap gap-5 text-sm text-muted-foreground">
              <span><iconify-icon icon="lucide:circle-check" class="mr-1 text-primary"></iconify-icon>Tanpa login</span>
              <span><iconify-icon icon="lucide:circle-check" class="mr-1 text-primary"></iconify-icon>Bahasa Indonesia</span>
              <span><iconify-icon icon="lucide:circle-check" class="mr-1 text-primary"></iconify-icon>Privasi terjaga</span>
            </div>
          </div>
          <div class="rounded-xl bg-secondary p-5 shadow-md">
            <div class="rounded-xl bg-card p-6 shadow-md">
              <div class="flex items-center justify-between border-b border-border pb-4">
                <span class="font-heading font-bold">Ringkasan kesiapan CV</span>
                <span class="rounded-full bg-secondary px-3 py-1 text-sm font-bold text-primary">ATS 86/100</span>
              </div>
              <div class="mt-6 grid grid-cols-2 gap-4">
                <div class="rounded-xl bg-muted p-4">
                  <iconify-icon icon="lucide:file-text" class="text-2xl text-primary"></iconify-icon>
                  <p class="mt-3 text-sm text-muted-foreground">Kata kunci</p>
                  <p class="font-heading text-2xl font-bold">24 cocok</p>
                </div>
                <div class="rounded-xl bg-accent p-4">
                  <iconify-icon icon="lucide:search-check" class="text-2xl text-primary"></iconify-icon>
                  <p class="mt-3 text-sm text-accent-foreground">Kemiripan</p>
                  <p class="font-heading text-2xl font-bold">3% kemiripan</p>
                </div>
              </div>
              <div class="mt-5 rounded-xl border border-border p-4">
                <div class="mb-3 flex items-center justify-between text-sm">
                  <span>Profil kandidat</span>
                  <span class="font-semibold text-primary">Lengkap</span>
                </div>
                <div class="h-3 rounded-full bg-muted">
                  <div class="h-3 w-5/6 rounded-full bg-primary"></div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <section id="cara" class="bg-muted py-16">
          <div class="mx-auto w-full max-w-7xl px-6">
            <div class="max-w-2xl">
              <p class="font-semibold text-primary">MUDAH DIMULAI</p>
              <h2 class="mt-2 font-heading text-3xl font-bold">Tiga langkah menuju lamaran yang lebih meyakinkan</h2>
            </div>
            <div class="mt-10 grid grid-cols-1 gap-5 md:grid-cols-3">
              <article class="rounded-xl bg-card p-6 shadow-md">
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-secondary font-heading font-bold text-primary">01</span>
                <h3 class="mt-5 font-heading text-lg font-semibold">Masukkan bahanmu</h3>
                <p class="mt-2 text-sm leading-6 text-muted-foreground">Ketik, paste, atau unggah CV dan teks lamaran yang ingin kamu optimalkan.</p>
              </article>
              <article class="rounded-xl bg-card p-6 shadow-md">
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-secondary font-heading font-bold text-primary">02</span>
                <h3 class="mt-5 font-heading text-lg font-semibold">Biarkan AI menganalisis</h3>
                <p class="mt-2 text-sm leading-6 text-muted-foreground">Kami memetakan struktur, kata kunci, keterbacaan, dan kemiripan teks.</p>
              </article>
              <article class="rounded-xl bg-card p-6 shadow-md">
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-secondary font-heading font-bold text-primary">03</span>
                <h3 class="mt-5 font-heading text-lg font-semibold">Perbaiki dan unduh</h3>
                <p class="mt-2 text-sm leading-6 text-muted-foreground">Tinjau rekomendasi, pilih tampilan, lalu bawa pulang hasil terbaikmu.</p>
              </article>
            </div>
          </div>
        </section>

        <section id="faq" class="mx-auto w-full max-w-3xl px-6 py-16">
          <p class="text-center font-semibold text-primary">PERTANYAAN UMUM</p>
          <h2 class="mt-2 text-center font-heading text-3xl font-bold">Yang perlu kamu tahu</h2>
          <div class="mt-8 space-y-3">
            <details class="rounded-xl border border-border bg-card p-5">
              <summary class="cursor-pointer font-heading font-semibold">Apakah saya harus membuat akun?</summary>
              <p class="mt-3 text-sm leading-6 text-muted-foreground">Tidak. Kamu bisa mulai menggunakan fitur publik langsung. Kontak hanya diperlukan sebelum pembayaran dan unduh.</p>
            </details>
            <details class="rounded-xl border border-border bg-card p-5">
              <summary class="cursor-pointer font-heading font-semibold">Apakah CV saya aman?</summary>
              <p class="mt-3 text-sm leading-6 text-muted-foreground">Dokumen diproses untuk memberikan analisis dan hasil yang kamu minta.</p>
            </details>
            <details class="rounded-xl border border-border bg-card p-5">
              <summary class="cursor-pointer font-heading font-semibold">Untuk siapa fitur Admin?</summary>
              <p class="mt-3 text-sm leading-6 text-muted-foreground">Area Admin disiapkan untuk tim HRD yang perlu membandingkan banyak CV dengan satu lowongan.</p>
            </details>
          </div>
        </section>
      </main>
      <footer class="border-t border-border">
        <div class="mx-auto flex w-full max-w-7xl flex-col gap-3 px-6 py-8 text-sm text-muted-foreground sm:flex-row sm:items-center sm:justify-between">
          <span>© 2026 KARIREA · Teman kariermu yang lebih siap.</span>
          <a href="{{ route('admin.login') }}" class="text-left font-semibold text-primary">Portal Admin</a>
        </div>
      </footer>
    </div>
  </body>
</html>