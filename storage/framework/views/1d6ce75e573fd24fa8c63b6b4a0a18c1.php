<?php $__env->startSection('title', 'All Aeps Txn Statement'); ?>
<?php $__env->startSection('pagetitle', 'All Aeps Txn Statement'); ?>

<?php
    $table = 'yes';
    $status['type'] = 'Report';
    $status['data'] = [
        'success' => 'Success',
        'pending' => 'Pending',
        'failed' => 'Failed',
        'reversed' => 'Reversed',
        'refunded' => 'Refunded',
    ];
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
                <div class="card-datatable">
                    <table width="100%" class="table border-top mb-5" id="datatable" role="grid"
                        aria-describedby="user-list-page-info">
                        <thead class=" text-center bg-light">
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>User Details</th>
                                <th>Bank Details</th>
                                <th>Transaction Details</th>
                                <th>Amount</th>
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

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script type="text/javascript">
        $(document).ready(function() {
            var url = "<?php echo e(url('statement/fetch')); ?>/aepstxnreport/<?php echo e($id); ?>";
            var onDraw = function() {};
            var options = [{
                    "data": "name",
                    render: function(data, type, full, meta) {
                        return `<div><span class='text-inverse m-l-10'><b>` + full.id + `</b> </span><div class="clearfix"></div></div><span style='font-size:13px' class="pull=right">` + full.created_at + `</span>`;
                    }
                },
                {
                    "data": "name",
                    render: function(data, type, full, meta) {

                        return `<div><span class='text-inverse m-l-10'><b>` + (full.txn_type == undefined || full.txn_type == null ? '' : full.txn_type) + `</b> </span><div class="clearfix"></div></div>`;

                    }
                },
                {
                    "data": "username"
                },
                {
                    "data": "bank",
                    render: function(data, type, full, meta) {
                        return `Bank - ` + (full.bankName == undefined || full.bankName == null ? '' : full.bankName) + `<br>Mobile - ` + (full.mobile_no == undefined || full.mobile_no == null ? '' : full.mobile_no)
                    }
                },
                {
                    "data": "bank",
                    render: function(data, type, full, meta) {
                        return `Ref No. - ` + (full.order_ref_id == undefined || full.order_ref_id == null ? '' : full.order_ref_id) + `<br>Txnid - ` + (full.txn_id == undefined || full.txn_id == null ? '' : full.txn_id) + `<br>Opertaorid - ` + (full.operator_ref_id == undefined || full.operator_ref_id == null ? '' : full.operator_ref_id) + `<br>Message - ` + (full.message == undefined || full.message == null ? full.description : full.message) || full.description;
                    }
                },
                {
                    "data": "bank",
                    render: function(data, type, full, meta) {
                        var amstr = "";
                        if ((full.pay_amount !=  '' && full.pay_amount !=  null)) {
                            amstr+= `Amount: <i class="fa fa-inr"></i> ` + full.pay_amount;
                        } else if(full.txn_amount != null && full.txn_amount != ""){
                            amstr+= `Amount: <i class="fa fa-inr"></i> ` + full.txn_amount;
                        }else {
                            amstr+= `Amount: <i class="fa fa-inr"></i> ` + ((full.txn_value != '' && full.txn_value != null )? full.txn_value : 0) ;
                        }

                        amstr+= `<br> Commission: <i class="fa fa-inr"></i> `+ ((full.commission != '' && full.commission != null )? full.commission : 0)

                        return amstr;



                    }
                },

                {
                    "data": "status",
                    render: function(data, type, full, meta) {

                        var menu = ``;
                        <?php if(Myhelper::can('aeps_status')): ?>
                            menu +=
                                `<li><a href="javascript:void(0)" class="dropdown-item" onclick="status(` + full.id + `, 'aepstxnreport')"><i class="icon-info22"></i>Check Status</a></li>`;
                        <?php endif; ?>

                        // <?php if(Myhelper::can('aeps_statement_edit')): ?>
                        //     menu +=
                        //         `<li><a href="javascript:void(0)" class="dropdown-item" onclick="editReport(` +
                        //         full.id + `,'` + full.order_ref_id + `','` + full.txn_id + `','` + full
                        //         .operator_ref_id + `','', '` + full.status +
                        //         `', 'aepstxnreport')"><i class="icon-pencil5"></i> Edit</a></li>`;
                        // <?php endif; ?>

                        menu +=
                            `<li><a href="javascript:void(0)" class="dropdown-item" onclick="complaint(` +
                            full.id + `, 'aepstxnreport')"><i class="icon-cogs"></i> Complaint</a></li>`;


                        return `<div class="btn-group" role="group">
                                    <span id="btnGroupDrop1" class="badge ${full.status.toLowerCase()=='success'? 'bg-success' : full.status.toLowerCase()=='pending'? 'bg-warning':full.status.toLowerCase()=='reversed'? 'bg-info':full.status.toLowerCase()=='complete'? 'bg-primary':'bg-danger'} dropdown-toggle"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    ` + full.status.toLowerCase() + `
                                    </span>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                       ` + menu + `
                                    </div>
                                 </div>`;


                    }
                }
            ];

            datatableSetup(url, options, onDraw);
        });

        function viewUtiid(id) {
            $.ajax({
                    url: `<?php echo e(url('statement/fetch')); ?>/utiidstatement/` + id,
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    data: {
                        'scheme_id': id
                    }
                })
                .done(function(data) {
                    $.each(data, function(index, values) {
                        $("." + index).text(values);
                    });
                    $('#utiidModal').offcanvas('show');
                })
                .fail(function(errors) {
                    notify('Oops', errors.status + '! ' + errors.statusText, 'warning');
                });
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.quick2pay.in/resources/views/statement/aepstxn.blade.php ENDPATH**/ ?>