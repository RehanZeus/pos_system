<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login System POS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card-login { width: 100%; max-width: 400px; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .btn-primary { background-color: #0d6efd; border: none; }
    </style>
</head>
<body>

    <div class="card card-login bg-white">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-primary">POS SYSTEM</h3>
            <p class="text-muted">Silakan login untuk masuk</p>
        </div>

        <?php if(session()->getFlashdata('error')):?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif;?>

        <form action="<?= base_url('/login/process') ?>" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" id="username" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2">MASUK</button>
        </form>
        
        <div class="text-center mt-3 text-muted small">
            &copy; 2024 POS Retail System
        </div>
    </div>

</body>
</html>