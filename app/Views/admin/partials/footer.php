<!-- ========== Footer Start ========== -->
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center">
                <strong>Copyright &copy; <script type='text/javascript'>var creditsyear = new Date();document.write(creditsyear.getFullYear());</script> Chibomi.</strong> All rights reserved.
            </div>
        </div>
    </div

    ><!-- MODAL AREA START (Logout Confirmation Modal) -->
<div class="ltn__modal-area ltn__logout-modal-area">
        <div class="modal fade" id="logout_modal" tabindex="-1">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content text-center p-4">
                    <div class="modal-header border-0 justify-content-end">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-product-item">
                            <h4 class="mb-3">Apakah Anda yakin ingin keluar?</h4>
                            <div class="btn-wrapper d-flex justify-content-center gap-3">
                                <a href="#" id="confirmLogout" class="btn btn-danger">Ya, Keluar</a>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
<!-- MODAL AREA END -->

</footer>
<!-- ========== Footer End ========== -->



<!-- Alert Logout -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let logoutUrl = '';

        // Tangkap klik tombol logout
        document.querySelectorAll('.logout').forEach(function (element) {
            element.addEventListener('click', function (event) {
                event.preventDefault();
                logoutUrl = this.getAttribute('href'); // Simpan URL logout
                const modal = new bootstrap.Modal(document.getElementById('logout_modal'));
                modal.show(); // Tampilkan modal konfirmasi
            });
        });

        // Jika tombol 'Ya, Keluar' diklik
        document.getElementById('confirmLogout').addEventListener('click', function () {
            window.location.href = logoutUrl;
        });
    });
</script>