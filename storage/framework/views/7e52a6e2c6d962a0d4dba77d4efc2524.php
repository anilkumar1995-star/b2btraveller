<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('pagetitle', 'Dashboard'); ?>
<?php $__env->startSection('content'); ?>
    <!-- Content -->


    <div id="loading">
        <div id="loading-center">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12 d-flex flex-wrap gap-3 justify-content-end">
            <button id="generateUrlBtn" class="btn btn-primary">
                Flight Booking Traveller URL
            </button>


            <form id="searchByUsernameForm" class="d-inline-flex align-items-center gap-2" method="GET" action="">
                <input type="text" name="username" class="form-control" placeholder="Search By Username">
                <button type="submit" class="btn btn-primary"><i class="ti ti-search"></i></button>
            </form>

            <form id="searchByTxnidForm" class="d-inline-flex align-items-center gap-2" method="GET" action="">
                <input type="text" name="txnid" class="form-control" placeholder="Search By TID">
                <button type="submit" class="btn btn-primary"><i class="ti ti-search"></i></button>
            </form>
        </div>
    </div>

    <div id="dashboardContent">
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <h5 class="mb-1 fw-bold text-white">Get Business</h5>
                        
                        <div class="progress w-75 mt-3" style="height: 4px">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuenow="0"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-danger text-white shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <h6 class="mb-1 fw-bold text-white">IMPS Pending / Txn Count</h6>
                        <span class="fs-5">1200 / 1</span>
                        <div class="progress w-75 mt-2" style="height: 4px">
                            <div class="progress-bar" role="progressbar" style="width: 100%; background:rgb(150, 10, 10)"
                                aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <h6 class="mb-1 fw-bold text-white">NEFT Pending / Txn Count</h6>
                        <span class="fs-5">0 / 0</span>
                        <div class="progress w-75 mt-2" style="height: 4px">
                            <div class="progress-bar" role="progressbar" style="width: 100%; background: #7fe8f7"
                                aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <h6 class="mb-1 fw-bold text-white">CMS Balance</h6>
                        <span class="fs-5">4351022.13</span>
                        <div class="progress w-75 mt-2" style="height: 4px">
                            <div class="progress-bar" role="progressbar" style="width: 100%; background: #7fe8f7"
                                aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <h6 class="mb-1 fw-bold text-white">IMPS Balance</h6>
                        <span class="fs-5">0.00</span>
                        <div class="progress w-75 mt-2" style="height: 4px">
                            <div class="progress-bar" role="progressbar" style="width: 100%; background: #7ff793"
                                aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-white shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <h6 class="mb-1 fw-bold">NSDL PAN Balance</h6>
                        <span class="fs-5">0.00</span>
                        <div class="progress w-75 mt-2" style="height: 4px">
                            <div class="progress-bar" role="progressbar" style="width: 100%; background: #ff802c"
                                aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- End Dashboard Cards -->


        <!-- Add this below your main dashboard cards/row -->
        <div class="row mb-4">
            <!-- Slider Section -->
            <div class="col-lg-8">
                <div id="dashboardSlider" class="carousel slide shadow-sm rounded" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="<?php echo e(asset('')); ?>public/banner/banner1.jpg" class="d-block w-100 rounded"
                                alt="Aadhaar Pay Banner">
                        </div>
                        <div class="carousel-item">
                            <img src="<?php echo e(asset('')); ?>public/banner/banner2.jpg" class="d-block w-100 rounded"
                                alt="Customer Service">
                        </div>
                        <!-- Add more carousel-item blocks for more images -->
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#dashboardSlider"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#dashboardSlider"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>
            <!-- Latest Updates Section -->
            <div class="col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Latest Updates</h5>
                    </div>
                    <div class="card-body" style="min-height: 200px;">
                        <ul class="list-unstyled mt-4" id="latestUpdates">

                            <li>
                                
                                <?php echo nl2br($mydata['notice']); ?>

                            </li>
                            <!-- Add more updates as needed -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Slider & Updates Block -->
    </div>


    <div id="txnResult" class="mt-4" style="display:none;">
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="card-datatable table-responsive">
                    <table width="100%" class="table border-top mb-5" id="datatable" role="grid"
                        aria-describedby="user-list-page-info">
                        <thead class=" text-center bg-light">
                            <tr>
                                <th>S.no</th>
                                <th>Agent</th>
                                <th>Agent Name</th>
                                <th>Txnid</th>
                                <th>Account No</th>
                                <th>Bank Name</th>
                                <th>Amount</th>
                                <th>Remitter</th>
                                <th>Date</th>
                                <th>Update Date</th>
                                <th>IFSC</th>
                                <th>UTR</th>
                                <th>Ref No</th>
                                <th>TXN-TYPE</th>
                                <th>Product</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="txnResultBody">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div id="userDetailsSection" class="mt-4" style="display:none;">
        <div class="p-3 rounded bg-white shadow-sm">
            <div class="mb-2 text-center fw-bold fs-6 rounded bg-primary text-white p-2">USER
                DETAILS</div>
            <div class="row g-2">
                <div class="col-md-4">
                    <table class="border table table-bordered rounded mb-0">
                        <tbody>
                            <tr>
                                <th class="text-start" style="width: 45%;">NAME</th>
                                <td class="text-start"><span id="ud_name"></span> </td>
                            </tr>
                            <tr>
                                <td class="text-start" style="width: 45%;">Agent Code</td>
                                <td class="text-start"> <span id="ud_username"></span> </td>
                            </tr>
                            <tr>
                                <td class="text-start" style="width: 45%;">FIRMNAME</td>
                                <td class="text-start"> <span id="ud_shopname"></span> </td>
                            </tr>
                            <tr>
                                <td class="text-start" style="width: 45%;">PHONE</td>
                                <td class="text-start"> <span id="ud_phone"></span> </td>
                            </tr>
                            <tr>
                                <td class="text-start" style="width: 45%;">EMAIL</td>
                                <td class="text-start"> <span id="ud_email"></span> </td>
                            </tr>
                            <tr>
                                <td class="text-start" style="width: 45%;">PAN NUMBER</td>
                                <td class="text-start"> <span id="ud_pan"></span> </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <div class="col-md-4">
                    <table class="table table-bordered rounded mb-0">
                        <tbody>
                            <tr>
                                <th class="text-start" style="width: 55%;">MAIN BALANCE</th>
                                <td class="text-start"><span id="ud_main_balance"></span></td>
                            </tr>
                            <tr>
                                <th class="text-start">COMMISSION BALANCE</th>
                                <td class="text-start"><span id="ud_comc_balance"></span></td>
                            </tr>
                            <tr>
                                <th class="text-start">REWARD BALANCE</th>
                                <td class="text-start"><span id="ud_reward_balance"></span></td>
                            </tr>
                            <tr>
                                <th class="text-start">CC Wallet</th>
                                <td class="text-start"><span id="ud_cc_balance"></span></td>
                            </tr>
                            <tr>
                                <th class="text-start">AEPS WALLET</th>
                                <td class="text-start"><span id="ud_aeps_wallet"></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Other Info Table -->
                <div class="col-md-4">
                    <table class="table table-bordered rounded mb-0">
                        <tbody>
                            <tr>
                                <th class="text-start">ADDED DATE</th>
                                <td class="text-start"><span id="ud_added_date"></span></td>
                            </tr>
                            <tr>
                                <th class="text-start">STATUS</th>
                                <td class="text-start"><span id="ud_status"></span></td>
                            </tr>
                            <tr>
                                <th class="text-start">Role</th>
                                <td class="text-start"><span id="ud_role"></span></td>
                            </tr>
                            <tr>
                                <th class="text-start">STATE</th>
                                <td class="text-start"><span id="ud_shop_state"></span></td>
                            </tr>
                            <tr>
                                <th class="text-start">DISTRICT</th>
                                <td class="text-start"><span id="ud_shop_district"></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-3 mb-2 text-center fw-bold fs-6 rounded bg-primary text-white p-2">AEPS
                PERMISSION:</div>
            <div class="d-flex flex-wrap gap-2 justify-content-center mb-2" id="ud_aeps_permissions">

            </div>
            <div class="mt-3 text-center fw-bold fs-6 rounded bg-primary text-white p-2">USER CURRENT PIPE
                WITHOUT BANK ROUTING</div>

            <div class="row g-2">
                <div class="col-md-12">
                    <table class="border table table-bordered rounded mb-0 mt-3">
                        <thead class="bg-light">
                            <tr>
                                <th>AEPS PIPE</th>
                                <th>AADHAAR PAY PIPE</th>
                                <th>MESSAGE</th>
                                <th>ROUTING TYPE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th><span id="ud_aeps_pipe"></span></th>
                                <td><span id="ud_aadhaar_pipe"></span> </td>
                                <td><span id="ud_message"></span></td>
                                <td><span id="ud_routing_type"></span> </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>

            <div class="mt-3 mb-2 text-center fw-bold fs-6 rounded bg-primary text-white p-2">TRANSACTION:</div>
            <div class="d-flex flex-wrap gap-2 justify-content-center mb-2">
                <span class="badge rounded-pill px-3 py-2 me-1 mb-1 bg-success">AEPS CLOSING:
                    <span id="ud_aeps_closing">0.00</span></span>
            </div>

            <div class="mb-2 text-center fw-bold fs-6 rounded bg-primary text-white p-2">PARENT BALANCE: </div>
            <div class="row g-2">
                <div class="col-md-3">
                    <table class="border table table-bordered rounded mb-0">
                        <tbody>
                            <tr>
                                <th class="text-start text-danger" style="width: 100%;" colspan="2">ADMIN</th>
                            </tr>
                            <tr>
                                <td class="text-start" style="width: 45%;">NAME</td>
                                <td class="text-start"> <span id="ad_name"></span> </td>
                            </tr>
                            <tr>
                                <td class="text-start" style="width: 45%;">FIRMNAME</td>
                                <td class="text-start"> <span id="ad_shopname"></span> </td>
                            </tr>
                            <tr>
                                <td class="text-start" style="width: 45%;">MOBILE</td>
                                <td class="text-start"> <span id="ad_mobile"></span> </td>
                            </tr>
                            <tr>
                                <td class="text-start" style="width: 45%;">BALANCE</td>
                                <td class="text-start"> <span id="ad_mainwallet"></span> </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <div class="col-md-3">
                    <table class="table table-bordered rounded mb-0">
                        <tbody>
                            <tr>
                                <th class="text-start text-danger" style="width: 100%;" colspan="2">RETAILER</th>
                            </tr>
                            <tr>
                                <td class="text-start" style="width: 45%;">NAME</td>
                                <td class="text-start"> <span id="rt_name"></span> </td>
                            </tr>
                            <tr>
                                <td class="text-start" style="width: 45%;">FIRMNAME</td>
                                <td class="text-start"> <span id="rt_shopname"></span> </td>
                            </tr>
                            <tr>
                                <td class="text-start" style="width: 45%;">MOBILE</td>
                                <td class="text-start"> <span id="rt_mobile"></span> </td>
                            </tr>
                            <tr>
                                <td class="text-start" style="width: 45%;">BALANCE</td>
                                <td class="text-start"> <span id="rt_mainwallet"></span> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Other Info Table -->
                <div class="col-md-3">
                    <table class="table table-bordered rounded mb-0">
                        <tbody>
                            <tr>
                                <th class="text-start text-danger" style="width: 100%;" colspan="2"> DISTRIBUTOR</th>
                            </tr>
                            <tr>
                                <td class="text-start" style="width: 45%;">NAME</td>
                                <td class="text-start"> <span id="dt_name"></span> </td>
                            </tr>
                            <tr>
                                <td class="text-start" style="width: 45%;">FIRMNAME</td>
                                <td class="text-start"> <span id="dt_shopname"></span> </td>
                            </tr>
                            <tr>
                                <td class="text-start" style="width: 45%;">MOBILE</td>
                                <td class="text-start"> <span id="dt_mobile"></span> </td>
                            </tr>
                            <tr>
                                <td class="text-start" style="width: 45%;">BALANCE</td>
                                <td class="text-start"> <span id="dt_mainwallet"></span> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-3">
                    <table class="table table-bordered rounded mb-0">
                        <tbody>
                            <tr>
                                <th class="text-start text-danger" style="width: 100%;" colspan="2">MASTER DISTRIBUTOR
                                </th>
                            </tr>
                            <tr>
                                <td class="text-start" style="width: 45%;">NAME</td>
                                <td class="text-start"> <span id="md_name"></span> </td>
                            </tr>
                            <tr>
                                <td class="text-start" style="width: 45%;">FIRMNAME</td>
                                <td class="text-start"> <span id="md_shopname"></span> </td>
                            </tr>
                            <tr>
                                <td class="text-start" style="width: 45%;">MOBILE</td>
                                <td class="text-start"> <span id="md_mobile"></span> </td>
                            </tr>
                            <tr>
                                <td class="text-start" style="width: 45%;">BALANCE</td>
                                <td class="text-start"> <span id="md_mainwallet"></span> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="mt-3 text-center fw-bold fs-6 rounded bg-primary text-white p-2">CAPPING:</div>

            <div class="row g-2">
                <div class="col-md-12">
                    <table class="border table table-bordered rounded mb-0 mt-3">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Capping Amount : ₹<span id="capping_amt"></span></th>
                                <th>Remarks : <span id="capping_remark"></span>
                                </th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>

            <div class="mt-3 text-center fw-bold fs-6 rounded bg-primary text-white p-2">LIEN AMOUNT:</div>

            <div class="row g-2">
                <div class="col-md-12">
                    <table class="border table table-bordered rounded mb-0 mt-3">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Amount</th>
                                <th>Fund Type</th>
                                <th>Services</th>
                                <th>Added By</th>
                                <th>Remarks</th>
                                <th>Date Added</th>
                            </tr>
                        </thead>
                        <tbody id="lien-amount">

                        </tbody>
                    </table>

                </div>
            </div>


            <div class="mt-3 text-center fw-bold fs-6 rounded bg-primary text-white p-2">Registered Device:</div>

            <div class="row g-2">
                <div class="col-md-12">
                    <table class="border table table-bordered rounded mb-0 mt-3">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Device Id</th>
                                <th>Status</th>
                                <th>Date Time</th>
                                <th>Change Status</th>
                            </tr>
                        </thead>
                        <tbody id="register-device">

                        </tbody>
                    </table>

                </div>
            </div>


            <div class="mt-3 text-center fw-bold fs-6 rounded bg-primary text-white p-2">USER KYC LAST AADHAAR:</div>

            <div class="row g-2">
                <div class="col-md-12">
                    <table class="border table table-bordered rounded mb-0 mt-3">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>TERMINAL ID</th>
                                <th>VERIFIED</th>
                            </tr>
                        </thead>
                        <tbody id="user-kyc-last">
                            <tr>
                                <td>2155</td>
                                <td>Re-kyc</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>

            <div class="mt-3 text-center fw-bold fs-6 rounded bg-primary text-white p-2">2FA Registration:</div>

            <div class="row g-2">
                <div class="col-md-12">
                    <table class="border table table-bordered rounded mb-0 mt-3">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Registration Date</th>
                                <th>Bank</th>
                                <th>Last 4 Aadhaar</th>
                            </tr>
                        </thead>
                        <tbody id="twofa-reg">
                            <tr>
                                <td>2025-09-10</td>
                                <td>Nsdl</td>
                                <td>xxxx xxxx 2323</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>


            <div class="mt-3 text-center fw-bold fs-6 rounded bg-primary text-white p-2">2FA Authentication:</div>

            <div class="row g-2">
                <div class="col-md-12">
                    <table class="border table table-bordered rounded mb-0 mt-3">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Authentication Date</th>
                                <th>Bank</th>
                                <th>Last 4 Aadhaar</th>
                                <th>Mode</th>
                                <th>Device Id</th>
                                <th>Lat-Long</th>
                            </tr>
                        </thead>
                        <tbody id="two-authentication">

                        </tbody>
                    </table>

                </div>
            </div>


            <div class="mt-3 text-center fw-bold fs-6 rounded bg-primary text-white p-2">Last Login Device:</div>

            <div class="row g-2">
                <div class="col-md-12">
                    <table class="border table table-bordered rounded mb-0 mt-3">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>IP Address</th>
                                <th>Date Time</th>
                                <th>Lat-Long</th>
                                <th>Device Id</th>
                            </tr>
                        </thead>
                        <tbody id="last-login-device">
                        </tbody>
                    </table>

                </div>
            </div>


            <div class="mt-3 text-center fw-bold fs-6 rounded bg-primary text-white p-2">Stored Location:</div>

            <div class="row g-2">
                <div class="col-md-12">
                    <table class="border table table-bordered rounded mb-0 mt-3">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Lat</th>
                                <th>Long</th>
                                <th>Device Type</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody id="store-location">
                        </tbody>
                    </table>

                </div>
            </div>

            <div class="mt-3 text-center fw-bold fs-6 rounded bg-primary text-white p-2">AEPS WARNINGS:</div>

            <div class="row g-2">
                <div class="col-md-12">
                    <table class="border table table-bordered rounded mb-0 mt-3">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Distance</th>
                                <th>Physical Verification</th>
                                <th>Risk Score Count</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody id="aeps-warninig">
                        </tbody>
                    </table>

                </div>
            </div>


            <div class="mt-3 text-center fw-bold fs-6 rounded bg-primary text-white p-2">Last 10 WARNINGS:</div>

            <div class="row g-2">
                <div class="col-md-12">
                    <table class="border table table-bordered rounded mb-0 mt-3">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Id</th>
                                <th>Message</th>
                                <th>Date Time</th>
                            </tr>
                        </thead>
                        <tbody id="last-ten-warninig">
                        </tbody>
                    </table>

                </div>
            </div>

            <div class="mt-3 text-center fw-bold fs-6 rounded bg-primary text-white p-2">Permission:</div>

            <div class="row g-2">
                <div class="col-md-12">
                    <table class="border table table-bordered rounded mb-0 mt-3">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Services</th>
                                <th>Status</th>
                                <th>Services</th>
                                <th>Status</th>
                                <th>Services</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="permission_user">
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>

    <!-- / Content -->

    <?php if(Myhelper::hasNotRole('admin')): ?>

        <?php if(Auth::user()->resetpwd == 'default'): ?>
            <div class="modal fade" id="pwdModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                            </button>
                        </div>
                        <form id="passwordForm" action="<?php echo e(route('profileUpdate')); ?>" method="post">
                            <div class="modal-body">
                                <input type="hidden" name="id" value="<?php echo e(Auth::id()); ?>">
                                <input type="hidden" name="actiontype" value="password">
                                <?php echo e(csrf_field()); ?>


                                <div class="row">
                                    <div class="form-group col-md-6  ">
                                        <label>Old Password</label>
                                        <input type="password" name="oldpassword" class="form-control" required=""
                                            placeholder="Enter Value">
                                    </div>
                                    <div class="form-group col-md-6  ">
                                        <label>New Password</label>
                                        <input type="password" name="password" id="password" class="form-control"
                                            required="" placeholder="Enter Value">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6  ">
                                        <label>Confirmed Password</label>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            required="" placeholder="Enter Value">
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" type="submit"
                                    data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Change
                                    Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="<?php echo e(asset('')); ?>assets/js/plugins/forms/selects/select2.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>

    <script>
        $(document).ready(function() {

            $("#generateUrlBtn").click(function() {

                $.ajax({
                    url: "traveller-generate-url",
                    method: "GET",

                    success: function(res) {
                        console.log(res);
                        if (res.status) {
                            
                            notify("URL generated successfully!", 'success');
                            window.open(res.url, '_blank');
                        } else {
                            notify("Failed to generate URL.", 'warning');
                        }
                    },

                    error: function(xhr) {
                        notify("An error occurred while generating the URL.", 'error');
                    }
                });

            });

            <?php if(Myhelper::hasNotRole('admin') && Auth::user()->resetpwd == 'default'): ?>
                $('#pwdModal').modal('show');
            <?php endif; ?>

            $("#passwordForm").validate({
                rules: {
                    <?php if(!Myhelper::can('member_password_reset')): ?>
                        oldpassword: {
                            required: true,
                            minlength: 6,
                        },
                        password_confirmation: {
                            required: true,
                            minlength: 8,
                            equalTo: "#password"
                        },
                    <?php endif; ?>
                    password: {
                        required: true,
                        minlength: 8
                    }
                },
                messages: {
                    <?php if(!Myhelper::can('member_password_reset')): ?>
                        oldpassword: {
                            required: "Please enter old password",
                            minlength: "Your password lenght should be atleast 6 character",
                        },
                        password_confirmation: {
                            required: "Please enter confirmed password",
                            minlength: "Your password lenght should be atleast 8 character",
                            equalTo: "New password and confirmed password should be equal"
                        },
                    <?php endif; ?>
                    password: {
                        required: "Please enter new password",
                        minlength: "Your password lenght should be atleast 8 character"
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase().toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('form#passwordForm');
                    form.find('span.text-danger').remove();
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                "disabled", true).addClass('btn-secondary');
                        },
                        success: function(data) {
                            form.find('button:submit').html('Change Password').attr(
                                "disabled", false).removeClass('btn-secondary');
                            if (data.status == "success") {
                                form[0].reset();
                                form.closest('.modal').modal('hide');
                                notify("Password Successfully Changed", 'success');
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            form.find('button:submit').html('Change Password').attr(
                                "disabled", false).removeClass('btn-secondary');
                            showError(errors, form.find('.modal-body'));
                        }
                    });
                }
            });
        });
    </script>

    <script>
        $('#searchByTxnidForm').on('submit', function(e) {
            e.preventDefault();
            var txnid = $(this).find('input[name="txnid"]').val();
            if (!txnid) return;

            $.ajax({
                url: "<?php echo e(route('searchTxnid')); ?>",
                type: "GET",
                data: {
                    txnid: txnid
                },
                success: function(resp) {
                    console.log(resp);

                    if (resp.status == 'success') {
                        $('#dashboardContent').hide();
                        $('#userDetailsSection').hide();
                        $('#txnResult').show();

                        var row = `<tr>
                        <td>${resp?.report?.id || 'N/A'}</td>
                        <td>${resp?.user.agentcode || 'N/A'}</td>
                        <td>${resp?.report?.agentname || 'N/A'}</td>
                        <td style="color:#e74c3c;">${resp?.report?.txnid || 'N/A'}</td>
                        <td>${resp?.report?.account_no || 'N/A'}</td>
                        <td>${resp?.report?.bank_name || 'N/A'}</td>
                        <td>${resp?.report?.amount || 'N/A'}</td>
                        <td>${resp?.report?.remitter || 'N/A'}</td>
                        <td>${resp?.report?.created_at || 'N/A'}</td>
                        <td>${resp?.report?.updated_at || 'N/A'}</td>
                        <td>${resp?.report?.ifsc || 'N/A'}</td>
                        <td>${resp?.report?.utr || 'N/A'}</td>
                        <td>${resp?.report?.refno || 'N/A'}</td>
                        <td>${resp?.report?.trans_type || 'N/A'}</td>
                        <td>${resp?.report?.product || 'N/A'}</td>
                        <td>${resp?.report?.status == "success" ? `<span class="badge bg-success">Success</span>` : resp?.report?.status == "pending" ? `<span class="badge bg-warning">Pending</span>` : `<span class="badge bg-danger">${resp?.report?.status}</span>` || 'N/A'}</td>
                    </tr>`;
                        $('#txnResultBody').html(row);
                    } else if (resp.status == 'error') {
                        notify(resp.message, 'warning');
                        $('#dashboardContent').show();
                        $('#userDetailsSection').hide();
                        $('#txnResult').hide();
                        return;

                    }

                }
            });
        });

        $('#searchByUsernameForm').on('submit', function(e) {
            e.preventDefault();
            $('#txnResult').hide();
            $('#dashboardContent').hide();
            var username = $(this).find('input[name="username"]').val();
            if (!username) return;
            $.ajax({
                url: "<?php echo e(route('searchUser')); ?>",
                type: "GET",
                data: {
                    username: username
                },
                success: function(resp) {
                    if (resp && resp.user && resp.status == 'success') {
                        // Fill user details
                        $('#ud_name').text(resp?.user?.name || '');
                        $('#ud_username').text(resp?.user?.agentcode || '');
                        $('#ud_shopname').text(resp?.user?.shopname || '');
                        $('#ud_phone').text(resp?.user?.mobile || '');
                        $('#ud_email').text(resp?.user?.email || '');
                        $('#ud_pan').text(resp?.user?.pancard || '');
                        $('#ud_main_balance').text(resp?.user?.mainwallet || '0.00');
                        $('#ud_comc_balance').text(resp?.user?.commission_wallet || '0.00');
                        $('#ud_reward_balance').text(resp?.user?.reward_wallet || '0.00');
                        $('#ud_cc_balance').text(resp?.user?.ccwallet || '0.00');
                        $('#ud_aeps_wallet').text(resp?.user?.aepsbalance || '0.00');

                        $('#ud_added_date').text(resp?.user?.created_at || '');
                        $('#ud_status').text(resp?.user?.status || '');
                        $('#ud_role').text(resp?.role.name || '');
                        $('#ud_shop_state').text(resp?.user?.state || '');
                        $('#ud_shop_district').text(resp?.user?.district || '');

                        // AEPS Permissions badges
                        let perms = resp.aeps_permissions || [];
                        let html = '';
                        perms.forEach(function(p) {
                            html +=
                                `<span class="badge rounded-pill px-3 py-2 me-1 mb-1" style="background:${p.color};color:#fff;">${p.label}</span>`;
                        });
                        $('#ud_aeps_permissions').html(html);

                        // AEPS PIPE BALNACE
                        $('#ud_aeps_pipe').text(resp?.pipe[0]?.aeps_pipe || 'CONSOLE APES1111');
                        $('#ud_aadhaar_pipe').text(resp?.pipe[1]?.aadhaar_pipe ||
                            'CONSOLE AADHAAR PAY1111');
                        $('#ud_message').text(resp?.pipe[2]?.aeps_message || 'SUCCESS1111');
                        $('#ud_routing_type').text(resp?.pipe[3]?.routing_type || 'SMART ROUTING1111');

                        // AEPS CLOSING BALANCE
                        $('#ud_aeps_closing').text(resp?.user?.aepsbalance || '0.00');

                        // Parent Role Data


                        let map = {
                            'admin': 'ad',
                            'retailer': 'rt',
                            'distributor': 'dt',
                            'masterdistributor': 'md'
                        };


                        let prefix = map[resp.role.slug];

                        Object.values(map).forEach(function(prefix) {
                            $('#' + prefix + '_name').text('N/A');
                            $('#' + prefix + '_shopname').text('N/A');
                            $('#' + prefix + '_mobile').text('N/A');
                            $('#' + prefix + '_mainwallet').text('0.00');
                        });


                        if (prefix) {
                            ['name', 'shopname', 'mobile', 'mainwallet'].forEach(function(key, i) {
                                $('#' + prefix + '_' + key).text(resp.parentRole[key] || 'N/A');
                            });
                        }


                        // Capping Data
                        $('#capping_amt').text(resp?.cappingAmount || '0.00');
                        if (resp?.cappingData) {
                            $('#capping_remark').html(
                                `${resp?.cappingData?.wallet_type} wallet of ₹${resp?.cappingData?.amount} updated by ${resp?.cappingData?.user?.name} to ${resp?.cappingData?.created_at}
                                    <br />Amount Updated, approved by ${resp?.cappingData?.approved_by} on ${resp?.cappingData?.updated_at}`
                            );
                        } else {
                            $('#capping_remark').text('N/A');
                        }

                        if (resp.permissions.length > 0) {
                            let phtml = '';
                            let permissions = resp.permissions;

                            permissions.forEach(function(p, index) {
                                if (index % 3 === 0) phtml += '<tr>';

                                phtml += `
                                    <td>${p.permission_name}</td>
                                    <td class="text-center">
                                        <span class="badge bg-success">Active</span>
                                        <span class="badge bg-info ms-1">${p.type}</span>
                                    </td>
                                `;

                                if ((index + 1) % 3 === 0) phtml += '</tr>';
                            });

                            if (permissions.length % 3 !== 0) phtml += '</tr>';

                            $('#permission_user').html(phtml);
                        } else {
                            $('#permission_user').html(
                                '<tr><td colspan="6" class="text-center text-danger">No permissions found</td></tr>'
                            );
                        }

                        $('#userDetailsSection').show();
                    } else {
                        $('#userDetailsSection').hide();
                        $('#dashboardContent').show();
                        notify(resp.message, 'warning');
                    }
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\login.bharatmitra.co\login.bharatmitra.co\resources\views/home.blade.php ENDPATH**/ ?>