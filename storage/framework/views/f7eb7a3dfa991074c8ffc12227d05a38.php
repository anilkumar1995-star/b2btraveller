<?php $__env->startSection('title', "Fund Request"); ?>
<?php $__env->startSection('pagetitle', "Fund Request"); ?>

<?php
$agentfilter = "hide";
$table = "yes";
?>

<?php $__env->startSection('content'); ?>
<div class="row mt-4">
    <div class="col-12 col-xl-12 col-sm-12 order-1 order-lg-2 mb-4 mb-lg-0">
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4 ">
                <div class="card-title mb-5">
                    <h5 class="mb-0">
                        <span><?php echo $__env->yieldContent('pagetitle'); ?> </span>
                    </h5>
                </div>
            </div>
            <div class="card-datatable table-responsive">
                <table width="100%" class="table border-top mb-5" id="datatable" role="grid" aria-describedby="user-list-page-info">
                    <thead class=" text-center bg-light">
                        <tr>
                            <th>#</th>
                            <th>Requested By</th>
                            <th>Deposit Bank Details</th>
                            <th>Refrence Details</th>
                            <th>Amount</th>
                            <th>Remark</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('style'); ?>

<?php $__env->stopPush(); ?>


<?php $__env->startPush('script'); ?>
<script type="text/javascript">
    $(document).ready(function() {

        var url = "<?php echo e(url('statement/fetch')); ?>/fundrequestviewall/0";
        var onDraw = function() {};
        var options = [{
                "data": "name",
                render: function(data, type, full, meta) {
                    return `<span class='text-inverse m-l-10'><b>` + full.id + `</b> </span><br>
                        <span style='font-size:13px'>` + full.updated_at + `</span>`;
                }
            },
            {
                "data": "username"
            },
            {
                "data": "bank",
                render: function(data, type, full, meta) {
                    return `Name - ` + full.fundbank.name + `<br>Account No. - ` + full.fundbank.account + `<br>Branch - ` + full.fundbank.branch;
                }
            },
            {
                "data": "bank",
                render: function(data, type, full, meta) {
                    var slip = '';
                    if (full.payslip) {
                        var slip = `<a target="_blank" href="<?php echo e(asset('public')); ?>/deposit_slip/` + full.payslip + `">Pay Slip</a>`
                    }
                    return `Ref No. - ` + full.ref_no + `<br>Paydate - ` + full.paydate + `<br>Paymode - ` + full.paymode + ` ( ` + slip + ` )`;
                }
            },
            {
                "data": "amount",
                render: function(data, type, full, meta) {
                        return `Amount - ` + full?.amount + `<br>Charges - ` + full?.charge ;
                    
                }
            },
            {
                "data": "remark"
            },
            {
                "data": "action",
                render: function(data, type, full, meta) {
                    var out = '';
                    if (full.status == "approved") {
                        out += `<label class="badge badge-success bg-success">Approved</label>`;
                    } else if (full.status == "pending") {
                        out += `<label class="badge badge-warning bg-warning">Pending</label>`;
                    } else if (full.status == "rejected") {
                        out += `<label class="badge badge-danger bg-danger">Rejected</label>`;
                    }
                    return out;
                }
            }
        ];

        datatableSetup(url, options, onDraw);
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.bharatmitra.co/resources/views/fund/requestviewall.blade.php ENDPATH**/ ?>