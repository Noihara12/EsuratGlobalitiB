<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;

class ArsipController extends Controller
{
    /**
     * Arsip Surat Masuk
     */
    public function suratMasuk(Request $request)
    {
        $user = auth()->user();
        $tuRoles = ['tu', 'ka_tu'];
        
        $query = SuratMasuk::where('is_archived', true);
        
        // TU & KA-TU dapat melihat semua surat masuk (baik yang dibuat maupun yang diterima melalui disposisi)
        if (!in_array($user->role, $tuRoles)) {
            // User biasa hanya lihat surat yang dikirim melalui disposisi
            $query->whereHas('disposisi', function ($q) use ($user) {
                $q->where('disposisi_ke', $user->id);
            });
        }
        
        // Filter berdasarkan tanggal
        if ($request->dari_tanggal && $request->sampai_tanggal) {
            $query->whereBetween('created_at', [
                $request->dari_tanggal,
                $request->sampai_tanggal . ' 23:59:59'
            ]);
        }
        
        // Filter berdasarkan jenis surat
        if ($request->jenis_surat) {
            $query->where('jenis_surat', $request->jenis_surat);
        }
        
        // Search
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%")
                  ->orWhere('asal_surat', 'like', "%{$search}%");
            });
        }
        
        $suratMasuk = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('arsip.surat-masuk', compact('suratMasuk'));
    }

    /**
     * Arsip Surat Keluar
     */
    public function suratKeluar(Request $request)
    {
        $user = auth()->user();
        $tuRoles = ['tu', 'ka_tu'];
        
        $query = SuratKeluar::where('is_archived', true);
        
        // TU & KA-TU dapat melihat semua surat keluar
        if (!in_array($user->role, $tuRoles)) {
            // User biasa hanya lihat surat yang dibuat sendiri
            $query->where('creator_id', $user->id);
        }
        
        // Filter berdasarkan tanggal
        if ($request->dari_tanggal && $request->sampai_tanggal) {
            $query->whereBetween('created_at', [
                $request->dari_tanggal,
                $request->sampai_tanggal . ' 23:59:59'
            ]);
        }
        
        // Filter berdasarkan jenis surat
        if ($request->jenis_surat) {
            $query->where('jenis_surat', $request->jenis_surat);
        }
        
        // Search
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%")
                  ->orWhere('tujuan', 'like', "%{$search}%");
            });
        }
        
        $suratKeluar = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('arsip.surat-keluar', compact('suratKeluar'));
    }
}
