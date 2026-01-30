<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    /**
     * Laporan Surat Masuk
     */
    public function suratMasuk(Request $request): View
    {
        $user = auth()->user();
        $tuRoles = ['tu', 'ka_tu'];
        
        $dari = $request->dari_tanggal ? Carbon::parse($request->dari_tanggal) : Carbon::now()->startOfYear();
        $sampai = $request->sampai_tanggal ? Carbon::parse($request->sampai_tanggal) : Carbon::now()->endOfYear();
        
        $query = SuratMasuk::whereBetween('created_at', [$dari, $sampai->endOfDay()]);
        
        // TU & KA-TU dapat melihat semua surat masuk
        if (!in_array($user->role, $tuRoles)) {
            // User biasa hanya lihat surat yang dikirim melalui disposisi
            $query->whereHas('disposisi', function ($q) use ($user) {
                $q->where('disposisi_ke', $user->id);
            });
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
        $totalSurat = $suratMasuk->total();
        
        return view('laporan.surat-masuk', compact('suratMasuk', 'dari', 'sampai', 'totalSurat'));
    }

    /**
     * Laporan Surat Keluar
     */
    public function suratKeluar(Request $request): View
    {
        $user = auth()->user();
        $tuRoles = ['tu', 'ka_tu'];
        
        $dari = $request->dari_tanggal ? Carbon::parse($request->dari_tanggal) : Carbon::now()->startOfYear();
        $sampai = $request->sampai_tanggal ? Carbon::parse($request->sampai_tanggal) : Carbon::now()->endOfYear();
        
        $query = SuratKeluar::whereBetween('created_at', [$dari, $sampai->endOfDay()]);
        
        if (!in_array($user->role, $tuRoles)) {
            $query->where('creator_id', $user->id);
        }
        
        if ($request->jenis_surat) {
            $query->where('jenis_surat', $request->jenis_surat);
        }
        
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%")
                  ->orWhere('tujuan', 'like', "%{$search}%");
            });
        }
        
        $suratKeluar = $query->orderBy('created_at', 'desc')->paginate(10);
        $totalSurat = $suratKeluar->total();
        
        return view('laporan.surat-keluar', compact('suratKeluar', 'dari', 'sampai', 'totalSurat'));
    }

    /**
     * Export PDF Surat Masuk
     */
    public function exportPdfSuratMasuk(Request $request)
    {
        $user = auth()->user();
        $tuRoles = ['tu', 'ka_tu'];
        
        $dari = $request->dari_tanggal ? Carbon::parse($request->dari_tanggal) : Carbon::now()->startOfYear();
        $sampai = $request->sampai_tanggal ? Carbon::parse($request->sampai_tanggal) : Carbon::now()->endOfYear();
        
        $query = SuratMasuk::whereBetween('created_at', [$dari, $sampai->endOfDay()]);
        
        if (!in_array($user->role, $tuRoles)) {
            $query->whereHas('disposisi', function ($q) use ($user) {
                $q->where('disposisi_ke', $user->id);
            });
        }
        
        if ($request->jenis_surat) {
            $query->where('jenis_surat', $request->jenis_surat);
        }
        
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%")
                  ->orWhere('asal_surat', 'like', "%{$search}%");
            });
        }
        
        $suratMasuk = $query->orderBy('created_at', 'desc')->get();
        
        $pdf = Pdf::loadView('laporan.export.surat-masuk-pdf', compact('suratMasuk', 'dari', 'sampai'));
        return $pdf->download('Laporan-Surat-Masuk-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Export PDF Surat Keluar
     */
    public function exportPdfSuratKeluar(Request $request)
    {
        $user = auth()->user();
        $tuRoles = ['tu', 'ka_tu'];
        
        $dari = $request->dari_tanggal ? Carbon::parse($request->dari_tanggal) : Carbon::now()->startOfYear();
        $sampai = $request->sampai_tanggal ? Carbon::parse($request->sampai_tanggal) : Carbon::now()->endOfYear();
        
        $query = SuratKeluar::whereBetween('created_at', [$dari, $sampai->endOfDay()]);
        
        if (!in_array($user->role, $tuRoles)) {
            $query->where('creator_id', $user->id);
        }
        
        if ($request->jenis_surat) {
            $query->where('jenis_surat', $request->jenis_surat);
        }
        
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%")
                  ->orWhere('tujuan', 'like', "%{$search}%");
            });
        }
        
        $suratKeluar = $query->orderBy('created_at', 'desc')->get();
        
        $pdf = Pdf::loadView('laporan.export.surat-keluar-pdf', compact('suratKeluar', 'dari', 'sampai'));
        return $pdf->download('Laporan-Surat-Keluar-' . now()->format('Y-m-d') . '.pdf');
    }
}
