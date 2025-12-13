<?php $__env->startSection('title', "Complaints"); ?>
<?php $__env->startSection('pagetitle', "Complaints"); ?>

<?php
$table = "yes";

$product['data'] = array(
'recharge' => 'Recharge',
'billpay' => 'Billpay',
'dmt' => 'Dmt',
'aeps' => 'Aeps',
'utipancard' => 'Utipancard'
);
$product['type'] = "Service";
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
                            <th>Complain Id</th>
                            <th>User Details</th>
                            <th>Transaction Details</th>
                            <th>Subject</th>
                            <th> Query Details</th>
                            <th> Solution Details</th>
                            <th> Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>


<div class="offcanvas offcanvas-end" id="utiidModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">

    <div class="modal-header bg-primary">
        <h5 class="text-white" id="exampleModalLabel">Transaction Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
        </button>
    </div>
    <div class="offcanvas-body p-0">
        <div class="table-responsive">
            <table class="table table-striped ">
                <tbody>
                    <tr>
                        <th>Provider</th>
                        <td class="providername"></td>
                    </tr>
                    <tr>
                        <th>BC Id</th>
                        <td class="aadhar"></td>
                    </tr>
                    <tr>
                        <th>Number</th>
                        <td class="number"></td>
                    </tr>
                    <tr>
                        <th>Mobile</th>
                        <td class="mobile"></td>
                    </tr>
                    <tr>
                        <th>Txnid</th>
                        <td class="txnid"></td>
                    </tr>
                    <tr>
                        <th>Payid</th>
                        <td class="payid"></td>
                    </tr>
                    <tr>
                        <th>Refno</th>
                        <td class="refno"></td>
                    </tr>
                    <tr>
                        <th>Amount</th>
                        <td class="amount"></td>
                    </tr>
                    <tr>
                        <th>Charge</th>
                        <td class="charge"></td>
                    </tr>
                    <tr>
                        <th>Gst</th>
                        <td class="gst"></td>
                    </tr>
                    <tr>
                        <th>Tds</th>
                        <td class="tds"></td>
                    </tr>
                    <tr>
                        <th>Remark</th>
                        <td class="remark"></td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas" aria-hidden="true">Close</button>
    </div>

</div>

<div class="offcanvas offcanvas-end" id="complaintEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">

    <div class="offcanvas-header bg-primary">
        <h5 class="text-white" id="exampleModalLabel">Edit Report</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">

        </button>
    </div>
    <form id="complaintEditForm" action="<?php echo e(route('complaintstore')); ?>" method="post">
        <div class="offcanvas-body">
            <input type="hidden" name="id">
            <?php echo e(csrf_field()); ?>

            <div class="form-group my-1">
                <label>Status</label>
                <select name="status" class="form-control my-1 select">
                    <option value="">Select Status</option>
                    <option value="pending">Pending</option>
                    <option value="resolved">Resolved</option>
                </select>
            </div>
            <div class="form-group my-1">
                <label>Solution</label>
                <textarea name="solution" cols="30" class="form-control my-1" rows="3" required></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Updating">Update</button>
        </div>
    </form>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        var url = "<?php echo e(url('statement/fetch')); ?>/complaints/0";
        var onDraw = function() {};
        var options = [{
                "data": "bank",
                render: function(data, type, full, meta) {
                    return `<div>
                            <span class='text-inverse m-l-10'><b>` + full.id + `</b> </span>
                            <div class="clearfix"></div>
                        </div><span style='font-size:13px' class="pull=right">` + full.created_at + `</span>`;
                }

            },
            {
                "data": "bank",
                render: function(data, type, full, meta) {
                    return full.user.name + ` ( ` + full.user.id + ` )<br>` + full.user.mobile + ` <br>` + full.user.role.name;
                }
            },
            {
                "data": "bank",
                render: function(data, type, full, meta) {
                    return `<a href="javascript:void(0)" class="bg-primary text-white badge badge-primary" style="font-size:15px" onclick="viewData('` + full.transaction_id + `', '` + full.product + `')">` + full.product + ` ( ` + full.transaction_id + ` )` + `</a>`;
                }
            },
            {
                "data": "bank",
                render: function(data, type, full, meta) {
                    return full.subject;
                }
            },
            {
                "data": "bank",
                render: function(data, type, full, meta) {
                    return full.description;
                }
            },
            {
                "data": "bank",
                render: function(data, type, full, meta) {
                    if (full.resolver) {
                        return 'Resolved By - ' + full.resolver.name + '(' + full.resolver.id + ')<br>' + full.solution;
                    } else {
                        return full.solution;
                    }
                }
            },
            {
                "data": "status",
                render: function(data, type, full, meta) {

                    var menu = ``;
                    var out = ``;
                    <?php if(Myhelper::can('complaint_edit')): ?>
                    menu += `
                            <li><a href="javascript:void(0)" class="dropdown-item" onclick="editComplaint(` + full.id + `, '` + full.status + `', '` + full.solution + `')"><i class="icon-pencil5"></i> Edit</a></li>`;
                    <?php endif; ?>


                    out += `<div class="btn-group" role="group">
                                    <span id="btnGroupDrop1" class="badge ${full.status=='success'? 'bg-success badge-success' : full.status=='pending'? 'bg-warning badge-warning':full.status=='reversed'? 'bg-info badge-info':full.status=='refund'? 'bg-dark badge-dark':'bg-danger badge-danger'} dropdown-toggle"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    ` + full.status + `
                                    </span>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                       ` + menu + `
                                    </div>
                                 </div>`;

                    return out;
                }
            }
        ];

        datatableSetup(url, options, onDraw);

        $("#complaintEditForm").validate({
            rules: {
                status: {
                    required: true,
                },
                solution: {
                    required: true,
                }
            },
            messages: {
                status: {
                    required: "Please select status",
                },
                solution: {
                    required: "Please enter your solution",
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
                var form = $('#complaintEditForm');
                form.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {
                        form.find('button:submit').html('Please wait...').attr("disabled", true).addClass('btn-secondary');
                    },
                    success: function(data) {
                        form.find('button:submit').html('Update').attr("disabled", false).removeClass('btn-secondary');
                        if (data.status) {
                            form[0].reset();
                            form.find('select').val(null).trigger('change');
                            form.closest('.offcanvas').offcanvas('hide');
                            $('#datatable').dataTable().api().ajax.reload();
                            notify("Complaint successfully updated", 'success');
                        } else {
                            notify(data.status, 'warning');
                        }
                    },
                    error: function(errors) {
                        form.find('button:submit').html('Update').attr("disabled", false).removeClass('btn-secondary');
                        showError(errors, form);
                    }
                });
            }
        });
    });

    function viewData(id, product) {
        var statement = "";
        if (product == "aeps") {
            statement = "aepsstatement";
        }

        $.ajax({
            url: `<?php echo e(url('statement/fetch')); ?>/` + statement + `/` + id + `/single`,
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            beforeSubmit: function(data) {
                swal({
                    title: 'Wait!',
                    text: 'Please wait, we are working on your request',
                    onOpen: () => {
                        swal.showLoading()
                    },
                    allowOutsideClick: () => !swal.isLoading()
                });
            },
            complete: function(data) {
                swal.close();
            },
            success: function(data) {
                $.each(data, function(index, values) {
                    $("." + index).text(values);
                });
                $('#utiidModal').offcanvas('show');
            },
            error: function(errors) {
                notify('Oops', errors.status + '! ' + errors.statusText, 'warning');
            }
        })

    }

    function editComplaint(id, status, solution) {
        $('#complaintEditModal').find('[name="id"]').val(id);
        $('#complaintEditModal').find('[name="solution"]').val(solution);
        $('#complaintEditModal').find('[name="status"]').val(status).trigger('change');
        $('#complaintEditModal').offcanvas('show');
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.quick2pay.in/resources/views/complaint.blade.php ENDPATH**/ ?>