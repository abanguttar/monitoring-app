<?php

use App\Controllers\MitraController;
use App\Controllers\PesertaController;
use CodeIgniter\Router\RouteCollection;
use App\Controllers\DashboardController;
use App\Controllers\PelatihanController;

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
$routes->resource('mitra', ['controller' => 'MitraController']);
$routes->resource('digital-platform', ['controller' => 'DigitalPlatformController']);
$routes->resource('master-class', ['controller' => 'MasterClassController']);
$routes->get('peserta/(:num)/add-pelatihan', [PelatihanController::class, 'new']);
$routes->post('peserta/(:num)/add-pelatihan', [PelatihanController::class, 'create']);
$routes->get('peserta/(:num)/edit-pelatihan/(:num)', [PelatihanController::class, 'edit']);
$routes->put('peserta/(:num)/edit-pelatihan/(:num)', [PelatihanController::class, 'update']);
$routes->get('peserta/(:num)/add-progress', [PelatihanController::class, 'addProgress']);
$routes->put('peserta/(:num)/add-progress', [PelatihanController::class, 'updateProgress']);
$routes->get('peserta/(:num)/update-payment', [PelatihanController::class, 'editPayment']);
$routes->put('peserta/(:num)/update-payment', [PelatihanController::class, 'updatePayment']);
$routes->get('peserta/(:num)/update-mitra/(:num)', [PesertaController::class, 'editMitra']);
$routes->put('peserta/(:num)/update-mitra/(:num)', [PesertaController::class, 'updateMitra']);
$routes->get('peserta/import-data/pembelian', [PesertaController::class, 'viewImportPembelian']);
$routes->get('peserta/import-data/redemption', [PesertaController::class, 'viewImportRedemption']);
$routes->get('peserta/import-data/completion', [PesertaController::class, 'viewImportCompletion']);
$routes->get('peserta/import-data/reconcile', [PesertaController::class, 'viewImportReconcile']);
$routes->post('peserta/import-data/pembelian', [PesertaController::class, 'storeImportPembelian']);
$routes->post('peserta/import-data/redemption', [PesertaController::class, 'storeImportRedemption']);
$routes->post('peserta/import-data/completion', [PesertaController::class, 'storeImportCompletion']);
$routes->post('peserta/import-data/reconcile', [PesertaController::class, 'storeImportReconcile']);
$routes->resource('peserta', ['controller' => 'PesertaController']);
$routes->delete('delete-table-message', [PesertaController::class, 'destroyMessage']);
$routes->get('download/(:any)', [PesertaController::class, 'downloadTemplate']);
