<?php $__env->startSection('title', "Aeps Wallet Statement"); ?>
<?php $__env->startSection('pagetitle', "Aeps Wallet Statement"); ?>

<?php
$table = "yes";
$export = "awallet";
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
                            <th>Refrences Details</th>
                            <th>Order ID</th>
                            <th>Transaction Details</th>
                            <th>TXN Type</th>
                            <th>ST Type</th>
                            <th>Status</th>
                            <th>Opening Bal. </th>
                            <th>Amount </th>
                            <th>Closing Bal. </th>
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
        var url = "<?php echo e(url('statement/fetch')); ?>/awalletstatement/<?php echo e($id); ?>";
        var onDraw = function() {
            $('[data-popup="tooltip"]').tooltip();
            $('[data-popup="popover"]').popover({
                template: '<div class="popover border-teal-400"><div class="arrow"></div><h3 class="popover-title bg-teal-400"></h3><div class="popover-content"></div></div>'
            });
        };
        var options = [{
                "data": "name",
                render: function(data, type, full, meta) {
                    var out = "";
                    out += `</a><span style='font-size:13px' class="pull=right">` + full.created_at + `</span>`;
                    return out;
                }
            },
            {
                "data": "username"
            },
            {
                "data": "txnid"
            },
            {
                "data":"product"
            },
            {
                "data": "trans_type",
                render: function(data, type, full, meta) {
                     var out = full.trans_type;
                     if (full.aepstype == undefined || full.aepstype == null){
                        out  += ""; 
                     }else{
                        out  +=  "<br>AEPS : "+full.aepstype;
                     }
                     return out;
                }
            },
            {
                "data": "rtype"
            },
            {
                "data": "status",
                render: function(data, type, full, meta) {
                    if (full.status == 'success') {
                        return `<span class="badge badge-success bg-success">${full.status}</span>`;
                    } else if (full.status == 'pending'){
                        return `<span class="badge badge-warning bg-warning">${full.status}</span>`;
                    }
                    else if (full.status == 'failed'){
                        return `<span class="badge badge-danger bg-danger">${full.status}</span>`;
                    }else {
                            return `<span class="badge badge-info bg-info">${full.status}</span>`;  
                        }
                }
            },
            {
                "data": "bank",
                render: function(data, type, full, meta) {
                    return `<i class="fa fa-inr"></i> ` + full.balance;
                }
            },
            {
                "data": "bank",
                render: function(data, type, full, meta) {
                    if (full.aepstype == "AP") {
                        if (full.type == "credit") {
                            return `<i class="text-success icon-plus22"></i> <i class="fa fa-inr"></i> ` + (full.amount - full.charge);
                        } else if (full.type == "debit") {
                            return `<i class="text-danger icon-dash"></i> <i class="fa fa-inr"></i> ` + (full.amount - full.charge);
                        } else {
                            return `<i class="fa fa-inr"></i> ` + (full.amount - full.charge);
                        }
                    } else {
                        if (full.type == "credit") {
                            return `<i class="text-success icon-plus22"></i> <i class="fa fa-inr"></i> ` + (full.amount + full.charge);
                        } else if (full.type == "debit") {
                            return `<i class="text-danger icon-dash"></i> <i class="fa fa-inr"></i> ` + (full.amount + full.charge);
                        } else {
                            return `<i class="fa fa-inr"></i> ` + (full.amount + full.charge);
                        }
                    }
                }
            },
            {
                "data": "closing_balance"
                // render: function(data, type, full, meta) {
                //     if (full.aepstype == "AP") {
                //         if (full.type == "credit") {
                //             return `<i class="fa fa-inr"></i> ` + (parseFloat(full.balance) + parseFloat(parseFloat(full.amount) - parseFloat(full.charge)));
                //         } else if (full.type == "debit") {
                //             return `<i class="fa fa-inr"></i> ` + (parseFloat(full.balance) - parseFloat(parseFloat(full.amount) - parseFloat(full.charge)));
                //         } else {
                //             return `<i class="fa fa-inr"></i> ` + full.balance;
                //         }
                //     } else {
                //         if (full.type == "credit") {
                //             if (full.status == "success") {
                //                 return `<i class="fa fa-inr"></i> ` + (parseFloat(full.balance) + parseFloat(parseFloat(full.amount) + parseFloat(full.charge)));
                //             } else {
                //                 return `<i class="fa fa-inr"></i> ` + full.balance;
                //             }

                //         } else if (full.type == "debit") {
                //             return `<i class="fa fa-inr"></i> ` + (parseFloat(full.balance) - parseFloat(parseFloat(full.amount) + parseFloat(full.charge)));
                //         } else {
                //             return `<i class="fa fa-inr"></i> ` + full.balance;
                //         }
                //     }
                // }
            }
        ];

        datatableSetup(url, options, onDraw, '#datatable', {
            columnDefs: [{
                orderable: false,
                width: '80px',
                targets: [0]
            }]
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.quick2pay.in/resources/views/statement/awallet.blade.php ENDPATH**/ ?>