@extends('layouts.app')

@section('title', 'Buat Surat Keluar')

@section('content')
<div class="mb-4">
    <h2>📝 Buat Surat Keluar</h2>
    <p class="text-muted">
        @php
            $tuRoles = ['tu', 'ka_tu'];
        @endphp
        @if(in_array(auth()->user()->role, $tuRoles))
            Anda dapat menambahkan file lampiran
        @else
            Catatan: Anda tidak dapat menambahkan file lampiran. Hanya TU dan KA-TU yang dapat menambahkan lampiran.
        @endif
    </p>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('surat-keluar.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="nomor_surat" class="form-label">Nomor Surat <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror" id="nomor_surat" name="nomor_surat" placeholder="Contoh: 001/SK/12/2025" value="{{ old('nomor_surat') }}" required>
                <small class="text-muted">Format: XXX/KODE/MM/YYYY</small>
                @error('nomor_surat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tanggal_surat" class="form-label">Tanggal Surat <span class="text-danger">*</span></label>
                <input type="date" class="form-control @error('tanggal_surat') is-invalid @enderror" id="tanggal_surat" name="tanggal_surat" value="{{ old('tanggal_surat') }}" required>
                @error('tanggal_surat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tujuan" class="form-label">Tujuan Surat <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('tujuan') is-invalid @enderror" id="tujuan" name="tujuan" placeholder="Contoh: Kepada Kepala Sekolah" value="{{ old('tujuan') }}" required>
                @error('tujuan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="perihal" class="form-label">Perihal <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('perihal') is-invalid @enderror" id="perihal" name="perihal" placeholder="Perihal surat" value="{{ old('perihal') }}" required>
                @error('perihal')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="isi_surat" class="form-label">Isi Surat <span class="text-danger">*</span></label>
                <textarea class="form-control @error('isi_surat') is-invalid @enderror" id="isi_surat" name="isi_surat" rows="6" required>{{ old('isi_surat') }}</textarea>
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
                    <input type="file" class="form-control @error('file_lampiran') is-invalid @enderror" id="file_lampiran" name="file_lampiran" accept=".pdf,.jpg,.jpeg,.png">
                    @error('file_lampiran')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endif

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">✔️ Simpan</button>
                <a href="{{ route('surat-keluar.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
