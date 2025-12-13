<?php $__env->startSection('title', 'Create '.$type); ?>
<?php $__env->startSection('pagetitle', 'Create '.$type); ?>
<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-lg-12 ">
        <div class="card h-100">
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4">
                <div class="card-title mb-0">
                    <h5 class="mb-0">
                        <h4>Personal Information</h4>
                    </h5>
                </div>
            </div>

            <div class="card-body">
                <div class=" rounded mt-5">
                    <form class="memberForm" action="<?php echo e(route('memberstore')); ?>" method="post">
                        <?php echo e(csrf_field()); ?>

                        <div class="row">
                            <?php if(!$role): ?>
                            <div class="col-md-12">
                                <h5>Member Type Information</h5>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Mamber Type</label>
                                        <select name="role_id" class="form-control my-1" required="">
                                            <option value="">Select Role</option>
                                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($role->id); ?>"><?php echo e($role->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <?php else: ?>
                            <input type="hidden" name="role_id" value="<?php echo e($role->id); ?>">
                            <?php endif; ?>

                            <div class="form-group col-md-6 my-1">
                                <label for="fname">Name : <span class="text-danger fw-bold h6">*</span></label>
                                <input type="text" name="name" class="form-control my-1" id="fname" placeholder="First Name">
                            </div>
                            <div class="form-group col-md-6 my-1">
                                <label for="lname">Mobile : <span class="text-danger fw-bold h6">*</span></label>
                                <input type="tel" maxlength="10" name="mobile" class="form-control my-1" id="lname" placeholder="Mobile Number">
                            </div>
                            <div class="form-group col-md-6 my-1">
                                <label for="add1">Email : <span class="text-danger fw-bold h6">*</span></label>
                                <input type="email" name="email" class="form-control my-1" id="add1" placeholder="Email Address">
                            </div>

                            <div class="form-group col-md-6 my-1">
                                <label for="cname">State : <span class="text-danger fw-bold h6">*</span></label>
                                <select name="state" class="form-control my-1" required="">
                                    <option value="">Select State</option>
                                    <?php $__currentLoopData = $state; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($state->state); ?>"><?php echo e($state->state); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6 my-1">
                                <label for="add2">Address : <span class="text-danger fw-bold h6">*</span></label>
                                <input type="text" name="address" class="form-control my-1" id="add2" placeholder="Address">
                            </div>
                            <div class="form-group col-md-6 my-1">
                                <label>City : <span class="text-danger fw-bold h6">*</span></label>
                                <input type="text" name="city" class="form-control my-1" value="" required="" placeholder="City">
                            </div>

                            <div class="form-group col-md-6 my-1">
                                <label>Pin Code : <span class="text-danger fw-bold h6">*</span></label>
                                <input type="tel" name="pincode" class="form-control my-1" value="" required="" maxlength="6" minlength="6" placeholder="PinCode">

                            </div>
                            <div class="form-group col-md-6 my-1">
                                <label>Shop Name : <span class="text-danger fw-bold h6">*</span></label>
                                <input type="text" name="shopname" class="form-control my-1" value="" required="" placeholder="Shop Name">
                            </div>
                            <div class="form-group col-md-6 my-1">
                                <label>PAN Card Number : <span class="text-danger fw-bold h6">*</span></label>
                                <input type="text" id="pancard" name="pancard" class="form-control my-1" value="" required="" placeholder="Pan card">

                            </div>
                            <div class="form-group col-md-6 my-1">
                                <label>Aadhaar Card Number : <span class="text-danger fw-bold h6">*</span></label>
                                <input type="text" name="aadharcard" id="aadharcard" class="form-control my-1" value="" required="" placeholder="Aadhar Card Number" maxlength="12" minlength="12">

                            </div>
                            <?php if(Myhelper::hasRole('admin') || (isset($mydata['schememanager']) && $mydata['schememanager']->value == "all")): ?>
                            <div class="form-group col-md-6 my-1">
                                <label>Scheme</label>
                                <select name="scheme_id" class="form-control my-1" required="">
                                    <option value="">Select Scheme</option>
                                    <?php $__currentLoopData = $scheme; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scheme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($scheme->id); ?>"><?php echo e($scheme->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <?php endif; ?>
                        </div>


                        

                        <?php if($role->slug == "whitelable"): ?>
                        <h5 class="mb-3">Whitelable Information</h5>
                        <div class="row">
                            <div class="form-group col-md-6 my-1">
                                <label>Company Name <span class="text-danger fw-bold">*</span></label>
                                <input type="text" name="companyname" class="form-control my-1" value="" required="" placeholder="Enter Value">
                            </div>
                            <div class="form-group col-md-6 my-1">
                                <label>Domain <span class="text-danger fw-bold">*</span></label>
                                <input type="url" name="website" class="form-control my-1" value="" required="" placeholder="Enter Value">
                            </div>
                        </div>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-primary mt-2">Add New User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        $(".memberForm").validate({
            rules: {
                name: {
                    required: true,
                },
                mobile: {
                    required: true,
                    minlength: 10,
                    number: true,
                    maxlength: 10
                },
                email: {
                    required: true,
                    email: true
                },
                state: {
                    required: true,
                },
                city: {
                    required: true,
                },
                pincode: {
                    required: true,
                    minlength: 6,
                    number: true,
                    maxlength: 6
                },
                address: {
                    required: true,
                },
                aadharcard: {
                    required: true,
                    minlength: 12,
                    number: true,
                    maxlength: 12
                }
                <?php if($role -> slug == "whitelable"): ?>,
                companyname: {
                    required: true,
                },
                website: {
                    required: true,
                    url: true
                }
                <?php endif; ?>
            },
            messages: {
                name: {
                    required: "Please enter name",
                },
                mobile: {
                    required: "Please enter mobile",
                    number: "Mobile number should be numeric",
                    minlength: "Your mobile number must be 10 digit",
                    maxlength: "Your mobile number must be 10 digit"
                },
                email: {
                    required: "Please enter email",
                    email: "Please enter valid email address",
                },
                state: {
                    required: "Please select state",
                },
                city: {
                    required: "Please enter city",
                },
                pincode: {
                    required: "Please enter pincode",
                    number: "Mobile number should be numeric",
                    minlength: "Your pincode must be 6 digit",
                    maxlength: "Your pincode must be 6 digit"
                },
                address: {
                    required: "Please enter address",
                },
                aadharcard: {
                    required: "Please enter aadharcard",
                    number: "Aadhar should be numeric",
                    minlength: "Your aadhar number must be 12 digit",
                    maxlength: "Your aadhar number must be 12 digit"
                }
                <?php if($role -> slug == "whitelable"): ?>,
                companyname: {
                    required: "Please enter company name",
                },
                website: {
                    required: "Please enter company website",
                    url: "Please enter valid company url"
                }
                <?php endif; ?>
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
                var form = $('form.memberForm');
                form.find('span.text-danger').remove();
                $('form.memberForm').ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {
                        form.find('button:submit').html('Please wait...').attr('disabled',true).addClass('btn-secondary');
                    },
                    complete: function() {
                        form.find('button:submit').html('Add New User').attr('disabled',false).removeClass('btn-secondary');
                    },
                    success: function(data) {
                        if (data.status == "success") {
                            form[0].reset();
                            $('select').val('');
                            $('select').trigger('change');
                            notify("Member Successfully Created", 'success');
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

        // Pan Verify keyup function

        /*$('#pancard').keyup(function() {
               // alert("");
              var pancard= $('#pancard').val();
              if(pancard.length >= 10){  
                  swal({
                        title: 'Wait!',
                        text: 'We are working on request.',
                        onOpen: () => {
                            swal.showLoading()
                        },
                        allowOutsideClick: () => !swal.isLoading()
                    });
                  $.ajax({
                          url:"<?php echo e(route('adharnumberverify')); ?>",
                               type:"POST",
                               data: {
                                  type:'panverify',
                                   pancard : pancard,
                                   _token: '<?php echo e(csrf_token()); ?>'
                                },
                               success:function (data) {
                                   swal.close();
                                    if(data.status == 'TXN'){
                                        swal("Verified","Your Pan Card is Verified " + data.full_name, "success");

                                    }else{
                                         $('#pancard'). val('');
                                         swal({
                                                 type: 'warning',
                                                 title: '!ERROR',
                                                 text: data.message,
                                                 showConfirmButton: true
                                             });  
                                    }
                               }
                           })
              }else{
                  
              }
            
         
        });*/


        $("#otpForm").validate({
            rules: {
                otp: {
                    required: true,
                    number: true
                }

            },
            messages: {
                otp: {
                    required: "Please enter otp",
                    number: "Reset otp should be numeric",
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
                var form = $('#otpForm');
                form.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {
                        swal({
                            title: 'Wait!',
                            text: 'We are checking your details',
                            onOpen: () => {
                                swal.showLoading()
                            },
                            allowOutsideClick: () => !swal.isLoading()
                        });
                    },
                    success: function(data) {
                        swal.close();
                        if (data.status == "TXN") {
                            $('#otpModal').modal('hide');

                            // $('#registerForm').find(':input[type=submit]').removeAttr('disabled');
                            $('#registerForm').find('[name="address"]').val(data.address);
                            $("#address").prop('readonly', true);
                            $('#registerForm').find('[name="name"]').val(data.name);
                            $("#name").prop('readonly', true);
                            $('#registerForm').find('[name="city"]').val(data.city);
                            $("#city").prop('readonly', true);
                            $('#registerForm').find('[name="pincode"]').val(data.pin);
                            $("#pincode").prop('readonly', true);
                            $('#registerForm').find('[name="state"]').select2().val(data.state).trigger('change');
                            $("state").prop('readonly', true);
                            // $('#registerForm').find('[name="state"]').val();
                            swal("Verified", "Your Adhar Card is Verified " + data.full_name, "success");

                        } else {
                            $('#aadharcard').val('');
                            swal({
                                type: 'warning',
                                title: '!ERROR',
                                text: data.message,
                                showConfirmButton: true
                            });
                        }
                    },
                    error: function(errors) {
                        swal.close();
                        if (errors.status == '400') {
                            notify(errors.responseJSON.status, 'warning');
                        } else {
                            notify('Something went wrong, try again later.', 'warning');
                        }
                    }
                });
            }
        });

        // For Aadhar Verification Keyup Function


        /* $('#aadharcard').keyup(function() {
               // alert("");
              var aadharcard= $('#aadharcard').val();
              if(aadharcard.length >= 12){  
                  swal({
                        title: 'Wait!',
                        text: 'We are working on request.',
                        onOpen: () => {
                            swal.showLoading()
                        },
                        allowOutsideClick: () => !swal.isLoading()
                    });
                  $.ajax({
                        url:"<?php echo e(route('adharnumberverify')); ?>",
                               type:"POST",
                               data: {
                                  type:'getotp',
                                   aadharcard : aadharcard,
                                   _token: '<?php echo e(csrf_token()); ?>'
                                },
                                
                              
                               success:function (data) {
                                   swal.close();
                                    if(data.status == 'TXNOTP'){
                                        $('#otpModal').find('[name="aadharcard"]').val(aadharcard);
                                        $('#otpModal').find('[name="refid"]').val(data.refid);
                                        
                                        $('#otpModal').modal('show');
                                    }else{
                                         
                                         swal({
                                                 type: 'warning',
                                                 title: '!ERROR',
                                                 text: data.message,
                                                 showConfirmButton: true
                                             });  
                                    }
                               }
                           })
              }else{
                  
              }
            
         
        });*/

    });

    function adharnumbercheck() {
        alert("hfhgf");
    }



    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#blah')
                    .attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/incognic/login.ismartpay.in/resources/views/member/create.blade.php ENDPATH**/ ?>