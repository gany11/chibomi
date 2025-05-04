<!DOCTYPE html>
<html lang="en">

<head>
      <?php echo view("admin/partials/title-meta", array("title" => "Beranda - Admin")) ?>

      <?= $this->include("admin/partials/head-css") ?>
</head>

<body>

     <!-- START Wrapper -->
     <div class="wrapper">

          <?php echo view("admin/partials/topbar", array("title" => "Beranda")) ?>
          <?= $this->include("admin/partials/main-nav") ?>

          <!-- ==================================================== -->
          <!-- Start right Content here -->
          <!-- ==================================================== -->
          <div class="page-content">
               <div class="container-fluid">
                    <div class="row">
                         <div class="col-xxl-8">
                              <div class="row">
                                   <!-- Total Transaksi -->
                                   <div class="col-md-6 col-lg-6">
                                        <div class="card overflow-hidden">
                                             <div class="card-body">
                                                  <div class="row">
                                                       <div class="col-6">
                                                            <div class="avatar-md bg-soft-primary rounded">
                                                            <iconify-icon icon="solar:cart-5-bold-duotone" class="avatar-title fs-32 text-primary"></iconify-icon>
                                                            </div>
                                                       </div>
                                                       <div class="col-6 text-end">
                                                            <p class="text-muted mb-0 text-truncate">Total Transaksi</p>
                                                            <?php
                                                            $totalTransaksi = array_sum(array_column($transaksiStats, 'total_transaksi'));
                                                            ?>
                                                            <h3 class="text-dark mt-1 mb-0"><?= $totalTransaksi ?></h3>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>

                                   <!-- Total Pendapatan -->
                                   <div class="col-md-6 col-lg-6">
                                        <div class="card overflow-hidden">
                                             <div class="card-body">
                                                  <div class="row">
                                                       <div class="col-6">
                                                            <div class="avatar-md bg-soft-primary rounded">
                                                            <i class="bx bx-dollar-circle avatar-title text-primary fs-24"></i>
                                                            </div>
                                                       </div>
                                                       <div class="col-6 text-end">
                                                            <p class="text-muted mb-0 text-truncate">Total Pendapatan</p>
                                                            <?php
                                                            $totalUang = array_sum(array_column($transaksiStats, 'total_uang'));
                                                            ?>
                                                            <h3 class="text-dark mt-1 mb-0">Rp<?= number_format($totalUang, 0, ',', '.') ?></h3>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>

                                   <!-- Kata Kunci Teratas -->
                                   <div class="col-md-6 col-lg-6">
                                        <div class="card overflow-hidden">
                                             <div class="card-header p-3 text-center">
                                                  <h5 class="card-title">Kata Kunci Teratas</h5>
                                             </div>
                                             <div class="card-body">
                                                  <ul class="list-group">
                                                       <?php foreach ($topSearches as $search): ?>
                                                       <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            <?= esc($search['search']) ?>
                                                            <span class="badge bg-primary rounded-pill"><?= $search['total'] ?></span>
                                                       </li>
                                                       <?php endforeach; ?>
                                                  </ul>
                                             </div>
                                        </div>
                                   </div>

                                   <!-- Pengguna Berdasarkan Peran -->
                                   <div class="col-md-6 col-lg-6">
                                        <div class="card overflow-hidden">
                                             <div class="card-header p-3 text-center">
                                                  <h5 class="card-title">Pengguna Berdasarkan Peran</h5>
                                             </div>
                                             <div class="card-body">
                                                  <ul class="list-group">
                                                       <?php foreach ($userByRole as $role): ?>
                                                       <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            <?= esc(ucwords($role['role'])) ?>
                                                            <span class="badge bg-secondary"><?= $role['total'] ?></span>
                                                       </li>
                                                       <?php endforeach; ?>
                                                  </ul>
                                             </div>
                                        </div>
                                   </div>

                                   <!-- Produk Paling Banyak Dilihat -->
                                   <div class="col-md-6 col-lg-6">
                                        <div class="card overflow-hidden">
                                             <div class="card-header p-3 text-center">
                                                  <h5 class="card-title">Produk Paling Banyak Dilihat</h5>
                                             </div>
                                             <div class="card-body">
                                                  <div class="table-responsive">
                                                       <table class="table table-hover table-nowrap table-centered m-0">
                                                            <thead class="bg-light bg-opacity-50">
                                                            <tr>
                                                                 <th class="text-muted ps-3">Nama Produk</th>
                                                                 <th class="text-muted">Jumlah Dilihat</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php foreach ($topViewedProducts as $product): ?>
                                                            <tr>
                                                                 <td class="ps-3"><?= esc($product->nama_produk) ?></td>
                                                                 <td><?= $product->views ?></td>
                                                            </tr>
                                                            <?php endforeach; ?>
                                                            </tbody>
                                                       </table>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>

                                   <!-- Portofolio Paling Banyak Dilihat -->
                                   <div class="col-md-6 col-lg-6">
                                        <div class="card overflow-hidden">
                                             <div class="card-header p-3 text-center">
                                                  <h5 class="card-title">Portofolio Terpopuler</h5>
                                             </div>
                                             <div class="card-body">
                                                  <ul class="list-group">
                                                       <?php foreach ($topViewedPortfolios as $portfolio): ?>
                                                       <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            <?= esc($portfolio->judul) ?>
                                                            <span class="badge bg-info rounded-pill"><?= $portfolio->views ?></span>
                                                       </li>
                                                       <?php endforeach; ?>
                                                  </ul>
                                             </div>
                                        </div>
                                   </div>

                                   <!-- Produk Terlaris -->
                                   <div class="col-md-6 col-lg-6">
                                        <div class="card overflow-hidden">
                                             <div class="card-header p-3 text-center">
                                                  <h5 class="card-title">Produk Terlaris</h5>
                                             </div>
                                             <div class="card-body">
                                                  <ul class="list-group">
                                                       <?php foreach ($topOrderedProducts as $product): ?>
                                                       <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            <?= esc($product->nama_produk) ?>
                                                            <span class="badge bg-success rounded-pill"><?= $product->total_ordered ?></span>
                                                       </li>
                                                       <?php endforeach; ?>
                                                  </ul>
                                             </div>
                                        </div>
                                   </div>

                                   <!-- Status Transaksi -->
                                   <div class="col-md-6 col-lg-6">
                                        <div class="card overflow-hidden">
                                             <div class="card-header p-3 text-center">
                                                  <h5 class="card-title">Status Transaksi</h5>
                                             </div>
                                             <div class="card-body">
                                                  <ul class="list-group">
                                                       <?php foreach ($transaksiStats as $status): ?>
                                                       <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            <?= esc($status->status) ?>
                                                            <span class="badge bg-warning rounded-pill"><?= $status->total_transaksi ?> Transaksi</span>
                                                       </li>
                                                       <?php endforeach; ?>
                                                  </ul>
                                             </div>
                                        </div>
                                   </div>

                              </div>
                         </div>
                    </div>
               </div>
          </div>
          <!-- ==================================================== -->
          <!-- End Page Content -->
          <!-- ==================================================== -->

     </div>
     <!-- END Wrapper -->

     <?= $this->include("admin/partials/vendor-scripts") ?>

     <!-- Vector Map Js -->
     <script src="/vendor/jsvectormap/jsvectormap.min.js"></script>
     <script src="/vendor/jsvectormap/maps/world-merc.js"></script>
     <script src="/vendor/jsvectormap/maps/world.js"></script>

     <!-- Dashboard Js -->
     <script src="/js/pages/dashboard.js"></script>

</body>

</html>