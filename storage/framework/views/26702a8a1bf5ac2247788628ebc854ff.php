<?php $__env->startSection('title', "CC Statement"); ?>
<?php $__env->startSection('pagetitle', "CC Statement"); ?>

<?php
$table = "yes";
$export = "money";

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
                            <th>Customer Details</th>
                            <th>Bank Details</th>
                             <th>Transaction</th>
                            <th>Amount/Commission</th>
                            <th>Settlement</th>
                            <th>Settlement</th>
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

<div class="modal fade bd-example-modal-xl" id="receipt" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between bg-light">
                <h5 class="modal-title">Receipt</h5>
                <img src="<?php echo e(Imagehelper::getImageUrl().Auth::user()->company->logo); ?>" height="50px" width="60px" alt="">

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="margin: -1rem -1rem -1rem !important;">

                </button>
            </div>
            <div class="modal-body">
                <div id="receptTable">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive-sm">
                                <table class="table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Txn Date</th>
                                            <th scope="col">Bank Details</th>
                                            <th scope="col">Shop Details</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="created_at"></td>
                                            <td>
                                                <address class="m-b-10">
                                                    <strong>Beneficary Name : </strong> <span class="option2"></span><br>
                                                    <strong>Account No : </strong> <span class="number"></span><br>
                                                    <strong>Phone :</strong> <span class="mobile"></span>
                                                </address>
                                            </td>
                                            <td>
                                                <address class="m-b-10">
                                                    <strong>Agent Name :</strong> <span><?php echo e(Auth::user()->name); ?></span><br>
                                                    <strong>Shop Name :</strong> <span><?php echo e(Auth::user()->shopname); ?></span><br>
                                                    <strong>Phone :</strong> <span><?php echo e(Auth::user()->mobile); ?></span>
                                                </address>
                                            </td>
                                            
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <h5>Transaction Details :</h5>
                                <div class="table-responsive-sm">
                                    <table class="table table-striped">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Order Id</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">TXN No.</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
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

                        <div class="col-sm-12">
                            <b class="text-danger">Notes:</b>
                            <p>* As per RBI guideline, maximum charges allowed is 2%.</p>
                        </div>


                    </div>

                  
                    <!-- <div class="col-sm-12">

                        <h5 class="mt-5"> Details</h5>
                        <div class="table-responsive-sm">
                            <table class="table table-striped">
                                  <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Bank</th>
                                        <th scope="col">.Acc.No</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row" class="option3"></th>
                                        <td class="number"></td>
                                        <td class="created_at"></td>
                                        <td class="amount"><b></b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> -->



                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" id="print"><i class="fa fa-print"></i>PRINT</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="otpModal" abindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sattel Amount in Payee Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>
            <form action="<?php echo e(route('sattelment')); ?>" method="post" id="transferForm">
                <?php echo e(csrf_field()); ?>

                <div class="modal-body">
                    <input type="hidden" name="type" value="getrefund">
                    <input type="hidden" name="id">
                    <div class="form-group">
                        <label>Account</label>
                        <input type="text" class="form-control" name="account" placeholder="enter Amount" required>
                    </div>
                      <div class="form-group">
                        <label>IFSC</label>
                        <input type="text" class="form-control" name="ifsc" placeholder="enter Amount" required>
                    </div>
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="text" class="form-control" name="amount" placeholder="enter Amount" required>
                    </div>
                     <div class="form-group">
                        <label>Action Mode</label>
                        <select class="form-control" name="mode" required="">
                            <option value="">Select Mode</option>
                            <option value="bank">Bank</option>
                            <option value="wallet">Wallet</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Action Type</label>
                        <select class="form-control" name="status" required="">
                            <option value="">Select Action Type</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Reject</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                   
                   
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
                </div>
            </form>
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
        var url = "<?php echo e(url('statement/fetch')); ?>/ccpaystatement/<?php echo e($id); ?>";

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
                    return `Name - ` + full.customer ;
                }
            },
            {
                "data": "bank",
                render: function(data, type, full, meta) {
                    return `Name -  ${full.accountname} <br>Bank AC - ${full.account} <br> ifsc - ${full.ifsc} `;
                }
            },
            {
                "data": "bank",
                render: function(data, type, full, meta) {
                    return `Txnid - ${full.txnid} <br> Payid - ${full.payid} <br>UTR -  ${full.refid} `;
                }
            },
            {
                "data": "bank",
                render: function(data, type, full, meta) {
                    return `Amount - <i class="fa fa-inr"></i> ` + full.amount +` <br> Charge -` +full.charge +` <br> Commission -` +full.commission + ` <br> Settlement -` +full.settlement 
                }
            },
              {
                "data": "Settlement",
                render: function(data, type, full, meta) {
                      var out = "";
                     if (full.settlementstatus == "success") {
                            out += `<span class="badge badge-success bg-success">Success</span>`;
                        } else if (full.settlementstatus == "pending") {
                            out += `<span class="badge badge-warning bg-warning">Pending</span>`;
                        } else if (full.settlementstatus == "failed") {
                            out += `<span class="badge badge-danger bg-danger">Rejected</span>`;
                        }else{
                             out += `<span class="badge badge-warning bg-warning">Pending</span>`;
                        }

                       return `Amount `+full.settlement_amt+`<br>Charge `+full.payout_charge+`<br> Status -  ` + out +` <br> Payid -` +full.settlement_payid+` <br> UTR -` +full.settlement_utr 
                }
            },
            
           {
                "data": "Settlement",
                render: function(data, type, full, meta) {
                     var out = "";
                     if (full.settlementstatus2 == "success") {
                            out += `<span class="badge badge-success bg-success">Success</span>`;
                        } else if (full.settlementstatus2 == "pending") {
                            out += `<span class="badge badge-warning bg-warning">Pending</span>`;
                        } else if (full.settlementstatus2 == "failed") {
                            out += `<span class="badge badge-danger bg-danger">Rejected</span>`;
                        }else{
                             out += `<span class="badge badge-warning bg-warning">Pending</span>`;
                        }
                      if(full.settlement_amt2 > 0){
                           return `Amount `+full.settlement_amt2+`<br> Charge `+full.payout_charge2+`<br> Status -  ` + out +` <br> Payid -` +full.settlement_payid2+` <br> UTR -` +full.settlement_utr2 
                      }else{
                          return "" ;
                      }
                }
            },
            
            {
                "data": "status",
                render: function(data, type, full, meta) {
                    var menu = ``;

                    <?php if(Myhelper::hasrole('admin')): ?>
                    if(full.status != "completed" && full.status == "success"){
                    menu += `<a href="javascript:void(0)" class="dropdown-item"  onclick="transfer('`+full.id+`','`+full.amount+`','`+full.refno+`','`+full.account+`','`+full.ifsc+`')"><i class="icon-info22"></i>Satelment</a>`;
                    }
                    
                    if(full.status == "pending" || full.status == "initiate"){
                         menu += `<a href="javascript:void(0)" class="dropdown-item"  onclick="ccstatus('`+full.txnid+`','`+"ccpay"+`')"><i class="icon-info22"></i>Status</a>`;
                    }
                    
                    if((full.status == "completed" && full.settlementstatus == "failed" && full.settlement_amt > 0 ) || (full.settlementstatus2 == "failed" && full.status == "completed" && full.settlement_amt2 > 0 )){
                       menu += `<a href="javascript:void(0)" class="dropdown-item"  onclick="retry('`+full.id+`','`+full.amount+`','`+full.refno+`','`+full.account+`','`+full.ifsc+`')"><i class="icon-info22"></i>Re Try</a>`;
                    }
                    <?php endif; ?>
                 
                    return `<div class="btn-group" role="group">
                                    <span id="btnGroupDrop1" class="badge ${full.status=='success'? 'bg-success badge-success' : full.status=='pending'? 'bg-warning badge-warning':full.status=='reversed'? 'bg-info badge-info':full.status=='refund'? 'bg-dark badge-dark':full.status=='completed'? 'bg-info badge-info':'bg-danger badge-danger'} dropdown-toggle"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    ` + full.status + `
                                    </span>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                       ` + menu + `
                                    </div>
                                 </div>`;

                }
            }
        ];

        var DT = datatableSetup(url, options, onDraw);

        $("#transferForm").validate({
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
                var form = $('#transferForm');
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
                               $('#datatable').dataTable().api().ajax.reload();
                            notify('Transaction Successfully Refunded, Amount Credited', 'success');
                        } else {
                            notify(data.message, 'error', "inline", form);
                        }
                    },
                    error: function(errors) {
                        form.find('button[type="submit"]').html('Submit').attr('disabled', false).removeClass('btn-secondary');
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
    
    
    
function transfer(id, amount,ref,account,ifsc) {
     
    $('#otpModal').find('input[name="refno"]').val(ref);
    $('#otpModal').find('input[name="amount"]').val(amount);
    $('#otpModal').find('input[name="id"]').val(id);
    $('#otpModal').find('input[name="account"]').val(account);
    $('#otpModal').find('input[name="ifsc"]').val(ifsc);
    $('#otpModal').modal('show');
}  


  function ccstatus(id, type) {
            $.ajax({
                url: `<?php echo e(route('ccstatus',['id'=> '`+id+`'])); ?>`,
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'id': id,
                    "type": type
                },
                dataType: 'json',
                beforeSend: function() {
                    swal({
                        title: 'Wait!',
                        text: 'Please wait, we are fetching transaction details',
                        onOpen: () => {
                            swal.showLoading()
                        },
                        allowOutsideClick: () => !swal.isLoading()
                    });
                },
                success: function(data) {
                    if (data.statuscode == "TXN") {
                         var ot = data.status;
                        var refno = "Your transaction " + ot;
                        console.log(refno);
                        swal({
                            type: 'success',
                            title: "Transaction status",
                            text: refno,
                            onClose: () => {
                                $('#datatable').dataTable().api().ajax.reload();
                            }
                        });
                    } else if (data.statuscode == "TXF" || data.status == 'failed' || data.status == 'reversed') {
                       var ot = data.status;
                        var refno = "Your transaction " + ot;
                        console.log(refno);
                        swal({
                            type: 'success',
                            title: "Transaction status",
                            text: refno,
                            onClose: () => {
                                $('#datatable').dataTable().api().ajax.reload();
                            }
                        });

                    } else {
                        swal({
                            type: 'warning',
                            title: "Transaction status",
                            text: data.message || "Please try after sometimes",
                            onClose: () => {
                                $('#datatable').dataTable().api().ajax.reload();
                            }
                        });
                    }
                },
                error: function(errors) {
                    swal.close();
                    $('#datatable').dataTable().api().ajax.reload();
                    showError(errors, "withoutform");
                    notify(errors.responseJSON, 'error');

                }
            })

        }
        
 function retry(id, amount,ref,account,ifsc){
   
     $.ajax({
                url: `<?php echo e(route('retry')); ?>`,
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'id': id,
                    "type": "retry"
                },
                dataType: 'json',
                beforeSend: function() {
                    swal({
                        title: 'Wait!',
                        text: 'Please wait, we are fetching transaction details',
                        onOpen: () => {
                            swal.showLoading()
                        },
                        allowOutsideClick: () => !swal.isLoading()
                    });
                },
                success: function(data) {
                    if (data.statuscode == "TXN") {
                         var ot = data.status;
                        var refno = "Your transaction successfull";
                        console.log(refno);
                        swal({
                            type: 'success',
                            title: "Transaction",
                            text: refno,
                            onClose: () => {
                                $('#datatable').dataTable().api().ajax.reload();
                            }
                        });
                    } else if (data.statuscode == "TXF" || data.statuscode == 'ERR' || data.status == 'reversed') {
                       var ot = data.status;
                        var refno = "Your transaction failed" ;
                       
                        swal({
                            type: 'success',
                            title: "Transaction ",
                            text: refno,
                            onClose: () => {
                                $('#datatable').dataTable().api().ajax.reload();
                            }
                        });

                    } else {
                        swal({
                            type: 'warning',
                            title: "Transaction status",
                            text: data.message || "Please try after sometimes",
                            onClose: () => {
                                $('#datatable').dataTable().api().ajax.reload();
                            }
                        });
                    }
                },
                error: function(errors) {
                    swal.close();
                    $('#datatable').dataTable().api().ajax.reload();
                    showError(errors, "withoutform");
                    notify(errors.responseJSON, 'error');

                }
            })
      
  }    
        
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.quick2pay.in/resources/views/statement/ccpay.blade.php ENDPATH**/ ?>