@extends('layouts.app')

@section('title', 'Detail Surat Masuk')

@section('content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <h2>📨 Detail Surat Masuk</h2>
        @php
            $prev = url()->previous();
            // If previous URL is the disposisi create page, prefer returning to the list instead
            $isFromDisposisiCreate = false;
            try {
                if ($prev && (strpos($prev, '/disposisi') !== false || strpos($prev, route('disposisi.create', $suratMasuk)) !== false)) {
                    $isFromDisposisiCreate = true;
                }
            } catch (\Exception $e) {
                // ignore route generation errors
            }
            $backUrl = ($prev && !$isFromDisposisiCreate) ? $prev : route('surat-masuk.index');
        @endphp
        <a href="{{ $backUrl }}" class="btn btn-secondary">← Kembali</a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header bg-light">
                <h5 class="mb-0">Informasi Surat</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="fw-bold">Jenis Surat:</label>
                        <p>
                            @if($suratMasuk->jenis_surat === 'rahasia')
                                <span class="jenis-rahasia">🔒 Rahasia</span>
                            @elseif($suratMasuk->jenis_surat === 'penting')
                                <span class="jenis-penting">⚠️ Penting</span>
                            @else
                                <span class="jenis-biasa">📄 Biasa</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold">Kode Surat:</label>
                        <p>{{ $suratMasuk->kode_surat }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="fw-bold">Nomor Surat:</label>
                        <p>{{ $suratMasuk->nomor_surat }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold">Tanggal Surat:</label>
                        <p>{{ $suratMasuk->tanggal_surat->format('d/m/Y') }}</p>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Asal Surat:</label>
                    <p>{{ $suratMasuk->asal_surat }}</p>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Perihal:</label>
                    <p>{{ $suratMasuk->perihal }}</p>
                </div>

                @if($suratMasuk->catatan)
                    <div class="mb-3">
                        <label class="fw-bold">Catatan:</label>
                        <p>{{ $suratMasuk->catatan }}</p>
                    </div>
                @endif

                @if($suratMasuk->file_lampiran)
                    <div class="mb-3">
                        <label class="fw-bold">File Lampiran:</label>
                        <p>
                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#previewModalMasuk">
                                👁️ Preview
                            </button>
                            <a href="{{ Storage::url($suratMasuk->file_lampiran) }}" download class="btn btn-sm btn-success">
                                📥 Download
                            </a>
                        </p>
                    </div>
                @endif

                <div class="mb-3">
                    <label class="fw-bold">Status:</label>
                    <p>
                        <span class="badge badge-status status-{{ $suratMasuk->status }}">
                            @switch($suratMasuk->status)
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
                                @default
                                    {{ ucfirst(str_replace('_', ' ', $suratMasuk->status)) }}
                            @endswitch
                        </span>
                    </p>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Dibuat oleh:</label>
                    <p>{{ $suratMasuk->creator->name }} ({{ $suratMasuk->creator->role }})</p>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Tanggal Dibuat:</label>
                    <p>{{ $suratMasuk->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        @php
            $tuRoles = ['tu', 'ka_tu'];
        @endphp
        @if(in_array(auth()->user()->role, $tuRoles) && $suratMasuk->status === 'draft')
            <div class="d-flex gap-2 mb-3">
                <form action="{{ route('surat-masuk.submit', $suratMasuk) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        ✈️ Ajukan ke Kepala Sekolah
                    </button>
                </form>
                <a href="{{ route('surat-masuk.edit', $suratMasuk) }}" class="btn btn-warning">✏️ Edit</a>
                <form action="{{ route('surat-masuk.destroy', $suratMasuk) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus surat ini?')">🗑️ Hapus</button>
                </form>
            </div>
        @endif

        @if(in_array(auth()->user()->role, $tuRoles) && $suratMasuk->status !== 'draft' && $suratMasuk->status !== 'diarsip')
            <div class="d-flex gap-2 mb-3">
                <form action="{{ route('surat-masuk.archive', $suratMasuk) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-secondary" onclick="return confirm('Arsipkan surat ini? Surat tidak akan bisa diedit setelah diarsipkan.')">
                        📦 Arsipkan
                    </button>
                </form>
            </div>
        @elseif(in_array(auth()->user()->role, $tuRoles) && $suratMasuk->status === 'draft')
            <!-- Tombol arsipkan ditampilkan bersama dengan tombol lain di atas -->
        @else
            @if($suratMasuk->status !== 'diarsip' && in_array(auth()->user()->role, $tuRoles))
                <div class="d-flex gap-2 mb-3">
                    <form action="{{ route('surat-masuk.archive', $suratMasuk) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-secondary" onclick="return confirm('Arsipkan surat ini? Surat tidak akan bisa diedit setelah diarsipkan.')">
                            📦 Arsipkan
                        </button>
                    </form>
                </div>
            @endif
        @endif
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header bg-light">
                <h5 class="mb-0">📋 Disposisi</h5>
            </div>
            <div class="card-body">
                @if($suratMasuk->status === 'submitted' && auth()->user()->role === 'kepala_sekolah')
                    <p class="text-muted mb-3">Surat menunggu disposisi Anda</p>
                    <a href="{{ route('disposisi.create', $suratMasuk) }}" class="btn btn-primary w-100">
                        ➕ Buat Disposisi
                    </a>
                @elseif($suratMasuk->disposisi->count() > 0)
                    @foreach($suratMasuk->disposisi as $disp)
                        <div class="alert alert-info mb-3">
                            <div class="mb-2">
                                <strong>Disposisi ke:</strong> {{ $disp->user->name }}
                            </div>
                            <div class="mb-2">
                                <strong>Isi:</strong> {{ Str::limit($disp->isi_disposisi, 50) }}
                            </div>
                            <div class="mb-2">
                                <strong>Status:</strong>
                                <span class="badge badge-status status-{{ $disp->status }}">
                                    @switch($disp->status)
                                        @case('pending')
                                            Menunggu
                                            @break
                                        @case('received')
                                            Diterima
                                            @break
                                        @case('in_progress')
                                            Dalam Proses
                                            @break
                                        @case('completed')
                                            Selesai
                                            @break
                                        @default
                                            {{ ucfirst(str_replace('_', ' ', $disp->status)) }}
                                    @endswitch
                                </span>
                            </div>
                            <a href="{{ route('disposisi.show', $disp) }}" class="btn btn-sm btn-primary mt-2">
                                Lihat Disposisi
                            </a>
                            @if($disp->disposisi_ke === auth()->id() && $disp->status === 'pending')
                                <form action="{{ route('disposisi.receive', $disp) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success mt-2">
                                        ✔️ Terima Disposisi
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">Belum ada disposisi</p>
                @endif
            </div>
        </div>

        <!-- Download Lampiran Disposisi untuk TU & KA-TU -->
        @php
            $tuRoles = ['tu', 'ka_tu'];
        @endphp
        @if(in_array(auth()->user()->role, $tuRoles) && $suratMasuk->disposisi->count() > 0)
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">📥 Lampiran Disposisi</h5>
            </div>
            <div class="card-body">
                <p class="text-muted text-sm mb-3">Unduh lampiran disposisi dalam format PDF</p>
                <a href="{{ route('surat-masuk.download-lampiran-disposisi', $suratMasuk) }}" class="btn btn-primary w-100">
                    📄 Download Lampiran Disposisi
                </a>
            </div>
        </div>
        @endif
    </div>
</div>

@if($suratMasuk->file_lampiran)
<!-- Modal Preview File -->
<div class="modal fade" id="previewModalMasuk" tabindex="-1">
    <div class="modal-dialog modal-fullscreen-lg-down" style="max-width: 85vw;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview File Lampiran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                @php
                    $fileUrl = Storage::url($suratMasuk->file_lampiran);
                    $extension = strtolower(pathinfo($suratMasuk->file_lampiran, PATHINFO_EXTENSION));
                @endphp
                
                @if(in_array($extension, ['pdf']))
                    <!-- PDF Preview -->
                    <iframe src="{{ $fileUrl }}" width="100%" height="700px" style="border: none;"></iframe>
                @elseif(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp']))
                    <!-- Image Preview -->
                    <div style="text-align: center;">
                        <img src="{{ $fileUrl }}" alt="Preview" style="max-width: 100%; max-height: 700px; object-fit: contain;">
                    </div>
                @elseif(in_array($extension, ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx']))
                    <!-- Office Document -->
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-file-earmark"></i>
                        File dokumen <strong>{{ strtoupper($extension) }}</strong> tidak bisa di-preview langsung.
                        <br><br>
                        Silakan gunakan tombol <strong>Download</strong> untuk membuka file dengan aplikasi yang sesuai.
                    </div>
                @else
                    <!-- Other Files -->
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-file"></i>
                        File dengan tipe <strong>.{{ $extension }}</strong> tidak bisa di-preview.
                        <br><br>
                        Silakan gunakan tombol <strong>Download</strong> untuk membuka file.
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a href="{{ $fileUrl }}" download class="btn btn-success">
                    📥 Download
                </a>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
