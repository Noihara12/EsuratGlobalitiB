@extends('layouts.app')

@section('title', 'Manajemen Tanda Tangan')

@section('content')
<div class="mb-4">
    <h2>🖊️ Manajemen Tanda Tangan Digital</h2>
    <p class="text-muted">Daftarkan tanda tangan digital Anda untuk disposisi surat</p>
</div>

<div class="row">
    <div class="col-md-8">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">Tanda Tangan Terdaftar</h5>
            </div>
            <div class="card-body">
                @if($tandaTangan)
                    <div class="alert alert-success mb-4">
                        ✓ Anda sudah mendaftarkan tanda tangan digital
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="fw-bold">Nama File:</label>
                            <p>{{ $tandaTangan->original_filename }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold">Jenis File:</label>
                            <p>
                                @if($tandaTangan->file_type === 'pdf')
                                    <span class="badge bg-danger">PDF</span>
                                @else
                                    <span class="badge bg-primary">{{ strtoupper($tandaTangan->file_type) }}</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="fw-bold">Ukuran File:</label>
                            <p>{{ number_format($tandaTangan->file_size / 1024, 2) }} KB</p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold">Tanggal Upload:</label>
                            <p>{{ $tandaTangan->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    @if($tandaTangan->description)
                        <div class="mb-4">
                            <label class="fw-bold">Keterangan:</label>
                            <p>{{ $tandaTangan->description }}</p>
                        </div>
                    @endif

                    <div class="mb-4">
                        <label class="fw-bold">Preview Tanda Tangan:</label>
                        <div class="border rounded p-3 bg-light" style="max-height: 300px; overflow-y: auto;">
                            @if($tandaTangan->file_type === 'pdf')
                                <div class="alert alert-info mb-0">
                                    📄 File PDF - Download untuk melihat preview lengkap
                                </div>
                            @else
                                <img src="{{ Storage::url($tandaTangan->file_path) }}" alt="Tanda Tangan" class="img-fluid" style="max-width: 100%; max-height: 150px;">
                            @endif
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ Storage::url($tandaTangan->file_path) }}" class="btn btn-primary" download>
                            📥 Download File
                        </a>
                        <a href="{{ route('tanda-tangan.create') }}" class="btn btn-warning">
                            ✏️ Perbarui Tanda Tangan
                        </a>
                        <form action="{{ route('tanda-tangan.destroy', $tandaTangan) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus tanda tangan ini?')">
                                🗑️ Hapus
                            </button>
                        </form>
                    </div>
                @else
                    <div class="alert alert-warning mb-4">
                        ⚠️ Anda belum mendaftarkan tanda tangan digital. Silakan daftarkan terlebih dahulu untuk dapat membuat disposisi.
                    </div>

                    <a href="{{ route('tanda-tangan.create') }}" class="btn btn-primary btn-lg">
                        ➕ Daftarkan Tanda Tangan
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">ℹ️ Informasi</h5>
            </div>
            <div class="card-body">
                <p><strong>Format File Didukung:</strong></p>
                <ul class="mb-3">
                    <li>JPG / JPEG</li>
                    <li>PNG</li>
                    <li>PDF</li>
                </ul>

                <p><strong>Ukuran Maksimal:</strong> 5 MB</p>

                <p><strong>Catatan:</strong></p>
                <ul>
                    <li>Tanda tangan akan digunakan secara otomatis pada semua disposisi yang Anda buat</li>
                    <li>Hanya satu tanda tangan yang dapat didaftarkan per pengguna</li>
                    <li>Anda dapat memperbarui tanda tangan kapan saja</li>
                </ul>

                <hr>

                <p><strong>Cara Membuat Tanda Tangan Digital:</strong></p>
                <ol style="font-size: 0.9rem;">
                    <li>Scan tanda tangan Anda</li>
                    <li>Potong dan rapikan gambarnya</li>
                    <li>Simpan sebagai JPG, PNG, atau PDF</li>
                    <li>Upload di sini</li>
                </ol>
            </div>
        </div>
    </div>
</div>

@endsection
