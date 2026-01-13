<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h5 class="fw-bold mb-4">Tambah User</h5>

<form action="<?= base_url('users/store') ?>" method="post" class="card p-4 shadow-sm">

    <div class="mb-3">
        <label class="form-label">Nama</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-4">
        <label class="form-label">Role</label>
        <select name="role" class="form-select" required>
            <option value="kasir">Kasir</option>
            <option value="admin">Admin</option>
        </select>
    </div>

    <div class="d-flex gap-2">
        <button class="btn btn-primary">Simpan</button>
        <a href="<?= base_url('users') ?>" class="btn btn-secondary">Kembali</a>
    </div>

</form>

<?= $this->endSection() ?>
