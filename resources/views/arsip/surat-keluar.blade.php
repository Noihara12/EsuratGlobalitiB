@extends('layouts.app')

@section('title', 'Arsip Surat Keluar')

@section('content')
<style>
    @media (max-width: 767.98px) {
        .header-title { margin-bottom: 1.5rem; }
        .filter-form .row { row-gap: 0.75rem; }
        .filter-form .col-md-3 { min-width: 100%; max-width: 100%; }
        .filter-form .form-label { font-size: 0.9rem; margin-bottom: 0.4rem; }
        .filter-form .form-control, .filter-form .form-select { font-size: 0.95rem; }
        .filter-buttons { display: flex; gap: 0.5rem; }
        .filter-buttons .btn { flex: 1; }
    }
</style>
<div class="header-title">
    <h2>📦 Arsip Surat Keluar</h2>
</div>

<!-- Filter Card -->
<div class="card shadow-sm border-0 mb-3">
    <div class="card-header bg-light border-0">
        <h6 class="mb-0"><i class="bi bi-funnel"></i> Filter & Pencarian</h6>
    </div>
    <div class="card-body pb-2">
        <form method="GET" class="filter-form row g-3">
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
                    <option value="rahasia" {{ request('jenis_surat') === 'rahasia' ? 'selected' : '' }}>🔴 Rahasia</option>
                    <option value="penting" {{ request('jenis_surat') === 'penting' ? 'selected' : '' }}>🟠 Penting</option>
                    <option value="biasa" {{ request('jenis_surat') === 'biasa' ? 'selected' : '' }}>⚪ Biasa</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" placeholder="No surat, perihal, tujuan..." value="{{ request('search') }}">
            </div>
            <div class="col-md-12">
                <div class="filter-buttons">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-search"></i> Filter
                    </button>
                    <a href="{{ route('arsip.surat-keluar') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Data Table -->
<div class="card shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%">No</th>
                    <th>Nomor Surat</th>
                    <th>Jenis</th>
                    <th>Tujuan</th>
                    <th>Tanggal</th>
                    <th>Perihal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($suratKeluar as $surat)
                    <tr>
                        <td><strong>{{ (($suratKeluar->currentPage() - 1) * $suratKeluar->perPage()) + $loop->iteration }}</strong></td>
                        <td>
                            <strong>{{ $surat->nomor_surat }}</strong>
                        </td>
                        <td>
                            @if ($surat->jenis_surat === 'rahasia')
                                <span class="badge bg-danger">🔴 Rahasia</span>
                            @elseif ($surat->jenis_surat === 'penting')
                                <span class="badge bg-warning">🟠 Penting</span>
                            @else
                                <span class="badge bg-secondary">⚪ Biasa</span>
                            @endif
                        </td>
                        <td>{{ $surat->tujuan }}</td>
                        <td>{{ $surat->created_at->format('d/m/Y') }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($surat->perihal, 50) }}</td>
                        <td>
                            <a href="{{ route('surat-keluar.show', $surat) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i> Lihat
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="bi bi-send"></i> Tidak ada data
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
    {{ $suratKeluar->links() }}
</div>
@endsection
