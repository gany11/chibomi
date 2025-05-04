<?php
echo view('master/header', [
    'title' => 'Lacak Pengiriman'
]);?>

<!-- BREADCRUMB AREA START -->        
<div class="ltn__breadcrumb-area ltn__breadcrumb-area-2 ltn__breadcrumb-color-white bg-image" data-bg="<?php echo base_url('assets/img/bg/breadcrumb.png')?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner ltn__breadcrumb-inner-2 justify-content-between">
                    <div class="section-title-area ltn__section-title-2">
                        <h1 class="section-title black-color">Lacak Pengiriman</h1>
                    </div>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="<?php echo base_url('/')?>">Beranda</a></li>
                            <li>Lacak Pengiriman</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->

<!-- Lacak Pengiriman START -->
<div class="ltn__login-area pb-110">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title-area text-center">
                    <h1 class="section-title">Lacak Pengiriman</h1>
                        <button type="button" class="btn btn-secondary" onclick="window.history.back();">← Kembali</button>
                    <hr>
                </div>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php elseif (!empty($tracking)): ?>
                    <div class="card">
                        <div class="card-header">
                            <strong>Status:</strong> <?= $tracking['summary']['status'] ?>
                        </div>
                        <div class="card-body">
                            <p><strong>Resi:</strong> <?= $tracking['summary']['waybill_number'] ?></p>
                            <p><strong>Kurir:</strong> <?= $tracking['summary']['courier_name'] ?></p>
                            <p><strong>Dikirim oleh:</strong> <?= $tracking['summary']['shipper_name'] ?></p>
                            <p><strong>Penerima:</strong> <?= $tracking['summary']['receiver_name'] ?></p>
                            <p><strong>Tujuan:</strong> <?= $tracking['summary']['destination'] ?></p>
                            <hr>
                            <h5>Riwayat Pengiriman</h5>
                            <ul class="timeline">
                                <?php foreach (array_reverse($tracking['manifest']) as $item): ?>
                                    <li>
                                        <strong><?= $item['manifest_date'] ?> <?= $item['manifest_time'] ?></strong><br>
                                        <?= $item['manifest_description'] ?> <br>
                                        <small><?= $item['city_name'] ?></small>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">Tidak ada data tracking tersedia.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- Lacak Pengiriman END -->


<?php echo view('master/footer'); ?>