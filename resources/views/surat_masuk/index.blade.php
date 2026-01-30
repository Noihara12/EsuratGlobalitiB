@extends('layouts.app')

@section('title', 'Surat Masuk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>📨 Surat Masuk</h2>
    <div>
        @php
            $deleteAllRoles = ['admin'];
        @endphp
        @if(in_array(auth()->user()->role, $deleteAllRoles))
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteAllModal">🗑️ Hapus Semua</button>
        @endif
        @php
            $tuRoles = ['tu', 'ka_tu'];
        @endphp
        @if(in_array(auth()->user()->role, $tuRoles))
            <a href="{{ route('surat-masuk.create') }}" class="btn btn-primary">+ Buat Surat Masuk</a>
        @endif
    </div>
</div>

<!-- Status Filter -->
@php
    $filterRoles = ['tu', 'ka_tu', 'admin'];
@endphp
@if(in_array(auth()->user()->role, $filterRoles))
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('surat-masuk.index') }}" class="d-flex gap-2 align-items-center">
            <label for="statusFilter" class="form-label mb-0">Filter by Status:</label>
            <select name="status" id="statusFilter" class="form-select" style="width: auto;" onchange="this.form.submit()">
                <option value="">-- Semua Status --</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>Diajukan</option>
                <option value="disposed" {{ request('status') === 'disposed' ? 'selected' : '' }}>Didisposisikan</option>
                <option value="received" {{ request('status') === 'received' ? 'selected' : '' }}>Diterima</option>
                <option value="diarsip" {{ request('status') === 'diarsip' ? 'selected' : '' }}>Diarsip</option>
            </select>
            <a href="{{ route('surat-masuk.index') }}" class="btn btn-sm btn-secondary">Reset</a>
        </form>
    </div>
</div>
@endif

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%">No</th>
                    <th>Nomor Surat</th>
                    <th>Jenis</th>
                    <th>Asal Surat</th>
                    <th>Tanggal</th>
                    <th>Perihal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suratMasuk as $surat)
                    <tr>
                        <td><strong>{{ (($suratMasuk->currentPage() - 1) * $suratMasuk->perPage()) + $loop->iteration }}</strong></td>
                        <td>{{ $surat->nomor_surat }}</td>
                        <td>
                            <span class="jenis-{{ $surat->jenis_surat }}">
                                @if($surat->jenis_surat === 'rahasia')
                                    🔒 Rahasia
                                @elseif($surat->jenis_surat === 'penting')
                                    ⚠️ Penting
                                @else
                                    📄 Biasa
                                @endif
                            </span>
                        </td>
                        <td>{{ $surat->asal_surat }}</td>
                        <td>{{ $surat->tanggal_surat->format('d/m/Y') }}</td>
                        <td>{{ Str::limit($surat->perihal, 30) }}</td>
                        <td>
                            <span class="badge badge-status status-{{ $surat->status }}">
                                @switch($surat->status)
                                    @case('draft')
                                        Draft
                                        @break
                                    @case('submitted')
                                        Diajukan
                                        @break
                                    @case('disposed')
                                        Didisposisikan
                                        @break
                                    @case('received')
                                        Diterima
                                        @break
                                    @case('diarsip')
                                        Diarsip
                                        @break
                                    @default
                                        {{ ucfirst(str_replace('_', ' ', $surat->status)) }}
                                @endswitch
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('surat-masuk.show', $surat) }}" class="btn btn-sm btn-info">Lihat</a>
                            @php
                                $tuRoles = ['tu', 'ka_tu'];
                            @endphp
                            @if(in_array(auth()->user()->role, $tuRoles) && $surat->status === 'draft')
                                <a href="{{ route('surat-masuk.edit', $surat) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('surat-masuk.destroy', $surat) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus surat ini?')">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">Tidak ada surat</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Semua -->
<div class="modal fade" id="confirmDeleteAllModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">⚠️ Peringatan Hapus Semua Surat</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-danger fw-bold">Anda yakin ingin menghapus SEMUA surat masuk?</p>
                <p>Tindakan ini <strong>TIDAK DAPAT DIBATALKAN</strong> dan semua data surat akan hilang permanen.</p>
                <hr>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="confirmCheckbox" onchange="toggleDeleteButton()">
                    <label class="form-check-label" for="confirmCheckbox">
                        Saya memahami dan setuju untuk menghapus SEMUA surat masuk
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('surat-masuk.delete-all') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" id="deleteAllBtn" class="btn btn-danger" disabled>🗑️ Hapus Semua Sekarang</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function toggleDeleteButton() {
    const checkbox = document.getElementById('confirmCheckbox');
    const deleteBtn = document.getElementById('deleteAllBtn');
    deleteBtn.disabled = !checkbox.checked;
}
</script>

<div class="d-flex justify-content-center mt-4">
    {{ $suratMasuk->links() }}
</div>
@endsection
