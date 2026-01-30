<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\Disposisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DisposisiController extends Controller
{
    public function create(SuratMasuk $suratMasuk)
    {
        if (auth()->user()->role !== 'kepala_sekolah') {
            abort(403, 'Hanya Kepala Sekolah yang dapat membuat disposisi');
        }

        if ($suratMasuk->status !== 'submitted') {
            abort(403, 'Surat tidak dalam status submitted');
        }

        $users = User::where('role', '!=', 'admin')->get();
        
        return view('disposisi.create', compact('suratMasuk', 'users'));
    }

    public function store(Request $request, SuratMasuk $suratMasuk)
    {
        if (auth()->user()->role !== 'kepala_sekolah') {
            abort(403);
        }

        if ($suratMasuk->status !== 'submitted') {
            abort(403);
        }

        $validated = $request->validate([
            'disposisi_ke' => 'required|array|min:1',
            'disposisi_ke.*' => 'required|exists:users,id',
            'isi_disposisi' => 'required|array|min:1',
            'isi_disposisi.*' => 'string',
            'catatan_kepala_sekolah' => 'nullable|string',
            'tambah_tanda_tangan' => 'required|in:ya,tidak',
        ]);

        // Get signature file path if user chose to add signature
        $filePath = null;
        if ($validated['tambah_tanda_tangan'] === 'ya') {
            $tandaTangan = \App\Models\TandaTangan::where('user_id', auth()->id())->first();
            if ($tandaTangan) {
                $filePath = $tandaTangan->file_path;
            }
        }

        // Convert checkbox array to comma-separated string
        $isiDisposisiString = implode(',', $validated['isi_disposisi']);

        // Buat disposisi untuk setiap user yang dipilih
        foreach ($validated['disposisi_ke'] as $userId) {
            Disposisi::create([
                'surat_masuk_id' => $suratMasuk->id,
                'disposisi_ke' => $userId,
                'isi_disposisi' => $isiDisposisiString,
                'catatan_kepala_sekolah' => $validated['catatan_kepala_sekolah'],
                'tanda_tangan_file' => $filePath,
                'status' => 'pending',
                'created_by' => auth()->id(),
            ]);
        }

        // Update status surat masuk menjadi 'disposed' dan set kepala_sekolah_id
        $suratMasuk->update(['status' => 'disposed', 'kepala_sekolah_id' => auth()->id()]);

        return redirect()->route('surat-masuk.show', $suratMasuk)->with('success', 'Disposisi berhasil dibuat untuk ' . count($validated['disposisi_ke']) . ' penerima');
    }

    public function receive(Disposisi $disposisi)
    {
        if ($disposisi->disposisi_ke !== auth()->id()) {
            abort(403);
        }

        $disposisi->update([
            'status' => 'received',
            'received_at' => now(),
        ]);

        // Check apakah semua disposisi untuk surat masuk ini sudah received
        $suratMasuk = $disposisi->suratMasuk;
        $pendingDispositions = $suratMasuk->disposisi()
            ->where('status', 'pending')
            ->count();

        // Update status surat masuk hanya jika tidak ada disposisi pending lagi
        if ($pendingDispositions === 0) {
            $suratMasuk->update(['status' => 'received']);
        }

        return redirect()->route('surat-masuk.show', $suratMasuk)->with('success', 'Disposisi berhasil diterima');
    }

    public function show(Disposisi $disposisi)
    {
        $user = auth()->user();
        
        // Check if user can view this disposisi
        if ($disposisi->disposisi_ke !== $user->id && $user->role !== 'kepala_sekolah' && $user->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses ke disposisi ini');
        }
        
        return view('disposisi.show', compact('disposisi'));
    }

    public function edit(Disposisi $disposisi)
    {
        if (auth()->user()->role !== 'kepala_sekolah') {
            abort(403, 'Hanya Kepala Sekolah yang dapat mengedit disposisi');
        }

        if ($disposisi->created_by !== auth()->id()) {
            abort(403, 'Anda hanya dapat mengedit disposisi yang Anda buat');
        }

        // Hanya disposisi dengan status pending atau received dapat diedit
        if (!in_array($disposisi->status, ['pending', 'received'])) {
            abort(403, 'Disposisi tidak dapat diedit dalam status ini');
        }

        $suratMasuk = $disposisi->suratMasuk;
        $users = User::where('role', '!=', 'admin')->get();
        $userTandaTangan = \App\Models\TandaTangan::where('user_id', auth()->id())->first();

        return view('disposisi.edit', compact('disposisi', 'suratMasuk', 'users', 'userTandaTangan'));
    }

    public function update(Request $request, Disposisi $disposisi)
    {
        if (auth()->user()->role !== 'kepala_sekolah') {
            abort(403);
        }

        if ($disposisi->created_by !== auth()->id()) {
            abort(403);
        }

        if (!in_array($disposisi->status, ['pending', 'received'])) {
            abort(403);
        }

        $validated = $request->validate([
            'disposisi_ke' => 'required|exists:users,id',
            'isi_disposisi' => 'required|array|min:1',
            'isi_disposisi.*' => 'string',
            'catatan_kepala_sekolah' => 'nullable|string',
            'tambah_tanda_tangan' => 'required|in:ya,tidak',
        ]);

        // Get signature file path if user chose to add signature
        $filePath = $disposisi->tanda_tangan_file;
        if ($validated['tambah_tanda_tangan'] === 'ya') {
            $tandaTangan = \App\Models\TandaTangan::where('user_id', auth()->id())->first();
            if ($tandaTangan) {
                $filePath = $tandaTangan->file_path;
            }
        } else {
            $filePath = null;
        }

        // Convert checkbox array to comma-separated string
        $isiDisposisiString = implode(',', $validated['isi_disposisi']);

        // Update disposisi
        $disposisi->update([
            'disposisi_ke' => $validated['disposisi_ke'],
            'isi_disposisi' => $isiDisposisiString,
            'catatan_kepala_sekolah' => $validated['catatan_kepala_sekolah'],
            'tanda_tangan_file' => $filePath,
        ]);

        return redirect()->route('disposisi.show', $disposisi)->with('success', 'Disposisi berhasil diperbarui');
    }
}
