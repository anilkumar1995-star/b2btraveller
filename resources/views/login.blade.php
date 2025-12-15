<!DOCTYPE html>

<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('theme_1/assets/') }}" data-template="vertical-menu-template">

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Login - {{ @$company->companyname }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ Imagehelper::getImageUrl().json_decode(app\Models\Company::where('id', '1')->first(['logo']))->logo }}" class=" img-fluid rounded" />


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('theme_1/assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme_1/assets/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme_1/assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('theme_1/assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('theme_1/assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('theme_1/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('theme_1/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme_1/assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme_1/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <!-- Vendor -->
    <link rel="stylesheet" href="{{ asset('theme_1/assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.css" />

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.js"></script>

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('theme_1/assets/vendor/css/pages/page-auth.css') }}" />

    <style>
        .form-group p {
            color: red;
        }
          .carousel,
    .carousel-inner,
    .carousel-item {
        height: 100%;
    }

    .carousel-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .carousel-caption {
        background: rgba(0,0,0,0.45);
        padding: 15px 20px;
        border-radius: 10px;
    }
    </style>
</head>

<body>
    <!-- Content -->
    @if(env('MAINTENANCE_MODE',false))
    {{ Artisan::call('down') }}
    @endif

  <div class="authentication-wrapper authentication-cover authentication-bg vh-100">
    <div class="authentication-inner row m-0 vh-100">

      
        <div class="d-none d-lg-flex col-lg-7 p-5 h-100">
            <div class="w-100 h-100">

                <div id="flightSlider"
                     class="carousel slide carousel-fade h-100 w-100"
                     data-bs-ride="carousel"
                     data-bs-interval="4000">

                    <div class="carousel-inner h-100 rounded">

                        <div class="carousel-item active h-100">
                            <img src="{{ asset('images/air-india.jpg') }}"
                                 class="d-block w-100 h-100"
                                 alt="Flight">
                            {{-- <div class="carousel-caption d-none d-md-block">
                                <h3>Book Flights Worldwide</h3>
                                <p>Fast, Secure & Affordable Air Travel</p>
                            </div> --}}
                        </div>

                        <div class="carousel-item h-100">
                            <img src="{{ asset('images/02.jpg') }}"
                                 class="d-block w-100 h-100"
                                 alt="Flight">
                            {{-- <div class="carousel-caption d-none d-md-block">
                                <h3>Explore the World</h3>
                                <p>Best deals on domestic & international flights</p>
                            </div> --}}
                        </div>

                        <div class="carousel-item h-100">
                            <img src="{{ asset('images/bus01.jpeg') }}"
                                 class="d-block w-100 h-100"
                                 alt="Flight">
                            {{-- <div class="carousel-caption d-none d-md-block">
                                <h3>Travel Smarter</h3>
                                <p>Your journey starts here</p>
                            </div> --}}
                        </div>
                        
                        <div class="carousel-item h-100">
                            <img src="{{ asset('images/hotel.jpeg') }}"
                                 class="d-block w-100 h-100"
                                 alt="Flight">
                            <!-- <div class="carousel-caption d-none d-md-block">
                                <h3>Travel Smarter</h3>
                                <p>Your journey starts here</p>
                            </div> -->
                        </div>

                    </div>

                  
                    <button class="carousel-control-prev" type="button"
                            data-bs-target="#flightSlider" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>

                    <button class="carousel-control-next" type="button"
                            data-bs-target="#flightSlider" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>

                </div>

            </div>
        </div>
 

        <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4 h-100">
            <div class="w-px-400 mx-auto sign-in-from">

                <div class="app-brand mb-4">
                    <a href="{{ route('home') }}" class="app-brand-link gap-2"></a>
                </div>

                <h3 class="mb-1 fw-bold">
                    Welcome to {{ @$company->companyname }}! 👋
                </h3>
                <p class="mb-4">
                Sign in to your account and begin your journey               
                </p>
                <form action="{{ route('authCheck') }}" method="POST" class="login-form">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Mobile No.</label>
                        <input type="tel"
                               class="form-control"
                               name="mobile"
                               maxlength="10"
                               minlength="10"
                               required>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <label class="form-label">Password</label>
                            <a href="javascript:void(0)" onclick="forgetPassword()">
                                <small>Forgot Password?</small>
                            </a>
                        </div>
                        <input type="password"
                               name="password"
                               class="form-control"
                               required>
                    </div>

                    <button class="btn btn-primary w-100 mb-3">
                        Sign in
                    </button>

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

                <div class="bottom-links">
                    <a href="{{ route('privacy-policy') }}">Privacy Policy</a>
                    <span>|</span>
                    <a href="{{ route('refund-policy') }}">Refund Policy</a>
                    <span>|</span>
                    <a href="{{ route('term-of-use') }}">Terms & Conditions</a>
                      <span>|</span>
                   <div class="text-center"><a href="{{ route('about') }}">About Us</a>
                    <span>|</span>
                    <a href="{{ route('contact') }}">Contact Us</a></div>  

                </div>
            
            </div>
        </div>


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
                    <form id="passwordRequestForm" action="{{ route('authReset') }}" method="post">
                        <b>
                            <p class="text-danger"></p>
                        </b>
                        <input type="hidden" name="type" value="request">
                        {{ csrf_field() }}
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
                    <form id="passwordForm" action="{{ route('authReset') }}" method="post">
                        <b>
                            <p class="text-danger"></p>
                        </b>
                        <input type="hidden" name="mobile">
                        <input type="hidden" name="type" value="reset">
                        {{ csrf_field() }}
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
                    <form id="registerForm" action="{{ route('register') }}" method="post">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="form-group mb-1 col-md-4">
                                <label>Member Type</label>
                                <select name="slug" class="form-control my-1 select" required>
                                    <option value="">Select Member Type</option>
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->slug }}">{{ $role->name }}</option>
                                    @endforeach
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
                                    @foreach ($state as $state)
                                    <option value="{{ $state->state }}">{{ $state->state }}</option>
                                    @endforeach
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
                        {{-- <h5 class="my-2">Upload Your Documents</h5>
                        <div class="row">
                            <div class="form-group col-md-6 my-1">
                                <label>Passport size photo <span class="text-danger fw-bold">*</span></label>

                                <input type="file" class="form-control my-1" autocomplete="off" name="profiles" placeholder="Enter Demat account" required">
                            </div>
                            <div class="form-group col-md-6 my-1">
                                <label>Pancard Photo <span class="text-danger fw-bold">*</span></label>
                                <input type="file" class="form-control my-1" autocomplete="off"
                                    name="pancardpics" placeholder="Enter Business saving account" required>
                            </div>
                            <div class="form-group col-md-6 my-1">
                                <label>Aadharcard Front Photo <span class="text-danger fw-bold">*</span></label>
                                <input type="file" class="form-control my-1" autocomplete="off"
                                    name="aadharcardpics" placeholder="Enter Digital saving account" value=""
                                    required>
                            </div>
                            <div class="form-group col-md-6 my-1">
                                <label>Aadharcard Back Photo <span class="text-danger fw-bold">*</span></label>
                                <input type="file" class="form-control my-1" autocomplete="off"
                                    name="aadharcardpicsback" placeholder="Enter Digital saving account"
                                    value="" required>
                            </div>
                        </div> --}}
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
    <script src="{{ asset('theme_1/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('theme_1/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('theme_1/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('theme_1/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('theme_1/assets/vendor/libs/node-waves/node-waves.js') }}"></script>

    <script src="{{ asset('theme_1/assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('theme_1/assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('theme_1/assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>

    <script src="{{ asset('theme_1/assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('theme_1/assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
    <script src="{{ asset('theme_1/assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
    <script src="{{ asset('theme_1/assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('') }}assets/js/core/jquery.validate.min.js"></script>
    <!-- Page JS -->
    <script src="{{ asset('theme_1/assets/js/pages-auth.js') }}"></script>
    <script src="{{ asset('') }}theme/js/jquery.min.js"></script>
    <script src="{{ asset('') }}theme/js/jquery.appear.js"></script>
    <script src="{{ asset('') }}theme/js/countdown.min.js"></script>
    <script src="{{ asset('') }}theme/js/waypoints.min.js"></script>
    <script src="{{ asset('') }}theme/js/jquery.counterup.min.js"></script>
    <script src="{{ asset('') }}theme/js/wow.min.js"></script>
    <script src="{{ asset('') }}theme/js/apexcharts.js"></script>
    <script src="{{ asset('') }}theme/js/lottie.js"></script>
    <script src="{{ asset('') }}theme/js/slick.min.js"></script>
    <script src="{{ asset('') }}theme/js/select2.min.js"></script>
    <script src="{{ asset('') }}theme/js/owl.carousel.min.js"></script>
    <script src="{{ asset('') }}theme/js/jquery.magnific-popup.min.js"></script>
    <script src="{{ asset('') }}theme/js/smooth-scrollbar.js"></script>
    <script src="{{ asset('') }}theme/js/style-customizer.js"></script>
    <script src="{{ asset('') }}theme/js/chart-custom.js"></script>
    <script src="{{ asset('') }}theme/js/custom.js"></script>
    <script src="{{ asset('') }}assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="{{ asset('') }}assets/js/core/jquery.validate.min.js"></script>
    <script type="text/javascript" src="{{ asset('') }}assets/js/core/jquery.form.min.js"></script>
    <script type="text/javascript" src="{{ asset('') }}assets/js/core/sweetalert2.min.js"></script>
    <script type="text/javascript" src="{{ asset('') }}assets/js/plugins/forms/selects/select2.min.js"></script>
    <script src="{{ asset('') }}assets/js/core/snackbar.js"></script>
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
                    url: `{{ route('authReset') }}`,
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
                        url: '{{ route("authCheck")}}',
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

</html>