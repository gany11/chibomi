<?php echo view('master/header', ['title' => 'Pencarian']); ?>

<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area ltn__breadcrumb-area-2 ltn__breadcrumb-color-white bg-image" data-bg="<?= base_url('assets/img/bg/breadcrumb.png') ?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner ltn__breadcrumb-inner-2 justify-content-between">
                    <div class="section-title-area ltn__section-title-2">
                        <h1 class="section-title black-color">Hasil Pencarian: "<?= esc($keyword) ?>"</h1>
                    </div>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="<?= base_url('/') ?>">Beranda</a></li>
                            <li>Pencarian</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->

<!-- PRODUK SECTION START -->
<div class="ltn__product-area ltn__product-gutter mb-60">
    <div class="container">
        <h3 class="mb-4">Produk Terkait</h3>
        <div class="row">
            <?php if (!empty($produk)): ?>
                <?php foreach ($produk as $item): ?>
                    <div class="col-xl-3 col-sm-6 col-6 mb-4">
                        <div class="ltn__product-item ltn__product-item-3 text-center">
                            <div class="product-img">
                                <a href="<?= base_url('/produk/detail/' . $item['slug']) ?>">
                                    <img src="<?= base_url('assets/img/product/' . ($item['image_file'] ?? '1.png')) ?>" alt="<?= esc($item['nama_produk']) ?>">
                                </a>
                            </div>
                            <div class="product-info">
                                <div class="product-ratting">
                                    <ul>
                                        <?php
                                            $rating = round($item['avg_rating']);
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
                                    <a href="<?= base_url('/produk/detail/' . $item['slug']) ?>">
                                        <?= $item['jenis'] === 'Jasa' ? '[Jasa] ' : '' ?><?= esc($item['nama_produk']) ?>
                                    </a>
                                </h2>
                                <div class="product-price">
                                    <span>Rp<?= number_format($item['price_unit'], 0, ',', '.') ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted">Tidak ada produk yang cocok dengan kata kunci.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- PRODUK SECTION END -->

<!-- PORTOFOLIO SECTION START -->
<div class="ltn__product-area ltn__product-gutter mb-60">
    <div class="container">
        <h3 class="mb-4">Portofolio Terkait</h3>
        <div class="row">
            <?php if (!empty($portofolio)): ?>
                <?php foreach ($portofolio as $item): ?>
                    <div class="col-xl-3 col-lg-4 col-sm-6 col-6 mb-4">
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
                <p class="text-muted">Tidak ada portofolio yang cocok dengan kata kunci.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- PORTOFOLIO SECTION END -->

<?php echo view('master/footer'); ?>