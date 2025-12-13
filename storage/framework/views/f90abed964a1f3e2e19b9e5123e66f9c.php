<?php $__env->startSection('title', 'Commission Settlement Details'); ?>
<?php $__env->startSection('pagetitle', 'Commission Settlement Details'); ?>

<?php
$table = 'yes';
// $export = 'aepsfundrequest';
$status['type'] = 'Fund';
$status['data'] = [
'success' => 'Success',
'pending' => 'Pending',
'failed' => 'Failed',
'approved' => 'Approved',
'rejected' => 'Rejected',
];
?>

<?php $__env->startSection('content'); ?>
<div class="row my-4">
    <div class="col-12 col-xl-12 col-sm-12 order-1 order-lg-2 mb-4 mb-lg-0">
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4">
                <div class="card-title mb-0">
                <h5 class="mb-0">
                        <span><?php echo $__env->yieldContent('pagetitle'); ?></span>
                    </h5>
                </div>
                <?php if( Myhelper::can(['commission_settlement_service'])): ?>
                <div class="col-sm-12 col-md-2 mb-5">
                    <div class="user-list-files d-flex float-right">
                    <a href="" class="btn btn-success text-white btn-sm" data-bs-toggle="offcanvas" data-bs-target="#fundRequestModalsRunpaisa">
                            <i class="ti ti-plus ti-xs"></i> New Request</a>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <div class="card-datatable table-responsive">
                <table width="100%" class="table border-top mb-5" id="datatable" role="grid" aria-describedby="user-list-page-info">
                    <thead class=" text-center bg-light">
                             <tr>
                                <th>#</th>
                                <th>User Details</th>
                                <th>Settlement Details</th>
                                <th>Txn Details</th>
                                <th>Description</th>
                                <th>Remark</th>
                                <th>Status</th>
                            </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>




<div class="offcanvas offcanvas-end " id="fundRequestModalsRunpaisa" tabindex="-1" role="modal" aria-labelledby="exampleModalLabels" aria-hidden="true" data-bs-backdrop="static">

    <div class="offcanvas-header bg-primary">
        <h4 class="text-white" id="exampleModalLabel">Commission Settlement</h4>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
        </button>
    </div>

    <form id="fundRequestFormsRunpaisa" action="<?php echo e(route('fundtransaction')); ?>" method="post">
        <div class="offcanvas-body">
            <input type="hidden" name="user_id">
            <?php echo e(csrf_field()); ?>

            <?php if(Auth::user()->userbanks['accountNo'] == '' || Auth::user()->userbanks['accountNo'] == null): ?>
            <div class="row">
                <div class="form-group col-md-12 my-1 my-1">
                    <label>Remarks <span class="text-danger fw-bold">*</span></label>
                    <input type="text" class="form-control my-1" name="remarks" placeholder="Enter Value" required="" value="<?php echo e(print 'Please add Bank Account for commission settlement'); ?>" readonly>
                </div>
            </div>
            <?php else: ?>
            <div class="row">
                <div class="form-group col-md-6 my-1 my-1">
                    <label>Account Number <span class="text-danger fw-bold">*</span></label>
                    <input type="text" class="form-control my-1" name="account" placeholder="Enter Value" required="" value="<?php echo e(Auth::user()->userbanks['accountNo']); ?>" readonly>
                </div>
                <div class="form-group col-md-6 my-1 my-1">
                    <label>IFSC Code <span class="text-danger fw-bold">*</span></label>
                    <input type="text" class="form-control my-1" name="ifsc" placeholder="Enter Value" required="" value="<?php echo e(Auth::user()->userbanks['ifscCode']); ?>" readonly>
                </div>
                <div class="form-group col-md-6 my-1 my-1">
                    <label>Bank Name <span class="text-danger fw-bold">*</span></label>
                    <input type="text" class="form-control my-1" name="bank" placeholder="Enter Value" required="" value="<?php echo e(Auth::user()->userbanks['bankName']); ?>" readonly>
                </div>
                <div class="form-group col-md-6 my-1 my-1">
                    <label>Wallet Type <span class="text-danger fw-bold">*</span></label>
                    <select name="type" class="form-control my-1" required>
                        <option value="">Select Wallet</option>
                        <option value="bank">Move To Bank</option>
                        <option value="wallet">Move To Wallet</option>
                    </select>
                </div>
                <div class="form-group col-md-6 my-1 my-1">
                    <label>Amount <span class="text-danger fw-bold">*</span></label>
                    <input type="number" class="form-control my-1" name="amount" placeholder="Enter Value" required="">
                </div>
                <div class="form-group col-md-6 my-1 my-1">
                    <label>Remarks <span class="text-danger fw-bold">*</span></label>
                    <input type="text" class="form-control my-1" name="remarks" placeholder="Enter Value" required="">
                </div>
                <div class="form-group col-md-12 my-1 my-1">
                    <label>T- PIN <span class="text-danger fw-bold">*</span></label>
                    <input type="password" name="pin" class="form-control my-1" placeholder="Enter transaction pin" required="">
                    <a href="<?php echo e(url('profile/view?tab=pinChange')); ?>" target="_blank" class="text-primary pull-right">Generate or Forgot PIN?</a>
                </div>
            </div>
            <p class="text-danger">Note - If you want to change bank details, please send mail with account details to
                update your bank details.</p>

           
            <?php endif; ?>
        </div>
        <div class="modal-footer">
                <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
            </div>
    </form>
</div>


<div class="offcanvas offcanvas-end" id="fundRequestModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="offcanvas-header bg-primary">
        <h5 class="text-white" id="exampleModalLabel">Aeps Fund Request</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
        </button>
    </div>
    <form id="fundRequestForms" action="<?php echo e(route('fundtransaction')); ?>" method="post">
        <div class="offcanvas-body">
            <?php if(Auth::user()->bank != '' && Auth::user()->ifsc != '' && Auth::user()->account != ''): ?>
            <table class="table table-bordered p-b-15" cellspacing="0" style="margin-bottom: 30px">
                <thead class="thead-light">
                    <tr>
                        <th>Select bank</th>
                        <th>Account</th>
                        <th>Name</th>
                        <th>Bank</th>
                        <th>Ifsc</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $payoutusers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payoutuser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><input type="radio" id="banktype" name="beniid" value="<?php echo e($payoutuser->bene_id); ?>"></td>
                        <td><?php echo e($payoutuser->account); ?></td>
                        <td><?php echo e($payoutuser->account); ?></td>
                        <td><?php echo e($payoutuser->bankname); ?></td>
                        <td><?php echo e($payoutuser->ifsc); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php endif; ?>

            <input type="hidden" name="user_id">
            <?php echo e(csrf_field()); ?>

            <div class="row">
                <?php if(Auth::user()->bank == '' && Auth::user()->ifsc == '' && Auth::user()->account == ''): ?>
                <div class="form-group col-md-6 my-1">
                    <label>Account Number</label>
                    <input type="text" class="form-control my-1" name="account" placeholder="Enter Value" required="" value="<?php echo e(Auth::user()->account); ?>">
                </div>
                <div class="form-group col-md-6 my-1">
                    <label>IFSC Code</label>
                    <input type="text" class="form-control my-1" name="ifsc" placeholder="Enter Value" required="" value="<?php echo e(Auth::user()->ifsc); ?>">
                </div>
                <div class="form-group col-md-6 my-1">
                    <label>Bank Name</label>
                    <input type="text" class="form-control my-1" name="bank" placeholder="Enter Value" required="" value="<?php echo e(Auth::user()->bank); ?>">
                </div>
                <?php endif; ?>

                <div class="form-group col-md-6 my-1">
                    <label>Wallet Type</label>
                    <select name="type" class="form-control my-1" required>
                        <option value="">Select Wallet</option>
                        <option value="bank">Move To Bank</option>
                        <option value="wallet">Move To Wallet</option>
                    </select>
                </div>
                <div class="form-group col-md-6 my-1">
                    <label>Amount</label>
                    <input type="number" class="form-control my-1" name="amount" placeholder="Enter Value" required="">
                </div>
                <div class="form-group col-md-6 my-1">
                    <label>T- PIN</label>
                    <input type="password" name="pin" class="form-control my-1" placeholder="Enter transaction pin" required="">
                    <a href="<?php echo e(url('profile/view?tab=pinChange')); ?>" target="_blank" class="text-primary pull-right">Generate or Forgot PIN?</a>
                </div>
            </div>
            <p class="text-danger">Note - If you want to change bank details, please send mail with account
                details to update your bank details.</p>

            <div class="modal-footer">
                <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
            </div>
    </form>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        var url = "<?php echo e(url('statement/fetch')); ?>/commissionsettlement/0";
        var onDraw = function() {};
        var options = [{
                "data": "name",
                render: function(data, type, full, meta) {
                    var out = '';
                    if (full.api) {
                        out += `<span class='myspan'>` + full.api.api_name + `</span><br>`;
                    }
                    out += `<span class='text-inverse'>` + full.id +
                        `</span><br><span style='font-size:12px'>` + full.created_at + `</span>`;
                    return out;
                }
            },
            {
                "data": "username"
            },
            {
                "data": "bank",
                render: function(data, type, full, meta) {
                    if (full.option1 == "wallet") {
                        return "Fund Settle in WALLET <br>" + "Settlement Mode: " + full.option2.toUpperCase();
                    } else {
                        return "Fund Settle in BANK <br>" + "Settlement Mode: " + full.option2.toUpperCase() + "<br> A/C No.: "+ full.number + "<br> IFSC: " + full.option4;
                    }
                }
            },
            {
                "data": "bank",
                render: function(data, type, full, meta) {
                    // if (full.option1 == "wallet") {
                    //     return "Wallet"
                    // } else {
                        return "Txn Id: "+ full.txnid + "<br>Pay Id: " + full.payid;
                    // }
                }
            },
            {
                "data": "description",
                render: function(data, type, full, meta) {
                    return "Amount: ₹ " + full.amount + "<br>Charges: " + full.charge;
                }
            },
            {
                "data": "remark"
            },
            {
                "data": "action",
                render: function(data, type, full, meta) {
                    if (full.status == "success") {
                        var btn = '<span class="badge badge-success bg-success text-uppercase"><b>' + "Approved" +
                            '</b></span>';
                    } else if (full.status == 'pending' || full.status == 'initiated') {
                        var btn = '<span class="badge badge-warning bg-warning text-uppercase"><b>' + full.status +
                            '</b></span>';
                    } else if (full.status == 'failed' || full.status == 'refunded'){
                        var btn = '<span class="badge badge-danger bg-danger text-uppercase"><b>' + full.status +
                            '</b></span>';
                    } else{
                        var btn = '<span class="badge badge-info bg-info text-uppercase"><b>' + full.status +
                            '</b></span>';
                    }
                    return btn;
                }
            }

        ];


        datatableSetup(url, options, onDraw);

        $("#fundRequestForm").validate({
            rules: {
                amount: {
                    required: true
                },
                type: {
                    required: true
                },
            },
            messages: {
                amount: {
                    required: "Please enter request amount",
                },
                type: {
                    required: "Please select request type",
                }
            },
            errorElement: "p",
            errorPlacement: function(error, element) {
                if (element.prop("tagName").toLowerCase() === "select") {
                    error.insertAfter(element.closest(".form-group").find(".select2"));
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function() {
                var form = $('#fundRequestForm');
                form.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {
                        form.find('button:submit').html('Please wait...').attr('disabled',
                            true).addClass('btn-secondary');
                    },
                    complete: function() {
                        form.find('button:submit').html('Submit').attr('disabled',
                            false).removeClass('btn-secondary');
                    },
                    success: function(data) {
                        if (data.status == "success") {
                            form[0].reset();
                            form.closest('.modal').modal('hide');
                            notify("Fund Request submitted Successfull", 'success');
                            $('#datatable').dataTable().api().ajax.reload();
                        } else {
                            notify(data.status, 'warning');
                        }
                    },
                    error: function(errors) {
                        notify(errors.responseJSON.status || 'Something went wrong',
                            'error');
                        form.find('button:submit').html('Submit').attr('disabled',
                            false).removeClass('btn-secondary');
                        // showError(errors, form);
                    }
                });
            }
        });

        $("#fundRequestForms").validate({
            rules: {
                amount: {
                    required: true
                },
                type: {
                    required: true
                },
            },
            messages: {
                amount: {
                    required: "Please enter request amount",
                },
                type: {
                    required: "Please select request type",
                }
            },
            errorElement: "p",
            errorPlacement: function(error, element) {
                if (element.prop("tagName").toLowerCase() === "select") {
                    error.insertAfter(element.closest(".form-group").find(".select2"));
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function() {
                var form = $('#fundRequestForms');
                form.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {
                        form.find('button:submit').html('Please wait...').attr('disabled',
                            true).addClass('btn-secondary');
                    },
                    complete: function() {
                        form.find('button:submit').html('Submit').attr('disabled',
                            false).removeClass('btn-secondary');
                    },
                    success: function(data) {
                        if (data.status == "success") {
                            form.closest('.offcanvas').offcanvas('hide');
                            notify("Fund Request submitted Successfull", 'success');
                            $('#datatable').dataTable().api().ajax.reload();
                        } else {
                            notify(data.status, 'warning');
                        }
                    },
                    error: function(errors) {
                        notify(errors.responseJSON.status || 'Something went wrong',
                            'error');
                        form.find('button:submit').html('Submit').attr('disabled',
                            false).removeClass('btn-secondary');
                        // showError(errors, form);
                    }
                });
            }
        });
        $("#fundRequestFormsRunpaisa").validate({
            rules: {
                amount: {
                    required: true
                },
                type: {
                    required: true
                },
            },
            messages: {
                amount: {
                    required: "Please enter request amount",
                },
                type: {
                    required: "Please select request type",
                }
            },
            errorElement: "p",
            errorPlacement: function(error, element) {
                if (element.prop("tagName").toLowerCase() === "select") {
                    error.insertAfter(element.closest(".form-group").find(".select2"));
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function() {
                var form = $('#fundRequestFormsRunpaisa');
                form.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {
                        form.find('button:submit').html('Please wait...').attr('disabled',
                            true).addClass('btn-secondary');
                    },
                    complete: function() {
                        form.find('button:submit').html('Submit').attr('disabled',
                            false).removeClass('btn-secondary');
                    },
                    success: function(data) {
                        if (data.statuscode == "TXN") {
                            form.closest('.offcanvas').offcanvas('hide');
                            notify("Fund Request submitted Successfull", 'success');
                            $('#datatable').dataTable().api().ajax.reload();
                        } else {
                            notify(data.status, 'warning');
                        }
                    },
                    error: function(errors) {
                        form.find('button:submit').html('Submit').attr('disabled',
                            false).removeClass('btn-secondary');
                        notify(errors.responseJSON.status ||
                            'Something went wrong, Please try again later..!',
                            'error');
                        // showError(errors, form);
                    }
                });
            }
        });

    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.ismartpay.in/resources/views/fund/aeps.blade.php ENDPATH**/ ?>