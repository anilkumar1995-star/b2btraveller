<?php $__env->startSection('title', "Commission Settlement Details"); ?>
<?php $__env->startSection('pagetitle', "Commission Settlement Details"); ?>

<?php
$table = "yes";
// $export = "aepsfundrequestview";
$status['type'] = "Fund";
$status['data'] = [
"success" => "Success",
"pending" => "Pending",
"failed" => "Failed",
"approved" => "Approved",
"rejected" => "Rejected",
];

$product['type'] = "Transaction";
$product['data'] = [
"wallet" => "Move To Wallet",
"bank" => "Move To Bank"
];

?>

<?php $__env->startSection('content'); ?>
<div class="row mt-4">
    <div class="col-12 col-xl-12 col-sm-12 order-1 order-lg-2 mb-4 mb-lg-0">
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4 ">
                <div class="card-title mb-5">
                    <h5 class="mb-0">
                        <span><?php echo $__env->yieldContent('pagetitle'); ?></span>
                    </h5>
                </div>
            </div>
            <div class="card-datatable table-responsive">
                <table width="100%" class="table border-top mb-5" id="datatable" role="grid" aria-describedby="user-list-page-info">
                    <thead class=" text-center bg-light">
                        <tr>
                            <th>#</th>
                            <th>User Details</th>
                            <th>Settlement Details</th>
                            <th>Txn Details</th>
                            <th>Description</th>
                            <th>Remark</th>
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

<?php if(Myhelper::hasRole('admin')): ?>
<div id="transferModal" class="offcanvas offcanvas-end" role="dialog" data-bs-backdrop="static">
            <div class="offcanvas-header bg-primary">
                <h4 class="text-white">Fund Request Update</h4>  
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>

            <form id="transferForm" method="post" action="<?php echo e(route('fundtransaction')); ?>">
                <div class="offcanvas-body">
                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="id">
                    <input type="hidden" name="type" value="aepstransfer">
                    <div class="form-group">
                        <label>Action Type</label>
                        <select class="form-control my-1" name="status" required="">
                            <option value="">Select Action Type</option>
                            <option value="success">Approved</option>
                            <option value="reversed">Reject</option>
                        </select>
                    </div>

                    <div class="form-group my-1">
                        <label>Ref No</label>
                        <input text="text" name="refno" class="form-control my-1" required>
                    </div>

                    <div class="form-group my-1">
                        <label>Remark</label>
                        <textarea name="remark" class="form-control my-1" rows="3" placeholder="Enter Value"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="offcanvas" aria-hidden="true">Close</button>
                    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
                </div>
            </form>
        
</div><!-- /.modal -->
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        var url = "<?php echo e(url('statement/fetch')); ?>/commissionsettlement/0";
        var onDraw = function() {};
        var options = [{
                "data": "name",
                render: function(data, type, full, meta) {
                    var out = '';
                    if (full.api) {
                        out += `<span class='myspan'>` + full.api.api_name + `</span><br>`;
                    }
                    out += `<span class='text-inverse'>` + full.id + `</span><br><span style='font-size:12px'>` + full.created_at + `</span>`;
                    return out;
                }
            },
            {
                "data": "username"
            },
            {
                "data": "bank",
                render: function(data, type, full, meta) {
                    if (full.option1 == "wallet") {
                        return "Fund Settle in WALLET <br>" + "Settlement Mode: " + full.option2.toUpperCase();
                    } else {
                        return "Fund Settle in BANK <br>" + "Settlement Mode: " + full.option2.toUpperCase() + "<br> A/C No.: "+ full.number + "<br> IFSC: " + full.option4;
                    }
                }
            },
            {
                "data": "bank",
                render: function(data, type, full, meta) {
                    // if (full.option1 == "wallet") {
                    //     return "Wallet"
                    // } else {
                        return "Txn Id: "+ full.txnid + "<br>Pay Id: " + full.payid;
                    // }
                }
            },
            {
                "data": "description",
                render: function(data, type, full, meta) {
                    return "Amount: ₹ " + full.amount + "<br>Charges: " + full.charge;
                }
            },
            {
                "data": "remark"
            },
            {
                "data": "action",
                render: function(data, type, full, meta) {
                    var menu = ``;
                    menu += `<li><a href="javascript:void(0)"></a></li>`;


                    // if (full.status == "success") {
                    //     var btn = '<span class="bg-success badge badge-success text-uppercase"><b>' + "Approved" + '</b></span>';
                    // } else if (full.status == 'pending' || full.status == 'initiated') {
                    //     var btn = '<span class="bg-warning badge badge-warning text-uppercase"><b>' + full.status + '</b></span>';
                    // } else if (full.status == 'failed' || full.status == 'refunded'){
                    //     var btn = '<span class="bg-danger badge badge-danger text-uppercase"><b>' + full.status + '</b></span>';
                    // } else {
                    //     var btn = '<span class="bg-info badge badge-info text-uppercase"><b>' + full.status + '</b></span>';
                    // }
                    <?php if(Myhelper::hasRole('admin')): ?>
                    // btn += `<br><button class="btn btn-primary my-2 btn-xs waves-effect mt-10" onclick="transfer('` + full.id + `', '` + full.username + `')"><i class="fa fa-pencil"></i> Edit</button>`;
                    menu += `<a href="javascript:void(0)" class="dropdown-item" onclick="transfer('` + full.id + `', '` + full.username + `')"><i class="icon-pencil5"></i> Edit</a>`;

                    menu += `<a href="javascript:void(0)" class="dropdown-item" onclick="status(` + full.id + `, 'commStatusCheck')"><i class="icon-info22"></i>Check Status</a>`;
                    // <?php endif; ?>
                    // <?php if(Myhelper::can('money_status')): ?>

                    <?php endif; ?>

                    return `<div class="btn-group" role="group">
                                    <span id="btnGroupDrop1" class="badge ${full.status=='success'? 'bg-success badge-success' : (full.status == 'pending' || full.status == 'initiated')? 'bg-warning badge-warning':(full.status == 'failed' || full.status == 'refunded')? 'bg-info badge-info':full.status=='refund'? 'bg-dark badge-dark':'bg-danger badge-danger'} dropdown-toggle"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    ` + full.status + `
                                    </span>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                       ` + menu + `
                                    </div>
                                 </div>`;



                    

                    // return btn; 
                }
            }
        ];

        datatableSetup(url, options, onDraw);

        $('form#transferForm').submit(function() {
            var form = $(this);
            $(this).ajaxSubmit({
                dataType: 'json',
                beforeSubmit: function() {
                    form.find('button:submit').html('Please wait...').attr('disabled',true).addClass('btn-secondary');
                },
                complete: function() {
                    form.find('button:submit').html('Submit').attr('disabled',false).removeClass('btn-secondary');
                },
                success: function(data) {
                    if (data.status == "success") {
                        form[0].reset();
                        notify('Fund request successfully updated', 'success');
                        $('#transferModal').offcanvas('hide');
                        $('#datatable').dataTable().api().ajax.reload();
                    } else {
                        notify('Something went wrong', 'error');
                    }
                },
                error: function(errors) {
                    notify(errors.responseJSON.status, 'Oops!', 'error');
                }
            });
            return false;
        });

        $("#transferModal").on('hidden.bs.offcanvas', function() {
            $('#transferModal').find('form')[0].reset();
            $('#transferForm').find('input[name="id"]').val('');
            $('#transferModal').find('.payeename').text('');
        });
    });

    function transfer(id, name) {
        $('#transferModal').find('.payeename').text(name);
        $('#transferForm').find('input[name="id"]').val(id);
        $('#transferModal').offcanvas('show');
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.quick2pay.in/resources/views/fund/aepsrequest.blade.php ENDPATH**/ ?>