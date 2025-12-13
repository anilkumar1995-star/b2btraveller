<?php $__env->startSection('title', 'Operator List'); ?>
<?php $__env->startSection('pagetitle', 'Operator List'); ?>
<?php
$table = "yes";

$agentfilter = "hide";
$product['type'] = "Operator Type";
$product['data'] = [
"mobile" => "Mobile",
"dth" => "Dth",
"electricity" => "Electricity",
"pancard" => "Pancard",
"dmt" => "Dmt",
"fund" => "Fund",
"lpggas" => "Lpg Gas",
"gas" => "Piped Gas",
"landline" => "Landline",
"postpaid" => "Postpaid",
"broadband" => "Broadband",
"loanrepay" => "Loan Repay",
"lifeinsurance" => "Life Insurance",
"fasttag" => "Fast Tag",
"cable" => "Cable",
"insurance" => "Insurance",
"schoolfees" => "School Fees",
"muncipal" => "Minicipal",
"housing" => "Housing"
];
asort($product['data']);
$status['type'] = "Operator";
$status['data'] = [
"1" => "Active",
"0" => "De-active"
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
                <div class="col-sm-12 col-md-2 mb-5">
                    <div class="user-list-files d-flex float-right">
                        <button type="button" class="btn btn-success text-white ms-4" onclick="addSetup()">
                            <i class="ti ti-plus ti-xs"></i> Add New</a>
                    </div>
                </div>
            </div>
            <div class="card-datatable table-responsive">
                <table width="100%" class="table border-top mb-5" id="datatable" role="grid" aria-describedby="user-list-page-info">
                    <thead class=" text-center bg-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Operator Api</th>
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
                    <h3 class="text-white">Add Operator</h3>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                
            </div>
                <form id="setupManager" action="<?php echo e(route('setupupdate')); ?>" method="post">
                    <div class="offcanvas-body">
                        <div class="row">
                            <input type="hidden" name="id">
                            <input type="hidden" name="actiontype" value="operator">
                            <?php echo e(csrf_field()); ?>

                            <div class="form-group col-md-6 my-1">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control my-1" placeholder="Enter value" required="">
                            </div>
                            <div class="form-group col-md-6 my-1">
                                <label>Recharge1</label>
                                <input type="text" name="recharge1" class="form-control my-1" placeholder="Enter value" required="">
                            </div>
                        </div>
                        <div class="row">
                            <!-- <div class="form-group col-md-6 my-1">
                                <label>Recharge2</label>
                                <input type="text" name="recharge2" class="form-control my-1" placeholder="Enter value" required="">
                            </div> -->
                            <div class="form-group col-md-6 my-1">
                                <label>Operator Type</label>
                                <select name="type" class="form-control my-1" required>
                                    <option value="">Select Operator Type</option>
                                    <option value="mobile">Mobile</option>
                                    <option value="dth">DTH</option>
                                    <option value="electricity">Electricity Bill</option>
                                    <option value="pancard">Pancard</option>
                                    <option value="dmt">Dmt</option>
                                    <option value="aeps">Aeps</option>
                                    <option value="fund">Fund</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 my-1">
                                <label>Api</label>
                                <select name="api_id" class="form-control my-1" required>
                                    <option value="">Select Api</option>
                                    <?php $__currentLoopData = $apis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $api): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($api->id); ?>"><?php echo e($api->product); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="offcanvas" aria-hidden="true">Close</button>
                        <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
                    </div>
                </form>
            
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        var url = "<?php echo e(url('statement/fetch')); ?>/setup<?php echo e($type); ?>/0";

        var onDraw = function() {
            // $('select').select2();
            $('input.operatorStatusHandler').on('click', function(evt) {
                evt.stopPropagation();
                var ele = $(this);
                var id = $(this).val();
                var status = "0";
                if ($(this).prop('checked')) {
                    status = "1";
                }

                $.ajax({
                        url: `<?php echo e(route('setupupdate')); ?>`,
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        data: {
                            'id': id,
                            'status': status,
                            "actiontype": "operator"
                        }
                    })
                    .done(function(data) {
                        if (data.status == "success") {
                            notify("Operator Updated", 'success');
                            form.closest('.offcanvas').offcanvas('hide');
                            $('#datatable').dataTable().api().ajax.reload();
                        } else {
                            if (status == "1") {
                                ele.prop('checked', false);
                            } else {
                                ele.prop('checked', true);
                            }
                            notify("Something went wrong, Try again.", 'warning');
                        }
                    })
                    .fail(function(errors) {
                        if (status == "1") {
                            ele.prop('checked', false);
                        } else {
                            ele.prop('checked', true);
                        }
                        showError(errors, "withoutform");
                    });
            });
        };

        var options = [{
                "data": "id"
            },
            {
                "data": "name"
            },
            {
                "data": "type"
            },
            {
                "data": "name",
                render: function(data, type, full, meta) {
                    var check = "";
                    if (full.status == "1") {
                        check = "checked='checked'";
                    }

                    return `<div class="form-check-size"> <div class="form-check form-switch form-check-inline">
                              <input type="checkbox" class="form-check-input custom-control-input operatorStatusHandler" id="operatorStatus_${full.id}" ${check} value="` + full.id + `" actionType="` + type + `">
                              <label class="custom-control-label" for="operatorStatus_${full.id}"></label>
                           </div></div>`;
                }
            },
            {
                "data": "name",
                render: function(data, type, full, meta) {
                    var out = "";
                    out += `<select class="form-control" required="" onchange="apiUpdate(this, ` + full.id + `)">`;
                    <?php $__currentLoopData = $apis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $api): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    var apiid = "<?php echo e($api->id); ?>";
                    out += `<option value="<?php echo e($api->id); ?>"`;
                    if (apiid == full.api_id) {
                        out += `selected="selected"`;
                    }
                    out += `><?php echo e($api->product); ?></option>`;
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    out += `</select>`;
                    return out;
                }
            },
            {
                "data": "action",
                render: function(data, type, full, meta) {
                    return `<button type="button" class="btn btn-primary" onclick="editSetup(` + full.id + `, \`` + full.name + `\`, \`` + full.recharge1 + `\`, \`` + full.recharge2 + `\`, \`` + full.type + `\`, \`` + full.api_id + `\`)"> Edit</button>`;
                }
            },
        ];
        datatableSetup(url, options, onDraw);

        $("#setupManager").validate({
            rules: {
                name: {
                    required: true,
                },
                recharge1: {
                    required: true,
                },
                recharge2: {
                    required: true,
                },
                type: {
                    required: true,
                },
                api_id: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: "Please enter operator name",
                },
                recharge1: {
                    required: "Please enter value",
                },
                recharge2: {
                    required: "Please enter value",
                },
                type: {
                    required: "Please select operator type",
                },
                api_id: {
                    required: "Please select api",
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
                        form.find('button[type="submit"]').html('Please wait...').attr('disabled',true).addClass('btn-secondary');
                        },
                        complete:function(){
                            form.find('button[type="submit"]').html('Submit').attr('disabled',false).removeClass('btn-secondary');
                        },
                        success: function(data) {if (data.status == "success") {
                            if (id == "new") {
                                form[0].reset();
                                $('[name="api_id"]').val(null).trigger('change');
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

    function editSetup(id, name, recharge1, recharge2, type, api_id) {
        $('#setupModal').find('.msg').text("Edit");
        $('#setupModal').find('input[name="id"]').val(id);
        $('#setupModal').find('input[name="name"]').val(name);
        $('#setupModal').find('input[name="recharge1"]').val(recharge1);
        $('#setupModal').find('input[name="recharge2"]').val(recharge2);
        $('#setupModal').find('[name="type"]').val(type).trigger('change');
        $('#setupModal').find('[name="api_id"]').val(api_id).trigger('change');
        $('#setupModal').offcanvas('show');
    }

    function apiUpdate(ele, id) {
        var api_id = $(ele).val();
        if (api_id != "") {
            $.ajax({
                    url: `<?php echo e(route('setupupdate')); ?>`,
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    data: {
                        'id': id,
                        'api_id': api_id,
                        "actiontype": "operator"
                    }
                })
                .done(function(data) {
                    if (data.status == "success") {
                        notify("Operator Updated", 'success');
                    } else {
                        notify("Something went wrong, Try again.", 'warning');
                    }
                    $('#datatable').dataTable().api().ajax.reload();
                })
                .fail(function(errors) {
                    showError(errors, "withoutform");
                });
        }
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.bharatmitra.co/resources/views/setup/operator.blade.php ENDPATH**/ ?>