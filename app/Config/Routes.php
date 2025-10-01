<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


//routes admin
$routes->get('/admin/manage_anggota', 'adminController::anggota', ['filter' => 'admin']);
$routes->get('/admin/manage_komponen', 'AdminController::komponen', ['filter' => 'admin']);
$routes->get('/admin/manage_penggajian', 'AdminController::penggajian', ['filter' => 'admin']);

//public
$routes->get('/public/anggota', 'PublicController::anggota', ['filter' => 'auth']);
$routes->get('/public/data_penggajian', 'PublicController::penggajian', ['filter' => 'auth']);

//login
$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/processLogin', 'Auth::processLogin');
$routes->get('/logout', 'Auth::logout');