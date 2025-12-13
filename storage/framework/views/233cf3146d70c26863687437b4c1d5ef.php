<?php $__env->startSection('title', 'CC Settlement Details'); ?>
<?php $__env->startSection('pagetitle', 'CC Settlement Details'); ?>

<?php
$table = 'yes';
// $export = 'aepsfundrequest';
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

<style>
    .swal2-shown{
        overflow-y: auto;
        z-index: 9999;
    }
</style>

<div class="row my-4">
    <div class="col-12 col-xl-12 col-sm-12 order-1 order-lg-2 mb-4 mb-lg-0">
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4">
                <div class="card-title mb-0">
                <h5 class="mb-0">
                        <span><?php echo $__env->yieldContent('pagetitle'); ?></span>
                    </h5>
                </div>
              
                <div class="col-sm-12 col-md-2 mb-5">
                    <div class="user-list-files d-flex float-right">
                    <a href="" class="btn btn-success text-white btn-sm" data-bs-toggle="offcanvas" data-bs-target="#fundRequestModalsRunpaisa">
                            <i class="ti ti-plus ti-xs"></i> New Request</a>
                    </div>
                </div>
               
            </div>

            <div class="card-datatable table-responsive">
                <table width="100%" class="table border-top mb-5" id="datatable" role="grid" aria-describedby="user-list-page-info">
                    <thead class="text-center bg-light">
                             <tr>
                                 <th>#</th>
                                <th>Refrences Details</th>
                                <th>Product</th>
                                <th>Provider</th>
                                <th>Txnid</th>
                                <th>Order ID</th>
                                <th>Number</th>
                                <th>ST_Type / TXN_Type</th>
                                <th>Status</th>
                                <th>Opening Bal. </th>
                                <th>Amount </th>
                                <th>Charge </th>
                                <th>Commission/Profit </th>
                                <th>Closing Bal. </th>
                            </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>

<div class="offcanvas offcanvas-end " id="fundRequestModalsRunpaisa" tabindex="-1" role="modal" aria-labelledby="exampleModalLabels" aria-hidden="true" data-bs-backdrop="static">

    <div class="offcanvas-header bg-primary">
        <h4 class="text-white" id="exampleModalLabel">CC Settlement</h4>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
        </button>
    </div>

    <form id="fundRequestFormsRunpaisa" action="<?php echo e(route('fundtransaction')); ?>" method="post">
        <div class="offcanvas-body">
            <input type="hidden" name="user_id">
            <?php echo e(csrf_field()); ?>

          
            <div class="row">
                 <div class="form-group col-md-6 my-1 my-1">
                    <label>Wallet Type <span class="text-danger fw-bold">*</span></label>
                    <select name="type" id="mySelect" class="form-control my-1" required>
                        <option value="">Select Wallet</option>
                        <option value="ccbank">Move To Bank</option>
                        <option value="ccwallet">Move To Wallet</option>
                    </select>
                </div>
                 <div class="form-group col-md-6 my-1 my-1 accountdetails">
                  <label>Bank Name <span class="text-danger fw-bold">*</span></label>
                   <select id="bank" name="bank" class="form-control mb-3" >
                                    <option value="">Select Bank</option>
                                    <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($bank->bankid); ?>" ifsc="<?php echo e($bank->masterifsc); ?>"><?php echo e($bank->bankname); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                </div>
                <div class="form-group col-md-6 my-1 my-1 accountdetails">
                    <label>IFSC Code <span class="text-danger fw-bold">*</span></label>
                    <input type="text" class="form-control my-1" name="ifsc" placeholder="Enter Value"  value="" >
                </div>
                 <div class="form-group col-md-6 my-1 my-1 accountdetails">
                    <label>A/C Holder Name <span class="text-danger fw-bold">*</span></label>
                    <input type="text" class="form-control my-1" name="accountname" placeholder="Enter Value"  value="" >
                </div>
                <div class="form-group col-md-6 my-1 my-1 accountdetails">
                    <label>Account Number <span class="text-danger fw-bold">*</span></label>
                    <input type="text" class="form-control my-1" name="account" placeholder="Enter Value"  value="<?php echo e(Auth::user()->userbanks['accountNo']); ?>" >
                </div>
                
               
                <div class="form-group col-md-6 my-1 my-1">
                    <label>Amount <span class="text-danger fw-bold">*</span></label>
                    <input type="number" class="form-control my-1" name="amount" placeholder="Enter Value" required="">
                </div>
                <div class="form-group col-md-12 my-1 my-1">
                    <label>Remarks <span class="text-danger fw-bold">*</span></label>
                    <input type="text" class="form-control my-1" name="remarks" placeholder="Enter Value" required="">
                </div>
                <div class="form-group col-md-12 my-1 my-1">
                    <label>T- PIN <span class="text-danger fw-bold">*</span></label>
                    <input type="password" name="pin" class="form-control my-1" placeholder="Enter transaction pin" required="">
                    <a href="<?php echo e(url('profile/view?tab=pinChange')); ?>" target="_blank" class="text-primary pull-right">Generate or Forgot PIN?</a>
                </div>
            </div>
        </div>
        <div class="modal-footer">
                 <button class="btn btn-primary legitRipple" type="button" id="getBenename">Get Name</button>
                <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
            </div>
    </form>
</div>

<div class="offcanvas offcanvas-end" id="fundRequestModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="offcanvas-header bg-primary">
        <h5 class="text-white" id="exampleModalLabel">Aeps Fund Request</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
        </button>
    </div>
    <form id="fundRequestForms" action="<?php echo e(route('fundtransaction')); ?>" method="post">
        <div class="offcanvas-body">
            <?php if(Auth::user()->bank != '' && Auth::user()->ifsc != '' && Auth::user()->account != ''): ?>
            <table class="table table-bordered p-b-15" cellspacing="0" style="margin-bottom: 30px">
                <thead class="thead-light">
                    <tr>
                        <th>Select bank</th>
                        <th>Account</th>
                        <th>Name</th>
                        <th>Bank</th>
                        <th>Ifsc</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $payoutusers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payoutuser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><input type="radio" id="banktype" name="beniid" value="<?php echo e($payoutuser->bene_id); ?>"></td>
                        <td><?php echo e($payoutuser->account); ?></td>
                        <td><?php echo e($payoutuser->account); ?></td>
                        <td><?php echo e($payoutuser->bankname); ?></td>
                        <td><?php echo e($payoutuser->ifsc); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php endif; ?>

            <input type="hidden" name="user_id">
            <?php echo e(csrf_field()); ?>

            <div class="row">
                <?php if(Auth::user()->bank == '' && Auth::user()->ifsc == '' && Auth::user()->account == ''): ?>
                <div class="form-group col-md-6 my-1">
                    <label>Account Number</label>
                    <input type="text" class="form-control my-1" name="account" placeholder="Enter Value" required="" value="<?php echo e(Auth::user()->account); ?>">
                </div>
                <div class="form-group col-md-6 my-1">
                    <label>IFSC Code</label>
                    <input type="text" class="form-control my-1" name="ifsc" placeholder="Enter Value" required="" value="<?php echo e(Auth::user()->ifsc); ?>">
                </div>
                <div class="form-group col-md-6 my-1">
                    <label>Bank Name</label>
                    <input type="text" class="form-control my-1" name="bank" placeholder="Enter Value" required="" value="<?php echo e(Auth::user()->bank); ?>">
                </div>
                <?php endif; ?>

                <div class="form-group col-md-6 my-1">
                    <label>Wallet Type</label>
                    <select name="type" class="form-control my-1" required>
                        <option value="">Select Wallet</option>
                        <option value="bank">Move To Bank</option>
                        <option value="wallet">Move To Wallet</option>
                    </select>
                </div>
                <div class="form-group col-md-6 my-1">
                    <label>Amount</label>
                    <input type="number" class="form-control my-1" name="amount" placeholder="Enter Value" required="">
                </div>
                <div class="form-group col-md-6 my-1">
                    <label>T- PIN</label>
                    <input type="password" name="pin" class="form-control my-1" placeholder="Enter transaction pin" required="">
                    <a href="<?php echo e(url('profile/view?tab=pinChange')); ?>" target="_blank" class="text-primary pull-right">Generate or Forgot PIN?</a>
                </div>
            </div>
          

            <div class="modal-footer">
                   <button class="btn btn-primary legitRipple" type="button" id="getBenename">Get Name</button>
                <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
            </div>
    </form>

</div>




<div id="receipt" class="modal fade" data-backdrop="false" data-keyboard="false">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-slate">
           
            <h4 class="modal-title">Receipt</h4>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> 
            </div>
            <div class="modal-body">
                <ul class="list-group transactionData p-0">
                </ul>
                <div id="receptTable">
                    <div class="clearfix">
                        <div class="text-center">
                             <img src="<?php echo e(asset('public/recept.jpeg')); ?>" class=" img-responsive" alt="" style="width: 70px;height: 50px;">
                              <h6 class="shopename"></h6>
                              <h6 class="umobile"></h6>
                            <h6>Money Transfer Receipt</h6>
                        </div>
                    </div>
                  
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                             
                                <table class="table m-t-10">
                                    <tbody>
                                        <tr>
                                            <th>Status</th>
                                            <td class="status"></td>
                                       </tr>   
                                        <tr>
                                            <th> Date</th>
                                            <td class="created_at"></td>
                                       </tr>   
                                       <tr>
                                            <th>Sender Mobile</th>
                                            <td class="mobile"></td>
                                       </tr>  
                                        <tr>
                                            <th>Bank Name</th>
                                            <td class="option3"></td>
                                       </tr>  
                                        <tr>
                                            <th>A/C</th>
                                            <td class="number"></td>
                                       </tr>  
                                         <tr>
                                            <th>Name</th>
                                            <td class="option2"></td>
                                       </tr>  
                                        <tr>
                                            <th>Transaction Id</th>
                                            <td class="txnid"></td>
                                       </tr> 
                                        <tr>
                                            <th>Transaction Mode</th>
                                            <td class="mode">IMPS</td>
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
                    <p>* As per RBI guideline, maximum charges allowed is 1.2%.</p>
                </div>
            </div>
            <div class="modal-footer">
                 <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"> Close     </button>
                <button class="btn bg-slate btn-raised legitRipple" type="button" id="print"><i class="fa fa-print"></i></button>
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
        
      $('#bank').on('change', function (e) {
            $('input[name="ifsc"]').val($(this).find('option:selected').attr('ifsc'));
        }); 
         
        //  $('#print').click(function() {
        //     //$("#receptTable").css( { marginRight : "50%" } );
             
        //     $('#receptTable').print();
        //     $('#receipt').modal('hide');
        // });

        
        var url = "<?php echo e(url('statement/fetch')); ?>/ccfundsettlement/0";
         var onDraw = function() {
            $('.print').click(function(event) {
                var data = DT.row($(this).parent().parent().parent().parent().parent()).data();
                $.each(data, function(index, values) {
                    $("." + index).text(values);
                });
                //  $(".shopename" ).text(data.shopname);
                  //$(".umobile" ).text(data.user.mobile); 
                
                // $("#receptTable").css( { marginRight : "0%" } );
                $('#receipt').modal('show');
            });
        };
       var options = [{
                "data": "name",
                render: function(data, type, full, meta) {
                    var out = "";
                    out += `</a><span style='font-size:13px' class="pull=right">` + full.created_at +
                        `</span>`;
                    return out;
                }
            },
            {
                "data": "full.username",
                render: function(data, type, full, meta) {
                    var uid = "<?php echo e(Auth::id()); ?>";
                    if (full.credited_by == uid) {
                        var name = full.username;
                    } else {
                        var name = full.sendername;
                    }
                    return name;
                }
            },
            {
                "data": "product"
            },
            {
                "data": "providername"
            },
            {
                "data": "txnid"
            },
            {
                "data": "id"
            },
            {
                "data": "number",
                 render: function(data, type, full, meta) {
                    if(full.product == "bank") {
                           return `AC `+full.number + `<br> ifsc ` + full.option3+ `<br> Name ` + full.option2;
                    }else{
                       return full.number
                    }
                 }
            },
            {
                "data": "rtype",
                render: function(data, type, full, meta) {
                    return full.rtype + `<br>` + full.trans_type;
                }
            },
            {
                "data": "status",
                render: function(data, type, full, meta) {
                    if (full.status == 'success') {
                        return `<a href="javascript:void(0)" id="print" class="badge badge-success bg-success print">${full.status}</a>`;
                    } else if (full.status == 'pending'){
                        return `<a href="javascript:void(0)" id="print" class="badge badge-warning bg-warning print">${full.status}</a>`;
                    }
                    else if (full.status == 'failed'){
                        return `<a href="javascript:void(0)" id="print" class="badge badge-danger bg-danger print">${full.status}</a>`;
                    }else {
                            return `<a href="javascript:void(0)" id="print" class="badge badge-info bg-info print">${full.status}</a>`;  
                        }
                }
            },
            {
                "data": "bank",
                render: function(data, type, full, meta) {
                    return `<i class="fa fa-inr"></i> ` + full.balance;
                }
            },
            {
                "data": "bank",
                render: function(data, type, full, meta) {
                    return `<i class="fa fa-inr"></i> ` + full.amount;
                    //   if(full.status == "pending" || full.status == "success" || full.status == "reversed" || full.status == "refunded"){
                    //     if(full.trans_type == "credit"){
                    //         return `<i class="fa fa-inr"></i> `+ (parseFloat(full.amount) + parseFloat(full.charge) - parseFloat(full.profit));
                    //     }else if(full.trans_type == "debit"){
                    //         return `<i class="fa fa-inr"></i> `+ (parseFloat(full.amount) - parseFloat(full.charge) - parseFloat(full.profit));
                    //     }else if(full.trans_type == "none"){
                    //         return `<i class="fa fa-inr"></i> `+ (parseFloat(full.amount) + parseFloat(full.charge) - parseFloat(full.profit));
                    //     }
                    // }else{
                    //    return `<i class="fa fa-inr"></i> `+full.balance;
                    //}
                }
            },
            {
                "data": "charge",
                render: function(data, type, full, meta) {
                    if (full.charge > 0) {
                        return `<i class="fa fa-inr"></i> ` + full.charge;
                    } else {
                        return 0;
                    }
                }
            },
            {
                "data": "profit",
                render: function(data, type, full, meta) {
                    if (full.profit > 0) {
                        return `<i class="fa fa-inr"></i> ` + full.profit
                    } else {
                        return `<i class="fa fa-inr"></i> ` + full.profit
                    }
                }
            },
            {
                "data": "closing_balance"
                // render: function(data, type, full, meta) {
                //     if (full.status == "pending" || full.status == "success" || full.status ==
                //         "reversed" || full.status == "refunded") {
                //         if (full.trans_type == "credit") {
                //             return `<i class="fa fa-inr"></i> ` + (parseFloat(full.balance) + parseFloat(parseFloat(full.amount) + parseFloat(full.charge) - parseFloat(full.profit))).toFixed(2);
                //         } else if (full.trans_type == "debit") {
                //             return `<i class="fa fa-inr"></i> ` + (parseFloat(full.balance) - parseFloat(parseFloat(full.amount) + parseFloat(full.charge) - parseFloat(full.profit))).toFixed(2);
                //         } else if (full.trans_type == "none") {
                //             return `<i class="fa fa-inr"></i> ` + (parseFloat(full.balance) - parseFloat(parseFloat(full.amount) + parseFloat(full.charge) - parseFloat(full.profit))).toFixed(2);
                //         }
                //     } else {
                //         return `<i class="fa fa-inr"></i> ` + full.balance;
                //     }
                // }
            },
        ];


       var DT  =  datatableSetup(url, options, onDraw);

        $("#fundRequestForm").validate({
            rules: {
                amount: {
                    required: true
                },
                type: {
                    required: true
                },
            },
            messages: {
                amount: {
                    required: "Please enter request amount",
                },
                type: {
                    required: "Please select request type",
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
                        form.find('button:submit').html('Please wait...').attr('disabled',
                            true).addClass('btn-secondary');
                    },
                    complete: function() {
                        form.find('button:submit').html('Submit').attr('disabled',
                            false).removeClass('btn-secondary');
                    },
                    success: function(data) {
                        if (data.status == "success") {
                            form[0].reset();
                            form.closest('.modal').modal('hide');
                            notify("Fund Request submitted Successfull", 'success');
                            $('#datatable').dataTable().api().ajax.reload();
                        } else {
                            notify(data.status, 'warning');
                        }
                    },
                    error: function(errors) {
                        notify(errors.responseJSON.status || 'Something went wrong',
                            'error');
                        form.find('button:submit').html('Submit').attr('disabled',
                            false).removeClass('btn-secondary');
                        // showError(errors, form);
                    }
                });
            }
        });

        $("#fundRequestForms").validate({
            rules: {
                amount: {
                    required: true
                },
                type: {
                    required: true
                },
            },
            messages: {
                amount: {
                    required: "Please enter request amount",
                },
                type: {
                    required: "Please select request type",
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
                var form = $('#fundRequestForms');
                form.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {
                        form.find('button:submit').html('Please wait...').attr('disabled',
                            true).addClass('btn-secondary');
                    },
                    complete: function() {
                        form.find('button:submit').html('Submit').attr('disabled',
                            false).removeClass('btn-secondary');
                    },
                    success: function(data) {
                        if (data.status == "success") {
                            form.closest('.offcanvas').offcanvas('hide');
                            notify("Fund Request submitted Successfull", 'success');
                            $('#datatable').dataTable().api().ajax.reload();
                        } else {
                            notify(data.status, 'warning');
                        }
                    },
                    error: function(errors) {
                        notify(errors.responseJSON.status || 'Something went wrong',
                            'error');
                        form.find('button:submit').html('Submit').attr('disabled',
                            false).removeClass('btn-secondary');
                        // showError(errors, form);
                    }
                });
            }
        });
        $("#fundRequestFormsRunpaisa").validate({
            rules: {
                amount: {
                    required: true
                },
                type: {
                    required: true
                },
            },
            messages: {
                amount: {
                    required: "Please enter request amount",
                },
                type: {
                    required: "Please select request type",
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
                var form = $('#fundRequestFormsRunpaisa');
                form.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {
                        form.find('button:submit').html('Please wait...').attr('disabled',
                            true).addClass('btn-secondary');
                    },
                    complete: function() {
                        form.find('button:submit').html('Submit').attr('disabled',
                            false).removeClass('btn-secondary');
                    },
                    success: function(data) {
                        if (data.status == "success") {
                            form.closest('.offcanvas').offcanvas('hide');
                            notify("Fund Request submitted Successfull", 'success');
                            $('#datatable').dataTable().api().ajax.reload();
                        } else {
                            notify(data.status, 'warning');
                        }
                    },
                    error: function(errors) {
                        form.find('button:submit').html('Submit').attr('disabled',
                            false).removeClass('btn-secondary');
                        // notify(errors.responseJSON.status ||
                        //     'Something went wrong, Please try again later..!',
                        //     'error');
                         showError(errors, form);
                    }
                });
            }
        });
        
          $('#getBenename').click(function(){
            var type = $(this).closest('form').find("[name='type']").val();
            var mobile = "<?php echo e(Auth::user()->mobile); ?>";
            var benemobile = "<?php echo e(Auth::user()->mobile); ?>";
            if(type == "ccbank"){
              
                var name = $(this).closest('form').find("[name='accountname']").val();
                var benebank = $(this).closest('form').find("[name='bank']").val();
                var beneaccount = $(this).closest('form').find("[name='account']").val();
                var beneifsc = $(this).closest('form').find("[name='ifsc']").val();
                var benename = $(this).closest('form').find("[name='accountname']").val();
            
                if(name != '' && benebank != '' && beneaccount != '' && beneifsc != '' && benename != ''){
                    getName(mobile, name, benebank, beneaccount, beneifsc, benename, benemobile, 'add');
                }else{
                       notify("Please fill bank details");
                }
            }else{
                  notify("Please Select type bank");
            }
        });

    });
    
    document.getElementById("mySelect").addEventListener("change", function() {
    var selectedValue = this.value;  // Get the value of the selected option
    if(selectedValue == "ccwallet"){
            $(".accountdetails").css("display", "none");
        }else{
            $(".accountdetails").css("display", "block");
     }
     
     function showError(errors, form="withoutform"){
            if(form != "withoutform"){
                form.find('button[type="submit"]').button('reset');
                $('p.error').remove();
                $('div.alert').remove();
                if(errors.status == 422){
                    $.each(errors.responseJSON.errors, function (index, value) {
                        form.find('[name="'+index+'"]').closest('div.form-group').append('<p class="error">'+value+'</span>');
                    });
                    form.find('p.error').first().closest('.form-group').find('input').focus();
                    setTimeout(function () {
                        form.find('p.error').remove();
                    }, 5000);
                }else if(errors.status == 400){
                    if(errors.responseJSON.message){
                        form.prepend(`<div class="alert bg-danger alert-styled-left">
                            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                            <span class="text-semibold">Oops !</span> `+errors.responseJSON.message+`
                        </div>`);
                    }else{
                        form.prepend(`<div class="alert bg-danger alert-styled-left">
                            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                            <span class="text-semibold">Oops !</span> `+errors.responseJSON.status+`
                        </div>`);
                    }

                    setTimeout(function () {
                        form.find('div.alert').remove();
                    }, 10000);
                }else{
                    notify(errors.statusText , 'warning');
                }
            }else{
                if(errors.responseJSON.message){
                    notify(errors.responseJSON.message , 'warning');
                }else{
                    notify(errors.responseJSON.status , 'warning');
                }
            }
        }  
        
 
});


function getName(mobile, name, benebank, beneaccount, beneifsc, benename, benemobile,type) {
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
                        url: "<?php echo e(route('dmtxpay')); ?>",
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
                                notify(data.message , 'warning');
                            }else if (data.statuscode == "TXN") {
                                if(type == "add"){
                                    $( "#fundRequestFormsRunpaisa" ).find('input[name="accountname"]').val(data.message);
                                    $( "#fundRequestFormsRunpaisa" ).find('input[name="accountname"]').blur();
                                    notify("Success! Account details found", 'success', "inline", $( "#beneficiaryForm" ));
                                }else{
                                    swal(
                                        'Account Verified',
                                        "Account Name is - "+ data.data.benename,
                                        'success'
                                    );
                                }
                            }else {
                                if(type == "add"){
                                    notify(data.message, 'danger', "inline", $( "#beneficiaryForm" ));
                                }else{
                                    swal('Oops!', data.message,'error');
                                }
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
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.bharatmitra.co/resources/views/fund/ccrequest.blade.php ENDPATH**/ ?>