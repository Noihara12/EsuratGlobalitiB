@extends('layouts.app')

@section('title', 'Edit Surat Masuk')

@section('content')
<div class="mb-4">
    <h2>✏️ Edit Surat Masuk</h2>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('surat-masuk.update', $suratMasuk) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="jenis_surat" class="form-label">Jenis Surat <span class="text-danger">*</span></label>
                    <select class="form-control @error('jenis_surat') is-invalid @enderror" id="jenis_surat" name="jenis_surat" required>
                        <option value="rahasia" {{ $suratMasuk->jenis_surat === 'rahasia' ? 'selected' : '' }}>🔒 Rahasia</option>
                        <option value="penting" {{ $suratMasuk->jenis_surat === 'penting' ? 'selected' : '' }}>⚠️ Penting</option>
                        <option value="biasa" {{ $suratMasuk->jenis_surat === 'biasa' ? 'selected' : '' }}>📄 Biasa</option>
                    </select>
                    @error('jenis_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="kode_surat" class="form-label">Kode Surat <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('kode_surat') is-invalid @enderror" id="kode_surat" name="kode_surat" value="{{ $suratMasuk->kode_surat }}" required>
                    @error('kode_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nomor_surat" class="form-label">Nomor Surat <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror" id="nomor_surat" name="nomor_surat" value="{{ $suratMasuk->nomor_surat }}" required>
                    @error('nomor_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="tanggal_surat" class="form-label">Tanggal Surat <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tanggal_surat') is-invalid @enderror" id="tanggal_surat" name="tanggal_surat" value="{{ $suratMasuk->tanggal_surat->format('Y-m-d') }}" required>
                    @error('tanggal_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="asal_surat" class="form-label">Asal Surat <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('asal_surat') is-invalid @enderror" id="asal_surat" name="asal_surat" value="{{ $suratMasuk->asal_surat }}" required>
                @error('asal_surat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="perihal" class="form-label">Perihal <span class="text-danger">*</span></label>
                <textarea class="form-control @error('perihal') is-invalid @enderror" id="perihal" name="perihal" rows="3" required>{{ $suratMasuk->perihal }}</textarea>
                @error('perihal')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="catatan" class="form-label">Catatan</label>
                <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="2">{{ $suratMasuk->catatan }}</textarea>
                @error('catatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="file_lampiran" class="form-label">File Lampiran (PDF, JPG, PNG - Max 5MB)</label>
                @if($suratMasuk->file_lampiran)
                    <div class="alert alert-info">
                        📎 File saat ini: <a href="{{ Storage::url($suratMasuk->file_lampiran) }}" target="_blank">Lihat File</a>
                    </div>
                @endif
                <input type="file" class="form-control @error('file_lampiran') is-invalid @enderror" id="file_lampiran" name="file_lampiran" accept=".pdf,.jpg,.jpeg,.png">
                <small class="text-muted">Jika Anda upload file baru, file lama akan diganti</small>
                @error('file_lampiran')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">✔️ Simpan Perubahan</button>
                <a href="{{ route('surat-masuk.show', $suratMasuk) }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
