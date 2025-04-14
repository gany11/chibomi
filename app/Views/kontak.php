<?php
echo view('master\header', [
    'title' => 'Kontak'
]);?>

<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area ltn__breadcrumb-area-2 ltn__breadcrumb-color-white bg-image" data-bg="<?= base_url('assets/img/bg/breadcrumb.png') ?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner ltn__breadcrumb-inner-2 justify-content-between">
                    <div class="section-title-area ltn__section-title-2">
                        <h1 class="section-title black-color">Kontak</h1>
                    </div>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="<?= base_url('/') ?>">Beranda</a></li>
                            <li>Kontak</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->

<!-- CONTACT ADDRESS AREA START -->
<div class="ltn__contact-address-area mb-90">
    <div class="container">
        <div class="row d-flex align-items-stretch">
            <div class="col-lg-4 h-100">
                <div class="ltn__contact-address-item ltn__contact-address-item-3 box-shadow h-100">
                    <div class="ltn__contact-address-icon">
                        <img src="<?php echo base_url('assets/img/icons/email.png')?>" alt="Icon Image">
                    </div>
                    <h3>Email</h3>
                    <p>info@webmail.com <br> jobs@webexample.com</p>
                </div>
            </div>
            <div class="col-lg-4 h-100">
                <div class="ltn__contact-address-item ltn__contact-address-item-3 box-shadow h-100">
                    <div class="ltn__contact-address-icon">
                        <img src="<?php echo base_url('assets/img/icons/phone.png')?>" alt="Icon Image">
                    </div>
                    <h3>Telepon</h3>
                    <p>+0123-456789 <br> +987-6543210</p>
                </div>
            </div>
            <div class="col-lg-4 h-100">
                <div class="ltn__contact-address-item ltn__contact-address-item-3 box-shadow h-100">
                    <div class="ltn__contact-address-icon">
                        <img src="<?php echo base_url('assets/img/icons/pin.png')?>" alt="Icon Image">
                    </div>
                    <h3>Alamat</h3>
                    <p>18/A, New Born Town Hall <br> New York, US</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- CONTACT ADDRESS AREA END -->
 
<?php echo view('master\footer'); ?>