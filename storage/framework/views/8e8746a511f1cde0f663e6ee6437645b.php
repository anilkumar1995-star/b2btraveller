<?php $__env->startSection('title', "Payout"); ?>
<?php $__env->startSection('pagetitle', "Payout"); ?>
<?php
$table = "yes";
?>

<style>
    .select2-container--default .select2-selection--single {
        border: 1px solid #a09e9e !important;
    }

    .select2-container--default .select2-selection--single {
        height: 45px !important;
        padding: 7px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        top: 65% !important;
    }
</style>

<?php $__env->startSection('content'); ?>
<div class="content">
    <div class="row">
        <div class="col-sm-4">
            <div class="card">

                <div class="card-body">
                    <h4 class="card-title">Payout</h4>
                    <form id="serachForm" action="<?php echo e(route('payoutTransaction')); ?>" method="post">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="type" value="fetchbeneficiary">
                        <input type="hidden" id="rname">
                        <input type="hidden" id="rlimit">
                        <div class="form-group no-margin-bottom mb-2">
                            <label>Mobile Number</label>
                            <input type="number" step="any" name="mobile" class="form-control mt-2" placeholder="Enter Mobile Number" required="">
                        </div>

                        <!-- <div class="text-center border-top-0 card-footer"> -->
                        <button type="submit" class="btn btn-primary" data-loading-text="<b><i class='fa fa-spin fa-spinner'></i></b> Searching"><b><i class="icon-search4"></i></b> Search</button>
                        <!-- </div> -->
                    </form>
                </div>
            </div>

            <div class="card userdetails mt-4" style="display:none">
                <div class="card-header">
                    <h5 class="content-group no-margin">
                        <span class="label label-flat label-rounded label-icon border-grey text-grey mr-10">
                            <i class="fa fa-user"></i>&nbsp;&nbsp;
                        </span>
                        <a href="javascript:void(0)" class="text-default name"></a>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- <h6 class="text-semibold no-margin-top mobile"></h6> -->
                            <h6 class="text-semibold text-right no-margin-top">Mobile No. : <span class="text-semibold mobile"></span></h6>
                            <ul class="list list-unstyled">
                                <li>Used Limit : <span class="usedlimit"></span></li>
                            </ul>
                        </div>

                        <div class="col-sm-6">
                            <h6 class="text-semibold text-right no-margin-top">Total Limit : <span class="text-semibold totallimit"></span></h6>
                            <ul class="list list-unstyled text-right">
                                <li>Remain Limit:<span class="text-semibold remainlimit"></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white text-center alpha-grey">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#beneficiaryModal" class="btn btn-primary">
                        <i class="icon-plus22 position-left"></i>
                        New Beneficiary
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-8 match-height">
            <div class="card card-default">
                <div class="card-header">
                    <h5 class="content-group no-margin">
                        Beneficiary List
                    </h5>
                </div>
                <div class="card-body p-3">
                    <table class="table table-bordered table-bordered transaction" cellspacing="0" width="100%" style="font-size:14px;">
                        <thead class="bg-light">
                            <th width="150px">Name</th>
                            <th width="250px">Account Details</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="beneficiaryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title pull-left">Beneficiary Details</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('payoutTransaction')); ?>" method="post" id="beneficiaryForm">
                <div class="modal-body">
                    <?php echo e(csrf_field()); ?>

                    <input type="hidden" name="rid">
                    <input type="hidden" name="type" value="addbeneficiary">
                    <input type="hidden" name="mobile">
                    <input type="hidden" name="name">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="form-group">
                                <label>Bank Name : </label><br />
                                <select id="bank" name="beneBank" class="form-select typebox ptag input-lg from-control" style="width:100%;">
                                    <option value="">----Select Bank----</option>
                                    <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($bank->id); ?>"><?php echo e($bank->bank); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-group">
                                <label for="phone">IFSC Code:</label>
                                <input type="text" class="form-control" name="beneIfsc" placeholder="Bank ifsc code" required="">
                            </div>
                        </div>

                        <div class="col-md-6 mb-2">
                            <div class="form-group">
                                <label for="phone">Bank Account No.:</label>
                                <input type="text" class="form-control" id="account" name="beneAccountNo" placeholder="Enter account no." required="">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-group">
                                <label for="phone">Beneficiary Mobile:</label>
                                <input type="text" class="form-control" name="beneMobile" placeholder="Enter name" required="">
                                <p></p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Beneficiary First Name:</label>
                                <input type="text" class="form-control" name="beneFName" placeholder="Enter fname name" required="">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Beneficiary Last Name:</label>
                                <input type="text" class="form-control" name="beneLName" placeholder="Enter last name" required="">
                            </div>
                        </div>
                    </div>

                </div>
                <center>
                    <div class="fullname"></div>
                </center>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-hidden="true">Close</button>
                    <button class="btn btn-primary" type="button" id="getBenename">Get Name</button>
                    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="otpModal" class="modal fade" role="dialog" data-bs-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title pull-left">Otp Verification</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('payoutTransaction')); ?>" method="post" id="otpForm">
                <?php echo e(csrf_field()); ?>

                <div class="modal-body">
                    <input type="hidden" name="type" value="beneverify">
                    <input type="hidden" name="mobile">
                    <input type="hidden" name="beneAccountNo">
                    <input type="hidden" name="beneMobile">
                    <div class="form-group mb-2">
                        <label>OTP</label>
                        <input type="text" class="form-control" name="otp" placeholder="enter otp" required>
                        <a href="javascript:void(0)" class="pull-right resendOtp" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Sending" type="resendOtpVerification"><i class='fa fa-paper-plane'></i> Resend Otp</a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-hidden="true">Close</button>
                    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="transferModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Transfer Money</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('payoutTransaction')); ?>" method="post" id="transferForm">
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="type" value="transfer">
                <input type="hidden" name="mobile">
                <input type="hidden" name="name">
                <input type="hidden" name="beneName">
                <input type="hidden" name="beneAccount">
                <input type="hidden" name="beneBank">
                <input type="hidden" name="beneIfsc">
                <input type="hidden" name="beneMobile">
                <input type="hidden" name="payoutapi" value="<?php echo e($type); ?>">
                <div class="modal-body">
                    <div class="card border-left-lg border-left-success invoice-grid timeline-content">
                        <div class="card-body border">
                            <div class="row ">
                                <div class="col-sm-6">
                                    <h6 class="text-semibold no-margin-top ">Name - <span class="benename"></span></h6>
                                    <ul class="list list-unstyled">
                                        <li>Bank - <span class="beneBank"></span></li>
                                    </ul>
                                </div>

                                <div class="col-sm-6">
                                    <h6 class="text-semibold text-right no-margin-top">Acc - <span class="beneAccountNo"></span></h6>
                                    <ul class="list list-unstyled text-right">
                                        <li>Ifsc - <span class="beneIfsc"></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Amount</label>
                                <input type="number" class="form-control" placeholder="Enter amount to be transfer" name="amount" step="any" required>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Transfer Mode</label><br />
                            <select name="mode" class="form-select typebox ptag input-lg from-control " id="mode" style="width:100%;">
                                <option selected>Transfer Mode </option>
                                <option value="IMPS">IMPS</option>
                                <option value="NEFT">NEFT</option>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label>T-Pin</label>
                            <input type="password" name="pin" class="form-control" placeholder="Enter transaction pin" required="">
                            <a href="<?php echo e(url('profile/view?tab=pinChange')); ?>" target="_blank" class="text-primary pull-right">Generate Or Forgot Pin??</a>
                        </div>

                        <!-- <div class="form-group col-md-4">-->
                        <!--    <label>Otp</label>-->
                        <!--    <input type="password" name="otp" class="form-control" Placeholder="Otp" required>-->
                        <!--    <a href="javascript:void(0)" onclick="OTPRESEND()" class="text-primary pull-right">Get Otp</a>-->
                        <!--</div>-->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-hidden="true">Close</button>
                    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
                </div>
            </form>
        </div>

    </div>
</div>

<div class="modal fade" id="receiptmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title">Receipt</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group transactionData p-0">
                </ul>
                <div id="receptTable">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4>Invoice</h4>
                        </div>
                    </div>
                    <hr class="m-t-10 m-b-10">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="pull-left m-t-10">
                                <address class="m-b-10">
                                    <strong> Agent : </strong><span class="username"><?php echo e(Auth::user()->name); ?></span><br>
                                    <strong> Shop Name :</strong> <span class="company"><?php echo e(Auth::user()->shopname); ?></span><br>
                                    <strong>Phone : </strong><span class="mobile"><?php echo e(Auth::user()->mobile); ?></span>
                                </address>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="pull-right m-t-10">
                                <address class="m-b-10">
                                    <strong>Date : </strong> <span class="date"><?php echo e(date('d M y - h:i A')); ?></span><br>
                                    <strong>Name : </strong> <span class="benename"></span><br>
                                    <strong>Account : </strong> <span class="beneAccountNo"></span><br>
                                    <strong>Bank : </strong> <span class="beneBank"></span>
                                </address>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <h5 class="mb-2">Transaction Details :</h5>
                                <table class="table m-t-10 text-center w-100 tabel-responsive" style="font-size:14px;">
                                    <thead class="border">
                                        <tr>
                                            <th>Order Id</th>
                                            <th>Amount</th>
                                            <th>UTR No.</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border">
                                        <tr>
                                            <td class="id"></td>
                                            <td class="amount"></td>
                                            <td class="txnid"></td>
                                            <td class="status"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row my-2" style="border-radius: 0px;">
                        <div class="col-md-6 col-md-offset-6">
                            <h5 class="text-left">Transfer Amount : <span class="samount"></span></h5>
                        </div>
                    </div>
                    <p><span class="text-danger">*</span><b> As per RBI guideline, maximum charges allowed is 2%. </b></p>
                    <hr>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-hidden="true">Close</button>
                <button class="btn btn-primary btn-lg" type="button" id="print"><i class="fa fa-print"></i></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="registrationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title pull-left">Member Registration</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('payoutTransaction')); ?>" method="post" id="registrationForm">
                <?php echo e(csrf_field()); ?>

                <div class="modal-body">
                    <input type="hidden" name="type" value="registration">
                    <input type="hidden" name="mobile">
                    <div class="row">
                        <div class="form-group col-md-6 mb-2">
                            <label>First Name</label>
                            <input type="text" class="form-control" name="fName" required="" placeholder="Enter first name">
                        </div>

                        <div class="form-group col-md-6 mb-2">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="lName" required="" placeholder="Enter last name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 mb-2">
                            <label>Pincode</label>
                            <input type="text" class="form-control" name="pincode" required="" placeholder="Enter Pincode">
                        </div>

                        <div class="form-group col-md-6 mb-2">
                            <label>Otp</label>
                            <input type="text" class="form-control" name="otp" required="" placeholder="Enter OTP">
                            <a href="javascript:void(0)" class="pull-right resendOtp" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Sending" type="resendOtpVerification"><i class='fa fa-paper-plane'></i> Resend Otp</a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-hidden="true">Close</button>
                    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
                </div>
            </form>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<!-- <script src="<?php echo e(asset('/assets/js/core/jQuery.print.js')); ?>"></script> -->
<script src="https://cdn.jsdelivr.net/gh/DoersGuild/jQuery.print/jQuery.print.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // $('#bank').select2({
        //     dropdownParent: $('#beneficiaryModal')
        // });
        // $('#mode').select2({
        //     dropdownParent: $('#transferModal')
        // });
    });
    $(document).ready(function() {
        $("[name='mobile']").keyup(function() {
            $("#serachForm").submit();
        });

        $('#print').click(function() {
            $('#receptTable').print();
        });

        $('#bank').on('change', function(e) {
            $('input[name="beneIfsc"]').val($(this).find('option:selected').attr('ifsc'));
        });

        $('a.resendOtp').click(function() {
            var mobile = $(this).closest('form').find('input[name="mobile"]').val();
            var button = $(this);
            var form = $(this).closest('form');
            $.ajax({
                url: "<?php echo e(route('payoutTransaction')); ?>",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                data: {
                    'mobile': mobile,
                    'type': "otp"
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
                success: function(data) {
                    swal.close();
                    if (data.statuscode == "TXN") {
                        notify(data.message, 'success');
                    } else {
                        notify(data.message, 'error');
                    }
                },
                error: function(error) {
                    swal.close();
                    notify("Something went wrong", 'error');
                }
            });
        });

        $("#serachForm").validate({
            rules: {
                mobile: {
                    required: true,
                    number: true,
                    minlength: 10,
                    maxlength: 10
                },
            },
            messages: {
                mobile: {
                    required: "Please enter mobile number",
                    number: "Mobile number should be numeric",
                    minlength: "Mobile number length should be 10 digit",
                    maxlength: "Mobile number length should be 10 digit",
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
                var form = $('#serachForm');
                form.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {
                        swal({
                            title: 'Wait!',
                            text: 'We are working on your request',
                            onOpen: () => {
                                swal.showLoading()
                            },
                            allowOutsideClick: () => !swal.isLoading()
                        });
                    },
                    complete: function() {},
                    success: function(data) {
                        swal.close();
                        if (data.statuscode == "TXN") {
                            setVerifyData(data);
                            setBeneData(data);
                        } else if (data.statuscode == "RNF") {
                            var mobile = form.find('[name="mobile"]').val();
                            $('#registrationModal').find('[name="mobile"]').val(mobile);
                            $('#registrationModal').modal('show');
                        } else if (data.statuscode == "TXNOTP") {
                            var type = form.find('[name="type"]').val();
                            if (type == "registration" || type == "fetchbeneficiary") {
                                $('#otpModal').find('[name="type"]').val("registrationValidate");
                            }
                            var mobile = form.find('[name="mobile"]').val();
                            $('#otpModal').find('[name="transid"]').val(data.transid);
                            $('#otpModal').find('[name="mobile"]').val(mobile);
                            $('#otpModal').modal('show');
                        } else {
                            notify(data.message || data.status, 'error');
                        }
                    },
                    error: function(errors) {
                        showError(errors, form);
                        swal.close();
                    }
                });
            }
        });

        $("#beneficiaryForm").validate({
            rules: {
                ifsc: {
                    required: true,
                },
                account: {
                    required: true,
                },
                account_confirmation: {
                    required: true,
                    equalTo: '#account'
                },
                name: {
                    required: true,
                }
            },
            messages: {
                ifsc: {
                    required: "Bank ifsc code is required",
                },
                account: {
                    required: "Beneficiary bank account number is required",
                },
                account_confirmation: {
                    required: "Account number confirmation is required",
                    equalTo: 'Account confirmation is same as account number'
                },
                name: {
                    required: "Beneficiary account name is required",
                }
            },
            errorElement: "p",
            errorPlacement: function(error, element) {
                if (element.prop("tagName").toLowerCase() === "select") {
                    error.insertAfter(element.closest(".form-group"));
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function() {
                var form = $('#beneficiaryForm');
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
                            form.find('select').val(null).trigger('change');
                            form.closest('.modal').modal('hide');
                            notify('Beneficiary Successfully Added.', 'success');
                            $("#serachForm").submit();
                        } else {
                            notify(data.message, 'error');
                        }
                    },
                    error: function(errors) {
                       form.find('button[type="submit"]').html('Submit').attr('disabled', false).removeClass('btn-secondary');
                
                        // showError(errors, form);
                        notify(errors.responseJSON, 'error');
                    }
                });
            }
        });

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
                        swal({
                            title: 'Wait!',
                            text: 'We are working on your request',
                            onOpen: () => {
                                swal.showLoading()
                            },
                            allowOutsideClick: () => !swal.isLoading()
                        });
                    },
                    success: function(data) {
                        swal.close();
                        if (data.statuscode == "TXN") {
                            var type = form.find('[name="type"]').val();
                            form[0].reset();
                            $('#otpModal').find('[name="mobile"]').val("");
                            $('#otpModal').find('[name="beneAccountNo"]').val("");
                            $('#otpModal').find('[name="beneMobile"]').val("");
                            $('#otpModal').modal('hide');
                            if (type == "registrationValidate") {
                                notify('Member successfully registered.', 'success');
                            } else {
                                notify('Beneficiary Successfully verified.', 'success');
                            }
                            $("#serachForm").submit();
                        } else {
                            notify(data.message, 'error');
                        }
                    },
                    error: function(errors) {
                        swal.close();
                        showError(errors, form);
                    }
                });
            }
        });

        $('#transferForm').submit(function(event) {
            var form = $(this);
            form.ajaxSubmit({
                dataType: 'json',
                beforeSubmit: function() {
                    // swal({
                    //     title: 'Wait!',
                    //     text: 'We are working on your request',
                    //     onOpen: () => {
                    //         swal.showLoading()
                    //     },
                    //     allowOutsideClick: () => !swal.isLoading()
                    // });
                form.find('button[type="submit"]').html('Please wait...').attr('disabled', true).addClass('btn-secondary');

                },
                complete: function() {
                    form.find('button[type="submit"]').html('Submit').attr('disabled', false).removeClass('btn-secondary');
                },
                success: function(data) {
                    console.log('data',data);
                    getbalance();
                    
                    var samount = 0;
                    var out = "";
                    var tbody = '';
                    if(data.statuscode == 'TXN'){
                        form.closest('.modal').modal('hide');
                        form[0].reset();
                        // if (data && data.data[0].status != "TXF") {
                            $.each(data.data, function(index, val) {
                                if (val?.data?.statuscode == "TXN" || val?.data?.statuscode == "TUP") {
                                    samount += parseFloat(val.amount);
                                    out += '<li class="list-group-item alert alert-success no-margin mb-10"><strong>Rs.  ' + val.amount + '</strong><span class="pull-right">(' + val?.data?.message + ')</span></li>';
                                    tbody += `
                                        <tr>
                                            <td>` + val?.data?.payid + `</td>
                                            <td>` + val.amount + `</td>
                                            <td>` + val?.data?.rrn + `</td>
                                            <td>` + val?.data?.status + `</td>
                                        </tr>        
                                    `;
                                } else {

                                    out += '<li class="list-group-item alert alert-danger no-margin mb-10"><strong>Rs.  ' + val.amount + '</strong> ( <strong>' + val?.data?.message + '</strong> )  <strong class="pull-right">' + val?.data?.rrn + '</strong></li>';
                                }
                            });
                        // }
                        $('.transactionData').html(out);
                        if (samount != 0 && data.data[0].status  != "TXF") {
                            $('#receptTable').fadeIn('400');
                            var benename = $('#transferForm').find('[name="beneName"]').val();
                            var beneAccountNo = $('#transferForm').find('[name="beneAccount"]').val();
                            var beneBank = form.find('[name="beneBank"]').val();
                            var bankname = form.find('.beneBank').text();


                            $('.benename').text(benename);
                            $('.beneAccountNo').text(beneAccountNo);
                            $('.beneBank').text(bankname);
                            $('#receptTable').find('tbody').html(tbody);
                            $('.samount').text(parseFloat(samount));
                            $('#receiptmodal').modal('show');
                                

                        } else {
                            notify(data?.message || data?.data[0].data?.status +" " + data?.data[0].data?.message, 'warning');
                        }
                    }else{
                        notify(data.message, 'error');

                    }
                       
                },
                error: function(errors) {
                    notify(errors.responseJSON.status || errors.responseJSON || "Something went worng", 'error');
                    form.find('button[type="submit"]').html('Submit').attr('disabled', false).removeClass('btn-secondary');
                    swal.close();
                }
            });
            return false;
        });

        // $( "#transferForm" ).validate({
        //     rules: {
        //         amount: {
        //             required: true,
        //             number : true,
        //             min:100
        //         }
        //     },
        //     messages: {
        //         amount: {
        //             required: "Please enter amount",
        //             number: "Amount should be numeric",
        //             min : "Amount value should be greater than 100"
        //         }
        //     },
        //     errorElement: "p",
        //     errorPlacement: function ( error, element ) {
        //         if ( element.prop("tagName").toLowerCase() === "select" ) {
        //             error.insertAfter( element.closest( ".form-group" ).find(".select2") );
        //         } else {
        //             error.insertAfter( element );
        //         }
        //     },
        //     submitHandler: function () {
        //         var form = $('#transferForm');
        //         var amount = form.find('[name="amount"]').val();
        //         var benename = form.find('[name="benename"]').val();
        //         var beneAccountNo = form.find('[name="beneAccountNo"]').val();
        //         var beneBank = form.find('[name="beneBank"]').val();
        //         var bankname = form.find('.beneBank').text();
        //         var beneIfsc = form.find('[name="beneIfsc"]').val();
        //         form.ajaxSubmit({
        //             dataType:'json',
        //             beforeSubmit:function(){
        //                 form.find('button[type="submit"]').button('loading');
        //             },
        //             success:function(data){
        //                 form.find('button[type="submit"]').button('reset');
        //                 form[0].reset();
        //                 getbalance();
        //                 form.closest('.modal').modal('hide');
        //                 var samount = 0;
        //                 var out ="";
        //                 var tbody = '';
        //                 $.each(data.data , function(index, val){
        //                     if(val.data.statuscode == "TXN" || val.data.statuscode == "TUP"){
        //                         samount += parseFloat(val.amount);
        //                         out += '<li class="list-group-item alert alert-success no-margin mb-10"><strong>Rs.  '+val.amount+'</strong><span class="pull-right">'+val.data.status+'</span></li>';
        //                         tbody += `
        //                             <tr>
        //                                 <td>`+val.data.payid+`</td>
        //                                 <td>`+val.amount+`</td>
        //                                 <td>`+val.data.rrn+`</td>
        //                                 <td>`+val.data.status+`</td>
        //                             </tr>        
        //                         `;
        //                     }else{
        //                         out += '<li class="list-group-item alert alert-danger no-margin mb-10"><strong>Rs.  '+val.amount+'</strong><span class="pull-right">'+val.data.rrn+'</span></li>';
        //                     }
        //                 });
        //                 $('.transactionData').html(out);
        //                 if(samount != 0){
        //                     $('#receptTable').fadeIn('400');                            
        //                     $('.benename').text(benename);
        //                     $('.beneAccountNo').text(beneAccountNo);
        //                     $('.beneBank').text(bankname);
        //                     $('#receptTable').find('tbody').html(tbody);
        //                     $('.samount').text(parseFloat(samount));
        //                 }else{
        //                     $('#receptTable').fadeOut('400');
        //                 }
        //                 $('#receipt').modal();
        //             },
        //             error: function(errors) {
        //                 showError(errors, form);
        //             }
        //         });
        //     }
        // });

        $("#registrationForm").validate({
            rules: {
                name: {
                    required: true,
                },
                surname: {
                    required: true,
                },
                pincode: {
                    required: true,
                    number: true,
                    minlength: 6,
                    maxlength: 6
                },
            },
            messages: {
                name: {
                    required: "Please enter firstname",
                },
                surname: {
                    required: "Please enter surname",
                },
                pincode: {
                    required: "Please enter pincode",
                    number: "Pincode should be numeric",
                    minlenght: "Pincode length should be 6 digit",
                    maxlenght: "Pincode length should be 6 digit",
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
                var form = $('#registrationForm');
                var type = form.find('input[name="type"]').val();
                form.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {
                        form.find('button[type="submit"]').html('Please wait...').attr('disabled',true).addClass('btn-secondary');
                        swal({
                            title: 'Wait!',
                            text: 'We are working on your request',
                            onOpen: () => {
                                swal.showLoading()
                            },
                            allowOutsideClick: () => !swal.isLoading()
                        });
                    },
                    success: function(data) {
                        swal.close();
                        form.find('button[type="submit"]').html('Submit').attr('disabled',false).removeClass('btn-secondary');
                        if (data.statuscode == "TXN") {
                            form.closest('.modal').modal('hide');
                            $("#serachForm").submit();
                        } else {
                            notify(data.message, 'error');
                        }
                    },
                    error: function(errors) {
                        notify(errors.responseJSON, 'error');
                        // showError(errors, form);
                        form.find('button[type="submit"]').html('Submit').attr('disabled',false).removeClass('btn-secondary');
                        swal.close();
                    }
                });
            }
        });

        $('#getBenename').click(function() {
            var mobile = $(this).closest('form').find("[name='mobile']").val();
            var name = $(this).closest('form').find("[name='name']").val();
            var beneBank = $(this).closest('form').find("[name='beneBank']").val();
            var beneAccountNo = $(this).closest('form').find("[name='beneAccountNo']").val();
            var beneIfsc = $(this).closest('form').find("[name='beneIfsc']").val();
            var beneFName = $(this).closest('form').find("[name='beneFName']").val();
            var beneLName = $(this).closest('form').find("[name='beneLName']").val();
            var beneMobile = $(this).closest('form').find("[name='beneMobile']").val();

            if (mobile != '' || name != '' || beneBank != '' || beneAccountNo != '' || beneIfsc != '' || beneFName != '' || beneLName != '' || beneMobile != '') {
                getName(mobile, name, beneBank, beneAccountNo, beneIfsc, beneFName, beneLName, beneMobile, 'add');

            }
        });
    });

    function setVerifyData(data) {

        $('.name').text(data.message.firstName);
        $('.mobile').text(data.message.mobile);
        $('.totallimit').text(parseInt(data.message.totalLimit));
        $('.usedlimit').text(parseInt(data.message.usedLimit));
        $('.remainlimit').text(parseInt(data.message.totalLimit) - parseInt(data.message.usedLimit));
        $('[name="mobile"]').val(data.message.mobile);
        $('[name="name"]').val(data.message.firstname);
        $('#rname').val(data.message.firstname);
        $('#rlimit').val(parseInt(data.message.totalLimit) - parseInt(data.message.usedLimit));
        $('.userdetails').fadeIn('400');
    }

    function setBeneData(data) {
        if (data.message.beneList.length > 0) {
            out = ``;
            $.each(data.message.beneList, function(index, beneficiary) {
                out += `<tr>
                        <td>` + beneficiary.beneFName + beneficiary.beneLName + `</td>
                        <td>` + beneficiary.beneAccountNo + ` <br> (` + beneficiary.beneIfsc + `)<br> ( ` + beneficiary.bankName + ` )</td>
                        <td>`;
                // if (beneficiary.beneStatus == "V" || beneficiary.beneStatus == "NV") {
                if (beneficiary.isaccountverify == "1") {
                    out += `<button class="btn btn-primary btn-sm" onclick="sendMoney('` + data.message.mobile + `','` + data.message.firstName + `','` + beneficiary.beneBankId + `', '` + beneficiary.beneAccountNo + `', '` + beneficiary.beneIfsc + `', '` + beneficiary.beneFName + `', '` + beneficiary.beneMobile + `', '` + beneficiary.bankName + `')"><i class="fa fa-paper-plane"></i> Send</button>`;
                    out += `<button type="button" class="btn btn-danger ms-2 btn-sm" onclick="deleteBene(` + beneficiary.id + `)"> Delete</button>`;
                }

                if (beneficiary.isaccountverify == "0") {
                    out += `<button class="btn btn-info btn-sm legitRipple" onclick="getName('` + data.message.mobile + `','` + data.message.firstName + `','` + beneficiary.bankName + `', '` + beneficiary.beneAccountNo + `','` + beneficiary.beneIfsc + `','` + beneficiary.beneFName + `', '` + beneficiary.beneLName + `', '` + beneficiary.beneMobile + `','accountverification')"><i class="fa fa-check"></i> Verify</button>`;
                    out += `<button type="button" class="btn btn-danger ms-2 btn-sm" onclick="deleteBene(` + beneficiary.id + `)"> Delete</button>`;
                }
                out += `</td>
                    </tr>`;
            });
            $('.transaction').find('tbody').html(out);
        } else {
            $('.transaction').find('tbody').html('');
        }
    }

    function getName(mobile, name, beneBank, beneAccountNo, beneIfsc, beneFName, beneLName, beneMobile, type) {
        var form = $('#beneficiaryForm');
        $.ajax({
            url: "<?php echo e(route('payoutTransaction')); ?>",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            data: {
                'type': "accountverification",
                'mobile': mobile,
                "beneAccountNo": beneAccountNo,
                "beneIfsc": beneIfsc,
                "name": name,
                "beneBank": beneBank,
                "beneFName": beneFName,
                "beneLName": beneLName,
                "beneMobile": beneMobile
            },
            beforeSubmit: function() {
                form.find('#getBenename').html('Please wait...').attr('disabled', true).addClass('btn-secondary');
            },
            success: function(data) {
                form.find('#getBenename').html('Get Name').attr('disabled', false).removeClass('btn-secondary');
                if (data.statuscode == "TXN") {
                    if (type == "add") {
                        $("#beneficiaryForm").find('.fullname').html(`<p class="mt-3 mx-5 p-3 fullname" style="background: #ede9e1;color: #42cc42;"><b>Account Holder Name: </b> ${data.message}</p>`);
                        $("#beneficiaryForm").find('.fullname').blur();
                        // $("#beneficiaryForm").find('input[name="beneFName"]').val(data.message);
                        // $("#beneficiaryForm").find('input[name="beneFName"]').blur();
                        // $("#beneficiaryForm").find('input[name="beneLName"]').val(data.message);
                        // $("#beneficiaryForm").find('input[name="beneLName"]').blur();
                        notify("Success! Account details found", 'success', "inline", $("#beneficiaryForm"));
                    } else{
                        // swal(
                        //     'Account Verified',
                        //     "Account Name is - ",
                        //     'success',5000
                        // );
                        notify(`Account Verified !<br/> Account Name is:  ${data.message} || ${data.status}`,'success');   
                    }
                }else if (data.statuscode == "IWB") {
                    notify(data.message || data.status, 'warning');
                } else if (data.statuscode == "ERR"){
                    notify(data.status || data.message, 'warning');
                } else if (data.statuscode == "TXR"){
                    notify(data.status || data.message, 'error');
                }else{
                    if (type == "add") {
                        notify(data.message, 'error', "inline", $("#beneficiaryForm"));
                    } else {
                        notify(data.status || data.message, 'error')
                    }
                }
            },
            error: function(errors) {
                // swal.close();
                form.find('#getBenename').html('Get Name').attr('disabled', false).removeClass('btn-secondary');
           
                // showError(errors, 'withoutform');
                notify(errors.responseJSON, 'warning');
            }
        });
        // swal({
        //     title: 'Are you sure ?',
        //     text: "You want verify account details, it will charge.",
        //     type: 'warning',
        //     showCancelButton: true,
        //     confirmButtonText: "Yes Verify",
        //     showLoaderOnConfirm: true,
        //     allowOutsideClick: () => !swal.isLoading(),
        //     preConfirm: () => {
        //         return new Promise((resolve) => {
        // $.ajax({
        //     url: "<?php echo e(route('payoutTransaction')); ?>",
        //     type: "POST",
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     },
        //     dataType: 'json',
        //     data: {
        //         'type': "accountverification",
        //         'mobile': mobile,
        //         "beneAccountNo": beneAccountNo,
        //         "beneIfsc": beneIfsc,
        //         "name": name,
        //         "beneBank": beneBank,
        //         "beneFName": beneFName,
        //         "beneLName": beneLName,
        //         "beneMobile": beneMobile
        //     },
        //     success: function(data) {
        //         swal.close();
        //         if (data.statuscode == "IWB") {
        //             notify(data.message, 'warning');
        //         } else if (data.statuscode == "TXN") {
        //             if (type == "add") {
        //                 $("#beneficiaryForm").find('.fullname').html(data.message);
        //                 $("#beneficiaryForm").find('.fullname').blur();
        //                 // $("#beneficiaryForm").find('input[name="beneFName"]').val(data.message);
        //                 // $("#beneficiaryForm").find('input[name="beneFName"]').blur();
        //                 // $("#beneficiaryForm").find('input[name="beneLName"]').val(data.message);
        //                 // $("#beneficiaryForm").find('input[name="beneLName"]').blur();
        //                 notify("Success! Account details found", 'success', "inline", $("#beneficiaryForm"));
        //             } else {
        //                 swal(
        //                     'Account Verified',
        //                     "Account Name is - " + data.data.beneFName + data.data.beneLName,
        //                     'success'
        //                 );
        //             }
        //         } else {
        //             if (type == "add") {
        //                 notify(data.message, 'error', "inline", $("#beneficiaryForm"));
        //             } else {
        //                 swal('Oops!', data.message, 'error');
        //             }
        //         }
        //     },
        //     error: function(errors) {
        //         swal.close();
        //         // showError(errors, 'withoutform');
        //         notify(errors.responseJSON, 'warning');
        //     }
        // });
        //         });
        //     },
        // });
    }

    function sendMoney(mobile, name, beneBank, beneAccountNo, beneIfsc, beneName, beneMobile, bankname) {
        $('#transferForm').find('input[name="mobile"]').val(mobile);
        $('#transferForm').find('input[name="name"]').val(name);
        $('#transferForm').find('input[name="beneBank"]').val(beneBank);
        $('#transferForm').find('input[name="beneAccount"]').val(beneAccountNo);
        $('#transferForm').find('input[name="beneIfsc"]').val(beneIfsc);
        $('#transferForm').find('input[name="beneName"]').val(beneName);
        $('#transferForm').find('input[name="beneMobile"]').val(beneMobile);

        $('#transferForm').find('.benename').text(beneName);
        $('#transferForm').find('.beneAccountNo').text(beneAccountNo);
        $('#transferForm').find('.beneIfsc').text(beneIfsc);
        $('#transferForm').find('.beneBank').text(bankname);
        $('#transferModal').modal('show');
    }

    function otpVerify(mobile, beneAccountNo, beneMobile) {
        $.ajax({
            url: "<?php echo e(route('payoutTransaction')); ?>",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            data: {
                'mobile': mobile,
                'type': "otp"
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
            success: function(result) {
                swal.close();
                if (result.statuscode == "TXN") {
                    $('#otpModal').find("[name='mobile']").val(mobile);
                    $('#otpModal').find("[name='beneAccountNo']").val(beneAccountNo);
                    $('#otpModal').find("[name='beneMobile']").val(beneMobile);
                    $('#otpModal').modal('show');
                } else {
                    notify(data.message, 'error');
                }
            },
            error: function(error) {
                swal.close();
                notify("Something went wrong", 'error');
            }
        });
    }

    function OTPRESEND() {
        var mobile = "<?php echo e(Auth::user()->mobile); ?>";
        if (mobile.length > 0) {
            $.ajax({
                    url: '<?php echo e(route("gettxnotp")); ?>',
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'mobile': mobile
                    },
                    beforeSend: function() {
                        swal({
                            title: 'Wait!',
                            text: 'Please wait, we are working on your request',
                            onOpen: () => {
                                swal.showLoading()
                            }
                        });
                    },
                    complete: function() {
                        swal.close();
                    }
                })
                .done(function(data) {
                    if (data.status == "TXN") {
                        notify("Otp sent successfully", 'success');
                    } else {
                        notify(data.message, 'warning');
                    }
                })
                .fail(function() {
                    notify("Something went wrong, try again", 'warning');
                });
        } else {
            notify("Enter your registered mobile number", 'warning');
        }
    }

    function deleteBene(id) {
        //console.log(data);
        swal({
            title: 'Are you sure ?',
            text: "You want to logout this user from application",
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: 'Yes delete it!',
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !swal.isLoading(),
            preConfirm: () => {
                return new Promise((resolve) => {
                    $.ajax({
                        url: "<?php echo e(route('beneDelete')); ?>",
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        data: {
                            'id': id
                        },
                        success: function(result) {

                            resolve(result);
                        },
                        error: function(error) {

                            resolve(error);
                        }
                    });
                });
            },
        }).then((result) => {
            console.log(result);
            if (result.value.statuscode == "TXN") {
                $("#serachForm").submit();
                notify("Benefecery Deleted Successfully", 'success');

            } else {
                notify('Something went wrong, try again', 'error');
            }

        });
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.quick2pay.in/resources/views/service/xpayout.blade.php ENDPATH**/ ?>