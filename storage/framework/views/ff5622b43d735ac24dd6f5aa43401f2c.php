<?php $__env->startSection('title', 'Affiliate Services'); ?>
<?php $__env->startSection('pagetitle', 'Affiliate Service'); ?>

<?php
    // $table = 'yes';

    // $status['type'] = 'Fund';
    // $status['data'] = [
    //     'success' => 'Success',
    //     'pending' => 'Pending',
    //     'failed' => 'Failed',
    //     'approved' => 'Approved',
    //     'rejected' => 'Rejected',
    // ];
?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12 col-xl-12 col-sm-12 order-1 order-lg-2 my-3 mb-lg-0">
            <?php if(isset($data['errorMesssage'])): ?>
                <script>
                    swal({
                        type: 'error',
                        title: "Error!",
                        text: `<?php echo e($data['errorMesssage']); ?>`,
                        icon: "error",
                        button: "OK",
                        showConfirmButton: true,
                        allowOutsideClick: false,
                    }).then((result) => {
                        window.location.href = '/affiliate/list/department';
                    });
                </script>
            <?php else: ?>
                <?php if(isset($data['departmentList']) && count((array) $data['departmentList']) > 0): ?>
                    <?php $__currentLoopData = $data['departmentList']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $depList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <div class="card ">
                                    
                                    <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4 ">
                                        <div class="card-title">
                                            <h5 class="mb-3">
                                                <span><?php echo e($depList->label); ?></span>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <?php $__currentLoopData = $depList->category_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $catList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="col-lg-2 col-sm-3 col-xs-3 col-3 cursor-pointer"
                                                    onclick="getProduct('0',<?php echo e($catList->id); ?>)">
                                                    <div>
                                                        <img src="https://images.incomeowl.in/incomeowl/<?php echo e($catList->img); ?>"
                                                            height="90px" width="90px">
                                                    </div>
                                                    

                                                    <div><?php echo e($catList->label); ?> </div>

                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>

                                    
                                    
                                </div>

                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <div class="text-center mt-3">
                        <button class="btn btn-primary " id="shareButton" onclick="getProduct('2',<?php echo e($depList->id); ?>)" type="button">
                            <i class="ti ti-eye ti-xs"></i> View More</button>
                    </div>
                <?php endif; ?>

                <?php if(isset($data['productInfo']) && count((array) $data['productInfo']) > 0): ?>
                    <div class="row">
                        <?php $__currentLoopData = $data['productInfo']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $depList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            
                            <div class="col-sm-12 col-lg-6 mb-3">
                                <div class="card">
                                    <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4 ">

                                        <div class="card-title mb-5 ">
                                            <h5 class="mb-0">
                                                <span>
                                                    <img src="https://images.incomeowl.in/incomeowl/<?php echo e($depList->image); ?>"
                                                        width="75px" />
                                                </span><br />
                                                <span><?php echo e($depList->name); ?></span>
                                            </h5>
                                        </div>
                                        <div class="mb-3">
                                            <div class="user-list-files d-flex float-right">

                                                <div class="bg-label-success px-3 py-2 rounded me-auto mb-3">
                                                    <h6 class="mb-0">earn<span class="text-success fw-normal"> upto
                                                            &#8377;</span>
                                                    </h6>
                                                    <span><b class="text-success"> <?php echo e($depList->earning); ?></b></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <ul class="pt-0">
                                                    <?php $__currentLoopData = $depList->Benefits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $catList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li><?php echo e($catList->name); ?></li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                                <div class="bg-lighter px-3 row rounded">
                                                    <div class="pt-2 me-auto mb-3 col-4">
                                                        <h6 class="mb-0"><span class="text-body fw-normal">Joining Fee
                                                                <br />
                                                            </span>&#8377; <?php echo e($depList->opening_charge); ?></h6>

                                                    </div>
                                                    <div class="pt-2 me-auto mb-3 col-4">
                                                        <h6 class="mb-0"><span class="text-body fw-normal">Annual
                                                                Fee<br />
                                                            </span>&#8377; <?php echo e($depList->annual_fee); ?></h6>
                                                    </div>
                                                    <div class="pt-2 me-auto mb-3 col-4">
                                                        <h6 class="mb-0"><span class="text-body fw-normal">Approval Rate
                                                                <br />
                                                            </span><?php echo e($depList->approval_rate == '0' ? 'No Rating' : ($depList->approval_rate == '1' ? 'Excellent' : ($depList->approval_rate == '2' ? 'Low' : ($depList->approval_rate == '3' ? 'Good' : 'Unknown Rating')))); ?>

                                                        </h6>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="float-end mt-3">
                                            <button class="btn btn-outline-success btn-sm" id="shareButton"
                                                onclick="sharefunction(<?php echo e($depList->id); ?>)" type="button">
                                                <i class="fa fa-share"></i> Share</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>

                <?php if(isset($data['categoryInfo']) && count((array) $data['categoryInfo']) > 0): ?>
                
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <div class="card ">
                                
                                <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4 ">
                                    <div class="card-title">
                                        <h5 class="mb-3">
                                            <span><?php echo e("Product List"); ?></span>
                                        </h5>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <?php $__currentLoopData = $data['categoryInfo']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $catList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-lg-2 col-sm-3 col-xs-3 col-3 cursor-pointer" onclick="getProduct(0,<?php echo e($catList->id); ?>)" style="padding-bottom: 20px;">
                                                <div>
                                                    <img src="https://images.incomeowl.in/incomeowl/<?php echo e($catList->img); ?>" height="90px" width="90px">
                                                </div>
                                                

                                                <div style="padding-bottom: 20px;" ><centre><?php echo e($catList->label); ?> </centre></div>

                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>

                                
                                
                            </div>

                        </div>
                    </div>
                
            <?php endif; ?>
            <?php endif; ?>

        </div>
    </div>

    <div class="modal fade" id="referAndEarn" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-simple modal-refer-and-earn">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-3">
                        <h3>Share</h3>

                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-3 ">
                            <div class="d-flex justify-content-center mb-2">
                                <a href="https://www.facebook.com" target="_blank">
                                    <div class="modal-refer-and-earn-step bg-label-primary" style="width:50px;height:50px">
                                        <i class="ti ti-brand-facebook"></i>
                                    </div>
                                </a>
                            </div>

                        </div>
                        <div class="col-12 col-lg-3 ">
                            <a href="https://www.whatsapp.com" target="_blank">
                                <div class="d-flex justify-content-center mb-2">
                                    <div class="modal-refer-and-earn-step bg-label-success" style="width:50px;height:50px">
                                        <i class="ti ti-brand-whatsapp"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-lg-3 ">
                            <a href="https://www.instagram.com" target="_blank">
                                <div class="d-flex justify-content-center mb-2">
                                    <div class="modal-refer-and-earn-step bg-label-danger" style="width:50px;height:50px">
                                        <i class="ti ti-brand-instagram"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-lg-3 ">
                            <a href="https://www.gmail.com" target="_blank">
                                <div class="d-flex justify-content-center mb-2">
                                    <div class="modal-refer-and-earn-step bg-label-warning" style="width:50px;height:50px">
                                        <i class="ti ti-mail"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <hr class="my-3" />
                    <h5 class="mt-1">Copy the link</h5>
                    <form class="row g-3" onsubmit="return false" id="linkvalform">
                        <div class="col-lg-12">
                            <label class="form-label" for="modalLink">You can also copy and send it or share it on your
                                social media. 🥳</label>
                            <div class="input-group input-group-merge">
                                <input type="text" id="modalLink" class="form-control" value="" readonly/>
                                <span class="input-group-text text-primary cursor-pointer" id="copylink">Copy
                                    link</span>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('/assets/js/core/jQuery.print.js')); ?>"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js">
    </script>
    <script type="text/javascript">
        function getProduct(depId, catId) {
            if (depId == '0') {
                window.location.href = "<?php echo e(url('/')); ?>/affiliate/list/product?categoryId=" + catId;
            }
            else if(depId == '1') {
                window.location.href = "<?php echo e(url('/')); ?>/affiliate/list/category?departmentId=" + catId;
            }else{
                window.location.href = "<?php echo e(url('/')); ?>/affiliate/list/category"
            }
        }

        function sharefunction(id) {
            $.ajax({
                    url: `<?php echo e(url('/')); ?>/affiliate/list/productById?productId=` + id,
                    type: 'get',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        swal({
                            title: 'Wait!',
                            text: 'We are getting link for your',
                            onOpen: () => {
                                swal.showLoading()
                            },
                            allowOutsideClick: () => !swal.isLoading()
                        });
                    }
                })
                .done(function(data) {
                    swal.close();
                    console.log(data);
                    notify(data?.message, 'success');
                    $('#referAndEarn').modal('show');
                    $('#linkvalform').find('input[type="text"]').val(data?.data?.link);
                })
                .fail(function(errors) {
                    swal.close();
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const inputBox = document.getElementById('modalLink');
            const copyButton = document.getElementById('copylink');

            copyButton.addEventListener('click', function() {
                inputBox.select();
                inputBox.setSelectionRange(0, 99999);

                try {
                    document.execCommand('copy');
                    notify('Text copied to clipboard!', 'success');
                } catch (err) {
                    notify('Failed to copy text. Please try again.', 'error');
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.quick2pay.in/resources/views/affiliate/department.blade.php ENDPATH**/ ?>