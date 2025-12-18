
<?php $__env->startSection('title', 'Booking Details'); ?>
<?php $__env->startSection('pagetitle', 'Booking Details'); ?>

<?php $__env->startSection('content'); ?>
    <!-- **************** MAIN CONTENT START **************** -->
    <main>
        <section>
            <div class="position-relative" data-sticky-container>
                <div class="row g-4">
                    <!-- Left Content START -->
                    <div class="col-xl-8">
                        <div class="accordion" id="accordionExample">

                            <!-- Accordion Item 2 -->
                            <div class="accordion-item mb-3 border">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <div class="d-flex align-items-center" id="titleSection">
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="border-top accordion-collapse collapse"
                                    aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body mt-3" id="getSelectFlightDetails">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="vstack gap-4">

                            <!-- Information START -->
                            <div class="card border">
                                <!-- Card header -->
                                <div class="card-header border-bottom px-4">
                                    <h4 class="card-title mb-0">Baggage Information</h4>
                                </div>
                                <!-- Card body -->
                                <div class="card-body py-4" id="baggageInfo">
                                    No Data Available
                                </div>
                            </div>


                            <form class="card border">
                                <div class="card-header border-bottom px-4">
                                    <h3 class="card-title mb-0">Traveler Details</h3>
                                </div>

                                <div class="card-body py-4">
                                    <div class="bg-light bg-opacity-10 rounded-2 p-3 mb-3">
                                        <p class="h6 fw-light small mb-0">
                                            <span class="badge bg-danger me-2">Note</span>
                                            Please make sure you enter the name as per your passport.
                                        </p>
                                        <div class="alert alert-warning mt-3" id="noteSection">

                                        </div>
                                    </div>

                                    <div id="travelerAccordion" class="accordion accordion-icon accordion-bg-light"></div>

                                    <!-- Contact Details -->
                                    <h5 class="mt-4">Booking details will be sent to</h5>
                                    <div class="row g-3 g-md-4">
                                        <div class="col-md-3">
                                            <label class="form-label">Cell Code<span class="text-danger">*</span></label>
                                            <select class="form-select required-field" name="cellcode">
                                                <option value="">Select</option>
                                                <option value="+91">+91</option>
                                                <option value="+1">+1</option>
                                                <option value="+44">+44</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Mobile Number<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control required-contact"
                                                placeholder="Enter your mobile number" name="mobileNo">
                                        </div>

                                        <div class="col-md-5">
                                            <label class="form-label">Email Address<span
                                                    class="text-danger">*</span></label>
                                            <input type="email" class="form-control required-contact"
                                                placeholder="Enter your email address" name="emailId">
                                        </div>
                                    </div>

                                    <div class="d-grid mt-4">
                                        <button id="proceedBtn" type="button" class="btn btn-primary mb-0" disabled>
                                            Proceed To Seat Details
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                    <!-- Left Content END -->

                    <!-- Right content START -->
                    <aside class="col-xl-4">

                        <div class="row g-4 sticky-top">
                            <!-- Fare summary START -->
                            <div class="col-md-6 col-xl-12">
                                <div class="card bg-light rounded-2" id="fareChargeDetails">

                                </div>
                            </div>
                            <!-- Fare summary END -->

                            <!-- Coupon START -->
                            <div class="col-md-6 col-xl-12">
                                <div class="card card-body bg-light" id="couponSection">

                                </div>
                            </div>
                            <!-- Coupon END -->

                            <!-- Cancel policy START -->
                            <div class="col-md-6 col-xl-12">
                                <div class="card card-body border p-4">
                                    <div class="cardt-title mb-3">
                                        <h5 class="mb-0">Cancellation, Date Change Charges & Mini Fare Rules</h5>
                                    </div>

                                    <p class="mb-2">The Cancellation penalty on this booking will depend on how close
                                        to the departure date you cancel your ticket. View fare rules to know more</p>
                                    <div><a href="#" class="btn p-0 mb-0 " data-bs-toggle="modal"
                                            data-bs-target="#cancellation">
                                            <i class="ti ti-eye"></i> <u class="text-decoration-underline">View Detail</u>
                                        </a></div>
                                </div>
                            </div>
                            <!-- Cancel policy END -->
                        </div>

                    </aside>
                    <!-- Right content END -->

                </div>
            </div>
        </section>
        <!-- =======================
                                                                    Main Content END -->

    </main>
    <!-- **************** MAIN CONTENT END **************** -->


    <!-- Cancellation modal START -->
    <div class="modal fade" id="cancellation" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Title -->
                <div class="modal-header">
                    <h5 class="modal-title" id="cancellationlabel">Cancellation, Date Change Charges & Mini Fare Rule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body p-3">

                    <ul class="nav nav-pills nav-justified nav-responsive border bg-opacity-10 rounded p-2 mb-3"
                        id="tour-pills-tab" role="tablist">
                        <!-- Tab item -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-start active mb-0" id="tour-pills-tab-1"
                                data-bs-toggle="pill" data-bs-target="#tour-pills-tab1" type="button" role="tab"
                                aria-controls="tour-pills-tab1" aria-selected="true">Mini Fare Charge</button>
                        </li>
                        <!-- Tab item -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-end mb-0" id="tour-pills-tab-2" data-bs-toggle="pill"
                                data-bs-target="#tour-pills-tab2" type="button" role="tab"
                                aria-controls="tour-pills-tab2" aria-selected="false">Date Change Charge</button>
                        </li>
                    </ul>

                    <!-- Tab content START -->
                    <div class="tab-content mb-0" id="tour-pills-tabContent">

                        <!-- Content item START -->
                        <div class="tab-pane fade show active" id="tour-pills-tab1" role="tabpanel"
                            aria-labelledby="tour-pills-tab-1">

                            <div class="card border" id="miniFareRules">

                            </div>
                        </div>
                        <!-- Content item END -->

                        <!-- Content item START -->
                        <div class="tab-pane fade" id="tour-pills-tab2" role="tabpanel"
                            aria-labelledby="tour-pills-tab-2">
                            <div class="card border" id="datatchargeDet">

                            </div>
                        </div>
                        <!-- Content item END -->

                    </div>
                    <!-- Tab content END -->
                </div>
            </div>
        </div>
    </div>
    <!-- Cancellation modal END -->

    <!-- Baggage and fare START -->
    <div class="modal fade" id="ruleFare" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- Title -->
                <div class="modal-header">
                    <h5 class="modal-title" id="ruleFarelabel">Fare Rules</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body p-3">
                    <!-- Card START -->
                    
                    <div class="card border" id="importantInfoSectionDeparture"></div>
                    <div class="card border" id="importantInfoSectionReturn"></div>

                </div>
            </div>
        </div>
    </div>
    <!-- Baggage and fare END -->

<?php $__env->stopSection(); ?>


<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('')); ?>js/flight.js"></script>


    <script>
        $(document).ready(function() {

            const payload = JSON.parse(localStorage.getItem('payload'));

            if (payload.JourneyType == 1) {
                const storedFlight = localStorage.getItem('selectedFlightDetails');
                const resultIndex = localStorage.getItem('ResultIndex');
                const traceId = localStorage.getItem('TraceId');

                $('#return-tab').hide();
                $('#returnFareRule').remove();

                if (storedFlight) {
                    const flightDetails = JSON.parse(storedFlight);
                    displayFlightDetails(flightDetails, 'departure');
                    getFareRules(resultIndex, traceId, 'departure');
                    getFareQuote(resultIndex, traceId, 'departure');

                } else {
                    console.log('No flight details found in localStorage.');
                }
            } else if (payload.JourneyType == 2) {

                const storedFlight = localStorage.getItem('selectedFlightDetails');
                const depresultIndex = localStorage.getItem('DepartureResultIndex');
                const rettresultIndex = localStorage.getItem('ReturnResultIndex');
                const traceId = localStorage.getItem('TraceId');

                $('#return-tab').show();
                if (storedFlight) {
                    const flightDetails = JSON.parse(storedFlight);

                    displayFlightDetails(flightDetails?.departure, 'departure');
                    displayFlightDetails(flightDetails?.return, 'return');

                    getFareRules(depresultIndex, traceId, 'departure');
                    getFareRules(rettresultIndex, traceId, 'return');

                    getFareQuote(depresultIndex, traceId, 'departure');
                    getFareQuote(rettresultIndex, traceId, 'return');

                } else {
                    console.log('No flight details found in localStorage.');
                }
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\flight_b2b_travel\flight_b2b_travel\resources\views/flight/detail.blade.php ENDPATH**/ ?>