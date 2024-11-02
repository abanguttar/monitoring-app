<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\DashboardController;
use App\Controllers\MitraController;

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
