<!DOCTYPE html>
<html lang="en">

<head>
     <?php echo view("admin/partials/title-meta", array("title" => "Registrasi Admin")) ?>

     <?= $this->include("admin/partials/head-css") ?>
</head>

<body>

     <!-- START Wrapper -->
     <div class="wrapper">

          <?php echo view("admin/partials/topbar", array("title" => "Registrasi Admin")) ?>
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
                                                  <form action="<?= base_url('/admin/akun/registrasi-admin/save') ?>" method="post">
                                                       <?= csrf_field() ?>

                                                       <!-- Input Nama -->
                                                       <div class="mb-3">
                                                       <label for="user-name" class="form-label">Nama</label>
                                                       <input type="text" id="user-name" class="form-control" placeholder="Nama Lengkap" name="nama" value="<?= old('nama') ?>" required>
                                                       <?php if (isset($errors['nama'])): ?>
                                                       <small class="text-danger"><?= esc($errors['nama']) ?></small>
                                                       <?php endif; ?>
                                                       </div>

                                                       <!-- Input Email -->
                                                       <div class="mb-3">
                                                       <label for="email" class="form-label">Email</label>
                                                       <input type="email" id="email" class="form-control" placeholder="Email" name="email" value="<?= old('email') ?>" required>
                                                       <?php if (isset($errors['email'])): ?>
                                                            <small class="text-danger"><?= esc($errors['email']) ?></small>
                                                       <?php endif; ?>
                                                       </div>

                                                       <!-- Input Nomor Telepon -->
                                                       <div class="mb-3">
                                                       <label for="telepon" class="form-label">Nomor Telepon</label>
                                                       <input type="text" id="telepon" class="form-control" placeholder="Nomor Telepon" name="telepon" value="<?= old('telepon') ?>" required>
                                                       <?php if (isset($errors['telepon'])): ?>
                                                       <small class="text-danger"><?= esc($errors['telepon']) ?></small>
                                                       <?php endif; ?>
                                                       </div>


                                                       <!-- Button Submit -->
                                                       <div class="btn-wrapper">
                                                            <button class="btn btn-primary" type="submit">Buat Akun Admin</button>
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