<!DOCTYPE html>
<html lang="en">

<head>
      <?php echo view("admin/partials/title-meta", array("title" => "Profil - Admin")) ?>

      <?= $this->include("admin/partials/head-css") ?>
</head>

<body>

     <!-- START Wrapper -->
     <div class="wrapper">

          <?php echo view("admin/partials/topbar", array("title" => "Profil")) ?>
          <?= $this->include("admin/partials/main-nav") ?>

    <!-- ==================================================== -->
    <!-- Start right Content here -->
    <!-- ==================================================== -->
    <div class="page-content">

        <!-- Start Container xxl -->
        <div class="container-xxl">

            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card overflow-hidden">
                        <div class="card-body">
                            <div class="bg-primary profile-bg rounded-top position-relative mx-n3 mt-n3">
                                <img src="<?= base_url('assets/admin/images/logo-sm.png')?>" alt=""
                                     class="avatar-xl border border-light border-3 rounded-circle position-absolute top-100 start-0 translate-middle ms-5">
                            </div>
                            <div class="mt-5 d-flex flex-wrap align-items-center justify-content-between">
                                <div>
                                    <h4 class="mb-1"><?= session()->get('nama') ?> <i
                                                class='bx bxs-badge-check text-success align-middle'></i></h4>
                                    <p class="mb-0"><?= session()->get('role') ?></p>
                                </div>
                                <div class="d-flex align-items-center gap-2 my-2 my-lg-0">
                                    <a href="<?= base_url('profil')?>" class="btn btn-info"><i class='bx bx-pen'></i> Edit</a>
                                    <!-- <a href="#!" class="btn btn-outline-primary"><i class="bx bx-plus"></i> Follow</a> -->
                                    <!-- <div class="dropdown">
                                        <a href="#" class="dropdown-toggle arrow-none card-drop"
                                           data-bs-toggle="dropdown" aria-expanded="false">
                                            <iconify-icon icon="solar:menu-dots-bold"
                                                          class="fs-20 align-middle text-muted"></iconify-icon>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="javascript:void(0);" class="dropdown-item">Download</a>
                                            <a href="javascript:void(0);" class="dropdown-item">Export</a>
                                            <a href="javascript:void(0);" class="dropdown-item">Import</a>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                            <!-- <div class="row mt-3 gy-2">
                                <div class="col-lg-2 col-6">
                                    <div class="d-flex align-items-center gap-2 border-end">
                                        <div class="">
                                            <iconify-icon icon="solar:clock-circle-bold-duotone"
                                                          class="fs-28 text-primary"></iconify-icon>
                                        </div>
                                        <div>
                                            <h5 class="mb-1">3+ Years Job</h5>
                                            <p class="mb-0">Experience</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-6">
                                    <div class="d-flex align-items-center gap-2 border-end">
                                        <div class="">
                                            <iconify-icon icon="solar:cup-star-bold-duotone"
                                                          class="fs-28 text-primary"></iconify-icon>
                                        </div>
                                        <div>
                                            <h5 class="mb-1">5 Certificate</h5>
                                            <p class="mb-0">Achieved</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-6">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="">
                                            <iconify-icon icon="solar:notebook-bold-duotone"
                                                          class="fs-28 text-primary"></iconify-icon>
                                        </div>
                                        <div>
                                            <h5 class="mb-1">2 Internship</h5>
                                            <p class="mb-0">Completed</p>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
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

<!-- Page Js -->
<!-- <script src="ges/profile.js"></script> -->


</body>

</html>