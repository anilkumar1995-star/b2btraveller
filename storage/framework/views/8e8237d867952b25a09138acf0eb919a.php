<?php $__env->startSection('title', 'Quick Links'); ?>
<?php $__env->startSection('pagetitle', 'Quick Links'); ?>
<?php
    $table = 'yes';
    $agentfilter = 'hide';
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
                            <button type="button" class="btn btn-success text-white ms-4" onclick="addSetup()">
                                <i class="ti ti-plus ti-xs"></i> Add New</a>
                        </div>
                    </div>
                </div>
                <div class="card-datatable table-responsive">
                    <table width="100%" class="table border-top mb-5" id="datatable" role="grid"
                        aria-describedby="user-list-page-info">
                        <thead class=" text-center bg-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Link</th>
                                <th>Image/Logo</th>
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


    <div class="offcanvas offcanvas-end" id="setupModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">

        <div class="offcanvas-header bg-primary">
            <div class="text-center">
                <h4 class="text-white">Add Links</h4>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>

        </div>
        <form id="setupManager" action="<?php echo e(route('setupupdate')); ?>" method="post">
            <div class="offcanvas-body">
                <div class="row">
                    <input type="hidden" name="id">
                    <input type="hidden" name="actiontype" value="links">
                    <?php echo e(csrf_field()); ?>

                    <div class="form-group col-md-6 my-1">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control my-1" placeholder="Enter Name"
                            required="">
                    </div>
                    <div class="form-group col-md-6 my-1">
                        <label>Link</label>
                        <input type="text" name="value" class="form-control my-1" placeholder="Enter Link"
                            required="">
                    </div>
                    <div class="form-group col-md-6 my-1">
                        <label>Image/Logo (Optional)</label>
                        <input type="file" name="quickLink" class="form-control my-1">
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit"
                    data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
            </div>
        </form>

    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script type="text/javascript">
        $(document).ready(function() {
            var url = "<?php echo e(url('statement/fetch')); ?>/setup<?php echo e($type); ?>/0";

            var onDraw = function() {};

            var imgurl = `<?php echo e(Imagehelper::getImageUrl()); ?>`

            var options = [{
                    "data": "id"
                },
                {
                    "data": "name"
                },
                {
                    "data": "value"
                },
                {
                    "data": "img",
                    render: function(data, type, full, meta) {
                        var disDetails = "";
                        if (full.img != undefined && full.img != '' && full.img != null) {
                            disDetails += `<a target="_blank" href=` + imgurl+ full.img + `>Image/Logo (Click to view)</a>`
                        }
                        return disDetails;
                    }
                },
                {
                    "data": "action",
                    render: function(data, type, full, meta) {
                        return `<button type="button" class="btn btn-primary" onclick="editSetup(` + full
                            .id + `, \`` + full.name + `\`, \`` + full.value + `\`)"> Edit</button>`;
                    }
                },
            ];
            datatableSetup(url, options, onDraw);

            $("#setupManager").validate({
                rules: {
                    name: {
                        required: true,
                    },
                    value: {
                        required: true,
                    }
                },
                messages: {
                    name: {
                        required: "Please enter value",
                    },
                    value: {
                        required: "Please enter value",
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
                    var form = $('#setupManager');
                    var id = form.find('[name="id"]').val();
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button[type="submit"]').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button[type="submit"]').html('Submit').attr(
                                'disabled', false).removeClass('btn-secondary');
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

            $("#setupModal").on('hidden.bs.offcanvas', function() {
                $('#setupModal').find('.msg').text("Add");
                $('#setupModal').find('form')[0].reset();
            });

        });

        function addSetup() {
            $('#setupModal').find('.msg').text("Add");
            $('#setupModal').find('input[name="id"]').val("new");
            $('#setupModal').offcanvas('show');
        }

        function editSetup(id, name, value) {
            $('#setupModal').find('.msg').text("Edit");
            $('#setupModal').find('input[name="id"]').val(id);
            $('#setupModal').find('[name="name"]').val(name);
            $('#setupModal').find('[name="value"]').val(value);
            $('#setupModal').offcanvas('show');
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.ismartpay.in/resources/views/setup/links.blade.php ENDPATH**/ ?>