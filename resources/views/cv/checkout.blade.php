@php
  $contact = data_get($cv->feedback_ai, 'cv.contact', []);
  $email = old('email', $cv->email ?? data_get($contact, 'email', ''));
  $phone = old('phone', $cv->no_hp ?? data_get($contact, 'phone', ''));
@endphp
<!DOCTYPE html>
<html lang="id" class="theme-cv">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#f4f8f8" />
    <title>Checkout CV — KARIREA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
  <body class="theme-cv min-h-screen bg-muted antialiased">
    <header class="border-b border-border bg-background">
      <div class="mx-auto flex max-w-5xl items-center justify-between px-5 py-3 sm:px-6 sm:py-4">
        <a href="{{ route('landing') }}" class="flex items-center gap-2 font-heading text-lg font-bold text-foreground" aria-label="KARIREA, kembali ke beranda">
          <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary text-primary-foreground" aria-hidden="true">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="m12 3 1.9 5.8L20 11l-6.1 2.2L12 19l-2-5.8L4 11l6-2.2L12 3Z" />
              <path d="m19 14 1 2.5 2.5 1-2.5 1L19 21l-1-2.5-2.5-1 2.5-1 1-2.5Z" />
            </svg>
          </span>
          KARIREA
        </a>
        <span class="text-sm text-muted-foreground">Checkout aman</span>
      </div>
    </header>

    <main class="mx-auto w-full max-w-5xl px-4 py-7 sm:px-6 sm:py-10">
      <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-2">
        <section class="rounded-xl bg-card p-5 shadow-sm sm:p-7">
          <p class="text-sm font-semibold text-primary">LANGKAH TERAKHIR</p>
          <h1 class="mt-2 font-heading text-2xl font-bold text-foreground sm:text-3xl">Siapkan hasil terbaikmu</h1>
          <p class="mt-2 text-sm leading-6 text-muted-foreground">Masukkan kontak untuk menerima bukti pesanan dan tautan unduhan.</p>

          <form id="checkout-form" class="mt-7 space-y-5">
            <div>
              <label for="phone" class="text-sm font-semibold text-foreground">Nomor WhatsApp</label>
              <input id="phone" name="phone" type="tel" autocomplete="tel" value="{{ $phone }}" placeholder="Contoh: 0812 3456 7890" required class="mt-2 min-h-11 w-full rounded-lg border border-input bg-background px-3 text-sm text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20" />
            </div>
            <div>
              <label for="email" class="text-sm font-semibold text-foreground">Email</label>
              <input id="email" name="email" type="email" autocomplete="email" value="{{ $email }}" placeholder="kamu@email.com" required class="mt-2 min-h-11 w-full rounded-lg border border-input bg-background px-3 text-sm text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20" />
            </div>
            <label class="flex gap-3 rounded-lg bg-secondary p-4 text-sm leading-5 text-secondary-foreground">
              <input type="checkbox" name="contact_consent" required checked class="mt-1 h-4 w-4 shrink-0 accent-primary" />
              <span>Saya setuju data kontak digunakan untuk pembaruan pesanan ini.</span>
            </label>
            <button type="submit" class="min-h-11 w-full rounded-lg bg-primary px-5 font-semibold text-primary-foreground transition hover:brightness-95 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">
              Lanjut ke pembayaran
            </button>
            <p class="text-xs leading-5 text-muted-foreground">Mode demo: kontak tidak disimpan dan pembayaran belum diproses.</p>
          </form>
        </section>

        <aside class="space-y-5">
          <section class="rounded-xl bg-card p-5 shadow-sm sm:p-6">
            <div class="flex items-center justify-between gap-3">
              <h2 class="font-heading text-lg font-semibold text-card-foreground">Ringkasan pesanan</h2>
              <span class="rounded-full bg-secondary px-3 py-1 text-xs font-semibold text-primary">CV ATS</span>
            </div>
            <p class="mt-1 text-sm text-muted-foreground">{{ $cv->target_posisi ?: 'Optimasi CV' }}</p>
            <div class="mt-5 space-y-3 border-b border-border pb-5 text-sm">
              <div class="flex justify-between gap-4"><span class="text-muted-foreground">Optimasi isi CV</span><span class="font-medium text-card-foreground">Rp19.000</span></div>
              <div class="flex justify-between gap-4"><span class="text-muted-foreground">Skor ATS &amp; rekomendasi</span><span class="font-medium text-card-foreground">Termasuk</span></div>
              <div class="flex justify-between gap-4"><span class="text-muted-foreground">Unduh PDF</span><span class="font-medium text-card-foreground">Termasuk</span></div>
            </div>
            <div class="mt-4 flex justify-between font-heading text-lg font-bold text-card-foreground">
              <span>Total</span><span class="text-primary">Rp19.000</span>
            </div>
            <p class="mt-2 text-xs text-muted-foreground">Harga pada tampilan ini hanya contoh dan belum ditagihkan.</p>
          </section>

          <section id="payment-panel" class="rounded-xl bg-card p-5 shadow-sm sm:p-6">
            <div class="flex items-center justify-between gap-3">
              <div>
                <h2 class="font-heading font-semibold text-card-foreground">Pembayaran QRIS</h2>
                <p class="text-sm text-muted-foreground">Pratinjau alur pembayaran</p>
              </div>
              <span class="rounded-lg bg-secondary p-2 text-primary" aria-hidden="true">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="3" y="3" width="7" height="7" rx="1" />
                  <rect x="14" y="3" width="7" height="7" rx="1" />
                  <rect x="3" y="14" width="7" height="7" rx="1" />
                  <path d="M14 14h3v3h-3zM20 14v2M14 20h2M20 19v2M18 17h3" />
                </svg>
              </span>
            </div>

            <div class="mx-auto mt-5 grid h-36 w-36 grid-cols-5 grid-rows-5 gap-1 rounded-lg bg-muted p-3 sm:h-40 sm:w-40" role="img" aria-label="Ilustrasi kode QR, bukan kode pembayaran yang dapat dipindai">
              <span class="rounded-sm bg-foreground"></span><span></span><span class="rounded-sm bg-foreground"></span><span class="rounded-sm bg-foreground"></span><span></span>
              <span></span><span class="rounded-sm bg-foreground"></span><span></span><span class="rounded-sm bg-foreground"></span><span></span>
              <span class="rounded-sm bg-foreground"></span><span></span><span class="rounded-sm bg-foreground"></span><span></span><span class="rounded-sm bg-foreground"></span>
              <span></span><span class="rounded-sm bg-foreground"></span><span></span><span class="rounded-sm bg-foreground"></span><span></span>
              <span class="rounded-sm bg-foreground"></span><span></span><span class="rounded-sm bg-foreground"></span><span></span><span class="rounded-sm bg-foreground"></span>
            </div>

            <p class="mt-3 text-center text-xs text-muted-foreground">Ilustrasi saja — QRIS belum terhubung ke payment gateway.</p>
            <div class="mt-4 flex items-center justify-center gap-2 rounded-lg bg-accent p-3 text-sm text-accent-foreground" aria-live="polite">
              <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="12" cy="12" r="9" />
                <path d="M12 7v5l3 2" />
              </svg>
              <span id="payment-timer">Menunggu · 14:35</span>
            </div>
            <button id="verify-payment" type="button" disabled class="mt-4 min-h-11 w-full rounded-lg border border-border px-4 font-semibold text-muted-foreground transition enabled:text-card-foreground enabled:hover:bg-muted disabled:cursor-not-allowed">
              Saya sudah bayar
            </button>
            <p id="payment-message" class="mt-3 hidden rounded-lg border border-border bg-muted p-3 text-sm leading-5 text-card-foreground" role="status" aria-live="polite"></p>
            <div id="demo-success" class="mt-3 hidden rounded-lg bg-secondary p-4 text-sm text-secondary-foreground">
              <p class="font-semibold">Simulasi selesai — tidak ada pembayaran sungguhan.</p>
              <a href="{{ route('cv.result', $cv) }}" class="mt-2 inline-flex font-semibold text-primary underline underline-offset-2">Kembali ke hasil CV</a>
            </div>
          </section>

          <section class="rounded-xl bg-secondary p-5">
            <div class="flex gap-3 text-secondary-foreground">
              <svg class="mt-0.5 h-5 w-5 shrink-0 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="12" cy="12" r="9" />
                <path d="m8 12 2.5 2.5L16 9" />
              </svg>
              <p class="text-sm leading-6">Alur ini masih berupa demo. Pembayaran tidak diproses, kontak tidak disimpan, dan unduhan PDF belum tersedia dari halaman checkout.</p>
            </div>
          </section>
        </aside>
      </div>
    </main>

    <script>
      (() => {
        const form = document.getElementById('checkout-form');
        const timer = document.getElementById('payment-timer');
        const verifyButton = document.getElementById('verify-payment');
        const message = document.getElementById('payment-message');
        const success = document.getElementById('demo-success');
        let remainingSeconds = 14 * 60 + 35;
        let countdown;

        const renderTime = () => {
          const minutes = Math.floor(remainingSeconds / 60).toString().padStart(2, '0');
          const seconds = (remainingSeconds % 60).toString().padStart(2, '0');
          timer.textContent = `Menunggu · ${minutes}:${seconds}`;
        };

        form.addEventListener('submit', (event) => {
          event.preventDefault();
          if (!form.reportValidity()) return;

          clearInterval(countdown);
          remainingSeconds = 14 * 60 + 35;
          renderTime();
          verifyButton.disabled = false;
          message.textContent = 'Mode demo aktif. QR ini bukan kode pembayaran dan tidak ada transaksi yang dibuat.';
          message.classList.remove('hidden');
          success.classList.add('hidden');

          countdown = setInterval(() => {
            remainingSeconds -= 1;
            renderTime();
            if (remainingSeconds <= 0) {
              clearInterval(countdown);
              timer.textContent = 'Waktu simulasi habis';
              verifyButton.disabled = true;
              message.textContent = 'Waktu simulasi berakhir. Tekan “Lanjut ke pembayaran” untuk memulai ulang demo.';
            }
          }, 1000);
          document.getElementById('payment-panel').scrollIntoView({ behavior: 'smooth', block: 'center' });
        });

        verifyButton.addEventListener('click', () => {
          if (verifyButton.disabled) return;
          clearInterval(countdown);
          timer.textContent = 'Simulasi selesai';
          verifyButton.disabled = true;
          message.classList.add('hidden');
          success.classList.remove('hidden');
        });
      })();
    </script>
  </body>
</html>
