let selectedBusId = null;
let selectedSeats = [];
let selectedBoardingId = null;
let selectedDroppingId = null;
let maxSeatsAllowed = 1;
let isDropMandatory = true;
let isIdProofRequired = false;


$('#busSearchForm').on('submit', function (e) {

    e.preventDefault();

    let payload = {};

    payload.DepartureId = $('#DepartureId').val();
    payload.DestinationId = $('#DestinationId').val();
    payload.JourneyDate = $('#JourneyDate').val();
    payload.ReturnJourneyDate = $('#ReturnJourneyDate').val();
    payload.Currency = $('#Currency').val();
    payload.BookingMode = $('#BookingMode').val();
    payload._token = $('input[name="_token"]').val();

    $.ajax({
        url: "/bus/search",
        method: "POST",
        data: payload,
        beforeSend: function () {

            localStorage.removeItem("TraceId");
            localStorage.removeItem("ResultIndex");
            $('#busSearchForm').find('button[type="submit"]').html('Please Wait...').attr('disabled', true);
        },
        complete: function () {
            $('#busSearchForm').find('button[type="submit"]').html('Search Buses<i class="ti ti-arrow-right"></i>').attr('disabled', false);
        },
        success: function (response) {
            $('#busContainerList').addClass('d-none');
            $('#busResults').html('');
            localStorage.setItem("payload", JSON.stringify(payload) || {});

            if (response.status == 'success') {
                $('#busContainerList').removeClass('d-none');

                notify("✅ Bus search completed successfully.", "success");
                let results = response.data.Results || [];
                if (results.length == 0) {
                    notify("❌ No Bus found for selected route.", "error");
                    return;
                }
                localStorage.setItem("TraceId", response?.data?.TraceId || '');
                let html = '';

                results.forEach(function (bus) {
                    // let boarding = bus.BoardingPointsDetails.map(bp => bp.CityPointName).join(', ');
                    // let dropping = bus.DroppingPointsDetails.map(dp => dp.CityPointName).join(', ');

                    html += `
                        <div class="card border mb-3">
                            <div class="card-header d-flex justify-content-between">
                                <div class="d-flex align-items-center">
                                    <h4 class="fw-normal mb-0">🚌  ${bus.TravelName} (${bus.ServiceName})</h4>
                                </div>
                                <h6 class="fw-normal mb-0">${bus.BusType}</h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4 align-items-center">
                                    <div class="col-md-9">
                                        <div class="row g-4">
                                            <div class="col-sm-4">
                                                <h4>${formatTime(bus.DepartureTime)}</h4>
                                                <h6 class="fw-normal mb-0">${formatDate(bus.DepartureTime)}</h6>
                                                <p>${bus.Origin ? bus.Origin : ''}</p>
                                            </div>
                                            <div class="col-sm-4 text-center">
                                                <h5>${calculateDuration(bus.DepartureTime, bus.ArrivalTime)}</h5>
                                                <div class="position-relative my-4">
                                                    <hr class="bg-primary opacity-5 position-relative">
                                                    <div class="icon-md bg-primary text-white rounded-circle position-absolute top-50 start-50 translate-middle p-2">
                                                        <i class="fa-solid fa-fw fa-bus rtl-flip"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <h4>${formatTime(bus.ArrivalTime)}</h4>
                                                <h6 class="fw-normal mb-0">${formatDate(bus.ArrivalTime)}</h6>
                                                <p>${bus.Destination ? bus.Destination : ''}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-md-end">
                                        <h4 class="text-success">₹${bus.BusPrice.PublishedPriceRoundedOff}</h4>
                                        <button class="btn btn-dark btn-sm mb-0 view-details" data-bs-toggle="modal" data-bs-target="#busdetail" data-busresultindex="${bus.ResultIndex}"
                                            data-businfo="${encodeURIComponent(JSON.stringify(bus))}">View Details</button>
                                    </div>
                                </div>                               
                            </div>

                             <div class="card-footer">
                                <ul class="list-inline bg-light d-sm-flex justify-content-sm-between text-center rounded-2 py-2 px-4 mb-0">
                                    <li class="list-inline-item text-danger">Only ${bus.AvailableSeats} Seat Left</li> |
                                    <li class="list-inline-item">👤
                                        ${bus.IdProofRequired ? '<span class="text-success">Id Proof Required</span>' : '<span class="text-danger">Id Proof Not Required</span>'}
                                    </li> |
                                    <li class="list-inline-item">📍
                                        ${bus.LiveTrackingAvailable ? '<span class="text-success">Live Tracking Available</span>' : '<span class="text-danger">No Live Tracking</span>'}
                                    </li>
                                </ul>
                                
                            </div>
                        </div>`;
                });
                $('#busResults').append(html);
            } else {
                notify(response.message, "error");
            }
        },
        error: function (xhr) {
            notify("Search failed. Please try again.", "error");
        }
    });
});

function formatTime(dateStr) {
    let dt = new Date(dateStr);
    return dt.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
}
function formatDate(dateStr) {
    let dt = new Date(dateStr);
    return dt.toLocaleDateString([], { day: '2-digit', month: 'short', year: 'numeric' });
}
function calculateDuration(dep, arr) {
    let start = new Date(dep);
    let end = new Date(arr);
    let diff = (end - start) / 60000; // minutes
    let h = Math.floor(diff / 60);
    let m = diff % 60;
    return `${h}h ${m}m`;
}

$(document).on("click", ".view-details", function () {
    selectedBusId = $(this).data('busresultindex');
    let busInfo = JSON.parse(
        decodeURIComponent($(this).attr("data-businfo"))
    );
    localStorage.setItem("selectedBusDetails", JSON.stringify(busInfo));

    let infohtml = "";
    let policyhtml = "";
    let farehtml = "";

    infohtml += `
        <div class="card border">
            <div class="card-header d-flex align-items-center border-bottom">
               
                <h5 class="card-title mb-0"> 🚌 ${busInfo.TravelName} (${busInfo.ServiceName}) <small>(Bus Type : ${busInfo.BusType})</small><br/>
                 <small>Max ${busInfo.MaxSeatsPerTicket} Seat Allowed </small> 
                 | ${busInfo?.PartialCancellationAllowed ? '<small class="text-success">Partial Cancellation Allowed</small>' : '<small class="text-danger">Partial Cancellation Not Allowed</small>'}
                 | ${busInfo?.IsDropPointMandatory ? '<small class="text-success">Droping Point Mandatory</small>' : '<small class="text-danger">Droping Point Not Mandatory</small>'}</h5>
            </div>
            <div class="card-body mt-3">
                <div class="table-responsive-lg">
                    <div class="row">

                        <div class="col-md-6 border-end">
                           <div class="py-2 fw-semibold">
                                🚏 Boarding Point
                            </div>
                            <div class="mt-2 boarding-list">
                                ${busInfo.BoardingPointsDetails?.length
            ? busInfo.BoardingPointsDetails.map((bp, i) => `
                                        <div class="form-check border rounded p-2 mb-2">
                                           
                                            
                                            <label class="form-check-label w-100" for="boarding_${i}">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <strong>${bp.CityPointName}</strong><br>
                                                        <small class="text-muted">${bp.CityPointLocation}</small><br/>
                                                        <span>
                                                            ${formatDateTime(bp.CityPointTime)}
                                                        </span>
                                                    </div>
                                                   
                                                </div>
                                            </label>
                                        </div>
                                    `).join('')
            : '<span class="text-muted">No boarding points available</span>'
        }
                            </div>
                        </div>

                        <div class="col-md-6 border-start">
                            <div class="py-2 fw-semibold">
                                🚏 Dropping Point
                            </div>
                            <div class="mt-2 boarding-list">
                                ${busInfo.DroppingPointsDetails?.length
            ? busInfo.DroppingPointsDetails.map((dp, i) => `
                                        <div class="form-check border rounded p-2 mb-2">
                                           
                                            
                                            <label class="form-check-label w-100" for="dropping_${i}">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <strong>${dp.CityPointName}</strong><br>
                                                        <small class="text-muted">${dp.CityPointLocation}</small>
                                                        <br/>
                                                        <span>
                                                            ${formatDateTime(dp.CityPointTime)}
                                                        </span>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    `).join('')
            : '<span class="text-muted">No dropping points available</span>'
        }
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>`;

    policyhtml += `<div class="card border mt-3">
            <div class="card-header d-flex align-items-center border-bottom">
                🚌
                <h5 class="card-title mb-0">${busInfo.TravelName} (${busInfo.ServiceName})</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive-lg">
                    <table class="table caption-bottom mb-0 mt-2">
                        <caption class="pb-0"> *${busInfo.BusType}</caption>
                        
                       <thead class="table-light">
                            <tr>
                                <th>Cancellation Time</th>
                                 <th>From</th>
                                <th>To</th>
                                <th>Charges</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            ${busInfo.CancellationPolicies && busInfo.CancellationPolicies.length
            ? busInfo.CancellationPolicies.map(policy => `
                                    <tr>
                                        <td>${policy.PolicyString}</td>
                                         <td>${formatDateTime(policy.FromDate)}</td>
                                        <td>${formatDateTime(policy.ToDate)}</td>
                                        <td>
                                            ${formatCancellationCharge(policy)}
                                        </td>
                                    </tr>
                                `).join('')
            : `<tr><td colspan="2" class="text-muted text-center">No cancellation policy available</td></tr>`
        }
                        </tbody>
                    </table>
                </div>
            </div>
        </div>`;


    // Fare Information

    farehtml = `
         <div class="card border card-body">
            <div class="table-responsive-lg">
                <table class="table caption-bottom mb-0">
                    <caption class="pb-0">*From The Date Of Departure</caption>
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="border-0 rounded-start">Base Fare</th>
                            <th scope="col" class="border-0">Taxes and Fees</th>
                            <th scope="col" class="border-0">Discount</th>
                            <th scope="col" class="border-0">Other Charges</th>
                            <th scope="col" class="border-0 rounded-end">Total Fees</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>${busInfo?.BusPrice?.CurrencyCode || '₹'} ${busInfo?.BusPrice?.BasePrice || '0.00'}</td>
                            <td>${busInfo?.BusPrice?.CurrencyCode || '₹'} ${busInfo?.BusPrice?.Tax || '0.00'}</td>
                            <td>${busInfo?.BusPrice?.CurrencyCode || '₹'} ${busInfo?.BusPrice?.Discount || '0.00'}</td>
                            <td>${busInfo?.BusPrice?.CurrencyCode || '₹'} ${busInfo?.BusPrice?.OtherCharges || '0.00'}</td>
                            <td><h5 class="mb-0">${busInfo?.BusPrice?.CurrencyCode || '₹'} ${busInfo?.BusPrice?.PublishedPriceRoundedOff || '0.00'}</h5></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>`;

    $("#policy-tab").html(policyhtml);
    $("#info-tab").html(infohtml);
    $("#fare-tab").html(farehtml);

    $('#busDetailFooter').html(` <small class="text-muted">
         ℹ️ Please Proceed to Seat Selection & Boarding Points after reviewing the bus details.
            
        </small>
        <div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary proceed-next">Proceed to Next</button>
    </div>
    `);
});


// BTN Book Now
$(document).on('click', '.proceed-next', function () {
    localStorage.setItem("BusResultIndex", selectedBusId || '');
    window.location.href = "/bus/seatlayout";
});

function formatDateTime(dateStr) {
    if (!dateStr) return '-';
    const d = new Date(dateStr);
    return d.toLocaleString('en-IN', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        hour12: true
    });
}


function formatCancellationCharge(policy) {
    switch (policy.CancellationChargeType) {
        case 1:
            return `₹${policy.CancellationCharge}`;
        case 2:
            return `${policy.CancellationCharge}%`;
        case 3:
            return `${policy.CancellationCharge} Night(s)`;
        default:
            return '-';
    }
}


function getSeatDetails(resultIndex, traceId) {
    $('#seatLayoutContainer').removeClass('d-none');
    $('.preloader').addClass('d-none');
    $.ajax({
        url: '/bus/seatdetails',
        method: 'POST',
        data: {
            ResultIndex: resultIndex,
            TraceId: traceId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            swal.close();
            if (response.status === 'success') {
                renderSeatLayout(response.data);
            } else {
                notify(response.message, 'error');
            }
        },
        error: function () {
            swal.close();
            notify('Failed to fetch seat layout details.', 'error');
        }
    });
}

function getboradingDetails(resultIndex, traceId) {
    $('#seatLayoutContainer').removeClass('d-none');
    $('.preloader').addClass('d-none');
    $.ajax({
        url: '/bus/boardingdetails',
        method: 'POST',
        data: {
            ResultIndex: resultIndex,
            TraceId: traceId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.status === 'success') {
                renderBoardingPoints(response.data);
            } else {
                notify(response.message, 'error');
            }
        },
        error: function () {
            notify('Failed to fetch boarding points details.', 'error');
        }
    });
}



function renderSeatLayout(apiResponse) {

    let bsdet = JSON.parse(localStorage.getItem("selectedBusDetails"));

    maxSeatsAllowed = bsdet.MaxSeatsPerTicket;
    isIdProofRequired = bsdet.IdProofRequired;

    const fareRules = apiResponse.FareRules;
    const rows = fareRules.SeatLayout.SeatDetails;

    // Render single seat
    let renderSeat = (seat) => {
        let seatClass = 'bus-seat';
        let typeText = 'Seat';

        // Determine seat type
        if (seat.SeatType === 2) {
            seatClass += ' sleeper';
            typeText = 'Sleeper';
        } else {
            seatClass += ' regular';
        }

        // Check seat attributes
        if (seat.IsLadiesSeat) {
            seatClass += ' ladies';
        } else if (seat.IsMalesSeat) {
            seatClass += ' male';
        } else if (seat.SeatStatus) {
            seatClass += ' available';
        }

        // Check if booked
        if (!seat.SeatStatus) {
            seatClass += ' booked';
        }

        let fare = typeof seat.SeatFare === 'string' ? seat.SeatFare : seat.SeatFare;

        // clearer labeled tooltip
        let tooltipLines = [];
        tooltipLines.push(`Seat: ${seat.SeatName}`);
        tooltipLines.push(`Type: ${typeText}`);
        if (seat.IsLadiesSeat) tooltipLines.push('Restriction: Ladies Only');
        else if (seat.IsMalesSeat) tooltipLines.push('Restriction: Men Only');
        tooltipLines.push(`Deck: ${seat.IsUpper ? 'Upper' : 'Lower'}`);
        tooltipLines.push(`Status: ${seat.SeatStatus ? 'Available' : 'Booked'}`);
        tooltipLines.push(`Fare: ₹${fare}`);

        let tooltip = tooltipLines.join('\n');

        return `
            <div class="seat-wrapper">
                <div class="seat-container ${seatClass}" 
                     data-seat='${JSON.stringify(seat)}'
                     title="${tooltip}"
                     ${!seat.SeatStatus ? 'disabled' : ''}>
                    <div class="seat-inner">
                        <div class="seat-name">${seat.SeatName}</div>
                        <div class="seat-fare">₹${fare}</div>
                    </div>
                </div>
            </div>
        `;
    };

    // Separate lower and upper deck rows
    let lowerDeckRows = [];
    let upperDeckRows = [];

    rows.forEach((rowSeats) => {
        if (rowSeats.length > 0) {
            if (rowSeats[0].IsUpper) {
                upperDeckRows.push(rowSeats);
            } else {
                lowerDeckRows.push(rowSeats);
            }
        }
    });

    console.log('Lower Deck Rows:', lowerDeckRows, 'Upper Deck Rows:', upperDeckRows);
    // Render rows layout
    let renderRowsLayout = (deckRows, showDriver = false) => {
       
        if (deckRows.length === 0) {
            return '<div class="text-center text-muted p-4">No seats available</div>';
        }

        let driverHTML = '';
        if (showDriver) {
            driverHTML = `
                <div class="driver-section">
                    <div class="driver-area">
                        <div class="steering-wheel">🛞</div>
                        <span class="driver-label">Driver</span>
                    </div>
                </div>
            `;
        }

        let layoutHTML = `
            <div class="bus-wrapper">
                ${driverHTML}
                <div class="rows-container">
        `;

        deckRows.forEach((rowSeats, rowIndex) => {
            layoutHTML += `<div class="row-column">`;

            // After 2 rows add a gap to visually separate sections

            for (let i = 0; i < rowSeats.length; i++) {
                layoutHTML += renderSeat(rowSeats[i]);
            }

            layoutHTML += `</div>`;
        });

        layoutHTML += `
                </div>
            </div>
        `;
        return layoutHTML;
    };

    const lowerHTML = renderRowsLayout(lowerDeckRows, false);
    const upperHTML = renderRowsLayout(upperDeckRows, false);

    $('#seatlayoutdetails').html(`
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light border-bottom py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <strong>🔴Select Seats</strong>
                    </h5>
                    <h5>Total ${fareRules.AvailableSeats} Available | Max ${maxSeatsAllowed} seats per ticket</h5>
                </div>
            </div>
            <div class="card-body p-4">
            
                <!-- Legend -->
                <div class="seat-legend mb-5 p-3 bg-light rounded-3">
                    <div class="row text-center g-3">
                        <div class="col-sm-auto mx-auto">
                            <div class="legend-item">
                                <div class="seat-mini available"></div>
                                <small>Available</small>
                            </div>
                        </div>
                        <div class="col-sm-auto mx-auto">
                            <div class="legend-item">
                                <div class="seat-mini booked"></div>
                                <small>Booked</small>
                            </div>
                        </div>
                        <div class="col-sm-auto mx-auto">
                            <div class="legend-item">
                                <div class="seat-mini selected"></div>
                                <small>Selected</small>
                            </div>
                        </div>
                        <div class="col-sm-auto mx-auto">
                            <div class="legend-item">
                                <div class="seat-mini ladies"></div>
                                <small>Ladies</small>
                            </div>
                        </div>
                        <div class="col-sm-auto mx-auto">
                            <div class="legend-item">
                                <div class="seat-mini male"></div>
                                <small>For Men</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Decks Container -->
                <div class="row g-4">
                    <!-- Lower Deck -->
                    <div class="col-lg-6">
                        <div class="deck-header-row d-flex justify-content-between align-items-center mb-3">
                            <div class="deck-label fw-bold text-primary fs-5">Lower Deck ⬇️</div>
                            <div class="lower-deck-driver">
                                <div class="steering-wheel">🛞</div>
                            </div>
                        </div>
                        <div class="deck-content border rounded p-3 bg-white">
                            ${lowerHTML}
                        </div>
                    </div>

                    <!-- Upper Deck -->
                    <div class="col-lg-6 ">
                        <div class="deck-header-row d-flex justify-content-between align-items-center mb-3">
                            <div class="deck-label fw-bold text-info fs-5">Upper Deck ⬆️</div>
                            <div class="lower-deck-driver ">
                                <div>💺</div>
                            </div>
                        </div>
                        <div class="deck-content border rounded p-3 bg-white">
                            ${upperHTML}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `);

    // Add inline CSS for seat layout
    addSeatLayoutStyles();

}

function renderBoardingPoints(response) {

    let bsdetails = JSON.parse(localStorage.getItem("selectedBusDetails"));

    // isDropMandatory = bsdetails.IsDropPointMandatory;
    isIdProofRequired = bsdetails.IdProofRequired;

    let html = `
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 border-end">
                        <h5>🚏 Boarding Point</h5>
                        <div class="mt-2 boarding-list">
                            ${response.BoardingPointsDetails?.length
            ? response.BoardingPointsDetails.map((bp, i) => `
                                    <div class="form-check border rounded p-2 mb-2 d-flex justify-content-between align-items-center">
                                        <label class="form-check-label w-100" for="boarding_${i}">
                                            <div>
                                                <strong>${bp.CityPointName}</strong><br>
                                                <small class="text-muted">${bp.CityPointLocation}</small><br>
                                                <span>${formatDateTime(bp.CityPointTime)}</span>
                                            </div>
                                        </label>

                                        <input 
                                            class="form-check-input ms-2"
                                            type="radio"
                                            name="boarding_point"
                                            id="boarding_${i}"
                                            value='${JSON.stringify(bp)}'
                                        >
                                    </div>
                                `).join('')
            : '<span class="text-muted">No boarding points available</span>'
        }
                        </div>
                    </div>

                
                    <div class="col-md-6 border-start">
                        <h5>🚏 Dropping Point ${isDropMandatory ? 'Mandatory' : 'Not Mandatory'}</h5>
                        <div class="mt-2 boarding-list">
                            ${response.DroppingPointsDetails?.length
            ? response.DroppingPointsDetails.map((dp, i) => `
                                                        <div class="form-check border rounded p-2 mb-2 d-flex justify-content-between align-items-center">
                                                            <label class="form-check-label w-100" for="dropping_${i}">
                                                                <div>
                                                                    <strong>${dp.CityPointName}</strong><br>
                                                                    <small class="text-muted">${dp.CityPointLocation}</small><br>
                                                                    <span>${formatDateTime(dp.CityPointTime)}</span>
                                                                </div>
                                                            </label>

                                                            <input 
                                                                class="form-check-input ms-2"
                                                                type="radio"
                                                                name="dropping_point"
                                                                id="dropping_${i}"
                                                                value='${JSON.stringify(dp)}'
                                                            >
                                                        </div>
                                                    `).join('')
            : '<span class="text-muted">No dropping points available</span>'
        }
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-footer text-warning">
            ℹ️ Select your preferred boarding and dropping points before proceeding.
            </div>
    `;
    $('#boardingpassdetails').html(html);
}


function validateProceedButton() {

    let seatOk = selectedSeats.length > 0;
    let boardingOk = selectedBoardingId !== null;
    let dropOk = selectedDroppingId !== null;

    if (seatOk && boardingOk && dropOk) {
        $('#proceedBookingBtn').prop('disabled', false);
    } else {
        $('#proceedBookingBtn').prop('disabled', true);
    }
}

$(document).on('click', '.bus-seat:not(.booked)', function () {

    let seatData = JSON.parse($(this).attr('data-seat'));
    let seatIndex = seatData.SeatIndex;

    let alreadySelected = selectedSeats.find(s => s.SeatIndex == seatIndex);

    if (alreadySelected) {
        selectedSeats = selectedSeats.filter(s => s.SeatIndex != seatIndex);
        $(this).removeClass('selected');
    }
    // ✅ SELECT
    else {
        if (selectedSeats.length >= maxSeatsAllowed) {
            notify(`Max ${maxSeatsAllowed} seats allowed`, 'warning');
            return;
        }

        selectedSeats.push(seatData);
        $(this).addClass('selected');
    }

    validateProceedButton();
});

$(document).on('change', 'input[name="boarding_point"]', function () {
    let bp = JSON.parse(this.value);
    selectedBoardingId = bp.CityPointIndex;
    validateProceedButton();
});

$(document).on('change', 'input[name="dropping_point"]', function () {
    let dp = JSON.parse(this.value);
    selectedDroppingId = dp.CityPointIndex;
    validateProceedButton();
});


$('#proceedBookingBtn').on('click', function () {
    buildPassengerForm();
    $('#passengerOffcanvas').offcanvas('show');
    $('#confirmPassengers').prop('disabled', true);
});

function buildPassengerForm() {

    let html = '';

    selectedSeats.forEach((seat, i) => {

        html += `
        <div class="card mb-3 shadow-sm passenger-card border" data-seatindex="${i}">
            
            <div class="card-header d-flex justify-content-between align-items-center bg-light py-3">
                <strong>Passenger ${i + 1}</strong>
                <span class="badge bg-primary">Seat ${seat.SeatName}</span>
            </div>

            <div class="card-body mt-4">
                <div class="row g-2">

                    <div class="col-md-3 mb-2">
                    
                        <label>Title <span class="text-danger">*</span></label>
                        <select class="form-select title required-field" required>
                            <option value="">Select Title</option>
                            <option value="Mr">Mr</option>
                            <option value="Mrs">Mrs</option>
                            <option value="Mstr">Mstr (Male Infant)</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-2">
                    
                    <label>First Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control fname required-field" placeholder="First Name" required>
                    </div>

                    <div class="col-md-5 mb-2">
                    
                    <label>Last Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control lname required-field" placeholder="Last Name" required>
                    </div>

                    <div class="col-md-3 mb-2">
                    
                    <label>Age <span class="text-danger">*</span></label>
                        <input type="number" class="form-control age required-field" placeholder="Age" min="1" required>
                    </div>

                    <div class="col-md-3 mb-2">
                    
                    <label>Gender <span class="text-danger">*</span></label>
                        <select class="form-select gender required-field" required>
                            <option value="">Gender</option>
                            <option value="1">Male</option>
                            <option value="2">Female</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-2">
                    <label>Address <span class="text-danger">*</span></label>
                        <input type="text" class="form-control address  required-field" placeholder="Address" required>
                    </div>`;

        if (isIdProofRequired == 'true' || isIdProofRequired) {
            html += `
                        <div class="col-md-6 mb-2">
                        <label>Select Id Type <span class="text-danger">*</span></label>
                            <select class="form-select idType required-field" required>
                                <option value="">Select ID Type</option>
                                <option value="voterid">Voter Id</option>
                                <option value="pan">PAN</option>
                                <option value="passport">Passport</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-2">
                        <label>ID Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control idNumber required-field" placeholder="ID Number" required>
                        </div>`;
        }
        html += `
                    </div>
                </div>
            </div>
        `;
    });

    $('#passengerOffcanvasBody').html(html);
}

function buildPassengerPayload() {

    let passengers = [];

    let email = $('.contact-email').val();
    let phone = $('.contact-phone').val();
    $('#passengerForm .passenger-card').each(function (i) {

        let card = $(this);

        let passenger = {
            LeadPassenger: i === 0,
            PassengerId: 0,
            Title: card.find('.title').val(),
            FirstName: card.find('.fname').val(),
            LastName: card.find('.lname').val(),
            Gender: parseInt(card.find('.gender').val()),
            Age: parseInt(card.find('.age').val()),
            Address: card.find('.address').val(),
            Email: email,
            Phoneno: phone,
            IdType: card.find('.idType').val() || null,
            IdNumber: card.find('.idNumber').val() || null,
            Seat: selectedSeats[i]
        };

        passengers.push(passenger);
    });

    return passengers;
}


function validatePassengerForm(liveCheck = false) {

    let allValid = true;

    $('#passengerForm .required-field, #passengerForm .required-contact').each(function () {

        let val = $(this).val();

        if (!val || !val.toString().trim()) {
            allValid = false;

            if (!liveCheck) {
                $(this).addClass('is-invalid');
            }
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    // Enable / Disable button
    $('#confirmPassengers').prop('disabled', !allValid);

    return allValid;
}

$(document).on('click', '#confirmPassengers', function () {


    let isValid = validatePassengerForm(false);

    if (!isValid) {

        notify('Please fill all required fields before proceeding.', 'error');

        $('#confirmPassengers').prop('disabled', true);
        return;
    }

    let passengers = buildPassengerPayload();

    let trcid = localStorage.getItem('TraceId');
    let bsrstindx = localStorage.getItem("BusResultIndex");

    let bookingPayload = {
        resultIndex: bsrstindx,
        traceId: trcid,
        boardingPointId: selectedBoardingId,
        droppingPointId: selectedDroppingId,
        passenger: passengers,
        _token: $('meta[name="csrf-token"]').attr('content')
    };

    swal({
        title: 'Confirm Seat Blocking?',
        text: 'Selected seats will be blocked for limited time.',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Block Seats',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.value) {
            callBlockApi(bookingPayload);
        }
    });
});

$(document).on(
    'input change',
    '#passengerForm .required-field, #passengerForm .required-contact',
    function () {
        validatePassengerForm(true);
    }
);

function callBlockApi(bookingPayload) {

    swal({
        type: 'warning',
        title: 'Blocking Seats...',
        text: 'Your request is being processed',
        onOpen: () => {
            swal.showLoading()
        },
        allowOutsideClick: () => !swal.isLoading(),
        allowEscapeKey: false,
    });

    $.ajax({
        url: '/bus/block',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(bookingPayload),
        success: function (res) {

            swal.close();
            if (res.status == 'success') {
                if (res.data?.IsPriceChanged) {
                    swal({
                        type: 'warning',
                        title: 'Fare Changed',
                        text: res.message || 'Seat price has changed. Please review before proceeding.',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then(() => {
                        window.location.href = '/bus/seatlayout';
                    });
                    return;
                }
                swal({
                    type: 'success',
                    title: 'Seats Blocked',
                    html: `Seats blocked successfully.<br/> <b class="text-success">Proceed to payment with Amount : ${res.totalAmount}</b>`,
                    confirmButtonText: 'Proceed',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then(() => {
                    callBookApi(bookingPayload, res.totalAmount);
                });
            } else {
                swal({
                    type: 'error',
                    title: 'Block Failed',
                    text: res.message || 'Seats could not be blocked',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then(() => {
                    window.location.href = `/bus/booking-list-failed`;
                });
                return;
            }
        },

        error: function () {
            swal.close();
            swal({
                title: 'Error',
                text: 'Unable to block seats. Please try again.',
                allowOutsideClick: false,
                confirmButtonText: 'OK, Got it',
                allowEscapeKey: false,
                type: 'error'
            }).then(() => {
                window.location.href = `/bus/booking-list`;
            });
        }
    });
}

function callBookApi(bookingPayload, amt) {

    swal({
        type: 'warning',
        title: 'Confirming Booking...',
        text: 'Amount will be deducted from wallet',
        onOpen: () => {
            swal.showLoading()
        },
        allowOutsideClick: () => !swal.isLoading(),
        allowEscapeKey: false,
    });


    bookingPayload.totalAmount = amt;

    $.ajax({
        url: '/bus/book',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(bookingPayload),

        success: function (res) {

            swal.close();

            if (res.status == 'success') {

                swal({
                    type: 'success',
                    title: 'Booking Confirmed 🎉',
                    html: `
                    <b>Bus Id:</b> ${res.data.BusId ?? 'N/A'}<br>
                    <b>Ticket No:</b> ${res.data.TicketNo ?? 'N/A'}<br>
                    <b>Invoice No:</b> ${res.data.InvoiceNumber ?? 'N/A'}
                `,
                    confirmButtonText: 'View Booking List',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then(() => {
                    window.location.href = `/bus/booking-list`;
                });
            } else {

                swal({
                    title: 'Booking Failed',
                    text: res.message || res.Error?.ErrorMessage || 'Unable to confirm booking',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    type: 'error'
                }).then(() => {
                    window.location.href = '/bus/booking-list-failed';
                });
                return;
            }


        },
        error: function () {
            swal.close();
            swal({
                title: 'Error',
                text: 'Booking Confirmation Failed',
                allowOutsideClick: false,
                allowEscapeKey: false,
                type: 'error'
            }).then(() => {
                window.location.href = '/bus/booking-list-failed';
            });
        }
    });
}

// Function to add inline CSS for seat layout
function addSeatLayoutStyles() {
    let styleId = 'bus-seat-layout-styles';

    // Check if styles already exist
    if (document.getElementById(styleId)) {
        return;
    }

    const css = `
        <style id="${styleId}">
            /* Bus Wrapper */
            .bus-wrapper {
                display: flex;
                gap: 25px;
                align-items: flex-start;
            }

            /* Driver Section */
            .driver-section {
                flex-shrink: 0;
            }

            .driver-area {
                width: 90px;
                height: 90px;
                background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%);
                border: 3px solid #ddd;
                border-radius: 12px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 8px;
                box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.1), 0 4px 12px rgba(0, 0, 0, 0.1);
                position: relative;
                overflow: hidden;
            }

            /* Small driver icon placed in Lower Deck header */
            .lower-deck-driver {
                width: 56px;
                height: 56px;
                background: linear-gradient(100deg, #adefb0 0%, #f3f3f3 100%);
                border: 2px solid #2e7d32;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 4px 10px rgba(0,0,0,0.08);
                flex-shrink: 0;
            }

            .driver-area::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.3), transparent);
                pointer-events: none;
            }

            .steering-wheel {
                font-size: 36px;
                animation: spin 4s linear infinite;
                filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }

            .driver-label {
                font-size: 12px;
                font-weight: bold;
                color: #555;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            /* Rows Container */
            .rows-container {
                display: flex;
                gap: 15px;
                overflow-x: auto;
                padding: 5px 0;
                align-items: flex-start;
                flex: 1;
                -webkit-overflow-scrolling: touch;
            }

            /* Row Column */
            .row-column {
                display: flex;
                flex-direction: column;
                gap: 10px;
                min-width: fit-content;
                padding: 8px 12px;
                background: linear-gradient(90deg, rgba(240, 240, 240, 0.5) 0%, transparent 100%);
                border-left: 3px solid #2196f3;
                border-radius: 4px 0 0 4px;
                position: relative;
                justify-content: flex-end;
                min-height: auto;
            }

            .row-column:first-child {
                border-left: 3px solid #4caf50;
            }

            .row-column:nth-child(odd) {
                border-left-color: #2196f3;
            }

            .row-column:nth-child(even) {
                border-left-color: #ff9800;
            }

            .row-column:nth-child(2) {
                margin-right: 50px;
            }

            /* Seat Container */
            .seat-wrapper {
                margin: 0 0 10px 0;
            }

            .seat-container {
                width: 60px;
                height: 60px;
                border: 2px solid #ddd;
                border-radius: 8px;
                background: #f0f0f0;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.3s ease;
                position: relative;
                user-select: none;
                overflow: hidden;
                font-weight: bold;
            }

            .bus-seat.sleeper {
                width: 60px;
                height: 85px;
            }

            .bus-seat.regular {
                width: 55px;
                height: 55px;
            }

            .seat-inner {
                text-align: center;
                width: 100%;
                height: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 2px;
                z-index: 2;
            }

            .seat-name {
                font-weight: bold;
                font-size: 11px;
                word-break: break-word;
            }

            .seat-fare {
                font-size: 9px;
                font-weight: bold;
            }

            /* Seat States */
            .bus-seat.available {
                background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
                border-color: #4caf50;
                color: #2e7d32;
                box-shadow: 0 2px 6px rgba(76, 175, 80, 0.2);
            }

            .bus-seat.available:hover {
                border-color: #388e3c;
                box-shadow: 0 0 15px rgba(76, 175, 80, 0.5);
                transform: translateY(-3px);
            }

            .bus-seat.booked {
                background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%);
                border-color: #f44336;
                color: #c62828;
                cursor: not-allowed;
                opacity: 0.65;
                box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            }

            .bus-seat.booked::after {
                content: 'Sold';
                position: absolute;
                font-size: 8px;
                font-weight: bold;
                color: #f44336;
                background: rgba(255, 255, 255, 0.95);
                padding: 3px 5px;
                border-radius: 3px;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                z-index: 3;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            }

            .bus-seat.selected {
                background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%);
                border-color: #0d47a1;
                color: white;
                box-shadow: 0 0 18px rgba(33, 150, 243, 0.7), inset 0 1px 3px rgba(255, 255, 255, 0.3);
                transform: scale(1.05);
            }

            .bus-seat.selected .seat-fare,
            .bus-seat.selected .seat-name {
                color: #fff;
                text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            }

            /* Ladies Seats */
            .bus-seat.ladies {
                background: linear-gradient(135deg, #fce4ec 0%, #f8bbd0 100%);
                border-color: #e45886;
                color: #880e4f;
                box-shadow: 0 2px 6px rgba(233, 30, 99, 0.2);
            }

            .bus-seat.ladies:hover:not(.booked) {
                border-color: #c2185b;
                box-shadow: 0 0 15px rgba(233, 30, 99, 0.5);
                transform: translateY(-3px);
            }

            .bus-seat.ladies.selected {
                background: linear-gradient(135deg, #e91e63 0%, #c2185b 100%);
                border-color: #880e4f;
                color: white;
            }

            /* Male Seats */
            .bus-seat.male {
                background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
                border-color: #2196f3;
                color: #1565c0;
                box-shadow: 0 2px 6px rgba(33, 150, 243, 0.2);
            }

            .bus-seat.male:hover:not(.booked) {
                border-color: #1565c0;
                box-shadow: 0 0 15px rgba(33, 150, 243, 0.5);
                transform: translateY(-3px);
            }

            .bus-seat.male.selected {
                background: linear-gradient(135deg, #2196f3 0%, #1565c0 100%);
                border-color: #0d47a1;
                color: white;
            }

            /* Legend */
            .seat-legend {
                background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 100%);
            }

            .legend-item {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 8px;
            }

            .seat-mini {
                width: 35px;
                height: 35px;
                border: 2px solid #ddd;
                border-radius: 5px;
                background: #f0f0f0;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .seat-mini.available {
                background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
                border-color: #4caf50;
            }

            .seat-mini.booked {
                background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%);
                border-color: #f44336;
            }

            .seat-mini.selected {
                background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%);
                border-color: #0d47a1;
            }

            .seat-mini.ladies {
                background: linear-gradient(135deg, #fce4ec 0%, #f8bbd0 100%);
                border-color: #e45886;
            }

            .seat-mini.male {
                background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
                border-color: #2196f3;
            }

            /* Badge Step */
            .badge-step {
                background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%);
                margin-right: 8px;
                padding: 5px 8px;
                border-radius: 50%;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-width: 28px;
                height: 28px;
                box-shadow: 0 2px 6px rgba(255, 107, 107, 0.3);
            }

            /* Responsive Design */
            @media (max-width: 992px) {
                .bus-wrapper {
                    gap: 15px;
                }

                .driver-area {
                    width: 80px;
                    height: 80px;
                }

                .steering-wheel {
                    font-size: 32px;
                }

                .seat-container {
                    width: 52px;
                    height: 52px;
                }

                .bus-seat.sleeper {
                    width: 52px;
                    height: 75px;
                }

                .bus-seat.regular {
                    width: 48px;
                    height: 48px;
                }

                .seat-name {
                    font-size: 10px;
                .deck-header-row .deck-label {
                    font-size: 1rem;
                }

                .upper-deck-placeholder {
                    width: 56px;
                    height: 56px;
                }
                }

                .seat-fare {
                    font-size: 8px;
                }

                .row-column {
                    gap: 8px;
                    padding: 6px 10px;
                }
            }

            @media (max-width: 768px) {
                .bus-wrapper {
                    flex-direction: column;
                    gap: 15px;
                }

                .driver-section {
                    width: 100%;
                    text-align: center;
                }

                .driver-area {
                    width: 100%;
                    max-width: 120px;
                    margin: 0 auto;
                    height: 70px;
                }

                .steering-wheel {
                    font-size: 28px;
                }

                .driver-label {
                    font-size: 11px;
                }

                .rows-container {
                    gap: 10px;
                    overflow-x: auto;
                    -webkit-overflow-scrolling: touch;
                    width: 100%;
                }

                .row-column {
                    gap: 8px;
                    padding: 6px 8px;
                }

                .seat-container {
                    width: 48px;
                    height: 48px;
                }

                .bus-seat.sleeper {
                    width: 48px;
                    height: 68px;
                }

                .bus-seat.regular {
                    width: 44px;
                    height: 44px;
                }

                .seat-name {
                    font-size: 9px;
                }

                .seat-fare {
                    font-size: 7px;
                }
            }

            @media (max-width: 480px) {
                .driver-area {
                    width: 100%;
                    height: 60px;
                }

                .steering-wheel {
                    font-size: 24px;
                }

                .seat-container {
                    width: 42px;
                    height: 42px;
                }

                .bus-seat.sleeper {
                    width: 42px;
                    height: 60px;
                }

                .seat-name {
                    font-size: 8px;
                }

                .seat-fare {
                    font-size: 6px;
                }
            }

            /* Disabled State */
            .seat-container:disabled {
                pointer-events: none;
            }

            /* Active State */
            .seat-container:active:not(.booked) {
                transform: scale(0.95);
            }

            .deck-content {
                background: #ffffff !important;
                // max-height: 450px;
                overflow-y: auto;
                border-radius: 8px;
            }

            /* Scrollbar Styling */
            .rows-container::-webkit-scrollbar {
                height: 8px;
            }

            .rows-container::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 4px;
            }

            .rows-container::-webkit-scrollbar-thumb {
                background: linear-gradient(180deg, #888 0%, #666 100%);
                border-radius: 4px;
            }

            .rows-container::-webkit-scrollbar-thumb:hover {
                background: linear-gradient(180deg, #555 0%, #333 100%);
            }

            /* Firefox Scrollbar */
            .rows-container {
                scrollbar-width: thin;
                scrollbar-color: #888 #f1f1f1;
            }
        </style>
    `;

    // Append styles to head
    $('head').append(css);
}


