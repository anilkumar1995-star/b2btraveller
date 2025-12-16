<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('pagetitle', 'Dashboard'); ?>
<?php $__env->startSection('content'); ?>

    <div id="loading">
        <div id="loading-center">
        </div>
    </div>

    <!-- Enhanced Vuexy-style Travel Dashboard Body with Banner, Better Cards, Clean Layout -->

    <div class="row">
        <div class="col-lg-12">
            <div class="row mb-2 justify-content-end">
                <div class="col-auto">
                    <div id="reportrange"
                        class="d-inline-flex align-items-center gap-1 border rounded px-2 py-1 bg-white cursor-pointer">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span></span> <i class="fa fa-caret-down"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Banner -->
    <div class="banner mb-4 p-4 rounded-4 text-white rounded"
        style="background: linear-gradient(135deg, #6366f1, #3b82f6); box-shadow: 0 10px 25px rgba(0,0,0,0.15);">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1 text-white">Welcome Back, <?php echo e(Auth::user()->name); ?> 🏆</h2>
                <p class="mb-0 text-white">Effortlessly plan, track, and manage your travel bookings with complete
                    control.
                </p>
            </div>
            <img src="https://cdn-icons-png.flaticon.com/512/201/201623.png" width="80" />
        </div>
    </div>

    <div class="content-wrapper">
        <!-- Content -->
        <div class="row g-2">
            <!-- Card Border Shadow -->
            <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">

                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-3">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="ti ti-plane"></i>
                                </span>
                            </div>

                            <h4 class="mb-0" id="total_booking_amount">
                                ₹0
                            </h4>
                        </div>

                        <p class="mb-1 fw-medium">
                            Confirmed booking value
                        </p>

                        <p class="mb-0">
                            <span class="text-heading fw-bold me-1" id="booking_count">
                                0
                            </span>
                            <small class="text-body-secondary">
                                Total Travel Bookings

                            </small>
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
                            <h4 class="mb-0" id="total_revenue_amount"></h4>
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

                    </div>

                    <div class="d-flex align-items-center justify-content-center"
                        style="height:270px; background:#f8faff; border-radius:12px;">

                        <img id="revenueChart" style="max-width:100%; height:100%; object-fit:contain; display:none;" />

                        <div id="noRevenueData" class="text-center text-muted">
                            <i class="bi bi-bar-chart" style="font-size:32px;"></i>
                            <p class="mt-2 mb-0 fw-semibold">No revenue data available</p>
                            <small>Selected date range has no bookings</small>
                        </div>

                    </div>
                </div>



            </div>

            <!-- Right Section -->
            <div class="col-lg-5">

                <div class="card shadow-sm border-0 rounded-4 p-3 mb-4">
                    <h5 class="fw-bold mb-4">All Recent Bookings</h5>

                    <div class="list-group">
                        <?php $__empty_1 = true; $__currentLoopData = $recentBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong><?php echo e($booking->user_name); ?></strong>
                                        |
                                        ✈️
                                        <small class="text-muted">
                                            <?php echo e($booking->origin); ?>

                                            →
                                            <?php echo e($booking->destination); ?>

                                            •
                                            <?php echo e(\Carbon\Carbon::parse($booking->journey_date)->format('d M')); ?>

                                        </small>
                                    </div>

                                    <?php if($booking->payment_status == 'success'): ?>
                                        <span class="badge bg-success">Confirmed</span>
                                    <?php elseif($booking->payment_status == 'pending'): ?>
                                        <span class="badge bg-warning">Pending</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Cancelled</span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <?php if(!$loop->last): ?>
                                <hr />
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-muted text-center mb-0">
                                No recent bookings found
                            </p>
                        <?php endif; ?>
                    </div>
                </div>


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
            right: 55px;
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
                <a class="btn" href="<?php echo e(route('flight.view')); ?>">New Flight Booking</a>
            </div>
        </div>

        <!-- BUS -->
        <div class="booking-item">
            <div class="booking-icon"><i class="ti ti-bus"></i></div>
            <div class="booking-slide">
                <h6>Bus Booking</h6>
                <p>Easy bus booking with multiple operators & routes.</p>
                <a class="btn" href="<?php echo e(route('flight.view')); ?>">New Bus Booking</a>
            </div>
        </div>

        <!-- HOTEL -->
        <div class="booking-item">
            <div class="booking-icon"><i class="ti ti-building"></i></div>
            <div class="booking-slide">
                <h6>Hotel Booking</h6>
                <p>Find hotels with best deals and instant confirmation.</p>
                <a class="btn" href="<?php echo e(route('flight.view')); ?>">New Hotel Booking</a>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="<?php echo e(asset('')); ?>assets/js/plugins/forms/selects/select2.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>

    <script>
        $(document).ready(function() {
            <?php if(Myhelper::hasNotRole('admin') && Auth::user()->resetpwd == 'default'): ?>
                $('#pwdModal').modal('show');
            <?php endif; ?>

            $("#passwordForm").validate({
                rules: {
                    <?php if(!Myhelper::can('member_password_reset')): ?>
                        oldpassword: {
                            required: true,
                            minlength: 6,
                        },
                        password_confirmation: {
                            required: true,
                            minlength: 8,
                            equalTo: "#password"
                        },
                    <?php endif; ?>
                    password: {
                        required: true,
                        minlength: 8
                    }
                },
                messages: {
                    <?php if(!Myhelper::can('member_password_reset')): ?>
                        oldpassword: {
                            required: "Please enter old password",
                            minlength: "Your password lenght should be atleast 6 character",
                        },
                        password_confirmation: {
                            required: "Please enter confirmed password",
                            minlength: "Your password lenght should be atleast 8 character",
                            equalTo: "New password and confirmed password should be equal"
                        },
                    <?php endif; ?>
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

            const getDashboardData = (start, end) => {

                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

                $.ajax({
                    url: "<?php echo e(route('home')); ?>",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        fromDate: start?.format('YYYY-MM-DD') || '',
                        toDate: end.format('YYYY-MM-DD') || '',
                    },
                    beforeSend: function() {
                        swal({
                            title: 'Wait!',
                            text: 'We are processing your request.',
                            allowOutsideClick: () => !swal.isLoading(),
                            onOpen: () => {
                                swal.showLoading()
                            }
                        });
                    },
                    complete: function() {
                        swal.close();
                    },
                    success: function(resp) {
                        swal.close();
                        $('#total_revenue_amount').html(parseFloat(resp.totalRevenueAmount)
                            .toLocaleString('en-IN', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }));
                        $('#total_booking_amount').html('₹' + parseFloat(resp.bookingSuccessAmount)
                            .toLocaleString('en-IN', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }));
                        $('#booking_count').html(resp.bookingCount);
                        // $('#revenueDateRange').html(resp.fromDate + '<b> to </b>' + resp.toDate);
                        updateRevenueChart(resp.revenueLabels, resp.revenueValues);

                    },
                    error: function(xhr, status, error) {
                        swal.close();
                        notify('Something went wrong', 'danger');
                    }
                });

            }

            $(function() {

                var start = moment();
                var end = moment();

                $('#reportrange').daterangepicker({
                    startDate: start,
                    endDate: end,
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment()
                            .subtract(1, 'month').endOf('month')
                        ]
                    }
                }, getDashboardData);

                getDashboardData(start, end);

            });
        });

        function updateRevenueChart(labels, values) {

             $('#noRevenueData').show();
             return
            if (!values || values.length === 0) {
                $('#revenueChart').hide();
                $('#noRevenueData').show();
                return;
            }

            $('#noRevenueData').hide();
            $('#revenueChart').show();

            var chartConfig = {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Revenue',
                        data: values.map(v => Number(v)),
                        backgroundColor: '#6366f1'
                    }]
                },
                options: {
                    responsive: true,
                    interaction: {
                        mode: 'nearest',
                        intersect: true
                    },
                    plugins: {
                        legend: {
                            display: true
                        },
                        tooltip: {
                            enabled: true,
                            callbacks: {
                                title: function(context) {
                                    return context[0].label;
                                },
                                label: function(context) {
                                    return '₹ ' + context.raw;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '₹' + value;
                                }
                            }
                        }
                    }
                }
            };
            var url = "https://quickchart.io/chart?c=" + encodeURIComponent(JSON.stringify(chartConfig));
            $('#revenueChart').attr('src', url);
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\flight_b2b_travel\flight_b2b_travel\resources\views/home.blade.php ENDPATH**/ ?>