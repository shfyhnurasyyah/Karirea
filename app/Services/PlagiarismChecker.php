<?php

namespace App\Services;

/**
 * Pengecek kemiripan teks surat lamaran (tanpa API eksternal).
 *
 * Cara kerja:
 *  1. Teks dipecah per kalimat.
 *  2. Tiap kalimat dibandingkan dengan korpus referensi memakai
 *     (a) similar_text() untuk kalimat yang hampir identik, dan
 *     (b) tumpang-tindih trigram kata (3 kata berurutan) untuk frasa yang disalin.
 *  3. Kalimat dengan kemiripan >= AMBANG_KALIMAT ditandai.
 *  4. Skor akhir = persentase kata yang berada di kalimat yang ditandai.
 */
class PlagiarismChecker
{
    public const AMBANG_KALIMAT = 70;   // % kemiripan agar kalimat dianggap mirip
    public const MIN_KATA_KALIMAT = 4;  // kalimat lebih pendek diabaikan
    public const UKURAN_SHINGLE = 3;    // panjang n-gram kata
    public const MAKS_KARAKTER_SIMILAR = 400;

    /**
     * @param  string    $teks       Teks lamaran dari pengguna
     * @param  iterable  $referensi  Objek dengan properti judul & isi (mis. model PlagiatReferensi)
     */
    public function cek(string $teks, iterable $referensi): array
    {
        $ref = $this->siapkanReferensi($referensi);

        $segmen = [];
        $totalKata = 0;
        $kataMirip = 0;
        $kalimatMirip = 0;
        $perSumber = [];

        foreach ($this->pecahKalimat($teks) as $kalimat) {
            $norm = $this->normalisasi($kalimat);
            $token = $norm === '' ? [] : explode(' ', $norm);
            $jumlah = count($token);
            $totalKata += $jumlah;

            $skor = 0;
            $sumber = null;
            if ($jumlah >= self::MIN_KATA_KALIMAT) {
                [$skor, $sumber] = $this->kemiripanTerbaik($norm, $token, $ref);
            }

            $mirip = $skor >= self::AMBANG_KALIMAT;
            if ($mirip) {
                $kataMirip += $jumlah;
                $kalimatMirip++;
                $perSumber[$sumber] = ($perSumber[$sumber] ?? 0) + 1;
            }

            $segmen[] = [
                'teks' => $kalimat,
                'mirip' => $mirip,
                'kemiripan' => (int) round($skor),
                'sumber' => $mirip ? $sumber : null,
            ];
        }

        $skorKemiripan = $totalKata > 0 ? (int) round($kataMirip / $totalKata * 100) : 0;

        arsort($perSumber);
        $sumberList = [];
        foreach ($perSumber as $judul => $jumlahKalimat) {
            $sumberList[] = ['judul' => $judul, 'jumlah_kalimat' => $jumlahKalimat];
        }

        return [
            'skor_kemiripan' => $skorKemiripan,
            'skor_orisinal' => 100 - $skorKemiripan,
            'status' => $this->statusDari($skorKemiripan),
            'jumlah_kata' => $totalKata,
            'jumlah_kalimat' => count($segmen),
            'kalimat_mirip' => $kalimatMirip,
            'segmen' => $segmen,
            'sumber' => $sumberList,
        ];
    }

    public function statusDari(int $skorKemiripan): string
    {
        return match (true) {
            $skorKemiripan < 15 => 'orisinal',
            $skorKemiripan < 40 => 'sedang',
            default => 'tinggi',
        };
    }

    /** Pecah per kalimat / baris baru; teks asli dipertahankan untuk ditampilkan. */
    private function pecahKalimat(string $teks): array
    {
        $bagian = preg_split('/(?<=[.!?])\s+|\R+/u', trim($teks), -1, PREG_SPLIT_NO_EMPTY);

        return array_values(array_filter(array_map('trim', $bagian ?: []), fn ($k) => $k !== ''));
    }

    private function normalisasi(string $teks): string
    {
        $teks = mb_strtolower($teks, 'UTF-8');
        $teks = preg_replace('/[^\p{L}\p{N}\s]+/u', ' ', $teks);

        return trim(preg_replace('/\s+/u', ' ', $teks));
    }

    /** Himpunan n-gram kata: ['a b c' => true, ...] */
    private function shingle(array $token): array
    {
        $n = self::UKURAN_SHINGLE;
        $hasil = [];
        for ($i = 0, $maks = count($token) - $n; $i <= $maks; $i++) {
            $hasil[implode(' ', array_slice($token, $i, $n))] = true;
        }

        return $hasil;
    }

    private function siapkanReferensi(iterable $referensi): array
    {
        $kalimat = [];
        $peta = []; // shingle => judul referensi

        foreach ($referensi as $r) {
            foreach ($this->pecahKalimat((string) $r->isi) as $k) {
                $norm = $this->normalisasi($k);
                $token = $norm === '' ? [] : explode(' ', $norm);
                if (count($token) < self::MIN_KATA_KALIMAT) {
                    continue;
                }
                $sh = $this->shingle($token);
                $kalimat[] = [
                    'judul' => $r->judul,
                    'norm' => mb_substr($norm, 0, self::MAKS_KARAKTER_SIMILAR),
                    'shingle' => $sh,
                ];
                foreach ($sh as $kunci => $_) {
                    $peta[$kunci] ??= $r->judul;
                }
            }
        }

        return ['kalimat' => $kalimat, 'peta' => $peta];
    }

    /** @return array{0: float, 1: ?string} [skor 0-100, judul sumber] */
    private function kemiripanTerbaik(string $norm, array $token, array $ref): array
    {
        $terbaik = 0.0;
        $sumber = null;
        $sh = $this->shingle($token);
        $normPendek = mb_substr($norm, 0, self::MAKS_KARAKTER_SIMILAR);

        // (a) bandingkan dengan tiap kalimat referensi
        foreach ($ref['kalimat'] as $r) {
            similar_text($normPendek, $r['norm'], $persen);
            $kontain = $sh ? count(array_intersect_key($sh, $r['shingle'])) / count($sh) * 100 : 0;
            $nilai = max($persen, $kontain);

            if ($nilai > $terbaik) {
                $terbaik = $nilai;
                $sumber = $r['judul'];
            }
        }

        // (b) frasa yang tersebar dari beberapa kalimat referensi
        if ($sh) {
            $hit = [];
            foreach ($sh as $kunci => $_) {
                if (isset($ref['peta'][$kunci])) {
                    $hit[] = $ref['peta'][$kunci];
                }
            }
            $cakupan = count($hit) / count($sh) * 100;
            if ($cakupan > $terbaik) {
                $terbaik = $cakupan;
                $hitung = array_count_values($hit);
                arsort($hitung);
                $sumber = (string) array_key_first($hitung);
            }
        }

        return [$terbaik, $sumber];
    }
}
