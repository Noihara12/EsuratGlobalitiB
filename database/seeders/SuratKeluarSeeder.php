<?php

namespace Database\Seeders;

use App\Models\SuratKeluar;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SuratKeluarSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::whereIn('role', ['tu', 'ka_tu', 'staff', 'wakasek_kurikulum', 'wakasek_sarana_prasarana', 'wakasek_kesiswaan', 'wakasek_humas', 'kaprog_dkv', 'kaprog_pplg', 'kaprog_tjkt', 'kaprog_bd', 'guru', 'pembina_ekstra', 'bkk'])->get();

        if ($users->count() < 1) {
            $users = User::limit(10)->get();
        }

        $statusArray = ['draft', 'published', 'diarsip'];
        $tujuanArray = [
            'Dinas Pendidikan Provinsi',
            'Kantor Walikota',
            'DPPKB Kabupaten',
            'Kantor Pajak',
            'Badan Sosial',
            'Dinas Kesehatan',
            'Polres Kabupaten',
            'BNN Kabupaten',
            'Dinas Perindustrian',
            'Kementerian Pendidikan',
            'Yayasan Pendidikan',
            'Universitas Negeri',
            'PT Bank Mandiri',
            'Perusahaan Swasta',
            'Koperasi Sekolah',
            'Panitia Event Kabupaten',
            'Tim Verifikasi Sekolah',
            'Organisasi Induk Sekolah',
            'Komite Orang Tua Peserta Didik',
            'Sekolah Mitra Kerjasama',
        ];

        $perihalArray = [
            'Permohonan Bantuan Dana',
            'Undangan Kegiatan Sekolah',
            'Laporan Hasil Evaluasi',
            'Surat Pemberitahuan Kegiatan',
            'Pernyataan Kemitraan Kerjasama',
            'Permintaan Dukungan Program',
            'Surat Tugas Peserta Didik',
            'Rekomendasi Beasiswa',
            'Sertifikat Penghargaan',
            'Nota Dinas Akademik',
            'Surat Minta Maaf',
            'Permohonan Magang',
            'Pemberitahuan Perubahan Jadwal',
            'Surat Kepada Orang Tua Siswa',
            'Laporan Rencana Program Tahunan',
            'Pengajuan Proposal Kegiatan',
            'Surat Penawaran Layanan',
            'Undangan Seminar Pendidik',
            'Permohonan Donasi untuk Sekolah',
            'Laporan Kegiatan Ekstrakurikuler',
        ];

        $isiArray = [
            'Kami dengan hormat mengajukan permohonan kepada Bapak/Ibu...',
            'Sehubungan dengan program tahunan sekolah, kami mengundang Bapak/Ibu untuk...',
            'Berdasarkan evaluasi yang telah dilakukan, kami melaporkan bahwa...',
            'Dengan ini kami memberitahukan bahwa kegiatan sekolah akan dilaksanakan pada...',
            'Dalam rangka meningkatkan kualitas pendidikan, kami mengajukan kerja sama untuk...',
            'Kami mohon dukungan dan persetujuan untuk melaksanakan program sebagai berikut...',
            'Sesuai dengan surat tugas, peserta didik diharapkan untuk mengikuti kegiatan...',
            'Kami dengan senang hati merekomendasikan siswa-siswi berprestasi untuk mendapat beasiswa...',
            'Atas dedikasi dan prestasi yang telah dicapai, kami memberikan sertifikat penghargaan...',
            'Untuk keperluan administrasi akademik, kami membutuhkan data lengkap mengenai...',
        ];

        for ($i = 1; $i <= 100; $i++) {
            $year = 2024 + rand(0, 1);
            $month = str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT);
            $day = str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT);

            $tanggalSurat = Carbon::createFromFormat('Y-m-d', "$year-$month-$day");

            SuratKeluar::create([
                'nomor_surat' => 'SK-' . str_pad($i, 4, '0', STR_PAD_LEFT) . '/' . $year,
                'tanggal_surat' => $tanggalSurat,
                'tujuan' => $tujuanArray[array_rand($tujuanArray)],
                'perihal' => $perihalArray[array_rand($perihalArray)],
                'isi_surat' => $isiArray[array_rand($isiArray)],
                'file_lampiran' => null,
                'status' => $statusArray[array_rand($statusArray)],
                'created_by' => $users[array_rand($users->toArray())]->id,
                'is_archived' => rand(0, 1) ? false : false,
                'archived_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('✅ 100 Surat Keluar berhasil dibuat');
    }
}
