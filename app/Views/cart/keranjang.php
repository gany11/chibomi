<?php
echo view('master/header', [
    'title' => 'Keranjang'
]);
?>

<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area ltn__breadcrumb-area-2 ltn__breadcrumb-color-white bg-image" data-bg="<?= base_url('assets/img/bg/breadcrumb.png') ?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner ltn__breadcrumb-inner-2 justify-content-between">
                    <div class="section-title-area ltn__section-title-2">
                        <h1 class="section-title black-color">Keranjang</h1>
                    </div>
                    <div class="ltn__breadcrumb-list">
                        <ul>
                            <li><a href="<?= base_url('/') ?>">Beranda</a></li>
                            <li>Keranjang</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->

<!-- SHOPPING CART AREA START -->
<div class="liton__shoping-cart-area mb-120">
    <div class="container">
        <div class="row">
            <div id="alert-container">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>
            </div>

            <div class="col-lg-12">
                <div class="shoping-cart-inner">
                    <div class="shoping-cart-table table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="cart-product-remove">Hapus</th>
                                    <th class="cart-product-image">Foto Produk</th>
                                    <th class="cart-product-info">Produk</th>
                                    <th class="cart-product-price">Harga Satuan</th>
                                    <th class="cart-product-quantity">Jumlah Produk</th>
                                    <th class="cart-product-subtotal">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $grandTotal = 0;
                                foreach ($cartItems as $item):
                                    $subtotal = $item['price_unit'] * $item['qty'];
                                    $grandTotal += $subtotal;
                                ?>
                                <tr data-id="<?= $item['id_cart'] ?>" data-idp="<?= $item['id_product'] ?>" data-jenis="<?= esc($item['jenis']) ?>" data-nama="<?= esc($item['nama_produk']) ?>" data-berat="<?= $item['total_berat_gram'] ?>" data-volume="<?= $item['total_volume_cm3'] ?>">
                                    <td class="cart-product-remove">
                                        <a href="#" class="remove-item" data-id="<?= $item['id_cart'] ?>">×</a>
                                    </td>
                                    <td class="cart-product-image">
                                        <a href="<?= base_url('produk/' . $item['slug']) ?>">
                                            <img src="<?= base_url('assets/img/product/' . ($item['image_file'] ?? '1.png')) ?>" alt="#">
                                        </a>
                                    </td>
                                    <td class="cart-product-info">
                                        <h4><a href="<?= base_url('produk/detail/' . $item['slug']) ?>"><?= esc($item['nama_produk']) ?></a></h4>
                                    </td>
                                    <td class="cart-product-price">Rp<?= number_format($item['price_unit'], 0, ',', '.') ?></td>
                                    <td class="cart-product-quantity">
                                        <div class="cart-plus-minus">
                                            <input type="number" min="1" class="cart-plus-minus-box qty-input" data-id="<?= $item['id_cart'] ?>" value="<?= $item['qty'] ?>">
                                        </div>
                                    </td>
                                    <td class="cart-product-subtotal">Rp<?= number_format($subtotal, 0, ',', '.') ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="shoping-cart-total mt-50">
                        <h4>Total</h4>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Total Pesanan</td>
                                    <td>Rp<?= number_format($grandTotal, 0, ',', '.') ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="btn-wrapper text-right mt-4 text-end">
                            <button id="checkout-btn" class="theme-btn-1 btn btn-effect-1 <?= (empty($cartItems)? 'disabled': '')?>">Konfirmasi Pesanan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL KONFIRMASI HAPUS -->
<div class="modal fade" id="hapusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content text-center p-4">
            <div class="modal-header border-0 justify-content-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <h4 class="mb-3">Apakah Anda yakin ingin menghapus produk ini dari keranjang?</h4>
                <div class="btn-wrapper d-flex justify-content-center gap-3">
                    <button id="confirmHapus" class="btn btn-danger">Ya, Hapus</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alertContainer = document.getElementById('alert-container');
        let cartIdToDelete = null;

        // Pantau perubahan value dari input secara berkala (misalnya dengan MutationObserver atau polling)
        document.querySelectorAll('.qty-input').forEach(input => {
            let previousValue = input.value;

            setInterval(() => {
                if (input.value !== previousValue) {
                    previousValue = input.value;
                    input.dispatchEvent(new Event('change'));
                }
            }, 300);
        });

        // Event change tetap di sini untuk AJAX update
        document.querySelectorAll('.qty-input').forEach(input => {
            input.addEventListener('change', function () {
                const idCart = this.dataset.id;
                const qty = parseInt(this.value);

                if (qty <= 0) return;

                fetch("<?= base_url('cart/ajaxUpdateQty') ?>", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id_cart=${idCart}&qty=${qty}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alertContainer.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                        setTimeout(() => location.reload(), 3000);
                    // alert(data.message);
                    }
                })
                .catch(() => {
                    alertContainer.innerHTML = `<div class="alert alert-danger">Terjadi kesalahan saat mengubah jumlah item.</div>`;
                    setTimeout(() => location.reload(), 3000);
                    // alert("Gagal update jumlah.");
                });
            });
        });

        // Hapus item (dengan konfirmasi modal)
        document.querySelectorAll('.remove-item').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                cartIdToDelete = this.dataset.id;
                const modal = new bootstrap.Modal(document.getElementById('hapusModal'));
                modal.show();
            });
        });

        document.getElementById('confirmHapus').addEventListener('click', function () {
            if (!cartIdToDelete) return;
            deleteCartItem(cartIdToDelete);
        });

        function deleteCartItem(idCart) {
            fetch("<?= base_url('cart/delete') ?>", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id_cart=${idCart}`
            })
            .then(response => response.json())
            .then(data => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('hapusModal'));
                if (modal) modal.hide();

                alertContainer.innerHTML = '';
                if (data.success) {
                    setTimeout(() => location.reload(), 1000);
                } else {
                    alertContainer.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                    setTimeout(() => location.reload(), 3000);
                }
            })
            .catch(() => {
                alertContainer.innerHTML = `<div class="alert alert-danger">Terjadi kesalahan saat menghapus item.</div>`;
                setTimeout(() => location.reload(), 3000);
            });
        }
    });
</script>
<script>
    document.getElementById('checkout-btn').addEventListener('click', function () {
        const alertContainer = document.getElementById('alert-container') || document.createElement('div');
        const rows = document.querySelectorAll('tr[data-id]');
        const cartItems = [];

        rows.forEach(row => {
            const id = row.getAttribute('data-id');
            const idp = row.getAttribute('data-idp');
            const nama = row.getAttribute('data-nama');
            const jenis = row.getAttribute('data-jenis');
            const berat = parseFloat(row.getAttribute('data-berat')) || 0;
            const volume = parseFloat(row.getAttribute('data-volume')) || 0;

            const qty = parseInt(row.querySelector('.qty-input')?.value || 1);
            const priceText = row.querySelector('.cart-product-price').textContent.replace(/[^\d]/g, '');
            const price = parseInt(priceText);
            const subtotal = price * qty;

            cartItems.push({
                id_cart: id,
                id_product: idp,
                nama_produk: nama,
                jenis: jenis,
                qty: qty,
                subtotal: subtotal,
                total_berat_gram: berat,
                total_volume_cm3: volume
            });
        });

        fetch("<?= base_url('/pesanan/cek') ?>", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ cartItems: cartItems })
        })
        .then(res => res.json())
        .then(response => {
            if (response.success) {
                window.location.href = "<?= base_url('/pesanan/cek') ?>";
            } else {
                alertContainer.innerHTML = `<div class="alert alert-danger">Gagal mengirim data: ${response.message || 'Terjadi kesalahan.'}</div>`;
                if (!document.getElementById('alert-container')) {
                    alertContainer.id = 'alert-container';
                    document.body.prepend(alertContainer);
                }
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alertContainer.innerHTML = `<div class="alert alert-danger">Kesalahan koneksi: ${error.message}</div>`;
            if (!document.getElementById('alert-container')) {
                alertContainer.id = 'alert-container';
                document.body.prepend(alertContainer);
            }
        });
    });
</script>




<?php echo view('master/footer'); ?>
