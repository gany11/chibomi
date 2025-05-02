<!DOCTYPE html>
<html lang="en">

<head>
     <?php echo view("admin/partials/title-meta", array("title" => "List Jasa Pengiriman")) ?>

     <!-- Gridjs Plugin css -->
    <link href="<?= base_url('/vendor/gridjs/theme/mermaid.min.css')?>" rel="stylesheet" type="text/css" />

     <?= $this->include("admin/partials/head-css") ?>
</head>

<body>

     <!-- START Wrapper -->
     <div class="wrapper">

          <?php echo view("admin/partials/topbar", array("title" => "List Jasa Pengiriman")) ?>
          <?= $this->include('admin/partials/main-nav') ?>

          <!-- ==================================================== -->
          <!-- Start right Content here -->
          <!-- ==================================================== -->

          <div class="page-content">

               <!-- Start Container Fluid -->
               <div class="container-xxl">

                    <div class="row">
                         <div class="col-xl-12">
                              <div class="card">
                                   <div class="p-3">
                                   <?php if (session()->has('message')): ?>
                                        <div class="alert alert-success"><?= session('message') ?></div>
                                   <?php endif; ?>
                                        <div id="table-gridjs"></div>
                                   </div>

                                   <script>
                                        document.addEventListener("DOMContentLoaded", function () {
                                        const delivery = <?= json_encode($delivery, JSON_UNESCAPED_UNICODE) ?>;
                                        const sessionRole = '<?= session()->get('role') ?>'; // Get session role

                                        if (document.getElementById("table-gridjs")) {
                                             new gridjs.Grid({
                                                  className: {
                                                       table: 'table table-hover table-striped mb-0',
                                                  },
                                                  columns: [
                                                       {
                                                            name: 'Nama Layanan',
                                                            formatter: (cell, row) => gridjs.html(`<span class="fw-semibold">${row.cells[0].data}</span>`)
                                                       },
                                                       {
                                                            name: 'Status',
                                                            formatter: (cell, row) => {
                                                            const status = row.cells[1].data;
                                                            let badgeClass = (status === 'Aktif') ? 'success' : 'danger';
                                                            return gridjs.html(`<span class="badge bg-${badgeClass}-subtle text-${badgeClass} py-1 px-2">${status}</span>`);
                                                            }
                                                       },
                                                       {
                                                            name: 'Aksi',
                                                            formatter: (_, row) => {
                                                            const delivery = {
                                                                 nama: row.cells[0].data,
                                                                 status: row.cells[1].data,
                                                                 id: row.cells[2].data
                                                            };
                                                            return gridjs.html(generateActionButtons(delivery, sessionRole));
                                                            }
                                                       }
                                                  ],
                                                  pagination: {
                                                       limit: 5
                                                  },
                                                  sort: true,
                                                  search: true,
                                                  data: delivery.map(d => [
                                                       d.nama,
                                                       d.status,
                                                       d.id_delivery_service
                                                  ])
                                             }).render(document.getElementById("table-gridjs"));
                                        }
                                        });

                                        function generateActionButtons(delivery, sessionRole) {
                                        return `<a href="/admin/pengiriman/edit/${delivery.id}" class="btn btn-sm btn-soft-primary m-1">Edit</a>`;
                                        }
                                   </script>

                              </div>
                         </div>

                    </div>
               </div>
               <!-- End Container Fluid -->

               <?= $this->include("admin/partials/footer") ?>

          </div>

          <!-- Gridjs Plugin js -->
          <script src="<?= base_url('/vendor/gridjs/gridjs.umd.js')?>"></script>

     </div>
     <!-- END Wrapper -->

     <?= $this->include("admin/partials/vendor-scripts") ?>

     <!-- SweetAlert Demo js -->
     <script src="<?= base_url('assets/admin//js/components/extended-sweetalert.js')?>"></script>

</body>

</html>