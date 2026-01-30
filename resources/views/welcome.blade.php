<!-- filepath: d:\laragon\www\EsuratGlobalitiB\resources\views\welcome.blade.php -->

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Surat - Sistem Manajemen Surat Elektronik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .welcome-container {
            background: white;
            border-radius: 12px;
            padding: 48px;
            box-shadow: 0 8px 28px rgba(0,0,0,0.16);
            text-align: center;
            max-width: 520px;
            width: 100%;
        }
        .welcome-logo {
            margin-bottom: 18px;
        }
        .welcome-logo img {
            max-width: 140px;
            height: auto;
            display: inline-block;
        }
        h1 {
            color: #333;
            margin-bottom: 6px;
            font-size: 1.35rem;
        }
        .welcome-description {
            color: #666;
            margin-bottom: 20px;
        }

        /* Mobile tweaks */
        @media (max-width: 576px) {
            body { padding: 12px; }
            .welcome-container {
                padding: 20px;
                border-radius: 10px;
                max-width: 420px;
            }
            .welcome-logo img { max-width: 120px; }
            h1 { font-size: 1.15rem; }
            .welcome-description { font-size: 0.95rem; margin-bottom: 16px; }
            .welcome-container .btn { width: 100%; padding: 10px 14px; font-size: 1rem; }
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <!-- Ganti emoji dengan gambar logo -->
        <div class="welcome-logo">
            <img src="{{ asset('images/logosmk.png') }}" alt="E-Surat Logo">
        </div>
        
        <h1>Sistem Manajemen Persuratan</h1>
        <p class="welcome-description">SMK TI BALI GLOBAL BADUNG</p>
        
        @auth
            <p>Selamat datang, {{ auth()->user()->name }}!</p>
            <div class="mt-4">
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-lg">📊 Ke Dashboard</a>
                @else
                    <a href="{{ route('surat-masuk.index') }}" class="btn btn-primary btn-lg">📨 Ke Surat Masuk</a>
                @endif
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-lg">Logout</button>
                    </form>
            </div>
        @else
            <p>Platform digital untuk mengelola surat masuk dan keluar dengan lebih efisien.</p>
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Login</a>
        @endauth
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>