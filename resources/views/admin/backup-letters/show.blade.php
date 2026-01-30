@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>
                <i class="bi bi-file-zip"></i> Detail Backup
            </h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.backup-letters.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Informasi Backup</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th style="width: 30%;">Nama File</th>
                                <td>{{ $backupLetters->backup_name }}</td>
                            </tr>
                            <tr>
                                <th>Tipe Backup</th>
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
                                <td>{{ $backupLetters->total_letters }} item</td>
                            </tr>
                            <tr>
                                <th>Jumlah Lampiran</th>
                                <td>{{ $backupLetters->total_attachments }} file</td>
                            </tr>
                            <tr>
                                <th>Ukuran File</th>
                                <td>{{ $backupLetters->formatted_size }}</td>
                            </tr>
                            <tr>
                                <th>Dibuat Oleh</th>
                                <td>{{ $backupLetters->creator->name ?? 'Unknown' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Dibuat</th>
                                <td>{{ $backupLetters->created_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                            <tr>
                                <th>Catatan</th>
                                <td>
                                    @if ($backupLetters->notes)
                                        <p class="mb-0">{{ $backupLetters->notes }}</p>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($metadata)
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Metadata Backup</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless table-sm">
                            <tbody>
                                <tr>
                                    <th style="width: 30%;">Tanggal Backup</th>
                                    <td>{{ $metadata['backup_date'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Dibuat Oleh</th>
                                    <td>{{ $metadata['backup_by'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Catatan</th>
                                    <td>
                                        @if (!empty($metadata['notes']))
                                            {{ $metadata['notes'] }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Aksi</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2 mb-2">
                        <a href="{{ route('admin.backup-letters.download', $backupLetters) }}" class="btn btn-success btn-action">
                            <i class="bi bi-download"></i> Download Backup
                        </a>
                    </div>

                    <div class="d-grid gap-2 mb-2">
                        <a href="{{ route('admin.backup-letters.restore', $backupLetters) }}" class="btn btn-warning btn-action">
                            <i class="bi bi-arrow-counterclockwise"></i> Restore Data
                        </a>
                    </div>

                    <div class="d-grid gap-2">
                        <form action="{{ route('admin.backup-letters.delete', $backupLetters) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus backup ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-action w-100">
                                <i class="bi bi-trash"></i> Hapus Backup
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Statistik</h5>
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
                        <small class="text-muted d-block">Ukuran File</small>
                        <h4 class="mb-0">{{ $backupLetters->formatted_size }}</h4>
                    </div>
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

    .btn-success.btn-action {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-success.btn-action:hover {
        background-color: #218838;
        border-color: #218838;
    }

    .btn-warning.btn-action {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #212529;
    }

    .btn-warning.btn-action:hover {
        background-color: #e0a800;
        border-color: #d39e00;
        color: #212529;
    }

    .btn-danger.btn-action {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-danger.btn-action:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }
</style>
@endsection
