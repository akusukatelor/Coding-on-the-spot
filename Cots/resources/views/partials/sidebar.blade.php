<div class="bg-white border-end" id="sidebar-wrapper" style="width: 260px; min-height: 100vh;">
    <div class="p-4">
        <h3 class="text-success fw-bold">SIHEMAT</h3>
    </div>
    <div class="list-group list-group-flush px-3">
        <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action border-0 py-3 rounded-3 mb-1 {{ request()->is('/') ? 'active bg-light text-success fw-bold' : 'text-muted' }}">
            <i class="bi bi-grid-fill me-2"></i> Dashboard
        </a>
        <a href="#" class="list-group-item list-group-item-action border-0 py-3 rounded-3 mb-1 text-muted">
            <i class="bi bi-wallet2 me-2"></i> Transaksi
        </a>
        <a href="#" class="list-group-item list-group-item-action border-0 py-3 rounded-3 mb-1 text-muted">
            <i class="bi bi-tags me-2"></i> Kategori
        </a>
        <a href="#" class="list-group-item list-group-item-action border-0 py-3 rounded-3 mb-1 text-muted">
            <i class="bi bi-file-earmark-bar-graph me-2"></i> Laporan
        </a>
    </div>
    <div class="mt-auto p-4 position-absolute bottom-0">
        <a href="#" class="text-danger text-decoration-none"><i class="bi bi-box-arrow-left me-2"></i> Keluar</a>
    </div>
</div>