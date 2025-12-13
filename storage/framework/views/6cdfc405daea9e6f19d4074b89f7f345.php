<?php $__env->startSection('title', 'Roles'); ?>
<?php $__env->startSection('pagetitle', 'Role List'); ?>
<?php
$table = 'yes';
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
                            <th>Name</th>
                            <th>Display Name</th>
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


<div class="offcanvas offcanvas-end" id="roleModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="offcanvas-header bg-primary">
        <div class="text-center">
            <h4 class="text-white">Add Role</h4>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <form id="rolemanager" action="<?php echo e(route('toolsstore', ['type' => 'roles'])); ?>" method="post">
        <div class="offcanvas-body">
            <div class="row">
                <input type="hidden" name="id">
                
                <?php echo e(csrf_field()); ?>

                <div class="form-group col-md-6 my-1">
                    <label>Role Name</label>
                    <input type="text" name="slug" class="form-control my-1" placeholder="Enter Role Name" required="">
                </div>
                <div class="form-group col-md-6 my-1">
                    <label>Display Name</label>
                    <input type="text" name="name" class="form-control my-1" placeholder="Enter Display Name" required="">
                </div>

            </div>

        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
        </div>
    </form>

</div>


<?php if(isset($permissions) && $permissions): ?>

<div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-hidden="true" id="permissionModal" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Member Permission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <form id="permissionForm" action="<?php echo e(route('toolssetpermission')); ?>" method="post">
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="role_id">
                <input type="hidden" name="type" value="permission">
                <div class="modal-body p-0">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th width="230px;">Section Category</th>
                                    <th>
                                        <span class="pull-left m-t-5 m-l-10">Permissions</span>
                                        <div class="md-checkbox pull-right">
                                            <input type="checkbox" id="selectall">
                                            <label for="selectall">Select All</label>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="selectall" id="<?php echo e(ucfirst($key)); ?>">
                                        <label for="<?php echo e(ucfirst($key)); ?>"><?php echo e(ucfirst($key)); ?></label>

                                    </td>

                                    <td class="row">
                                        <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-sm-4 py-1">
                                            <input type="checkbox" class="case" id="<?php echo e($permission->id); ?>" name="permissions[]" value="<?php echo e($permission->id); ?>">
                                            <label for="<?php echo e($permission->id); ?>"><?php echo e($permission->name); ?></label>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="offcanvas offcanvas-end" id="schemeModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">

    <div class="offcanvas-header bg-primary">
        <div class="text-center">
            <h4 class="text-white">Scheme Manager</h4>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>

    </div>
    <form id="schemeForm" method="post" action="<?php echo e(route('toolssetpermission')); ?>">
        <?php echo e(csrf_field()); ?>

        <div class="offcanvas-body">
            <div class="row">
                <input type="hidden" name="role_id">
                <input type="hidden" name="type" value="scheme">
                <div class="form-group col-md-12 my-1">
                    <label>Scheme</label>
                    <select class="form-control my-1" name="permissions[]">
                        <option value="">Select Scheme</option>
                        <?php $__currentLoopData = $scheme; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($element->id); ?>"><?php echo e($element->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
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
<style>
    .md-checkbox {
        margin: 5px 0px;
    }
</style>
<?php $__env->stopPush(); ?>


<?php $__env->startPush('script'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        var url = "<?php echo e(url('statement/fetch/roles/0')); ?>";
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
                "data": "updated_at"
            },
            {
                "data": "action",
                render: function(data, type, full, meta) {
                    var menu = ``;

                    // <?php if(Myhelper::can(['fund_transfer', 'fund_return'])): ?>
                    // menu +=
                    //     `<a href="javascript:void(0)" class="dropdown-item" onclick="editRole(this)"><i class="fa fa-pencil"></i> Edit</a>`;
                    // <?php endif; ?>

                    <?php if(Myhelper::can('member_permission_change')): ?>
                    menu +=
                        `<a href="javascript:void(0)" class="dropdown-item" onclick="getPermission(` +
                        full.id + `)"><i class="icon-cogs"></i> Permission</a>`;
                    <?php endif; ?>

                    <?php if(Myhelper::can('member_scheme_change')): ?>
                    menu += `<a href="javascript:void(0)" class="dropdown-item" onclick="scheme(${full.id},${full.scheme})"><i class="icon-wallet"></i> Scheme</a>`;
                    <?php endif; ?>

                    out = ` <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                   More
                                    </button>
                                    <div class="dropdown-menu" style="height:140px;" aria-labelledby="btnGroupDrop1">
                                       ` + menu + `
                                    </div>
                                 </div>`;

                    return out;
                }
            },
        ];
        datatableSetup(url, options, onDraw);

        $("#rolemanager").validate({
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
                var form = $('#rolemanager');
                form.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {
                        form.find('button[type="submit"]').html('Please wait...').attr('disabled', true).addClass('btn-secondary');
                    },
                    success: function(data) {
                        form.find('button[type="submit"]').html('Submit').attr('disabled', false).removeClass('btn-secondary')
                        if (data.status == "success") {
                            notify("Task Successfully Completed", 'success');
                            form.closest('.offcanvas').offcanvas('hide');
                            $('#datatable').dataTable().api().ajax.reload();
                            if (id == "new") {
                                form[0].reset();
                            }
                        } else {
                            notify(data.status, 'warning');
                        }
                    },
                    error: function(errors) {
                        form.find('button[type="submit"]').html('Submit').attr('disabled', false).removeClass('btn-secondary')
                        showError(errors, form);
                    }
                });
            }
        });

        $("#roleModal").on('hidden.bs.modal', function() {
            $('#roleModal').find('.msg').text("Add");
            $('#roleModal').find('form')[0].reset();
        });

        $('form#permissionForm').submit(function() {
            var form = $(this);
            $(this).ajaxSubmit({
                dataType: 'json',
                beforeSubmit: function() {
                    form.find('button[type="submit"]').html('Please wait...').attr('disabled', true).addClass('btn-secondary');
                },
                complete: function() {
                    form.find('button[type="submit"]').html('Submit').attr('disabled', false).removeClass('btn-secondary');
                },
                success: function(data) {
                    if (data.status == "success") {
                        notify('Permission Set Successfully', 'success');
                        $('#permissionModal').modal('hide');
                    } else {
                        notify('Transaction Failed', 'warning');
                    }
                },
                error: function(errors) {
                    showError(errors, form);
                }
            });
            return false;
        });

        $('#selectall').click(function(event) {
            if (this.checked) {
                $('.case').each(function() {
                    this.checked = true;
                });
                $('.selectall').each(function() {
                    this.checked = true;
                });
            } else {
                $('.case').each(function() {
                    this.checked = false;
                });
                $('.selectall').each(function() {
                    this.checked = false;
                });
            }
        });

        $('.selectall').click(function(event) {
            if (this.checked) {
                $(this).closest('tr').find('.case').each(function() {
                    this.checked = true;
                });
            } else {
                $(this).closest('tr').find('.case').each(function() {
                    this.checked = false;
                });
            }
        });


        $("#schemeForm").validate({
            rules: {
                scheme_id: {
                    required: true
                }
            },
            messages: {
                scheme_id: {
                    required: "Please select scheme",
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
                var form = $('#schemeForm');
                var type = $('#schemeForm').find('[name="type"]').val();
                form.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {
                        form.find('button:submit').html('Please wait...').attr('disabled',true).addClass('btn-secondary');
                    },
                    success: function(data) {
                        console.log('data'.data);
                        form.find('button:submit').html('Submit').attr('disabled',false).removeClass('btn-secondary');
                        if (data.status == "success") {
                            getbalance();
                            notify("Role Scheme Updated Successfull", 'success');
                            form.closest('.offcanvas').offcanvas('hide');
                            $('#datatable').dataTable().api().ajax.reload();
                        } else {
                            notify(data.status, 'warning');
                        }
                    },
                    error: function(errors) {
                        form.find('button:submit').html('Submit').attr('disabled',false).removeClass('btn-secondary');
                        showError(errors, form);
                    }
                });
            }
        });
    });

    function addrole() {
        $('#roleModal').find('.panel-title').text("Add New Role");
        $('#roleModal').find('input[name="id"]').val("new");
        $('#roleModal').offcanvas('show');
    }

    function editRole(ele) {
        var id = $(ele).closest('tr').find('td').eq(0).text();
        var slug = $(ele).closest('tr').find('td').eq(1).text();
        var name = $(ele).closest('tr').find('td').eq(2).text();

        $('#roleModal').find('.msg').text("Edit");
        $('#roleModal').find('input[name="id"]').val(id);
        $('#roleModal').find('input[name="slug"]').val(slug);
        $('#roleModal').find('input[name="name"]').val(name);
        $('#roleModal').offcanvas('show');
    }

    function getPermission(id) {
        if (id.length != '') {
            $.ajax({
                    url: `<?php echo e(url('tools/getdefault/permission')); ?>/` + id,
                    type: 'post',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                })
                .done(function(data) {
                    $('#permissionForm').find('[name="role_id"]').val(id);
                    $('.case').each(function() {
                        this.checked = false;
                    });
                    $.each(data, function(index, val) {
                        $('#permissionForm').find('input[value=' + val.permission_id + ']').prop('checked',
                            true);
                    });
                    $('#permissionModal').modal('show');
                })
                .fail(function() {
                    notify('Somthing went wrong', 'warning');
                });
        }
    }

    function scheme(id, scheme) {
        $('#schemeForm').find('[name="role_id"]').val(id);
        if (scheme != '' && scheme != null && scheme != 'null') {
            $('#schemeForm').find('[name="permissions[]"]').val(scheme).trigger('change');
        }
        $('#schemeModal').offcanvas('show');
    }
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.ismartpay.in/resources/views/tools/roles.blade.php ENDPATH**/ ?>