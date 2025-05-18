<!DOCTYPE html>
<html lang="en">

<head>
     <?php echo view("admin/partials/title-meta", array("title" => "List Transaksi " .$jenis . ' | '. $status)) ?>

     <!-- Gridjs Plugin css -->
    <link href="<?= base_url('/vendor/gridjs/theme/mermaid.min.css')?>" rel="stylesheet" type="text/css" />

     <?= $this->include("admin/partials/head-css") ?>
</head>

<body>

     <!-- START Wrapper -->
     <div class="wrapper">

          <?php echo view("admin/partials/topbar", array("title" => "List Transaksi " .$jenis . ' | '. $status)) ?>
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
                              foreach ($transaksi as &$item) {
                                   // Tombol Detail
                                   $buttons = '<button class="btn btn-sm btn-soft-primary m-1" onclick="window.location.href=\'/admin/transaksi/detail/'.$item['id_transaksi'].'\'">Detail</button>';

                                   // Status dan tombol aksi sesuai status
                                   switch ($item['status']) {
                                        case 'Pending':
                                        $item['status_label'] = '<span class="badge bg-warning-subtle text-warning py-1 px-2">Pending</span>';
                                        // $buttons .= '<button class="btn btn-sm btn-soft-success m-1" onclick="ubahStatus(\'' . $item['id_transaksi'] . '\', \'Proses\', \'Pending\')">Proses</button>';
                                        // $buttons .= '<button class="btn btn-sm btn-soft-danger m-1" onclick="ubahStatus(\'' . $item['id_transaksi'] . '\', \'Batal\', \'Pending\')">Batal</button>';
                                        break;
                                   
                                        case 'Proses':
                                        $item['status_label'] = '<span class="badge bg-info-subtle text-info py-1 px-2">Proses</span>';
                                        $buttons .= '<button class="btn btn-sm btn-soft-danger m-1" onclick="ubahStatus(\'' . $item['id_transaksi'] . '\', \'Batal\', \'Pending\')">Batal</button>';
                                        break;
                                   
                                        case 'Kirim':
                                        $item['status_label'] = '<span class="badge bg-primary-subtle text-primary py-1 px-2">Kirim</span>';
                                        // Jika jenis = Barang, tampilkan tombol "Selesai"
                                        if ($item['jenis'] === 'Barang') {
                                             $buttons .= '<button class="btn btn-sm btn-soft-success m-1" onclick="ubahStatus(\'' . $item['id_transaksi'] . '\', \'Selesai\', \'Kirim\')">Selesai</button>';
                                        }
                                        break;
                                   
                                        case 'Selesai':
                                        $item['status_label'] = '<span class="badge bg-success-subtle text-success py-1 px-2">Selesai</span>';
                                        break;
                                   
                                        case 'Batal':
                                        $item['status_label'] = '<span class="badge bg-danger-subtle text-danger py-1 px-2">Batal</span>';
                                        // Tidak ada tombol tambahan
                                        break;
                                   
                                        default:
                                        $item['status_label'] = '<span class="badge bg-secondary-subtle text-secondary py-1 px-2">Tidak Diketahui</span>';
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
                                             const transaksi = <?= json_encode($transaksi, JSON_UNESCAPED_UNICODE) ?>;

                                             if (document.getElementById("table-gridjs")) {
                                             new gridjs.Grid({
                                                  className: {
                                                       table: 'table table-hover table-striped mb-0',
                                                  },
                                                  columns: [
                                                       {
                                                            name: 'Invoice',
                                                            formatter: (cell) => gridjs.html(`<span class="fw-semibold">${cell}</span>`)
                                                       },
                                                       {
                                                            name: 'Jenis',
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
                                                  data: transaksi.map(t => [
                                                       t.invoice_number,
                                                       t.jenis,
                                                       t.status_label,
                                                       t.action_buttons
                                                  ])
                                             }).render(document.getElementById("table-gridjs"));
                                             }
                                        });

                                        function ubahStatus(id, statusBaru, statusawal) {
                                             Swal.fire({
                                             title: 'Ubah Status Transaksi?',
                                             text: 'Status akan diubah menjadi ' + statusBaru,
                                             icon: 'question',
                                             showCancelButton: true,
                                             confirmButtonText: 'Ya, Ubah!',
                                             cancelButtonText: 'Batal',
                                             reverseButtons: true
                                             }).then((result) => {
                                             if (result.isConfirmed) {
                                                  fetch('/transaksi/ubah-status', {
                                                       method: 'POST',
                                                       headers: {
                                                            'Content-Type': 'application/json',
                                                       },
                                                       body: JSON.stringify({ id: id, status: statusBaru, statusawal: statusawal })
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