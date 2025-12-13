<?php $__env->startSection('title', "Aeps Agents List"); ?>
<?php $__env->startSection('pagetitle', "Aeps Agent List"); ?>

<?php
$table = "yes";

$status['type'] = "Id";
$status['data'] = [
"success" => "Success",
"pending" => "Pending",
"failed" => "Failed",
"approved" => "Approved",
"rejected" => "Rejected",
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
                            <th>Agent Details</th>
                            <th>Details</th>
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

<?php if(Myhelper::can('aepsid_statement_edit')): ?>
<div class="offcanvas offcanvas-end" id="editModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">

    <div class="offcanvas-header bg-primary">
        <div class="text-white mb-3">
            <h4 class="mb-2 text-white">Edit Report</h4>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <form id="editUtiidForm" action="<?php echo e(route('statementUpdate')); ?>" method="post">
        <div class="offcanvas-body">
            <div class="row">
                <input type="hidden" name="user_id">
                <?php echo e(csrf_field()); ?>


                <div class="form-group col-md-12 my-1">
                    <label>Agent Id</label>
                    <input type="text" name="bc_id" class="form-control my-1" required="">
                </div>
                <div class="form-group col-md-12 my-1">
                    <label>Mobile </label>
                    <input type="text" name="phone1" class="form-control my-1" required="">
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-bs-dismiss="offcanvas" aria-label="Close">Close</button>
            <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Update</button>
        </div>
    </form>

</div>
<?php endif; ?>

<div class="offcanvas offcanvas-end" id="viewFullDataModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">

    <div class="offcanvas-header bg-primary">
        <h4 class="text-white" id="exampleModalLabel">Agent Details</h4>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
        </button>
    </div>
    <div class="offcanvas-body">
        <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <th>Agent Id</th>
                        <td class="bc_id"></td>
                    </tr>
                    
                    <tr>
                        <th>Agent Name</th>
                        <td><span class="bc_f_name"></span> <span class="bc_l_name"></span></td>
                    </tr>
                    <tr>
                        <th>Agent Mailid</th>
                        <td class="emailid"></td>
                    </tr>
                    <tr>
                        <th>Phone 1</th>
                        <td class="phone1"></td>
                    </tr>
                     <tr>
                        <th>Pin Code</th>
                        <td class="bc_pincode"></td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td class="gender"></td>
                    </tr>
                    <tr>
                        <th>Shopname</th>
                        <td class="shopname"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="offcanvas" aria-hidden="true">Close</button>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
<script type="text/javascript">
    $(document).ready(function() {

        $("#editUtiidForm").validate({
            rules: {
                bbps_agent_id: {
                    required: true,
                },
            },
            messages: {
                bbps_agent_id: {
                    required: "Please enter id",
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
                var form = $('#editUtiidForm');
                var id = form.find('[name="id"]').val();
                form.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {
                        form.find('button[type="submit"]').html('Please wait...').attr('disabled',true).addClass('btn-secondary');
                        },
                        complete:function(){
                            form.find('button[type="submit"]').html('Update').attr('disabled',false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                            if (id == "new") {
                                form[0].reset();
                            }
                            notify("Task Successfully Completed", 'success');
                            form.closest('.offcanvas').offcanvas('hide');
                            $('#datatable').dataTable().api().ajax.reload();
                        } else {
                            notify(data.status, 'warning');
                        }
                    },
                    error: function(errors) {
                        showError(errors, form);
                    }
                });
            }
        });

        $("#editModal").on('hidden.bs.offcanvas', function() {
            $('#setupModal').find('form')[0].reset();
        });

        var url = "<?php echo e(url('statement/fetch')); ?>/aepsagentstatement/<?php echo e($id); ?>";
        var onDraw = function() {};
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
                    return `Agent Id - ` + full.bc_id + `<br>Agent Name - <a href="javascript:void(0)" onclick="viewFullData(` + full.id + `)">` + full.bc_f_name + `</a>`;
                }
            },
            {
                "data": "bank",
                render: function(data, type, full, meta) {
                    return `Mobile - ` + full.phone1 + `<br>KYC Name -` + full.kyc_name;
                }
            },
            {
                "data": "status",
                render: function(data, type, full, meta) {

                    var menu = '';
                    // <?php if(Myhelper::can('aepsid_statement_edit')): ?>
                    // menu += `<li><a href="javascript:void(0)" class="dropdown-item" onclick="editUtiid(` + full.id + `,'` + full.bbps_agent_id + `','` + full.bbps_id + `')"><i class="icon-pencil5"></i> Edit</a></li>`;
                    // menu += `<li><a href="javascript:void(0)" class="dropdown-item" onclick="status('` + full.id + `','bcstatus')""><i class="icon-refresh"></i> Status</a></li>`;
                    // <?php endif; ?>


                    return `<div class="btn-group" role="group">
                                    <span id="btnGroupDrop1" class="badge ${full.status=='success'? 'bg-success' : full.status=='pending'? 'bg-warning':full.status=='approved'? 'bg-primary':full.status=='refund'? 'bg-dark':'bg-danger'}" aria-haspopup="true" aria-expanded="false">
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
    });

    function viewFullData(id) {
        $.ajax({
                url: `<?php echo e(url('statement/fetch')); ?>/aepsagentstatement/` + id + `/view`,
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
                    console.log(index, values);
                    $("." + index).text(values);
                });
                $('#viewFullDataModal').offcanvas('show');
            })
            .fail(function(errors) {
                notify('Oops', errors.status + '! ' + errors.statusText, 'warning');
            });
    }

    function editUtiid(id, bc_id, phone1) {
        $('#editModal').find('[name="id"]').val(id);
        $('#editModal').find('[name="bc_id"]').val(bc_id);
        $('#editModal').find('[name="phone1"]').val(phone1);
        $('#editModal').offcanvas('show');
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.ismartpay.in/resources/views/statement/aepsid.blade.php ENDPATH**/ ?>