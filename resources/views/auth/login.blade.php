@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 56px);">
    <div class="card" style="width: 100%; max-width: 400px;">
        <div class="card-header bg-light text-center">
            <img src="{{ asset('images/logosmk1.png') }}" alt="E-Surat Logo" style="max-width: 100px; height: auto;">
            <h2>Login</h2>
            <p class="text-muted">Sistem Manajemen Persuratan</p>
        </div>
        <div class="card-body">
            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                        <button class="btn btn-outline-secondary password-toggle" type="button" data-target="#password" aria-label="Toggle password visibility">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true"><path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8z"/><path d="M8 5.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5z"/></svg>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div>

                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>

            <hr>
            <div class="alert alert-info mt-3">
                <strong>Demo Users:</strong><br>
                <small>
                    <strong>Admin:</strong> admin@esurat.local / password<br>
                    <strong>Kepala Sekolah:</strong> kepala@esurat.local / password<br>
                    <strong>TU:</strong> tu@esurat.local / password<br>
                    <strong>User:</strong> user@esurat.local / password
                </small>
            </div>
        </div>
    </div>
</div>
@endsection
