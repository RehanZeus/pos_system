<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center">
        <div class="bg-primary text-white rounded p-2 me-3 shadow-sm">
            <i class="bi bi-box-seam fs-4"></i>
        </div>
        <div>
            <h4 class="mb-0 fw-bold text-dark">Data Produk & Stok</h4>
            <small class="text-muted">Kelola inventaris, harga modal, dan profit</small>
        </div>
    </div>
    
    <button class="btn btn-primary fw-bold px-4 shadow-sm" style="border-radius: 8px;" onclick="openModal('add')">
        <i class="bi bi-plus-lg me-2"></i> Tambah Produk
    </button>
</div>

<div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
    <div class="card-body p-3">
        <div class="input-group">
            <span class="input-group-text bg-white border-0 ps-3"><i class="bi bi-search text-muted"></i></span>
            <input type="text" id="searchInput" class="form-control border-0 bg-white shadow-none fw-bold" placeholder="Cari Nama Produk, Barcode, atau Kategori..." onkeyup="filterTable()">
        </div>
    </div>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success border-0 shadow-sm mb-4 d-flex align-items-center">
        <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger border-0 shadow-sm mb-4 d-flex align-items-center">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="productTable">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-bold text-secondary border-bottom">Produk</th>
                        <th class="py-3 text-uppercase small fw-bold text-secondary border-bottom">Kategori</th>
                        <th class="text-end py-3 text-uppercase small fw-bold text-secondary border-bottom">Modal (Beli)</th>
                        <th class="text-end py-3 text-uppercase small fw-bold text-secondary border-bottom">Harga Jual</th>
                        <th class="text-end py-3 text-uppercase small fw-bold text-secondary border-bottom">Profit</th>
                        <th class="text-center py-3 text-uppercase small fw-bold text-secondary border-bottom">Stok</th>
                        <th class="text-center py-3 text-uppercase small fw-bold text-secondary border-bottom pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($products)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted opacity-25 mb-3"><i class="bi bi-box2 display-4"></i></div>
                                <h6 class="text-muted fw-bold">Data Produk Kosong</h6>
                                <small class="text-muted">Klik tombol tambah untuk memulai.</small>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($products as $row): ?>
                        <?php 
                            // LOGIKA PROFIT
                            $modal = $row['purchase_price'];
                            $jual  = $row['price'];
                            $profit = $jual - $modal;
                            
                            // LOGIKA GAMBAR
                            $img = $row['image'] ? 'uploads/products/'.$row['image'] : 'https://via.placeholder.com/50?text=IMG';
                        ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <img src="<?= base_url($img) ?>" class="rounded border me-3" width="45" height="45" style="object-fit: cover;">
                                    <div>
                                        <div class="fw-bold text-dark"><?= esc($row['name']) ?></div>
                                        <div class="badge bg-light text-secondary border" style="font-family: monospace; font-size: 10px;">
                                            <i class="bi bi-upc me-1"></i><?= esc($row['barcode']) ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info bg-opacity-10 text-info fw-bold px-2 py-1">
                                    <?= esc($row['category_name']) ?>
                                </span>
                            </td>
                            <td class="text-end text-secondary small">
                                Rp <?= number_format($modal, 0,',','.') ?>
                            </td>
                            <td class="text-end fw-bold text-primary">
                                Rp <?= number_format($jual, 0,',','.') ?>
                            </td>
                            <td class="text-end fw-bold <?= $profit >= 0 ? 'text-success' : 'text-danger' ?>">
                                <?= $profit >= 0 ? '+' : '' ?>Rp <?= number_format($profit, 0,',','.') ?>
                            </td>
                            <td class="text-center">
                                <?php $stokClass = ($row['stock'] <= 5) ? 'bg-danger' : 'bg-success'; ?>
                                <span class="badge <?= $stokClass ?> rounded-pill px-3">
                                    <?= $row['stock'] ?>
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="btn-group shadow-sm">
                                    <button class="btn btn-sm btn-light border text-primary" 
                                            onclick='openModal("edit", <?= json_encode($row) ?>)'
                                            data-bs-toggle="tooltip" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <a href="<?= base_url('products/delete/'.$row['id']) ?>" 
                                       class="btn btn-sm btn-light border text-danger" 
                                       onclick="return confirm('Hapus produk ini beserta gambar?')" 
                                       data-bs-toggle="tooltip" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </a>
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

<div class="modal fade" id="modalProduct" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold" id="modalTitle">Tambah Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <form action="<?= base_url('products/store') ?>" method="post" enctype="multipart/form-data" id="prodForm">
                <div class="modal-body">
                    <input type="hidden" name="id" id="prodId">
                    <input type="hidden" name="old_image" id="oldImage">

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small text-uppercase fw-bold text-muted">Barcode</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-upc"></i></span>
                                <input type="text" name="barcode" id="barcode" class="form-control bg-light border-start-0" placeholder="Scan / Input" required>
                                <button type="button" class="btn btn-outline-secondary" onclick="generateBarcode()" title="Buat Barcode Acak"><i class="bi bi-magic"></i> Auto</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-uppercase fw-bold text-muted">Kategori</label>
                            <select name="category_id" id="catId" class="form-select bg-light" required>
                                <option value="">-- Pilih --</option>
                                <?php foreach($categories as $c): ?>
                                    <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-uppercase fw-bold text-muted">Nama Produk</label>
                        <input type="text" name="name" id="name" class="form-control bg-light" placeholder="Contoh: Kopi Susu Gula Aren" required>
                    </div>

                    <div class="p-3 bg-light border rounded mb-3" style="border-radius: 8px;">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label small text-uppercase fw-bold text-danger">Harga Beli (Modal)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">Rp</span>
                                    <input type="number" name="purchase_price" id="purchase_price" class="form-control bg-white border-start-0" placeholder="0">
                                </div>
                                <small class="text-muted" style="font-size:10px">Harga dari supplier</small>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-uppercase fw-bold text-primary">Harga Jual</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">Rp</span>
                                    <input type="number" name="price" id="price" class="form-control bg-white border-start-0 fw-bold" placeholder="0" required>
                                </div>
                                <small class="text-muted" style="font-size:10px">Harga ke pelanggan</small>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-uppercase fw-bold text-muted">Stok Awal</label>
                                <input type="number" name="stock" id="stock" class="form-control bg-white" value="0">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small text-uppercase fw-bold text-muted">Gambar Produk (Opsional)</label>
                        <input type="file" name="image" class="form-control">
                        <small class="text-muted">Format: JPG, PNG, JPEG.</small>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light w-100 py-2 text-muted fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // 1. GENERATE BARCODE OTOMATIS
    function generateBarcode() {
        let random = Math.floor(Math.random() * 89999999) + 10000000;
        document.getElementById('barcode').value = random;
    }

    // 2. BUKA MODAL (UNIFIED FUNCTION)
    function openModal(type, data = null) {
        const modal = new bootstrap.Modal(document.getElementById('modalProduct'));
        const title = document.getElementById('modalTitle');
        const form = document.getElementById('prodForm');

        // Reset Form
        document.getElementById('prodId').value = "";
        document.getElementById('oldImage').value = "";
        document.getElementById('barcode').value = "";
        document.getElementById('name').value = "";
        document.getElementById('catId').value = "";
        document.getElementById('purchase_price').value = "";
        document.getElementById('price').value = "";
        document.getElementById('stock').value = "0";

        if (type === 'add') {
            title.innerText = "Tambah Produk Baru";
            form.action = "<?= base_url('products/store') ?>";
        } else if (type === 'edit' && data) {
            title.innerText = "Edit Produk";
            form.action = "<?= base_url('products/update') ?>"; // Pastikan route update pakai POST data ID atau sesuaikan

            // Isi Data
            document.getElementById('prodId').value = data.id;
            document.getElementById('oldImage').value = data.image;
            document.getElementById('barcode').value = data.barcode;
            document.getElementById('name').value = data.name;
            document.getElementById('catId').value = data.category_id;
            document.getElementById('purchase_price').value = data.purchase_price;
            document.getElementById('price').value = data.price;
            document.getElementById('stock').value = data.stock;
        }

        modal.show();
    }

    // 3. SEARCH REALTIME
    function filterTable() {
        let input = document.getElementById("searchInput");
        let filter = input.value.toUpperCase();
        let table = document.getElementById("productTable");
        let tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) {
            // Kolom Nama Produk ada di index 0 (karena ada div wrapper)
            // Tapi kita cek text content dari seluruh baris agar bisa cari barcode/kategori juga
            let rowContent = tr[i].textContent || tr[i].innerText;
            
            if (rowContent.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }       
        }
    }
</script>

<?= $this->endSection() ?>