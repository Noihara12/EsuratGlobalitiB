@extends('layouts.app')

@section('title', 'Surat Keluar')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2>📤 Surat Keluar</h2>
    </div>
    <div class="d-flex gap-2">
        @php
            $deleteAllRoles = ['admin'];
        @endphp
        @if(in_array(auth()->user()->role, $deleteAllRoles))
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteAllModal">🗑️ Hapus Semua</button>
        @endif
        @php
            $allowedRoles = ['tu', 'ka_tu', 'staff', 'wakasek_kurikulum', 'wakasek_sarana_prasarana', 'wakasek_kesiswaan', 'wakasek_humas', 'kaprog_dkv', 'kaprog_pplg', 'kaprog_tjkt', 'kaprog_bd', 'guru', 'pembina_ekstra', 'bkk'];
        @endphp
        @if(!in_array(auth()->user()->role, ['tu', 'ka_tu', 'kepala_sekolah']))
            <a href="{{ route('surat-keluar.my-letters') }}" class="btn btn-outline-secondary">
                📋 Surat Saya
            </a>
        @endif
        @if(in_array(auth()->user()->role, $allowedRoles))
            <a href="{{ route('surat-keluar.create') }}" class="btn btn-primary">+ Buat Surat Keluar</a>
        @endif
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%">No</th>
                    <th>Nomor Surat</th>
                    <th>Tanggal</th>
                    <th>Tujuan Surat</th>
                    <th>Perihal</th>
                    <th>Dibuat oleh</th>
                    <th>Status</th>
                    <th>Lampiran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suratKeluar as $surat)
                    <tr>
                        <td><strong>{{ (($suratKeluar->currentPage() - 1) * $suratKeluar->perPage()) + $loop->iteration }}</strong></td>
                        <td>{{ $surat->nomor_surat }}</td>
                        <td>{{ $surat->tanggal_surat->format('d/m/Y') }}</td>
                        <td>{{ Str::limit($surat->tujuan, 20) }}</td>
                        <td>{{ Str::limit($surat->perihal, 30) }}</td>
                        <td>{{ $surat->creator->name }}</td>
                        <td>
                            <span class="badge badge-status status-{{ $surat->status }}">
                                @switch($surat->status)
                                    @case('draft')
                                        📝 Draft
                                        @break
                                    @case('published')
                                        ✅ Dipublikasikan
                                        @break
                                    @case('diarsip')
                                        📦 Diarsip
                                        @break
                                    @default
                                        {{ ucfirst($surat->status) }}
                                @endswitch
                            </span>
                        </td>
                        <td>
                            @if($surat->file_lampiran)
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#previewModalKeluar{{ $surat->id }}">
                                    👁️
                                </button>
                                <a href="{{ Storage::url($surat->file_lampiran) }}" download class="btn btn-sm btn-success">
                                    📥
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('surat-keluar.show', $surat) }}" class="btn btn-sm btn-info">Lihat</a>
                            @php
                                $tuRoles = ['tu', 'ka_tu'];
                            @endphp
                            @if(in_array(auth()->user()->role, $tuRoles) || auth()->id() === $surat->created_by)
                                @if($surat->status === 'draft')
                                    <a href="{{ route('surat-keluar.edit', $surat) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('surat-keluar.destroy', $surat) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus surat ini?')">Hapus</button>
                                    </form>
                                @endif
                            @endif
                        </td>
                    </tr>
                    
                    @if($surat->file_lampiran)
                    <!-- Modal Preview File untuk setiap surat -->
                    <div class="modal fade" id="previewModalKeluar{{ $surat->id }}" tabindex="-1">
                        <div class="modal-dialog modal-fullscreen-lg-down" style="max-width: 85vw;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Preview - {{ $surat->perihal }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                                    @php
                                        $fileUrl = Storage::url($surat->file_lampiran);
                                        $extension = strtolower(pathinfo($surat->file_lampiran, PATHINFO_EXTENSION));
                                    @endphp
                                    
                                    @if(in_array($extension, ['pdf']))
                                        <iframe src="{{ $fileUrl }}" width="100%" height="700px" style="border: none;"></iframe>
                                    @elseif(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp']))
                                        <div style="text-align: center;">
                                            <img src="{{ $fileUrl }}" alt="Preview" style="max-width: 100%; max-height: 700px; object-fit: contain;">
                                        </div>
                                    @elseif(in_array($extension, ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx']))
                                        <div class="alert alert-info mb-0">
                                            File dokumen <strong>{{ strtoupper($extension) }}</strong> tidak bisa di-preview.
                                        </div>
                                    @else
                                        <div class="alert alert-info mb-0">
                                            File dengan tipe <strong>.{{ $extension }}</strong> tidak bisa di-preview.
                                        </div>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <a href="{{ $fileUrl }}" download class="btn btn-success">📥 Download</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
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
                <p class="text-danger fw-bold">Anda yakin ingin menghapus SEMUA surat keluar?</p>
                <p>Tindakan ini <strong>TIDAK DAPAT DIBATALKAN</strong> dan semua data surat akan hilang permanen.</p>
                <hr>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="confirmCheckbox" onchange="toggleDeleteButton()">
                    <label class="form-check-label" for="confirmCheckbox">
                        Saya memahami dan setuju untuk menghapus SEMUA surat keluar
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('surat-keluar.delete-all') }}" method="POST" style="display: inline;">
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
    {{ $suratKeluar->links() }}
</div>
@endsection
