<?php $__env->startSection('title', 'Scheme Manager'); ?>
<?php $__env->startSection('pagetitle', 'Scheme Manager'); ?>


<?php
$table = 'yes';
$agentfilter = 'hide';
$status['type'] = 'Scheme';
$status['data'] = [
'1' => 'Active',
'0' => 'De-active',
];
?>

<?php $__env->startSection('content'); ?>
<div class="row mt-4">
    <div class="col-12 col-xl-12 col-sm-12 order-1 order-lg-2 mb-4 mb-lg-0">
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4">
                <div class="card-title mb-0">
                    <h5 class="mb-0">
                        <span><?php echo $__env->yieldContent('pagetitle'); ?> </span>
                    </h5>
                </div>
                <div class="col-sm-12 col-md-2 mb-5">
                    <div class="user-list-files d-flex float-right">
                        <button type="button" class="btn btn-success text-white ms-4" onclick="addSetup()"> <i class="ti ti-plus ti-xs"></i> Add New</button>

                    </div>
                </div>
            </div>

            <div class="card-datatable table-responsive" style="overflow-x: visible;">

                <table class="table  border-top mb-5" id="datatable">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>


<!-- / Content -->
<!-- Modal -->


<div class="offcanvas offcanvas-end" id="setupModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">

    <div class="offcanvas-header bg-primary">
        <h5 class="offcanvas-title text-white" id="exampleModalLabel1">Add Scheme</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <form id="setupManager" action="<?php echo e(route('resourceupdate')); ?>" method="post">
        <div class="offcanvas-body">
            <div class="row">
                <input type="hidden" name="id">
                <input type="hidden" name="actiontype" value="scheme">
                <?php echo e(csrf_field()); ?>


                <div class="form-group col-md-10 m-auto">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control my-1" placeholder="Enter Scheme Name" required="">
                </div>

            </div>

        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Add</button>
        </div>
    </form>

</div>



<div class="modal fade bd-example-modal-xl" id="mobileModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mobile Recharge Commission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <form class="commissionForm" method="post" action="<?php echo e(route('resourceupdate')); ?>">

                <div class="modal-body">

                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="actiontype" value="commission">
                    <input type="hidden" name="scheme_id" value="">
                    <table class="table table-bordered m-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Operator</th>
                                <?php if(Myhelper::hasRole('admin')): ?>
                                <th>Commission Type</th>
                                <?php endif; ?>
                                <th>Whitelable</th>
                                <th>Master Distributor</th>
                                <th>Distributor</th>
                                <th>Retailer</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $__currentLoopData = $mobileOperator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <input type="hidden" name="slab[]" value="<?php echo e($element->id); ?>">
                                    <?php echo e($element->name); ?>

                                </td>
                                <?php if(Myhelper::hasRole('admin')): ?>
                                <td class="p-t-0 p-b-0">
                                    <select class="form-control my-1" name="type[]" required="">
                                        <option value="">Select Type</option>
                                        <option value="percent">Percent (%)</option>
                                        <option value="flat">Flat (Rs)</option>
                                    </select>
                                </td>
                                <?php endif; ?>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="whitelable[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="md[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="distributor[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="retailer[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade bd-example-modal-xl" id="allBillPamentModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bill Payments Commission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <form class="commissionForm" method="post" action="<?php echo e(route('resourceupdate')); ?>">

                <div class="modal-body">

                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="actiontype" value="commission">
                    <input type="hidden" name="scheme_id" value="">
                    <table class="table table-bordered m-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Operator</th>
                                <?php if(Myhelper::hasRole('admin')): ?>
                                <th>Commission Type</th>
                                <?php endif; ?>
                                <th>Whitelable</th>
                                <th>Master Distributor</th>
                                <th>Distributor</th>
                                <th>Retailer</th>
                            </tr>
                        </thead>
                        <tbody>
                            

                            <?php $__currentLoopData = $allBillPayOperator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <input type="hidden" name="slab[]" value="<?php echo e($element->service_slug); ?>">
                                    <?php echo e($element->service_name); ?>

                                </td>
                                <?php if(Myhelper::hasRole('admin')): ?>
                                <td class="p-t-0 p-b-0">
                                    <select class="form-control my-1" name="type[]" required="">
                                        <option value="">Select Type</option>
                                        <option value="percent">Percent (%)</option>
                                        <option value="flat">Flat (Rs)</option>
                                    </select>
                                </td>
                                <?php endif; ?>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="whitelable[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="md[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="distributor[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="retailer[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-xl" id="dthModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">DTH Recharge Commission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <form class="commissionForm" method="post" action="<?php echo e(route('resourceupdate')); ?>">
                <div class="modal-body">
                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="actiontype" value="commission">
                    <input type="hidden" name="scheme_id" value="">
                    <table class="table table-bordered m-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Operator</th>
                                <?php if(Myhelper::hasRole('admin')): ?>
                                <th>Commission Type</th>
                                <?php endif; ?>
                                <th>Whitelable</th>
                                <th>Master Distributor</th>
                                <th>Distributor</th>
                                <th>Retailer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $dthOperator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <input type="hidden" name="slab[]" value="<?php echo e($element->id); ?>">
                                    <?php echo e($element->name); ?>

                                </td>
                                <?php if(Myhelper::hasRole('admin')): ?>
                                <td class="p-t-0 p-b-0">
                                    <select class="form-control my-1" name="type[]" required="">
                                        <option value="">Select Type</option>
                                        <option value="percent">Percent (%)</option>
                                        <option value="flat">Flat (Rs)</option>
                                    </select>
                                </td>
                                <?php endif; ?>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="whitelable[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="md[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="distributor[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="retailer[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-xl" id="electricModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Electricity Bill Commission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <form class="commissionForm" method="post" action="<?php echo e(route('resourceupdate')); ?>">
                <div class="modal-body">
                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="actiontype" value="commission">
                    <input type="hidden" name="scheme_id" value="">
                    <table class="table table-bordered m-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Operator</th>
                                <?php if(Myhelper::hasRole('admin')): ?>
                                <th>Commission Type</th>
                                <?php endif; ?>
                                <th>Whitelable</th>
                                <th>Master Distributor</th>
                                <th>Distributor</th>
                                <th>Retailer</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $__currentLoopData = $ebillOperator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <input type="hidden" name="slab[]" value="<?php echo e($element->id); ?>">
                                    <?php echo e($element->name); ?>

                                </td>
                                <?php if(Myhelper::hasRole('admin')): ?>
                                <td class="p-t-0 p-b-0">
                                    <select class="form-control my-1" name="type[]" required="">
                                        <option value="">Select Type</option>
                                        <option value="percent">Percent (%)</option>
                                        <option value="flat">Flat (Rs)</option>
                                    </select>
                                </td>
                                <?php endif; ?>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="whitelable[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="md[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="distributor[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="retailer[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        </tbody>
                    </table>

                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>


</div>


<div class="modal fade bd-example-modal-xl" id="lpggasModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">LPG GAS Bill Commission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <form class="commissionForm" method="post" action="<?php echo e(route('resourceupdate')); ?>">
                <div class="modal-body">
                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="actiontype" value="commission">
                    <input type="hidden" name="scheme_id" value="">
                    <table class="table table-bordered m-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Operator</th>
                                <?php if(Myhelper::hasRole('admin')): ?>
                                <th>Commission Type</th>
                                <?php endif; ?>
                                <th>Whitelable</th>
                                <th>Master Distributor</th>
                                <th>Distributor</th>
                                <th>Retailer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $lpggasOperator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <input type="hidden" name="slab[]" value="<?php echo e($element->id); ?>">
                                    <?php echo e($element->name); ?>

                                </td>
                                <?php if(Myhelper::hasRole('admin')): ?>
                                <td class="p-t-0 p-b-0">
                                    <select class="form-control my-1" name="type[]" required="">
                                        <option value="">Select Type</option>
                                        <option value="percent">Percent (%)</option>
                                        <option value="flat">Flat (Rs)</option>
                                    </select>
                                </td>
                                <?php endif; ?>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="whitelable[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="md[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="distributor[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="retailer[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-xl" tabindex="-1" id="waterModal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Water Bill Commission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>
            <form class="commissionForm" method="post" action="<?php echo e(route('resourceupdate')); ?>">
                <div class="modal-body">
                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="actiontype" value="commission">
                    <input type="hidden" name="scheme_id" value="">
                    <table class="table table-bordered m-0">
                        <thead class="thead-light">
                            <th>Operator</th>
                            <?php if(Myhelper::hasRole('admin')): ?>
                            <th>Commission Type</th>
                            <?php endif; ?>
                            <th>Whitelable</th>
                            <th>Master Distributor</th>
                            <th>Distributor</th>
                            <th>Retailer</th>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $waterOperator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <input type="hidden" name="slab[]" value="<?php echo e($element->id); ?>">
                                    <?php echo e($element->name); ?>

                                </td>
                                <?php if(Myhelper::hasRole('admin')): ?>
                                <td class="p-t-0 p-b-0">
                                    <select class="form-control my-1" name="type[]" required="">
                                        <option value="">Select Type</option>
                                        <option value="percent">Percent (%)</option>
                                        <option value="flat">Flat (Rs)</option>
                                    </select>
                                </td>
                                <?php endif; ?>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="whitelable[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="md[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="distributor[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="retailer[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-xl" id="loanrepayModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Loanrepay Bill Commission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>
            <form class="commissionForm" method="post" action="<?php echo e(route('resourceupdate')); ?>">
                <div class="modal-body">
                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="actiontype" value="commission">
                    <input type="hidden" name="scheme_id" value="">
                    <table class="table table-bordered m-0">
                        <thead class="thead-light">
                            <th>Operator</th>
                            <?php if(Myhelper::hasRole('admin')): ?>
                            <th>Commission Type</th>
                            <?php endif; ?>
                            <th>Whitelable</th>
                            <th>Master Distributor</th>
                            <th>Distributor</th>
                            <th>Retailer</th>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $loanrepayOperator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <input type="hidden" name="slab[]" value="<?php echo e($element->id); ?>">
                                    <?php echo e($element->name); ?>

                                </td>
                                <?php if(Myhelper::hasRole('admin')): ?>
                                <td class="p-t-0 p-b-0">
                                    <select class="form-control my-1" name="type[]" required="">
                                        <option value="">Select Type</option>
                                        <option value="percent">Percent (%)</option>
                                        <option value="flat">Flat (Rs)</option>
                                    </select>
                                </td>
                                <?php endif; ?>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="whitelable[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="md[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="distributor[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="retailer[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-xl" id="fasttagModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Fasttag Bill Commission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>
            <form class="commissionForm" method="post" action="<?php echo e(route('resourceupdate')); ?>">
                <div class="modal-body">
                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="actiontype" value="commission">
                    <input type="hidden" name="scheme_id" value="">
                    <table class="table table-bordered m-0">
                        <thead class="thead-light">
                            <th>Operator</th>
                            <?php if(Myhelper::hasRole('admin')): ?>
                            <th>Commission Type</th>
                            <?php endif; ?>
                            <th>Whitelable</th>
                            <th>Master Distributor</th>
                            <th>Distributor</th>
                            <th>Retailer</th>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $fasttagOperator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <input type="hidden" name="slab[]" value="<?php echo e($element->id); ?>">
                                    <?php echo e($element->name); ?>

                                </td>
                                <?php if(Myhelper::hasRole('admin')): ?>
                                <td class="p-t-0 p-b-0">
                                    <select class="form-control my-1" name="type[]" required="">
                                        <option value="">Select Type</option>
                                        <option value="percent">Percent (%)</option>
                                        <option value="flat">Flat (Rs)</option>
                                    </select>
                                </td>
                                <?php endif; ?>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="whitelable[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="md[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="distributor[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="retailer[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-xl" id="cableModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cable Bill Commission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>
            <form class="commissionForm" method="post" action="<?php echo e(route('resourceupdate')); ?>">

                <div class="modal-body">
                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="actiontype" value="commission">
                    <input type="hidden" name="scheme_id" value="">
                    <table class="table table-bordered m-0">
                        <thead class="thead-light">
                            <th>Operator</th>
                            <?php if(Myhelper::hasRole('admin')): ?>
                            <th>Commission Type</th>
                            <?php endif; ?>
                            <th>Whitelable</th>
                            <th>Master Distributor</th>
                            <th>Distributor</th>
                            <th>Retailer</th>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $cableOperator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <input type="hidden" name="slab[]" value="<?php echo e($element->id); ?>">
                                    <?php echo e($element->name); ?>

                                </td>
                                <?php if(Myhelper::hasRole('admin')): ?>
                                <td class="p-t-0 p-b-0">
                                    <select class="form-control my-1" name="type[]" required="">
                                        <option value="">Select Type</option>
                                        <option value="percent">Percent (%)</option>
                                        <option value="flat">Flat (Rs)</option>
                                    </select>
                                </td>
                                <?php endif; ?>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="whitelable[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="md[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="distributor[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="retailer[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>

                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-xl" id="upipayoutModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">UPI Payout Transfer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>
            <form class="commissionForm" method="post" action="<?php echo e(route('resourceupdate')); ?>">

                <div class="modal-body">
                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="actiontype" value="commission">
                    <input type="hidden" name="scheme_id" value="">
                    <table class="table table-bordered m-0">
                        <thead class="thead-light">
                            <th>Operator</th>
                            <?php if(Myhelper::hasRole('admin')): ?>
                            <th>Type</th>
                            <?php endif; ?>
                            <th>Whitelable</th>
                            <th>Master Distributor</th>
                            <th>Distributor</th>
                            <th>Retailer</th>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $upiOperator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <input type="hidden" name="slab[]" value="<?php echo e($element->id); ?>">
                                    <?php echo e($element->name); ?>

                                </td>
                                <?php if(Myhelper::hasRole('admin')): ?>
                                <td>
                                    <?php if($element->recharge1 == 'dmt1accverify'): ?>
                                    <input type="hidden" name="type[]" value="flat">
                                    Flat
                                    <?php else: ?>
                                    <select class="form-control my-1" name="type[]" required="">
                                        <option value="">Select Type</option>
                                        <option value="percent">Percent (%)</option>
                                        <option value="flat">Flat (Rs)</option>
                                    </select>
                                    <?php endif; ?>
                                </td>
                                <?php endif; ?>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="whitelable[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="md[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="distributor[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="retailer[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>


<div class="modal fade bd-example-modal-xl" id="qrcollectModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Van Collection Charge</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form class="commissionForm" method="post" action="<?php echo e(route('resourceupdate')); ?>">

                <div class="modal-body">

                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="actiontype" value="commission">
                    <input type="hidden" name="scheme_id" value="">
                    <table class="table table-bordered m-0">
                        <thead class="thead-light">
                            <th>Operator</th>
                            <?php if(Myhelper::hasRole('admin')): ?>
                            <th>Commission Type</th>
                            <?php endif; ?>
                            <th>Whitelable</th>
                            <th>Master Distributor</th>
                            <th>Distributor</th>
                            <th>Retailer</th>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $qrOperator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <input type="hidden" name="slab[]" value="<?php echo e($element->id); ?>">
                                    <?php echo e($element->name); ?>

                                </td>
                                <?php if(Myhelper::hasRole('admin')): ?>
                                <td class="p-t-0 p-b-0">
                                    <select class="form-control my-1" name="type[]" required="">
                                        <option value="">Select Type</option>
                                        <option value="percent">Percent (%)</option>
                                        <option value="flat">Flat (Rs)</option>
                                    </select>
                                </td>
                                <?php endif; ?>

                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="whitelable[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="md[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="distributor[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="retailer[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-xl" id="postpaidModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Postpaid Bill Commission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>
            <form class="commissionForm" method="post" action="<?php echo e(route('resourceupdate')); ?>">
                <div class="modal-body">
                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="actiontype" value="commission">
                    <input type="hidden" name="scheme_id" value="">
                    <table class="table table-bordered m-0">
                        <thead class="thead-light">
                            <th>Operator</th>
                            <?php if(Myhelper::hasRole('admin')): ?>
                            <th>Commission Type</th>
                            <?php endif; ?>
                            <th>Whitelable</th>
                            <th>Master Distributor</th>
                            <th>Distributor</th>
                            <th>Retailer</th>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $postpaidOperator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <input type="hidden" name="slab[]" value="<?php echo e($element->id); ?>">
                                    <?php echo e($element->name); ?>

                                </td>
                                <?php if(Myhelper::hasRole('admin')): ?>
                                <td class="p-t-0 p-b-0">
                                    <select class="form-control my-1" name="type[]" required="">
                                        <option value="">Select Type</option>
                                        <option value="percent">Percent (%)</option>
                                        <option value="flat">Flat (Rs)</option>
                                    </select>
                                </td>
                                <?php endif; ?>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="whitelable[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="md[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="distributor[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="retailer[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-xl" id="matmModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">MATM Commission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>
            <form class="commissionForm" method="post" action="<?php echo e(route('resourceupdate')); ?>">
                <div class="modal-body">
                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="actiontype" value="commission">
                    <input type="hidden" name="scheme_id" value="">
                    <table class="table table-bordered m-0">
                        <thead class="thead-light">
                            <th>Operator</th>
                            <?php if(Myhelper::hasRole('admin')): ?>
                            <th>Commission Type</th>
                            <?php endif; ?>
                            <th>Whitelable</th>
                            <th>Master Distributor</th>
                            <th>Distributor</th>
                            <th>Retailer</th>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $matmOperator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <input type="hidden" name="slab[]" value="<?php echo e($element->id); ?>">
                                    <input type="hidden" name="type[]" value="flat">
                                    <?php echo e($element->name); ?>

                                </td>
                                <?php if(Myhelper::hasRole('admin')): ?>
                                <td class="p-t-0 p-b-0">
                                    <select class="form-control my-1" name="type[]" required="">
                                        <option value="">Select Type</option>
                                        <option value="percent">Percent (%)</option>
                                        <option value="flat">Flat (Rs)</option>
                                    </select>
                                </td>
                                <?php endif; ?>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="whitelable[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="md[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="distributor[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="retailer[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-xl" id="aepsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">AePS Commission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>
            <form class="commissionForm" method="post" action="<?php echo e(route('resourceupdate')); ?>">

                <div class="modal-body">

                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="actiontype" value="commission">
                    <input type="hidden" name="scheme_id" value="">
                    <table class="table table-bordered m-0">
                        <thead class="thead-light">
                            <th>Operator</th>
                            <?php if(Myhelper::hasRole('admin')): ?>
                            <th>Commission Type</th>
                            <?php endif; ?>
                            <th>Whitelable</th>
                            <th>Master Distributor</th>
                            <th>Distributor</th>
                            <th>Retailer</th>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $aepsOperator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <input type="hidden" name="slab[]" value="<?php echo e($element->id); ?>">
                                    <?php echo e($element->name); ?>

                                </td>
                                <?php if(Myhelper::hasRole('admin')): ?>
                                <td class="p-t-0 p-b-0">
                                    <select class="form-control my-1" name="type[]" required="">
                                        <option value="">Select Type</option>
                                        <option value="percent">Percent (%)</option>
                                        <option value="flat">Flat (Rs)</option>
                                    </select>
                                </td>
                                <?php endif; ?>

                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="whitelable[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="md[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="distributor[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="retailer[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade bd-example-modal-xl" id="ccpayModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">CC Payment Charge</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form class="commissionForm" method="post" action="<?php echo e(route('resourceupdate')); ?>">

                <div class="modal-body">

                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="actiontype" value="commission">
                    <input type="hidden" name="scheme_id" value="">
                    <table class="table table-bordered m-0">
                        <thead class="thead-light">
                            <th>Operator</th>
                            <?php if(Myhelper::hasRole('admin')): ?>
                            <th>Commission Type</th>
                            <?php endif; ?>
                            <th>Whitelable</th>
                            <th>Master Distributor</th>
                            <th>Distributor</th>
                            <th>Retailer</th>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $ccOperator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <input type="hidden" name="slab[]" value="<?php echo e($element->id); ?>">
                                    <?php echo e($element->name); ?>

                                </td>
                                <?php if(Myhelper::hasRole('admin')): ?>
                                <td class="p-t-0 p-b-0">
                                    <select class="form-control my-1" name="type[]" required="">
                                        <option value="">Select Type</option>
                                        <option value="percent">Percent (%)</option>
                                        <option value="flat">Flat (Rs)</option>
                                    </select>
                                </td>
                                <?php endif; ?>

                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="whitelable[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="md[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="distributor[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="retailer[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade bd-example-modal-xl" id="xdmtModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Express Payout Transfer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>
            <form class="commissionForm" method="post" action="<?php echo e(route('resourceupdate')); ?>">

                <div class="modal-body">
                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="actiontype" value="commission">
                    <input type="hidden" name="scheme_id" value="">
                    <table class="table table-bordered m-0">
                        <thead class="thead-light">
                            <th>Operator</th>
                            <?php if(Myhelper::hasRole('admin')): ?>
                            <th>Type</th>
                            <?php endif; ?>
                            <th>Whitelable</th>
                            <th>Master Distributor</th>
                            <th>Distributor</th>
                            <th>Retailer</th>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $xdmtOperator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <input type="hidden" name="slab[]" value="<?php echo e($element->id); ?>">
                                    <?php echo e($element->name); ?>

                                </td>
                                <?php if(Myhelper::hasRole('admin')): ?>
                                <td>
                                    <?php if($element->recharge1 == 'dmt1accverify' || $element->recharge1 == 'condmtekycverify'): ?>
                                    <input type="hidden" name="type[]" value="flat">
                                    Flat
                                    <?php else: ?>
                                    <select class="form-control my-1" name="type[]" required="">
                                        <option value="">Select Type</option>
                                        <option value="percent">Percent (%)</option>
                                        <option value="flat">Flat (Rs)</option>
                                    </select>
                                    <?php endif; ?>
                                </td>
                                <?php endif; ?>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="whitelable[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="md[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="distributor[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="retailer[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-xl" id="ccpayoutModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">CC Payout Charge</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form class="commissionForm" method="post" action="<?php echo e(route('resourceupdate')); ?>">

                <div class="modal-body">

                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="actiontype" value="commission">
                    <input type="hidden" name="scheme_id" value="">
                    <table class="table table-bordered m-0">
                        <thead class="thead-light">
                            <th>Operator</th>
                            <?php if(Myhelper::hasRole('admin')): ?>
                            <th>Commission Type</th>
                            <?php endif; ?>
                            <th>Whitelable</th>
                            <th>Master Distributor</th>
                            <th>Distributor</th>
                            <th>Retailer</th>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $ccpayOperator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <input type="hidden" name="slab[]" value="<?php echo e($element->id); ?>">
                                    <?php echo e($element->name); ?>

                                </td>
                                <?php if(Myhelper::hasRole('admin')): ?>
                                <td class="p-t-0 p-b-0">
                                    <select class="form-control my-1" name="type[]" required="">
                                        <option value="">Select Type</option>
                                        <option value="percent">Percent (%)</option>
                                        <option value="flat">Flat (Rs)</option>
                                    </select>
                                </td>
                                <?php endif; ?>

                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="whitelable[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="md[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="distributor[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="retailer[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-xl" id="dmtModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Money Transfer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>
            <form class="commissionForm" method="post" action="<?php echo e(route('resourceupdate')); ?>">

                <div class="modal-body">
                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="actiontype" value="commission">
                    <input type="hidden" name="scheme_id" value="">
                    <table class="table table-bordered m-0">
                        <thead class="thead-light">
                            <th>Operator</th>
                            <?php if(Myhelper::hasRole('admin')): ?>
                            <th>Type</th>
                            <?php endif; ?>
                            <th>Whitelable</th>
                            <th>Master Distributor</th>
                            <th>Distributor</th>
                            <th>Retailer</th>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $dmtOperator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <input type="hidden" name="slab[]" value="<?php echo e($element->id); ?>">
                                    <?php echo e($element->name); ?>

                                </td>
                                <?php if(Myhelper::hasRole('admin')): ?>
                                <td>
                                     <?php if($element->recharge1 == 'dmt1accverify' || $element->recharge1 == 'condmtekycverify'): ?>
                                    <input type="hidden" name="type[]" value="flat">
                                    Flat
                                    <?php else: ?>
                                    <select class="form-control my-1" name="type[]" required="">
                                        <option value="">Select Type</option>
                                        <option value="percent">Percent (%)</option>
                                        <option value="flat">Flat (Rs)</option>
                                    </select>
                                    <?php endif; ?>
                                </td>
                                <?php endif; ?>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="whitelable[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="md[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="distributor[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="retailer[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-xl" id="AadharpayModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Aadharpay Charge</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>
            <form class="commissionForm" method="post" action="<?php echo e(route('resourceupdate')); ?>">

                <div class="modal-body">

                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="actiontype" value="commission">
                    <input type="hidden" name="scheme_id" value="">
                    <table class="table table-bordered m-0">
                        <thead class="thead-light">
                            <th>Operator</th>
                            <?php if(Myhelper::hasRole('admin')): ?>
                            <th>Type</th>
                            <?php endif; ?>
                            <th>Whitelable</th>

                            <th>Master Distributor</th>
                            <th>Distributor</th>
                            <th>Retailer</th>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $aadharpayOperator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <input type="hidden" name="slab[]" value="<?php echo e($element->id); ?>">
                                    <?php echo e($element->name); ?>

                                </td>
                                <?php if(Myhelper::hasRole('admin')): ?>
                                <td>
                                    <?php if($element->recharge1 == 'dmt1accverify'): ?>
                                    <input type="hidden" name="type[]" value="flat">
                                    Flat
                                    <?php else: ?>
                                    <select class="form-control my-1" name="type[]" required="">
                                        <option value="">Select Type</option>
                                        <option value="percent">Percent (%)</option>
                                        <option value="flat">Flat (Rs)</option>
                                    </select>
                                    <?php endif; ?>
                                </td>
                                <?php endif; ?>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="whitelable[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>

                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="md[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="distributor[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                                <td class="p-t-0 p-b-0">
                                    <input type="number" step="any" name="retailer[]" placeholder="Enter Value" class="form-control my-1" required="">
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade bd-example-modal-xl" id="commissionModal" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title ">
                    <span class="schemename"></span>

                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>
            <div class="modal-body commissioData">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        var url = "<?php echo e(url('statement/fetch')); ?>/resource<?php echo e($type); ?>/0";

        var onDraw = function() {
            $('input.schemeStatusHandler').on('click', function(evt) {
                evt.stopPropagation();
                var ele = $(this);
                var id = $(this).val();
                var status = "0";
                if ($(this).prop('checked')) {
                    status = "1";
                }

                $.ajax({
                        url: `<?php echo e(route('resourceupdate')); ?>`,
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        data: {
                            'id': id,
                            'status': status,
                            "actiontype": "scheme"
                        }
                    })
                    // beforeSend: function() {
                    //     swal({
                    //         title: 'Wait!',
                    //         text: 'Please wait, we are fetching commission details',
                    //         onOpen: () => {
                    //             swal.showLoading()
                    //         },
                    //         allowOutsideClick: () => !swal.isLoading()
                    //     });
                    // },
                    .done(function(data) {

                        if (data.status == "success") {
                            notify("Scheme Updated", 'success');
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
                    })
                // })

            });
        };

        var options = [{
                "data": "id"
            },
            {
                "data": "name"
            },
            {
                "data": "name",
                render: function(data, type, full, meta) {
                    var check = "";
                    if (full.status == "1") {
                        check = "checked='checked'";
                    }

                    return `<div class="form-check-size"> <div class="form-check form-switch form-check-inline">
                              <input type="checkbox" class="form-check-input switch-primary check-size schemeStatusHandler" id="schemeStatus_${full.id}" ${check} value="` +
                        full.id + `" actionType="` + type + `">
                              <label class="custom-control-label" for="schemeStatus_${full.id}"></label>
                           </div>
                           </div>`;

                }
            },
            {
                "data": "action",
                render: function(data, type, full, meta) {
                    var menu = ``;

                    menu += `<li class="dropdown-header">Commission</li>
                    <a href="javascript:void(0)"  class="dropdown-item" onclick="commission(` + full.id + `, 'mobile','mobileModal')">Mobile Recharge</a>
                                <a href="javascript:void(0)"  class="dropdown-item" onclick="commission(` + full.id + `, 'dth','dthModal')">Dth Recharge</a>`;
                    menu += `<a href="javascript:void(0)"  class="dropdown-item" onclick="commission(` + full.id + `, 'allBillPament','allBillPamentModal')">Bill Payments</a>`;
                    // menu += `<a href="javascript:void(0)"  class="dropdown-item" onclick="commission(` + full.id + `, 'electricity','electricModal')">Online Electricity Bill</a>`;
                    // menu += `<a href="javascript:void(0)"  class="dropdown-item" onclick="commission(` +
                    //     full.id +
                    //     `, 'electricity','electricOfflineModal')">Offline Electricity Bill</a>`;
                    menu += `<a href="javascript:void(0)"  class="dropdown-item" onclick="commission(` + full.id + `, 'aeps','aepsModal')">AePS</a>`;
                    // menu += `<a href="javascript:void(0)"  class="dropdown-item" onclick="commission(` +
                    //     full.id + `, 'aeps','cmsModal')">CMS</a>`;
                    menu += `<a href="javascript:void(0)"  class="dropdown-item" onclick="commission(` + full.id + `, 'aeps','matmModal')">Matm</a> <hr>`;

                    menu += `<li class="dropdown-header">Charge</li>
                    <a href="javascript:void(0)"  class="dropdown-item" onclick="commission(` + full.id + `, 'dmt','dmtModal')">DMT</a>`;
                    menu += `<a href="javascript:void(0)"  class="dropdown-item" onclick="commission(` + full.id + `, 'Aadharpay','AadharpayModal')">Aadharpay</a>`; 
                    menu += `<a href="javascript:void(0)"  class="dropdown-item" onclick="commission(` + full.id + `, 'CCPayments','ccpayModal')">CC Payments</a>`;
                     menu += `<a href="javascript:void(0)"  class="dropdown-item" onclick="commission(` + full.id + `, 'xdmt','xdmtModal')">Xpress-Payout</a>`;
                    menu += `<a href="javascript:void(0)"  class="dropdown-item" onclick="commission(` + full.id + `, 'ccpayout','ccpayoutModal')">CC Payout</a>`;
                    menu += `<a href="javascript:void(0)"  class="dropdown-item" onclick="commission(` + full.id + `, 'ccpayout','upipayoutModal')">UPI Payout</a>`; 
                    menu += `<a href="javascript:void(0)"  class="dropdown-item" onclick="commission(` + full.id + `, 'collect','qrcollectModal')">QR Collect</a>`;
                    var out = `<button type="button" class="btn btn-primary btn-sm" onclick="editSetup(this)">Edit</button>
                                <button type="button" class="btn btn-primary btn-sm" onclick="viewCommission(` + full.id + `, '` + full.name + `')"> View Commission</button>
                                <div class="btn-group dropdown show" role="group">
                                    <button id="dropdownMenuLink" type="button" class="btn btn-primary btn-sm dropdown-bs-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Commission/Charge 
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="height:200px;overflow-y:scroll;position: absolute;">
                                       ` + menu + `
                                       
                                    </div>
                                 </div>`;


                    return out;
                    // <button type="button" class="btn btn-primary btn-sm" onclick="commission(` + full.id + `, 'allBillPament','allBillPamentModal')">BillPayments Commission</button>

                }
            },
        ];
        datatableSetup(url, options, onDraw);

        $("#setupManager").validate({
            rules: {
                name: {
                    required: true,
                }
            },
            messages: {
                name: {
                    required: "Please enter bank name",
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
                    type: 'post',
                    beforeSubmit: function() {
                        form.find('button:submit').html('Please wait...').attr('disabled',true).addClass('btn-secondary');
                    },
                    complete:function(){
                        form.find('button:submit').html('Add').attr('disabled',false).removeClass('btn-secondary');
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

        $('form.commissionForm').submit(function() {
            var form = $(this);
            form.closest('.modal').find('tbody').find('span.pull-right').remove();
            form.ajaxSubmit({
                dataType: 'json',
                beforeSubmit: function() {
                    form.find('button[type="submit"]').html('Please wait...').attr('disabled',true).addClass('btn-secondary');
                },
                complete: function() {
                    form.find('button[type="submit"]').html('Submit').attr('disabled',false).removeClass('btn-secondary');
                },
                success: function(data) {
                    $.each(data.status, function(index, values) {
                        if (values.id) {
                            form.find('input[value="' + index + '"]').closest('tr')
                                .find('td').eq(0).append(
                                    '<span class="pull-right text-success"><i class="fa fa-check"></i></span>'
                                );
                        } else {
                            form.find('input[value="' + index + '"]').closest('tr')
                                .find('td').eq(0).append(
                                    '<span class="pull-right text-danger"><i class="fa fa-times"></i></span>'
                                );
                            if (values != 0) {
                                form.find('input[value="' + index + '"]').closest(
                                    'tr').find('input[name="value[]"]').closest(
                                    'td').append(
                                    '<span class="text-danger pull-right"><i class="fa fa-times"></i> ' +
                                    values + '</span>');
                            }
                        }
                    });

                    setTimeout(function() {
                        form.find('span.pull-right').remove();
                    }, 10000);
                    notify('Submitted Successfully','success');
                },
                error: function(errors) {
                    showError(errors, form);
                    form.find('button[type="submit"]').html('Submit').attr('disabled',false).removeClass('btn-secondary');
                    notify('Something went wrong','error')
                }
            });
            return false;
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

    function editSetup(ele) {
        var id = $(ele).closest('tr').find('td').eq(0).text();
        var name = $(ele).closest('tr').find('td').eq(1).text();

        $('#setupModal').find('.msg').text("Edit");
        $('#setupModal').find('input[name="id"]').val(id);
        $('#setupModal').find('input[name="name"]').val(name);
        $('#setupModal').offcanvas('show');
    }

    function commission(id, type, modal) {
        $.ajax({
            url: `<?php echo e(url('resources/get')); ?>/` + type + "/commission",
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            data: {
                'scheme_id': id
            },
            beforeSend: function() {
                swal({
                    title: 'Wait!',
                    text: 'Please wait, we are working',
                    onOpen: () => {
                        swal.showLoading()
                    },
                    allowOutsideClick: () => !swal.isLoading()
                });
            },
            success: function(data) {
                swal.close();
                if (data.length > 0) {
                    $.each(data, function(index, values) {
                        if (type != "gst" && type != "itr") {
                            <?php if(Myhelper::hasRole('admin')): ?>
                            $('#' + modal).find('input[value="' + values.slab + '"]').closest('tr')
                                .find('select[name="type[]"]').val(values.type);
                            <?php endif; ?>
                        }
                        $('#' + modal).find('input[value="' + values.slab + '"]').closest('tr').find(
                            'input[name="whitelable[]"]').val(values.whitelable);
                        $('#' + modal).find('input[value="' + values.slab + '"]').closest('tr').find(
                            'input[name="md[]"]').val(values.md);
                        $('#' + modal).find('input[value="' + values.slab + '"]').closest('tr').find(
                            'input[name="distributor[]"]').val(values.distributor);
                        $('#' + modal).find('input[value="' + values.slab + '"]').closest('tr').find(
                            'input[name="retailer[]"]').val(values.retailer);
                    });
                }
                $('#' + modal).find('input[name="scheme_id"]').val(id);
                $('#' + modal).modal('show');
            },
            fail: function(errors) {
                notify('Oops', errors.status + '! ' + errors.statusText, 'warning');
            }
        })
    }

    <?php if(isset($mydata['schememanager']) && $mydata['schememanager'] -> value == 'all'): ?>

    function viewCommission(id, name) {
        if (id != '') {
            $.ajax({
                url: '<?php echo e(route("getMemberPackageCommission")); ?>',
                type: 'post',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    "scheme_id": id
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
                    $('#commissionModal').find('.schemename').text(name);
                    $('#commissionModal').find('.commissioData').html(data);
                    $('#commissionModal').modal('show');
                },
                fail: function() {
                    swal.close();
                    notify('Somthing went wrong', 'warning');
                }
            })

        }
    }
    <?php else: ?>

    function viewCommission(id, name) {
        if (id != '') {
            $.ajax({
                url: '<?php echo e(route("getMemberCommission")); ?>',
                type: 'post',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    "scheme_id": id
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
                    $('#commissionModal').find('.schemename').text(name);
                    $('#commissionModal').find('.commissioData').html(data);
                    $('#commissionModal').modal('show');
                },
                fail: function() {
                    swal.close();
                    notify('Somthing went wrong', 'warning');
                }
            })

        }
    }
    <?php endif; ?>
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.ismartpay.in/resources/views/resource/scheme.blade.php ENDPATH**/ ?>