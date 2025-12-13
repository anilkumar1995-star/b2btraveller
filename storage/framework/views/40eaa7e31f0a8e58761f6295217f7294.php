<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('pagetitle', 'Dashboard'); ?>
<?php $__env->startSection('content'); ?>
    <!-- Content -->


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
                <h2 class="fw-bold mb-1 text-white">Welcome Back, Shivani ✈️</h2>
                <p class="mb-0 text-white">Plan, track & manage your travel bookings efficiently.</p>
            </div>
            <img src="https://cdn-icons-png.flaticon.com/512/201/201623.png" width="110" />
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4 p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <small class="text-muted">Today's Bookings</small>
                        <h3 class="fw-bold">264</h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 p-3 rounded-3">✈️</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4 p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <small class="text-muted">Hotel Reservations</small>
                        <h3 class="fw-bold">148</h3>
                    </div>
                    <div class="bg-warning bg-opacity-10 p-3 rounded-3">🏨</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4 p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <small class="text-muted">Bus Tickets</small>
                        <h3 class="fw-bold">512</h3>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded-3">🚌</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4 p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <small class="text-muted">Total Revenue</small>
                        <h3 class="fw-bold">₹1.8 Lakh</h3>
                    </div>
                    <div class="bg-danger bg-opacity-10 p-3 rounded-3">💸</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts & Lists Row -->
    <div class="row g-4">

        <!-- Left side section -->
        <div class="col-lg-8">

            <!-- Revenue Chart Box -->
            <div class="card shadow-sm border-0 rounded-4 p-3 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="fw-bold">Revenue Overview</h5>
                    <span class="text-muted small">Last 30 days</span>
                </div>
                <div
                    style="height:240px; background:#f8faff; border-radius:12px; display:flex; align-items:center; justify-content:center; color:#9ca3af;">
                    <img src="https://quickchart.io/chart?c={type:'bar',data:{labels:['Week 1','Week 2','Week 3','Week 4'],datasets:[{label:'Revenue',data:[40,55,32,70]}]}}"
                        style="max-width:100%; height:100%; object-fit:contain; opacity:0.9;" /></div>
            </div>

            <!-- Popular Routes -->
            <div class="card shadow-sm border-0 rounded-4 p-3">
                <h5 class="fw-bold mb-3">Top Travel Routes</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">DEL → MUM <span
                            class="badge bg-primary">85%</span></li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">BLR → GOA <span
                            class="badge bg-primary">78%</span></li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">PNQ → DEL <span
                            class="badge bg-primary">73%</span></li>
                </ul>
            </div>

        </div>

        <!-- Right Section -->
        <div class="col-lg-4">

            <!-- Recent Bookings -->
            <div class="card shadow-sm border-0 rounded-4 p-3 mb-4">
                <h5 class="fw-bold mb-2">Recent Bookings</h5>
                <div class="list-group">
                    <div class="list-group-item border-0 px-0">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>Asha R.</strong><br>
                                <small class="text-muted">GOA • Hotel • 22 Dec</small>
                            </div>
                            <span class="badge bg-success">Confirmed</span>
                        </div>
                    </div>
                    <div class="list-group-item border-0 px-0">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>Vikram P.</strong><br>
                                <small class="text-muted">MUM • Flight • 14 Dec</small>
                            </div>
                            <span class="badge bg-warning text-dark">Pending</span>
                        </div>
                    </div>
                    <div class="list-group-item border-0 px-0">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>Neha S.</strong><br>
                                <small class="text-muted">DEL • Bus • 16 Dec</small>
                            </div>
                            <span class="badge bg-danger">Cancelled</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Log -->
            <div class="card shadow-sm border-0 rounded-4 p-3">
                <h6 class="fw-bold mb-2">Live Activity</h6>
                <div style="max-height:200px; overflow:auto;">
                    <div class="mb-2 small">🟢 Booking #5482 confirmed — <strong>Rahul K.</strong> <span
                            class="text-muted">2m ago</span></div>
                    <div class="mb-2 small">🔔 Payment failed for <strong>#5479</strong> <span class="text-muted">10m
                            ago</span></div>
                    <div class="mb-2 small">✈️ Flight DEL → MUM fully booked <span class="text-muted">1h ago</span></div>
                </div>
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
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\flight_b2b_travel\flight_b2b_travel\resources\views/home.blade.php ENDPATH**/ ?>