<?php

namespace Database\Seeders;

use App\Models\PlagiatReferensi;
use Illuminate\Database\Seeder;

/**
 * Korpus awal berisi kalimat klise yang sangat umum di surat lamaran.
 * Tambahkan lebih banyak contoh supaya deteksi makin akurat.
 */
class PlagiatReferensiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'judul' => 'Pembuka lamaran klasik',
                'isi' => 'Dengan hormat, Berdasarkan informasi lowongan pekerjaan yang saya peroleh, saya bermaksud mengajukan diri untuk mengisi posisi yang tersedia di perusahaan Bapak/Ibu. Saya adalah lulusan yang memiliki semangat belajar tinggi dan mampu bekerja sama dalam tim maupun secara mandiri. Besar harapan saya untuk dapat diberi kesempatan wawancara agar dapat menjelaskan lebih lanjut mengenai kemampuan saya. Atas perhatian Bapak/Ibu, saya ucapkan terima kasih.',
            ],
            [
                'judul' => 'Template fresh graduate',
                'isi' => 'Saya adalah fresh graduate yang memiliki motivasi tinggi untuk memulai karier profesional. Selama masa perkuliahan, saya aktif dalam berbagai organisasi dan kegiatan kepanitiaan yang melatih kemampuan komunikasi dan kepemimpinan. Saya siap belajar hal baru dengan cepat dan beradaptasi dengan lingkungan kerja yang dinamis. Saya yakin kemampuan dan semangat saya dapat memberikan kontribusi positif bagi perusahaan Bapak/Ibu.',
            ],
            [
                'judul' => 'Template berpengalaman',
                'isi' => 'Dengan pengalaman kerja lebih dari tiga tahun di bidang yang relevan, saya memiliki keahlian dalam mengelola proyek, bekerja di bawah tekanan, dan mencapai target yang ditetapkan. Saya terbiasa berkoordinasi dengan berbagai pihak untuk menyelesaikan pekerjaan tepat waktu. Saya percaya pengalaman tersebut dapat membantu perusahaan Bapak/Ibu mencapai tujuan bisnisnya.',
            ],
            [
                'judul' => 'Template penutup lamaran',
                'isi' => 'Bersama surat lamaran ini, saya lampirkan daftar riwayat hidup serta dokumen pendukung lainnya. Saya sangat berharap dapat bergabung dengan tim Bapak/Ibu dan berkontribusi secara maksimal. Saya bersedia untuk mengikuti seluruh tahapan seleksi yang ditetapkan oleh perusahaan. Demikian surat lamaran ini saya buat dengan sebenar-benarnya. Atas waktu dan perhatian Bapak/Ibu, saya ucapkan terima kasih.',
            ],
            [
                'judul' => 'Template alih karier',
                'isi' => 'Meskipun latar belakang saya berasal dari bidang yang berbeda, saya memiliki keterampilan yang dapat dialihkan dan sangat relevan dengan posisi ini. Saya telah mengikuti berbagai kursus dan pelatihan untuk meningkatkan kompetensi di bidang baru ini. Saya adalah pribadi yang jujur, disiplin, bertanggung jawab, dan mampu bekerja di bawah tekanan.',
            ],
            [
                'judul' => 'English cover letter template',
                'isi' => 'I am writing to express my strong interest in the position advertised on your company website. I am a highly motivated and detail-oriented professional with excellent communication skills and a strong ability to work in a team. I am confident that my skills and experience make me an ideal candidate for this role. Thank you for your time and consideration, and I look forward to hearing from you.',
            ],
        ];

        foreach ($data as $row) {
            PlagiatReferensi::updateOrCreate(
                ['judul' => $row['judul']],
                ['sumber' => 'Korpus internal KARIREA', 'isi' => $row['isi']]
            );
        }
    }
}
