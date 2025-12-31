let totalPassengers = 1;

$('#busSearchForm').on('submit', function (e) {
    return;
    e.preventDefault();

    let payload = {};
    let totalTraveler = 0;

    let selectedTypes = $('input[name="FlightType[]"]:checked')
        .map(function () { return $(this).val(); })
        .get();

    let adultCount = parseInt($('#AdultCount').val()) || 1;
    let childCount = parseInt($('#ChildCount').val()) || 0;
    let infantCount = parseInt($('#InfantCount').val()) || 0;

    payload.FlightCabinClass = $('#FlightCabinClass').val();
    payload.AdultCount = adultCount;
    payload.ChildCount = childCount;
    payload.InfantCount = infantCount;
    payload._token = $('input[name="_token"]').val();
    payload.DirectFlight = selectedTypes.includes('direct') ? true : false,
        payload.OneStopFlight = selectedTypes.includes('onestop') ? true : false


    // Add adult infant and child 
    totalTraveler = adultCount + childCount + infantCount;
    if (totalTraveler > 9) {
        notify("Total number of travelers cannot exceed 9.", "error");
        return;
    } else {
        if (activeContent === 'pills-one-way') {
            if ($('#Origin').val() == '') {
                notify("Please Select Origin Location.", "error");
                return;
            } else if ($('#Destination').val() == '') {
                notify("Please Select Destination Location.", "error");
                return;
            } else if ($('#PreferredDepartureTime').val() == '') {
                notify("Please Select Departure Date.", "error");
                return;
            }

            payload.JourneyType = journeyType;
            payload.Origin = $('#Origin').val();
            payload.Destination = $('#Destination').val();
            payload.PreferredDepartureTime = $('#PreferredDepartureTime').val();
        } else if (activeContent === 'pills-round-trip') {
            if ($('#roundOrigin').val() == '') {
                notify("Please Select Origin Location.", "error");
                return;
            } else if ($('#roundDestination').val() == '') {
                notify("Please Select Destination Location.", "error");
                return;
            } else if ($('#roundDeparture').val() == '') {
                notify("Please Select Departure Date.", "error");
                return;
            } else if ($('#roundReturn').val() == '') {
                notify("Please Select Return Date.", "error");
                return;
            }

            payload.JourneyType = journeyType;

            payload.Segments = [
                {
                    Origin: $('#roundOrigin').val(),
                    Destination: $('#roundDestination').val(),
                    FlightCabinClass: $('#FlightCabinClass').val(),
                    PreferredDepartureTime: $('#roundDeparture').val() + "T00:00:00",
                    PreferredArrivalTime: $('#roundDeparture').val() + "T00:00:00"
                },
                {
                    Origin: $('#roundDestination').val(),
                    Destination: $('#roundOrigin').val(),
                    FlightCabinClass: $('#FlightCabinClass').val(),
                    PreferredDepartureTime: $('#roundReturn').val() + "T00:00:00",
                    PreferredArrivalTime: $('#roundReturn').val() + "T00:00:00"
                }
            ];
        }

        // console.log(payload);
        // return;
        $.ajax({
            url: "/flight/search",
            method: "POST",
            data: payload,
            beforeSend: function () {
                // localStorage remove
                localStorage.removeItem("TraceId");
                localStorage.removeItem("ResultIndex");
                localStorage.removeItem("selectedFlightDetails");

                // Button loading state submit
                $('#flightSearchForm').find('button[type="submit"]').html('Please Wait...').attr('disabled', true);
            },
            complete: function () {
                $('#flightSearchForm').find('button[type="submit"]').html('Find Ticket <i class="ti ti-arrow-right ps-3"></i>').attr('disabled', false);
            },
            success: function (response) {
                localStorage.setItem("payload", JSON.stringify(payload) || {});


                $("#search_flight_list").html("");
                $('.all_flight_list').addClass('d-none');

                if (response.status == 'success') {
                    $('#summaryDetails').html('');
                    $('#btnfordetailsPage').html('');
                    $('#roundSummaryCard').addClass('d-none');

                    let results = response.data.Results || [];
                    if (results.length == 0) {
                        notify("❌ No flights found for selected route.", "error");
                        return;
                    }
                    localStorage.setItem("TraceId", response?.data?.TraceId || '');
                    $('.all_flight_list').removeClass('d-none');

                    if (journeyType == 1) {
                        $("#roundTabs").addClass("d-none");

                        results.forEach((group, i) => {
                            group.forEach((flight, j) => {
                                let segs = flight.Segments[0];
                                let hasLayover = segs.length > 1;
                                let layovers = segs.length - 1;

                                let airline = segs[0].Airline.AirlineName;
                                let flightNo = segs[0].Airline.FlightNumber;

                                if (segs[0].CabinClass == 1) {
                                    segs[0].CabinClass = 'All';
                                } else if (segs[0].CabinClass == 2) {
                                    segs[0].CabinClass = 'Economy';
                                } else if (segs[0].CabinClass == 3) {
                                    segs[0].CabinClass = 'Premium Economy';
                                } else if (segs[0].CabinClass == 4) {
                                    segs[0].CabinClass = 'Business';
                                } else if (segs[0].CabinClass == 5) {
                                    segs[0].CabinClass = 'Premium Business';
                                } else if (segs[0].CabinClass == 6) {
                                    segs[0].CabinClass = 'First';
                                }


                                let travelClass = segs[0].CabinClass || 'Economy';

                                let totalFare = flight.Fare.PublishedFare;
                                let seats = segs[0].NoOfSeatAvailable || 0;
                                let lcc = flight.IsLCC ? 'LCC' : 'Non-LCC';

                                // helper function
                                const fmtTime = (t) => new Date(t).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                                const fmtDate = (t) => new Date(t).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' });

                                let html = '';

                                let seg = segs[0];
                                html += `
                                <div class="card border">
                                    <div class="card-header d-flex justify-content-between">
                                        <div class="d-flex align-items-center">
                                            ✈️
                                            <h6 class="fw-normal mb-0">${airline} (${seg.Airline.AirlineCode} - ${flightNo})</h6>
                                        </div>
                                        <h6 class="fw-normal mb-0"> ${travelClass} (${lcc})</h6>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="row g-4 align-items-center">
                                            <div class="col-md-9">
                                                <div class="row g-4">
                                                    <div class="col-sm-4">
                                                        <h4>${fmtTime(seg.Origin.DepTime)}</h4>
                                                        <h6 class="fw-normal mb-0">${fmtDate(seg.Origin.DepTime)}</h6>
                                                        <p>${seg.Origin.Airport.CityName}</p>
                                                    </div>
                                                    <div class="col-sm-4 text-center">
                                                        <h5>${formatDuration(seg.Duration)}</h5>
                                                        <div class="position-relative my-4">
                                                            <hr class="bg-primary opacity-5 position-relative">
                                                            <div class="icon-md bg-primary text-white rounded-circle position-absolute top-50 start-50 translate-middle p-2">
                                                                <i class="fa-solid fa-fw fa-plane rtl-flip"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <h4>${fmtTime(seg.Destination.ArrTime)}</h4>
                                                        <h6 class="fw-normal mb-0">${fmtDate(seg.Destination.ArrTime)}</h6>
                                                        <p>${seg.Destination.Airport.CityName}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 text-md-end">
                                                <h4>₹${totalFare}</h4>
                                                <button class="btn btn-dark mb-0 btn-book-now" data-bookingflightdetails='${encodeURIComponent(JSON.stringify(flight))}'>Book Now</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer pt-4">
                                        <ul class="list-inline bg-light d-sm-flex justify-content-sm-between text-center rounded-2 py-2 px-4 mb-0">
                                            <li class="list-inline-item text-danger">Only ${seats} Seat Left</li>
                                            <li class="list-inline-item ${flight.IsRefundable ? 'text-success' : 'text-danger'}">
                                                ${flight.IsRefundable ? 'Refundable' : 'Non-Refundable'}
                                            </li>
                                            <li class="list-inline-item text-danger">
                                             ${layovers > 0
                                        ? `<span class="text-primary fw-bold">${layovers} Layover${layovers > 1 ? 's' : ''}</span>`
                                        : `<span class="text-success fw-bold">Non-stop</span>`
                                    }</li>
                            
                                            <li class="list-inline-item">
                                                <button class="btn p-0 text-primary view-details" 
                                                    data-bs-toggle="modal" data-bs-target="#flightdetail" 
                                                    data-segs='${JSON.stringify(segs)}' data-allDetails='${JSON.stringify(flight)}'>
                                                    👁️ View Details <i class="fa-solid fa-angle-right ms-1"></i>
                                                </button>
                                            </li>
                                        </ul>
                                        
                                    </div>
                                </div>`;

                                $("#search_flight_list").append(html);
                            });
                        });
                    } else if (journeyType == 2) {
                        roundtripFlightResults(response.data);
                    }
                } else {
                    notify(response.message, "error");
                }
            },
            error: function (xhr) {
                notify("Search failed. Please try again.", "error");
            }
        });
    }

});