@extends('layouts.app')

@section('title', 'Laporan Surat Masuk')

@section('content')
<style>
    @media (max-width: 767.98px) {
        .header-wrapper { display: block; margin-bottom: 1.5rem; }
        .header-wrapper h2 { margin-bottom: 0.75rem; }
        .header-buttons { display: flex; gap: 0.5rem; margin-bottom: 1rem; }
        .header-buttons .btn { flex: 1; }
        .filter-form .row { row-gap: 0.75rem; }
        .filter-form .col-md-3 { min-width: 100%; max-width: 100%; }
        .filter-form .form-label { font-size: 0.9rem; margin-bottom: 0.4rem; }
        .filter-form .form-control, .filter-form .form-select { font-size: 0.95rem; }
        .filter-buttons { display: flex; gap: 0.5rem; }
        .filter-buttons .btn { flex: 1; }
        .summary-row .col-md-3 { min-width: 100%; max-width: 100%; margin-bottom: 1rem; }
    }
    @media (min-width: 768px) {
        .header-wrapper { display: flex; justify-content: space-between; align-items: center; }
    }
</style>
<div class="header-wrapper">
    <h2>📊 Laporan Surat Masuk</h2>
    <div class="header-buttons">
        <a href="{{ route('laporan.surat-masuk.export-pdf', request()->query()) }}" 
           class="btn btn-danger btn-sm"
           target="_blank">
            <i class="bi bi-file-pdf"></i> Download PDF
        </a>
    </div>
</div>

<!-- Filter Card -->
<div class="card shadow-sm border-0 mb-3">
    <div class="card-header bg-light border-0">
        <h6 class="mb-0"><i class="bi bi-funnel"></i> Filter & Pencarian</h6>
    </div>
    <div class="card-body pb-2">
        <form method="GET" action="{{ route('laporan.surat-masuk') }}" class="filter-form row g-3">
            <div class="col-md-3">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" name="dari_tanggal" class="form-control" value="{{ request('dari_tanggal') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" name="sampai_tanggal" class="form-control" value="{{ request('sampai_tanggal') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Jenis Surat</label>
                <select name="jenis_surat" class="form-select">
                    <option value="">-- Semua --</option>
                    <option value="rahasia" {{ request('jenis_surat') === 'rahasia' ? 'selected' : '' }}>🔒 Rahasia</option>
                    <option value="penting" {{ request('jenis_surat') === 'penting' ? 'selected' : '' }}>⚠️ Penting</option>
                    <option value="biasa" {{ request('jenis_surat') === 'biasa' ? 'selected' : '' }}>📄 Biasa</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" placeholder="No surat, perihal, asal..." value="{{ request('search') }}">
            </div>
            <div class="col-md-12">
                <div class="filter-buttons">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-search"></i> Filter
                    </button>
                    <a href="{{ route('laporan.surat-masuk') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Summary -->
<div class="summary-row row mb-3">
</div>

<!-- Data Table -->
<div class="card shadow-sm border-0">
    <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center">
        <h6 class="mb-0"><i class="bi bi-list"></i> Data Surat Masuk</h6>
        <span class="badge bg-primary" style="font-size: 0.9rem; padding: 0.5rem 0.75rem;">Total: <strong>{{ $totalSurat }}</strong></span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%">No</th>
                    <th>Nomor Surat</th>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Asal Surat</th>
                    <th>Perihal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($suratMasuk as $surat)
                    <tr>
                        <td>{{ $suratMasuk->firstItem() + $loop->index }}</td>
                        <td><strong>{{ $surat->nomor_surat }}</strong></td>
                        <td>{{ $surat->created_at->format('d-m-Y') }}</td>
                        <td>
                            @if($surat->jenis_surat === 'rahasia')
                                <span class="badge bg-danger">Rahasia</span>
                            @elseif($surat->jenis_surat === 'penting')
                                <span class="badge bg-warning">Penting</span>
                            @else
                                <span class="badge bg-secondary">Biasa</span>
                            @endif
                        </td>
                        <td>{{ $surat->asal_surat }}</td>
                        <td>{{ substr($surat->perihal, 0, 60) }}...</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-light">
        {{ $suratMasuk->links() }}
    </div>
</div>
@endsection
