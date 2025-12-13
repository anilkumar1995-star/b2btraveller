<?php
$name = explode(" ", Auth::user()->name);
?>


<?php $__env->startSection('title', "Payment Via Card"); ?>
<?php $__env->startSection('pagetitle', "Payment Via Card"); ?>
<?php 
$table = "yes";
?>

<?php $__env->startSection('content'); ?>
 <style>
    #payout-table table {
            border-collapse: collapse; /* Collapse borders into a single border */
            width: 100%; /* Full width of the parent */
        }
        #payout-table th, #payout-table td {
            border: 1px solid black; /* Border for table headers and cells */
            padding: 10px; /* Space inside the cells */
            text-align: left; /* Align text to the left */
        }
        #payout-table th {
            background-color: #f2f2f2; /* Light gray background for headers */
        }
    </style>
<div class="content">
    <div class="row">
        <div class="col-sm-4">
            <div class="card card-default pandetails">
                <form id="serachForm" action="<?php echo e(route('ccpayments')); ?>" method="post">
                    <?php echo e(csrf_field()); ?>

                    <input type="hidden" name="type" value="verification">
                    <input type="hidden" id="rname">
                    <input type="hidden" id="rlimit">
                    <div class="card-body">
                         <h4 class="card-title"><?php echo e(ucfirst($type)); ?> </h4>
                        <div class="form-group no-margin-bottom">
                             <label>Pan/Mobile Number </label> 
                            <input type="text" step="any" name="pancard" class="form-control" placeholder="Enter Pan/Mobile Number" required="">
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary" data-loading-text="<b><i class='fa fa-spin fa-spinner'></i></b> Searching"><b><i class="icon-search4"></i></b> Search</button>
                    </div>
                </form>
            </div>
           <br>
             <div class="card custdetails" style="display:none">
                <div class="card-body">
                    <div class="row ">
                       <div class="col-md-6">
                         <h6 class="content-group no-margin">
                         <span> Name:  <a href="javascript:void(0)" class="text-default custname">  </a></span><br>
                         <span> DOB:  <a href="javascript:void(0)" class="text-default custdob">  </a></span><br>
                         <span> Mo.:  <a href="javascript:void(0)" class="text-default custmobile">  </a></span><br>
                         <span> Email.:  <a href="javascript:void(0)" class="text-default custemail">  </a></span>
                    </h6>
                     <span> Add:  <a href="javascript:void(0)" class="text-default custadd"> </a></span>
                    </div>
                     <div class="col-md-6 col-sm-12"> <a style="float: right" href="javascript:void(0)" class="text-default"> <img id="customerimage" alt="Base64 Image" /></a></div>
                    </div>
                </div>
            
                <hr class="no-margin">
                <div class="card-footer text-center alpha-grey">
                      <button class="btn btn-primary" id="refreshButton">New Customer</button> </div>
                </div>
           <br>
            <div class="card userdetails" style="display:none">
                <div class="card-body">
                    <h5 class="content-group no-margin">
                        <span class="label label-flat label-rounded label-icon border-grey text-grey mr-10">
                            <i class="icon-user"></i>
                        </span>
                        <a href="javascript:void(0)" class="text-default name"></a>
                         <a style="float: right" href="javascript:void(0)" class="text-default mobile"></a>
                    </h5>
                    <div class="row banklist">
                     
                    </div>
                    
                </div>
            
                <hr class="no-margin">
                <div class="card-footer text-center alpha-grey">
                      <button   type="button" class="btn btn-primary"  data-bs-toggle="modal"  data-bs-target="#addbankModal">Add New Bank</button> </div>
                </div>
          
        </div>
        <div class="col-sm-8">
            <div class="card card-default">
              
                <div class="card-body">
                      <h4 class="card-title">Credit Card List
                    
                     <span style="display: none;"  id="credadd"><button style='float: right;'  type="button" class="btn btn-primary float-right"  data-bs-toggle="modal"  data-bs-target="#cardregistrationModal">   New Credit Card   </button></span> </h4>
                    <table class="table table-bordered table-bordered transaction" cellspacing="0" width="100%">
                            <thead>
                               
                                <th width="150px">Type</th>
                                <th width="250px">Card Number</th>
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

<div id="registrationModal" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-slate">
                <h4 class="modal-title pull-left">Member Registration</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="<?php echo e(route('ccpayments')); ?>" method="post" id="registrationForm">
                <?php echo e(csrf_field()); ?>

                <div class="modal-body">
                    <input type="hidden" name="type" value="registration">
                  
                  <div class="row">

                        <div class="form-group col-md-6 my-1">
                            <label>Name <span class="text-danger fw-bold">*</span></label>
                            <input type="text" class="form-control my-1" autocomplete="off" name="name" placeholder="Enter Your Firstame" value="<?php echo e(isset($name[0]) ? $name[0] : ''); ?>" required>
                        </div>
                        <div class="form-group col-md-6 my-1">
                            <label>Mobile <span class="text-danger fw-bold">*</span></label>
                            <input type="text" pattern="[0-9]*" maxlength="10" minlength="10" class="form-control my-1" name="mobile" autocomplete="off" placeholder="Enter Your Mobile" value="<?php echo e($agent->phone1 ?? Auth::user()->mobile); ?>" required>
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6 my-1">
                            <label>Pancard <span class="text-danger fw-bold">*</span></label>
                            <input type="text" class="form-control my-1" autocomplete="off" name="pancard" placeholder="Enter Your Pancard" value="" required>
                        </div>
                        <div class="form-group col-md-6 my-1">
                            <label>Email <span class="text-danger fw-bold">*</span></label>
                            <input type="email" class="form-control my-1" autocomplete="off" name="emailid" placeholder="Enter Your Email" value="" required>
                        </div>
                        <div class="form-group col-md-6 my-1">
                            <label>Aadhaar <span class="text-danger fw-bold">*</span></label>
                            <input type="text" class="form-control my-1" name="aadhaar" autocomplete="off" placeholder="Enter Your Aadhaar" value="" required>
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


<div id="cardregistrationModal" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-slate">
                <h4 class="modal-title pull-left">Add Card</h4>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('ccpayments')); ?>" method="post" id="cardregistrationForm">
                <?php echo e(csrf_field()); ?>

                <div class="modal-body">
                    <input type="hidden" name="type" value="cardregistration">
                    <input type="hidden" name="pancard">
                    <input type="hidden" name="customerId">
                  <div class="row">
                        <div class="form-group col-md-6 my-1">
                            <label>Card Number <span class="text-danger fw-bold">*</span></label>
                            <input type="text" id="creditCardNumber" class="form-control my-1" autocomplete="off" name="cardnumber" maxlength="19" placeholder="1234 5678 9012 3456" required>
                        </div>
                        <div class="form-group col-md-6 my-1">
                            <label>Exp. Date <span class="text-danger fw-bold">*</span></label>
                            <input type="text"   id="expirationDate" class="form-control my-1" name="expdate" autocomplete="off" maxlength="7" placeholder="MM/YY" required>
                        </div>
                         <div class="form-group col-md-12 mb-3">
                            <label>Card Type</label>
                                <select name="network"  id="network" class="form-control" required="">
                                    <option value="VISA">VISA</option>
                                    <option value="Mastercard">Mastercard</option>
                                    <option value="AMEX">AMEX</option>
                                    <option value="RUPAY">RUPAY</option>
                                </select>
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



<div id="addbankModal" class="modal fade" role="dialog" data-backdrop="false" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-slate">
                <h4 class="modal-title pull-left">Add New Bank</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="<?php echo e(route('ccpayments')); ?>" method="post" id="addbankForm">
                <?php echo e(csrf_field()); ?>

                <div class="modal-body">
                    <input type="hidden" name="type" value="addbank">
                    <input type="hidden" name="pancard">
                    <input type="hidden" name="customerId">
                  <div class="row">
                        <div class="form-group col-md-6 my-1">
                            <label>Bank Name <span class="text-danger fw-bold">*</span></label>
                            <input type="text" id="namkname" class="form-control my-1" autocomplete="off" name="bank" placeholder="Enter Bank Name" required>
                        </div>
                        <div class="form-group col-md-6 my-1">
                            <label>IFSC <span class="text-danger fw-bold">*</span></label>
                            <input type="text"   id="ifsccode" class="form-control my-1" name="ifsc" autocomplete="off" placeholder="Enter ifsc code"  required>
                        </div>
                         <div class="form-group col-md-6 my-1">
                            <label>Account Holder Name <span class="text-danger fw-bold">*</span></label>
                            <input type="text"   id="accountholder" class="form-control my-1" name="accountname" autocomplete="off" placeholder="Enter account holder name"  required>
                        </div>
                         <div class="form-group col-md-6 my-1">
                              <label for="phone"><span class="text-danger fw-bold">*</span> Bank Account No.:</label>
                            <input type="text"   id="accountNumber" class="form-control my-1" name="account" autocomplete="off" placeholder="Enter account holder name"  required>
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



<div id="paymentsModal" class="modal fade modal-lg" role="dialog" data-backdrop="false" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-slate">
                <h4 class="modal-title pull-left">Payment Transfer</h4>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('ccpayments')); ?>" method="post" id="paymentsForm">
                <?php echo e(csrf_field()); ?>

                <div class="modal-body">
                    <input type="hidden" name="type" value="payment">
                    <input type="hidden" name="pancard">
                    <input type="hidden" name="customerId">
                    <input type="hidden" name="cardId">
                    <input type="hidden" name="customer">
                     <input type="hidden" name="cardtype">
                      <input type="hidden" name="commission" value="0">
                    <input type="hidden" name="categoryId" value="3">
                  <div class="row">
                        <div class="form-group col-md-12 mb-3">
                           <table id="payout-table">
                                <thead>
                                    <tr>
                                        <th>Select</th>
                                        <th>Name</th>
                                        <th>Account</th>
                                        <th>IFSC</th>
                                        <th>Bank Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group col-md-12 my-1">
                            <label>Amount <span class="text-danger fw-bold">*</span></label>
                            <input type="text" id="amount" class="form-control my-1" autocomplete="off" name="amount" placeholder="Enter amount" required>
                        </div>
                        <!--<div class="form-group col-md-12 my-1">-->
                        <!--    <label>Charge in percentage <span class="text-danger fw-bold">*</span></label>-->
                        <!--    <input type="text" id="charge" class="form-control my-1" autocomplete="off" name="commission" placeholder="Enter charge" required>-->
                        <!--</div>-->
                        
                         <div class="form-group col-md-12 mb-3">
                            <label>Setelment Type</label>
                            <select name="setelment" class="form-control">
                                <option value="instant">Instant</option>
                                <option value="t1">T+1</option>
                                <option value="t2">T+2</option>
                            </select>
                        </div>
                         <div class="form-group col-md-12 mb-3">
                            <label>Select Category</label>
                            <select name="category" id="" class="category form-control">
                                <option value="">Select a category</option>
                              
                            </select>
                        </div>
                        
                         <div class="form-group col-md-12 mb-3">
                            <label>Select Sub Category</label>
                            <select name="subcategory" id="" disabled class=" subcategory form-control">
                               <option value="">Select a subcategory</option>
                            </select>
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




<div id="verfyModal" class="modal fade modal-lg" role="dialog" data-backdrop="false" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content modal-lg">
            <div class="modal-header bg-slate">
                <h4 class="modal-title pull-left">Payment Transfer</h4>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('ccpayments')); ?>" method="post" id="verfyForm">
                <?php echo e(csrf_field()); ?>

                <div class="modal-body">
                    <input type="hidden" name="type" value="verifycard">
                    <input type="hidden" name="pancard">
                    <input type="hidden" name="customerId">
                    <input type="hidden" name="cardId">
                    <input type="hidden" name="customer">
                     <input type="hidden" name="cardtype">
                       <input type="hidden" name="account">
                          <input type="hidden" name="commission" value="0">
                   <input type="hidden" name="expireDate">
                    <input type="hidden" name="categoryId" value="3">
                  <div class="row">
                        <div class="form-group col-md-12 mb-3">
                           <table id="payout-table">
                                <thead>
                                    <tr>
                                        <th>Select</th>
                                        <th>Name</th>
                                        <th>Account</th>
                                        <th>IFSC</th>
                                        <th>Bank Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group col-md-12 my-1">
                            <label>Amount <span class="text-danger fw-bold">*</span></label>
                            <input type="text" id="amount" class="form-control my-1" autocomplete="off" name="amount" placeholder="Enter amount" required>
                        </div>
                        <!--<div class="form-group col-md-12 my-1">-->
                        <!--    <label>Charge in percentage <span class="text-danger fw-bold">*</span></label>-->
                        <!--    <input type="text" id="charge" class="form-control my-1" autocomplete="off" name="commission" placeholder="Enter charge" required>-->
                        <!--</div>-->
                        
                         <div class="form-group col-md-12 mb-3">
                            <label>Setelment Type</label>
                            <select name="setelment" class="form-control">
                                <option value="instant">Instant</option>
                                <option value="t1">T+1</option>
                                <option value="t2">T+2</option>
                            </select>
                        </div>
                         <div class="form-group col-md-12 mb-3">
                            <label>Select Category</label>
                            <select name="category" class="form-control category">
                                <option value="">Select a category</option>
                              
                            </select>
                        </div>
                        
                         <div class="form-group col-md-12 mb-3">
                            <label>Select Sub Category</label>
                            <select name="subcategory"  disabled class="form-control subcategory">
                               <option value="">Select a subcategory</option>
                            </select>
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
     getCat().then(function(data) {
         console.log(data) ;
        if (data) {
            category = data;
            $.each(category.data, function(index, cat) {
                $('.category').append($('<option>', {
                    value: cat.catetoryId,
                    text: cat.name
                }));
            });
            $('.category').change(function() {
                var categoryId = $(this).val();
                $('.subcategory').empty().append($('<option>', {
                    value: '',
                    text: 'Select a subcategory'
                })).prop('disabled', true);

                if (categoryId) {
                    var selectedCategory = category.data.find(function(cat) {
                        return cat.catetoryId == categoryId;
                    });

                    if (selectedCategory && selectedCategory.subCategory.length > 0) {
                        $.each(selectedCategory.subCategory, function(index, subCategory) {
                            $('.subcategory').append($('<option>', {
                                value: subCategory.catetoryId,
                                text: subCategory.name
                            }));
                        });
                        $('.subcategory').prop('disabled', false);
                    }
                }
            });
        } else {
            console.log("No data returned or an error occurred.");
        }
    })
    .catch(function(error) {
        console.log("Error fetching categories:", error);
    });
        
         $('#refreshButton').click(function() {
                location.reload(); // This will refresh the page
            });
            
        $("[name='pancard']").keyup(function(){
            $( "#serachForm" ).submit();
        });

        $( "#serachForm" ).validate({
            rules: {
                pancard: {
                    required: true,
                    minlength:10,
                    maxlength:10
                },
            },
            messages: {
                pancard: {
                    required: "Please enter pancard number",
                    minlenght: "Pan number length should be 10 digit",
                    maxlenght: "Pan number length should be 10 digit",
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
                             $("#credadd").css("display", "block");
                             
                             if(data.data.digioKyc == 0){
                             swal({
                                title: 'Suscess', 
                                text : "Your Kyc is pending click here to complete", 
                                type : 'success',
                             });    
                              window.open(data.data.kycUrl, '_blank');
                             // return false ;
                             }
                             
                             setVerifyData(data);
                             setBeneData(data);
                             //setbankdata(data);
                        }else if(data.statuscode == "RNF"){
                            var pancard = form.find('[name="pancard"]').val();
                            $('#registrationModal').find('[name="pancard"]').val(pancard);
                            $('#registrationModal').modal('show');
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
                ifsc: {
                    required: true,
                },
                account: {
                    required: true,
                },
                account_confirmation: {
                    required: true,
                    equalTo : '#account'
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
                    equalTo : 'Account confirmation is same as account number'
                },
                name: {
                    required: "Beneficiary account name is required",
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
                       form.find('button[type="submit"]').html(
                            '<span class="spinner-border me-1" role="status" aria-hidden="true"></span> Loading...'
                        ).attr(
                            'disabled', true).addClass('btn-secondary');
                    },
                    success:function(data){
                      form.find('button[type="submit"]').html('Submit').attr(
                                'disabled', false).removeClass('btn-secondary');
                        if(data.statuscode == "TXN"){
                            form.closest('.modal').modal('hide');
                             swal({
                                title: 'Suceess',
                                text: "Check your email/sms to complete kyc ",
                                type: 'success',
                                onClose: () => {
                                    window.open(data.url, "_blank");
                                }
                            });
                           // $( "#serachForm" ).submit();
                        }else{
                            notify(data.message, 'danger', "inline",form);
                        }
                    },
                      error: function(errors) {
                            form.find('button[type="submit"]').html('Submit').attr(
                                'disabled', false).removeClass('btn-secondary');
                        showError(errors, form);
                    }
                });
            }
        });
        
        
          $( "#cardregistrationForm" ).validate({
            rules: {
                cardnumber: {
                    required: true,
                },
                expdate: {
                    required: true,
                },
            },
            messages: {
                cardnumber: {
                    required: "Please enter Pancard",
                },
                surname: {
                    required: "Please enter exp date",
                },
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
                var form = $('#cardregistrationForm');
                var type = form.find('input[name="type"]').val();
                form.ajaxSubmit({
                    dataType:'json',
                    beforeSubmit:function(){
                       form.find('button[type="submit"]').html(
                            '<span class="spinner-border me-1" role="status" aria-hidden="true"></span> Loading...'
                        ).attr(
                            'disabled', true).addClass('btn-secondary');
                    },
                    success:function(data){
                      form.find('button[type="submit"]').html('Submit').attr(
                                'disabled', false).removeClass('btn-secondary');
                        if(data.statuscode == "TXN"){
                            form.closest('.modal').modal('hide');
                            $( "#serachForm" ).submit();
                        }else{
                            notify(data.message, 'danger', "inline",form);
                        }
                    },
                      error: function(errors) {
                            form.find('button[type="submit"]').html('Submit').attr(
                                'disabled', false).removeClass('btn-secondary');
                        showError(errors, form);
                    }
                });
            }
        });

          $( "#addbankForm" ).validate({
            rules: {
                cardnumber: {
                    required: true,
                },
                expdate: {
                    required: true,
                },
            },
            messages: {
                cardnumber: {
                    required: "Please enter Pancard",
                },
                surname: {
                    required: "Please enter exp date",
                },
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
                var form = $('#addbankForm');
                var type = form.find('input[name="type"]').val();
                form.ajaxSubmit({
                    dataType:'json',
                    beforeSubmit:function(){
                       form.find('button[type="submit"]').html(
                            '<span class="spinner-border me-1" role="status" aria-hidden="true"></span> Loading...'
                        ).attr(
                            'disabled', true).addClass('btn-secondary');
                    },
                    success:function(data){
                      form.find('button[type="submit"]').html('Submit').attr(
                                'disabled', false).removeClass('btn-secondary');
                        if(data.statuscode == "TXN"){
                            form.closest('.modal').modal('hide');
                            $( "#serachForm" ).submit();
                        }else{
                            notify(data.message, 'danger', "inline",form);
                        }
                    },
                      error: function(errors) {
                            form.find('button[type="submit"]').html('Submit').attr(
                                'disabled', false).removeClass('btn-secondary');
                        showError(errors, form);
                    }
                });
            }
        });
        
         $( "#paymentsForm" ).validate({
            rules: {
                ampount: {
                    required: true,
                },
                // bankId: {
                //     required: true,
                // },
            },
            messages: {
                ampount: {
                    required: "Please enter amount",
                },
                // bankId: {
                //     required: "Please select bank",
                // },
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
                var form = $('#paymentsForm');
                var type = form.find('input[name="type"]').val();
                form.ajaxSubmit({
                    dataType:'json',
                    beforeSubmit:function(){
                       form.find('button[type="submit"]').html(
                            '<span class="spinner-border me-1" role="status" aria-hidden="true"></span> Loading...'
                        ).attr(
                            'disabled', true).addClass('btn-secondary');
                    },
                    success:function(data){
                      form.find('button[type="submit"]').html('Submit').attr(
                                'disabled', false).removeClass('btn-secondary');
                        if(data.statuscode == "TXN"){
                            form.closest('.modal').modal('hide');
                            swal({
                                title: 'Suscess', 
                                text : "Payment link generated Successfully", 
                                type : 'success',
                             });    
                              window.open(data.url);
                        }else{
                            notify(data.message, 'danger', "inline",form);
                        }
                    },
                      error: function(errors) {
                            form.find('button[type="submit"]').html('Submit').attr(
                                'disabled', false).removeClass('btn-secondary');
                        showError(errors, form);
                    }
                });
            }
        });
        
             $( "#verfyForm" ).validate({
            rules: {
                ampount: {
                    required: true,
                },
                // bankId: {
                //     required: true,
                // },
            },
            messages: {
                ampount: {
                    required: "Please enter amount",
                },
                // bankId: {
                //     required: "Please select bank",
                // },
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
                var form = $('#verfyForm');
                var type = form.find('input[name="type"]').val();
                form.ajaxSubmit({
                    dataType:'json',
                    beforeSubmit:function(){
                       form.find('button[type="submit"]').html(
                            '<span class="spinner-border me-1" role="status" aria-hidden="true"></span> Loading...'
                        ).attr(
                            'disabled', true).addClass('btn-secondary');
                    },
                    success:function(data){
                      form.find('button[type="submit"]').html('Submit').attr(
                                'disabled', false).removeClass('btn-secondary');
                        if(data.statuscode == "TXN"){
                            form.closest('.modal').modal('hide');
                            swal({
                                title: 'Suscess', 
                                text : "Payment link generated Successfully", 
                                type : 'success',
                             });    
                              window.open(data.url);
                        }else{
                            notify(data.message, 'danger', "inline",form);
                        }
                    },
                      error: function(errors) {
                            form.find('button[type="submit"]').html('Submit').attr(
                                'disabled', false).removeClass('btn-secondary');
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
        $('.name').text(data.data.kycName);
        $('.mobile').text(data.data.mobile);
        $('[name="mobile"]').val(data.data.mobile);
        $('[name="pancard"]').val(data.data.pan);
        $('[name="customerId"]').val(data.data.custId);
        $('[name="name"]').val(data.data.kycName);
        $('#rname').val(data.data.kycName);
        $('[name="customer"]').val(data.data.kycName); 
        
        
      
         var base64String = "data:image/png;base64,"+data.data.imageBase64
         $('#customerimage').attr('src', base64String);
         $('.custname').text(data.data.kycName); 
         $('.custmobile').text(data.data.mobile); 
         $('.custadd').text(data.data.address);   
         $('.custdob').text(data.data.dob); 
         $('.custemail').text(data.data.email); 
        
        $('.userdetails').fadeIn('400');
        $('.pandetails').fadeOut('400');
        $('.custdetails').fadeIn('400');
    }

    function setBeneData(data) {
        if(data.carddata.length > 0){
            out = ``;
            $.each(data.carddata , function(index, beneficiary) {
                let cardNo = beneficiary.accountNo.slice(-4)
                let type = "" ;
                if(beneficiary.network == null){
                    type =   "UNKNOWN";
                }else{
                     type = beneficiary.network;
                }
                out += `<tr>
                     
                        <td>`+ type +`</td>
                        <td>XXXXXXXXXXXX`+cardNo+`</td>
                        <td>`;
                 if(beneficiary.isVerify == "1"){
                      out +=`<button class="btn btn-primary btn-sm legitRipple" onclick="sendMoney('`+beneficiary.customerId+`','`+beneficiary.accountNo+`','`+beneficiary.cardId+`','`+beneficiary.network+`')"><i class="fa fa-paper-plane"></i>  Send</button>`;
                 }else{
                       out +=`<button class="btn btn-primary btn-sm legitRipple" onclick="verfyMoney('`+beneficiary.customerId+`','`+beneficiary.accountNo+`','`+beneficiary.cardId+`','`+beneficiary.network+`','`+beneficiary.expireDate+`')"><i class="fa fa-paper-plane"></i>  Send</button>`;
                     // out +=`<button class="btn btn-primary btn-sm legitRipple" onclick="verifycard('`+beneficiary.customerId+`','`+beneficiary.accountNo+`','`+beneficiary.cardId+`','`+beneficiary.expireDate+`','`+beneficiary.cardName+`')"><i class="fa fa-paper-plane"></i> Verify</button>`;
                 }
                     out +=`<button type="button" class="btn btn-sm btn-danger legitRipple" onclick="deleteBene('`+beneficiary.customerId+ `','`+beneficiary.cardId+ `')"> <i class="fa fa-trash"></i></button>`;
                out +=`</td>
                    </tr>`;
            });
            $('.transaction').find('tbody').html(out);
            console.log('if') ;
        }else{
            console.log('else') ;
            $('.transaction').find('tbody').html('');
        }
    }

    function sendMoney(custid,account,cardId,cardtype) {
       
        $('[name="customerId"]').val(custid);
        $('[name="account"]').val(account);
        $('[name="cardId"]').val(cardId);
        $('[name="cardtype"]').val(cardtype);
        $('#paymentsModal').modal('show');
        
    }  
    
    
      function verfyMoney(custid,account,cardId,cardtype,expireDate) {
       
        $('[name="customerId"]').val(custid);
        $('[name="account"]').val(account);
        $('[name="cardId"]').val(cardId);
        $('[name="cardtype"]').val(cardtype);
        $('[name="expireDate"]').val(expireDate);
        $('#verfyModal').modal('show');
        
    }  


   function verifycard(customerId,accountNo, cardId, expireDate,cardName){
        $.ajax({
                url: "<?php echo e(route('ccpayments')); ?>",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType:'json',
                data: {'accountNo':accountNo, 'cardId':cardId,'expireDate':expireDate,'customerId':customerId,'type':"verifycard","cardName":cardName},
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
                          swal({
                                title: 'Suscess', 
                                text : "Payment link generated Successfully", 
                                type : 'success',
                             });    
                           window.open(result.link, "_blank");
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

  function setbankdata(data){
     $(".banklist").html('');
     $("#payout-table tbody").html('');
     var $tableBody = $('#payout-table tbody');
     var $list =$('.banklist');
     if(data.bankdata.length > 0){
      $.each(data.bankdata, function(index, user) {
                var rowHtml = '<tr>' +
                    '<td><input type="radio" id="banktype_' + user.bankId + '" name="bankId" value="' + user.bankId + '"></td>' +
                    '<td>' + user.accountHolderName + '</td>' +
                    '<td>' + user.accountNo + '</td>' +
                    '<td>' + user.ifsc + '</td>' +
                    '<td>' + user.bankName + '</td>' +
                    '</tr>';
                $tableBody.append(rowHtml);
                var bankdelete =`<button type="button" class="btn btn-sm btn-danger legitRipple" onclick="deleteBank('`+data.data.custId+ `','`+user.bankId+ `')"> <i class="fa fa-trash"></i></button>`;
                var bankp = `<div class="col-md-10"> <p>`+ user.bankName +` (`+ user.accountNo+`)</p></div><div class="col-md-2">`+bankdelete+`</div>`;
                $list.append(bankp);
            });
     }    
   }
   
   
  function getCat() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "<?php echo e(route('ccpayments')); ?>",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            data: { "type": "getcategory" },
            success: function(result) {
                let data;

                if (result.statuscode == "TXN") {
                    data = result;
                } else {
                    data = {
                        "code": "0x0200",
                        "message": "Category list found",
                        "status": "SUCCESS",
                        "data": [
                            { "catetoryId": 3, "name": "Bill Payment", "isActive": "1", "subCategory": [] },
                            { "catetoryId": 2, "name": "Business Payment", "isActive": "1", "subCategory": [] },
                            { "catetoryId": 1, "name": "Rent", "isActive": "1", "subCategory": [
                                { "catetoryId": 4, "name": "Test", "isActive": "1" }
                            ]}
                        ]
                    };
                }

                resolve(data); // Resolve the promise with the data
            },
            error: function(error) {
                console.error("Error fetching categories:", error);
                reject(error); // Reject the promise on error
            }
        });
    });
}

function deleteBene(id,cardid) {
            //console.log(data);
            swal({
                title: 'Are you sure ?',
                text: "You want to detete this card from application",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: 'Yes delete it!',
                showLoaderOnConfirm: true,
                allowOutsideClick: () => !swal.isLoading(),
                preConfirm: () => {
                    return new Promise((resolve) => {
                        $.ajax({
                            url: "<?php echo e(route('ccpayments')); ?>",
                            type: "POST",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: 'json',
                            data: {
                                'custid': id,
                                'type' : 'deletecard',
                                'cardid' : cardid
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

                if (result.value.statuscode == "TXN") {
                    $("#serachForm").submit();
                    notify("Card Deleted Successfully", 'success');

                } else {
                    notify('Something went wrong, try again', 'Oops', 'error');
                }

            });
        }


function deleteBank(id,cardid) {
            //console.log(data);
            swal({
                title: 'Are you sure ?',
                text: "You want to detete this card from application",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: 'Yes delete it!',
                showLoaderOnConfirm: true,
                allowOutsideClick: () => !swal.isLoading(),
                preConfirm: () => {
                    return new Promise((resolve) => {
                        $.ajax({
                            url: "<?php echo e(route('ccpayments')); ?>",
                            type: "POST",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: 'json',
                            data: {
                                'custid': id,
                                'type' : 'deletebank',
                                'cardid' : cardid
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

                if (result.value.statuscode == "TXN") {
                    $("#serachForm").submit();
                    notify("Card Deleted Successfully", 'success');

                } else {
                    notify('Something went wrong, try again', 'Oops', 'error');
                }

            });
        }

 
    
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.quick2pay.in/resources/views/service/ccpay.blade.php ENDPATH**/ ?>