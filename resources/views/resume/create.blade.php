<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buat CV - Data pribadi</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f3f4f6; color: #111827; }
        .wrap { display: flex; gap: 32px; padding: 32px; max-width: 1300px; margin: 0 auto; }
        .panel { background: #fff; border-radius: 12px; padding: 32px; flex: 1; }
        .preview { flex: 1; display: flex; justify-content: center; }
        .paper { background: #fff; width: 100%; max-width: 520px; min-height: 640px; padding: 40px; box-shadow: 0 2px 10px rgba(0,0,0,.1); }
        .step { color: #f04e23; font-weight: bold; font-size: 14px; }
        h1 { margin: 8px 0; }
        .desc { color: #4b5563; margin-bottom: 24px; }
        label { display: block; font-weight: bold; margin: 16px 0 6px; }
        input[type=text], input[type=email] { width: 100%; padding: 16px; border: 1px solid #e5e7eb; border-radius: 8px; background: #f9fafb; font-size: 16px; }
        .row { display: flex; gap: 16px; }
        .row > div { flex: 1; }
        .foto { display: flex; align-items: center; gap: 16px; border: 1px dashed #d1d5db; border-radius: 8px; padding: 16px; cursor: pointer; }
        .foto .plus { width: 48px; height: 48px; border-radius: 50%; background: #f3f4f6; display: flex; align-items: center; justify-content: center; font-size: 24px; overflow: hidden; }
        .foto .plus img { width: 100%; height: 100%; object-fit: cover; }
        .foto small { color: #6b7280; }
        .btn { margin-top: 28px; background: #f04e23; color: #fff; border: 0; padding: 16px 28px; border-radius: 999px; font-size: 16px; font-weight: bold; cursor: pointer; float: right; }
        .error { color: #dc2626; font-size: 14px; margin-top: 4px; }
        .sukses { background: #dcfce7; color: #166534; padding: 12px; border-radius: 8px; margin-bottom: 16px; }
        .paper h2 { margin: 0 0 4px; }
        .paper .pos { color: #4b5563; margin: 0 0 4px; }
        .paper .mail { color: #6b7280; font-size: 14px; }
        .paper .pp { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin-bottom: 12px; display: none; }
        .paper .judul { font-size: 12px; font-family: serif; margin-bottom: 16px; }
    </style>
</head>
<body>
<div class="wrap">
    <div class="panel">
        <div class="step">Langkah 1 dari 8</div>
        <h1>Data pribadi</h1>
        <p class="desc">Cara perusahaan menghubungi Anda. Kami memakai posisi yang Anda inginkan untuk menyesuaikan bagian CV lainnya.</p>

        @if (session('sukses'))
            <div class="sukses">{{ session('sukses') }}</div>
        @endif

        <form action="{{ route('resume.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label class="foto" for="foto" style="font-weight: normal; margin-top: 0;">
                <span class="plus" id="fotoBox">+</span>
                <span><strong>Tambah foto</strong><br><small>Opsional, pilih file gambar</small></span>
            </label>
            <input type="file" id="foto" name="foto" accept="image/*" style="display:none">
            @error('foto') <div class="error">{{ $message }}</div> @enderror

            <label for="posisi">Posisi yang diinginkan</label>
            <input type="text" id="posisi" name="posisi" value="{{ old('posisi') }}">
            @error('posisi') <div class="error">{{ $message }}</div> @enderror

            <div class="row">
                <div>
                    <label for="nama_depan">Nama depan</label>
                    <input type="text" id="nama_depan" name="nama_depan" value="{{ old('nama_depan') }}">
                    @error('nama_depan') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label for="nama_belakang">Nama belakang</label>
                    <input type="text" id="nama_belakang" name="nama_belakang" value="{{ old('nama_belakang') }}">
                    @error('nama_belakang') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}">
            @error('email') <div class="error">{{ $message }}</div> @enderror

            <button type="submit" class="btn">Berikutnya: Pengalaman kerja &rarr;</button>
            <div style="clear: both"></div>
        </form>
    </div>

    <div class="preview">
        <div class="paper">
            <div class="judul">Detail pribadi</div>
            <img id="pvFoto" class="pp" alt="Foto">
            <h2 id="pvNama"></h2>
            <p class="pos" id="pvPosisi"></p>
            <div class="mail" id="pvEmail"></div>
        </div>
    </div>
</div>

<script>
    const $ = (id) => document.getElementById(id);

    function perbarui() {
        $('pvNama').textContent = ($('nama_depan').value + ' ' + $('nama_belakang').value).trim();
        $('pvPosisi').textContent = $('posisi').value;
        $('pvEmail').textContent = $('email').value;
    }

    ['nama_depan', 'nama_belakang', 'posisi', 'email'].forEach((id) => {
        $(id).addEventListener('input', perbarui);
    });

    $('foto').addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (!file) return;
        const url = URL.createObjectURL(file);
        $('pvFoto').src = url;
        $('pvFoto').style.display = 'block';
        $('fotoBox').innerHTML = '<img src="' + url + '" alt="">';
    });

    perbarui();
</script>
</body>
</html>