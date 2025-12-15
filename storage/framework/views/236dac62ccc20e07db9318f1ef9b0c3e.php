<!-- Navbar -->
<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="ti ti-menu-2 ti-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        
        <!-- /Search -->

        <div class="left-header col-xxl-5 col-xl-6 col-lg-5 col-md-4 col-4 col-sm-3 p-0">
            <marquee>
                <div class="notification-slider">
                    <div class="d-flex h-100"> 
                        <h6 class="mb-0 f-w-500"><span class="font-primary text-danger">&nbsp;&nbsp;Welcome to <?php echo e(@json_decode(app\Models\Company::where('website', $_SERVER['HTTP_HOST'])->first(['companyname']))->companyname); ?> Dashboard </span></h6><i class="icon-arrow-top-right f-light"></i>
                    </div>
                </div>
            </marquee>
        </div>
        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- Language -->
            
            <!--/ Language -->

            <!-- Style Switcher -->
            <li class="nav-item me-2 me-xl-0">
                <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);">
                    <i class="ti ti-md"></i>
                </a>
            </li>
            <!--/ Style Switcher -->

            <!-- Quick links  -->
            <?php if(Myhelper::hasRole('admin')): ?>
            <li class="nav-item me-2 me-xl-0 cursor-pointer">
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#walletloadModal">
                    Load Wallet<i class="ti ti-wallet ti-sm"></i>
                </button>
            </li>
            <?php endif; ?>

            <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-2 me-xl-0">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    <i class="ti ti-wallet ti-md"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end py-0">
                    <div class="dropdown-menu-header border-bottom">
                        <div class="dropdown-header bg-primary  d-flex align-items-center py-3">
                            <h5 class="text-white mb-0 me-auto">Wallet Balance</h5>
                        </div>
                    </div>
                    <div class="dropdown-shortcuts-list scrollable-container">
                        <div class="row row-bordered overflow-visible g-0">
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                                    <i class="ti ti-calendar fs-4"></i>
                                </span>
                                <a href="<?php echo e(route('statement', ['type' => 'account'])); ?>" class="stretched-link">Main Wallet</a>
                                <small class="text-muted mb-0">&#8377; <?php echo e(Auth::user()->mainwallet); ?> /-</small>
                            </div>
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                                    <i class="ti ti-file-invoice fs-4"></i>
                                </span>
                                <a href="<?php echo e(route('statement', ['type' => 'awallet'])); ?>" class="stretched-link">AEPS Wallet</a>
                                <small class="text-muted mb-0"> &#8377; <?php echo e(Auth::user()->aepsbalance); ?> /-</small>
                            </div>
                             <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                                    <i class="ti ti-file-invoice fs-4"></i>
                                </span>
                                <a href="<?php echo e(route('fund', ['type' => 'ccrequest'])); ?>" class="stretched-link">CC Wallet</a>
                                <small class="text-muted mb-0"> &#8377; <?php echo e(Auth::user()->ccwallet); ?> /-</small>
                            </div>
                            <?php if(\Myhelper::hasNotRole('admin')): ?>
                            <div class="dropdown-shortcuts-item col">
                                    <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                                        <i class="ti ti-file fs-4"></i>
                                    </span>
                                <a href="#" class="stretched-link">Commision Wallet</a>
                                    <small class="text-muted mb-0"> &#8377; <?php echo e(Auth::user()->commission_wallet); ?> /-</small>
                            </div>
                            <?php endif; ?>
                            
                        </div>

                    </div>
                </div>
            </li>
            <!-- Quick links -->

            <!-- Notification -->
            
            <!--/ Notification -->

            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="<?php echo e(asset('theme_1/assets/img/avatars/1.png')); ?>" alt class="h-auto rounded-circle" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="javascript:void(0)">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="<?php echo e(asset('theme_1/assets/img/avatars/1.png')); ?>" alt class="h-auto rounded-circle" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block">Hello <?php echo e(explode(' ',ucwords(Auth::user()->name))[0]); ?></span>
                                    <small class="text-muted d-block"><?php echo e(Auth::user()->role->name); ?></small>
                                    <small class="text-muted">UserId - <?php echo e(Auth::id()); ?></small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a href="<?php echo e(route('profile')); ?>" class="dropdown-item">
                            <i class="ti ti-user-check me-2 ti-sm"></i>
                            <span class="align-middle">
                                My Profile
                            </span>
                        </a>
                    </li>


                    
                    <li>
                        <a class="dropdown-item" href="<?php echo e(route('logout')); ?>">
                            <i class="ti ti-logout me-2 ti-sm"></i>
                            <span class="align-middle">Log Out</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
        </div>

  



    <!-- Search Small Screens -->
    <div class="navbar-search-wrapper search-input-wrapper d-none">
        <input type="text" class="form-control search-input container-xxl border-0" placeholder="Search..." aria-label="Search..." />
        <i class="ti ti-x ti-sm search-toggler cursor-pointer"></i>
    </div>
</nav>
<!-- / Navbar --><?php /**PATH C:\wamp64\www\flight_b2b_travel\flight_b2b_travel\resources\views/layouts/topbar.blade.php ENDPATH**/ ?>