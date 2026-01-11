<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Dashboard Overview</h4>
        <small class="text-muted">Halo, <strong><?= session()->get('name') ?></strong>! Berikut ringkasan performa toko hari ini.</small>
    </div>
    <div class="bg-white p-2 px-3 rounded shadow-sm border d-none d-md-block">
        <i class="bi bi-calendar-event me-2 text-primary"></i>
        <span class="fw-bold text-secondary"><?= date('d F Y') ?></span>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm text-white h-100 overflow-hidden" style="border-radius: 12px; background: linear-gradient(135deg, #0d6efd, #0043a8);">
            <div class="card-body p-4 position-relative">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="bg-white bg-opacity-25 rounded p-2">
                        <i class="bi bi-wallet2 fs-4 text-white"></i>
                    </div>
                    <span class="badge bg-white text-primary fw-bold px-3 rounded-pill">Hari Ini</span>
                </div>
                <h3 class="fw-bold mb-0">Rp <?= number_format($todays_earnings, 0, ',', '.') ?></h3>
                <small class="opacity-75">Total Pendapatan Kotor</small>
                
                <i class="bi bi-currency-dollar position-absolute" style="font-size: 8rem; right: -20px; bottom: -40px; opacity: 0.1;"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm text-dark h-100" style="border-radius: 12px; background: #fff;">
            <div class="card-body p-4 border-start border-5 border-warning position-relative">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="bg-warning bg-opacity-10 rounded p-2">
                        <i class="bi bi-receipt fs-4 text-warning"></i>
                    </div>
                    <small class="text-muted fw-bold text-uppercase">Volume</small>
                </div>
                <h3 class="fw-bold mb-0"><?= $todays_count ?></h3>
                <small class="text-muted">Transaksi Berhasil Hari Ini</small>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm text-dark h-100" style="border-radius: 12px; background: #fff;">
            <div class="card-body p-4 border-start border-5 border-success position-relative">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="bg-success bg-opacity-10 rounded p-2">
                        <i class="bi bi-box-seam fs-4 text-success"></i>
                    </div>
                    <a href="<?= base_url('products') ?>" class="text-decoration-none small fw-bold text-success">Lihat Stok <i class="bi bi-arrow-right"></i></a>
                </div>
                <h3 class="fw-bold mb-0"><?= $total_products ?></h3>
                <small class="text-muted">Total Varian Produk Aktif</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-header bg-white border-bottom-0 py-3">
                <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-graph-up-arrow me-2 text-primary"></i>Tren Omset (7 Hari Terakhir)</h6>
            </div>
            <div class="card-body pt-0">
                <canvas id="salesChart" style="max-height: 280px;"></canvas>
            </div>
        </div>

        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-header bg-white border-bottom-0 py-3 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-clock-history me-2 text-primary"></i> 5 Transaksi Terakhir</h6>
                <a href="<?= base_url('reports') ?>" class="btn btn-sm btn-light text-primary fw-bold">Laporan Penuh</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 small text-muted text-uppercase">Waktu</th>
                                <th class="py-3 small text-muted text-uppercase">Invoice</th>
                                <th class="py-3 small text-muted text-uppercase">Kasir</th>
                                <th class="py-3 text-end pe-4 small text-muted text-uppercase">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($recent_sales)): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">Belum ada transaksi hari ini.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($recent_sales as $sale): ?>
                                <tr>
                                    <td class="ps-4">
                                        <span class="fw-bold text-dark"><?= date('H:i', strtotime($sale['created_at'])) ?></span>
                                        <small class="text-muted ms-1" style="font-size: 10px;"><?= date('d/m', strtotime($sale['created_at'])) ?></small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-secondary border" style="font-family: monospace;"><?= $sale['invoice_no'] ?></span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-2" style="width: 25px; height: 25px; font-size: 10px;">
                                                <?= strtoupper(substr($sale['cashier_name'], 0, 1)) ?>
                                            </div>
                                            <small class="fw-bold text-secondary"><?= $sale['cashier_name'] ?></small>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4 fw-bold text-success">
                                        + Rp <?= number_format($sale['total_price'], 0, ',', '.') ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="row g-2 mb-4">
            <div class="col-6">
                <a href="<?= base_url('pos') ?>" class="btn btn-primary w-100 p-3 shadow-sm border-0" style="border-radius: 12px; background: linear-gradient(to right, #0d6efd, #0b5ed7);">
                    <i class="bi bi-cart-plus fs-3 mb-2 d-block"></i>
                    <span class="fw-bold small">KASIR BARU</span>
                </a>
            </div>
            <div class="col-6">
                <a href="<?= base_url('products') ?>" class="btn btn-white w-100 p-3 shadow-sm border" style="border-radius: 12px;">
                    <i class="bi bi-box-seam fs-3 mb-2 d-block text-secondary"></i>
                    <span class="fw-bold small text-secondary">STOK</span>
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-white border-bottom-0 py-3 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-danger"><i class="bi bi-exclamation-circle-fill me-2"></i> Stok Menipis</h6>
                <small class="text-muted" style="font-size: 11px;">(Sisa &le; 5)</small>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <?php if(empty($low_stock)): ?>
                        <li class="list-group-item text-center py-5 text-muted border-0">
                            <i class="bi bi-check-circle fs-1 text-success opacity-50 mb-2"></i><br>
                            Semua stok aman
                        </li>
                    <?php else: ?>
                        <?php foreach($low_stock as $prod): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3 px-3 border-light">
                            <div>
                                <div class="fw-bold text-dark text-truncate" style="max-width: 150px;"><?= esc($prod['name']) ?></div>
                                <small class="text-muted" style="font-size: 11px; font-family: monospace;"><?= esc($prod['barcode']) ?></small>
                            </div>
                            <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">
                                Sisa: <?= $prod['stock'] ?>
                            </span>
                        </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
            <?php if(!empty($low_stock)): ?>
            <div class="card-footer bg-white border-top-0 p-3">
                <a href="<?= base_url('products') ?>" class="btn btn-light btn-sm w-100 text-danger fw-bold">Kelola Stok Sekarang</a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= $chart_labels ?>, // Data Label Tanggal
            datasets: [{
                label: 'Omset (Rp)',
                data: <?= $chart_data ?>, // Data Total Uang
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                borderWidth: 2,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#0d6efd',
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) { label += ': '; }
                            if (context.parsed.y !== null) {
                                label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { borderDash: [2, 4], color: '#f0f0f0' },
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + (value / 1000) + 'k';
                        }
                    }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
</script>

<?= $this->endSection() ?>