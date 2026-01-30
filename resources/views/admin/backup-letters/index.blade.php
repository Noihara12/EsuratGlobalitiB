@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>📦 Backup Data Surat</h2>
    <div>
        <a href="{{ route('admin.backup-letters.create') }}" class="btn btn-primary">+ Buat Backup Baru</a>
    </div>
</div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h5>Error:</h5>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%">No</th>
                                <th>Nama Backup</th>
                                <th>Tipe</th>
                                <th>Jumlah Surat</th>
                                <th>Lampiran</th>
                                <th>Ukuran File</th>
                                <th>Dibuat Oleh</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($backups as $backup)
                                <tr>
                                    <td><strong>{{ (($backups->currentPage() - 1) * $backups->perPage()) + $loop->iteration }}</strong></td>
                                    <td>
                                        <a href="{{ route('admin.backup-letters.show', $backup) }}" class="text-decoration-none">
                                            <i class="bi bi-file-zip"></i> {{ $backup->backup_name }}
                                        </a>
                                    </td>
                                    <td>
                                        @if ($backup->type === 'surat_masuk')
                                            <span class="badge bg-info">Surat Masuk</span>
                                        @elseif ($backup->type === 'surat_keluar')
                                            <span class="badge bg-warning">Surat Keluar</span>
                                        @else
                                            <span class="badge bg-primary">Semua Surat</span>
                                        @endif
                                    </td>
                                    <td>{{ $backup->total_letters }}</td>
                                    <td>
                                        <small class="text-muted">{{ $backup->total_attachments }} file</small>
                                    </td>
                                    <td>{{ $backup->formatted_size }}</td>
                                    <td>{{ $backup->creator->name ?? 'Unknown' }}</td>
                                    <td>{{ $backup->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.backup-letters.show', $backup) }}" class="btn btn-sm btn-info">Lihat</a>
                                        <a href="{{ route('admin.backup-letters.download', $backup) }}" class="btn btn-sm btn-success">Download</a>
                                        <a href="{{ route('admin.backup-letters.restore', $backup) }}" class="btn btn-sm btn-warning">Restore</a>
                                        <form action="{{ route('admin.backup-letters.delete', $backup) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus backup ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">Belum ada backup. Klik tombol "Buat Backup Baru" untuk memulai.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $backups->links('pagination::bootstrap-4') }}
                </div>
        </div>
    </div>
@endsection
