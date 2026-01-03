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
            localStorage.removeItem("selectedFlightDetails");

            // Button loading state submit
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
                                                <p>${bus.Origin ? bus.Origin : 'N/A'}</p>
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
                                                <p>${bus.Destination ? bus.Destination : 'N/A'}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-md-end">
                                        <h4 class="text-success">₹${bus.BusPrice.PublishedPriceRoundedOff}</h4>
                                        <button class="btn btn-dark mb-0 view-details" data-bs-toggle="modal" data-bs-target="#busdetail" data-busid="${bus.ResultIndex}"
                                            data-businfo="${encodeURIComponent(JSON.stringify(bus))}">View Details</button>
                                    </div>
                                </div>                               
                            </div>

                             <div class="card-footer pt-4">
                                <ul class="list-inline bg-light d-sm-flex justify-content-sm-between text-center rounded-2 py-2 px-4 mb-0">
                                    <li class="list-inline-item text-danger">Only ${bus.AvailableSeats} Seat Left</li> |
                                    <li class="list-inline-item">👤
                                        ${bus.IdProofRequired ? '<span class="text-success fw-bold">Id Proof Required</span>' : '<span class="text-danger fw-bold">Id Proof Not Required</span>'}
                                    </li> |
                                    <li class="list-inline-item">📍
                                        ${bus.LiveTrackingAvailable ? '<span class="text-success fw-bold">Live Tracking Available</span>' : '<span class="text-danger fw-bold">No Live Tracking</span>'}
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
    let busId = $(this).data('busid');
    let busInfo = JSON.parse(
        decodeURIComponent($(this).attr("data-businfo"))
    );

    let infohtml = "";
    let policyhtml = "";
    let farehtml = "";

    infohtml += `
        <div class="card border">
            <div class="card-header d-flex align-items-center border-bottom">
                🚌
                <h5 class="card-title mb-0">${busInfo.TravelName} (${busInfo.ServiceName}) <small>(Bus Type : ${busInfo.BusType})</small></h5>
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
                                                    <div class="text-end">
                                                      
                                                         <input class="form-check-input boarding-point"
                                                            type="radio"
                                                            name="boardingPoint[]"
                                                            id="boarding_${i}"
                                                            value="${bp.CityPointIndex}"
                                                            data-location="${bp.CityPointLocation}"
                                                            data-time="${bp.CityPointTime}">
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
                                                    <div class="text-end">
                                                        
                                                         <input class="form-check-input dropping-point"
                                                            type="radio"
                                                            name="droppingPoint[]"
                                                            id="dropping_${i}"
                                                            value="${dp.CityPointIndex}"
                                                            data-location="${dp.CityPointLocation}"
                                                            data-time="${dp.CityPointTime}">
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

    $('#busDetailFooter').html(`
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-book-now">Proceed to Next</button>
    `);
});


// BTN Book Now
$(document).on('click', '.btn-book-now', function () {

    notify("🚧 Booking service is currently under maintenance. Please try again later.", "warning");
    return;
    // let busId = $(this).data('busid');
    // localStorage.setItem("ResultIndex", busId || '');   
    // window.location.href = "/bus/details";
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