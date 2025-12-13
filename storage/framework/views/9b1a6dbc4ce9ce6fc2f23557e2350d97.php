<?php $__env->startSection('title', 'Certificate'); ?>
<?php $__env->startSection('pagetitle', 'Certificate'); ?>
<?php

$getDet  =App\Models\User::where('role_id','1')->first(['bene_id1']);
$getDet =json_decode($getDet->bene_id1);
$cmo = @$getDet->cmo;
$coo = @$getDet->coo;

?>

<?php $__env->startSection('content'); ?>
<style>
    .datatable-img {
    background-image: url('<?php echo e(asset('assets/')); ?>/certificateImg.jpg');
    background-size: 100% 100%;
}

@media print {
    .datatable-img {
        -webkit-print-color-adjust: exact !important; /* For Chrome */
        background-image: url('<?php echo e(asset('assets/')); ?>/certificateImg.jpg') !important; 
    }
    
}
</style>

<div class="row mt-4">
    <div class="col-12 col-xl-12 col-sm-12 order-1 order-lg-2 mb-lg-0">
        <div class="card">
           
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4 ">
                <div class="card-title">
                    <h4 class="mb-0">
                        <span>Certificate</span>
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
                <div class="card-table table-responsive p-2" style="overflow-y:hidden" >
                    <table class="mx-auto datatable-img border" style=" text-align: center; height:auto;min-height:750px;width:60%">
                        
                       
                        
                        <tr style="width: 100%">
                            <td style="position: relative;top: 0px;width:100%;text-align:right;padding-right:45px"><?php echo e(date("jS F Y")); ?></td>
                            
                        </tr>
                        
                        <tr>
                            <td colspan="2" style="padding:0px 50px;position: relative;top: 80px;font-weight: 500;color: black;">
                                <small><?php echo e(strtoupper(Auth::user()->role->name)); ?></small>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding:0px 50px;position: relative;top: 50px;font-weight: 500;color: black;">
                            <small>    <?php echo e(strtoupper(Auth::user()->name)); ?></small>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding-left:70px;position: relative;top: -6px;font-weight: 500;color: black;">
                            <small>    <?php echo e("C/O " .Auth::user()->shopname.  ", " .strtoupper(Auth::user()->address) . " ".Auth::user()->city. " " .Auth::user()->state. " " .Auth::user()->pincode); ?></small>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding:0px 50px;position: relative;top: -35px;font-weight: 500;color: black;">
                            <small>    <?php echo e(strtoupper(Auth::user()->pancard)); ?></small>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding:0px 50px;position: relative;top: -60px;font-weight: 500;color: black;"><u>
                                
                            <small> <?php echo e(!empty(Auth::user()->company->companyfullname) ? strtoupper(Auth::user()->company->companyfullname) : strtoupper(Auth::user()->company->companyname)); ?></small>
                            </u></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="font-family:Freestyle Script;position: relative;top: -105px;font-weight: 500;color: black;">
                            <span style="margin-right: 150px ;font-size:20px;"> <?php echo e($cmo); ?> </span>
                                <span style="font-size: 20px"> <?php echo e($coo); ?> </span>
                            </td>
                        </tr>
                        <tr style="width: 100%">
                            <td style="position: relative;top: -85px;width:60%;text-align:left;padding-left:90px"><?php echo e(\Carbon\Carbon::createFromFormat('d M y - h:i A', Auth::user()->created_at)->format('d M Y')); ?></td>
                            
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
            
            $('#printable').addClass('increase-width').print();
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.quick2pay.in/resources/views/certificate.blade.php ENDPATH**/ ?>