<?php
echo view('master/header', [
    'title' => 'Registrasi Akun'
]);?>

<!-- BREADCRUMB AREA START -->        
<div class="ltn__breadcrumb-area ltn__breadcrumb-area-2 ltn__breadcrumb-color-white bg-image" data-bg="<?php echo base_url('assets/img/bg/breadcrumb.png')?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner ltn__breadcrumb-inner-2 justify-content-between">
                    <div class="section-title-area ltn__section-title-2">
                        <h1 class="section-title black-color">Registrasi</h1>
                    </div>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="<?php echo base_url('/')?>">Beranda</a></li>
                            <li>Registrasi Akun</li>
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
                    <h1 class="section-title">Registrasi Akun</h1>
                    <p>Silakan isi formulir di bawah ini untuk membuat akun Anda.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="account-login-inner">
                    <?php if (session()->has('error')): ?>
                        <div class="alert alert-danger"><?= session('error') ?></div>
                    <?php endif; ?>

                    <form action="<?= base_url('/registrasi/save') ?>" method="post" class="ltn__form-box contact-form-box">
                        <?= csrf_field() ?>

                        <div>
                            <input type="text" name="nama" class="mb-1" placeholder="Nama Lengkap" value="<?= old('nama') ?>">
                            <?php if (isset($errors['nama'])): ?>
                                <?php foreach ((array)$errors['nama'] as $error): ?>
                                    <small class="text-danger d-block"><?= esc($error) ?></small>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <div>
                            <input type="text" name="email" class="mb-1" placeholder="Email*" value="<?= old('email') ?>">
                            <?php if (isset($errors['email'])): ?>
                                <?php foreach ((array)$errors['email'] as $error): ?>
                                    <small class="text-danger d-block"><?= esc($error) ?></small>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <div>
                            <input type="text" name="telepon" class="mb-1" placeholder="Nomor Telepon" value="<?= old('telepon') ?>">
                            <?php if (isset($errors['telepon'])): ?>
                                <?php foreach ((array)$errors['telepon'] as $error): ?>
                                    <small class="text-danger d-block"><?= esc($error) ?></small>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <div>
                            <input type="password" name="password" class="mb-1" placeholder="Password">
                            <?php if (isset($errors['password'])): ?>
                                <?php foreach ((array)$errors['password'] as $error): ?>
                                    <small class="text-danger d-block"><?= esc($error) ?></small>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <div>
                            <input type="password" name="confirm_password" class="mb-1" placeholder="Konfirmasi Password">
                            <?php if (isset($errors['confirm_password'])): ?>
                                <?php foreach ((array)$errors['confirm_password'] as $error): ?>
                                    <small class="text-danger d-block"><?= esc($error) ?></small>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <div class="btn-wrapper">
                            <button class="theme-btn-4 btn btn-block" type="submit">Buat Akun</button>
                        </div>
                    </form>


                    <div class="by-agree text-center">
                        <div class="go-to-btn mt-50">
                            <a href="<?= base_url('/login') ?>">SUDAH PUNYA AKUN?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- LOGIN AREA END -->

<?php echo view('master/footer'); ?>