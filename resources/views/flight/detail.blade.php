@extends('layouts.app')
@section('title', 'Booking Details')
@section('pagetitle', 'Booking Details')

@section('content')
    <!-- **************** MAIN CONTENT START **************** -->
    <main>

        <!-- =======================
                                        Main Content START -->
        <section>
            <div class="position-relative" data-sticky-container>
                <div class="row g-4">
                    <!-- Left Content START -->
                    <div class="col-xl-8">
                        <div class="vstack gap-4">

                            <!-- Title START -->
                            <div class="d-flex align-items-center" id="titleSection">

                            </div>
                            <!-- Title END -->

                            <!-- Ticket START -->
                            <div class="card border" id="getSelectFlightDetails">

                            </div>
                            <!-- Ticket END -->

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
                            <!-- Information END -->

                            {{-- <!-- Booking form START -->
                            <form class="card border">
                                <!-- Card header -->
                                <div class="card-header border-bottom px-4">
                                    <h3 class="card-title mb-0">Traveler Details</h3>
                                </div>

                                <!-- Card body START -->
                                <div class="card-body py-4">
                                    <!-- Badge with content -->
                                    <div class="bg-danger bg-opacity-10 rounded-2 p-3 mb-3">
                                        <p class="h6 fw-light small mb-0"><span
                                                class="badge bg-danger me-2">New</span>Please make sure you enter the Name
                                            as per your passport</p>
                                    </div>

                                    <!-- Button -->
                                    <div class="text-end mb-3">
                                        <a href="#" class="btn btn-primary-soft mb-0">Add New Adult</a>
                                    </div>

                                    <!-- Accordion START -->
                                    <div class="accordion accordion-icon accordion-bg-light" id="accordionExample2">
                                        <!-- Item -->
                                        <div class="accordion-item mb-3">
                                            <h6 class="accordion-header font-base" id="heading-1">
                                                <button class="accordion-button fw-bold rounded collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapse-1"
                                                    aria-expanded="true" aria-controls="collapse-1">
                                                    Adult 1
                                                </button>
                                            </h6>
                                            <!-- Accordion Body START -->
                                            <div id="collapse-1" class="accordion-collapse collapse show"
                                                aria-labelledby="heading-1" data-bs-parent="#accordionExample2">
                                                <div class="accordion-body mt-3">

                                                    <!-- Form START -->
                                                    <div class="row g-4">
                                                        <!-- Select item -->
                                                        <div class="col-md-3">
                                                            <label class="form-label">Title</label>
                                                            <select class="form-select js-choice">
                                                                <option selected>Mr</option>
                                                                <option>Mrs</option>
                                                            </select>
                                                        </div>

                                                        <!-- Input item -->
                                                        <div class="col-md-9">
                                                            <label class="form-label">Full name</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                    placeholder="First name">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Last name">
                                                            </div>
                                                        </div>

                                                        <!-- Select group -->
                                                        <div class="col-md-6">
                                                            <label class="form-label">Date Of Birth</label>
                                                            <div class="row g-0">
                                                                <div class="col-4">
                                                                    <div class="choice-radius-end">
                                                                        <select
                                                                            class="form-select js-choice z-index-9 rounded-start">
                                                                            <option value="" selected>Date</option>
                                                                            <option>1</option>
                                                                            <option>2</option>
                                                                            <option>3</option>
                                                                            <option>4</option>
                                                                            <option>5</option>
                                                                            <option>6</option>
                                                                            <option>7</option>
                                                                            <option>8</option>
                                                                            <option>9</option>
                                                                            <option>10</option>
                                                                            <option>11</option>
                                                                            <option>12</option>
                                                                            <option>13</option>
                                                                            <option>14</option>
                                                                            <option>15</option>
                                                                            <option>16</option>
                                                                            <option>17</option>
                                                                            <option>18</option>
                                                                            <option>19</option>
                                                                            <option>20</option>
                                                                            <option>21</option>
                                                                            <option>22</option>
                                                                            <option>23</option>
                                                                            <option>24</option>
                                                                            <option>25</option>
                                                                            <option>26</option>
                                                                            <option>27</option>
                                                                            <option>28</option>
                                                                            <option>29</option>
                                                                            <option>30</option>
                                                                            <option>31</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-4">
                                                                    <div class="choice-radius-0">
                                                                        <select
                                                                            class="form-select choice-radius-0 js-choice z-index-9 border-0 bg-light">
                                                                            <option value="" selected>Month</option>
                                                                            <option>Jan</option>
                                                                            <option>Feb</option>
                                                                            <option>Mar</option>
                                                                            <option>Apr</option>
                                                                            <option>May</option>
                                                                            <option>Jun</option>
                                                                            <option>Jul</option>
                                                                            <option>Aug</option>
                                                                            <option>Sep</option>
                                                                            <option>Oct</option>
                                                                            <option>Nov</option>
                                                                            <option>Dec</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-4">
                                                                    <div class="choice-radius-start">
                                                                        <select
                                                                            class="form-select js-choice z-index-9 border-0 bg-light">
                                                                            <option value="" selected>Year</option>
                                                                            <option>1990</option>
                                                                            <option>1991</option>
                                                                            <option>1992</option>
                                                                            <option>1993</option>
                                                                            <option>1994</option>
                                                                            <option>1995</option>
                                                                            <option>1996</option>
                                                                            <option>1997</option>
                                                                            <option>1998</option>
                                                                            <option>1999</option>
                                                                            <option>2000</option>
                                                                            <option>2001</option>
                                                                            <option>2002</option>
                                                                            <option>2003</option>
                                                                            <option>2004</option>
                                                                            <option>2005</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Select item -->
                                                        <div class="col-md-6">
                                                            <label class="form-label">Nationality</label>
                                                            <select class="form-select js-choice">
                                                                <option value="" selected>Select Nationality</option>
                                                                <option>Indian</option>
                                                                <option>Mali</option>
                                                                <option>Japan</option>
                                                                <option>Jordan</option>
                                                            </select>
                                                        </div>

                                                        <!-- Input item -->
                                                        <div class="col-md-6">
                                                            <label class="form-label">Passport Number</label>
                                                            <input type="text" class="form-control"
                                                                placeholder="Enter passport number">
                                                        </div>

                                                        <!-- Select item -->
                                                        <div class="col-md-6">
                                                            <label class="form-label">Passport Issuing Country</label>
                                                            <select class="form-select js-choice">
                                                                <option value="" selected>Select Country</option>
                                                                <option>India</option>
                                                                <option>Canada</option>
                                                                <option>Japan</option>
                                                                <option>China</option>
                                                            </select>
                                                        </div>

                                                        <!-- Select group -->
                                                        <div class="col-md-6">
                                                            <label class="form-label">Passport Expiry</label>
                                                            <input type="text" class="form-control flatpickr"
                                                                placeholder="Enter passport date"
                                                                data-date-format="d M y">
                                                        </div>
                                                    </div>
                                                    <!-- Form END -->

                                                </div>
                                            </div>
                                            <!-- Accordion Body END -->
                                        </div>

                                        <!-- Item -->
                                        <div class="accordion-item">
                                            <h6 class="accordion-header font-base" id="heading-2">
                                                <button class="accordion-button rounded fw-bold collapsed pe-5"
                                                    type="button" data-bs-toggle="collapse" data-bs-target="#collapse-2"
                                                    aria-expanded="false" aria-controls="collapse-2">
                                                    Adult 2
                                                </button>
                                            </h6>
                                            <!-- Body -->
                                            <div id="collapse-2" class="accordion-collapse collapse"
                                                aria-labelledby="heading-2" data-bs-parent="#accordionExample2">
                                                <div class="accordion-body mt-3">
                                                    What deal evil rent by real in. But her ready least set lived spite
                                                    solid. September how men saw tolerably two behavior arranging. She
                                                    offices for highest and replied one venture pasture. Applauded no
                                                    discovery in newspaper allowance am northward. Frequently partiality
                                                    possession resolution at or appearance unaffected me. Engaged its was
                                                    the evident pleased husband. Ye goodness felicity do disposal dwelling
                                                    no. First am plate jokes to began to cause a scale. Subjects he prospect
                                                    elegance followed no overcame possible it on. Improved own provided
                                                    blessing may peculiar domestic. Sight house has sex never. No visited
                                                    raising gravity outward subject my cottage Mr be.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Accordion END -->

                                    <!-- Number and email START -->
                                    <!-- Title -->
                                    <h5 class="mt-4">Booking detail will be sent to</h5>
                                    <div class="row g-3 g-md-4">
                                        <!-- Input item -->
                                        <div class="col-md-6">
                                            <label class="form-label">Mobile Number</label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter your mobile number">
                                        </div>

                                        <!-- Input item -->
                                        <div class="col-md-6">
                                            <label class="form-label">Email Address</label>
                                            <input type="email" class="form-control"
                                                placeholder="Enter your email address">
                                        </div>
                                    </div>
                                    <!-- Number and email START -->

                                    <!-- Button -->
                                    <div class="d-grid mt-4">
                                        <a href="{{ route('second', ['flight', 'booking']) }}"
                                            class="btn btn-primary mb-0">Proceed To Payment</a>
                                    </div>
                                </div>
                                <!-- Card body END -->
                            </form>
                            <!-- Booking form END --> --}}

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

                    <ul class="nav nav-pills nav-justified nav-responsive bg-primary bg-opacity-10 rounded p-2 mb-3"
                        id="tour-pills-tab" role="tablist">
                        <!-- Tab item -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-start active mb-0" id="tour-pills-tab-1" data-bs-toggle="pill"
                                data-bs-target="#tour-pills-tab1" type="button" role="tab"
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
                    <div class="card border">
                        <!-- Card header -->
                        <div class="card-header border-bottom" id="fareRulehead">
                            <!-- Title -->

                        </div>

                        <!-- Card body -->
                        <div class="card-body mt-3" id="importantInfoSection">

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Baggage and fare END -->
@endsection


@push('script')
    <script src="{{ asset('') }}js/flight.js"></script>


    <script>
        $(document).ready(function() {

            const payload = JSON.parse(localStorage.getItem('payload'));

            if (payload.JourneyType == 1) {
                const storedFlight = localStorage.getItem('selectedFlightDetails');
                const resultIndex = localStorage.getItem('ResultIndex');
                const traceId = localStorage.getItem('TraceId');
                if (storedFlight) {
                    const flightDetails = JSON.parse(storedFlight);
                    displayFlightDetails(flightDetails);
                    getFareRules(resultIndex, traceId);
                    getFareQuote(resultIndex, traceId);

                } else {
                    console.log('No flight details found in localStorage.');
                }
            } else if (payload.JourneyType == 2) {

                const storedFlight = localStorage.getItem('selectedFlightDetails');
                const depresultIndex = localStorage.getItem('DepartureResultIndex');
                const rettresultIndex = localStorage.getItem('ReturnResultIndex');
                const traceId = localStorage.getItem('TraceId');

                if (storedFlight) {
                    const flightDetails = JSON.parse(storedFlight);
                   
                    displayFlightDetails(flightDetails?.departure, 'return');
                    displayFlightDetails(flightDetails?.return, 'return');

                    getFareRules(resultIndex, traceId, 'return');
                    getFareRules(resultIndex, traceId, 'return');

                    getFareQuote(resultIndex, traceId, 'return');
                    getFareQuote(resultIndex, traceId, 'return');

                } else {
                    console.log('No flight details found in localStorage.');
                }
            }
        });
    </script>
@endpush
