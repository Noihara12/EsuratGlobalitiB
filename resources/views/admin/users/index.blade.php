@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>👥 Kelola User</h2>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">+ Tambah User</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>Role</th>
                    <th>Dibuat pada</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td><strong>{{ (($users->currentPage() - 1) * $users->perPage()) + $loop->iteration }}</strong></td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->no_hp ?? '-' }}</td>
                        <td>
                            <span class="badge" style="background-color: 
                                {{ $user->role === 'admin' ? '#dc3545' : 
                                   ($user->role === 'kepala_sekolah' ? '#007bff' : 
                                    ($user->role === 'tu' ? '#28a745' : '#6c757d')) }}">
                                {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">Edit</a>
                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus user ini?')">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">Tidak ada user</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($users->hasPages())
    <div class="d-flex justify-content-center mt-3">
        {{ $users->withQueryString()->links() }}
    </div>
@endif

@endsection
