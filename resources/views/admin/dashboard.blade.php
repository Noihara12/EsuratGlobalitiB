@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<style>
    .stat-card {
        border-radius: 10px;
        border: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        overflow: hidden;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }

    .stat-card.primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .stat-card.success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
    }

    .stat-card.info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }

    .stat-card.warning {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: white;
    }

    .stat-card .card-body {
        padding: 0.8rem 0.6rem;
    }

    .stat-number {
        font-size: 1.8rem;
        font-weight: bold;
        margin: 0.2rem 0;
    }

    .stat-label {
        font-size: 0.75rem;
        opacity: 0.95;
        font-weight: 500;
    }

    .stat-icon {
        font-size: 1.2rem;
        margin-bottom: 0.2rem;
        opacity: 0.8;
    }

    .role-card {
        max-height: 250px;
        overflow-y: auto;
    }

    .role-card::-webkit-scrollbar {
        width: 6px;
    }

    .role-card::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .role-card::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .role-card::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .role-badge {
        display: inline-block;
        padding: 0.4rem 0.8rem;
        border-radius: 50px;
        background-color: #f0f0f0;
        font-weight: 500;
        font-size: 0.85rem;
        margin-bottom: 0.3rem;
    }

    .role-badge.admin { background-color: #ffe5e5; color: #d32f2f; }
    .role-badge.kepala_sekolah { background-color: #e3f2fd; color: #1976d2; }
    .role-badge.tu { background-color: #f3e5f5; color: #7b1fa2; }
    .role-badge.user { background-color: #e8f5e9; color: #388e3c; }
    .role-badge.other { background-color: #fff3e0; color: #e65100; }

    .quick-action-btn {
        border-radius: 10px;
        padding: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        transition: all 0.3s ease;
        border: none;
        color: white;
        font-size: 0.85rem;
        min-height: 65px;
        flex-direction: column;
        text-align: center;
    }

    .quick-action-btn:hover {
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }

    .quick-action-btn.primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .quick-action-btn.success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }

    .quick-action-btn.info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .quick-action-btn.secondary {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .role-table {
        border-collapse: collapse;
    }

    .role-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .role-table td {
        padding: 0.5rem;
        border-bottom: 1px solid #e9ecef;
        font-size: 0.8rem;
    }

    .role-count {
        font-weight: bold;
        font-size: 1.1rem;
        color: #667eea;
    }

    @media (max-width: 767.98px) {
        .stat-number { font-size: 1.3rem; }
        .stat-label { font-size: 0.7rem; }
        .stat-icon { font-size: 1.1rem; }
        .stat-card .card-body { padding: 0.6rem 0.5rem; }
        .stat-card:hover { transform: none; }
        
        .quick-action-btn { 
            min-height: 60px; 
            font-size: 0.8rem; 
            padding: 0.6rem;
            gap: 0.2rem;
        }
        .quick-action-btn:hover { transform: none; }
        
        .role-card { 
            max-height: 200px;
        }
        
        .card { 
            margin-bottom: 0.8rem !important;
        }
        
        .card-header { 
            padding: 0.5rem 0.7rem !important;
        }
        
        .card-body {
            padding: 0.5rem 0.7rem !important;
        }
        
        .role-table td {
            padding: 0.4rem;
            font-size: 0.75rem;
        }
        
        .role-badge {
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
        }
        
        .role-count {
            font-size: 0.9rem;
        }
        
        h2 { font-size: 1.2rem !important; }
        .text-muted { font-size: 0.7rem !important; }
        h5 { font-size: 0.9rem !important; }
        
        .d-grid.gap-2 { gap: 0.4rem !important; }
    }
    
    @media (max-width: 575.98px) {
        .stat-number { font-size: 1.15rem; }
        .stat-label { font-size: 0.65rem; }
        .stat-icon { font-size: 1rem; }
        .stat-card .card-body { padding: 0.5rem 0.4rem; }
        
        .quick-action-btn { 
            min-height: 55px;
            font-size: 0.75rem;
            padding: 0.5rem;
        }
        
        .role-card { max-height: 180px; }
        h2 { font-size: 1.1rem !important; }
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>📊 Admin Dashboard</h2>
</div>

<!-- Statistics Cards -->
<div style="display: flex; flex-wrap: wrap; gap: 0.4rem; margin-bottom: 0.8rem;">
    <div style="flex: 1 1 calc(50% - 0.2rem); min-width: 120px;">
        <div class="card stat-card primary">
            <div class="card-body text-center">
                <div class="stat-icon">👥</div>
                <div class="stat-number">{{ $totalUsers }}</div>
                <div class="stat-label">Total User</div>
            </div>
        </div>
    </div>
    <div style="flex: 1 1 calc(50% - 0.2rem); min-width: 120px;">
        <div class="card stat-card success">
            <div class="card-body text-center">
                <div class="stat-icon">📨</div>
                <div class="stat-number">{{ $suratMasukCount ?? 0 }}</div>
                <div class="stat-label">Surat Masuk</div>
            </div>
        </div>
    </div>
    <div style="flex: 1 1 calc(50% - 0.2rem); min-width: 120px;">
        <div class="card stat-card info">
            <div class="card-body text-center">
                <div class="stat-icon">📤</div>
                <div class="stat-number">{{ $suratKeluarCount ?? 0 }}</div>
                <div class="stat-label">Surat Keluar</div>
            </div>
        </div>
    </div>
    <div style="flex: 1 1 calc(50% - 0.2rem); min-width: 120px;">
        <div class="card stat-card warning">
            <div class="card-body text-center">
                <div class="stat-icon">💾</div>
                <div class="stat-number">{{ $backupCount ?? 0 }}</div>
                <div class="stat-label">Total Backup</div>
            </div>
        </div>
    </div>
</div>

<!-- User by Role & Quick Actions -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 0.8rem;">
    <div>
        <div class="card">
            <div class="card-header bg-light border-0" style="padding: 0.6rem 0.8rem;">
                <h5 class="mb-0" style="font-size: 0.95rem;">👤 User Berdasarkan Role</h5>
            </div>
            <div class="role-card card-body p-0">
                <table class="table table-sm table-borderless role-table mb-0">
                    <tbody>
                        @php
                            $allRoles = [
                                'admin' => ['label' => 'Admin', 'icon' => '🔐', 'badge' => 'admin'],
                                'kepala_sekolah' => ['label' => 'Kepala Sekolah', 'icon' => '👔', 'badge' => 'kepala_sekolah'],
                                'tu' => ['label' => 'TU', 'icon' => '📋', 'badge' => 'tu'],
                                'ka_tu' => ['label' => 'Kepala TU', 'icon' => '📋', 'badge' => 'tu'],
                                'staff' => ['label' => 'Staff', 'icon' => '👤', 'badge' => 'user'],
                                'wakasek_kurikulum' => ['label' => 'Wakasek Kurikulum', 'icon' => '📚', 'badge' => 'other'],
                                'wakasek_sarana_prasarana' => ['label' => 'Wakasek Sarana', 'icon' => '🏗️', 'badge' => 'other'],
                                'wakasek_kesiswaan' => ['label' => 'Wakasek Kesiswaan', 'icon' => '👨‍🎓', 'badge' => 'other'],
                                'wakasek_humas' => ['label' => 'Wakasek Humas', 'icon' => '📢', 'badge' => 'other'],
                                'kaprog_dkv' => ['label' => 'Kaprog DKV', 'icon' => '🎨', 'badge' => 'other'],
                                'kaprog_pplg' => ['label' => 'Kaprog PPLG', 'icon' => '💻', 'badge' => 'other'],
                                'kaprog_tjkt' => ['label' => 'Kaprog TJKT', 'icon' => '⚙️', 'badge' => 'other'],
                                'kaprog_bd' => ['label' => 'Kaprog BD', 'icon' => '🏢', 'badge' => 'other'],
                                'guru' => ['label' => 'Guru', 'icon' => '👨‍🏫', 'badge' => 'other'],
                                'pembina_ekstra' => ['label' => 'Pembina Ekstra', 'icon' => '🎭', 'badge' => 'other'],
                                'bkk' => ['label' => 'BKK', 'icon' => '💼', 'badge' => 'other'],
                                'user' => ['label' => 'User Biasa', 'icon' => '👤', 'badge' => 'user'],
                            ];
                        @endphp
                        @foreach($allRoles as $role => $info)
                            @if($usersByRole->has($role) && $usersByRole->get($role, 0) > 0)
                                <tr>
                                    <td style="width: 60%;">
                                        <span class="role-badge {{ $info['badge'] }}">
                                            {{ $info['icon'] }} {{ $info['label'] }}
                                        </span>
                                    </td>
                                    <td class="text-end" style="width: 40%;">
                                        <span class="role-count">{{ $usersByRole->get($role, 0) }}</span>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div>
        <div class="card">
            <div class="card-header bg-light border-0" style="padding: 0.6rem 0.8rem;">
                <h5 class="mb-0" style="font-size: 0.95rem;">⚡ Quick Actions</h5>
            </div>
            <div class="card-body" style="padding: 0.6rem;">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.users.index') }}" class="quick-action-btn primary">
                        <span>👥</span>
                        <span>Kelola User</span>
                    </a>
                    <a href="{{ route('admin.backup-letters.index') }}" class="quick-action-btn secondary">
                        <span>📦</span>
                        <span>Backup Surat</span>
                    </a>
                    <a href="{{ route('admin.backup.list') }}" class="quick-action-btn success">
                        <span>💾</span>
                        <span>Backup Database</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- System Information -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-light border-0" style="padding: 0.6rem 0.8rem;">
                <h5 class="mb-0" style="font-size: 0.95rem;">ℹ️ Informasi Sistem</h5>
            </div>
            <div class="card-body" style="padding: 0.6rem;">
                <div class="row g-2">
                    <div class="col-6 col-md-4">
                        <p class="text-muted mb-1" style="font-size: 0.75rem;">Laravel Version</p>
                        <p class="fw-bold mb-0" style="font-size: 0.85rem;">{{ App::version() }}</p>
                    </div>
                    <div class="col-6 col-md-4">
                        <p class="text-muted mb-1" style="font-size: 0.75rem;">PHP Version</p>
                        <p class="fw-bold mb-0" style="font-size: 0.85rem;">{{ phpversion() }}</p>
                    </div>
                    <div class="col-6 col-md-4">
                        <p class="text-muted mb-1" style="font-size: 0.75rem;">Tanggal</p>
                        <p class="fw-bold mb-0" style="font-size: 0.85rem;">{{ now()->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

