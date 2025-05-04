<?php
echo view('master/header', [
    'title' => 'Pesanan'
]);?>

<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area ltn__breadcrumb-area-2 ltn__breadcrumb-color-white bg-image" data-bg="<?php echo base_url('assets/img/bg/breadcrumb.png')?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner ltn__breadcrumb-inner-2 justify-content-between">
                    <div class="section-title-area ltn__section-title-2">
                        <h1 class="section-title black-color">Pesanan Saya</h1>
                    </div>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="<?php echo base_url('/')?>">Beranda</a></li>
                            <li>Pesanan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->

<!-- WISHLIST AREA START -->
<div class="liton__wishlist-area pb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- PRODUCT TAB AREA START -->
                <div class="ltn__product-tab-area">
                    <div class="container">
                        <div class="row">
                            <?php
                            echo view('master/menu-list-akun', [
                                'title' => 'Pesanan'
                            ]);?>
                            <div class="col-lg-8">
                                <div class="tab-content">
                                    <div class="tab-pane fade active show">
                                        <?php if (session()->has('error')): ?>
                                            <div class="alert alert-danger"><?= session('error') ?></div>
                                        <?php endif; ?>
                                        <?php if (session()->has('success')): ?>
                                            <div class="alert alert-success"><?= session('success') ?></div>
                                        <?php endif; ?>
                                        <div class="ltn__myaccount-tab-content-inner">
                                            <div class="table-responsive">
                                                <?php if (!empty($pesanan)) : ?>
                                                    <table class="table">
                                                        <thead>
                                                            <tr class="text-center">
                                                                <th>No</th>
                                                                <th>Nomor Invoice</th>
                                                                <th>Status</th>
                                                                <th>Jenis</th>
                                                                <th>Total</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($pesanan as $i => $row) : ?>
                                                                <tr>
                                                                    <td class="text-center"><?= $i + 1 ?></td>
                                                                    <td><?= esc($row['invoice_number']) ?></td>
                                                                    <td><?= esc($row['status']) ?></td>
                                                                    <td><?= esc($row['jenis']) ?></td>
                                                                    <td>Rp<?= number_format($row['total_price_producta'], 0, ',', '.') ?></td>
                                                                    <td><a href="<?= base_url('pesanan/detail/' . $row['id_transaksi']) ?>">Lihat</a></td>
                                                                </tr>
                                                            <?php endforeach ?>
                                                        </tbody>
                                                    </table>
                                                <?php else : ?>
                                                    <div class="alert alert-info">
                                                        Anda belum memiliki pesanan.
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
                <!-- PRODUCT TAB AREA END -->
            </div>
        </div>
    </div>
</div>
<!-- WISHLIST AREA START -->

<?php echo view('master/footer'); ?>
