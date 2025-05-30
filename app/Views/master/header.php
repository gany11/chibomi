<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?= esc(empty($title)? '' : $title. ' | ') ?>Chibomi</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Place favicon.png in the root directory -->
    <link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.png')?>" type="image/x-icon" />
    <!-- Font Icons css -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/font-icons.css')?>">
    <!-- plugins css -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/plugins.css')?>">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css')?>">
    <!-- Responsive css -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/responsive.css')?>">
</head>

<body>
    <!-- Body main wrapper start -->
    <div class="body-wrapper">

        <!-- HEADER AREA START (header-5) -->
        <header class="ltn__header-area ltn__header-5 ltn__header-transparent gradient-color-2">
            <!-- ltn__header-middle-area start -->
            <div class="ltn__header-middle-area ltn__header-sticky ltn__sticky-bg-white ltn__logo-right-menu-option plr--9---">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="site-logo-wrap">
                                <div class="site-logo">
                                    <a href="<?php echo base_url('/')?>"><img src="<?php echo base_url('assets/img/logo-2.png')?>" alt="Logo"></a>
                                </div>
                            </div>
                        </div>
                        <div class="col header-menu-column menu-color-black">
                            <div class="header-menu d-none d-xl-block">
                                <nav>
                                    <div class="ltn__main-menu">
                                        <ul>
                                            <li><a href="<?php echo base_url('/')?>">Beranda</a></li>
                                            <li><a href="<?php echo base_url('/produk')?>">Produk</a></li>
                                            <li><a href="<?php echo base_url('/portofolio')?>">Portofolio</a></li>
                                            <li><a href="<?php echo base_url('/kontak')?>">Kontak</a></li>
                                        </ul>
                                    </div>
                                </nav>
                            </div>
                        </div>
                        <div class="ltn__header-options ltn__header-options-2">
                            <!-- header-search-1 -->
                            <div class="header-search-wrap">
                                <div class="header-search-1">
                                    <div class="search-icon">
                                        <i class="icon-search for-search-show"></i>
                                        <i class="icon-cancel  for-search-close"></i>
                                    </div>
                                </div>
                                <div class="header-search-1-form">
                                    <form method="post"  action="<?php echo base_url('cari')?>">
                                        <input type="text" name="q" value="" placeholder="Cari produk atau portofolio..."/>
                                        <button type="submit">
                                            <span><i class="icon-search"></i></span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <!-- user-menu -->
                            <div class="ltn__drop-menu user-menu">
                                <ul>
                                    <li>
                                        <a href="#"><i class="icon-user"></i></a>
                                        <ul>
                                        <?php if (session()->has('id_account')): ?>
                                        <div class="user-info">
                                            <li><a href="<?= base_url('/profil') ?>">Profil</a></li>
                                            <?php if ((session()->get('role') === "Pemilik") || (session()->get('role') === "Admin")): ?>
                                                <li><a href="<?= base_url('/admin') ?>">Mode Admin</a></li>
                                            <?php endif; ?>
                                            <?php if (session()->has('id_account') && (session()->get('role') === 'Pelanggan')): ?>
                                                <li><a href="<?= base_url('/pesanan') ?>">Pesanan Saya</a></li>
                                                <li><a href="<?= base_url('/alamat') ?>">Alamat</a></li>
                                            <?php endif; ?>
                                            <li><a class="logout" href="<?= base_url('/logout') ?>">Logout</a></li>
                                        </div>
                                        <?php else: ?>
                                        <div class="auth-links">
                                            <li><a href="<?= base_url('/login') ?>">Login</a></li>
                                            <li><a href="<?= base_url('/registrasi') ?>">Registrasi</a></li>
                                        </div>
                                        <?php endif; ?>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <!-- cart -->
                            <?php if (session()->get('id_account') && (session()->get('role') === "Pelanggan")): ?>
                            <div class="mini-cart-icon">
                                <a href="<?= base_url('/keranjang') ?>">
                                    <i class="icon-shopping-cart"></i>
                                </a>
                            </div>
                            <?php endif; ?>
                            <!-- cart -->
                            <!-- Mobile Menu Button -->
                            <div class="mobile-menu-toggle d-xl-none">
                                <a href="#ltn__utilize-mobile-menu" class="ltn__utilize-toggle">
                                    <svg viewBox="0 0 800 600">
                                        <path d="M300,220 C300,220 520,220 540,220 C740,220 640,540 520,420 C440,340 300,200 300,200" id="top"></path>
                                        <path d="M300,320 L540,320" id="middle"></path>
                                        <path d="M300,210 C300,210 520,210 540,210 C740,210 640,530 520,410 C440,330 300,190 300,190" id="bottom" transform="translate(480, 320) scale(1, -1) translate(-480, -318) "></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ltn__header-middle-area end -->
        </header>
        <!-- HEADER AREA END -->

        <!-- Utilize Mobile Menu Start -->
        <div id="ltn__utilize-mobile-menu" class="ltn__utilize ltn__utilize-mobile-menu">
            <div class="ltn__utilize-menu-inner ltn__scrollbar">
                <div class="ltn__utilize-menu-head">
                    <!-- <div class="site-logo">
                        <a href="index.html"><img src="img/logo.png" alt="Logo"></a>
                    </div> -->
                    <button class="ltn__utilize-close">×</button>
                </div>
                <div class="ltn__utilize-menu-search-form">
                    <form method="post"  action="<?php echo base_url('cari')?>">
                        <input type="text" name="q" value="" placeholder="Cari produk atau portofolio..."/>
                        <button><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="ltn__utilize-menu">
                    <ul>
                        <li><a href="<?php echo base_url('/')?>">Beranda</a></li>
                        <li><a href="<?php echo base_url('/produk')?>">Produk</a></li>
                        <li><a href="<?php echo base_url('/portofolio')?>">Portofolio</a></li>
                        <li><a href="<?php echo base_url('/kontak')?>">Kontak</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Utilize Mobile Menu End -->

        <div class="ltn__utilize-overlay"></div>