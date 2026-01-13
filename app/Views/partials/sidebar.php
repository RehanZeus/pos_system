<div class="d-flex flex-column h-100 text-white">

    <!-- BRAND -->
    <div class="px-4 py-3 border-bottom border-secondary border-opacity-25">
        <div class="d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 rounded-circle d-flex justify-content-center align-items-center me-3"
                 style="width: 40px; height: 40px;">
                <i class="bi bi-shop fs-4 text-primary"></i>
            </div>
            <span class="fw-bold text-white">POS SYSTEM</span>
        </div>
    </div>

    <!-- MENU -->
    <?php
        $uri = service('uri')->getSegment(1);
        function activeMenu($target, $current) {
            return $target === $current ? 'active' : '';
        }
    ?>

    <ul class="nav nav-pills flex-column px-3 mt-3 gap-1">

        <?php if(session()->get('role') === 'owner'): ?>
        <li class="nav-item">
            <a href="<?= base_url('dashboard') ?>" class="nav-link <?= activeMenu('dashboard', $uri) ?>">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>
        <?php endif; ?>

        <?php if(in_array(session()->get('role'), ['owner','admin'])): ?>
            <li class="nav-item">
                <a href="<?= base_url('products') ?>" class="nav-link <?= activeMenu('products', $uri) ?>">
                    <i class="bi bi-box-seam me-2"></i> Produk
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('categories') ?>" class="nav-link <?= activeMenu('categories', $uri) ?>">
                    <i class="bi bi-tags me-2"></i> Kategori
                </a>
            </li>
        <?php endif; ?>

        <?php if(in_array(session()->get('role'), ['owner','kasir'])): ?>
            <li class="nav-item mt-2">
                <a href="<?= base_url('pos') ?>" class="nav-link <?= activeMenu('pos', $uri) ?>">
                    <i class="bi bi-cart-check me-2"></i> Kasir (POS)
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('reports') ?>" class="nav-link <?= activeMenu('reports', $uri) ?>">
                    <i class="bi bi-journal-text me-2"></i> Laporan
                </a>
            </li>
        <?php endif; ?>

        <!-- USERS (OWNER ONLY, DI BAWAH LAPORAN) -->
        <?php if(session()->get('role') === 'owner'): ?>
            <li class="nav-item mt-2">
                <a href="<?= base_url('users') ?>" class="nav-link <?= activeMenu('users', $uri) ?>">
                    <i class="bi bi-people me-2"></i> Users
                </a>
            </li>
        <?php endif; ?>

    </ul>

    <!-- PROFILE (BOTTOM) -->
    <div class="mt-auto px-3 py-3 border-top border-secondary border-opacity-25">

        <div class="dropdown">
            <a href="#"
               class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
               data-bs-toggle="dropdown">

                <div class="bg-primary rounded-circle d-flex justify-content-center align-items-center me-2"
                     style="width: 34px; height: 34px; font-size: 14px;">
                    <?= strtoupper(substr(session()->get('name') ?: 'U', 0, 1)) ?>
                </div>

                <div class="small">
                    <div class="fw-bold"><?= esc(session()->get('name')) ?></div>
                    <div class="text-muted" style="font-size: 11px;">
                        <?= esc(session()->get('role')) ?>
                    </div>
                </div>
            </a>

            <ul class="dropdown-menu dropdown-menu-dark w-100 shadow">
                <li>
                    <a class="dropdown-item text-danger"
                       href="<?= base_url('logout') ?>"
                       onclick="return confirm('Yakin ingin logout?')">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </a>
                </li>
            </ul>
        </div>

    </div>

</div>
