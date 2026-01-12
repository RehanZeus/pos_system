<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// 1. PUBLIC (Login/Logout)
$routes->get('/', 'Auth::index');
$routes->post('login/process', 'Auth::loginProcess');
$routes->get('logout', 'Auth::logout');

// 2. DASHBOARD (Hanya OWNER)
// Admin Gudang & Kasir DILARANG masuk sini
$routes->group('', ['filter' => 'role:owner'], function($routes) {
    $routes->get('dashboard', 'Dashboard::index');
});

// 3. MASTER DATA (OWNER & ADMIN GUDANG)
// Kasir DILARANG masuk sini
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
        $routes->post('store', 'Products::store');   // Tambah
        $routes->post('update', 'Products::update'); // Edit (PENTING: Ini pasangannya fungsi update di Controller)
        $routes->get('delete/(:num)', 'Products::delete/$1');
    });
});

// 4. TRANSAKSI & LAPORAN (OWNER & KASIR)
// Admin Gudang DILARANG masuk sini
$routes->group('', ['filter' => 'role:owner,kasir'], function($routes) {
    
    // POS (Kasir)
    $routes->group('pos', function($routes) {
        $routes->get('/', 'Pos::index');
        $routes->get('search', 'Pos::searchProduct'); 
        $routes->post('processPayment', 'Pos::processPayment');
        $routes->get('struk/(:any)', 'Pos::struk/$1');
    });

    // REPORTS (Laporan)
    $routes->group('reports', function($routes) {
        $routes->get('/', 'Reports::index');
        $routes->get('detail/(:num)', 'Reports::detail/$1');
        $routes->get('export', 'Reports::exportExcel');
    });
});