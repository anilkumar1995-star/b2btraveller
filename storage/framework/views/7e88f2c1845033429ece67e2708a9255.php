
<?php $__env->startSection('title', 'Money Transfer'); ?>
<?php $__env->startSection('pagetitle', 'Money Transfer'); ?>
<?php
    $table = 'yes';
?>

<?php $__env->startSection('content'); ?>
<style>
    .swal2-shown{
        overflow-y: auto;
        z-index: 9999;
    }
</style>
    <div class="content">
        <div class="row">
            <?php if(!empty($agent) && $agent->status == 'success'): ?>
            
                <?php if(empty($agent->ipay_outlet_id)): ?>
                 <div class="col-sm-4">
                    <div class="card mb-3">
    
                        <div class="card-body">
                            <h4 class="card-title">Agent Onboarding</h4>
                            <form id="agentKycForm" action="<?php echo e(route('ipaydmt1')); ?>" method="post">
                                <?php echo e(csrf_field()); ?>

                                <input type="hidden" name="type" value="agent_registration">
                                <input type="hidden" name="longitude" value="">
                                <input type="hidden" name="latitude" value="">
                                <input type="hidden" name="wadh" value="">
                                <input type="hidden" name="merchantCode" value="<?php echo e($agent->bc_id); ?>"> 
                                     <!--<input type="hidden" name="mobile" value="<?php echo e($agent->phone1); ?>"> -->
                               <div class="panel-body">
                                    <div class="form-group my-1 no-margin-bottom"> 
                                        <label>Mobile</label>
                                        <input type="number" maxlength="10"  name="mobile" class="form-control my-1"
                                            placeholder="Enter Mobile number" required="">
                                    </div>
                                </div>         
                                <div class="panel-body">
                                    <div class="form-group my-1 no-margin-bottom">
                                        <label>Aadhaar Number</label>
                                        <input type="number" maxlength="12"  name="aadhaar" class="form-control my-1"
                                            placeholder="Enter aadhaar number" required="">
                                    </div>
                                </div>
                                  <div class="panel-body">
                                    <div class="form-group my-1 no-margin-bottom">
                                        <label>Pan Number</label>
                                        <input type="text" maxlength="10" value="<?php echo e($agent->bc_pan); ?>"  name="pan" class="form-control my-1"
                                            placeholder="Enter pan " required="">
                                    </div>
                                </div>
                                  <div class="panel-body">
                                    <div class="form-group my-1 no-margin-bottom">
                                        <label>Account Number</label>
                                        <input type="number"   name="accountNo" class="form-control my-1"
                                            placeholder="Enter accountNo " required="">
                                    </div>
                                </div>
                                  <div class="panel-body">
                                    <div class="form-group my-1 no-margin-bottom">
                                        <label>IFSC </label>
                                        <input type="text"   name="ifsc" class="form-control my-1"
                                            placeholder="Enter ifsc " required="">
                                    </div>
                                </div>
                                <div class="panel-footer text-center mt-4">
                                    <button type="submit" class="btn btn-primary"
                                        data-loading-text="<b><i class='fa fa-spin fa-spinner'></i></b> Searching"><b><i
                                                class="icon-search4"></i></b> Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
 
                </div>
                <?php else: ?>
                <div class="col-sm-4">
                    <div class="card mb-3">
    
                        <div class="card-body">
                            <h4 class="card-title">Money Transfer</h4>
                            <form id="serachForm" action="<?php echo e(route('ipaydmt1')); ?>" method="post">
                                <?php echo e(csrf_field()); ?>

                                <input type="hidden" name="type" value="verification">
                                  <input type="hidden" name="remitterDetailsRef" id="remitterDetailsRef" value="">
                                
                             
                                <div class="panel-body">
                                    <div class="form-group my-1 no-margin-bottom">
                                        <label>Mobile Number</label>
                                        <input type="number" maxlength="10"  name="mobile" id="searchMobile" class="form-control my-1"
                                            placeholder="Enter Mobile Number" required="">
                                    </div>
                                </div>
                                <div class="panel-footer text-center mt-4">
                                    <button type="submit" class="btn btn-primary"
                                        data-loading-text="<b><i class='fa fa-spin fa-spinner'></i></b> Searching"><b><i
                                                class="icon-search4"></i></b> Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
    
    
    
                    <div class="card userdetails" style="display:none">
                        <div class="card-body">
    
                            <div class="row">
                                <div class="col-sm-6">
                                    <a href="javascript:void(0)" class="text-default name"></a>
                                    <h6 class="text-semibold no-margin-top mobile"></h6>
                                    <ul class="list list-unstyled">
                                        <li>Used Limit : <i class="fa fa-inr"></i> <span class="usedlimit"></span></li>
                                    </ul>
                                </div>
    
                                <div class="col-sm-6">
                                    <h6 class="text-semibold text-right no-margin-top">Total Limit : <i class="fa fa-inr"></i>
                                        <span class="totallimit"></span></h6>
                                    <ul class="list list-unstyled text-right">
                                        <li>Remain Limit: <i class="fa fa-inr"></i> <span
                                                class="text-semibold remainlimit"></span></li>
                                    </ul>
                                </div>
    
                                <div class="col-sm-12 text-center">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#beneficiaryModal"
                                        class="btn btn-primary">
                                        <i class="icon-plus22 position-left"></i>
                                        New Beneficiary
                                    </a>
                                </div>
                            </div>
    
                        </div>
    
                    </div>
                </div>
    
                <div class="col-sm-8">
    
    
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Beneficiary List</h4>
                            <div class="table-responsive">
                                <table class="table transaction">
                                    <thead class="bg-light">
                                        <th>Name</th>
                                        <th>Account Details</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
              <?php endif; ?>
            <?php else: ?>
            <div class="col-sm-4"><p>Please do digio kyc first</p></div> 
            <?php endif; ?>
        </div>

    </div>

    <div class="modal fade" id="beneficiaryModal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Beneficiary</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                       
                    </button>
                </div>
                <form action="<?php echo e(route('ipaydmt1')); ?>" method="post" id="beneficiaryForm">
                    <div class="modal-body">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="rid">
                        <input type="hidden" name="type" value="addbeneficiary">
                        <input type="hidden" name="mobile">
                        <input type="hidden" name="name">
                           <input type="hidden" name="referenceKey">
                             <input type="hidden" name="beneficiaryId">
                        <div class="row beneDetails" >
                            <div class="col-md-6">
                                <div class="form-group my-1">
                                   
                                    <label>Bank Name : </label>
                                    <select id="bank" name="benebank" class="form-control my-1">
                                        <option value="">Select Bank</option>
                                        <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($bank->bankId); ?>" ifsc="<?php echo e($bank->ifscGlobal); ?>">
                                                <?php echo e($bank->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group my-1">
                                    <label for="phone">IFSC Code:</label>
                                    <input type="text" class="form-control my-1" name="beneifsc"
                                        placeholder="Bank ifsc code" required="">
                                </div>
                            </div>
                        </div>
                        <div class="row beneDetails">
                            <div class="col-md-6">
                                <div class="form-group my-1">
                                    <label for="phone">Bank Account No.:</label>
                                    <input type="text" class="form-control my-1" id="account" name="beneaccount"
                                        placeholder="Enter account no." required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group my-1">
                                    <label for="phone">Beneficiary Mobile:</label>
                                    <input type="text" class="form-control my-1" name="benemobile"
                                        placeholder="Enter name" required="">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                        <div class="row beneDetails">
                            <div class="col-md-6">
                                <div class="form-group my-1">
                                    <label for="phone">Beneficiary Name:</label>
                                    <input type="text" class="form-control my-1" name="benename"
                                        placeholder="Enter name" required="">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                         <div class="row beneOTPDetails" style="display:none">
                            <div class="col-md-6">
                                <div class="form-group my-1">
                                    <label for="otp">OTP:</label>
                                    <input type="number" class="form-control my-1" name="otp"
                                        placeholder="Enter otp" required="">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-warning text-white" type="button" id="getBenename">Get Name</button>
                        <button class="btn btn-primary " type="submit"
                            data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="otpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">OTP Verification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                       
                    </button>
                </div>
                <form action="<?php echo e(route('dmt1pay')); ?>" method="post" id="otpForm">
                    <?php echo e(csrf_field()); ?>

                    <div class="modal-body">
                        <input type="hidden" name="type" value="beneverify">
                        <input type="hidden" name="mobile">
                        <input type="hidden" name="beneaccount">
                        <input type="hidden" name="benemobile">
                        <div class="form-group my-1">
                            <label>OTP</label>
                            <input type="text" class="form-control my-1" name="otp" placeholder="enter otp"
                                required>
                            <a href="javascript:void(0)" class="pull-right resendOtp"
                                data-loading-text="<i class='fa fa-spinner fa-spin'></i> Sending"
                                type="resendOtpVerification"><i class='fa fa-paper-plane'></i> Resend Otp</a>
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

  <div class="modal fade" id="otpModalAgent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabels"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabels">Agent OTP Verification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                       
                    </button>
                </div>
                <form action="<?php echo e(route('ipaydmt1')); ?>" method="post" id="otpFormAgent">
                    <?php echo e(csrf_field()); ?>

                    <div class="modal-body">
                        <input type="hidden" name="type" value="agent_otp">
                      
                        <input type="hidden" name="otpReference">
                        <input type="hidden" name="hash">
                        <div class="form-group my-1">
                            <label>OTP</label>
                            <input type="text" class="form-control my-1" name="otp" placeholder="enter otp"
                                required>
                           
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

    <div class="modal fade" id="transferModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Send Money</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                       
                    </button>
                </div>
                <form action="<?php echo e(route('ipaydmt1')); ?>" method="post" id="transferForm">
                    <?php echo e(csrf_field()); ?>

                    <input type="hidden" name="type" value="transfer_otp">
                    <input type="hidden" name="mobile">
                    <input type="hidden" name="name">
                    <input type="hidden" name="benename">
                    <input type="hidden" name="beneaccount">
                    <input type="hidden" name="benebank">
                    <input type="hidden" name="beneifsc">
                    <input type="hidden" name="benemobile">
                    <input type="hidden" name="referenceKey">
                    <input type="hidden" name="referenceNewKey">
                    <input type="hidden" name="latitude">
                    <input type="hidden" name="longitude">
                      
                    <div class="modal-body">
                        <div class="panel border-left-lg border-left-success invoice-grid timeline-content">
                            <div class="panel-body">
                                <div class="row sendMoney" style="display:none">
                                    <div class="col-sm-6">
                                        <h6 class="text-semibold no-margin-top ">Name - <span class="benename"></span>
                                        </h6>
                                        <ul class="list list-unstyled">
                                            <li>Bank - <span class="benebank"></span></li>
                                        </ul>
                                    </div>

                                    <div class="col-sm-6">
                                        <h6 class="text-semibold text-right no-margin-top">Acc - <span
                                                class="beneaccount"></span></h6>
                                        <ul class="list list-unstyled text-right">
                                            <li>Ifsc - <span class="beneifsc"></span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group my-1">
                                    <label>Amount</label>
                                    <input type="number" class="form-control my-1"
                                        placeholder="Enter amount to be transfer" name="amount" step="any" required/>
                                </div>
                            </div>
                            <div class="col-md-12 transferOtp" style="display:none">
                                <div class="form-group my-1">
                                    <label>OTP</label>
                                    <input type="number" class="form-control my-1"
                                        placeholder="Enter otp" name="transfer_otp"  />
                                </div>
                            </div>
                            <div class="form-group my-1 col-md-12">
                                <label>T-Pin</label>
                                <input type="password" name="pin" class="form-control my-1"
                                    placeholder="Enter transaction pin" required="">
                                <a href="<?php echo e(url('profile/view?tab=pinChange')); ?>" target="_blank"
                                    class="text-primary pull-right">Generate Or Forgot Pin??</a>
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


    <div class="modal fade bd-example-modal-lg" id="receipt" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Receipt</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                       
                    </button>
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
                            <div class="col-md-12">

                                <div class="pull-left m-t-10">
                                    <address class="m-b-10">
                                        Agent : <strong class="username"><?php echo e(Auth::user()->name); ?></strong><br>
                                        Shop Name : <span class="company"><?php echo e(Auth::user()->shopname); ?></span><br>
                                        Phone : <span class="mobile"><?php echo e(Auth::user()->mobile); ?></span>
                                    </address>
                                </div>
                                <div class="pull-right m-t-10">
                                    <address class="m-b-10">
                                        <strong>Date : </strong> <span
                                            class="date"><?php echo e(date('d M y - h:i A')); ?></span><br>
                                        <strong>Name : </strong> <span class="benename"></span><br>
                                        <strong>Account : </strong> <span class="beneaccount"></span><br>
                                        <strong>Bank : </strong> <span class="benebank"></span>
                                    </address>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <h4>Transaction Details :</h4>
                                    <table class="table m-t-10">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Order Id</th>
                                                <th>Amount</th>
                                                <th>UTR No.</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="id"></td>
                                                <td class="amount"></td>
                                                <td class="refno"></td>
                                                <td class="status"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="border-radius: 0px;">
                            <div class="col-md-6 col-md-offset-6">
                                <h5 class="text-right">Transfer Amount : <span class="samount"></span></h5>
                            </div>
                        </div>
                        <p>* As per RBI guideline, maximum charges allowed is 2%.</p>
                        <hr>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-secondary" type="button" id="print"><i class="fa fa-print"></i></button>
                </div>
            </div>
        </div>
    </div>

  
    <div class="modal fade" id="registrationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelRemitter"
        aria-hidden="true">
        <div class="modal-dialog" role="document"> 
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelRemitter">Remitter Registration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                       
                    </button>
                </div>
                <form action="<?php echo e(route('ipaydmt1')); ?>" method="post" id="registrationForm">
                    <?php echo e(csrf_field()); ?>

                    <div class="modal-body">
                        <input type="hidden" name="type" value="registration">
                        <input type="hidden" name="mobile">
                           <input type="hidden" name="referenceKey">
                            <input type="hidden" name="longitude">
                           <input type="hidden" name="latitude">
                            <input type="hidden" name="wadh" value="">
                              <input type="hidden" name="pid" id="pid" class="form-control"/>
                        <div class="row remitter" >
                            <div class="form-group my-1 col-md-6">
                                <label>First Name</label>
                                <input type="text" class="form-control my-1" name="fname" required=""
                                    placeholder="Enter last name">
                            </div>

                            <div class="form-group my-1 col-md-6">
                                <label>Last Name</label>
                                <input type="text" class="form-control my-1" name="lname" required=""
                                    placeholder="Enter first name">
                            </div>
                        </div>
                        <div class="row remitter">
                            <div class="form-group my-1 col-md-6">
                                <label>Pincode</label>
                                <input type="text" class="form-control my-1" name="pincode" required=""
                                    placeholder="Enter Pincode">
                            </div>
                              <div class="form-group my-1 col-md-6">
                                <label>Aadhaar No</label>
                                <input type="number" class="form-control my-1" name="aadhaar" required=""
                                    placeholder="Enter aadhaar no">
                            </div>
                            </div>
                            <div class="row remitterOtp" style="display:none">
                          

                            <div class="form-group my-1 col-md-6" >
                                <label>Otp</label>
                                <input type="text" class="form-control my-1" name="otp" required=""
                                    placeholder="Enter otp">
                               
                            </div>
                        </div>
                        
                        <div class="row selectDevice" style="display:none">
                          

                            <div class="form-group my-1 col-md-6" >
                                 <label>Device</label>
                                <select name="device" id="device" class="form-control">
                                <option value="">Select Device</option>
                                <option value="MANTRA_PROTOBUF">Mantra Device</option>
                                <option value="MORPHO_PROTOBUF">Morpho Device</option>
                            </select>
                    
                               
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

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('/assets/js/core/jQuery.print.js')); ?>"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            
             if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {

                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;
                    var longitude = $("#agentKycForm").find('[name="longitude"]').val(lng);
                    var latitude = $("#agentKycForm").find('[name="latitude"]').val(lat);
                    var longitude = $("#registrationForm").find('[name="longitude"]').val(lng);
                    var latitude = $("#registrationForm").find('[name="latitude"]').val(lat);
                    var longitude = $("#transferForm").find('[name="longitude"]').val(lng);
                    var latitude = $("#transferForm").find('[name="latitude"]').val(lat);
                })

            }
            
            
            $("[name='mobile']").keyup(function() {
                $("#serachForm").submit();
            });

            $('#print').click(function() {
                $('#receptTable').print();
            });

            $('#bank').on('change', function(e) {
                $('input[name="beneifsc"]').val($(this).find('option:selected').attr('ifsc'));
            });

            $('a.resendOtp').click(function() {
                var mobile = $(this).closest('form').find('input[name="mobile"]').val();
                var button = $(this);
                var form = $(this).closest('form');
                $.ajax({
                    url: "<?php echo e(route('dmt1pay')); ?>",
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
                        if (result.statuscode == "TXN") {
                            notify(data.message, 'success', "inline", form);
                        } else {
                            notify(data.message, 'error', "inline", form);
                        }
                    },
                    error: function(error) {
                        swal.close();
                        notify("Something went wrong", 'error', "inline", form);
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
                        minlenght: "Mobile number length should be 10 digit",
                        maxlenght: "Mobile number length should be 10 digit",
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group my-1").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('#serachForm');
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button[type="submit"]').html('Please wait...').attr('disabled',true).addClass('btn-secondary');
                        },
                        complete:function(){
                            form.find('button[type="submit"]').html('Search').attr('disabled',false).removeClass('btn-secondary');
                        },
                        success: function(data) {    
                             $('#serachForm').find('[name="wadh"]').val(data.data.wadh);
                             $('#registrationModal').find('[name="wadh"]').val(data.data.wadh); 
                            if (data.statuscode == "TXN") {
                               $('#remitterDetailsRef').val(data.data.referenceKey);
                                setVerifyData(data);
                                setBeneData(data);
                            } else if (data.statuscode == "RNF") {
                                var mobile = form.find('[name="mobile"]').val();
                                $('#registrationModal').find('[name="mobile"]').val(mobile);
                                $('#registrationModal').find('[name="referenceKey"]').val(data.data.referenceKey); 
                              
                                $('#registrationModal').modal("show");
                            } else if (data.statuscode == "TXNOTP") {
                                var type = form.find('[name="type"]').val();
                                if (type == "registration" || type == "verification") {
                                    $('#otpModal').find('[name="type"]').val(
                                        "registrationValidate");
                                }
                                var mobile = form.find('[name="mobile"]').val();
                                $('#otpModal').find('[name="transid"]').val(data.transid);
                                $('#otpModal').find('[name="mobile"]').val(mobile);
                                $('#otpModal').modal();
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

            $("#agentKycForm").validate({
                rules: {
                    aadhaar: {
                        required: true,
                        number: true,
                        minlength: 12,
                        maxlength: 12
                    },
                },
                messages: {
                    aadhaar: {
                        required: "Please enter aadhaar number",
                        number: "Aadhaar number should be numeric",
                        minlenght: "Mobile number length should be 12 digit",
                        maxlenght: "Mobile number length should be 12 digit",
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group my-1").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('#agentKycForm');
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button[type="submit"]').html('Please wait...').attr('disabled',true).addClass('btn-secondary');
                        },
                        complete:function(){
                            form.find('button[type="submit"]').html('Search').attr('disabled',false).removeClass('btn-secondary');
                        },
                        success: function(data) {    
                            if (data.statuscode == "TXN") {
                               $('#otpModalAgent').find('[name="otpReference"]').val(data.data.otpReference);
                                $('#otpModalAgent').find('[name="hash"]').val(data.data.hash);
                                $('#otpModalAgent').modal('show');
                                
                            } else if (data.statuscode == "TXR") {
                                 notify(data.message, 'error', "inline", form);
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
                        error.insertAfter(element.closest(".form-group my-1").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('#beneficiaryForm');
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button[type="submit"]').html('Please wait...').attr('disabled',true).addClass('btn-secondary');
                        },
                        complete:function(){
                            form.find('button[type="submit"]').html('Submit').attr('disabled',false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.statuscode == "TXN") {
                                  var type = form.find('[name="type"]').val();
                                if (type == 'addbeneficiary') { 
                                      $('#beneficiaryForm').find('[name="beneficiaryId"]').val(data.data.beneficiaryId);
                                      $('#beneficiaryForm').find('[name="referenceKey"]').val(data.data.referenceKey); 
                                      $('.beneDetails').css('display', 'none');
                                      $('.beneOTPDetails').css('display', 'block');
                                       form.find('[name="type"]').val('beneverify'); 
                                            notify('OTP Send successful.', 'success');
                                } else {
                                      form[0].reset();
                                      form.find('select').select2().val(null).trigger('change');
                                      form.closest('.modal').modal('hide');
                                         notify('Beneficiary added successful.', 'success');
                                }
                                 $("#serachForm").submit();
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

            $("#otpFormAgent").validate({
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
                        error.insertAfter(element.closest(".form-group my-1").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('#otpFormAgent');
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button[type="submit"]').html('Please wait...').attr('disabled',true).addClass('btn-secondary');
                        },
                        complete:function(){
                            form.find('button[type="submit"]').html('Submit').attr('disabled',false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.statuscode == "TXN") {
                                notify('Agent successfully registered.', 'success');
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
                        error.insertAfter(element.closest(".form-group my-1").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('#otpForm');
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button[type="submit"]').html('Please wait...').attr('disabled',true).addClass('btn-secondary');
                        },
                        complete:function(){
                            form.find('button[type="submit"]').html('Submit').attr('disabled',false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.statuscode == "TXN") {
                                var type = form.find('[name="type"]').val();
                                form[0].reset();
                                $('#otpModal').find('[name="mobile"]').val("");
                                $('#otpModal').find('[name="beneaccount"]').val("");
                                $('#otpModal').find('[name="benemobile"]').val("");
                                $('#otpModal').modal('hide');
                                if (type == "registrationValidate") {
                                    notify('Member successfully registered.', 'success');
                                } else {
                                    notify('Beneficiary Successfully verified.', 'success');
                                }
                                $("#serachForm").submit();
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


            $('#transferForm').submit(function(event) {
                var form = $('#transferForm');
                var amount = form.find('[name="amount"]').val();
                var benename = form.find('[name="benename"]').val();
                var beneaccount = form.find('[name="beneaccount"]').val();
                var benebank = form.find('[name="benebank"]').val();
                var bankname = form.find('.benebank').text();
                var beneifsc = form.find('[name="beneifsc"]').val();
                form.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {
                    form.find('button[type="submit"]').html('Please wait...').attr('disabled',true).addClass('btn-secondary');
                    },
                    complete:function(){
                        form.find('button[type="submit"]').html('Submit').attr('disabled',false).removeClass('btn-secondary');
                    },
                    success: function(data) {
                        
                        type = form.find('[name="type"]').val();
                        if (data.statuscode == "TXN") {
                                 if (type == 'transfer_otp') {    
                               
                                   form.find('input[name="type"]').val('transfer');
                                   form.find('input[name="referenceNewKey"]').val(data.data.referenceKey);
                                   $('.remitter').css('display', 'none');
                                   $('.sendMoney').css('display', 'block');
                                   $('.transferOtp').css('display', 'block'); 
                                 } else if(type == 'transfer') {
                                    form[0].reset();
                                    getbalance();
                                    form.closest('.modal').modal('hide');
                                    var samount = 0;
                                    var out = "";
                                    var tbody = '';
                                    $.each(data.data, function(index, val) {
                                        if (val.data.statuscode == "TXN" || val.data.statuscode ==
                                            "TUP") {
                                            samount += parseFloat(val.amount);
                                            out +=
                                                '<li class="list-group-item alert alert-success no-margin mb-10"><strong>Rs.  ' +
                                                val.amount + '</strong><span class="pull-right">' +
                                                val.data.status + '</span></li>';
                                            tbody += `
                                            <tr>
                                                <td>` + val.data.payid + `</td>
                                                <td>` + val.amount + `</td>
                                                <td>` + val.data.rrn + `</td>
                                                <td>` + val.data.status + `</td>
                                            </tr>        
                                        `;
                                        } else {
                                            out +=
                                                '<li class="list-group-item alert alert-danger no-margin mb-10"><strong>Rs.  ' +
                                                val.amount + '</strong><span class="pull-right">' +
                                                val.data.rrn + '</span></li>';
                                        }
                                    });
                                    $('.transactionData').html(out);
                                    if (samount != 0) {
                                        $('#receptTable').fadeIn('400');
                                        $('.benename').text(benename);
                                        $('.beneaccount').text(beneaccount);
                                        $('.benebank').text(bankname);
                                        $('#receptTable').find('tbody').html(tbody);
                                        $('.samount').text(parseFloat(samount));
                                    } else {
                                        $('#receptTable').fadeOut('400');
                                    }
                                    $('#receipt').modal('show');
                                 } else {
                                     notify(data.message, 'success', "inline", form);
                                 }
                               // form.closest('.modal').modal('hide');
                               // $("#serachForm").submit();
                            } else {
                                notify(data.message, 'error', "inline", form);
                            }
                      
                    },
                    error: function(errors) {
                        showError(errors, form);
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
            //             error.insertAfter( element.closest( ".form-group my-1" ).find(".select2") );
            //         } else {
            //             error.insertAfter( element );
            //         }
            //     },
            //     submitHandler: function () {
            //         var form = $('#transferForm');
            //         var amount = form.find('[name="amount"]').val();
            //         var benename = form.find('[name="benename"]').val();
            //         var beneaccount = form.find('[name="beneaccount"]').val();
            //         var benebank = form.find('[name="benebank"]').val();
            //         var bankname = form.find('.benebank').text();
            //         var beneifsc = form.find('[name="beneifsc"]').val();
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
            //                     $('.beneaccount').text(beneaccount);
            //                     $('.benebank').text(bankname);
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
                        error.insertAfter(element.closest(".form-group my-1").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                }, 
                submitHandler: function() {
                    var form = $('#registrationForm');
                    var type = form.find('input[name="type"]').val();
                    var pid = form.find('input[name="pid"]').val();
                    
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button[type="submit"]').html('Please wait...').attr('disabled',true).addClass('btn-secondary');
                        },
                        complete:function(){
                            form.find('button[type="submit"]').html('Submit').attr('disabled',false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                              form.find('input[name="pid"]').val('');
                            if (data.statuscode == "TXN") {
                                 if (type == 'registration') {    
                                   $('#exampleModalLabelRemitter').text('Remitter OTP Verify');
                                   form.find('input[name="type"]').val('remitter_otp');
                                   form.find('input[name="referenceKey"]').val(data.data.otpReference);
                                   $('.remitter').css('display', 'none');
                                   $('.remitterOtp').css('display', 'block');
                                 } else if(type == 'remitter_otp') {
                                    $('#exampleModalLabelRemitter').text('Remitter eKyc');
                                    form.find('input[name="type"]').val('remitter_kyc');
                                    form.find('input[name="referenceKey"]').val(data.data.referenceKey);
                                    $('.remitterOtp').css('display', 'none');
                                    $('.selectDevice').css('display', 'block');
                                 } else {
                                     notify(data.message, 'success', "inline", form);
                                 }
                               // form.closest('.modal').modal('hide');
                               // $("#serachForm").submit();
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

            $('#getBenename').click(function() {
                var mobile = $(this).closest('form').find("[name='mobile']").val();
                var name = $(this).closest('form').find("[name='name']").val();
                var benebank = $(this).closest('form').find("[name='benebank']").val();
                var beneaccount = $(this).closest('form').find("[name='beneaccount']").val();
                var beneifsc = $(this).closest('form').find("[name='beneifsc']").val();
                var benename = $(this).closest('form').find("[name='benename']").val();
                var benemobile = $(this).closest('form').find("[name='benemobile']").val();

                if (mobile != '' || name != '' || benebank != '' || beneaccount != '' || beneifsc != '' ||
                    benename != '' || benemobile != '') {
                    getName(mobile, name, benebank, beneaccount, beneifsc, benename, benemobile, 'add');
                }
            });
        });

        function setVerifyData(data) {
            $('.name').text(data.data.firstName+' '+data.data.lastName);
            $('.mobile').text(data.data.mobile);
            $('.totallimit').text(parseInt(data.data.limitTotal));
            $('.usedlimit').text(parseInt(data.data.limitConsumed));
            $('.remainlimit').text(parseInt(data.data.limitAvailable) - parseInt(data.data.limitConsumed));
            $('[name="mobile"]').val(data.data.mobile);
            $('[name="name"]').val(data.data.firstName+' '+data.data.lastName);
            $('#rname').val(data.data.firstName+' '+data.data.lastName);
            $('#rlimit').val(parseInt(data.data.limitTotal) - parseInt(data.data.limitConsumed));
            $('.userdetails').fadeIn('400');
        }

        function setBeneData(data) {
            if (data.data.beneficiaries.length > 0) {
                out = ``;
                $.each(data.data.beneficiaries, function(index, beneficiary) {
                    out += `<tr>
                        <td>` + beneficiary.name + `</td>
                        <td>` + beneficiary.account + ` <br> (` + beneficiary.ifsc + `)<br> ( ` + beneficiary
                        .bank + ` )</td>
                        <td>`;
                    if (beneficiary.verificationDt != "") {
                        out += `<button class="btn btn-primary" onclick="sendMoney('` + data.data.mobile +
                            `','` + data.data.firstName + `','` + beneficiary.id + `', '` + beneficiary
                            .account + `', '` + beneficiary.ifsc + `', '` + beneficiary.name + `', '` +
                            beneficiary.beneficiaryMobileNumber + `', '` + beneficiary.bank +
                            `')"><i class="fa fa-paper-plane"></i> Send</button>`;
                    }

                    if (beneficiary.verificationDt == null) {
                        // out += `<button class="btn btn-success" onclick="otpVerify('` + data.data.mobile +
                        //     `', '` + beneficiary.account + `', '` + beneficiary.beneficiaryMobileNumber +
                        //     `')"><i class="fa fa-check"></i> Verify</button>`;
                    }
                    out += `</td>
                    </tr>`;
                });
                $('.transaction').find('tbody').html(out);
            } else {
                $('.transaction').find('tbody').html('');
            }
        }

        function getName(mobile, name, benebank, beneaccount, beneifsc, benename, benemobile, type) {
            swal({
                title: 'Are you sure ?',
                text: "You want verify account details, it will charge.",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: "Yes Verify",
                showLoaderOnConfirm: true,
                allowOutsideClick: () => !swal.isLoading(),
                preConfirm: () => {
                    return new Promise((resolve) => {
                        $.ajax({
                            url: "<?php echo e(route('ipaydmt1')); ?>",
                            type: "POST",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: 'json',
                            data: {
                                'type': "accountverification",
                                'mobile': mobile,
                                "beneaccount": beneaccount,
                                "beneifsc": beneifsc,
                                "name": name,
                                "benebank": benebank,
                                "benename": benename,
                                "benemobile": benemobile
                            },
                            success: function(data) {
                                swal.close();
                                if (data.statuscode == "IWB") {
                                    notify(data.message, 'error');
                                } else if (data.statuscode == "TXN") {
                                    if (type == "add") {
                                        $("#beneficiaryForm").find('input[name="benename"]')
                                            .val(data.message);
                                        $("#beneficiaryForm").find('input[name="benename"]')
                                            .blur();
                                        notify("Success! Account details found", 'success',
                                            "inline", $("#beneficiaryForm"));
                                    } else {
                                        swal(
                                            'Account Verified',
                                            "Account Name is - " + data.data.benename,
                                            'success'
                                        );
                                    }
                                } else {
                                    if (type == "add") {
                                        notify(data.message, 'error', "inline", $(
                                            "#beneficiaryForm"));
                                    } else {
                                        swal('Oops!', data.message, 'error');
                                    }
                                }
                            },
                            error: function(errors) {
                                swal.close();
                                showError(errors, 'withoutform');
                            }
                        });
                    });
                },
            });
        }

        function sendMoney(mobile, name, benebank, beneaccount, beneifsc, benename, benemobile, bankname) {
            $('#transferForm').find('input[name="mobile"]').val(mobile);
            $('#transferForm').find('input[name="name"]').val(name);
            $('#transferForm').find('input[name="benebank"]').val(benebank);
            $('#transferForm').find('input[name="beneaccount"]').val(beneaccount);
            $('#transferForm').find('input[name="beneifsc"]').val(beneifsc);
            $('#transferForm').find('input[name="benename"]').val(benename);
            $('#transferForm').find('input[name="benemobile"]').val(benemobile);

            $('#transferForm').find('.benename').text(benename);
            $('#transferForm').find('.beneaccount').text(beneaccount);
            $('#transferForm').find('.beneifsc').text(beneifsc);
            $('#transferForm').find('.benebank').text(bankname);
            $('#transferForm').find('input[name="referenceKey"]').val($('#remitterDetailsRef').val());
            $('#transferModal').modal('show');
        }

        function otpVerify(mobile, beneaccount, benemobile) {
            $.ajax({
                url: "<?php echo e(route('dmt1pay')); ?>",
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
                        $('#otpModal').find("[name='beneaccount']").val(beneaccount);
                        $('#otpModal').find("[name='benemobile']").val(benemobile);
                        $('#otpModal').modal();
                    } else {
                        notify(data.message, 'error', "inline", form);
                    }
                },
                error: function(error) {
                    swal.close();
                    notify("Something went wrong", 'error', "inline", form);
                }
            });
        }
        
        
    $('#device').change(function() {
        var optionSelected = $(this).find("option:selected");
        var device = optionSelected.val();
        var form = $('#registrationForm');
        var wadth = form.find('[name="wadh"]').val();
        if (device != '') {
           rdservice(wadth,device, "11100", 'kyc');
        }
    });


    function rdservice(wadth,device, port, type = "none", ) {
        var primaryUrl = "http://127.0.0.1:" + port;
        // var primaryUrl = "http://localhost:"+port;

        $.ajax({
            type: "RDSERVICE",
            async: true,
            crossDomain: true,
            url: primaryUrl,
            processData: false,
            beforeSend: function() {
               notify("Search Device", 'info');
            },
            success: function(data) {
                swal.close();
                var $doc = $.parseXML(data);
                var CmbData1 = $($doc).find('RDService').attr('status');
                var CmbData2 = $($doc).find('RDService').attr('info');

                if (!CmbData1) {
                    var CmbData1 = $(data).find('RDService').attr('status');
                    var CmbData2 = $(data).find('RDService').attr('info');
                }

                if (CmbData1 == "READY") {
                    capture(device, port, type,wadth);
                } else if (port == "11100") {
                    rdservice(wadth,device, "11101", type);
                } else if (port == "11101") {
                    rdservice(wadth,device, "11102", type);
                } else if (port == "11102") {
                    rdservice(wadth,device, "11103", type);
                } else if (port == "11103") {
                    rdservice(wadth,device, "11104", type);
                } else if (port == "11104") {
                    rdservice(wadth,device, "11105", type);
                } else {
                    notify("Device : " + CmbData1, 'warning');
                }
            },
            error: function(jqXHR, ajaxOptions, thrownError) {
                swal.close();
                //$('#aepsTransactionForm').unblock();
                if (port == "11100") {
                    rdservice(wadth,device, "11101", type);
                } else if (port == "11101") {
                    rdservice(wadth,device, "11102", type);
                } else if (port == "11102") {
                    rdservice(wadth,device, "11103", type);
                } else if (port == "11103") {
                    rdservice(wadth,device, "11104", type);
                } else if (port == "11104") {
                    rdservice(wadth,device, "11105", type);
                } else {
                    notify("Oops! Device not working correctly, please try again", 'warning');
                }
            },
        });
    }

        
    function capture(device, port, type,wadth) {
        var primaryUrl = "http://127.0.0.1:" + port;
        var form = $('#registrationForm');
        var wadth = form.find('[name="wadh"]').val();
        console.log(wadth) ;
        if (device == "MORPHO_PROTOBUF") {
            var url = primaryUrl + "/capture";
        } else {
            var url = primaryUrl + "/rd/capture";
        }
        
        if (type == "kyc") {
            var XML = '<PidOptions ver=\"1.0\"><Opts env=\"P\" fCount=\"1\" fType=\"2\" iCount=\"0\" format=\"0\" pidVer=\"2.0\" timeout=\"15000\" wadh=\"'+wadth+'\" posh=\"UNKNOWN\" /></PidOptions>';
        } else {
            if (device == "MANTRA_PROTOBUF") {
                var XML = '<?php echo '<?xml version="1.0"?>'; ?> <PidOptions ver="1.0"> <Opts fCount="2" fType="2" iCount="0" pCount="0" format="0" pidVer="2.0" timeout="20000" posh="UNKNOWN" env="P" wadh=\"'+wadth+'\"/> <CustOpts><Param name="mantrakey" value="" /></CustOpts> </PidOptions>';
            } else {
                var XML = '<PidOptions ver=\"1.0\">' + '<Opts fCount=\"2\" fType=\"2\" iCount=\"\" iType=\"\" pCount=\"\" pType=\"\" format=\"0\" pidVer=\"2.0\" timeout=\"10000\" otp=\"\" wadh=\"'+wadth+'\" posh=\"\"/>' + '</PidOptions>';
            }
        }

        $.ajax({
            type: "CAPTURE",
            async: true,
            crossDomain: true,
            url: url,
            data: XML,
            contentType: "text/xml; charset=utf-8",
            processData: false,
          
            success: function(data) {
                swal.close();
                
                if (device == "MANTRA_PROTOBUF") {
                    var $doc = $.parseXML(data);
                    var errorInfo = $($doc).find('Resp').attr('errInfo');

                    if (errorInfo == 'Success.') {
                        notify("Fingerprint Captured Successfully", "success");
                          var form = $('#registrationForm');
                        if (type == "none") {
                               $('#registrationForm').find('input[name="pid"]').val(data);
                         
                           // form.submit(); 
                        } else {
                             $('#registrationForm').find('input[name="pid"]').val(data);
                            // form.submit(); 
                        }

                    } else {
                        notify("Oops! Device not working correctly, please try again", "warning");
                    }
                } else {
                    var errorInfo = $(data).find('Resp').attr('errInfo');
                    var errorCode = $(data).find('Resp').attr('errCode');
                    var mydata = $(data).find('PidData').html();
                    if (errorCode == '0') {
                        notify("Fingerprint Captured Successfully", "success");
                     var form = $('#registrationForm');
                        if (type == "none") {
                            form.find('input[name="pid"]').val("<PidData>" + mydata + "</PidData>");
                          
                          //  form.submit(); 
                        } else {
                            form.find('input[name="pid"]').val("<PidData>" + mydata + "</PidData>");
                          //  form.submit(); 

                        }
                    } else {
                        notify("Oops! Device not working correctly, please try again", "warning");
                    }
                }
            },
            error: function(jqXHR, ajaxOptions, thrownError) {
                console.log(thrownError);
                swal.close();
                notify("Oops! Device not working correctly, please try again", "warning");
            },
        });
    }
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.ismartpay.in/resources/views/service/ipaydmt.blade.php ENDPATH**/ ?>