<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('pagetitle', 'Dashboard'); ?>
<?php $__env->startSection('content'); ?>
<!-- Content -->


<div id="loading">
    <div id="loading-center">
    </div>
</div>



<div class="row">
    <div class="col-lg-12">
        <div class="row mb-2">
            <div class="col-lg-8"></div>
            <div class="col-lg-4">
                <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <i class="fa fa-caret-down"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Wallet Balance -->
    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <div class="card">
            <div class="card-body pb-0">
                <div class="card-icon">
                    <span class="badge bg-label-success rounded-pill p-2">
                        <i class="ti ti-wallet ti-sm"></i>
                    </span>
                </div>
                <h5 class="card-title mb-0 mt-2"><?php echo e(Auth::user()->mainwallet); ?></h5>
                <small>Main Wallet Balance</small>
            </div>
            <div id="revenueGenerated1"></div>
        </div>
    </div>
    <!--/ Main Wallet Balance -->


    <!-- AEPS Balance -->
    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <div class="card">
            <div class="card-body pb-0">
                <div class="card-icon">
                    <span class="badge bg-label-primary rounded-pill p-2">
                        <i class="ti ti-brand-paypal ti-sm"></i>
                    </span>
                </div>
                <h5 class="card-title mb-0 mt-2"><?php echo e(Auth::user()->aepsbalance); ?></h5>
                <small>AEPS Balance</small>
            </div>
            <div id="revenueGenerated2"></div>
        </div>
    </div>
    <!--/ AEPS Balance -->

    <!-- AEPS Reports -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4">
                <div class="card-title mb-0">
                    <h5 class="mb-0">AEPS</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="border rounded p-3 mt-5">
                    <div class="row gap-4 gap-sm-0">
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-success p-1">
                                    <i class="ti ti-clock-check ti-sm"></i>
                                </div>
                                <h6 class="mb-0">Success</h6>
                            </div>
                            <h6 class="my-2 pt-1"><span id="aeps_successCount" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="0">0</span> |
                                <span id="aeps_success" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="₹0.00"> ₹0.00</span>
                            </h6>
                            <div class="progress w-75" style="height: 4px">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-warning p-1">
                                    <i class="ti ti-clock-exclamation ti-sm"></i>
                                </div>
                                <h6 class="mb-0">Pending</h6>
                            </div>
                            <h6 class="my-2 pt-1"><span id="aeps_pendingCount" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="0">0</span> | <span id="aeps_pending" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="₹0.00">₹0.00</span></h6>
                            <div class="progress w-75" style="height: 4px">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-danger p-1">
                                    <i class="ti ti-clock-x ti-sm"></i>
                                    <!-- <i class="ti ti-brand-paypal ti-sm"></i> -->
                                </div>
                                <h6 class="mb-0">Failed</h6>
                            </div>
                            <h6 class="my-2 pt-1"><span id="aeps_failedCount" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="0">0</span> | <span id="aeps_failed" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="₹0.00">₹0.00</span></h6>
                            <div class="progress w-75" style="height: 4px">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ AEPS Reports -->

    <!-- MATM Reports -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4">
                <div class="card-title mb-0">
                    <h5 class="mb-0">MATM</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="border rounded p-3 mt-5">
                    <div class="row gap-4 gap-sm-0">
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-success p-1">
                                    <i class="ti ti-clock-check ti-sm"></i>
                                </div>
                                <h6 class="mb-0">Success</h6>
                            </div>
                            <h6 class="my-2 pt-1"><span id="matm_successCount" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="0">0</span> |
                                <span id="matm_success" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="₹0.00">₹0.00</span>
                            </h6>
                            <div class="progress w-75" style="height: 4px">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-warning p-1">
                                    <i class="ti ti-clock-exclamation ti-sm"></i>
                                </div>
                                <h6 class="mb-0">Pending</h6>
                            </div>
                            <h6 class="my-2 pt-1"><span id="matm_pendingCount" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="0">0</span> |
                                <span id="matm_pending" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="₹0.00">₹0.00</span>
                            </h6>
                            <div class="progress w-75" style="height: 4px">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-danger p-1">
                                    <i class="ti ti-clock-x ti-sm"></i>
                                </div>
                                <h6 class="mb-0">Failed</h6>
                            </div>
                            <h6 class="my-2 pt-1"><span id="matm_failedCount" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="0">0</span> |
                                <span id="matm_failed" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="₹0.00">₹0.00</span>
                            </h6>
                            <div class="progress w-75" style="height: 4px">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ MATM Reports -->

    <!-- DMT Reports -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4">
                <div class="card-title mb-0">
                    <h5 class="mb-0">Payout</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="border rounded p-3 mt-5">
                    <div class="row gap-4 gap-sm-0">
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-success p-1">
                                    <i class="ti ti-clock-check ti-sm"></i>
                                </div>
                                <h6 class="mb-0">Success</h6>
                            </div>
                            <h6 class="my-2 pt-1"><span id="money_successCount" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="0">0</span> |
                                <span id="money_success" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="₹0.00">₹0.00</span>
                            </h6>
                            <div class="progress w-75" style="height: 4px">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-warning p-1">
                                    <i class="ti ti-clock-exclamation ti-sm"></i>
                                </div>
                                <h6 class="mb-0">Pending</h6>
                            </div>
                            <h6 class="my-2 pt-1"><span id="money_pendingCount" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="0">0</span> |
                                <span id="money_pending" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="₹0.00">₹0.00</span>
                            </h6>
                            <div class="progress w-75" style="height: 4px">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-danger p-1">
                                    <i class="ti ti-clock-x ti-sm"></i>
                                </div>
                                <h6 class="mb-0">Failed</h6>
                            </div>
                            <h6 class="my-2 pt-1"><span id="money_failedCount" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="0">0</span> |
                                <span id="money_failed" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="₹0.00">₹0.00</span>
                            </h6>
                            <div class="progress w-75" style="height: 4px">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ DMT Reports -->

    <!-- Recharge Reports -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4">
                <div class="card-title mb-0">
                    <h5 class="mb-0">Recharge</h5>
                </div>

                <!-- </div> -->
            </div>
            <div class="card-body">
                <div class="border rounded p-3 mt-5">
                    <div class="row gap-4 gap-sm-0">
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-success p-1">
                                    <i class="ti ti-clock-check ti-sm"></i>
                                </div>
                                <h6 class="mb-0">Success</h6>
                            </div>
                            <h6 class="my-2 pt-1"><span id="recharge_successCount" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="0">0</span> |
                                <span id="recharge_success" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="₹0.00">₹0.00</span>
                            </h6>
                            <div class="progress w-75" style="height: 4px">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-warning p-1">
                                    <i class="ti ti-clock-exclamation ti-sm"></i>
                                </div>
                                <h6 class="mb-0">Pending</h6>
                            </div>
                            <h6 class="my-2 pt-1"><span id="recharge_pendingCount" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="0">0</span> |
                                <span id="recharge_pending" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="₹0.00">₹ 0</span>
                            </h6>
                            <div class="progress w-75" style="height: 4px">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-danger p-1">
                                    <i class="ti ti-clock-x ti-sm"></i>
                                    <!-- <i class="ti ti-brand-paypal ti-sm"></i> -->
                                </div>
                                <h6 class="mb-0">Failed</h6>
                            </div>
                            <h6 class="my-2 pt-1"><span id="recharge_failedCount" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="0">0</span> |
                                <span id="recharge_failed" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="₹0.00">₹0.00</span>
                            </h6>
                            <div class="progress w-75" style="height: 4px">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Recharge Reports -->

    <!-- Bill Payment Reports -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4">
                <div class="card-title mb-0">
                    <h5 class="mb-0">Bill Payment</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="border rounded p-3 mt-5">
                    <div class="row gap-4 gap-sm-0">
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-success p-1">
                                    <i class="ti ti-clock-check ti-sm"></i>
                                </div>
                                <h6 class="mb-0">Success</h6>
                            </div>
                            <h6 class="my-2 pt-1"><span id="billpayment_successCount" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="0">0</span> |
                                <span id="billpayment_success" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="₹0.00">₹0.00</span>
                            </h6>
                            <div class="progress w-75" style="height: 4px">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-warning p-1">
                                    <i class="ti ti-clock-exclamation ti-sm"></i>
                                </div>
                                <h6 class="mb-0">Pending</h6>
                            </div>
                            <h6 class="my-2 pt-1"><span id="billpayment_pendingCount" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="0">0</span> |
                                <span id="billpayment_pending" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="₹0.00">₹0.00</span>
                            </h6>
                            <div class="progress w-75" style="height: 4px">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-danger p-1">
                                    <i class="ti ti-clock-x ti-sm"></i>
                                    <!-- <i class="ti ti-brand-paypal ti-sm"></i> -->
                                </div>
                                <h6 class="mb-0">Failed</h6>
                            </div>
                            <h6 class="my-2 pt-1"><span id="billpayment_failedCount" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="0">0</span> |
                                <span id="billpayment_failed" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="₹0.00">₹0.00</span>
                            </h6>
                            <div class="progress w-75" style="height: 4px">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
      <!-- Xpayout Reports -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4">
                <div class="card-title mb-0">
                    <h5 class="mb-0">X-Payout</h5>
                </div>

                <!-- </div> -->
            </div>
            <div class="card-body">
                <div class="border rounded p-3 mt-5">
                    <div class="row gap-4 gap-sm-0">
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-success p-1">
                                    <i class="ti ti-clock-check ti-sm"></i>
                                </div>
                                <h6 class="mb-0">Success</h6>
                            </div>
                            <h6 class="my-2 pt-1"><span id="xpayout_successCount" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="0">0</span> |
                                <span id="xpayout_success" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="₹0.00">₹0.00</span>
                            </h6>
                            <div class="progress w-75" style="height: 4px">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-warning p-1">
                                    <i class="ti ti-clock-exclamation ti-sm"></i>
                                </div>
                                <h6 class="mb-0">Pending</h6>
                            </div>
                            <h6 class="my-2 pt-1"><span id="xpayout_pendingCount" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="0">0</span> |
                                <span id="xpayout_pending" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="₹0.00">₹ 0</span>
                            </h6>
                            <div class="progress w-75" style="height: 4px">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-danger p-1">
                                    <i class="ti ti-clock-x ti-sm"></i>
                                    <!-- <i class="ti ti-brand-paypal ti-sm"></i> -->
                                </div>
                                <h6 class="mb-0">Failed</h6>
                            </div>
                            <h6 class="my-2 pt-1"><span id="xpayout_failedCount" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="0">0</span> |
                                <span id="xpayout_failed" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="₹0.00">₹0.00</span>
                            </h6>
                            <div class="progress w-75" style="height: 4px">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Recharge Reports -->

    <!-- Bill Payment Reports -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4">
                <div class="card-title mb-0">
                    <h5 class="mb-0">CC Payment</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="border rounded p-3 mt-5">
                    <div class="row gap-4 gap-sm-0">
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-success p-1">
                                    <i class="ti ti-clock-check ti-sm"></i>
                                </div>
                                <h6 class="mb-0">Success</h6>
                            </div>
                            <h6 class="my-2 pt-1"><span id="ccbillpayment_successCount" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="0">0</span> |
                                <span id="ccbillpayment_success" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="₹0.00">₹0.00</span>
                            </h6>
                            <div class="progress w-75" style="height: 4px">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-warning p-1">
                                    <i class="ti ti-clock-exclamation ti-sm"></i>
                                </div>
                                <h6 class="mb-0">Pending</h6>
                            </div>
                            <h6 class="my-2 pt-1"><span id="ccbillpayment_pendingCount" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="0">0</span> |
                                <span id="ccbillpayment_pending" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="₹0.00">₹0.00</span>
                            </h6>
                            <div class="progress w-75" style="height: 4px">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-danger p-1">
                                    <i class="ti ti-clock-x ti-sm"></i>
                                    <!-- <i class="ti ti-brand-paypal ti-sm"></i> -->
                                </div>
                                <h6 class="mb-0">Failed</h6>
                            </div>
                            <h6 class="my-2 pt-1"><span id="ccbillpayment_failedCount" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="0">0</span> |
                                <span id="ccbillpayment_failed" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="₹0.00">₹0.00</span>
                            </h6>
                            <div class="progress w-75" style="height: 4px">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!--/ Bill Payment Reports -->
    <?php if(in_array(Auth::user()->role->slug, ['admin'])): ?>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between">
                <div class="card-title m-0 me-2">
                    <h5 class="m-0 me-2">Balances</h5>
                </div>

            </div>
            <div class="card-body">
                <ul class="p-0 m-0">
                    <?php if(in_array(Auth::user()->role->slug, ['admin'])): ?>
                    <li class="d-flex mb-4 pb-1 align-items-center">
                        <div class="badge rounded bg-label-success me-2 p-1">
                            <i class="ti ti-currency-rupee ti-sm "></i>
                        </div>
                        <div class="d-flex w-100 align-items-center gap-2">
                            <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                                <div>
                                    <h6 class="mb-0">Downline Balance</h6>
                                </div>

                                <div class="user-progress d-flex align-items-center gap-2">
                                    <h6 class="mb-0 downlinebalance">0</h6>
                                </div>
                            </div>
                            <div class="chart-progress" data-color="secondary" data-series="85"></div>
                        </div>
                    </li>
                    <?php endif; ?>

                    
    
    </ul>
</div>
</div>
</div>
<?php endif; ?>

<?php if(in_array(Auth::user()->role->slug, ['whitelable', 'md', 'distributor', 'admin'])): ?>
<div class="col-xl-4 col-md-6 mb-4">
    <div class="card h-100">
        <div class="card-header d-flex justify-content-between">
            <div class="card-title m-0 me-2">
                <h5 class="m-0 me-2">User Counts</h5>
            </div>

        </div>
        <div class="card-body">
            <ul class="p-0 m-0">
                <?php if(in_array(Auth::user()->role->slug, ['admin'])): ?>
                <li class="d-flex mb-4 pb-1 align-items-center">
                    <div class="badge rounded bg-label-success me-2 p-1">
                        <i class="ti ti-refresh ti-sm "></i>
                    </div>
                    <div class="d-flex w-100 align-items-center gap-2">
                        <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                            <div>
                                <h6 class="mb-0">White Label</h6>
                            </div>

                            <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="mb-0"><?php echo e($whitelable); ?></h6>
                            </div>
                        </div>
                        <div class="chart-progress" data-color="secondary" data-series="85"></div>
                    </div>
                </li>
                <?php endif; ?>
                <?php if(in_array(Auth::user()->role->slug, ['admin', 'whitelable'])): ?>
                <li class="d-flex mb-4 pb-1 align-items-center">
                    <div class="badge rounded bg-label-danger me-2 p-1">
                        <i class="ti ti-user ti-sm "></i>
                    </div>
                    <div class="d-flex w-100 align-items-center gap-2">
                        <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                            <div>
                                <h6 class="mb-0">Master Distributor</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="mb-0"><?php echo e($md); ?></h6>
                            </div>
                        </div>
                        <div class="chart-progress" data-color="success" data-series="70"></div>
                    </div>
                </li>
                <?php endif; ?>
                <?php if(in_array(Auth::user()->role->slug, ['admin', 'whitelable', 'md'])): ?>
                <li class="d-flex mb-4 pb-1 align-items-center">
                    <div class="badge rounded bg-label-warning me-2 p-1">
                        <i class="ti ti-id ti-sm "></i>
                    </div>
                    <div class="d-flex w-100 align-items-center gap-2">
                        <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                            <div>
                                <h6 class="mb-0">Distributor</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="mb-0"><?php echo e($distributor); ?></h6>
                            </div>
                        </div>
                        <div class="chart-progress" data-color="primary" data-series="25"></div>
                    </div>
                </li>
                <?php endif; ?>

                <?php if(in_array(Auth::user()->role->slug, ['admin', 'whitelable', 'md', 'distributor'])): ?>
                <li class="d-flex mb-4 pb-1 align-items-center">
                    <div class="badge rounded bg-label-primary me-2 p-1">
                        <i class="ti ti-brand-paypal ti-sm "></i>
                    </div>
                    <div class="d-flex w-100 align-items-center gap-2">
                        <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                            <div>
                                <h6 class="mb-0">Retailer</h6>
                            </div>

                            <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="mb-0"><?php echo e($retailer); ?></h6>
                            </div>
                        </div>
                        <div class="chart-progress" data-color="danger" data-series="75"></div>
                    </div>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="col-xl-4 col-md-6 mb-4">
    <div class="card h-100">

        <div class="card-body text-center">
            <div>
                <img src="<?php echo e(asset('')); ?>logos/helpdesk.jpg"  class="img-responsive mb-10" style="margin: auto; width: 200px">
            </div>

            <a href="#">

                <img src="https://static.vecteezy.com/system/resources/previews/001/991/656/original/customer-service-flat-design-concept-illustration-icon-support-call-center-help-desk-hotline-operator-abstract-metaphor-can-use-for-landing-page-mobile-app-free-vector.jpg" class="img-responsive mb-10" style="margin: auto; width: 150px">
            </a>
            <div class="mt-1  mb-3">
                <b>Timing - 10 AM to 7 PM</b>
            </div>

            <div class="form-group mb-3">
                <span class="text-semibold">
                    <h6><i class="fa fa-phone"></i> <?php echo e($mydata['supportnumber']); ?></h6>
                    <small></small>
                </span>
            </div>

            <div class="form-group mb-3">
                <span class="text-semibold">
                    <h6><i class="fa fa-envelope"></i> <?php echo e($mydata['supportemail']); ?></h6>
                    <small></small>
                </span>
            </div>
        </div>
    </div>
</div>
</div>

<!-- / Content -->

<?php if(Myhelper::hasNotRole('admin')): ?>
<?php if(Auth::user()->kyc != 'pending' && Auth::user()->kyc != 'rejected' && Auth::user()->kyc != 'active'): ?>

<div class="modal fade" id="kycModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Complete your profile with kyc</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>

            <?php if(Auth::user()->kyc == 'rejected'): ?>
            <div class="alert text-white bg-danger" role="alert">
                <div class="iq-alert-text">Kyc Rejected! —<?php echo e(Auth::user()->remark); ?></div>
                <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                    <i class="ri-close-line"></i>
                </button>
            </div>
            <?php endif; ?>

            <form id="kycForm" action="<?php echo e(route('kycUpdate')); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?php echo e(Auth::id()); ?>">
                    <input type="hidden" name="actiontype" value="kycdata">
                    <input type="hidden" name="kyc" value="submitted">
                    <?php echo e(csrf_field()); ?>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Address</label>
                            <textarea name="address" class="form-control" rows="2" required="" placeholder="Enter Value"><?php echo e(Auth::user()->address); ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>State</label>
                            <select name="state" class="form-control select" required="">
                                <option value="">Select State</option>
                                <?php $__currentLoopData = $state; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($state->state); ?>" <?php echo e(Auth::user()->state == $state->state ? 'selected=""' : ''); ?>>
                                    <?php echo e($state->state); ?>

                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>City</label>
                            <input type="text" name="city" class="form-control" required="" placeholder="Enter Value" value="<?php echo e(Auth::user()->city); ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Pincode</label>
                            <input type="number" name="pincode" value="<?php echo e(Auth::user()->pincode); ?>" class="form-control" value="" required="" maxlength="6" minlength="6" placeholder="Enter Value">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Shop Name</label>
                            <input type="text" name="shopname" value="<?php echo e(Auth::user()->shopname); ?>" class="form-control" value="" required="" placeholder="Enter Value">
                        </div>

                        <div class="form-group col-md-4">
                            <label>Pancard Number</label>
                            <input type="text" name="pancard" value="<?php echo e(Auth::user()->pancard); ?>" class="form-control" value="" required="" placeholder="Enter Value">
                        </div>

                        <div class="form-group col-md-4">
                            <label>Adhaarcard Number</label>
                            <input type="text" name="aadharcard" value="<?php echo e(Auth::user()->aadharcard); ?>" class="form-control" value="" required="" placeholder="Enter Value" maxlength="12" minlength="12">
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Complete
                        Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if(Auth::user()->resetpwd == 'default'): ?>
<div class="modal fade" id="pwdModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <input type="password" name="oldpassword" class="form-control" required="" placeholder="Enter Value">
                        </div>
                        <div class="form-group col-md-6  ">
                            <label>New Password</label>
                            <input type="password" name="password" id="password" class="form-control" required="" placeholder="Enter Value">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6  ">
                            <label>Confirmed Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required="" placeholder="Enter Value">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Change
                        Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>
<?php endif; ?>

<div class="modal fade bd-example-modal-xl" id="noticeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Necessary Notice ( आवश्यक सूचना )</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>
            <div class="modal-body">
                <?php echo nl2br($mydata['notice']); ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="<?php echo e(asset('')); ?>assets/js/plugins/forms/selects/select2.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>

<script>
    $(window).on('load', function() {
        $('#noticeModal').modal('show');
    });

    $(document).ready(function() {

        <?php if(Myhelper::hasNotRole('admin')): ?>
        <?php if(Auth::user() -> kyc == 'pending' || Auth::user() -> kyc == 'rejected'): ?>
        $('#kycModal').modal('show');
        <?php endif; ?>
        <?php endif; ?>

        <?php if(Myhelper::hasNotRole('admin') && Auth::user() -> resetpwd == 'default'): ?>
        $('#pwdModal').modal('show');
        <?php endif; ?>

        // <?php if($mydata['notice'] != null || $mydata['notice'] != ''): ?>
        // $('#noticeModal').modal('show');
        // <?php endif; ?>


        $("#searchbydate").validate({
            rules: {
                fromdate: {
                    required: true,
                },
                todate: {
                    required: true,
                }
            },
            messages: {
                fromdate: {
                    required: "Please select fromdate",
                },
                todate: {
                    required: "Please select fromdate",
                },
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
                var form = $('form#searchbydate');
                form.find('span.text-danger').remove();
                form.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {
                        form.find('button:submit').html('Please wait...').attr("disabled", true).addClass('btn-secondary');;
                    },
                    success: function(data) {
                        form.find('button:submit').html('Search').attr("disabled", false).removeClass('btn-secondary');;
                        $.each(data, function(index, value) {
                            $('.' + index).text(value);
                        });
                    },
                    error: function(errors) {
                        form.find('button:submit').html('Search').attr("disabled", false).removeClass('btn-secondary');;
                        showError(errors, form.find('.modal-body'));
                    }
                });
            }
        });

        $("#kycForm").validate({
            rules: {
                state: {
                    required: true,
                },
                city: {
                    required: true,
                },
                pincode: {
                    required: true,
                    minlength: 6,
                    number: true,
                    maxlength: 6
                },
                address: {
                    required: true,
                },
                aadharcard: {
                    required: true,
                    minlength: 12,
                    number: true,
                    maxlength: 12
                },
                pancard: {
                    required: true,
                },
                shopname: {
                    required: true,
                },
                pancardpics: {
                    required: true,
                },
                aadharcardpics: {
                    required: true,
                }
            },
            messages: {
                state: {
                    required: "Please select state",
                },
                city: {
                    required: "Please enter city",
                },
                pincode: {
                    required: "Please enter pincode",
                    number: "Mobile number should be numeric",
                    minlength: "Your mobile number must be 6 digit",
                    maxlength: "Your mobile number must be 6 digit"
                },
                address: {
                    required: "Please enter address",
                },
                aadharcard: {
                    required: "Please enter aadharcard",
                    number: "Mobile number should be numeric",
                    minlength: "Your mobile number must be 12 digit",
                    maxlength: "Your mobile number must be 12 digit"
                },
                pancard: {
                    required: "Please enter pancard",
                },
                shopname: {
                    required: "Please enter shop name",
                },
                pancardpics: {
                    required: "Please upload pancard pic",
                },
                aadharcardpics: {
                    required: "Please upload aadharcard pic",
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
                var form = $("#kycForm");
                form.find('span.text-danger').remove();
                form.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {
                        form.find('button:submit').html('Please wait...').attr("disabled", true).addClass('btn-secondary');
                    },
                    success: function(data) {
                        form.find('button:submit').html('Complete Profile').attr("disabled", true).removeClass('btn-secondary');
                        if (data.status == "success") {
                            form[0].reset();
                            $('select').val('');
                            $('select').trigger('change');
                            notify("Profile Successfully Updated, wait for kyc approval",
                                'success');
                        } else {
                            notify(data.status, 'warning');
                        }
                    },
                    error: function(errors) {
                        form.find('button:submit').html('Complete Profile').attr("disabled", true).removeClass('btn-secondary');
                        showError(errors, form);
                    }
                });
            }
        });

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
                        form.find('button:submit').html('Please wait...').attr("disabled", true).addClass('btn-secondary');
                    },
                    success: function(data) {
                        form.find('button:submit').html('Change Password').attr("disabled", false).removeClass('btn-secondary');
                        if (data.status == "success") {
                            form[0].reset();
                            form.closest('.modal').modal('hide');
                            notify("Password Successfully Changed", 'success');
                        } else {
                            notify(data.status, 'warning');
                        }
                    },
                    error: function(errors) {
                        form.find('button:submit').html('Change Password').attr("disabled", false).removeClass('btn-secondary');
                        showError(errors, form.find('.modal-body'));
                    }
                });
            }
        });
    });

    const getDashboardData = (start, end) => {

        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

        $.ajax({
            url: "<?php echo e(route('home')); ?>",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {

                fromDate: start?.format('YYYY-MM-DD') || '',
                toDate: end.format('YYYY-MM-DD') || '',
            },
            beforeSend: function() {
                // swal({
                //     title: 'Wait!',
                //     text: 'We are processing your request.',
                //     allowOutsideClick: () => !swal.isLoading(),
                //     onOpen: () => {
                //         swal.showLoading()
                //     }
                // });
            },
            complete: function() {
                swal.close();
            },
            success: function(resp) {

                $(`#aeps_success`).html(`₹${resp.aeps.success  >= 100000 ? (resp.aeps.success / 100000).toFixed(2) + ' Lac' 
                                            : resp.aeps.success >= 1000 ? (resp.aeps.success / 1000).toFixed(2) + 'k' 
                                            : resp.aeps.success.toFixed(2)}`).attr('data-bs-original-title', `₹${resp.aeps.success.toFixed(2)}}`);
                $(`#aeps_successCount`).html(`${resp.aeps.successCount}`).attr('data-bs-original-title', `${resp.aeps.successCount}`);
                $(`#aeps_pending`).html(`₹${resp.aeps.pending  >= 100000 ? (resp.aeps.pending / 100000).toFixed(2) + ' Lac' 
                                            : resp.aeps.pending >= 1000 ? (resp.aeps.pending / 1000).toFixed(2) + 'k' 
                                            : resp.aeps.pending.toFixed(2)}`).attr('data-bs-original-title', `₹${resp.aeps.pending.toFixed(2)}`);
                $(`#aeps_pendingCount`).html(`${resp.aeps.pendingCount}`).attr('data-bs-original-title', `${resp.aeps.pendingCount}`);
                $(`#aeps_failed`).html(`₹${resp.aeps.failed  >= 100000 ? (resp.aeps.failed / 100000).toFixed(2) + ' Lac' 
                                            : resp.aeps.failed >= 1000 ? (resp.aeps.failed / 1000).toFixed(2) + 'k' 
                                            : resp.aeps.failed.toFixed(2)}`).attr('data-bs-original-title', `₹${resp.aeps.failed.toFixed(2)}`);
                $(`#aeps_failedCount`).html(`${resp.aeps.failedCount}`).attr('data-bs-original-title', `${resp.aeps.failedCount}`);

                $(`#bbps_success`).html(`₹${resp.billpayment.success  >= 100000 ? (resp.billpayment.success / 100000).toFixed(2) + ' Lac' 
                                            : resp.billpayment.success >= 1000 ? (resp.billpayment.success / 1000).toFixed(2) + 'k' 
                                            : resp.billpayment.success.toFixed(2)}`).attr('data-bs-original-title', `₹${resp.billpayment.success.toFixed(2)}`);
                $(`#bbps_successCount`).html(`${resp.billpayment.successCount}`).attr('data-bs-original-title', `${resp.billpayment.successCount}`);
                $(`#bbps_pending`).html(`₹${resp.billpayment.pending  >= 100000 ? (resp.billpayment.pending / 100000).toFixed(2) + ' Lac' 
                                            : resp.billpayment.pending >= 1000 ? (resp.billpayment.pending / 1000).toFixed(2) + 'k' 
                                            : resp.billpayment.pending.toFixed(2)}`).attr('data-bs-original-title', `₹${resp.billpayment.pending.toFixed(2)}`);
                $(`#bbps_pendingCount`).html(`${resp.billpayment.pendingCount}`).attr('data-bs-original-title', `${resp.billpayment.pendingCount}`);
                $(`#bbps_failed`).html(`₹${resp.billpayment.failed  >= 100000 ? (resp.billpayment.failed / 100000).toFixed(2) + ' Lac' 
                                            : resp.billpayment.failed >= 1000 ? (resp.billpayment.failed / 1000).toFixed(2) + 'k' 
                                            : resp.billpayment.failed.toFixed(2)}`).attr('data-bs-original-title', `₹${resp.billpayment.failed.toFixed(2)}`);
                $(`#bbps_failedCount`).html(`${resp.billpayment.failedCount}`).attr('data-bs-original-title', `${resp.billpayment.failedCount}`);

                $(`#money_success`).html(`₹${resp.money.success  >= 100000 ? (resp.money.success / 100000).toFixed(2) + ' Lac' 
                                            : resp.money.success >= 1000 ? (resp.money.success / 1000).toFixed(2) + 'k' 
                                            : resp.money.success.toFixed(2)}`).attr('data-bs-original-title', `₹${resp.money.success.toFixed(2)}`);
                $(`#money_successCount`).html(`${resp.money.successCount}`).attr('data-bs-original-title', `${resp.money.successCount}`);
                $(`#money_pending`).html(`₹${resp.money.pending  >= 100000 ? (resp.money.pending / 100000).toFixed(2) + ' Lac' 
                                            : resp.money.pending >= 1000 ? (resp.money.pending / 1000).toFixed(2) + 'k' 
                                            : resp.money.pending.toFixed(2)}`).attr('data-bs-original-title', `₹${resp.money.pending.toFixed(2)}`);
                $(`#money_pendingCount`).html(`${resp.money.pendingCount}`).attr('data-bs-original-title', `${resp.money.pendingCount}`);
                $(`#money_failed`).html(`₹${resp.money.failed  >= 100000 ? (resp.money.failed / 100000).toFixed(2) + ' Lac' 
                                            : resp.money.failed >= 1000 ? (resp.money.failed / 1000).toFixed(2) + 'k' 
                                            : resp.money.failed.toFixed(2)}`).attr('data-bs-original-title', `₹${resp.money.failed.toFixed(2)}`);
                $(`#money_failedCount`).html(`${resp.money.failedCount}`).attr('data-bs-original-title', `${resp.money.failedCount}`);

                $(`#matm_success`).html(`₹${resp.matm.success  >= 100000 ? (resp.matm.success / 100000).toFixed(2) + ' Lac' 
                                            : resp.matm.success >= 1000 ? (resp.matm.success / 1000).toFixed(2) + 'k' 
                                            : resp.matm.success.toFixed(2)}`).attr('data-bs-original-title', `₹${resp.matm.success.toFixed(2)}`);
                $(`#matm_successCount`).html(`${resp.matm.successCount}`).attr('data-bs-original-title', `${resp.matm.successCount}`);
                $(`#matm_pending`).html(`₹${resp.matm.pending  >= 100000 ? (resp.matm.pending / 100000).toFixed(2) + ' Lac' 
                                            : resp.matm.pending >= 1000 ? (resp.matm.pending / 1000).toFixed(2) + 'k' 
                                            : resp.matm.pending.toFixed(2)}`).attr('data-bs-original-title', `₹${resp.matm.pending.toFixed(2)}`);
                $(`#matm_pendingCount`).html(`${resp.matm.pendingCount}`).attr('data-bs-original-title', `${resp.matm.pendingCount}`);
                $(`#matm_failed`).html(`₹${resp.matm.failed  >= 100000 ? (resp.matm.failed / 100000).toFixed(2) + ' Lac' 
                                            : resp.matm.failed >= 1000 ? (resp.matm.failed / 1000).toFixed(2) + 'k' 
                                            : resp.matm.failed.toFixed(2)}`).attr('data-bs-original-title', `₹${resp.matm.failed.toFixed(2)}`);
                $(`#matm_failedCount`).html(`${resp.matm.failedCount}`).attr('data-bs-original-title', `${resp.matm.failedCount}`);

                $(`#recharge_success`).html(`₹${resp.recharge.success  >= 100000 ? (resp.recharge.success / 100000).toFixed(2) + ' Lac' 
                                            : resp.recharge.success >= 1000 ? (resp.recharge.success / 1000).toFixed(2) + 'k' 
                                            : resp.recharge.success.toFixed(2)}`).attr('data-bs-original-title', `₹${resp.recharge.success.toFixed(2)}`);
                $(`#recharge_successCount`).html(`${resp.recharge.successCount}`).attr('data-bs-original-title', `${resp.recharge.successCount}`);
                $(`#recharge_pending`).html(`₹${resp.recharge.pending  >= 100000 ? (resp.recharge.pending / 100000).toFixed(2) + ' Lac' 
                                            : resp.recharge.pending >= 1000 ? (resp.recharge.pending / 1000).toFixed(2) + 'k' 
                                            : resp.recharge.pending.toFixed(2)}`).attr('data-bs-original-title', `₹${resp.recharge.pending.toFixed(2)}`);
                $(`#recharge_pendingCount`).html(`${resp.recharge.pendingCount}`).attr('data-bs-original-title', `${resp.recharge.pendingCount}`);
                $(`#recharge_failed`).html(`₹${resp.recharge.failed  >= 100000 ? (resp.recharge.failed / 100000).toFixed(2) + ' Lac' 
                                            : resp.recharge.failed >= 1000 ? (resp.recharge.failed / 1000).toFixed(2) + 'k' 
                                            : resp.recharge.failed.toFixed(2)}`).attr('data-bs-original-title', `₹${resp.recharge.failed.toFixed(2)}`);
                $(`#recharge_failedCount`).html(`${resp.recharge.failedCount}`).attr('data-bs-original-title', `${resp.recharge.failedCount}`);

                $(`#billpayment_success`).html(`₹${resp.billpayment.success  >= 100000 ? (resp.billpayment.success / 100000).toFixed(2) + ' Lac' 
                                            : resp.billpayment.success >= 1000 ? (resp.billpayment.success / 1000).toFixed(2) + 'k' 
                                            : resp.billpayment.success.toFixed(2)}`).attr('data-bs-original-title', `₹${resp.billpayment.success.toFixed(2)}`);
                $(`#billpayment_successCount`).html(`${resp.billpayment.successCount}`).attr('data-bs-original-title', `${resp.billpayment.successCount}`);
                $(`#billpayment_pending`).html(`₹${resp.billpayment.pending  >= 100000 ? (resp.billpayment.pending / 100000).toFixed(2) + ' Lac' 
                                            : resp.billpayment.pending >= 1000 ? (resp.billpayment.pending / 1000).toFixed(2) + 'k' 
                                            : resp.billpayment.pending.toFixed(2)}`).attr('data-bs-original-title', `₹${resp.billpayment.pending.toFixed(2)}`);
                $(`#billpayment_pendingCount`).html(`${resp.billpayment.pendingCount}`).attr('data-bs-original-title', `${resp.billpayment.pendingCount}`);
                $(`#billpayment_failed`).html(`₹${resp.billpayment.failed  >= 100000 ? (resp.billpayment.failed / 100000).toFixed(2) + ' Lac' 
                                            : resp.billpayment.failed >= 1000 ? (resp.billpayment.failed / 1000).toFixed(2) + 'k' 
                                            : resp.billpayment.failed.toFixed(2)}`).attr('data-bs-original-title', `₹${resp.billpayment.failed.toFixed(2)}`);
                $(`#billpayment_failedCount`).html(`${resp.billpayment.failedCount}`).attr('data-bs-original-title', `${resp.billpayment.failedCount}`);
                
                $(`#ccbillpayment_success`).html(`₹${resp.ccbillpayment.success  >= 100000 ? (resp.ccbillpayment.success / 100000).toFixed(2) + ' Lac' 
                                            : resp.ccbillpayment.success >= 1000 ? (resp.ccbillpayment.success / 1000).toFixed(2) + 'k' 
                                            : resp.billpayment.pending.toFixed(2)}`).attr('data-bs-original-title', `₹${resp.billpayment.pending.toFixed(2)}`);
                $(`#ccbillpayment_successCount`).html(`${resp.ccbillpayment.successCount}`).attr('data-bs-original-title', `${resp.ccbillpayment.successCount}`);
                $(`#ccbillpayment_pending`).html(`₹${resp.ccbillpayment.pending  >= 100000 ? (resp.ccbillpayment.pending / 100000).toFixed(2) + ' Lac' 
                                            : resp.ccbillpayment.pending >= 1000 ? (resp.ccbillpayment.pending / 1000).toFixed(2) + 'k' 
                                            : resp.ccbillpayment.pending.toFixed(2)}`).attr('data-bs-original-title', `₹${resp.ccbillpayment.pending.toFixed(2)}`);
                $(`#ccbillpayment_pendingCount`).html(`${resp.ccbillpayment.pendingCount}`).attr('data-bs-original-title', `${resp.ccbillpayment.pendingCount}`);
                $(`#ccbillpayment_failed`).html(`₹${resp.ccbillpayment.failed  >= 100000 ? (resp.ccbillpayment.failed / 100000).toFixed(2) + ' Lac' 
                                            : resp.ccbillpayment.failed >= 1000 ? (resp.ccbillpayment.failed / 1000).toFixed(2) + 'k' 
                                            : resp.ccbillpayment.failed.toFixed(2)}`).attr('data-bs-original-title', `₹${resp.ccbillpayment.failed.toFixed(2)}`);
                $(`#ccbillpayment_failedCount`).html(`${resp.ccbillpayment.failedCount}`).attr('data-bs-original-title', `${resp.ccbillpayment.failedCount}`);
                
                $(`#xpayout_success`).html(`₹${resp.xpayout.success  >= 100000 ? (resp.xpayout.success / 100000).toFixed(2) + ' Lac' 
                                            : resp.xpayout.success >= 1000 ? (resp.xpayout.success / 1000).toFixed(2) + 'k' 
                                            : resp.xpayout.success.toFixed(2)}`).attr('data-bs-original-title', `₹${resp.xpayout.success.toFixed(2)}`);
                $(`#xpayout_successCount`).html(`${resp.xpayout.successCount}`).attr('data-bs-original-title', `${resp.xpayout.successCount}`);
                $(`#xpayout_pending`).html(`₹${resp.xpayout.pending  >= 100000 ? (resp.xpayout.pending / 100000).toFixed(2) + ' Lac' 
                                            : resp.xpayout.pending >= 1000 ? (resp.xpayout.pending / 1000).toFixed(2) + 'k' 
                                            : resp.xpayout.pending.toFixed(2)}`).attr('data-bs-original-title', `₹${resp.xpayout.pending.toFixed(2)}`);
                $(`#xpayout_pendingCount`).html(`${resp.xpayout.pendingCount}`).attr('data-bs-original-title', `${resp.xpayout.pendingCount}`);
                $(`#xpayout_failed`).html(`₹${resp.xpayout.failed  >= 100000 ? (resp.xpayout.failed / 100000).toFixed(2) + ' Lac' 
                                            : resp.xpayout.failed >= 1000 ? (resp.xpayout.failed / 1000).toFixed(2) + 'k' 
                                            : resp.xpayout.failed.toFixed(2)}`).attr('data-bs-original-title', `₹${resp.xpayout.failed.toFixed(2)}`);
                $(`#xpayout_failedCount`).html(`${resp.xpayout.failedCount}`).attr('data-bs-original-title', `${resp.xpayout.failedCount}`);
              
            }
        });

    }

    $(function() {

        var start = moment();
        var end = moment();

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, getDashboardData);

        getDashboardData(start, end);

    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.quick2pay.in/resources/views/home.blade.php ENDPATH**/ ?>