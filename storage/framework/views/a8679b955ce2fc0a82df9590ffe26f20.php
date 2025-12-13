<?php
$name = explode(" ", Auth::user()->name);
?>


<?php $__env->startSection('title', "Aeps Service"); ?>
<?php $__env->startSection('pagetitle', "Aeps Service"); ?>
<?php
$table = "yes";
?>

<?php $__env->startSection('content'); ?>

<?php if(!empty($agent) && $agent->status == 'success'): ?>
<!--<div class="row">
        <div class="col-sm-12">
             <div class="card my-3">

                <div class="card-body">
                    <h4 class="card-title">AePS Service Registration</h4>
                    <form action="<?php echo e(route('aepskyc')); ?>" method="post" id="transactionForm">
                        <?php echo e(csrf_field()); ?>

                        <div class="row">
                            <div class="form-group col-md-4 my-1">
                                <label>Firstname <span class="text-danger fw-bold">*</span></label>
                                <input type="text" class="form-control my-1" autocomplete="off" name="bc_f_name" placeholder="Enter Your Firstame" value="<?php echo e(isset($name[0]) ? $name[0] : ''); ?>" required>
                            </div>

                            <div class="form-group col-md-4 my-1">
                                <label>Lastname <span class="text-danger fw-bold">*</span></label>
                                <input type="text" class="form-control my-1" name="bc_l_name" autocomplete="off" placeholder="Enter Your Lastname" value="<?php echo e(isset($name[1]) ? $name[1] : ''); ?>" required>
                            </div>

                            <div class="form-group col-md-4 my-1">
                                <label>Email <span class="text-danger fw-bold">*</span></label>
                                <input type="email" class="form-control my-1" autocomplete="off" name="emailid" placeholder="Enter Your Email" value="<?php echo e(Auth::user()->email); ?>" required>
                            </div>
                        </div>

                        <div class="row">


                            <div class="form-group col-md-4 my-1">
                                <label>Mobile <span class="text-danger fw-bold">*</span></label>
                                <input type="text" pattern="[0-9]*" maxlength="10" minlength="10" class="form-control my-1" name="phone1" autocomplete="off" placeholder="Enter Your Mobile" value="<?php echo e(Auth::user()->mobile); ?>" required>
                            </div>

                            <div class="form-group col-md-4 my-1">
                                <label>Alternate Mobile <span class="text-danger fw-bold">*</span></label>
                                <input type="text" class="form-control my-1" autocomplete="off" name="phone2" pattern="[0-9]*" maxlength="10" minlength="10" placeholder="Enter Your Alternate Mobile">
                            </div>

                            <div class="form-group col-md-4 my-1">
                                <label>DOB <span class="text-danger fw-bold">*</span></label>
                                <input type="text" class="form-control mydatepic" autocomplete="off" name="bc_dob" placeholder="Enter Your DOB (DD-MM-YYYY)" required>
                            </div>
                        </div>

                        <div class="row">


                            <div class="form-group col-md-4 my-1">
                                <label>State <span class="text-danger fw-bold">*</span></label>
                                <select name="bc_state" class="form-control my-1" onchange="getDistrict(this)" required>
                                    <option value="">Select State</option>
                                    <?php $__currentLoopData = $stateList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($state->stateid); ?>"><?php echo e($state->statename); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="form-group col-md-4 my-1">
                                <label>District <span class="text-danger fw-bold">*</span></label>
                                <select name="bc_district" class="form-control my-1" required>

                                </select>
                            </div>

                            <div class="form-group col-md-4 my-1">
                                <label>Address <span class="text-danger fw-bold">*</span></label>
                                <input type="text" class="form-control my-1" autocomplete="off" name="bc_address" placeholder="Enter Your Address" value="<?php echo e(Auth::user()->address); ?>" required>
                            </div>
                        </div>

                        <div class="row">


                            <div class="form-group col-md-4 my-1">
                                <label>Block <span class="text-danger fw-bold">*</span></label>
                                <input type="text" class="form-control my-1" name="bc_block" autocomplete="off" placeholder="Enter Your Block" required>
                            </div>

                            <div class="form-group col-md-4 my-1">
                                <label>City <span class="text-danger fw-bold">*</span></label>
                                <input type="text" class="form-control my-1" autocomplete="off" name="bc_city" value="<?php echo e(Auth::user()->city); ?>" placeholder="Enter Your City" required>
                            </div>
                            <div class="form-group col-md-4 my-1">
                                <label>Landmark <span class="text-danger fw-bold">*</span></label>
                                <input type="text" class="form-control my-1" autocomplete="off" name="bc_landmark" placeholder="Enter Your Landmark" required>
                            </div>
                        </div>

                        <div class="row">


                            <div class="form-group col-md-4 my-1">
                                <label>Mohalla <span class="text-danger fw-bold">*</span></label>
                                <input type="text" class="form-control my-1" name="bc_mohhalla" autocomplete="off" placeholder="Enter Your Mohhalla" required>
                            </div>

                            <div class="form-group col-md-4 my-1">
                                <label>Location <span class="text-danger fw-bold">*</span></label>
                                <input type="text" class="form-control my-1" autocomplete="off" name="bc_loc" placeholder="Enter Your Location" required>
                            </div>

                            <div class="form-group col-md-4 my-1">
                                <label>PIN Code <span class="text-danger fw-bold">*</span></label>
                                <input type="text" class="form-control my-1" autocomplete="off" name="bc_pincode" placeholder="Enter Your Pincode" pattern="[0-9]*" value="<?php echo e(Auth::user()->pincode); ?>" maxlength="6" minlength="6" required>
                            </div>
                        </div>

                        <div class="row">

                        <div class="form-group col-md-4 my-1">
                                <label>Aadhaar <span class="text-danger fw-bold">*</span></label>
                                <input type="text" class="form-control my-1" name="aadhaar" autocomplete="off" placeholder="Enter Your Aadhaar" value="<?php echo e(Auth::user()->aadhaar); ?>" required>
                            </div>
                            <div class="form-group col-md-4 my-1">
                                <label>PAN Card <span class="text-danger fw-bold">*</span></label>
                                <input type="text" class="form-control my-1" name="bc_pan" autocomplete="off" placeholder="Enter Your Pancard" value="<?php echo e(Auth::user()->pancard); ?>" required>
                            </div>

                            <div class="form-group col-md-4 my-1">
                                <label>Shop Name <span class="text-danger fw-bold">*</span></label>
                                <input type="text" class="form-control my-1" autocomplete="off" name="shopname" value="<?php echo e(Auth::user()->shopname); ?>" placeholder="Enter Your Shopname" required>
                            </div>

                           
                        </div>

                        <div class="row">
                        <div class="form-group col-md-4 my-1">
                                <label>Shop Type <span class="text-danger fw-bold">*</span></label>
                                <input type="text" class="form-control my-1" autocomplete="off" name="shopType" placeholder="Enter Your Shop type" required>
                            </div>

                            <div class="form-group col-md-4 my-1">
                                <label>Qualification <span class="text-danger fw-bold">*</span></label>
                                <select name="qualification" class="form-control my-1">
                                    <option value="SSC">SSC</option>
                                    <option value="HSC">HSC</option>
                                    <option value="Graduate">Graduate</option>
                                    <option value="Post Graduate">Post Graduate</option>
                                    <option value="Diploma">Diploma</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4 my-1">
                                <label>Population <span class="text-danger fw-bold">*</span></label>
                                <select name="population" class="form-control my-1">
                                    <option value="0 to 2000">0 to 2000</option>
                                    <option value="2000 to 5000">2000 to 5000</option>
                                    <option value="5000 to 10000">5000 to 10000</option>
                                    <option value="10000 to 50000">10000 to 50000</option>
                                    <option value="50000 to 100000">50000 to 100000</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4 my-1">
                                <label>Location Type <span class="text-danger fw-bold">*</span></label>
                                <select name="locationType" class="form-control my-1">
                                    <option value="Rural">Rural</option>
                                    <option value="Urban">Urban</option>
                                    <option value="Metro Semi Urban">Metro Semi Urban</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary my-2" data-loading-text="<b><i class='fa fa-spin fa-spinner'></i></b> Submitting"><b><i class=" icon-paperplane"></i></b> Submit</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div> -->
<div class="row">
    <?php if(isset($agent->ekyc) && !empty(@$agent->ekyc) &&  @$agent->ekyc == '1'): ?>

    <div class="col-sm-12">

        <div class="card my-3">
            <div class="card-body">
                <h4 class="card-title">Aeps</h4>
                <table class="table table-bordered">
                    <tr>
                        <td>Merchant ID</td>

                        <td><?php echo e($agent->bc_id); ?></td>
                    </tr>
                    <tr>
                        <td>Phone Number</td>
                        <td><?php echo e(Auth::user()->mobile); ?></td>
                        
                    </tr>
                    </tbody>
                </table>
            </div>

            <?php if(isset($error)): ?>
            <div class="panel-footer text-center text-danger">
                Error - <?php echo e($error); ?>

            </div>
            <?php endif; ?>
        </div>

        <div class="card my-3">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title"><span><img src="<?php echo e(asset('assets/images/AePS.png')); ?>" style="width:30px"></span><span style="margin-top:10px">S-Aeps Service</h4>
                </div>
            </div>
            <div class="card-body" style="padding: 0px;">
                <ul class="nav nav-tabs" id="myTab-1" role="tablist" style="margin-right: 0rem;  margin-left: 0rem;">
                    <li class="nav-item active">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false" onclick="AEPSTAB('BE')">Balance Enquiry</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="home-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false" onclick="AEPSTAB('MS')">Mini Statement</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="home-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="true" onclick="AEPSTAB('CW')">Cash Withdrawal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="home-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="true" onclick="AEPSTAB('AP')">Aadhaar Pay</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="home-tab" data-toggle="tab" href="#2fa" role="tab" aria-controls="2fa" aria-selected="true" onclick="AEPSTAB('2FA')">2FA</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="home-tab" data-toggle="tab" href="#2faap" role="tab" aria-controls="2faap" aria-selected="true" onclick="AEPSTAB('2FAP')">2FA-AP</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent-2">
                    <div class="tab-pane active show" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <form action="<?php echo e(route('aepsTxndo')); ?>" method="POST" id="aepsTransactionForm" enctype="multipart/form-data">
                            <?php echo e(csrf_field()); ?>

                            <input type="hidden" name="transactionType" id="transactionType" value="BE">
                            <input type="hidden" name="aeps" value="">
                            <input type="hidden" name="longitude" value="">
                            <input type="hidden" name="latitude" value="">
                            <input type="hidden" name="authType" value="">
                            
                            <input type="hidden" name="biodata" value="">
                            <div class="panel panel-default no-margin">
                                <div class="panel-heading">
                                    <h4 class="panel-title mytitle">Balance Enquiry</h4>
                                </div>

                                <div class="panel-body">
                                    <div class="row mb-20">
                                        <div class="col-sm-4 my-3">
                                            <div class="md-radio m-b-0">
                                                <input autocomplete="off" type="radio" value="MORPHO_PROTOBUF" id="MORPHO_PROTOBUF" name="device">
                                                <label for="MORPHO_PROTOBUF" style="padding: 0 25px"><span><img src="<?php echo e(asset('assets/images/Morpho.png')); ?>" style="width:30px"></span><span style="margin-left:5px">MORPHO</span></label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 my-3">
                                            <div class="md-radio m-b-0">
                                                <input autocomplete="off" type="radio" value="MANTRA_PROTOBUF" id="MANTRA_PROTOBUF" name="device">
                                                <label for="MANTRA_PROTOBUF" style="padding: 0 25px"><span><img src="<?php echo e(asset('assets/images/Mantra.png')); ?>" style="width:30px"></span><span style="margin-left:5px">MANTRA</style></label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 my-3">
                                            <div class="md-radio m-b-0">
                                                <input autocomplete="off" type="radio" value="SECUGEN_PROTOBUF" id="SECUGEN_PROTOBUF" name="device">
                                                <label for="SECUGEN_PROTOBUF" style="padding: 0 25px"><span><img src="<?php echo e(asset('assets/images/SecuGen.png')); ?>" style="width:30px"></span><span style="margin-left:3px">SECUGEN</style></span></label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 my-3">
                                            <div class="md-radio m-b-0">
                                                <input autocomplete="off" type="radio" value="TATVIK_PROTOBUF" id="TATVIK_PROTOBUF" name="device">
                                                <label for="TATVIK_PROTOBUF" style="padding: 0 25px"><span><img src="<?php echo e(asset('assets/images/Tatvik.png')); ?>" style="width:30px"></span><span style="margin-left:5px">TATVIK</style></label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 my-3">
                                            <div class="md-radio m-b-0">
                                                <input autocomplete="off" type="radio" value="STARTEK_PROTOBUF" id="STARTEK_PROTOBUF" name="device">
                                                <label for="STARTEK_PROTOBUF" style="padding: 0 25px"><span><img src="<?php echo e(asset('assets/images/Startek.png')); ?>" style="width:30px"></span><span style="margin-left:5px">STARTEK</style></label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 my-3">
                                            <div class="md-radio m-b-0">
                                                <input autocomplete="off" type="radio" value="PB100_PROTOBUF" id="PB100_PROTOBUF" name="device">
                                                <label for="PB100_PROTOBUF" style="padding: 0 25px"><span><img src="<?php echo e(asset('assets/images/pb100.png')); ?>" style="width:30px"></span><span style="margin-left:5px">PB100</style></label>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-6 my-2">
                                                <div class="form-group">
                                                    <label>Mobile Number :</label>
                                                    <input type="text" class="form-control" name="mobileNumber" id="mobileNumber" maxlength="10" autocomplete="off" placeholder="Enter mobile number" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 my-2">
                                                <div class="form-group">
                                                    <label>Aadhar Number :</label>
                                                    <input type="text" class="form-control" name="adhaarNumber" id="adhaarNumber" maxlength="12" minlength="12" autocomplete="off" pattern="[0-9]*" placeholder="Enter aadhar number" required="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 my-2">
                                                <div class="form-group">
                                                    <label>Bank :</label>
                                                    <select name="iin" class="form-control mb-1" required>
                                                        <option value="">Select Bank</option>   

                                                        <?php $__currentLoopData = $aepsbanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value=" <?php echo e($bank->iin); ?>"><?php echo e($bank->bank); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                    <!-- <span class="text-dark bg-light badge badge-light my-1" onclick="bank('607094')" style="cursor: pointer;">SBI Bank</span>
                                                    <span class="text-dark bg-light badge badge-light my-1" onclick="bank('508534')" style="cursor: pointer;">ICICI Bank</span>
                                                    <span class="text-dark bg-light badge badge-light my-1" onclick="bank('607152')" style="cursor: pointer;">HDFC Bank</span>
                                                    <span class="text-dark bg-light badge badge-light my-1" onclick="bank('607027')" style="cursor: pointer;">PNB Bank</span>
                                                    <span class="text-dark bg-light badge badge-light my-1" onclick="bank('606985')" style="cursor: pointer;">BOB Bank</span>
                                                    <span class="text-dark bg-light badge badge-light my-1" onclick="bank('607161')" style="cursor: pointer;">Union Bank</span>
                                                    <span class="text-dark bg-light badge badge-light my-1" onclick="bank('607264')" style="cursor: pointer;">Central Bank</span>
                                                    -->
                                                </div>
                                            </div>
                                            <div class="col-md-6 my-2">
                                                <div class="form-group transactionAmount">

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel-footer text-center">
                                        <?php if($agent->status == "success"): ?>
                                        <button type="submit" class="btn btn-primary btn-lg" data-loading-text="<b><i class='fa fa-spin fa-spinner'></i></b> Proceeding...">Scan & Submit</button>

                                        <?php else: ?>
                                        <h4 class="text-danger">Useronboard is <?php echo e($agent->status); ?></h4>
                                        <?php endif; ?>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

</div>


<?php else: ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card my-3">
            <?php if(@$agent->status == 'success' && @$agent->ekyc == '0'): ?>
            <div class="card-body">
                <h4 class="card-title">AePS Service Registration</h4>

            </div>

            <?php else: ?>
            <div class="card-body">
                <h4 class="card-title">AePS Service Registration</h4>
                <form action="<?php echo e(route('aepskyc')); ?>" method="post" id="transactionForm">
                    <?php echo e(csrf_field()); ?>

                    <div class="row">

                        <div class="form-group col-md-4 my-1">
                            <label>Name <span class="text-danger fw-bold">*</span></label>
                            <input type="text" class="form-control my-1" autocomplete="off" name="name" placeholder="Enter Your Firstame" value="<?php echo e(isset($name[0]) ? $name[0] : ''); ?>" required>
                        </div>
                        <div class="form-group col-md-4 my-1">
                            <label>Mobile <span class="text-danger fw-bold">*</span></label>
                            <input type="text" pattern="[0-9]*" maxlength="10" minlength="10" class="form-control my-1" name="phone1" autocomplete="off" placeholder="Enter Your Mobile" value="<?php echo e($agent->phone1 ?? Auth::user()->mobile); ?>" required>
                        </div>
                        <div class="form-group col-md-4 my-1">
                            <label>Email <span class="text-danger fw-bold">*</span></label>
                            <input type="email" class="form-control my-1" autocomplete="off" name="emailid" placeholder="Enter Your Email" value="<?php echo e($agent->emailid ??  Auth::user()->email); ?>" required>
                        </div>
                    </div>

                    <div class="row">

                        <div class="form-group col-md-4 my-1">
                            <label>Aadhaar <span class="text-danger fw-bold">*</span></label>
                            <input type="text" class="form-control my-1" name="aadhaar" autocomplete="off" placeholder="Enter Your Aadhaar" value="<?php echo e(Auth::user()->aadhaar); ?>" required>
                        </div>
                        <div class="form-group col-md-4 my-1">
                            <label>PAN Card <span class="text-danger fw-bold">*</span></label>
                            <input type="text" class="form-control my-1" name="bc_pan" autocomplete="off" placeholder="Enter Your Pancard" value="<?php echo e($agent->bc_pan ?? Auth::user()->pancard); ?>" required>
                        </div>

                        <div class="form-group col-md-4 my-1">
                            <label>Shop Name <span class="text-danger fw-bold">*</span></label>
                            <input type="text" class="form-control my-1" autocomplete="off" name="shopname" value="<?php echo e(@$agent->shopname); ?>" placeholder="Enter Your Shopname" required>
                        </div>
                    </div>

                    <div class="row">

                        <div class="form-group col-md-4 my-1">
                            <label>Location Type <span class="text-danger fw-bold">*</span></label>
                            <select name="locationType" class="form-control my-1">
                                <option value="Rural">Rural</option>
                                <option value="Urban">Urban</option>
                                <option value="Metro Semi Urban">Metro Semi Urban</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group text-center">
                        <?php if(@$agent->status == 'pending'): ?>
                        <span class="btn btn-primary my-2" onclick="getkycStatus()"> Check Status</span>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-primary my-2" data-loading-text="<b><i class='fa fa-spin fa-spinner'></i></b> Submitting"><b><i class=" icon-paperplane"></i></b> Submit</button>
                    </div>
                </form>
            </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php endif; ?>


<div id="kycModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Complete E-KYC</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo e(route('sendOtpForm')); ?>" method="post" id="kycForm">
                    <?php echo e(csrf_field()); ?>

                    <input type="hidden" name="longitude" value=""/>
                    <input type="hidden" name="latitude" value=""/>

                    <input type="hidden" name="E_transactionType" id="E_transactionType" value="sendotp">
                    <div class="modal-body" id="sendOtpModal" style="display: block;">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Aadhar Number</label>
                                    <input type="text" class="form-control" name="aadhaar" placeholder="Enter aadhar no.">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Pancard Number</label>
                                    <input type="text" class="form-control" name="pan" placeholder="Enter pan number">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body" id="validateOtpModal" style="display: none;">

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">OTP</label>
                                    <input type="hidden" name="pkId" id="pkId" value="" />
                                    <input type="hidden" name="fpkId" id="fpkId" value="" />
                                    <input type="number" class="form-control" name="otp" placeholder="Enter otp">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body" id="EKYCModal" style="display: none;">

                        <div class="row">
                            <label for="device">Select Device</label>
                            <select name="device" id="device" class="form-control">
                                <option value="">Select Device</option>
                                <option value="MANTRA_PROTOBUF">Mantra Device</option>
                                <option value="MORPHO_PROTOBUF">Morpho Device</option>
                            </select>
                            <input type="hidden" name="epkId" id="epkId" value="" />
                            <input type="hidden" name="efpkId" id="efpkId" value="" />
                            <input type="hidden" name="mybiodata" id="mybiodata" value="" />


                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-hidden="true">Close</button>
                        <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="receipt" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="statci">
    <div class="modal-dialog" role="document">
        <!-- Modal content-->
        <div class="modal-content">
        <div class="modal-header border-bottom">
                <h4 class="modal-title">Receipt</h4>
                    <h4>
                        <?php if(Auth::user()->company->logo): ?>
                        <img src="<?php echo e(Imagehelper::getImageUrl().Auth::user()->company->logo); ?>" class=" img-responsive" alt="" style="width: 60px;height: 50px;">
                        <?php else: ?>
                        <?php echo e(Auth::user()->company->companyname); ?>

                        <?php endif; ?>
                    </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>    
            </div>
            <div class="modal-body">
                <div class="panel panel-primary">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="pull-left m-t-10">
                                    <address class="m-b-10">
                                        <strong><?php echo e(Auth::user()->name); ?></strong><br>
                                        <?php echo e(Auth::user()->company->companyname); ?><br>
                                        Phone : <?php echo e(Auth::user()->mobile); ?>

                                    </address>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="pull-right m-t-10">
                                    <address class="m-b-10">
                                        <strong>Date: </strong> <span class="created_at"></span><br>
                                        <strong>Order ID: </strong> <span class="id"></span><br>
                                        <strong>Status: </strong> <span class="status"></span><br>
                                    </address>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <h4 class="title"></h4>
                                    <table class="table m-t-10 table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Bank</th>
                                                <th>Aadhar Number</th>
                                                <th>Ref No.</th>
                                                <th>Amount</th>
                                                <th>Account Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="bank"></td>
                                                <td class="aadhar"></td>
                                                <td class="rrn"></td>
                                                <td class="amount"></td>
                                                <td class="balance"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="border-radius: 0px;">
                            <div class="col-md-12 mt-3">
                                <h5 class="text-right cash ">Withdrawal Amount : <span class="amount">5000</span></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                    <a href="javascript:void(0)" id="print" class="btn btn-primary"><i class="fa fa-print"></i></a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div id="balancemodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <!-- Modal content-->
        <div class="modal-content">
        <div class="modal-header border-bottom">
                <h4 class="modal-title">Balance Receipt</h4>
                    <h4>
                        <?php if(Auth::user()->company->logo): ?>
                        <img src="<?php echo e(Imagehelper::getImageUrl().Auth::user()->company->logo); ?>" class=" img-responsive" alt="" style="width: 60px;height: 50px;">
                        <?php else: ?>
                        <?php echo e(Auth::user()->company->companyname); ?>

                        <?php endif; ?>
                    </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>    
            </div>
            <div class="modal-body">
                <div class="panel panel-primary">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="pull-left m-t-10">
                                    <address class="m-b-10">
                                        <strong><?php echo e(Auth::user()->name); ?></strong><br>
                                        <?php echo e(Auth::user()->company->companyname); ?><br>
                                        Phone : <?php echo e(Auth::user()->mobile); ?>

                                    </address>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="pull-right m-t-10">
                                    <address class="m-b-10">
                                        <strong>Date: </strong> <span class="created_at"></span><br>
                                        <strong>Order ID: </strong> <span class="id"></span><br>
                                        <strong>Status: </strong> <span class="status"></span><br>
                                    </address>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <h4 class="title"></h4>
                                    <table class="table m-t-10 table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Bank</th>
                                                <th>Aadhar Number</th>
                                                <th>Ref No.</th>
                                                <th>Account Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="bank"></td>
                                                <td class="aadhar"></td>
                                                <td class="rrn"></td>
                                                <td class="balance"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0)" id="balanceprint" class="btn btn-primary"><i class="fa fa-print"></i></a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="ministatement" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h4 class="modal-title">Mini Statement</h4>
                    <h4>
                        <?php if(Auth::user()->company->logo): ?>
                        <img src="<?php echo e(Imagehelper::getImageUrl().Auth::user()->company->logo); ?>" class=" img-responsive" alt="" style="width: 60px;height: 50px;">
                        <?php else: ?>
                        <?php echo e(Auth::user()->company->companyname); ?>

                        <?php endif; ?>
                    </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>    
            </div>
            <div class="modal-body">
                <div class="panel panel-primary">
                    <div class="panel-body">
                    
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="pull-left m-t-10">
                                    <address class="m-b-10">
                                        <strong><?php echo e(Auth::user()->name); ?></strong><br>
                                        <?php echo e(Auth::user()->company->companyname); ?><br>
                                        Phone : <?php echo e(Auth::user()->mobile); ?>

                                    </address>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="pull-right m-t-10">
                                    <address class="m-b-10">
                                        <strong>Bank : </strong> <span class="bank"></span><br>
                                        <strong>Acc. Bal. : </strong> <span class="balance"></span><br>
                                        <strong>Bank Rrn: </strong> <span class="rrn"></span><br>
                                    </address>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <h4 class="title"></h4>
                                    <table class="table m-t-10 table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Narrartion</th>
                                                <th>Type</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody class="statementData">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0)" id="statementprint" class="btn btn-primary"><i class="fa fa-print"></i></a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script src="<?php echo e(asset('/assets/js/core/jQuery.print.js')); ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {

        if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {

                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;
                    var longitude = $("#kycForm").find('[name="longitude"]').val(lng);
                    var latitude = $("#kycForm").find('[name="latitude"]').val(lat);
                })

            }
            

        $('#print').click(function() {
            $('#receipt').find('.modal-body').print();
        });
        $('#balanceprint').click(function() {
            $('#balancemodal').find('.modal-body').print();
        });
        $('#statementprint').click(function() {
            $('#ministatement').find('.modal-body').print();
        });

           if ("<?php echo e(@$agent->ekyc); ?>" == '0' && "<?php echo e(@$agent->status); ?>" == 'success' || "<?php echo e(@$agent->ekyc); ?>" == '' && "<?php echo e(@$agent->status); ?>" == 'success') {
            $('#kycModal').modal('show');
        }

        $('.mydatepic').datepicker({
            'autoclose': true,
            'clearBtn': true,
            'todayHighlight': true,
            'format': 'dd-mm-yyyy',
        });

        $('form#transactionForm').submit(function() {
            var form = $(this);
            var type = form.find('[name="type"]');
            $(this).ajaxSubmit({
                dataType: 'json',
                beforeSubmit: function() {
                    swal({
                        title: 'Wait!',
                        text: 'We are working on request.',
                        onOpen: () => {
                            swal.showLoading()
                        },
                        allowOutsideClick: () => !swal.isLoading()
                    });
                },
                success: function(data) {
                    swal.close();
                    console.log(type);
                    switch (data.statuscode) {
                        case 'TXN':
                            swal({
                                title: 'Suceess',
                                text: data.message,
                                type: 'success',
                                onClose: () => {
                                    window.open(data.data.url, "_blank");

                                }
                            });
                            break;
                        case 'REDIRECT':
                             var win = window.open(data.url, '_blank');
                                if (win) {
                                    //Browser has allowed it to be opened
                                    win.focus();
                                } else {
                                    //Browser has blocked it
                                    alert('Please allow popups for this website');
                                }
                            break ;
                        default:
                            notify(data.message, 'error');
                            break;
                    }
                },
                error: function(errors) {
                    swal.close();
                    if (errors.status == '400') {
                        notify(errors.responseJSON.message, 'error');
                    } else {
                        swal(
                            'Oops!',
                            'Something went wrong, try again later.',
                            'error'
                        );
                    }
                }
            });
            return false;
        });


        $('form#kycForm').submit(function() {

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {

                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;
                    var longitude = $("#kycForm").find('[name="longitude"]').val(lng);
                    var latitude = $("#kycForm").find('[name="latitude"]').val(lat);
                })

            }
            var form = $(this);
            var type = form.find('[name="type"]');
            $(this).ajaxSubmit({
                dataType: 'json',
                beforeSubmit: function() {
                    form.find('button[type="submit"]').html('Please wait...').attr('disabled', true).addClass('btn-secondary');
                },
                complete: function() {
                    form.find('button[type="submit"]').html('Submit').attr('disabled', false).removeClass('btn-secondary');
                },
                success: function(data) {
                    console.log(data);
                    switch (data.statuscode) {
                        case 'TXN':
                            var txnType = $('#E_transactionType').val();
                            if (txnType == 'sendotp') {
                                $('#E_transactionType').val('validateOtp');
                                $('#sendOtpModal').css('display', 'none');
                                $('#validateOtpModal').css('display', 'block');
                                $('#pkId').val(data.data.primaryKeyId);
                                $('#fpkId').val(data.data.encodeFPTxnId);
                            } else if (txnType == 'validateOtp') {
                                $('#E_transactionType').val('doekyc');
                                $('#sendOtpModal').css('display', 'none');
                                $('#validateOtpModal').css('display', 'none');
                                $('#EKYCModal').css('display', 'block');
                                $('#epkId').val(data.data.primaryKeyId);
                                $('#efpkId').val(data.data.encodeFPTxnId);
                            } else if (txnType == 'doekyc') {
                                swal({
                                    title: 'Suceess',
                                    text: data.message,
                                    type: 'success',
                                    onClose: () => {
                                        window.location.reload();
                                    
                                    }
                                });
                            }

                            break;
                           case 'REDIRECT':
                             var win = window.open(data.url, '_blank');
                                if (win) {
                                    //Browser has allowed it to be opened
                                    win.focus();
                                } else {
                                    //Browser has blocked it
                                    alert('Please allow popups for this website');
                                }
                            break ;
                        default:
                            notify(data.message, 'error');
                            break;
                    }
                },
                error: function(errors) {
                    form.find('button[type="submit"]').html('Submit').attr('disabled', false).removeClass('btn-secondary');

                    if (errors.status == '400') {
                        notify(errors.responseJSON.message, 'error');
                    } else {
                        swal(
                            'Oops!',
                            'Something went wrong, try again later.',
                            'error'
                        );
                    }
                }
            });
            return false;


            return false;
        });

    });

    function getDistrict(ele) {
        $.ajax({
            url: "<?php echo e(route('dmt1pay')); ?>",
            type: "POST",
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                swal({
                    title: 'Wait!',
                    text: 'We are fetching district.',
                    allowOutsideClick: () => !swal.isLoading(),
                    onOpen: () => {
                        swal.showLoading()
                    }
                });
            },
            data: {
                'type': "getdistrict",
                'stateid': $(ele).val()
            },
            success: function(data) {
                swal.close();
                var out = `<option value="">Select District</option>`;
                $.each(data.message, function(index, value) {
                    out += `<option value="` + value.districtid + `">` + value.districtname + `</option>`;
                });

                $('[name="bc_district"]').html(out);
            }
        });
    }

    function getkycStatus() {
        $.ajax({
            url: "<?php echo e(route('kycStatusCheck')); ?>",
            type: "POST",
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                swal({
                    title: 'Wait!',
                    text: 'We are fetching kyc status.',
                    allowOutsideClick: () => !swal.isLoading(),
                    onOpen: () => {
                        swal.showLoading()
                    }
                });
            },

            success: function(data) {
                swal({
                    title: 'Suceess',
                    text: data.message,
                    type: 'success',
                    onClose: () => {
                        window.location.reload();
                    }
                });
            }
        });
    }

    $('#device').change(function() {
        var optionSelected = $(this).find("option:selected");
        var device = optionSelected.val();
        rdservice(device, "11100", 'kyc');
    });

    function rdservice(device, port, type = "none") {
        var primaryUrl = "http://127.0.0.1:" + port;
        // var primaryUrl = "http://localhost:"+port;

        $.ajax({
            type: "RDSERVICE",
            async: true,
            crossDomain: true,
            url: primaryUrl,
            processData: false,
            beforeSend: function() {
                swal({
                    title: 'Scanning',
                    text: 'Please wait, device getting initiated',
                    onOpen: () => {
                        swal.showLoading()
                    },
                    allowOutsideClick: () => !swal.isLoading()
                });
            },
            success: function(data) {
                swal.close();
                var $doc = $.parseXML(data);
                var CmbData1 = $($doc).find('RDService').attr('status');
                var CmbData2 = $($doc).find('RDService').attr('info');

                if (!CmbData1) {
                    var CmbData1 = $(data).find('RDService').attr('status');
                    var CmbData2 = $(data).find('RDService').attr('info');
                }

                if (CmbData1 == "READY") {
                    capture(device, port, type);
                } else if (port == "11100") {
                    rdservice(device, "11101", type);
                } else if (port == "11101") {
                    rdservice(device, "11102", type);
                } else if (port == "11102") {
                    rdservice(device, "11103", type);
                } else if (port == "11103") {
                    rdservice(device, "11104", type);
                } else if (port == "11104") {
                    rdservice(device, "11105", type);
                } else {
                    notify("Device : " + CmbData1, 'warning');
                }
            },
            error: function(jqXHR, ajaxOptions, thrownError) {
                swal.close();
                //$('#aepsTransactionForm').unblock();
                if (port == "11100") {
                    rdservice(device, "11101", type);
                } else if (port == "11101") {
                    rdservice(device, "11102", type);
                } else if (port == "11102") {
                    rdservice(device, "11103", type);
                } else if (port == "11103") {
                    rdservice(device, "11104", type);
                } else if (port == "11104") {
                    rdservice(device, "11105", type);
                } else {
                    notify("Oops! Device not working correctly, please try again", 'warning');
                }
            },
        });
    }

    function capture(device, port, type) {
        var primaryUrl = "http://127.0.0.1:" + port;
        if (device == "MORPHO_PROTOBUF") {
            var url = primaryUrl + "/capture";
        } else {
            var url = primaryUrl + "/rd/capture";
        }

        if (type == "kyc") {
            var XML = '<PidOptions ver=\"1.0\"><Opts env=\"P\" fCount=\"1\" fType=\"2\" iCount=\"0\" format=\"0\" pidVer=\"2.0\" timeout=\"15000\" wadh=\"E0jzJ/P8UopUHAieZn8CKqS4WPMi5ZSYXgfnlfkWjrc=\" posh=\"UNKNOWN\" /></PidOptions>';
        } else {
            if (device == "MANTRA_PROTOBUF") {
                var XML = '<?php echo '<?xml version="1.0"?>'; ?> <PidOptions ver="1.0"> <Opts fCount="2" fType="2" iCount="0" pCount="0" format="0" pidVer="2.0" timeout="20000" posh="UNKNOWN" env="P" wadh=""/> <CustOpts><Param name="mantrakey" value="" /></CustOpts> </PidOptions>';
            } else {
                var XML = '<PidOptions ver=\"1.0\">' + '<Opts fCount=\"2\" fType=\"2\" iCount=\"\" iType=\"\" pCount=\"\" pType=\"\" format=\"0\" pidVer=\"2.0\" timeout=\"10000\" otp=\"\" wadh=\"\" posh=\"\"/>' + '</PidOptions>';
            }
        }

        $.ajax({
            type: "CAPTURE",
            async: true,
            crossDomain: true,
            url: url,
            data: XML,
            contentType: "text/xml; charset=utf-8",
            processData: false,
            beforeSend: function() {
                swal({
                    text: 'Please put any of your finger on device',
                    imageUrl: '<?php echo e(asset("")); ?>assets/images/capute.png',
                    showConfirmButton: false,
                    allowOutsideClick: () => false
                });
            },
            success: function(data) {
                swal.close();
                if (device == "MANTRA_PROTOBUF") {
                    var $doc = $.parseXML(data);
                    var errorInfo = $($doc).find('Resp').attr('errInfo');

                    if (errorInfo == 'Success.') {
                        notify("Fingerprint Captured Successfully", "success");
                        if (type == "none") {
                            $('[name="biodata"]').val(data);
                            $('#aepsTransactionForm').submit();
                        } else {
                            $('[name="mybiodata"]').val(data);
                            //$('#kycForm').submit();
                        }

                    } else {
                        notify("Oops! Device not working correctly, please try again", "warning");
                    }
                } else {
                    var errorInfo = $(data).find('Resp').attr('errInfo');
                    var errorCode = $(data).find('Resp').attr('errCode');
                    var mydata = $(data).find('PidData').html();
                    if (errorCode == '0') {
                        notify("Fingerprint Captured Successfully", "success");
                        if (type == "none") {
                            $('[name="biodata"]').val("<PidData>" + mydata + "</PidData>");
                            $('#aepsTransactionForm').submit();
                        } else {
                            $('[name="mybiodata"]').val("<PidData>" + mydata + "</PidData>");
                            //$('#kycForm').submit();

                        }
                    } else {
                        notify("Oops! Device not working correctly, please try again", "warning");
                    }
                }
            },
            error: function(jqXHR, ajaxOptions, thrownError) {
                console.log(thrownError);
                swal.close();
                notify("Oops! Device not working correctly, please try again", "warning");
            },
        });
    }





    $("#aepsTransactionForm").validate({
        rules: {
            mobileNumber: {
                required: true,
                minlength: 10,
                number: true,
                maxlength: 11
            },
            transactionAmount: {
                max: 10000,
                min: 100,

            },
            adhaarNumber: {
                required: true,
                number: true,
                minlength: 12,
                maxlength: 12
            },
            bankName1: 'required',
            routeType: 'required',
            device: 'required'
        },
        messages: {
            mobileNumber: {
                required: "Please enter mobile number",
                number: "Mobile number should be numeric",
                minlength: "Your mobile number must be 10 digit",
                maxlength: "Your mobile number must be 10 digit"
            },
            adhaarNumber: {
                required: "Please enter aadhar number",
                number: "Aadhar number should be numeric",
                minlength: "Your aadhar number must be 12 digit",
                maxlength: "Your aadhar number must be 12 digit"
            },
            transactionAmount: {
                required: "Please enter amount",
                number: "Transaction amount should be numeric",
                min: "Minimum transaction amount should be 100",
                max: "Maximum transaction amount should be 10000"
            },
            bankName1: "Please select bank",
            routeType: "Please select routeType",
            device: "Please select device"
        },
        errorElement: "p",
        errorPlacement: function(error, element) {
            if (element.prop("name") === "bankId") {
                error.insertAfter(element.closest(".form-group").find("span.select2"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(element) {

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {

                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;
                    var longitude = $("#aepsTransactionForm").find('[name="longitude"]').val(lng);
                    var latitude = $("#aepsTransactionForm").find('[name="latitude"]').val(lat);
                })

            }

            var form = $("#aepsTransactionForm");
            var scan = form.find('[name="biodata"]').val();
            var lat = "yes";

            if (scan != '') {
                if (lat != '') {
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button[type="submit"]').html('Please wait...').attr('disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button[type="submit"]').html('Scan & Submit').attr('disabled', false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            form.find('[name="biodata"]').val('');
                         if(data.status == 'REDIRECT'){
                             var win = window.open(data.url, '_blank');
                            if (win) {
                                //Browser has allowed it to be opened
                                win.focus();
                            } else {
                                //Browser has blocked it
                                alert('Please allow popups for this website');
                            }
                                    console.log(data.url) ;
                            }
                            if (data.status == "TXN" || data.status == "TUP") {
                                form[0].reset();
                                form.find('select').select2().val(null).trigger('change');
                                getbalance();
                                if (data.status == "TXN" || data.status == "TUP") {
                                    if (data.transactionType != "MS") {
                                        if (data.transactionType == "CW") {
                                            $('#receipt').find('.rrn').text(data.refno);
                                            $('#receipt').find('.aadhar').text(data.aadhar);
                                            $('#receipt').find('.amount').text(data.amount);
                                            $('#receipt').find('.id').text(data.txnid);
                                            $('#receipt').find('.created_at').text(data.date);
                                            $('#receipt').find('.status').text("Success");
                                            $('#receipt').find('.bank').text(data.bank);
                                            $('#receipt').find('.balance').text(data.balance);
                                            $('#receipt').find('.title').text(data.txnTitle);
                                            $('#receipt').modal('show');
                                        } else if (data.transactionType == "2FA") {
                                            swal({
                                                title: '2FA Success',
                                                text: data.message,
                                                type: 'success'
                                            });
                                        } else {
                                            $('#balancemodal').find('.created_at').text(data.created_at);
                                            $('#balancemodal').find('.rrn').text(data.refno);
                                            $('#balancemodal').find('.aadhar').text(data.aadhar);
                                            $('#balancemodal').find('.id').text(data.txnid);
                                            $('#balancemodal').find('.status').text("Success");
                                            $('#balancemodal').find('.bank').text(data.bank);
                                            $('#balancemodal').find('.balance').text(data.balance);
                                            $('#balancemodal').find('.title').text(data.txnTitle);
                                            $('#balancemodal').modal('show');
                                        }
                                    } else {
                                        $('#ministatement').find('.rrn').text(data.refno);
                                        $('#ministatement').find('.bank').text(data.bank);
                                        $('#ministatement').find('.balance').text(data.balance);
                                        $('#ministatement').find('.title').text(data.txnTitle);
                                        var trdata = '';


                                        if (data) {

                                            $.each(data.statement, function(index, val) {

                                                if (val.txnType == "CR") {
                                                    trdata += `<tr>
                                                                <td>` + val.date + `</td>
                                                                <td>` + val.narration + `</td>
                                                                <td>` + val.txnType + `</td>
                                                                <td>` + val.amount + `</td>
                                                                <td></td>
                                                            </tr>`;
                                                } else {
                                                    trdata += `<tr>
                                                                <td>` + val.date + `</td>
                                                                <td>` + val.narration + `</td>
                                                                <td>` + val.txnType + `</td>
                                                                <td>` + val.amount + `</td>
                                                            </tr>`;
                                                }
                                            });
                                        }

                                        $('#ministatement').find('.statementData').html(trdata);
                                        $('#ministatement').modal('show');
                                    }
                                } else {
                                    swal('Failed', data.message, 'error');
                                }
                            } else {
                                form.find('[name="biodata"]').val('');
                                swal({
                                    title: 'Failed',
                                    text: data.message,
                                    type: 'error'
                                });
                            }
                        },
                        error: function(errors) {
                            form.find('button[type="submit"]').html('Scan & Submit').attr('disabled', false).removeClass('btn-secondary');
                        
                            form.find('[name="biodata"]').val('');
                            showError(errors, form);
                        }
                    });
                }
            } else {
                scandata();
            }
        }
    });


    function scandata() {
        var device = $("#aepsTransactionForm").find('[name="device"]:checked').val();
        var port = 11100;
        var portfound = false;
        rdservice(device, port);
        /*for (i = port ; i <= 11120 ; i++) {
            
             if (portfound) {
                 break;
             }
             rdservice(device, i);
        }  */

    }

    function showPosition(position) {
        swal.close();
        $("[name='lat']").val(position.coords.latitude);
        $("[name='lon']").val(position.coords.longitude);
        $('#aepsTransactionForm').submit();
    }

    function amount(amount) {
        $('[name="transactionAmount"]').val(amount);
    }

    function AEPSTAB(type) {

        if (type == "CW" || type == "M" ||  type == "AP") {
            $('.transactionAmount').html(`
                <label>Amount :</label>
                <input type="text" class="form-control" name="transactionAmount" pattern="[0-9]*" id="amount" autocomplete="off" placeholder="Enter Amount">
                <span class="text-dark bg-light badge badge-light my-1" onclick="amount('100')" style="cursor: pointer;">100</span>
                <span class="text-dark bg-light badge badge-light my-1" onclick="amount('500')" style="cursor: pointer;">500</span>
                <span class="text-dark bg-light badge badge-light my-1" onclick="amount('1000')" style="cursor: pointer;">1000</span>
                <span class="text-dark bg-light badge badge-light my-1" onclick="amount('1500')" style="cursor: pointer;">1500</span>
                <span class="text-dark bg-light badge badge-light my-1" onclick="amount('2000')" style="cursor: pointer;">2000</span>
                <span class="text-dark bg-light badge badge-light my-1" onclick="amount('2500')" style="cursor: pointer;">2500</span>
                <span class="text-dark bg-light badge badge-light my-1" onclick="amount('3000')" style="cursor: pointer;">3000</span>
                <span class="text-dark bg-light badge badge-light my-1" onclick="amount('10000')" style="cursor: pointer;">10000</span>
            `);
        } else {
            $('.transactionAmount').html('');
        }

        authType = "0"; // Default value for Auth Type is 0 - No Authentication

        if (type == "CW") {
            $('.mytitle').text("Cash Withdrawal");
        } else if (type == "BE") {
            $('.mytitle').text("Balance Enquiry");
        } else if (type == "2FA") {
            $('.mytitle').text("2FA");
        } else if (type == "AP") {
            $('.mytitle').text("Aadhaar Pay");
        }else if (type == "2FAP") {
            type = "2FA";
            authType = "2";
            $('.mytitle').text("2FAP");
        }else {
            $('.mytitle').text("Mini Statement");
        }
        $("#aepsTransactionForm").find('[name="transactionType"]').val(type)
        $("#aepsTransactionForm").find('[name="authType"]').val(authType)
    }

    function bank(iinno) {
        // $('[name="iin"]').val(iinno).trigger('change');
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.quick2pay.in/resources/views/service/aeps.blade.php ENDPATH**/ ?>