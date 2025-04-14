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
                                    <div class="tab-pane fade">
                                        <div class="ltn__myaccount-tab-content-inner">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Order</th>
                                                            <th>Date</th>
                                                            <th>Status</th>
                                                            <th>Total</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>Jun 22, 2019</td>
                                                            <td>Pending</td>
                                                            <td>$3000</td>
                                                            <td><a href="cart.html">View</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>2</td>
                                                            <td>Nov 22, 2019</td>
                                                            <td>Approved</td>
                                                            <td>$200</td>
                                                            <td><a href="cart.html">View</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>3</td>
                                                            <td>Jan 12, 2020</td>
                                                            <td>On Hold</td>
                                                            <td>$990</td>
                                                            <td><a href="cart.html">View</a></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade">
                                        <div class="ltn__myaccount-tab-content-inner">
                                            <p>The following addresses will be used on the checkout page by default.</p>
                                            <div class="row">
                                                <div class="col-md-6 col-12 learts-mb-30">
                                                    <h4>Billing Address <small><a href="#">edit</a></small></h4>
                                                    <address>
                                                        <p><strong>Alex Tuntuni</strong></p>
                                                        <p>1355 Market St, Suite 900 <br>
                                                            San Francisco, CA 94103</p>
                                                        <p>Mobile: (123) 456-7890</p>
                                                    </address>
                                                </div>
                                                <div class="col-md-6 col-12 learts-mb-30">
                                                    <h4>Shipping Address <small><a href="#">edit</a></small></h4>
                                                    <address>
                                                        <p><strong>Alex Tuntuni</strong></p>
                                                        <p>1355 Market St, Suite 900 <br>
                                                            San Francisco, CA 94103</p>
                                                        <p>Mobile: (123) 456-7890</p>
                                                    </address>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade active show">
                                        <div class="ltn__myaccount-tab-content-inner">
                                            <!-- <p>Alamat berikut akan digunakan secara default di halaman checkout.</p> -->
                                            <div class="ltn__form-box">
                                                <form action="">
                                                    <div class="row mb-50">
                                                        <div class="col-md-12">
                                                            <label>Nama:</label>
                                                            <input type="text" name="ltn__name" value="<?= session()->get('nama')?? ''?>" placeholder="Nama Lengkap">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Telepon:</label>
                                                            <input type="text" name="ltn__lastname" value="<?= session()->get('telepon')?? '' ?>" placeholder="089012345678">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Email:</label>
                                                            <input type="email" name="ltn__lastname" value="<?= session()->get('email')?? ''?>" placeholder="example@example.com">
                                                        </div>
                                                    </div>
                                                    <fieldset>
                                                        <legend>Ubah Kata Sandi</legend>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label>Kata sandi saat ini (biarkan kosong jika tidak ingin diubah):</label>
                                                                <input type="password" name="ltn__name">
                                                                <label>Kata sandi baru (biarkan kosong jika tidak ingin diubah):</label>
                                                                <input type="password" name="ltn__lastname">
                                                                <label>Konfirmasi kata sandi baru:</label>
                                                                <input type="password" name="ltn__lastname">
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                    <div class="btn-wrapper">
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

<?php echo view('master\footer'); ?>
