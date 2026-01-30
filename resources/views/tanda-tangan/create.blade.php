@extends('layouts.app')

@section('title', $tandaTangan ? 'Perbarui Tanda Tangan' : 'Daftarkan Tanda Tangan')

@section('content')
<div class="mb-4">
    <h2>🖊️ {{ $tandaTangan ? 'Perbarui' : 'Daftarkan' }} Tanda Tangan Digital</h2>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">{{ $tandaTangan ? 'Perbarui' : 'Daftarkan' }} Tanda Tangan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('tanda-tangan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="file" class="form-label">
                            File Tanda Tangan <span class="text-danger">*</span>
                        </label>
                        <input type="file" 
                               class="form-control @error('file') is-invalid @enderror" 
                               id="file" 
                               name="file" 
                               accept=".pdf,.jpg,.jpeg,.png"
                               required>
                        <small class="text-muted d-block mt-2">
                            Format: JPG, PNG, atau PDF | Ukuran maksimal: 5 MB
                        </small>
                        @error('file')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Keterangan (Opsional)</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="3"
                                  placeholder="Misalnya: Tanda tangan resmi pada tanggal ...">{{ old('description', $tandaTangan?->description) }}</textarea>
                        <small class="text-muted">Tambahkan keterangan untuk membedakan versi tanda tangan (opsional)</small>
                        @error('description')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div id="ttdPreview" class="mb-4" style="display: none;">
                        <label class="fw-bold">Preview Tanda Tangan:</label>
                        <div class="border rounded p-3 bg-light">
                            <div id="ttdPreviewContent"></div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            {{ $tandaTangan ? '✔️ Perbarui Tanda Tangan' : '✔️ Daftarkan Tanda Tangan' }}
                        </button>
                        <a href="{{ route('tanda-tangan.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>

        @if($tandaTangan)
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Tanda Tangan Saat Ini</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Nama File: <strong>{{ $tandaTangan->original_filename }}</strong></p>
                    
                    <div class="border rounded p-3 bg-light" style="max-height: 250px; overflow-y: auto;">
                        @if($tandaTangan->file_type === 'pdf')
                            <div class="alert alert-info mb-0">
                                📄 File PDF - Download untuk melihat preview lengkap
                            </div>
                        @else
                            <img src="{{ Storage::url($tandaTangan->file_path) }}" alt="Tanda Tangan Saat Ini" class="img-fluid">
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">ℹ️ Petunjuk</h5>
            </div>
            <div class="card-body">
                <p><strong>Format File Didukung:</strong></p>
                <ul class="mb-3">
                    <li>JPG / JPEG</li>
                    <li>PNG</li>
                    <li>PDF</li>
                </ul>

                <p><strong>Ukuran Maksimal:</strong> 5 MB</p>

                <hr>

                <p><strong>Tips Tanda Tangan Digital:</strong></p>
                <ol style="font-size: 0.85rem;">
                    <li>Scan tanda tangan dengan jelas</li>
                    <li>Gunakan background putih/netral</li>
                    <li>Potong area tanda tangan saja</li>
                    <li>Pastikan resolusi cukup untuk cetakan</li>
                    <li>Simpan sebagai file dengan ukuran wajar</li>
                </ol>

                <div class="alert alert-info small mt-3 mb-0">
                    <strong>Catatan:</strong> Tanda tangan yang Anda daftarkan akan ditampilkan otomatis pada semua disposisi yang Anda buat.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('file').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('ttdPreview');
        const previewContent = document.getElementById('ttdPreviewContent');
        
        if (file) {
            const fileType = file.type;
            const fileName = file.name;
            const fileSize = (file.size / 1024).toFixed(2);
            
            let previewHtml = `<p><strong>File:</strong> ${fileName}</p><p><strong>Ukuran:</strong> ${fileSize} KB</p>`;
            
            if (fileType.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    previewHtml += `<img src="${event.target.result}" style="max-width: 100%; max-height: 200px; border: 1px solid #ddd; padding: 5px; margin-top: 10px;">`;
                    previewContent.innerHTML = previewHtml;
                };
                reader.readAsDataURL(file);
            } else if (fileType === 'application/pdf') {
                previewHtml += `<p><span class="badge bg-danger">PDF</span> File PDF akan disimpan dan digunakan pada disposisi</p>`;
                previewContent.innerHTML = previewHtml;
            }
            
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    });
</script>

@endsection
