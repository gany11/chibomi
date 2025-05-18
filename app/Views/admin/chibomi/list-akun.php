<!DOCTYPE html>
<html lang="en">

<head>
     <?php echo view("admin/partials/title-meta", array("title" => "List Akun")) ?>

     <!-- Gridjs Plugin css -->
    <link href="<?= base_url('/vendor/gridjs/theme/mermaid.min.css')?>" rel="stylesheet" type="text/css" />

     <?= $this->include("admin/partials/head-css") ?>
</head>

<body>

     <!-- START Wrapper -->
     <div class="wrapper">

          <?php echo view("admin/partials/topbar", array("title" => "List Akun")) ?>
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
                                        const users = <?= json_encode($users, JSON_UNESCAPED_UNICODE) ?>;
                                        const sessionRole = '<?= session()->get('role') ?>'; // Get session role

                                        if (document.getElementById("table-gridjs")) {
                                             new gridjs.Grid({
                                                  className: {
                                                       table: 'table table-hover table-striped mb-0',
                                                  },
                                                  columns: [
                                                       {
                                                            name: 'Nama',
                                                            formatter: (cell, row) => gridjs.html(`<span class="fw-semibold">${row.cells[0].data}</span>`)
                                                       },
                                                       {
                                                            name: 'Email',
                                                            formatter: (cell, row) => gridjs.html(`<a href="mailto:${row.cells[1].data}" class="text-primary">${row.cells[1].data}</a>`)
                                                       },
                                                       {
                                                            name: 'Status',
                                                            formatter: (cell, row) => {
                                                            const status = row.cells[2].data;
                                                            let badgeClass = 'secondary';
                                                            if (status === 'Aktif') badgeClass = 'success';
                                                            else if (status === 'Blokir') badgeClass = 'danger';
                                                            else if (status === 'EmailVerif') badgeClass = 'warning';

                                                            return gridjs.html(`<span class="badge bg-${badgeClass}-subtle text-${badgeClass} py-1 px-2">${status}</span>`);
                                                            }
                                                       },
                                                       {
                                                            name: 'Role',
                                                            formatter: (cell, row) => gridjs.html(`<span class="text-muted">${row.cells[3].data}</span>`)
                                                       },
                                                       {
                                                            name: 'Aksi',
                                                            formatter: (_, row) => {
                                                            const user = {
                                                                 nama: row.cells[0].data,
                                                                 email: row.cells[1].data,
                                                                 status_akun: row.cells[2].data,
                                                                 role: row.cells[3].data,
                                                                 id_account: row.cells[4].data
                                                            };
                                                            return gridjs.html(generateActionButtons(user, sessionRole)); // Pass session role to the function
                                                            }
                                                       }
                                                  ],
                                                  pagination: {
                                                       limit: 10
                                                  },
                                                  sort: true,
                                                  search: true,
                                                  data: users.map(u => [
                                                       u.nama,
                                                       u.email,
                                                       u.status_akun,
                                                       u.role,
                                                       u.id_account
                                                  ])
                                             }).render(document.getElementById("table-gridjs"));
                                        }
                                        });

                                        function generateActionButtons(user, sessionRole) {
                                        let buttons = '';

                                        if (sessionRole === 'Pemilik' && user.role !== 'Pemilik') {
                                             if (user.status_akun === 'Aktif') {
                                                  buttons += `<button class="btn btn-sm btn-soft-danger m-1" onclick="changeStatus('${user.id_account}', 'blokir')">Blokir</button>`;
                                             } else if (user.status_akun === 'Blokir') {
                                                  buttons += `<button class="btn btn-sm btn-soft-success m-1" onclick="changeStatus('${user.id_account}', 'aktifkan')">Pulihkan</button>`;
                                             }

                                             if (user.status_akun === 'EmailVerif') {
                                                  buttons += `<button class="btn btn-sm btn-soft-warning m-1" onclick="sendVerification('${user.id_account}')">Kirim Verifikasi</button>`;
                                             }
                                        } else if (user.role === 'Pemilik') {
                                             buttons = `<button class="btn btn-sm btn-soft-secondary m-1" disabled>Pemilik</button>`;
                                        }

                                        return buttons;
                                        }

                                        function changeStatus(id_account, action) {
                                             Swal.fire({
                                                  title: 'Apakah Anda yakin?',
                                                  text: `Anda akan mengubah status akun ke ${action === 'blokir' ? 'Blokir' : 'Aktif'}`,
                                                  icon: 'warning',
                                                  showCancelButton: true,
                                                  confirmButtonText: 'Ya, ubah!',
                                                  cancelButtonText: 'Batal',
                                                  reverseButtons: true
                                             }).then((result) => {
                                                  if (result.isConfirmed) {
                                                       fetch('/user/changeStatus', {
                                                            method: 'POST',
                                                            headers: {
                                                                 'Content-Type': 'application/json',
                                                            },
                                                            body: JSON.stringify({
                                                                 id_account: id_account,
                                                                 action: action
                                                            })
                                                       })
                                                       .then(response => response.json())
                                                       .then(data => {
                                                            if (data.success) {
                                                                 Swal.fire('Berhasil!', data.message, 'success')
                                                                 .then(() => {
                                                                 // Reload the page to update the table
                                                                 location.reload();
                                                                 });
                                                            } else {
                                                                 Swal.fire('Gagal!', data.message, 'error');
                                                            }
                                                       })
                                                       .catch(error => {
                                                            Swal.fire('Terjadi Kesalahan!', 'Gagal mengubah status', 'error');
                                                       });
                                                  }
                                             });
                                        }

                                        function sendVerification(id_account) {
                                        Swal.fire({
                                             title: 'Kirim Email Verifikasi?',
                                             text: 'Anda yakin ingin mengirim email verifikasi?',
                                             icon: 'question',
                                             showCancelButton: true,
                                             confirmButtonText: 'Ya, kirim!',
                                             cancelButtonText: 'Batal',
                                             reverseButtons: true
                                        }).then((result) => {
                                             if (result.isConfirmed) {
                                                  fetch('/user/sendVerification', {
                                                       method: 'POST',
                                                       headers: {
                                                            'Content-Type': 'application/json',
                                                       },
                                                       body: JSON.stringify({ id_account: id_account })
                                                  })
                                                  .then(response => response.json())
                                                  .then(data => {
                                                       if (data.success) {
                                                            Swal.fire('Berhasil!', data.message, 'success');
                                                            // Reload or update the table as needed
                                                       } else {
                                                            Swal.fire('Gagal!', data.message, 'error');
                                                       }
                                                  })
                                                  .catch(error => {
                                                       Swal.fire('Terjadi Kesalahan!', 'Gagal mengirim verifikasi', 'error');
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