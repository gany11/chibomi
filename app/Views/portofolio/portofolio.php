<?php
echo view('master\header', [
    'title' => 'Portofolio'
]);?>

<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area ltn__breadcrumb-area-2 ltn__breadcrumb-color-white bg-image" data-bg="<?= base_url('assets/img/bg/breadcrumb.png') ?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner ltn__breadcrumb-inner-2 justify-content-between">
                    <div class="section-title-area ltn__section-title-2">
                        <h1 class="section-title black-color">Portofolio</h1>
                    </div>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="<?= base_url('/') ?>">Beranda</a></li>
                            <li>Portofolio</li>
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
            <div class="col-lg-12">
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="liton_product_grid">
                        <div class="ltn__product-tab-content-inner ltn__product-grid-view">
                            <div class="row">
                            <?php if (!empty($portofolio)): ?>
                                <?php foreach ($portofolio as $item): ?>
                                    <!-- ltn__product-item -->
                                    <div class="col-xl-3 col-lg-4 col-sm-6 col-6">
                                        <div class="ltn__product-item ltn__product-item-3 text-center">
                                            <div class="product-img">
                                                <!-- Mengubah href dan alt dengan data dari controller -->
                                                <a href="<?= base_url('/portofolio/detail/' . $item['slug']) ?>">
                                                    <img src="<?= base_url('assets/img/portofolio/' . ($item['file'] ?? '1.png')) ?>" alt="<?= esc($item['judul']) ?>">
                                                </a>
                                                <div class="product-badge">
                                                    <ul>
                                                        <!-- <li class="sale-badge">New</li> -->
                                                    </ul>
                                                </div>
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
                                <p>Portofolio Belum Tersedia</p>
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- PRODUCT DETAILS AREA END -->
<?php echo view('master\footer'); ?>