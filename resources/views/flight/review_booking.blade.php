@extends('layouts.app')
@section('title', 'Booking Page')
@section('pagetitle', 'Booking Page')

@section('content')
    <main>
        <section>

            <div id="bookingData">

                <div class="row g-4 g-xl-5">
                    <!-- Left Content START -->
                    <div class="col-xl-8">
                        <div class="card border" id="bookingSummaryCard">
                            <div class="card-header d-flex justify-content-between align-items-center border-bottom">
                                <h5 class="mb-0 card-title">Your Booking Details🔖</h5>


                                <button class="btn btn-primary" id="proceedBookingBtn">
                                    Proceed to Booking
                                </button>
                            </div>


                            <!-- Card body -->
                            <div class="card-body mt-2">
                                <!-- Flight Details Section -->
                                <div class="mb-4" id="flightDetailsSection"></div>

                                <!-- Journey Details -->
                                <div id="segmentList"></div>

                                <!-- Traveler Detail Section -->
                                <div class="mt-4">
                                    <h6 class="mb-3"><i class="bi bi-person-circle me-2"></i><strong>Traveler
                                            Details</strong></h6>
                                    <div id="travelerList"></div>
                                </div>

                                <!-- Important Notes -->
                                <div class="alert alert-info mt-4" role="alert">
                                    <small>
                                        <i class="bi bi-info-circle me-2"></i>
                                        Please ensure all passenger details are correct before proceeding with the booking.
                                    </small>
                                </div>
                            </div>

                            <!-- Card footer -->

                        </div>

                    </div>
                    <!-- Left Content END -->

                    <!-- Right content START -->
                    <aside class="col-xl-4">
                        <div class=" sticky-top">
                            <div class="row g-4">
                                <!-- Fare summary START -->
                                <div class="col-md-6 col-xl-12">
                                    <div class="card border rounded-3" id="farebreakdowntotal">

                                    </div>
                                </div>
                                <!-- Fare summary END -->
                            </div>
                            <div class="card card-body border p-2 mt-3 cursor-pointer text-center" data-bs-toggle="modal"
                                data-bs-target="#ruleFaredeparture">
                                <div class="card-title pt-2">
                                    <h5 class="mb-0"><i class="ti ti-eye"></i> Fare Rules</h5>
                                </div>
                            </div>
                        </div>
                    </aside>



                </div>
            </div>
        </section>

        <div id="fareRuleListModal"></div>

    </main>

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
@endsection


@push('script')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf417-js/2.1.7/pdf417.min.js"></script> --}}
    <script src="https://unpkg.com/bwip-js/dist/bwip-js-min.js"></script>

    <script src="{{ asset('') }}js/boookflighttriping.js"></script>
    <script>
        $(document).ready(function() {
            const payload = JSON.parse(localStorage.getItem('payload'));
            const traceId = localStorage.getItem('TraceId') || '';
            let selectedFlightDetails = JSON.parse(localStorage.getItem('selectedFlightDetails'));
            let selectedSeats = JSON.parse(localStorage.getItem('selectedSeat')) || [];
            let selectedMeals = JSON.parse(localStorage.getItem('selectedmeal')) || [];
            let selectedBaggage = JSON.parse(localStorage.getItem('selectedBaggage')) || [];
            let travelerDetails = JSON.parse(localStorage.getItem('travelerDetails')) || [];
            let contactDetails = JSON.parse(localStorage.getItem('contactDetails'));
            let fareFlightDetailsdeparture = JSON.parse(localStorage.getItem('fareFlightDetailsdeparture')) || [];
            let fareFlightDetailsreturn = JSON.parse(localStorage.getItem('fareFlightDetailsreturn')) || [];
            let fareRules = JSON.parse(localStorage.getItem('fareRulesdeparture')) || [];

            let isInternational = localStorage.getItem("isInternational") || false;

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

            displayFlightDetails();
            displayPassengerDetails();
            displayContactInfo();

            function displayFlightDetails() {
                let html = '';

                // Get first segment for departure and last segment for arrival info
                if (selectedFlightDetails && selectedFlightDetails.Segments && selectedFlightDetails.Segments[0]) {
                    const segments = selectedFlightDetails.Segments[0];
                    const firstSeg = segments[0];
                    const lastSeg = segments[segments.length - 1];

                    const fmtTime = (t) => new Date(t).toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    const fmtDate = (t) => new Date(t).toLocaleDateString('en-IN', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    });

                    html += `
                        <div class="card border-0 mb-3">
                            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-0">${firstSeg?.Origin?.Airport?.CityName} (${firstSeg?.Origin?.Airport?.AirportCode}) → ${lastSeg?.Destination?.Airport?.CityName} (${lastSeg?.Destination?.Airport?.AirportCode})</h5>
                                    <small class="text-muted">${fmtDate(segments[0]?.Origin?.DepTime)} | ${segments.length - 1 != 0 ? segments.length - 1 + ' Stop' : 'Non Stop'}</small>
                                </div>
                                <span class="badge bg-warning text-white">departure</span>
                            </div>
                            <div class="card-body p-3">
                                <div class="mb-2"><strong>Travel Class:</strong> ${segments[0]?.CabinClass == 2 ? 'Economy' : segments[0]?.CabinClass == 3 ? 'Premium Economy' : 'Business'}</div>
                    `;

                    for (let i = 0; i < segments.length; i++) {
                        let s = segments[i];
                        html += `
                            <div class="row g-4 align-items-center py-2">
                                <div class="col-md-4">
                                    <h5 class="mb-0">${s?.Origin?.Airport?.AirportCode}</h5>
                                    <p class="mb-1 fw-bold">${fmtTime(s?.Origin?.DepTime)}</p>
                                    <p class="mb-1 small text-muted">${fmtDate(s?.Origin?.DepTime)}</p>
                                    <p class="mb-1">${s?.Origin?.Airport?.CityName}</p>
                                    <p class="mb-0 small text-muted">Terminal: ${s?.Origin?.Airport?.Terminal || 'N/A'}</p>
                                </div>
                                <div class="col-md-4 text-center">
                                    <p class="mb-1">${s?.Airline?.AirlineName} (${s?.Airline?.AirlineCode}-${s?.Airline?.FlightNumber})</p>
                                    <h5 class="mb-1">${formatDuration(s?.Duration)}</h5>
                                    <div class="position-relative mt-3">
                                        <hr class="mt-2 mb-2" />
                                        <div class="badge bg-light rounded-pill text-white position-absolute top-50 start-50 translate-middle p-2"><i class="fa-solid fa-plane"></i></div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-end">
                                    <h5 class="mb-0">${s?.Destination?.Airport?.AirportCode}</h5>
                                    <p class="mb-1 fw-bold">${fmtTime(s?.Destination?.ArrTime)}</p>
                                    <p class="mb-1 small text-muted">${fmtDate(s?.Destination?.ArrTime)}</p>
                                    <p class="mb-1">${s?.Destination?.Airport?.CityName}</p>
                                    <p class="mb-0 small text-muted">Terminal: ${s?.Destination?.Airport?.Terminal || 'N/A'}</p>
                                </div>
                            </div>
                        `;

                        if (i < segments.length - 1) {
                            let groundTime = calculateGroundTime(
                                s?.Destination?.ArrTime,
                                segments[i + 1]?.Origin?.DepTime
                            );

                            html += `
                                <div class="bg-light text-center text-danger py-2 mt-2 mb-2 rounded">Ground Time at ${s?.Destination?.Airport?.CityName}: ${groundTime}</div>
                            `;
                        }
                    }

                    html += `</div></div>`;
                }

                document.getElementById('flightDetailsSection').innerHTML = html;
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

                                                        <!-- COMMON DETAILS (ONLY ONCE) -->
                                                        <tr>
                                                            <th style="width:180px;">Airline</th>
                                                            <td>${seat.AirlineCode || bag.AirlineCode || '-'}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Flight</th>
                                                            <td>${seat.FlightNumber || bag.FlightNumber || '-'}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Route</th>
                                                            <td>${seat.Origin || bag.Origin || '-'} → ${seat.Destination || bag.Destination || '-'}</td>
                                                        </tr>

                                                        <!-- SEAT -->
                                                        ${passengerSSR.seatDataFull ? `
                                                                                                                                <tr>
                                                                                                                                    <th>Seat</th>
                                                                                                                                    <td>${seat.RowNo}${seat.SeatNo} (${getSeatType(seat.SeatType)}) - ₹${seat.Price}</td>
                                                                                                                                </tr>` : ''}

                                                        <!-- MEAL -->
                                                        ${passengerSSR.meal ? `
                                                                                                                                <tr>
                                                                                                                                    <th>Meal</th>
                                                                                                                                    <td>${passengerSSR.meal}</td>
                                                                                                                                </tr>` : ''}

                                                        <!-- BAGGAGE -->
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

            function displayContactInfo() {
                // Contact details are now shown in the first passenger's card
                // This function is kept for compatibility but doesn't display separate contact info
            }
        });
    </script>
@endpush
