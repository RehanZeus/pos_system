<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'POS System' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body { 
            background-color: #f8f9fa; 
            overflow-x: hidden; /* Mencegah scroll ke samping */
        }
        
        /* 1. KUNCI SIDEBAR DI KIRI */
        .sidebar-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background-color: #212529; /* Warna Gelap */
            z-index: 1000;
            overflow-y: auto; /* Scroll jika menu panjang */
        }

        /* 2. DORONG KONTEN KE KANAN */
        .main-wrapper {
            margin-left: 250px; /* Harus sama dengan lebar sidebar */
            width: calc(100% - 250px);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Style Card agar cantik */
        .card-custom { 
            border: none; 
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); 
            transition: transform 0.2s; 
        }
        .card-custom:hover { transform: translateY(-3px); }
    </style>
</head>
<body>

    <div class="sidebar-wrapper">
        <?= $this->include('partials/sidebar') ?>
    </div>

    <div class="main-wrapper">
        <?= $this->include('partials/navbar') ?>

        <div class="container-fluid p-4">
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>