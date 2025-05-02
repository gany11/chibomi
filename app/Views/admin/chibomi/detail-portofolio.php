<!DOCTYPE html>
<html lang="en">

<head>
    <?php echo view("admin/partials/title-meta", array("title" => "Detail Portofolio")) ?>
    <?= $this->include("admin/partials/head-css") ?>
</head>

<body>
<div class="wrapper">
    <?php echo view("admin/partials/topbar", array("title" => "Detail Portofolio")) ?>
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
                                <img src="<?= base_url('assets/img/portofolio/' . esc($images[0])) ?>" alt="" class="img-fluid rounded bg-light">
                            <?php else: ?>
                                <img src="<?= base_url('assets/img/portofolio/1.png') ?>" alt="" class="img-fluid rounded bg-light">
                            <?php endif; ?>

                            <div class="mt-3">
                                <h4><?= esc($portofolio['judul']) ?> <span class="fs-14 text-muted ms-1">(<?= esc(!empty($portofolio['kategori'])? $portofolio['kategori'] : '-')?>)</span></h4>

                                <div class="mt-3">
                                    <h5 class="text-dark fw-medium">Klien :</h5>
                                    <p><?= esc($portofolio['klien']) ?></p>
                                </div>

                                <div class="mt-3">
                                    <h5 class="text-dark fw-medium">URL Proyek:</h5>
                                    <?= (!empty($portofolio['url_proyek'])? '<a href="'.$portofolio['url_proyek'].'" target="_blank">'.$portofolio['url_proyek'].'</a>' : '')?>
                                </div>

                                <div class="mt-3">
                                    <h5 class="text-dark fw-medium">Tools :</h5>
                                    <p><?= esc($portofolio['tools']) ?></p>
                                </div>

                                <div class="mt-3">
                                    <h5 class="text-dark fw-medium">Tag :</h5>
                                    <p><?= esc($portofolio['tag']) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-9 col-lg-8 ">
                    <form action="<?= base_url('admin/portofolio/detail/save/' . $portofolio['id_portofolio']) ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Tambah Foto Portofolio</h4>
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
                                    <input type="text" id="kategori" class="form-control <?= isset($errors['kategori']) ? 'is-invalid' : '' ?>" name="kategori" value="<?= old('kategori', $portofolio['kategori'] ?? '') ?>">
                                    <?php if (isset($errors['kategori'])): ?>
                                        <small class="text-danger"><?= esc($errors['kategori']) ?></small>
                                    <?php endif; ?>
                                </div>

                                <!-- Input Klien -->
                                <div class="mb-3">
                                    <label for="klien" class="form-label">Klien</label>
                                    <input type="text" id="klien" class="form-control <?= isset($errors['klien']) ? 'is-invalid' : '' ?>" name="klien" value="<?= old('klien', $portofolio['klien'] ?? '') ?>">
                                    <?php if (isset($errors['klien'])): ?>
                                        <small class="text-danger"><?= esc($errors['klien']) ?></small>
                                    <?php endif; ?>
                                </div>

                                <!-- Input URL Proyek -->
                                <div class="mb-3">
                                    <label for="url_proyek" class="form-label">URL Proyek</label>
                                    <input type="text" id="url_proyek" class="form-control <?= isset($errors['url_proyek']) ? 'is-invalid' : '' ?>" name="url_proyek" value="<?= old('url_proyek', $portofolio['url_proyek'] ?? '') ?>">
                                    <?php if (isset($errors['url_proyek'])): ?>
                                        <small class="text-danger"><?= esc($errors['url_proyek']) ?></small>
                                    <?php endif; ?>
                                </div>

                                <!-- Input Deskripsi -->
                                <div class="mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <div id="deskripsi-editor" style="height: 300px;">
                                        <?= old('deskripsi', $portofolio['deskripsi'] ?? '') ?>
                                    </div>
                                    <input type="hidden" name="deskripsi" id="deskripsi" value="<?= esc(old('deskripsi', $portofolio['deskripsi']) ?? '') ?>">
                                    <?php if (isset($errors['deskripsi'])): ?>
                                        <small class="text-danger"><?= esc($errors['deskripsi']) ?></small>
                                    <?php endif; ?>
                                </div>

                                <!-- Input Tag -->
                                <div class="mb-3">
                                    <label for="tag" class="form-label">Tag</label>
                                    <input type="text" id="tag" data-choices data-choices-text-unique-true class="form-control <?= isset($errors['tag']) ? 'is-invalid' : '' ?>" name="tag" value="<?= old('tag', $portofolio['tag'] ?? '') ?>">
                                    <?php if (isset($errors['tag'])): ?>
                                        <small class="text-danger"><?= esc($errors['tag']) ?></small>
                                    <?php endif; ?>
                                </div>

                                <!-- Input Tools -->
                                <div class="mb-3">
                                    <label for="tools" class="form-label">Tools</label>
                                    <input type="text" id="tools" data-choices data-choices-text-unique-true class="form-control <?= isset($errors['tools']) ? 'is-invalid' : '' ?>" name="tools" value="<?= old('tools', $portofolio['tools'] ?? '') ?>">
                                    <?php if (isset($errors['tools'])): ?>
                                        <small class="text-danger"><?= esc($errors['tools']) ?></small>
                                    <?php endif; ?>
                                </div>

                                <!-- Input Status -->
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select id="status" class="form-select <?= isset($errors['status']) ? 'is-invalid' : '' ?>" name="status">
                                        <option value="">Pilih Status</option>
                                        <option value="Proses" <?= old('status', $portofolio['status'] ?? '') == 'Proses' ? 'selected' : '' ?>>Proses</option>
                                        <option value="Selesai" <?= old('status', $portofolio['status'] ?? '') == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                                    </select>
                                    <?php if (isset($errors['status'])): ?>
                                        <small class="text-danger"><?= esc($errors['status']) ?></small>
                                    <?php endif; ?>
                                </div>

                                <!-- Input Tanggal Mulai -->
                                <div class="mb-3">
                                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                    <input type="text" id="tanggal_mulai" class="form-control <?= isset($errors['tanggal_mulai']) ? 'is-invalid' : '' ?>" name="tanggal_mulai" value="<?= old('tanggal_mulai', $portofolio['tanggal_mulai'] ?? '') ?>">
                                    <?php if (isset($errors['tanggal_mulai'])): ?>
                                        <small class="text-danger"><?= esc($errors['tanggal_mulai']) ?></small>
                                    <?php endif; ?>
                                </div>

                                <!-- Input Tanggal Selesai -->
                                <div class="mb-3">
                                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                    <input type="text" id="tanggal_selesai" class="form-control <?= isset($errors['tanggal_selesai']) ? 'is-invalid' : '' ?>" name="tanggal_selesai" value="<?= old('tanggal_selesai', $portofolio['tanggal_selesai'] ?? '') ?>">
                                    <?php if (isset($errors['tanggal_selesai'])): ?>
                                        <small class="text-danger"><?= esc($errors['tanggal_selesai']) ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Save -->
                        <div class="p-3 bg-light mb-3 rounded">
                            <div class="row justify-content-end g-2">
                                <div class="col-lg-2">
                                    <button type="submit" class="btn btn-primary w-100">Save</button>
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
