<?php $__env->startSection('title', 'Matching Percent'); ?>
<?php $__env->startSection('pagetitle', 'Matching Percent'); ?>

<?php
    $table = 'yes';

?>

<?php $__env->startSection('content'); ?>

    <div class="row mt-2">
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
                    <table width="100%" class="table border-top mb-5" id="datatable" role="grid"
                        aria-describedby="user-list-page-info">
                        <thead class=" text-center bg-light">
                            <tr>
                                <th>Id</th>
                                <th>User Details</th>
                                <th>Bene Bank Details</th>
                                <th>Bene Details</th>
                                <th>Matching Percent</th>
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

    <div class="offcanvas offcanvas-end" id="matchingpercentModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">

        <div class="offcanvas-header bg-primary">
            <h5 class="text-white" id="exampleModalLabel">Update Matching Percent</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">

            </button>
        </div>
        <form id="matchingupdateForm" action="<?php echo e(route('percentstore')); ?>" method="post">
            <div class="offcanvas-body">
                <input type="hidden" name="id">
                <?php echo e(csrf_field()); ?>


                <div class="form-group my-1">
                    <label>Matching Percent</label>
                    <input name="match" type="text" class="form-control my-1" rows="3" required />
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit"
                    data-loading-text="<i class='fa fa-spin fa-spinner'></i> Updating">Update</button>
            </div>
        </form>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script type="text/javascript">
        $(document).ready(function() {
        var url = "<?php echo e(url('statement/fetch')); ?>/matchingpercent/0";
        var onDraw = function() {};
        var options = [{
                "data": "id",
                render: function(data, type, full, meta) {
                    return `<div>
                            <span class='text-inverse m-l-10'><b>` + full.id + `</b> </span>
                            <div class="clearfix"></div>
                        </div><span style='font-size:13px' class="pull=right">` + full.created_at + `</span>`;
                }

            },
            {
                "data": "user",
                render: function(data, type, full, meta) {
                    return (full.username == undefined || full.username == null ? '' : full.username);
                }
            },
            {
                "data": "bank",
                render: function(data, type, full, meta) {
                    return `Account No - `+ (full.beneaccount == undefined || full.beneaccount == null ? '' : full.beneaccount)  + ` <br>IFSC - ` + (full.beneifsc == undefined || full.beneifsc == null ? '' : full.beneifsc) + `<br>Bank - ` + (full.bankname.bank == undefined || full.bankname.bank == null ? '' : full.bankname.bank);
                }
            },
            {
                "data": "bank",
                render: function(data, type, full, meta) {
                    return `Name in Bank - ` + (full.name_in_bank == undefined || full.name_in_bank == null ? '' : full.name_in_bank) + ` <br> Bene Mobile - `+ (full.benemobile == undefined || full.benemobile == null ? '' : full.benemobile) + ` <br> KYC Name - `+ (full.agentDetails == undefined || full.agentDetails == null ? '' : full.agentDetails);
                }
            },
            {
                "data": "percent",
                render: function(data, type, full, meta) {
                     return (full.name_match_percent == undefined || full.name_match_percent == null ? '' : full.name_match_percent);
                
                }
            },
            {
                "data": "action",
                render: function(data, type, full, meta) {
                    if(full.name_match_percent != undefined || full.name_match_percent != null){
                    return `<button type="button" class="btn btn-primary btn-sm" onclick="updatepercent(${full.id},${full.name_match_percent})">Update</button>`;
                    }
                    return '';
                }
            }
        ];

        datatableSetup(url, options, onDraw);
     
            $("#matchingupdateForm").validate({
                rules: {
                    match: {
                        required: true,
                    }
                },
                messages: {
                    match: {
                        required: "Please enter matching percent",
                    },
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                submitHandler: function() {
                    var form = $('#matchingupdateForm');
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr("disabled",
                                true).addClass('btn-secondary');
                        },
                        success: function(data) {
                            form.find('button:submit').html('Update').attr("disabled",
                                false).removeClass('btn-secondary');
                            if (data.status) {
                                form[0].reset();
                                form.closest('.offcanvas').offcanvas('hide');
                                $('#datatable').dataTable().api().ajax.reload();
                                notify("Data successfully updated", 'success');
                                // window.location.reload();
                            } else {
                                notify(data.message, 'warning');
                            }
                        },
                        error: function(errors) {
                            console.log(errors.responseJSON.errors.match);
                            form.find('button:submit').html('Update').attr("disabled",
                                false).removeClass('btn-secondary');
                            // showError(errors, form);
                            notify(errors.responseJSON.errors.match[0], 'error');
                        }
                    });
                }
            });
        });

        function updatepercent(id, matchpercent) {
            $('#matchingpercentModal').find('[name="id"]').val(id);
            $('#matchingpercentModal').find('[name="match"]').val(matchpercent);
            $('#matchingpercentModal').offcanvas('show');
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.quick2pay.in/resources/views/matchingpercent.blade.php ENDPATH**/ ?>