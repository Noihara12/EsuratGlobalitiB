<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratMasukController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $tuRoles = ['tu', 'ka_tu'];
        $statusFilter = $request->query('status');
        
        // Admin dapat melihat semua surat masuk
        if ($user->role === 'admin') {
            $query = SuratMasuk::where('is_archived', false);
            
            // Apply status filter if provided
            if ($statusFilter) {
                $query->where('status', $statusFilter);
            }
            
            $suratMasuk = $query->orderBy('created_at', 'desc')
                ->paginate(10);
            return view('surat_masuk.index', compact('suratMasuk'));
        }
        
        if (in_array($user->role, $tuRoles)) {
            // Check if filter parameter is 'diterima' for TU & KA-TU
            if ($request->query('filter') === 'diterima') {
                // TU & KA-TU dapat melihat disposisi mereka (sama seperti user biasa)
                $query = SuratMasuk::where('is_archived', false)
                    ->whereHas('disposisi', function ($query) use ($user) {
                        $query->where('disposisi_ke', $user->id);
                    });
            } else {
                // TU & KA-TU dapat melihat semua surat masuk yang dibuat oleh TU atau KA-TU manapun
                $query = SuratMasuk::where('is_archived', false)
                    ->whereHas('creator', function ($query) use ($tuRoles) {
                        $query->whereIn('role', $tuRoles);
                    });
            }
            
            // Apply status filter if provided
            if ($statusFilter) {
                $query->where('status', $statusFilter);
            }
            
            $suratMasuk = $query->orderBy('created_at', 'desc')
                ->paginate(10);
        } elseif ($user->role === 'kepala_sekolah') {
            // Kepala sekolah melihat surat masuk yang perlu disposisi
            $suratMasuk = SuratMasuk::where('is_archived', false)
                ->where('status', 'submitted')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            // User biasa & Wakasek & Kaprog & Guru & Pembina Ekstra & BKK melihat disposisi mereka
            $suratMasuk = SuratMasuk::where('is_archived', false)
                ->whereHas('disposisi', function ($query) use ($user) {
                    $query->where('disposisi_ke', $user->id);
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return view('surat_masuk.index', compact('suratMasuk'));
    }

    public function create()
    {
        $tuRoles = ['tu', 'ka_tu'];
        if (!in_array(auth()->user()->role, $tuRoles)) {
            abort(403, 'Hanya TU dan KA-TU yang dapat membuat surat masuk');
        }
        
        return view('surat_masuk.create');
    }

    public function store(Request $request)
    {
        $tuRoles = ['tu', 'ka_tu'];
        if (!in_array(auth()->user()->role, $tuRoles)) {
            abort(403, 'Hanya TU dan KA-TU yang dapat membuat surat masuk');
        }

        $validated = $request->validate([
            'jenis_surat' => 'required|in:rahasia,penting,biasa',
            'kode_surat' => 'required|string',
            'nomor_surat' => 'required|string|unique:surat_masuk',
            'tanggal_surat' => 'required|date',
            'asal_surat' => 'required|string',
            'perihal' => 'required|string',
            'catatan' => 'nullable|string',
            'file_lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $filePath = null;
        if ($request->hasFile('file_lampiran')) {
            $file = $request->file('file_lampiran');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('surat_masuk', $fileName, 'public');
        }

        SuratMasuk::create([
            'jenis_surat' => $validated['jenis_surat'],
            'kode_surat' => $validated['kode_surat'],
            'nomor_surat' => $validated['nomor_surat'],
            'tanggal_surat' => $validated['tanggal_surat'],
            'asal_surat' => $validated['asal_surat'],
            'perihal' => $validated['perihal'],
            'catatan' => $validated['catatan'],
            'file_lampiran' => $filePath,
            'status' => 'draft',
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('surat-masuk.index')->with('success', 'Surat masuk berhasil dibuat');
    }

    public function show(SuratMasuk $suratMasuk)
    {
        $user = auth()->user();
        $tuRoles = ['tu', 'ka_tu'];
        
        // Admin dapat melihat semua surat masuk
        if ($user->role === 'admin') {
            return view('surat_masuk.show', compact('suratMasuk'));
        }
        
        // Check if user can view this surat
        // TU & KA-TU bisa akses surat apapun yang dibuat oleh TU atau KA-TU
        if (in_array($user->role, $tuRoles)) {
            // Check if creator is TU or KA-TU
            if (!in_array($suratMasuk->creator->role, $tuRoles)) {
                abort(403, 'Anda tidak memiliki akses ke surat ini');
            }
        }
        
        return view('surat_masuk.show', compact('suratMasuk'));
    }

    public function submit(SuratMasuk $suratMasuk)
    {
        $tuRoles = ['tu', 'ka_tu'];
        $user = auth()->user();
        
        // TU & KA-TU dapat submit surat yang dibuat oleh TU atau KA-TU manapun
        if (!in_array($user->role, $tuRoles) || !in_array($suratMasuk->creator->role, $tuRoles)) {
            abort(403);
        }

        if ($suratMasuk->status !== 'draft') {
            return back()->with('error', 'Surat tidak bisa diajukan');
        }

        $suratMasuk->update(['status' => 'submitted']);

        return redirect()->route('surat-masuk.show', $suratMasuk)->with('success', 'Surat berhasil diajukan ke Kepala Sekolah');
    }

    public function edit(SuratMasuk $suratMasuk)
    {
        $tuRoles = ['tu', 'ka_tu'];
        $user = auth()->user();
        
        // TU & KA-TU dapat edit surat yang dibuat oleh TU atau KA-TU manapun (status draft)
        if (!in_array($user->role, $tuRoles) || !in_array($suratMasuk->creator->role, $tuRoles) || $suratMasuk->status !== 'draft') {
            abort(403);
        }

        return view('surat_masuk.edit', compact('suratMasuk'));
    }

    public function update(Request $request, SuratMasuk $suratMasuk)
    {
        $tuRoles = ['tu', 'ka_tu'];
        $user = auth()->user();
        
        // TU & KA-TU dapat update surat yang dibuat oleh TU atau KA-TU manapun (status draft)
        if (!in_array($user->role, $tuRoles) || !in_array($suratMasuk->creator->role, $tuRoles) || $suratMasuk->status !== 'draft') {
            abort(403);
        }

        $validated = $request->validate([
            'jenis_surat' => 'required|in:rahasia,penting,biasa',
            'kode_surat' => 'required|string',
            'nomor_surat' => 'required|string|unique:surat_masuk,nomor_surat,' . $suratMasuk->id,
            'tanggal_surat' => 'required|date',
            'asal_surat' => 'required|string',
            'perihal' => 'required|string',
            'catatan' => 'nullable|string',
            'file_lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('file_lampiran')) {
            if ($suratMasuk->file_lampiran) {
                Storage::disk('public')->delete($suratMasuk->file_lampiran);
            }
            $file = $request->file('file_lampiran');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $validated['file_lampiran'] = $file->storeAs('surat_masuk', $fileName, 'public');
        }

        $suratMasuk->update($validated);

        return redirect()->route('surat-masuk.show', $suratMasuk)->with('success', 'Surat berhasil diperbarui');
    }

    public function destroy(SuratMasuk $suratMasuk)
    {
        $tuRoles = ['tu', 'ka_tu'];
        $user = auth()->user();
        // TU & KA-TU dapat menghapus surat berstatus 'draft'
        if (!in_array($user->role, $tuRoles) || $suratMasuk->status !== 'draft') {
            abort(403);
        }

        if ($suratMasuk->file_lampiran) {
            Storage::disk('public')->delete($suratMasuk->file_lampiran);
        }

        $suratMasuk->delete();

        return redirect()->route('surat-masuk.index')->with('success', 'Surat berhasil dihapus');
    }

    public function archive(SuratMasuk $suratMasuk)
    {
        $tuRoles = ['tu', 'ka_tu'];
        $user = auth()->user();
        
        // Hanya TU & KA-TU yang dapat arsipkan surat
        if (!in_array($user->role, $tuRoles)) {
            abort(403, 'Hanya TU dan KA-TU yang dapat mengarsipkan surat');
        }

        $suratMasuk->update([
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
        $surats = SuratMasuk::all();
        foreach ($surats as $surat) {
            if ($surat->file_lampiran) {
                Storage::disk('public')->delete($surat->file_lampiran);
            }
        }

        // Delete semua surat dengan delete() bukan truncate() untuk menghindari foreign key constraint
        SuratMasuk::query()->delete();

        return back()->with('success', 'Semua surat masuk berhasil dihapus');
    }

    public function downloadLampiranDisposisi(SuratMasuk $suratMasuk)
    {
        $tuRoles = ['tu', 'ka_tu'];
        $user = auth()->user();
        
        // Hanya TU & KA-TU yang dapat download lampiran disposisi
        if (!in_array($user->role, $tuRoles)) {
            abort(403, 'Hanya TU dan KA-TU yang dapat download lampiran disposisi');
        }

        // Get disposisi data
        $disposisi = $suratMasuk->disposisi()->get();

        $pdf = Pdf::loadView('surat_masuk.export.lampiran-disposisi-pdf', [
            'suratMasuk' => $suratMasuk,
            'disposisi' => $disposisi
        ])->setPaper('a4')->setOption('margin-top', 5)->setOption('margin-bottom', 5);

        // Sanitize filename by removing "/" and "\" characters
        $sanitizedNomor = str_replace(['/', '\\'], '-', $suratMasuk->nomor_surat);
        
        return $pdf->download('Lampiran-Disposisi-' . $sanitizedNomor . '.pdf');
    }
}