<?php $__env->startSection('title', 'Wallet Load Request'); ?>
<?php $__env->startSection('pagetitle', 'Van Collection'); ?>
<?php
    $table = 'yes';

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
   

    <div class="row mt-4">
        <div class="col-12 col-xl-12 col-sm-12 order-1 order-lg-2 mb-4 mb-lg-0">
            <div class="card">
                <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">
                            <span><?php echo $__env->yieldContent('pagetitle'); ?> </span>
                        </h5>
                    </div>
                    <div class="col-sm-12 col-md-4 mb-5">
                    </div>
                </div>

                <div class="card-datatable table-responsive">
                    <table width="100%" class="table border-top mb-5" id="datatable" role="grid"
                        aria-describedby="user-list-page-info">
                        <thead class=" text-center bg-light">
                            <tr>
                                <th>#</th>
                                <th>User Details</th>
                                <th>Refrence Details</th>
                                <th>Amount</th>
                                <th>Charge</th>
                                <th>Remark</th>
                                <th>Status</th>
                                 <th>Settlement</th>
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
    <script src="<?php echo e(asset('/assets/js/core/jQuery.print.js')); ?>"></script>
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
              $('#downloadQRBtn').on('click', function () {
                const imageSrc = $('#qr-image').attr('src');
                const fileName = 'qr-code.png';
    
                const link = $('<a>')
                    .attr('href', imageSrc)
                    .attr('download', fileName)
                    .css('display', 'none');
    
                $('body').append(link);
                link[0].click();
                link.remove();
            });
            var url = "<?php echo e(url('statement/fetch')); ?>/qrfundrequest/0";
            var onDraw = function() {};
            var options = [{
                    "data": "name",
                    render: function(data, type, full, meta) {
                        return `<span class='text-inverse m-l-10'><b>` + full.id + `</b> </span><br>
                        <span style='font-size:13px'>` + full.updated_at + `</span>`;
                    }
                },
                {
                    "data": "bank",
                    render: function(data, type, full, meta) {
                        return full.user.name +" - "+ full.user.mobile;
                    }
                },
                {
                    "data": "bank",
                    render: function(data, type, full, meta) {
                        var slip = '';
                        if (full.payslip) {
                            var slip = `<a target="_blank" href=<?php echo e(Imagehelper::getImageUrl()); ?>`+full.payslip +`>Pay Slip</a>`
                        }
                        return `Ref No. - ` + full.refno + `<br>TXN Id - ` + full.txnid + `<br>Pay Id - ` + full.payid;
                    }
                },
                {
                    "data": "amount",
                    render: function(data, type, full, meta) {
                        return  full?.amount;

                    }
                },
                {
                    "data": "charge"
                }, 
                {
                    "data": "remark"
                },
              {
                    "data": "action",
                    render: function(data, type, full, meta) {
                        var out = '';
                        if (full.status == "success") {
                            out += `<span class="badge badge-success bg-success">success</span>`;
                        } else if (full.status == "processing") {
                            out += `<span class="badge badge-warning bg-warning"> Processing</span>`;
                        } else if (full.status == "rejected") {
                            out += `<span class="badge badge-danger bg-danger">Rejected</span>`;
                        }
                        return out;
                    }
                },
                {
                    "data": "action",
                    render: function(data, type, full, meta) {
                        var out = '';
                        if (full.settlement == "success") {
                            out += `<span class="badge badge-success bg-success">success</span>`;
                        } else if (full.settlement == "pending") {
                            out += `<span class="badge badge-warning bg-warning"> Processing</span>`;
                        } else if (full.settlement == "processing") {
                            out += `<span class="badge badge-danger bg-danger">T+1</span>`;
                        }

                        return out;
                    }
                },                 
            ];

            datatableSetup(url, options, onDraw);

        });

     

        function fundRequest(id = "none") {
            if (id != "none") {
                $('#fundRequestForm').find('[name="fundbank_id"]').val(id).trigger('change');
            }
            $('#fundRequestModal').offcanvas('show');
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.ismartpay.in/resources/views/statement/vancollection.blade.php ENDPATH**/ ?>