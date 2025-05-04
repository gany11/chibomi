<!DOCTYPE html>
<html lang="en">

<head>
     <?php echo view("admin/partials/title-meta", array("title" => "Laporan")) ?>

     <?= $this->include("admin/partials/head-css") ?>

     <!-- Dropzone CSS -->
     <link href="<?= base_url('assets/admin/libs/dropzone/min/dropzone.min.css') ?>" rel="stylesheet" type="text/css" />
</head>

<body>

     <!-- START Wrapper -->
     <div class="wrapper">

          <?php echo view("admin/partials/topbar", array("title" => "Laporan")) ?>
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
                                        <div class="row ">
                                             <?php if (session()->has('error')): ?>
                                                  <div class="alert alert-danger"><?= session('error') ?></div>
                                             <?php endif; ?>
                                             <div class="col-lg-12 d-print-none">
                                                  <form action="<?= base_url('/admin/laporan') ?>" method="post">
                                                       <?= csrf_field() ?>

                                                       <!-- Jenis Produk -->
                                                       <div class="mb-3">
                                                            <label for="jenis" class="form-label">Periode</label>
                                                            
                                                            <input type="text" name="periode" id="range-datepicker" class="form-control" placeholder="YYYY-MM-DD to YYYY-MM-DD">
                                                       </div>
                                                       <!-- Button Submit -->
                                                       <div class="btn-wrapper">
                                                            <button class="btn btn-primary" type="submit">Tampilkan Data</button>
                                                       </div>
                                                  </form>
                                             </div>
                                             <?php if (isset($periode)): ?>
                                                  <div class="mt-4">
                                                       <p><strong>Periode:</strong> <?= esc($periode) ?></p>
                                                  </div>

                                                  <?php if (!empty($dataLaporan)): ?>
                                                       <div class="table-responsive">
                                                            <table class="table table-bordered">
                                                                 <thead>
                                                                      <tr>
                                                                           <th>Invoice</th>
                                                                           <th>Status Transaksi</th>
                                                                           <th>Jenis</th>
                                                                           <th>Total Harga</th>
                                                                           <th>Metode Pembayaran</th>
                                                                           <th>Status Pembayaran</th>
                                                                           <th>Tanggal Pembayaran</th>
                                                                      </tr>
                                                                 </thead>
                                                                 <tbody>
                                                                      <?php foreach ($dataLaporan as $row): ?>
                                                                           <tr>
                                                                                <td><?= esc($row['invoice_number']) ?></td>
                                                                                <td><?= esc($row['status']) ?></td>
                                                                                <td><?= esc($row['jenis']) ?></td>
                                                                                <td><?= number_format($row['total_price_producta'], 0, ',', '.') ?></td>
                                                                                <td><?= esc($row['payment_method']) ?></td>
                                                                                <td><?= esc($row['status_pembayaran']) ?></td>
                                                                                <td><?= date('d-m-Y H:i', strtotime($row['paid_at'])) ?></td>
                                                                           </tr>
                                                                      <?php endforeach; ?>
                                                                 </tbody>
                                                            </table>
                                                       </div>
                                                  <?php else: ?>
                                                       <div class="alert alert-warning mt-3">
                                                            Tidak ada data yang ditemukan untuk periode <strong><?= esc($periode) ?></strong>.
                                                       </div>
                                                  <?php endif; ?>
                                             <?php endif; ?>

                                             <div class="text-end d-print-none mt-3">
                                                  <a href="javascript:window.print()" class="btn btn-info width-xl">Cetak</a>
                                                  
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

    

     <?= $this->include("admin/partials/vendor-scripts") ?>

</body>

<script>  
     document.getElementById('range-datepicker').flatpickr({
          mode: "range"
     });
</script>

</html>
