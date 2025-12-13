<?php $__env->startSection('title', 'Bill Payment'); ?>
<?php $__env->startSection('pagetitle', 'Bill Payment'); ?>


<?php $__env->startSection('content'); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <style>
        tr {
            padding: 2px;
        }

        .fw-bold1 {
            font-weight: 500;
            padding: 4px;
        }
    </style>


    <div class="card shadow-sm bg-white">
        <div class="card-body">
            <div id='billrecipt'>
                <!-- <div class="row text-center"><div class="col-sm-12 fw-bold1"></div></div> -->
                <div class="row">
                    <div class="col-sm-3">
                        <img src="<?php echo e(asset('')); ?>logos/billpay.jpeg" height="150px" width="150px" />
                    </div>
                    <div class="col-sm-6  text-center">
                        <div class="fw-bold1"> Bill Payment Details</div>
                        
                    </div>
                    
                </div>
                <div class="row">
                    <?php if(@isset($error) && !empty($error)): ?>
                        <div class="col" style="padding-left: 431px; color: red;">
                            <td class="fw-bold1"><?php echo e($error); ?></td>
                            <div class="container" style="text-align-last: center;">
                                <a href="<?php echo e(route('home')); ?>"><button type="button" class="btn"><strong>GO To
                                            Dashboard</strong></button></a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="col-sm-3">
                        </div>
                        <div class="col-sm-6">
                            <table width="100%">
                                <tr>
                                    <td class="fw-bold1">Name of the biller</td>
                                    <td class="fw-bold1"><?php echo e(@$order->billerName); ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold1">Operator Name</td>
                                    <td class="fw-bold1"><?php echo e(@$order->providername); ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold1">Bill Number</td>
                                    <td class="fw-bold1"><?php echo e(@$order->billerNo); ?></td>
                                </tr>

                                <tr>
                                    <td class="fw-bold1">Bill Date</td>
                                    <td class="fw-bold1"><?php echo e(@$order->option2); ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold1">Bill Due Date</td>
                                    <td class="fw-bold1"><?php echo e(@$order->option3); ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold1">Transaction Date</td>
                                    <td class="fw-bold1"><?php echo e(@$order->created_at); ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold1">Transaction Ref Id</td>
                                    <td class="fw-bold1"><?php echo e(@$order->txnid); ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold1">Biller Reference Number</td>
                                    <td class="fw-bold1"><?php echo e(@$order->refno); ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold1">Bill Amount</td>
                                    <td class="fw-bold1">Rs <?php echo e(@$order->amount); ?></td>
                                </tr>
                                
                                

                                <tr>
                                    <td class="fw-bold1">Status</td>
                                    <td class="fw-bold1"><?php echo e(strtoupper(@$order->status)); ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold1">Remark</td>
                                    <td class="fw-bold1"><?php echo e(@$order->remark); ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold1">Description</td>
                                    <td class="fw-bold1"><?php echo e(@$order->description); ?></td>
                                </tr>
                            </table>
                        </div>
                    <?php endif; ?>
                    <div class="col-sm-3">


                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary" type="button" id="print"><i class="fa fa-print"></i>PRINT</button>
        </div>
    </div>



<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script src="<?php echo e(asset('/assets/js/core/jQuery.print.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            $('#print').click(function() {
                $('#billrecipt').print();
            });

        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.quick2pay.in/resources/views/billpayReciptWithLogo.blade.php ENDPATH**/ ?>