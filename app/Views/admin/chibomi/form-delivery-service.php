<!DOCTYPE html>
<html lang="en">

<head>
     <?php echo view("admin/partials/title-meta", array("title" => $title)) ?>

     <?= $this->include("admin/partials/head-css") ?>
</head>

<body>

     <!-- START Wrapper -->
     <div class="wrapper">

          <?php echo view("admin/partials/topbar", array("title" => $title)) ?>
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
                                                  <form action="<?= base_url('/admin/pengiriman/save') ?>" method="post">
                                                       <?= csrf_field() ?>

                                                       <?php if (!empty($delivery)): ?>
                                                            <input type="hidden" name="id" value="<?= esc($delivery['id_delivery_service']) ?>">
                                                       <?php endif; ?>

                                                       <!-- Input Nama -->
                                                       <div class="mb-3">
                                                            <label for="nama" class="form-label">Nama Layanan</label>
                                                            <input type="text" id="nama" class="form-control" name="nama" placeholder="Nama Layanan"
                                                                 value="<?= old('nama', $delivery['nama'] ?? '') ?>" required>
                                                            <?php if (isset($errors['nama'])): ?>
                                                                 <small class="text-danger"><?= esc($errors['nama']) ?></small>
                                                            <?php endif; ?>
                                                       </div>

                                                       <!-- Input Kode -->
                                                       <div class="mb-3">
                                                            <label for="kode" class="form-label">Kode</label>
                                                            <input type="text" id="kode" class="form-control" name="kode" placeholder="Kode Layanan"
                                                                 value="<?= old('kode', $delivery['kode'] ?? '') ?>" required>
                                                            <?php if (isset($errors['kode'])): ?>
                                                                 <small class="text-danger"><?= esc($errors['kode']) ?></small>
                                                            <?php endif; ?>
                                                       </div>

                                                       <!-- Dropdown Status -->
                                                       <div class="mb-3">
                                                            <label for="status" class="form-label">Status</label>
                                                            <select id="status" class="form-control" name="status" required>
                                                                 <option value="">-- Pilih Status --</option>
                                                                 <option value="Aktif" <?= old('status', $delivery['status'] ?? '') == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                                                                 <option value="Pasif" <?= old('status', $delivery['status'] ?? '') == 'Pasif' ? 'selected' : '' ?>>Pasif</option>
                                                            </select>
                                                            <?php if (isset($errors['status'])): ?>
                                                                 <small class="text-danger"><?= esc($errors['status']) ?></small>
                                                            <?php endif; ?>
                                                       </div>

                                                       <!-- Button Submit -->
                                                       <div class="btn-wrapper">
                                                            <button class="btn btn-primary" type="submit">
                                                                 <?= !empty($delivery) ? 'Update Layanan' : 'Tambah Layanan' ?>
                                                            </button>
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

     <?= $this->include("admin/partials/vendor-scripts") ?>

</body>

</html>