<?php $__env->startSection('title', 'Portal Settings'); ?>
<?php $__env->startSection('pagetitle', 'Portal Settings'); ?>

<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-4 col-xl-4 col-sm-4 order-1 order-lg-2 my-3 mb-lg-0">
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4 ">
                <div class="card-title mb-3">
                    <h5 class="mb-0">
                        <span>Wallet Settlement Type</span>
                    </h5>
                </div>
            </div>
            <form class="actionForm" action="<?php echo e(route('setupupdate')); ?>" method="post">
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="actiontype" value="portalsetting">
                <input type="hidden" name="code" value="settlementtype">
                <input type="hidden" name="name" value="Wallet Settlement Type">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label>Settlement Type</label>
                            <select name="value" class="form-control my-1" required>
                                <option value="">Select Type</option>
                                <option value="auto" <?php echo e((isset($settlementtype->value) && $settlementtype->value == "auto") ? "selected=''" : ''); ?>>Auto</option>
                                <option value="manual" <?php echo e((isset($settlementtype->value) && $settlementtype->value == "manual") ? "selected=''" : ''); ?>>Manual</option>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Updating">Update Info</button>
                </div>
            </form>
        </div>

    </div>
    <div class="col-4 col-xl-4 col-sm-4 order-1 order-lg-2 my-3 mb-lg-0">
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4 ">
                <div class="card-title mb-3">
                    <h5 class="mb-0">
                        <span>Bank Settlement Type</span>
                    </h5>
                </div>
            </div>
            <form class="actionForm" action="<?php echo e(route('setupupdate')); ?>" method="post">
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="actiontype" value="portalsetting">
                <input type="hidden" name="code" value="banksettlementtype">
                <input type="hidden" name="name" value="Wallet Settlement Type">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label>Settlement Type</label>
                            <select name="value" class="form-control my-1" required>
                                <option value="">Select Type</option>
                                <option value="auto" <?php echo e((isset($banksettlementtype->value) && $banksettlementtype->value == "auto") ? "selected=''" : ''); ?>>Auto</option>
                                <option value="manual" <?php echo e((isset($banksettlementtype->value) && $banksettlementtype->value == "manual") ? "selected=''" : ''); ?>>Manual</option>
                                <option value="down" <?php echo e((isset($banksettlementtype->value) && $banksettlementtype->value == "down") ? "selected=''" : ''); ?>>Down</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Updating">Update Info</button>

                </div>
            </form>

        </div>

    </div>
    
     <div class="col-4 col-xl-4 col-sm-4 order-1 order-lg-2 my-3 mb-lg-0">
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4 ">
                <div class="card-title mb-3">
                    <h5 class="mb-0">
                        <span>CC Settlement Type</span>
                    </h5>
                </div>
            </div>
            <form class="actionForm" action="<?php echo e(route('setupupdate')); ?>" method="post">
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="actiontype" value="portalsetting">
                <input type="hidden" name="code" value="ccsettlementtype">
                <input type="hidden" name="name" value="Wallet Settlement Type">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label>Settlement Type</label>
                            <select name="value" class="form-control my-1" required>
                                <option value="">Select Type</option>
                                <option value="auto" <?php echo e((isset($ccsettlementtype->value) && $ccsettlementtype->value == "auto") ? "selected=''" : ''); ?>>Auto</option>
                                <option value="manual" <?php echo e((isset($ccsettlementtype->value) && $ccsettlementtype->value == "manual") ? "selected=''" : ''); ?>>Manual</option>
                                <option value="down" <?php echo e((isset($ccsettlementtype->value) && $ccsettlementtype->value == "down") ? "selected=''" : ''); ?>>Down</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Updating">Update Info</button>

                </div>
            </form>

        </div>

    </div>
    <div class="col-4 col-xl-4 col-sm-4 order-1 order-lg-2 my-3 mb-lg-0">
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4 ">
                <div class="card-title mb-3">
                    <h5 class="mb-0">
                        <span>Bank Settlement Charge
                        </span>
                    </h5>
                </div>
            </div>
            <form class="actionForm" action="<?php echo e(route('setupupdate')); ?>" method="post">
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="actiontype" value="portalsetting">
                <input type="hidden" name="code" value="settlementcharge">
                <input type="hidden" name="name" value="Wallet Settlement Type">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label>Charge</label>
                            <input type="number" name="value" value="<?php echo e($settlementcharge->value ?? ''); ?>" class="form-control my-1" required="" placeholder="Enter value">

                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Updating">Update Info</button>

                </div>
            </form>
        </div>

    </div>
    <div class="col-4 col-xl-4 col-sm-4 order-1 order-lg-2 my-3 mb-lg-0">
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4 ">
                <div class="card-title mb-3">
                    <h5 class="mb-0">
                        <span>Bank Settlement Charge Upto 25000
                        </span>
                    </h5>
                </div>
            </div>
            <form class="actionForm" action="<?php echo e(route('setupupdate')); ?>" method="post">
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="actiontype" value="portalsetting">
                <input type="hidden" name="code" value="impschargeupto25">
                <input type="hidden" name="name" value="Bank Settlement Charge Upto 25000">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 ">
                            <label>Charge</label>
                            <input class="form-control my-1" name="value" value="<?php echo e($impschargeupto25->value ?? ''); ?>" placeholder="Charge" />
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Updating">Update Info</button>

                </div>
            </form>
        </div>
    </div>

    <div class="col-4 col-xl-4 col-sm-4 order-1 order-lg-2 my-3 mb-lg-0">
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4 ">
                <div class="card-title mb-3">
                    <h5 class="mb-0">
                        <span>login with OTP
                        </span>
                    </h5>
                </div>
            </div>
            <form class="actionForm" action="<?php echo e(route('setupupdate')); ?>" method="post">
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="actiontype" value="portalsetting">
                <input type="hidden" name="code" value="otplogin">
                <input type="hidden" name="name" value="Login required otp">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label>Login Type</label>
                            <select name="value" class="form-control my-1" required>
                                <option value="">Select Type</option>
                                <option value="yes" <?php echo e((isset($otplogin->value) && $otplogin->value == "yes") ? "selected=''" : ''); ?>>With Otp</option>
                                <option value="no" <?php echo e((isset($otplogin->value) && $otplogin->value == "no") ? "selected=''" : ''); ?>>Without Otp</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Updating">Update Info</button>

                </div>
            </form>
        </div>

    </div>

    <div class="col-4 col-xl-4 col-sm-4 order-1 order-lg-2 my-3 mb-lg-0">
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4 ">
                <div class="card-title mb-3">
                    <h5 class="mb-0">
                        <span>Sending mail id for otp
                        </span>
                    </h5>
                </div>
            </div>
            <form class="actionForm" action="<?php echo e(route('setupupdate')); ?>" method="post">
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="actiontype" value="portalsetting">
                <input type="hidden" name="code" value="otpsendmailid">
                <input type="hidden" name="name" value="Sending mail id for otp">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label>Mail Id</label>
                            <input type="text" name="value" value="<?php echo e($otpsendmailid->value ?? ''); ?>" class="form-control my-1" required="" placeholder="Enter value">

                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Updating">Update Info</button>

                </div>
            </form>
        </div>
    </div>

    <div class="col-4 col-xl-4 col-sm-4 order-1 order-lg-2 my-3 mb-lg-0">
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4 ">
                <div class="card-title mb-3">
                    <h5 class="mb-0">
                        <span>Sending mailer name id for otp
                        </span>
                    </h5>
                </div>
            </div>
            <form class="actionForm" action="<?php echo e(route('setupupdate')); ?>" method="post">
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="actiontype" value="portalsetting">
                <input type="hidden" name="code" value="otpsendmailname">
                <input type="hidden" name="name" value="Sending mailer name id for otp">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label>Mailer Name</label>
                            <input type="text" name="value" value="<?php echo e($otpsendmailname->value ?? ''); ?>" class="form-control my-1" required="" placeholder="Enter value">

                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Updating">Update Info</button>

                </div>
            </form>
        </div>
    </div>

    <!-- <div class="col-4 col-xl-4 col-sm-4 order-1 order-lg-2 my-3 mb-lg-0">
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4 ">
                <div class="card-title mb-3">
                    <h5 class="mb-0">
                        <span>Bc Id for DMT
                        </span>
                    </h5>
                </div>
            </div>
            <form class="actionForm" action="<?php echo e(route('setupupdate')); ?>" method="post">
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="actiontype" value="portalsetting">
                <input type="hidden" name="code" value="bcid">
                <input type="hidden" name="name" value="Bc Id for dmt">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label>Bcid</label>
                            <input type="text" name="value" value="<?php echo e($bcid->value ?? ''); ?>" class="form-control my-1" required="" placeholder="Enter value">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Updating">Update Info</button>

                </div>
            </form>
        </div>
    </div>

    <div class="col-4 col-xl-4 col-sm-4 order-1 order-lg-2 my-3 mb-lg-0">
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4 ">
                <div class="card-title mb-3">
                    <h5 class="mb-0">
                        <span>CP Id For DMT
                        </span>
                    </h5>
                </div>
            </div>
            <form class="actionForm" action="<?php echo e(route('setupupdate')); ?>" method="post">
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="actiontype" value="portalsetting">
                <input type="hidden" name="code" value="cpid">
                <input type="hidden" name="name" value="CP Id for dmt">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label>CP Id</label>
                            <input type="text" name="value" value="<?php echo e($cpid->value ?? ''); ?>" class="form-control my-1" required="" placeholder="Enter value">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Updating">Update Info</button>

                </div>
            </form>
        </div>
    </div> -->

    <div class="col-4 col-xl-4 col-sm-4 order-1 order-lg-2 my-3 mb-lg-0">
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4 ">
                <div class="card-title mb-3">
                    <h5 class="mb-0">
                        <span>Transaction Id Code
                        </span>
                    </h5>
                </div>
            </div>
            <form class="actionForm" action="<?php echo e(route('setupupdate')); ?>" method="post">
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="actiontype" value="portalsetting">
                <input type="hidden" name="code" value="transactioncode">
                <input type="hidden" name="name" value="Transaction Id Code">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label>Code</label>
                            <input type="text" name="value" value="<?php echo e($transactioncode->value ?? ''); ?>" class="form-control my-1" required="" placeholder="Enter value">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Updating">Update Info</button>

                </div>
            </form>
        </div>
    </div>

    <div class="col-4 col-xl-4 col-sm-4 order-1 order-lg-2 my-3 mb-lg-0">
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4 ">
                <div class="card-title mb-3">
                    <h5 class="mb-0">
                        <span>Main Wallet Locked Amount
                        </span>
                    </h5>
                </div>
            </div>
            <form class="actionForm" action="<?php echo e(route('setupupdate')); ?>" method="post">
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="actiontype" value="portalsetting">
                <input type="hidden" name="code" value="mainlockedamount">
                <input type="hidden" name="name" value="Main Wallet Locked Amount">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label>Amount</label>
                            <input type="text" name="value" value="<?php echo e($mainlockedamount->value ?? ''); ?>" class="form-control my-1" required="" placeholder="Enter value">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Updating">Update Info</button>

                </div>
            </form>
        </div>
    </div>

    <div class="col-4 col-xl-4 col-sm-4 order-1 order-lg-2 my-3 mb-lg-0">
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4 ">
                <div class="card-title mb-3">
                    <h5 class="mb-0">
                        <span>Aeps Bank Settlement Locked Amount
                        </span>
                    </h5>
                </div>
            </div>
            <form class="actionForm" action="<?php echo e(route('setupupdate')); ?>" method="post">
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="actiontype" value="portalsetting">
                <input type="hidden" name="code" value="aepslockedamount">
                <input type="hidden" name="name" value="Aeps Bank Settlement Locked Amount">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label>Amount</label>
                            <input type="text" name="value" value="<?php echo e($aepslockedamount->value ?? ''); ?>" class="form-control my-1" required="" placeholder="Enter value">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Updating">Update Info</button>

                </div>
            </form>
        </div>
    </div>

    


</div>


<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('.actionForm').submit(function(event) {
            var form = $(this);
            var id = form.find('[name="id"]').val();
            form.ajaxSubmit({
                dataType: 'json',
                beforeSubmit: function() {
                    form.find('button[type="submit"]').html('Please wait...').attr('disabled',true).addClass('btn-secondary');
                        },
                        complete:function(){
                            form.find('button[type="submit"]').html('Update Info').attr('disabled',false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                        if (id == "new") {
                            form[0].reset();
                            $('[name="api_id"]').select2().val(null).trigger('change');
                        }
                        notify("Task Successfully Completed", 'success');
                        form.closest('.offcanvas').offcanvas('hide');
                        $('#datatable').dataTable().api().ajax.reload();
                    } else {
                        notify(data.status, 'warning');
                    }
                },
                error: function(errors) {
                    showError(errors, form);
                }
            });
            return false;
        });

        $("#setupModal").on('hidden.bs.offcanvas', function() {
            $('#setupModal').find('.msg').text("Add");
            $('#setupModal').find('form')[0].reset();
        });

        $('')
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.ismartpay.in/resources/views/setup/portalsetting.blade.php ENDPATH**/ ?>