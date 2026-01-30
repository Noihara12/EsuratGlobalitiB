@extends('layouts.app')

@section('title', 'Edit Disposisi')

@section('content')
<div class="mb-4">
    <h2>✏️ Edit Disposisi</h2>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header bg-light">
                <h5 class="mb-0">Surat yang Didisposisikan</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="fw-bold">Nomor Surat:</label>
                        <p>{{ $suratMasuk->nomor_surat }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold">Jenis:</label>
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
                        <label class="fw-bold">Catatan TU:</label>
                        <p>{{ $suratMasuk->catatan }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">✏️ Form Edit Disposisi</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('disposisi.update', $disposisi) }}" method="POST" enctype="multipart/form-data" id="disposisiForm">
                    @csrf
                    @method('PUT')

                    <!-- Penerima disposisi -->
                    <div class="mb-3">
                        <label for="disposisi_ke" class="form-label"><strong>Penerima Disposisi <span class="text-danger">*</span></strong></label>
                        <select class="form-select @error('disposisi_ke') is-invalid @enderror" id="disposisi_ke" name="disposisi_ke" required>
                            <option value="">-- Pilih User --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" @selected(old('disposisi_ke', $disposisi->disposisi_ke) == $user->id)>
                                    {{ $user->name }} ({{ ucfirst(str_replace('_', ' ', $user->role)) }})
                                </option>
                            @endforeach
                        </select>
                        @error('disposisi_ke')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Isi disposisi -->
                    <div class="mb-3">
                        <label class="form-label">Isi Disposisi <span class="text-danger">*</span></label>
                        <div class="border rounded p-3 bg-white @error('isi_disposisi') border-danger @enderror">
                            @php
                                $isiDisposisiOptions = ['Diketahui', 'Diperbanyak', 'Dibahas', 'Difile', 'Diumumkan', 'Dibicarakan', 'Dilaksanakan', 'Dihubungi'];
                                $isiDisposisiValues = old('isi_disposisi', explode(',', $disposisi->isi_disposisi));
                                $isiDisposisiValues = array_map('trim', $isiDisposisiValues);
                            @endphp
                            <div class="row">
                                @foreach($isiDisposisiOptions as $index => $option)
                                    <div class="col-md-6 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   name="isi_disposisi[]" 
                                                   value="{{ $option }}"
                                                   id="isi_disposisi_{{ $index }}"
                                                   @checked(in_array($option, $isiDisposisiValues))>
                                            <label class="form-check-label" for="isi_disposisi_{{ $index }}">
                                                {{ $option }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <small class="text-muted d-block mt-2">Pilih minimal satu opsi untuk isi disposisi</small>
                        @error('isi_disposisi')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Catatan kepala sekolah -->
                    <div class="mb-3">
                        <label for="catatan_kepala_sekolah" class="form-label">Catatan Kepala Sekolah</label>
                        <textarea class="form-control @error('catatan_kepala_sekolah') is-invalid @enderror" id="catatan_kepala_sekolah" name="catatan_kepala_sekolah" rows="3">{{ old('catatan_kepala_sekolah', $disposisi->catatan_kepala_sekolah) }}</textarea>
                        @error('catatan_kepala_sekolah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tanda tangan -->
                    <div class="mb-3">
                        <label class="form-label">Tambahkan Tanda Tangan <span class="text-danger">*</span></label>
                        <div class="border rounded p-3 bg-white @error('tambah_tanda_tangan') border-danger @enderror">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="radio" 
                                               name="tambah_tanda_tangan" 
                                               value="ya"
                                               id="tambah_tanda_tangan_ya"
                                               @checked(old('tambah_tanda_tangan', $disposisi->tanda_tangan_file ? 'ya' : 'tidak') === 'ya')
                                               required>
                                        <label class="form-check-label" for="tambah_tanda_tangan_ya">
                                            ✓ Ya (Gunakan Tanda Tangan Terdaftar)
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="radio" 
                                               name="tambah_tanda_tangan" 
                                               value="tidak"
                                               id="tambah_tanda_tangan_tidak"
                                               @checked(old('tambah_tanda_tangan', $disposisi->tanda_tangan_file ? 'ya' : 'tidak') === 'tidak')
                                               required>
                                        <label class="form-check-label" for="tambah_tanda_tangan_tidak">
                                            ✗ Tidak (Tanpa Tanda Tangan)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <small class="text-muted d-block mt-2">Pilih "Ya" untuk menambahkan tanda tangan terdaftar Anda</small>
                        @error('tambah_tanda_tangan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Preview tanda tangan -->
                    @php
                        $showCurrentSignature = false;
                        if ($disposisi->tanda_tangan_file && $userTandaTangan && $disposisi->tanda_tangan_file !== $userTandaTangan->file_path) {
                            $showCurrentSignature = true;
                        }
                    @endphp

                    @if($userTandaTangan)
                        <div id="ttdPreview" class="mb-3">
                            <div class="alert alert-info">
                                <strong>📋 Tanda Tangan Terdaftar Anda:</strong>
                                <div class="mt-3" style="max-height: 200px; overflow-y: auto;">
                                    @if($userTandaTangan->file_type === 'pdf')
                                        <div class="alert alert-secondary small mb-0">
                                            📄 File PDF - {{ $userTandaTangan->original_filename }}
                                        </div>
                                    @else
                                        <img src="{{ Storage::url($userTandaTangan->file_path) }}" alt="Tanda Tangan" class="img-fluid border rounded" style="max-width: 300px;">
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="mb-3">
                            <div class="alert alert-warning">
                                ⚠️ Anda belum mendaftarkan tanda tangan digital. <a href="{{ route('tanda-tangan.create') }}" class="alert-link">Daftarkan sekarang</a>
                            </div>
                        </div>
                    @endif

                    <!-- Tanda tangan saat ini (hanya jika berbeda dengan tanda tangan terdaftar) -->
                    @if($showCurrentSignature)
                        <div class="mb-3">
                            <div class="alert alert-secondary">
                                <strong>📋 Tanda Tangan Saat Ini:</strong>
                                <div class="mt-3" style="max-height: 200px; overflow-y: auto;">
                                    @php
                                        $fileExtension = strtolower(pathinfo($disposisi->tanda_tangan_file, PATHINFO_EXTENSION));
                                    @endphp
                                    @if(in_array($fileExtension, ['jpg', 'jpeg', 'png']))
                                        <img src="{{ Storage::url($disposisi->tanda_tangan_file) }}" alt="Tanda Tangan" class="img-fluid border rounded" style="max-width: 300px;">
                                    @else
                                        <div class="alert alert-secondary small mb-0">
                                            📄 File - {{ basename($disposisi->tanda_tangan_file) }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">✔️ Perbarui Disposisi</button>
                        <a href="{{ route('disposisi.show', $disposisi) }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .jenis-rahasia {
        color: #dc3545;
        font-weight: 500;
    }

    .jenis-penting {
        color: #ff9800;
        font-weight: 500;
    }

    .jenis-biasa {
        color: #28a745;
        font-weight: 500;
    }
</style>
@endsection
