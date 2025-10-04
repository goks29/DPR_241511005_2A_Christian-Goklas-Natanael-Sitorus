<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//routes admin
$routes->get('/admin/manage_anggota', 'adminController::manageAnggota', ['filter' => 'admin']);
$routes->get('/admin/manage_anggota/new', 'adminController::newAnggota', ['filter' => 'admin']);
$routes->post('/admin/manage_anggota/store', 'adminController::storeAnggota', ['filter' => 'admin']);
$routes->get('/admin/manage_anggota/edit/(:num)', 'adminController::editAnggota/$1', ['filter' => 'admin']);
$routes->post('/admin/manage_anggota/update/(:num)', 'adminController::updateAnggota/$1', ['filter' => 'admin']);
$routes->delete('/admin/manage_anggota/delete/(:num)', 'adminController::deleteAnggota/$1', ['filter' => 'admin']);

$routes->get('/admin/manage_komponen', 'adminController::manageKomponen', ['filter' => 'admin']);
$routes->get('/admin/manage_komponen/new', 'adminController::newKomponen', ['filter' => 'admin']);
$routes->post('/admin/manage_komponen/store', 'adminController::storeKomponen', ['filter' => 'admin']);
$routes->get('/admin/manage_komponen/edit/(:num)', 'adminController::editKomponen/$1', ['filter' => 'admin']);
$routes->post('/admin/manage_komponen/update/(:num)', 'adminController::updateKomponen/$1', ['filter' => 'admin']);
$routes->delete('/admin/manage_komponen/delete/(:num)', 'adminController::deleteKomponen/$1', ['filter' => 'admin']);

$routes->get('/admin/manage_penggajian', 'adminController::managePenggajian', ['filter' => 'admin']);
$routes->get('/admin/manage_penggajian/new', 'adminController::newPenggajian', ['filter' => 'admin']);
$routes->post('/admin/manage_penggajian/store', 'adminController::storePenggajian', ['filter' => 'admin']);
$routes->get('/admin/manage_penggajian/edit/(:num)', 'adminController::editPenggajian/$1', ['filter' => 'admin']);
$routes->post('/admin/manage_penggajian/update/(:num)', 'adminController::updatePenggajian/$1', ['filter' => 'admin']);
$routes->delete('/admin/manage_penggajian/delete/(:num)', 'adminController::deletePenggajian/$1', ['filter' => 'admin']);
$routes->get('/admin/manage_penggajian/detail/(:num)', 'adminController::detailPenggajian/$1', ['filter' => 'admin']);


//public
$routes->get('/public/anggota', 'PublicController::anggota', ['filter' => 'auth']);
$routes->get('/public/data_penggajian', 'PublicController::penggajian', ['filter' => 'auth']);

//login
$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/processLogin', 'Auth::processLogin');
$routes->get('/logout', 'Auth::logout');