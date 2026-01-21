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
                    let boarding = bus.BoardingPointsDetails.map(bp => bp.CityPointName).join(', ');
                    let dropping = bus.DroppingPointsDetails.map(dp => dp.CityPointName).join(', ');

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

    let lowerHTML = '';
    let upperHTML = '';

    rows.forEach((row, index) => {
        let rowHTML = `<div class="bus-row">`;

        row.forEach((seat, idx) => {

            let seatClass = '';
            let icon = '💺';
            let typeText = 'Seat';

            if ([2, 3, 4, 5].includes(seat.SeatType)) {
                seatClass += ' sleeper';
                icon = '🛏️';
                typeText = 'Sleeper';
            }

            if (seat.SeatType == 4) {
                seatClass += ' upper';
                icon = '⬆️🛏️';
                typeText = 'Upper Berth';
            }

            if (seat.SeatType == 5) {
                seatClass += ' lower';
                icon = '⬇️🛏️';
                typeText = 'Lower Berth';
            }

            if (seat.IsLadiesSeat) seatClass += ' ladies';
            if (seat.IsMalesSeat) seatClass += ' male';
            if (!seat.SeatStatus) seatClass += ' booked';

            let tooltip = `Fare: ₹${seat.SeatFare} ${seat?.IsLadiesSeat ? '| Ladies' : ''}  ${seat?.IsMalesSeat ? '| Male' : ''} | ${typeText} `.trim();

            rowHTML += `
                <div class="seat ${seatClass} mb-2"
                     data-tooltip="${tooltip}"
                     data-seat='${JSON.stringify(seat)}'>
                     <span class="icon">${seat?.SeatName}</span>
                </div>
            `;
        });

        rowHTML += `</div>`;

        index < 4 ? lowerHTML += rowHTML : upperHTML += rowHTML;
    });



    $('#seatlayoutdetails').html(`
        <div class="card">
            <div class="card-header border-bottom">
                🚌 Total ${fareRules.AvailableSeats} Seats Available in which you can select Max ${maxSeatsAllowed} Seat
            </div>
            <div class="card-body">
            
                <div class="legend-panel">
                    <div class="legend-item">
                        <div class="legend-box  sleeper male-seat"></div>
                        <span>Male Seat/Sleeper</span>
                   
                        <div class="legend-box  sleeper ladies-seat"></div>
                        <span>Ladies Seat/Sleeper</span>
                                  
                        <div class="legend-box sleeper available-sleeper"></div>
                        <span>Available Seat/Sleeper</span>
                   
                        <div class="legend-box sleeper selected-sleeper"></div>
                        <span>Selected Seat/Sleeper</span>
                 
                        <div class="legend-box sleeper booked-seat"></div>
                        <span>Booked Seat/Sleeper</span>
                    </div>
                </div>
                <div class="row px-2">
                    <div class="col-md-6">
                        <div class="card bus-card border h-100 shadow-none">
                            <div class="card-header pb-1 border-bottom d-flex justify-content-between align-items-center">
                                <h5>Lower Deck ⬇️</h5>
                                <h5 class="fs-5">🛞 Driver</h5>
                            </div>


                            <div class="card-body mt-4">
                                ${lowerHTML}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card bus-card border h-100 shadow-none">
                        

                                <div class="card-header pb-1 border-bottom deck-header">
                                    <h5>Upper Deck ⬆️</h5>
                                </div>

                                <div class="card-body mt-4">
                                    ${upperHTML}
                                </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    `);

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

$(document).on('click', '.seat:not(.booked)', function () {

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
                    text: 'Seats blocked successfully. Proceed to payment.',
                    confirmButtonText: 'Proceed',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then(() => {
                    callBookApi(bookingPayload);
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

function callBookApi(bookingPayload) {

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
                if (res.status == 'balance_low') {
                    swal({
                        title: 'Insufficient Wallet Balance',
                        text: 'Please recharge wallet and try again.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        confirmButtonText: 'OK, Got it',
                        type: 'error'
                    }).then(() => {
                        window.location.href = '/bus/view';
                    });
                } else {
                    swal({
                        title: 'Booking Failed',
                        text: res.Error?.ErrorMessage || 'Unable to confirm booking',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        type: 'error'
                    }).then(() => {
                        window.location.href = '/bus/booking-list-failed';
                    });
                }
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

