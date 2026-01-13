<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Manajemen User</h4>
        <small class="text-muted">Kelola akun kasir dan admin toko</small>
    </div>

    <a href="<?= base_url('users/create') ?>"
       class="btn btn-primary px-4">
        <i class="bi bi-plus-lg me-2"></i>Tambah Baru
    </a>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success shadow-sm">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm" style="border-radius: 14px;">
    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-muted small text-uppercase">User</th>
                        <th class="py-3 text-muted small text-uppercase">Role</th>
                        <th class="py-3 text-end pe-4 text-muted small text-uppercase">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                <?php foreach($users as $u): ?>
                    <tr>
                        <!-- USER -->
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle
                                            d-flex align-items-center justify-content-center me-3"
                                     style="width: 36px; height: 36px;">
                                    <?= strtoupper(substr($u['username'], 0, 1)) ?>
                                </div>
                                <div>
                                    <div class="fw-bold"><?= esc($u['username']) ?></div>
                                    <small class="text-muted"><?= esc($u['name'] ?? '-') ?></small>
                                </div>
                            </div>
                        </td>

                        <!-- ROLE -->
                        <td>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3">
                                <?= strtoupper($u['role']) ?>
                            </span>
                        </td>

                        <!-- AKSI ICON -->
                        <td class="text-end pe-4">
                            <a href="<?= base_url('users/edit/'.$u['id']) ?>"
                               class="btn btn-sm btn-light border me-1"
                               title="Edit">
                                <i class="bi bi-pencil-square text-primary"></i>
                            </a>

                            <form action="<?= base_url('users/reset-password/'.$u['id']) ?>"
                                  method="post"
                                  class="d-inline"
                                  onsubmit="return confirm('Reset password user ini?')">
                                <button class="btn btn-sm btn-light border me-1"
                                        title="Reset Password">
                                    <i class="bi bi-arrow-clockwise text-warning"></i>
                                </button>
                            </form>

                            <form action="<?= base_url('users/delete/'.$u['id']) ?>"
                                  method="post"
                                  class="d-inline"
                                  onsubmit="return confirm('Hapus user ini?')">
                                <button class="btn btn-sm btn-light border"
                                        title="Hapus">
                                    <i class="bi bi-trash text-danger"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>

            </table>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
