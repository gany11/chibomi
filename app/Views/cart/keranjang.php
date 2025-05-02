<?php
echo view('master\header', [
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
                                <tr data-id="<?= $item['id_cart'] ?>">
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
                        <div class="btn-wrapper text-right text-end">
                            <a href="<?= base_url('checkout') ?>" class="theme-btn-1 btn btn-effect-1">Pilih Pengiriman</a>
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

        // Qty change & update
        document.querySelectorAll('.qty-input').forEach(input => {
            input.addEventListener('change', function () {
                const idCart = this.dataset.id;
                let qty = parseInt(this.value);

                if (qty <= 0) {
                    // langsung hapus jika qty <= 0
                    deleteCartItem(idCart);
                    return;
                }

                fetch("<?= base_url('cart/ajaxUpdateQty') ?>", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id_cart=${idCart}&qty=${qty}`
                })
                .then(response => response.json())
                .then(data => {
                    alertContainer.innerHTML = '';
                    if (data.success) {
                        alertContainer.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        alertContainer.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                    }
                })
                .catch(() => {
                    alertContainer.innerHTML = `<div class="alert alert-danger">Terjadi kesalahan saat mengupdate jumlah.</div>`;
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
                    alertContainer.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                    setTimeout(() => location.reload(), 1000);
                } else {
                    alertContainer.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                }
            })
            .catch(() => {
                alertContainer.innerHTML = `<div class="alert alert-danger">Terjadi kesalahan saat menghapus item.</div>`;
            });
        }
    });
</script>


<?php echo view('master\footer'); ?>
