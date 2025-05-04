<?php
echo view('master/header', [
    'title' => 'Detail Portofolio'
]);?>

<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area ltn__breadcrumb-area-2 ltn__breadcrumb-color-white bg-image" data-bg="<?= base_url('assets/img/bg/breadcrumb.png') ?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner ltn__breadcrumb-inner-2 justify-content-between">
                    <div class="section-title-area ltn__section-title-2">
                        <h1 class="section-title black-color">Detail Produk</h1>
                    </div>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="<?= base_url('/') ?>">Beranda</a></li>
                            <li><a href="<?= base_url('/portofolio') ?>">Portofolio</a></li>
                            <li>Detail Portofolio</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->

<!-- PORTOFOLIO DETAILS AREA START -->
<div class="ltn__shop-details-area pb-85">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="ltn__shop-details-inner mb-60">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="ltn__shop-details-img-gallery">
                                <div class="ltn__shop-details-large-img">
                                    <?php foreach ($images as $img): ?>
                                        <div class="single-large-img">
                                            <a href="<?= base_url('assets/img/portofolio/' . $img) ?>" data-rel="lightcase:myCollection">
                                                <img src="<?= base_url('assets/img/portofolio/' . $img) ?>" alt="Image">
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="ltn__shop-details-small-img slick-arrow-2">
                                    <?php foreach ($images as $img): ?>
                                        <div class="single-small-img">
                                            <img src="<?= base_url('assets/img/portofolio/' . $img) ?>" alt="Image">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="modal-product-info shop-details-info pl-0">
                                <h3><?= esc($portofolio['judul']) ?></h3>
                                <div class="modal-product-meta ltn__product-details-menu-1">
                                    <ul>
                                        <li>
                                            <strong>Tag:</strong>
                                            <span>
                                                <?php foreach (explode(',', $portofolio['tag']) as $tag): ?>
                                                    <a href="#"><?= esc(trim($tag)) ?></a>
                                                <?php endforeach; ?>
                                            </span>
                                        </li>
                                        <li>
                                            <strong>Tools:</strong>
                                            <span>
                                                <?php foreach (explode(',', $portofolio['tools']) as $tools): ?>
                                                    <a href="#"><?= esc(trim($tools)) ?></a>
                                                <?php endforeach; ?>
                                            </span>
                                        </li>
                                        <li><strong>Kategori:</strong> <span><?= esc($portofolio['kategori']) ?></span></li>
                                        <li><strong>Klien:</strong> <span><?= esc($portofolio['klien']) ?></span></li>
                                        <li><strong>Status:</strong> <span><?= esc($portofolio['status']) ?></span></li>
                                        <li><strong>Periode:</strong>
                                            <span>
                                                <?= !empty($portofolio['tanggal_mulai']) ? date('d M Y', strtotime($portofolio['tanggal_mulai'])) : '' ?>
                                                -
                                                <?= !empty($portofolio['tanggal_selesai']) ? date('d M Y', strtotime($portofolio['tanggal_selesai'])) : '' ?>
                                            </span>
                                        </li>

                                    </ul>
                                </div>
                                <?php if (!empty($portofolio['url_proyek'])): ?>
                                    <a class="btn theme-btn-1 btn-effect-1 mt-3" href="<?= esc($portofolio['url_proyek']) ?>" target="_blank">Kunjungi Proyek</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Portofolio Tab Start -->
                <div class="ltn__shop-details-tab-inner ltn__shop-details-tab-inner-2">
                    <div class="ltn__shop-details-tab-menu">
                        <div class="nav">
                            <a class="active show" data-bs-toggle="tab" href="#liton_tab_details_1_1">Deskripsi</a>
                            <a data-bs-toggle="tab" href="#liton_tab_details_1_2" class="">Ulasan</a>
                        </div>
                    </div>
                    <div class="tab-content">
                        <!-- Deskripsi Tab -->
                        <div class="tab-pane fade active show" id="liton_tab_details_1_1">
                            <div class="ltn__shop-details-tab-content-inner">
                                <h4 class="title-2">Deskripsi Proyek</h4>
                                <p><?= nl2br(($portofolio['deskripsi'])) ?></p>
                            </div>
                        </div>

                        <!-- Ulasan Tab -->
                        <div class="tab-pane fade" id="liton_tab_details_1_2">
                            <div class="ltn__shop-details-tab-content-inner">
                                <h4 class="title-2">Ulasan</h4>

                                <div class="ltn__comment-area mb-30">
                                    <?php if (session()->getFlashdata('success')): ?>
                                        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                                    <?php endif; ?>
                                    <?php if (session()->getFlashdata('eror')): ?>
                                        <div class="alert alert-danger"><?= session()->getFlashdata('eror') ?></div>
                                    <?php endif; ?>
                                    <div class="ltn__comment-inner">
                                        <ul>
                                            <?php if (!empty($comments)): ?>
                                                <?php foreach ($comments as $c): ?>
                                                    <li>
                                                        <div class="ltn__comment-item clearfix">
                                                            <div class="ltn__commenter-img">
                                                                <img src="<?= base_url('assets/img/favicon.png') ?>" alt="Avatar">
                                                            </div>
                                                            <div class="ltn__commenter-comment">
                                                                <h6><?= esc($c['nama'] ?? 'Anonim') ?></h6>
                                                                <div class="product-ratting">
                                                                    <ul>
                                                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                                                        <li>
                                                                            <i class="<?= $i <= $c['rating'] ? 'fas fa-star' : 'far fa-star' ?>"></i>
                                                                        </li>
                                                                        <?php endfor; ?>
                                                                    </ul>
                                                                </div>
                                                                <p><?= esc($c['komentar']) ?></p>
                                                                <?php if (in_array(session()->get('role'), ['Pemilik', 'Admin'])): ?>
                                                                    <div class="mb-2">
                                                                        <button class="btn btn-sm btn-danger" 
                                                                                data-bs-toggle="modal" 
                                                                                data-bs-target="#hapusModal" 
                                                                                data-id="<?= $c['id_comment_portofolio'] ?>">Hapus Komentar</button>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <li><p>Belum ada ulasan.</p></li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                                <?php if (session()->get('role') === 'Pelanggan'): ?>
                                    <?php if (session()->getFlashdata('errors')): ?>
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                                    <li><?= esc($error) ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                    <div class="ltn__form-box mb-30">
                                        <form action="<?= base_url('portofolio/ulasan/kirim') ?>" method="POST">
                                            <input type="hidden" name="portofolio_id" value="<?= esc($portofolio['id_portofolio']) ?>">
                                            <h4>Beri Ulasan</h4>
                                            <div class="mb-3">
                                                <label class="d-block">Rating</label>
                                                <div class="d-flex gap-2">
                                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="rating" id="rating<?= $i ?>" value="<?= $i ?>" required>
                                                            <label class="form-check-label" for="rating<?= $i ?>">
                                                                <?= str_repeat('★', $i) ?>
                                                            </label>
                                                        </div>
                                                    <?php endfor; ?>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="komentar">Komentar</label>
                                                <textarea name="komentar" rows="4" class="form-control" required></textarea>
                                            </div>
                                            <button class="btn theme-btn-1 btn-effect-1" type="submit">Kirim</button>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Portofolio Tab End -->
            </div>
        </div>
    </div>
</div>
<!-- PORTOFOLIO DETAILS AREA END -->


<div class="modal fade" id="hapusModal" tabindex="-1">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content text-center p-4">
            <div class="modal-header border-0 justify-content-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <h4 class="mb-3">Apakah Anda yakin ingin menghapus komentar ini?</h4>
                <div class="btn-wrapper d-flex justify-content-center gap-3">
                    <a href="#" id="confirmHapus" class="btn btn-danger">Ya, Hapus</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var hapusModal = document.getElementById('hapusModal');
        var confirmBtn = document.getElementById('confirmHapus');

        hapusModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var commentId = button.getAttribute('data-id');

            confirmBtn.setAttribute('href', '<?= base_url('portofolio/ulasan/hapus/') ?>' + commentId);
        });
    });
</script>
<?php echo view('master/footer'); ?>