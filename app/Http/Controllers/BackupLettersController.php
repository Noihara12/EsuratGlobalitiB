<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\BackupLetters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use ZipArchive;
use File;

class BackupLettersController extends Controller
{
    public function index()
    {
        $backups = BackupLetters::with('creator')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $suratMasukCount = SuratMasuk::count();
        $suratKeluarCount = SuratKeluar::count();
        $totalLetters = $suratMasukCount + $suratKeluarCount;

        return view('admin.backup-letters.index', compact('backups', 'suratMasukCount', 'suratKeluarCount', 'totalLetters'));
    }

    public function create()
    {
        $suratMasukCount = SuratMasuk::count();
        $suratKeluarCount = SuratKeluar::count();

        return view('admin.backup-letters.create', compact('suratMasukCount', 'suratKeluarCount'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'type' => 'required|in:surat_masuk,surat_keluar,all',
                'notes' => 'nullable|string|max:500',
            ]);

            // Determine which letters to backup
            if ($validated['type'] === 'surat_masuk') {
                $suratMasuk = SuratMasuk::all();
                $suratKeluar = collect();
            } elseif ($validated['type'] === 'surat_keluar') {
                $suratMasuk = collect();
                $suratKeluar = SuratKeluar::all();
            } else {
                $suratMasuk = SuratMasuk::all();
                $suratKeluar = SuratKeluar::all();
            }

            // Create backup directory
            $backupDir = storage_path('app/backups/letters/' . Carbon::now()->format('Y-m-d_H-i-s'));
            if (!is_dir($backupDir)) {
                mkdir($backupDir, 0755, true);
            }

            // Create subdirectories
            $masukDir = $backupDir . '/surat_masuk';
            $keluarDir = $backupDir . '/surat_keluar';
            mkdir($masukDir, 0755, true);
            mkdir($keluarDir, 0755, true);

            $totalLetters = 0;
            $totalAttachments = 0;
            $attachmentErrors = [];

            // Backup Surat Masuk
            if ($suratMasuk->count() > 0) {
                $masukAttachmentDir = $masukDir . '/attachments';
                mkdir($masukAttachmentDir, 0755, true);

                foreach ($suratMasuk as $surat) {
                    $totalLetters++;

                    // Copy attachment if exists
                    if ($surat->file_lampiran) {
                        // Try multiple possible paths
                        $possiblePaths = [
                            storage_path('app/public/' . $surat->file_lampiran),
                            storage_path('app/' . $surat->file_lampiran),
                        ];
                        
                        $sourceFile = null;
                        foreach ($possiblePaths as $path) {
                            if (file_exists($path)) {
                                $sourceFile = $path;
                                break;
                            }
                        }
                        
                        if ($sourceFile) {
                            $fileName = basename($surat->file_lampiran);
                            $destFile = $masukAttachmentDir . '/' . $surat->id . '_' . $fileName;
                            try {
                                copy($sourceFile, $destFile);
                                $totalAttachments++;
                            } catch (\Exception $e) {
                                $attachmentErrors[] = "Gagal menyalin lampiran surat masuk #" . $surat->id . ": " . $e->getMessage();
                            }
                        }
                    }
                }

                // Create JSON file with letter data
                $masukData = $suratMasuk->map(function ($surat) {
                    return [
                        'id' => $surat->id,
                        'jenis_surat' => $surat->jenis_surat,
                        'kode_surat' => $surat->kode_surat,
                        'nomor_surat' => $surat->nomor_surat,
                        'tanggal_surat' => $surat->tanggal_surat,
                        'asal_surat' => $surat->asal_surat,
                        'perihal' => $surat->perihal,
                        'catatan' => $surat->catatan,
                        'file_lampiran' => $surat->file_lampiran,
                        'status' => $surat->status,
                        'created_by' => $surat->created_by,
                        'kepala_sekolah_id' => $surat->kepala_sekolah_id,
                        'is_archived' => $surat->is_archived,
                        'archived_at' => $surat->archived_at,
                        'created_at' => $surat->created_at,
                        'updated_at' => $surat->updated_at,
                    ];
                })->toArray();

                file_put_contents($masukDir . '/data.json', json_encode($masukData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            }

            // Backup Surat Keluar
            if ($suratKeluar->count() > 0) {
                $keluarAttachmentDir = $keluarDir . '/attachments';
                mkdir($keluarAttachmentDir, 0755, true);

                foreach ($suratKeluar as $surat) {
                    $totalLetters++;

                    // Copy attachment if exists
                    if ($surat->file_lampiran) {
                        // Try multiple possible paths
                        $possiblePaths = [
                            storage_path('app/public/' . $surat->file_lampiran),
                            storage_path('app/' . $surat->file_lampiran),
                        ];
                        
                        $sourceFile = null;
                        foreach ($possiblePaths as $path) {
                            if (file_exists($path)) {
                                $sourceFile = $path;
                                break;
                            }
                        }
                        
                        if ($sourceFile) {
                            $fileName = basename($surat->file_lampiran);
                            $destFile = $keluarAttachmentDir . '/' . $surat->id . '_' . $fileName;
                            try {
                                copy($sourceFile, $destFile);
                                $totalAttachments++;
                            } catch (\Exception $e) {
                                $attachmentErrors[] = "Gagal menyalin lampiran surat keluar #" . $surat->id . ": " . $e->getMessage();
                            }
                        }
                    }
                }

                // Create JSON file with letter data
                $keluarData = $suratKeluar->map(function ($surat) {
                    return [
                        'id' => $surat->id,
                        'nomor_surat' => $surat->nomor_surat,
                        'tanggal_surat' => $surat->tanggal_surat,
                        'tujuan' => $surat->tujuan,
                        'perihal' => $surat->perihal,
                        'isi_surat' => $surat->isi_surat,
                        'file_lampiran' => $surat->file_lampiran,
                        'status' => $surat->status,
                        'created_by' => $surat->created_by,
                        'is_archived' => $surat->is_archived,
                        'archived_at' => $surat->archived_at,
                        'created_at' => $surat->created_at,
                        'updated_at' => $surat->updated_at,
                    ];
                })->toArray();

                file_put_contents($keluarDir . '/data.json', json_encode($keluarData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            }

            // Create backup metadata file
            $metadata = [
                'backup_date' => Carbon::now()->format('Y-m-d H:i:s'),
                'type' => $validated['type'],
                'total_letters' => $totalLetters,
                'total_attachments' => $totalAttachments,
                'backup_by' => auth()->user()->name,
                'notes' => $validated['notes'] ?? '',
            ];
            file_put_contents($backupDir . '/metadata.json', json_encode($metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            // Create ZIP file
            $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
            $backupName = 'backup_surat_' . $validated['type'] . '_' . $timestamp . '.zip';
            $zipPath = storage_path('app/backups/letters/' . $backupName);

            $zip = new ZipArchive();
            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                $this->addDirToZip($backupDir, $zip, basename($backupDir));
                $zip->close();
            }

            // Delete temporary backup directory
            File::deleteDirectory($backupDir);

            // Calculate file size
            $fileSize = filesize($zipPath);

            // Save to database
            BackupLetters::create([
                'backup_name' => $backupName,
                'type' => $validated['type'],
                'total_letters' => $totalLetters,
                'total_attachments' => $totalAttachments,
                'file_size' => $fileSize,
                'file_path' => 'backups/letters/' . $backupName,
                'created_by' => auth()->id(),
                'notes' => $validated['notes'] ?? null,
            ]);

            $successMessage = 'Backup berhasil dibuat. Total surat: ' . $totalLetters . ', Total lampiran: ' . $totalAttachments;
            
            if (!empty($attachmentErrors)) {
                $successMessage .= '\n\nPeringatan:\n' . implode('\n', array_slice($attachmentErrors, 0, 5));
                if (count($attachmentErrors) > 5) {
                    $successMessage .= '\n... dan ' . (count($attachmentErrors) - 5) . ' error lainnya';
                }
            }

            return redirect()->route('admin.backup-letters.index')->with('success', $successMessage);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat backup: ' . $e->getMessage());
        }
    }

    public function download(BackupLetters $backupLetters)
    {
        try {
            $filePath = storage_path('app/' . $backupLetters->file_path);

            if (!file_exists($filePath)) {
                \Log::error('Backup file not found', [
                    'file_path' => $backupLetters->file_path,
                    'full_path' => $filePath,
                    'exists' => file_exists($filePath)
                ]);
                return back()->with('error', 'File backup tidak ditemukan: ' . $filePath);
            }

            return response()->download($filePath, $backupLetters->backup_name);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal download backup: ' . $e->getMessage());
        }
    }

    public function show(BackupLetters $backupLetters)
    {
        $backupLetters->load('creator');
        
        // Try to read metadata if available
        $metadata = null;
        $filePath = storage_path('app/' . $backupLetters->file_path);
        
        if (file_exists($filePath)) {
            $zip = new ZipArchive();
            if ($zip->open($filePath) === true) {
                // Find and read metadata.json
                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $filename = $zip->getNameIndex($i);
                    if (basename($filename) === 'metadata.json') {
                        $metadata = json_decode($zip->getFromName($filename), true);
                        break;
                    }
                }
                $zip->close();
            }
        }

        return view('admin.backup-letters.show', compact('backupLetters', 'metadata'));
    }

    public function restore(BackupLetters $backupLetters)
    {
        return view('admin.backup-letters.restore', compact('backupLetters'));
    }

    public function restoreStore(Request $request, BackupLetters $backupLetters)
    {
        try {
            $validated = $request->validate([
                'restore_surat_masuk' => 'boolean',
                'restore_surat_keluar' => 'boolean',
                'merge_data' => 'boolean',
            ]);

            $filePath = storage_path('app/' . $backupLetters->file_path);

            if (!file_exists($filePath)) {
                return back()->with('error', 'File backup tidak ditemukan');
            }

            // Extract ZIP file
            $extractPath = storage_path('backups/extract/' . time());
            if (!is_dir($extractPath)) {
                mkdir($extractPath, 0755, true);
            }

            $zip = new ZipArchive();
            if ($zip->open($filePath) !== true) {
                return back()->with('error', 'Gagal membuka file backup');
            }

            $zip->extractTo($extractPath);
            $zip->close();

            $restoredCount = 0;
            $errors = [];

            // Find the backup folder (it has timestamp)
            $backupFolders = glob($extractPath . '/backup_surat_*', GLOB_ONLYDIR);
            if (empty($backupFolders)) {
                // Fallback to looking for any folder
                $items = array_diff(scandir($extractPath), ['.', '..']);
                foreach ($items as $item) {
                    if (is_dir($extractPath . '/' . $item)) {
                        $backupFolders[] = $extractPath . '/' . $item;
                        break;
                    }
                }
            }

            if (empty($backupFolders)) {
                return back()->with('error', 'Struktur file backup tidak valid');
            }

            $backupFolder = $backupFolders[0];

            // Restore Surat Masuk
            if ($validated['restore_surat_masuk'] ?? false) {
                $masukPath = $backupFolder . '/surat_masuk';
                if (is_dir($masukPath) && file_exists($masukPath . '/data.json')) {
                    try {
                        $data = json_decode(file_get_contents($masukPath . '/data.json'), true);
                        $attachmentDir = $masukPath . '/attachments';

                        foreach ($data as $item) {
                            try {
                                // Check if record already exists
                                $existingSurat = SuratMasuk::find($item['id']);

                                if ($existingSurat && !($validated['merge_data'] ?? false)) {
                                    continue;
                                }

                                // Restore attachment if exists
                                $newAttachmentPath = null;
                                if ($item['file_lampiran'] && is_dir($attachmentDir)) {
                                    $attachmentFiles = glob($attachmentDir . '/' . $item['id'] . '_*');
                                    if (!empty($attachmentFiles)) {
                                        $sourceAttachment = $attachmentFiles[0];
                                        $fileName = basename($sourceAttachment);
                                        $newFileName = preg_replace('/^\d+_/', '', $fileName);
                                        $destPath = 'public/surat_masuk/' . $item['id'] . '_' . time() . '_' . $newFileName;
                                        $destFullPath = storage_path('app/' . $destPath);
                                        
                                        if (!is_dir(dirname($destFullPath))) {
                                            mkdir(dirname($destFullPath), 0755, true);
                                        }

                                        copy($sourceAttachment, $destFullPath);
                                        $newAttachmentPath = $destPath;
                                    }
                                }

                                if ($existingSurat) {
                                    // Update existing
                                    $existingSurat->update([
                                        'jenis_surat' => $item['jenis_surat'],
                                        'kode_surat' => $item['kode_surat'],
                                        'nomor_surat' => $item['nomor_surat'],
                                        'tanggal_surat' => $item['tanggal_surat'],
                                        'asal_surat' => $item['asal_surat'],
                                        'perihal' => $item['perihal'],
                                        'catatan' => $item['catatan'],
                                        'file_lampiran' => $newAttachmentPath ?? $item['file_lampiran'],
                                        'status' => $item['status'],
                                    ]);
                                } else {
                                    // Create new
                                    SuratMasuk::create([
                                        'id' => $item['id'],
                                        'jenis_surat' => $item['jenis_surat'],
                                        'kode_surat' => $item['kode_surat'],
                                        'nomor_surat' => $item['nomor_surat'],
                                        'tanggal_surat' => $item['tanggal_surat'],
                                        'asal_surat' => $item['asal_surat'],
                                        'perihal' => $item['perihal'],
                                        'catatan' => $item['catatan'],
                                        'file_lampiran' => $newAttachmentPath,
                                        'status' => $item['status'],
                                        'created_by' => $item['created_by'],
                                        'kepala_sekolah_id' => $item['kepala_sekolah_id'],
                                        'is_archived' => $item['is_archived'],
                                        'archived_at' => $item['archived_at'],
                                    ]);
                                }

                                $restoredCount++;
                            } catch (\Exception $e) {
                                $errors[] = 'Surat masuk #' . $item['id'] . ': ' . $e->getMessage();
                            }
                        }
                    } catch (\Exception $e) {
                        $errors[] = 'Error membaca data surat masuk: ' . $e->getMessage();
                    }
                }
            }

            // Restore Surat Keluar
            if ($validated['restore_surat_keluar'] ?? false) {
                $keluarPath = $backupFolder . '/surat_keluar';
                if (is_dir($keluarPath) && file_exists($keluarPath . '/data.json')) {
                    try {
                        $data = json_decode(file_get_contents($keluarPath . '/data.json'), true);
                        $attachmentDir = $keluarPath . '/attachments';

                        foreach ($data as $item) {
                            try {
                                // Check if record already exists
                                $existingSurat = SuratKeluar::find($item['id']);

                                if ($existingSurat && !($validated['merge_data'] ?? false)) {
                                    continue;
                                }

                                // Restore attachment if exists
                                $newAttachmentPath = null;
                                if ($item['file_lampiran'] && is_dir($attachmentDir)) {
                                    $attachmentFiles = glob($attachmentDir . '/' . $item['id'] . '_*');
                                    if (!empty($attachmentFiles)) {
                                        $sourceAttachment = $attachmentFiles[0];
                                        $fileName = basename($sourceAttachment);
                                        $newFileName = preg_replace('/^\d+_/', '', $fileName);
                                        $destPath = 'public/surat_keluar/' . $item['id'] . '_' . time() . '_' . $newFileName;
                                        $destFullPath = storage_path('app/' . $destPath);
                                        
                                        if (!is_dir(dirname($destFullPath))) {
                                            mkdir(dirname($destFullPath), 0755, true);
                                        }

                                        copy($sourceAttachment, $destFullPath);
                                        $newAttachmentPath = $destPath;
                                    }
                                }

                                if ($existingSurat) {
                                    // Update existing
                                    $existingSurat->update([
                                        'nomor_surat' => $item['nomor_surat'],
                                        'tanggal_surat' => $item['tanggal_surat'],
                                        'tujuan' => $item['tujuan'],
                                        'perihal' => $item['perihal'],
                                        'isi_surat' => $item['isi_surat'],
                                        'file_lampiran' => $newAttachmentPath ?? $item['file_lampiran'],
                                        'status' => $item['status'],
                                    ]);
                                } else {
                                    // Create new
                                    SuratKeluar::create([
                                        'id' => $item['id'],
                                        'nomor_surat' => $item['nomor_surat'],
                                        'tanggal_surat' => $item['tanggal_surat'],
                                        'tujuan' => $item['tujuan'],
                                        'perihal' => $item['perihal'],
                                        'isi_surat' => $item['isi_surat'],
                                        'file_lampiran' => $newAttachmentPath,
                                        'status' => $item['status'],
                                        'created_by' => $item['created_by'],
                                        'is_archived' => $item['is_archived'],
                                        'archived_at' => $item['archived_at'],
                                    ]);
                                }

                                $restoredCount++;
                            } catch (\Exception $e) {
                                $errors[] = 'Surat keluar #' . $item['id'] . ': ' . $e->getMessage();
                            }
                        }
                    } catch (\Exception $e) {
                        $errors[] = 'Error membaca data surat keluar: ' . $e->getMessage();
                    }
                }
            }

            // Clean up
            File::deleteDirectory($extractPath);

            $message = 'Restore berhasil. Total surat yang direstore: ' . $restoredCount;
            if (!empty($errors)) {
                $message .= '\nPeringatan: ' . count($errors) . ' error';
            }

            return redirect()->route('admin.backup-letters.index')->with('success', $message);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal restore backup: ' . $e->getMessage());
        }
    }

    public function delete(BackupLetters $backupLetters)
    {
        try {
            $filePath = storage_path('app/' . $backupLetters->file_path);

            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $backupLetters->delete();

            // After deleting a backup from its detail page, don't return to the deleted show URL (404).
            // Redirect to the index listing instead.
            return redirect()->route('admin.backup-letters.index')->with('success', 'Backup berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus backup: ' . $e->getMessage());
        }
    }

    /**
     * Helper function to add directory to ZIP file recursively
     */
    private function addDirToZip($dir, &$zip, $zipDir = '')
    {
        $files = scandir($dir);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;

            $filePath = $dir . '/' . $file;
            $zipPath = $zipDir . '/' . $file;

            if (is_dir($filePath)) {
                $zip->addEmptyDir($zipPath);
                $this->addDirToZip($filePath, $zip, $zipPath);
            } else {
                $zip->addFile($filePath, $zipPath);
            }
        }
    }
}
