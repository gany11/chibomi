<?php
echo view('master/header', [
    'title' => 'Alamat Saya'
]);?>

<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area ltn__breadcrumb-area-2 ltn__breadcrumb-color-white bg-image" data-bg="<?php echo base_url('assets/img/bg/breadcrumb.png')?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner ltn__breadcrumb-inner-2 justify-content-between">
                    <div class="section-title-area ltn__section-title-2">
                        <h1 class="section-title black-color">Alamat Saya</h1>
                    </div>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="<?php echo base_url('/')?>">Beranda</a></li>
                            <li>Alamat</li>
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
                                    <div class="tab-pane fade active show"><div class="ltn__myaccount-tab-content-inner">

                                        <?php if (session()->has('error')): ?>
                                            <div class="alert alert-danger"><?= session('error') ?></div>
                                        <?php endif; ?>
                                        <?php if (session()->has('success')): ?>
                                            <div class="alert alert-success"><?= session('success') ?></div>
                                        <?php endif; ?>
                                        <?php if (count($alamat) === 0): ?>
                                            <div class="alert alert-warning" role="alert">
                                                Anda belum memiliki alamat tersimpan. Silakan tambahkan minimal 1 alamat pengiriman.
                                            </div>
                                        <?php endif; ?>

                                        <div class="by-agree text-end">
                                            <h4>
                                                <a class="theme-btn-4 btn btn-block <?= count($alamat) >= 3 ? 'disabled' : '' ?>" 
                                                href="<?= base_url('alamat/tambah') ?>">
                                                Tambah Alamat Baru
                                                </a>
                                            </h4>
                                        </div>
                                        <p>Anda dapat mendaftarkan hingga 3 alamat.</p>

                                        <div class="row">
                                            <?php foreach ($alamat as $index => $a): ?>
                                                <div class="col-md-6 col-12 learts-mb-30">
                                                    <h4>
                                                        Alamat <?= $index + 1 ?>
                                                        <small class="m-3">
                                                            <a class="primary-color-4 m-2" href="<?= base_url('alamat/ubah/' . $a['id_address']) ?>">Edit</a>
                                                            <?php if (count($alamat) > 1): ?>
                                                                | <a href="#" 
                                                                    class="text-danger m-2 btn-hapus-alamat" 
                                                                    data-id="<?= $a['id_address'] ?>" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#hapusModal">Hapus</a>
                                                            <?php endif; ?>
                                                        </small>
                                                    </h4>
                                                    <address>
                                                        <p><strong><?= esc($a['nama_penerima']) ?></strong></p>
                                                        <p><?= esc($a['alamat_lengkap']) ?></p>
                                                        <p><?= esc($a['kecamatan']) ?>, <?= esc($a['kelurahan']) ?></p>
                                                        <p><?= esc($a['kota_kabupaten']) ?>, <?= esc($a['provinsi']) ?> - <?= esc($a['kode_pos']) ?></p>
                                                        <p>Telepon: <?= esc($a['telp_penerima']) ?></p>
                                                    </address>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Konfirmasi Hapus -->
                            <div class="modal fade" id="hapusModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-md" role="document">
                                    <div class="modal-content text-center p-4">
                                        <div class="modal-header border-0 justify-content-end">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h4 class="mb-3">Apakah Anda yakin ingin menghapus alamat ini?</h4>
                                            <div class="btn-wrapper d-flex justify-content-center gap-3">
                                                <a href="#" id="confirmHapus" class="btn btn-danger">Ya, Hapus</a>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hapusLinks = document.querySelectorAll('.btn-hapus-alamat');
        const confirmBtn = document.getElementById('confirmHapus');

        hapusLinks.forEach(link => {
            link.addEventListener('click', function () {
                const idAlamat = this.getAttribute('data-id');
                confirmBtn.href = `<?= base_url('alamat/hapus/') ?>${idAlamat}`;
            });
        });
    });
</script>

