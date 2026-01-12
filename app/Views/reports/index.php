<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center">
        <div class="bg-primary text-white rounded p-2 me-3 shadow-sm">
            <i class="bi bi-journal-text fs-4"></i>
        </div>
        <div>
            <h4 class="mb-0 fw-bold text-dark">Laporan Transaksi</h4>
            <small class="text-muted">Kelola riwayat dan unduh laporan</small>
        </div>
    </div>
    
    <div class="dropdown">
        <button class="btn btn-success shadow-sm px-4 py-2 fw-bold dropdown-toggle" type="button" id="exportMenu" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 8px;">
            <i class="bi bi-file-earmark-excel me-2"></i> Export Excel
        </button>
        <ul class="dropdown-menu dropdown-menu-end border-0 shadow mt-2" aria-labelledby="exportMenu" style="min-width: 260px; border-radius: 12px;">
            <li><h6 class="dropdown-header text-uppercase small text-muted fw-bold ls-1">Pilih Jenis Laporan</h6></li>
            
            <li>
                <a class="dropdown-item py-2 d-flex align-items-center" href="<?= base_url('reports/export') ?>?start_date=<?= $start_date ?>&end_date=<?= $end_date ?>" target="_blank">
                    <div class="bg-light text-success rounded p-2 me-3"><i class="bi bi-calendar-check fs-5"></i></div>
                    <div>
                        <span class="fw-bold d-block text-dark">Sesuai Filter</span>
                        <small class="text-muted" style="font-size: 11px;">
                            <?= date('d/m', strtotime($start_date)) ?> - <?= date('d/m', strtotime($end_date)) ?>
                        </small>
                    </div>
                </a>
            </li>

            <li><hr class="dropdown-divider my-2"></li>

            <li>
                <a class="dropdown-item py-2 d-flex align-items-center" href="<?= base_url('reports/export') ?>?mode=all" target="_blank" onclick="return confirm('Download semua data mungkin memakan waktu. Lanjutkan?')">
                    <div class="bg-light text-secondary rounded p-2 me-3"><i class="bi bi-database fs-5"></i></div>
                    <div>
                        <span class="fw-bold d-block text-dark">Semua Data</span>
                        <small class="text-muted" style="font-size: 11px;">Backup Full Data Toko</small>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="card mb-4 border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-body bg-white p-4">
        <form action="" method="get" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-bold text-secondary small text-uppercase">Dari Tanggal</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-calendar3"></i></span>
                    <input type="date" name="start_date" class="form-control border-start-0 bg-light" value="<?= $start_date ?>">
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold text-secondary small text-uppercase">Sampai Tanggal</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-calendar3"></i></span>
                    <input type="date" name="end_date" class="form-control border-start-0 bg-light" value="<?= $end_date ?>">
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100 fw-bold py-2 shadow-sm">
                    <i class="bi bi-search me-1"></i> Tampilkan
                </button>
            </div>
            <div class="col-md-2">
                <a href="<?= base_url('reports') ?>" class="btn btn-light w-100 text-muted border fw-bold py-2">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm text-white" style="border-radius: 12px; background: linear-gradient(135deg, #0d6efd, #0043a8);">
            <div class="card-body d-flex justify-content-between align-items-center px-4 py-3">
                <div>
                    <h6 class="mb-1 opacity-75 text-uppercase small ls-1">Total Omset Periode Ini</h6>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-calendar-range me-2 opacity-50"></i>
                        <small class="opacity-75"><?= date('d M Y', strtotime($start_date)) ?> — <?= date('d M Y', strtotime($end_date)) ?></small>
                    </div>
                </div>
                <div class="text-end">
                    <h2 class="mb-0 fw-bold">Rp <?= number_format($total_omset, 0, ',', '.') ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="border-collapse: separate; border-spacing: 0;">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-bold text-secondary border-bottom">Waktu</th>
                        <th class="py-3 text-uppercase small fw-bold text-secondary border-bottom">Invoice</th>
                        <th class="py-3 text-uppercase small fw-bold text-secondary border-bottom">Kasir</th>
                        <th class="text-end py-3 text-uppercase small fw-bold text-secondary border-bottom">Total</th>
                        <th class="text-end py-3 text-uppercase small fw-bold text-secondary border-bottom">Tunai</th>
                        <th class="text-center py-3 text-uppercase small fw-bold text-secondary border-bottom pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($sales)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted opacity-25 mb-3">
                                    <i class="bi bi-clipboard-x display-1"></i>
                                </div>
                                <h6 class="text-muted fw-bold">Tidak ada data ditemukan</h6>
                                <small class="text-muted">Silakan ubah filter tanggal di atas.</small>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($sales as $row): ?>
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark"><?= date('d/m/Y', strtotime($row['created_at'])) ?></div>
                                <small class="text-muted" style="font-size: 11px;"><?= date('H:i', strtotime($row['created_at'])) ?> WIB</small>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-2 py-1" style="font-family: monospace;">
                                    <?= $row['invoice_no'] ?>
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-2 shadow-sm" style="width: 28px; height: 28px; font-size: 11px;">
                                        <?= strtoupper(substr($row['cashier_name'], 0, 1)) ?>
                                    </div>
                                    <span class="small fw-bold text-secondary"><?= $row['cashier_name'] ?></span>
                                </div>
                            </td>
                            <td class="text-end fw-bold text-primary">
                                Rp <?= number_format($row['total_price'], 0, ',', '.') ?>
                            </td>
                            <td class="text-end text-secondary small">
                                <?= number_format($row['pay_amount'], 0, ',', '.') ?>
                            </td>
                            <td class="text-center pe-4">
                                <div class="btn-group shadow-sm" role="group">
                                    <button class="btn btn-sm btn-light border" onclick="showDetail(<?= $row['id'] ?>, '<?= $row['invoice_no'] ?>')" data-bs-toggle="tooltip" title="Lihat Detail">
                                        <i class="bi bi-eye text-primary"></i>
                                    </button>
                                    <button class="btn btn-sm btn-light border" onclick="reprintStruk('<?= $row['invoice_no'] ?>')" data-bs-toggle="tooltip" title="Cetak Struk">
                                        <i class="bi bi-printer-fill text-dark"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section('modals') ?>

<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Detail Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-light border mb-3 d-flex align-items-center">
                    <i class="bi bi-receipt me-2 text-primary"></i> 
                    <strong id="detailTitle" class="text-dark">...</strong>
                </div>
                <div class="table-responsive border rounded" style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-borderless mb-0">
                        <thead class="bg-light sticky-top">
                            <tr class="small text-uppercase text-muted">
                                <th class="ps-3 py-2">Item</th>
                                <th class="text-center py-2">Qty</th>
                                <th class="text-end pe-3 py-2">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="detailList"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0">
                <button type="button" class="btn btn-light w-100 py-2 text-muted fw-bold" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script>
    // Inisialisasi Tooltip Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    function reprintStruk(invoice) {
        let url = '<?= base_url('pos/struk') ?>/' + invoice;
        window.open(url, '_blank', 'width=400,height=600');
    }

    // Variabel Instance Modal agar tidak duplicate
    let detailModalInstance;

    async function showDetail(saleId, invoiceNo) {
        document.getElementById('detailTitle').innerText = invoiceNo;
        const tbody = document.getElementById('detailList');
        tbody.innerHTML = '<tr><td colspan="3" class="text-center py-5 text-muted"><div class="spinner-border spinner-border-sm text-primary mb-2"></div><br>Memuat data...</td></tr>';
        
        // Cek apakah instance modal sudah ada, jika belum buat baru
        const modalElement = document.getElementById('modalDetail');
        if (!detailModalInstance) {
            detailModalInstance = new bootstrap.Modal(modalElement);
        }
        detailModalInstance.show();

        try {
            let response = await fetch('<?= base_url('reports/detail') ?>/' + saleId);
            let items = await response.json();
            tbody.innerHTML = '';
            
            items.forEach(item => {
                let row = `
                    <tr class="border-bottom">
                        <td class="ps-3 py-3">
                            <div class="fw-bold text-dark">${item.name}</div>
                            <small class="text-muted" style="font-size: 11px;">${item.barcode}</small>
                        </td>
                        <td class="text-center py-3 text-secondary" style="vertical-align: middle;">
                            ${item.qty} x ${parseInt(item.price_at_time).toLocaleString('id-ID')}
                        </td>
                        <td class="text-end pe-3 py-3 fw-bold text-dark" style="vertical-align: middle;">
                            Rp ${parseInt(item.subtotal).toLocaleString('id-ID')}
                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        } catch (error) {
            tbody.innerHTML = '<tr><td colspan="3" class="text-center text-danger py-3">Gagal memuat data.</td></tr>';
        }
    }
</script>
<?= $this->endSection() ?>