<!DOCTYPE html>
<html lang="en">

<head>
     <?php echo view("admin/partials/title-meta", array("title" => "Tambah Portofolio")) ?>

     <?= $this->include("admin/partials/head-css") ?>

     <!-- Dropzone CSS -->
     <link href="<?= base_url('assets/admin/libs/dropzone/min/dropzone.min.css') ?>" rel="stylesheet" type="text/css" />
</head>

<body>

     <!-- START Wrapper -->
     <div class="wrapper">

          <?php echo view("admin/partials/topbar", array("title" => "Tambah Portofolio")) ?>
          <?= $this->include('admin/partials/main-nav') ?>

          <!-- ==================================================== -->
          <!-- Start right Content here -->
          <!-- ==================================================== -->
          <div class="page-content">

               <!-- Start Container Fluid -->
               <div class="container-xxl">

                    <div class="row">
                         <div class="col-lg-12">
                              <div class="card">
                                   <div class="card-body">
                                        <div class="row">
                                             <?php if (session()->has('error')): ?>
                                                  <div class="alert alert-danger"><?= session('error') ?></div>
                                             <?php endif; ?>
                                             <div class="col-lg-12">
                                                  <form action="<?= base_url('/admin/portofolio/tambah/save') ?>" method="post" enctype="multipart/form-data">
                                                       <?= csrf_field() ?>

                                                       <!-- Input Judul -->
                                                       <div class="mb-3">
                                                            <label for="judul" class="form-label">Judul</label>
                                                            <input type="text" id="judul" class="form-control" name="judul" value="<?= old('judul') ?>" required>
                                                            <?php if (isset($errors['judul'])): ?>
                                                                 <small class="text-danger"><?= esc($errors['judul']) ?></small>
                                                            <?php endif; ?>
                                                       </div>

                                                       <!-- Input Kategori -->
                                                       <div class="mb-3">
                                                            <label for="kategori" class="form-label">Kategori</label>
                                                            <input type="text" id="kategori" class="form-control" name="kategori" value="<?= old('kategori') ?>">
                                                            <?php if (isset($errors['kategori'])): ?>
                                                                 <small class="text-danger"><?= esc($errors['kategori']) ?></small>
                                                            <?php endif; ?>
                                                       </div>

                                                       <!-- Input Klien -->
                                                       <div class="mb-3">
                                                            <label for="klien" class="form-label">Klien</label>
                                                            <input type="text" id="klien" class="form-control" name="klien" value="<?= old('klien') ?>">
                                                            <?php if (isset($errors['klien'])): ?>
                                                                 <small class="text-danger"><?= esc($errors['klien']) ?></small>
                                                            <?php endif; ?>
                                                       </div>

                                                       <!-- Input URL Proyek -->
                                                       <div class="mb-3">
                                                            <label for="url_proyek" class="form-label">URL Proyek</label>
                                                            <input type="text" id="url_proyek" class="form-control" name="url_proyek" value="<?= old('url_proyek') ?>">
                                                            <?php if (isset($errors['url_proyek'])): ?>
                                                                 <small class="text-danger"><?= esc($errors['url_proyek']) ?></small>
                                                            <?php endif; ?>
                                                       </div>

                                                       <!-- Input Deskripsi (Quill Editor) -->
                                                       <div class="mb-3">
                                                            <label class="form-label">Deskripsi</label>
                                                            <div id="deskripsi-editor" style="height: 300px;">
                                                                 <?= old('deskripsi') ?>
                                                            </div>
                                                            <input type="hidden" name="deskripsi" id="deskripsi" value="<?= esc(old('deskripsi')) ?>">
                                                            <?php if (isset($errors['deskripsi'])): ?>
                                                                 <small class="text-danger"><?= esc($errors['deskripsi']) ?></small>
                                                            <?php endif; ?>
                                                       </div>

                                                       <!-- Input Tag -->
                                                       <div class="mb-3">
                                                            <label for="tag" class="form-label">Tag</label>
                                                            <input type="text" id="tag" data-choices data-choices-text-unique-true class="form-control" name="tag" value="<?= old('tag') ?>">
                                                            <?php if (isset($errors['tag'])): ?>
                                                                 <small class="text-danger"><?= esc($errors['tag']) ?></small>
                                                            <?php endif; ?>
                                                       </div>

                                                       <!-- Input Tools -->
                                                       <div class="mb-3">
                                                            <label for="tools" class="form-label">Tools</label>
                                                            <input type="text" id="tools" data-choices data-choices-text-unique-true class="form-control" name="tools" value="<?= old('tools') ?>">
                                                            <?php if (isset($errors['tools'])): ?>
                                                                 <small class="text-danger"><?= esc($errors['tools']) ?></small>
                                                            <?php endif; ?>
                                                       </div>

                                                       <!-- Input Status -->
                                                       <div class="mb-3">
                                                            <label for="status" class="form-label">Status</label>
                                                            <select id="status" class="form-select" name="status" required>
                                                                 <option value="">Pilih Status</option>
                                                                 <option value="Proses" <?= old('status') == 'Proses' ? 'selected' : '' ?>>Proses</option>
                                                                 <option value="Selesai" <?= old('status') == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                                                            </select>
                                                            <?php if (isset($errors['status'])): ?>
                                                                 <small class="text-danger"><?= esc($errors['status']) ?></small>
                                                            <?php endif; ?>
                                                       </div>

                                                       <!-- Input Tanggal Mulai -->
                                                       <div class="mb-3">
                                                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                                            <input type="text" id="tanggal_mulai" class="form-control" name="tanggal_mulai" value="<?= old('tanggal_mulai') ?>" placeholder="Tanggal Mulai">
                                                            <?php if (isset($errors['tanggal_mulai'])): ?>
                                                                 <small class="text-danger"><?= esc($errors['tanggal_mulai']) ?></small>
                                                            <?php endif; ?>
                                                       </div>

                                                       <!-- Input Tanggal Selesai -->
                                                       <div class="mb-3">
                                                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                                            <input type="text" id="tanggal_selesai" class="form-control" name="tanggal_selesai" value="<?= old('tanggal_selesai') ?>" placeholder="Tanggal Selesai">
                                                            <?php if (isset($errors['tanggal_selesai'])): ?>
                                                                 <small class="text-danger"><?= esc($errors['tanggal_selesai']) ?></small>
                                                            <?php endif; ?>
                                                       </div>

                                                       <!-- Upload Cover Foto -->
                                                       <div class="mb-3">
                                                            <label class="form-label">Cover Foto (600x600)</label>
                                                            <input type="file" name="cover" class="form-control" accept="image/png, image/jpeg, image/jpg" required>
                                                            <small class="text-muted">Ukuran disarankan 600x600 piksel, format PNG, JPG, JPEG.</small>

                                                            <?php if (isset($errors['cover'])): ?>
                                                                 <small class="text-danger"><?= esc($errors['cover']) ?></small>
                                                            <?php endif; ?>
                                                       </div>

                                                       <!-- Button Submit -->
                                                       <div class="btn-wrapper">
                                                            <button class="btn btn-primary" type="submit">Simpan Portofolio</button>
                                                            <button type="button" class="btn btn-secondary" onclick="window.history.back();">Batal</button>
                                                       </div>
                                                  </form>

                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>

               </div>
               <!-- End Container Fluid -->

               <?= $this->include("admin/partials/footer") ?>

          </div>
          <!-- ==================================================== -->
          <!-- End Page Content -->
          <!-- ==================================================== -->

     </div>
     <!-- END Wrapper -->
     
     <!-- QuillJS -->
     <script src="<?= base_url('assets/admin/libs/quill/quill.min.js') ?>"></script>

     <!-- Dropzone JS -->
     <script src="<?= base_url('assets/admin/libs/dropzone/min/dropzone.min.js') ?>"></script>

     <script>
          document.addEventListener('DOMContentLoaded', function() {
               // Init Quill Editor
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

     <?= $this->include("admin/partials/vendor-scripts") ?>

</body>

</html>
