function totalRoomsAndGuest() {
    const rooms = parseInt($("#room").text());
    const adults = parseInt($("#adult").text());
    const children = parseInt($("#children").text());

    document.getElementById("guestAndRooms").value = `${rooms} Room / ${adults + children} Guests`;
}

$(document).ready(function () {
    const maxRooms = 6;
    const maxAdults = 48;
    const maxChildren = 24;
    const minRooms = 1;
    const maxAdultsPerRoom = 8;
    const maxChildrenPerRoom = 4;

    function updateRoomAndGuestSummary() {
        const rooms = parseInt($("#room").text());
        const adults = parseInt($("#adult").text());
        const children = parseInt($("#children").text());
        $("#guestAndRooms").val(`${rooms} Room${rooms > 1 ? "s" : ""} / ${adults + children} Guest${adults + children > 1 ? "s" : ""}`);
    }
    function adjustRoomCount() {
        const adults = parseInt($("#adult").text());
        const requiredRooms = Math.ceil(adults / maxAdultsPerRoom);
        const currentRooms = parseInt($("#room").text());

        if (requiredRooms > currentRooms) {
            $("#room").text(Math.min(requiredRooms, maxRooms));
        }
    }
    function createChildAgeDropdown(count) {
        const container = $("#child-age-container");
        const existingDropdowns = container.find(".child-age-dropdown");
        existingDropdowns.remove();

        for (let i = 1; i <= count; i++) {
            container.append(`
                <div class="row align-items-center child-age-dropdown mb-2">
                    <div class="col-sm-7">
                        <p class="mb-sm-0">Child ${i} Age</p>
                    </div>
                    <div class="col-sm-5">
                        <select class="form-control child-age-select">
                            ${[...Array(18).keys()].map(age => `<option value="${age}">${age}</option>`).join('')}
                        </select>
                    </div>
                </div>
            `);
        }
    }

    function increment(elementId, maxValue) {
        const element = $(`#${elementId}`);
        let currentValue = parseInt(element.text());

        if (currentValue < maxValue) {
            element.text(++currentValue);

            if (elementId === "adult") {
                adjustRoomCount();
            } else if (elementId === "children") {
                createChildAgeDropdown(currentValue);
            }
        }
        updateRoomAndGuestSummary();
    }
    function decrement(elementId, minValue) {
        const element = $(`#${elementId}`);
        let currentValue = parseInt(element.text());

        if (currentValue > minValue) {
            element.text(--currentValue);

            if (elementId === "children") {
                createChildAgeDropdown(currentValue);
            }
        }
        updateRoomAndGuestSummary();
    }

    window.increment3 = function () { increment("room", maxRooms); };
    window.decrement3 = function () { decrement("room", minRooms); };

    window.increment1 = function () { increment("adult", maxAdults); };
    window.decrement1 = function () { decrement("adult", minRooms); };

    window.increment2 = function () { increment("children", maxChildren); };
    window.decrement2 = function () { decrement("children", 0); };

    $(".submit-done").on("click", function () {
        const rooms = parseInt($("#room").text());
        const adults = parseInt($("#adult").text());
        const children = parseInt($("#children").text());
        const childAges = $(".child-age-select").map((_, el) => $(el).val()).get();

        document.getElementById("guestAndRooms").value = `${room} Rooms, ${adult + children
            } Guests`;
        $('.travellers-dropdown').removeClass('show');
    });

    updateRoomAndGuestSummary();
    createChildAgeDropdown(0);



    $(function () {

        $("#checkin").datepicker({
            minDate: new Date(),
            'autoclose': true,
            'clearBtn': true,
            'todayHighlight': true,
            'format': 'dd-mm-yyyy', //yyyy-mm-dd
            startDate: new Date()
        });


        $("#checkout").datepicker({
            minDate: new Date(),
            'autoclose': true,
            'clearBtn': true,
            'todayHighlight': true,
            'format': 'dd-mm-yyyy', //yyyy-mm-dd
            startDate: new Date()
        })

        var today = new Date();
        const day = String(today.getDate()).padStart(2, '0');
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const year = today.getFullYear();
        const formattedDate = `${day}-${month}-${year}`;
        $("#checkin").datepicker("setDate", formattedDate);


        const tomorrow = new Date(today);
        tomorrow.setDate(today.getDate() + 1);
        const nextDay = String(tomorrow.getDate()).padStart(2, '0');
        const nextMonth = String(tomorrow.getMonth() + 1).padStart(2, '0');
        const nextYear = tomorrow.getFullYear();
        const formattedNextDate = `${nextDay}-${nextMonth}-${nextYear}`;

        $("#checkout").datepicker("setDate", formattedNextDate);
    });
});


function searchHotel() {
    $(".preview-card-body").children().remove();
    $(".preview-card-body-calender").empty();
    $(".preview-card-side").children().remove();

    let destid = $("#hotelCode").val();
    var destname = $('#hotelCode').find('option:selected').text();

    const rooms = parseInt($("#room").text());
    const adults = parseInt($("#adult").text());
    const children = parseInt($("#children").text());

    let checkin = $("#checkin").val();
    let checkout = $("#checkout").val();
    const childAge = $(".child-age-select").map((_, el) => $(el).val()).get();

    if (destname == "" || destid == "") {
        notify("Please Select Hotel Location.", "error");
        return;
    }

    sentR = {
        chkInDate: checkin,
        chkOutDate: checkout,
        adultCount: adults,
        childCount: children,
        hotelCode: destid,
        hotelName: destname,
        childAges: childAge.length > 0 ? childAge : [],
        roomCount: rooms,
    };

    $.ajax({
        url: "/hotel/search",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: sentR,
        beforeSend: function () {
            $("#form-wizard1").find("[type='button']").attr("disabled", true);
            let skelet = "";
            skelet += beforeSendSket();
            $(".preview-card-side").html(`<div class="card">${skelet}</div>`);
            $(".preview-card-body").html(`<div class="card">${skelet}</div>`);
        },

        success: function (data) {

            $("#form-wizard1").find("[type='button']").attr("disabled", false);
            $(".preview-card-side").html("");
            $(".preview-card-body").html("");

            if (data.status == "success" && data.data?.HotelResults?.length > 0) {

                localStorage.setItem("sentReqest", JSON.stringify([sentR]));
                renderHotelList(data);
                // searchFilter(data);
                return false;
            } else {
                notify(data?.message || "Unable to search Hotel", "error");
            }
        },
        error: function () {
            $("#form-wizard1").find("[type='button']").attr("disabled", false);
        },
    });
}



function fliterHotelSearch_filter(Datas) {
    $.ajax({
        url: "/hotel/search/filter",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: Datas,
        beforeSend: function () {
            swal({
                type: 'info',
                text: 'We are fetching details.',
                allowOutsideClick: false,
                backdrop: true,
                showConfirmButton: false
            });
        },

        success: function (data) {
            swal.close();
            renderHotelList(data);
        },
        error: function () {
            swal.close();
        }
    });
}

function fliterHotelSearch(action) {
    if (action == 'clear') {
        $(".location_checkbox").prop("checked", false);
        $(".freeCancel_checkbox").prop("checked", false);
        $(".breakfast_checkbox").prop("checked", false);
        $(".star_checkbox").prop("checked", false);
    }



    $(".preview-card-body").children().remove();
    var selectedbreakfastfree = '';
    var selectedcancellationfree = '';

    var selectedStar = [];
    var selectedloc = [];

    $(".location_checkbox").each(function () {
        if (this.checked == true) {
            selectedloc.push(this.value);
        }
    });

    $(".freeCancel_checkbox").each(function () {
        if (this.checked == true) {
            selectedcancellationfree = true;
        } else {
            selectedcancellationfree = false;
        }
    });
    $(".breakfast_checkbox").each(function () {
        if (this.checked == true) {
            selectedbreakfastfree = true;
        } else {
            selectedbreakfastfree = false;
        }
    });

    $(".star_checkbox").each(function () {
        if (this.checked == true) {
            selectedStar.push(parseInt(this.value));
        }
    });


    const rangeS = document.querySelectorAll('input[type="range"]');

    rangeS.forEach((el) => {
        el.oninput = () => {
            let slide1 = parseFloat(rangeS[0].value),
                slide2 = parseFloat(rangeS[1].value);

            if (slide1 > slide2) {
                [slide1, slide2] = [slide2, slide1];
            }
            priceRange1 = slide1;
            priceRange2 = slide2;
            $("#price1").html(`₹ ${slide1}`);
            $("#price2").html(`₹ ${slide2}`);
        };
    });

    const data = {
        requestId: hotelDetails.requestId,
        hotelRatings: selectedStar,
        hotelPincode: selectedloc,
        isBreakfast: selectedbreakfastfree,
        isFreeCancellation: selectedcancellationfree,
        hotelPriceMin: priceRange1,
        hotelPriceMax: priceRange2,
    };

    fliterHotelSearch_filter(data);

}

var hotelDetails;
function searchFilter(data) {

    hotelDetails = data.data;

    let hotelPriceDetails = hotelDetails.hotelContents.flatMap((hotel) =>
        hotel?.hotelFareDetails?.totalAmount
    );

    let hotelsDet = hotelDetails.hotelContents.flat();

    // console.log(hotelPriceDetails,hotelsDet);

    let hotelsDetails = hotelsDet.map((hotel) => {
        if (hotel.location != "") {
            return `${hotel.location}|${hotel.pincode}`;
        }
        return "";
    }).filter((code) => code != "");
    var sidemenu = `<div class="card border">
                          <div class="px-3 pt-3 d-flex justify-content-between align-items-center">
                             <h4 class="text-start fw-bold text-primary mb-0">Filters</h4>
                            
                             <span class="badge bg-light text-end pe-2 cursor-pointer" onclick="fliterHotelSearch('clear')">Clear All</span>
                         
                          </div>
                          <div class="card-header p-2">
                                <div class="row p-2" >
                                  <div class="col-sm-12">
                                        <div class="position-relative">
                                            <input id="location" value="" name="location" type="text" class="form-control form-control-sm" 
                                            oninput="filterLocations()" placeholder="Search Location...">
                                            <span class="icon-inside"><i class="ti ti-search"></i></span>
                                        </div>                                                         
                                  </div>
                                </div>
                                <div class="row p-2 me-2 custom-scrollbar mt-2" style="height: auto;max-height:150px;overflow-y: auto;">`;

    let showhotelloc = Array.from(new Set(hotelsDetails));
    let idx = 0;
    for (let hotelloc of showhotelloc) {
        idx++;
        sidemenu += `<div class="col-12 my-1 location-item" data-name="${hotelloc.toLowerCase()}">
                                                <div class="custom-control custom-checkbox custom-control-inline d-flex">
                                                    <input type="checkbox" class="custom-control-input location_checkbox" id="${hotelloc.split('|')[1]}${idx}" name="${hotelloc.split('|')[1]}" value="${hotelloc.split('|')[1]}" onclick="fliterHotelSearch('')">

                                                    <label class="custom-control-label ms-2" for="${hotelloc.split('|')[1]}${idx}">${toTitleCase(hotelloc.split('|')[0])}</label>
                                                </div>
                                            </div>`;
    }

    sidemenu += `</div>
                              
                          </div>
                          <div class="card-header p-2">
                             
                                      <h6 class="mb-0 text-start text-primary fw-bold">Star Ratings</h6>
                               
                              <div class="row p-2">
                                  <div class="col-12 my-1">
                                      <div class="custom-control custom-checkbox custom-control-inline">
                                          <input type="checkbox" class="custom-control-input star_checkbox" id="star1" name="star1" value="1" onclick="fliterHotelSearch('')">
                                          <label class="custom-control-label" for="star1">1 <i class="fas fa-star text-warning"></i></label>
                                      </div>
                                  </div>
                                  <div class="col-12 my-1">
                                      <div class="custom-control custom-checkbox custom-control-inline">
                                          <input type="checkbox" class="custom-control-input star_checkbox" id="star2" name="star2" value="2" onclick="fliterHotelSearch('')">
                                          <label class="custom-control-label" for="star2">2 <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i></label>
                                      </div>
                                  </div>
                                  <div class="col-12 my-1">
                                      <div class="custom-control custom-checkbox custom-control-inline">
                                          <input type="checkbox" class="custom-control-input star_checkbox" id="star3" name="star3" value="3" onclick="fliterHotelSearch('')">
                                          <label class="custom-control-label" for="star3">3 <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i></label>
                                      </div>
                                  </div>
                                  <div class="col-12 my-1">
                                      <div class="custom-control custom-checkbox custom-control-inline">
                                          <input type="checkbox" class="custom-control-input star_checkbox" id="star4" name="star4" value="4" onclick="fliterHotelSearch('')">
                                          <label class="custom-control-label" for="star4">4 <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i></label>
                                      </div>
                                  </div>
                                  <div class="col-12 my-1">
                                      <div class="custom-control custom-checkbox custom-control-inline">
                                          <input type="checkbox" class="custom-control-input star_checkbox" id="star5" name="star5" value="5" onclick="fliterHotelSearch('')">
                                          <label class="custom-control-label" for="star5">5 <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i></label>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div>
                            <h6 class="ps-2 mb-0 text-start text-primary fw-bold">Price</h6>
                       
                              </div>
                              <div class="card-header p-2">
                              <div class="row p-2">
                                    
                               
                                  <div class="col-12">`;

    let uniquePrice = Array.from(new Set(hotelPriceDetails));
    priceRange1 = Math.min(...uniquePrice);
    priceRange2 = Math.max(...uniquePrice);

    sidemenu += `
                                      <div class="row">
                                      <div class="col-8"> <span id="price1">₹ ${priceRange1} </span> </div>
                                      <div class="col-4">  <span id="price2">₹ ${priceRange2} </span></div>
                                      </div>
                                      <div class="range-slider w-100">
                                      <input value="${priceRange1}" min="${priceRange1}" max="${priceRange2}" step="1" type="range" onclick="fliterHotelSearch('')">
                                      <input value="${priceRange2}" min="${priceRange1}" max="${priceRange2}" step="1" type="range" onclick="fliterHotelSearch('')">
  
                                  </div></div>
  
                              </div>
                          </div>
  
                           <div class="p-2">
                              <div class="row p-2">
                                    <div class="col-12 my-1">
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                          <input type="checkbox" class="custom-control-input breakfast_checkbox" id="freebreakfast" name="freebreakfast" value="false" onclick="fliterHotelSearch('')">
  
                                          <label class="custom-control-label" for="freebreakfast">🥣 Free Breakfast</label>
                                        </div>
                                    </div
                                    <div class="col-12 my-1">
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                          <input type="checkbox" class="custom-control-input freeCancel_checkbox" id="freeCancel" name="freeCancel" value="false" onclick="fliterHotelSearch('')">
  
                                          <label class="custom-control-label" for="freeCancel">✅ Free Cancellation</label>
                                        </div>
                                    </div
                                </div>
                          </div>
  
                      </div>`;

    $(".preview-card-side").html(sidemenu);
    fliterHotelSearch('')
}

function filterLocations() {
    let searchValue = $("#location").val().toLowerCase();

    $(".location-item").each(function () {
        let locName = $(this).data("name").toLowerCase();

        if (locName.includes(searchValue)) {
            $(this).slideDown(); // Smooth show
        } else {
            $(this).slideUp(); // Smooth hide without space
        }
    });

    // let locations = document.querySelectorAll(".location-item");

    // locations.forEach(loc => {
    //     let locName = loc.getAttribute("data-name");
    //     if (locName.includes(searchValue)) {
    //         loc.slideDown(200);
    //     } else {
    //         loc.slideUp(200);
    //     }
    // });
}

function renderHotelList(data) {

    let x = data?.data?.HotelResults[0]?.Rooms;

    x.forEach(function (hotel, index) {
        var bs = hotelSklt(hotel, index);

        $(".preview-card-body").append(bs);
    });

    localStorage.setItem("hotelcode", data?.data?.HotelResults[0]?.HotelCode);
    $('[data-bs-toggle="tooltip"]').tooltip({ html: true });
}

function hotelSklt(z, indexx) {

    var dt = '';

    let hotelName = z?.Name || 'Hotel Name';
    let latitude = z?.Latitude || '';
    let longitude = z?.Longitude || '';

    let inclusion = z?.Inclusion || '';
    let mealType = z?.MealType?.replace('_', ' ') || 'Room Only';

    let basePrice = z?.DayRates?.[0]?.[0]?.BasePrice || 0;
    let totalFare = z?.TotalFare || 0;
    let totalTax = z?.TotalTax || 0;

    let isRefundable = z?.IsRefundable;

    let rating = z?.StarRating || 0;

    // ⭐ Rating stars
    let stars = '';
    for (let i = 0; i < rating; i++) {
        stars += `<i class="fas fa-star text-warning"></i>`;
    }


    let defaultImg = "https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400";

    dt += `<div class="hotels-item card bg-white shadow-sm rounded p-3 mb-3" id="hotel${indexx}">
              <div class="row">

                <!-- IMAGE -->
                <div class="col-md-4" style="height:203px;"> 
                        <img src="${z?.HotelPicture || defaultImg}"
                            onerror="this.src='${defaultImg}'"
                            class="img-fluid rounded"
                            style="height:100%; width:100%">
                </div>

                <div class="col-md-8 ps-3 ps-md-0 mt-3 mt-md-0">
                  <div class="row g-0">

                    <!-- LEFT CONTENT -->
                    <div class="col-sm-9">

                      <h4>
                        <a target="_blank" 
                           href="https://www.google.com/maps/search/${encodeURIComponent(hotelName)}/@${latitude},${longitude}" 
                           class="text-dark text-5">
                           ${hotelName}
                        </a>
                      </h4>

                      <p class="mb-2">${stars}</p>


                      <p class="mb-2">🍽️ ${mealType}</p>

                      <p class="hotels-amenities mb-2 text-4">
                        ${inclusion
            ? inclusion.split(',').map(i =>
                `<span class="cf border rounded badge text-1 text-nowrap px-2 m-1 text-muted">${i}</span>`
            ).join('')
            : ''}
                      </p>

                      <p class="reviews mb-2"> 
                        ${isRefundable
            ? '✅ <span class="fw-600 text-success">Refundable</span>'
            : '❌ <span class="fw-600 text-danger">Non-Refundable</span>'}
                            | 
                            ${z?.WithTransfers
            ? '🚗 <span class="text-success">Free Transfer Available</span>'
            : '❌ <span class="text-danger">No Transfer</span>'}
                            
                            <br/>
                            ${z?.CancelPolicies?.length
            ? `<button class="ms-2 btn btn-sm btn-outline-primary mt-2" 
                                    onclick='showCancelPolicy(${JSON.stringify(z.CancelPolicies)})'>
                                    View Policy
                            </button>`
            : ''}                           
                      </p>

                    </div>

                    <div class="col-sm-3 g-4 text-end d-flex d-sm-block align-items-center">

                      <div class="text-black-50 fs-5">Starts from</div>

                      <div class="fare-container">

                        <div class="text-4 fw-bold mb-2 m-2 price-display fw-bold fs-5" style="color:#d63b05;">
                          ₹${totalFare.toFixed(2)}
                        </div>

                        <!-- FARE BREAKDOWN -->
                        <div class="fare-breakdown-container-hotel card p-3" style="display:none; background: #f8f9fa; border-radius: 12px; border:1px solid silver">

                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-bold">Room Price</span>
                                <span>₹${basePrice}</span>
                            </div>

                            <hr/>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-bold">Tax</span>
                                <span>₹${totalTax}</span>
                            </div>

                            <hr/>

                            <div class="d-flex justify-content-between mt-2">
                                <span class="fw-bold">TOTAL</span>
                                <span class="fw-bold" style="color:#d63b05;">₹${totalFare}</span>
                            </div>

                        </div>
                      </div>

                      <div class="text-black-50 mt-3">1 Room/Night</div>

                      <button onclick=viewNowHotel('${encodeURIComponent(JSON.stringify(z))}') 
                              class="btn btn-primary ms-auto mt-2">
                          Book Room
                      </button>

                    </div>

                  </div>
                </div>

              </div>
            </div>`;

    return dt;
}

function showCancelPolicy(policies) {

    let html = `
        <div class="table-responsive">
            <table class="table table-bordered table-sm text-center">
                <thead class="table-light">
                    <tr>
                        <th>From Date</th>
                        <th>Charge Type</th>
                        <th>Charge</th>
                    </tr>
                </thead>
                <tbody>
    `;

    policies.forEach(p => {

        let charge = p.ChargeType === 'Percentage'
            ? p.CancellationCharge + '%'
            : '₹' + p.CancellationCharge;

        html += `
            <tr>
                <td>${p.FromDate}</td>
                <td>${p.ChargeType}</td>
                <td>${charge}</td>
            </tr>
        `;
    });

    html += `
                </tbody>
            </table>
        </div>
    `;

    $('#cancelPolicyBody').html(html);

    $('#cancelPolicyModal').modal('show');
}

var sessionExpired = false;
function updateCountdown() {
    let expireTime = parseInt(sessionStorage.getItem("hotelExpireTime"), 10);

    if (!expireTime) {
        expireTime = parseInt(localStorage.getItem("hotelExpireTime"), 10);
        if (expireTime) {
            sessionStorage.setItem("hotelExpireTime", expireTime);
        }
    }

    const currentTime = Date.now();
    const remainingTime = expireTime - currentTime;

    if (!expireTime || remainingTime <= 0) {

        if (!sessionExpired) {
            sessionExpired = true;
            sessionStorage.removeItem("hotelExpireTime");
            localStorage.removeItem("hotelExpireTime");

            swal({
                html: `Your hotel booking session has expired. Please search again.`,
                type: "warning",
                confirmButtonText: `Ok`,
                showCancelButton: false,
                backdrop: true,
                allowOutsideClick: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    window.open("/hotel/booking", "_self");
                }
            });
        }
        return false;
    }


    const minutes = Math.floor(remainingTime / 60000);
    const seconds = Math.floor((remainingTime % 60000) / 1000);
    $("#countdown-timer").text(`${minutes}:${seconds < 10 ? "0" : ""}${seconds}`);
    $("#countdown").text(`${minutes}:${seconds < 10 ? "0" : ""}${seconds}`);

    return true;
}


function viewNowHotel(selectData) {


    let val = JSON.parse(decodeURIComponent(selectData));


    sessionStorage.setItem("hotelExpireTime", Date.now() + 10 * 60 * 1000);

    sessionStorage.setItem("allHotelData", JSON.stringify(val));
    window.open("/hotel/booking/detail", "_blank");
}

$(document).on('mouseenter', '.price-display', function () {
    $(this).siblings('.fare-breakdown-container-hotel').stop(true, true).fadeIn();
}).on('mouseleave', '.price-display', function () {
    $(this).siblings('.fare-breakdown-container-hotel').stop(true, true).fadeOut();
});

$(document).on('mouseenter', '.price-display-details', function () {
    $(this).siblings('.fare-breakdown-container-hotel-details').stop(true, true).fadeIn();
}).on('mouseleave', '.price-display-details', function () {
    $(this).siblings('.fare-breakdown-container-hotel-details').stop(true, true).fadeOut();
});

$(document).ready(function () {
    // Attach hover functionality for each fare container
    $('.fare-container').each(function () {
        const priceDisplay = $(this).find('.price-display');
        const fareBreakdown = $(this).find('.fare-breakdown-container-hotel');

        // Show fare breakdown on hover
        priceDisplay.hover(
            function () {
                fareBreakdown.stop(true, true).fadeIn();
            },
            function () {
                fareBreakdown.stop(true, true).fadeOut();
            }
        );
    });
    $('.fare-container-details').each(function () {
        const priceDisplay = $(this).find('.price-display-details');
        const fareBreakdown = $(this).find('.fare-breakdown-container-hotel-details');

        // Show fare breakdown on hover
        priceDisplay.hover(
            function () {
                fareBreakdown.stop(true, true).fadeIn();
            },
            function () {
                fareBreakdown.stop(true, true).fadeOut();
            }
        );
    });
});

function hotelDeatilsUrlAjaxHit(datas, hotelcode) {

    $.ajax({
        url: "/hotel/details",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            HotelCode: hotelcode
        },
        success: function (data) {
            showHotelTabContent(data?.data);
        },
        error: function () {
            notify('Something went wrong', 'error');
        },
    });
}

function preBookingDetailsAjaxHit(datas) {

    $.ajax({
        url: "/hotel/prebooking",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            bookingId: datas,
        },
        success: function (data) {
            if (data?.status == "success") {
                let html = viewAllHoTelDetail(data?.data?.HotelResult);
                $('#roomDetailsBody').html(html);
            } else {
                swal({
                    html: `Pre-booking details are not available for this hotel. Please try booking again or choose another hotel.`,
                    type: "warning",
                    confirmButtonText: `Ok,I Understand!`,
                    showCancelButton: false,
                    backdrop: true,
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.isConfirmed || result.value) {
                        setTimeout(function () {
                            window.open("/hotel/view", "_self");
                        }, 2000);
                    }
                });
            }

        },
        error: function () {
            notify('Something went wrong', 'error');
        },
    });


}

function formatDate(dateStr) {
    if (!dateStr) return '';

    let [day, month, year] = dateStr.split('-');
    let months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    return `${day} ${months[parseInt(month) - 1]} ${year}`;
}

function viewAllHoTelDetail(data) {

    let hotel = data[0];
    let sendReq = JSON.parse(localStorage.getItem('sentReqest')) || [];
    let req = sendReq[0] || {};
    let adults = req.adultCount || 0;
    let children = req.childCount || 0;
    return `
  
        <div class="row">
            <div class="col-md-8">

                ${hotel.Rooms.map(room => `
                
                <div class="card mb-4 shadow-sm border-0 rounded-3">
                    <div class="card-body">

                        <h4 class="fw-bold mb-2">${room.Name?.[0] ?? 'Room'}</h4>

                        <div class="mb-2">
                            <span class="badge bg-primary">${room.MealType}</span> |
                            <span class="badge ${room.IsRefundable ? 'bg-success' : 'bg-danger'}">
                                ${room.IsRefundable ? 'Refundable' : 'Non Refundable'}
                            </span> | 
                            <span class="badge ${room.WithTransfers ? 'bg-success' : 'bg-danger'}">
                                ${room.WithTransfers ? '🚘 With Transfers' : 'Without Transfers'}
                            </span>
                        </div>

                        <p class="text-muted">${room.Inclusion || ''}</p>

                         <!-- DAY RATES -->
                        <div class="mt-3 rounded p-3" style="border:1px dashed silver;">
                            <h6 class="fw-bold">📅 Day Price</h6>
                            ${room.DayRates?.map(day => day.map(d => `
                                <div class="small">
                                    Base Price: ₹${parseFloat(d.BasePrice).toFixed(2)}
                                </div>
                            `).join('')).join('')}
                        </div>

                        <!-- SUPPLEMENTS -->
                        ${room.Supplements?.length ? `
                        <div class="mt-3 rounded p-3" style="border:1px dashed silver;">
                            <h6 class="fw-bold">➕ Extra Charges</h6>
                            ${room.Supplements.map(supArr => supArr.map(s => `
                                <div class="small">
                                    ${s.Description} → ${s.Price} ${s.Currency} (${s.Type})
                                </div>
                            `).join('')).join('')}
                        </div>
                        ` : ''}

                        <!-- Amenities -->
                        <div class="mt-3 rounded p-3" style="border:1px dashed silver;">
                            <h6 class="fw-bold">🧰 Amenities</h6>
                            <div class="row">
                                ${room.Amenities.map(a => `
                                    <div class="col-md-6 small mb-1">✔ ${a}</div>
                                `).join('')}
                            </div>
                        </div>

                        <!-- Cancellation -->
                        <div class="mt-3 rounded p-3" style="border:1px dashed silver;">
                            <h6 class="fw-bold text-danger">❌ Cancellation Policy</h6>
                            ${room.CancelPolicies.map(p => `
                                <div class="small">
                                    ${p.FromDate} → ${p.ChargeType} : ${p.CancellationCharge}%
                                </div>
                            `).join('')}
                            <div class="small fw-bold mt-1 fs-5">
                               Cancellation Deadline: ${room.LastCancellationDeadline}
                            </div>
                        </div>

                    </div>
                </div>

                `).join('')}

                <!-- HOTEL POLICIES -->
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">📜 Hotel Policies</h5>
                       ${hotel.RateConditions.map(c => `
                            <div class="mb-2 text-muted small">
                                ${c.replace(/&lt;/g, '<').replace(/&gt;/g, '>')}
                            </div>
                        `).join('')}
                    </div>
                </div>

            </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 position-sticky top-0">
                        <div class="card-body">

                            ${hotel.Rooms.map(room => `
                            
                            <!-- Price Header -->
                            <h5 class="fw-bold mb-3">💰 Price Summary
                            </h5>

                            <div class="border rounded-3 mb-3">
                                <div class="d-flex justify-content-between p-2 border-bottom small">
                                    <div>
                                        <b>Check-in</b><br>
                                        ${formatDate(req.chkInDate)}
                                    </div>
                                    <div>
                                        <b>Check-out</b><br>
                                        ${formatDate(req.chkOutDate)}
                                    </div>
                                </div>
                                <div class="p-2 small">
                                    <b>Guests:</b> ${adults} Adult${adults > 1 ? 's' : ''}
                                        ${children > 0 ? `, ${children} Child${children > 1 ? 'ren' : ''}` : ''}
                                </div>
                            </div>

                            <!-- Pricing Breakdown -->
                            <h6 class="fw-bold mb-2">Pricing Breakdown</h6>

                            <div class="d-flex justify-content-between small mb-2">
                                <span>Room Price</span>
                                <span>₹${room.PriceBreakUp[0].RoomRate.toFixed(2)}</span>
                            </div>

                            <div class="d-flex justify-content-between small mb-2">
                                <span>Taxes & Fees</span>
                                <span>₹${room.TotalTax.toFixed(2)}</span>
                            </div>

                            <!-- Supplements -->
                            ${room.Supplements?.length ? `
                            ${room.Supplements.map(supArr => supArr.map(s => `
                                <div class="d-flex justify-content-between small mb-2">
                                    <span>${s.Description}</span>
                                    <span>${s.Price} ${s.Currency}</span>
                                </div>
                            `).join('')).join('')}
                            ` : ''}

                            <hr>

                            <!-- Total -->
                            <div class="d-flex justify-content-between fw-bold fs-5">
                                <span>Net Total Price</span>
                                <span class="fw-bold text-success">₹${room.NetAmount.toFixed(2)}</span>
                            </div>

                            <div class="text-muted small mt-1">
                                (Includes ₹${room.NetTax.toFixed(2)} taxes)
                            </div>

                            <!-- Button -->
                            <button class="btn btn-primary w-100 mt-3 rounded-pill" id="bookNowBtn" onclick="bookNowHotel('${encodeURIComponent(JSON.stringify(room))}', '${hotel.HotelCode}', ${room.NetAmount})">
                                Continue to Passenger Details
                            </button>

                            <div class="text-center text-muted small mt-2">
                                You won’t be charged yet
                            </div>

                            `).join('')}

                        </div>
                    </div>
                </div>
            </div>
    `;
}

// function prebookingdetails() {
//     return `<div class="d-flex align-items-center">
//             <div class="text-dark text-7 lh-1 fw-500 me-2 me-lg-3">₹${roomd?.totalAmount}</div>
//             <div class="d-block text-4 text-black-50 me-2 me-lg-3"></div>
        
//         </div>
//         <div class="text-success text-3 me-2 me-lg-3"> 
//             ${roomd?.ratePlanDetails[0]?.roomAvailability
//             ? '<span class="cf border rounded badge bg-label-success text-1 text-nowrap px-2 m-1">Room Available</span>'
//             : '<span class="cf border rounded badge bg-label-danger text-1 text-nowrap px-2 m-1">Room Not Available</span>'}</div>
                        
//                             <div class="text-success text-3 me-2 me-lg-3"> 
//                             ${roomd?.ratePlanDetails[0]?.refundable.toLowerCase() == 'true'
//             ? '<span class="cf border rounded badge bg-label-success text-1 text-nowrap px-2 m-1">Refundable</span>'
//             : '<span class="cf border rounded badge bg-label-danger text-1 text-nowrap px-2 m-1">Non-Refundable</span>'}</div>
//                 <span class="text-black-50">1 Room/Night</span> </div>
//                 <div class="d-flex align-items-center mt-3"> 
//                 <a href="javascript:void(0)" onclick="cancelPolicy('${encodeURIComponent(roomd?.ratePlanDetails[0]?.cancellationPolicy)}',
//                         '${roomd?.ratePlanDetails[0]?.childrenPolicy ? encodeURIComponent(JSON.stringify(roomd?.ratePlanDetails[0]?.childrenPolicy)) : ''}',
//                         '${JSON.stringify(roomd?.ratePlanDetails[0]?.essentialInformation)}')">Cancellation Policy</a> 
//             <button onclick="bookNowHotel(this,'${JSON.stringify(roomd)}', '${roomDet?.hotelKey}', ${roomd?.totalAmount})" 
//             class="btn btn-sm btn-outline-primary shadow-none ms-auto select-room-btn">Select Room</button> </div>
//         </div>`;
// }

function showHotelTabContent(viewdet) {

    let hotelInfo = viewdet?.HotelDetails?.[0] || {};

    let rating = hotelInfo?.HotelRating || 0;

    let stars = '';
    for (let i = 0; i < rating; i++) {
        stars += `<i class="fas fa-star text-warning fs-6"></i>`;
    }

    let detailstabhtml = '';
    let galleryimg = '';


    let description = hotelInfo?.Description
        ? hotelInfo.Description
        : '<p>No description available.</p>';

    let facilitiesHtml = '';
    if (hotelInfo?.HotelFacilities?.length > 0) {

        let facilities = hotelInfo.HotelFacilities;

        facilitiesHtml = facilities
            .reduce((acc, curr, index, array) => {
                const itemsPerColumn = Math.ceil(array.length / 3);
                const columnIndex = Math.floor(index / itemsPerColumn);
                acc[columnIndex] = acc[columnIndex] || [];
                acc[columnIndex].push(curr);
                return acc;
            }, [])
            .map(chunk => `
                <div class="col-sm-6">
                    <ul class="simple-ul">
                        ${chunk.map(item => `<li>${item}</li>`).join('')}
                    </ul>
                </div>
            `).join('');
    } else {
        facilitiesHtml = `<p>No facilities available.</p>`;
    }


    let attractionsHtml = '';

    if (hotelInfo?.Attractions) {
        let attractions = Object.values(hotelInfo.Attractions);

        attractionsHtml = `
            <div class="row ps-3">
                ${attractions.map(item => `
                    <div class="col-sm-6 mb-2">
                        <div class="border rounded p-2 text-muted">
                            📍 ${item}
                        </div>
                    </div>
                `).join('')}
            </div>
        `;
    } else {
        attractionsHtml = `<p>No nearby attractions found.</p>`;
    }

    let html = viewAllHotelRoom(hotelInfo?.RoomDetails);

    detailstabhtml = `
        <div class="tab-pane fade show active" id="knownfor">
           
            ${description}
        </div>        

        <div class="tab-pane fade" id="amenities">
            <div class="row ps-3">
                ${facilitiesHtml}
            </div>
        </div>
        <div class="tab-pane fade" id="attractions">
            ${attractionsHtml}
        </div>

        <div class="tab-pane fade" id="chooseroom">
           ${html}
        </div>
    `;

    $('#hotel_name_det').html(`
        <section class="rounded bg-white p-3 mb-2 d-flex justify-content-between">
            <span>
                <span class="fs-4 fw-bold">${hotelInfo?.HotelName} (${stars})
                | 
                    </span>
                    ${hotelInfo?.HotelWebsiteUrl ? `<a href="${hotelInfo.HotelWebsiteUrl}" target="_blank" style="text-decoration:none; color:blue;">
                        🌐 Visit Website
                    </a>` : ''}
                <p class="opacity-8 mb-0">
                    <i class="fas fa-map-marker-alt"></i>
                    ${hotelInfo?.Address || ''} 
                    ${hotelInfo?.CityName || ''}, 
                    ${hotelInfo?.CountryName || ''}
                    ${hotelInfo?.PinCode || ''}
                    <br/>
                    ${hotelInfo?.PhoneNumber
            ? `<a href="tel:${hotelInfo.PhoneNumber}" style="text-decoration:none; color:blue;">
                            📞 ${hotelInfo.PhoneNumber}
                        </a>`
            : ''} |
                    ${hotelInfo?.CheckInTime ? 'Check-in: ' + hotelInfo.CheckInTime : ''} 
                    ${hotelInfo?.CheckOutTime ? ' | Check-out: ' + hotelInfo.CheckOutTime : ''}
                    
                </p>
            </span>

            <a target="_blank" href="https://www.google.com/maps/search/${hotelInfo?.HotelName}/@${hotelInfo?.Map?.split('|')[0]},${hotelInfo?.Map?.split('|')[1]}">
                <img src="/public/images/map.png" height="45"/>
            </a>
        </section>
    `);

    let mainImage = hotelInfo?.Images?.[0] || '/images/no-hotel.jpg';

    $('#hotel_image').html(`
        <img src="${mainImage}" 
            class="rounded"
            style="height: 320px; object-fit: cover; width: 100%;">
    `);

    $('#viewdetHotelContent').html(detailstabhtml);

    if (hotelInfo?.Images?.length > 0) {

        galleryimg = hotelInfo.Images.map((img, index) => {

            if (index < 3) {
                return `
                    <div class="col-6 mb-2">
                        <img src="${img}" class="img-fluid rounded"
                        style="height:153px; object-fit:cover; width:100%;">
                    </div>
                `;
            }

            if (index === 3) {
                return `
                    <div class="col-6">
                        <div class="position-relative">
                            <img src="${img}" class="img-fluid rounded"
                            style="height:153px; object-fit:cover; width:100%;">

                            <div class="hover-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-25">
                                <button class="btn btn-secondary btn-sm" id="viewAllImages">view all</button>
                            </div>
                        </div>
                    </div>
                `;
            }

        }).join('');

    } else {
        galleryimg = `<p>No images available</p>`;
    }

    $('#galleryImgSwiperHotel').html(galleryimg);

    let allImages = hotelInfo?.Images.map((img, ind) => `
 
        <div class="carousel-item ${ind == 0 ? 'active' : ''}">
            <img class="d-block w-100 rounded" src="${img}" 
            style="height:550px; object-fit:cover"/>
        </div>
    `).join('');

    $('#morehotelimg').html(allImages);


    $('#galleryImgSwiperHotel').on('click', '#viewAllImages', function () {
        $('#showmoreHotelImageModal').modal('show');
    });
}

function viewAllHotelRoom(roomdet) {

    let roomdetHtml = '';

    const maxVisibleInclusion = 4;
    const hiddenInclusion = [];



    if (roomdet && Array.isArray(roomdet) && roomdet.length > 0) {
        let galleryimg = '';
        let allGalleryImages = '';

        roomdetHtml += roomdet?.map((roomd, index) => {
            if (roomd?.imageURL && roomd.imageURL.length > 0) {

                allGalleryImages = roomd?.imageURL.map((valH, ind) => {
                    return ` <div class="carousel-item ${ind == 0 ? 'active' : ''}">
                                <img class="d-block w-100 rounded" src="${valH}" alt="Hotel${ind}" style="height:550px; object-fit:cover"/>
                            </div>`;
                }).join('');

                galleryimg = roomd?.imageURL.map((valH, indexxx) => {

                    let encodedImages = encodeURIComponent(allGalleryImages);
                    if (indexxx === 0) {
                        return `<div class="position-relative">
                            <img class="img-fluid rounded align-top" src="${valH}" alt="Hotel${indexxx}" style="height: 225px;width: 100%;"> 
                           
                            <div style="height: 225px;object-fit: cover;" class="hover-overlay rounded position-absolute top-0 start-0 w-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-25">
                                <button class="btn btn-secondary btn-sm" onclick="viewAllGalleryImages(${indexxx}, '${encodedImages}')">view all</button>
                            </div>
                        </div>`;
                    }
                }).join('');
            } else {
                galleryimg = `<img class="img-fluid rounded align-top" src="https://ik.imagekit.io/ryn4njrqfh/TravlTech/no_img_hotel.jpg?updatedAt=1742980696180" alt="Hotels" style="height: 225px;width: 100%;"> `;
            }

            let desc = roomd.RoomDescription ? roomd.RoomDescription : '';

            return ` <div class="row g-4" id="hotelRoom${index}">
                        <div class="col-12 col-md-5" style="height:225px;"> 
                            ${galleryimg}
                        </div>
                        <div class="col-12 col-md-7">
                            <h4 class="text-5"> ${roomd.RoomName}</h4>
                            <ul class="list-inline mb-2">
                            <li class="list-inline-item"><span class="me-1 text-black-50"><i class="fas fa-bed"></i></span>
                            <span style="font-size:14px;">${desc}</span>
                            </li>

                            </ul>
                            <div class="mb-3">
                                <p class="hotels-amenities align-items-center mb-2 text-4" id="facilityContainer10">
                                    ${roomd.RoomSize ? `<span class="text-muted">Size: ${roomd.RoomSize}</span>` : ''}
                                </p>
                            </div>
                        </div>                            
                     <hr class="my-2"/>`;
        }).join('');

    } else {
        swal({
            html: `No rate plans available at the moment. Please check back later or try adjusting your search criteria.`,
            type: "warning",
            confirmButtonText: `Ok,I Understand!`,
            showCancelButton: false,
            backdrop: true,
            allowOutsideClick: false,
        }).then((result) => {
            if (result.isConfirmed || result.value) {
                setTimeout(function () {
                    window.open("/hotel/view", "_self");
                }, 2000);
            }
        });
    }

    return roomdetHtml;
}

function bookNowHotel(roomd, hkey, amt) {
    
    sessionStorage.setItem("recomdet", decodeURIComponent(roomd));
    sessionStorage.setItem("hkey", hkey);
    sessionStorage.setItem("amt", amt);

    window.open("/hotel/guest/detail", "_blank");
}

function selectedroom(roomd, hkey) {
    // sessionStorage.setItem("recomdet", roomd);
    // sessionStorage.setItem("hkey", hkey);
    // window.open("/hotel/guest/detail", "_blank");
}


function cancelPolicyAjaxHit(recomId, ratePlanId, hotelKy, reqid) {

    $.ajax({
        url: "/hotel/policy",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            ratePlanId: ratePlanId,
            hotelKey: hotelKy,
            recommendationId: recomId,
            requestId: reqid
        },
        success: function (data) {
            if (data?.data?.cancellationPolicy != null || data?.data?.cancellationPolicy != 'null') {
                $(`#cancellationrulesHotel`).html(
                    `<div class="col-12">${data?.data?.cancellationPolicy}</div>`
                );
            } else {
                $(`#cancellationrulesHotel`).html(
                    `<div class="col-12"><p class="text-danger">Cancellation terms are not available at the moment. For any query, Please contact customer support</p></div>`
                );
            }
        },
        error: function () {
            $(`#cancellationrulesHotel`).html(
                `<div class="col-12 px-4"><p class="text-danger">Cancellation terms are not available at the moment. For any query, Please contact customer support</p></div>`
            );
        },
    });
}

function viewAllGalleryImages(id, allGalleryImg) {
    let allGalleryImages = decodeURIComponent(allGalleryImg);
    console.log('allGalleryImages', allGalleryImages);

    $('#morehotelimgGallery').html(allGalleryImages);
    $('#showmoreHotelImageGalleryModal').modal('show');
}

function cancelPolicy(cancelpol, childpol, essenpol) {
    let htmlofModalBody = '';

    htmlofModalBody += `<div>
                ${decodeURIComponent(cancelpol)}
            </div>`;

    htmlofModalBody += `<h5 class="mt-2"><u>Children Policy :</u></h5>`;
    if (childpol != '') {
        htmlofModalBody += `<div>
                ${JSON.parse(decodeURIComponent(childpol))}
            </div>`;
    } else {
        htmlofModalBody += `-`;
    }

    htmlofModalBody += `<h5 class="mt-2"><u>Esssential Information</u></h5>`;
    htmlofModalBody += JSON.parse(essenpol).map((val) => {
        return `➤ <b>${val?.type}</b> : ${val?.text} <br/>`;
    }).join('');

    $('#showCancelPolicyModal .modal-body').html(htmlofModalBody);
    $('#showCancelPolicyModal').modal('show');
}

function beforeSendSket() {
    return `
          <div class="card-body">
              <h2 class="card-title skeleton">
              </h2>
              <p class="card-intro skeleton">
              </p>
              <h2 class="card-title skeleton">
              </h2>
          </div>`;
}


function toTitleCase(str) {
    return str.toLowerCase().replace(/\b\w/g, (char) => char.toUpperCase());
}


function ucwords(str) {
    return str.replace(/\b\w/g, function (char) {
        return char.toUpperCase();
    });
}

function validateForm() {
    const requiredFields = document.querySelectorAll(
        "#passengerForm input[required], #passengerForm select[required]"
    );

    for (let field of requiredFields) {
        if (!field.value) {
            field.focus();
            return false;
        }
    }
    return true;
}

$(document).ready(function () {

    let storedFareDetails;
    try {
        storedFareDetails = JSON.parse(localStorage.getItem("sentReqest"));
    } catch {
        storedFareDetails = {};
    }

    if (storedFareDetails) {

        let roomCount = parseInt(storedFareDetails[0]?.roomCount);
        let adultCount = parseInt(storedFareDetails[0]?.adultCount) || 2;
        let childCount = parseInt(storedFareDetails[0]?.childCount) || 0;

        let totalPassengerCount = adultCount + childCount;

        for (let index = 0; index < totalPassengerCount; index++) {

            let paxType;
            let paxTypeValue;
            let heading = "";

            if (index < adultCount) {
                heading = `Adult ${index + 1}`;
                paxType = 'Adult';
                paxTypeValue = 1;
            } else {
                heading = `Child ${index - adultCount + 1}`;
                paxType = 'Child';
                paxTypeValue = 2;
            }

            // ⭐ FIXED LEAD LOGIC
            let isLeadPassenger = (index < roomCount && paxType === 'Adult');

            let roomLabel = '';

            if (isLeadPassenger) {
                let roomNumber = index + 1; // kyuki first N adults hi lead hain
                roomLabel = ` - Room ${roomNumber}`;
            }

            let formHtml = `
            <div class="table-responsive border rounded mt-2 rows" id="passenger-row-${index + 1}">
                
                <input type="hidden" name="occupantType" id="paxtype-${index + 1}" value="${paxType}"/>
                <input type="hidden" name="paxTypeValue" id="paxTypeValue-${index + 1}" value="${paxTypeValue}">
                <input type="hidden" name="paxLeadPassenger" id="paxLeadPassenger-${index + 1}" value="${isLeadPassenger}">

                <table class="table table-bordered mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>${heading} ${isLeadPassenger ? `(Lead ${roomLabel})` : ''}</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>
                                <div class="row">

                                    <!-- Title -->
                                    <div class="col-md-3 mb-3">
                                        <label>Title *</label>
                                        <select name="title" id="title-${index + 1}" class="form-control" required>
                                            <option value="">Select Title</option>
                                            <option value="Mr">Mr</option>
                                            <option value="Mrs">Mrs</option>
                                            <option value="Miss">Miss</option>
                                            <option value="Ms">Ms</option>
                                        </select>
                                    </div>

                                    <!-- First Name -->
                                    <div class="col-md-3 mb-3">
                                        <label>First Name *</label>
                                        <input type="text" name="firstName" id="firstName-${index + 1}"
                                        minlength="2" maxlength="50"
                                        oninput="validateName('firstName-${index + 1}')"
                                        class="form-control" required
                                        placeholder="Enter First Name">
                                    </div>

                                    <!-- Middle Name -->
                                    <div class="col-md-3 mb-3">
                                        <label>Middle Name</label>
                                        <input type="text" name="middleName" id="middleName-${index + 1}"
                                        maxlength="50"
                                        oninput="validateName('middleName-${index + 1}')"
                                        class="form-control" placeholder="Enter Middle Name">
                                    </div>

                                    <!-- Last Name -->
                                    <div class="col-md-3 mb-3">
                                        <label>Last Name *</label>
                                        <input type="text" name="lastName" id="lastName-${index + 1}"
                                        minlength="2" maxlength="50"
                                        oninput="validateName('lastName-${index + 1}')"
                                        class="form-control" required placeholder="Enter Last Name">
                                    </div>

                                    <!-- Phone -->
                                    ${isLeadPassenger ?
                                        `<div class="col-md-3 mb-3">
                                        <label>Phone ${isLeadPassenger ? '*' : ''}</label>
                                        <input type="text" name="mobile" id="mobile-${index + 1}"
                                            maxlength="10"
                                         oninput="validatePhone('mobile-${index + 1}')"
                                        class="form-control" placeholder="Enter Phone Number" required ></div>`
                                    : ''}
                                   

                                    <!-- Email -->
                                    ${isLeadPassenger ? 
                                        `<div class="col-md-3 mb-3">
                                            <label>Email ${isLeadPassenger ? '*' : ''}</label>
                                            <input type="email" name="email" id="email-${index + 1}"
                                            oninput="validateEmail('email-${index + 1}')"
                                            class="form-control" placeholder="Enter Email Id"
                                             required ></div>`
                                    : ''}

                                    <!-- Age -->
                                    ${paxType === 'Child' ? `
                                    <div class="col-md-3 mb-3">
                                        <label>Age *</label>
                                        <input type="number" name="age" id="age-${index + 1}"
                                        max="12" placeholder="Enter Age"
                                        class="form-control" required>
                                    </div>` : ''}

                                    <!-- PAN -->
                                    <div class="col-md-3 mb-3">
                                        <label>PAN</label>
                                        <input type="text" name="pan" id="pan-${index + 1}"
                                        maxlength="10" placeholder="Enter PAN"
                                        oninput="validatePan('pan-${index + 1}')"
                                        class="form-control">
                                    </div>

                                    <!-- Passport -->
                                    <div class="col-md-3 mb-3">
                                        <label>Passport No</label>
                                        <input type="text" name="passport" id="passport-${index + 1}"
                                        class="form-control" placeholder="Enter Passport Number">
                                    </div>

                                    <!-- Passport Issue -->
                                    <div class="col-md-3 mb-3">
                                        <label>Passport Issue</label>
                                        <input type="datetime-local" name="passportIssueDate" 
                                        id="passportIssueDate-${index + 1}"
                                        placeholder="Enter Passport Issue"
                                        class="form-control">
                                    </div>

                                    <!-- Passport Expiry -->
                                    <div class="col-md-3 mb-3">
                                        <label>Passport Expiry</label>
                                        <input type="datetime-local" name="passportExpDate" 
                                        id="passportExpDate-${index + 1}"
                                        placeholder="Enter Passport Expiry"
                                        class="form-control">
                                    </div>

                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            `;

            $("#formsContainerHotel").append(formHtml);
        }

        try {
            const existingPsgr = JSON.parse(localStorage.getItem('psgr') || '[]');
            if (existingPsgr && existingPsgr.length > 0) {
                existingPsgr.forEach((p, idx) => {
                    const num = idx + 1;
                    $(`#title-${num}`).val(p.Title);
                    $(`#firstName-${num}`).val(p.FirstName);
                    $(`#middleName-${num}`).val(p.MiddleName);
                    $(`#lastName-${num}`).val(p.LastName);
                    $(`#mobile-${num}`).val(p.Phoneno);
                    $(`#email-${num}`).val(p.Email);
                    $(`#age-${num}`).val(p.Age);
                    $(`#pan-${num}`).val(p.PAN);
                    $(`#passport-${num}`).val(p.PassportNo);
                    $(`#passportIssueDate-${num}`).val(p.PassportIssueDate);
                    $(`#passportExpDate-${num}`).val(p.PassportExpDate);
                });
            }
        } catch (e) {
            console.error("Error repopulating guest details:", e);
        }
    }

    // if (storedFareDetails) {
    //     let roomCount = parseInt(storedFareDetails[0]?.roomCount);

    //     var totalPassengerCount = parseInt(storedFareDetails[0]?.adultCount);
    //     //   var totalPassengerCount = parseInt(storedFareDetails[0]?.adultCount) + parseInt(storedFareDetails[0]?.childCount);

    //     var formCount = 0;
    //     createForm(formCount);
    //     $("#addMoreForm").on("click", function () {
    //         if (formCount < totalPassengerCount) {
    //             createForm(formCount);
    //         }
    //     });

    //     function createForm(index) {
    //         let formHtml = '';
    //         if (storedFareDetails) {
    //             var adultCount = parseInt(storedFareDetails[0]?.adultCount) || 2;
    //             var childCount = parseInt(storedFareDetails[0]?.childCount) || 0;
    //         }

    //         let paxType;
    //         let paxTypeValue;
    //         let heading = "";

    //         if (index < adultCount) {
    //             heading = `Adult ${index + 1}`;
    //             paxType = 'Adult';
    //             paxTypeValue = 1;
    //         } else if (index < adultCount + childCount) {
    //             heading = `Child ${index - adultCount + 1}`;
    //             paxType = 'Child';
    //             paxTypeValue = 2;
    //         }

    //         let isLeadPassenger = (index === 0 && paxType === 'Adult') ? true : false;

    //         formHtml += `
    //             <div class="table-responsive border rounded mt-2 rows" style="overflow: hidden;" id="passenger-row-${index + 1}">
    //              <input type="hidden" name="occupantType" id="paxtype-${index + 1}" value="${paxType}"/>
    //                 <input type="hidden" name="paxTypeValue" id="paxTypeValue-${index + 1}" value="${paxTypeValue}">
    //                 <input type="hidden" name="paxLeadPassenger" id="paxLeadPassenger-${index + 1}" value="${isLeadPassenger}">
  
    //                       <table class="table table-bordered  mb-0 " >
    //                           <thead class="thead-light bg-light">
    //                               <tr>
    //                                   <th>${heading}</th>
    //                               </tr>
    //                           </thead>
    //                           <tbody>
    //                               <tr>
    //                                   <td>
    //                                       <div class="row">
    //                                             <div class="col-md-3 mb-3">
    //                                                 <div class="form-group">
    //                                                     <label class="mb-1" for="title-${index + 1}">Title<sup class="text-danger">*</sup></label>
    //                                                     <select name="title" id="title-${index + 1}" class="form-control title-dropdown" required >
    //                                                         <option value="">Select Title</option>
    //                                                                 <option value="Mr">Mr</option>
    //                                                                 <option value="Mrs">Mrs</option>
    //                                                                 <option value="Miss">Miss</option>
    //                                                                 <option value="Ms">Ms</option>
    //                                                     </select>
    //                                                 </div>
    //                                             </div>
    //                                                 <div class="col-md-3 mb-3" >
    //                                                   <div class="form-group">
    //                                                       <label class="mb-1" for="firstName-${index + 1}">First  Name<sup class="text-danger">*</sup></label>
    //                                                       <input type="text" name="firstName" minlength="2" maxlength="50" id="firstName-${index + 1}" 
    //                                                       oninput="validateName('firstName-${index + 1}')" 
    //                                                       class="form-control" placeholder="Enter First Name"  required>
    //                                                   </div>
    //                                                 </div>
    //                                                 <div class="col-md-3 mb-3" >
    //                                                   <div class="form-group">
    //                                                       <label class="mb-1" for="middleName-${index + 1}">Middle  Name</label>
    //                                                       <input type="text" name="middleName" maxlength="50" id="middleName-${index + 1}" 
    //                                                       oninput="validateName('middleName-${index + 1}')" 
    //                                                       class="form-control" placeholder="Enter Middle Name">
    //                                                   </div>
    //                                                 </div>
    //                                                 <div class="col-md-3 mb-3">
    //                                                   <div class="form-group">
    //                                                       <label class="mb-1" for="lastName-${index + 1}">Last Name<sup class="text-danger">*</sup></label>
    //                                                       <input type="text" name="lastName" minlength="2" maxlength="50" id="lastName-${index + 1}" 
    //                                                             oninput="validateName('lastName-${index + 1}')" 
    //                                                             class="form-control" placeholder="Enter Surname" required>
    //                                                   </div>
    //                                                 </div>

    //                                                 ${paxType === 'Child' ? `
    //                                                     <div class="col-md-3 mb-3">
    //                                                         <div class="form-group">
    //                                                             <label class="mb-1" for="age-${index + 1}">Age<sup class="text-danger">*</sup></label>
    //                                                             <input type="number" name="age" id="age-${index + 1}" 
    //                                                                     oninput="validateAge('age-${index + 1}')"  max="12"
    //                                                                     class="form-control" placeholder="Enter Age">
    //                                                         </div>
    //                                                     </div>` 
    //                                                 : ''}

    //                                                 <div class="col-md-3 mb-3">
    //                                                     <div class="form-group">
    //                                                         <label class="mb-1" for="pan-${index + 1}">PAN Number</label>
    //                                                         <input type="text" name="pan" maxlength="10" id="pan-${index + 1}" 
    //                                                                 oninput="validatePAN('pan-${index + 1}')"
    //                                                                 class="form-control" placeholder="Enter PAN Number">
    //                                                     </div>
    //                                                 </div>
    //                                                 <div class="col-md-3 mb-3">
    //                                                     <div class="form-group">
    //                                                         <label class="mb-1" for="passport-${index + 1}">Passport No</label>
    //                                                         <input type="number" name="passport" maxlength="10" id="passport-${index + 1}" 
    //                                                                 oninput="validatePassport('passport-${index + 1}')" 
    //                                                                 class="form-control" placeholder="Enter passport Number">
    //                                                     </div>
    //                                                 </div>
    //                                                 <div class="col-md-3 mb-3">
    //                                                     <div class="form-group">
    //                                                         <label class="mb-1" for="passportIssueDate-${index + 1}">Passport Issue</label>
    //                                                         <input type="datetime-local" name="passportIssueDate" maxlength="10" id="passportIssueDate-${index + 1}" 
    //                                                                 class="form-control" placeholder="Enter Passport Issue Date">
    //                                                     </div>
    //                                                 </div>
                                                    
    //                                                 <div class="col-md-3 mb-3">
    //                                                     <div class="form-group">
    //                                                         <label class="mb-1" for="passportExpDate-${index + 1}">Passport Expiry</label>
    //                                                         <input type="datetime-local" name="passportExpDate" maxlength="10" id="passportExpDate-${index + 1}" 
    //                                                                 class="form-control" placeholder="Enter Passport Expiry Date">
    //                                                     </div>
    //                                                 </div>
                                                 
    //                                       </div>
    //                                   </td>
    //                               </tr>
    //                           </tbody>
    //                       </table>
    //                   </div>
    //     `;
    //         $("#formsContainerHotel").append(formHtml);
    //         formCount++;

    //         if (formCount >= totalPassengerCount) {
    //             $("#addMoreForm").attr("disabled", true);
    //         }
    //     }
    // }
});


function submitGuestDetails() {
    if (!validateForm()) {
        notify("Please fill in all required fields", "error");
    } else {
        let storedFareDetails;
        try {
            storedFareDetails = JSON.parse(localStorage.getItem("sentReqest"));
        } catch {
            storedFareDetails = {};
        }
        var totalPassengerCount = parseInt(storedFareDetails[0]?.adultCount) + parseInt(storedFareDetails[0]?.childCount);
      
        let hotelKy = sessionStorage.getItem('hkey');
        let netAmt = parseFloat(sessionStorage.getItem('amt') || 0).toFixed(2);
        let recomdet = JSON.parse(sessionStorage.getItem('recomdet'));
        const passengers = [];
        for (var index = 0; totalPassengerCount > index; index++) {
            const title = $(`#title-${index + 1}`).val();
            const occupantType = $(`#paxtype-${index + 1}`).val();
            const paxTypeValue = $(`#paxTypeValue-${index + 1}`).val();
            const paxLeadPassenger = $(`#paxLeadPassenger-${index + 1}`).val();
            const firstName = $(`#firstName-${index + 1}`).val();
            const middleName = $(`#middleName-${index + 1}`).val();
            const lastName = $(`#lastName-${index + 1}`).val();
            const mobile = $(`#mobile-${index + 1}`).val();
            const email = $(`#email-${index + 1}`).val();
            const age = $(`#age-${index + 1}`).val();
            const passport = $(`#passport-${index + 1}`).val();
            const pan = $(`#pan-${index + 1}`).val();
            const passportExpDate = $(`#passportExpDate-${index + 1}`).val();
            const passportIssueDate = $(`#passportIssueDate-${index + 1}`).val();

            if (!title || !occupantType || !firstName || !lastName) {
                notify("Kindly add all travellers before proceeding", "error");
                return true;
            }

            const passenger = {
                Title: title,
                 FirstName: firstName,
                MiddleName: middleName,
                LastName: lastName,     
                Phoneno: mobile,
                Email: email,
                PaxType: occupantType,
                LeadPassenger: paxLeadPassenger,
                Age: age,
                PassportNo: passport,
                PAN: pan,
                PaxId: paxTypeValue,
                PassportExpDate: passportExpDate,
                PassportIssueDate: passportIssueDate,
                GSTCompanyAddress: '',
                GSTCompanyContactNumber: '',
                GSTCompanyName: '',
                GSTNumber: '',
                GSTCompanyEmail: '',
            };

            passengers.push(passenger);
        }
        if (passengers.length != totalPassengerCount) {
            notify("Kindly add all travellers before proceeding", "error");
            return true;
        }

        const payload = {
            netAmt: netAmt,
            hotelKy: hotelKy,
            BookingId: recomdet?.BookingCode,
            details: recomdet,
            HotelPassenger: passengers,
            payment_mode: 'pg'
        };

        localStorage.setItem('psgr', JSON.stringify(passengers));
        window.location.href = "/hotel/review-booking"; 
        return;

        /*
        var txtMsg = `Want to book this Hotel and <br/>Proceed with the payment? </br>Amount: ₹ ${netAmt}`;

        swal({
            title: "Are you sure?",
            html: txtMsg,
            type: "question",
            showCancelButton: true,
            confirmButtonText: "Yes, Proceed",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed || result.value) {
                swal({
                    type: "warning",
                    title: "Processing...",
                    text: "Please wait, redirecting you to the secure payment gateway.",
                    allowOutsideClick: false,
                    allowEscapeKey: false
                });
                
                $.ajax({
                    url: "/hotel/booking",
                    method: "POST",
                    contentType: "application/json",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    data: JSON.stringify(payload),
                    success: function (response) {
                        if (response.url) {
                            window.location.href = response.url;
                            return;
                        }

                        swal.close();
                        let recomdet = JSON.parse(sessionStorage.getItem('recomdet'));
                        let alHotelData = JSON.parse(sessionStorage.getItem('allHotelData'));
                        let sentReqest = JSON.parse(localStorage.getItem('sentReqest'));
                        let psngr = JSON.parse(localStorage.getItem('psgr'));
                        let checkInFormatted = formatDate(sentReqest[0]?.chkInDate);
                        let checkOutFormatted = formatDate(sentReqest[0]?.chkOutDate);

                        let bookingStatus = response?.data?.Status;
                        if (response.status == "success" && bookingStatus == 1) {
                            swal({
                                type: "success",
                                html: `<p><span class="badge bg-success">Booking Confirmed</span></p>
                                    <div class="alert alert-secondary border rounded p-3">
                                        <ul class="list-unstyled mb-0">
                                            <li>Your booking is successful at <strong class="fs-5">${alHotelData?.Name}</strong> and your 
                                            Booking ID : <span class="badge bg-primary">${response?.data?.BookingId}</span>
                                            
                                            and Invoice Number : <span class="badge bg-primary">${response?.data?.InvoiceNumber}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body px-1 pt-1 pb-0 mb-0">
                                        <p>Lead Guest:<span class="fs-4"> ${psngr[0]?.Title}  ${psngr[0]?.FirstName}  ${psngr[0]?.LastName}</span></p>
                                    </div>`,
                                confirmButtonText: 'OK, Got it🙂',
                                showConfirmButton: true,
                                backdrop: true,
                                allowOutsideClick: false,
                            }).then((result) => {
                                if (result.isConfirmed || result.value) {
                                    setTimeout(function () {
                                        window.open("/hotel/view", "_self");
                                    }, 1000);
                                }
                            });                            
                        } else if (bookingStatus == 3) {
                            notify("Price changed. Please verify before booking again.", "warning");

                        } else if (bookingStatus == 6) {
                            notify("Booking has been cancelled.", "error");

                        } else if (bookingStatus == 0) {
                            notify("Booking failed. Please try again.", "error");

                        } else {
                            notify(
                                response?.message ||
                                "Error while booking Hotel.",
                                "error"
                            );
                            setTimeout(function () {
                                window.open("/hotel/view", "_blank");
                            }, 2000);
                        }
                    },
                    error: function (error) {
                        swal.close();
                        notify(
                            "Something went wrong while confirming the booking.",
                            "error"
                        );
                        setTimeout(function () {
                            window.open("/hotel/view", "_blank");
                        }, 2000);
                    },
                });
            }
        });
        */
    }
}



function formatDate(dateStr) {
    let parts = dateStr.split("-");
    let formattedDate = new Date(parts[2], parts[1] - 1, parts[0]);
    let options = { weekday: 'short', day: '2-digit', month: 'short', year: 'numeric' };
    return formattedDate.toLocaleDateString('en-GB', options).replace(/,/g, '');
}

   