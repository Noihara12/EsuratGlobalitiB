@extends('layouts.app')

@section('title', 'Detail Disposisi')

@section('content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <h2>📋 Detail Disposisi</h2>
        <a href="{{ route('surat-masuk.show', $disposisi->suratMasuk) }}" class="btn btn-secondary">← Kembali</a>
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
                        <label class="fw-bold">Nomor Surat:</label>
                        <p>{{ $disposisi->suratMasuk->nomor_surat }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold">Asal Surat:</label>
                        <p>{{ $disposisi->suratMasuk->asal_surat }}</p>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Perihal:</label>
                    <p>{{ $disposisi->suratMasuk->perihal }}</p>
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Tanggal Surat:</label>
                    <p>{{ $disposisi->suratMasuk->tanggal_surat->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header bg-light">
                <h5 class="mb-0">📋 Disposisi</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="fw-bold">Disposisi ke:</label>
                    <p>{{ $disposisi->user->name }} ({{ ucfirst(str_replace('_', ' ', $disposisi->user->role)) }})</p>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Isi Disposisi:</label>
                    <p>{{ $disposisi->isi_disposisi }}</p>
                </div>

                @if($disposisi->catatan_kepala_sekolah)
                    <div class="mb-3">
                        <label class="fw-bold">Catatan Kepala Sekolah:</label>
                        <p>{{ $disposisi->catatan_kepala_sekolah }}</p>
                    </div>
                @endif

                <div class="mb-3">
                    <label class="fw-bold">Status:</label>
                    <p>
                        <span class="badge badge-status status-{{ $disposisi->status }}">
                            @switch($disposisi->status)
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
                                    {{ ucfirst(str_replace('_', ' ', $disposisi->status)) }}
                            @endswitch
                        </span>
                    </p>
                </div>

                @if($disposisi->received_at)
                    <div class="mb-3">
                        <label class="fw-bold">Diterima pada:</label>
                        <p>{{ $disposisi->received_at->format('d/m/Y H:i') }}</p>
                    </div>
                @endif

                @if($disposisi->tanda_tangan_file)
                    <div class="mb-3">
                        <label class="fw-bold">Tanda Tangan:</label>
                        <div class="card">
                            <div class="card-body">
                                @php
                                    $fileExtension = strtolower(pathinfo($disposisi->tanda_tangan_file, PATHINFO_EXTENSION));
                                @endphp
                                @if(in_array($fileExtension, ['jpg', 'jpeg', 'png']))
                                    <div style="max-width: 300px;">
                                        <img src="{{ Storage::url($disposisi->tanda_tangan_file) }}" class="img-fluid border rounded" alt="Tanda Tangan">
                                    </div>
                                @else
                                    <p class="text-muted">File: {{ basename($disposisi->tanda_tangan_file) }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <div class="mb-3">
                    <label class="fw-bold">Dibuat oleh:</label>
                    <p>{{ $disposisi->creator->name }} ({{ ucfirst(str_replace('_', ' ', $disposisi->creator->role)) }})</p>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Tanggal Dibuat:</label>
                    <p>{{ $disposisi->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        @if($disposisi->disposisi_ke === auth()->id() && $disposisi->status === 'pending')
            <form action="{{ route('disposisi.receive', $disposisi) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success btn-lg w-100">
                    ✔️ Terima Disposisi
                </button>
            </form>
        @elseif(auth()->user()->role === 'kepala_sekolah' && $disposisi->created_by === auth()->id() && in_array($disposisi->status, ['pending', 'received']))
            <div class="d-flex gap-2">
                <a href="{{ route('disposisi.edit', $disposisi) }}" class="btn btn-warning btn-lg flex-grow-1">
                    ✏️ Edit Disposisi
                </a>
                <a href="{{ route('surat-masuk.show', $disposisi->suratMasuk) }}" class="btn btn-secondary btn-lg flex-grow-1">
                    ← Kembali
                </a>
            </div>
        @else
            <a href="{{ route('surat-masuk.show', $disposisi->suratMasuk) }}" class="btn btn-secondary btn-lg w-100">
                ← Kembali
            </a>
        @endif
    </div>
</div>
@endsection
