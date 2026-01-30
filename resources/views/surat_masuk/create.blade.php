@extends('layouts.app')

@section('title', 'Buat Surat Masuk')

@section('content')
<div class="mb-4">
    <h2>📝 Buat Surat Masuk</h2>
    <p class="text-muted">Isi form di bawah untuk membuat surat masuk baru</p>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('surat-masuk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="jenis_surat" class="form-label">Jenis Surat <span class="text-danger">*</span></label>
                    <select class="form-control @error('jenis_surat') is-invalid @enderror" id="jenis_surat" name="jenis_surat" required>
                        <option value="">-- Pilih Jenis Surat --</option>
                        <option value="rahasia" {{ old('jenis_surat') === 'rahasia' ? 'selected' : '' }}>🔒 Rahasia</option>
                        <option value="penting" {{ old('jenis_surat') === 'penting' ? 'selected' : '' }}>⚠️ Penting</option>
                        <option value="biasa" {{ old('jenis_surat') === 'biasa' ? 'selected' : '' }}>📄 Biasa</option>
                    </select>
                    @error('jenis_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="kode_surat" class="form-label">Kode Surat <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('kode_surat') is-invalid @enderror" id="kode_surat" name="kode_surat" value="{{ old('kode_surat') }}" required>
                    @error('kode_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nomor_surat" class="form-label">Nomor Surat <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror" id="nomor_surat" name="nomor_surat" placeholder="Contoh: 001/SK/12/2025" value="{{ old('nomor_surat') }}" required>
                    @error('nomor_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="tanggal_surat" class="form-label">Tanggal Surat <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tanggal_surat') is-invalid @enderror" id="tanggal_surat" name="tanggal_surat" value="{{ old('tanggal_surat') }}" required>
                    @error('tanggal_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="asal_surat" class="form-label">Asal Surat <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('asal_surat') is-invalid @enderror" id="asal_surat" name="asal_surat" placeholder="Contoh: Dinas Pendidikan" value="{{ old('asal_surat') }}" required>
                @error('asal_surat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="perihal" class="form-label">Perihal <span class="text-danger">*</span></label>
                <textarea class="form-control @error('perihal') is-invalid @enderror" id="perihal" name="perihal" rows="3" required>{{ old('perihal') }}</textarea>
                @error('perihal')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="catatan" class="form-label">Catatan</label>
                <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="2">{{ old('catatan') }}</textarea>
                @error('catatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="file_lampiran" class="form-label">File Lampiran (PDF, JPG, PNG - Max 5MB)</label>
                <input type="file" class="form-control @error('file_lampiran') is-invalid @enderror" id="file_lampiran" name="file_lampiran" accept=".pdf,.jpg,.jpeg,.png">
                @error('file_lampiran')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">✔️ Simpan</button>
                <a href="{{ route('surat-masuk.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
