<?php

namespace App\Http\Controllers;

use App\Models\TandaTangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TandaTanganController extends Controller
{
    /**
     * Display the signature registration index (for kepala_sekolah only)
     */
    public function index()
    {
        // Check if user is kepala_sekolah
        if (auth()->user()->role !== 'kepala_sekolah') {
            abort(403, 'Hanya Kepala Sekolah yang dapat mengelola tanda tangan');
        }

        $tandaTangan = TandaTangan::where('user_id', auth()->id())->first();
        
        return view('tanda-tangan.index', compact('tandaTangan'));
    }

    /**
     * Show the form to create or edit signature
     */
    public function create()
    {
        if (auth()->user()->role !== 'kepala_sekolah') {
            abort(403, 'Hanya Kepala Sekolah yang dapat mengelola tanda tangan');
        }

        $tandaTangan = TandaTangan::where('user_id', auth()->id())->first();

        return view('tanda-tangan.create', compact('tandaTangan'));
    }

    /**
     * Store or update the signature
     */
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'kepala_sekolah') {
            abort(403);
        }

        $validated = $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'description' => 'nullable|string|max:500',
        ]);

        // Get or create signature record
        $tandaTangan = TandaTangan::where('user_id', auth()->id())->first();

        if ($tandaTangan && $tandaTangan->file_path) {
            // Delete old file
            Storage::disk('public')->delete($tandaTangan->file_path);
        }

        if (!$tandaTangan) {
            $tandaTangan = new TandaTangan();
            $tandaTangan->user_id = auth()->id();
        }

        // Upload new file
        $file = $request->file('file');
        $fileName = auth()->id() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('tanda_tangan', $fileName, 'public');

        // Update or create record
        $tandaTangan->file_path = $filePath;
        $tandaTangan->original_filename = $file->getClientOriginalName();
        $tandaTangan->file_type = strtolower($file->getClientOriginalExtension());
        $tandaTangan->file_size = $file->getSize();
        $tandaTangan->description = $validated['description'] ?? null;
        $tandaTangan->save();

        return redirect()->route('tanda-tangan.index')
            ->with('success', 'Tanda tangan berhasil disimpan');
    }

    /**
     * Show the signature details
     */
    public function show(TandaTangan $tandaTangan)
    {
        // Only allow owner or admin to view
        if (auth()->user()->id !== $tandaTangan->user_id && auth()->user()->role !== 'admin') {
            abort(403);
        }

        return view('tanda-tangan.show', compact('tandaTangan'));
    }

    /**
     * Delete the signature
     */
    public function destroy(TandaTangan $tandaTangan)
    {
        if (auth()->user()->role !== 'kepala_sekolah' || auth()->user()->id !== $tandaTangan->user_id) {
            abort(403);
        }

        // Delete file from storage
        if ($tandaTangan->file_path) {
            Storage::disk('public')->delete($tandaTangan->file_path);
        }

        $tandaTangan->delete();

        return redirect()->route('tanda-tangan.index')
            ->with('success', 'Tanda tangan berhasil dihapus');
    }
}
