<!DOCTYPE html>
<html lang="en">

<head>
    <?php echo view("admin/partials/title-meta", array("title" => "Detail Barang")) ?>
    <?= $this->include("admin/partials/head-css") ?>
</head>

<body>
<div class="wrapper">
    <?php echo view("admin/partials/topbar", array("title" => "Detail Barang")) ?>
    <?= $this->include('admin/partials/main-nav') ?>

    <div class="page-content">
         <!-- Start Container Fluid -->
         <div class="container-xxl">

            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="p-3">
                            <?php if (session()->has('message')): ?>
                                <div class="alert alert-success"><?= session('message') ?></div>
                            <?php endif; ?>
                            <?php if (session()->has('error')): ?>
                                <div class="alert alert-danger"><?= session('error') ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <div class="clearfix pb-3 bg-info-subtle p-lg-3 p-2 m-n2 rounded position-relative">
                                <div class="float-sm-start">
                                    <img class="logo-dark me-1" src="<?= base_url('assets/admin/images/logo-dark.png')?>" alt="logo-dark" height="24" />
                                    <div class="mt-4">
                                        <h4><?= $toko_nama ?? 'Nama Toko' ?></h4>
                                        <address class="mt-3 mb-0">
                                            <?= $toko_alamat ?? 'Alamat toko di sini' ?><br>
                                            <abbr title="Telepon">Telepon:</abbr> <?= $toko_telepon ?? '+62-812-3456-7890' ?>
                                        </address>
                                    </div>
                                </div>
                                <div class="float-sm-end">
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                            <tr>
                                                <td class="p-0 pe-5 py-1">No. Invoice:</td>
                                                <td class="text-end text-dark fw-semibold px-0 py-1">#<?= $transaksi['invoice_number']; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="p-0 pe-5 py-1">Tanggal Pembayaran:</td>
                                                <td class="text-end text-dark fw-medium px-0 py-1"><?= (empty($payment['paid_at']))? '' : date('d M Y', strtotime($payment['paid_at']?? '')); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="p-0 pe-5 py-1">Jumlah Bayar:</td>
                                                <td class="text-end text-dark fw-medium px-0 py-1">Rp<?= number_format(($payment['amount']?? 0), 0, ',', '.'); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="p-0 pe-5 py-1">Status Pembayaran:</td>
                                                <td class="text-end px-0 py-1">
                                                    <span class="badge bg-<?= (!empty($payment['paid_at'])) ? 'success' : 'warning' ?> text-white px-2 py-1 fs-13">
                                                        <?= (!empty($payment['paid_at'])) ? 'Lunas' : 'Menunggu' ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <?php if ($transaksi['jenis'] == 'Barang'): ?>
                            <!-- Dari dan Untuk -->
                            <div class="clearfix mt-4">
                                <div class="float-sm-start">
                                    <h4 class="card-title">Dikeluarkan Oleh:</h4>
                                    <div class="mt-3">
                                        <h4><?= $toko_nama ?? 'Nama Toko' ?></h4>
                                        <p><?= $toko_alamat ?? 'Alamat toko di sini' ?></p>
                                        <p><u>Telepon:</u> <?= $toko_telepon ?? '+62-812-3456-7890' ?></p>
                                        <p><u>Email:</u> <?= $toko_email ?? 'email@tokomu.com' ?></p>
                                    </div>
                                </div>
                                <div class="float-sm-end">
                                    <h4 class="card-title">Dikirim Kepada:</h4>
                                    <div class="mt-3">
                                        <h4><?= $pengiriman['nama_tujuan'] ?? ''; ?></h4>
                                        <p><?= $pengiriman['alamat'] ?? ''; ?></p>
                                        <p><u>Telepon:</u> <?= $pengiriman['telepon'] ?? ''; ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Daftar Produk -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <table class="table table-borderless text-nowrap table-centered">
                                        <thead class="bg-light bg-opacity-50">
                                            <tr>
                                                <th>Produk</th>
                                                <th>Jumlah</th>
                                                <th>Harga Satuan</th>
                                                <th class="text-end">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($listOrder as $item): ?>
                                            <tr>
                                                <td><?= $item['nama_produk'] ?? 'Produk #' . $item['id_product']; ?></td>
                                                <td><?= $item['qty']; ?></td>
                                                <td>Rp<?= number_format($item['total_price'] / $item['qty'], 0, ',', '.'); ?></td>
                                                <td class="text-end">Rp<?= number_format($item['total_price'], 0, ',', '.'); ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Ringkasan -->
                            <div class="row justify-content-end">
                                <div class="col-lg-5 col-6">
                                    <table class="table table-borderless mb-0">
                                        <?php if ($transaksi['jenis'] == 'Barang'): ?>
                                        <tr>
                                            <td class="text-end p-0 pe-5 py-2">Subtotal Produk:</td>
                                            <td class="text-end text-dark fw-medium py-2">Rp<?= number_format($transaksi['total_price_producta']-$pengiriman['shipping_cost'], 0, ',', '.'); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="text-end p-0 pe-5 py-2">Biaya Pengiriman:</td>
                                            <td class="text-end text-dark fw-medium py-2">Rp<?= number_format($pengiriman['shipping_cost'], 0, ',', '.'); ?></td>
                                        </tr>
                                        <?php endif; ?>
                                        <tr class="border-top">
                                            <td class="text-end p-0 pe-5 py-2">Total Keseluruhan:</td>
                                            <td class="text-end text-dark fw-semibold py-2">Rp<?= number_format($transaksi['total_price_producta'], 0, ',', '.'); ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Dokumen Jasa -->
                            <?php if (!empty($dokumen_jasa)): ?>
                            <div class="mt-3">
                                <h5>Dokumen Tambahan:</h5>
                                <ul>
                                    <?php foreach ($dokumen_jasa as $dok): ?>
                                    <li><a href="<?= $dok['url_dokumen']; ?>" target="_blank">Lihat Dokumen</a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <?php endif; ?>

                            <!-- Catatan -->
                            <div class="alert alert-success mt-4 p-2">
                                Terima kasih dan sampai jumpa di pesanan berikutnya!
                            </div>
                            <!-- Tombol Aksi -->
                            <?php if ($transaksi['jenis'] == 'Barang'): ?>
                                <div class="text-end d-print-none mt-3">
                                    <?php if (in_array($transaksi['status'], ['Kirim', 'Proses'])): ?>
                                        <a href="javascript:window.print()" class="btn btn-info width-xl">Cetak</a>
                                    <?php endif; ?>
                                    <?php if ($transaksi['status'] == 'Proses'): ?>
                                        <button type="button" id="btnKirim" class="btn btn-info width-xl" data-bs-toggle="modal" data-bs-target="#modalResi">
                                            Kirim
                                        </button>
                                    <?php endif; ?>
                                    <?php if ($transaksi['status'] == 'Kirim'): ?>
                                        <a href="<?= base_url('/pesanan/lacak/').  $transaksi['id_transaksi']?>" class="btn btn-info width-xl">Lacak</a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($transaksi['jenis'] == 'Jasa' && $transaksi['status'] == 'Proses'): ?>
                                <div class="text-end d-print-none mt-3">
                                    <button type="button" id="btnSelesai" class="btn btn-info width-xl" data-bs-toggle="modal" data-bs-target="#modalDokumen">
                                        Selesaikan
                                    </button>
                                </div>
                            <?php endif; ?>
                            <?php if ($transaksi['jenis'] == 'Jasa' && $transaksi['status'] == 'Selesai'): ?>
                                <div class="text-end d-print-none mt-3">
                                    <a href="<?=$dokumen['url_dokumen']?>" class="btn btn-info width-xl">Lihat Dokumen</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalResi" tabindex="-1" aria-labelledby="modalResiLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="<?= base_url('admin/transaksi/barang/kirim/'.$transaksi['id_transaksi']) ?>" method="post" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalResiLabel">Input No. Resi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="no_resi" class="form-label">No. Resi</label>
                            <input type="text" class="form-control" id="no_resi" name="no_resi" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Kirim</button>
                    </div>
                    </form>
                </div>
            </div>

            <div class="modal fade" id="modalDokumen" tabindex="-1" aria-labelledby="modalDokumenLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="<?= base_url('admin/transaksi/jasa/selesai/'.$transaksi['id_transaksi']) ?>" method="post" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDokumenLabel">Link Dokumen Jasa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="link_dokumen" class="form-label">Link Dokumen</label>
                            <input type="url" class="form-control" id="link_dokumen" name="link_dokumen" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Selesaikan</button>
                    </div>
                    </form>
                </div>
            </div>

        </div>
        <!-- End Container Fluid -->

        <?= $this->include("admin/partials/footer") ?>
    </div>
</div>

<?= $this->include("admin/partials/vendor-scripts") ?>



</body>

</html>
