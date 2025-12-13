<?php $__env->startSection('title', "Fund Request"); ?>
<?php $__env->startSection('pagetitle', "Fund Request"); ?>

<?php
$agentfilter = "hide";
$table = "yes";
$export = "fund";
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
                            <th>#</th>
                            <th>Requested By</th>
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

<div class="offcanvas offcanvas-end" id="transferModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
   
            <div class="offcanvas-header bg-primary">
                <h4 class="text-white" id="exampleModalLabel">Fund Request Update</h4>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <form id="transferForm" action="<?php echo e(route('fundtransaction')); ?>" method="post">
                <div class="offcanvas-body">
                    <div class="row">
                        <input type="hidden" name="id">
                        <input type="hidden" name="type" value="requestview">
                        <?php echo e(csrf_field()); ?>

                        <div class="form-group col-md-12 mb-2">
                            <label>Select Action</label>
                            <select name="status" class="form-control mt-2" id="select" required>
                                <option value="">Select Status</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                    
                        <div class="form-group col-md-12 my-2">
                            <label>Remark</label>
                            <textarea name="remark" class="form-control mt-2" rows="3" placeholder="Enter Remark"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
                </div>
            </form>
       
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
<script type="text/javascript">
    $(document).ready(function() {

        var url = "<?php echo e(url('statement/fetch')); ?>/fundrequestview/0";
        var onDraw = function() {};
        var options = [{
                "data": "name",
                render: function(data, type, full, meta) {
                    return `<span class='text-inverse m-l-10'><b>` + full.id + `</b> </span><br>
                        <span style='font-size:13px'>` + full.updated_at + `</span>`;
                }
            },
            {
                "data": "username"
            },
            {
                "data": "bank",
                render: function(data, type, full, meta) {
                    return `<b>Name</b> - ` + full.fundbank.name + `<br><b>Ac No.</b> - ` + full.fundbank.account + `<br><b>Branch</b> - ` + full.fundbank.branch;
                }
            },
            {
                "data": "bank",
                render: function(data, type, full, meta) {
                    var slip = '';
                    if (full.payslip) {
                        var slip = `<a target="_blank" href="<?php echo e(asset('public')); ?>/deposit_slip/` + full.payslip + `">Pay Slip</a>`
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

                    var menu = ``;

                    <?php if(Myhelper::can(['fund_request'])): ?>
                    menu += `<li class="dropdown-header">Action</li><li class="dropdown-item"><a href="javascript:void(0)" onclick="transfer(` + full.id + `, '` + full.remark + `', '` + full.status + `')"><i class="icon-wallet"></i> Update Request</a></li>`;
                    <?php endif; ?>


                    return `<div class="btn-group" role="group">
                                    <span id="btnGroupDrop1" class="badge ${full.status=='success'? 'badge-success bg-success' : full.status=='pending'? 'badge-warning bg-warning':full.status=='reversed'? 'badge-info bg-info':full.status=='complete'? 'badge-primary bg-primary':'badge-danger'} dropdown-toggle"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    ` + full.status + `
                                    </span>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                       ` + menu + `
                                    </div>
                                 </div>`;
                }
            }
        ];

        datatableSetup(url, options, onDraw);

        $("#transferForm").validate({
            rules: {
                status: {
                    required: true
                },
            },
            messages: {
                fundbank_id: {
                    required: "Please select request status",
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
                        form.find('button:submit').html('Please wait...').attr('disabled',true).addClass('btn-secondary');
                    },
                    complete: function() {
                        form.find('button:submit').html('Submit').attr('disabled',false).removeClass('btn-secondary');
                    },
                    success: function(data) {
                        if (data.status == "success") {
                            form[0].reset();
                            form.closest('.offcanvas').offcanvas('hide');
                            notify("Fund Request Updated Successfully", 'success');
                            $('#datatable').dataTable().api().ajax.reload();
                        } else {
                            notify(data.status, 'warning');
                        }
                    },
                    error: function(errors) {
                        // showError(errors, form);
                        notify(errors.responseJSON.status || "Something",'error');
                        form.find('button:submit').html('Submit').attr('disabled',false).removeClass('btn-secondary');
                    }
                });
            }
        });
    });

    function transfer(id, remark, status) {
        $('#transferForm').find('[name="id"]').val(id);
        $('#transferForm').find('[name="status"]').val(status).trigger('change');
        $('#transferForm').find('[name="remark"]').val(remark);
        $('#transferModal').offcanvas('show');
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.bharatmitra.co/resources/views/fund/requestview.blade.php ENDPATH**/ ?>