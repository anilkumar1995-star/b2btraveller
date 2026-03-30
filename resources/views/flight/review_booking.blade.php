@extends('layouts.app')
@section('title', 'Booking Page')
@section('pagetitle', 'Booking Page')

@section('content')

    <div class="modal fade" id="cancellation" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header border-bottom pb-3">
                    <h5 class="modal-title" id="cancellationlabel">Cancellation, Date Change Charges & Mini Fare Rule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>


                <div class="modal-body p-3">

                    <div class="accordion" id="cancellationAccordion">

                        <!-- Departure -->
                        <div class="accordion-item border" id="departureAccordion">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#departureCollapse">
                                    ✈️ Departure – Cancellation & Fare Rules
                                </button>
                            </h2>
                            <div id="departureCollapse" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <ul class="nav nav-pills nav-justified nav-responsive border bg-opacity-10 rounded p-2 mb-3"
                                        id="tour-pills-tab" role="tablist">

                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link rounded-start active mb-0" id="tour-pills-tab-1"
                                                data-bs-toggle="pill" data-bs-target="#tour-pills-tab1" type="button"
                                                role="tab" aria-controls="tour-pills-tab1" aria-selected="true">Mini
                                                Fare Charge</button>
                                        </li>

                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link rounded-end mb-0" id="tour-pills-tab-2"
                                                data-bs-toggle="pill" data-bs-target="#tour-pills-tab2" type="button"
                                                role="tab" aria-controls="tour-pills-tab2" aria-selected="false">Date
                                                Change Charge</button>
                                        </li>
                                    </ul>


                                    <div class="tab-content mb-0" id="tour-pills-tabContent">


                                        <div class="tab-pane fade show active" id="tour-pills-tab1" role="tabpanel"
                                            aria-labelledby="tour-pills-tab-1">

                                            {{-- <div id="miniFareRules"> --}}
                                            <div id="departureMiniFare">

                                            </div>
                                        </div>



                                        <div class="tab-pane fade" id="tour-pills-tab2" role="tabpanel"
                                            aria-labelledby="tour-pills-tab-2">
                                            {{-- <div id="datatchargeDet"> --}}
                                            <div id="departureDateCharge">

                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Return -->
                        <div class="accordion-item border mt-3" id="returnAccordion">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#returnCollapse">
                                    🔁 Return – Cancellation & Fare Rules
                                </button>
                            </h2>
                            <div id="returnCollapse" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <ul class="nav nav-pills nav-justified nav-responsive border bg-opacity-10 rounded p-2 mb-3"
                                        id="tour-pills-tab-return" role="tablist">

                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link rounded-start active mb-0" id="tour-pills-tab-11"
                                                data-bs-toggle="pill" data-bs-target="#tour-pills-tab11" type="button"
                                                role="tab" aria-controls="tour-pills-tab11" aria-selected="true">Mini
                                                Fare Charge</button>
                                        </li>

                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link rounded-end mb-0" id="tour-pills-tab-22"
                                                data-bs-toggle="pill" data-bs-target="#tour-pills-tab22" type="button"
                                                role="tab" aria-controls="tour-pills-tab22" aria-selected="false">Date
                                                Change Charge</button>
                                        </li>
                                    </ul>


                                    <div class="tab-content mb-0" id="tour-pills-tabContentReturn">


                                        <div class="tab-pane fade show active" id="tour-pills-tab11" role="tabpanel"
                                            aria-labelledby="tour-pills-tab-11">

                                            <div id="returnMiniFare">

                                            </div>
                                        </div>



                                        <div class="tab-pane fade" id="tour-pills-tab22" role="tabpanel"
                                            aria-labelledby="tour-pills-tab-22">
                                            <div id="returnDateCharge">

                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="ruleFaredeparture" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="ruleFarelabel">Fare Rules Departure</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>


                <div class="modal-body p-3">
                    <div class="card border" id="importantInfoSectionDeparture"></div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ruleFarereturn" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="ruleFareRetlabel">Fare Rules Return</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>


                <div class="modal-body p-3">
                    <div class="card border" id="importantInfoSectionReturn"></div>

                </div>
            </div>
        </div>
    </div>
    <main>
        <section>

            <div id="bookingData">

                <div class="row g-4 g-xl-5">
                    <!-- Left Content START -->
                    <div class="col-xl-12">
                        <div class="card border" id="bookingSummaryCard">
                            <div class="card-header d-flex justify-content-between align-items-center border-bottom">
                                <h5 class="mb-0 card-title">Your Booking Details🔖</h5>


                                <button class="btn btn-primary" id="proceedBookingBtn">
                                    Proceed to Booking
                                </button>
                            </div>


                            <div class="position-relative m-3" data-sticky-container>
                                <div class="row g-4">

                                    <div class="col-xl-8">
                                        <div class="accordion" id="accordionExample">


                                            <div class="accordion-item mb-3 border">
                                                <h2 class="accordion-header" id="headingTwo">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                        aria-expanded="false" aria-controls="collapseTwo">
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

                                        <div id="baggageInfo">
                                        </div>

                                        <div class="card-body mt-2 border shadow-sm rounded">
                                            <div>
                                                <h6 class="mb-3"><i
                                                        class="bi bi-person-circle me-2"></i><strong>Traveler
                                                        Details</strong></h6>
                                                <div id="travelerList"></div>
                                                <div id="travelerListReturn"></div>
                                            </div>

                                        </div>

                                    </div>



                                    <aside class="col-xl-4">

                                        <div class="row g-4 sticky-top">

                                            <div class="col-md-6 col-xl-12">
                                                <div class="card rounded-2">
                                                    <!-- Tabs Header -->
                                                    <ul class="nav nav-tabs ms-0 w-100" id="fareTabs" role="tablist">
                                                        <li class="nav-item w-50" role="presentation">
                                                            <button class="nav-link active" id="departure-tab-fare"
                                                                data-bs-toggle="tab"
                                                                data-bs-target="#departurefareChargeDetails"
                                                                type="button" role="tab"
                                                                aria-controls="departurefareChargeDetails"
                                                                aria-selected="true">
                                                                Departure
                                                            </button>
                                                        </li>
                                                        <li class="nav-item w-50 d-none" role="presentation"
                                                            id="returntabfare">
                                                            <button class="nav-link" id="return-tab-fare"
                                                                data-bs-toggle="tab"
                                                                data-bs-target="#returnfareChargeDetails" type="button"
                                                                role="tab" aria-controls="returnfareChargeDetails"
                                                                aria-selected="false">
                                                                Return
                                                            </button>
                                                        </li>
                                                    </ul>

                                                    <!-- Tabs Content -->
                                                    <div class="tab-content p-3" id="fareTabsContent">
                                                        <div class="tab-pane fade show active bg-light rounded"
                                                            id="departurefareChargeDetails" role="tabpanel"
                                                            aria-labelledby="departure-tab-fare">

                                                        </div>
                                                        <div class="tab-pane fade bg-light rounded"
                                                            id="returnfareChargeDetails" role="tabpanel"
                                                            aria-labelledby="return-tab-fare">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-12">
                                                <div class="card card-body border p-4">
                                                    <div class="cardt-title mb-3">
                                                        <h5 class="mb-0">Cancellation, Date Change Charges & Mini
                                                            Fare Rules</h5>
                                                    </div>

                                                    <p class="mb-2">The Cancellation penalty on this booking will
                                                        depend on how close
                                                        to the departure date you cancel your ticket. View fare rules to
                                                        know more</p>
                                                    <div><a href="#" class="btn p-0 mb-0 " data-bs-toggle="modal"
                                                            data-bs-target="#cancellation">
                                                            <i class="ti ti-eye"></i> <u
                                                                class="text-decoration-underline">View Detail</u>
                                                        </a></div>
                                                </div>
                                            </div>

                                        </div>

                                    </aside>


                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection


@push('script')
    <script src="{{ asset('') }}js/boookflighttriping.js"></script>


    <script>
        $(document).ready(function() {

            const payload = JSON.parse(localStorage.getItem('payload'));

            let isInternational = localStorage.getItem("isInternational") || false;

            if (!payload) {
                swal({
                    title: "Session Expired",
                    html: "Your booking session has expired.<br/>Please search flights again to continue.",
                    type: "warning",
                    confirmButtonText: "Search Flights",
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then(() => {
                    window.location.href = "/flight/view";
                });
                return;
            }

            if (payload.JourneyType == 1) {
                const storedFlight = localStorage.getItem('selectedFlightDetails');
                const resultIndex = localStorage.getItem('ResultIndex');
                const traceId = localStorage.getItem('TraceId');

                if (storedFlight) {
                    const flightDetails = JSON.parse(storedFlight);
                    localStorage.removeItem(`requiredSSRdeparture`);

                    displayFlightDetails(flightDetails, 'departure');
                    getFareRules(resultIndex, traceId, 'departure');
                    getFareQuote(resultIndex, traceId, 'departure');

                } else {
                    notify('No flight details found in localStorage.', 'error');
                }
            } else if (payload.JourneyType == 2) {

                const storedFlight = localStorage.getItem('selectedFlightDetails');
                const traceId = localStorage.getItem('TraceId');

                // $('#return-tab').show();
                if (storedFlight) {
                    const flightDetails = JSON.parse(storedFlight);

                    if (isInternational) {

                        const resultIndex = flightDetails.ResultIndex;

                        displayInternationalRTFlightDetails(flightDetails, 'departure', 0);
                        displayInternationalRTFlightDetails(flightDetails, 'return', 1);

                        getFareRulesInternationalRoundtrip(resultIndex, traceId);
                        getInternationalRoundTripFareQuote(resultIndex, traceId);
                    } else {

                        const depresultIndex = localStorage.getItem('DepartureResultIndex');
                        const rettresultIndex = localStorage.getItem('ReturnResultIndex');
                        localStorage.removeItem(`requiredSSRdeparture`);
                        localStorage.removeItem(`requiredSSRreturn`);

                        displayFlightDetails(flightDetails?.departure, 'departure');
                        getFareRules(depresultIndex, traceId, 'departure');
                        getFareQuote(depresultIndex, traceId, 'departure');

                        displayFlightDetails(flightDetails?.return, 'return');
                        getFareRules(rettresultIndex, traceId, 'return');
                        getFareQuote(rettresultIndex, traceId, 'return');
                    }
                } else {
                    notify('No flight details found in localStorage.', 'error');
                }
            }
        });
    </script>
@endpush

@push('script')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf417-js/2.1.7/pdf417.min.js"></script> --}}
    <script src="https://unpkg.com/bwip-js/dist/bwip-js-min.js"></script>

    {{-- <script src="{{ asset('') }}js/boookflighttriping.js"></script> --}}
    <script>
        $(document).ready(function() {
            const payload = JSON.parse(localStorage.getItem('payload'));
            const traceId = localStorage.getItem('TraceId') || '';
            let selectedFlightDetails = JSON.parse(localStorage.getItem('selectedFlightDetails'));
            let selectedSeats = JSON.parse(localStorage.getItem('selectedSeat')) || [];
            let selectedMeals = JSON.parse(localStorage.getItem('selectedmeal')) || [];
            let selectedBaggage = JSON.parse(localStorage.getItem('selectedBaggage')) || [];

            let selectedSeatsRet = JSON.parse(localStorage.getItem('selectedSeatReturn')) || [];
            let selectedMealsRet = JSON.parse(localStorage.getItem('selectedmealReturn')) || [];
            let selectedBaggageRet = JSON.parse(localStorage.getItem('selectedBaggageReturn')) || [];

            let travelerDetails = JSON.parse(localStorage.getItem('travelerDetails')) || [];
            let contactDetails = JSON.parse(localStorage.getItem('contactDetails'));
            let fareFlightDetailsdeparture = JSON.parse(localStorage.getItem('fareFlightDetailsdeparture')) || [];
            let fareFlightDetailsreturn = JSON.parse(localStorage.getItem('fareFlightDetailsreturn')) || [];
            let fareRules = JSON.parse(localStorage.getItem('fareRulesdeparture')) || [];

            let isInternational = localStorage.getItem("isInternational") || false;

            if (payload.JourneyType == 1) {

                if (selectedFlightDetails) {
                    displayFlightDetails(selectedFlightDetails, 'departure');
                } else {
                    notify('No flight details found in localStorage.', 'error');
                }
            } else if (payload.JourneyType == 2) {

                if (selectedFlightDetails) {

                    if (isInternational) {
                        displayInternationalRTFlightDetails(flightDetails, 'departure', 0);
                        displayInternationalRTFlightDetails(flightDetails, 'return', 1);

                    } else {
                        displayFlightDetails(selectedFlightDetails?.departure, 'departure');
                        displayFlightDetails(selectedFlightDetails?.return, 'return');
                    }
                } else {
                    notify('No flight details found in localStorage.', 'error');
                }
            }

            let cardHtml = '';
            fareRules.forEach((rule, index) => {
                cardHtml += `
                    <div class="card mb-3">
                        <div class="card-header border-bottom">
                            <h5 class="card-title mb-0">
                                ✈️ ${rule.Origin} - ${rule.Destination} [${rule.Airline}]
                                <span class="badge bg-light text-success mb-2"><i class="ti ti-star fs-6 me-2"></i>Travel
                                    Hack ${index + 1}</span>
                            </h5>
                        </div>

                        <div class="card-body mt-3">
                            ${rule.FareRuleDetail || 'No Fare Rules Available.'}
                        </div>
                    </div>
                `;
            });


            $('#importantInfoSectionDeparture').html(cardHtml);

            displayPassengerDetails();

            function displayFlightDetails(flightDetails, trip) {

                let segs = flightDetails?.Segments[0] || [];

                let firstSeg = segs[0] || null;
                let lastSeg = segs.length ? segs[segs.length - 1] : null;

                let detailsHtml = '';
                let titledetailsHtml = '';

                const fmtTime = (t) => new Date(t).toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                const fmtDate = (t) => new Date(t).toLocaleDateString('en-IN', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });

                titledetailsHtml = `<h1 class="display-4 mb-0"><i class="fa-solid fa-plane rtl-flip fs-1"></i></h1>
                    <div class="ms-3">
                        <ul class="list-inline mb-2">
                            <li class="list-inline-item me-2">
                                <h4 class="mb-0">${firstSeg.Origin?.Airport?.CityName}(${firstSeg.Origin?.Airport?.AirportCode || firstSeg.Origin?.Airport?.CityCode})</h4>
                            </li>
                            <li class="list-inline-item me-2">
                                <h4 class="mb-0"><i class="ti ti-arrow-right"></i></h4>
                            </li>
                            <li class="list-inline-item me-0">
                                <h4 class="mb-0">${lastSeg.Destination?.Airport?.CityName}(${lastSeg.Destination?.Airport?.AirportCode || lastSeg.Destination?.Airport?.CityCode})</h4>
                            </li>
                        </ul>

                        <ul class="nav nav-divider h6 fw-normal text-body mb-0">
                            <li class="nav-item">${fmtDate(segs[0].Origin?.DepTime)}</li>
                            <li class="nav-item">&nbsp;| &nbsp;${segs.length - 1 != 0 ? segs.length - 1 : 'Non'} Stop &nbsp;| &nbsp;</li>
                            <li class="nav-item badge bg-label-warning">${trip}</li>
                        </ul>
                    </div>`;

                // -------- MULTIPLE SEGMENTS LOOP --------

                let modalId = trip == 'departure' ? 'ruleFaredeparture' : 'ruleFarereturn';
                detailsHtml += `<div class="card-header d-flex justify-content-between pb-0">
                        <h6 class="fw-normal mb-0"><span class="text-body">Travel Class:</span> ${segs[0].CabinClass}</h6>
                        <a href="javascript:void(0)" 
                            class="btn p-0 mb-0"
                            data-bs-toggle="modal"
                            data-bs-target="#${modalId}">
                            <i class="ti ti-eye me-1"></i>
                            <u class="text-decoration-underline">Fare Rules (${trip})</u>
                        </a>
                    </div>  
                <div class="card-body p-4">`;

                for (let i = 0; i < segs.length; i++) {
                    let s = segs[i];
                    detailsHtml += `
                    <div class="row g-4 ">
                        <div class="col-md-3 pt-5">
                            ✈️
                            <h6 class="fw-normal mb-0">${s.Airline.AirlineName}</h6>
                            <h6 class="fw-normal mb-0">(${s.Airline.AirlineCode} - ${s.Airline.FlightNumber})</h6>
                        </div>
                        <div class="col-sm-4 col-md-3">
                            <h4>${s.Origin.Airport.AirportCode}</h4>
                            <h6>${fmtTime(s.Origin.DepTime)}</h6>
                            <p>${fmtDate(s.Origin.DepTime)}</p>
                            <p>${s.Origin.Airport.AirportName} ${s.Origin.Airport.CityName}</p>
                            <p>Terminal: ${s.Origin.Airport.Terminal || 'N/A'}</p>
                        </div>
                        <div class="col-sm-4 col-md-3 text-center my-sm-auto">
                            <h5>${formatDuration(s.Duration)}</h5>
                            <div class="position-relative my-4">
                                <hr class="bg-primary opacity-5 position-relative">
                                <div class="icon-md bg-primary text-white rounded-circle position-absolute top-50 start-50 translate-middle p-2">
                                    <i class="fa-solid fa-plane"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 text-end">
                            <h4>${s.Destination.Airport.AirportCode}</h4>
                            <h6>${fmtTime(s.Destination.ArrTime)}</h6>
                            <p>${fmtDate(s.Destination.ArrTime)}</p>
                            <p>${s.Destination.Airport.AirportName} ${s.Destination.Airport.CityName}</p>
                            <p>Terminal: ${s.Destination.Airport.Terminal || 'N/A'}</p>
                        </div>
                    </div>`;

                    if (i < segs.length - 1) {
                        let groundTime = calculateGroundTime(
                            s.Destination.ArrTime,
                            segs[i + 1].Origin.DepTime
                        );

                        detailsHtml += `<div class="bg-light rounded-2 text-center text-danger p-2 mb-4">
                            Ground Time at ${s.Destination.Airport.CityName}: ${groundTime}
                        </div>`;
                    }
                }

                detailsHtml += `</div>`;

                if (trip === 'return') {
                    $('#titleSectionReturn').html(titledetailsHtml);
                    $('#getSelectFlightDetailsReturn').html(detailsHtml);
                } else {
                    $('#titleSection').html(titledetailsHtml);
                    $('#getSelectFlightDetails').html(detailsHtml);
                }
            }

            function formatDuration(minutes) {
                const hrs = Math.floor(minutes / 60);
                const mins = minutes % 60;
                return `${hrs}h ${mins}m`;
            }

            function calculateGroundTime(prevArr, nextDep) {
                let diffMs = new Date(nextDep) - new Date(prevArr);
                let mins = Math.floor(diffMs / 60000);
                let h = Math.floor(mins / 60);
                let m = mins % 60;
                return `${h}h ${m}m`;
            }


            let fareDataFromAPI = fareFlightDetailsdeparture[0] || [];
            renderFareSummary(fareDataFromAPI, travelerDetails);

            function renderFareSummary(fareData, travelerDetails) {

                let baseFare = fareData?.BaseFare || 0;
                let tax = fareData?.Tax || 0;

                // SSR Calculation
                let seatTotal = 0,
                    mealTotal = 0,
                    baggageTotal = 0;

                $.each(travelerDetails, function(i) {

                    let ssr = getPassengerSSR(i);

                    if (ssr?.seatDataFull) {
                        seatTotal += ssr.seatDataFull.Price || 0;
                    }

                    if (ssr?.mealObjData) {
                        mealTotal += ssr.mealObjData.Price || 0;
                    }

                    if (ssr?.baggage?.bagObjData) {
                        baggageTotal += ssr.baggage.bagObjData.Price || 0;
                    }
                });

                let ssrTotal = seatTotal + mealTotal + baggageTotal;
                let grandTotal = baseFare + tax + ssrTotal;

                // 🔥 HTML
                let html = `
                        <div class="card rounded-3 shadow-sm">
                            
                            <div class="card-header d-flex justify-content-between align-items-center bg-white">
                                <h5 class="card-title mb-0">Fare Summary</h5>
                            ${selectedFlightDetails.IsRefundable ? '<span class="badge bg-success">Refundable</span>' : '<span class="badge bg-danger">Non-Refundable</span>'}
                            </div>

                            <div class="card-body">

                                <table class="table border border-muted rounded  mb-0">
                                    <tbody>

                                        <tr>
                                            <td class="text-muted">Base Fare</td>
                                            <td class="text-end">₹${baseFare}</td>
                                        </tr>

                                        <tr>
                                            <td class="text-muted">Tax & Charges</td>
                                            <td class="text-end">₹${tax}</td>
                                        </tr>

                                        <tr>
                                            <td class="text-muted">Discount</td>
                                            <td class="text-end text-success">₹0</td>
                                       </tr>
                                        <tr>
                                            <td class="text-muted">Seat</td>
                                            <td class="text-end text-success">₹${seatTotal}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Meal</td>
                                            <td class="text-end text-success">₹${mealTotal}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Baggage</td>
                                            <td class="text-end text-success">₹${baggageTotal}</td>
                                        </tr>

                                    </tbody>
                                </table>

                            </div>

                            <div class="card-footer bg-white border-top pt-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-semibold">SSR Total</span>
                                    <span class="fw-bold text-success">₹${ssrTotal}</span>
                                </div>
                                <hr class="mt-2 mb-2" />

                                 <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-semibold fs-5">Grand Total</span>
                                    <span class="fw-bold text-success fs-5">₹${grandTotal}</span>
                                </div>
                            </div>

                        </div>
                        `;

                // Inject
                $('#farebreakdowntotal').html(html);
            }

            function displayPassengerDetails() {
                if (!travelerDetails || travelerDetails.length === 0) return;
                let html = '<div class="row g-3">';

                travelerDetails.forEach((passenger, index) => {
                    const isFirstPassenger = index === 0;

                    html += `<div class="col-md-12 pb-3">
                        <div class="card border-light h-100 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="bi bi-person-badge me-2"></i>Passenger ${index + 1} ${isFirstPassenger ? '<span class="badge bg-primary ms-2">Lead Passenger</span>' : ''}</h6>
                            </div>
                            <div class="card-body row g-2 mt-2">
                                <div class="col-md-4">
                                    <small class="text-muted">Name</small>
                                    <p class="mb-0"><strong>${passenger?.title || ''} ${passenger?.firstName || ''} ${passenger?.lastName || ''}</strong></p>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">Type</small>
                                    <p class="mb-0"><span class="badge bg-info">${passenger?.type || 'Adult'}</span></p>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">Date of Birth</small>
                                    <p class="mb-0">${passenger?.dob || 'N/A'}</p>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">Gender</small>
                                    <p class="mb-0">${passenger?.gender === '1' ? '👨 Male' : passenger?.gender === '2' ? '👩 Female' : 'Other'}
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">Nationality</small>
                                    <p class="mb-0"><strong>${passenger?.nationality || 'N/A'}</strong></p>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">Address</small>
                                    <p class="mb-0"><strong>${passenger?.address1 || 'N/A'} ${passenger?.address2 || 'N/A'} ${passenger?.city || 'N/A'}</strong></p>
                                </div>`;

                    // Add contact details to first passenger
                    if (isFirstPassenger && contactDetails) {
                        html += `
                                        <hr class="my-2">
                                        <div class="mb-3">
                                            <small class="text-muted">
                                                <i class="bi bi-telephone me-1"></i>Contact Details
                                            </small>

                                            <div class="mt-2">
                                                <table class="table table-sm table-bordered mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <th style="width: 120px;" class="fw-bold">Email📩</th>
                                                            <td>${contactDetails?.email || 'N/A'}</td>
                                                            <th class="fw-bold">Mobile📱</th>
                                                            <td>+91 ${contactDetails?.mobile || 'N/A'}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>`;
                    }

                    // Add SSR details for each passenger
                    const passengerSSR = getPassengerSSR(index);
                    const passengerSSRRet = getPassengerSSRReturn(index);
                    if (passengerSSR && Object.keys(passengerSSR).length > 0) {
                        const seat = passengerSSR.seatDataFull || {};
                        const bag = passengerSSR.baggage?.bagObjData || {};
                        const meal = passengerSSR.mealObjData || {};
                        html += `
                            <div class="">
                                <small class="text-muted">
                                    <i class="bi bi-gear me-1"></i>Special Services
                                </small>

                                <div class="mt-2">
                                    <table class="table table-sm table-bordered mb-0">
                                        <tbody>

                                            <tr>
                                                <th style="width:180px;">Airline</th>
                                                <td>${seat.AirlineCode || bag.AirlineCode || '-'} / ${seat.FlightNumber || bag.FlightNumber || '-'}
                                                    ( ${seat.Origin || bag.Origin || '-'} → ${seat.Destination || bag.Destination || '-'} )</td>
                                            </tr>

                                            ${passengerSSR.seatDataFull ? `
                                                        <tr>
                                                            <th>Seat</th>
                                                            <td>${seat.RowNo}${seat.SeatNo} (${getSeatType(seat.SeatType)}) - ₹${seat.Price}</td>
                                                        </tr>` : ''}

                                            ${passengerSSR.meal ? `
                                                        <tr>
                                                            <th>Meal</th>
                                                            <td>${passengerSSR.meal}</td>
                                                        </tr>` : ''}

                                            ${passengerSSR.baggage ? `
                                                        <tr>
                                                            <th>Baggage</th>
                                                            <td>
                                                                ${bag.Text || ''} (${bag.Weight}KG) - ₹${bag.Price}
                                                            </td>
                                                        </tr>` : ''}

                                        </tbody>
                                    </table>
                                </div>
                            </div>`;
                    }

                     if (passengerSSRRet && Object.keys(passengerSSRRet).length > 0) {
                        const seat = passengerSSRRet.seatDataFull || {};
                        const bag = passengerSSRRet.baggage?.bagObjData || {};
                        const meal = passengerSSRRet.mealObjData || {};
                        html += `
                            <div class="">
                                <small class="text-muted">
                                    <i class="bi bi-gear me-1"></i>Special Services
                                </small>

                                <div class="mt-2">
                                    <table class="table table-sm table-bordered mb-0">
                                        <tbody>

                                            <tr>
                                                <th style="width:180px;">Airline</th>
                                                <td>${seat.AirlineCode || bag.AirlineCode || '-'} / ${seat.FlightNumber || bag.FlightNumber || '-'}
                                                    ( ${seat.Origin || bag.Origin || '-'} → ${seat.Destination || bag.Destination || '-'} )</td>
                                            </tr>

                                            ${passengerSSRRet.seatDataFull ? `
                                                        <tr>
                                                            <th>Seat</th>
                                                            <td>${seat.RowNo}${seat.SeatNo} (${getSeatType(seat.SeatType)}) - ₹${seat.Price}</td>
                                                        </tr>` : ''}

                                            ${passengerSSRRet.meal ? `
                                                        <tr>
                                                            <th>Meal</th>
                                                            <td>${passengerSSRRet.meal}</td>
                                                        </tr>` : ''}

                                            ${passengerSSRRet.baggage ? `
                                                        <tr>
                                                            <th>Baggage</th>
                                                            <td>
                                                                ${bag.Text || ''} (${bag.Weight}KG) - ₹${bag.Price}
                                                            </td>
                                                        </tr>` : ''}

                                        </tbody>
                                    </table>
                                </div>
                            </div>`;
                    }
                   

                    html += '</div></div></div>';
                });

                html += '</div>';
                document.getElementById('travelerList').innerHTML = html;
            }

            function getSeatType(type) {
                const map = {
                    1: 'Window',
                    2: 'Middle',
                    3: 'Aisle'
                };
                return map[type] || 'Standard';
            }

            function getSeatWayType(type) {
                const map = {
                    1: 'Left',
                    2: 'Right',
                    3: 'Center'
                };
                return map[type] || '-';
            }

            function getAvailability(type) {
                const map = {
                    1: '<span class="badge bg-success">Available</span>',
                    2: '<span class="badge bg-danger">Blocked</span>'
                };
                return map[type] || '-';
            }

            function getPassengerSSR(passengerIndex) {
                const ssr = {};

                // Check for selected seat
                if (selectedSeats && selectedSeats[0].length > passengerIndex) {
                    const seat = selectedSeats[0][passengerIndex];

                    if (seat && seat.SeatObjData) {
                        ssr.seatDataFull = seat.SeatObjData;
                    }
                }

                // Check for selected meal
                if (selectedMeals && selectedMeals.length > passengerIndex) {
                    const meal = selectedMeals[passengerIndex];
                    if (meal) ssr.meal = meal
                }

                // Check for selected baggage
                if (selectedBaggage && selectedBaggage.length > passengerIndex) {
                    const baggage = selectedBaggage[passengerIndex];
                    if (baggage) ssr.baggage = baggage
                }

                return ssr;
            }
            function getPassengerSSRReturn(passengerIndex) {
                const ssrRet = {};

                // Check for selected seat
                if (selectedSeatsRet && selectedSeatsRet[0].length > passengerIndex) {
                    const seat = selectedSeatsRet[0][passengerIndex];

                    if (seat && seat.SeatObjData) {
                        ssrRet.seatDataFull = seat.SeatObjData;
                    }
                }

                // Check for selected meal
                if (selectedMeals && selectedMeals.length > passengerIndex) {
                    const meal = selectedMeals[passengerIndex];
                    if (meal) ssrRet.meal = meal
                }

                // Check for selected baggage
                if (selectedBaggage && selectedBaggage.length > passengerIndex) {
                    const baggage = selectedBaggage[passengerIndex];
                    if (baggage) ssrRet.baggage = baggage
                }

                return ssrRet;
            }
        });
    </script>
@endpush
