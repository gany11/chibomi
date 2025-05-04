<?php
echo view('master/header', [
    'title' => 'Verifikasi Akun'
]);?>

<!-- BREADCRUMB AREA START -->        
<div class="ltn__breadcrumb-area ltn__breadcrumb-area-2 ltn__breadcrumb-color-white bg-image" data-bg="<?php echo base_url('assets/img/bg/breadcrumb.png')?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner ltn__breadcrumb-inner-2 justify-content-between">
                    <div class="section-title-area ltn__section-title-2">
                        <h1 class="section-title black-color">Verifikasi</h1>
                    </div>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="<?php echo base_url('/')?>">Beranda</a></li>
                            <li>Verifikasi Akun</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->

<!-- LOGIN AREA START (Register) -->
<div class="ltn__login-area pb-110">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
            <div class="section-title-area text-center">
                <h1 class="section-title">Verifikasi Akun</h1>
                <p>Akun Anda sudah Terverifikasi.</p>
                
                <hr>
                <p>Anda akan dialihkan ke halaman login dalam <span id="countdown">10</span> detik.</p>
            </div>

            <script>
                let countdownTime = 10;

                const countdownInterval = setInterval(() => {
                    countdownTime--;
                    document.getElementById("countdown").textContent = countdownTime;

                    if (countdownTime <= 0) {
                        clearInterval(countdownInterval);
                        window.location.href = '<?= base_url("login") ?>';
                    }
                }, 1000);
            </script>
            </div>
        </div>
    </div>
</div>
<!-- LOGIN AREA END -->

<?php echo view('master/footer'); ?>