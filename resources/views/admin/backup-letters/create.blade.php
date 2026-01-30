@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>
                <i class="bi bi-plus-circle"></i> Buat Backup Data Surat
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

    <div class="card">
        <div class="card-header bg-light">
            <h5 class="mb-0">Konfigurasi Backup</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.backup-letters.store') }}">
                @csrf

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="mb-3">Statistik Data Saat Ini</h6>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Surat Masuk
                                <span class="badge bg-info rounded-pill">{{ $suratMasukCount }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Surat Keluar
                                <span class="badge bg-warning rounded-pill">{{ $suratKeluarCount }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Total Surat
                                <span class="badge bg-primary rounded-pill">{{ $suratMasukCount + $suratKeluarCount }}</span>
                            </li>
                        </ul>
                    </div>

                    <div class="col-md-6">
                        <h6 class="mb-3">Pilih Tipe Backup</h6>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="type" id="type_surat_masuk" value="surat_masuk" required>
                            <label class="form-check-label" for="type_surat_masuk">
                                <strong>Surat Masuk</strong>
                                <small class="d-block text-muted">Backup hanya untuk surat masuk</small>
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="type" id="type_surat_keluar" value="surat_keluar">
                            <label class="form-check-label" for="type_surat_keluar">
                                <strong>Surat Keluar</strong>
                                <small class="d-block text-muted">Backup hanya untuk surat keluar</small>
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="type_all" value="all">
                            <label class="form-check-label" for="type_all">
                                <strong>Semua Surat</strong>
                                <small class="d-block text-muted">Backup untuk surat masuk dan keluar</small>
                            </label>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="mb-3">
                    <label for="notes" class="form-label">Catatan Backup (Opsional)</label>
                    <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Misalnya: Backup sebelum update sistem, Backup backup rutin harian, dsb..." maxlength="500"></textarea>
                    <small class="form-text text-muted">
                        Maksimal 500 karakter
                    </small>
                </div>

                <div class="alert alert-info" role="alert">
                    <h6 class="alert-heading">Informasi Penting</h6>
                    <ul class="mb-0">
                        <li>Backup akan mencakup semua data surat dan lampirannya</li>
                        <li>File backup akan dikompres dalam format ZIP</li>
                        <li>Proses backup dapat memakan waktu beberapa menit untuk data yang besar</li>
                        <li>Pastikan ada cukup ruang storage tersedia</li>
                    </ul>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.backup-letters.index') }}" class="btn btn-secondary btn-action">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg btn-action">
                        <i class="bi bi-check-circle"></i> Mulai Backup
                    </button>
                </div>
            </form>
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

    .btn-primary.btn-action {
        background-color: #4A7BA7;
        border-color: #4A7BA7;
    }

    .btn-primary.btn-action:hover {
        background-color: #3a5f87;
        border-color: #3a5f87;
    }

    .btn-secondary.btn-action {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary.btn-action:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }

    .btn-lg.btn-action {
        padding: 12px 20px;
        font-size: 1rem;
    }
</style>
@endsection
