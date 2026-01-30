<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratKeluarController extends Controller
{
    public function index()
    {
        // Semua user dapat melihat semua surat keluar yang belum diarsipkan
        $suratKeluar = SuratKeluar::where('is_archived', false)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('surat_keluar.index', compact('suratKeluar'));
    }

    public function myLetters()
    {
        // User hanya melihat surat keluar yang mereka buat dan belum diarsipkan
        $user = auth()->user();
        $suratKeluar = SuratKeluar::where('created_by', $user->id)
            ->where('is_archived', false)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('surat_keluar.my_letters', compact('suratKeluar'));
    }

    public function create()
    {
        $user = auth()->user();
        $allowedRoles = ['tu', 'ka_tu', 'staff', 'wakasek_kurikulum', 'wakasek_sarana_prasarana', 'wakasek_kesiswaan', 'wakasek_humas', 'kaprog_dkv', 'kaprog_pplg', 'kaprog_tjkt', 'kaprog_bd', 'guru', 'pembina_ekstra', 'bkk'];
        
        if (!in_array($user->role, $allowedRoles)) {
            abort(403, 'Anda tidak memiliki akses untuk membuat surat keluar');
        }

        return view('surat_keluar.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $allowedRoles = ['tu', 'ka_tu', 'staff', 'wakasek_kurikulum', 'wakasek_sarana_prasarana', 'wakasek_kesiswaan', 'wakasek_humas', 'kaprog_dkv', 'kaprog_pplg', 'kaprog_tjkt', 'kaprog_bd', 'guru', 'pembina_ekstra', 'bkk'];
        
        if (!in_array($user->role, $allowedRoles)) {
            abort(403);
        }

        $validated = $request->validate([
            'nomor_surat' => 'required|string|unique:surat_keluar',
            'tanggal_surat' => 'required|date',
            'tujuan' => 'required|string',
            'perihal' => 'required|string',
            'isi_surat' => 'required|string',
            'file_lampiran' => $user->role === 'tu' 
                ? 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120'
                : 'nullable',
        ]);

        if ($user->role !== 'tu' && $request->hasFile('file_lampiran')) {
            return back()->with('error', 'User biasa tidak dapat mengunggah file lampiran');
        }

        $filePath = null;
        if ($user->role === 'tu' && $request->hasFile('file_lampiran')) {
            $file = $request->file('file_lampiran');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('surat_keluar', $fileName, 'public');
        }

        SuratKeluar::create([
            'nomor_surat' => $validated['nomor_surat'],
            'tanggal_surat' => $validated['tanggal_surat'],
            'tujuan' => $validated['tujuan'],
            'perihal' => $validated['perihal'],
            'isi_surat' => $validated['isi_surat'],
            'file_lampiran' => $filePath,
            'status' => 'draft',
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('surat-keluar.index')->with('success', 'Surat keluar berhasil dibuat');
    }

    public function show(SuratKeluar $suratKeluar)
    {
        $user = auth()->user();
        
        // Semua user dapat melihat surat yang sudah published
        // TU dan Admin dapat melihat semua surat (draft/published)
        // User lain hanya melihat surat published atau milik mereka
        if ($user->role === 'tu' || $user->role === 'admin') {
            // TU dan Admin bisa lihat semua surat
            return view('surat_keluar.show', compact('suratKeluar'));
        } elseif ($suratKeluar->status === 'published' || $suratKeluar->created_by === $user->id) {
            // User lain hanya bisa lihat surat published atau milik mereka
            return view('surat_keluar.show', compact('suratKeluar'));
        } else {
            abort(403, 'Anda tidak memiliki akses ke surat ini');
        }
    }

    public function edit(SuratKeluar $suratKeluar)
    {
        $user = auth()->user();
        
        if (($user->role !== 'tu' && $suratKeluar->created_by !== $user->id) || $suratKeluar->status !== 'draft') {
            abort(403);
        }

        return view('surat_keluar.edit', compact('suratKeluar'));
    }

    public function update(Request $request, SuratKeluar $suratKeluar)
    {
        $user = auth()->user();
        
        if (($user->role !== 'tu' && $suratKeluar->created_by !== $user->id) || $suratKeluar->status !== 'draft') {
            abort(403);
        }

        $validated = $request->validate([
            'nomor_surat' => 'required|string|unique:surat_keluar,nomor_surat,' . $suratKeluar->id,
            'tanggal_surat' => 'required|date',
            'tujuan' => 'required|string',
            'perihal' => 'required|string',
            'isi_surat' => 'required|string',
            'file_lampiran' => $user->role === 'tu' 
                ? 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120'
                : 'nullable',
        ]);

        if ($user->role === 'tu' && $request->hasFile('file_lampiran')) {
            if ($suratKeluar->file_lampiran) {
                Storage::disk('public')->delete($suratKeluar->file_lampiran);
            }
            $file = $request->file('file_lampiran');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $validated['file_lampiran'] = $file->storeAs('surat_keluar', $fileName, 'public');
        }

        $suratKeluar->update($validated);

        return redirect()->route('surat-keluar.show', $suratKeluar)->with('success', 'Surat berhasil diperbarui');
    }

    public function publish(SuratKeluar $suratKeluar)
    {
        $user = auth()->user();
        
        if ($user->role !== 'tu' || $suratKeluar->status !== 'draft') {
            abort(403);
        }

        $suratKeluar->update(['status' => 'published']);

        return redirect()->route('surat-keluar.show', $suratKeluar)->with('success', 'Surat berhasil dipublikasikan');
    }

    public function destroy(SuratKeluar $suratKeluar)
    {
        $user = auth()->user();
        
        if (($user->role !== 'tu' && $suratKeluar->created_by !== $user->id) || $suratKeluar->status !== 'draft') {
            abort(403);
        }

        if ($suratKeluar->file_lampiran) {
            Storage::disk('public')->delete($suratKeluar->file_lampiran);
        }

        $suratKeluar->delete();

        return redirect()->route('surat-keluar.index')->with('success', 'Surat berhasil dihapus');
    }

    public function archive(SuratKeluar $suratKeluar)
    {
        $tuRoles = ['tu', 'ka_tu'];
        $user = auth()->user();
        
        // Hanya TU & KA-TU yang dapat arsipkan surat
        if (!in_array($user->role, $tuRoles)) {
            abort(403, 'Hanya TU dan KA-TU yang dapat mengarsipkan surat');
        }

        $suratKeluar->update([
            'is_archived' => true,
            'archived_at' => now(),
            'status' => 'diarsip'
        ]);

        return back()->with('success', 'Surat berhasil diarsipkan');
    }

    public function deleteAll()
    {
        $tuRoles = ['tu', 'ka_tu', 'admin'];
        $user = auth()->user();
        
        // Hanya TU, KA-TU, dan Admin yang dapat hapus semua surat
        if (!in_array($user->role, $tuRoles)) {
            abort(403, 'Hanya TU, KA-TU, dan Admin yang dapat menghapus semua surat');
        }

        // Delete files dari storage
        $surats = SuratKeluar::all();
        foreach ($surats as $surat) {
            if ($surat->file_lampiran) {
                Storage::disk('public')->delete($surat->file_lampiran);
            }
        }

        // Delete semua surat dengan delete() bukan truncate() untuk menghindari foreign key constraint
        SuratKeluar::query()->delete();

        return back()->with('success', 'Semua surat keluar berhasil dihapus');
    }
}