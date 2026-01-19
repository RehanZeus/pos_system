<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh; background-color: #f0f2f5;">
    <div class="card border-0 shadow-sm" style="width: 100%; max-width: 420px; border-radius: 14px;">
        <div class="card-body p-4">

            <!-- Header -->
            <div class="text-center mb-4">
                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex justify-content-center align-items-center mb-3"
                     style="width: 70px; height: 70px;">
                    <i class="bi bi-shop fs-2 text-primary"></i>
                </div>
                <h4 class="fw-bold text-dark mb-1">LuckyMart7</h4>
                <p class="text-muted mb-0">Silakan login untuk masuk</p>
            </div>

            <!-- Error -->
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger small">
                    <i class="bi bi-exclamation-circle me-1"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <!-- Form -->
            <form action="<?= base_url('/login/process') ?>" method="post">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Username</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-person text-secondary"></i>
                        </span>
                        <input type="text" name="username" class="form-control" required autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-lock text-secondary"></i>
                        </span>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>

                <button type="submit"
                        class="btn btn-primary w-100 py-2 fw-bold"
                        style="border-radius: 10px;">
                    <i class="bi bi-box-arrow-in-right me-1"></i> MASUK
                </button>
            </form>

            <div class="text-center mt-4 text-muted small">
                &copy; <?= date('Y') ?> LuckyMart7
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>
