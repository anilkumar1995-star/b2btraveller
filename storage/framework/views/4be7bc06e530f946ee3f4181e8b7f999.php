<ul class="nav nav-pills nav-tabs mb-3" id="pills-tab" role="tablist">
    <?php if(isset($commission)): ?>
        <?php $__currentLoopData = $commission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="nav-item">
                <a class="nav-link <?php echo e($key == 'mobile' ? 'active' : ''); ?>" id="pills-home-tab" data-bs-toggle="pill"
                    href="#<?php echo e($key); ?>" role="tab" aria-controls="pills-home"
                    aria-selected="true"><?php echo e(ucfirst($value['label'])); ?></a>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</ul>
<div class="tab-content" id="pills-tabContent-2">

    <?php if(isset($mydata['schememanager']) && isset($commission) && $mydata['schememanager']->value == 'admin'): ?>
        <?php $__currentLoopData = $commission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="tab-pane fade show <?php echo e($key == 'mobile' ? 'active' : ''); ?>" id="<?php echo e($key); ?>"
                role="tabpanel" aria-labelledby="pills-home-tab">

                <div class="table-responsive">
                    <table class="table">
                        <thead class="thead-light">
                            <th>Provider</th>
                            <th>Type</th>
                            <?php if(Myhelper::hasRole(['admin', 'whitelable'])): ?>
                                <th>Whitelable</th>
                            <?php endif; ?>
                            <?php if(Myhelper::hasRole('admin', 'md')): ?>
                                <th>Md</th>
                            <?php endif; ?>
                            <?php if(Myhelper::hasRole('admin', 'distributor')): ?>
                                <th>Distributor</th>
                            <?php endif; ?>
                            <?php if(Myhelper::hasRole('admin', 'retailer')): ?>
                                <th>Retailer</th>
                            <?php endif; ?>
                        </thead>

                        <tbody>
                            <?php $__currentLoopData = $value['details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    
                                    <td><?php echo e(ucfirst(@$comm->provider['name'])); ?></td>

                                    <td><?php echo e(ucfirst(@$comm->type)); ?></td>
                                    <?php if(Myhelper::hasRole('admin', 'whitelable')): ?>
                                        <td><?php echo e(ucfirst(@$comm->whitelable)); ?></td>
                                    <?php endif; ?>
                                    <?php if(Myhelper::hasRole('admin', 'md')): ?>
                                        <td><?php echo e(ucfirst(@$comm->md)); ?></td>
                                    <?php endif; ?>
                                    <?php if(Myhelper::hasRole('admin', 'distributor')): ?>
                                        <td><?php echo e(ucfirst(@$comm->distributor)); ?></td>
                                    <?php endif; ?>
                                    <?php if(Myhelper::hasRole('admin', 'retailer')): ?>
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

            <?php $__currentLoopData = $commission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="tab-pane fade show <?php echo e($key == 'mobile' ? 'active' : ''); ?>" id="<?php echo e($key); ?>"
                    role="tabpanel" aria-labelledby="pills-home-tab">
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
<?php /**PATH /home/incognic/login.quick2pay.in/resources/views/member/commission.blade.php ENDPATH**/ ?>