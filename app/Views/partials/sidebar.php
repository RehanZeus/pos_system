<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark h-100">
    <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <i class="bi bi-shop fs-3 me-2"></i>
        <span class="fs-4 fw-bold">POS SYSTEM</span>
    </a>
    <hr>
    
    <ul class="nav nav-pills flex-column mb-auto">
        
        <?php if(session()->get('role') === 'owner'): ?>
        <li class="nav-item">
            <a href="<?= base_url('dashboard') ?>" class="nav-link <?= uri_string() == 'dashboard' ? 'active' : 'text-white' ?>">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>
        <?php endif; ?>

        <?php if(session()->get('role') === 'owner' || session()->get('role') === 'admin'): ?>
            <li class="mt-3 mb-1 text-uppercase small text-white-50 fw-bold">Gudang</li>
            <li>
                <a href="<?= base_url('products') ?>" class="nav-link <?= uri_string() == 'products' ? 'active' : 'text-white' ?>">
                    <i class="bi bi-box-seam me-2"></i> Produk
                </a>
            </li>
            <li>
                <a href="<?= base_url('categories') ?>" class="nav-link <?= uri_string() == 'categories' ? 'active' : 'text-white' ?>">
                    <i class="bi bi-tags me-2"></i> Kategori
                </a>
            </li>
        <?php endif; ?>

        <?php if(session()->get('role') === 'owner' || session()->get('role') === 'kasir'): ?>
            <li class="mt-3 mb-1 text-uppercase small text-white-50 fw-bold">Transaksi</li>
            
            <li>
                <a href="<?= base_url('pos') ?>" class="nav-link <?= uri_string() == 'pos' ? 'active text-white' : 'text-warning' ?>">
                    <i class="bi bi-cart-check me-2"></i> Kasir (POS)
                </a>
            </li>

            <li>
                <a href="<?= base_url('reports') ?>" class="nav-link <?= uri_string() == 'reports' ? 'active' : 'text-white' ?>">
                    <i class="bi bi-journal-text me-2"></i> Laporan
                </a>
            </li>
        <?php endif; ?>

    </ul>
    
    <hr>
    
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                <?= substr(session()->get('name') ? session()->get('name') : 'U', 0, 1) ?>
            </div>
            <strong><?= session()->get('name') ?></strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
            <li><a class="dropdown-item" href="<?= base_url('logout') ?>">Sign out</a></li>
        </ul>
    </div>
</div>