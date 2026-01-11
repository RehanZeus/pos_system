<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center">
        <div class="bg-primary text-white rounded p-2 me-3 shadow-sm">
            <i class="bi bi-tags-fill fs-4"></i>
        </div>
        <div>
            <h4 class="mb-0 fw-bold text-dark">Data Kategori</h4>
            <small class="text-muted">Kelola pengelompokan produk toko</small>
        </div>
    </div>
    
    <button class="btn btn-primary fw-bold px-4 shadow-sm" style="border-radius: 8px;" onclick="openModal('add')">
        <i class="bi bi-plus-lg me-2"></i> Tambah Baru
    </button>
</div>

<div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
    <div class="card-body p-3">
        <div class="input-group">
            <span class="input-group-text bg-white border-0 ps-3"><i class="bi bi-search text-muted"></i></span>
            <input type="text" id="searchInput" class="form-control border-0 bg-white shadow-none fw-bold" placeholder="Cari nama kategori..." onkeyup="filterTable()">
        </div>
    </div>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success border-0 shadow-sm mb-4 d-flex align-items-center">
        <i class="bi bi-check-circle-fill me-2"></i>
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger border-0 shadow-sm mb-4 d-flex align-items-center">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="categoryTable">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-bold text-secondary border-bottom" width="10%">No</th>
                        <th class="py-3 text-uppercase small fw-bold text-secondary border-bottom">Nama Kategori</th>
                        <th class="text-center py-3 text-uppercase small fw-bold text-secondary border-bottom" width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($categories)): ?>
                        <tr>
                            <td colspan="3" class="text-center py-5">
                                <div class="text-muted opacity-25 mb-3">
                                    <i class="bi bi-folder-x display-4"></i>
                                </div>
                                <h6 class="text-muted fw-bold">Belum ada kategori</h6>
                                <small class="text-muted">Klik tombol Tambah Baru untuk memulai.</small>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($categories as $index => $row): ?>
                        <tr>
                            <td class="ps-4 fw-bold text-secondary"><?= $index + 1 ?></td>
                            <td>
                                <span class="fw-bold text-dark fs-6"><?= esc($row['name']) ?></span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group shadow-sm">
                                    <button class="btn btn-sm btn-light border text-primary" onclick="openModal('edit', <?= $row['id'] ?>, '<?= esc($row['name']) ?>')" data-bs-toggle="tooltip" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <a href="<?= base_url('categories/delete/'.$row['id']) ?>" class="btn btn-sm btn-light border text-danger" onclick="return confirm('Yakin ingin menghapus kategori ini?')" data-bs-toggle="tooltip" title="Hapus">
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

<div class="modal fade" id="modalCat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold" id="modalTitle">Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <form action="<?= base_url('categories/store') ?>" method="post" id="catForm">
                <div class="modal-body">
                    <input type="hidden" name="id" id="catId">
                    
                    <div class="mb-3">
                        <label class="form-label small text-uppercase fw-bold text-muted">Nama Kategori</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-tag"></i></span>
                            <input type="text" name="name" id="catName" class="form-control bg-light border-start-0" placeholder="Contoh: Minuman, Makanan..." required autocomplete="off">
                        </div>
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
    // FUNGSI BUKA MODAL (Auto Title & Action)
    function openModal(type, id = null, name = '') {
        const modalElement = document.getElementById('modalCat');
        const modal = new bootstrap.Modal(modalElement);
        const title = document.getElementById('modalTitle');
        const inputId = document.getElementById('catId');
        const inputName = document.getElementById('catName');
        const form = document.getElementById('catForm');

        if (type === 'add') {
            title.innerText = "Tambah Kategori Baru";
            inputId.value = "";
            inputName.value = "";
            // Route untuk Simpan Baru
            form.action = "<?= base_url('categories/store') ?>"; 
        } else {
            title.innerText = "Edit Kategori";
            inputId.value = id;
            inputName.value = name;
            // Route untuk Update
            form.action = "<?= base_url('categories/update') ?>"; 
        }
        
        // Fokus ke input saat modal muncul
        modalElement.addEventListener('shown.bs.modal', function () {
            inputName.focus();
        });

        modal.show();
    }

    // FUNGSI SEARCH TABLE REALTIME
    function filterTable() {
        let input = document.getElementById("searchInput");
        let filter = input.value.toUpperCase();
        let table = document.getElementById("categoryTable");
        let tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) { // Skip header
            let td = tr[i].getElementsByTagName("td")[1]; // Kolom Nama (Index 1)
            if (td) {
                let txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }       
        }
    }
</script>

<?= $this->endSection() ?>