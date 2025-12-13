<?php $__env->startSection('title', 'Affiliate List'); ?>
<?php $__env->startSection('pagetitle', 'Affiliate List'); ?>

<?php
    $table = 'yes';
    // $export = 'wallet';
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
                    <table width="100%" class="table border-top mb-5" id="datatable" role="grid"
                        aria-describedby="user-list-page-info">
                        <thead class=" text-center bg-light">
                            <tr>
                                <th>#</th>
                                <th>References Details</th>
                                <th>Merchant Details </th>
                                <th>Share Link Details</th>
                                <th>Expected Comm</th>

                            </tr>
                        </thead>
                        <tbody>
                    </table>
                </div>
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
            var url = "<?php echo e(url('statement/fetch')); ?>/affiliateList/<?php echo e($id); ?>";
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
                        out += `</a><span style='font-size:13px' class="pull=right">` + full.cdtm +
                            `</span>`;
                        return out;
                    }
                },
                {
                    "data": "username"

                },
                {
                    "data": "name",
                    render: function(data, type, full, meta) {
                        return `Name: ` + full.customer_name + `<br> Email: ` + full.customer_email + `<br> Mobile: ` + full.customer_mobile;
                    }
                },
                {
                    "data": "name",
                    render: function(data, type, full, meta) {
                        return `Department Name: ` + full.department_name + `<br> Data Info Type: ` + full.data_info_type + `<br> Product Type: ` + full.sell_earn_name;
                    }
                },
                {
                    "data": "merchant_expt_comm"
                },

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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.ismartpay.in/resources/views/statement/affiliateList.blade.php ENDPATH**/ ?>