<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/', 'Home::index', ['filter' => 'auth']);

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');

// $routes->get('produk', 'ProdukController::index');
// $routes->get('keranjang', 'TransaksiController::index');
$routes->group('produk', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'ProdukController::index');
    $routes->post('', 'ProdukController::create');
    $routes->post('edit/(:any)', 'ProdukController::edit/$1');
    $routes->get('delete/(:any)', 'ProdukController::delete/$1');
    $routes->get('download', 'ProdukController::download');
});

$routes->group('diskon', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'DiscountController::index');
    $routes->post('', 'DiscountController::create');
    $routes->post('edit/(:any)', 'DiscountController::edit/$1');
    $routes->get('delete/(:any)', 'DiscountController::delete/$1');
});

$routes->group('admin-transaksi', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'AdminTransaksiController::index');
    $routes->post('update-status/(:num)', 'AdminTransaksiController::update_status/$1');
});

$routes->group('api', function ($routes) {
    $routes->get('discount', 'Api\DiscountController::index');
    $routes->post('discount', 'Api\DiscountController::create');
});

$routes->group('keranjang', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'TransaksiController::index');
    $routes->post('', 'TransaksiController::cart_add');
    $routes->post('edit', 'TransaksiController::cart_edit');
    $routes->get('delete/(:any)', 'TransaksiController::cart_delete/$1');
    $routes->get('clear', 'TransaksiController::cart_clear');
});

$routes->get('keranjang', 'TransaksiController::index', ['filter' => 'auth']);
$routes->get('contact', 'Home::contact', ['filter' => 'role']);

$routes->get('checkout', 'TransaksiController::checkout', ['filter' => 'auth']);
$routes->post('buy', 'TransaksiController::buy', ['filter' => 'auth']);
$routes->get('history', 'TransaksiController::history', ['filter' => 'auth']);

$routes->get('ajax/destinations','TransaksiController::destinations', ['filter' => 'auth']);
$routes->get('ajax/costs','TransaksiController::costs', ['filter' => 'auth']);

$routes->resource('api/products', ['controller' => 'Api\ProdukController']);

$routes->get('api/transactions', 'Api\TransaksiController::index');