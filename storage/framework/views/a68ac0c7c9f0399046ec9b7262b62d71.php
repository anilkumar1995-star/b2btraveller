
<?php $__env->startSection('title', 'Booking List'); ?>
<?php $__env->startSection('pagetitle', 'Booking List'); ?>


<?php $__env->startSection('content'); ?>
    <main>
        <section>


            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="card card-border-shadow-primary a h-90">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar me-3">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="ti ti-plane"></i>
                                    </span>
                                </div>
                                <h4 class="mb-0 text-success" data-bs-toggle="tooltip" title=""
                                    data-bs-original-title="Total Lcc = ₹ <?php echo e(number_format($total_booking_amount ?? 0, 2)); ?>"
                                    id="total_booking_amount">
                                    ₹0
                                </h4>
                            </div>
                            <small class="mb-1 fw-bold">Total LCC booking value</small>
                            <p class="mb-0">
                                <span class="text-heading fw-bold me-1" id="booking_count"> 0 </span>
                                <small class="text-body-secondary">Total LCC Counts</small>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="card shadow-sm bg-light-success h-90">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar me-3">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="ti ti-plane"></i>
                                    </span>
                                </div>
                                <h4 class="mb-0 text-success" data-bs-toggle="tooltip" title=""
                                    data-bs-original-title="Total Lcc = ₹ <?php echo e(number_format($total_booking_amount ?? 0, 2)); ?>"
                                    id="total_booking_amount">
                                    ₹0
                                </h4>
                            </div>
                            <small class="mb-1 fw-bold">Total Non Lcc bookings</small>
                            <p class="mb-0">
                                <span class="text-heading fw-bold me-1" id="booking_count"> 0 </span>
                                <small class="text-body-secondary">Total Non Lcc Counts</small>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="card card-border-shadow-primary h-90">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar me-3">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="ti ti-plane"></i>
                                    </span>
                                </div>
                                <h4 class="mb-0 text-success" data-bs-toggle="tooltip" title=""
                                    data-bs-original-title="Total Lcc = ₹ <?php echo e(number_format($total_booking_amount ?? 0, 2)); ?>"
                                    id="total_booking_amount">
                                    ₹0
                                </h4>
                            </div>
                            <small class="mb-1 fw-bold">Total Oneway bookings</small>
                            <p class="mb-0">
                                <span class="text-heading fw-bold me-1" id="booking_count"> 0 </span>
                                <small class="text-body-secondary">Total Oneway Counts</small>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-3">
                    <div class="card card-border-shadow-primary h-90">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar me-3">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="ti ti-plane"></i>
                                    </span>
                                </div>
                                <h4 class="mb-0 text-success" data-bs-toggle="tooltip" title=""
                                    data-bs-original-title="Total Lcc = ₹ <?php echo e(number_format($total_booking_amount ?? 0, 2)); ?>"
                                    id="total_booking_amount">
                                    ₹0
                                </h4>
                            </div>
                            <small class="mb-1 fw-bold">Total Round Trip bookings</small>
                            <p class="mb-0">
                                <span class="text-heading fw-bold me-1" id="booking_count"> 0 </span>
                                <small class="text-body-secondary">Total Roundtrip Counts</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4 ">
                    <div class="card-title mb-5">
                        <h4 class="mb-0">
                            <span><?php echo $__env->yieldContent('pagetitle'); ?> </span>
                        </h4>
                    </div>
                </div>
                <div class="card-body">
                    <div id="bookingTable" class="overflow-auto">
                        <?php echo $__env->make('flight.booking-table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
        </section>


    </main>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('script'); ?>
    <script>
        $(document).ready(function() {

            // When clicking next/previous page
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                loadBookings(url);
            });

            function loadBookings(url) {
                $.ajax({
                    url: url,
                    success: function(data) {
                        $("#bookingTable").html(data);
                    }
                });
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\flight_b2b_travel\flight_b2b_travel\resources\views/flight/bookinglist.blade.php ENDPATH**/ ?>