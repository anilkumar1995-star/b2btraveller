@extends('layouts.app')
@section('title', 'Dashboard')
@section('pagetitle', 'Dashboard')
@section('content')

    <div id="loading">
        <div id="loading-center">
        </div>
    </div>

    <!-- Enhanced Vuexy-style Travel Dashboard Body with Banner, Better Cards, Clean Layout -->

    <!-- Hero Banner -->
    <div class="banner mb-4 p-4 rounded-4 text-white rounded"
        style="background: linear-gradient(135deg, #6366f1, #3b82f6); box-shadow: 0 10px 25px rgba(0,0,0,0.15);">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1 text-white">Welcome Back, {{ Auth::user()->name }} 🏆</h2>
                <p class="mb-0 text-white">Effortlessly plan, track, and manage your travel bookings with complete control.</p>
            </div>
            <img src="https://cdn-icons-png.flaticon.com/512/201/201623.png" width="80" />
        </div>
    </div>

    <div class="content-wrapper">
        <!-- Content -->
        <div class="row">
            <!-- Card Border Shadow -->
            <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary"><i class="ti ti-plane"></i></span>
                            </div>
                            <h4 class="mb-0">0</h4>
                        </div>
                        <p class="mb-1">Today's Bookings</p>
                        <p class="mb-0">
                            <span class="text-heading fw-medium me-2">+0%</span>
                            <small class="text-body-secondary">than last week</small>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-warning h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-warning"><i class="ti ti-building"></i></span>
                            </div>
                            <h4 class="mb-0">0</h4>
                        </div>
                        <p class="mb-1">Hotel Reservations</p>
                        <p class="mb-0">
                            <span class="text-heading fw-medium me-2">+0%</span>
                            <small class="text-body-secondary">than last week</small>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-danger h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-danger"><i class="ti ti-bus"></i></span>
                            </div>
                            <h4 class="mb-0">0</h4>
                        </div>
                        <p class="mb-1">Bus Tickets</p>
                        <p class="mb-0">
                            <span class="text-heading fw-medium me-2">+0%</span>
                            <small class="text-body-secondary">than last week</small>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-info h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-info">₹</span>
                            </div>
                            <h4 class="mb-0">0</h4>
                        </div>
                        <p class="mb-1">Total Revenue</p>
                        <p class="mb-0">
                            <span class="text-heading fw-medium me-2">0%</span>
                            <small class="text-body-secondary">than last week</small>
                        </p>
                    </div>
                </div>
            </div>




            <!-- Charts & Lists Row -->



        </div>

        <div class="row mt-4">

            <!-- Left side section -->
            <div class="col-lg-7">

                <!-- Revenue Chart Box -->
                <div class="card shadow-sm border-0 rounded-4 p-3 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="fw-bold">Revenue Overview</h5>
                        <span class="text-muted small">Last 30 days</span>
                    </div>
                    <div
                        style="height:270px; background:#f8faff; border-radius:12px; display:flex; align-items:center; justify-content:center; color:#9ca3af;">
                        <img src="https://quickchart.io/chart?c={type:'bar',data:{labels:['Week 1','Week 2','Week 3','Week 4'],datasets:[{label:'Revenue',data:[40,55,32,70]}]}}"
                            style="max-width:100%; height:100%; object-fit:contain; opacity:0.9;" />
                    </div>
                </div>

            </div>

            <!-- Right Section -->
            <div class="col-lg-5">

                <!-- Recent Bookings -->
                <div class="card shadow-sm border-0 rounded-4 p-3 mb-4">
                    <h5 class="fw-bold mb-4">Recent Bookings</h5>
                    <div class="list-group">
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>Shivani P.</strong> | 🏨
                                    <small class="text-muted">GOA • Hotel • 22 Dec</small>
                                </div>
                                <span class="badge bg-success">Confirmed</span>
                            </div>


                        </div>
                        <hr />
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>Asha R.</strong> | 🏨
                                    <small class="text-muted">GOA • Hotel • 22 Dec</small>
                                </div>
                                <span class="badge bg-success">Confirmed</span>
                            </div>
                        </div>
                        <hr />
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>Vikram P.</strong> | ✈️
                                    <small class="text-muted">MUM • Flight • 14 Dec</small>
                                </div>
                                <span class="badge bg-warning">Pending</span>
                            </div>
                        </div>
                        <hr />
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>Neha S.</strong> | 🚌
                                    <small class="text-muted">DEL • Bus • 16 Dec</small>
                                </div>
                                <span class="badge bg-danger">Cancelled</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Log -->
                {{-- <div class="card shadow-sm border-0 rounded-4 p-3">
                        <h6 class="fw-bold mb-2">Live Activity</h6>
                        <div style="max-height:200px; overflow:auto;">
                            <div class="mb-2 small">🟢 Booking #5482 confirmed — <strong>Rahul K.</strong> <span
                                    class="text-muted">2m ago</span></div>
                            <div class="mb-2 small">🔔 Payment failed for <strong>#5479</strong> <span
                                    class="text-muted">10m
                                    ago</span></div>
                            <div class="mb-2 small">✈️ Flight DEL → MUM fully booked <span class="text-muted">1h
                                    ago</span></div>
                        </div>
                    </div> --}}

            </div>

        </div>
    </div>

    <style>
        .floating-booking {
            position: fixed;
            right: 0px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 999;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .booking-item {
            position: relative;
        }

        .booking-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, #003d75, #62bf00a8);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 22px;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .booking-slide {
            position: absolute;
            right: 70px;
            top: 50%;
            transform: translateY(-50%) translateX(20px);
            width: 230px;
            background: linear-gradient(145deg, #ffffff, #d6dbf0);
            border-radius: 18px;
            padding: 18px;
            box-shadow: 0 15px 35px rgba(99, 102, 241, 0.25);
            opacity: 0;
            pointer-events: none;
            transition: all 0.35s ease;
            border: 1px solid rgba(99, 102, 241, 0.15);
            backdrop-filter: blur(6px);
        }

        .booking-item:hover .booking-slide {
            opacity: 1;
            transform: translateY(-50%) translateX(0);
            pointer-events: auto;
        }

        .booking-slide h6 {
            font-weight: 700;
            margin-bottom: 6px;
        }

        .booking-slide p {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 10px;
        }

        .booking-slide a {
            width: 100%;
            background: linear-gradient(135deg, #6366f1, #22c55e);
            border: none;
            color: #fff;
            padding: 9px 0;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .booking-slide a:hover {
            transform: translateY(-1px);
            color: #ececec;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }
    </style>

    <div class="floating-booking">

        <!-- FLIGHT -->
        <div class="booking-item">
            <div class="booking-icon"><i class="ti ti-plane"></i></div>
            <div class="booking-slide">
                <h6>Flight Booking</h6>
                <p>Book domestic & international flights at best fares.</p>
                <a class="btn" href="{{ route('flight.view') }}">New Flight Booking</a>
            </div>
        </div>

        <!-- BUS -->
        <div class="booking-item">
            <div class="booking-icon"><i class="ti ti-bus"></i></div>
            <div class="booking-slide">
                <h6>Bus Booking</h6>
                <p>Easy bus booking with multiple operators & routes.</p>
                <a class="btn" href="{{ route('flight.view') }}">New Bus Booking</a>
            </div>
        </div>

        <!-- HOTEL -->
        <div class="booking-item">
            <div class="booking-icon"><i class="ti ti-building"></i></div>
            <div class="booking-slide">
                <h6>Hotel Booking</h6>
                <p>Find hotels with best deals and instant confirmation.</p>
                <a class="btn" href="{{ route('flight.view') }}">New Hotel Booking</a>
            </div>
        </div>

    </div>
@endsection

@push('script')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="{{ asset('') }}assets/js/plugins/forms/selects/select2.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>

    <script>
        $(document).ready(function() {

            // $("#generateUrlBtn").click(function() {

            //     $.ajax({
            //         url: "traveller-generate-url",
            //         method: "GET",

            //         success: function(res) {
            //             console.log(res);
            //             if (res.status) {

            //                 notify("URL generated successfully!", 'success');
            //                 window.open(res.url, '_blank');
            //             } else {
            //                 notify("Failed to generate URL.", 'warning');
            //             }
            //         },

            //         error: function(xhr) {
            //             notify("An error occurred while generating the URL.", 'error');
            //         }
            //     });

            // });

            @if (Myhelper::hasNotRole('admin') && Auth::user()->resetpwd == 'default')
                $('#pwdModal').modal('show');
            @endif

            $("#passwordForm").validate({
                rules: {
                    @if (!Myhelper::can('member_password_reset'))
                        oldpassword: {
                            required: true,
                            minlength: 6,
                        },
                        password_confirmation: {
                            required: true,
                            minlength: 8,
                            equalTo: "#password"
                        },
                    @endif
                    password: {
                        required: true,
                        minlength: 8
                    }
                },
                messages: {
                    @if (!Myhelper::can('member_password_reset'))
                        oldpassword: {
                            required: "Please enter old password",
                            minlength: "Your password lenght should be atleast 6 character",
                        },
                        password_confirmation: {
                            required: "Please enter confirmed password",
                            minlength: "Your password lenght should be atleast 8 character",
                            equalTo: "New password and confirmed password should be equal"
                        },
                    @endif
                    password: {
                        required: "Please enter new password",
                        minlength: "Your password lenght should be atleast 8 character"
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
                                "disabled", true).addClass('btn-secondary');
                        },
                        success: function(data) {
                            form.find('button:submit').html('Change Password').attr(
                                "disabled", false).removeClass('btn-secondary');
                            if (data.status == "success") {
                                form[0].reset();
                                form.closest('.modal').modal('hide');
                                notify("Password Successfully Changed", 'success');
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            form.find('button:submit').html('Change Password').attr(
                                "disabled", false).removeClass('btn-secondary');
                            showError(errors, form.find('.modal-body'));
                        }
                    });
                }
            });
        });
    </script>
@endpush
