<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - SIMAMAT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .sidebar { width: 260px; height: 100vh; position: fixed; background: #fff; border-right: 1px solid #e2e8f0; z-index: 100; }
        .main-content { margin-left: 260px; padding: 2rem; }
        .nav-link { color: #64748b; padding: 0.8rem 1.5rem; border-radius: 10px; margin-bottom: 5px; transition: 0.3s; }
        .nav-link:hover { background: #f1f5f9; color: #10b981; }
        .nav-link.active { background: #ecfdf5; color: #10b981; font-weight: 600; }
        .card { border: none; border-radius: 20px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        /* Warna untuk Tombol Toggle di Modal */
    .active-expense {
        background-color: #fee2e2 !important; /* Merah muda lembut */
        color: #b91c1c !important;
        border: 1px solid #fecaca !important;
    }
    .active-income {
        background-color: #e0f2fe !important; /* Biru muda lembut */
        color: #0369a1 !important;
        border: 1px solid #bae6fd !important;
    }
        .btn-outline-secondary:hover {
            background-color: #f3f4f6;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar d-flex flex-column p-4">
        <h3 class="text-success fw-bold mb-5 px-3">SIHEMAT</h3>
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/"><i class="bi bi-grid-fill me-2"></i> Dashboard</a>
            <a class="nav-link {{ request()->is('transaksi') ? 'active' : '' }}" href="{{ route('transaksi') }}"><i class="bi bi-wallet2 me-2"></i> Transaksi</a>
            <a class="nav-link {{ request()->is('kategori') ? 'active' : '' }}" href="{{ route('kategori') }}"><i class="bi bi-tags me-2"></i> Kategori</a>
            <a class="nav-link {{ request()->is('laporan') ? 'active' : '' }}" href="{{ route('laporan') }}"><i class="bi bi-bar-chart me-2"></i> Laporan</a>
        </nav>
        <div class="mt-auto px-3">
            <a href="{{ route('logout') }}" class="text-danger text-decoration-none small fw-bold"><i class="bi bi-box-arrow-left me-2"></i> Keluar</a>
        </div>
        
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div class="input-group w-50">
                <span class="input-group-text bg-white border-0 shadow-sm"><i class="bi bi-search text-muted"></i></span>
                <input type="text" class="form-control border-0 shadow-sm" placeholder="Cari transaksi...">
            </div>
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-bell fs-5 text-muted"></i>
                <div class="vr mx-2"></div>
                <img src="https://ui-avatars.com/api/?name=User&background=10b981&color=fff" class="rounded-circle" width="40">
            </div>
        </div>

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>