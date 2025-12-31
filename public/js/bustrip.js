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
            $('#busSearchForm').find('button[type="submit"]').html('Find Ticket <i class="ti ti-arrow-right ps-3"></i>').attr('disabled', false);
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

                    console.log(bus, boarding, dropping);
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
                                        <h4>₹${bus.BusPrice.OfferedPrice}</h4>
                                        <button class="btn btn-dark mb-0 btn-book-now" data-busid="${bus.ResultIndex}">Book Now</button>
                                    </div>
                                </div>                               
                            </div>

                             <div class="card-footer pt-4">
                                <ul class="list-inline bg-light d-sm-flex justify-content-sm-between text-center rounded-2 py-2 px-4 mb-0">
                                    <li class="list-inline-item text-danger">Only ${bus.AvailableSeats} Seat Left</li> |
                                    <li class="list-inline-item text-danger">
                                        Id Proof : ${bus.IdProofRequired ? 'Required' : 'Not Required'}
                                    </li> |
                                    <li class="list-inline-item text-danger">
                                        ${bus.LiveTrackingAvailable ? '<span class="text-success fw-bold">Live Tracking Available</span>' : '<span class="text-danger fw-bold">No Live Tracking</span>'}
                                    </li> |
                    
                                    <li class="list-inline-item">
                                        <button class="btn p-0 text-primary view-details" 
                                        >
                                            👁️ Full Details <i class="fa-solid fa-angle-right ms-1"></i>
                                        </button>
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

// data-bs-toggle="modal" data-bs-target="#busdetail" data-busid="${bus.ResultIndex}"
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

// BTN Book Now
$(document).on('click', '.btn-book-now', function () {

    notify("🚧 Booking service is currently under maintenance. Please try again later.", "warning");
    return;
    // let busId = $(this).data('busid');
    // localStorage.setItem("ResultIndex", busId || '');   
    // window.location.href = "/bus/details";
});