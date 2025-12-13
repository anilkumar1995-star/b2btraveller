<!DOCTYPE html>

<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="<?php echo e(asset('theme_1/assets/')); ?>" data-template="vertical-menu-template">

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Login - <?php echo e(@$company->companyname); ?></title>

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo e(Imagehelper::getImageUrl().json_decode(app\Models\Company::where('id', '1')->first(['logo']))->logo); ?>" class=" img-fluid rounded" />


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="<?php echo e(asset('theme_1/assets/vendor/fonts/fontawesome.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('theme_1/assets/vendor/fonts/tabler-icons.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('theme_1/assets/vendor/fonts/flag-icons.css')); ?>" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('theme_1/assets/vendor/css/rtl/core.css')); ?>" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?php echo e(asset('theme_1/assets/vendor/css/rtl/theme-default.css')); ?>" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?php echo e(asset('theme_1/assets/css/demo.css')); ?>" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('theme_1/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('theme_1/assets/vendor/libs/node-waves/node-waves.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('theme_1/assets/vendor/libs/typeahead-js/typeahead.css')); ?>" />
    <!-- Vendor -->
    <link rel="stylesheet" href="<?php echo e(asset('theme_1/assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')); ?>" />

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.css" />

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.js"></script>

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="<?php echo e(asset('theme_1/assets/vendor/css/pages/page-auth.css')); ?>" />

    <style>
        .form-group p {
            color: red;
        }
    </style>
</head>

<body>
    <!-- Content -->
    <?php if(env('MAINTENANCE_MODE',false)): ?>
    <?php echo e(Artisan::call('down')); ?>

    <?php endif; ?>

    <div class="authentication-wrapper authentication-cover authentication-bg">
        <div class="authentication-inner row sign-in-page">
            <!-- /Left Text -->
            <div class="d-none d-lg-flex col-lg-7 p-0">
                <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
                    <img src="<?php echo e(asset('theme_1/assets/img/illustrations/auth-login-illustration-light.png')); ?>" alt="auth-login-cover" class="img-fluid my-5 auth-illustration" data-app-light-img="illustrations/auth-login-illustration-light.png" data-app-dark-img="illustrations/auth-login-illustration-dark.png" />

                    <img src="<?php echo e(asset('theme_1/assets/img/illustrations/bg-shape-image-light.png')); ?>" alt="auth-login-cover" class="platform-bg" data-app-light-img="illustrations/bg-shape-image-light.png" data-app-dark-img="illustrations/bg-shape-image-dark.png" />
                </div>
            </div>
            <!-- /Left Text -->

            <!-- Login -->
            <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
                <div class="w-px-400 mx-auto sign-in-from">

                    <!-- Logo -->
                    <div class="app-brand mb-4">
                        <a href="<?php echo e(route('home')); ?>" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">
                                
                                

                        </span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <h3 class="mb-1 fw-bold">Welcome to <?php echo e(@$company->companyname); ?>! 👋</h3>
                    <p class="mb-4">Please sign-in to your account and start the adventure</p>


                    <form action="<?php echo e(route('authCheck')); ?>" method="POST" class="login-form">
                        <p style="color:red"><b class="errorText"></b></p>
                        <p style="color:teal"><b class="successText"></b></p>
                        <?php echo e(csrf_field()); ?>

                        <div class="form-group mb-3">
                            <label for="exampleInputEmail1">Username</label>

                            <input type="tel" class="form-control my-1" name="mobile" placeholder="User name" pattern="[0-9]*" maxlength="10" minlength="10" required>

                        </div>

                        <div class="form-group my-3">
                            <div class="d-flex justify-content-between">
                                <label for="exampleInputPassword1">Password</label>
                                <a href="javascript:void(0)" onclick="forgetPassword()">
                                    <small>Forgot Password?</small>
                                </a>
                            </div>
                            <input type="password" name="password" class="form-control my-1" placeholder="Password" aria-label="Recipient's username" aria-describedby="basic-addon2">
                        </div>
                        <div class="formdata">

                        </div>

                        <button class="btn btn-primary d-grid w-100 mb-3">Sign in</button>

                        <p class="text-center">
                            <span>New on our platform?</span>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal">
                                <span>Create an account</span>
                            </a>
                        </p>
                    </form>

                    <div class=" divider my-4">
                        <div class="divider-text">or</div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <a href="javascript:;" class="btn btn-icon btn-label-facebook me-3">
                            <i class="tf-icons fa-brands fa-facebook-f fs-5"></i>
                        </a>

                        <a href="javascript:;" class="btn btn-icon btn-label-google-plus me-3">
                            <i class="tf-icons fa-brands fa-google fs-5"></i>
                        </a>

                        <a href="javascript:;" class="btn btn-icon btn-label-twitter">
                            <i class="tf-icons fa-brands fa-twitter fs-5"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Login -->
        </div>
    </div>


    <div class="modal fade" id="passwordResetModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Forgot Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <form id="passwordRequestForm" action="<?php echo e(route('authReset')); ?>" method="post">
                        <b>
                            <p class="text-danger"></p>
                        </b>
                        <input type="hidden" name="type" value="request">
                        <?php echo e(csrf_field()); ?>

                        <div class="form-group my-1">
                            <label>Mobile</label>
                            <input type="text" name="mobile" class="form-control my-1" placeholder="Enter Mobile Number" required="">
                        </div>
                        <div class="form-group my-1">
                            <button class="btn btn-primary btn-block text-uppercase waves-effect waves-light" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Resetting">Reset
                                Request</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="passwordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Forgot Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <form id="passwordForm" action="<?php echo e(route('authReset')); ?>" method="post">
                        <b>
                            <p class="text-danger"></p>
                        </b>
                        <input type="hidden" name="mobile">
                        <input type="hidden" name="type" value="reset">
                        <?php echo e(csrf_field()); ?>

                        <div class="form-group my-1">
                            <label>Reset Token</label>
                            <input type="text" name="token" class="form-control my-1" placeholder="Enter OTP" required="">
                        </div>
                        <div class="form-group my-1">
                            <label>New Password</label>
                            <input type="password" name="password" class="form-control my-1" placeholder="Enter New Password" required="">
                        </div>
                        <div class="form-group mt-3">
                            <button class="btn btn-primary btn-block text-uppercase waves-effect waves-light" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Resetting">Reset
                                Password</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="registerModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Member Registration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="registerForm" action="<?php echo e(route('register')); ?>" method="post">
                        <?php echo e(csrf_field()); ?>

                        <div class="row">
                            <div class="form-group mb-1 col-md-4">
                                <label>Member Type</label>
                                <select name="slug" class="form-control my-1 select" required>
                                    <option value="">Select Member Type</option>
                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($role->slug); ?>"><?php echo e($role->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <h5 class="mb-2">Personal Details</h5>
                        <div class="row">
                            <div class="form-group my-1 col-md-4">
                                <label for="exampleInputEmail1">Name</label>
                                <input type="text" name="name" class="form-control my-1" placeholder="Enter your name" required>
                            </div>
                            <div class="form-group my-1 col-md-4">
                                <label for="exampleInputPassword1">Email</label>
                                <input type="text" name="email" class="form-control my-1" placeholder="Enter your email id" required>
                                <div class="alert-message" id="emailError"></div>
                            </div>
                            <div class="form-group my-1 col-md-4">
                                <label for="exampleInputPassword1">Mobile</label>

                                <input type="tel" maxlength="10" name="mobile" class="form-control my-1" placeholder="Enter your mobile" required>

                                <div class="alert-message" id="mobileError"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group my-1 col-md-4">
                                <label>State</label>
                                <select name="state" class="form-control my-1 state" required>
                                    <option value="">Select State</option>
                                    <?php $__currentLoopData = $state; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($state->state); ?>"><?php echo e($state->state); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="form-group my-1 col-md-4">
                                <label>City</label>
                                <input type="text" name="city" class="form-control my-1" value="" required="" placeholder="Enter Value">
                            </div>
                            <div class="form-group my-1 col-md-4">
                                <label>Pincode</label>

                                <input type="tel" name="pincode" class="form-control my-1" value="" required="" maxlength="6" minlength="6" placeholder="Enter Value" pattern="[0-9]*">

                            </div>
                            <div class="form-group my-1 col-md-4">
                                <label>Shop Name</label>
                                <input type="text" name="shopname" class="form-control my-1" value="" required="" placeholder="Enter Value">
                                <div class="alert-message" id="shopnameError"></div>
                            </div>
                            <div class="form-group my-1 col-md-4">
                                <label>Pancard</label>
                                <input type="text" name="pancard" class="form-control my-1" value="" id="pancard" required="" placeholder="Enter Value">
                                <div class="alert-message" id="pancardError"></div>
                            </div>
                            <div class="form-group my-1 col-md-4">
                                <label>Aadhar</label>
                                <input type="text" name="aadharcard" required="" class="form-control my-1" id="aadharcard" placeholder="Enter Value" pattern="[0-9]*" maxlength="12" minlength="12">
                                <div class="alert-message" id="aadharcardError"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group my-1 col-md-12">
                                <label>Address</label>
                                <textarea name="address" class="form-control my-1" rows="3" required="" placeholder="Enter Value"></textarea>
                            </div>
                        </div>
                        
                        <div class="text-center form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="<?php echo e(asset('theme_1/assets/vendor/libs/jquery/jquery.js')); ?>"></script>
    <script src="<?php echo e(asset('theme_1/assets/vendor/libs/popper/popper.js')); ?>"></script>
    <script src="<?php echo e(asset('theme_1/assets/vendor/js/bootstrap.js')); ?>"></script>
    <script src="<?php echo e(asset('theme_1/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')); ?>"></script>
    <script src="<?php echo e(asset('theme_1/assets/vendor/libs/node-waves/node-waves.js')); ?>"></script>

    <script src="<?php echo e(asset('theme_1/assets/vendor/libs/hammer/hammer.js')); ?>"></script>
    <script src="<?php echo e(asset('theme_1/assets/vendor/libs/i18n/i18n.js')); ?>"></script>
    <script src="<?php echo e(asset('theme_1/assets/vendor/libs/typeahead-js/typeahead.js')); ?>"></script>

    <script src="<?php echo e(asset('theme_1/assets/vendor/js/menu.js')); ?>"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="<?php echo e(asset('theme_1/assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')); ?>"></script>
    <script src="<?php echo e(asset('theme_1/assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')); ?>"></script>
    <script src="<?php echo e(asset('theme_1/assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('')); ?>assets/js/core/jquery.validate.min.js"></script>
    <!-- Page JS -->
    <script src="<?php echo e(asset('theme_1/assets/js/pages-auth.js')); ?>"></script>
    <script src="<?php echo e(asset('')); ?>theme/js/jquery.min.js"></script>
    <script src="<?php echo e(asset('')); ?>theme/js/jquery.appear.js"></script>
    <script src="<?php echo e(asset('')); ?>theme/js/countdown.min.js"></script>
    <script src="<?php echo e(asset('')); ?>theme/js/waypoints.min.js"></script>
    <script src="<?php echo e(asset('')); ?>theme/js/jquery.counterup.min.js"></script>
    <script src="<?php echo e(asset('')); ?>theme/js/wow.min.js"></script>
    <script src="<?php echo e(asset('')); ?>theme/js/apexcharts.js"></script>
    <script src="<?php echo e(asset('')); ?>theme/js/lottie.js"></script>
    <script src="<?php echo e(asset('')); ?>theme/js/slick.min.js"></script>
    <script src="<?php echo e(asset('')); ?>theme/js/select2.min.js"></script>
    <script src="<?php echo e(asset('')); ?>theme/js/owl.carousel.min.js"></script>
    <script src="<?php echo e(asset('')); ?>theme/js/jquery.magnific-popup.min.js"></script>
    <script src="<?php echo e(asset('')); ?>theme/js/smooth-scrollbar.js"></script>
    <script src="<?php echo e(asset('')); ?>theme/js/style-customizer.js"></script>
    <script src="<?php echo e(asset('')); ?>theme/js/chart-custom.js"></script>
    <script src="<?php echo e(asset('')); ?>theme/js/custom.js"></script>
    <script src="<?php echo e(asset('')); ?>assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="<?php echo e(asset('')); ?>assets/js/core/jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?php echo e(asset('')); ?>assets/js/core/jquery.form.min.js"></script>
    <script type="text/javascript" src="<?php echo e(asset('')); ?>assets/js/core/sweetalert2.min.js"></script>
    <script type="text/javascript" src="<?php echo e(asset('')); ?>assets/js/plugins/forms/selects/select2.min.js"></script>
    <script src="<?php echo e(asset('')); ?>assets/js/core/snackbar.js"></script>
    <script>
        $(document).ready(function() {
            $('#passwordView').click(function() {
                var passwordType = $(this).closest('form').find('[name="password"]').attr('type');
                if (passwordType == "password") {
                    $(this).closest('form').find('[name="password"]').attr('type', "text");
                    $(this).find('i').removeClass('a fa-eye').addClass('fa fa-eye-slash');
                } else {
                    $(this).closest('form').find('[name="password"]').attr('type', "password");
                    $(this).find('i').addClass('a fa-eye').removeClass('fa fa-eye-slash');
                }
            });
            var number = 1 + Math.floor(Math.random() * 100000);
            $('#capcha').text(number);
            $(".login-form").validate({
                rules: {
                    mobile: {
                        required: true,
                        minlength: 10,
                        number: true,
                        maxlength: 11
                    },
                    password: {
                        required: true,
                      
                    },
                    capchaConfirm: {
                        required: true,
                    },
                    capcha: {
                        required: true,
                        minlength: 6,
                        equalTo: "#capchaConfirm"
                    },
                },
                messages: {
                    mobile: {
                        required: "Please enter mobile number",
                        number: "Mobile number should be numeric",
                        minlength: "Your mobile number must be 10 digit",
                        maxlength: "Your mobile number must be 10 digit"
                    },
                    capcha: {
                        required: "Please enter captcha",
                        number: "Captcha should be numeric",
                        equalTo: "Invalid Captcha",
                        minlength: "Your captcha  must be 6 digit",

                    },
                    password: {
                        required: "Please enter password",
                    },
                    capchaConfirm: {
                        required: "Please enter password",
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                        $
                    }
                },
                submitHandler: function() {
                    var form = $('.login-form');
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            swal({
                                title: 'Wait!',
                                text: 'We are checking your login credential',
                                onOpen: () => {
                                    swal.showLoading()
                                },
                                allowOutsideClick: () => !swal.isLoading()
                            });
                        },
                        success: function(data) {
                            swal.close();
                            if (data.status == "Login") {
                                swal({
                                    type: 'success',
                                    title: 'Success',
                                    text: 'Successfully logged in.',
                                    showConfirmButton: false,
                                    timer: 2000,
                                    onClose: () => {
                                        window.location.reload();
                                    },
                                });
                            } else if (data.status == "otpsent" || data.status ==
                                "preotp") {
                                $('div.formdata').append(`
                                <div class="form-group my-3">
                                    <div class="d-flex justify-content-between">
                                        <label for="exampleInputPassword1">OTP</label>
                                        <a href="javascript:void(0)" onclick="OTPRESEND()">
                                            <small>Resend OTP</small>
                                        </a>
                                    </div>
                                    <input type="password" class="form-control my-1" placeholder="Enter Otp" name="otp" required
                                        aria-label="Recipient's username" aria-describedby="basic-addon2">
                                </div>`);

                                if (data.status == "preotp") {
                                    $('b.successText').text(
                                        'Please use previous otp sent on your mobile.');
                                    setTimeout(function() {
                                        $('b.successText').text('');
                                    }, 5000);
                                }
                            }
                        },
                        error: function(errors) {
                            swal.close();
                            if (errors.status == '400') {
                                $('b.errorText').text(errors.responseJSON.status);
                                setTimeout(function() {
                                    $('b.errorText').text('');
                                }, 5000);
                            } else {
                                $('b.errorText').text(
                                    'Something went wrong, try again later.');
                                setTimeout(function() {
                                    $('b.errorText').text('');
                                }, 5000);
                            }
                        }
                    });
                }
            });

            $("#registerForm").validate({
                rules: {
                    slug: {
                        required: true
                    },
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
                    },
                    pancard: {
                        required: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    shopname: {
                        required: true,
                    }

                },
                messages: {
                    slug: {
                        required: "Please select member type",
                    },
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
                        minlength: "Your pincode number must be 6 digit",
                        maxlength: "Your pincode number must be 6 digit"
                    },
                    address: {
                        required: "Please enter address",
                    },
                    aadharcard: {
                        required: "Please enter aadharcard",
                        number: "Aadhar should be numeric",
                        minlength: "Your aadhar number must be 12 digit",
                        maxlength: "Your aadhar number must be 12 digit"
                    },
                    pancard: {
                        required: "Please enter pancard",
                        minlength: "Your pancard number must be 10 digit",
                        maxlength: "Your pancard number must be 10 digit"
                    },
                    shopname: {
                        required: "Please enter shopname"

                    },
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
                    var form = $('#registerForm');
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr("disabled",
                                true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Submit').attr("disabled",
                                false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "TXN") {
                                $('#registerModal').modal('hide');
                                notify('Your request has been submitted successfully, please wait for confirmation',
                                    'success');
                            } else {
                                notify(data.message, 'error');
                            }
                        },
                        error: function(errors) {
                            form.find('button:submit').html('Submit').attr("disabled",
                                false).removeClass('btn-secondary');
                            if (errors.status == '422') {
                                // notify(errors.responseJSON.errors[0], 'warning');
                                $('#emailError').text(errors.responseJSON.errors.email);
                                $('#mobileError').text(errors.responseJSON.errors.mobile);
                                $('#shopnameError').text(errors.responseJSON.errors
                                    .shopname);
                                $('#pancardError').text(errors.responseJSON.errors.pancard);
                                $('#aadharcardError').text(errors.responseJSON.errors
                                    .aadharcard);

                            } else {
                                swal("Oh No!", "Something went wrong, try again later!",
                                    "error");
                                //  notify('Something went wrong, try again later.', 'warning');
                            }
                        }
                    });
                }
            });

            $("#passwordForm").validate({
                rules: {
                    token: {
                        required: true,
                        number: true
                    },
                    password: {
                        required: true,
                    }
                },
                messages: {
                    mobile: {
                        required: "Please enter reset token",
                        number: "Reset token should be numeric",
                    },
                    password: {
                        required: "Please enter password",
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
                    var form = $('#passwordForm');
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                        form.find('button[type="submit"]').html('Please wait...').attr('disabled',true).addClass('btn-secondary');
                        },
                        complete:function(){
                            form.find('button[type="submit"]').html('Reset Password').attr('disabled',false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "TXN") {
                                $('#passwordModal').modal('hide');
                                swal({
                                    type: 'success',
                                    title: 'Reset!',
                                    text: 'Password Successfully Changed',
                                    showConfirmButton: true
                                });
                            } else {
                                notify(data.message, 'error');
                            }
                        },
                        error: function(errors) {
                            if (errors.status == '400') {
                                notify(errors.responseJSON.message, 'error');
                            } else if (errors.status == '422' || errors.responseJSON.statuscode == 'ERR') {
                                notify(errors.responseJSON[0] || errors.responseJSON.message, 'error');
                                // $.each(errors.responseJSON.errors, function(index, value) {
                                //     form.find('[name="' + index + '"]').closest(
                                //         'div.form-group').append(
                                //         '<p class="error">' + value + '</span>');
                                // });
                                // form.find('p.error').first().closest('.form-group').find(
                                //     'input').focus();
                                // setTimeout(function() {
                                //     form.find('p.error').remove();
                                // }, 5000);
                            } else {
                                notify('Something went wrong, try again later.', 'error');
                            }
                        }
                    });
                }
            });



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
                                $('#registerForm').find('[name="address"]').val(data
                                    .address);
                                $("#address").prop('readonly', true);
                                $('#registerForm').find('[name="name"]').val(data
                                    .full_name);
                                $("#name").prop('readonly', true);
                                $('#registerForm').find('[name="city"]').val(data.city);
                                $("#city").prop('readonly', true);
                                $('#registerForm').find('[name="pincode"]').val(data.pin);
                                $("#pincode").prop('readonly', true);
                                $('#registerForm').find('[name="state"]').select2().val(data
                                    .state).trigger('change');
                                $("state").prop('readonly', true);
                                // $('#registerForm').find('[name="state"]').val();
                                swal("Verified", "Your Adhar Card is Verified " + data
                                    .full_name, "success");

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
                                notify(errors.responseJSON.status, 'error');
                            } else {
                                notify('Something went wrong, try again later.', 'error');
                            }
                        }
                    });
                }
            });



        });

        // function notify(msg, type = "success") {
        //     let snackbar = new SnackBar;
        //     snackbar.make("message", [
        //         msg,
        //         null,
        //         "bottom",
        //         "right",
        //         "text-" + type
        //     ], 5000);
        // }


        function notify(text, status) {
            new Notify({
                status: status,
                title: null,
                text: text,
                effect: 'fade',
                customClass: null,
                customIcon: null,
                showIcon: true,
                showCloseButton: true,
                autoclose: true,
                autotimeout: 2000,
                gap: 20,
                distance: 15,
                type: 1,
                position: 'right top'
            })
        }




        function forgetPassword() {
            var mobile = $('.login-form').find('[name="mobile"]').val();
            var form = $('.login-form');
            if (mobile != '') {

                $.ajax({
                    url: `<?php echo e(route('authReset')); ?>`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    data: {
                        'type': 'request',
                        "mobile": mobile
                    },
                    beforeSubmit: function() {
                        form.find('button[type="submit"]').html('Please wait...').attr('disabled',true).addClass('btn-secondary');
                    },
                    complete:function(){
                        form.find('button[type="submit"]').html('Reset Password').attr('disabled',false).removeClass('btn-secondary');
                    },
                    success: function(data) {
                        swal.close();
                        if (data.status == "TXN") {
                            notify(data.message,'success');
                            $('#passwordResetModal').modal('hide');
                            $('#passwordForm').find('input[name="mobile"]').val(mobile);
                            $('#passwordModal').modal('show');
                        } else {
                            $('b.errorText').text(data.message);
                            setTimeout(function() {
                                $('b.errorText').text('');
                            }, 5000);
                        }
                    },
                    error: function(errors) {
                        form.find('button[type="submit"]').html('Reset Password').attr('disabled',false).removeClass('btn-secondary');
                     
                        if (errors.status == '400') {
                            $('b.errorText').text(errors.responseJSON.message);
                            setTimeout(function() {
                                $('b.errorText').text('');
                            }, 5000);
                        } else {
                            $('b.errorText').text("Something went wrong, try again later.");
                            setTimeout(function() {
                                $('b.errorText').text('');
                            }, 5000);
                        }
                    }
                })

            } else {
                $('b.errorText').text('Enter your registered mobile number');
                setTimeout(function() {
                    $('b.errorText').text('');
                }, 5000);
            }
        }

        function OTPRESEND() {
            var mobile = $('input[name="mobile"]').val();
            var password = $('input[name="password"]').val();
            if (mobile.length > 0) {
                $.ajax({
                        url: '<?php echo e(route("authCheck")); ?>',
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            'mobile': mobile,
                            'password': password,
                            'otp': "resend"
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
                        if (data.status == "otpsent") {
                            $('b.successText').text('Otp sent successfully');
                            setTimeout(function() {
                                $('b.successText').text('');
                            }, 5000);
                        } else {
                            $('b.errorText').text(data.message);
                            setTimeout(function() {
                                $('b.errorText').text('');
                            }, 5000);
                        }
                    })
                    .fail(function() {
                        $('b.errorText').text('Something went wrong, try again');
                        setTimeout(function() {
                            $('b.errorText').text('');
                        }, 5000);
                    });
            } else {
                $('b.errorText').text('Enter your registered mobile number');
                setTimeout(function() {
                    $('b.errorText').text('');
                }, 5000);
            }
        }
    </script>

</body>

</html><?php /**PATH C:\wamp64\www\flight_b2b_travel\flight_b2b_travel\resources\views/login.blade.php ENDPATH**/ ?>