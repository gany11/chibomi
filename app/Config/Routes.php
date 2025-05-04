<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Home (Done)
$routes->get('/', 'Home::indexBeranda');

// Kontak (Done)
$routes->get('/kontak', 'Home::indexKontak');

// Produk (Done)
$routes->get('/produk', 'Product::indexProduk');
$routes->get('/produk/detail/(:segment)', 'Product::indexDetailProduk/$1');
$routes->get('/ulasan/sembunyikan/(:segment)', 'Product::hideUlasan/$1', ['filter' => 'role:Admin,Pemilik']);

// Portofolio (Done)
$routes->get('/portofolio', 'Portofolio::indexPortofolio');
$routes->get('/portofolio/detail/(:segment)', 'Portofolio::indexDetailPortofolio/$1');
$routes->post('/portofolio/ulasan/kirim', 'Portofolio::saveUlasan', ['filter' => 'role:Pelanggan']);
$routes->get('/portofolio/ulasan/hapus/(:segment)', 'Portofolio::deleteUlasan/$1', ['filter' => 'role:Admin,Pemilik']);

// Keranjang (Done)
$routes->get('/keranjang', 'Cart::indexKeranjang', ['filter' => 'role:Pelanggan']);
$routes->post('cart/add', 'Cart::addToCart', ['filter' => 'role:Pelanggan']);
$routes->post('cart/ajaxUpdateQty', 'Cart::ajaxUpdateQty', ['filter' => 'role:Pelanggan']);
$routes->post('cart/delete', 'Cart::delete', ['filter' => 'role:Pelanggan']);

// Cari  (Done)
$routes->post('cari', 'Home::csearch/$1');
$routes->get('cari/(:any)', 'Home::search/$1');

// Registrasi (Done)
$routes->get('/registrasi', 'Account::indexRegister', ['filter' => 'role:nonlogin']);
$routes->add('/registrasi/save', 'Account::register', ['filter' => 'role:nonlogin']);

// Lupa Password (Done)
$routes->get('/lupa-password', 'Account::indexLupaPassword', ['filter' => 'role:nonlogin']);
$routes->add('/lupa-password/save', 'Account::saveLupaPassword', ['filter' => 'role:nonlogin']);

// Verifikasi Email (Done)
$routes->get('/verifikasi/(:segment)', 'Account::verifyEmail/$1', ['filter' => 'role:nonlogin']);

// Login (Done)
$routes->get('/login', 'Account::indexLogin', ['filter' => 'role:nonlogin']);
$routes->add('/login/in', 'Account::login', ['filter' => 'role:nonlogin']);

// Logout (Done)
$routes->get('/logout', 'Account::logout', ['filter' => 'role']);

// Profil (Done)
$routes->get('/profil', 'Account::indexProfil', ['filter' => 'role']);
$routes->add('/profil/update', 'Account::updateProfil', ['filter' => 'role']);
$routes->get('/admin/profil', 'Account::indexProfilAdmin', ['filter' => 'role:Admin,Pemilik']);

// Alamat (Done)
$routes->get('/alamat', 'Address::indexAlamat', ['filter' => 'role:Pelanggan']);
$routes->get('/alamat/tambah', 'Address::indexTambahAlamat', ['filter' => 'role:Pelanggan']);
$routes->get('/alamat/ubah/(:segment)', 'Address::indexEditAlamat/$1', ['filter' => 'role:Pelanggan']);
$routes->get('/alamat/hapus/(:segment)', 'Address::deleteAlamat/$1', ['filter' => 'role:Pelanggan']);
$routes->post('/alamat/simpan', 'Address::saveAlamat', ['filter' => 'role:Pelanggan']);
$routes->get('/alamat/api/cek-kodepos/(:num)', 'Address::cekKodePos/$1', ['filter' => 'role:Pelanggan']);

// Admin - Akun (Done)
$routes->get('/admin/akun/list', 'Account::indexListAkun', ['filter' => 'role:Admin,Pemilik']);
$routes->get('/admin/akun/registrasi-admin', 'Account::indexRegistrasiAdmin', ['filter' => 'role:Pemilik']);
$routes->add('/admin/akun/registrasi-admin/save', 'Account::saveRegistrasiAdmin', ['filter' => 'role:Pemilik']);
$routes->post('user/changeStatus', 'Account::changeStatus', ['filter' => 'role:Admin,Pemilik']);
$routes->post('user/sendVerification', 'Account::sendVerification', ['filter' => 'role:Admin,Pemilik']);

// Admin - Jasa Pengiriman (Done)
$routes->get('/admin/pengiriman/list', 'DeliveryService::indexListDeliveryService', ['filter' => 'role:Admin,Pemilik']);
$routes->get('/admin/pengiriman/tambah', 'DeliveryService::indexDeliveryService', ['filter' => 'role:Admin,Pemilik']);
$routes->get('/admin/pengiriman/edit/(:segment)', 'DeliveryService::indexDeliveryService/$1', ['filter' => 'role:Admin,Pemilik']);
$routes->post('/admin/pengiriman/save', 'DeliveryService::saveAddDeliveryService', ['filter' => 'role:Admin,Pemilik']);

// Admin - Portofolio (Done)
$routes->get('/admin/portofolio/list', 'Portofolio::indexListPortofolio', ['filter' => 'role:Admin,Pemilik']);
$routes->get('/admin/portofolio/tambah', 'Portofolio::indexFormTambahPortofolio', ['filter' => 'role:Admin,Pemilik']);
$routes->post('/admin/portofolio/tambah/save', 'Portofolio::saveFormTambahPortofolio', ['filter' => 'role:Admin,Pemilik']);
$routes->get('/admin/portofolio/detail/(:segment)', 'Portofolio::indexDetailPortofolioAdmin/$1', ['filter' => 'role:Admin,Pemilik']);
$routes->post('/admin/portofolio/detail/save/(:segment)', 'Portofolio::saveDetailPortofolioAdmin/$1', ['filter' => 'role:Admin,Pemilik']);
$routes->post('portofolio/archive', 'Portofolio::archive', ['filter' => 'role:Admin,Pemilik']);
$routes->post('portofolio/restore', 'Portofolio::restore', ['filter' => 'role:Pemilik']);
$routes->post('portofolio/delete', 'Portofolio::delete', ['filter' => 'role:Pemilik']);

// Admin - Produk  (Done)
$routes->get('/admin/barang/list', 'Product::indexListBarang', ['filter' => 'role:Admin,Pemilik']);
$routes->get('/admin/jasa/list', 'Product::indexListJasa', ['filter' => 'role:Admin,Pemilik']);
$routes->get('/admin/produk/tambah', 'Product::indexFormTambahProduct', ['filter' => 'role:Admin,Pemilik']);
$routes->post('/admin/produk/tambah/save', 'Product::saveFormTambahProduct', ['filter' => 'role:Admin,Pemilik']);
$routes->get('/admin/barang/detail/(:segment)', 'Product::indexDetailBarangAdmin/$1', ['filter' => 'role:Admin,Pemilik']);
$routes->get('/admin/jasa/detail/(:segment)', 'Product::indexDetailJasaAdmin/$1', ['filter' => 'role:Admin,Pemilik']);
$routes->post('/admin/barang/detail/save/(:segment)', 'Product::saveDetailBarangAdmin/$1', ['filter' => 'role:Admin,Pemilik']);
$routes->post('/admin/jasa/detail/save/(:segment)', 'Product::saveDetailJasaAdmin/$1', ['filter' => 'role:Admin,Pemilik']);
$routes->post('produk/archive', 'Product::archive', ['filter' => 'role:Admin,Pemilik']);
$routes->post('produk/restore', 'Product::restore', ['filter' => 'role:Pemilik']);
$routes->post('produk/delete', 'Product::delete', ['filter' => 'role:Pemilik']);

// Admin - Home
$routes->get('/admin', 'Home::indexBerandaAdmin', ['filter' => 'role:Admin,Pemilik']);
$routes->add('/admin/laporan', 'Home::indexLaporan', ['filter' => 'role:Admin,Pemilik']);

// Transaksi
$routes->add('/pesanan/cek', 'Transaction::cek', ['filter' => 'role:Pelanggan']);
$routes->add('/pesanan/simpan', 'Transaction::simpan', ['filter' => 'role:Pelanggan']);
$routes->add('/pesanan/simpan-jasa', 'Transaction::simpanJasa', ['filter' => 'role:Pelanggan']);
$routes->get('/pesanan', 'Transaction::pesanan', ['filter' => 'role:Pelanggan']);
$routes->get('/pesanan/detail/(:segment)', 'Transaction::pesananDetail/$1', ['filter' => 'role:Pelanggan']);
$routes->add('/pesanan/bayar/(:segment)', 'Transaction::bayar/$1', ['filter' => 'role:Pelanggan']);
$routes->add('/pesanan/lacak/(:segment)', 'Transaction::lacakPengiriman/$1', ['filter' => 'role:Pelanggan,Admin,Pemilik']);
$routes->post('/ongkir/cek', 'Transaction::cekOngkir', ['filter' => 'role:Pelanggan']);
$routes->post('/pesanan/ubah-status', 'Transaction::ubahStatus', ['filter' => 'role:Pelanggan']);
$routes->post('/produk/ulasan/kirim', 'Transaction::kirimUlasan', ['filter' => 'role:Pelanggan']);
$routes->get('/pembayaran/(:segment)', 'Transaction::pembayaran/$1', ['filter' => 'role:Pelanggan']);
$routes->post('midtrans/callback', 'Transaction::callback');


// Transaksi - Admin (Done)
$routes->get('/admin/pesanan/list/(:segment)/(:segment)', 'Transaction::indexTransaksiAdmin/$1/$2', ['filter' => 'role:Admin,Pemilik']);
$routes->get('/admin/transaksi/detail/(:segment)', 'Transaction::pesananDetailAdmin/$1', ['filter' => 'role:Admin,Pemilik']);
$routes->post('/admin/transaksi/barang/kirim/(:segment)', 'Transaction::kirim_barang/$1', ['filter' => 'role:Admin,Pemilik']);
$routes->post('/admin/transaksi/jasa/selesai/(:segment)', 'Transaction::selesai_jasa/$1', ['filter' => 'role:Admin,Pemilik']);
$routes->post('/transaksi/ubah-status', 'Transaction::ubahStatus', ['filter' => 'role:Admin,Pemilik']);
