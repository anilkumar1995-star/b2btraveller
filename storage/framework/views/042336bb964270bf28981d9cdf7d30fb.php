<?php $__env->startSection('title', 'Permissions'); ?>
<?php $__env->startSection('pagetitle', 'Permissions List'); ?>
<?php
$table = "yes";
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
                <div class="col-sm-12 col-md-2 mb-5">
                    <div class="user-list-files d-flex float-right">
                        <button type="button" class="btn btn-success text-white ms-4" onclick="addrole()">
                            <i class="ti ti-plus ti-xs"></i> Add New</button>
                    </div>
                </div>
            </div>
            <div class="card-datatable table-responsive">
                <table width="100%" class="table border-top mb-5" id="datatable" role="grid" aria-describedby="user-list-page-info">
                    <thead class=" text-center bg-light">
                        <tr>
                            <th>#</th>
                            <th> Name</th>
                            <th>Display Name</th>
                            <th>Type</th>
                            <th>Last Updated</th>
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


<div class="offcanvas offcanvas-end" id="permissionModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
            <div class="offcanvas-header bg-primary">
                <div class="text-center">
                    <h4 class="text-white">Add Permission</h4>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>   

                <form id="permissionManager" action="<?php echo e(route('toolsstore', ['type'=>'permission'])); ?>" method="post">
                    <div class="offcanvas-body">
                        <div class="row">
                            <input type="hidden" name="id">
                            <input type="hidden" name="actiontype" value="bank">
                            <?php echo e(csrf_field()); ?>

                            <div class="form-group col-md-6 my-1">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control my-1" placeholder="Enter Permission Name" required="">
                            </div>
                            <div class="form-group col-md-6 my-1">
                                <label>Display Name</label>
                                <input type="text" name="account" class="form-control my-1" placeholder="Enter Display Name" required="">
                            </div>
                            <div class="form-group col-md-12 my-1">
                                <label>Type</label>
                                    <input type="text" name="type" class="form-control my-1" placeholder="Enter Permission Type" required="">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
                    </div>
                </form>
            
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        var url = "<?php echo e(url('statement/fetch/permissions/0')); ?>";
        var onDraw = function() {};
        var options = [{
                "data": "id"
            },
            {
                "data": "slug"
            },
            {
                "data": "name"
            },
            {
                "data": "type"
            },
            {
                "data": "updated_at"
            },
            {
                "data": "action",
                render: function(data, type, full, meta) {
                    return `<button type="button" class="btn btn-primary" onclick="editRole(this)"> Edit</button>`;
                }
            },
        ];
        datatableSetup(url, options, onDraw);

        $("#permissionManager").validate({
            rules: {
                slug: {
                    required: true,
                },
                name: {
                    required: true,
                },
            },
            messages: {
                mobile: {
                    required: "Please enter role slug",
                },
                name: {
                    required: "Please enter role name",
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
                var form = $('#permissionManager');
                var id = $('#permissionManager').find("[name='id']").val();
                form.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {
                        form.find('button[type="submit"]').html('Please wait...').attr('disabled',true).addClass('btn-secondary');
                        },
                        complete:function(){
                            form.find('button[type="submit"]').html('Submit').attr('disabled',false).removeClass('btn-secondary');
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

        $("#permissionModal").on('hidden.bs.offcanvas', function() {
            $('#permissionModal').find('.msg').text("Add");
            $('#permissionModal').find('form')[0].reset();
        });
    });

    function addrole() {
        $('#permissionModal').find('.msg').text("Add");
        $('#permissionModal').find('input[name="id"]').val("new");
        $('#permissionModal').offcanvas('show');
    }

    function editRole(ele) {
        var id = $(ele).closest('tr').find('td').eq(0).text();
        var slug = $(ele).closest('tr').find('td').eq(1).text();
        var name = $(ele).closest('tr').find('td').eq(2).text();
        var type = $(ele).closest('tr').find('td').eq(3).text();

        $('#permissionModal').find('.msg').text("Edit");
        $('#permissionModal').find('input[name="id"]').val(id);
        $('#permissionModal').find('input[name="slug"]').val(slug);
        $('#permissionModal').find('input[name="name"]').val(name);
        $('#permissionModal').find('input[name="type"]').val(type);
        $('#permissionModal').offcanvas('show');
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.ismartpay.in/resources/views/tools/permissions.blade.php ENDPATH**/ ?>