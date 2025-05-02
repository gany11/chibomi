<?php
echo view('master\header', [
    'title' => 'Beranda'
]);?>

<!-- SLIDER AREA START (slider-3) -->
<div class="ltn__slider-area ltn__slider-3 section-bg-1 body-wrapper">
    <div class="ltn__slide-one-active slick-slide-arrow-1 slick-slide-dots-1">
        <!-- ltn__slide-item -->
        <div class="ltn__slide-item ltn__slide-item-2 ltn__slide-item-3 ltn__slide-item-3-normal">
            <div class="ltn__slide-item-inner">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 align-self-center">
                            <div class="slide-item-info">
                                <div class="slide-item-info-inner ltn__slide-animation pt-5">
                                    <h6 class="slide-sub-title animated"></h6>
                                    <h1 class="slide-title animated">Hai, selamat datang di<br> dunia Chibomi!</h1>
                                    <div class="slide-brief animated">
                                        <p>Temukan ilustrasi penuh warna dan karakter imajinatif yang dibuat dengan sepenuh hati. Yuk, intip karya-karyaku!</p>
                                    </div>
                                    <div class="btn-wrapper animated">
                                        <a href="<?= base_url('/portofolio') ?>" class="theme-btn-4 btn btn-effect-1 text-uppercase">Lihat Portofolio</a>
                                    </div>
                                </div>
                            </div>
                            <div class="slide-item-img">
                                <img src="<?php echo base_url('assets/img/slider/home1.png')?>" alt="#">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- SLIDER AREA END -->

<!-- ABOUT US AREA START -->
<div class="ltn__about-us-area pt-120 pb-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 align-self-center">
                <div class="about-us-img-wrap about-img-left">
                    <img src="<?php echo base_url('assets/img/others/home2.png')?>" alt="Tentang Chibomi">
                </div>
            </div>
            <div class="col-lg-6 align-self-center">
                <div class="about-us-info-wrap">
                    <div class="section-title-area ltn__section-title-2">
                        <h6 class="section-subtitle ltn__primary-color-4">Tentang Saya</h6>
                        <h1 class="section-title">Siapa itu Chibomi?</h1>
                        <p>Saya adalah seorang ilustrator digital yang suka menuangkan imajinasi ke dalam karya visual. Dari karakter lucu, pemandangan fantasi, hingga komisi personal, setiap karya saya dibuat dengan sentuhan hati.</p>
                    </div>
                    <p>Kamu bisa melihat berbagai karya saya di halaman portofolio, atau jika ingin berkolaborasi jangan ragu hubungi ya!</p>
                    <div class="about-author-info d-flex">
                        <div class="author-name-designation align-self-center mr-30">
                            <h4 class="mb-0">Chibomi</h4>
                            <small>/ ilustrator digital</small>
                        </div>
                    </div>
                    <div class="btn-wrapper animated">
                        <a href="<?= base_url('/kontak') ?>" class="theme-btn-4 btn btn-effect-1 text-uppercase">Hubungi Saya</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ABOUT US AREA END -->

<!-- PRODUCT TAB AREA START (product-item-3) -->
<div class="ltn__product-tab-area ltn__product-gutter pt-115 pb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title-area ltn__section-title-2 text-center">
                    <h1 class="section-title">Produk</h1>
                </div>
                <div class="row">
                    <!-- Item Produk -->
                    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                        <div class="ltn__product-item ltn__product-item-3 text-center h-100">
                            <div class="product-img">
                                <a href="#"><img src="<?php echo base_url('assets/img/product/1.png')?>" alt="Keychain Design"></a>
                                <!-- Optional badge -->
                                <!-- <div class="product-badge">
                                    <ul>
                                        <li class="sale-badge">New</li>
                                    </ul>
                                </div> -->
                                <div class="product-hover-action">
                                    <ul>
                                        <li>
                                            <a href="#" title="Quick View" data-bs-toggle="modal" data-bs-target="#quick_view_modal">
                                                <i class="far fa-eye"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" title="Add to Cart" data-bs-toggle="modal" data-bs-target="#add_to_cart_modal">
                                                <i class="fas fa-shopping-cart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-info">
                                <div class="product-ratting">
                                    <ul>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star-half-alt"></i></li>
                                        <li><i class="far fa-star"></i></li>
                                    </ul>
                                </div>
                                <h2 class="product-title"><a href="#">Gantungan Kunci Ilustrasi</a></h2>
                                <div class="product-price">
                                    <span>Rp25.000</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                        <div class="ltn__product-item ltn__product-item-3 text-center h-100">
                            <div class="product-img">
                                <a href="#"><img src="<?php echo base_url('assets/img/product/1.png')?>" alt="Keychain Design"></a>
                                <!-- Optional badge -->
                                <!-- <div class="product-badge">
                                    <ul>
                                        <li class="sale-badge">New</li>
                                    </ul>
                                </div> -->
                                <div class="product-hover-action">
                                    <ul>
                                        <li>
                                            <a href="#" title="Quick View" data-bs-toggle="modal" data-bs-target="#quick_view_modal">
                                                <i class="far fa-eye"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" title="Add to Cart" data-bs-toggle="modal" data-bs-target="#add_to_cart_modal">
                                                <i class="fas fa-shopping-cart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-info">
                                <div class="product-ratting">
                                    <ul>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star-half-alt"></i></li>
                                        <li><i class="far fa-star"></i></li>
                                    </ul>
                                </div>
                                <h2 class="product-title"><a href="#">Gantungan Kunci Ilustrasi</a></h2>
                                <div class="product-price">
                                    <span>Rp25.000</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                        <div class="ltn__product-item ltn__product-item-3 text-center h-100">
                            <div class="product-img">
                                <a href="#"><img src="<?php echo base_url('assets/img/product/1.png')?>" alt="Keychain Design"></a>
                                <!-- Optional badge -->
                                <!-- <div class="product-badge">
                                    <ul>
                                        <li class="sale-badge">New</li>
                                    </ul>
                                </div> -->
                                <div class="product-hover-action">
                                    <ul>
                                        <li>
                                            <a href="#" title="Quick View" data-bs-toggle="modal" data-bs-target="#quick_view_modal">
                                                <i class="far fa-eye"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" title="Add to Cart" data-bs-toggle="modal" data-bs-target="#add_to_cart_modal">
                                                <i class="fas fa-shopping-cart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-info">
                                <div class="product-ratting">
                                    <ul>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star-half-alt"></i></li>
                                        <li><i class="far fa-star"></i></li>
                                    </ul>
                                </div>
                                <h2 class="product-title"><a href="#">Gantungan Kunci Ilustrasi</a></h2>
                                <div class="product-price">
                                    <span>Rp25.000</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                        <div class="ltn__product-item ltn__product-item-3 text-center h-100">
                            <div class="product-img">
                                <a href="#"><img src="<?php echo base_url('assets/img/product/1.png')?>" alt="Keychain Design"></a>
                                <!-- Optional badge -->
                                <!-- <div class="product-badge">
                                    <ul>
                                        <li class="sale-badge">New</li>
                                    </ul>
                                </div> -->
                                <div class="product-hover-action">
                                    <ul>
                                        <li>
                                            <a href="#" title="Quick View" data-bs-toggle="modal" data-bs-target="#quick_view_modal">
                                                <i class="far fa-eye"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" title="Add to Cart" data-bs-toggle="modal" data-bs-target="#add_to_cart_modal">
                                                <i class="fas fa-shopping-cart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-info">
                                <div class="product-ratting">
                                    <ul>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star-half-alt"></i></li>
                                        <li><i class="far fa-star"></i></li>
                                    </ul>
                                </div>
                                <h2 class="product-title"><a href="#">Gantungan Kunci Ilustrasi</a></h2>
                                <div class="product-price">
                                    <span>Rp25.000</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- PRODUCT TAB AREA END -->

<!-- CATEGORY AREA START -->
<div class="ltn__category-area section-bg-1-- ltn__primary-bg before-bg-1 bg-image bg-overlay-theme-black-5--0 pt-115 pb-90" data-bg="<?php echo base_url('assets/img/bg/home4.png') ?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title-area ltn__section-title-2 text-center">
                    <h1 class="section-title white-color">Kategori Produk</h1>
                </div>
            </div>
        </div>
        <div class="row ltn__category-slider-active slick-arrow-1">
            <div class="col-12">
                <div class="ltn__category-item ltn__category-item-3 text-center">
                    <div class="ltn__category-item-img">
                        <a href="<?php echo base_url('shop') ?>">
                            <img src="<?php echo base_url('assets/img/product/2.png') ?>" alt="Semua Produk">
                        </a>
                    </div>
                    <div class="ltn__category-item-name">
                        <h5><a href="<?php echo base_url('shop') ?>">Semua Produk</a></h5>
                        <h6>(Semua item)</h6>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="ltn__category-item ltn__category-item-3 text-center">
                    <div class="ltn__category-item-img">
                        <a href="<?php echo base_url('shop/gantungan-kunci') ?>">
                            <img src="<?php echo base_url('assets/img/product/2.png') ?>" alt="Gantungan Kunci">
                        </a>
                    </div>
                    <div class="ltn__category-item-name">
                        <h5><a href="<?php echo base_url('shop/gantungan-kunci') ?>">Gantungan Kunci</a></h5>
                        <h6>(xx item)</h6>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="ltn__category-item ltn__category-item-3 text-center">
                    <div class="ltn__category-item-img">
                        <a href="<?php echo base_url('shop/stiker') ?>">
                            <img src="<?php echo base_url('assets/img/product/2.png') ?>" alt="Stiker">
                        </a>
                    </div>
                    <div class="ltn__category-item-name">
                        <h5><a href="<?php echo base_url('shop/stiker') ?>">Stiker</a></h5>
                        <h6>(xx item)</h6>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="ltn__category-item ltn__category-item-3 text-center">
                    <div class="ltn__category-item-img">
                        <a href="<?php echo base_url('shop/poster') ?>">
                            <img src="<?php echo base_url('assets/img/product/2.png') ?>" alt="Poster">
                        </a>
                    </div>
                    <div class="ltn__category-item-name">
                        <h5><a href="<?php echo base_url('shop/poster') ?>">Poster</a></h5>
                        <h6>(xx item)</h6>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="ltn__category-item ltn__category-item-3 text-center">
                    <div class="ltn__category-item-img">
                        <a href="<?php echo base_url('shop/jasa-desain') ?>">
                            <img src="<?php echo base_url('assets/img/product/2.png') ?>" alt="Jasa Desain">
                        </a>
                    </div>
                    <div class="ltn__category-item-name">
                        <h5><a href="<?php echo base_url('shop/jasa-desain') ?>">Jasa Desain</a></h5>
                        <h6>(xx item)</h6>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="ltn__category-item ltn__category-item-3 text-center">
                    <div class="ltn__category-item-img">
                        <a href="<?php echo base_url('shop/custom') ?>">
                            <img src="<?php echo base_url('assets/img/product/2.png') ?>" alt="Produk Custom">
                        </a>
                    </div>
                    <div class="ltn__category-item-name">
                        <h5><a href="<?php echo base_url('shop/custom') ?>">Produk Custom</a></h5>
                        <h6>(xx item)</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- CATEGORY AREA END -->

<!-- COUNTER UP AREA START -->
<!-- <div class="ltn__counterup-area bg-image bg-overlay-theme-black-80 pt-115 pb-70" data-bg="img/bg/5.jpg">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6 align-self-center">
                <div class="ltn__counterup-item-3 text-color-white text-center">
                    <div class="counter-icon"> <img src="<?php echo base_url('assets/img/icons/icon-img/2.png') ?>" alt="#"> </div>
                    <h1><span class="counter">733</span><span class="counterUp-icon">+</span> </h1>
                    <h6>Active Clients</h6>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 align-self-center">
                <div class="ltn__counterup-item-3 text-color-white text-center">
                    <div class="counter-icon"> <img src="<?php echo base_url('assets/img/icons/icon-img/3.png') ?>" alt="#"> </div>
                    <h1><span class="counter">33</span><span class="counterUp-letter">K</span><span class="counterUp-icon">+</span> </h1>
                    <h6>Cup Of Coffee</h6>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 align-self-center">
                <div class="ltn__counterup-item-3 text-color-white text-center">
                    <div class="counter-icon"> <img src="<?php echo base_url('assets/img/icons/icon-img/4.png') ?>" alt="#"> </div>
                    <h1><span class="counter">100</span><span class="counterUp-icon">+</span> </h1>
                    <h6>Get Rewards</h6>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 align-self-center">
                <div class="ltn__counterup-item-3 text-color-white text-center">
                    <div class="counter-icon"> <img src="<?php echo base_url('assets/img/icons/icon-img/5.png') ?>" alt="#"> </div>
                    <h1><span class="counter">21</span><span class="counterUp-icon">+</span> </h1>
                    <h6>Country Cover</h6>
                </div>
            </div>
        </div>
    </div>
</div> -->
<!-- COUNTER UP AREA END -->

<!-- PRODUCT AREA START (product-item-3) -->
<!-- <div class="ltn__product-area ltn__product-gutter pt-115 pb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title-area ltn__section-title-2 text-center">
                    <h1 class="section-title">Featured Products</h1>
                </div>
            </div>
        </div>
        <div class="row ltn__tab-product-slider-one-active--- slick-arrow-1">
            <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="ltn__product-item ltn__product-item-3 text-left">
                    <div class="product-img">
                        <a href="product-details.html"><img src="<?php echo base_url('assets/img/product/1.png') ?>" alt="#"></a>
                        <div class="product-badge">
                            <ul>
                                <li class="sale-badge">New</li>
                            </ul>
                        </div>
                        <div class="product-hover-action">
                            <ul>
                                <li>
                                    <a href="#" title="Quick View" data-bs-toggle="modal" data-bs-target="#quick_view_modal">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Add to Cart" data-bs-toggle="modal" data-bs-target="#add_to_cart_modal">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Wishlist" data-bs-toggle="modal" data-bs-target="#liton_wishlist_modal">
                                        <i class="far fa-heart"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-ratting">
                            <ul>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                <li><a href="#"><i class="far fa-star"></i></a></li>
                            </ul>
                        </div>
                        <h2 class="product-title"><a href="product-details.html">Carrots Group Scal</a></h2>
                        <div class="product-price">
                            <span>$32.00</span>
                            <del>$46.00</del>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="ltn__product-item ltn__product-item-3 text-left">
                    <div class="product-img">
                        <a href="product-details.html"><img src="<?php echo base_url('assets/img/product/2.png') ?>" alt="#"></a>
                        <div class="product-hover-action">
                            <ul>
                                <li>
                                    <a href="#" title="Quick View" data-bs-toggle="modal" data-bs-target="#quick_view_modal">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Add to Cart" data-bs-toggle="modal" data-bs-target="#add_to_cart_modal">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Wishlist" data-bs-toggle="modal" data-bs-target="#liton_wishlist_modal">
                                        <i class="far fa-heart"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-ratting">
                            <ul>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                <li><a href="#"><i class="far fa-star"></i></a></li>
                            </ul>
                        </div>
                        <h2 class="product-title"><a href="product-details.html">Red Hot Tomato</a></h2>
                        <div class="product-price">
                            <span>$25.00</span>
                            <del>$35.00</del>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="ltn__product-item ltn__product-item-3 text-center">
                    <div class="product-img">
                        <a href="product-details.html"><img src="<?php echo base_url('assets/img/product/3.png') ?>" alt="#"></a>
                        <div class="product-badge">
                            <ul>
                                <li class="sale-badge">New</li>
                            </ul>
                        </div>
                        <div class="product-hover-action">
                            <ul>
                                <li>
                                    <a href="#" title="Quick View" data-bs-toggle="modal" data-bs-target="#quick_view_modal">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Add to Cart" data-bs-toggle="modal" data-bs-target="#add_to_cart_modal">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Wishlist" data-bs-toggle="modal" data-bs-target="#liton_wishlist_modal">
                                        <i class="far fa-heart"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-ratting">
                            <ul>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                <li><a href="#"><i class="far fa-star"></i></a></li>
                            </ul>
                        </div>
                        <h2 class="product-title"><a href="product-details.html">Orange Fresh Juice</a></h2>
                        <div class="product-price">
                            <span>$75.00</span>
                            <del>$92.00</del>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="ltn__product-item ltn__product-item-3 text-center">
                    <div class="product-img">
                        <a href="product-details.html"><img src="<?php echo base_url('assets/img/product/4.png') ?>" alt="#"></a>
                        <div class="product-badge">
                            <ul>
                                <li class="sale-badge">New</li>
                            </ul>
                        </div>
                        <div class="product-hover-action">
                            <ul>
                                <li>
                                    <a href="#" title="Quick View" data-bs-toggle="modal" data-bs-target="#quick_view_modal">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Add to Cart" data-bs-toggle="modal" data-bs-target="#add_to_cart_modal">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Wishlist" data-bs-toggle="modal" data-bs-target="#liton_wishlist_modal">
                                        <i class="far fa-heart"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-ratting">
                            <ul>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                <li><a href="#"><i class="far fa-star"></i></a></li>
                            </ul>
                        </div>
                        <h2 class="product-title"><a href="product-details.html">Poltry Farm Meat</a></h2>
                        <div class="product-price">
                            <span>$78.00</span>
                            <del>$85.00</del>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="ltn__product-item ltn__product-item-3 text-center">
                    <div class="product-img">
                        <a href="product-details.html"><img src="<?php echo base_url('assets/img/product/5.png') ?>" alt="#"></a>
                        <div class="product-badge">
                            <ul>
                                <li class="sale-badge">New</li>
                            </ul>
                        </div>
                        <div class="product-hover-action">
                            <ul>
                                <li>
                                    <a href="#" title="Quick View" data-bs-toggle="modal" data-bs-target="#quick_view_modal">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Add to Cart" data-bs-toggle="modal" data-bs-target="#add_to_cart_modal">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Wishlist" data-bs-toggle="modal" data-bs-target="#liton_wishlist_modal">
                                        <i class="far fa-heart"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-ratting">
                            <ul>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                <li><a href="#"><i class="far fa-star"></i></a></li>
                            </ul>
                        </div>
                        <h2 class="product-title"><a href="product-details.html">Fresh Butter Cake</a></h2>
                        <div class="product-price">
                            <span>$150.00</span>
                            <del>$180.00</del>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="ltn__product-item ltn__product-item-3 text-center">
                    <div class="product-img">
                        <a href="product-details.html"><img src="<?php echo base_url('assets/img/product/6.png') ?>" alt="#"></a>
                        <div class="product-badge">
                            <ul>
                                <li class="sale-badge">New</li>
                            </ul>
                        </div>
                        <div class="product-hover-action">
                            <ul>
                                <li>
                                    <a href="#" title="Quick View" data-bs-toggle="modal" data-bs-target="#quick_view_modal">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Add to Cart" data-bs-toggle="modal" data-bs-target="#add_to_cart_modal">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Wishlist" data-bs-toggle="modal" data-bs-target="#liton_wishlist_modal">
                                        <i class="far fa-heart"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-ratting">
                            <ul>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                <li><a href="#"><i class="far fa-star"></i></a></li>
                            </ul>
                        </div>
                        <h2 class="product-title"><a href="product-details.html">Orange Sliced Mix</a></h2>
                        <div class="product-price">
                            <span>$150.00</span>
                            <del>$180.00</del>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="ltn__product-item ltn__product-item-3 text-center">
                    <div class="product-img">
                        <a href="product-details.html"><img src="<?php echo base_url('assets/img/product/7.png') ?>" alt="#"></a>
                        <div class="product-badge">
                            <ul>
                                <li class="sale-badge">New</li>
                            </ul>
                        </div>
                        <div class="product-hover-action">
                            <ul>
                                <li>
                                    <a href="#" title="Quick View" data-bs-toggle="modal" data-bs-target="#quick_view_modal">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Add to Cart" data-bs-toggle="modal" data-bs-target="#add_to_cart_modal">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Wishlist" data-bs-toggle="modal" data-bs-target="#liton_wishlist_modal">
                                        <i class="far fa-heart"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-ratting">
                            <ul>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                <li><a href="#"><i class="far fa-star"></i></a></li>
                            </ul>
                        </div>
                        <h2 class="product-title"><a href="product-details.html">Orange Fresh Juice</a></h2>
                        <div class="product-price">
                            <span>$75.00</span>
                            <del>$92.00</del>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="ltn__product-item ltn__product-item-3 text-center">
                    <div class="product-img">
                        <a href="product-details.html"><img src="<?php echo base_url('assets/img/product/8.png') ?>" alt="#"></a>
                        <div class="product-badge">
                            <ul>
                                <li class="sale-badge">New</li>
                            </ul>
                        </div>
                        <div class="product-hover-action">
                            <ul>
                                <li>
                                    <a href="#" title="Quick View" data-bs-toggle="modal" data-bs-target="#quick_view_modal">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Add to Cart" data-bs-toggle="modal" data-bs-target="#add_to_cart_modal">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Wishlist" data-bs-toggle="modal" data-bs-target="#liton_wishlist_modal">
                                        <i class="far fa-heart"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-ratting">
                            <ul>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                <li><a href="#"><i class="far fa-star"></i></a></li>
                            </ul>
                        </div>
                        <h2 class="product-title"><a href="product-details.html">Poltry Farm Meat</a></h2>
                        <div class="product-price">
                            <span>$78.00</span>
                            <del>$85.00</del>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
<!-- PRODUCT AREA END -->

<!-- CALL TO ACTION START (call-to-action-4) -->
<!-- <div class="ltn__call-to-action-area ltn__call-to-action-4 bg-image pt-115 pb-120" data-bg="img/bg/6.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="call-to-action-inner call-to-action-inner-4 text-center">
                    <div class="section-title-area ltn__section-title-2">
                        <h6 class="section-subtitle ltn__secondary-color">//  any question you have  //</h6>
                        <h1 class="section-title white-color">897-876-987-90</h1>
                    </div>
                    <div class="btn-wrapper">
                        <a href="tel:+123456789" class="theme-btn-1 btn btn-effect-1">MAKE A CALL</a>
                        <a href="contact.html" class="btn btn-transparent btn-effect-4 white-color">CONTACT US</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ltn__call-to-4-img-1">
        <img src="<?php echo base_url('assets/img/bg/12.png') ?>" alt="#">
    </div>
    <div class="ltn__call-to-4-img-2">
        <img src="<?php echo base_url('assets/img/bg/1.png') ?>" alt="#">
    </div>
</div> -->
<!-- CALL TO ACTION END -->

<!-- BLOG AREA START (blog-3) -->
<!-- <div class="ltn__blog-area pt-115 pb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title-area ltn__section-title-2 text-center">
                    <h1 class="section-title white-color---">Leatest Blog</h1>
                </div>
            </div>
        </div>
        <div class="row  ltn__blog-slider-one-active slick-arrow-1 ltn__blog-item-3-normal">
            <div class="col-lg-12">
                <div class="ltn__blog-item ltn__blog-item-3">
                    <div class="ltn__blog-img">
                        <a href="blog-details.html"><img src="<?php echo base_url('assets/img/blog/1.jpg') ?>" alt="#"></a>
                    </div>
                    <div class="ltn__blog-brief">
                        <div class="ltn__blog-meta">
                            <ul>
                                <li class="ltn__blog-author">
                                    <a href="#"><i class="far fa-user"></i>by: Admin</a>
                                </li>
                                <li class="ltn__blog-tags">
                                    <a href="#"><i class="fas fa-tags"></i>Services</a>
                                </li>
                            </ul>
                        </div>
                        <h3 class="ltn__blog-title"><a href="blog-details.html">Common Engine Oil Problems and Solutions</a></h3>
                        <div class="ltn__blog-meta-btn">
                            <div class="ltn__blog-meta">
                                <ul>
                                    <li class="ltn__blog-date"><i class="far fa-calendar-alt"></i>June 24, 2020</li>
                                </ul>
                            </div>
                            <div class="ltn__blog-btn">
                                <a href="blog-details.html">Read more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="ltn__blog-item ltn__blog-item-3">
                    <div class="ltn__blog-img">
                        <a href="blog-details.html"><img src="<?php echo base_url('assets/img/blog/2.jpg') ?>" alt="#"></a>
                    </div>
                    <div class="ltn__blog-brief">
                        <div class="ltn__blog-meta">
                            <ul>
                                <li class="ltn__blog-author">
                                    <a href="#"><i class="far fa-user"></i>by: Admin</a>
                                </li>
                                <li class="ltn__blog-tags">
                                    <a href="#"><i class="fas fa-tags"></i>Services</a>
                                </li>
                            </ul>
                        </div>
                        <h3 class="ltn__blog-title"><a href="blog-details.html">How and when to replace brake rotors</a></h3>
                        <div class="ltn__blog-meta-btn">
                            <div class="ltn__blog-meta">
                                <ul>
                                    <li class="ltn__blog-date"><i class="far fa-calendar-alt"></i>July 23, 2020</li>
                                </ul>
                            </div>
                            <div class="ltn__blog-btn">
                                <a href="blog-details.html">Read more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="ltn__blog-item ltn__blog-item-3">
                    <div class="ltn__blog-img">
                        <a href="blog-details.html"><img src="<?php echo base_url('assets/img/blog/3.jpg') ?>" alt="#"></a>
                    </div>
                    <div class="ltn__blog-brief">
                        <div class="ltn__blog-meta">
                            <ul>
                                <li class="ltn__blog-author">
                                    <a href="#"><i class="far fa-user"></i>by: Admin</a>
                                </li>
                                <li class="ltn__blog-tags">
                                    <a href="#"><i class="fas fa-tags"></i>Services</a>
                                </li>
                            </ul>
                        </div>
                        <h3 class="ltn__blog-title"><a href="blog-details.html">Elenance, Servicing & Repairs</a></h3>
                        <div class="ltn__blog-meta-btn">
                            <div class="ltn__blog-meta">
                                <ul>
                                    <li class="ltn__blog-date"><i class="far fa-calendar-alt"></i>August 22, 2020</li>
                                </ul>
                            </div>
                            <div class="ltn__blog-btn">
                                <a href="blog-details.html">Read more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="ltn__blog-item ltn__blog-item-3">
                    <div class="ltn__blog-img">
                        <a href="blog-details.html"><img src="<?php echo base_url('assets/img/blog/4.jpg') ?>" alt="#"></a>
                    </div>
                    <div class="ltn__blog-brief">
                        <div class="ltn__blog-meta">
                            <ul>
                                <li class="ltn__blog-author">
                                    <a href="#"><i class="far fa-user"></i>by: Admin</a>
                                </li>
                                <li class="ltn__blog-tags">
                                    <a href="#"><i class="fas fa-tags"></i>Services</a>
                                </li>
                            </ul>
                        </div>
                        <h3 class="ltn__blog-title"><a href="blog-details.html">Healthiest Vegetables on Earth</a></h3>
                        <div class="ltn__blog-meta-btn">
                            <div class="ltn__blog-meta">
                                <ul>
                                    <li class="ltn__blog-date"><i class="far fa-calendar-alt"></i>June 24, 2020</li>
                                </ul>
                            </div>
                            <div class="ltn__blog-btn">
                                <a href="blog-details.html">Read more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="ltn__blog-item ltn__blog-item-3">
                    <div class="ltn__blog-img">
                        <a href="blog-details.html"><img src="<?php echo base_url('assets/img/blog/5.jpg') ?>" alt="#"></a>
                    </div>
                    <div class="ltn__blog-brief">
                        <div class="ltn__blog-meta">
                            <ul>
                                <li class="ltn__blog-author">
                                    <a href="#"><i class="far fa-user"></i>by: Admin</a>
                                </li>
                                <li class="ltn__blog-tags">
                                    <a href="#"><i class="fas fa-tags"></i>Services</a>
                                </li>
                            </ul>
                        </div>
                        <h3 class="ltn__blog-title"><a href="blog-details.html">How te Your Tires Last Longer</a></h3>
                        <div class="ltn__blog-meta-btn">
                            <div class="ltn__blog-meta">
                                <ul>
                                    <li class="ltn__blog-date"><i class="far fa-calendar-alt"></i>June 24, 2020</li>
                                </ul>
                            </div>
                            <div class="ltn__blog-btn">
                                <a href="blog-details.html">Read more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
<!-- BLOG AREA END -->

<!-- FEATURE AREA START ( Feature - 3) -->
<!-- <div class="ltn__feature-area before-bg-bottom-2-- mb--30--- plr--5 mb-120">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__feature-item-box-wrap ltn__border-between-column white-bg">
                    <div class="row">
                        <div class="col-xl-3 col-md-6 col-12">
                            <div class="ltn__feature-item ltn__feature-item-8">
                                <div class="ltn__feature-icon">
                                    <img src="<?php echo base_url('assets/img/icons/icon-img/1.png') ?>" alt="#">
                                </div>
                                <div class="ltn__feature-info">
                                    <h4>Curated Products</h4>
                                    <p>Provide Curated Products for
                                        all product over $100</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-12">
                            <div class="ltn__feature-item ltn__feature-item-8">
                                <div class="ltn__feature-icon">
                                    <img src="<?php echo base_url('assets/img/icons/icon-img/12.png') ?>" alt="#">
                                </div>
                                <div class="ltn__feature-info">
                                    <h4>Handmade</h4>
                                    <p>We ensure the product quality
                                        that is our main goal</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-12">
                            <div class="ltn__feature-item ltn__feature-item-8">
                                <div class="ltn__feature-icon">
                                    <img src="<?php echo base_url('assets/img/icons/icon-img/13.png') ?>" alt="#">
                                </div>
                                <div class="ltn__feature-info">
                                    <h4>Natural Food</h4>
                                    <p>Return product within 3 days
                                        for any product you buy</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-12">
                            <div class="ltn__feature-item ltn__feature-item-8">
                                <div class="ltn__feature-icon">
                                    <img src="<?php echo base_url('assets/img/icons/icon-img/14.png') ?>" alt="#">
                                </div>
                                <div class="ltn__feature-info">
                                    <h4>Free home delivery</h4>
                                    <p>We ensure the product quality
                                        that you can trust easily</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
<!-- FEATURE AREA END -->

<!-- FAQ AREA START (faq-2) (ID > accordion_2) -->
<div class="ltn__faq-area mb-100 pt-90 id="faq">
    <div class="container">
        <div class="section-title-area ltn__section-title-2 text-center">
            <h1 class="section-title">FAQ</h1>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="ltn__faq-inner ltn__faq-inner-2">
                    <div id="accordion_2">
                        <!-- card -->
                        <div class="card">
                            <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-1" aria-expanded="false">
                                Bagaimana cara membeli produk di Chibomi?
                            </h6>
                            <div id="faq-item-2-1" class="collapse" data-parent="#accordion_2">
                                <div class="card-body">
                                    <p>Pilih produk yang Anda inginkan, tambahkan ke keranjang belanja, lalu lanjutkan ke proses checkout. Isi informasi pengiriman, pilih metode pembayaran, dan selesaikan transaksi.</p>
                                </div>
                            </div>
                        </div>
                        <!-- card -->
                        <div class="card">
                            <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-2" aria-expanded="false">
                                Bagaimana cara melakukan pengembalian dana?
                            </h6>
                            <div id="faq-item-2-2" class="collapse" data-parent="#accordion_2">
                                <div class="card-body">
                                    <p>Silakan hubungi tim layanan pelanggan kami melalui halaman <a href="<?= base_url('/kontak') ?>">Kontak</a> untuk mengajukan pengembalian dana. Permintaan refund berlaku maksimal 7 hari setelah barang diterima, dengan syarat dan ketentuan berlaku.</p>
                                </div>
                            </div>
                        </div>
                        <!-- card -->
                        <div class="card">
                            <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-3" aria-expanded="false">
                                Saya pengguna baru. Bagaimana cara memulai?
                            </h6>
                            <div id="faq-item-2-3" class="collapse" data-parent="#accordion_2">
                                <div class="card-body">
                                    <p>Silakan daftar akun terlebih dahulu. Setelah itu, Anda dapat menelusuri produk, menambahkan ke keranjang, dan melakukan pembelian. Akun Anda akan mencatat histori pesanan dan rekomendasi produk.</p>
                                </div>
                            </div>
                        </div>
                        <!-- card -->
                        <div class="card">
                            <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-4" aria-expanded="false">
                                Apakah informasi pribadi saya aman?
                            </h6>
                            <div id="faq-item-2-4" class="collapse" data-parent="#accordion_2">
                                <div class="card-body">
                                    <p>Ya, Chibomi menggunakan sistem enkripsi dan kebijakan privasi yang ketat untuk menjaga keamanan data pribadi Anda. Kami tidak akan membagikan informasi kepada pihak ketiga tanpa persetujuan Anda.</p>
                                </div>
                            </div>
                        </div>
                        <!-- card -->
                        <div class="card">
                            <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-6" aria-expanded="false">
                                Metode pembayaran apa saja yang tersedia?
                            </h6>
                            <div id="faq-item-2-6" class="collapse" data-parent="#accordion_2">
                                <div class="card-body">
                                    <p>Chibomi mendukung pembayaran melalui transfer bank, e-wallet (OVO, DANA, GoPay), kartu kredit, serta pembayaran instan melalui payment gateway yang tersedia saat checkout.</p>
                                </div>
                            </div>
                        </div>
                        <!-- card -->
                        <div class="card">
                            <h6 class="collapsed ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-7" aria-expanded="false">
                                Bagaimana cara melihat status pesanan saya?
                            </h6>
                            <div id="faq-item-2-7" class="collapse" data-parent="#accordion_2">
                                <div class="card-body">
                                    <p>Masuk ke akun Anda, lalu buka menu “Pesanan Saya”. Di sana Anda bisa melihat status terkini, termasuk apakah pesanan sedang dikemas, dikirim, atau telah sampai.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="need-support text-center mt-100">
                        <h2>Masih butuh bantuan? Tim kami siap 24/7:</h2>
                        <div class="btn-wrapper mb-30">
                            <a href="<?= base_url('/kontak') ?>" class="theme-btn-4 btn">Hubungi Kami</a>
                        </div>
                        <h3><i class="fas fa-phone"></i> +62-812-3456-7890</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <aside class="sidebar-area ltn__right-sidebar">
                    <!-- Banner Widget -->
                    <div class="widget ltn__banner-widget">
                        <a href="shop.html"><img src="<?php echo base_url('assets/img/banner/home3.png')?>" alt="Banner Image"></a>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</div>
<!-- FAQ AREA END -->

<!-- MODAL AREA START (Quick View Modal) -->
<div class="ltn__modal-area ltn__quick-view-modal-area">
    <div class="modal fade" id="quick_view_modal" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <!-- <i class="fas fa-times"></i> -->
                    </button>
                </div>
                <div class="modal-body">
                        <div class="ltn__quick-view-modal-inner">
                            <div class="modal-product-item">
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <div class="modal-product-img">
                                        <img src="<?php echo base_url('assets/img/product/4.png')?>" alt="#">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="modal-product-info">
                                        <div class="product-ratting">
                                            <ul>
                                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                                <li><a href="#"><i class="far fa-star"></i></a></li>
                                                <li class="review-total"> <a href="#"> ( 95 Reviews )</a></li>
                                            </ul>
                                        </div>
                                        <h3>Vegetables Juices</h3>
                                        <div class="product-price">
                                            <span>$149.00</span>
                                            <del>$165.00</del>
                                        </div>
                                        <div class="modal-product-meta ltn__product-details-menu-1">
                                            <ul>
                                                <li>
                                                    <strong>Categories:</strong> 
                                                    <span>
                                                        <a href="#">Parts</a>
                                                        <a href="#">Car</a>
                                                        <a href="#">Seat</a>
                                                        <a href="#">Cover</a>
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="ltn__product-details-menu-2">
                                            <ul>
                                                <li>
                                                    <div class="cart-plus-minus">
                                                        <input type="text" value="02" name="qtybutton" class="cart-plus-minus-box">
                                                    </div>
                                                </li>
                                                <li>
                                                    <a href="#" class="theme-btn-1 btn btn-effect-1" title="Add to Cart" data-bs-toggle="modal" data-bs-target="#add_to_cart_modal">
                                                        <i class="fas fa-shopping-cart"></i>
                                                        <span>ADD TO CART</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="ltn__product-details-menu-3">
                                            <ul>
                                                <li>
                                                    <a href="#" class="" title="Wishlist" data-bs-toggle="modal" data-bs-target="#liton_wishlist_modal">
                                                        <i class="far fa-heart"></i>
                                                        <span>Add to Wishlist</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="" title="Compare" data-bs-toggle="modal" data-bs-target="#quick_view_modal">
                                                        <i class="fas fa-exchange-alt"></i>
                                                        <span>Compare</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="ltn__social-media">
                                            <ul>
                                                <li>Share:</li>
                                                <li><a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                                                <li><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                                                <li><a href="#" title="Linkedin"><i class="fab fa-linkedin"></i></a></li>
                                                <li><a href="#" title="Instagram"><i class="fab fa-instagram"></i></a></li>
                                                
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- MODAL AREA END -->

<!-- MODAL AREA START (Add To Cart Modal) -->
<div class="ltn__modal-area ltn__add-to-cart-modal-area">
    <div class="modal fade" id="add_to_cart_modal" tabindex="-1">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="ltn__quick-view-modal-inner">
                            <div class="modal-product-item">
                            <div class="row">
                                <div class="col-12">
                                    <div class="modal-product-img">
                                        <img src="<?php echo base_url('assets/img/product/1.png')?>" alt="#">
                                    </div>
                                        <div class="modal-product-info">
                                        <h5><a href="product-details.html">Vegetables Juices</a></h5>
                                        <p class="added-cart"><i class="fa fa-check-circle"></i>  Successfully added to your Cart</p>
                                        <div class="btn-wrapper">
                                            <a href="cart.html" class="theme-btn-1 btn btn-effect-1">View Cart</a>
                                            <a href="checkout.html" class="theme-btn-2 btn btn-effect-2">Checkout</a>
                                        </div>
                                        </div>
                                </div>
                            </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- MODAL AREA END -->

<?php echo view('master\footer'); ?>