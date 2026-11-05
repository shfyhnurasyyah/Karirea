<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Perbaiki CV — KARIREA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
    @vite('resources/css/app.css')
    <script src="https://code.iconify.design/iconify-icon/3.0.0/iconify-icon.min.js"></script>
  </head>
  <body class="theme-cv">
    <div class="min-h-screen w-full bg-muted flex flex-col relative">
      <header class="bg-background border-b border-border">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
          <a href="{{ route('landing') }}" class="flex items-center gap-2 font-heading text-xl font-bold">
            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary text-primary-foreground">
              <iconify-icon icon="lucide:sparkles"></iconify-icon>
            </span>KARIREA
          </a>
          <span class="text-sm text-muted-foreground">Perbaiki CV</span>
        </div>
      </header>

      <main class="mx-auto w-full max-w-6xl flex-1 px-6 py-10">
        <div class="mb-8">
          <div class="flex items-center justify-between text-sm">
            <span class="font-semibold text-primary">Langkah 1 dari 3</span>
            <span class="text-muted-foreground">Data &amp; preferensi</span>
          </div>
          <div class="mt-3 flex gap-2">
            <div class="h-2 flex-1 rounded-full bg-primary"></div>
            <div class="h-2 flex-1 rounded-full bg-border"></div>
            <div class="h-2 flex-1 rounded-full bg-border"></div>
          </div>
        </div>

        <form action="{{ route('cv.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 gap-6 lg:grid-cols-3">
          @csrf

          <section class="rounded-xl bg-card p-6 shadow-md lg:col-span-2">
            <div class="flex items-start justify-between gap-4">
              <div>
                <h1 class="font-heading text-3xl font-bold text-balance">Ceritakan CV dan tujuan kariermu</h1>
                <p class="mt-2 text-muted-foreground">AI akan memakai informasi ini untuk membuat rekomendasi yang lebih relevan.</p>
              </div>
              <span class="hidden rounded-lg bg-secondary p-3 text-primary sm:block">
                <iconify-icon icon="lucide:file-text" class="text-2xl"></iconify-icon>
              </span>
            </div>

            <div class="mt-8">
              <label class="text-sm font-semibold">CV kamu</label>
              <div class="mt-2 rounded-xl border-2 border-dashed border-input bg-muted p-8 text-center">
                <span class="mx-auto flex h-11 w-11 items-center justify-center rounded-xl bg-secondary text-primary">
                  <iconify-icon icon="lucide:upload" class="text-xl"></iconify-icon>
                </span>
                <p class="mt-3 font-semibold">Tarik file CV ke sini</p>
                <p class="mt-1 text-sm text-muted-foreground">PDF, TXT, atau Gambar — maksimal 10 MB</p>
                <label class="mt-4 inline-block cursor-pointer min-h-11 rounded-lg border border-border bg-card px-4 py-2.5 text-sm font-semibold">
                  Pilih file
                  <input type="file" name="file_cv" accept=".pdf,.txt,image/*" class="hidden" />
                </label>
              </div>
              <div class="my-5 flex items-center gap-3 text-sm text-muted-foreground">
                <div class="h-px flex-1 bg-border"></div>atau tempel teks CV<div class="h-px flex-1 bg-border"></div>
              </div>
              <textarea name="teks_cv_asli" maxlength="4000"
                class="min-h-36 w-full rounded-xl border border-input bg-background p-4 text-sm outline-none"
                placeholder="Tempel ringkasan pengalaman, pendidikan, keahlian, dan pencapaianmu di sini..."
                oninput="document.getElementById('cvCharCount').innerText = this.value.length"></textarea>
              <p class="mt-1 text-right text-xs text-muted-foreground"><span id="cvCharCount">0</span> / 4000 karakter</p>
            </div>

            <div class="mt-7 grid grid-cols-1 gap-5 md:grid-cols-2">
              <div>
                <label class="text-sm font-semibold">Target posisi <span class="text-red-500">*</span></label>
                <input type="text" name="target_posisi" required
                  class="mt-2 min-h-11 w-full rounded-lg border border-input bg-background px-3" placeholder="Contoh: Staff Administrasi">
              </div>
              <div>
                <label class="text-sm font-semibold">Level pengalaman</label>
                <select name="level_pengalaman" class="mt-2 min-h-11 w-full rounded-lg border border-input bg-background px-3">
                  <option value="Fresh Graduate">Fresh Graduate</option>
                  <option value="Career Switch">Career Switch (Pindah Karir)</option>
                  <option value="Experienced">Experienced (Berpengalaman)</option>
                </select>
              </div>
              <div>
                <label class="text-sm font-semibold">Bahasa CV</label>
                <select name="bahasa_output" class="mt-2 min-h-11 w-full rounded-lg border border-input bg-background px-3">
                  <option value="Bahasa Indonesia">Bahasa Indonesia</option>
                  <option value="English">English (Internasional)</option>
                </select>
              </div>
              <div class="rounded-xl bg-secondary p-4">
                <div class="flex items-center justify-between">
                  <div>
                    <p class="text-sm font-semibold">Gunakan lowongan spesifik</p>
                    <p class="mt-1 text-xs text-secondary-foreground">Tambahkan kata kunci dari job description</p>
                  </div>
                  <label class="relative inline-flex cursor-pointer items-center">
                    <input type="checkbox" name="pakai_lowongan_spesifik" value="1" class="peer sr-only"
                      onchange="document.getElementById('lowonganBox').classList.toggle('hidden')">
                    <div class="h-6 w-11 rounded-full bg-border peer-checked:bg-primary transition-colors"></div>
                    <div class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-card transition-transform peer-checked:translate-x-5"></div>
                  </label>
                </div>
              </div>
            </div>

            <div id="lowonganBox" class="hidden mt-5">
              <div class="flex items-center justify-between">
                <label class="text-sm font-semibold">Deskripsi lowongan <span class="font-normal text-muted-foreground">(opsional)</span></label>
                <label class="cursor-pointer text-xs font-semibold text-primary">
                  Upload Flyer (PDF/IMG)
                  <input type="file" name="file_lowongan" accept=".pdf,image/*" class="hidden" />
                </label>
              </div>
              <textarea name="deskripsi_lowongan" maxlength="3000"
                class="mt-2 min-h-28 w-full rounded-xl border border-input bg-background p-4 text-sm"
                placeholder="Tempel deskripsi pekerjaan untuk mencocokkan kata kunci..."
                oninput="document.getElementById('jobCharCount').innerText = this.value.length"></textarea>
              <p class="mt-1 text-right text-xs text-muted-foreground"><span id="jobCharCount">0</span> / 3000 karakter</p>
            </div>
          </section>

          <aside class="space-y-6">
            <section class="rounded-xl bg-card p-6 shadow-md">
              <h2 class="font-heading text-lg font-semibold">Tampilan CV</h2>
              <p class="mt-1 text-sm text-muted-foreground">Pilih fondasi desainmu sekarang, lalu sesuaikan lagi nanti.</p>

              <div class="mt-5 grid grid-cols-3 gap-3">
                <label class="cursor-pointer">
                  <input type="radio" name="template" value="Klasik" class="peer sr-only" checked>
                  <div class="rounded-lg border-2 border-border peer-checked:border-primary bg-secondary p-2">
                    <div class="h-16 rounded bg-card p-2">
                      <div class="h-1 w-1/2 rounded bg-primary"></div>
                      <div class="mt-2 h-1 w-full rounded bg-border"></div>
                    </div>
                    <span class="mt-2 block text-xs font-semibold text-center">Teal</span>
                  </div>
                </label>
                <label class="cursor-pointer">
                  <input type="radio" name="template" value="Modern" class="peer sr-only">
                  <div class="rounded-lg border border-border peer-checked:border-primary p-2">
                    <div class="h-16 rounded bg-muted p-2">
                      <div class="h-1 w-1/2 rounded bg-primary"></div>
                      <div class="mt-2 h-1 w-full rounded bg-border"></div>
                    </div>
                    <span class="mt-2 block text-xs text-center">Minimal</span>
                  </div>
                </label>
                <label class="cursor-pointer">
                  <input type="radio" name="template" value="Elegan" class="peer sr-only">
                  <div class="rounded-lg border border-border peer-checked:border-primary p-2">
                    <div class="h-16 rounded bg-accent p-2">
                      <div class="h-1 w-1/2 rounded bg-primary"></div>
                      <div class="mt-2 h-1 w-full rounded bg-card"></div>
                    </div>
                    <span class="mt-2 block text-xs text-center">Kreatif</span>
                  </div>
                </label>
              </div>

              <div class="mt-4">
                <p class="text-sm font-semibold">Tema warna</p>
                <div class="mt-2 flex gap-2">
                  <input type="radio" name="tema_warna" value="#1F8A8C" checked class="cv-color-teal h-7 w-7 rounded-full border-2 border-border">
                  <input type="radio" name="tema_warna" value="#16313A" class="cv-color-dark h-7 w-7 rounded-full border-2 border-border">
                  <input type="radio" name="tema_warna" value="#C94B4B" class="cv-color-red h-7 w-7 rounded-full border-2 border-border">
                  <input type="radio" name="tema_warna" value="#6B4B14" class="cv-color-brown h-7 w-7 rounded-full border-2 border-border">
                </div>
              </div>

              <div class="mt-5 flex items-center justify-between rounded-lg bg-muted p-3">
                <span class="text-sm font-semibold">Sertakan foto</span>
                <label class="relative inline-flex cursor-pointer items-center">
                  <input type="checkbox" name="sertakan_foto" value="1" class="peer sr-only"
                    onchange="document.getElementById('fotoBox').classList.toggle('hidden')">
                  <div class="h-6 w-11 rounded-full bg-border peer-checked:bg-primary transition-colors"></div>
                  <div class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-card transition-transform peer-checked:translate-x-5"></div>
                </label>
              </div>
              <div id="fotoBox" class="hidden mt-3 space-y-3">
                <div class="rounded-xl border border-border bg-background p-4">
                  <div class="flex items-center gap-4">
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-full bg-secondary text-primary">
                      <img id="fotoPreview" class="hidden h-full w-full object-cover" alt="Preview foto profil" />
                      <iconify-icon id="fotoPlaceholder" icon="lucide:user-round" class="text-2xl"></iconify-icon>
                    </div>
                    <div class="min-w-0 flex-1">
                      <p class="text-sm font-semibold">Foto profil</p>
                      <p id="fotoFileName" class="mt-1 truncate text-xs text-muted-foreground">Pilih foto terbaikmu untuk CV</p>
                      <div class="mt-3 flex flex-wrap items-center gap-2">
                        <label for="fotoProfilInput" class="inline-flex min-h-9 cursor-pointer items-center gap-2 rounded-lg bg-primary px-3 py-2 text-xs font-semibold text-primary-foreground">
                          <iconify-icon icon="lucide:upload"></iconify-icon>
                          Pilih foto
                        </label>
                        <button id="hapusFoto" type="button" class="hidden min-h-9 rounded-lg px-3 py-2 text-xs font-semibold text-muted-foreground hover:bg-muted">
                          Hapus
                        </button>
                      </div>
                    </div>
                  </div>
                  <input id="fotoProfilInput" type="file" name="foto_profil" accept="image/*" class="sr-only" aria-label="Pilih foto profil" />
                </div>
                <div class="flex gap-4 text-xs">
                  <label class="flex items-center gap-1"><input type="radio" name="bentuk_foto" value="Lingkaran" checked>Lingkaran</label>
                  <label class="flex items-center gap-1"><input type="radio" name="bentuk_foto" value="Kotak">Kotak (Rounded)</label>
                </div>
              </div>
            </section>

            <section class="rounded-xl bg-accent p-5">
              <iconify-icon icon="lucide:lightbulb" class="text-xl text-primary"></iconify-icon>
              <p class="mt-3 text-sm font-semibold">Tip cepat</p>
              <p class="mt-1 text-sm leading-6 text-accent-foreground">Cantumkan pencapaian terukur, misalnya "meningkatkan retensi 18%".</p>
            </section>

            <button type="submit" class="min-h-11 w-full rounded-lg bg-primary px-5 font-semibold text-primary-foreground shadow-md">
              Optimalkan CV saya <iconify-icon icon="lucide:arrow-right" class="ml-2"></iconify-icon>
            </button>
          </aside>
        </form>
      </main>
    </div>
    <script>
      const fotoInput = document.getElementById('fotoProfilInput');
      const fotoPreview = document.getElementById('fotoPreview');
      const fotoPlaceholder = document.getElementById('fotoPlaceholder');
      const fotoFileName = document.getElementById('fotoFileName');
      const hapusFoto = document.getElementById('hapusFoto');
      let fotoPreviewUrl;

      fotoInput.addEventListener('change', () => {
        const foto = fotoInput.files[0];
        if (!foto) return;

        if (fotoPreviewUrl) URL.revokeObjectURL(fotoPreviewUrl);
        fotoPreviewUrl = URL.createObjectURL(foto);
        fotoPreview.src = fotoPreviewUrl;
        fotoPreview.classList.remove('hidden');
        fotoPlaceholder.classList.add('hidden');
        fotoFileName.textContent = foto.name;
        hapusFoto.classList.remove('hidden');
      });

      hapusFoto.addEventListener('click', () => {
        fotoInput.value = '';
        fotoPreview.removeAttribute('src');
        fotoPreview.classList.add('hidden');
        fotoPlaceholder.classList.remove('hidden');
        fotoFileName.textContent = 'Pilih foto terbaikmu untuk CV';
        hapusFoto.classList.add('hidden');
        if (fotoPreviewUrl) {
          URL.revokeObjectURL(fotoPreviewUrl);
          fotoPreviewUrl = undefined;
        }
      });
    </script>
  </body>
</html>