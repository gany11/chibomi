<header class="topbar">
     <div class="container-fluid">
          <div class="navbar-header">
               <div class="d-flex align-items-center">
                    <!-- Menu Toggle Button -->
                    <div class="topbar-item">
                         <button type="button" class="button-toggle-menu me-2">
                              <iconify-icon icon="solar:hamburger-menu-broken" class="fs-24 align-middle"></iconify-icon>
                         </button>
                    </div>

                    <!-- Menu Toggle Button -->
                    <div class="topbar-item">
                         <h4 class="fw-bold topbar-button pe-none text-uppercase mb-0"><?php echo ($title) ? $title : 'Chibomi' ?></h4>
                    </div>
               </div>

               <div class="d-flex align-items-center gap-1">

                    <!-- Theme Color (Light/Dark) -->
                    <div class="topbar-item">
                         <button type="button" class="topbar-button" id="light-dark-mode">
                              <iconify-icon icon="solar:moon-bold-duotone" class="fs-24 align-middle"></iconify-icon>
                         </button>
                    </div>

                    <!-- User -->
                    <div class="dropdown topbar-item">
                         <a type="button" class="topbar-button" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <span class="d-flex align-items-center">
                                   <img class="rounded-circle" width="32" src="<?= base_url('assets/admin/images/logo-sm.png')?>" alt="avatar-3">
                              </span>
                         </a>
                         <div class="dropdown-menu dropdown-menu-end">
                              <!-- item-->
                              <h6 class="dropdown-header"><?php echo session()->get('nama'); ?></h6>
                              <a class="dropdown-item" href="<?= base_url('admin/profil')?>">
                                   <i class="bx bx-user-circle text-muted fs-18 align-middle me-1"></i><span class="align-middle">Prpfil</span>
                              </a>
                              
                              <a class="dropdown-item" href="<?= base_url('/')?>">
                                   <i class="bx bx-log-out fs-18 align-middle me-1"></i><span class="align-middle">Mode Pelanggan</span>
                              </a>

                              <div class="dropdown-divider my-1"></div>

                              <a class="dropdown-item text-danger logout" href="<?= base_url('logout')?>">
                                   <i class="bx bx-log-out fs-18 align-middle me-1"></i><span class="align-middle">Logout</span>
                              </a>
                         </div>
                    </div>

                    <!-- App Search-->
                    <!-- <form class="app-search d-none d-md-block ms-2">
                         <div class="position-relative">
                              <input type="search" class="form-control" placeholder="Search..." autocomplete="off" value="">
                              <iconify-icon icon="solar:magnifer-linear" class="search-widget-icon"></iconify-icon>
                         </div>
                    </form> -->
               </div>
          </div>
     </div>
</header>