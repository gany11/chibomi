<div class="col-lg-4">
    <div class="ltn__tab-menu-list mb-50">
        <div class="nav">
            <?php if (session()->has('id_account') && (session()->get('role') === 'Pelanggan')): ?>
            <a <?=$title === 'Pesanan' ? 'class="active show"' : '';?> href="<?= base_url('/pesanan') ?>">Pesanan Saya <i class="fas fa-file-alt"></i></a>
            <a <?=$title === 'Alamat' ? 'class="active show"' : '';?> href="<?= base_url('/alamat') ?>">Alamat <i class="fas fa-map-marker-alt"></i></a>
            <?php endif; ?>
            <a <?=$title === 'Profil Akun' ? 'class="active show"' : '';?> href="<?= base_url('/profil') ?>">Profil Akun <i class="fas fa-user"></i></a>
            <a class="logout" href="<?= base_url('/logout') ?>">Logout <i class="fas fa-sign-out-alt"></i></a>
        </div>
    </div>
</div>