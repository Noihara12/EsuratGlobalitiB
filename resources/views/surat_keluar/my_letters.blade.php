@extends('layouts.app')

@section('title', 'Surat Keluar (Saya)')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2>📋 Surat Keluar (Saya)</h2>
        <small class="text-muted">Daftar surat keluar yang Anda buat</small>
    </div>
    @php
        $allowedRoles = ['tu', 'ka_tu', 'staff', 'wakasek_kurikulum', 'wakasek_sarana_prasarana', 'wakasek_kesiswaan', 'wakasek_humas', 'kaprog_dkv', 'kaprog_pplg', 'kaprog_tjkt', 'kaprog_bd', 'guru', 'pembina_ekstra', 'bkk'];
    @endphp
    @if(in_array(auth()->user()->role, $allowedRoles))
        <a href="{{ route('surat-keluar.create') }}" class="btn btn-primary">+ Buat Surat Keluar</a>
    @endif
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%">No</th>
                    <th>Nomor Surat</th>
                    <th>Tanggal</th>
                    <th>Perihal</th>
                    <th>Status</th>
                    <th>Lampiran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suratKeluar as $surat)
                    <tr>
                        <td><strong>{{ $loop->iteration }}</strong></td>
                        <td>{{ $surat->nomor_surat }}</td>
                        <td>{{ $surat->tanggal_surat->format('d/m/Y') }}</td>
                        <td>{{ Str::limit($surat->perihal, 30) }}</td>
                        <td>
                            <span class="badge badge-status status-{{ $surat->status }}">
                                @switch($surat->status)
                                    @case('draft')
                                        📝 Draft
                                        @break
                                    @case('published')
                                        ✅ Dipublikasikan
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
                                @if($surat->status === 'draft' && in_array(auth()->user()->role, $tuRoles))
                                    <form action="{{ route('surat-keluar.publish', $surat) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Publikasikan</button>
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
                        <td colspan="6" class="text-center py-4">
                            <div class="text-muted">
                                <p>Anda belum membuat surat keluar</p>
                                @php
                                    $allowedRoles = ['tu', 'ka_tu', 'staff', 'wakasek_kurikulum', 'wakasek_sarana_prasarana', 'wakasek_kesiswaan', 'wakasek_humas', 'kaprog_dkv', 'kaprog_pplg', 'kaprog_tjkt', 'kaprog_bd', 'guru', 'pembina_ekstra', 'bkk'];
                                @endphp
                                @if(in_array(auth()->user()->role, $allowedRoles))
                                    <a href="{{ route('surat-keluar.create') }}" class="btn btn-sm btn-primary">Buat Surat Keluar</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $suratKeluar->links() }}
</div>
@endsection
