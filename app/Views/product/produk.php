<?php
echo view('master\header', [
    'title' => 'Produk'
]);?>

<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area ltn__breadcrumb-area-2 ltn__breadcrumb-color-white bg-image" data-bg="<?= base_url('assets/img/bg/breadcrumb.png') ?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner ltn__breadcrumb-inner-2 justify-content-between">
                    <div class="section-title-area ltn__section-title-2">
                        <h1 class="section-title black-color">Produk</h1>
                    </div>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="<?= base_url('/') ?>">Beranda</a></li>
                            <li>Produk</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->

<!-- PRODUCT DETAILS AREA START -->
<div class="ltn__product-area ltn__product-gutter mb-120">
    <div class="container">
    <div class="row">
        <?php foreach ($produk as $produk): ?>
            <div class="col-xl-3 col-sm-6 col-6">
                <div class="ltn__product-item ltn__product-item-3 text-center">
                    <div class="product-img">
                        <a href="<?= base_url('/produk/detail/' . $produk['slug']) ?>">
                            <img src="<?= base_url('assets/img/product/' . ($produk['image_file'] ?? '1.png')) ?>" alt="<?= esc($produk['nama_produk']) ?>">
                        </a>
                        <div class="product-badge">
                            <ul>
                                <!-- Bisa tambahkan badge di sini -->
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
                                            echo '<li><a href="#"><i class="fas fa-star"></i></a></li>';
                                        elseif ($i == $rating + 0.5):
                                            echo '<li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>';
                                        else:
                                            echo '<li><a href="#"><i class="far fa-star"></i></a></li>';
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
                            <!-- Optional: del harga lama -->
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    </div>
</div>
<!-- PRODUCT DETAILS AREA END -->
 
<?php echo view('master\footer'); ?>