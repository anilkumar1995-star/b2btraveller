<?php $__env->startSection('title', ucwords($user->name) . ' Profile'); ?>
<?php $__env->startSection('bodyClass', 'has-detached-left'); ?>
<?php $__env->startSection('pagetitle', ucwords($user->name) . ' Profile'); ?>

<?php
    $table = 'yes';
?>
<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-lg-12 ">
            <div class="card h-100">
                <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">
                            <h4>My Profile</h4>
                        </h5>
                    </div>
                </div>

                <div class="card-body">
                    <div class=" rounded mt-5">
                        <div class="row gap-4 gap-sm-0">
                            <div class="">
                                <ul class="nav nav-tabs nav-pills" role="tablist">
                                    <li class="nav-item">
                                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-justified-profile" aria-controls="navs-justified-profile"
                                            aria-selected="true">
                                            Profile Details
                                        </button>
                                    </li>
                                    <?php if((Auth::id() == $user->id && Myhelper::can('password_reset')) || Myhelper::can('member_password_reset')): ?>
                                        <li class="nav-item">
                                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                data-bs-target="#navs-justified-password"
                                                aria-controls="navs-justified-password" aria-selected="false">
                                                Password Manager
                                            </button>
                                        </li>
                                    <?php endif; ?>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-justified-pin" aria-controls="navs-justified-pin"
                                            aria-selected="false">
                                            Pin Manager
                                        </button>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="navs-justified-profile" role="tabpanel">
                                        <form id="profileForm" action="<?php echo e(route('profileUpdate')); ?>" method="post"
                                            enctype="multipart/form-data">
                                            <?php echo e(csrf_field()); ?>

                                            <input type="hidden" name="id" value="<?php echo e($user->id); ?>">
                                            <input type="hidden" name="actiontype" value="profile">

                                            <div class="row">
                                                <div class="form-group col-md-4 my-1">
                                                    <label>Name</label>
                                                    <input type="text" name="name" class="form-control my-1"
                                                        value="<?php echo e($user->name); ?>" required=""
                                                        placeholder="Enter Value">
                                                </div>
                                                <div class="form-group col-md-4 my-1">
                                                    <label>Mobile</label>
                                                    <input type="tel" maxlength="10"
                                                        <?php echo e(Myhelper::hasNotRole('admin') ? 'disabled=""' : 'name=mobile'); ?>

                                                        required="" value="<?php echo e($user->mobile); ?>" class="form-control my-1"
                                                        placeholder="Enter Value">
                                                </div>
                                                <div class="form-group col-md-4 my-1">
                                                    <label>Email</label>
                                                    <input type="email" name="email" class="form-control my-1"
                                                        value="<?php echo e($user->email); ?>" required=""
                                                        placeholder="Enter Value">
                                                </div>

                                                <div class="form-group col-md-4 my-1">
                                                    <label>State</label>
                                                    <select name="state" class="form-control my-1" required="">
                                                        <option value="">Select State</option>
                                                        <?php $__currentLoopData = $state; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($state->state); ?>"><?php echo e($state->state); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4 my-1">
                                                    <label>City</label>
                                                    <input type="text" name="city" class="form-control my-1"
                                                        value="<?php echo e($user->city); ?>" required=""
                                                        placeholder="Enter Value">
                                                </div>
                                                <div class="form-group col-md-4 my-1">
                                                    <label>PIN Code</label>
                                                    <input type="tel" name="pincode" class="form-control my-1"
                                                        value="<?php echo e($user->pincode); ?>" required="" maxlength="6"
                                                        minlength="6" placeholder="Enter Value">
                                                </div>

                                                <div class="form-group col-md-4 my-1">
                                                    <label>Gender</label>
                                                    <select name="gender" class="form-control my-1" required="">
                                                        <option value="">Select Gender</option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4 my-1">
                                                    <label>Address</label>
                                                    <input type="text" name="address" class="form-control my-1"
                                                        rows="3" required="" placeholder="Enter Value"
                                                        value="<?php echo e($user->address); ?>"></input>
                                                </div>
                                                <?php if(Myhelper::hasRole('admin')): ?>
                                                    <div class="form-group col-md-4 my-1">
                                                        <label>Security PIN</label>
                                                        <input type="password" name="mpin" autocomplete="off"
                                                            class="form-control my-1" required="">
                                                    </div>
                                                <?php endif; ?>

                                                <?php if((Auth::id() == $user->id && Myhelper::can('profile_edit')) || Myhelper::can('member_profile_edit')): ?>
                                                    <div class="col-sm-12">
                                                        <button class="btn btn-primary pull-right  mt-2" type="submit"
                                                            data-loading-text="<i class='fa fa-spin fa-spinner'></i> Updating...">Update
                                                            Profile</button>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </form>
                                    </div>



                                    <div class="tab-pane fade " id="navs-justified-password" role="tabpanel">
                                        <form id="passwordForm" action="<?php echo e(route('profileUpdate')); ?>" method="post"
                                            enctype="multipart/form-data">
                                            <?php echo e(csrf_field()); ?>

                                            <input type="hidden" name="id" value="<?php echo e($user->id); ?>">
                                            <input type="hidden" name="actiontype" value="password">
                                            <div class="panel panel-default">

                                                <div class="panel-body p-b-0">
                                                    <div class="row">
                                                        <?php if(Auth::id() == $user->id || (Myhelper::hasNotRole('admin') && !Myhelper::can('member_password_reset'))): ?>
                                                            <div class="form-group col-md-4 my-1">
                                                                <label>Old Password</label>
                                                                <input type="password" name="oldpassword"
                                                                    class="form-control my-1" required=""
                                                                    placeholder="Enter Value">
                                                            </div>
                                                        <?php endif; ?>

                                                        <div class="form-group col-md-4 my-1">
                                                            <label>New Password</label>
                                                            <input type="password" name="password" id="password"
                                                                class="form-control my-1" required=""
                                                                placeholder="Enter Value">
                                                        </div>

                                                        <?php if(Auth::id() == $user->id || (Myhelper::hasNotRole('admin') && !Myhelper::can('member_password_reset'))): ?>
                                                            <div class="form-group col-md-4 my-1">
                                                                <label>Confirmed Password</label>
                                                                <input type="password" name="password_confirmation"
                                                                    class="form-control my-1" required=""
                                                                    placeholder="Enter Value">
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php if(Myhelper::hasRole('admin')): ?>
                                                            <div class="form-group col-md-4 my-1">
                                                                <label>Security PIN</label>
                                                                <input type="password" name="mpin" autocomplete="off"
                                                                    class="form-control my-1" required="">
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class="col-sm-12">
                                                            <button class="btn btn-primary mt-2 pull-right" type="submit"
                                                                data-loading-text="<i class='fa fa-spin fa-spinner'></i> Resetting...">Password
                                                                Reset</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="tab-pane fade" id="navs-justified-pin" role="tabpanel">
                                        <form id="pinForm" action="<?php echo e(route('setpin')); ?>" method="post"
                                            enctype="multipart/form-data">
                                            <?php echo e(csrf_field()); ?>

                                            <input type="hidden" name="id" value="<?php echo e($user->id); ?>">
                                            <input type="hidden" name="mobile" value="<?php echo e($user->mobile); ?>">
                                            <div class="row">
                                                <div class="form-group col-md-4 my-1">
                                                    <label>New PIN</label>
                                                    <input type="password" name="pin" id="pin"
                                                        class="form-control my-1" required=""
                                                        placeholder="Enter Value">
                                                </div>
                                                <div class="form-group col-md-4 my-1">
                                                    <label>Confirmed PIN</label>
                                                    <input type="password" name="pin_confirmation"
                                                        class="form-control my-1" required=""
                                                        placeholder="Enter Value">
                                                </div>
                                                <div class="form-group col-md-4 my-1">
                                                    <label>OTP</label>
                                                    <input type="password" name="otp" class="form-control my-1"
                                                        Placeholder="Otp" required>
                                                    <a href="javascript:void(0)" onclick="OTPRESEND()"
                                                        class="text-primary pull-right fw-bloder">Send OTP</a>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <button class="btn btn-primary mt-2 float-right" type="submit"
                                                        data-loading-text="<i class='fa fa-spin fa-spinner'></i> Resetting...">Reset
                                                        Pin</button>

                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                    



                                    


                                    <?php if(\Myhelper::hasRole('admin')): ?>


                                        <div class="tab-pane fade my-1" id="navs-justified-role" role="tabpanel">
                                            <form id="roleForm" action="<?php echo e(route('profileUpdate')); ?>" method="post">
                                                <?php echo e(csrf_field()); ?>

                                                <input type="hidden" name="id" value="<?php echo e($user->id); ?>">
                                                <input type="hidden" name="actiontype" value="rolemanager">
                                                <div class="row">
                                                    <div class="form-group col-md-4 my-1">
                                                        <label>Member Role</label>
                                                        <select name="role_id" class="form-control my-1" required="">
                                                            <option value="">Select Role</option>
                                                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($role->id); ?>"><?php echo e($role->name); ?>

                                                                </option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                    <?php if(Myhelper::hasRole('admin')): ?>
                                                        <div class="form-group col-md-4 my-1">
                                                            <label>Security PIN</label>
                                                            <input type="password" name="mpin" autocomplete="off"
                                                                class="form-control my-1" required="">
                                                        </div>
                                                    <?php endif; ?>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <button class="btn btn-primary mt-2 pull-right" type="submit"
                                                            data-loading-text="<i class='fa fa-spin fa-spinner'></i> Changing...">Change</button>

                                                    </div>
                                                </div>
                                            </form>
                                        </div>



                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>

    
    

<?php $__env->stopSection(); ?>


<?php $__env->startPush('script'); ?>
    <script type="text/javascript">
        $(document).ready(function() {
          
            $('[name="state"]').val('<?php echo e($user->state); ?>').trigger('change');
            $('[name="gender"]').val('<?php echo e($user->gender); ?>').trigger('change');
            <?php if(\Myhelper::hasRole('admin')): ?>
                $('[name="parent_id"]').val('<?php echo e($user->parent_id); ?>').trigger('change');
                $('[name="role_id"]').val('<?php echo e($user->role_id); ?>').trigger('change');
            <?php endif; ?>
            // $('[href="#<?php echo e($tab); ?>"]').trigger('click');
            $("#profileForm").validate({
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
                    }
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
                        minlength: "Your mobile number must be 6 digit",
                        maxlength: "Your mobile number must be 6 digit"
                    },
                    address: {
                        required: "Please enter address",
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase().toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('form#profileForm');
                    form.find('span.text-danger').remove();
                    $('form#profileForm').ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Update Profile').attr(
                                'disabled', false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                notify("Profile Successfully Updated", 'success');
                                window.location.reload();
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors, form.find('.panel-body'));
                        }
                    });
                }
            });

            $("#kycForm").validate({
                rules: {
                    aadharcard: {
                        required: true,
                        minlength: 12,
                        number: true,
                        maxlength: 12
                    },
                    pancard: {
                        required: true,
                    },
                    shopname: {
                        required: true,
                    }
                },
                messages: {
                    aadharcard: {
                        required: "Please enter aadharcard",
                        number: "Mobile number should be numeric",
                        minlength: "Your mobile number must be 12 digit",
                        maxlength: "Your mobile number must be 12 digit"
                    },
                    pancard: {
                        required: "Please enter pancard",
                    },
                    shopname: {
                        required: "Please enter shop name",
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase().toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('form#kycForm');
                    form.find('span.text-danger').remove();
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Update Profile').attr(
                                'disabled', false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                notify("Profile Successfully Updated", 'success');
                                window.location.reload();
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors, form.find('.panel-body'));
                            form.find('button:submit').html('Update Profile').attr(
                                'disabled', false).removeClass('btn-secondary');

                        }
                    });
                }
            });

            $("#passwordForm").validate({
                rules: {
                    <?php if(Auth::id() == $user->id || (Myhelper::hasNotRole('admin') && !Myhelper::can('member_password_reset'))): ?>
                        oldpassword: {
                            required: true,
                        },
                        password_confirmation: {
                            required: true,
                            minlength: 8,
                            equalTo: "#password"
                        },
                    <?php endif; ?>
                    password: {
                        required: true,
                        minlength: 8,
                    }
                },
                messages: {
                    <?php if(Auth::id() == $user->id || (Myhelper::hasNotRole('admin') && !Myhelper::can('member_password_reset'))): ?>
                        oldpassword: {
                            required: "Please enter old password",
                        },
                        password_confirmation: {
                            required: "Please enter confirmed password",
                            minlength: "Your password lenght should be atleast 8 character",
                            equalTo: "New password and confirmed password should be equal"
                        },
                    <?php endif; ?>
                    password: {
                        required: "Please enter new password",
                        minlength: "Your password lenght should be atleast 8 character",
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase().toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('form#passwordForm');
                    form.find('span.text-danger').remove();
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Password Reset').attr(
                                'disabled', false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                notify("Password Successfully Changed", 'success');
                                window.location.reload();
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors, form.find('.panel-body'));
                        }
                    });
                }
            });

            $("#memberForm").validate({
                rules: {
                    parent_id: {
                        required: true
                    }
                },
                messages: {
                    parent_id: {
                        required: "Please select parent member"
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase().toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('form#memberForm');
                    form.find('span.text-danger').remove();
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Change').attr('disabled',
                                false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                notify("Mapping Successfully Changed", 'success');
                                window.location.reload();
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors);
                        }
                    });
                }
            });

            $("#certificateForm").validate({
                rules: {
                    coo: {
                        required: true
                    },
                    cmo: {
                        required: true
                    }
                },
                messages: {
                    coo: {
                        required: "Please enter COO name"
                    },
                    cmo: {
                        required: "Please enter CMO name"
                    }

                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase().toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('form#certificateForm');
                    form.find('span.text-danger').remove();
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Change').attr('disabled',
                                false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                notify("Mapping Successfully Changed", 'success');
                                window.location.reload();
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors);
                        }
                    });
                }
            });

            $("#roleForm").validate({
                rules: {
                    role_id: {
                        required: true
                    }
                },
                messages: {
                    role_id: {
                        required: "Please select member role"
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase().toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('form#roleForm');
                    form.find('span.text-danger').remove();
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Change').attr('disabled',
                                false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                notify("Role Successfully Changed", 'success');
                                window.location.reload();
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors);
                        }
                    });
                }
            });

            $("#bankForm").validate({
                rules: {
                    account: {
                        required: true
                    },
                    bank: {
                        required: true
                    },
                    ifsc: {
                        required: true
                    }
                },
                messages: {
                    account: {
                        required: "Please enter member account"
                    },
                    bank: {
                        required: "Please enter member bank"
                    },
                    ifsc: {
                        required: "Please enter bank ifsc"
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase().toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('form#bankForm');
                    form.find('span.text-danger').remove();
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Submit').attr('disabled',
                                false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                notify("Bank Details Successfully Changed", 'success');
                                window.location.reload();
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors, form.find('.panel-body'));
                        }
                    });
                }
            });

            $("#pinForm").validate({
                rules: {
                    oldpin: {
                        required: true,
                    },
                    pin_confirmation: {
                        required: true,
                        minlength: 4,
                        equalTo: "#pin"
                    },
                    pin: {
                        required: true,
                        minlength: 4,
                    }
                },
                messages: {
                    oldpin: {
                        required: "Please enter old pin",
                    },
                    pin_confirmation: {
                        required: "Please enter confirmed pin",
                        minlength: "Your pin lenght should be atleast 4 character",
                        equalTo: "New pin and confirmed pin should be equal"
                    },
                    pin: {
                        required: "Please enter new pin",
                        minlength: "Your pin lenght should be atleast 4 character",
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase().toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('form#pinForm');
                    form.find('span.text-danger').remove();
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Reset Pin').attr('disabled',
                                false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                form[0].reset();
                                notify("Pin Successfully Changed", 'success');
                                window.location.reload();
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            // showError(errors, form.find('.panel-body'));
                            form.find('button:submit').html('Reset Pin').attr('disabled',
                                false).removeClass('btn-secondary');
                            console.log(errors.responseJSON.status);
                            notify(errors.responseJSON[0] || errors.responseJSON.status ||
                                "Something went wrong", 'error');
                        }
                    });
                }
            });


            // Wallet Lock Form AJAX Submission
            $("#walletLockForm").validate({
                rules: {
                    amount: {
                        required: true,
                        number: true
                    },
                    wallet_type: {
                        required: true
                    },
                    status: {
                        required: true
                    }
                },
                messages: {
                    amount: {
                        required: "Please enter amount",
                        number: "Amount must be numeric"
                    },
                    wallet_type: {
                        required: "Please select wallet type"
                    },
                    status: {
                        required: "Please select status"
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                submitHandler: function() {
                    var form = $('#walletLockForm');
                    form.find('span.text-danger').remove();
                    var btn = form.find('button[type="submit"]');
                    btn.html('Please wait...').attr('disabled', true).addClass('btn-secondary');
                    $.ajax({
                        url: 'wallet-lock-store',
                        type: 'POST',
                        data: form.serialize(),
                        dataType: 'json',
                        success: function(data) {
                            if (data.status === 'success') {
                                notify(data.message ||
                                    'Wallet lock amount added successfully', 'success');
                                form[0].reset();
                            } else {
                                notify(data.message || 'Something went wrong', 'error');
                            }
                        },
                        error: function(xhr) {
                            notify('Server error, please try again.', 'error');
                        },
                        complete: function() {
                            btn.html('Save').attr('disabled', false).removeClass(
                                'btn-secondary');
                        }
                    });
                }
            });


            $("#cappingStatusForm").validate({
                rules: {
                    capAmount: {
                        required: true,
                        number: true
                    },
                    walletType: {
                        required: true
                    },
                    newStatus: {
                        required: true
                    },
                    approved_by: {
                        required: true
                    },
                    userId: {
                        required: true
                    }
                },
                messages: {
                    capAmount: {
                        required: "Please enter amount",
                        number: "Amount must be numeric"
                    },
                    walletType: {
                        required: "Please select wallet type"
                    },
                    newStatus: {
                        required: "Please select status"
                    },
                    approved_by: {
                        required: "Please Enter Approved By Name"
                    },
                    userId: {
                        required: "User ID is required"
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                submitHandler: function() {
                    var form = $('#cappingStatusForm');
                    form.find('span.text-danger').remove();
                    var btn = form.find('button[type="submit"]');
                    btn.html('Please wait...').attr('disabled', true).addClass('btn-secondary');
                    $.ajax({
                        url: 'walletLockapprove',
                        type: 'POST',
                        data: form.serialize(),
                        dataType: 'json',
                        success: function(data) {
                            if (data.status === 'success') {
                                notify(data.message ||
                                    'Capping status updated successfully', 'success');
                                $('#cappingModal').modal('hide');
                                $('#datatable').DataTable().ajax.reload();
                            } else {
                                notify(data.message || 'Something went wrong', 'error');
                            }
                        },
                        error: function(xhr) {
                            notify('Server error, please try again.', 'error');
                        },
                        complete: function() {
                            btn.html('Update Status').attr('disabled', false).removeClass(
                                'btn-secondary');
                        }
                    });
                }
            });
        });

        function OTPRESEND() {
            var mobile = "<?php echo e(Auth::user()->mobile); ?>";
            if (mobile.length > 0) {
                $.ajax({
                        url: '<?php echo e(route('getotp')); ?>',
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            'mobile': mobile
                        },
                        beforeSend: function() {
                            swal({
                                title: 'Wait!',
                                text: 'Please wait, we are working on your request',
                                onOpen: () => {
                                    swal.showLoading()
                                }
                            });
                        },
                        complete: function() {
                            swal.close();
                        }
                    })
                    .done(function(data) {
                        if (data.status == "TXN") {
                            notify("Otp sent successfully", 'success');
                        } else {
                            notify(data.message, 'warning');
                        }
                    })
                    .fail(function() {
                        notify("Something went wrong, try again", 'warning');
                    });
            } else {
                notify("Enter your registered mobile number", 'warning');
            }
        }

        function changeStatus(id, wallet_type, user_id, amount, status) {
            $('[name="Id"]').val(id);
            $('[name="walletType"]').val(wallet_type);
            $('[name="userId"]').val(user_id);
            $('[name="capAmount"]').val(amount);
            $('#cappingModal').modal('show');
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\flight_b2b_travel\flight_b2b_travel\resources\views/profile/index.blade.php ENDPATH**/ ?>