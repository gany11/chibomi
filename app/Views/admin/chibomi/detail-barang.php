<!DOCTYPE html>
<html lang="en">

<head>
    <?php echo view("admin/partials/title-meta", array("title" => "Detail Barang")) ?>
    <?= $this->include("admin/partials/head-css") ?>
</head>

<body>
<div class="wrapper">
    <?php echo view("admin/partials/topbar", array("title" => "Detail Barang")) ?>
    <?= $this->include('admin/partials/main-nav') ?>

    <div class="page-content">
        <div class="container-xxl">
            <div class="row">
                <?php if (session()->has('error')): ?>
                    <div class="alert alert-danger"><?= session('error') ?></div>
                <?php endif; ?>
                <?php if (session()->has('message')): ?>
                    <div class="alert alert-success"><?= session('message') ?></div>
                <?php endif; ?>
                <div class="col-xl-3 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <?php if (!empty($images)): ?>
                                <img src="<?= base_url('assets/img/product/' . esc($images[0])) ?>" alt="" class="img-fluid rounded bg-light">
                            <?php else: ?>
                                <img src="<?= base_url('assets/img/product/1.png') ?>" alt="" class="img-fluid rounded bg-light">
                            <?php endif; ?>

                            <div class="mt-3">
                                <h4><?= esc($barang['nama_produk']) ?> <span class="fs-14 text-muted ms-1">(<?= esc(!empty($barang['kategori'])? $barang['kategori'] : '-')?>)</span></h4>

                                <div class="mt-3">
                                    <h5 class="text-dark fw-medium">Tag :</h5>
                                    <p><?= esc($barang['tag']) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-9 col-lg-8 ">
                    <form action="<?= base_url('admin/barang/detail/save/' . $barang['id_product']) ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Tambah Foto Barang</h4>
                            </div>
                            <div class="card-body">
                                <div class="dropzone bg-light-subtle py-5">
                                    <input name="gambar[]" type="file" accept="image/png, image/jpeg, image/jpg" multiple="multiple">
                                    <!-- <input type="file" name="gambar[]" multiple> -->
                                    <!-- <div class="fallback">   
                                    </div> -->
                                    <!-- <div class="dz-message needsclick">
                                        <i class="bx bx-cloud-upload fs-48 text-primary"></i>
                                        <h3 class="mt-4">Seret gambar Anda ke sini, atau <span class="text-primary">klik untuk mencari</span></h3>
                                        <span class="text-muted fs-13">Disarankan ukuran 600 x 600 (1:1). Hanya file PNG, JPG, dan JPEG yang diperbolehkan.</span>
                                    </div> -->
                                </div>

                                <!-- <ul class="list-unstyled mb-0" id="dropzone-preview">
                                    <li class="mt-2" id="dropzone-preview-list">
                                        <div class="border rounded">
                                            <div class="d-flex p-2">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar-sm bg-light rounded">
                                                        <img data-dz-thumbnail class="img-fluid rounded d-block" src="#" alt="Dropzone-Image"/>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="pt-1">
                                                        <h5 class="fs-14 mb-1" data-dz-name>&</h5>
                                                        <p class="fs-13 text-muted mb-0" data-dz-size></p>
                                                        <strong class="error text-primary" data-dz-errormessage></strong>
                                                    </div>
                                                </div>
                                                <div class="flex-shrink-0 ms-3">
                                                    <button data-dz-remove class="btn btn-sm btn-primary">Hapus</button>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul> -->
                                <?php if (isset($errors['gambar'])): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= esc($errors['gambar']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit Data</h4>
                            </div>
                            <div class="card-body">
                                <!-- Input Kategori -->
                                <div class="mb-3">
                                    <label for="kategori" class="form-label">Kategori</label>
                                    <input type="text" id="kategori" class="form-control <?= isset($errors['kategori']) ? 'is-invalid' : '' ?>" name="kategori" value="<?= old('kategori', $barang['kategori'] ?? '') ?>">
                                    <?php if (isset($errors['kategori'])): ?>
                                        <small class="text-danger"><?= esc($errors['kategori']) ?></small>
                                    <?php endif; ?>
                                </div>

                                <!-- Input Deskripsi -->
                                <div class="mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <div id="deskripsi-editor" style="height: 300px;">
                                        <?= old('deskripsi', $barang['deskripsi'] ?? '') ?>
                                    </div>
                                    <input type="hidden" name="deskripsi" id="deskripsi" value="<?= esc(old('deskripsi', $barang['deskripsi']) ?? '') ?>">
                                    <?php if (isset($errors['deskripsi'])): ?>
                                        <small class="text-danger"><?= esc($errors['deskripsi']) ?></small>
                                    <?php endif; ?>
                                </div>

                                <!-- Input Tag -->
                                <div class="mb-3">
                                    <label for="tag" class="form-label">Tag</label>
                                    <input type="text" id="tag" data-choices data-choices-text-unique-true class="form-control <?= isset($errors['tag']) ? 'is-invalid' : '' ?>" name="tag" value="<?= old('tag', $barang['tag'] ?? '') ?>">
                                    <?php if (isset($errors['tag'])): ?>
                                        <small class="text-danger"><?= esc($errors['tag']) ?></small>
                                    <?php endif; ?>
                                </div>

                                <!-- Harga Beli/Modal -->
                                <div class="mb-3">
                                    <label for="harga_beli" class="form-label">Harga Beli/Modal</label>
                                    <input type="number" id="harga_beli" name="harga_beli" class="form-control" value="<?= old('harga_beli', $harga['modal'] ?? '') ?>" required>
                                    <?php if (isset($errors['harga_beli'])): ?>
                                    <small class="text-danger"><?= esc($errors['harga_beli']) ?></small>
                                    <?php endif; ?>
                                </div>

                                <!-- Harga Jual -->
                                <div class="mb-3">
                                    <label for="harga_jual" class="form-label">Harga Jual</label>
                                    <input type="number" id="harga_jual" name="harga_jual" class="form-control" value="<?= old('harga_jual', $harga['price_unit'] ?? '') ?>" required>
                                    <?php if (isset($errors['harga_jual'])): ?>
                                    <small class="text-danger"><?= esc($errors['harga_jual']) ?></small>
                                    <?php endif; ?>
                                </div>

                                <!-- Stok -->
                                <div class="mb-3">
                                    <label for="stok_awal" class="form-label">Penambahan Stok</label>
                                    <input type="number" id="stok_awal" name="stok_awal" class="form-control" value="<?= old('stok_awal') ?>" placeholder="Kosongkan jika tdak ada penambahan stok">
                                    <?php if (isset($errors['stok_awal'])): ?>
                                        <small class="text-danger"><?= esc($errors['stok_awal']) ?></small>
                                    <?php endif; ?>
                                </div>

                                <!-- Berat -->
                                <div class="mb-3">
                                    <label for="berat" class="form-label">Berat Barang (gram)</label>
                                    <input type="number" id="berat" name="berat" class="form-control" value="<?= old('berat', $dimensi['berat_gram'] ?? '0') ?>">
                                    <?php if (isset($errors['berat'])): ?>
                                        <small class="text-danger"><?= esc($errors['berat']) ?></small>
                                    <?php endif; ?>
                                </div>

                                <!-- Dimensi -->
                                <div class="mb-3">
                                    <label class="form-label">Dimensi (cm)</label>
                                    <div class="row">
                                        <div class="col">
                                            <input type="number" class="form-control" name="panjang" placeholder="Panjang" value="<?= old('panjang', $dimensi['panjang_cm'] ?? '0') ?>">
                                        </div>
                                        <div class="col">
                                            <input type="number" class="form-control" name="lebar" placeholder="Lebar" value="<?= old('lebar', $dimensi['lebar_cm'] ?? '0') ?>">
                                        </div>
                                        <div class="col">
                                            <input type="number" class="form-control" name="tinggi" placeholder="Tinggi" value="<?= old('tinggi', $dimensi['tinggi_cm'] ?? '0') ?>">
                                        </div>
                                    </div>
                                    <?php if (isset($errors['panjang'])): ?>
                                        <small class="text-danger"><?= esc($errors['panjang']) ?></small>
                                    <?php endif; ?>
                                    <?php if (isset($errors['lebar'])): ?>
                                        <small class="text-danger"><?= esc($errors['lebar']) ?></small>
                                    <?php endif; ?>
                                    <?php if (isset($errors['tinggi'])): ?>
                                        <small class="text-danger"><?= esc($errors['tinggi']) ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Save -->
                        <div class="p-3 bg-light mb-3 rounded">
                            <div class="row justify-content-end g-2">
                                <div class="col-lg-2">
                                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?= $this->include("admin/partials/footer") ?>
    </div>
</div>

<?= $this->include("admin/partials/vendor-scripts") ?>
<script src="<?= base_url('assets/admin/libs/quill/quill.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/js/components/extended-sweetalert.js')?>"></script>
<script src="<?= base_url('assets/admin/js/components/form-fileupload.js') ?>"></script>
<!-- <script>
    form.addEventListener("submit", function (e) {
        if (myDropzone.getAcceptedFiles().length > 0) {
            e.preventDefault();

            let formData = new FormData(form);
            myDropzone.getAcceptedFiles().forEach(function(file) {
                formData.append("gambar[]", file, file.name);
            });

            fetch(form.action, {
                method: "POST",
                body: formData
            }).then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                } else {
                    return response.text().then(html => console.log(html));
                }
            }).catch(err => alert("Gagal mengunggah: " + err));
        }
    });
</script> -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var quill = new Quill('#deskripsi-editor', {
            theme: 'bubble'
        });

        var deskripsiInput = document.getElementById('deskripsi');

        quill.on('text-change', function() {
            deskripsiInput.value = quill.root.innerHTML;
        });

        // Init Flatpickr
        flatpickr("#tanggal_mulai", {
            dateFormat: "Y-m-d"
        });
        flatpickr("#tanggal_selesai", {
            dateFormat: "Y-m-d"
        });
    });
</script>
<script src="<?= base_url('assets/admin/js/pages/ecommerce-product-details.js')?>"></script>
</body>

</html>
