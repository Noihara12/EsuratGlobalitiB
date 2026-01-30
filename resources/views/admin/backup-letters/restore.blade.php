@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>
                <i class="bi bi-arrow-counterclockwise"></i> Restore Data Surat
            </h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.backup-letters.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h5>Terjadi Kesalahan:</h5>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Informasi Backup</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-sm">
                        <tbody>
                            <tr>
                                <th style="width: 30%;">Nama File</th>
                                <td>{{ $backupLetters->backup_name }}</td>
                            </tr>
                            <tr>
                                <th>Tipe</th>
                                <td>
                                    @if ($backupLetters->type === 'surat_masuk')
                                        <span class="badge bg-info">Surat Masuk</span>
                                    @elseif ($backupLetters->type === 'surat_keluar')
                                        <span class="badge bg-warning">Surat Keluar</span>
                                    @else
                                        <span class="badge bg-primary">Semua Surat</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Jumlah Surat</th>
                                <td>{{ $backupLetters->total_letters }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Dibuat</th>
                                <td>{{ $backupLetters->created_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Konfigurasi Restore</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.backup-letters.restore-store', $backupLetters) }}" onsubmit="return confirm('Proses restore akan memulihkan data dari backup. Apakah Anda yakin ingin melanjutkan?');">
                        @csrf

                        <div class="mb-4">
                            <h6 class="mb-3">Pilih Data yang Akan Direstore</h6>

                            @if ($backupLetters->type === 'all' || $backupLetters->type === 'surat_masuk')
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="restore_surat_masuk" id="restore_surat_masuk" value="1" checked>
                                    <label class="form-check-label" for="restore_surat_masuk">
                                        <strong>Restore Surat Masuk</strong>
                                        <small class="d-block text-muted">Akan mengembalikan surat masuk dari backup</small>
                                    </label>
                                </div>
                            @endif

                            @if ($backupLetters->type === 'all' || $backupLetters->type === 'surat_keluar')
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="restore_surat_keluar" id="restore_surat_keluar" value="1" checked>
                                    <label class="form-check-label" for="restore_surat_keluar">
                                        <strong>Restore Surat Keluar</strong>
                                        <small class="d-block text-muted">Akan mengembalikan surat keluar dari backup</small>
                                    </label>
                                </div>
                            @endif
                        </div>

                        <hr>

                        <div class="mb-4">
                            <h6 class="mb-3">Opsi Restore</h6>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="merge_data" id="merge_data" value="1">
                                <label class="form-check-label" for="merge_data">
                                    <strong>Merge Data</strong>
                                    <small class="d-block text-muted">Jika diaktifkan, data duplikat akan diupdate. Jika tidak, data duplikat akan dilewati.</small>
                                </label>
                            </div>
                        </div>

                        <div class="alert alert-warning" role="alert">
                            <h6 class="alert-heading">
                                <i class="bi bi-exclamation-triangle"></i> Peringatan
                            </h6>
                            <ul class="mb-0">
                                <li>Proses restore akan menambahkan atau memperbarui data dari backup</li>
                                <li>Pastikan Anda telah membuat backup data saat ini sebelum melanjutkan</li>
                                <li>Lampirannya akan dikopy otomatis ke folder penyimpanan</li>
                                <li>Proses ini dapat memakan waktu, mohon tunggu hingga selesai</li>
                            </ul>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.backup-letters.index') }}" class="btn btn-secondary btn-action">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-danger btn-lg btn-action">
                                <i class="bi bi-check-circle"></i> Mulai Restore
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Ringkasan</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block">Total Surat</small>
                        <h4 class="mb-0">{{ $backupLetters->total_letters }}</h4>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Lampiran</small>
                        <h4 class="mb-0">{{ $backupLetters->total_attachments }}</h4>
                    </div>
                    <div>
                        <small class="text-muted d-block">Ukuran</small>
                        <h4 class="mb-0">{{ $backupLetters->formatted_size }}</h4>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Informasi Lanjutan</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small">
                        <strong>Tipe Backup:</strong><br>
                        @if ($backupLetters->type === 'surat_masuk')
                            Surat Masuk
                        @elseif ($backupLetters->type === 'surat_keluar')
                            Surat Keluar
                        @else
                            Semua Surat
                        @endif
                    </p>
                    <p class="text-muted small">
                        <strong>Dibuat Oleh:</strong><br>
                        {{ $backupLetters->creator->name ?? 'Unknown' }}
                    </p>
                    <p class="text-muted small">
                        <strong>Tanggal:</strong><br>
                        {{ $backupLetters->created_at->format('d/m/Y H:i:s') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: none;
    }

    /* Action Buttons Styling */
    .btn-action {
        padding: 10px 16px;
        font-weight: 500;
        border-radius: 6px;
        border: 1px solid transparent;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-secondary.btn-action {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary.btn-action:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }

    .btn-danger.btn-action {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-danger.btn-action:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    .btn-lg.btn-action {
        padding: 12px 20px;
        font-size: 1rem;
    }
</style>
@endsection
