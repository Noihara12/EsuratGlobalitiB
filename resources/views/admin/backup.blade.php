@extends('layouts.app')

@section('title', 'Backup Database')

@section('content')
<style>
    @media (max-width: 767.98px) {
        .main-content { padding: 15px; }
        .card { margin-bottom: 1rem; }
    }
</style>
<div class="mb-4">
    <h2>💾 Backup Database</h2>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">Buat Backup</h5>
            </div>
            <div class="card-body">
                <p>Klik tombol di bawah untuk membuat backup database saat ini. File akan tersimpan dan bisa didownload dari daftar backup.</p>
                <form action="{{ route('admin.backup.database') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success btn-lg">
                        💾 Buat Backup Database
                    </button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">Daftar Backup</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Klik "Lihat Backup" untuk melihat daftar lengkap backup yang telah dibuat.</p>
                <a href="{{ route('admin.backup.list') }}" class="btn btn-primary">📋 Lihat Daftar Backup</a>
            </div>
        </div>
    </div>
</div>
@endsection
