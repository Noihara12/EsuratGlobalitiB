@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="mb-4">
    <h2>➕ Tambah User</h2>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="no_hp" class="form-label">No HP</label>
                <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" placeholder="Contoh: 08123456789">
                @error('no_hp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
                    <option value="">-- Pilih Role --</option>
                    <optgroup label="Pimpinan">
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="kepala_sekolah" {{ old('role') === 'kepala_sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                    </optgroup>
                    <optgroup label="Wakil Kepala Sekolah">
                        <option value="wakasek_kurikulum" {{ old('role') === 'wakasek_kurikulum' ? 'selected' : '' }}>Wakasek Kurikulum</option>
                        <option value="wakasek_sarana_prasarana" {{ old('role') === 'wakasek_sarana_prasarana' ? 'selected' : '' }}>Wakasek Sarana Prasarana</option>
                        <option value="wakasek_kesiswaan" {{ old('role') === 'wakasek_kesiswaan' ? 'selected' : '' }}>Wakasek Kesiswaan</option>
                        <option value="wakasek_humas" {{ old('role') === 'wakasek_humas' ? 'selected' : '' }}>Wakasek Humas</option>
                    </optgroup>
                    <optgroup label="Tata Usaha">
                        <option value="tu" {{ old('role') === 'tu' ? 'selected' : '' }}>TU (Tata Usaha)</option>
                        <option value="ka_tu" {{ old('role') === 'ka_tu' ? 'selected' : '' }}>KA-TU (Kepala Tata Usaha)</option>
                    </optgroup>
                    <optgroup label="Program Keahlian">
                        <option value="kaprog_dkv" {{ old('role') === 'kaprog_dkv' ? 'selected' : '' }}>Kaprog DKV</option>
                        <option value="kaprog_pplg" {{ old('role') === 'kaprog_pplg' ? 'selected' : '' }}>Kaprog PPLG</option>
                        <option value="kaprog_tjkt" {{ old('role') === 'kaprog_tjkt' ? 'selected' : '' }}>Kaprog TJKT</option>
                        <option value="kaprog_bd" {{ old('role') === 'kaprog_bd' ? 'selected' : '' }}>Kaprog BD</option>
                    </optgroup>
                    <optgroup label="Pendidik & Tenaga Kependidikan">
                        <option value="guru" {{ old('role') === 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="pembina_ekstra" {{ old('role') === 'pembina_ekstra' ? 'selected' : '' }}>Pembina Ekstra</option>
                        <option value="bkk" {{ old('role') === 'bkk' ? 'selected' : '' }}>BKK (Bursa Kerja Khusus)</option>
                    </optgroup>
                    <optgroup label="Lainnya">
                        <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Staff</option>
                    </optgroup>
                </select>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                    <button class="btn btn-outline-secondary password-toggle" type="button" data-target="#password" aria-label="Toggle password visibility">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true"><path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8z"/><path d="M8 5.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5z"/></svg>
                    </button>
                </div>
                <small class="text-muted">Minimal 8 karakter</small>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" required>
                    <button class="btn btn-outline-secondary password-toggle" type="button" data-target="#password_confirmation" aria-label="Toggle password visibility">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true"><path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8z"/><path d="M8 5.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5z"/></svg>
                    </button>
                </div>
                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">✔️ Tambah User</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
