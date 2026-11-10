<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Buat CV - Data pribadi | KARIREA</title>
  <style>
    :root {
      --primary: #1f8a87;
      --primary-dark: #176f6d;
      --primary-soft: #e8f3f2;
      --bg: #f4f8f8;
      --text: #0b0f0f;
      --muted: #5f7a80;
      --border: #dde7e7;
    }
    * { box-sizing: border-box; }
    body {
      margin: 0; background: var(--bg); color: var(--text);
      font-family: "Segoe UI", Inter, system-ui, -apple-system, sans-serif;
    }
    a { text-decoration: none; color: inherit; }

    /* ===== Navbar (sama seperti landing) ===== */
    .nav { background: #fff; border-bottom: 1px solid var(--border); }
    .nav-in {
      max-width: 1240px; margin: 0 auto; padding: 14px 24px;
      display: flex; align-items: center; justify-content: space-between;
    }
    .brand { display: flex; align-items: center; gap: 12px; font-weight: 800; font-size: 20px; }
    .logo {
      width: 36px; height: 36px; border-radius: 10px; background: var(--primary);
      color: #fff; display: grid; place-items: center; font-size: 18px;
    }
    .menu { display: flex; align-items: center; gap: 28px; font-weight: 600; font-size: 15px; }
    .btn-nav {
      background: var(--primary); color: #fff; padding: 12px 20px;
      border-radius: 12px; font-weight: 600;
      box-shadow: 0 4px 12px rgba(31,138,135,.3);
    }

    /* ===== Layout ===== */
    .wrap {
      display: grid; grid-template-columns: 1fr 1fr; gap: 32px;
      max-width: 1240px; margin: 40px auto; padding: 0 24px;
    }
    .card {
      background: #fff; border-radius: 20px; padding: 36px;
      border: 1px solid var(--border); box-shadow: 0 8px 30px rgba(31,138,135,.08);
    }
    .badge {
      display: inline-block; background: var(--primary-soft); color: var(--primary);
      font-weight: 600; font-size: 13px; padding: 6px 14px; border-radius: 999px; margin-bottom: 14px;
    }
    h1 { font-size: 36px; font-weight: 800; margin: 0 0 10px; line-height: 1.2; }
    .desc { color: var(--muted); line-height: 1.7; margin: 0 0 24px; }

    label.field { display: block; font-weight: 600; margin: 20px 0 8px; }
    .input {
      width: 100%; padding: 14px 16px; background: #f7fafa;
      border: 1px solid var(--border); border-radius: 12px; font-size: 15px; font-family: inherit;
    }
    .input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px var(--primary-soft); background: #fff; }
    .row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

    .upload {
      display: flex; gap: 14px; align-items: center; padding: 16px;
      border: 1px dashed var(--primary); background: var(--primary-soft);
      border-radius: 14px; cursor: pointer;
    }
    .upload .plus {
      width: 44px; height: 44px; border-radius: 50%; background: #fff; color: var(--primary);
      display: grid; place-items: center; font-size: 22px; font-weight: 700;
    }
    .upload small { display: block; color: var(--muted); margin-top: 2px; }

    .actions { display: flex; justify-content: flex-end; margin-top: 32px; }
    .btn {
      background: var(--primary); color: #fff; border: 0; padding: 14px 28px;
      border-radius: 12px; font-weight: 600; font-size: 15px; cursor: pointer;
      box-shadow: 0 4px 12px rgba(31,138,135,.3);
    }
    .btn:hover { background: var(--primary-dark); }

    .error { color: #c0392b; font-size: 13px; display: block; margin-top: 6px; }
    .ok { background: var(--primary-soft); color: var(--primary-dark); padding: 12px 16px; border-radius: 12px; margin-bottom: 16px; font-weight: 600; }

    /* ===== Preview ===== */
    .preview {
      background: #fff; border-radius: 8px; min-height: 620px; padding: 44px;
      border: 1px solid var(--border); box-shadow: 0 8px 30px rgba(0,0,0,.06);
    }
    .preview small { color: var(--muted); }
    .preview h2 { margin: 14px 0 4px; font-size: 26px; }
    .preview .pos { color: var(--primary); font-weight: 600; margin: 0 0 6px; }
    .preview .mail { color: var(--muted); margin: 0; }

    @media (max-width: 900px) {
      .wrap { grid-template-columns: 1fr; }
      .menu a:not(.btn-nav) { display: none; }
    }
  </style>
</head>
<body>

<header class="nav">
  <div class="nav-in">
    <a href="{{ route('landing') }}" class="brand">
      <span class="logo">✦</span> KARIREA
    </a>
    <nav class="menu">
      <a href="{{ route('landing') }}#cara-kerja">Cara kerja</a>
      <a href="{{ route('landing') }}#template">Template</a>
      <a href="{{ route('landing') }}#faq">FAQ</a>
      <a href="{{ route('admin.login') }}">Masuk Admin</a>
      <a href="{{ route('mulai') }}" class="btn-nav">Mulai gratis</a>
    </nav>
  </div>
</header>

<main class="wrap">
  <form class="card" action="{{ route('resume.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <span class="badge">Langkah 1 dari 8</span>
    <h1>Data pribadi</h1>
    <p class="desc">Cara perusahaan menghubungi Anda. Kami memakai posisi yang Anda inginkan untuk menyesuaikan bagian CV lainnya.</p>

    @if (session('sukses')) <div class="ok">{{ session('sukses') }}</div> @endif

    <label class="upload">
      <input type="file" name="foto" accept="image/*" hidden>
      <span class="plus">+</span>
      <span><strong>Tambah foto</strong><small>Opsional, pilih file gambar</small></span>
    </label>
    @error('foto') <span class="error">{{ $message }}</span> @enderror

    <label class="field">Posisi yang diinginkan</label>
    <input class="input" type="text" name="posisi" value="{{ old('posisi') }}">
    @error('posisi') <span class="error">{{ $message }}</span> @enderror

    <div class="row">
      <div>
        <label class="field">Nama depan</label>
        <input class="input" type="text" name="nama_depan" value="{{ old('nama_depan') }}">
        @error('nama_depan') <span class="error">{{ $message }}</span> @enderror
      </div>
      <div>
        <label class="field">Nama belakang</label>
        <input class="input" type="text" name="nama_belakang" value="{{ old('nama_belakang') }}">
        @error('nama_belakang') <span class="error">{{ $message }}</span> @enderror
      </div>
    </div>

    <label class="field">Email</label>
    <input class="input" type="email" name="email" value="{{ old('email') }}">
    @error('email') <span class="error">{{ $message }}</span> @enderror

    <div class="actions">
      <button class="btn" type="submit">Berikutnya: Pengalaman kerja →</button>
    </div>
  </form>

  <aside class="preview">
    <small>Detail pribadi</small>
    <h2 id="pv-nama">Nama Anda</h2>
    <p class="pos" id="pv-posisi">Posisi</p>
    <p class="mail" id="pv-email">email@contoh.com</p>
  </aside>
</main>

<script>
  const q = n => document.querySelector(`[name="${n}"]`);
  const set = (id, v, f) => document.getElementById(id).textContent = v || f;
  const nama = () => set('pv-nama', `${q('nama_depan').value} ${q('nama_belakang').value}`.trim(), 'Nama Anda');
  q('nama_depan').addEventListener('input', nama);
  q('nama_belakang').addEventListener('input', nama);
  q('posisi').addEventListener('input', e => set('pv-posisi', e.target.value, 'Posisi'));
  q('email').addEventListener('input', e => set('pv-email', e.target.value, 'email@contoh.com'));
</script>
</body>
</html>