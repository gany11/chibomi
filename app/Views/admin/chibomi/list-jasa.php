<!DOCTYPE html>
<html lang="en">

<head>
     <?php echo view("admin/partials/title-meta", array("title" => "List Jasa")) ?>

     <!-- Gridjs Plugin css -->
    <link href="<?= base_url('/vendor/gridjs/theme/mermaid.min.css')?>" rel="stylesheet" type="text/css" />

     <?= $this->include("admin/partials/head-css") ?>
</head>

<body>

     <!-- START Wrapper -->
     <div class="wrapper">

          <?php echo view("admin/partials/topbar", array("title" => "List Jasa")) ?>
          <?= $this->include('admin/partials/main-nav') ?>

          <!-- ==================================================== -->
          <!-- Start right Content here -->
          <!-- ==================================================== -->

          <div class="page-content">

               <!-- Start Container Fluid -->
               <div class="container-xxl">

                    <div class="row">
                         <div class="col-xl-12">
                              <?php
                              $sessionRole = session()->get('role');
                              foreach ($jasa as &$item) {
                              // Siapkan tombol detail
                              $buttons = '<button class="btn btn-sm btn-soft-primary m-1" onclick="window.location.href=\'/admin/jasa/detail/'.$item['id_product'].'\'">Detail</button>';

                              // Status Berdasarkan drafted_at
                              if ($item['drafted_at']) {
                                   $item['status_label'] = '<span class="badge bg-warning-subtle text-warning py-1 px-2">Draf</span>';

                                   // Jika Pemilik, saat status Draf, tampilkan Pulihkan dan Hapus
                                   if ($sessionRole === 'Pemilik') {
                                        $buttons .= '<button class="btn btn-sm btn-soft-success m-1" onclick="restorePortofolio(\''.$item['id_product'].'\')">Pulihkan</button>';
                                        $buttons .= '<button class="btn btn-sm btn-soft-danger m-1" onclick="deletePortofolio(\''.$item['id_product'].'\')">Hapus</button>';
                                   }
                              } else {
                                   $item['status_label'] = '<span class="badge bg-success-subtle text-success py-1 px-2">Aktif</span>';

                                   // Jika status Aktif, tampilkan tombol Arsipkan
                                   $buttons .= '<button class="btn btn-sm btn-soft-warning m-1" onclick="archivePortofolio(\''.$item['id_product'].'\')">Arsipkan</button>';
                              }

                              $item['action_buttons'] = $buttons;
                              }
                              unset($item);
                              ?>

                              <div class="card">
                              <div class="p-3">
                                   <?php if (session()->has('message')): ?>
                                        <div class="alert alert-success"><?= session('message') ?></div>
                                   <?php endif; ?>
                                   <?php if (session()->has('error')): ?>
                                        <div class="alert alert-danger"><?= session('error') ?></div>
                                   <?php endif; ?>
                                   <div id="table-gridjs"></div>
                              </div>

                              <script>
                              document.addEventListener("DOMContentLoaded", function () {
                                   const jasa = <?= json_encode($jasa, JSON_UNESCAPED_UNICODE) ?>;

                                   if (document.getElementById("table-gridjs")) {
                                        new gridjs.Grid({
                                             className: {
                                                  table: 'table table-hover table-striped mb-0',
                                             },
                                             columns: [
                                                  {
                                                  name: 'Nama Jasa',
                                                  formatter: (cell) => gridjs.html(`<span class="fw-semibold">${cell}</span>`)
                                                  },
                                                  {
                                                  name: 'Status',
                                                  formatter: (cell) => gridjs.html(cell)
                                                  },
                                                  {
                                                  name: 'Aksi',
                                                  formatter: (cell) => gridjs.html(cell)
                                                  }
                                             ],
                                             pagination: {
                                                  limit: 20
                                             },
                                             sort: true,
                                             search: true,
                                             data: jasa.map(p => [
                                                  p.nama_produk,
                                                  p.status_label,
                                                  p.action_buttons
                                             ])
                                        }).render(document.getElementById("table-gridjs"));
                                   }
                              });

                              function archivePortofolio(id_product) {
                                   Swal.fire({
                                        title: 'Arsipkan Portofolio?',
                                        text: 'Portofolio akan diarsipkan!',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonText: 'Ya, Arsipkan!',
                                        cancelButtonText: 'Batal',
                                        reverseButtons: true
                                   }).then((result) => {
                                        if (result.isConfirmed) {
                                             fetch('/produk/archive', {
                                                  method: 'POST',
                                                  headers: {
                                                  'Content-Type': 'application/json',
                                                  },
                                                  body: JSON.stringify({ id_product: id_product })
                                             })
                                             .then(response => response.json())
                                             .then(data => {
                                                  if (data.success) {
                                                  Swal.fire('Berhasil!', data.message, 'success')
                                                  .then(() => location.reload());
                                                  } else {
                                                  Swal.fire('Gagal!', data.message, 'error');
                                                  }
                                             })
                                             .catch(error => {
                                                  Swal.fire('Error!', 'Terjadi kesalahan.', 'error');
                                             });
                                        }
                                   });
                              }

                              function restorePortofolio(id_product) {
                                   Swal.fire({
                                        title: 'Pulihkan Portofolio?',
                                        text: 'Portofolio akan dipulihkan!',
                                        icon: 'question',
                                        showCancelButton: true,
                                        confirmButtonText: 'Ya, Pulihkan!',
                                        cancelButtonText: 'Batal',
                                        reverseButtons: true
                                   }).then((result) => {
                                        if (result.isConfirmed) {
                                             fetch('/produk/restore', {
                                                  method: 'POST',
                                                  headers: {
                                                  'Content-Type': 'application/json',
                                                  },
                                                  body: JSON.stringify({ id_product: id_product })
                                             })
                                             .then(response => response.json())
                                             .then(data => {
                                                  if (data.success) {
                                                  Swal.fire('Berhasil!', data.message, 'success')
                                                  .then(() => location.reload());
                                                  } else {
                                                  Swal.fire('Gagal!', data.message, 'error');
                                                  }
                                             })
                                             .catch(error => {
                                                  Swal.fire('Error!', 'Terjadi kesalahan.', 'error');
                                             });
                                        }
                                   });
                              }

                              function deletePortofolio(id_product) {
                                   Swal.fire({
                                        title: 'Hapus Portofolio?',
                                        text: 'Portofolio akan dihapus secara permanen!',
                                        icon: 'error',
                                        showCancelButton: true,
                                        confirmButtonText: 'Ya, Hapus!',
                                        cancelButtonText: 'Batal',
                                        reverseButtons: true
                                   }).then((result) => {
                                        if (result.isConfirmed) {
                                             fetch('/produk/delete', {
                                                  method: 'POST',
                                                  headers: {
                                                  'Content-Type': 'application/json',
                                                  },
                                                  body: JSON.stringify({ id_product: id_product })
                                             })
                                             .then(response => response.json())
                                             .then(data => {
                                                  if (data.success) {
                                                  Swal.fire('Berhasil!', data.message, 'success')
                                                  .then(() => location.reload());
                                                  } else {
                                                  Swal.fire('Gagal!', data.message, 'error');
                                                  }
                                             })
                                             .catch(error => {
                                                  Swal.fire('Error!', 'Terjadi kesalahan.', 'error');
                                             });
                                        }
                                   });
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