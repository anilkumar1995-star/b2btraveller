<?php if(
    !Request::is('flight/*') &&
        !Request::is('bus/*') &&
        !Request::is('hotel/*') &&
        !Request::is('insights') &&
        !Request::is('condmt') &&
        !Request::is('upipay/*') &&
        !Request::is('rentpay') &&
        !Request::is('ipaydmt') &&
        !Request::is('ccpayout') &&
        !Request::is('dashboard') &&
        !Request::is('xdmt') &&
        !Request::is('payout/*') &&
        !Request::is('certificate') &&
        !Request::is('idcard') &&
        !Request::is('affiliate/*') &&
        !Request::is('billpayrecipt/*') &&
        !Request::is('aeps') &&
        !Request::is('profile/*') &&
        !Request::is('recharge/*') &&
        !Request::is('billpay/*') &&
        !Request::is('pancard/*') &&
        !Request::is('member/*/create') &&
        !Request::is('profile') &&
        !Request::is('profile/*') &&
        !Request::is('dmt') &&
        !Request::is('resources/companyprofile') &&
        !Request::is('aeps/*') &&
        !Request::is('developer/*') &&
        !Request::is('resources/commission') &&
        !Request::is('setup/portalsetting') &&
        !Request::is('pdmt') &&
        !Request::is('raeps/*')): ?>

    <div class="row">
        <form id="searchForm">
            <div class="col-lg-12 ">
                <div class="card h-100">
                    <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4">
                        <div class="card-title mb-0">
                            <h5 class="mb-0">
                                <h4><?php echo $__env->yieldContent('pagetitle'); ?></h4>
                            </h5>
                        </div>
                        <?php if(@$export != null): ?>
                            <div class="col-sm-12 col-md-3">
                                <div class="user-list-files d-flex float-right">
                                    <button type="button" class="btn btn-danger  mx-3 " id="formReset"
                                        data-loading-text="<b><i class='fa fa-spin fa-spinner'></i></b> Refreshing">Refresh</button>
                                    <button type="button"
                                        class="btn btn-success  text-white mx-3 <?php echo e(isset($export) ? '' : 'hide'); ?>"
                                        product="<?php echo e($export ?? ''); ?>" id="reportExport"> Export</button>

                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="card-body">
                        <div class=" rounded p-3 mt-5">
                            <div class="row gap-4 gap-sm-0">
                                <div class="col-12 col-sm-12">
                                    <div class="d-flex gap-2 align-items-center dataTables_filter"
                                        id="user_list_datatable_info">

                                        <?php if(isset($mystatus)): ?>
                                            <input type="hidden" name="status" value="<?php echo e($mystatus); ?>">
                                        <?php endif; ?>
                                        <div class="row">

                                            <div class="form-group col-md-2">
                                                <label for="exampleInputdate1">From Date</label>
                                                <input class="form-control mydate mt-1" name="from_date" type="text"
                                                    autocomplete="off" placeholder="From Date" />
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="exampleInputdate2">To Date</label>
                                                <input class="form-control  mt-1" name="to_date" type="text"
                                                    autocomplete="off" placeholder="To Date" />
                                            </div>

                                            <div class="form-group col-md-2 m-b-10">
                                                <label for="exampleInputdate3">Search Value</label>
                                                <input type="text" name="searchtext" class="form-control  mt-1"
                                                    placeholder="Search Value">
                                            </div>

                                            <?php if(Myhelper::hasNotRole(['retailer', 'apiuser'])): ?>
                                                <div
                                                    class="form-group col-md-2 m-b-10 <?php echo e(isset($agentfilter) ? $agentfilter : ''); ?>">
                                                    <label for=" exampleInputdate4">User Id</label>
                                                    <input type="text" name="agent" class="form-control  mt-1"
                                                        placeholder="Agent/Parent id">
                                                </div>
                                            <?php endif; ?>

                                            <?php if(isset($status)): ?>
                                                <div class="form-group col-md-2">
                                                    <label for="exampleInputdate5">Status</label>

                                                    <select name="status" class="form-select select mt-1"
                                                        aria-label="Status">
                                                        <option value="">Select status</option>
                                                        <?php if(isset($status['data']) && sizeOf($status['data']) > 0): ?>
                                                            <?php $__currentLoopData = $status['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($key); ?>"><?php echo e($value); ?>

                                                                </option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            <?php endif; ?>

                                            <?php if(isset($product)): ?>
                                                <div class="form-group col-md-2">
                                                    <label for="exampleInputdate7">Product</label>
                                                    <select name="product" class="form-select select  mt-1">
                                                        <option value="">Select <?php echo e($product['type'] ?? ''); ?>

                                                        </option>
                                                        <?php if(isset($product['data']) && sizeOf($product['data']) > 0): ?>
                                                            <?php $__currentLoopData = $product['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($key); ?>"><?php echo e($value); ?>

                                                                </option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            <?php endif; ?>

                                            <div class="col-md-2">
                                                <div class="user-list-files d-flex search-button  mt-4">
                                                    <button type="submit" class="btn btn-primary"
                                                        data-loading-text="<b><i class='fa fa-spin fa-spinner'></i></b> Searching">
                                                        Search</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </form>

    </div>



    <div id="helpModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-slate">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    <h6 class="modal-title">Help Desk</h6>
                </div>
                <div class="modal-body no-padding">
                    <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <tbody>
                            <tr>
                                <th>Support Number</th>
                                <td><?php echo e($mydata['supportnumber']); ?></td>
                            </tr>
                            <tr>
                                <th>Support Email</th>
                                <td><?php echo e($mydata['supportemail']); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style>
    .select2-container--default {
        width: 100% !important;
    }

    .select2-container--default .select2-selection--single {
        border: 1px solid #dbdade !important;
        height: 38px !important;
        border-radius: 0.375rem !important;
        line-height: 1.5 !important;
        border-radius: 0.375rem !important;
        font-size: 0.9375rem !important;
        padding: 0.422rem 0.375rem !important;
        width: 100% !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #807c8c !important;
        line-height: 25px !important;
    }

    .select2-container--default .select2-results>.select2-results__options {
        cursor: pointer !important;
    }
</style>
<?php /**PATH C:\wamp64\www\flight_b2b_travel\flight_b2b_travel\resources\views/layouts/pageheader.blade.php ENDPATH**/ ?>