<?php $__env->startSection('title', "Verification Statement"); ?>
<?php $__env->startSection('pagetitle', "Verification Statement"); ?>

<?php
$table = "yes";
$export = "verification";

$table = "yes";

$status['type'] = "Report";
$status['data'] = [
"success" => "Success",
"pending" => "Pending",
"reversed" => "Reversed",
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

            <div class="card-datatable table-responsive">
                <table width="100%" class="table border-top mb-5" id="datatable" role="grid" aria-describedby="user-list-page-info">
                    <thead class=" text-center bg-light">
                        <tr>
                            <th>Order ID</th>
                            <th>User Details</th>
                            <th>Provided Name</th>
                            <th>Others Details</th>
                            <th>Amount/Charges</th>
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

<?php $__env->startPush('style'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
<script src="<?php echo e(asset('/assets/js/core/jQuery.print.js')); ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var url = "<?php echo e(url('statement/fetch')); ?>/verificationstatment/<?php echo e($id); ?>";

        $('#print').click(function() {
            $('#receptTable').print();
        });

        var onDraw = function() {
            $('.print').click(function(event) {
                var data = DT.row($(this).parent().parent().parent().parent().parent()).data();
                $.each(data, function(index, values) {
                    $("." + index).text(values);
                });
                $('#receipt').modal('show');
            });
        };
        var options = [{
                "data": "name",
                render: function(data, type, full, meta) {
                    return `<div>
                            <span class='text-inverse m-l-10'><b>` + full.id + `</b> </span>
                            <div class="clearfix"></div>
                        </div><span style='font-size:13px' class="pull=right">` + full.created_at + `</span>`;
                }
            },
            {
                "data": "username"
            },
            {
                "data": "bank",
                render: function(data, type, full, meta) {
                    return `Name - ` + full.option1 + `<br> Name in Bank -` +full.option3;
                }
            },
            {
                "data": "remark"
               
            },
            {
                "data": "bank",
                render: function(data, type, full, meta) {
                    return `Charge - <i class="fa fa-inr"></i> ${full.charge}`
                }
            },
            {
                "data": "status",
                render: function(data, type, full, meta) {

                    // var menu = ``;
                    // menu += `<li><a href="javascript:void(0)" class="dropdown-item print"><i class="icon-info22"></i>Print Invoice</a></li>`;
                    // if (full.status == "refund" || full.status == "success") {
                    //     menu += `<li><a href="javascript:void(0)" class="dropdown-item" onclick="getrefund(` + full.id + `)"><i class="icon-info22"></i>Get Refund</a></li>`;
                    // }

                    // <?php if(Myhelper::can('money_status')): ?>
                    // menu += `<a href="javascript:void(0)" class="dropdown-item" onclick="status(` + full.id + `, 'money')"><i class="icon-info22"></i>Check Status</a>`;
                    // <?php endif; ?>

                    // <?php if(Myhelper::can('money_statement_edit')): ?>
                    // menu += `<a href="javascript:void(0)" class="dropdown-item" onclick="editReport(` + full.id + `,'` + full.refno + `','` + full.txnid + `','` + full.payid + `','` + full.remark + `', '` + full.status + `', 'money')"><i class="icon-pencil5"></i> Edit</a>`;
                    // <?php endif; ?>

                    // <?php if(Myhelper::can('complaint')): ?>
                    // menu += `<a href="javascript:void(0)" class="dropdown-item" onclick="complaint(` + full.id + `, 'recharge')"><i class="icon-cogs"></i> Complaint</a>`;
                    // <?php endif; ?>


                    return `<div class="btn-group" role="group">
                                    <span id="btnGroupDrop1" class="badge ${full.status=='success'? 'bg-success badge-success' : full.status=='pending'? 'bg-warning badge-warning':full.status=='failed'? 'bg-danger badge-danger':full.status=='refund'? 'bg-dark badge-dark':'bg-info badge-info'}  aria-haspopup="true" aria-expanded="false">
                                    ` + full.status + `
                                    </span>
                                    
                                 </div>`;

                }
            }
        ];

        var DT = datatableSetup(url, options, onDraw);

        $("#otpForm").validate({
            rules: {
                otp: {
                    required: true,
                    number: true,
                },
            },
            messages: {
                otp: {
                    required: "Please enter otp number",
                    number: "Otp number should be numeric",
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
                var form = $('#otpForm');
                form.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {
                        form.find('button[type="submit"]').html('Please wait...').attr('disabled', true).addClass('btn-secondary');
                    },
                    complete: function() {
                        form.find('button[type="submit"]').html('Submit').attr('disabled', false).removeClass('btn-secondary');
                    },
                    success: function(data) {
                        if (data.statuscode == "TXN") {
                            form[0].reset();
                            $('#otpModal').find('[name="transid"]').val("");
                            $('#otpModal').modal('hide');
                            notify('Transaction Successfully Refunded, Amount Credited', 'success');
                        } else {
                            notify(data.message, 'error', "inline", form);
                        }
                    },
                    error: function(errors) {
                        showError(errors, form);
                    }
                });
            }
        });

    });

    function getrefund(id, type = "none") {
        $.ajax({
                url: `<?php echo e(route('dmt2pay')); ?>`,
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                data: {
                    'id': id,
                    "type": "refundotp"
                },
                beforeSend: function() {
                    swal({
                        title: 'Wait!',
                        text: 'We are processing your request.',
                        allowOutsideClick: () => !swal.isLoading(),
                        onOpen: () => {
                            swal.showLoading()
                        }
                    });
                },
            })
            .done(function(data) {
                swal.close();
                if (type == "none") {
                    if (data.statuscode == "TXN") {
                        $('#otpModal').find('[name="transid"]').val(id);
                        $('#otpModal').modal('show');
                    } else {
                        notify(data.message, 'error');
                    }
                } else {
                    if (data.statuscode == "TXN") {
                        notify(data.message, 'success', "inline", $('#otpForm'));
                    } else {
                        notify(data.message, 'error', "inline", $('#otpForm'));
                    }
                    $('#datatable').dataTable().api().ajax.reload();
                }
            })
            .fail(function(errors) {
                swal.close();
            });
    }

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
                $('#utiidModal').modal();
            })
            .fail(function(errors) {
                notify('Oops', errors.message + '! ' + errors.statusText, 'error');
            });
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.quick2pay.in/resources/views/statement/verification.blade.php ENDPATH**/ ?>