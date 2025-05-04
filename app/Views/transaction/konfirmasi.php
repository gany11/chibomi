<?php
echo view('master/header', ['title' => 'Konfirmasi Pesanan']);
?>

<!-- BREADCRUMB AREA -->
<div class="ltn__breadcrumb-area ltn__breadcrumb-area-2 ltn__breadcrumb-color-white bg-image" data-bg="<?= base_url('assets/img/bg/breadcrumb.png') ?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner ltn__breadcrumb-inner-2 justify-content-between">
                    <div class="section-title-area ltn__section-title-2">
                        <h1 class="section-title black-color">Konfirmasi Pesanan</h1>
                    </div>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="<?= base_url('/') ?>">Beranda</a></li>
                            <li>Konfirmasi Pesanan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SHOPPING CART -->
<div class="liton__shoping-cart-area mb-120">
    <div class="container">
        <div class="row">
            <!-- Flash Messages -->
            <div id="alert-container">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>
            </div>

            <?php
                $grandTotalBarang = 0;
                $grandTotalBeratBarang = 0;
            ?>
            <!-- Barang -->
            <?php if (!empty($barang_items)): ?>
                <div class="col-lg-12 p-3">
                    <div class="shoping-cart-inner">
                        <h3>Barang</h3>
                        <div class="shoping-cart-table table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Harga Satuan</th>
                                        <th>Jumlah</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($barang_items as $item):
                                        $priceUnit = $item['subtotal'] / max($item['qty'], 1);
                                        $grandTotalBarang += $item['subtotal'];
                                        $grandTotalBeratBarang += $item['total_berat_gram'];
                                    ?>
                                    <tr>
                                        <td><?= esc($item['nama_produk']) ?></td>
                                        <td>Rp<?= number_format($priceUnit, 0, ',', '.') ?></td>
                                        <td><?= $item['qty'] ?></td>
                                        <td>Rp<?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-6 p-3">
                                <!-- Alamat & Jasa -->
                                <h4>Pilih Alamat Pengiriman</h4>
                                <?php if (!empty($alamat)): ?>
                                    <div class="form-group">
                                        <select class="form-control" id="alamat" name="alamat">
                                            <?php foreach ($alamat as $a): ?>
                                                <option value="<?= $a['id_address'] ?>" data-kodepos="<?= $a['kode_pos'] ?>" <?= ($a['id_address'] == $selectedAlamatId) ? 'selected' : '' ?>>
                                                    <?= $a['nama_penerima'] ?> | <?= $a['telp_penerima'] ?> | <?= $a['alamat_lengkap'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="col-lg-6 p-3">
                                <h4>Pilih Jasa Pengiriman</h4>
                                <div class="form-group">
                                    <select class="form-control" id="jasa" style="display: none;" name="jasa"></select>
                                </div>
                            </div>
                        </div>

                        <!-- Total Barang -->
                        <div class="shoping-cart-total mt-4">
                            <table class="table">
                                <tr>
                                    <td>Total Barang</td>
                                    <td>Rp<?= number_format($grandTotalBarang, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>Total Berat</td>
                                    <td><?= $grandTotalBeratBarang ?> gram</td>
                                </tr>
                                <tr>
                                    <td>Total Ongkir</td>
                                    <td id="ongkir-display">Rp0</td>
                                </tr>
                                <tr class="bg-light">
                                    <th>Total Seluruh Pesanan</th>
                                    <th id="total-semua-display">Rp<?= number_format($grandTotalBarang + ($grandTotalJasa ?? 0), 0, ',', '.') ?></th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Jasa -->
            <?php if (!empty($jasa_items)): ?>
                <div class="col-lg-12 p-3">
                    <div class="shoping-cart-inner">
                        <h3>Jasa</h3>
                        <div class="shoping-cart-table table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Jasa</th>
                                        <th>Harga Satuan</th>
                                        <th>Jumlah</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $grandTotalJasa = 0;
                                    foreach ($jasa_items as $item):
                                        $priceUnit = $item['subtotal'] / max($item['qty'], 1);
                                        $grandTotalJasa += $item['subtotal'];
                                    ?>
                                    <tr>
                                        <td><?= esc($item['nama_produk']) ?></td>
                                        <td>Rp<?= number_format($priceUnit, 0, ',', '.') ?></td>
                                        <td><?= $item['qty'] ?></td>
                                        <td>Rp<?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="shoping-cart-total mt-4">
                            <h4>Total Jasa</h4>
                            <table class="table">
                                <tr>
                                    <td>Total Jasa</td>
                                    <td>Rp<?= number_format($grandTotalJasa, 0, ',', '.') ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Tombol -->
            <div class="col-lg-12">
                <div class="btn-wrapper text-right mt-4 text-end">
                    <?php if (!empty($barang_items)): ?>
                    <button id="checkout-btn" class="theme-btn-1 btn btn-effect-1">Buat Pesanan</button>
                    <?php else: ?>
                    <button id="checkout-jasa" class="theme-btn-1 btn btn-effect-1">Buat Pesanan</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT -->
<script>
    const jasaSelect = document.getElementById('jasa');
    const alamatSelect = document.getElementById('alamat');
    const ongkirDisplay = document.getElementById('ongkir-display');
    const totalDisplay = document.getElementById('total-semua-display');
    const alertContainer = document.getElementById('alert-container') || document.createElement('div');
    const deliveryServiceMap = <?= json_encode(array_column($delivery_services, 'id_delivery_service', 'kode')) ?>;
    const grandTotalBarang = <?= $grandTotalBarang ?>;
    const grandTotalJasa = <?= $grandTotalJasa ?? 0 ?>;
    const beratTotal = <?= $grandTotalBeratBarang ?>;

    function loadOngkir() {
        const destKodepos = alamatSelect.selectedOptions[0].dataset.kodepos;
        // Ambil kode kurir dari PHP dan gabung jadi format "jne:sicepat:jnt"
        const courier = "<?= implode(':', array_column($delivery_services, 'kode')) ?>";
        if (!courier) {
            alertContainer.innerHTML = `<div class="alert alert-warning">Tidak ada kurir pengiriman yang tersedia.</div>`;
            jasaSelect.innerHTML = '';
            updateTotalHarga(0); // Reset total
            return;
        }

        fetch("<?= base_url('/ongkir/cek') ?>", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                destination: destKodepos,
                weight: beratTotal,
                courier: courier
            })
        })
        .then(res => res.json())
        .then(data => {
            if (!data.data || data.data.length === 0) {
                alertContainer.innerHTML = `<div class="alert alert-danger">Gagal mengambil data ongkir. Silakan coba lagi.</div>`;
                return;
            }            
            jasaSelect.innerHTML = '<option disabled selected>Pilih jasa pengiriman</option>';

            let minOngkir = 0;
            let selectedCost = 0;

            data.data.forEach((service, index) => {
                const idDelivery = deliveryServiceMap[service.code];
                if (!idDelivery) return; 
                const option = document.createElement('option');
                option.value = idDelivery;
                option.text = `${service.name} (${service.description}) - Rp${service.cost.toLocaleString()}`;
                option.dataset.cost = service.cost;

                if (index === 0 || service.cost < minOngkir) {
                    minOngkir = service.cost;
                    selectedCost = service.cost;
                }

                jasaSelect.appendChild(option);
            });

            jasaSelect.style.display = 'block';
            jasaSelect.selectedIndex = 1;

            alertContainer.innerHTML = '';
            updateTotalHarga(selectedCost);
        })
        .catch(err => {
            console.error('Gagal cek ongkir:', err);
            alertContainer.innerHTML = `<div class="alert alert-danger">Gagal mengambil data ongkir: ${err.message || 'Terjadi kesalahan.'}</div>`;
        });
    }

    function updateTotalHarga(ongkir) {
        ongkirDisplay.textContent = 'Rp' + ongkir.toLocaleString();
        const total = grandTotalBarang + grandTotalJasa + ongkir;
        totalDisplay.innerHTML = '<strong>Rp' + total.toLocaleString() + '</strong>';
    }

    alamatSelect.addEventListener('change', loadOngkir);

    jasaSelect.addEventListener('change', () => {
        const cost = jasaSelect.selectedOptions[0].dataset.cost;
        if (cost) {
            updateTotalHarga(parseInt(cost));
        }
    });

    window.addEventListener('DOMContentLoaded', () => {
        loadOngkir(); // Panggil fungsi setelah DOM benar-benar siap
    });
</script>

<script>
    document.getElementById('checkout-btn').addEventListener('click', function () {
        const alertContainer = document.getElementById('alert-container') || document.createElement('div');
        const alamatSelect = document.getElementById('alamat');
        const jasaSelect = document.getElementById('jasa');
        const ongkir = parseInt(document.getElementById('ongkir-display').innerText.replace(/[^\d]/g, '')) || 0;
        const totalBarang = <?= $grandTotalBarang ?? 0 ?>;
        const totalJasa = <?= $grandTotalJasa ?? 0 ?>;
        const totalSeluruh = totalBarang + ongkir + totalJasa;

        const dataToSend = {
            total_seluruh_pesanan: totalSeluruh
        };

        <?php if (!empty($barang_items)): ?>
            const selectedAlamat = alamatSelect.options[alamatSelect.selectedIndex];
            const alamatData = <?= json_encode($alamat) ?>;
            const alamatTerpilih = alamatData.find(a => a.id_address == selectedAlamat.value);

            dataToSend.nama_tujuan = alamatTerpilih.nama_penerima;
            dataToSend.telepon = alamatTerpilih.telp_penerima;
            dataToSend.alamat = {
                alamat_lengkap: alamatTerpilih.alamat_lengkap,
                provinsi: alamatTerpilih.provinsi,
                kota_kabupaten: alamatTerpilih.kota_kabupaten,
                kecamatan: alamatTerpilih.kecamatan,
                kelurahan: alamatTerpilih.kelurahan,
                kode_pos: alamatTerpilih.kode_pos
            };
            dataToSend.shipping_cost = ongkir;
            dataToSend.code = jasaSelect.value;

            dataToSend.listbarang = <?= json_encode(array_map(function($item) {
                return [
                    'id_product' => $item['id_product'],
                    'qty' => $item['qty'],
                    'total_price' => $item['subtotal']
                ];
            }, $barang_items)) ?>;
        <?php endif; ?>

        <?php if (!empty($jasa_items)): ?>
            dataToSend.listjasa = <?= json_encode(array_map(function($item) {
                return [
                    'id_product' => $item['id_product'],
                    'qty' => $item['qty'],
                    'total_price' => $item['subtotal']
                ];
            }, $jasa_items)) ?>;
        <?php endif; ?>

        // Kirim data JSON
        fetch('<?= base_url("pesanan/simpan") ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
            },
            body: JSON.stringify(dataToSend)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect_url || '<?= base_url("pesanan/simpan") ?>';
            } else {
                alertContainer.innerHTML = `<div class="alert alert-danger">Terjadi kesalahan: : ${data.message || 'Unknown error'}</div>`;
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>
<script>
    document.getElementById('checkout-jasa').addEventListener('click', function () {
        const alertContainer = document.getElementById('alert-container') || document.createElement('div');
        const totalJasa = <?= $grandTotalJasa ?? 0 ?>;
        
        const dataToSend = {
            total_seluruh_pesanan: totalJasa
        };

        <?php if (!empty($jasa_items)): ?>
            // Jika ada jasa, tambahkan listjasa
            dataToSend.listjasa = <?= json_encode(array_map(function($item) {
                return [
                    'id_product' => $item['id_product'],
                    'qty' => $item['qty'],
                    'total_price' => $item['subtotal']
                ];
            }, $jasa_items)) ?>;
        <?php endif; ?>

        // Kirim data JSON
        fetch('<?= base_url("pesanan/simpan-jasa") ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
            },
            body: JSON.stringify(dataToSend)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect_url || '<?= base_url("pesanan/simpan-jasa") ?>';
            } else {
                alertContainer.innerHTML = `<div class="alert alert-danger">Terjadi kesalahan: ${data.message || 'Unknown error'}</div>`;
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
     });
</script>

<?php echo view('master/footer'); ?>