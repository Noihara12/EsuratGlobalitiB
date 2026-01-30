# 📧 E-Surat - Sistem Manajemen Surat Elektronik
## Quick Start Guide

Aplikasi E-Surat telah berhasil dibuat dan siap digunakan! Ikuti panduan di bawah untuk mulai menggunakan sistem.

---

## ✅ Apa Yang Sudah Disetup

- ✓ Database dengan 4 table utama (users, surat_masuk, disposisi, surat_keluar)
- ✓ Authentication system dengan 4 role (Admin, Kepala Sekolah, TU, User)
- ✓ Fitur Surat Masuk dengan sistem disposisi
- ✓ Fitur Surat Keluar dengan kontrol upload file
- ✓ Admin Dashboard dengan User Management & Database Backup
- ✓ File upload untuk lampiran surat dan tanda tangan
- ✓ 4 Demo Users untuk testing

---

## 🚀 Cara Menjalankan Aplikasi

### Option 1: Menggunakan PHP Built-in Server

```bash
cd d:\laragon\www\EsuratGlobalitiB
php artisan serve
```

Aplikasi akan berjalan di: **http://localhost:8000**

### Option 2: Menggunakan Laragon

1. Buka Laragon
2. Pastikan Apache dan MySQL sudah running
3. Edit `C:\laragon\etc\apache2\conf.d\httpd-vhosts.conf`:
   ```apache
   <VirtualHost *:80>
       DocumentRoot "d:/laragon/www/EsuratGlobalitiB/public"
       ServerName esurat.local
       <Directory "d:/laragon/www/EsuratGlobalitiB/public">
           Options Indexes FollowSymLinks
           AllowOverride All
           Require all granted
       </Directory>
   </VirtualHost>
   ```

4. Edit `C:\Windows\System32\drivers\etc\hosts`:
   ```
   127.0.0.1 esurat.local
   ```

5. Restart Apache di Laragon
6. Akses: **http://esurat.local**

---

## 👥 Demo User Credentials

Login dengan akun berikut untuk testing:

| Role | Email | Password |
|------|-------|----------|
| 👨‍💼 Admin | admin@esurat.local | password |
| 🎓 Kepala Sekolah | kepala@esurat.local | password |
| 📝 TU (Tata Usaha) | tu@esurat.local | password |
| 👤 User Biasa | user@esurat.local | password |

---

## 📋 Cara Menggunakan Sistem

### A. SURAT MASUK

#### 1️⃣ TU - Input Surat Masuk
1. Login sebagai **tu@esurat.local**
2. Klik "📨 Surat Masuk"
3. Klik "+ Buat Surat Masuk Baru"
4. Isi form:
   - Jenis Surat (Rahasia/Penting/Biasa)
   - Kode Surat (contoh: SKPS)
   - Nomor Surat (contoh: 001/SK/12/2025)
   - Tanggal Surat
   - Asal Surat (nama instansi)
   - Perihal
   - Catatan (opsional)
   - File Lampiran (opsional)
5. Klik "Simpan Surat Masuk"

#### 2️⃣ TU - Submit ke Kepala Sekolah
1. Dari daftar surat masuk, klik "Lihat" pada surat draft
2. Klik "✈️ Ajukan ke Kepala Sekolah"
3. Status surat berubah menjadi "submitted"

#### 3️⃣ Kepala Sekolah - Membuat Disposisi
1. Login sebagai **kepala@esurat.local**
2. Klik "📨 Surat Masuk (Disposisi)"
3. Lihat daftar surat yang perlu didisposisikan
4. Klik "Lihat" pada surat
5. Klik "➕ Buat Disposisi"
6. Isi form:
   - Disposisi ke (pilih user yang dituju)
   - Isi Disposisi (apa yang harus dikerjakan)
   - Catatan Kepala Sekolah (opsional)
   - Tanda Tangan (upload file tanda tangan - opsional)
7. Klik "✔️ Buat Disposisi"

#### 4️⃣ User - Menerima Disposisi
1. Login sebagai **user@esurat.local**
2. Klik "📨 Surat Masuk (Diterima)"
3. Lihat surat yang didisposisikan ke Anda
4. Klik "Lihat" pada surat
5. Di bagian Disposisi, klik "✔️ Terima Disposisi"
6. Status disposisi berubah menjadi "received"

---

### B. SURAT KELUAR

#### 1️⃣ TU - Buat Surat Keluar dengan Lampiran
1. Login sebagai **tu@esurat.local**
2. Klik "📤 Surat Keluar"
3. Klik "+ Buat Surat Keluar"
4. Isi form:
   - Nomor Surat (contoh: 001/SK/12/2025)
   - Tanggal Surat
   - Perihal
   - Isi Surat
   - **File Lampiran** (TU bisa upload - JPG, PNG, PDF max 5MB)
5. Klik "Simpan"
6. Surat masuk ke Draft
7. Klik "Publikasikan" untuk publish surat

#### 2️⃣ User Biasa - Buat Surat Keluar (Tanpa Lampiran)
1. Login sebagai **user@esurat.local**
2. Klik "📤 Surat Keluar"
3. Klik "+ Buat Surat Keluar"
4. Isi form (tanpa file lampiran):
   - Nomor Surat
   - Tanggal Surat
   - Perihal
   - Isi Surat
5. Klik "Simpan"
6. **User biasa tidak bisa publikasikan**, hanya bisa preview

---

### C. ADMIN - MANAGE USER

#### 1️⃣ Lihat Daftar User
1. Login sebagai **admin@esurat.local**
2. Klik "👥 Kelola User"
3. Lihat semua user terdaftar

#### 2️⃣ Tambah User Baru
1. Klik "+ Tambah User"
2. Isi form:
   - Nama
   - Email (harus unik)
   - Role (Admin/Kepala Sekolah/TU/User)
   - Password (min 8 karakter)
   - Konfirmasi Password
3. Klik "✔️ Tambah User"

#### 3️⃣ Edit User
1. Klik "Edit" pada user yang ingin diubah
2. Update data yang diperlukan
3. Klik "✔️ Simpan Perubahan"

#### 4️⃣ Hapus User
1. Klik "Hapus" pada user
2. Konfirmasi penghapusan

---

### D. ADMIN - BACKUP DATABASE

#### 1️⃣ Buat Backup
1. Login sebagai **admin@esurat.local**
2. Klik "💾 Backup Database"
3. Klik "💾 Download Backup Database"
4. File akan didownload secara otomatis

#### 2️⃣ Lihat Daftar Backup
1. Klik "📋 Lihat Daftar Backup"
2. Lihat semua backup yang sudah dibuat

#### 3️⃣ Restore Backup
1. Di daftar backup, klik "⬆️ Restore"
2. Database akan dikembalikan ke state backup tersebut
3. **Backup otomatis dibuat sebelum restore**

#### 4️⃣ Hapus Backup
1. Klik "🗑️ Hapus" pada backup yang ingin dihapus
2. Konfirmasi penghapusan

---

## 📁 File Upload & Storage

### Lokasi Penyimpanan File

```
storage/app/public/
├── surat_masuk/        → Lampiran surat masuk
├── surat_keluar/       → Lampiran surat keluar
└── tanda_tangan/       → Tanda tangan digital

storage/backups/        → Backup database
```

### Akses File
File yang di-upload dapat diakses melalui:
- `http://localhost:8000/storage/surat_masuk/nama-file.pdf`
- `http://localhost:8000/storage/surat_keluar/nama-file.pdf`
- `http://localhost:8000/storage/tanda_tangan/nama-file.pdf`

---

## 🔍 Status Surat

### Surat Masuk
- 📋 **Draft** - Surat baru, belum diajukan
- ✈️ **Submitted** - Diajukan ke Kepala Sekolah, menunggu disposisi
- 📑 **Disposed** - Sudah didisposisikan oleh Kepala Sekolah
- ✅ **Received** - Sudah diterima oleh user tujuan

### Disposisi
- ⏳ **Pending** - Menunggu user tujuan untuk menerima
- ✅ **Received** - Sudah diterima user tujuan
- 🔄 **In Progress** - Sedang dikerjakan
- ✓ **Completed** - Selesai dikerjakan

### Surat Keluar
- 📝 **Draft** - Surat baru, belum dipublikasikan
- 📤 **Published** - Sudah dipublikasikan (hanya TU yang bisa publikasikan)

---

## 🔐 Security Notes

✓ Password ter-hash menggunakan bcrypt
✓ CSRF protection untuk semua form
✓ Role-based access control
✓ File upload validation (type & size)
✓ Unique constraints pada email & nomor surat

---

## ⚙️ Configuration

### Mengubah Password User
1. Login dengan akun yang ingin diubah
2. Hubungi admin untuk reset password
3. Admin bisa edit user dan ganti password

### Menambah Role Baru
Jika perlu menambah role baru (misal: Bendahara), edit:
- `database/migrations/2024_01_01_000001_create_users_table.php`
- `app/Models/User.php`
- Run: `php artisan migrate:refresh --seed`

### Mengubah Max File Size
Edit di `app/Http/Controllers/`:
```php
'file_lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120'
// max:5120 = 5MB, ubah ke max:10240 untuk 10MB
```

---

## 🐛 Troubleshooting

### Aplikasi tidak bisa diakses
```bash
php artisan serve
# Pastikan port 8000 tidak digunakan aplikasi lain
```

### File upload tidak bisa
```bash
# Pastikan storage directory writable
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

### Database error
```bash
# Reset database dan seed ulang
php artisan migrate:fresh --seed
```

### Login gagal
- Pastikan email sesuai dengan format: `user@esurat.local`
- Password: `password` (semuanya lowercase)

---

## 📞 Support & Maintenance

### Daily Maintenance
- Monitor storage space untuk uploads
- Clear old backups secara berkala
- Review user access logs

### Backup Schedule
Sebaiknya buat backup minimal 1x per hari menggunakan automation:
```bash
# Buat backup otomatis (set di cron job)
php artisan backup:run
```

---

## 📚 Dokumentasi Lengkap

Lihat file `README_ESURAT.md` untuk dokumentasi teknis lengkap.

---

**Status**: ✅ Ready to Use
**Version**: 1.0.0
**Last Updated**: January 9, 2026

Happy using E-Surat! 🎉
