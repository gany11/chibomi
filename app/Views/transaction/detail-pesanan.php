<?php
echo view('master\header', [
    'title' => 'Detail Pesanan'
]);?>

<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area ltn__breadcrumb-area-2 ltn__breadcrumb-color-white bg-image" data-bg="<?php echo base_url('assets/img/bg/breadcrumb.png')?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner ltn__breadcrumb-inner-2 justify-content-between">
                    <div class="section-title-area ltn__section-title-2">
                        <h1 class="section-title black-color">Detail Pesanan Saya</h1>
                    </div>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="<?php echo base_url('/')?>">Beranda</a></li>
                            <li><a href="<?php echo base_url('/pesanan')?>">Pesanan</a></li>
                            <li>Detail</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->

<!-- WISHLIST AREA START -->
<div class="liton__wishlist-area pb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- PRODUCT TAB AREA START -->
                <div class="ltn__product-tab-area">
                    <div class="container">
                        <div class="row">
                            <?php
                            echo view('master\menu-list-akun', [
                                'title' => 'Pesanan'
                            ]);?>
                            <div class="col-lg-8">
                                <div class="tab-content">
                                    <div class="tab-pane fade active show">
                                        <div id="alert-container">
                                            <?php if (session()->getFlashdata('success')): ?>
                                                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                                            <?php endif; ?>
                                            <?php if (session()->getFlashdata('error')): ?>
                                                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="ltn__myaccount-tab-content-inner">
                                            <!-- Informasi Transaksi -->
                                            <div class="card mb-4">
                                                <div class="card-header">Informasi Pesanan</div>
                                                <div class="card-body">
                                                    <p><strong>Invoice:</strong> <?= esc($pesanan['invoice_number']) ?></p>
                                                    <p><strong>Status:</strong> <?= esc($pesanan['status']) ?></p>
                                                    <p><strong>Jenis:</strong> <?= esc($pesanan['jenis']) ?></p>
                                                    <p><strong>Total Tagihan:</strong> Rp<?= number_format($pesanan['total_price_producta'], 0, ',', '.') ?></p>
                                                </div>
                                            </div>

                                            <!-- Pengiriman -->
                                            <?php if (!empty($pengiriman)) : ?>
                                                <?php $peng = $pengiriman[0]; ?>
                                                <div class="card mb-4">
                                                    <div class="card-header">Informasi Pengiriman</div>
                                                    <div class="card-body">
                                                        <p><strong>Nama Tujuan:</strong> <?= esc($peng['nama_tujuan']) ?></p>
                                                        <p><strong>No. Telepon:</strong> <?= esc($peng['telepon']) ?></p>
                                                        <p><strong>Alamat:</strong> <?= esc($peng['alamat']) ?></p>
                                                        <p><strong>Kurir:</strong> <?= esc($peng['nama']) ?> (<?= esc(strtoupper($peng['kode'])) ?>)</p>
                                                        <p><strong>Biaya Pengiriman:</strong> Rp<?= number_format($peng['shipping_cost'], 0, ',', '.') ?></p>
                                                        <p><strong>No. Resi:</strong> <?= $peng['resi'] ? esc($peng['resi']) : '<em>Belum tersedia</em>' ?></p>
                                                        <?php if ($pesanan['status'] == 'Kirim') : ?>
                                                            <a href="<?= base_url('pesanan/lacak/' . $pesanan['id_transaksi']) ?>" class="theme-btn-1 btn btn-effect-1 mt-2">Lacak</a>
                                                            <button class="theme-btn-1 btn btn-effect-1 mt-2" onclick="ubahStatus('<?= $pesanan['id_transaksi'] ?>', 'Selesai', '<?= $pesanan['status'] ?>')">Selesai</button>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <!-- Produk -->
                                            <div class="card mb-4">
                                                <div class="card-header">Produk Dipesan</div>
                                                <div class="card-body table-responsive">
                                                    <?php if (!empty($listOrder)) : ?>
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Produk</th>
                                                                    <th>Jumlah</th>
                                                                    <th>Harga Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($listOrder as $item) : ?>
                                                                    <tr>
                                                                        <td><?= esc($item['nama_produk']) ?></td>
                                                                        <td><?= esc($item['qty']) ?></td>
                                                                        <td>Rp<?= number_format($item['total_price'], 0, ',', '.') ?></td>
                                                                    </tr>
                                                                    <?php if ($pesanan['status'] == 'Selesai') : ?>
                                                                        <tr>
                                                                            <td colspan="3">
                                                                                <?php if (empty($item['rating']) || empty($item['ulasan'])) : ?>
                                                                                    <!-- FORM ULASAN -->
                                                                                    <form action="<?= base_url('produk/ulasan/kirim') ?>" method="POST" class="mt-2">
                                                                                        <?= csrf_field() ?>
                                                                                        <input type="hidden" name="id_product_order" value="<?= esc($item['id_product_order']) ?>">
                                                                                        <h6 class="mb-2">Beri Ulasan untuk <strong><?= esc($item['nama_produk']) ?></strong></h6>

                                                                                        <div class="mb-2">
                                                                                            <label class="d-block">Rating</label>
                                                                                            <div class="d-flex gap-2">
                                                                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                                                                    <div class="form-check form-check-inline">
                                                                                                        <input class="form-check-input" type="radio" name="rating" id="rating<?= $item['id_product_order'] ?>-<?= $i ?>" value="<?= $i ?>" required>
                                                                                                        <label class="form-check-label" for="rating<?= $item['id_product_order'] ?>-<?= $i ?>">
                                                                                                            <?= str_repeat('★', $i) ?>
                                                                                                        </label>
                                                                                                    </div>
                                                                                                <?php endfor; ?>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="mb-2">
                                                                                            <label for="ulasan<?= $item['id_product_order'] ?>">Ulasan</label>
                                                                                            <textarea name="ulasan" id="ulasan<?= $item['id_product_order'] ?>" rows="3" class="form-control" required></textarea>
                                                                                        </div>

                                                                                        <button class="btn btn-sm btn-primary" type="submit">Kirim Ulasan</button>
                                                                                    </form>
                                                                                <?php else : ?>
                                                                                    <!-- TAMPIL ULASAN -->
                                                                                    <div class="alert alert-success mb-0">
                                                                                        <strong>Rating:</strong> <?= esc($item['rating']) ?>/5<br>
                                                                                        <strong>Ulasan:</strong> <?= esc($item['ulasan']) ?>
                                                                                    </div>
                                                                                <?php endif; ?>
                                                                            </td>
                                                                        </tr>
                                                                    <?php endif; ?>
                                                                <?php endforeach ?>
                                                            </tbody>
                                                        </table>
                                                    <?php else : ?>
                                                        <p>Tidak ada produk dalam pesanan ini.</p>
                                                    <?php endif; ?>

                                                    <?php if (($pesanan['status'] == 'Selesai') && ($pesanan['jenis'] == 'Jasa')) : ?>
                                                        <a href="<?= $dokumen['url_dokumen'] ?>" class="theme-btn-1 btn btn-effect-1 mt-2">Lihat Dokumen</a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <!-- Pembayaran -->
                                            <div class="card mb-4">
                                                <div class="card-header">Informasi Pembayaran</div>
                                                <div class="card-body">
                                                    <?php if (!empty($payment)) : ?>
                                                        <?php foreach ($payment as $p) : ?>
                                                            <p><strong>Metode:</strong> <?= esc($p['payment_method']) ?></p>
                                                            <p><strong>Status:</strong> <?= esc($p['status_pembayaran']) ?></p>
                                                            <p><strong>Total Dibayar:</strong> Rp<?= number_format($p['amount'], 0, ',', '.') ?></p>
                                                            <p><strong>Tanggal Bayar:</strong> <?= esc($p['paid_at']) ?></p>
                                                        <?php endforeach ?>
                                                    <?php else : ?>
                                                        <p><em>Belum ada data pembayaran.</em></p>
                                                        <?php if ($pesanan['status'] == 'Pending') : ?>
                                                            <button id="pay-button" class="theme-btn-1 btn btn-effect-1 mt-2">Bayar Sekarang</button>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- PRODUCT TAB AREA END -->
                 <!-- MODAL AREA START (Ubah Status) -->
                <div class="modal fade" id="ubahStatusModal" tabindex="-1">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content text-center p-4">
                            <div class="modal-header border-0 justify-content-end">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <h4 class="mb-3">Yakin ingin mengubah status pesanan ke <span id="statusBaruText" class="text-primary"></span>?</h4>
                                <div class="btn-wrapper d-flex justify-content-center gap-3">
                                    <button type="button" id="konfirmasiUbahStatus" class="btn btn-primary">Ya, Ubah</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                </div>
                                <div id="alert-container" class="mt-3 w-100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- MODAL AREA END -->
            </div>
        </div>
    </div>
</div>
<!-- WISHLIST AREA START -->
<script>
    let idPesanan = null;
    let statusBaru = null;
    let statusAwal = null;

    function ubahStatus(id, newStatus, currentStatus) {
        idPesanan = id;
        statusBaru = newStatus;
        statusAwal = currentStatus;
        document.getElementById('statusBaruText').innerText = newStatus;
        const modal = new bootstrap.Modal(document.getElementById('ubahStatusModal'));
        modal.show();
    }

    document.getElementById('konfirmasiUbahStatus').addEventListener('click', function () {
        fetch('/pesanan/ubah-status', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
            },
            body: JSON.stringify({ id: idPesanan, status: statusBaru, statusawal: statusAwal })
        })
        .then(response => response.json())
        .then(data => {
            const alertContainer = document.getElementById('alert-container');
            alertContainer.innerHTML = '';

            if (data.success) {
                alertContainer.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                setTimeout(() => location.reload(), 1000);
            } else {
                alertContainer.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
            }
        })
        .catch(error => {
            const alertContainer = document.getElementById('alert-container');
            alertContainer.innerHTML = `<div class="alert alert-danger">Terjadi kesalahan saat memproses permintaan.</div>`;
        });
    });
</script>

<script type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="SB-Mid-client-KB8nG-D3f0xF0sfN"></script>
<script type="text/javascript">
    document.getElementById('pay-button').addEventListener('click', function () {
        const alertContainer = document.getElementById('alert-container') || document.createElement('div');
        fetch('<?= base_url('pesanan/bayar/' . $pesanan['id_transaksi']) ?>')
            .then(response => response.json())
            .then(data => {
                if (data.snap_token) {
                    snap.pay(data.snap_token);
                } else {
                    alertContainer.innerHTML = `<div class="alert alert-danger">Gagal mendapatkan token pembayaran.</div>`;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alertContainer.innerHTML = `<div class="alert alert-danger">Terjadi kesalahan saat memproses pembayaran.</div>`;
            });
    });
</script>


<?php echo view('master\footer'); ?>
