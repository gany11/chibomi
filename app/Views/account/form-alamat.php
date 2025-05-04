<?php
echo view('master/header', [
    'title' => (empty($alamat['id_address'])? 'Tambah Alamat' : 'Edit Alamat')
]);?>

<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area ltn__breadcrumb-area-2 ltn__breadcrumb-color-white bg-image" data-bg="<?php echo base_url('assets/img/bg/breadcrumb.png')?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner ltn__breadcrumb-inner-2 justify-content-between">
                    <div class="section-title-area ltn__section-title-2">
                        <h1 class="section-title black-color">Alamat</h1>
                    </div>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="<?php echo base_url('/')?>">Beranda</a></li>
                            <li><a href="<?php echo base_url('/alamat')?>">Alamat</a></li>
                            <li><?= (empty($alamat['id_address'])? 'Tambah Alamat' : 'Edit Alamat') ?></li>
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
                                'title' => 'Alamat'
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

                                                <form action="<?= base_url('/alamat/simpan') ?>" method="post" class="ltn__form-box contact-form-box">
                                                    <?= csrf_field() ?>
                                                    <div class="row mb-50">
                                                        <div class="col-md-6">
                                                            <label>Nama Penerima:</label>
                                                            <input type="text" name="nama_penerima" value="<?= old('nama_penerima', $alamat['nama_penerima'] ?? '') ?>" placeholder="Nama Penerima">
                                                            <input type="hidden" name="id_address" value="<?= old('id_address', $alamat['id_address'] ?? '') ?>">
                                                            <?php if (isset($errors['nama_penerima'])): ?>
                                                                <small class="text-danger"><?= esc($errors['nama_penerima']) ?></small>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>No. Telepon:</label>
                                                            <input type="text" name="telp_penerima" value="<?= old('telp_penerima', $alamat['telp_penerima'] ?? '') ?>" placeholder="08xxxxxxxxxx">
                                                            <?php if (isset($errors['telp_penerima'])): ?>
                                                                <small class="text-danger"><?= esc($errors['telp_penerima']) ?></small>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label>Alamat Lengkap:</label>
                                                            <textarea name="alamat_lengkap" rows="3"><?= old('alamat_lengkap', $alamat['alamat_lengkap'] ?? '') ?></textarea>
                                                            <?php if (isset($errors['alamat_lengkap'])): ?>
                                                                <small class="text-danger"><?= esc($errors['alamat_lengkap']) ?></small>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Kode Pos:</label>
                                                            <input type="text" id="kode_pos" name="kode_pos" value="<?= old('kode_pos', $alamat['kode_pos'] ?? '') ?>" placeholder="12345">
                                                            <small class="text-danger d-block" id="kodepos-error" style="display:none;"></small>
                                                            <?php if (isset($errors['kode_pos'])): ?>
                                                                <small class="text-danger"><?= esc($errors['kode_pos']) ?></small>
                                                            <?php endif; ?>
                                                        </div>
                                                        <!-- Otomatis terisi -->
                                                        <div class="col-md-6">
                                                            <label>Provinsi:</label>
                                                            <input type="text" id="provinsi" name="provinsi" value="<?= old('provinsi', $alamat['provinsi'] ?? '') ?>" readonly class="form-control">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Kabupaten/Kota:</label>
                                                            <input type="text" id="kota" name="kota_kabupaten" value="<?= old('kota_kabupaten', $alamat['kota_kabupaten'] ?? '') ?>" readonly class="form-control">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Kecamatan:</label>
                                                            <input type="text" id="kecamatan" name="kecamatan" value="<?= old('kecamatan', $alamat['kecamatan'] ?? '') ?>" readonly class="form-control">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Kelurahan:</label>
                                                            <input type="text" id="kelurahan" name="kelurahan" value="<?= old('kelurahan', $alamat['kelurahan'] ?? '') ?>" readonly class="form-control">
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn theme-btn-1 btn-effect-1">Simpan Alamat</button>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        let debounceTimeout;

        $('#kode_pos').on('input', function () {
            clearTimeout(debounceTimeout);
            const kode = $(this).val();

            console.log("Input kode pos:", kode);
            if (kode.length >= 5) {
                debounceTimeout = setTimeout(function () {
                    $.get("<?= base_url('alamat/api/cek-kodepos') ?>/" + kode, function (data) {
                        $('#provinsi').val(data.province_name);
                        $('#kota').val(data.city_name);
                        $('#kecamatan').val(data.district_name);
                        $('#kelurahan').val(data.subdistrict_name);
                        $('#kodepos-error').hide();
                    }).fail(function (xhr) {
                        $('#kodepos-error').text(xhr.responseJSON?.message || 'Gagal validasi').show();
                        kosongkanWilayah();
                    });
                }, 500);
            } else {
                kosongkanWilayah();
            }
        });

        function kosongkanWilayah() {
            $('#provinsi, #kota, #kecamatan, #kelurahan').val('');
        }
    });
</script>



<?php echo view('master/footer'); ?>
