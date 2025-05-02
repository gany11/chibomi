<div class="main-nav">
     <!-- Sidebar Logo -->
     <div class="logo-box">
          <a href="/" class="logo-dark">
               <img src="<?= base_url('assets/admin/images/logo-sm.png')?>" class="logo-sm" alt="logo sm">
               <img src="<?= base_url('assets/admin/images/logo-dark.png')?>" class="logo-lg" alt="logo dark">
          </a>

          <a href="/" class="logo-light">
               <img src="<?= base_url('assets/admin/images/logo-sm.png')?>" class="logo-sm" alt="logo sm">
               <img src="<?= base_url('assets/admin/images/logo-light.png')?>" class="logo-lg" alt="logo light">
          </a>
     </div>

     <!-- Menu Toggle Button (sm-hover) -->
     <button type="button" class="button-sm-hover" aria-label="Show Full Sidebar">
          <iconify-icon icon="solar:double-alt-arrow-right-bold-duotone" class="button-sm-hover-icon"></iconify-icon>
     </button>

     <div class="scrollbar" data-simplebar>
          <ul class="navbar-nav" id="navbar-nav">

               <!-- <li class="menu-title">General</li> -->

               <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/admin')?>">
                         <span class="nav-icon">
                              <iconify-icon icon="solar:widget-5-bold-duotone"></iconify-icon>
                         </span>
                         <span class="nav-text"> Beranda</span>
                    </a>
               </li>

               <li class="nav-item">
                    <a class="nav-link menu-arrow" href="#sidebarProducts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProducts">
                         <span class="nav-icon">
                              <iconify-icon icon="solar:t-shirt-bold-duotone"></iconify-icon>
                         </span>
                         <span class="nav-text"> Produk </span>
                    </a>
                    <div class="collapse" id="sidebarProducts">
                         <ul class="nav sub-navbar-nav">
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="<?= base_url('/admin/barang/list')?>">Barang</a>
                              </li>
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="<?= base_url('/admin/jasa/list')?>">Jasa</a>
                              </li>
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="<?= base_url('/admin/produk/tambah')?>">Tambah Produk</a>
                              </li>
                         </ul>
                    </div>
               </li>

               <li class="nav-item">
                    <a class="nav-link menu-arrow" href="#sidebarPortofolio" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPortofolio">
                         <span class="nav-icon">
                              <iconify-icon icon="solar:document-text-bold-duotone"></iconify-icon>
                         </span>
                         <span class="nav-text"> Portofolio </span>
                    </a>
                    <div class="collapse" id="sidebarPortofolio">
                         <ul class="nav sub-navbar-nav">
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="<?= base_url('/admin/portofolio/tambah')?>">Tambah</a>
                              </li>
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="<?= base_url('/admin/portofolio/list')?>">List</a>
                              </li>
                         </ul>
                    </div>
               </li>

               <li class="nav-item">
                    <a class="nav-link menu-arrow" href="#sidebarOrders" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarOrders">
                         <span class="nav-icon">
                              <iconify-icon icon="solar:bag-smile-bold-duotone"></iconify-icon>
                         </span>
                         <span class="nav-text"> Pesanan </span>
                    </a>
                    <div class="collapse" id="sidebarOrders">
                         <ul class="nav sub-navbar-nav">

                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="<?= base_url('/admin/pesanan/list')?>">List</a>
                              </li>
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="<?= base_url('/admin/pesanan/laporan')?>">Laporan</a>
                              </li>
                         </ul>
                    </div>
               </li>

               <li class="nav-item">
                    <a class="nav-link menu-arrow" href="#sidebarAkun" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAkun">
                         <span class="nav-icon">
                              <iconify-icon icon="solar:users-group-two-rounded-bold-duotone"></iconify-icon>
                         </span>
                         <span class="nav-text"> Akun </span>
                    </a>
                    <div class="collapse" id="sidebarAkun">
                         <ul class="nav sub-navbar-nav">
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link"  href="<?= base_url('/admin/akun/registrasi-admin')?>">Registrasi Admin</a>
                              </li>
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link"  href="<?= base_url('/admin/akun/list')?>">List</a>
                              </li>
                         </ul>
                    </div>
               </li>

               <li class="nav-item">
                    <a class="nav-link menu-arrow" href="#sidebarSellers" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarSellers">
                         <span class="nav-icon">
                              <iconify-icon icon="solar:shop-bold-duotone"></iconify-icon>
                         </span>
                         <span class="nav-text"> Jasa Pengiriman </span>
                    </a>
                    <div class="collapse" id="sidebarSellers">
                         <ul class="nav sub-navbar-nav">
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="<?= base_url('/admin/pengiriman/tambah')?>">Tambah</a>
                              </li>
                              <li class="sub-nav-item">
                                   <a class="sub-nav-link" href="<?= base_url('/admin/pengiriman/list')?>">List</a>
                              </li>
                         </ul>
                    </div>
               </li>
          </ul>
     </div>
</div>