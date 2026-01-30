@extends('layouts.app')

@section('title', 'Daftar Backup')

@section('content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <h2>💾 Daftar Backup</h2>
        <a href="{{ route('admin.backup') }}" class="btn btn-primary">+ Buat Backup</a>
    </div>
</div>

<div class="card">
    @if(count($backups) > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%">No</th>
                        <th>Nama File</th>
                        <th>Ukuran</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($backups as $backup)
                        <tr>
                            <td><strong>{{ $loop->iteration }}</strong></td>
                            <td>{{ $backup['name'] }}</td>
                            <td>
                                @php
                                    $size = $backup['size'];
                                    if ($size >= 1073741824) {
                                        $display = number_format($size / 1073741824, 2) . ' GB';
                                    } elseif ($size >= 1048576) {
                                        $display = number_format($size / 1048576, 2) . ' MB';
                                    } elseif ($size >= 1024) {
                                        $display = number_format($size / 1024, 2) . ' KB';
                                    } else {
                                        $display = $size . ' B';
                                    }
                                @endphp
                                {{ $display }}
                            </td>
                            <td>
                                @php
                                    // Convert UTC to WITA (UTC+8)
                                    $witaTime = \DateTime::createFromFormat('U', $backup['date'], new DateTimeZone('UTC'));
                                    $witaTime->setTimezone(new DateTimeZone('Asia/Makassar')); // WITA timezone
                                    echo $witaTime->format('d/m/Y H:i:s');
                                @endphp
                            </td>
                            <td>
                                <a href="{{ route('admin.backup.download', $backup['name']) }}" class="btn btn-sm btn-info">
                                    ⬇️ Download
                                </a>
                                <form action="{{ route('admin.backup.restore', $backup['name']) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Restore backup ini? Database saat ini akan ditimpa.')">
                                        ⬆️ Restore
                                    </button>
                                </form>
                                <form action="{{ route('admin.backup.delete', $backup['name']) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus backup ini?')">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="card-body text-center py-5">
            <p class="text-muted">Belum ada backup yang dibuat</p>
            <a href="{{ route('admin.backup') }}" class="btn btn-primary">Buat Backup Sekarang</a>
        </div>
    @endif
</div>
@endsection
