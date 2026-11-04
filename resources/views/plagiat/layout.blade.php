<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Cek Plagiat') — KARIREA</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --color-primary: #1F8A8C;
            --color-dark: #16313A;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">
    <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-4xl items-center justify-between px-5 py-4">
            <a href="{{ route('landing') }}" class="text-lg font-bold tracking-tight text-dark">KARI<span class="text-primary">REA</span></a>
            <nav class="flex items-center gap-5 text-sm font-medium text-slate-600">
                <a href="{{ route('cv.create') }}" class="hover:text-primary focus-visible:outline-2 focus-visible:outline-primary">Perbaiki CV</a>
                <a href="{{ route('plagiat.create') }}" class="text-primary">Cek Plagiat</a>
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-4xl px-5 py-10">
        @yield('content')
    </main>

    <footer class="mx-auto max-w-4xl px-5 pb-10 text-xs text-slate-500">
        &copy; 2026 KARIREA. Hasil cek bersifat indikatif dan dibandingkan dengan korpus internal, bukan seluruh internet.
    </footer>
    @stack('scripts')
</body>
</html>
