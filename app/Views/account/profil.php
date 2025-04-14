<?php
echo view('master\header', [
    'title' => 'Profil Akun'
]);?>

<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area ltn__breadcrumb-area-2 ltn__breadcrumb-color-white bg-image" data-bg="<?php echo base_url('assets/img/bg/breadcrumb.png')?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner ltn__breadcrumb-inner-2 justify-content-between">
                    <div class="section-title-area ltn__section-title-2">
                        <h1 class="section-title black-color">Akun</h1>
                    </div>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="<?php echo base_url('/')?>">Beranda</a></li>
                            <li>Profil</li>
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
                            echo view('master\menu-list-akun', [
                                'title' => 'Profil Akun'
                            ]);?>
                            <div class="col-lg-8">
                                <div class="tab-content">
                                    <div class="tab-pane fade active show">
                                        <div class="ltn__myaccount-tab-content-inner">
                                            <!-- <p>Alamat berikut akan digunakan secara default di halaman checkout.</p> -->
                                            <div class="ltn__form-box">
                                                <?php $errors = session('errors'); ?>
                                                <?php if (session()->has('error')): ?>
                                                    <div class="alert alert-danger"><?= session('error') ?></div>
                                                <?php endif; ?>

                                                <form action="<?= base_url('/profil/update') ?>" method="post" class="ltn__form-box contact-form-box">
                                                    <?= csrf_field() ?>

                                                    <div class="row mb-50">
                                                        <div class="col-md-12">
                                                            <label>Nama:</label>
                                                            <input type="text" name="nama" class="mb-1" value="<?= old('nama', session()->get('nama')) ?>" placeholder="Nama Lengkap">
                                                            <?php if (isset($errors['nama'])): ?>
                                                                <?php foreach ((array)$errors['nama'] as $error): ?>
                                                                    <small class="text-danger d-block"><?= esc($error) ?></small>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label>Telepon:</label>
                                                            <input type="text" name="telepon" class="mb-1" value="<?= old('telepon', session()->get('telepon')) ?>" placeholder="089012345678">
                                                            <?php if (isset($errors['telepon'])): ?>
                                                                <?php foreach ((array)$errors['telepon'] as $error): ?>
                                                                    <small class="text-danger d-block"><?= esc($error) ?></small>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label>Email:</label>
                                                            <input type="email" name="email" class="mb-1" value="<?= old('email', session()->get('email')) ?>" placeholder="example@example.com">
                                                            <?php if (isset($errors['email'])): ?>
                                                                <?php foreach ((array)$errors['email'] as $error): ?>
                                                                    <small class="text-danger d-block"><?= esc($error) ?></small>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>

                                                    <fieldset>
                                                        <legend>Ubah Kata Sandi</legend>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label>Kata sandi saat ini (kosongkan jika tidak diubah):</label>
                                                                <input type="password" class="mb-1" name="password_lama" placeholder="********">
                                                                <?php if (isset($errors['password_lama'])): ?>
                                                                    <?php foreach ((array)$errors['password_lama'] as $error): ?>
                                                                        <small class="text-danger d-block"><?= esc($error) ?></small>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>

                                                                <label>Kata sandi baru (kosongkan jika tidak diubah):</label>
                                                                <input type="password" class="mb-1" name="password" placeholder="********">
                                                                <?php if (isset($errors['password'])): ?>
                                                                    <?php foreach ((array)$errors['password'] as $error): ?>
                                                                        <small class="text-danger d-block"><?= esc($error) ?></small>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>

                                                                <label>Konfirmasi kata sandi baru:</label>
                                                                <input type="password" class="mb-1" name="confirm_password" placeholder="********">
                                                                <?php if (isset($errors['confirm_password'])): ?>
                                                                    <?php foreach ((array)$errors['confirm_password'] as $error): ?>
                                                                        <small class="text-danger d-block"><?= esc($error) ?></small>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <div class="btn-wrapper mt-3">
                                                        <button type="submit" class="btn theme-btn-1 btn-effect-1 text-uppercase">Simpan Perubahan</button>
                                                    </div>
                                                </form>
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

<?php if (session()->has('success')): ?>
    <!-- MODAL AREA START (Success Message Modal) -->
    <div class="ltn__modal-area ltn__success-modal-area">
        <div class="modal fade" id="success_modal" tabindex="-1">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content text-center p-4">
                    <div class="modal-header border-0 justify-content-end">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-product-item">
                            <h4 class="mb-3 text-success">Berhasil</h4>
                            <p class="mb-4"><?= session('success') ?></p>
                            <div class="btn-wrapper d-flex justify-content-center">
                                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL AREA END -->

    <!-- Script untuk otomatis tampilkan modal -->
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            var successModal = new bootstrap.Modal(document.getElementById('success_modal'));
            successModal.show();
        });
    </script>
<?php endif; ?>


<?php echo view('master\footer'); ?>
