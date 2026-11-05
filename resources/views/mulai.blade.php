<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mulai gratis — KARIREA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/iconify-icon/3.0.0/iconify-icon.min.js"></script>
    <style type="text/tailwindcss">
        @theme {
            --color-primary: #1F8A8C;
            --color-primary-foreground: #FFFFFF;
            --color-dark: #16313A;
            --font-sans: 'Inter', ui-sans-serif, system-ui, sans-serif;
            --font-heading: 'Plus Jakarta Sans', 'Inter', ui-sans-serif, system-ui, sans-serif;
        }
    </style>
    <style>
        :root {
            --color-primary: #1F8A8C;
            --color-dark: #16313A;
        }
        body {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            color: #16313A;
        }
        .font-heading {
            font-family: 'Plus Jakarta Sans', 'Inter', ui-sans-serif, system-ui, sans-serif;
        }
    </style>
</head>
<body class="bg-white p-2 font-sans text-dark antialiased sm:p-3">

<div class="flex min-h-[calc(100vh-1rem)] flex-col rounded-2xl bg-neutral-50 sm:min-h-[calc(100vh-1.5rem)]">

    {{-- Header --}}
    <header class="flex items-center justify-between gap-4 px-4 py-5 sm:px-10 sm:py-6">
        <a href="{{ route('landing') }}" class="flex shrink-0 items-center gap-2 font-heading text-xl font-bold text-dark rounded-lg focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-primary">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary text-white">
                <iconify-icon icon="lucide:sparkles" class="text-lg" aria-hidden="true"></iconify-icon>
            </span>KARIREA
        </a>

        <p class="text-right text-xs sm:text-sm text-neutral-600">
            Sudah punya akun?
            <a href="{{ route('admin.login') }}" class="font-semibold text-dark underline-offset-4 hover:text-primary hover:underline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">Masuk</a>
        </p>
    </header>

    {{-- Konten utama --}}
    <main class="flex flex-1 items-center justify-center px-6 pb-16 pt-4">
        <div class="w-full max-w-[680px]">
            <h1 class="text-center font-heading text-3xl font-semibold tracking-tight sm:text-4xl">Anda ingin mulai dari mana?</h1>

            <div class="mt-10 space-y-4">

                {{-- Kartu 1: Buat CV baru (disorot) --}}
                <a href="{{ route('cv.create') }}"
                   class="group flex items-center gap-5 rounded-2xl border border-primary bg-white p-5 transition hover:bg-primary/5 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">
                    <span class="grid size-14 shrink-0 place-items-center rounded-xl bg-primary text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6" aria-hidden="true">
                            <path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"/>
                            <path d="M20 3v4"/><path d="M22 5h-4"/><path d="M4 17v2"/><path d="M5 18H3"/>
                        </svg>
                    </span>
                    <span class="min-w-0 flex-1">
                        <span class="block text-lg font-semibold">Buat CV baru</span>
                        <span class="block text-primary">AI memandu Anda langkah demi langkah</span>
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 shrink-0 text-neutral-400 transition group-hover:translate-x-0.5 group-hover:text-primary" aria-hidden="true">
                        <path d="m9 18 6-6-6-6"/>
                    </svg>
                </a>

                {{-- Kartu 2: Unggah CV Anda (netral) --}}
                <a href="{{ route('cv.create', ['mode' => 'unggah']) }}"
                   class="group flex items-center gap-5 rounded-2xl border border-neutral-200 bg-white p-5 transition hover:border-primary focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">
                    <span class="grid size-14 shrink-0 place-items-center rounded-xl bg-neutral-100 text-neutral-700 transition group-hover:bg-primary/10 group-hover:text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6" aria-hidden="true">
                            <path d="m5 12 7-7 7 7"/><path d="M12 19V5"/>
                        </svg>
                    </span>
                    <span class="min-w-0 flex-1">
                        <span class="block text-lg font-semibold">Unggah CV Anda</span>
                        <span class="block text-neutral-700">AI mengimpor dan memperbaiki teks Anda</span>
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 shrink-0 text-neutral-400 transition group-hover:translate-x-0.5 group-hover:text-primary" aria-hidden="true">
                        <path d="m9 18 6-6-6-6"/>
                    </svg>
                </a>

            </div>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="px-6 pb-8 text-center text-sm text-neutral-600">
        Dengan melanjutkan, Anda menyetujui
        <a href="#" class="underline underline-offset-2 hover:text-primary focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary rounded">Syarat dan ketentuan</a>
        serta
        <a href="#" class="underline underline-offset-2 hover:text-primary focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary rounded">Kebijakan privasi</a>
        KARIREA.
    </footer>
</div>

</body>
</html>
