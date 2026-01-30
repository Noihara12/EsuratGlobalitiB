<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Surat')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4A7BA7;
            --secondary-color: #F4A460;
        }
        body {
            background-color: #f5f5f5;
        }
        .navbar {
            background-color: var(--primary-color);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1030;
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.3rem;
        }
        .sidebar {
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
            min-height: calc(100vh - 56px);
            padding: 0;
            position: relative;
            z-index: 1020;
            display: flex;
            flex-direction: column;
        }
        .sidebar .nav {
            padding: 10px 0;
            flex: 1 1 auto;
        }
        .sidebar .nav-link {
            color: #495057;
            padding: 12px 20px;
            border-left: 4px solid transparent;
            margin: 0;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar .nav-link:hover {
            background-color: #e9ecef;
            border-left-color: var(--primary-color);
            color: var(--primary-color);
            padding-left: 22px;
        }
        .sidebar .nav-link.active {
            background-color: #e8f0f7;
            border-left-color: var(--primary-color);
            color: var(--primary-color);
            font-weight: 600;
        }
        .sidebar .collapse {
            background-color: #ffffff;
        }
        .sidebar .collapse .nav-link {
            padding: 10px 20px 10px 40px;
            font-size: 0.9rem;
            border-left: 4px solid transparent;
        }
        .sidebar .collapse .nav-link:hover {
            background-color: #f0f0f0;
            border-left-color: var(--secondary-color);
            padding-left: 42px;
        }
        .sidebar .collapse .nav-link.active {
            background-color: #f0f0f0;
            border-left-color: var(--secondary-color);
            color: var(--secondary-color);
        }
        .sidebar .nav-link i {
            transition: transform 0.3s ease;
        }
        .sidebar .nav-link[data-bs-toggle="collapse"][aria-expanded="true"] i {
            transform: rotate(180deg);
        }
        .sidebar .menu-divider {
            height: 1px;
            background-color: #dee2e6;
            margin: 10px 0;
        }
        .sidebar .menu-label {
            padding: 10px 20px;
            font-size: 0.75rem;
            font-weight: 700;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 10px;
            margin-bottom: 5px;
        }
        .main-content {
            padding: 20px;
        }
        .card {
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        /* Page header and filter improvements for Arsip / Laporan */
        .page-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
        }
        .page-header h1 {
            font-size: 1.25rem;
            margin: 0;
        }
        .filter-card .card-body {
            padding: 14px;
        }
        /* Make form controls and buttons flow vertically on small screens */
        .filter-card .form-control,
        .filter-card .btn,
        .filter-card .input-group {
            width: 100%;
            margin-bottom: 8px;
        }
        /* On larger screens keep controls inline */
        @media (min-width: 768px) {
            .filter-card .form-control,
            .filter-card .input-group { width: auto; display: inline-block; margin-bottom: 0; }
            .filter-card .btn { display: inline-block; margin-left: 6px; margin-bottom: 0; }
            .page-header h1 { font-size: 1.45rem; }
        }
        /* spacing under navbar so content doesn't feel squashed on mobile */
        @media (max-width: 767.98px) {
            .main-content { padding-top: 10px; }
            .pagination { flex-wrap: wrap; gap: 0.25rem; }
            .pagination .page-item { margin: 0.25rem 0; }
            .pagination .page-link { padding: 0.5rem 0.75rem; font-size: 0.9rem; }
        }
        /* Responsive pagination for mobile */
        @media (max-width: 767.98px) {
            .pagination { flex-wrap: wrap; gap: 0.25rem; }
            .pagination .page-item { margin: 0.25rem 0; }
            .pagination .page-link { padding: 0.5rem 0.75rem; font-size: 0.9rem; }
            .pagination .page-item .page-link { min-width: 36px; text-align: center; }
        }
        /* Compact previous/next buttons on mobile to save horizontal space */
        @media (max-width: 767.98px) {
            .pagination .page-item:first-child .page-link,
            .pagination .page-item:last-child .page-link {
                padding: 0.25rem 0.35rem;
                min-width: 36px;
                width: 36px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 0; /* hide original text visually */
            }
            .pagination .page-item:first-child .page-link::after {
                content: "←";
                font-size: 0.95rem;
                color: inherit;
            }
            .pagination .page-item:last-child .page-link::after {
                content: "→";
                font-size: 0.95rem;
                color: inherit;
            }
        }
        .btn-primary:hover {
            background-color: #3a5f87;
            border-color: #3a5f87;
        }
        .badge-status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: bold;
        }
        .status-draft { background-color: #e2e3e5; color: #383d41; }
        .status-submitted { background-color: #fff3cd; color: #856404; }
        .status-disposed { background-color: #d1ecf1; color: #0c5460; }
        .status-received { background-color: #d4edda; color: #155724; }
        .status-published { background-color: #cfe2ff; color: #084298; }
        .status-pending { background-color: #fff3cd; color: #856404; }
        .status-in_progress { background-color: #d1ecf1; color: #0c5460; }
        .status-completed { background-color: #d4edda; color: #155724; }
        .status-diarsip { background-color: #6f42c1; color: #ffffff; }
        .jenis-rahasia { color: #dc3545; font-weight: bold; }
        .jenis-penting { color: #ff6b6b; font-weight: bold; }
        .jenis-biasa { color: #6c757d; }

        /* Mobile / off-canvas sidebar rules */
        .sidebar-wrapper { position: relative; }
        .sidebar-avatar { width:36px; height:36px; border-radius:50%; object-fit:cover; display:block; }
        .sidebar-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.45); z-index: 1045; display: none; }

        /* default: hide toggle until mobile */
        #sidebarToggle { display: none; }

        @media (max-width: 767.98px) {
            /* collapse the left column visually but keep it rendered so fixed sidebar can be shown */
            .row > .col-md-3 { max-width: 0 !important; flex: 0 0 0 !important; padding-left: 0 !important; padding-right: 0 !important; }
            .row > .col-md-9 { width: 100% !important; flex: 0 0 100% !important; max-width: 100% !important; }

            /* off-canvas sidebar */
            .sidebar {
                position: fixed !important;
                left: 0 !important;
                top: 56px !important;
                width: 260px !important;
                height: calc(100vh - 56px) !important;
                transform: translateX(-110%) !important;
                transition: transform .28s ease !important;
                z-index: 1046 !important;
                box-shadow: 2px 0 12px rgba(0,0,0,0.12) !important;
            }
            body.sidebar-open .sidebar { transform: translateX(0) !important; }

            /* show toggle on mobile */
            #sidebarToggle { display: inline-flex !important; }
            .sidebar-overlay.show { display: block; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <div class="brand-stack">
                <a class="navbar-brand" href="{{ auth()->check() ? (auth()->user()->role === 'admin' ? route('admin.dashboard') : route('surat-masuk.index')) : '/' }}"><img src="{{ asset('images/logosmk1.png') }}" alt="Logo SMK TI Bali Global Badung" style="max-width: 40px; height: auto; margin-right: 10px;">Sistem Manajemen Persuratan</a>
                <div class="d-md-none mt-2">
                    <button id="sidebarToggle" class="btn btn-outline-light" aria-label="Toggle sidebar" aria-expanded="false">☰</button>
                </div>
            </div>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    @auth
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="sidebar-wrapper">
                        <div class="sidebar" id="appSidebar">
                        <nav class="nav flex-column">
                            @php
                                        $tuRoles = ['tu', 'ka_tu'];
                                        $userRoles = ['staff', 'wakasek_kurikulum', 'wakasek_sarana_prasarana', 'wakasek_kesiswaan', 'wakasek_humas', 'kaprog_dkv', 'kaprog_pplg', 'kaprog_tjkt', 'kaprog_bd', 'guru', 'pembina_ekstra', 'bkk'];
                                    @endphp

                                    <div class="sidebar-user p-3 border-bottom">
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                <img src="{{ asset('images/user-avatar.png') }}" alt="logo" style="width:36px; height:auto;">
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="fw-bold">{{ auth()->user()->name }}</div>
                                                <div class="text-muted" style="font-size:0.85rem">{{ auth()->user()->role }}</div>
                                            </div>
                                            <div></div>
                                        </div>
                                    </div>

                                    @if(in_array(auth()->user()->role, $tuRoles))
                                <a class="nav-link {{ request()->routeIs('surat-masuk.index') && request()->query('filter') !== 'diterima' ? 'active' : '' }}" href="{{ route('surat-masuk.index') }}">📨 Surat Masuk</a>
                                <a class="nav-link {{ request()->routeIs('surat-masuk.index') && request()->query('filter') === 'diterima' ? 'active' : '' }}" href="{{ route('surat-masuk.index', ['filter' => 'diterima']) }}">📨 Surat Masuk (Diterima)</a>
                                <a class="nav-link {{ request()->routeIs('surat-keluar*') ? 'active' : '' }}" href="{{ route('surat-keluar.index') }}">📤 Surat Keluar</a>
                                <a class="nav-link {{ request()->routeIs('arsip*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#arsipMenuTU" role="button" aria-expanded="{{ request()->routeIs('arsip*') ? 'true' : 'false' }}">📦 Arsip <i class="bi bi-chevron-down ms-auto"></i></a>
                                <div class="collapse {{ request()->routeIs('arsip*') ? 'show' : '' }}" id="arsipMenuTU">
                                    <a class="nav-link {{ request()->routeIs('arsip.surat-masuk') ? 'active' : '' }}" href="{{ route('arsip.surat-masuk') }}">Surat Masuk</a>
                                    <a class="nav-link {{ request()->routeIs('arsip.surat-keluar') ? 'active' : '' }}" href="{{ route('arsip.surat-keluar') }}">Surat Keluar</a>
                                </div>
                                <a class="nav-link {{ request()->routeIs('laporan*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#laporanMenuTU" role="button" aria-expanded="{{ request()->routeIs('laporan*') ? 'true' : 'false' }}">📊 Laporan <i class="bi bi-chevron-down ms-auto"></i></a>
                                <div class="collapse {{ request()->routeIs('laporan*') ? 'show' : '' }}" id="laporanMenuTU">
                                    <a class="nav-link {{ request()->routeIs('laporan.surat-masuk') ? 'active' : '' }}" href="{{ route('laporan.surat-masuk') }}">Surat Masuk</a>
                                    <a class="nav-link {{ request()->routeIs('laporan.surat-keluar') ? 'active' : '' }}" href="{{ route('laporan.surat-keluar') }}">Surat Keluar</a>
                                </div>
                            @elseif(auth()->user()->role === 'kepala_sekolah')
                                <a class="nav-link {{ request()->routeIs('surat-masuk*') && !request()->routeIs('tanda-tangan*') ? 'active' : '' }}" href="{{ route('surat-masuk.index') }}">📨 Surat Masuk (Disposisi)</a>
                                <a class="nav-link {{ request()->routeIs('tanda-tangan*') ? 'active' : '' }}" href="{{ route('tanda-tangan.index') }}">🖊️ Registrasi Tanda Tangan</a>
                            @elseif(in_array(auth()->user()->role, $userRoles))
                                <a class="nav-link {{ request()->routeIs('surat-masuk*') ? 'active' : '' }}" href="{{ route('surat-masuk.index') }}">📨 Surat Masuk (Diterima)</a>
                                <a class="nav-link {{ request()->routeIs('surat-keluar*') ? 'active' : '' }}" href="{{ route('surat-keluar.index') }}">📤 Surat Keluar</a>
                            @endif

                            @if(auth()->user()->role === 'admin')
                                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
                                <a class="nav-link {{ request()->routeIs('surat-masuk*') ? 'active' : '' }}" href="{{ route('surat-masuk.index') }}">📨 Surat Masuk</a>
                                <a class="nav-link {{ request()->routeIs('surat-keluar*') ? 'active' : '' }}" href="{{ route('surat-keluar.index') }}">📤 Surat Keluar</a>
                                <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">👥 Kelola User</a>
                                <a class="nav-link {{ request()->routeIs('admin.backup*') ? 'active' : '' }}" href="{{ route('admin.backup.list') }}">💾 Backup Database</a>
                                <a class="nav-link {{ request()->routeIs('admin.backup-letters*') ? 'active' : '' }}" href="{{ route('admin.backup-letters.index') }}">📦 Backup Surat</a>
                            @endif
                            
                            <!-- Sidebar footer: logout placed at bottom -->
                            <div class="sidebar-footer border-top p-3 mt-3">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger w-100">⎋ Logout</button>
                                </form>
                            </div>
                        </nav>
                        </div>
                        <div id="sidebarOverlay" class="sidebar-overlay"></div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="main-content">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="main-content">
            @yield('content')
        </div>
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function(){
            var toggle = document.getElementById('sidebarToggle');
            var overlay = document.getElementById('sidebarOverlay');
            var body = document.body;

            function setOpen(open) {
                if (open) {
                    body.classList.add('sidebar-open');
                    if (overlay) overlay.style.display = 'block';
                    if (toggle) toggle.setAttribute('aria-expanded','true');
                } else {
                    body.classList.remove('sidebar-open');
                    if (overlay) overlay.style.display = 'none';
                    if (toggle) toggle.setAttribute('aria-expanded','false');
                }
            }

            if (toggle) {
                toggle.addEventListener('click', function(e){ e.preventDefault(); setOpen(!body.classList.contains('sidebar-open')); });
            }
            if (overlay) overlay.addEventListener('click', function(){ setOpen(false); });

            // close sidebar when clicking a navigational menu link on mobile
            var sidebarLinks = document.querySelectorAll('#appSidebar .nav-link');
            sidebarLinks.forEach(function(link){
                link.addEventListener('click', function(e){
                    // ignore collapse toggles (they use data-bs-toggle or href starting with '#')
                    var isToggle = link.hasAttribute('data-bs-toggle') || (link.getAttribute('href') || '').startsWith('#');
                    if (!isToggle && window.innerWidth <= 767.98) {
                        setOpen(false);
                    }
                });
            });

            // close on resize to desktop
            window.addEventListener('resize', function(){ if (window.innerWidth > 767.98) setOpen(false); });
        })();
    </script>
    <script>
        // Limit visible pagination numbers: 4 on mobile, 10 on desktop
        (function(){
            function limitPagination(pagination, maxVisible) {
                maxVisible = maxVisible || 5;
                // remove any previously inserted ellipses
                pagination.querySelectorAll('.js-ellipsis').forEach(function(n){ n.remove(); });

                var numberItems = Array.from(pagination.querySelectorAll('.page-item')).filter(function(li){
                    var txt = (li.textContent||'').trim();
                    return /^\d+$/.test(txt);
                });
                if (numberItems.length <= maxVisible) return;

                var activeIndex = numberItems.findIndex(function(li){ return li.classList.contains('active'); });
                if (activeIndex === -1) {
                    // if none active, prefer start
                    activeIndex = 0;
                }

                var half = Math.floor(maxVisible/2);
                var start = Math.max(0, activeIndex - half);
                if (start + maxVisible > numberItems.length) start = numberItems.length - maxVisible;
                var end = start + maxVisible - 1;

                numberItems.forEach(function(li, idx){
                    if (idx < start || idx > end) li.classList.add('d-none'); else li.classList.remove('d-none');
                });

                // insert ellipses before/after visible range if needed
                var firstVisible = numberItems[start];
                var lastVisible = numberItems[end];

                if (start > 0) {
                    var ell = document.createElement('li');
                    ell.className = 'page-item disabled js-ellipsis';
                    ell.innerHTML = '<span class="page-link">…</span>';
                    firstVisible.parentElement.insertBefore(ell, firstVisible);
                }
                if (end < numberItems.length - 1) {
                    var ell2 = document.createElement('li');
                    ell2.className = 'page-item disabled js-ellipsis';
                    ell2.innerHTML = '<span class="page-link">…</span>';
                    if (lastVisible.nextSibling) lastVisible.parentElement.insertBefore(ell2, lastVisible.nextSibling);
                    else lastVisible.parentElement.appendChild(ell2);
                }
            }

            function applyLimits() {
                var maxVisible = (window.innerWidth <= 767.98) ? 4 : 10;
                document.querySelectorAll('.pagination').forEach(function(p){
                    limitPagination(p, maxVisible);
                });
            }

            if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', applyLimits);
            else applyLimits();
            // Re-apply on window resize
            var resizeTimer;
            window.addEventListener('resize', function(){ clearTimeout(resizeTimer); resizeTimer = setTimeout(applyLimits, 120); });
        })();
    </script>
    <script>
        // Password visibility toggles: any button with .password-toggle toggles its target input
        (function(){
            var eyeSvg = '<img src="https://img.icons8.com/?size=100&id=KJa1vG6vZTIQ&format=png&color=000000" style="width:16px;height:16px;display:block;" alt="show" />';
            var eyeSlashSvg = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true"><path d="M13.359 11.238 15 12.879l-1.121 1.121-1.641-1.64A8.14 8.14 0 0 1 8 13.5C3 13.5 0 8 0 8a15.28 15.28 0 0 1 2.03-2.52L.353 2.646 1.475 1.525l13 13L13.359 11.238zM11.64 9.522A3.5 3.5 0 0 1 6.478 4.36l1.07 1.07a2.5 2.5 0 0 0 3.092 3.092l.001.001z"/></svg>';

            function setIcon(btn, open) {
                try { btn.innerHTML = open ? eyeSlashSvg : eyeSvg; } catch(e){}
            }

            function togglePassword(btn) {
                var targetSelector = btn.getAttribute('data-target');
                if (!targetSelector) return;
                var input = document.querySelector(targetSelector);
                if (!input) return;
                if (input.type === 'password') {
                    input.type = 'text';
                    setIcon(btn, true);
                    btn.setAttribute('aria-pressed', 'true');
                } else {
                    input.type = 'password';
                    setIcon(btn, false);
                    btn.setAttribute('aria-pressed', 'false');
                }
                input.focus();
            }

            // initialize icons (in case buttons were added server-side)
            document.addEventListener('DOMContentLoaded', function(){
                document.querySelectorAll('.password-toggle').forEach(function(btn){ setIcon(btn, false); });
            });

            document.addEventListener('click', function(e){
                var btn = e.target.closest && e.target.closest('.password-toggle');
                if (btn) {
                    e.preventDefault();
                    togglePassword(btn);
                }
            });
        })();
    </script>
    @stack('scripts')
</body>
</html>
