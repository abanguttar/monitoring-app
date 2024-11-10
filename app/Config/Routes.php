<?php

use App\Controllers\MitraController;
use App\Controllers\PesertaController;
use CodeIgniter\Router\RouteCollection;
use App\Controllers\DashboardController;
use App\Controllers\GrafikTransaksiController;
use App\Controllers\MasterClassController;
use App\Controllers\PelatihanController;
use App\Controllers\UserController;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// $routes->group('monitoring-app', static function ($routes) {
//     $routes->group('', ['namespace' => 'Myth\Auth\Controllers'], function ($routes) {
//         $routes->get('login', 'AuthController::login', ['as' => 'login']);
//         $routes->post('login', 'AuthController::attemptLogin');
//         $routes->get('register', 'AuthController::register', ['as' => 'register']);
//         $routes->post('register', 'AuthController::attemptRegister');
//         $routes->get('logout', 'AuthController::logout', ['as' => 'logout']);
//         $routes->get('forgot', 'AuthController::forgotPassword', ['as' => 'forgot']);
//         $routes->post('forgot', 'AuthController::attemptForgot');
//         $routes->get('reset/(:hash)', 'AuthController::resetPassword/$1', ['as' => 'reset']);
//         $routes->post('reset/(:hash)', 'AuthController::attemptReset');
//     });
// });
$routes->get('dashboard', [DashboardController::class, 'index']);
// $routes->resource('mitra', ['controller' => 'MitraController']);
// $routes->resource('digital-platform', ['controller' => 'D    igitalPlatformController']);
// $routes->resource('master-class', ['controller' => 'MasterClassController']);

$routes->group('master-class', ['namespace' => 'App\Controllers'], static  function ($routes) {
    $routes->get('', 'MasterClassController::index', ['filter' => 'access:1']);
    $routes->get('new', 'MasterClassController::new', ['filter' => 'access:2']);
    $routes->post('', 'MasterClassController::create', ['filter' => 'access:2']);
    $routes->get('(.*)/edit', 'MasterClassController::edit/$1', ['filter' => 'access:3']);
    $routes->put('(.*)', 'MasterClassController::update/$1', ['filter' => 'access:3']);
});
$routes->group('digital-platform', ['namespace' => 'App\Controllers'], static  function ($routes) {
    $routes->get('', 'DigitalPlatformController::index', ['filter' => 'access:4']);
    $routes->get('new', 'DigitalPlatformController::new', ['filter' => 'access:5']);
    $routes->post('create', 'DigitalPlatformController::create', ['filter' => 'access:5']);
    $routes->get('(.*)/edit', 'DigitalPlatformController::edit/$1', ['filter' => 'access:6']);
    $routes->put('(.*)', 'DigitalPlatformController::update/$1', ['filter' => 'access:6']);
});
$routes->group('mitra', ['namespace' => 'App\Controllers'], static  function ($routes) {
    $routes->get('', 'MitraController::index', ['filter' => 'access:7']);
    $routes->get('new', 'MitraController::new', ['filter' => 'access:8']);
    $routes->post('', 'MitraController::create', ['filter' => 'access:8']);
    $routes->get('(.*)/edit', 'MitraController::edit/$1', ['filter' => 'access:9']);
    $routes->put('(.*)', 'MitraController::update/$1', ['filter' => 'access:9']);
});


$routes->get('peserta/(:num)/add-pelatihan', [PelatihanController::class, 'new'], ['filter' => 'access:13']);
$routes->post('peserta/(:num)/add-pelatihan', [PelatihanController::class, 'create'], ['filter' => 'access:13']);
$routes->get('peserta/(:num)/edit-pelatihan/(:num)', [PelatihanController::class, 'edit'], ['filter' => 'access:14']);
$routes->put('peserta/(:num)/edit-pelatihan/(:num)', [PelatihanController::class, 'update'], ['filter' => 'access:14']);
$routes->get('peserta/(:num)/add-progress', [PelatihanController::class, 'addProgress'], ['filter' => 'access:15']);
$routes->put('peserta/(:num)/add-progress', [PelatihanController::class, 'updateProgress'], ['filter' => 'access:15']);
$routes->get('peserta/(:num)/update-payment', [PelatihanController::class, 'editPayment'], ['filter' => 'access:16']);
$routes->put('peserta/(:num)/update-payment', [PelatihanController::class, 'updatePayment'], ['filter' => 'access:16']);
$routes->get('peserta/(:num)/update-mitra/(:num)', [PesertaController::class, 'editMitra'], ['filter' => 'access:17']);
$routes->put('peserta/(:num)/update-mitra/(:num)', [PesertaController::class, 'updateMitra'], ['filter' => 'access:17']);
$routes->get('peserta/import-data/pembelian', [PesertaController::class, 'viewImportPembelian'], ['filter' => 'access:18']);
$routes->get('peserta/import-data/redemption', [PesertaController::class, 'viewImportRedemption'], ['filter' => 'access:19']);
$routes->get('peserta/import-data/completion', [PesertaController::class, 'viewImportCompletion'], ['filter' => 'access:20']);
$routes->get('peserta/import-data/reconcile', [PesertaController::class, 'viewImportReconcile'], ['filter' => 'access:21']);
$routes->post('peserta/import-data/pembelian', [PesertaController::class, 'storeImportPembelian'], ['filter' => 'access:18']);
$routes->post('peserta/import-data/redemption', [PesertaController::class, 'storeImportRedemption'], ['filter' => 'access:19']);
$routes->post('peserta/import-data/completion', [PesertaController::class, 'storeImportCompletion'], ['filter' => 'access:20']);
$routes->post('peserta/import-data/reconcile', [PesertaController::class, 'storeImportReconcile'], ['filter' => 'access:21']);
$routes->group('peserta', ['namespace' => 'App\Controllers'], static  function ($routes) {
    $routes->get('', 'PesertaController::index', ['filter' => 'access:10']);
    $routes->get('new', 'PesertaController::new', ['filter' => 'access:11']);
    $routes->post('', 'PesertaController::create', ['filter' => 'access:11']);
    $routes->get('(.*)/edit', 'PesertaController::edit/$1', ['filter' => 'access:12']);
    $routes->put('(.*)', 'PesertaController::update/$1', ['filter' => 'access:12']);
});
// $routes->resource('peserta', ['controller' => 'PesertaController']);
$routes->delete('delete-table-message', [PesertaController::class, 'destroyMessage']);
$routes->get('download/(:any)', [PesertaController::class, 'downloadTemplate']);

$routes->group('users', ['filter' => 'listadminfilter'], static function ($routes) {
    $routes->get('', [UserController::class, 'index']);
    $routes->get('new', [UserController::class, 'new']);
    $routes->post('new', [UserController::class, 'create']);
    $routes->get('(:num)/edit', [UserController::class, 'edit']);
    $routes->put('(:num)/edit', [UserController::class, 'update']);
    $routes->get('(:num)/permissions', [UserController::class, 'viewPermissions']);
    $routes->put('(:num)/permissions', [UserController::class, 'updatePermissions']);
});

$routes->get('grafik-transaksi', [GrafikTransaksiController::class, 'index']);
$routes->get('grafik-transaksi/pembelian-penyelesaian', [GrafikTransaksiController::class, 'fetchPembelianPenyelesaian']);
$routes->get('grafik-transaksi/penjualan-kelas', [GrafikTransaksiController::class, 'fetchPenjualanKelas']);
$routes->get('grafik-transaksi/penjualan-mitra', [GrafikTransaksiController::class, 'fetchPenjualanMitra']);
