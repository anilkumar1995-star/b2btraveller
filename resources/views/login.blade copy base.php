<!DOCTYPE html>

<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('theme_1/assets/') }}" data-template="vertical-menu-template">

<head>

    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Login - {{ @$company->companyname }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="https://ipayments.in/assets/images/ilogo.png"
        class=" img-fluid rounded" />


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('theme_1/assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme_1/assets/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme_1/assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('theme_1/assets/vendor/css/rtl/core.css') }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('theme_1/assets/vendor/css/rtl/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('theme_1/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('theme_1/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme_1/assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme_1/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <!-- Vendor -->
    <link rel="stylesheet"
        href="{{ asset('theme_1/assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.css" />

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.js"></script>

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('theme_1/assets/vendor/css/pages/page-auth.css') }}" />

    <style>
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-text-fill-color: #d0d2d6 !important;
            /* light text */
            -webkit-box-shadow: 0 0 0px 1000px #2f3349 inset !important;
            /* dark bg */
            caret-color: #fff !important;
            border-radius: inherit;
        }

        body {
            margin: 0;
            height: 100vh;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg,
                    #0f172a 0%,
                    #1e293b 50%,
                    #334155 100%);

            /* background: url({{ asset('images/bg.png') }}) no-repeat center center fixed;
            background-size: 100% 100%; */
            display: flex;
            align-items: center;
            justify-content: flex-end;
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgb(0 0 0 / 0%)
        }

        .login-panel {
            position: relative;
            width: 100%;
            max-width: 480px;
            padding: 45px;
            /* margin-right: 70px; */
            margin: 0px auto;
            border-radius: 25px;
            background: rgb(10 25 40 / 90%);
            backdrop-filter: blur(20px);
            box-shadow: 0 0 25px rgba(110, 121, 121, 0.4);
            color: #fff;
            z-index: 2;
            /* transform: scale(0.80); */
            transform-origin: right center;
        }

        .login-panel h5 {
            font-weight: 600;
            opacity: 0.9;
        }

        .login-panel h3 {
            font-weight: 700;
            margin-bottom: 25px;
        }

        .form-control {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #fff;
            height: 50px;
            border-radius: 12px;
        }

        .form-control::placeholder {
            color: #ddd;
        }

        .form-control:focus {
            background: transparent;
            color: #fff;
            box-shadow: none;
            border-color: #00e5ff;
        }

        .input-group-text {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #fff;
            border-radius: 12px 0 0 12px;
        }

        .login-btn {
            height: 50px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(90deg, #ff9800, #ff3d00);
            font-size: 18px;
            font-weight: 600;
            color: #fff;
            box-shadow: 0 0 15px rgba(255, 140, 0, 0.7);
        }

        .login-btn:hover {
            opacity: 0.9;
        }

        .divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
        }

        .divider::before,
        .divider::after {
            content: "";
            position: absolute;
            top: 50%;
            width: 40%;
            height: 1px;
            background: #777;
        }

        .divider::before {
            left: 0;
        }

        .divider::after {
            right: 0;
        }

        .social-btn {
            height: 45px;
            border-radius: 10px;
            font-weight: 500;
        }

        .social-btn:hover {
            border: 1px solid #00e5ff;
            color: #00e5ff;
            box-shadow: 0 0 10px rgba(0, 229, 255, 0.7);

        }

        .google {
            background: #fff;
        }

        .otp {
            background: #1de9b6;
            color: #000;
        }

        .secure-badge {
            margin-top: 25px;
            padding: 10px;
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            text-align: center;
            font-size: 14px;
            opacity: 0.9;
        }

        @media(max-width:768px) {
            body {
                justify-content: center;
            }

            .login-panel {
                margin: 20px;
            }
        }

        .modal select {
            background-color: #2c3e50 !important;
            color: #fff !important;
        }

        .modal select option {
            background-color: #2c3e50;
            color: #fff;
        }
    </style>
    <style>
        /* .form-group p {
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
        } */

        .carousel-caption {
            background: rgba(0, 0, 0, 0.45);
            padding: 15px 20px;
            border-radius: 10px;
        }

        /* Modal Background Blur */
        .modal-content {
            background: rgba(10, 25, 40, 0.85);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 30px rgba(0, 255, 255, 0.2);
            color: #fff;
        }

        .modal-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .modal-title {
            font-weight: 600;
        }

        .btn-close {
            filter: invert(1);
        }

        /* Section Headings */
        .modal-body h5 {
            color: #00e5ff;
            font-weight: 600;
            margin-top: 15px;
        }

        /* Inputs */
        .modal .form-control,
        .modal select,
        .modal textarea {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            border-radius: 10px;
        }

        .modal .form-control::placeholder,
        .modal textarea::placeholder {
            color: #ccc;
        }

        .modal .form-control:focus,
        .modal select:focus,
        .modal textarea:focus {
            background: rgba(255, 255, 255, 0.12);
            border-color: #00e5ff;
            box-shadow: none;
            color: #fff;
        }

        /* Labels */
        .modal label {
            font-size: 14px;
            font-weight: 500;
        }

        /* Submit Button */
        .modal .btn-primary {
            background: linear-gradient(90deg, #ff9800, #ff3d00);
            border: none;
            padding: 10px 30px;
            border-radius: 10px;
            font-weight: 600;
            box-shadow: 0 0 15px rgba(255, 140, 0, 0.5);
        }

        .modal .btn-primary:hover {
            opacity: 0.9;
        }

        /* Error message styling */
        .alert-message {
            font-size: 12px;
            color: #ff5252;
        }
    </style>
</head>

<body>
    <!-- Content -->
    @if (env('MAINTENANCE_MODE', false))
        {{ Artisan::call('down') }}
    @endif

    <div class="authentication-wrapper authentication-cover authentication-bg vh-100">
        <div class="authentication-inner row m-0 vh-100">


            <div class="d-none d-lg-flex col-lg-7 p-5 h-100">
                <div class="w-100 h-100">

                    <div id="flightSlider" class="carousel slide carousel-fade h-100 w-100" data-bs-ride="carousel"
                        data-bs-interval="4000">


                        <img src="{{ asset('images/slider.png') }}" class="d-block w-100 h-100" alt="Flight"
                            width="100%" height="100%">



                    </div>

                </div>
            </div>


            <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4 h-100">

                <div class="login-panel">

                    <div class="text-center mb-3">
                        <h6>Welcome Back!</h6>
                        <h4>Merchant Login Panel</h4>
                    </div>

                    <form action="{{ route('authCheck') }}" method="POST" class="login-form">
                        @csrf
                        <b class="errorText text-danger d-block mb-2"></b>
                        <b class="successText text-success d-block mb-2"></b>

                        <div class="mb-3 input-group">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                            <input type="tel" class="form-control w-75" name="mobile" maxlength="10" minlength="10"
                                required placeholder="Enter User Mobile Number" autocomplete="off">
                        </div>

                        <div class="mb-3 input-group">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            <input type="password" name="password" class="form-control w-75" required
                                placeholder="Enter Password Here">
                            {{-- <span class="input-group-text"><i class="fa fa-eye"></i></span> --}}
                        </div>

                        <div class="d-flex justify-content-between mb-3 small">
                            <div>
                                <input type="checkbox"> Remember Me
                            </div>
                            <a href="javascript:void(0)" onclick="forgetPassword()"
                                class="text-warning text-decoration-none">Forgot
                                Password?</a>
                        </div>

                        <div class="formdata">

                        </div>

                        <button class="btn login-btn w-100" id="login-btn"><i class="fa fa-user"></i>
                            &nbsp;Login</button>

                        <div class="divider my-4">
                            <div class="divider-text">or</div>
                        </div>


                        <p class="text-center">
                            <span>New on our platform?</span>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal"
                                class="text-warning text-decoration-none">
                                <span>Create an account</span>
                            </a>
                        </p>
                    </form>

                    <div class="bottom-links text-center">
                        <a href="{{ route('privacy-policy') }}">Privacy Policy</a>
                        <span>|</span>
                        <a href="{{ route('refund-policy') }}">Refund Policy</a>

                        <div class="text-center">
                            <a href="{{ route('term-of-use') }}">Terms & Conditions</a>
                            <span>|</span>
                            <a href="{{ route('about') }}">About Us</a>
                            <span>|</span>
                            <a href="{{ route('contact') }}">Contact Us</a>
                        </div>

                    </div>

                    {{-- <div class="d-flex gap-2">
                <button type="button" class="btn social-btn google w-50">
                    <i class="fab fa-chrome"></i> &nbsp;Google
                </button>
                <button type="button" class="btn social-btn otp w-50">
                    <i class="fa fa-globe"></i> &nbsp;OTP Login
                </button>
            </div> --}}


                    <div class="secure-badge">
                        🔒 Secure & Encrypted
                    </div>

                    </form>

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
                            <input type="text" name="mobile" class="form-control my-1"
                                placeholder="Enter Mobile Number" required="">
                        </div>
                        <div class="form-group my-1">
                            <button class="btn btn-primary btn-block text-uppercase waves-effect waves-light"
                                type="submit"
                                data-loading-text="<i class='fa fa-spin fa-spinner'></i> Resetting">Reset
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
                            <input type="text" name="token" class="form-control my-1" placeholder="Enter OTP"
                                required="">
                        </div>
                        <div class="form-group my-1">
                            <label>New Password</label>
                            <input type="password" name="password" class="form-control my-1"
                                placeholder="Enter New Password" required="">
                        </div>
                        <div class="form-group mt-3">
                            <button class="btn btn-primary btn-block text-uppercase waves-effect waves-light"
                                type="submit"
                                data-loading-text="<i class='fa fa-spin fa-spinner'></i> Resetting">Reset
                                Password</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="registerModal" tabindex="-1" aria-hidden="true"
        data-bs-backdrop="static">
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
                                <input type="text" name="name" class="form-control my-1"
                                    placeholder="Enter your name" required>
                            </div>
                            <div class="form-group my-1 col-md-4">
                                <label for="exampleInputPassword1">Email</label>
                                <input type="text" name="email" class="form-control my-1"
                                    placeholder="Enter your email id" required>
                                <div class="alert-message" id="emailError"></div>
                            </div>
                            <div class="form-group my-1 col-md-4">
                                <label for="exampleInputPassword1">Mobile</label>

                                <input type="tel" maxlength="10" name="mobile" class="form-control my-1"
                                    placeholder="Enter your mobile" required>

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
                                <input type="text" name="city" class="form-control my-1" value=""
                                    required="" placeholder="Enter Value">
                            </div>
                            <div class="form-group my-1 col-md-4">
                                <label>Pincode</label>

                                <input type="tel" name="pincode" class="form-control my-1" value=""
                                    required="" maxlength="6" minlength="6" placeholder="Enter Value"
                                    pattern="[0-9]*">

                            </div>
                            <div class="form-group my-1 col-md-4">
                                <label>Shop Name</label>
                                <input type="text" name="shopname" class="form-control my-1" value=""
                                    required="" placeholder="Enter Value">
                                <div class="alert-message" id="shopnameError"></div>
                            </div>
                            <div class="form-group my-1 col-md-4">
                                <label>Pancard</label>
                                <input type="text" name="pancard" class="form-control my-1" value=""
                                    id="pancard" required="" placeholder="Enter Value">
                                <div class="alert-message" id="pancardError"></div>
                            </div>
                            <div class="form-group my-1 col-md-4">
                                <label>Aadhar</label>
                                <input type="text" name="aadharcard" required="" class="form-control my-1"
                                    id="aadharcard" placeholder="Enter Value" pattern="[0-9]*" maxlength="12"
                                    minlength="12">
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
                                $('#login-btn').attr("disabled", false).removeClass(
                                    'btn-secondary').text('Sign In');
                                swal({
                                    type: 'success',
                                    title: 'Success',
                                    text: 'Successfully logged in.',
                                    showConfirmButton: false,
                                    timer: 2000,
                                    onClose: () => {
                                        window
                                            .location
                                            .reload();
                                    },
                                });
                            } else if (data.status ==
                                "otpsent" || data.status ==
                                "preotp") {
                                $('#login-btn').attr("disabled", false).removeClass(
                                    'btn-secondary').text('Verify OTP');
                                $('div.formdata').append(`
                                                    <div class="form-group my-3">
                                                        <div class="d-flex justify-content-between">
                                                            <label for="otp">OTP</label>
                                                            <a href="javascript:void(0)" onclick="OTPRESEND()">
                                                                <small>Resend OTP</small>
                                                            </a>
                                                        </div>
                                                        <input type="password" class="form-control my-1" placeholder="Enter Otp" name="otp" required>
                                                    </div>
                                                `);
                                if (data.status ==
                                    "preotp") {
                                    $('b.successText').text(
                                        'Please use previous otp sent on your mobile.'
                                    );
                                    setTimeout(() => $(
                                            'b.successText'
                                        ).text(''),
                                        5000);
                                }
                            }
                        },
                        error: function(xhr) {
                            swal.close();

                            let msg = 'Something went wrong, try again later.';

                            if (xhr.responseJSON) {
                                if (xhr.responseJSON.status) {
                                    msg = xhr.responseJSON.status;
                                } else if (xhr.responseJSON.message) {
                                    msg = xhr.responseJSON.message;
                                }
                            }

                            $('b.errorText').text(msg);

                            setTimeout(function() {
                                $('b.errorText').text('');
                            }, 5000);
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
                            form.find('button:submit').html('Please wait...').attr(
                                "disabled",
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
                            if (errors.status == '400') {
                                notify(errors.responseJSON.errors[0], 'warning');
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
                            form.find('button[type="submit"]').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button[type="submit"]').html('Reset Password').attr(
                                'disabled', false).removeClass('btn-secondary');
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
                            } else if (errors.status == '422' || errors.responseJSON
                                .statuscode == 'ERR') {
                                notify(errors.responseJSON[0] || errors.responseJSON
                                    .message, 'error');
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
                        form.find('button[type="submit"]').html('Please wait...').attr('disabled', true)
                            .addClass('btn-secondary');
                    },
                    complete: function() {
                        form.find('button[type="submit"]').html('Reset Password').attr('disabled', false)
                            .removeClass('btn-secondary');
                    },
                    success: function(data) {
                        swal.close();
                        if (data.status == "TXN") {
                            notify(data.message, 'success');
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
                        form.find('button[type="submit"]').html('Reset Password').attr('disabled', false)
                            .removeClass('btn-secondary');

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
                        url: '{{ route('authCheck') }}',
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
