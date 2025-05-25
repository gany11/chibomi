<!DOCTYPE html>
<html lang="en">

<head>
      <?php echo view("admin/partials/title-meta", array("title" => "Beranda - Admin")) ?>
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                                                            <p class="text-muted mb-0 text-truncate">Transaksi Sedang Diproses</p>
                                                            <?php
                                                                 // Cari item dengan status 'Proses'
                                                                 $sedangProses = 0;
                                                                 foreach ($transaksiStats as $row) {
                                                                      if (strtolower($row->status) === 'proses') {
                                                                           $sedangProses = $row->total_transaksi;
                                                                           break;
                                                                      }
                                                                 }
                                                            ?>
                                                            <h3 class="text-dark mt-1 mb-0"><?= $sedangProses ?></h3>
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
                                                            $totalUang = array_sum(array_column($transaksiStats2, 'total_uang'));
                                                            ?>
                                                            <h3 class="text-dark mt-1 mb-0">Rp<?= number_format($totalUang, 0, ',', '.') ?></h3>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>

                                   <!-- Clustering -->
                                   <div class="col-md-6 col-lg-6">
                                        <div class="card overflow-hidden">
                                             <div class="card-header p-3 text-center">
                                                  <h5 class="card-title">Clustering Pelanggan</h5>
                                             </div>
                                             <div class="card-body">
                                                  <canvas id="clusterChart" height="200"></canvas>
                                             </div>
                                        </div>
                                   </div>

                                   <!-- Total Transaksi -->
                                   <div class="col-md-6 col-lg-6">
                                        <div class="card overflow-hidden">
                                             <div class="card-header p-3 text-center">
                                                  <h5 class="card-title">Grafik Pendapatan Harian</h5>
                                             </div>
                                             <div class="card-body">
                                                  <canvas id="pendapatanChart" height="200"></canvas>
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
          <?= $this->include("admin/partials/footer") ?>
          <!-- ==================================================== -->
          <!-- End Page Content -->
          <!-- ==================================================== -->

     </div>
     <!-- END Wrapper -->

     <?= $this->include("admin/partials/vendor-scripts") ?>

     <script>
          const clusterData = <?= json_encode($clusteredData) ?>;

          const datasets = [[], []];
          clusterData.forEach(d => {
               datasets[d.cluster].push({
                    x: d.jumlah,
                    y: d.total,
                    nama: d.nama,
                    email: d.email
               });
               });

               const colors = ['rgba(255, 99, 132, 0.7)', 'rgba(54, 162, 235, 0.7)'];

               const ctxCluster = document.getElementById('clusterChart');
               new Chart(ctxCluster, {
               type: 'scatter',
               data: {
                    datasets: datasets.map((data, i) => ({
                         label: 'Cluster ' + (i + 1),
                         data: data,
                         backgroundColor: colors[i]
                    }))
               },
               options: {
                    plugins: {
                         tooltip: {
                              callbacks: {
                                   label: function(context) {
                                   const item = context.raw;
                                   return `${item.nama} (${item.email}): ${item.x} transaksi, Rp${item.y}`;
                                   }
                              }
                         }
                    },
                    scales: {
                         x: {
                              title: {
                                   display: true,
                                   text: 'Jumlah Transaksi'
                              }
                         },
                         y: {
                              title: {
                                   display: true,
                                   text: 'Total Belanja (Rp)'
                              }
                         }
                    }
               }
          });


          // Data Pendapatan Harian
          const pendapatanLabel = <?= json_encode(array_column($pendapatan, 'tanggal')) ?>;
          const pendapatanData = <?= json_encode(array_map('intval', array_column($pendapatan, 'total'))) ?>;

          const ctxPendapatan = document.getElementById('pendapatanChart');
          new Chart(ctxPendapatan, {
               type: 'line',
               data: {
                    labels: pendapatanLabel,
                    datasets: [{
                         label: 'Pendapatan Harian',
                         data: pendapatanData,
                         borderColor: '#4e73df',
                         backgroundColor: 'rgba(78, 115, 223, 0.05)',
                         fill: true
                    }]
               },
               options: {
                    scales: {
                         y: {
                              beginAtZero: true,
                              title: { display: true, text: 'Jumlah Pendapatan (Rp)' }
                         },
                         x: {
                              title: { display: true, text: 'Tanggal' }
                         }
                    }
               }
          });
     </script>

     <!-- Vector Map Js -->
     <script src="/vendor/jsvectormap/jsvectormap.min.js"></script>
     <script src="/vendor/jsvectormap/maps/world-merc.js"></script>
     <script src="/vendor/jsvectormap/maps/world.js"></script>

     <!-- Dashboard Js -->
     <script src="/js/pages/dashboard.js"></script>
</body>

</html>