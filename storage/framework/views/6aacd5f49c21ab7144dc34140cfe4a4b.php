
<?php $__env->startSection('title', 'ID Card'); ?>
<?php $__env->startSection('pagetitle', 'ID Card'); ?>





<?php $__env->startSection('content'); ?>
<style>
    .datatable-img {
    background-image: url('<?php echo e(asset('assets/')); ?>/idcardImg.jpg');
    background-size: 100% 100%;
}

@media print {
    .datatable-img {
        -webkit-print-color-adjust: exact !important; /* For Chrome */
        background-image: url('<?php echo e(asset('assets/')); ?>/idcardImg.jpg') !important;
    }
}
</style>


    <div class="row">
        <div class="col-12 col-xl-12 col-sm-12 order-1 order-lg-2 mb-lg-0">
            <div class="card">

                <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4 ">
                    <div class="card-title">
                        <h4 class="mb-0">
                            <span>ID Card</span>
                        </h4>
                    </div>
                    <div class="col-sm-12 col-md-1 ">
                        <div class=" d-flex float-right">
                            <button type="button" class="btn btn-primary text-white" id="print"> <i
                                    class="ti ti-printer"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body" id="printable">
                    <div class="card-table table-responsive p-2" style="overflow-y:hidden">

                        <table class="mx-auto border datatable-img"
                            style="height:420px;width:auto">
                            
                            
                            <tr style="width: 100%">
                                <td colspan="2" style="width: 100%;text-align:center">

                                    <?php if(Auth::user()->company->logo): ?>
                                        <div style="width:50px;height:30px;position: relative;top:-5px;" class="mx-auto">
                                            <img src="<?php echo e(Imagehelper::getImageUrl() . Auth::user()->company->logo); ?>"
                                                class=" img-responsive" alt="" width="100%" height="100%">
                                        </div>
                                    <?php else: ?>
                                        <div style="height:30px;position: relative;top:-5px;" class="mx-auto">
                                            <span class="fw-bold fs-6"><?php echo e(Auth::user()->company->companyname); ?></span>
                                        </div>
                                    <?php endif; ?>

                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">

                                    <div style="width:107px;height:80x !important;border-radius:50%;overflow:hidden;position: relative;top:-7px;"
                                        class="mx-auto">

                                        <?php if(Auth::user()->profile): ?>
                                            <img src="<?php echo e(Imagehelper::getImageUrl() . Auth::user()->profile); ?>"
                                                class="img-responsive" alt="" width="100%" height="100px">
                                        <?php else: ?>
                                            <img src="<?php echo e(asset('assets/')); ?>/idcardimage.jpg" class="img-responsive"
                                                alt="" width="100%" height="100px">
                                        <?php endif; ?>
                                        <div>

                                </td>
                            </tr>


                            <tr>
                                <td colspan="2" style="padding:0px 50px;position: relative;top: -60px;color: black;">
                                    <div style="text-align: center"> <?php echo e(strtoupper(Auth::user()->name)); ?>

                                        <br>
                                        (<u><i><?php echo e(strtoupper(Auth::user()->role->name)); ?></i></u>)
                                    </div>


                                    <strong>ID : </strong><?php echo e($getDet); ?><br>
                                    <strong>Mobile : </strong><?php echo e(strtoupper(Auth::user()->mobile)); ?><br>
                                    <strong>Email : </strong><?php echo e(strtolower(Auth::user()->email)); ?><br>

                                </td>
                            </tr>

                        </table>

                    </div>
                </div>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script src="<?php echo e(asset('/assets/js/core/jQuery.print.js')); ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#print').click(function() {
            $('#printable').print();
        });
    });
</script>

    
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wampp\www\b2btraveller\resources\views/idcard.blade.php ENDPATH**/ ?>