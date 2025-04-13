<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area ltn__breadcrumb-area-2 ltn__breadcrumb-color-white bg-image" data-bg="<?= base_url('assets/img/bg/breadcrumb.png') ?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner ltn__breadcrumb-inner-2 justify-content-between">
                    <div class="section-title-area ltn__section-title-2">
                        <h1 class="section-title black-color">Akun</h1>
                    </div>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="<?= base_url('/') ?>">Beranda</a></li>
                            <li>Login Akun</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->

<!-- LOGIN AREA START -->
<div class="ltn__login-area pb-65">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title-area text-center">
                    <div class="section-title-area text-center">
                        <h1 class="section-title">Login Akun</h1>
                        <p>Masukkan email dan password untuk masuk ke akun Anda.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="account-login-inner">
                <?php if (session()->has('error')): ?>
                    <div class="alert alert-danger"><?= session('error') ?></div>
                <?php endif; ?>

                <?php if (session()->has('message')): ?>
                    <div class="alert alert-success"><?= session('message') ?></div>
                <?php endif; ?>

                    <form action="<?= base_url('/login/in') ?>" method="post" class="ltn__form-box contact-form-box">
                        <?= csrf_field() ?>

                        <div>
                            <input type="text" name="email" class="mb-1" placeholder="Email" value="<?= old('email') ?>">
                            <?php if (isset($errors['email'])): ?>
                                <small class="text-danger d-block"><?= esc($errors['email']) ?></small>
                            <?php endif; ?>
                        </div>

                        <div>
                            <input type="password" name="password" class="mb-1" placeholder="Password">
                            <?php if (isset($errors['password'])): ?>
                                <small class="text-danger d-block"><?= esc($errors['password']) ?></small>
                            <?php endif; ?>
                        </div>

                        <div class="btn-wrapper">
                            <button class="theme-btn-4 btn btn-block" type="submit">Masuk</button>
                        </div>

                        <div class="go-to-btn mt-20">
                            <a href="<?php echo base_url('/lupa-password')?>"><small>LUPA PASSWORD?</small></a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="account-create text-center pt-50">
                    <h4>BELUM PUNYA AKUN?</h4>
                    <div class="btn-wrapper">
                        <a href="<?php echo base_url('/registrasi')?>" class="theme-btn-4 btn black-btn">Registrasi Akun</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- LOGIN AREA END -->