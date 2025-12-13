<?php $__env->startSection('title', 'Wallet Load Request'); ?>
<?php $__env->startSection('pagetitle', 'Wallet Load Request'); ?>

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
    <div class="row">
        <?php if($banks): ?>
            <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-4 col-xl-4 col-sm-4 order-1 order-lg-2 my-3 mb-lg-0">
                    <div class="card">
                        <a href="javascript:void(0)" onclick="fundRequest(<?php echo e($bank->id); ?>)">
                            <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4 ">
                                <div class="card-title mb-5">
                                    <h5 class="mb-0">
                                        <span><?php echo e($bank->name); ?></span>
                                    </h5>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div>IFSC :<?php echo e($bank->ifsc); ?></div>
                                        <div>AC / NO. : <?php echo e($bank->account); ?></div>
                                        <div>Branch : <?php echo e($bank->branch); ?></div>
                                        <?php if(isset($bank->fund_qr)): ?>
                                            <div>QR : <a target="_blank" href="<?php echo e(Imagehelper::getImageUrl().$bank->fund_qr); ?>">SCAN QR (Click to Scan & Pay)</a></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                        </a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

    </div>

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
                            <button type="button" class="btn btn-primary" data-bs-toggle="offcanvas"
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


    <div class="offcanvas offcanvas-end" id="fundRequestModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-dropback="static">

        <div class="offcanvas-header bg-primary">
            <h4 id="exampleModalLabel" class="text-white">Wallet Fund Request</h4>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                <span aria-hidden="true"></span>
            </button>
        </div>
        <form id="fundRequestForm" action="<?php echo e(route('fundtransaction')); ?>" method="post">
            <div class="offcanvas-body">
                <input type="hidden" name="user_id">
                <input type="hidden" name="type" value="request">
                <?php echo e(csrf_field()); ?>

                <div class="row">
                    <div class="form-group col-md-6 my-1">
                        <label>Deposit Bank</label>
                        <select name="fundbank_id" class="form-control my-1" id="select" required>
                            <option value="">Select Bank</option>
                            <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($bank->id); ?>"><?php echo e($bank->name); ?> ( <?php echo e($bank->account); ?> )</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6 my-1">
                        <label>Amount</label>
                        <input type="number" name="amount" step="any" class="form-control my-1"
                            placeholder="Enter Amount" required="">
                    </div>
                    <div class="form-group col-md-6 my-1">
                        <label>Payment Mode</label>
                        <select name="paymode" class="form-control my-1" id="select" required>
                            <option value="">Select Paymode</option>
                            <?php $__currentLoopData = $paymodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paymode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($paymode->name); ?>"><?php echo e($paymode->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6 my-1">
                        <label>Pay Date</label>
                        <input type="text" name="paydate" class="form-control mydate" placeholder="Select date">
                    </div>
                    <div class="form-group col-md-6 my-1">
                        <label>Ref No.</label>
                        <input type="text" name="ref_no" class="form-control my-1" placeholder="Enter Refrence Number"
                            required="">
                    </div>
                    <div class="form-group col-md-6 my-1">
                        <label>Pay Slip (Optional)</label>
                        <input type="file" name="payslips" class="form-control my-1">
                    </div>
                    <div class="form-group col-md-12">
                        <label>Remark</label>
                        <textarea name="remark" class="form-control my-1" rows="2" placeholder="Enter Remark"></textarea>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" type="submit"
                    data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
            </div>
        </form>

    </div>

    <div class="modal fade" id="createvpaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Onboard VPA Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <form id="createVpaForm" action="<?php echo e(route('createvpa')); ?>" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="user_id">
                        <input type="hidden" name="type" value="request">
                        <?php echo e(csrf_field()); ?>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Account</label>
                                <input type="number" name="account" step="any" class="form-control my-1"
                                    placeholder="Enter Account Number" required="">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Ifsc Code</label>
                                <input type="text" name="ifsc" step="any" class="form-control my-1"
                                    placeholder="Enter Ifsc Code" required="">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Mobile</label>
                                <input type="tel" maxlength="10" name="mobile" class="form-control my-1"
                                    placeholder="Enter Mobile number" required="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Address</label>
                                <input type="text" name="address" step="any" class="form-control my-1"
                                    placeholder="Enter Address" required="">
                            </div>

                            <div class="form-group col-md-4">
                                <label>city</label>
                                <input type="text" name="city" class="form-control my-1" placeholder="Enter city "
                                    required="">
                            </div>
                            <div class="form-group col-md-4">
                                <label>State</label>
                                <input type="text" name="state" class="form-control my-1"
                                    placeholder="Enter state " required="">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Pincode</label>
                                <input type="text" name="pincode" class="form-control my-1"
                                    placeholder="Enter pincode " required="">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Pan Number</label>
                                <input type="pan" name="pan" class="form-control my-1"
                                    placeholder="Enter pan number " required="">
                            </div>
                            <div class="form-group col-md-4">
                                <label>VPA</label>
                                <input type="text" name="vpa" class="form-control my-1" placeholder="Enter vpa "
                                    required="">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit"
                            data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="onlineRequestModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Onboard VPA Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <form id="pgRequestForm" action="<?php echo e(route('fundtransaction')); ?>" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="user_id">
                        <input type="hidden" name="type" value="dynamicqr">
                        <?php echo e(csrf_field()); ?>

                        <div class="row">

                            <div class="form-group col-md-12">
                                <label>Amount</label>
                                <input type="number" name="amount" step="any" class="form-control my-1"
                                    placeholder="Enter Amount" required="">
                            </div>

                        </div>
                        <div class="mydiv">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit"
                            data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="qrModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">QrCode Scan & Pay</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="canvas_div_pdf" id="receptTable">
                        <h4><?php echo e(\Auth::user()->company->companyname); ?> QrCode</h4><br>
                        <div class="qrimage"></div><br>
                        <h4><?php echo e(\Auth::user()->name ?? ''); ?></h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary"
                        onclick="getPDF('<?php echo e($agent->vpaaddress ?? ''); ?>')">Download</button>

                </div>

            </div>
        </div>
    </div>


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
            var url = "<?php echo e(url('statement/fetch')); ?>/fundrequest/0";
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
                        return `Name - ` + full.fundbank.name + `<br>Account No. - ` + full.fundbank.account + `<br>Branch - ` + full.fundbank.branch;
                    }
                },
                {
                    "data": "bank",
                    render: function(data, type, full, meta) {
                        var slip = '';
                        if (full.payslip) {
                            var slip = `<a target="_blank" href=<?php echo e(Imagehelper::getImageUrl()); ?>`+full.payslip +`>Pay Slip</a>`
                        }
                        return `Ref No. - ` + full.ref_no + `<br>Paydate - ` + full.paydate + `<br>Paymode - ` + full.paymode + ` ( ` + slip + ` )`;
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
            $('#fundRequestModal').offcanvas('show');
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.quick2pay.in/resources/views/fund/request.blade.php ENDPATH**/ ?>