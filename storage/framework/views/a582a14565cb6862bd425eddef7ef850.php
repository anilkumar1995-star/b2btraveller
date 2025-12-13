<?php $__env->startSection('title', 'Scheme Manager'); ?>
<?php $__env->startSection('pagetitle', 'Scheme Manager'); ?>

<?php $__env->startSection('content'); ?>
    <div class="content">

        <div class="row mt-4">
            <div class="col-12 col-xl-12 col-sm-12 order-1 order-lg-2 mb-4 mb-lg-0">
                <div class="card">
                    <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4">
                        <div class="card-title mb-0">
                            My Commission
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-pills" role="tablist">
                            <?php if(isset($commission)): ?>
                                <?php $__currentLoopData = @$commission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link <?php echo e($key == 'mobile' ? 'active' : ''); ?>"
                                            role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-justified-<?php echo e($key); ?>"
                                            aria-controls="navs-justified-<?php echo e($key); ?>" aria-selected="true">
                                            <i class="tf-icons ti ti-home ti-xs me-1"></i> <?php echo e(ucfirst($value['label'])); ?>

                                        </button>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </ul>

                        <div class="tab-content">

                            <?php if(isset($mydata['schememanager']) && isset($commission) && $mydata['schememanager']->value == 'admin'): ?>
                                <?php $__currentLoopData = @$commission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="tab-pane fade my-2 show <?php echo e($key == 'mobile' ? 'active' : ''); ?>"
                                        id="navs-justified-<?php echo e($key); ?>" role="tabpanel">

                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="thead-light">
                                                    <th>Provider</th>
                                                    <th>Type</th>
                                                    <?php if(Myhelper::hasRole('whitelable')): ?>
                                                        <th>Whitelable</th>
                                                    <?php endif; ?>
                                                    <?php if(Myhelper::hasRole('md')): ?>
                                                        <th>Md</th>
                                                    <?php endif; ?>
                                                    <?php if(Myhelper::hasRole('distributor')): ?>
                                                        <th>Distributor</th>
                                                    <?php endif; ?>
                                                    <?php if(Myhelper::hasRole('retailer')): ?>
                                                        <th>Retailer</th>
                                                    <?php endif; ?>
                                                </thead>

                                                <tbody>
                                                    <?php $__currentLoopData = @$value['details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e(ucfirst(@$comm->provider['name'])); ?></td>
                                                            <td><?php echo e(ucfirst(@$comm->type)); ?></td>
                                                            <?php if(Myhelper::hasRole('whitelable')): ?>
                                                                <td><?php echo e(ucfirst(@$comm->whitelable)); ?></td>
                                                            <?php endif; ?>
                                                            <?php if(Myhelper::hasRole('md')): ?>
                                                                <td><?php echo e(ucfirst(@$comm->md)); ?></td>
                                                            <?php endif; ?>
                                                            <?php if(Myhelper::hasRole('distributor')): ?>
                                                                <td><?php echo e(ucfirst(@$comm->distributor)); ?></td>
                                                            <?php endif; ?>
                                                            <?php if(Myhelper::hasRole('retailer')): ?>
                                                                <td><?php echo e(ucfirst(@$comm->retailer)); ?></td>
                                                            <?php endif; ?>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <?php if(isset($commission)): ?>

                                    <?php $__currentLoopData = @$commission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="tab-pane fade my-2 show <?php echo e($key == 'mobile' ? 'active' : ''); ?>"
                                            id="navs-justified-<?php echo e($key); ?>" role="tabpanel">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead class="thead-light">
                                                        <th>Provider</th>
                                                        <th>Type</th>
                                                        <th>Value</th>
                                                    </thead>

                                                    <tbody>
                                                        <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e(ucfirst(@$comm->provider->name)); ?></td>
                                                                <td><?php echo e(ucfirst(@$comm->type)); ?></td>
                                                                <td><?php echo e(ucfirst(@$comm->value)); ?></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.quick2pay.in/resources/views/resource/commission.blade.php ENDPATH**/ ?>