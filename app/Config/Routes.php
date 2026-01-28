<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ========================
// 1. PUBLIC (LOGIN / LOGOUT)
// ========================
$routes->get('/', 'Auth::index');
$routes->post('login/process', 'Auth::loginProcess');
$routes->get('logout', 'Auth::logout');


// ========================
// 2. DASHBOARD & USER MANAGEMENT (OWNER ONLY)
// ========================
// Admin & Kasir DILARANG
$routes->group('', ['filter' => 'role:owner'], function($routes) {

    // Dashboard
    $routes->get('dashboard', 'Dashboard::index');

    // ========================
    // USER MANAGEMENT (OWNER ONLY)
    // ========================
    $routes->group('users', function($routes) {

        // List user
        $routes->get('/', 'UserController::index');

        // Tambah user
        $routes->get('create', 'UserController::create');
        $routes->post('store', 'UserController::store');

        // Edit profil user
        $routes->get('edit/(:num)', 'UserController::edit/$1');
        $routes->post('update/(:num)', 'UserController::update/$1');

        // Reset password user
        $routes->post('reset-password/(:num)', 'UserController::resetPassword/$1');

        // Hapus user (NON owner)
        $routes->post('delete/(:num)', 'UserController::delete/$1');
    });

});


// ========================
// 3. MASTER DATA (OWNER & ADMIN)
// ========================
// Kasir DILARANG
$routes->group('', ['filter' => 'role:owner,admin'], function($routes) {
    
    // Categories
    $routes->group('categories', function($routes) {
        $routes->get('/', 'Categories::index');
        $routes->post('store', 'Categories::store');
        $routes->get('delete/(:num)', 'Categories::delete/$1');
    });

    // Products
    $routes->group('products', function($routes) {
        $routes->get('/', 'Products::index');
        $routes->post('store', 'Products::store');
        $routes->post('update', 'Products::update');
        $routes->get('delete/(:num)', 'Products::delete/$1');
    });
});


// ========================
// 4. TRANSAKSI & LAPORAN
// ========================
// Admin Gudang DILARANG
$routes->group('', ['filter' => 'role:owner,kasir'], function($routes) {
    
    // POS
    $routes->group('pos', function($routes) {
        $routes->get('/', 'Pos::index');
        $routes->get('search', 'Pos::searchProduct'); 
        $routes->post('processPayment', 'Pos::processPayment');
        $routes->get('struk/(:any)', 'Pos::struk/$1');
    });

    // Reports
    $routes->group('reports', function($routes) {
        $routes->get('/', 'Reports::index');
        $routes->get('detail/(:num)', 'Reports::detail/$1');
        $routes->get('export', 'Reports::exportExcel');
    });
});
