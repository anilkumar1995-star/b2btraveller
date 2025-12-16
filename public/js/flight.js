let totalPassengers = 1;
let selectedSeats = {};
let selectedMeals = [];
let selectedBaggage = [];

let selectedDeparture = '';
let selectedReturn = '';


$('#flightSearchForm').on('submit', function (e) {
    e.preventDefault();

    let activeTab = $('.nav-pills .nav-link.active').attr('id');
    let journeyType = activeTab === 'pills-one-way-tab' ? 1 : 2;

    let activeContent = $('.tab-pane.active').attr('id');

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
                // localstorage save payload

                localStorage.setItem("payload", JSON.stringify(payload) || {});

                $("#search_flight_list").html('');
                $('.all_flight_list').addClass('d-none');
                if (response.status == 'success') {
                    let results = response.data.Results || [];
                    if (results.length == 0) {
                        notify("❌ No flights found for selected route.", "error");
                        return;
                    }
                    localStorage.setItem("TraceId", response?.data?.TraceId || '');
                    $('.all_flight_list').removeClass('d-none');

                    if (journeyType == 1) {
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
                                <div class="card border mb-3">
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


// Book Now Click
$(document).on("click", ".btn-book-now", function () {
    const encoded = $(this).attr('data-bookingflightdetails');
    try {
        const flight = JSON.parse(decodeURIComponent(encoded));
        if (flight) {
            localStorage.setItem('selectedFlightDetails', JSON.stringify(flight));
            localStorage.setItem("ResultIndex", flight?.ResultIndex || '');
            window.location.href = "/flight/detail";
        } else {
            notify("Flight details not found!", "error");
        }
    } catch (error) {
        notify("Error reading flight details!", "error");
    }
});

// View Details Click
$(document).on("click", ".view-details", function () {
    // Airline Source mapping
    const airlineSourceMap = {
        0: "NotSet",
        3: "SpiceJet",
        4: "Amadeus",
        5: "Galileo",
        6: "Indigo",
        10: "GoAir",
        13: "AirArabia",
        14: "AirIndiaExpress",
        15: "AirIndiaExpressDom",
        17: "FlyDubai",
        19: "AirAsia",
        24: "IndigoCoupon",
        25: "SpiceJetCoupon",
        26: "GoAirCoupon",
        27: "IndigoTBF",
        28: "SpiceJetTBF",
        29: "GoAirTBF",
        30: "IndigoSPLCoupon",
        31: "SpiceJetSPLCoupon",
        32: "GoAirSPLCoupon",
        36: "IndigoCrpFare",
        37: "SpiceJetCrpFare",
        38: "GoAirCrpFare",
        42: "IndigoDstInv",
        43: "SpiceJetDstInv",
        44: "GoAirDstInv",
        46: "AirCosta",
        47: "MalindoAir",
        48: "BhutanAirlines",
        49: "AirPegasus",
        50: "TruJet"
    };




    let segs = JSON.parse($(this).attr("data-segs"));
    let allDetails = JSON.parse($(this).attr("data-allDetails"));
    let infohtml = "";
    let policyhtml = "";
    let baghtml = "";
    let farehtml = "";

    let cabnClass = '';

    segs.forEach((s, idx) => {
        if (s.CabinClass == 1) {
            cabnClass = "All Class"
        } else if (s.CabinClass == 2) {
            cabnClass = "Economy"
        } else if (s.CabinClass == 3) {
            cabnClass = "Premium Economy"
        } else if (s.CabinClass == 4) {
            cabnClass = "Business"
        } else if (s.CabinClass == 5) {
            cabnClass = "Premium Business"
        } else if (s.CabinClass == 6) {
            cabnClass = "First Class"
        } else {
            cabnClass = s.CabinClass;
        }

        if (segs.length === 1 && idx > 0) return;

        infohtml += `
        <div class="card border" id="segment-${idx + 1}">
            <div class="card-header">
                <div class="d-sm-flex justify-content-sm-between align-items-center">

                    <div class="d-flex mb-2 mb-sm-0">
                       ✈️
                        <h6 class="fw-normal mb-0">
                            ${s.Airline?.AirlineName || 'N/A'} 
                            (${s.Airline?.AirlineCode || s.Airline?.OperatingCarrier} - ${s.Airline?.FlightNumber || ''})
                            | Source : ${airlineSourceMap[allDetails.Source] || "N/A"}
                        </h6>
                    </div>

                    <h6 class="fw-normal mb-0">
                        ${cabnClass || 'Economy'} 
                        ${s.Craft ? `| ${s.Craft}` : ''} 
                        ${s.TripIndicator == 1 ? `| Outbound ` : s.TripIndicator == 2 ? `| Inbound ` : ''} 
                        <span class="badge ${s.FlightStatus?.toLowerCase() === 'confirmed' ? 'bg-success' : 'bg-danger'}">
                            ${s.FlightStatus}
                        </span>
                    </h6>

                </div>
            </div>


            <div class="card-body px-4 pt-4 pb-0">

                <div class="row g-4">

                    <div class="col-sm-4">
                        <h4>${s.Origin?.Airport?.AirportCode || s.Origin?.Airport?.CityCode}</h4>
                        <h6 class="mb-0">${fmtTime(s.Origin?.DepTime)}</h6>
                        <p class="mb-0">${s.Origin?.Airport?.AirportName} ${s.Origin?.Airport?.CityName}</p>
                        <h6 class="mb-0">Terminal : ${s.Origin?.Airport?.Terminal || 'N/A'}</h6>
                    </div>

                    <div class="col-sm-4 my-sm-auto text-center">
                        <h5>${formatDuration(s.Duration)}</h5>

                        <div class="position-relative my-4">
                            <hr class="bg-primary opacity-5 position-relative">
                            <div class="icon-md bg-primary text-white rounded-circle position-absolute top-50 start-50 translate-middle p-2">
                                <i class="fa-solid fa-fw fa-plane rtl-flip"></i>
                            </div>
                        </div>

                        <h6>${s.SegmentIndicator == 1 ? `Outbound` : s.SegmentIndicator == 2 ? `Inbound` : ''}</h6>
                    </div>

                    <div class="col-sm-4 text-end">
                        <h4>${s.Destination?.Airport?.AirportCode || s.Destination?.Airport?.CityCode}</h4>
                        <h6 class="mb-0">${fmtTime(s.Destination?.ArrTime)}</h6>
                        <p class="mb-0">${s.Destination?.Airport?.AirportName} ${s.Destination?.Airport?.CityName}</p>
                        <h6 class="mb-0">Terminal : ${s.Destination?.Airport?.Terminal || 'N/A'}</h6>
                    </div>

                </div>

            </div>


            <div class="card-footer">
                <ul class="list-inline bg-light d-sm-flex justify-content-sm-between text-center rounded-2 py-2 px-4 mb-0">

                    <li class="list-inline-item text-danger">
                        Only ${s.NoOfSeatAvailable} Seat Left
                    </li> |

                    <li class="list-inline-item ${allDetails?.IsRefundable ? 'text-success' : 'text-danger'}">
                        ${allDetails?.IsRefundable ? 'Refundable' : 'Non-Refundable'}
                    </li> |

                    <li class="list-inline-item"> 
                        E-Ticket : 
                        ${allDetails?.IsETicketEligible
                ? '<span class="text-success">Eligible</span>'
                : '<span class="text-danger">Not Eligible</span>'}
                    </li> |

                    <li class="list-inline-item"> 
                        Free Meal :
                        ${allDetails?.IsFreeMealAvailable
                ? '<span class="text-success">Available</span>'
                : '<span class="text-danger">Not Available</span>'}
                    </li> |

                    <li class="list-inline-item"> 
                        ${allDetails?.LastTicketDate
                ? `Last Ticket: ${new Date(allDetails?.LastTicketDate).toLocaleDateString('en-IN')}`
                : 'N/A'}
                    </li>

                </ul>
                </div>`;

        let nextSeg = segs[idx + 1];

        if (nextSeg) {
            const groundCity = nextSeg?.Origin?.Airport?.CityName || "N/A";
            const gTime = nextSeg?.GroundTime || 0;

            infohtml += `
                <div class="bg-light text-center rounded-2 mt-2 p-2">
                    <strong>Ground Time at ${groundCity}:</strong> ${formatDuration(gTime)}
                </div>
            `;
        }

        infohtml += ` </div>`;




        // Baggage Information
        baghtml += `<div class="card border mt-3">       
            <div class="card-header d-flex align-items-center border-bottom">
            ✈️
                <h5 class="card-title mb-0">${s.Origin?.Airport?.AirportCode || s.Origin?.Airport?.CityCode} - ${s.Destination?.Airport?.AirportCode || s.Destination?.Airport?.CityCode}</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive-lg">
                    <table class="table caption-bottom mb-0 mt-2">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="border-0 rounded-start">Baggage Type</th>
                                <th scope="col" class="border-0">Check In</th>
                                <th scope="col" class="border-0 rounded-end">Cabin</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            <tr>
                                <td>🧳 ${cabnClass} | Carft: ${s.Craft ? s.Craft : 'N/A'}</td>
                                <td>${s.Baggage}</td>
                                <td>${s.CabinBaggage}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>`;


        // Policy Information

        policyhtml += `<div class="card border mt-3">
            <div class="card-header d-flex align-items-center border-bottom">
                ✈️
                <h5 class="card-title mb-0">${s.Origin?.Airport?.AirportCode || s.Origin?.Airport?.CityCode} - ${s.Destination?.Airport?.AirportCode || s.Destination?.Airport?.CityCode}</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive-lg">
                    <table class="table caption-bottom mb-0">
                        <caption class="pb-0">Airline Remark : *${allDetails.AirlineRemark}</caption>
                        
                        <tbody class="border-top-0">
                            <tr>
                                <td>Ticket Advisory</td>
                                <td>${allDetails?.TicketAdvisory || 'N/A'}</td>
                            </tr>
                            <tr>
                                <td>Penalty Charges</td>
                                <td>${allDetails?.PenaltyCharges?.ReissueCharge || 'INR 0'} (${allDetails?.ResultFareType || 'N/A'})</td>
                            </tr>
                            <tr>
                            <td>Fare Classification</td>
                            <td><span class="badge" style="background:${allDetails?.FareClassification?.Color}">${allDetails?.FareClassification?.Type}</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>`;


        // Fare Information

        farehtml = `
         <div class="card card-body">
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
                            <td>${allDetails?.Fare?.Currency || '₹'} ${allDetails?.Fare?.BaseFare || '0.00'}</td>
                            <td>${allDetails?.Fare?.Currency || '₹'} ${allDetails?.Fare?.Tax || '0.00'}</td>
                            <td>${allDetails?.Fare?.Currency || '₹'} ${allDetails?.Fare?.Discount || '0.00'}</td>
                            <td>${allDetails?.Fare?.Currency || '₹'} ${allDetails?.Fare?.OtherCharges || '0.00'}</td>
                            <td><h5 class="mb-0">${allDetails?.Fare?.Currency || '₹'} ${allDetails?.Fare?.PublishedFare || '0.00'}</h5></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer pb-0">
                <ul class="list-inline bg-light d-sm-flex justify-content-sm-between text-center rounded-2 py-2 px-4 mb-0">
                    <li class="list-inline-item text-danger">
                         Baggage Charge : ${allDetails?.Fare?.TotalBaggageCharges || '0'}
                    </li> |
                    
                    <li class="list-inline-item"> 
                         Meal Charge : ${allDetails?.Fare?.TotalMealCharges || '0'}
                    </li> |

                    <li class="list-inline-item"> 
                         Seat Charge : ${allDetails?.Fare?.TotalSeatCharges || '0'}
                    </li> |

                    <li class="list-inline-item"> 
                         Special Service Charge : ${allDetails?.Fare?.TotalSpecialServiceCharges || '0'}
                    </li> |
                </ul>
                
            </div>
        </div>`;
    });




    $("#policy-tab").html(policyhtml);
    $("#info-tab").html(infohtml);
    $("#baggage-tab").html(baghtml);
    $("#fare-tab").html(farehtml);
});

function fmtTime(dateStr) {
    if (!dateStr) return '';
    let d = new Date(dateStr);
    return d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
}

function formatDuration(minutes) {
    const hrs = Math.floor(minutes / 60);
    const mins = minutes % 60;
    return `${hrs}h ${mins}m`;
}


function getFareRules(resultIndex, traceId) {
    if (resultIndex && traceId) {
        $.ajax({
            url: "/flight/farerule",
            method: "POST",
            data: {
                ResultIndex: resultIndex,
                TraceId: traceId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.status == 'success') {
                    let flightDetails = response.data;

                    // trace id store in localstorage

                    localStorage.setItem("TraceId", flightDetails?.TraceId);

                    if (flightDetails?.FareRules.length > 0) {
                        $('#fareRulehead').html(`<h5 class="card-title mb-0">
                                ✈️
                               ${flightDetails.FareRules[0].Origin} - ${flightDetails.FareRules[0].Destination}  [${flightDetails.FareRules[0].Airline}] 
                               <span class="badge bg-light text-success mb-2"><i class="ti ti-star-fill me-2"></i>Travel
                                 Hack</span>
                            </h5>`);
                        $('#importantInfoSection').html(flightDetails.FareRules[0].FareRuleDetail || 'No Fare Rules Available.');
                        $('#importantInfoSection table').addClass('w-100');
                    } else {
                        $('#fareRulehead').html(`<h5 class="card-title mb-0">No Header Data</h4>`);
                        $('#importantInfoSection').html('No Data Available');
                    }
                } else {
                    notify(response.message, "error");
                }
            },
            error: function (xhr) {
                notify("Failed to fetch fare quote. Please try again.", "error");
            }
        });

    }
}

function getFareQuote(resultIndex, traceId) {
    if (resultIndex && traceId) {
        $.ajax({
            url: "/flight/farequote",
            method: "POST",
            data: {
                ResultIndex: resultIndex,
                TraceId: traceId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.status == 'success') {
                    let flightDetails = response.data;
                    let resultData = flightDetails?.Results || {};
                    let segmnt = resultData.Segments[0];
                    const fmt = (num) => Number(num || 0).toLocaleString('en-IN');

                    // Mini Fare rULE sECTION

                    let minifarehtml = '';
                    minifarehtml += `<div class="card-body">
                                
                                <div class="table-responsive-lg">
                                    <table class="table table-bordered rounded caption-bottom overflow-hidden mb-0">
                                        
                                        <caption class="pb-0">*From The Date Of Departure</caption>
                                        
                                        <thead class="table-dark border-light">
                                            <tr>                                              
                                                <th scope="col">Journey Point</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Details</th>
                                                <th scope="col">Online Reissue</th>
                                                <th scope="col">Online Refund</th>
                                               
                                            </tr>
                                        </thead>
                                        
                                        <tbody class="border-top-0">`;

                    resultData.MiniFareRules[0].forEach(mfare => {
                        minifarehtml += `
                                <tr>
                                    <td>${mfare?.JourneyPoints}</td>
                                    <td>${mfare.Type}</td>
                                    <td>${mfare.Details}</td>
                                    <td>${mfare?.OnlineReissueAllowed ? 'Allowed' : 'Not Allowed'}</td>
                                    <td>${mfare?.OnlineRefundAllowed ? 'Allowed' : 'Not Allowed'}</td>
                                </tr>
                                `;
                    });

                    minifarehtml += `</tbody>
                                    </table>
                                </div>
                                
                            </div>`;


                    $('#miniFareRules').html(minifarehtml);


                    let datachargehtml = '';
                    datachargehtml += ` 
                            <div class="card-header border-bottom"> 
                                <h5 class="card-title mb-0">
                                    ✈️
                                        Grand Total: ₹${resultData?.Fare.PublishedFare}
                                    
                                </h5>
                            </div>
                            
                            <div class="card-body">
                                
                                <div class="table-responsive-lg">
                                    <table class="table table-bordered rounded caption-bottom overflow-hidden mb-0">
                                        
                                        <caption class="pb-0">*From The Date Of Departure</caption>
                                        
                                        <thead class="table-dark border-light">
                                            <tr>                                              
                                                <th scope="col">Passenger Type</th>
                                                <th scope="col">Base Fare</th>
                                                <th scope="col">Tax</th>
                                                <th scope="col">Total Fare</th>
                                               
                                            </tr>
                                        </thead>
                                        
                                        <tbody class="border-top-0">`;
                    resultData.FareBreakdown.forEach(fare => {
                        let type = fare.PassengerType === 1 ? "Adult" : fare.PassengerType === 2 ? "Child" : "Infant";
                        datachargehtml += `
                                <tr>
                                    <td>${type}</td>
                                    <td>₹${fare.BaseFare}</td>
                                    <td>₹${fare.Tax}</td>
                                    <td>₹${resultData?.Fare.PublishedFare}</td>
                                </tr>
                                `;
                    });

                    datachargehtml += `</tbody>
                                    </table>
                                </div>
                                
                            </div>`;

                    $('#datatchargeDet').html(datachargehtml);

                    // Fare Section
                    let fare = resultData?.Fare || {};
                    let farehtml = '';

                    farehtml = `
                        <div class="card-header border-bottom bg-light d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Fare Summary</h5>
                                <span class="badge ${resultData?.IsRefundable ? 'bg-success' : 'bg-danger'}">
                                ${resultData?.IsRefundable ? 'Refundable' : 'Non-Refundable'}
                            </span>
                        </div>

                        <div class="card-body" >
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <h6 class="fw-normal mb-1">${segmnt[0]?.Airline?.AirlineName || 'Unknown Airline'}</h6>
                                    <p class="mb-0 small text-muted">
                                        ${segmnt[0]?.Airline?.AirlineCode || ''} - ${segmnt[0]?.Airline?.FlightNumber || ''}
                                    </p>
                                </div>
                                <div class="col-md-4 text-end">
                                    <h5 class="fw-bold text-success mb-0">₹ ${fmt(fare?.PublishedFare)}</h5>
                                    <small class="text-muted">Total Fare</small>
                                </div>
                            </div>
                            <hr/>
                            <ul class="list-group list-group-borderless">
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="h6 fw-normal mb-0">Base Fare
                                        <a href="#" tabindex="0" data-bs-toggle="popover"
                                            data-bs-trigger="focus" data-bs-placement="bottom"
                                            data-bs-content="COVID-19 test required Vaccinated travelers can visit">
                                            <i class="ti ti-info-circle"></i>
                                        </a>
                                    </span>
                                    <span class="fs-5">₹${fmt(fare?.BaseFare)}</span>
                                </li>
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="h6 fw-normal mb-0">Tax & Charges</span>
                                    <span class="fs-6 text-success">₹${fmt(fare?.Tax)}</span>
                                </li>
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="h6 fw-normal mb-0">Discount</span>
                                    <span class="fs-6 text-success">₹${fmt(fare?.Discount)}</span>
                                </li>
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="h6 fw-normal mb-0">Services Fee</span>
                                    <span class="fs-5">₹${fmt(fare?.ServiceFee)}</span>
                                </li>
                            </ul>
                        </div>

                        <div class="card-footer border-top bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 fw-normal mb-0">Grand Total</span>
                                <span class="h5 fw-normal mb-0">₹${fmt(fare?.PublishedFare)}</span>
                            </div>
                            <div class="mt-3 small text-secondary">
                                <i class="ti ti-info-circle me-1"></i> Last ticket date: 
                                ${new Date(resultData?.LastTicketDate).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' })}
                            </div>
                        </div>
                    `;

                    $("#fareChargeDetails").html(farehtml);

                    // Baggage Section
                    let bagDetHtml = '';
                    bagDetHtml = `
                        <div class="table-responsive-lg">
                            <table class="table table-bordered rounded caption-bottom overflow-hidden mb-0">
                            <thead class="table-dark border-light">
                                    <tr>
                                        <th scope="col">Baggage Type</th>
                                        <th scope="col">Check In</th>
                                        <th scope="col">Cabin</th>
                                    </tr>
                                </thead>
                                <tbody class="border-top-0">
                        `;

                    resultData?.Segments[0].forEach((seg, index) => {
                        bagDetHtml += `
                                <tr>
                                    <td>Adult 🧳 (Segment ${index + 1} - ${seg.Craft})</td>
                                    <td>${seg.Baggage}</td>
                                    <td>${seg.CabinBaggage}</td>
                                </tr>
                            `;
                    });

                    bagDetHtml += `
                                </tbody>
                            </table>
                        </div>`;

                    $('#baggageInfo').html(bagDetHtml);

                    // Coupon Section
                    if (resultData?.IsCouponAppilcable) {
                        let couponHtml = '';
                        couponHtml = `<form>
                                    <div class="card-title">
                                        <h5>Offer & Discount</h5>
                                    </div>
                                    
                                    <div class="input-group mt-2">
                                        <input class="form-control form-control" placeholder="Coupon code">
                                        <button type="button" class="btn btn-primary">Apply</button>
                                    </div>
                                </form>`;
                        $('#couponSection').html(couponHtml);
                    }

                    // Passenger Form
                    generateTravelerForm(resultData);
                } else {
                    notify(response.message, "error");
                }
            },
            error: function (xhr) {
                notify("Failed to fetch fare quote. Please try again.", "error");
            }
        });

    }
}


function displayFlightDetails(flightDetails) {

    let segs = flightDetails?.Segments[0] || [];
    let detailsHtml = '';
    let titledetailsHtml = '';

    const fmtTime = (t) => new Date(t).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    const fmtDate = (t) => new Date(t).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' });

    titledetailsHtml = `<h1 class="display-4 mb-0"><i class="fa-solid fa-plane rtl-flip"></i></h1>

        <div class="ms-3">
            <ul class="list-inline mb-2">
                <li class="list-inline-item me-2">
                    <h3 class="mb-0">${segs[0].Origin?.Airport?.CityName}(${segs[0].Origin?.Airport?.AirportCode || segs[0].Origin?.Airport?.CityCode})</h3>
                </li>
                <li class="list-inline-item me-2">
                    <h3 class="mb-0"><i class="ti ti-arrow-right"></i></h3>
                </li>
                <li class="list-inline-item me-0">
                    <h3 class="mb-0">${segs[0].Destination?.Airport?.CityName}(${segs[0].Destination?.Airport?.AirportCode || segs[0].Destination?.Airport?.CityCode})</h3>
                </li>
            </ul>

            <ul class="nav nav-divider h6 fw-normal text-body mb-0">
                <li class="nav-item">${fmtDate(segs[0].Origin?.DepTime)}</li>
                <li class="nav-item">${segs.length - 1 != 0 ? segs.length - 1 : 'Non'} Stop</li>
            </ul>
        </div>`;

    // -------- MULTIPLE SEGMENTS LOOP --------
    detailsHtml += `<div class="card-header d-flex justify-content-between pb-0">
            <h6 class="fw-normal mb-0"><span class="text-body">Travel Class:</span> ${segs[0].CabinClass}</h6>
            <a href="#" class="btn p-0 mb-0"
                data-bs-toggle="modal" data-bs-target="#ruleFare">
                <i class="ti ti-eye me-1"></i> <u class="text-decoration-underline">Fare Rules</u>
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

            detailsHtml += `
            <div class="bg-light rounded-2 text-center text-danger p-2 mb-4">
                Ground Time at ${s.Destination.Airport.CityName}: ${groundTime}
            </div>`;
        }
    }

    detailsHtml += `</div>`;

    $('#titleSection').html(titledetailsHtml);
    $('#getSelectFlightDetails').html(detailsHtml);
}

function calculateGroundTime(prevArr, nextDep) {
    let diffMs = new Date(nextDep) - new Date(prevArr);
    let mins = Math.floor(diffMs / 60000);
    let h = Math.floor(mins / 60);
    let m = mins % 60;
    return `${h}h ${m}m`;
}

function generateTravelerForm(response) {
    let searchPayload = JSON.parse(localStorage.getItem('payload')) || {};
    let adults = searchPayload.AdultCount || 1;
    let children = searchPayload.ChildCount || 0;
    let infants = searchPayload.InfantCount || 0;

    let panRequired = response.IsPanRequiredAtBook || false;
    let passportRequired = response.IsPassportRequiredAtBook || false;


    function createTravelerForm(type, index) {
        // PAN field only for Adult
        let panField = '';
        if (type === 'Adult' && panRequired) {
            panField = `
                    <div class="col-md-6">
                        <label class="form-label">PAN Number ${panRequired ? '<span class="text-danger">*</span>' : ''}</label>
                        <input type="text" class="form-control ${panRequired ? 'required-field' : ''}" 
                            placeholder="Enter PAN Number" ${panRequired ? 'required' : ''}>
                    </div>`;
        }

        // Passport field for all
        let passportFields = '';
        if (passportRequired) {
            passportFields = `
                    <div class="col-md-6">
                        <label class="form-label">Passport Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control required-field" placeholder="Passport number" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Passport Expiry <span class="text-danger">*</span></label>
                        <input type="date" class="form-control required-field" required>
                    </div>`;
        }

        return `
            <div class="accordion-item mb-3 border rounded">
                <h6 class="accordion-header font-base" id="heading-${type}-${index}">
                    <button class="accordion-button fw-bold rounded collapsed" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapse-${type}-${index}"
                        aria-expanded="false" aria-controls="collapse-${type}-${index}">
                        ${type} ${index}
                    </button>
                </h6>
                <div id="collapse-${type}-${index}" class="accordion-collapse collapse"
                    aria-labelledby="heading-${type}-${index}" data-bs-parent="#travelerAccordion">
                    <div class="accordion-body mt-3">
                        <div class="row g-4 traveler-form" data-type="${type}">
                            <div class="col-md-3">
                                <label class="form-label">Title<span class="text-danger">*</span></label>
                                <select class="form-select required-field" name="titleName">
                                    <option value="">Select</option>
                                    <option value="Mr">Mr</option>
                                    <option value="Mrs">Mrs</option>
                                </select>
                            </div>
                            <div class="col-md-9">
                                <label class="form-label">Full name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control required-field" name="firstname" placeholder="First name">
                                    <input type="text" class="form-control required-field" name="lastname" placeholder="Last name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Date Of Birth</label>
                                <input type="date" class="form-control required-field" name="dob">
                            </div>
                             <div class="col-md-4">
                                <label class="form-label">Gender<span class="text-danger">*</span></label>
                                <select class="form-select required-field" name="gender">
                                    <option value="">Select</option>
                                    <option value="1">Male</option>
                                    <option value="2">Female</option>
                                    <option value="3">Other</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Nationality<span class="text-danger">*</span></label>
                                <select class="form-select required-field" name="nationality">
                                    <option value="">Select</option>
                                    <option value="IN">Indian</option>
                                    <option value="US">American</option>
                                </select>
                            </div>

                             <div class="col-md-4">
                                <label class="form-label">Address 1 <span class="text-danger">*</span></label>
                                <input type="text" class="form-control required-field" placeholder="Address 1" name="address1">
                            </div>
                             <div class="col-md-4">
                                <label class="form-label">Address 2</label>
                                <input type="text" class="form-control required-field" placeholder="Address 2" name="address2">
                            </div>
                            
                             <div class="col-md-4">
                                <label class="form-label">City<span class="text-danger">*</span></label>
                                <input type="text" class="form-control required-field" placeholder="City" name="city">
                            </div>
                            ${panField}
                            ${passportFields}
                        </div>
                    </div>
                </div>
            </div>`;
    }

    // Generate accordion forms
    let accordionHTML = '';
    for (let i = 1; i <= adults; i++) accordionHTML += createTravelerForm('Adult', i);
    for (let i = 1; i <= children; i++) accordionHTML += createTravelerForm('Child', i);
    for (let i = 1; i <= infants; i++) accordionHTML += createTravelerForm('Infant', i);

    $('#travelerAccordion').html(accordionHTML);

    // $('#noteSection').html(response.FirstNameFormat);
    $('#noteSection').html(`Canada: If Last Name is missing → use “LNU”. If First Name is missing → use “FNU”. Example: LNU/JEREMY MR, SMITH/FNU MR.
       <br/> UAE: Single-name passports not accepted. If only one full name → Last Name = full name, First Name = “FNU”. Example: MARYAM ALI/FNU MS.
        <br/>Australia/NZ: If only one name → repeat for both. Example: JONES/JONES MR.`);

    function checkFormComplete() {
        let allFilled = true;
        $('.required-field, .required-contact').each(function () {
            if (!$(this).val().trim()) {
                allFilled = false;
                return false;
            }
        });

        $('#proceedBtn').prop('disabled', !allFilled);
    }

    $(document).on('input change', '.required-field, .required-contact', checkFormComplete);

    $('#proceedBtn').on('click', function () {
        let allFilled = true;

        $('.required-field, .required-contact').each(function () {
            if (!$(this).val().trim()) {
                allFilled = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if (!allFilled) {
            notify('Please fill all required fields before proceeding.', 'error');
            return;
        }

        let travelers = [];
        $('.traveler-form').each(function () {
            let inputs = $(this).find('.required-field');
            travelers.push({
                type: $(this).data('type'),
                title: inputs.eq(0).val(),
                firstName: inputs.eq(1).val(),
                lastName: inputs.eq(2).val(),
                dob: inputs.eq(3).val(),
                gender: inputs.eq(4).val(),
                nationality: inputs.eq(5).val(),
                address1: inputs.eq(6).val(),
                address2: inputs.eq(7).val(),
                city: inputs.eq(8).val(),
                passportNo: inputs.eq(9).val(),
                passportExpiry: inputs.eq(10).val()
            });
        });
      


       



        localStorage.setItem('travelerDetails', JSON.stringify(travelers));
        localStorage.setItem('contactDetails', JSON.stringify({
            mobile: $('.required-contact').eq(0).val(),
            email: $('.required-contact').eq(1).val()
        }));

        window.location.href = "/flight/seatlayout";
    });
}


function getSSRDetails(resultIndex, traceId) {
    if (resultIndex && traceId) {
        $('#seatLayoutContainer').addClass('d-none');
        $('.preloader').removeClass('d-none');
        $.ajax({
            url: "/flight/ssr",
            method: "POST",
            data: {
                ResultIndex: resultIndex,
                TraceId: traceId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                $('#seatLayoutContainer').addClass('d-none');
                $('.preloader').removeClass('d-none');
            },
            complete: function () {
                $('#seatLayoutContainer').removeClass('d-none');
                $('.preloader').addClass('d-none');
            },
            success: function (response) {
                if (response.status == 'success') {

                    let searchPayload = JSON.parse(localStorage.getItem('payload')) || {};
                    let adults = parseInt(searchPayload.AdultCount) || 1;
                    let children = parseInt(searchPayload.ChildCount) || 0;
                    let infants = parseInt(searchPayload.InfantCount) || 0;

                    totalPassengers = adults + children + infants;


                    selectedMeals = [];
                    selectedBaggage = [];

                    let ssrDetails = response.data;
                    // Baggae Details
                    if (ssrDetails.Baggage && ssrDetails.Baggage.length > 0) {
                        let baggageHtml = '';

                        $.each(ssrDetails.Baggage, function (pIndex, passengerBaggage) {
                            if (!passengerBaggage || passengerBaggage.length === 0) return;

                            baggageHtml += `
                                        <div class="table-responsive mt-3">
                                            <table class="table table-bordered align-middle text-center mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Text</th>
                                                        <th>Description</th>
                                                        <th>Weight (kg)</th>
                                                        <th>Price</th>
                                                        <th>Select</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                            `;

                            $.each(passengerBaggage, function (index, baggage) {
                                let desc = '';
                                let waytype = '';
                                switch (baggage.Description) {
                                    case 1: desc = "Included (Can be upgraded)"; break;
                                    case 2: desc = "Direct (Purchase - Can't be upgraded)"; break;
                                    case 3: desc = "Imported"; break;
                                    case 4: desc = "UpGrade"; break;
                                    case 5: desc = "ImportedUpgrade"; break;
                                    default: desc = "NotSet"; break;
                                }

                                let priceText = baggage.Price == 0 ? "Included" : `${baggage?.Currency} ${baggage.Price}`;

                                if (baggage?.WayType == 1) {
                                    waytype = "Segment";
                                } else if (baggage?.WayType == 2) {
                                    waytype = "FullJourney ";
                                }
                                if (index == 0) {
                                    $('#baggageSectionHead').html(`${baggage?.Origin} - ${baggage?.Destination} [${baggage?.AirlineCode} - ${baggage?.FlightNumber}]
                                        <span class="badge bg-info">${waytype}</span>`);
                                }

                                baggageHtml += `
                                    <tr>
                                        <td>${baggage?.Text ?? '-'}</td>
                                        <td>${baggage?.Code} - ${desc}</td>
                                        <td>${baggage.Weight || '0'} Kg</td>
                                        <td>${priceText}</td>
                                        <td>
                                            <input type="checkbox" name="baggage-checkbox" 
                                            data-code="${baggage?.Code}" 
                                            data-price="${priceText}"  
                                            data-description="${baggage?.Description}"
                                            data-bagobjdata='${JSON.stringify(baggage)}'>
                                        </td>
                                    </tr>
                                `;
                            });

                            baggageHtml += `
                                                </tbody>
                                            </table>
                                             <small class="text-muted d-block mt-1 text-end">
                                                <span class="baggage-count">0</span> / ${totalPassengers} selected
                                            </small>
                                        </div>
                            `;
                        });

                        $("#baggageContainer").html(baggageHtml);
                    } else {
                        $("#baggageContainer").html(`
                            <div class="alert alert-warning text-center mb-0">
                                No baggage options available for this flight.
                            </div>
                        `);
                    }

                    // Meal Details
                    if (ssrDetails.Meal && ssrDetails.Meal.length > 0) {
                        let mealHtml = '';

                        $.each(ssrDetails.Meal, function (pIndex, passengerMeal) {
                            if (!passengerMeal || passengerMeal.length === 0) return;

                            mealHtml += `
                                        <div class="table-responsive mt-3">
                                            <table class="table table-bordered align-middle text-center mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Text</th>
                                                        <th>Description</th>
                                                        <th>Quantity</th>
                                                        <th>Price</th>
                                                        <th>Select</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                            `;

                            $.each(passengerMeal, function (index, meal) {
                                let desc = '';
                                let waytype = '';
                                switch (meal.Description) {
                                    case 1: desc = "The fare includes the Meal"; break;
                                    case 2: desc = "The Meal charges are added while making the ticket"; break;
                                    case 3: desc = "Meal charges are added while importing the ticket"; break;
                                    default: desc = "NotSet"; break;
                                }

                                let priceText = meal.Price == 0 ? "Included" : `${meal?.Currency} ${meal.Price}`;

                                if (meal?.WayType == 1) {
                                    waytype = "Segment";
                                } else if (meal?.WayType == 2) {
                                    waytype = "FullJourney ";
                                }
                                if (index == 0) {
                                    $('#mealSectionHead').html(`${meal?.Origin} - ${meal?.Destination} [${meal?.AirlineCode} - ${meal?.FlightNumber}]
                                        <span class="badge bg-info">${waytype}</span>`);
                                }

                                mealHtml += `
                                    <tr>
                                        <td>${meal?.AirlineDescription || 'No Meal'}</td>
                                        <td>${meal?.Code} - ${desc}</td>
                                        <td>${meal.Quantity || '0'} </td>
                                        <td>${priceText}</td>
                                        <td>
                                            <input type="checkbox" name="meal-checkbox" 
                                            data-code="${meal?.Code}" 
                                            data-price="${priceText}" 
                                            data-description="${meal?.Description}"
                                            data-mealobjdata='${JSON.stringify(meal)}'>
                                        </td>
                                    </tr>
                                `;
                            });

                            mealHtml += `
                                                </tbody>
                                            </table>
                                             <small class="text-muted d-block mt-1 text-end">
                                                <span class="meal-count">0</span> / ${totalPassengers} selected
                                            </small>
                                        </div>
                            `;
                        });

                        $("#mealContainer").html(mealHtml);
                    } else {
                        $("#mealContainer").html(`
                            <div class="alert alert-warning text-center mb-0">
                                No Meal options available for this flight.
                            </div>
                        `);
                    }

                    if (ssrDetails?.SeatDynamic && ssrDetails?.SeatDynamic.length > 0) {
                        renderSeatLayout(ssrDetails?.SeatDynamic, totalPassengers);
                    } else {
                        $("#mainPlaneWrapper").html(`<div class="alert alert-danger">No seat layout found</div>`);
                    }

                    // Baggage checkbox handler
                    $(document).on('change', 'input[name="baggage-checkbox"]', function () {
                        let checkedCount = $('input[name="baggage-checkbox"]:checked').length;

                        if ($(this).is(':checked')) {
                            if (checkedCount > totalPassengers) {
                                $(this).prop('checked', false);
                                notify(`You can select baggages only for ${totalPassengers} passenger(s).`, 'error');
                                return;
                            }

                            let bdesc = $(this).data('description');
                            let bagDesc = '';
                            if (bdesc == 1) {
                                bagDesc = 'Included (The fare includes the Baggage)';
                            } else if (bdesc == 2) {
                                bagDesc = 'Direct (The Baggage charges are added while making the ticket)';
                            } else if (bdesc == 3) {
                                bagDesc = 'Imported (Baggage charges are added while importing the ticket.)';
                            }


                            // 🟢 Add selected baggage details to array
                            let baggageData = {
                                Code: $(this).data('code'),
                                price: $(this).data('price'),
                                Description: bdesc,
                                bagObjData: $(this).data('bagobjdata')
                            };
                            selectedBaggage.push(baggageData);

                        } else {
                            // 🔴 Remove unselected baggage from array
                            let codeToRemove = $(this).data('code');
                            selectedBaggage = selectedBaggage.filter(baggage => baggage.Code !== codeToRemove);
                        }

                        // 🧮 Update selected count display
                        $('.baggage-count').text(selectedBaggage.length);
                        updateSummaryUI();
                    });


                    $(document).on('change', 'input[name="meal-checkbox"]', function () {
                        let checkedCount = $('input[name="meal-checkbox"]:checked').length;


                        if ($(this).is(':checked')) {
                            if (checkedCount > totalPassengers) {
                                $(this).prop('checked', false);
                                notify(`You can select meals only for ${totalPassengers} passenger(s).`, 'error');
                                return;
                            }
                            let mdesc = $(this).data('description');
                            let mealDesc = '';
                            if (mdesc == 1) {
                                mealDesc = 'Included (The fare includes the Meal)';
                            } else if (mdesc == 2) {
                                mealDesc = 'Direct (The Meal charges are added while making the ticket)';
                            } else if (mdesc == 3) {
                                mealDesc = 'Imported (Meal charges are added while importing the ticket.)';
                            }

                            // 🟢 Add selected meal details to array
                            let mealData = {
                                Code: $(this).data('code'),
                                price: $(this).data('price'),
                                Description: mdesc,
                                mealObjData: $(this).data('mealobjdata')
                            };
                            selectedMeals.push(mealData);

                        } else {
                            // 🔴 Remove unselected meal from array
                            let codeToRemove = $(this).data('code');
                            selectedMeals = selectedMeals.filter(meal => meal.Code !== codeToRemove);
                        }

                        // 🧮 Update selected count display
                        $('.meal-count').text(selectedMeals.length);
                        updateSummaryUI();
                    });

                } else {
                    $("#baggageContainer").html(`<div class="alert alert-danger">Baggage Not Found</div>`);
                    $("#mealContainer").html(`<div class="alert alert-danger">Meal Not Found</div>`);
                    $("#mainPlaneWrapper").html(`<div class="alert alert-danger">Seat Layout Not found</div>`);
                }
            },
            error: function (xhr) {
                notify("Failed to fetch fare quote. Please try again.", "error");
            }
        });

    }
}

function renderSeatLayout(seatDynamicData, totalPassengers) {

    $("#flightContainer").html("");
    $("#mainPlaneWrapper").html("");

    if (!seatDynamicData || seatDynamicData.length === 0) {
        $("#mainPlaneWrapper").html("<p class='text-danger'>No seat layout found.</p>");
        return;
    }

    // SeatDynamic → SegmentSeat → RowSeats
    const segmentSeats = seatDynamicData[0]?.SegmentSeat || [];

    // 🔥 Segment-wise seat selection storage
    selectedSeats = {};
    segmentSeats.forEach((s, i) => selectedSeats[i] = []);


    segmentSeats.forEach((segment, segIndex) => {

        let planeHtml = `
            <div class="plane-container mb-2 border">

                <div class="section" style="border-right:1px solid grey;padding-right:10px">
                    <div class="exit">EXIT</div>
                    <div class="lavatory fs-4">👨‍✈️</div>
                    <div class="exit">EXIT</div>
                </div>

                <div style="display:flex; flex-direction:row;" id="planeContainer_${segIndex}">
                </div>

                <div class="section">
                    <div class="exit">EXIT</div>
                    <div class="lavatory fs-5"><i class="fa-solid fa-person-dress"></i><i class="fa-solid fa-person-dress"></i></div>
                    <div class="exit">EXIT</div>
                </div>
            </div>
        `;

        $("#mainPlaneWrapper").append(planeHtml);

        segment.RowSeats.forEach((row, rowIndex) => {

            let rowDiv = $('<div class="seat-row justify-content-center mb-2"></div>');

            row.Seats.forEach((seat, idx) => {


                let isUnavailable = '';
                let bgColor = '';
                let cursor = 'pointer';

                if (seat.AvailablityType == 1) {
                    isUnavailable = "Open";
                    bgColor = "#4caf50";
                } else if (seat.AvailablityType == 3) {
                    isUnavailable = "Reserved";
                    bgColor = "#ff9800";
                } else if (seat.AvailablityType == 4) {
                    isUnavailable = "Blocked";
                    bgColor = "#f44336";
                    cursor = "not-allowed";
                } else if (seat.AvailablityType == 5) {
                    isUnavailable = "NoSeatAtThisLocation";
                    bgColor = "#000000";
                    cursor = "not-allowed";
                } else {
                    isUnavailable = "Not Set";
                    bgColor = "#9e9e9e";
                    cursor = 'not-allowed';
                }

                let seattype = '';
                if (seat?.seatType == 1) {
                    seattype = 'Window';
                } else if (seat?.seatType == 2) {
                    seattype = 'Aisle';
                } else if (seat?.seatType == 3) {
                    seattype = 'Middle';
                } else {
                    seattype = 'Normal';
                }

                let waytpe = '';

                if (seat?.SeatWayType == 1) {
                    waytpe = 'Segment';
                } else if (seat?.SeatWayType == 2) {
                    waytpe = 'FullJourney';
                }


                let seatDiv = $(`
                    <div class="seat ${isUnavailable} mx-1 text-center" 
                    title="${seat?.AirlineCode} - ${seat?.FlightNumber} |  ${seat.Code} | ${seat?.Origin} - ${seat?.Destination} | ${seat?.Currency} ${seat?.Price} | 
                    ${isUnavailable} | ${seattype} | ${waytpe} 
                    | Compartment${seat?.Compartment} | Deck${seat?.Deck}"
                        data-code="${seat.Code}"
                        data-price="${seat.Price}"
                        data-availability="${seat.AvailablityType}"
                        data-segment="${segIndex}"
                        data-description="${seat.Description}"
                        data-seatobjdata='${JSON.stringify(seat)}'
                        style="width:35px; height:35px; line-height:35px; border:1px solid #ccc; border-radius:5px; cursor:${cursor};background:${bgColor};">
                        ${seat.RowNo != 0 ? seat?.RowNo : '<span class="text-danger">X</span>'}${seat.SeatNo || ''}
                    </div>
                `);

                seatDiv.on("click", function () {

                    const avail = $(this).data("availability");
                    if (avail != 1) return;

                    const seg = $(this).data("segment");
                    const code = $(this).data("code");
                    const price = parseFloat($(this).data("price") || 0);
                    const description = $(this).data("description");
                    const SeatObjData = $(this).data("seatobjdata");

                    let desc = '';
                    if (description == 1) {
                        desc = 'Included (The fare includes the Seat)';
                    } else if (description == 2) {
                        desc = 'Purchase (The Seat charges are added while making the ticket)';
                    }

                    let segmentSelected = selectedSeats[seg];

                    const found = segmentSelected.find(s => s.Code === code);

                    if (found) {
                        // remove
                        selectedSeats[seg] = segmentSelected.filter(s => s.Code !== code);
                        $(this).removeClass("selected").css({ background: "#4caf50" });
                    } else {
                        if (segmentSelected.length >= totalPassengers) {
                            notify(`You can select only ${totalPassengers} seat(s) in this segment.`, "error");
                            return;
                        }
                        // add
                        segmentSelected.push({
                            Code: code,
                            Description: description,
                            price: price,
                            SeatObjData: SeatObjData
                        });

                        $(this).addClass("selected").css({ background: "#007bff" });
                    }

                    updateSummaryUI(selectedSeats);
                });

                rowDiv.append(seatDiv);
                if (idx === 2) rowDiv.append("<br>");
            });

            $(`#planeContainer_${segIndex}`).append(rowDiv);
        });
    });
}


function updateSummaryUI() {
    // const seatsCount = selectedSeats?.length || 0;
    // const totalSeatPrice = selectedSeats.reduce((sum, item) => {

    //     let price = parseFloat(item.price?.toString().replace(/[^\d.]/g, '')) || 0;
    //     return sum + price;
    // }, 0);


    let totalSeatPrice = 0;
    let seatsCount = 0;

    // ---- SEAT SUMMARY (segment-wise object) ----
    if (selectedSeats && typeof selectedSeats === "object") {
        Object.values(selectedSeats).forEach(segmentArray => {
            segmentArray.forEach(item => {
                seatsCount++;

                let price = parseFloat(item.price?.toString().replace(/[^\d.]/g, '')) || 0;
                totalSeatPrice += price;
            });
        });
    }

    // Meal Summary
    const mealsCount = selectedMeals?.length || 0;
    const totalMealPrice = selectedMeals.reduce((sum, item) => {
        let price = 0;
        if (item.price && item.price.toLowerCase() !== 'included') {
            price = parseFloat(item.price.toString().replace(/[^\d.]/g, '')) || 0;
        }
        return sum + price;
    }, 0);

    // Baggage Summary
    const baggageCount = selectedBaggage?.length || 0;
    const totalBaggagePrice = selectedBaggage.reduce((sum, item) => {
        let price = 0;
        if (item.price && item.price.toLowerCase() !== 'included') {
            price = parseFloat(item.price.toString().replace(/[^\d.]/g, '')) || 0;
        }
        return sum + price;
    }, 0);

    localStorage.setItem('selectedmeal', JSON.stringify(selectedMeals));
    localStorage.setItem('selectedBaggage', JSON.stringify(selectedBaggage));
    localStorage.setItem('selectedSeat', JSON.stringify(selectedSeats));

    // $("#totalSeats").text(seatsCount);
    $("#totalSeatPrice").text(`₹${totalSeatPrice.toFixed(2)}`);
    $("#totalMealPrice").text(`₹${totalMealPrice.toFixed(2)}`);
    $("#totalBaggagePrice").text(`₹${totalBaggagePrice.toFixed(2)}`);
}


$('#proceedBookingBtn').on('click', function () {

    swal({
        title: "Are you sure?",
        text: "Do you want to proceed with booking?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Proceed",
        cancelButtonText: "Cancel"
    }).then((result) => {

        
        if (result.value) {

            swal({
                title: "Redirecting...",
                text: "Taking you to the booking page.",
                type: "success",
                timer: 1200,
                showConfirmButton: false
            });

            window.location.href = "/flight/booking";
        }

    });

});

function hitBookingAPI() {
    const selectedFlightDetails = JSON.parse(localStorage.getItem('selectedFlightDetails'));
    const travelerDetails = JSON.parse(localStorage.getItem('travelerDetails'));
    const contactDetails = JSON.parse(localStorage.getItem('contactDetails'));
    const selectedSeats = JSON.parse(localStorage.getItem('selectedSeat')) || [];
    const selectedMeals = JSON.parse(localStorage.getItem('selectedmeal')) || [];
    const selectedBaggage = JSON.parse(localStorage.getItem('selectedBaggage')) || [];
    const traceId = localStorage.getItem('TraceId') || '';

    const formatDate = (date) => date ? `${date}T00:00:00` : null;

    const mapSeatsToPassengers = (seatData, numPassengers) => {
        const passengersSeats = Array.from({ length: numPassengers }, () => []);
        Object.values(seatData).forEach(seatArray => {
            seatArray.forEach((seatObj, index) => {

                if (index < numPassengers) {
                    // const { price, ...rest } = seatObj; // remove price
                    passengersSeats[index].push(seatObj?.SeatObjData);
                }
            });
        });
        return passengersSeats;
    };

    const numPassengers = travelerDetails.length;
    const passengerSeats = mapSeatsToPassengers(selectedSeats, numPassengers);

    const getForPassenger = (arr, i) => {
        if (arr.length === 0) return null;
        if (arr.length === 1 && i > 0) return null;
        return arr[i] || null;
    };

    const passengers = travelerDetails.map((trav, index) => {
        const passenger = {
            Title: trav.title,
            FirstName: trav.firstName,
            LastName: trav.lastName,
            PaxType: trav.type === "Child" ? 2 : trav.type === "Infant" ? 3 : 1,
            DateOfBirth: formatDate(trav.dob),
            Gender: trav.gender,
            PassportNo: trav.passportNo || "",
            PassportExpiry: formatDate(trav.passportExpiry),
            AddressLine1: trav.address1 || "",
            AddressLine2: trav.address2 || "",
            City: trav.city || "",
            CountryCode: trav.nationality || "IN",
            Nationality: trav.nationality || "IN",
            ContactNo: contactDetails.mobile,
            Email: contactDetails.email,
            IsLeadPax: index === 0,
            Fare: selectedFlightDetails?.Fare || {}
        };

        const seat = passengerSeats[index] || [];
        const meal = removeExtraKey(getForPassenger(selectedMeals, index), 'meal');
        const baggage = removeExtraKey(getForPassenger(selectedBaggage, index), 'baggage');


        const seatData = seat.length === 1 ? seat[0] : seat;
        return {
            ...passenger,
            ...(seat.length ? { SeatDynamic: seatData } : {}),
            ...(meal != null ? { Meal: meal.mealObjData } : {}),
            ...(baggage != null ? { Baggage: baggage.bagObjData } : {}),
        };
    });


    const payload = {
        resultIndex: selectedFlightDetails?.ResultIndex,
        passengers: passengers,
        traceId: traceId,
        _token: $('meta[name="csrf-token"]').attr('content')
    };

    if (selectedFlightDetails?.IsLCC) {
        ViewTicketAjax(payload);
    } else {
        $('#bookingData').addClass('d-none');
        $('.preloader').removeClass('d-none');
        $.ajax({
            url: '/flight/book',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(payload),
            beforeSend: function () {
                $('#bookingData').addClass('d-none');
                $('.preloader').removeClass('d-none');
            },
            complete: function () {
                $('#bookingData').removeClass('d-none');
                $('.preloader').addClass('d-none');
            },
            success: function (response) {
                if (response?.status == 'success') {
                    const bookingData = response?.data?.Response?.Response;

                    swal({
                        title: "Booking Successful!",
                        html: `
                    <p>${response?.message || "Your ticket has been booked successfully 🎉"}</p>
                    <p><strong>PNR:</strong> ${bookingData?.PNR || "Not Available"}</p>
                    <p><strong>Booking Id:</strong> ${bookingData?.BookingId || "Not Available"}</p>
                `,
                        type: "success",
                        confirmButtonText: "OK, I got it",
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then(() => {
                        renderFareSummary(bookingData);
                        renderBookingDetails(bookingData);
                    });
                } else {
                    swal({
                        title: "Error",
                        text: response.message || "Something went wrong while booking.",
                        type: "error"
                    }).then(() => {
                        window.location.href = "/";
                    });
                }


            },
            error: function (err) {
                swal({
                    title: "Error",
                    text: "Something went wrong while booking.",
                    type: "error"
                });
            }
        });
    }
}

function ViewTicketAjax(payload) {
    $('#bookingData').addClass('d-none');
    $('.preloader').removeClass('d-none');
    $.ajax({
        url: '/flight/ticket',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(payload),
        beforeSend: function () {
            $('#bookingData').addClass('d-none');
            $('.preloader').removeClass('d-none');
        },
        complete: function () {
            $('#bookingData').removeClass('d-none');
            $('.preloader').addClass('d-none');
        },
        success: function (response) {
            if (response?.status == 'success') {
                const bookingData = response?.data?.Response?.Response;

                swal({
                    title: "Booking Successful!",
                    html: `
                    <p>${response?.message || "Your ticket has been booked successfully 🎉"}</p>
                    <p><strong>PNR:</strong> ${bookingData?.PNR || "Not Available"}</p>
                    <p><strong>Booking Id:</strong> ${bookingData?.BookingId || "Not Available"}</p>
                `,
                    type: "success",
                    confirmButtonText: "OK, I got it",
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then(() => {
                    renderFareSummary(bookingData);
                    renderBookingDetails(bookingData);
                });
            } else {
                swal({
                    title: "Error",
                    text: response.message || "Something went wrong while booking.",
                    type: "error"
                }).then(() => {
                    window.location.href = "/";
                });
            }


        },
        error: function (err) {
            swal({
                title: "Error",
                text: "Something went wrong while booking.",
                type: "error"
            });
        }
    });
}


function removeExtraKey(obj, keys) {
    if (keys === 'baggage') {
        if (!obj) return null;
        const { bagObjData } = obj;
        return { bagObjData };
    } else if (keys === 'meal') {
        if (!obj) return null;
        const { mealObjData } = obj;
        return { mealObjData };
    }

}

function renderFareSummary(data) {
    const fare = data?.FlightItinerary?.Fare || {};

    $("#fareBaseFare").text("₹" + fare.BaseFare || 0);
    $("#fareDiscount").text("₹" + fare.Discount || 0);
    $("#fareOther").text("₹" + fare.OtherCharges || 0);
    $("#fareTax").text("₹" + fare.Tax || 0);
    $("#fareTotal").text("₹" + fare.PublishedFare || 0);
}

function renderBookingDetails(data) {

    $("#pnrText").text(data?.PNR || "Not Available");
    $("#bookingId").text(data?.BookingId || "Not Available");

    const itinerary = data?.FlightItinerary;
    const src = itinerary?.Origin || "--";
    const dest = itinerary?.Destination || "--";
    const priceChange = data?.IsPriceChanged || "--";
    const timeChange = data?.IsTimeChanged || "--";
    const ssrDenied = data?.SSRDenied || "--";

    $("#routeText").html(`${src} <i class="ti ti-arrow-right"></i> ${dest}`);


    $("#flightDate").text(itinerary?.TravelDate || "--");

    // ---------- Stops ----------
    const stops = itinerary?.StopCount ?? 0;
    $("#flightStops").text(stops === 0 ? "Non-stop" : `${stops} Stop`);

    // ---------- Duration ----------
    $("#flightDuration").text(itinerary?.Duration || "--");


    $("#segmentList").html("");
    $("#fareRuleList").html("");
    $("#fareRuleListModal").html("");

    itinerary?.Segments.map((seg, index) => {

        let origin = seg?.Origin?.Airport;
        let dest = seg?.Destination?.Airport;

        // Dates & times
        let dep = new Date(seg?.Origin?.DepTime || "");
        let arr = new Date(seg?.Destination?.ArrTime || "");

        let depTime = dep.toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" });
        let arrTime = arr.toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" });

        let depDate = dep.toLocaleDateString();
        let arrDate = arr.toLocaleDateString();

        // Duration format
        let durationMin = seg?.Duration || 0;
        let durationH = Math.floor(durationMin / 60);
        let durationM = durationMin % 60;

        $("#segmentList").append(`
                <div class="card-body p-4 border mb-4 rounded-3">

                <div class="row g-4 ">
                    <div class="col-md-3 pt-5">
                        ✈️
                        <h6 class="fw-normal mb-0">${seg?.Airline?.AirlineName || ""}</h6>
                        <h6 class="fw-normal mb-0">(${seg?.Airline?.AirlineCode} - ${seg?.Airline?.FlightNumber})</h6>
                    </div>

                    <div class="col-sm-4 col-md-3">
                        <h4>${origin?.AirportCode}</h4>
                        <h6>${depTime}</h6>
                        <p>${depDate}</p>
                        <p>${origin?.CityName}</p>
                        <p>Terminal: ${origin?.Terminal || "N/A"}</p>
                    </div>

                    <div class="col-sm-4 col-md-3 text-center my-sm-auto">
                        <h5>${durationH}h ${durationM}m</h5>

                        <div class="position-relative my-4">
                            <hr class="bg-primary opacity-5 position-relative">
                            <div class="icon-md bg-primary text-white rounded-circle position-absolute top-50 start-50 translate-middle p-2">
                                <i class="fa-solid fa-plane"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 col-md-3 text-end">
                        <h4>${dest?.AirportCode}</h4>
                        <h6>${arrTime}</h6>
                        <p>${arrDate}</p>
                        <p>${dest?.CityName}</p>
                        <p>Terminal: ${dest?.Terminal || "N/A"}</p>
                    </div>
                </div>

                ${seg?.GroundTime > 0 ? `
                <div class="bg-light rounded-2 text-center text-danger p-2 mb-4">
                    Ground Time at ${dest?.CityName}: ${Math.floor(seg.GroundTime / 60)}h ${seg.GroundTime % 60}m
                </div>` : ""}
            </div>
        `);
    });

    let fareRules = itinerary.FareRules.length > 0 ? itinerary.FareRules : [];

    let fareRulesHTML = "";

    let passengerHTMLModalShow = "";

    if (fareRules.length > 0) {

        fareRules.forEach((rule, i) => {

            fareRulesHTML += `
                    <div class="card border rounded p-2 mb-2">
                        <b>Rule ${i + 1} [${rule?.Origin} → ${rule?.Destination}]</b><br>
                        Airline: ${rule.Airline ?? 'N/A'} [${rule?.FareFamilyCode}]<br>
                        Fare Basis: ${rule.FareBasisCode ?? 'N/A'}<br>
                        Rule: <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#fareRuleModal${i + 1}">View Fare rule ${i + 1}</button>
                    </div>
            `;

            passengerHTMLModalShow += `
                <div class="modal fade" id="fareRuleModal${i + 1}" data-bs-backdrop="static">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">Fare Rule ${i + 1}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <p>${rule.FareRuleDetail ?? 'No Rule Found.'}</p>
                            </div>

                        </div>
                    </div>
                </div>
            `;
        });

    } else {
        fareRulesHTML = `<p>No fare rules found.</p>`;
    }

    $("#fareRuleList").html(fareRulesHTML);
    $("#fareRuleListModal").html(passengerHTMLModalShow);
    // ---------- Traveler List ----------
    $("#travelerList").empty();

    let passengers = Array.isArray(itinerary.Passenger) ? itinerary.Passenger : [];
    let passengerHTML = "";

    if (passengers.length > 0) {

        passengerHTML += `<h5 class="mt-3 mb-3">Passenger Details</h5>`;

        passengers.forEach((pax, i) => {

            let fullName = `${pax.Title ?? ''} ${pax.FirstName ?? ''} ${pax.LastName ?? ''}`.trim();

            let paxType = pax.PaxType === 1 ? "Adult" :
                pax.PaxType === 2 ? "Child" :
                    pax.PaxType === 3 ? "Infant" : "Unknown";

            let gender = pax.Gender === 1 ? "Male" :
                pax.Gender === 2 ? "Female" :
                    "Other";

            let dob = pax.DateOfBirth ? pax.DateOfBirth.split("T")[0] : "N/A";

            // Baggage
            let baggageInfo = "";
            if (Array.isArray(pax.Baggage) && pax.Baggage.length > 0) {
                baggageInfo = pax.Baggage.map(b => `${b.Weight ?? 'N/A'} ${b.Unit ?? ''}`).join(", ");
            } else {
                baggageInfo = "Included";
            }

            // Fare
            let fare = pax.Fare ?? {};
            let baseFare = fare.BaseFare ?? 0;
            let tax = fare.Tax ?? 0;
            let other = fare.OtherCharges ?? 0;
            let discont = fare.Discount ?? 0;
            let total = fare.TotalFare ?? (baseFare + tax);

            // Barcode
            let barcode = "N/A";
            if (
                pax.BarcodeDetails &&
                pax.BarcodeDetails.Barcode &&
                pax.BarcodeDetails.Barcode.length > 0
            ) {
                barcode = pax.BarcodeDetails.Barcode[0].Content ?? "N/A";
            }


            passengerHTML += `
            <div class="border rounded p-3 mb-3 bg-light">

                <div class="d-flex justify-content-between">
                    <h6><b>Passenger ${i + 1} - ${paxType}</b></h6>
                    ${pax.IsLeadPax ? '<span class="badge bg-primary">Lead Passenger</span>' : ''}
                </div>

                <div class="row mt-2">

                    <div class="col-md-7">

                        <p><b>Name:</b> ${fullName}</p>
                        <p><b>Gender:</b> ${gender}</p>
                        <p><b>Date of Birth:</b> ${dob}</p>

                        <p><b>Contact:</b> ${pax.ContactNo ?? 'N/A'}</p>
                        <p><b>Email:</b> ${pax.Email ?? 'N/A'}</p>

                        <p><b>Nationality:</b> ${pax.Nationality ?? 'N/A'}</p>

                        <p><b>Address:</b> 
                            ${pax.AddressLine1 ?? ''}, 
                            ${pax.AddressLine2 ?? ''}, 
                            ${pax.City ?? ''}, 
                            ${pax.CountryCode ?? ''}
                        </p>

                        <p><b>Baggage:</b> ${baggageInfo}</p>

                        <p><b>Barcode:</b> <br>
                           <div class="barcode-box mt-2">
                                <canvas id="barcodeCanvas${i}" class="barcode-canvas"></canvas>
                            </div>


                        </p>

                    </div>

                    
                    <div class="col-md-5">
                     <div class="card">
                            <div class="card-body">
                                    <ul class="list-group list-group-borderless">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="h6 fw-normal mb-0">Base Fare
                                            </span>
                                            <span class="fs-5">₹${baseFare}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="h6 fw-normal mb-0">Discount</span>
                                            <span class="fs-5 text-success">₹${discont}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="h6 fw-normal mb-0">Tax</span>
                                            <span class="fs-5 text-success">₹${tax}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="h6 fw-normal mb-0">Other Services</span>
                                            <span class="fs-5">₹${other}</span>
                                        </li>
                                    </ul>
                                </div>

                                <div class="card-footer border-top">
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <span class="h5 fw-normal mb-0">Total Fare</span>
                                        <span class="h5 fw-normal mb-0">₹${total}</span>
                                    </div>
                                </div>
                            </div>
                    </div>

                </div>

            </div>
        `;
            setTimeout(() => makeBarcode(i, barcode), 100);
        });

    } else {
        passengerHTML = `<p>No passenger details found.</p>`;
    }


    $('#travelerList').html(passengerHTML);
    // ---------- Show Box ----------
    $("#bookingSummaryCard").show();
}

function makeBarcode(i, barcode) {
    const canvas = document.getElementById("barcodeCanvas" + i);

    if (!canvas) return;

    try {
        bwipjs.toCanvas(canvas, {
            bcid: 'pdf417',
            text: barcode,
            scale: 2,
            height: 8,
            columns: 6,
            rows: 3,
            includetext: false,
            paddingwidth: 10,
            paddingheight: 10,
        });
    } catch (e) {
        $(canvas).replaceWith(`<code class="text-primary">${barcode}</code>`);
    }
}


// Roundtrip code are start
$(document).on("click", "#flightTabs .nav-link", function () {

    $("#flightTabs .nav-link").removeClass("active");
    $(this).addClass("active");

    let type = $(this).data("type");
    roundtripFlightResults(type);
});

function roundtripFlightResults(data) {
    let results = data.Results || [];

    if (results.length < 2) {
        notify("Invalid roundtrip response!", "error");
        return;
    }
    $("#roundTabs").removeClass("d-none");
    window.roundData = results;

    renderRoundList(0);
}

$("#tabDeparture").on("click", function () {
    $(".nav-link").removeClass("active");
    $(this).addClass("active");
    renderRoundList(0);
});

$("#tabReturn").on("click", function () {
    $(".nav-link").removeClass("active");
    $(this).addClass("active");
    renderRoundList(1);
});

function renderRoundList(index) {
    $("#search_flight_list").html("");

    let groups = window.roundData[index] || [];

    let html = "";
    groups.forEach((flight, j) => {
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
                                <div class="card border mb-3">
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
                                                <input type="radio" 
                                                        name="select_flight_${index}" 
                                                        class="select-flight"
                                                        data-flight='${encodeURIComponent(JSON.stringify(flight))}'
                                                        style="transform: scale(1.4); cursor: pointer;">
                                                    <label class="ms-1">Select</label>

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
}



