<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// 1. AUTHENTICATION (Login & Logout)
$routes->get('/', 'Auth::index');
$routes->post('login/process', 'Auth::loginProcess');
$routes->get('logout', 'Auth::logout');

// 2. DASHBOARD
$routes->get('dashboard', 'Dashboard::index');

// 3. MASTER DATA - CATEGORIES
$routes->group('categories', static function($routes) {
    $routes->get('/', 'Categories::index');
    $routes->post('store', 'Categories::store');
    $routes->get('delete/(:num)', 'Categories::delete/$1');
});

// 4. MASTER DATA - PRODUCTS
$routes->group('products', static function($routes) {
    $routes->get('/', 'Products::index');
    $routes->post('store', 'Products::store');
    $routes->get('delete/(:num)', 'Products::delete/$1');
});

// 5. KASIR (POINT OF SALE)
$routes->group('pos', static function($routes) {
    $routes->get('/', 'Pos::index');
    $routes->get('search', 'Pos::searchProduct');        // API Search Produk
    $routes->post('processPayment', 'Pos::processPayment'); // API Bayar (Utama)
    $routes->get('struk/(:any)', 'Pos::struk/$1');       // Tampilan Struk
});

// 6. LAPORAN (REPORTS)
$routes->group('reports', static function($routes) {
    $routes->get('/', 'Reports::index');
    $routes->get('detail/(:num)', 'Reports::detail/$1'); // Detail Transaksi
    $routes->get('export', 'Reports::exportExcel');      // Download Excel
});

// 7. UTILITY / TEST
$routes->get('test', 'Test::index');