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
                                <button id="confirmPassengers" type="button" class="btn btn-primary mb-0">
                                    Proceed To Bus Block
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

    <script src="{{ asset('') }}js/busbbooking.js"></script>
    <script>
        $(document).ready(function() {
            const payload = JSON.parse(localStorage.getItem('payload'));
            const traceId = localStorage.getItem('TraceId') || '';
            let selectedBusDetails = JSON.parse(localStorage.getItem('selectedBusDetails'));
            let selectedBoardingPointDetails = JSON.parse(localStorage.getItem('selectedBoardingPointDet'));
            let selectedDroppingPointDetails = JSON.parse(localStorage.getItem('selectedDroppingPointDet'));
            let travelerDetails = JSON.parse(localStorage.getItem('passengerDetails'));

            displayBusDetails();
            renderBusFareSummary();
            displayPassengerDetails();

            function displayBusDetails() {

                let html = '';

                if (selectedBusDetails) {

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
                                    <h5 class="mb-0">
                                        🚌 ${selectedBoardingPointDetails?.CityPointLocation || 'Boarding'} 
                                        → 
                                        ${selectedDroppingPointDetails?.CityPointLocation || 'Dropping'}
                                    </h5>

                                    <small class="text-muted">
                                        ${fmtDate(selectedBusDetails?.DepartureTime)} | 
                                        ${selectedBusDetails?.BusType || ''}
                                    </small>
                                </div>

                                <span class="badge bg-warning text-white">Bus</span>
                            </div>

                            <div class="card-body p-3">

                                <div class="row g-4 align-items-center">

                                    <div class="col-md-4">
                                        <h5 class="mb-0">Departure</h5>
                                        <p class="mb-1 fw-bold">${fmtTime(selectedBoardingPointDetails?.CityPointTime)}</p>
                                        <p class="mb-1 small text-muted">${fmtDate(selectedBoardingPointDetails?.CityPointTime)}</p>
                                        <p class="mb-0">${selectedBoardingPointDetails?.CityPointLocation}</p>
                                    </div>

                                    <div class="col-md-4 text-center">
                                        <p class="mb-1">${selectedBusDetails?.TravelName}</p>
                                        <h6 class="mb-1">${selectedBusDetails?.BusType}</h6>

                                        <div class="position-relative my-4">
                                            <hr class="mt-2 mb-2"/>
                                            <div class="badge bg-light text-dark position-absolute top-50 start-50 translate-middle p-2">
                                                🚌
                                            </div>
                                        </div>

                                        <small class="text-success mt-2">
                                            Seats Available: ${selectedBusDetails?.AvailableSeats}
                                        </small>
                                    </div>

                                    <div class="col-md-4 text-end">
                                        <h5 class="mb-0">Arrival</h5>
                                        <p class="mb-1 fw-bold">${fmtTime(selectedDroppingPointDetails?.CityPointTime)}</p>
                                        <p class="mb-1 small text-muted">${fmtDate(selectedDroppingPointDetails?.CityPointTime)}</p>
                                        <p class="mb-0">${selectedDroppingPointDetails?.CityPointLocation}</p>
                                    </div>

                                </div>

                                <hr/>

                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <small class="text-muted">Operator</small>
                                        <p class="mb-0 fw-bold">${selectedBusDetails?.TravelName}</p>
                                    </div>

                                    <div class="col-md-4 text-center">
                                        <small class="text-muted">Route ID</small>
                                        <p class="mb-0">${selectedBusDetails?.RouteId}</p>
                                    </div>

                                    <div class="col-md-4 text-end">
                                        <small class="text-muted">Live Tracking</small>
                                        <p class="mb-0">
                                            ${selectedBusDetails?.LiveTrackingAvailable ? '✅ Available' : '❌ Not Available'}
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    `;
                }

                $('#flightDetailsSection').html(html);
            }

            function renderBusFareSummary() {

                let fare = selectedBusDetails?.BusPrice || {};

                let baseFare = fare?.BasePrice || 0;
                let tax = fare?.Tax || 0;
                let other = fare?.OtherCharges || 0;
                let discount = fare?.Discount || 0;

                let seatTotal = 0;

                $.each(travelerDetails, function(i) {
                    if (travelerDetails[i]) {
                        seatTotal += parseFloat(travelerDetails[i]?.Seat?.Price?.BasePrice) || 0;
                    }
                });

                let grandTotal = parseFloat(baseFare) + parseFloat(tax) + parseFloat(seatTotal);

                let total = parseFloat(fare?.PublishedPrice) || (parseFloat(baseFare) + parseFloat(tax) + parseFloat(other) - parseFloat(discount));

                let html = `
                    <div class="card shadow-sm">

                        <div class="card-header bg-light">
                            <h5 class="mb-0">Fare Summary</h5>
                        </div>

                        <div class="card-body">

                            <table class="table mb-0">
                                <tr>
                                    <td>Base Fare</td>
                                    <td class="text-end">₹${baseFare}</td>
                                </tr>
                                <tr>
                                    <td>Tax</td>
                                    <td class="text-end">₹${tax}</td>
                                </tr>
                                <tr>
                                    <td>Other Charges</td>
                                    <td class="text-end">₹${other}</td>
                                </tr>
                                <tr>
                                    <td>Discount</td>
                                    <td class="text-end text-success">₹${discount}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted fw-bold">Seat Price</td>
                                    <td class="text-end text-success">₹${seatTotal}</td>
                                </tr>
                            </table>

                        </div>

                        <div class="card-footer d-flex justify-content-between">
                            <strong>Grand Total</strong>
                            <strong class="text-success">₹${seatTotal}</strong>
                        </div>

                    </div>
                `;

                $('#farebreakdowntotal').html(html);
            }

            function displayPassengerDetails() {
                if (!travelerDetails || travelerDetails.length === 0) return;

                let html = '<div class="row g-3">';

                travelerDetails.forEach((passenger, index) => {
                    const isFirstPassenger = index === 0;

                    console.log('Passenger:', passenger);

                    html += `<div class="col-md-12 pb-3">
                        <div class="card border-light h-100 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="bi bi-person-badge me-2"></i>Passenger ${index + 1} ${passenger?.LeadPassenger ? '<span class="badge bg-primary ms-2">Lead Passenger</span>' : ''}</h6>
                            </div>
                            <div class="card-body row g-2 mt-2">
                                <div class="col-md-4">
                                    <small class="text-muted">Name</small>
                                    <p class="mb-0"><strong>${passenger?.Title || ''} ${passenger?.FirstName || ''} ${passenger?.LastName || ''}</strong></p>
                                </div>
                               
                                <div class="col-md-2">
                                    <small class="text-muted">Age</small>
                                    <p class="mb-0">${passenger?.Age || 'N/A'}</p>
                                </div>
                                <div class="col-md-3">
                                    <small class="text-muted">Gender</small>
                                    <p class="mb-0">${passenger?.Gender == 1 ? '👨 Male' : passenger?.Gender === 2 ? '👩 Female' : 'Other'}</p>
                                </div>
                                <div class="col-md-3">
                                    <small class="text-muted">Address</small>
                                    <p class="mb-0"><strong>${passenger?.Address || 'N/A'}</strong></p>
                                </div>`;

                    // Add contact details to first passenger
                    if (isFirstPassenger) {
                        html += `<hr class="my-2">
                            <div class="mb-3">
                                <small class="text-muted">
                                    <i class="bi bi-telephone me-1"></i>Contact Details
                                </small>

                                <div class="mt-2">
                                    <table class="table table-sm table-bordered mb-0">
                                        <tbody>
                                            <tr>
                                                <th style="width: 120px;" class="fw-bold">Email</th>
                                                <td>${passenger?.Email || 'N/A'}</td>
                                                <th class="fw-bold">Mobile</th>
                                                <td>+91${passenger?.Phoneno || 'N/A'}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>`;
                    }

                    if (passenger?.Seat && Object.keys(passenger.Seat).length > 0) {

                        const seat = passenger.Seat;

                        html += `
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="bi bi-bus-front me-1"></i>Seat Details
                                </small>

                                <div class="mt-2">
                                    <table class="table table-sm table-bordered mb-0">
                                        <tbody>

                                            <tr>
                                                <th style="width:180px;">Seat No</th>
                                                <td>${seat.RowNo}-${seat.ColumnNo}</td>
                                            </tr>

                                            <tr>
                                                <th>Seat Type</th>
                                                <td>
                                                    ${seat.IsUpper ? 'Upper' : 'Lower'} 
                                                    ${seat.IsLadiesSeat ? '(Ladies)' : ''}
                                                    ${seat.IsMalesSeat ? '(Males)' : ''}
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Seat Name</th>
                                                <td>
                                                    ${getSeatPosition(seat)}
                                                   (${seat.SeatName || ''})
                                                    ${seat.SeatStatus ? '<span class="badge bg-success">Available</span>' : '<span class="badge bg-danger">Not-Available</span>'}
                                                    ${seat.IsMalesSeat ? '(Males)' : ''}
                                                    </td>
                                            </tr>

                                            <tr>
                                                <th>Fare</th>
                                                <td>${seat.Price?.Currency ? 'INR' : '₹'}${seat.Price?.BasePrice || 0} </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        `;
                    }

                    html += '</div></div></div>';
                });

                html += '</div>';
                document.getElementById('travelerList').innerHTML = html;
            }


            function getSeatPosition(seat) {

                if (seat.IsUpper) return 'Upper Deck';
                if (seat.IsMalesSeat) return 'Male Reserved';
                if (seat.IsLadiesSeat) return 'Ladies Reserved';

                return 'General';
            }

            function getSeatType(type) {
                switch (type) {
                    case '1':
                        return 'Window';
                    case '2':
                        return 'Aisle';
                    case '3':
                        return 'Middle';
                    default:
                        return 'Unknown';
                }
            }
        });
    </script>
@endpush
