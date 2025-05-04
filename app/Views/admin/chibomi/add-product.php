<!DOCTYPE html>
<html lang="en">

<head>
     <?php echo view("admin/partials/title-meta", array("title" => "Tambah Produk")) ?>

     <?= $this->include("admin/partials/head-css") ?>

     <!-- Dropzone CSS -->
     <link href="<?= base_url('assets/admin/libs/dropzone/min/dropzone.min.css') ?>" rel="stylesheet" type="text/css" />
</head>

<body>

     <!-- START Wrapper -->
     <div class="wrapper">

          <?php echo view("admin/partials/topbar", array("title" => "Tambah Produk")) ?>
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
                                                  <form action="<?= base_url('/admin/produk/tambah/save') ?>" method="post" enctype="multipart/form-data">
                                                       <?= csrf_field() ?>

                                                       <!-- Jenis Produk -->
                                                       <div class="mb-3">
                                                            <label for="jenis" class="form-label">Jenis Produk</label>
                                                            <select id="jenis" name="jenis" class="form-select" required>
                                                            <option value="">Pilih Jenis</option>
                                                            <option value="Barang" <?= old('jenis') == 'Barang' ? 'selected' : '' ?>>Barang</option>
                                                            <option value="Jasa" <?= old('jenis') == 'Jasa' ? 'selected' : '' ?>>Jasa</option>
                                                            </select>
                                                            <?php if (isset($errors['jenis'])): ?>
                                                            <small class="text-danger"><?= esc($errors['jenis']) ?></small>
                                                            <?php endif; ?>
                                                       </div>

                                                       <!-- Nama Produk -->
                                                       <div class="mb-3">
                                                            <label for="nama_produk" class="form-label">Nama Produk</label>
                                                            <input type="text" id="nama_produk" name="nama_produk" class="form-control" value="<?= old('nama_produk') ?>" required>
                                                            <?php if (isset($errors['nama_produk'])): ?>
                                                            <small class="text-danger"><?= esc($errors['nama_produk']) ?></small>
                                                            <?php endif; ?>
                                                       </div>

                                                       <!-- Deskripsi -->
                                                       <div class="mb-3">
                                                       <label class="form-label">Deskripsi</label>
                                                            <div id="deskripsi-editor" style="height: 300px;">
                                                                 <?= old('deskripsi') ?>
                                                            </div>
                                                            <input type="hidden" name="deskripsi" id="deskripsi" value="<?= old('deskripsi') ?>">
                                                            <?php if (isset($errors['deskripsi'])): ?>
                                                                 <small class="text-danger"><?= esc($errors['deskripsi']) ?></small>
                                                            <?php endif; ?>
                                                       </div>

                                                       <!-- Kategori -->
                                                       <div class="mb-3">
                                                            <label for="kategori" class="form-label">Kategori</label>
                                                            <input type="text" id="kategori" name="kategori" class="form-control" value="<?= old('kategori') ?>" required>
                                                            <?php if (isset($errors['kategori'])): ?>
                                                            <small class="text-danger"><?= esc($errors['kategori']) ?></small>
                                                            <?php endif; ?>
                                                       </div>

                                                       <!-- Tag -->
                                                       <div class="mb-3">
                                                            <label for="tag" class="form-label">Tag</label>
                                                            <input type="text" id="tag" data-choices data-choices-text-unique-true name="tag" class="form-control" value="<?= old('tag') ?>" required>
                                                            <?php if (isset($errors['tag'])): ?>
                                                            <small class="text-danger"><?= esc($errors['tag']) ?></small>
                                                            <?php endif; ?>
                                                       </div>

                                                       <!-- Foto Cover -->
                                                       <div class="mb-3">
                                                            <label for="cover" class="form-label">Foto Cover</label>
                                                            <input type="file" name="cover" class="form-control" accept="image/png, image/jpeg, image/jpg" required>
                                                            <?php if (isset($errors['cover'])): ?>
                                                            <small class="text-danger"><?= esc($errors['cover']) ?></small>
                                                            <?php endif; ?>
                                                       </div>

                                                       <!-- Harga Beli/Modal -->
                                                       <div class="mb-3">
                                                            <label for="harga_beli" class="form-label">Harga Beli/Modal</label>
                                                            <input type="number" id="harga_beli" name="harga_beli" class="form-control" value="<?= old('harga_beli') ?>" required>
                                                            <?php if (isset($errors['harga_beli'])): ?>
                                                            <small class="text-danger"><?= esc($errors['harga_beli']) ?></small>
                                                            <?php endif; ?>
                                                       </div>

                                                       <!-- Harga Jual -->
                                                       <div class="mb-3">
                                                            <label for="harga_jual" class="form-label">Harga Jual</label>
                                                            <input type="number" id="harga_jual" name="harga_jual" class="form-control" value="<?= old('harga_jual') ?>" required>
                                                            <?php if (isset($errors['harga_jual'])): ?>
                                                            <small class="text-danger"><?= esc($errors['harga_jual']) ?></small>
                                                            <?php endif; ?>
                                                       </div>

                                                       <!-- Input Tambahan untuk Barang -->
                                                       <div id="barang-fields" style="display: none;">
                                                            <!-- Stok Awal -->
                                                            <div class="mb-3">
                                                                 <label for="stok_awal" class="form-label">Stok Awal</label>
                                                                 <input type="number" id="stok_awal" name="stok_awal" class="form-control" value="<?= old('stok_awal') ?>">
                                                                 <?php if (isset($errors['stok_awal'])): ?>
                                                                      <small class="text-danger"><?= esc($errors['stok_awal']) ?></small>
                                                                 <?php endif; ?>
                                                            </div>

                                                            <!-- Berat -->
                                                            <div class="mb-3">
                                                                 <label for="berat" class="form-label">Berat Barang (gram)</label>
                                                                 <input type="number" id="berat" name="berat" class="form-control" value="<?= old('berat') ?>">
                                                                 <?php if (isset($errors['berat'])): ?>
                                                                      <small class="text-danger"><?= esc($errors['berat']) ?></small>
                                                                 <?php endif; ?>
                                                            </div>

                                                            <!-- Dimensi -->
                                                            <div class="mb-3">
                                                                 <label class="form-label">Dimensi (cm)</label>
                                                                 <div class="row">
                                                                      <div class="col">
                                                                           <input type="number" class="form-control" name="panjang" placeholder="Panjang" value="<?= old('panjang') ?>">
                                                                      </div>
                                                                      <div class="col">
                                                                           <input type="number" class="form-control" name="lebar" placeholder="Lebar" value="<?= old('lebar') ?>">
                                                                      </div>
                                                                      <div class="col">
                                                                           <input type="number" class="form-control" name="tinggi" placeholder="Tinggi" value="<?= old('tinggi') ?>">
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

                                                       <!-- Button Submit -->
                                                       <div class="btn-wrapper">
                                                            <button class="btn btn-primary" type="submit">Simpan Data</button>
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
          });
     </script>

     <script>
     document.addEventListener('DOMContentLoaded', function () {
          const jenisSelect = document.getElementById('jenis');
          const barangFields = document.getElementById('barang-fields');

          function toggleBarangFields() {
               if (jenisSelect.value === 'Barang') {
                    barangFields.style.display = 'block';
               } else {
                    barangFields.style.display = 'none';
               }
          }

          // Inisialisasi tampilan saat halaman dimuat
          toggleBarangFields();

          // Tambahkan event listener untuk perubahan pada select jenis
          jenisSelect.addEventListener('change', toggleBarangFields);
     });
     </script>


     <?= $this->include("admin/partials/vendor-scripts") ?>

</body>

</html>
