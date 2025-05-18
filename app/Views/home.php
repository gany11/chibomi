<?php
echo view('master/header', [
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
                        <div class="col-lg-12 align-self-center p-5">
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
                    <?php foreach ($produk as $produk): ?>
                        <div class="col-xl-3 col-sm-6 col-6 mb-4">
                            <div class="ltn__product-item ltn__product-item-3 text-center h-100">
                                <div class="product-img">
                                    <a href="<?= base_url('/produk/detail/' . $produk['slug']) ?>">
                                        <img src="<?= base_url('assets/img/product/' . ($produk['image_file'] ?? '1.png')) ?>" alt="<?= esc($produk['nama_produk']) ?>">
                                    </a>
                                    <!-- Optional Badge -->
                                    <div class="product-badge">
                                        <ul>
                                            <!-- Tambahkan badge jika diperlukan -->
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <div class="product-ratting">
                                        <ul>
                                            <?php
                                                $rating = round($produk['avg_rating']);
                                                for ($i = 1; $i <= 5; $i++):
                                                    if ($i <= $rating):
                                                        echo '<li><i class="fas fa-star"></i></li>';
                                                    else:
                                                        echo '<li><i class="far fa-star"></i></li>';
                                                    endif;
                                                endfor;
                                            ?>
                                        </ul>
                                    </div>
                                    <h2 class="product-title">
                                        <a href="<?= base_url('/produk/detail/' . $produk['slug']) ?>">
                                            <?= $produk['jenis'] === 'Jasa' ? '[Jasa] ' : '' ?><?= esc($produk['nama_produk']) ?>
                                        </a>
                                    </h2>
                                    <div class="product-price">
                                        <span>Rp<?= number_format($produk['price_unit'], 0, ',', '.') ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- PRODUCT TAB AREA END -->


<!-- PORTOFOLIO AREA START -->
<div class="ltn__product-area ltn__product-gutter before-bg-2 pt-115 pb-90">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title-area ltn__section-title-2 text-center">
                    <h1 class="section-title">Portofolio</h1>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="liton_portofolio_grid">
                        <div class="ltn__product-tab-content-inner ltn__product-grid-view">
                            <div class="row">
                                <?php if (!empty($portofolio)): ?>
                                    <?php foreach ($portofolio as $item): ?>
                                        <div class="col-xl-3 col-lg-4 col-sm-6 col-6">
                                            <div class="ltn__product-item ltn__product-item-3 text-center">
                                                <div class="product-img">
                                                    <a href="<?= base_url('/portofolio/detail/' . $item['slug']) ?>">
                                                        <img src="<?= base_url('assets/img/portofolio/' . ($item['file'] ?? '1.png')) ?>" alt="<?= esc($item['judul']) ?>">
                                                    </a>
                                                </div>
                                                <div class="product-info">
                                                    <h2 class="product-title">
                                                        <a href="<?= base_url('/portofolio/detail/' . $item['slug']) ?>">
                                                            <?= esc($item['judul']) ?>
                                                        </a>
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="col-12 text-center">
                                        <p>Portofolio belum tersedia.</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- PORTOFOLIO AREA END -->

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
                        <h3><i class="fas fa-phone"></i> <a href="https://wa.me/6287873504007">+62-878-7350-4007</a></h3>
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

<?php echo view('master/footer'); ?>