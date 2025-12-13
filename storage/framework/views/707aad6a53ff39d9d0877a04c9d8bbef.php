<?php $__env->startSection('title', "Aeps Statement"); ?>
<?php $__env->startSection('pagetitle',  "Aeps Statement"); ?>

<?php
    $table = "yes";
    $export = "aeps";

    $status['type'] = "Report";
    $status['data'] = [
        "success" => "Success",
        "pending" => "Pending",
        "failed" => "Failed",
        "reversed" => "Reversed",
        "refunded" => "Refunded",
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
                            <th>Type</th>
                            <th>User Details</th>
                            <th>Bank Details</th>
                            <th>Refrences Details</th>
                            <th>Amount/Commission</th>
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
<div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header border-bottom">
                    <h5 class="modal-title">
                        <img src="https://res.cloudinary.com/jerrick/image/upload/v1746168809/68146be9e4f3ed001da00cab.png" alt="ipayment logo" height="50" class="me-1" />
                        Receipt
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <div class="border rounded p-2 mb-2">
                        <div class="d-flex flex-column flex-md-row justify-content-between">
                            <div>
                                <strong><?php echo e(Auth::user()->name); ?></strong><br />
                                <span class="text-muted"> <?php echo e(Auth::user()->shopname); ?></span><br />
                                <span class="text-muted">Phone : <?php echo e(Auth::user()->mobile); ?></span>
                            </div>
                            <div class="text-end">
                                <div><strong>Date:</strong > <span class="created_at"></span></div>
                                <div><strong>Order ID:</strong > <span class="txnid"></span> </div>
                                <div><strong>Status:</strong> <span class="badge bg-success status"></span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction Info -->
                    <h5 class="fw-bold mt-4">CW</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>Bank</th>
                                    <th>Aadhar Number</th>
                                    <th>Mobile</th>
                                    <th>TXN Id</th>
                                    <th>Ref No.</th>
                                    <th>Amount</th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="bank"></td>
                                    <td class="aadhar"></td>
                                    <td class="mobile"></td>
                                    <td class="txnid"></td>
                                    <td class="refno"></td>
                                    <td class="amount"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Withdrawal Info -->
                    <div class="text-end mt-2">
                        <strong>Withdrawal Amount :</strong> <span class="amount"> </span>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" id="print" class="btn btn-primary">
                        <i class="ti ti-printer me-1 fs-5"></i>
                    </button>
                    <!--<button type="button" class="btn btn-primary">-->
                    <!--    <i class="ti ti-search me-1 fs-6"></i> Search-->
                    <!--</button>-->
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?> 
<script src="<?php echo e(asset('/assets/js/core/jQuery.print.js')); ?>"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var url = "<?php echo e(url('statement/fetch')); ?>/aepsstatement/<?php echo e($id); ?>";
        
        
     $('#print').click(function() {
            $('#receptTable').print();
        });
        
        var onDraw = function() {
            $('.print').click(function(event) {
                var data = DT.row($(this).parent().parent().parent().parent().parent()).data();
                $.each(data, function(index, values) {
                    $("." + index).text(values);
                });
                $('#receiptModal').modal('show');
            });
        };
        var options = [
            { "data" : "name",
                render:function(data, type, full, meta){
                    return `<div>
                            <span class='text-inverse m-l-10'><b>`+full.id +`</b> </span>
                            <div class="clearfix"></div>
                        </div><span style='font-size:13px' class="pull=right">`+full.created_at+`</span>`;
                }
            },
            { "data" : "name",
                render:function(data, type, full, meta){
                    if(full.transtype == "fund"){
                         return `<div>
                            <span class='text-inverse m-l-10'><b>Fund</b> </span>
                            <div class="clearfix"></div>
                        </div>`;
                    }else{
                    return `<div>
                            <span class='text-inverse m-l-10'><b>`+full.aepstype +`</b> </span>
                            <div class="clearfix"></div>
                        </div>`;
                    }
                }
            },
            { "data" : "username"},
            { "data" : "bank",
                render:function(data, type, full, meta){
                    return `Adhaar - `+full.aadhar+`<br>Mobile - `+full.mobile;
                }
            },
            { "data" : "bank",
                render:function(data, type, full, meta){
                    return `Ref No. - `+full.refno+`<br>Txnid - `+full.txnid+`<br>Payid - `+full.payid;
                }
            },
            { "data" : "bank",
                render:function(data, type, full, meta){
                    if(full.aepstype == "AP"){
                        return `Amount - <i class="fa fa-inr"></i> `+full.amount+`<br>Charge - <i class="fa fa-inr"></i> `+ (full.profit - full.charge);
                    }else if(full.transtype == "fund"){
                          return `Amount - <i class="fa fa-inr"></i> `+full.amount+`<br>Charge - <i class="fa fa-inr"></i> `+ (full.profit - full.charge);
                        }else{
                        return `Amount - <i class="fa fa-inr"></i> `+full.amount+`<br>Commission - <i class="fa fa-inr"></i> `+ (full.profit - full.charge);
                    }
                }
            },
            
            { "data" : "status",
                render:function(data, type, full, meta){
                    
                    var menu = ``;
                    // <?php if(Myhelper::can('aeps_status')): ?>
                    // menu += `<li><a href="javascript:void(0)" class="dropdown-item" onclick="status(`+full.id+`, 'aeps')"><i class="icon-info22"></i>Check Status</a></li>`;
                    // <?php endif; ?>

                    // <?php if(Myhelper::can('aeps_statement_edit')): ?>
                    // menu += `<li><a href="javascript:void(0)" class="dropdown-item" onclick="editReport(`+full.id+`,'`+full.refno+`','`+full.txnid+`','`+full.payid+`','`+full.remark+`', '`+full.status+`', 'aeps')"><i class="icon-pencil5"></i> Edit</a></li>`;
                    // <?php endif; ?>
                    
                   if(full.aepstype == "AP" || full.aepstype == "CW"){
                         menu += `<li><a href="javascript:void(0)" class="dropdown-item print"><i class="icon-info22"></i>Print Invoice</a></li>`;
                     }
                     
                    menu += `<li><a href="javascript:void(0)" class="dropdown-item" onclick="complaint(`+full.id+`, 'aeps')"><i class="icon-cogs"></i> Complaint</a></li>`;
                    

                            return `<div class="btn-group" role="group">
                                    <span id="btnGroupDrop1" class="badge ${full.status=='success'? 'bg-success' : full.status=='pending'? 'bg-warning':full.status=='reversed'? 'bg-info':full.status=='complete'? 'bg-primary':'bg-danger'} dropdown-toggle"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    ` + full.status + `
                                    </span>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                       ` + menu + `
                                    </div>
                                 </div>`;

                
                }
            }
        ];

      var DT =  datatableSetup(url, options, onDraw);
    });

    function viewUtiid(id){
        $.ajax({
            url: `<?php echo e(url('statement/fetch')); ?>/utiidstatement/`+id,
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType:'json',
            data:{'scheme_id':id}
        })
        .done(function(data) {
            $.each(data, function(index, values) {
                $("."+index).text(values);
            });
            $('#utiidModal').offcanvas('show');
        })
        .fail(function(errors) {
            notify('Oops', errors.status+'! '+errors.statusText, 'warning');
        });
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.ismartpay.in/resources/views/statement/aeps.blade.php ENDPATH**/ ?>