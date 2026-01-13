<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h5 class="fw-bold mb-4">Edit Profil User</h5>

<form action="<?= base_url('users/update/'.$user['id']) ?>" method="post"
      class="card p-4 shadow-sm">

    <div class="mb-3">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="full_name" class="form-control"
               value="<?= esc($profile['full_name'] ?? '') ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">No. HP</label>
        <input type="text" name="phone" class="form-control"
               value="<?= esc($profile['phone'] ?? '') ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Alamat</label>
        <textarea name="address" class="form-control"><?= esc($profile['address'] ?? '') ?></textarea>
    </div>

    <div class="mb-4">
        <label class="form-label">Kota</label>
        <input type="text" name="city" class="form-control"
               value="<?= esc($profile['city'] ?? '') ?>">
    </div>

    <div class="d-flex gap-2">
        <button class="btn btn-primary">Simpan</button>
        <a href="<?= base_url('users') ?>" class="btn btn-secondary">Kembali</a>
    </div>

</form>

<?= $this->endSection() ?>
