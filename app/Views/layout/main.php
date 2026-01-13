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
            overflow-x: hidden; 
        }
        
        /* ================= SIDEBAR ================= */
        .sidebar-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background-color: #212529; 
            z-index: 1040;
            overflow-y: auto; 
            transition: all 0.3s;
        }

        .sidebar-wrapper .nav-link {
            color: #adb5bd;
            border-radius: 10px;
            padding: 10px 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .sidebar-wrapper .nav-link:hover {
            background-color: rgba(255,255,255,0.08);
            color: #ffffff;
        }

        .sidebar-wrapper .nav-link.active {
            background-color: #0d6efd;
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(13,110,253,.35);
        }

        .sidebar-wrapper .nav-link i {
            font-size: 1.1rem;
        }

        /* ================= MAIN CONTENT ================= */
        .main-wrapper {
            margin-left: 250px; 
            width: calc(100% - 250px);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 1; 
        }

        /* LOGIN PAGE (NO SIDEBAR) */
        .main-wrapper.no-sidebar {
            margin-left: 0 !important;
            width: 100% !important;
        }

        /* ===== FIX DROPDOWN OVERLAY BUG (FINAL) ===== */
        .dropdown-backdrop {
            display: none !important;
        }

        /* Debug toolbar off */
        #debug-icon, .debug-bar-container {
            display: none !important;
        }
    </style>
</head>
<body>

<?php $isLoggedIn = session()->get('isLoggedIn'); ?>

<?php if ($isLoggedIn): ?>
    <div class="sidebar-wrapper">
        <?= $this->include('partials/sidebar') ?>
    </div>
<?php endif; ?>

<div class="main-wrapper <?= $isLoggedIn ? '' : 'no-sidebar' ?>">
    <div class="container-fluid p-4">
        
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        
        <?= $this->renderSection('content') ?>
    </div>
</div>

<?= $this->renderSection('modals') ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?= $this->renderSection('scripts') ?>

</body>
</html>
