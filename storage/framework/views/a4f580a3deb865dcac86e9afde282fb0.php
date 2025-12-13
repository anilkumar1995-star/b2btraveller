<?php $__env->startSection('title', 'AEPS to Wallet'); ?>
<?php $__env->startSection('pagetitle', 'AEPS to Wallet'); ?>

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
                    <div class="col-sm-12 col-md-2 mb-5">

                        <div class="user-list-files d-flex float-right">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#fundRequestModal">
                                <i class="ti ti-plus ti-xs"></i> New Request</button>
                        </div>
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
   
   <div id="fundRequestModal" class="modal fade" data-backdrop="false" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-slate">
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <h6 class="modal-title">AEPS Move To Wallet Fund</h6>
            </div>
           <form id="fundRequestForm" action="<?php echo e(route('fundtransaction')); ?>" method="post">
            <div class="modal-body">
                <input type="hidden" name="user_id">
                <input type="hidden" name="type" value="request">
                <?php echo e(csrf_field()); ?>

                <div class="row">
                 
                    <div class="form-group col-md-6 my-1">
                        <label>Amount</label>
                        <input type="number" name="amount" step="any" class="form-control my-1"
                            placeholder="Enter Amount" required="">
                    </div>
                    <div class="form-group col-md-6 my-1 my-1">
                        <label>Wallet Type <span class="text-danger fw-bold">*</span></label>
                        <select name="type" class="form-control my-1" required>
                            <option value="">Select Wallet</option>
                            <option value="aeps2wallet">Move To Main Wallet</option>
                        </select>
                   </div>
                   
                    <!--<div class="form-group col-md-6 my-1 my-1">-->
                    <!--<label>Remarks <span class="text-danger fw-bold">*</span></label>-->
                    <!-- <input type="text" class="form-control my-1" name="remarks" placeholder="Enter Value" required="">-->
                    <!--</div>-->
                     <div class="form-group col-md-6 my-1 my-1">
                    <label>T- PIN <span class="text-danger fw-bold">*</span></label>
                    <input type="password" name="pin" class="form-control my-1" placeholder="Enter transaction pin" required="">
                    <a href="<?php echo e(url('profile/view?tab=pinChange')); ?>" target="_blank" class="text-primary pull-right">Generate or Forgot PIN?</a>
                </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" type="submit"
                    data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
            </div>
        </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('/assets/js/core/jQuery.print.js')); ?>"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js">
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var url = "<?php echo e(url('statement/fetch')); ?>/aepsfundrequest/0";
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
                        return full.username
                    }
                },
                {
                    "data": "bank",
                    render: function(data, type, full, meta) {
                        return  full.payoutid;
                    }
                },
                {
                    "data": "amount",
                    render: function(data, type, full, meta) {
                        return `Amount - ` + full?.amount;

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
                            out += `<span class="badge badge-success bg-success">Approved</span>`;
                        } else if (full.status == "pending") {
                            out += `<span class="badge badge-warning bg-warning">Pending</span>`;
                        } else if (full.status == "rejected") {
                            out += `<span class="badge badge-danger bg-danger">Rejected</span>`;
                        }

                        return out;
                    }
                }
            ];

            datatableSetup(url, options, onDraw);

            $("#createVpaForm").validate({
                rules: {
                    account: {
                        required: true
                    },
                    vpa: {
                        required: true
                    },
                    pincode: {
                        required: true
                    },
                    state: {
                        required: true
                    },
                    city: {
                        required: true
                    },
                    address: {
                        required: true
                    },
                    mobile: {
                        required: true
                    },
                    ifsc: {
                        required: true
                    },

                },
                messages: {
                    account: {
                        required: "Please enter a/c number",
                    },
                    vpa: {
                        required: "Please enter request vpa",
                    },
                    pincode: {
                        required: "Please select payment mode",
                    },
                    state: {
                        required: "Please enter State",
                    },
                    city: {
                        required: "Please enter city",
                    },
                    address: {
                        required: "Please enter address",
                    },
                    mobile: {
                        required: "Please enter mobile",
                    },
                    ifsc: {
                        required: "Please enter ifsc",
                    },
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
                    var form = $('#createVpaForm');
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Submit').attr('disabled',
                                false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                form[0].reset();
                                form.closest('.modal').modal('hide');
                                notify(data.message, 'success');
                                $('#datatable').dataTable().api().ajax.reload();
                            } else {
                                notify(data.message, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors, form);
                        }
                    });
                }
            });

            $("#pgRequestForm").validate({
                rules: {
                    amount: {
                        required: true
                    },

                },
                messages: {
                    amount: {
                        required: "Please enter amount",
                    },

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
                    var form = $('#pgRequestForm');
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Submit').attr('disabled',
                                false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                form.closest('.modal').modal('hide');
                                var vpastring = data.data;
                                jQuery(".qrimage").qrcode({
                                    width: 250,
                                    height: 250,
                                    text: vpastring
                                });
                                $('#qrModal').modal();
                                notify(data.status);
                            } else {
                                notify(data.message, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors, form);
                        }
                    });
                }
            });


            $("#fundRequestForm").validate({
                rules: {
                    fundbank_id: {
                        required: true
                    },
                    amount: {
                        required: true
                    },
                    paymode: {
                        required: true
                    },
                    ref_no: {
                        required: true
                    },
                },
                messages: {
                    fundbank_id: {
                        required: "Please select deposit bank",
                    },
                    amount: {
                        required: "Please enter request amount",
                    },
                    paymode: {
                        required: "Please select payment mode",
                    },
                    ref_no: {
                        required: "Please enter transaction refrence number",
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
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Submit').attr('disabled',
                                false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                form[0].reset();
                                form.closest('.offcanvas').offcanvas('hide');
                                notify("Fund Request submitted Successfull", 'success');
                                $('#datatable').dataTable().api().ajax.reload();
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors, form);
                        }
                    });
                }
            });
        });

        function onboarding() {
            var actiontype = "dynamicqr";
            $.ajax({
                    url: "<?php echo e(route('fundtransaction')); ?>",
                    type: 'post',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        swal({
                            title: 'Wait!',
                            text: 'We are fetching bill details',
                            onOpen: () => {
                                swal.showLoading()
                            },
                            allowOutsideClick: () => !swal.isLoading()
                        });
                    },
                    data: {
                        "type": actiontype
                    }
                })
                .done(function(data) {
                    swal.close();

                    // var vpa="<?php echo e($agent->vpaaddress ?? ''); ?>";
                    //  var merchantBusinessName="<?php echo e($agent->merchantBusinessName ?? ''); ?>";
                    //var vpastring='upi://pay?pa='+vpa+'&pn='+merchantBusinessName+'&tr=EZV2021101113322400027817&am=&cu=INR';
                    var vpastring = data.data;
                    jQuery(".qrimage").qrcode({
                        width: 250,
                        height: 250,
                        text: vpastring
                    });
                    $('#qrModal').modal();
                    notify(data.status);
                })
                .fail(function(errors) {
                    swal.close();
                    showError(errors, $('#billpayForm'));
                });
        }

        function fundRequest(id = "none") {
            if (id != "none") {
                $('#fundRequestForm').find('[name="fundbank_id"]').val(id).trigger('change');
            }
            $('#fundRequestModal').modal('show');
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.ismartpay.in/resources/views/fund/aeps2wallet.blade.php ENDPATH**/ ?>