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
        
        /* --- 1. SIDEBAR (Fixed Left) --- */
        .sidebar-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background-color: #212529; 
            z-index: 1040; /* Standar Bootstrap Sidebar */
            overflow-y: auto; 
            transition: all 0.3s;
        }

        /* --- 2. MAIN CONTENT (Push Right) --- */
        .main-wrapper {
            margin-left: 250px; 
            width: calc(100% - 250px);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 1; 
        }

        /* Hilangkan Hack Overlay sebelumnya, biarkan Bootstrap mengatur layer secara alami */
        
        /* Fix Debug Toolbar agar tidak mengganggu layout (Opsional) */
        #debug-icon, .debug-bar-container {
            display: none !important;
        }

        .card-custom { 
            border: none; 
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); 
        }
        
        @media (max-width: 768px) {
            .sidebar-wrapper { margin-left: -250px; }
            .main-wrapper { margin-left: 0; width: 100%; }
        }
    </style>
</head>
<body>

    <div class="sidebar-wrapper">
        <?= $this->include('partials/sidebar') ?>
    </div>

    <div class="main-wrapper">
        <div class="container-fluid p-4">
            
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <?= $this->renderSection('modals') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <?= $this->renderSection('scripts') ?>

</body>
</html>