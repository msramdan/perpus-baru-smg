<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('/', 'Home::index');

$routes->get('/Library', 'Library::index', ['filter' => 'login']);

$routes->get('/buku', 'Buku::index', ['filter' => 'login']);

$routes->get('/anggota', 'Anggota::index', ['filter' => 'login']);

$routes->get('/buku/generate-qr-code/(:num)', 'Buku::generateQRCode/$1');

$routes->post('/buku/import', 'Buku::import', ['filter' => 'login']);

$routes->post('/anggota/import', 'Anggota::import', ['filter' => 'login']);

$routes->get('/buku/create', 'Buku::create', ['filter' => 'login']);

$routes->get('/buku/edit/(:segment)', 'Buku::edit/$1', ['filter' => 'login']);

$routes->get('/buku/update', 'Buku::update', ['filter' => 'login']);

$routes->get('/buku/save', 'Buku::save', ['filter' => 'login']);

$routes->get('/buku/(:segment)', 'Buku::detail/$1', ['filter' => 'login']);

$routes->get('/databuku/(:segment)', 'Databuku::detail/$1');

$routes->get('/anggota/create', 'Anggota::create', ['filter' => 'login']);

$routes->get('/anggota/edit/(:segment)', 'Anggota::edit/$1', ['filter' => 'login']);

$routes->get('/anggota/update', 'Anggota::update', ['filter' => 'login']);

$routes->get('/anggota/save', 'Anggota::save', ['filter' => 'login']);

$routes->get('/pinjamkembali', 'PinjamKembali::index', ['filter' => 'login']);

$routes->get('/pinjamkembali/create', 'PinjamKembali::create', ['filter' => 'login']);

$routes->get('/pinjamkembali/edit/(:segment)', 'PinjamKembali::edit/$1', ['filter' => 'login']);

$routes->get('/pinjamkembali/update', 'PinjamKembali::update', ['filter' => 'login']);

$routes->get('/pinjamkembali/peminjaman', 'PinjamKembali::peminjaman', ['filter' => 'login']);

$routes->get('/pinjamkembali/cetak-laporan', 'PinjamKembali::cetakLaporan', ['filter' => 'login']);

$routes->get('/logpinjamkembali/cetak-laporan', 'LogPinjamKembali::cetakLaporan', ['filter' => 'login']);

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
