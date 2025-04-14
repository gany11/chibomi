<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::indexBeranda');
$routes->get('/kontak', 'Home::indexKontak');

$routes->get('/registrasi', 'Account::indexRegister', ['filter' => 'role:nonlogin']);
$routes->add('/registrasi/save', 'Account::register', ['filter' => 'role:nonlogin']);
$routes->get('/verifikasi/(:segment)', 'Account::verifyEmail/$1', ['filter' => 'role:nonlogin']);

$routes->get('/login', 'Account::indexLogin', ['filter' => 'role:nonlogin']);
$routes->add('/login/in', 'Account::login', ['filter' => 'role:nonlogin']);

$routes->get('/logout', 'Account::logout', ['filter' => 'role']);

$routes->get('/profil', 'Account::indexProfil', ['filter' => 'role']);
$routes->add('/profil/update', 'Account::updateProfil', ['filter' => 'role']);

$routes->get('/alamat', 'Account::indexAlamat', ['filter' => 'role']);