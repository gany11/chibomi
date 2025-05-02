<?php
echo view('master\header', [
    'title' => 'Detail Produk'
]);?>

<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area ltn__breadcrumb-area-2 ltn__breadcrumb-color-white bg-image" data-bg="<?= base_url('assets/img/bg/breadcrumb.png') ?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner ltn__breadcrumb-inner-2 justify-content-between">
                    <div class="section-title-area ltn__section-title-2">
                        <h1 class="section-title black-color">Detail Produk</h1>
                    </div>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="<?= base_url('/') ?>">Beranda</a></li>
                            <li><a href="<?= base_url('/produk') ?>">Produk</a></li>
                            <li>Detail Produk</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->

<!-- SHOP DETAILS AREA START -->
<div class="ltn__shop-details-area pb-85">
    <div class="container">
        <div class="row">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
            <div class="col-lg-12 col-md-12">
                <div class="ltn__shop-details-inner mb-60">
                    <div class="row">
                        <!-- Gambar Produk -->
                        <div class="col-md-6">
                            <div class="ltn__shop-details-img-gallery">
                                <div class="ltn__shop-details-large-img">
                                    <?php foreach ($images as $file): ?>
                                        <div class="single-large-img">
                                            <a href="<?= base_url('assets/img/product/' . $file) ?>" data-rel="lightcase:myCollection">
                                                <img src="<?= base_url('assets/img/product/' . $file) ?>" alt="Image">
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="ltn__shop-details-small-img slick-arrow-2">
                                    <?php foreach ($images as $file): ?>
                                        <div class="single-small-img">
                                            <img src="<?= base_url('assets/img/product/' . $file) ?>" alt="Image">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Produk -->
                        <div class="col-md-6">
                            <div class="modal-product-info shop-details-info pl-0">
                                <div class="product-ratting">
                                    <?php
                                        $bintang = round($ratingAvg['avg_rating'] ?? 0, 1);
                                        $fullStars = floor($bintang);
                                        $halfStar = ($bintang - $fullStars >= 0.5);
                                    ?>
                                    <ul>
                                        <?php for ($i = 0; $i < $fullStars; $i++): ?>
                                            <li><a href="#"><i class="fas fa-star"></i></a></li>
                                        <?php endfor; ?>
                                        <?php if ($halfStar): ?>
                                            <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                        <?php endif; ?>
                                        <?php for ($i = $fullStars + $halfStar; $i < 5; $i++): ?>
                                            <li><a href="#"><i class="far fa-star"></i></a></li>
                                        <?php endfor; ?>
                                        <li class="review-total">
                                            ( <?= count($ulasan) ?> Ulasan )
                                        </li>
                                    </ul>
                                </div>
                                <h3><?= esc($produk['nama_produk']) ?></h3>
                                <div class="product-price">
                                    <span>Rp<?= number_format($harga['price_unit'], 0, ',', '.') ?></span>
                                </div>
                                <div class="modal-product-meta ltn__product-details-menu-1">
                                    <ul>
                                        <li>
                                            <strong>Kategori:</strong>
                                            <span><?= esc($produk['kategori'] ?? '-') ?></span>
                                        </li>
                                        <li>
                                            <strong>Tag:</strong>
                                            <span><?= esc($produk['tag'] ?? '-') ?></span>
                                        </li>
                                        <li>
                                            <strong>Jenis:</strong>
                                            <span><?= esc($produk['jenis'] ?? '-') ?></span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="ltn__product-details-menu-2">
                                    <form action="<?= base_url('cart/add') ?>" method="post">
                                        <input type="hidden" name="product_id" value="<?= $produk['id_product'] ?>">
                                        <ul>
                                            <li>
                                                <div class="cart-plus-minus">
                                                    <input type="number" name="qty" class="cart-plus-minus-box" value="1" min="1">
                                                </div>
                                            </li>
                                            <li>
                                                <button type="submit" class="theme-btn-1 btn btn-effect-1">
                                                    <i class="fas fa-shopping-cart"></i>
                                                    <span>Tambah Ke Keranjang</span>
                                                </button>
                                            </li>
                                        </ul>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shop Tab Start -->
                <div class="ltn__shop-details-tab-inner ltn__shop-details-tab-inner-2">
                    <div class="ltn__shop-details-tab-menu">
                        <div class="nav">
                            <a class="active show" data-bs-toggle="tab" href="#liton_tab_details_1_1">Deskripsi</a>
                            <a data-bs-toggle="tab" href="#liton_tab_details_1_2">Ulasan</a>
                        </div>
                    </div>
                    <div class="tab-content">
                        <!-- Deskripsi Produk -->
                        <div class="tab-pane fade active show" id="liton_tab_details_1_1">
                            <div class="ltn__shop-details-tab-content-inner">
                                <h4 class="title-2">Deskripsi Produk</h4>
                                <p><?= nl2br(($produk['deskripsi'])) ?></p>
                            </div>
                        </div>

                        <!-- Ulasan Produk -->
                        <div class="tab-pane fade" id="liton_tab_details_1_2">
                            <div class="ltn__shop-details-tab-content-inner">
                                <h4 class="title-2">Ulasan</h4>
                                <div class="product-ratting">
                                    <ul>
                                        <?php for ($i = 0; $i < $fullStars; $i++): ?>
                                            <li><a href="#"><i class="fas fa-star"></i></a></li>
                                        <?php endfor; ?>
                                        <?php if ($halfStar): ?>
                                            <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                        <?php endif; ?>
                                        <?php for ($i = $fullStars + $halfStar; $i < 5; $i++): ?>
                                            <li><a href="#"><i class="far fa-star"></i></a></li>
                                        <?php endfor; ?>
                                        <li class="review-total"> ( <?= count($ulasan) ?> Ulasan )</li>
                                    </ul>
                                </div>
                                <hr>
                                <!-- Ulasan -->
                                <div class="ltn__comment-area mb-30">
                                    <div class="ltn__comment-inner">
                                        <ul>
                                            <?php if (empty($ulasan)): ?>
                                                <li><p>Belum ada ulasan untuk produk ini.</p></li>
                                            <?php else: ?>
                                                <?php foreach ($ulasan as $u): ?>
                                                    <li>
                                                        <div class="ltn__comment-item clearfix">
                                                            <div class="ltn__commenter-img">
                                                                <img src="<?= base_url('assets/img/user.png') ?>" alt="Image">
                                                            </div>
                                                            <div class="ltn__commenter-comment">
                                                                <h6><a href="#"><?= esc($u['nama']) ?></a></h6>
                                                                <div class="product-ratting">
                                                                    <ul>
                                                                        <?php for ($i = 0; $i < (int) $u['rating']; $i++): ?>
                                                                            <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                                        <?php endfor; ?>
                                                                        <?php for ($i = $u['rating']; $i < 5; $i++): ?>
                                                                            <li><a href="#"><i class="far fa-star"></i></a></li>
                                                                        <?php endfor; ?>
                                                                    </ul>
                                                                </div>
                                                                <p><?= esc($u['ulasan']) ?></p>
                                                                <span class="ltn__comment-reply-btn"><?= date('d M Y', strtotime($u['created_at'])) ?></span>
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Shop Tab End -->
            </div>
        </div>
    </div>
</div>
<!-- SHOP DETAILS AREA END -->

 
<?php echo view('master\footer'); ?>