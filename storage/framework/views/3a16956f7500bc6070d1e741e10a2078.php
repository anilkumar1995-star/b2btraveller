<?php $__env->startSection('title', ucfirst($type).' Recharge'); ?>
<?php $__env->startSection('pagetitle', ucfirst($type).' Recharge'); ?>
<?php
$table = "yes";
?>

<?php $__env->startSection('content'); ?>
<div class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="card card mb-3">
                <div class="card-body">
                    <h4 class="card-title"><?php echo e(ucfirst($type)); ?> Recharge</h4>
                    <form id="rechargeForm" action="<?php echo e(route('rechargepay')); ?>" method="post" autocomplete="off">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="type" value="<?php echo e($type); ?>">
                        <div class="row">
                            <div class="form-group col-sm-12 col-lg-3 my-1">
                                <label><?php echo e(ucfirst($type)); ?> Number <span class="text-danger fw-bold">*</span></label>
                                <input type="text" name="number" class="form-control my-1" placeholder="Enter <?php echo e($type); ?> number" required="">
                                <!--onchange="getoperator()"-->
                            </div>
                            <div class="form-group col-sm-12 col-lg-3 my-1">
                                <label><?php echo e(ucfirst($type)); ?> Operator <span class="text-danger fw-bold">*</span></label>
                                <select name="provider_id" class="form-control my-1" required="" onchange="getdthinfo()">
                                    <option value="">Select Operator</option>
                                    <?php $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($provider->id); ?>"><?php echo e($provider->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <?php if($type == "mobile"): ?>
                            <div class="form-group col-sm-12 col-lg-3 my-1">
                                <label>Circle</label>
                                <select name="circle" class="form-control my-1" id="circle" required>
                                    <option value="">Select Circle</option>
                                    <?php $__currentLoopData = $circles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $circle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($circle->id); ?>"><?php echo e($circle->circle_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-12 col-lg-3 my-1">
                                <label>Plan Type</label>
                                <select name="rechargeType" class="form-control my-1" id="rechargeType" required>
                                    <option value="">Select Plan Type</option>
                                    <?php $__currentLoopData = $rechargeType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $circle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($circle->rechargeTypeId); ?>"><?php echo e($circle->rechargeType); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <?php endif; ?>

                            <div class="form-group col-sm-12 col-lg-3 my-1">
                                <label>Recharge Amount <span class="text-danger fw-bold">*</span></label>
                                <input type="text" name="amount" class="form-control my-1" placeholder="Enter  amount" required="">
                            </div>
                            <div class="form-group col-sm-12 col-lg-3 my-1">
                                <label>T-Pin <span class="text-danger fw-bold">*</span></label>
                                <input type="password" name="pin" class="form-control my-1" placeholder="Enter transaction pin" required="">
                                <a href="<?php echo e(url('profile/view?tab=pinChange')); ?>" target="_blank" class="text-primary pull-right">Generate Or Forgot Pin??</a>
                            </div>

                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary" data-loading-text="<b><i class='fa fa-spin fa-spinner'></i></b> Paying"><b><i class=" icon-paperplane"></i></b> Pay Now</button>
                                <button type="button" class="btn submit-button btn-success" onclick="getplan()">GET Plan</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-12 ">

            <div class="card mb-3">
                <div class="card-body">
                    <h4 class="card-title">Recent <?php echo e(ucfirst($type)); ?> Recharge</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Recharge Details</th>
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
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="planModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo e(ucfirst($type)); ?> Plans</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body planData">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php if($type == "dth"): ?>


<div class="modal fade" id="dthinfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">DTH Customer Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Name</th>
                        <td class="name"></td>
                    </tr>
                    <tr>
                        <th>Plan Name</th>
                        <td class="planname"></td>
                    </tr>
                    <tr>
                        <th>Balance</th>
                        <td class="balance"></td>
                    </tr>
                    <tr>
                        <th>Monthly Plan</th>
                        <td class="mplan"></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td class="status"></td>
                    </tr>
                    <tr>
                        <th>Recharge Date</th>
                        <td class="date"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        var url = "<?php echo e(url('statement/fetch')); ?>/<?php echo e($type); ?>statement/0";

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
                "data": "bank",
                render: function(data, type, full, meta) {
                    return `Number - ` + full.number + `<br>Operator - ` + full.providername;
                }
            },
            {
                "data": "bank",
                render: function(data, type, full, meta) {
                    return `Amount - <i class="fa fa-inr"></i> ` + full.amount + `<br>Profit - <i class="fa fa-inr"></i> ` + full.profit;
                }
            },
            {
                "data": "status",
                render: function(data, type, full, meta) {
                    if (full.status == "success") {
                        var out = `<span class="badge badge-success bg-success">Success</span>`;
                    } else if (full.status == "pending") {
                        var out = `<span class="badge badge-warning bg-warning">Pending</span>`;
                    } else if (full.status == "reversed") {
                        var out = `<span class="badge badge-primary bg-primary">Reversed</span>`;
                    } else {
                        var out = `<span class="badge badge-danger bg-danger">Failed</span>`;
                    }
                    return out;
                }
            }
        ];

        datatableSetup(url, options, onDraw);

        $("#rechargeForm").validate({
            rules: {
                provider_id: {
                    required: true,
                    number: true,
                },
                number: {
                    required: true,
                    number: true,
                    minlength: 8,
                    maxlength: 11
                },
                amount: {
                    required: true,
                    number: true,
                    min: 10
                },
            },
            messages: {
                provider_id: {
                    required: "Please select <?php echo e($type); ?> operator",
                    number: "Operator id should be numeric",
                },
                number: {
                    required: "Please enter <?php echo e($type); ?> number",
                    number: "<?php echo e($type); ?> number should be numeric",
                    min: "<?php echo e($type); ?> number length should be atleast 8",
                    max: "<?php echo e($type); ?> number length should be less than 14",
                },
                amount: {
                    required: "Please enter <?php echo e($type); ?> amount",
                    number: "Amount should be numeric",
                    min: "Min <?php echo e($type); ?> amount value rs 10",
                }
            },
            errorElement: "p",
            errorPlacement: function(error, element) {
                if (element.prop("tagName").toLowerCase() === "select") {
                    error.insertAfter(element);
                    // error.insertAfter(element.closest(".form-group"));
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function() {
                var form = $('#rechargeForm');
                var id = form.find('[name="id"]').val();
                form.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {
                        form.find('button[type="submit"]').html('Processing...').attr('disabled', true).addClass('btn-secondary');
                    },
                    complete: function() {
                        form.find('button[type="submit"]').html('Pay Now').attr('disabled', false).removeClass('btn-secondary');
                    },
                    success: function(data) {
                        if (data.status == "success" || data.status == "pending" || data.statuscode == "TXN" || data.statuscode == "TXF" || data.statuscode == "TUP") {
                            getbalance();
                            form[0].reset();
                            form.find('select').val(null).trigger('change')
                            if(data.status == "success" || data.statuscode == "TXN"){
                                notify("Recharge " + data.status + "! " + data?.description, 'success');
                            }else if(data.status == "pending" || data.statuscode == "TUP"){
                                notify("Recharge " + data.status + "! " + data?.description, 'warning');    
                            }else{
                                notify("Recharge " + data.status + "! " + data?.description, 'error');
                            }
                            $('#datatable').dataTable().api().ajax.reload();
                        } else {
                            notify(data.status,'error');
                        }
                    },
                    error: function(errors) {

                        // console.log(errors.responseJSON.status);
                        // showError(errors, form);
                        notify(errors.responseJSON.status || errors.responseJSON || errors.responseJSON.message|| "Something went worng", 'error');
                        form.find('button[type="submit"]').html('Pay Now').attr('disabled', false).removeClass('btn-secondary');
                        // notify(errors.responseJSON || errors.responseJSON.status, 'error');
                    }
                });
            }
        });
    });

    function activeTab(targetEle) {
        // alert(targetEle);
        $('.class_for_remove').removeClass('show active');
        $(`#${targetEle}`).addClass('show active');
    }

    function getplan() {
        var operator = $('[name="provider_id"]').val();
        var number = $('[name="number"]').val();
        var circle = $('[name="circle"]').val();
        var type = $('[name="type"]').val();
        var rechargeType = $('[name="rechargeType"]').val();

        if (number != '' && operator != '' && circle != '') {
            $.ajax({
                url: '<?php echo e(route("getplan")); ?>',
                type: 'post',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    "operator": operator,
                    'number': number,
                    'circle': circle,
                    'type': type,
                    'rechargeType': rechargeType
                },
                beforeSend: function() {
                    swal({
                        title: 'Wait!',
                        text: 'Please wait, we are fetching commission details',
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
                    // if ((typeof data.data[0] !== 'undefined' && data.data[0] != null) || data.data.desc == 'Plan Not Available') {
                    //     return;
                    // }

                    if (data.status == "success") {
                        notify("Plan fetch successfully", 'success');
                        var head = `<ul class="nav nav-tabs" id="myTab-1" role="tablist"><li class="nav-item">
                            <a class="nav-link active" id="4GPlan-tabLink" data-toggle="tab" href="#" role="tab" aria-controls="4GPlan-tab" aria-selected="true"><?php echo e(ucfirst($type)); ?> Plan</a>
                            </li>`;
                        var tabdata = ``;
                        var count = 0;

                        $.each(data.data, function(index, value) {
                            console.log('value', value);
                            // count = count + 1;
                            // if (count == "1") {
                            //     var active = "active";
                            // } else {
                            //     var active = "";
                            // }
                            // head += `<li class="nav-item">
                            // <a onClick="activeTab('${count}-tab')" class="nav-link ` + active + `" id="` + count + `-tabLink" data-toggle="tab" href="#` + count + `-tab" role="tab" aria-controls="` + count + `-tab" aria-selected="true">` + index + ` </a>
                            // </li>`;
                            var plandata = ``;
                            // $.each(val, function(index, value) {

                            <?php if($type == "mobile"): ?>
                            plandata += `<tr><td><button class="btn btn-xs btn-primary" onclick="setAmount('` + value.amount + `')" style="width: 70px;padding:2px 0px;font-size: 15px;"><i class="fa fa-inr"></i> ` + value.amount + `</button></td><td>` + value.shortDesc + `</td><td>` + value.longDesc + `</td>
                                    </tr>`;
                            <?php else: ?>
                            // var rss = '';
                            // var validitys = '';
                            // var longdescs = '';
                            // $.each(value.amount, function(validity, amount, longDesc) {
                            //     rss = amount;
                            //     validitys = validity;
                            //     longdescs  = longDesc;
                            // });
                            plandata += `<tr><td><button class="btn  btn-primary" onclick="setAmount('` + value.cost + `')" style="width: 70px;padding:2px 0px;font-size: 15px;"><i class="fa fa-inr"></i> ` + value.cost + `</button></td><td>` + value?.validity_human + `</td><td>` + value?.plan_name + `</td>
                                    </tr>`;
                            <?php endif; ?>
                            // });

                            tabdata += `
                           

                                <tbody>
                                    ` + plandata + `
                                </tbody>
                            
                        </div>
                        `;
                        });

                        head += '</ul>';

                        var htmldata = ` ` + head + `
                            <div class="tab-content" id="myTabContent-2">
                            <div class="tab-pane class_for_remove fade show active" id="4GPlan-tab">
                            <table class="table table-bordered">
                                  <thead class="thead-light">
                                    <tr>
                                        <th width="150px">Amount</th>
                                        <th width="150px">Validity</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                ` + tabdata + `
                                </table>
                            </div>
                        </div>
                        </div>`;

                        $('.planData').html(htmldata);
                        $('#planModal').modal('show');
                    }
                    else{
                        notify(data.message, 'error');   
                    }
                },
                fail: function() {
                    notify('Something went wrong', 'error');
                }
            })
        } else {
            notify('Mobile number, operator and circle field required', 'error');
        }

    }

    function getoperator() {
        <?php if($type == "mobile" || $type == "dth"): ?>
        var number = $('[name="number"]').val();
        if (number != '') {
            $.ajax({
                url: '<?php echo e(route("getoperator")); ?>',
                type: 'post',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'number': number,
                    "type": "<?php echo e($type); ?>"
                },
                beforeSend: function() {
                    swal({
                        title: 'Wait!',
                        text: 'Please wait, we are fetching commission details',
                        onOpen: () => {
                            swal.showLoading()
                        },
                        allowOutsideClick: () => !swal.isLoading()
                    });
                },
                success: function(data) {
                    swal.close();
                    if (data.status == "success") {
                        $("[name='provider_id']").val(data.data).trigger('change');
                        $("[name='circle']").val(data.circle);
                        $("[name='providername']").val(data.providername);
                    } else {
                        notify(data.message, 'error');
                    }
                },
                fail: function() {
                    swal.close();
                    notify('Somthing went wrong', 'error');
                }
            })

        } else {
            notify('Mobile number and operator field required', 'error');
        }
        <?php endif; ?>
    }

    function getdthinfo() {
        <?php if($type == "dth"): ?>
        var number = $('[name="number"]').val();
        var operator = $('[name="provider_id"]').val();
        if (number != '' && operator != '') {
            $.ajax({
                url: '<?php echo e(route("getplan")); ?>',
                type: 'post',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'number': number,
                    "operator": operator
                },
                beforeSend: function() {
                    swal({
                        title: 'Wait!',
                        text: 'Please wait, we are fetching commission details',
                        onOpen: () => {
                            swal.showLoading()
                        },
                        allowOutsideClick: () => !swal.isLoading()
                    });
                },
                success: function(data) {
                    swal.close();
                    console.log(data);
                    if (data.message == "Success") {
                        notify('Plan fetch Successfully', 'success');
                        $('#dthinfo').modal('show');
                        $('.name').text(data.data.customerName);
                        $('.planname').text(data.data.planname);
                        $('.balance').text(data.data.Balance);
                        $('.mplan').text(data.data.MonthlyRecharge);
                        $('.date').text(data.data.NextRechargeDate);
                        $('.status').text(data.data.status);
                    } else {
                        $('.dthinfo').hide();
                        // notify(data.message, 'error');
                    }
                },
                fail: function() {
                    $('.dthinfo').hide();
                    swal.close();
                    notify('Somthing went wrong', 'error');
                }
            })
        } 
        <?php endif; ?>
    }

    function setAmount(amount) {
        $("[name='amount']").val(amount);
        $('#planModal').modal('hide');
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.quick2pay.in/resources/views/service/recharge.blade.php ENDPATH**/ ?>