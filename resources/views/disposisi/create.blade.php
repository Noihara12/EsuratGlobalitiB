@extends('layouts.app')

@section('title', 'Buat Disposisi')

@section('content')
<div class="mb-4">
    <h2>📝 Buat Disposisi</h2>
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
                <h5 class="mb-0">📋 Form Disposisi (Multiple)</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('disposisi.store', $suratMasuk) }}" method="POST" enctype="multipart/form-data" id="disposisiForm">
                    @csrf

                    <!-- Container untuk daftar penerima disposisi -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <label class="form-label mb-0"><strong>Penerima Disposisi <span class="text-danger">*</span></strong></label>
                            <button type="button" class="btn btn-sm btn-success" id="btnTambahPenerima">
                                + Tambah Penerima
                            </button>
                        </div>

                        <div id="penerimaContainer">
                            <!-- Penerima akan ditambahkan di sini -->
                        </div>

                        @error('disposisi_ke')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Isi Disposisi <span class="text-danger">*</span></label>
                        <div class="border rounded p-3 bg-white @error('isi_disposisi') border-danger @enderror">
                            @php
                                $isiDisposisiOptions = ['Diketahui', 'Diperbanyak', 'Dibahas', 'Difile', 'Diumumkan', 'Dibicarakan', 'Dilaksanakan', 'Dihubungi'];
                                $isiDisposisiValues = old('isi_disposisi', []);
                                if (is_string($isiDisposisiValues)) {
                                    $isiDisposisiValues = explode(',', $isiDisposisiValues);
                                }
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

                    <div class="mb-3">
                        <label for="catatan_kepala_sekolah" class="form-label">Catatan Kepala Sekolah</label>
                        <textarea class="form-control @error('catatan_kepala_sekolah') is-invalid @enderror" id="catatan_kepala_sekolah" name="catatan_kepala_sekolah" rows="3">{{ old('catatan_kepala_sekolah') }}</textarea>
                        @error('catatan_kepala_sekolah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

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
                                               @checked(old('tambah_tanda_tangan') === 'ya')
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
                                               @checked(old('tambah_tanda_tangan') === 'tidak')
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

                    <!-- Preview Tanda Tangan yang Terdaftar -->
                    @php
                        $userTandaTangan = \App\Models\TandaTangan::where('user_id', auth()->id())->first();
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

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">✔️ Buat Disposisi</button>
                        <a href="{{ route('surat-masuk.show', $suratMasuk) }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .penerima-item {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        padding: 1rem;
        margin-bottom: 1rem;
        background: #f8f9fa;
        position: relative;
    }

    .btn-remove-penerima {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        padding: 0.25rem 0.5rem;
        font-size: 0.85rem;
    }

    .penerima-number {
        font-weight: bold;
        color: #495057;
        margin-bottom: 1rem;
        display: block;
        font-size: 0.9rem;
    }
</style>

<script>
    let penerimaCount = 0;
    const minPenerima = 1;
    const maxPenerima = 10;

    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi dengan 1 penerima
        addPenerima();

        // Event listener untuk tombol tambah
        document.getElementById('btnTambahPenerima').addEventListener('click', function() {
            if (penerimaCount < maxPenerima) {
                addPenerima();
            } else {
                alert('Maksimal ' + maxPenerima + ' penerima');
            }
        });

        // Form validation
        document.getElementById('disposisiForm').addEventListener('submit', function(e) {
            const container = document.getElementById('penerimaContainer');
            const selects = container.querySelectorAll('select[name="disposisi_ke[]"]');
            
            if (selects.length === 0 || !hasAnyValueSelected(selects)) {
                e.preventDefault();
                alert('Pilih minimal satu penerima disposisi');
                return false;
            }
        });
    });

    function addPenerima() {
        if (penerimaCount >= maxPenerima) return;

        penerimaCount++;
        const container = document.getElementById('penerimaContainer');
        const penerimaItem = document.createElement('div');
        penerimaItem.className = 'penerima-item';
        penerimaItem.id = 'penerima-' + penerimaCount;

        const users = {!! json_encode($users->map(function($user) {
            return ['id' => $user->id, 'name' => $user->name, 'role' => $user->role];
        })) !!};

        let optionsHtml = '<option value="">-- Pilih User --</option>';
        users.forEach(function(user) {
            optionsHtml += '<option value="' + user.id + '">' + user.name + ' (' + user.role.replace(/_/g, ' ') + ')</option>';
        });

        penerimaItem.innerHTML = `
            <span class="penerima-number">Penerima #${penerimaCount}</span>
            <div class="mb-3">
                <label class="form-label">Nama Penerima <span class="text-danger">*</span></label>
                <select class="form-select" name="disposisi_ke[]" required>
                    ${optionsHtml}
                </select>
            </div>
            ${penerimaCount > minPenerima ? `
                <button type="button" class="btn btn-danger btn-sm btn-remove-penerima" onclick="removePenerima(${penerimaCount})">
                    ✕ Hapus
                </button>
            ` : ''}
        `;

        container.appendChild(penerimaItem);
    }

    function removePenerima(index) {
        const item = document.getElementById('penerima-' + index);
        if (item) {
            item.remove();
        }
    }

    function hasAnyValueSelected(selects) {
        return Array.from(selects).some(select => select.value !== '');
    }
</script>
@endsection
