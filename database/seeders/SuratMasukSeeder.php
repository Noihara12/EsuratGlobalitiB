<?php

namespace Database\Seeders;

use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SuratMasukSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::whereIn('role', ['tu', 'ka_tu'])->get();
        $tuUsers = $users->count() > 0 ? $users : User::limit(2)->get();

        $jenisArray = ['biasa', 'penting', 'rahasia'];
        $statusArray = ['draft', 'submitted', 'disposed', 'received', 'diarsip'];
        $asalArray = [
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
        ];

        $perihalArray = [
            'Undangan Rapat',
            'Pemberitahuan Program Pendidikan',
            'Surat Ajuan Dana Hibah',
            'Pengumuman Beasiswa',
            'Laporan Kegiatan Sekolah',
            'Perubahan Jadwal Pembelajaran',
            'Perbaikan Sarana Prasarana',
            'Program Pembinaan Siswamandiri',
            'Sertifikat Penghargaan',
            'Permintaan Data Statistik',
            'Undangan Seminar Pendidikan',
            'Kerjasama Program Magang',
            'Audit Keuangan',
            'Inspeksi Sekolah',
            'Pembaruan Data Peserta Didik',
            'Pelaksanaan Ujian Nasional',
            'Program Pertukaran Pelajar',
            'Sertifikasi Pendidik',
            'Renovasi Gedung Sekolah',
            'Pengadaan Buku Pelajaran',
        ];

        for ($i = 1; $i <= 100; $i++) {
            $year = 2024 + rand(0, 1);
            $month = str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT);
            $day = str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT);

            $kodePrefix = ['SK', 'UM', 'AD', 'PP', 'DK', 'PI'];
            $kodeSurat = $kodePrefix[array_rand($kodePrefix)] . '/' . $month . '/' . $year;

            $tanggalSurat = Carbon::createFromFormat('Y-m-d', "$year-$month-$day");

            SuratMasuk::create([
                'jenis_surat' => $jenisArray[array_rand($jenisArray)],
                'kode_surat' => $kodeSurat,
                'nomor_surat' => 'SM-' . str_pad($i, 4, '0', STR_PAD_LEFT) . '/' . $year,
                'tanggal_surat' => $tanggalSurat,
                'asal_surat' => $asalArray[array_rand($asalArray)],
                'perihal' => $perihalArray[array_rand($perihalArray)],
                'catatan' => rand(0, 1) ? 'Catatan penting surat nomor ' . $i : null,
                'file_lampiran' => null,
                'status' => $statusArray[array_rand($statusArray)],
                'created_by' => $tuUsers[array_rand($tuUsers->toArray())]->id,
                'kepala_sekolah_id' => User::where('role', 'kepala_sekolah')->first()?->id,
                'is_archived' => rand(0, 1) ? false : false,
                'archived_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('✅ 100 Surat Masuk berhasil dibuat');
    }
}
