# 🔧 Troubleshooting Guide - E-Surat

## Common Issues & Solutions

---

## 🌐 Connection Issues

### Issue: "Connection refused" saat akses aplikasi

**Solutions:**
1. Pastikan Laravel development server sudah berjalan:
   ```bash
   php artisan serve
   ```

2. Cek port yang digunakan:
   ```bash
   php artisan serve --port=8001
   ```
   Jika port 8000 sudah dipakai, gunakan port lain.

3. Jika menggunakan Laragon:
   - Restart Apache
   - Pastikan virtual host sudah benar di `httpd-vhosts.conf`
   - Check file di hosts: `C:\Windows\System32\drivers\etc\hosts`

---

## 🔑 Authentication Issues

### Issue: Login tidak berhasil / "Auth failed"

**Solutions:**
1. Pastikan credentials benar:
   - Email: **tepat** (jangan ada spasi)
   - Password: **password** (lowercase, tidak ada spasi)

2. Reset demo users:
   ```bash
   php artisan migrate:fresh --seed
   ```

3. Cek database connection:
   ```bash
   php artisan tinker
   >>> DB::table('users')->get();
   ```

### Issue: Session expires terlalu cepat

Edit `.env`:
```env
SESSION_LIFETIME=525600  # 1 tahun (default 120 menit)
```

Atau di `config/session.php`:
```php
'lifetime' => env('SESSION_LIFETIME', 525600),
```

---

## 📁 File Upload Issues

### Issue: File tidak bisa di-upload / "File validation failed"

**Solutions:**
1. Pastikan file memenuhi kriteria:
   - Format: PDF, JPG, JPEG, PNG
   - Ukuran: maksimal 5MB
   - Contoh: `surat.pdf` ✅, `surat.docx` ❌

2. Cek folder writable:
   ```bash
   chmod -R 755 storage/
   chmod -R 755 bootstrap/cache/
   ```

3. Windows - gunakan command prompt as admin:
   ```powershell
   icacls "storage" /grant:r "%USERNAME%:(OI)(CI)F"
   icacls "bootstrap\cache" /grant:r "%USERNAME%:(OI)(CI)F"
   ```

### Issue: File tidak bisa di-download

**Solutions:**
1. Cek apakah storage link sudah dibuat:
   ```bash
   php artisan storage:link
   ```

2. File masih ada di server:
   ```bash
   ls storage/app/public/surat_masuk/
   ```

3. Cek permissions:
   ```bash
   chmod -R 644 storage/app/public/
   ```

4. Test akses file:
   - Buka: `http://localhost:8000/storage/surat_masuk/nama_file.pdf`

---

## 💾 Database Issues

### Issue: "Table already exists" atau migration error

**Solutions:**
1. Reset database sepenuhnya:
   ```bash
   php artisan migrate:reset --force
   php artisan migrate --force
   ```

2. Fresh start dengan seed:
   ```bash
   php artisan migrate:fresh --seed
   ```

3. Cek database file:
   ```bash
   ls -la database/database.sqlite
   ```
   Jika ada permission issues:
   ```bash
   chmod 666 database/database.sqlite
   ```

### Issue: "UNIQUE constraint failed" saat insert

**Penyebab**: Nomor surat atau email sudah ada di database

**Solutions:**
1. Clear data & seed ulang:
   ```bash
   php artisan migrate:fresh --seed
   ```

2. Manual delete data:
   ```bash
   php artisan tinker
   >>> DB::table('surat_masuk')->delete();
   >>> DB::table('users')->whereNotIn('role', ['admin'])->delete();
   ```

---

## 👥 User & Role Issues

### Issue: User tidak bisa akses fitur sesuai role

**Debug:**
1. Check user role di database:
   ```bash
   php artisan tinker
   >>> User::find(1)->role;
   ```

2. Edit user role:
   ```bash
   >>> $user = User::find(1);
   >>> $user->role = 'tu';
   >>> $user->save();
   ```

### Issue: Admin tidak bisa akses admin panel

**Solutions:**
1. Pastikan user memiliki role 'admin':
   ```bash
   php artisan tinker
   >>> User::where('email', 'admin@esurat.local')->update(['role' => 'admin']);
   ```

2. Clear browser cache:
   - Press: `Ctrl+Shift+Delete`
   - Delete cookies untuk `localhost:8000`

3. Logout dan login ulang

---

## 🎨 UI & Display Issues

### Issue: CSS/styling tidak tampil dengan benar

**Solutions:**
1. Jika menggunakan Vite:
   ```bash
   npm run dev
   npm run build
   ```

2. Clear browser cache:
   - Press: `Ctrl+F5` (force refresh)
   - Atau: `Ctrl+Shift+R`

3. Jika bootstrap tidak loading:
   - Aplikasi menggunakan CDN
   - Check internet connection
   - Atau edit `resources/views/layouts/app.blade.php` gunakan local bootstrap

### Issue: Sidebar menu tidak muncul

**Solutions:**
1. Login terlebih dahulu (sidebar hanya muncul untuk authenticated users)
2. Check user role:
   - Sidebar content berdasarkan `auth()->user()->role`

---

## 🔄 Performance Issues

### Issue: Aplikasi lambat / loading lama

**Solutions:**
1. Clear cache:
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   ```

2. Optimize autoloader:
   ```bash
   composer dump-autoload -o
   ```

3. Check query performance:
   - Gunakan Laravel Debugbar
   - Atau enable query log di `.env`:
     ```env
     DB_QUERY_LOG=true
     ```

4. Reduce pagination size jika perlu:
   - Edit controller `->paginate(10)` jadi lebih kecil
   - Atau lebih besar jika OK

---

## 🔒 Permission & Security Issues

### Issue: "403 Unauthorized" atau akses ditolak

**Penyebab**: Role tidak sesuai untuk mengakses fitur

**Solutions:**
1. Pastikan login dengan role yang tepat:
   - TU untuk input surat masuk
   - Kepala Sekolah untuk disposisi
   - User biasa untuk terima disposisi
   - Admin untuk manage user & backup

2. Check route permissions:
   - Routes sudah diberi middleware sesuai role
   - Contoh: `Route::post(...)->middleware('admin')`

3. Manual update user role jika perlu:
   ```bash
   php artisan tinker
   >>> User::where('email', 'tu@esurat.local')->update(['role' => 'tu']);
   ```

---

## 📧 Notification Issues

### Issue: Email notifications tidak terkirim

**Status**: Email currently NOT implemented
- Aplikasi ini belum memiliki email notifications
- Semua notifikasi hanya di dalam aplikasi (flash messages)
- Untuk menambah email, edit `config/mail.php`

---

## 🐛 Debug Mode

### Enable detailed error messages

Edit `.env`:
```env
APP_DEBUG=true
APP_ENV=local
```

Ini akan menampilkan stack trace lengkap jika terjadi error.

### Check Laravel logs

```bash
tail -f storage/logs/laravel.log
```

Atau di Windows:
```powershell
Get-Content storage/logs/laravel.log -Tail 50 -Wait
```

---

## 🔄 Reset & Clean Installation

### Hard Reset (jika semua gagal)

```bash
# 1. Hapus database
rm database/database.sqlite

# 2. Buat database baru
touch database/database.sqlite

# 3. Run migrations
php artisan migrate --force

# 4. Seed demo users
php artisan db:seed

# 5. Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# 6. Restart Laravel
php artisan serve
```

### Windows PowerShell version:

```powershell
# 1. Hapus database
Remove-Item database/database.sqlite -Force

# 2. Create file baru
New-Item -Path database/database.sqlite -ItemType File

# 3-6: Same as above
```

---

## 📞 Getting Help

### Diagnostic Command

Jalankan ini untuk mendapat info sistem:

```bash
php artisan tinker
```

Kemudian:
```bash
>>> phpversion()           # PHP version
>>> config('app.name')     # App name
>>> DB::connection()->getDatabaseName()  # Database name
>>> User::count()          # Total users
>>> Schema::getTables()    # List tables
```

### Check Application Health

```bash
php artisan config:show
php artisan migrate:status
php artisan storage:link
```

---

## 📝 Common Quick Fixes

| Issue | Quick Fix |
|-------|-----------|
| Database error | `php artisan migrate:fresh --seed` |
| Cache problem | `php artisan cache:clear` |
| View problem | `php artisan view:clear` |
| Config problem | `php artisan config:clear` |
| Storage link | `php artisan storage:link` |
| Slow app | `composer dump-autoload -o` |
| Login fail | Reset password or `migrate:fresh` |
| File upload fail | Check file type/size, chmod storage |
| CSS not showing | `Ctrl+Shift+Delete` browser cache |
| 403 error | Check user role, login with correct account |

---

## 🆘 Still Having Issues?

1. **Check the logs**:
   ```bash
   cat storage/logs/laravel.log
   ```

2. **Review documentation**:
   - `README_ESURAT.md` - Technical docs
   - `QUICK_START.md` - User guide
   - `IMPLEMENTATION_CHECKLIST.md` - Features list

3. **Common mistakes**:
   - ❌ Wrong email format (extra spaces)
   - ❌ File format not supported
   - ❌ Storage folder not writable
   - ❌ Database not seeded with users
   - ❌ Wrong port (8000 sudah dipakai)

4. **Last resort - Fresh installation**:
   ```bash
   php artisan migrate:fresh --seed
   php artisan cache:clear
   php artisan config:clear
   php artisan serve
   ```

---

**Version**: 1.0.0  
**Last Updated**: January 9, 2026

Good luck! 🚀
