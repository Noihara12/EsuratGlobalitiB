@extends('layouts.app')

@section('title', 'Edit Surat Keluar')

@section('content')
<div class="mb-4">
    <h2>✏️ Edit Surat Keluar</h2>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('surat-keluar.update', $suratKeluar) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nomor_surat" class="form-label">Nomor Surat <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror" id="nomor_surat" name="nomor_surat" value="{{ $suratKeluar->nomor_surat }}" required>
                @error('nomor_surat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tanggal_surat" class="form-label">Tanggal Surat <span class="text-danger">*</span></label>
                <input type="date" class="form-control @error('tanggal_surat') is-invalid @enderror" id="tanggal_surat" name="tanggal_surat" value="{{ $suratKeluar->tanggal_surat->format('Y-m-d') }}" required>
                @error('tanggal_surat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tujuan" class="form-label">Tujuan Surat <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('tujuan') is-invalid @enderror" id="tujuan" name="tujuan" value="{{ $suratKeluar->tujuan }}" required>
                @error('tujuan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="perihal" class="form-label">Perihal <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('perihal') is-invalid @enderror" id="perihal" name="perihal" value="{{ $suratKeluar->perihal }}" required>
                @error('perihal')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="isi_surat" class="form-label">Isi Surat <span class="text-danger">*</span></label>
                <textarea class="form-control @error('isi_surat') is-invalid @enderror" id="isi_surat" name="isi_surat" rows="6" required>{{ $suratKeluar->isi_surat }}</textarea>
                @error('isi_surat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            @php
                $tuRoles = ['tu', 'ka_tu'];
            @endphp
            @if(in_array(auth()->user()->role, $tuRoles))
                <div class="mb-3">
                    <label for="file_lampiran" class="form-label">File Lampiran (PDF, JPG, PNG - Max 5MB)</label>
                    @if($suratKeluar->file_lampiran)
                        <div class="alert alert-info">
                            📎 File saat ini: <a href="{{ Storage::url($suratKeluar->file_lampiran) }}" target="_blank">Lihat File</a>
                        </div>
                    @endif
                    <input type="file" class="form-control @error('file_lampiran') is-invalid @enderror" id="file_lampiran" name="file_lampiran" accept=".pdf,.jpg,.jpeg,.png">
                    <small class="text-muted">Jika Anda upload file baru, file lama akan diganti</small>
                    @error('file_lampiran')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endif

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">✔️ Simpan Perubahan</button>
                <a href="{{ route('surat-keluar.show', $suratKeluar) }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
