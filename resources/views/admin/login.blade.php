<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Masuk Admin — KARIREA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet" />
    @vite('resources/css/app.css')
    <script src="https://code.iconify.design/iconify-icon/3.0.0/iconify-icon.min.js"></script>
</head>
<body class="theme-landing bg-[#F8FAFA] text-[#16313A] min-h-screen flex flex-col justify-between font-sans selection:bg-[#1F8A8C] selection:text-white">
    <!-- Header / Navbar minimalis -->
    <header class="w-full border-b border-[#D9E6E6] bg-white/80 backdrop-blur-md sticky top-0 z-20">
        <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-6 py-4">
            <a href="{{ route('landing') }}" class="flex items-center gap-2.5 font-heading text-xl font-bold text-[#16313A] hover:opacity-90 transition">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#1F8A8C] text-white shadow-sm">
                    <iconify-icon icon="lucide:sparkles" class="text-lg"></iconify-icon>
                </span>
                <span>KARIREA</span>
            </a>
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-[#62757B] hover:text-[#1F8A8C] transition">
                <iconify-icon icon="lucide:arrow-left" class="text-base"></iconify-icon>
                Kembali ke Beranda
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 flex items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <!-- Card Container -->
            <div class="rounded-2xl border border-[#D9E6E6] bg-white p-8 sm:p-10 shadow-xl shadow-[#1F8A8C]/5 transition-all">
                <!-- Header Card -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center gap-1.5 rounded-full bg-[#E8F4F4] px-3.5 py-1 text-xs font-semibold text-[#1F8A8C] mb-3">
                        <iconify-icon icon="lucide:shield-check" class="text-sm"></iconify-icon>
                        Area Terbatas
                    </div>
                    <h1 class="font-heading text-2xl sm:text-3xl font-extrabold text-[#16313A] tracking-tight">
                        Masuk Admin
                    </h1>
                    <p class="mt-2 text-sm text-[#62757B]">
                        Masuk untuk mengelola data sistem, CV, dan referensi plagiat KARIREA.
                    </p>
                </div>

                <!-- Alert Status / Sukses -->
                @if (session('status'))
                    <div class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50/90 p-4 text-sm text-emerald-800">
                        <iconify-icon icon="lucide:check-circle-2" class="text-lg text-emerald-600 mt-0.5 shrink-0"></iconify-icon>
                        <div>{{ session('status') }}</div>
                    </div>
                @endif

                <!-- Alert Validasi Error Global -->
                @if ($errors->any())
                    <div class="mb-6 flex items-start gap-3 rounded-xl border border-rose-200 bg-rose-50/90 p-4 text-sm text-rose-800">
                        <iconify-icon icon="lucide:alert-circle" class="text-lg text-rose-600 mt-0.5 shrink-0"></iconify-icon>
                        <div>
                            @if ($errors->count() == 1)
                                {{ $errors->first() }}
                            @else
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Form Login -->
                <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-5" novalidate>
                    @csrf

                    <!-- Input Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-[#16313A] mb-1.5">
                            Alamat Email
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#62757B]">
                                <iconify-icon icon="lucide:mail" class="text-lg"></iconify-icon>
                            </span>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="email"
                                placeholder="admin@karirea.id"
                                class="w-full rounded-xl border {{ $errors->has('email') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-200' : 'border-[#D9E6E6] focus:border-[#1F8A8C] focus:ring-[#1F8A8C]/20' }} bg-white pl-10 pr-4 py-3 text-sm text-[#16313A] placeholder-[#62757B]/60 transition outline-none focus:ring-4"
                            />
                        </div>
                        @error('email')
                            <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Input Password -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-sm font-semibold text-[#16313A]">
                                Kata Sandi
                            </label>
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#62757B]">
                                <iconify-icon icon="lucide:lock" class="text-lg"></iconify-icon>
                            </span>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                required
                                autocomplete="current-password"
                                placeholder="••••••••"
                                class="w-full rounded-xl border {{ $errors->has('password') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-200' : 'border-[#D9E6E6] focus:border-[#1F8A8C] focus:ring-[#1F8A8C]/20' }} bg-white pl-10 pr-11 py-3 text-sm text-[#16313A] placeholder-[#62757B]/60 transition outline-none focus:ring-4"
                            />
                            <button
                                type="button"
                                id="togglePasswordBtn"
                                aria-label="Tampilkan atau sembunyikan kata sandi"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-[#62757B] hover:text-[#1F8A8C] transition focus:outline-none"
                            >
                                <iconify-icon id="passwordEyeIcon" icon="lucide:eye" class="text-lg"></iconify-icon>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ingat Saya -->
                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2.5 cursor-pointer select-none">
                            <input
                                type="checkbox"
                                name="remember"
                                id="remember"
                                value="1"
                                {{ old('remember') ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-[#D9E6E6] text-[#1F8A8C] focus:ring-[#1F8A8C]/30 focus:ring-offset-0 transition cursor-pointer"
                            />
                            <span class="text-sm text-[#62757B]">Ingat saya di perangkat ini</span>
                        </label>
                    </div>

                    <!-- Tombol Masuk -->
                    <div class="pt-2">
                        <button
                            type="submit"
                            class="w-full rounded-xl bg-[#1F8A8C] hover:bg-[#167072] active:scale-[0.99] text-white py-3.5 px-4 font-heading font-semibold text-sm shadow-md shadow-[#1F8A8C]/20 transition-all flex items-center justify-center gap-2"
                        >
                            <span>Masuk ke Panel</span>
                            <iconify-icon icon="lucide:arrow-right" class="text-base"></iconify-icon>
                        </button>
                    </div>
                </form>

                <!-- Informasi Akun Bawaan (Default Credentials) -->
                <div class="mt-8 rounded-xl border border-dashed border-[#D9E6E6] bg-[#F5F8F8] p-4 text-xs text-[#62757B]">
                    <div class="flex items-center gap-1.5 font-semibold text-[#16313A] mb-1.5">
                        <iconify-icon icon="lucide:info" class="text-sm text-[#1F8A8C]"></iconify-icon>
                        <span>Akun Administrator Bawaan:</span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-1.5 mt-2 font-mono text-[11px]">
                        <div class="bg-white px-2.5 py-1.5 rounded border border-[#D9E6E6]">
                            <span class="text-[#62757B]">Email:</span> <strong class="text-[#16313A]">admin@karirea.id</strong>
                        </div>
                        <div class="bg-white px-2.5 py-1.5 rounded border border-[#D9E6E6]">
                            <span class="text-[#62757B]">Password:</span> <strong class="text-[#16313A]">password</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer copyright kecil -->
            <p class="mt-8 text-center text-xs text-[#62757B]">
                &copy; {{ date('Y') }} KARIREA. Seluruh hak cipta dilindungi.
            </p>
        </div>
    </main>

    <!-- Script toggle password visibility -->
    <script>
        const passwordInput = document.getElementById('password');
        const togglePasswordBtn = document.getElementById('togglePasswordBtn');
        const eyeIcon = document.getElementById('passwordEyeIcon');

        if (togglePasswordBtn && passwordInput && eyeIcon) {
            togglePasswordBtn.addEventListener('click', function () {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                eyeIcon.setAttribute('icon', isPassword ? 'lucide:eye-off' : 'lucide:eye');
            });
        }
    </script>
</body>
</html>

