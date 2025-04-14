<?php
echo view('master\header', [
    'title' => '404 - Tidak Ditemukan'
]);?>

<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area ltn__breadcrumb-area-2 ltn__breadcrumb-color-white bg-image" data-bg="<?php echo base_url('assets/img/bg/breadcrumb.png')?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner ltn__breadcrumb-inner-2 justify-content-between">
                    <div class="section-title-area ltn__section-title-2">
                        <h1 class="section-title black-color">404</h1>
                    </div>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="<?php echo base_url('/')?>">Beranda</a></li>
                            <li>404 - Tidak Ditemukan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->

<!-- 404 area start -->
<div class="ltn__404-area ltn__404-area-1 mb-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="error-404-inner text-center">
                    <h1 class="error-404-title">404</h1>
                    <h2>Halaman Tidak Ditemukan!</h2>
                    <?php if (ENVIRONMENT !== 'production') : ?>
                        <p><?= nl2br(esc($message)) ?></p>
                    <?php else : ?>
                        <!-- <p><?= lang('Errors.sorryCannotFind') ?></p> -->
                    <?php endif; ?>
                    <div class="btn-wrapper">
                        <a href="<?php echo base_url('/')?>" class="btn btn-transparent"><i class="fas fa-long-arrow-alt-left"></i> KEMBALI KE BERANDA</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 404 area end -->
        
<?php echo view('master\footer'); ?>