<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\BackupLetters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $usersByRole = User::selectRaw('role, count(*) as count')->groupBy('role')->pluck('count', 'role');
        $suratMasukCount = SuratMasuk::count();
        $suratKeluarCount = SuratKeluar::count();
        $backupCount = BackupLetters::count();

        return view('admin.dashboard', compact('totalUsers', 'usersByRole', 'suratMasukCount', 'suratKeluarCount', 'backupCount'));
    }

    public function userIndex()
    {
        $users = User::paginate(10);
        
        return view('admin.users.index', compact('users'));
    }

    public function userCreate()
    {
        return view('admin.users.create');
    }

    public function userStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'no_hp' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,kepala_sekolah,wakasek_kurikulum,wakasek_sarana_prasarana,wakasek_kesiswaan,wakasek_humas,tu,ka_tu,kaprog_dkv,kaprog_pplg,kaprog_tjkt,kaprog_bd,guru,pembina_ekstra,bkk,staff',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan');
    }

    public function userEdit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function userUpdate(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'no_hp' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,kepala_sekolah,wakasek_kurikulum,wakasek_sarana_prasarana,wakasek_kesiswaan,wakasek_humas,tu,ka_tu,kaprog_dkv,kaprog_pplg,kaprog_tjkt,kaprog_bd,guru,pembina_ekstra,bkk,staff',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->no_hp = $validated['no_hp'];
        $user->role = $validated['role'];

        if ($validated['password']) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui');
    }

    public function userDestroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus');
    }

    public function backup()
    {
        return view('admin.backup');
    }

    public function backupDatabase()
    {
        try {
            $backupPath = storage_path('backups');
            
            if (!is_dir($backupPath)) {
                mkdir($backupPath, 0755, true);
            }

            $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
            $backupFile = $backupPath . '/backup_' . $timestamp . '.sql';

            // Get database credentials from .env
            $dbHost = env('DB_HOST', 'localhost');
            $dbPort = env('DB_PORT', '3306');
            $dbName = env('DB_DATABASE');
            $dbUser = env('DB_USERNAME');
            $dbPassword = env('DB_PASSWORD');

            // Find mysqldump in Laragon installation
            $mysqldumpPath = 'D:\\laragon\\bin\\mysql\\mysql-8.4.3-winx64\\bin\\mysqldump.exe';
            
            if (!file_exists($mysqldumpPath)) {
                // Try to find any mysql version available
                $mysqlDir = 'D:\\laragon\\bin\\mysql\\';
                if (is_dir($mysqlDir)) {
                    $folders = glob($mysqlDir . 'mysql-*', GLOB_ONLYDIR);
                    if (!empty($folders)) {
                        $mysqldumpPath = $folders[0] . '\\bin\\mysqldump.exe';
                    }
                }
            }

            if (!file_exists($mysqldumpPath)) {
                throw new \Exception('mysqldump tidak ditemukan di ' . $mysqldumpPath);
            }

            // Build mysqldump command
            $password = $dbPassword ? '-p' . $dbPassword : '';
            $command = '"' . $mysqldumpPath . '" -h ' . $dbHost . ' -P ' . $dbPort . ' -u ' . $dbUser . ' ' . $password . ' ' . $dbName . ' > "' . $backupFile . '"';

            // Execute mysqldump
            exec($command, $output, $returnCode);

            if ($returnCode !== 0) {
                $errorOutput = implode("\n", $output);
                throw new \Exception('Gagal eksekusi mysqldump. Error: ' . $errorOutput);
            }

            if (!file_exists($backupFile) || filesize($backupFile) === 0) {
                throw new \Exception('File backup tidak terbuat atau kosong');
            }

            // Opsi: Download langsung ATAU simpan dan redirect ke list
            // Uncomment salah satu sesuai preferensi Anda:
            
            // Opsi 1: Download langsung (tanpa menyimpan record)
            // return response()->download($backupFile)->deleteFileAfterSend(true);
            
            // Opsi 2: Simpan file dan tampilkan di daftar (RECOMMENDED)
            $fileName = basename($backupFile);
            return redirect()->route('admin.backup.list')
                ->with('success', 'Backup database berhasil dibuat: ' . $fileName);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat backup: ' . $e->getMessage());
        }
    }

    public function backupList()
    {
        $backupPath = storage_path('backups');
        $backups = [];

        if (is_dir($backupPath)) {
            $files = scandir($backupPath);
            foreach ($files as $file) {
                if (strpos($file, 'backup_') === 0 && strpos($file, '.sql') !== false) {
                    $backups[] = [
                        'name' => $file,
                        'size' => filesize($backupPath . '/' . $file),
                        'date' => filemtime($backupPath . '/' . $file),
                    ];
                }
            }
        }

        usort($backups, function ($a, $b) {
            return $b['date'] - $a['date'];
        });

        return view('admin.backup-list', compact('backups'));
    }

    public function downloadBackup($filename)
    {
        try {
            $backupPath = storage_path('backups');
            $backupFile = $backupPath . '/' . basename($filename);

            if (!file_exists($backupFile)) {
                return back()->with('error', 'File backup tidak ditemukan');
            }

            return response()->download($backupFile);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal download backup: ' . $e->getMessage());
        }
    }

    public function restoreBackup($filename)
    {
        try {
            $backupPath = storage_path('backups');
            $backupFile = $backupPath . '/' . basename($filename);

            if (!file_exists($backupFile)) {
                return back()->with('error', 'File backup tidak ditemukan');
            }

            // Get database credentials from .env
            $dbHost = env('DB_HOST', 'localhost');
            $dbPort = env('DB_PORT', '3306');
            $dbName = env('DB_DATABASE');
            $dbUser = env('DB_USERNAME');
            $dbPassword = env('DB_PASSWORD');

            // Find mysql in Laragon installation
            $mysqlPath = 'D:\\laragon\\bin\\mysql\\mysql-8.4.3-winx64\\bin\\mysql.exe';
            
            if (!file_exists($mysqlPath)) {
                // Try to find any mysql version available
                $mysqlDir = 'D:\\laragon\\bin\\mysql\\';
                if (is_dir($mysqlDir)) {
                    $folders = glob($mysqlDir . 'mysql-*', GLOB_ONLYDIR);
                    if (!empty($folders)) {
                        $mysqlPath = $folders[0] . '\\bin\\mysql.exe';
                    }
                }
            }

            if (!file_exists($mysqlPath)) {
                throw new \Exception('mysql tidak ditemukan di ' . $mysqlPath);
            }

            // Build mysql command to restore from SQL dump
            $password = $dbPassword ? '-p' . $dbPassword : '';
            $command = '"' . $mysqlPath . '" -h ' . $dbHost . ' -P ' . $dbPort . ' -u ' . $dbUser . ' ' . $password . ' ' . $dbName . ' < "' . $backupFile . '"';

            // Execute mysql restore command
            exec($command, $output, $returnCode);

            if ($returnCode !== 0) {
                $errorOutput = implode("\n", $output);
                throw new \Exception('Gagal eksekusi restore. Error: ' . $errorOutput);
            }

            return back()->with('success', 'Database berhasil direstore dari backup');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal restore backup: ' . $e->getMessage());
        }
    }

    public function deleteBackup($filename)
    {
        try {
            $backupPath = storage_path('backups');
            $backupFile = $backupPath . '/' . basename($filename);

            if (file_exists($backupFile)) {
                unlink($backupFile);
            }

            return back()->with('success', 'Backup berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus backup: ' . $e->getMessage());
        }
    }
}
