@extends('layouts.app')

@section('title', 'Detail Surat Keluar')

@section('content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <h2>📤 Detail Surat Keluar</h2>
        <a href="{{ url()->previous() ?: route('surat-keluar.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-light">
        <h5 class="mb-0">Informasi Surat</h5>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="fw-bold">Nomor Surat:</label>
                <p>{{ $suratKeluar->nomor_surat }}</p>
            </div>
            <div class="col-md-6">
                <label class="fw-bold">Tanggal Surat:</label>
                <p>{{ $suratKeluar->tanggal_surat->format('d/m/Y') }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="fw-bold">Tujuan Surat:</label>
                <p>{{ $suratKeluar->tujuan }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="fw-bold">Dibuat oleh:</label>
                <p>{{ $suratKeluar->creator->name }} <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $suratKeluar->creator->role)) }}</span></p>
            </div>
            <div class="col-md-6">
                <label class="fw-bold">Status:</label>
                <p>
                    <span class="badge badge-status status-{{ $suratKeluar->status }}">
                        @switch($suratKeluar->status)
                            @case('draft')
                                📝 Draft
                                @break
                            @case('published')
                                ✅ Dipublikasikan
                                @break
                            @default
                                {{ ucfirst($suratKeluar->status) }}
                        @endswitch
                    </span>
                </p>
            </div>
        </div>

        <div class="mb-3">
            <label class="fw-bold">Perihal:</label>
            <p>{{ $suratKeluar->perihal }}</p>
        </div>

        <div class="mb-3">
            <label class="fw-bold">Isi Surat:</label>
            <p style="white-space: pre-wrap;">{{ $suratKeluar->isi_surat }}</p>
        </div>

        @if($suratKeluar->file_lampiran)
            <div class="mb-3">
                <label class="fw-bold">File Lampiran:</label>
                <p>
                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#previewModal">
                        👁️ Preview
                    </button>
                    <a href="{{ Storage::url($suratKeluar->file_lampiran) }}" download class="btn btn-sm btn-success">
                        📥 Download
                    </a>
                </p>
            </div>
        @else
            <div class="mb-3">
                <label class="fw-bold">File Lampiran:</label>
                <p class="text-muted">Tidak ada lampiran</p>
            </div>
        @endif

        <div class="mb-3">
            <label class="fw-bold">Status:</label>
            <p>
                <span class="badge badge-status status-{{ $suratKeluar->status }}">
                    @switch($suratKeluar->status)
                        @case('draft')
                            📝 Draft
                            @break
                        @case('published')
                            ✅ Dipublikasikan
                            @break
                        @default
                            {{ ucfirst($suratKeluar->status) }}
                    @endswitch
                </span>
            </p>
        </div>

        <div class="mb-3">
            <label class="fw-bold">Dibuat oleh:</label>
            <p>{{ $suratKeluar->creator->name }} ({{ ucfirst(str_replace('_', ' ', $suratKeluar->creator->role)) }})</p>
        </div>

        <div class="mb-3">
            <label class="fw-bold">Tanggal Dibuat:</label>
            <p>{{ $suratKeluar->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>
</div>

@php
    $tuRoles = ['tu', 'ka_tu'];
@endphp
@if(in_array(auth()->user()->role, $tuRoles) || auth()->id() === $suratKeluar->created_by)
    @if($suratKeluar->status === 'draft')
        <div class="d-flex gap-2 mb-3">
            <a href="{{ route('surat-keluar.edit', $suratKeluar) }}" class="btn btn-warning">✏️ Edit</a>
            <form action="{{ route('surat-keluar.destroy', $suratKeluar) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus surat ini?')">🗑️ Hapus</button>
            </form>
            @if(in_array(auth()->user()->role, $tuRoles))
                <form action="{{ route('surat-keluar.publish', $suratKeluar) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-success">📤 Publikasikan</button>
                </form>
            @endif
            @if($suratKeluar->status !== 'diarsip')
                <form action="{{ route('surat-keluar.archive', $suratKeluar) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-secondary" onclick="return confirm('Arsipkan surat ini? Surat tidak akan bisa diedit setelah diarsipkan.')">📦 Arsipkan</button>
                </form>
            @endif
        </div>
    @elseif(in_array(auth()->user()->role, $tuRoles) && $suratKeluar->status !== 'diarsip')
        <div class="d-flex gap-2 mb-3">
            <form action="{{ route('surat-keluar.archive', $suratKeluar) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-secondary" onclick="return confirm('Arsipkan surat ini? Surat tidak akan bisa diedit setelah diarsipkan.')">📦 Arsipkan</button>
            </form>
        </div>
    @endif
@endif

@if($suratKeluar->file_lampiran)
<!-- Modal Preview File -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-fullscreen-lg-down" style="max-width: 85vw;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview File Lampiran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                @php
                    $fileUrl = Storage::url($suratKeluar->file_lampiran);
                    $extension = strtolower(pathinfo($suratKeluar->file_lampiran, PATHINFO_EXTENSION));
                @endphp
                
                @if(in_array($extension, ['pdf']))
                    <!-- PDF Preview -->
                    <iframe src="{{ $fileUrl }}" width="100%" height="700px" style="border: none;"></iframe>
                @elseif(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp']))
                    <!-- Image Preview -->
                    <div style="text-align: center;">
                        <img src="{{ $fileUrl }}" alt="Preview" style="max-width: 100%; max-height: 700px; object-fit: contain;">
                    </div>
                @elseif(in_array($extension, ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx']))
                    <!-- Office Document -->
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-file-earmark"></i>
                        File dokumen <strong>{{ strtoupper($extension) }}</strong> tidak bisa di-preview langsung.
                        <br><br>
                        Silakan gunakan tombol <strong>Download</strong> untuk membuka file dengan aplikasi yang sesuai.
                    </div>
                @else
                    <!-- Other Files -->
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-file"></i>
                        File dengan tipe <strong>.{{ $extension }}</strong> tidak bisa di-preview.
                        <br><br>
                        Silakan gunakan tombol <strong>Download</strong> untuk membuka file.
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a href="{{ $fileUrl }}" download class="btn btn-success">
                    📥 Download
                </a>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
