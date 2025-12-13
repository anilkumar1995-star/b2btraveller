<?php $__env->startSection('title', "Payout"); ?>
<?php $__env->startSection('pagetitle', "Payout"); ?>
<?php
    $table = "yes";
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
        <div class="col-sm-4">
            <div class="card card-default">

                <form id="serachForm" action="<?php echo e(route('upitransfer')); ?>" method="post">
                    <?php echo e(csrf_field()); ?>

                    <input type="hidden" name="type" value="verification">
                    <input type="hidden" id="rname">
                    <input type="hidden" id="rlimit">
                    <div class="card-body">
                         <h4 class="card-title"><?php echo e(ucfirst($type)); ?> Transfer</h4>
                        <div class="form-group no-margin-bottom">
                            <label>Mobile Number</label> 
                            <input type="number" step="any" name="mobile" class="form-control" placeholder="Enter Mobile Number" required="">
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary" data-loading-text="<b><i class='fa fa-spin fa-spinner'></i></b> Searching"><b><i class="icon-search4"></i></b> Search</button>
                    </div>
                </form>
            </div>
           <br>
            <div class="card userdetails" style="display:none">
                <div class="card-body">
                    <h5 class="content-group no-margin">
                        <span class="label label-flat label-rounded label-icon border-grey text-grey mr-10">
                            <i class="icon-user"></i>
                        </span>
                        <a href="javascript:void(0)" class="text-default name"></a>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <h6 class="text-semibold no-margin-top mobile"></h6>
                            <!--<ul class="list list-unstyled">-->
                            <!--    <li>Used Limit : <i class="fa fa-inr"></i> <span class="usedlimit"></span></li>-->
                            <!--</ul>-->
                        </div>

                        <div class="col-sm-6">
                            <h6 class="text-semibold text-right no-margin-top">Total Limit : <i class="fa fa-inr"></i> <span class="totallimit"></span></h6>
                            <!--<ul class="list list-unstyled text-right">-->
                            <!--    <li>Remain Limit: <i class="fa fa-inr"></i> <span class="text-semibold remainlimit"></span></li>-->
                            <!--</ul>-->
                        </div>
                    </div>
                </div>
                <hr class="no-margin">
                <div class="card-footer text-center alpha-grey">
                     <button
                          type="button"
                          class="btn btn-primary"
                          data-bs-toggle="modal"
                          data-bs-target="#beneficiaryModal">
                            New Beneficiary
                        </button>
                </div>
            </div> 
        </div>
        <div class="col-sm-8">
            <div class="card card-default">
              
                <div class="card-body">
                      <h4 class="card-title">Beneficiary List</h4>
                    <table class="table table-bordered table-bordered transaction" cellspacing="0" width="100%">
                            <thead>
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
<div id="beneficiaryModal" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false">
    <div class="modal-dialog">
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-slate">
                <h4 class="modal-title pull-left">Beneficiary Details Please</h4>
                <button type="button"   class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('upitransfer')); ?>" method="post" id="beneficiaryForm">
                <div class="modal-body">
                    <?php echo e(csrf_field()); ?>

                    <input type="hidden" name="rid">
                    <input type="hidden" name="type" value="addbeneficiary">
                    <input type="hidden" name="mobile">
                    <input type="hidden" name="name">
                    <input type="hidden" name="benemobile">
                   
                    <div class="row">
                        
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="phone">UPI</label>
                                <input type="text" class="form-control" id="account" name="beneaccount" placeholder="Enter UPI ID" required="">
                            </div>
                        </div>
                        
                         <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="phone">Beneficiary Mobile:</label>
                                <input type="text" class="form-control" name="benemobile" placeholder="Beneficiary Mobile No" required="">
                                <p></p>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="phone">Beneficiary First Name:</label>
                                <input type="text" class="form-control" name="benename" placeholder="Beneficiary First Name" required="">
                                <p></p>
                            </div>
                        </div>
                        
                         <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="phone">Beneficiary Last Name:</label>
                                <input type="text" class="form-control" name="benenamelast" placeholder="Beneficiary Last Name" required="">
                                <p></p>
                            </div>
                        </div>
                        
                        
                         <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="phone">Beneficiary Email:</label>
                                <input type="text" class="form-control" name="benemail" placeholder="Beneficiary email" required="">
                                <p></p>
                            </div>
                        </div>
                        
                        
                        
                    </div>
                    <div class="row">
                       
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary legitRipple" type="button" id="getBenename">Get Name</button>
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"> Close     </button>
                    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>         
                </div>             

            </form>
        </div>
    </div>
</div>

<div id="otpModal" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-slate">
                <h4 class="modal-title pull-left">Otp Verification</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="<?php echo e(route('upitransfer')); ?>" method="post" id="otpForm">
                <?php echo e(csrf_field()); ?>

                <div class="modal-body">
                    <input type="hidden" name="type" value="beneverify">
                    <input type="hidden" name="mobile">
                    <input type="hidden" name="beneaccount">
                    <input type="hidden" name="benemobile">
                    <div class="form-group">
                        <label>OTP</label>
                        <input type="text" class="form-control" name="otp" placeholder="enter otp" required>
                        <a href="javascript:void(0)" class="pull-right resendOtp" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Sending" type="resendOtpVerification"><i class='fa fa-paper-plane'></i> Resend Otp</a>
                    </div>
                </div>
                <div class="modal-footer">
                     <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"> Close   </button>
                    <button class="btn bg-slate btn-raised legitRipple" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="transferModal" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-slate">
                <h4 class="modal-title">Transfer Money</h4>
                  <button type="button"   class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('upitransfer')); ?>" method="post" id="transferForm">
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="type" value="transfer">
                <input type="hidden" name="mobile">
                <input type="hidden" name="name">
                <input type="hidden" name="benename">
                <input type="hidden" name="beneaccount">
                <input type="hidden" name="benebank">
                <input type="hidden" name="beneifsc">
                <input type="hidden" name="benemobile">
              <input type="hidden" name="contectid">
                <input type="hidden" name="payoutapi" value="<?php echo e($type); ?>">
                <div class="modal-body">
                    <div class="panel border-left-lg border-left-success invoice-grid timeline-content">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <h6 class="text-semibold no-margin-top ">Name - <span class="benename"></span></h6>
                                   
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <h6 class="text-semibold text-right no-margin-top">Acc - <span class="beneaccount"></span></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                           <div class="form-group col-md-6 mb-3">
                            <label>Transfer Mode</label>
                            <select name="mode" class="form-control">
                                <option value="UPI">UPI</option>
                               
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Amount</label>
                                <input type="number" class="form-control" placeholder="Enter amount to be transfer" name="amount" step="any" required>
                            </div>
                        </div>
                         <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label>T-Pin</label>
                            <input type="password" name="pin" class="form-control" placeholder="Enter transaction pin" required="">
                            <a href="<?php echo e(url('profile/view?tab=pinChange')); ?>" target="_blank" class="text-primary pull-right">Generate Or Forgot Pin??</a>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                     <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"> Close     </button>
                    <button class="btn bg-slate btn-raised legitRipple" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
                </div>
            </form>
        </div>
    
    </div>
</div>

<div id="receipt" class="modal fade" data-backdrop="false" data-keyboard="false">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-slate">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Receipt</h4>
            </div>
            <div class="modal-body">
                <ul class="list-group transactionData p-0">
                </ul>
                <div id="receptTable">
                    <div class="clearfix">
                        <div class="text-center">
                             <img src="https://images.incomeowl.in/incomeowl/b2b/images/logos1_250102105839191.jpg" class=" img-responsive" alt="" style="width: 260px;height: 56px;">
                            <h4>Money Transfer Receipt</h4>
                        </div>
                    </div>
                    <hr class="m-t-10 m-b-10">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <h4>Transaction Details :</h4>
                                <table class="table m-t-10">
                                    <tbody>
                                        <tr>
                                            <th>Status</th>
                                            <td class="status"></td>
                                       </tr>   
                                        <tr>
                                            <th>Transaction Date</th>
                                            <td class="created_at"></td>
                                       </tr>   
                                       <tr>
                                            <th>Sender Mobile</th>
                                            <td class="mobile"></td>
                                       </tr>  
                                    
                                        <tr>
                                            <th>Transaction Id</th>
                                            <td class="txnid"></td>
                                       </tr> 
                                        <tr>
                                            <th>Transaction Mode</th>
                                            <td class="mode">UPI</td>
                                       </tr> 
                                       <tr>
                                            <th>Pay Id</th>
                                            <td class="payid"></td>
                                       </tr> 
                                       <tr>
                                            <th>Bank UTR</th>
                                            <td class="refno"></td>
                                       </tr> 
                                        <tr>
                                            <th>Amount</th>
                                            <td class="amount"></td>
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
                    <p>* As per RBI guideline, maximum charges allowed is 1.2%.</p>
                    <hr>
                </div>
            </div>
            <div class="modal-footer">
                 <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"> Close     </button>
                <button class="btn bg-slate btn-raised legitRipple" type="button" id="print"><i class="fa fa-print"></i></button>
            </div>
        </div>
    </div>
</div>

<div id="registrationModal" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-slate">
                <h4 class="modal-title pull-left">Member Registration</h4>
                 <button type="button"   class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('upitransfer')); ?>" method="post" id="registrationForm">
                <?php echo e(csrf_field()); ?>

                <div class="modal-body">
                    <input type="hidden" name="type" value="registration">
                    <input type="hidden" name="mobile">
                      <input type="hidden" class="form-control" name="pincode" value="222222">
                    <div  class="row">
                        <div class="form-group col-md-6">
                            <label>First Name</label>
                            <input type="text" class="form-control" name="fname" required="" placeholder="Enter First name">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="lname" required="" placeholder="Enter Last name">
                        </div>
                    </div>
                    <div  class="row">
                         <div class="form-group">
                            <label>Otp</label>
                            <input type="password" name="otp" class="form-control" placeholder="Enter transaction pin" required="">
                            <!--<a href="<?php echo e(url('profile/view?tab=pinChange')); ?>" target="_blank" class="text-primary pull-right">Generate Or Forgot Pin??</a>-->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"> Close     </button>
                    <button class="btn bg-slate btn-raised legitRipple" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
                </div>
            </form>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script src="<?php echo e(asset('/assets/js/core/jQuery.print.js')); ?>"></script>
<script type="text/javascript">
    $(document).ready(function () {
        
        
        $("[name='mobile']").keyup(function(){
            $( "#serachForm" ).submit();
        });

        $('#print').click(function(){
            $('#receptTable').print();
        });

        $('#bank').on('change', function (e) {
            $('input[name="beneifsc"]').val($(this).find('option:selected').attr('ifsc'));
        }); 

        $('a.resendOtp').click(function(){
            var mobile = $(this).closest('form').find('input[name="mobile"]').val();
            var button = $(this);
            var form  = $(this).closest('form');
            $.ajax({
                url: "<?php echo e(route('upitransfer')); ?>",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType:'json',
                data: {'mobile':mobile, 'type':"otp"},
                beforeSend:function(){
                    swal({
                        title: 'Wait!',
                        text: 'We are processing your request.',
                        allowOutsideClick: () => !swal.isLoading(),
                        onOpen: () => {
                            swal.showLoading()
                        }
                    });
                },
                success: function(data){
                    swal.close();
                    if(result.statuscode == "TXN"){
                        notify(data.message, 'success', "inline",form);
                    }else{
                        notify(data.message, 'danger', "inline",form);
                    }
                },
                error: function(error){
                    swal.close();
                    notify("Something went wrong", 'danger', "inline",form);
                }
            });
        });

        $( "#serachForm" ).validate({
            rules: {
                mobile: {
                    required: true,
                    number : true,
                    minlength:10,
                    maxlength:10
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
            errorPlacement: function ( error, element ) {
                if ( element.prop("tagName").toLowerCase() === "select" ) {
                    error.insertAfter( element.closest( ".form-group" ).find(".select2") );
                } else {
                    error.insertAfter( element );
                }
            },
            submitHandler: function () {
                var form = $('#serachForm');
                form.ajaxSubmit({
                    dataType:'json',
                   beforeSubmit: function() {
                        form.find('button[type="submit"]').html(
                            '<span class="spinner-border me-1" role="status" aria-hidden="true"></span> Loading...'
                        ).attr(
                            'disabled', true).addClass('btn-secondary');
                    },
                    success:function(data){
                       form.find('button[type="submit"]').html('Submit').attr(
                                'disabled', false).removeClass('btn-secondary');
                        if(data.statuscode == "TXN"){
                            setVerifyData(data);
                            setBeneData(data);
                        }else if(data.statuscode == "RNF"){
                            var mobile = form.find('[name="mobile"]').val();
                            $('#registrationModal').find('[name="mobile"]').val(mobile);
                            $('#beneficiaryModal').find('[name="benemobile"]').val(mobile);
                            $('#registrationModal').modal('show');
                        }else if(data.statuscode == "TXNOTP"){
                            var type = form.find('[name="type"]').val();
                            if(type == "registration" || type == "verification"){
                                $('#otpModal').find('[name="type"]').val("registrationValidate");
                            }
                            var mobile = form.find('[name="mobile"]').val();
                            $('#otpModal').find('[name="transid"]').val(data.transid);
                            $('#otpModal').find('[name="mobile"]').val(mobile);
                            $('#otpModal').modal('show');
                        }else{
                            notify(data.message, 'danger', "inline",form);
                        }
                    },
                    error: function(errors) {
                        showError(errors, form);
                    }
                });
            }
        });

        $( "#beneficiaryForm" ).validate({
            rules: {
                benename: {
                    required: true,
                    minlength: 3
                },
                benenamelast: {
                    required: true,
                    minlength: 3
                },
                benemobile: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                beneaccount: {
                    required: true,
                   // pattern: /^[\w.\-]{2,256}@[a-zA-Z]{2,64}$/
                },
                email: {
                    required: true,
                    email: true
                }
            },
            messages: {
                benename: {
                    required: "First name is required",
                    minlength: "First name must be at least 3 characters"
                },
                benenamelast: {
                    required: "Last name is required",
                    minlength: "Last name must be at least 3 characters"
                },
                benemobile: {
                    required: "Mobile number is required",
                    digits: "Please enter a valid mobile number",
                    minlength: "Mobile number must be 10 digits",
                    maxlength: "Mobile number must be 10 digits"
                },
                beneaccount: {
                    required: "UPI ID is required",
                   // pattern: "Enter a valid UPI ID (example: name@upi)"
                },
                email: {
                    required: "Email is required",
                    email: "Enter a valid email address"
                }
            },
            errorElement: "p",
            errorPlacement: function ( error, element ) {
                if ( element.prop("tagName").toLowerCase() === "select" ) {
                    error.insertAfter( element.closest( ".form-group" ).find(".select2") );
                } else {
                    error.insertAfter( element );
                }
            },
            submitHandler: function () {
                var form = $('#beneficiaryForm');
                form.ajaxSubmit({
                    dataType:'json',
                    beforeSubmit:function(){
                        form.find('button[type="submit"]').button('loading');
                    },
                    success:function(data){
                        form.find('button[type="submit"]').button('reset');
                        if(data.statuscode == "TXN"){
                            form[0].reset();
                            form.find('select').select2().val(null).trigger('change');
                            form.closest('.modal').modal('hide');
                            notify('Beneficiary Successfully Added.', 'success');
                            $( "#serachForm" ).submit();
                        }else{
                            notify(data.message, 'danger', "inline", form);
                        }
                    },
                    error: function(errors) {
                        showError(errors, form);
                    }
                });
            }
        });

        $( "#otpForm" ).validate({
            rules: {
                otp: {
                    required: true,
                    number : true,
                },
            },
            messages: {
                otp: {
                    required: "Please enter otp number",
                    number: "Otp number should be numeric",
                }
            },
            errorElement: "p",
            errorPlacement: function ( error, element ) {
                if ( element.prop("tagName").toLowerCase() === "select" ) {
                    error.insertAfter( element.closest( ".form-group" ).find(".select2") );
                } else {
                    error.insertAfter( element );
                }
            },
            submitHandler: function () {
                var form = $('#otpForm');
                form.ajaxSubmit({
                    dataType:'json',
                    beforeSubmit:function(){
                        form.find('button[type="submit"]').button('loading');
                    },
                    success:function(data){
                        form.find('button[type="submit"]').button('reset');
                        if(data.statuscode == "TXN"){
                            var type = form.find('[name="type"]').val();
                            form[0].reset();
                            $('#otpModal').find('[name="mobile"]').val("");
                            $('#otpModal').find('[name="beneaccount"]').val("");
                            $('#otpModal').find('[name="benemobile"]').val("");
                            $('#otpModal').modal('hide');
                            if(type == "registrationValidate"){
                                notify('Member successfully registered.', 'success');
                            }else{
                                notify('Beneficiary Successfully verified.', 'success');
                            }
                            $( "#serachForm" ).submit();
                        }else{
                            notify(data.message, 'danger', "inline",form);
                        }
                    },
                    error: function(errors) {
                        showError(errors, form);
                    }
                });
            }
        });

       $( "#transferForm" ).validate({
            rules: {
                amount: {
                    required : true,
                    number   : true,
                    min      : 10
                }
            },
            messages: {
                amount: {
                    required : "Please enter amount",
                    number   : "Amount should be numeric",
                    min      : "Amount value should be greater than 10"
                }
            },
            errorElement: "p",
            errorPlacement: function ( error, element ) {
                if ( element.prop("tagName").toLowerCase() === "select" ) {
                    error.insertAfter( element.closest( ".form-group" ).find(".select2") );
                } else {
                    error.insertAfter( element );
                }
            },
            submitHandler: function () {
                var form = $('#transferForm'); 
                var amount      = form.find('[name="amount"]').val();
                var benename    = form.find('[name="benename"]').val();
                var beneaccount = form.find('[name="beneaccount"]').val();
                var benebank = form.find('[name="benebank"]').val();
                var bankname = form.find('.benebank').text();
                var beneifsc = form.find('[name="beneifsc"]').val();
                var name     = form.find('[name="name"]').val();
                var mobile   = form.find('[name="mobile"]').val();
                var rid   = form.find('[name="rid"]').val();
                var beneid   = form.find('[name="beneid"]').val();
                var mode   = form.find('[name="mode"]').val();
                var tpin  = form.find('[name="tpin"]').val();
                var pin  = form.find('[name="pin"]').val();
                var pipe  = form.find('[name="pipe"]').val();
                var benemobile = form.find('[name="benemobile"]').val();
                var payoutapi = form.find('[name="payoutapi"]').val();
                var limit1 =  $('.usedlimit').text();
                var limit2 =  $('.totallimit').text();
                var limit3 =  $('.remainlimit').text();
                var cotectid = form.find('[name="contectid"]').val(); 
                if(pipe == 'bank1'){
                      var tolimit = parseInt(limit1);
                }else if(pipe == 'bank2'){
                     var tolimit = parseInt(limit2); 
                }else{
                      var tolimit = parseInt(limit3);
                }
                
              
                var bank1_limit   = form.find('[name="bank1_limit"]').val();
                var bank2_limit  = form.find('[name="bank2_limit"]').val();
                var bank3_limit  = form.find('[name="bank3_limit"]').val();
           
                if(amount > tolimit)
                {
                  swal({
                        title: 'Oops!', 
                        text : "Please Enter Amount Below or Equal to  "+tolimit, 
                        type : 'error',
                                });     
                  return false ;              
                }
                swal({
                    title: 'Are you sure ?',
                    html: "You want transfer Rs."+amount +"<br> Name "+ benename +" <br>UPI No."+beneaccount ,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "Yes Transfer",
                    showLoaderOnConfirm: true,
                    allowOutsideClick: () => !swal.isLoading(),
                    preConfirm: () => {
                        return new Promise((resolve) => {
                            $.ajax({
                                url: "<?php echo e(route('upitransfer')); ?>",
                                type: "POST",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                dataType:'json',
                                data: {
                                    'type' : "transfer",
                                    'mobile' : mobile,
                                    "beneaccount" : beneaccount,
                                    "beneifsc" : beneifsc,
                                    "name" : name,
                                    "benebank" : benebank,
                                    "benename" : benename,
                                    'benemobile' : benemobile,
                                    "rid" : rid,
                                    "beneid" : beneid,
                                    "amount" : amount,
                                    "mode" : mode,
                                    "tpin" : tpin,
                                    "pin" : pin,
                                    "bank1_limit" : bank1_limit,
                                    "bank2_limit" : bank2_limit,
                                    "bank3_limit" : bank3_limit,
                                    "payoutapi" : payoutapi,
                                    "cotectid" : cotectid,
                                },
                                beforeSend:function(){
                                   
                                    swal({
                                        title: 'Wait!',
                                        text: 'Please wait, we are working on your request',
                                        onOpen: () => {
                                            swal.showLoading()
                                        },
                                        allowOutsideClick: () => !swal.isLoading()
                                    });
                                },
                                success: function(data){
                                    swal.close();
                                    form.find('button[type="submit"]').button('reset');
                                    form[0].reset();
                                    getbalance();
                                    form.closest('.modal').modal('hide');
                                    var samount = 0;
                                    var out ="";
                                    var tbody = '';
                                    if(data.statuscode == 'ERR' || data.status != 'success')
                                    {
                                      swal('Oops!',data.message,'error');
                                         return false;
                                    }
                                  
                                    
                                     $.each(data.txndata, function(index, values) {
                                            $("." + index).text(values);
                                        });
                                      $('#receipt').modal('show');
                                },
                                error: function(errors){
                                    swal.close();
                                    
                                    showError(errors,form);
                                }
                            });
                        });
                    },
                });
            }
        });


        $( "#registrationForm" ).validate({
            rules: {
                name: {
                    required: true,
                },
                surname: {
                    required: true,
                },
                pincode: {
                    required: true,
                    number : true,
                    minlength:6,
                    maxlength:6
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
            errorPlacement: function ( error, element ) {
                if ( element.prop("tagName").toLowerCase() === "select" ) {
                    error.insertAfter( element.closest( ".form-group" ).find(".select2") );
                } else {
                    error.insertAfter( element );
                }
            },
            submitHandler: function () {
                var form = $('#registrationForm');
                var type = form.find('input[name="type"]').val();
                form.ajaxSubmit({
                    dataType:'json',
                    beforeSubmit:function(){
                        form.find('button[type="submit"]').button('loading');
                    },
                    success:function(data){
                        form.find('button[type="submit"]').button('reset');
                        if(data.statuscode == "TXN"){
                            form.closest('.modal').modal('hide');
                            $( "#serachForm" ).submit();
                        }else{
                            notify(data.message, 'danger', "inline",form);
                        }
                    },
                    error: function(errors) {
                        showError(errors, form);
                    }
                });
            }
        });

        $('#getBenename').click(function(){
            var mobile = $(this).closest('form').find("[name='mobile']").val();
            var name = $(this).closest('form').find("[name='name']").val();
            var benebank = $(this).closest('form').find("[name='benebank']").val();
            var beneaccount = $(this).closest('form').find("[name='beneaccount']").val();
            var beneifsc = $(this).closest('form').find("[name='beneifsc']").val();
            var benename = $(this).closest('form').find("[name='benename']").val();
            var benemobile = $(this).closest('form').find("[name='benemobile']").val();

            if(mobile != '' || name != '' || benebank != '' || beneaccount != '' || beneifsc != '' || benename != '' || benemobile != ''){
                getName(mobile, name, benebank, beneaccount, beneifsc, benename, benemobile, 'add');
            }
        });
    });

    function setVerifyData(data) {
        $('.name').text(data.message.custfirstname);
        $('.mobile').text(data.message.custmobile);
        $('.totallimit').text( parseInt(data.message.total_limit));
        $('.usedlimit').text( parseInt(data.message.used_limit) );
        $('.remainlimit').text( parseInt(data.message.total_limit) - parseInt(data.message.used_limit));
        $('[name="mobile"]').val(data.message.custmobile);
        $('[name="benemobile"]').val(data.message.custmobile);
        $('[name="name"]').val(data.message.custfirstname);
        $('#rname').val(data.message.custfirstname);
        $('#rlimit').val(parseInt(data.message.total_limit) - parseInt(data.message.used_limit));
        $('.userdetails').fadeIn('400');
    }

    function setBeneData(data) {
        if(data.message.Data.length > 0){
            out = ``;
            $.each(data.message.Data , function(index, beneficiary) {
                out += `<tr>
                        <td>`+beneficiary.benename+`</td>
                        <td>`+beneficiary.beneaccno+`</td>
                        <td>`;
                if(beneficiary.status == "V" || beneficiary.status == "NV"){
                out +=`<button class="btn btn-primary btn-sm legitRipple" onclick="sendMoney('`+data.message.custmobile+`','`+data.message.custfirstname+`','`+beneficiary.bankid+`', '`+beneficiary.beneaccno+`', '`+beneficiary.ifsc+`', '`+beneficiary.benename+`', '`+beneficiary.benemobile+`', '`+beneficiary.bankname+`','`+beneficiary.contect_id+`')"><i class="fa fa-paper-plane"></i>  Send</button>`;
                  out +=`<button type="button" class="btn btn-sm btn-danger btn-raised heading-btn legitRipple ml-5" onclick="deleteBene(`+beneficiary.id + `)"> <i class="fa fa-trash"></i></button>`;
                }
                
                if(beneficiary.status == "NV"){
                  //  out +=`<button class="btn btn-info btn-xs legitRipple" onclick="otpVerify('`+data.message.custmobile+`', '`+beneficiary.beneaccno+`', '`+beneficiary.benemobile+`')"><i class="fa fa-check"></i> Verify</button>`;
                }
                out +=`</td>
                    </tr>`;
            });
            $('.transaction').find('tbody').html(out);
        }else{
            $('.transaction').find('tbody').html('');
        }
    }

    function getName(mobile, name, benebank, beneaccount, beneifsc, benename, benemobile,type) {
        swal({
            title: 'Are you sure ?',
            text: "You want verify UPI ID, it will charge.",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: "Yes Verify",
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !swal.isLoading(),
            preConfirm: () => {
                return new Promise((resolve) => {
                    $.ajax({
                        url: "<?php echo e(route('upitransfer')); ?>",
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType:'json',
                        data: {
                            'type':"accountverification",
                            'mobile':mobile,
                            "beneaccount":beneaccount,
                            "beneifsc":beneifsc,
                            "name":name,
                            "benebank":benebank,
                            "benename":benename,
                            "benemobile":benemobile
                        },
                        success: function(data){
                            swal.close();
                            if(data.statuscode == "IWB"){
                                 swal('Oops!', data.message,'error');
                               // notify(data.message , 'warning');
                            }else if (data.statuscode == "TXN") {
                                if(type == "add"){
                                    $( "#beneficiaryForm" ).find('input[name="benename"]').val(data.message);
                                     $( "#beneficiaryForm" ).find('input[name="benenamelast"]').val(data.message2);
                                    $( "#beneficiaryForm" ).find('input[name="benename"]').blur();
                                     swal(
                                        'UPI Verified',
                                        "Custome Name is - "+ data.message +' '+data.message2,
                                        'success'
                                    );
                                  //  notify("UPI Verified", 'success', "inline", $( "#beneficiaryForm" ));
                                }else{
                                    swal(
                                        'UPI Verified',
                                        "Account Name is - "+ data.message,
                                        'success'
                                    );
                                }
                            }else {
                               //  swal('Oops!', data.message,'error');
                                  swal(
                                        'Oops!',
                                         data.message,
                                        'error'
                                    );
                                // if(type == "add"){
                                //     notify(data.message, 'danger', "inline", $( "#beneficiaryForm" ));
                                // }else{
                                //     swal('Oops!', data.message,'error');
                                // }
                            }
                        },
                        error: function(errors){
                            swal.close();
                            showError(errors, 'withoutform');
                        }
                    });
                });
            },
        });
    }

    function sendMoney(mobile, name, benebank, beneaccount, beneifsc, benename, benemobile, bankname,contectid) {
        $('#transferForm').find('input[name="mobile"]').val(mobile);
        $('#transferForm').find('input[name="name"]').val(name);
        $('#transferForm').find('input[name="benebank"]').val(benebank);
        $('#transferForm').find('input[name="beneaccount"]').val(beneaccount);
        $('#transferForm').find('input[name="beneifsc"]').val(beneifsc);
        $('#transferForm').find('input[name="benename"]').val(benename);
        $('#transferForm').find('input[name="benemobile"]').val(benemobile);
         $('#transferForm').find('input[name="contectid"]').val(contectid);

        $('#transferForm').find('.benename').text(benename);
        $('#transferForm').find('.beneaccount').text(beneaccount);
        $('#transferForm').find('.beneifsc').text(beneifsc);
        $('#transferForm').find('.benebank').text(bankname);
        $('#transferModal').modal('show');
    }

    function otpVerify(mobile, beneaccount, benemobile){
        $.ajax({
                url: "<?php echo e(route('dmtxpay')); ?>",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType:'json',
                data: {'mobile':mobile, 'type':"otp"},
                beforeSend:function(){
                    swal({
                        title: 'Wait!',
                        text: 'We are processing your request.',
                        allowOutsideClick: () => !swal.isLoading(),
                        onOpen: () => {
                            swal.showLoading()
                        }
                    });
                },
                success: function(result){
                    swal.close();
                    if(result.statuscode == "TXN"){
                        $('#otpModal').find("[name='mobile']").val(mobile);
                        $('#otpModal').find("[name='beneaccount']").val(beneaccount);
                        $('#otpModal').find("[name='benemobile']").val(benemobile);
                        $('#otpModal').modal('show');
                    }else{
                        notify(data.message, 'danger', "inline",form);
                    }
                },
                error: function(error){
                    swal.close();
                    notify("Something went wrong", 'danger', "inline",form);
                }
            });
    }
  function OTPRESEND() {
            var mobile = "<?php echo e(Auth::user()->mobile); ?>";
            if(mobile.length > 0){
                $.ajax({
                    url: '<?php echo e(route("gettxnotp")); ?>',
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data :  {'mobile' : mobile},
                    beforeSend:function(){
                        swal({
                            title: 'Wait!',
                            text: 'Please wait, we are working on your request',
                            onOpen: () => {
                                swal.showLoading()
                            }
                        });
                    },
                    complete: function(){
                        swal.close();
                    }
                })
                .done(function(data) {
                    if(data.status == "TXN"){
                        notify("Otp sent successfully" , 'success');
                    }else{
                        notify(data.message , 'warning');
                    }
                })
                .fail(function() {
                    notify("Something went wrong, try again", 'warning');
                });
            }else{
                notify("Enter your registered mobile number", 'warning');
            }
        }
          function deleteBene(id) {
            //console.log(data);
            swal({
                title: 'Are you sure ?',
                text: "You want to delete this UPI Id ",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: 'Yes delete it!',
                showLoaderOnConfirm: true,
                allowOutsideClick: () => !swal.isLoading(),
                preConfirm: () => {
                    return new Promise((resolve) => {
                        $.ajax({
                            url: "<?php echo e(route('upibeneDelete')); ?>",
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

                if (result.value.status == "1") {
                    $("#serachForm").submit();
                    notify("Benefecery Deleted Successfully", 'success');

                } else {
                    notify('Something went wrong, try again', 'Oops', 'error');
                }

            });
        }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.ismartpay.in/resources/views/service/upi.blade.php ENDPATH**/ ?>