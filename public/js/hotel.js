function totalRoomsAndGuest() {
    const rooms = parseInt($("#room").text());
    const adults = parseInt($("#adult").text());
    const children = parseInt($("#children").text());

    document.getElementById("guestAndRooms").value = `${rooms} Room / ${adults + children} Guests`;
}

$(document).ready(function () {
    const maxRooms = 6;
    const maxAdults = 48;
    const maxChildren = 12;
    const minRooms = 1;
    const maxAdultsPerRoom = 8;
    const maxChildrenPerRoom = 2;

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
                            ${[...Array(13).keys()].map(age => `<option value="${age}">${age}</option>`).join('')}
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

    let destid = $("#cityName").val();
    var destname = $('#cityName').find('option:selected').text();

    const rooms = parseInt($("#room").text());
    const adults = parseInt($("#adult").text());
    const children = parseInt($("#children").text());

    let checkin = $("#checkin").val();
    let checkout = $("#checkout").val();
    const childAge = $(".child-age-select").map((_, el) => $(el).val()).get();

    // console.log(childAge.length > 0 ? childAge :[]);

    sentR = {
        chkInDate: checkin,
        chkOutDate: checkout,
        adultCount: adults,
        childCount: children,
        destFullName: destname,
        destId: destid,
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

            console.log(data);
            $("#form-wizard1").find("[type='button']").attr("disabled", false);
            $(".preview-card-side").html("");
            $(".preview-card-body").html("");

            if (data.status == "success" && data.data?.HotelResults?.length > 0) {

                localStorage.setItem("traceId", data?.data?.TraceId);
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

    let x = data?.data?.HotelResults;

    x.forEach(function (hotel, index) {
        var bs = hotelSklt(hotel, index);

        $(".preview-card-body").append(bs);
    });

    $('[data-bs-toggle="tooltip"]').tooltip({ html: true });
}

function hotelSklt(z, indexx) {
    var dt = '';
    let maxVisiblePolicies = 5;
    let hiddenPolicies = [];

    dt += `<div class="hotels-item card bg-white shadow-sm rounded p-3 mb-3" id="hotel${indexx}">
              <div class="row">
                <div class="col-md-4" style="height:203px;"> 
                    <a href="javascript:void(0)"><img class="img-fluid rounded align-top" style="height:100%; width:100%"
                    src="${z?.HotelPicture}" alt="hotels"></a> 
                </div>

                <div class="col-md-8 ps-3 ps-md-0 mt-3 mt-md-0">
                  <div class="row g-0">
                    <div class="col-sm-9">
                      <h4><a target="_blank" href="https://www.google.com/maps/search/${z?.HotelName.replace(/\s+/g, '')}/@${z?.Latitude},${z?.Longitude}" class="text-dark text-5">${z?.HotelName}</a></h3>
                      <p class="mb-2"> 
                        <span class="me-2">`;
    for (let i = 0; i < parseInt(z?.StarRating); i++) {
        dt += `<i class="fas fa-star text-warning"></i> `;
    }
    dt += `</span>
                        
                        <span class="text-black-50">
                                <i class="fas fa-map-marker-alt"></i> ${z?.HotelAddress}
                        </span> 
                       </p>
                      
                      <p class="hotels-amenities align-items-center mb-2 text-4" id="facilityContainer${indexx}">`;

    let policies = z?.HotelPolicy
        ? z.HotelPolicy.split('|').map(item => item.trim()).filter(item => item !== '')
        : [];
    policies.forEach((policy, index) => {
        if (index < maxVisiblePolicies) {
            dt += `<span class="cf border rounded badge text-1 text-nowrap px-2 m-1 text-muted">${policy}</span>`;
        } else {
            hiddenPolicies.push(policy);
        }
    });

    if (hiddenPolicies.length > 0) {
        const tooltipContent = `
                        <strong>Policies:</strong><br><ul style='list-style-type: circle; padding-left: 20px; text-align: left;'>
                        ${hiddenPolicies.map(policy => `<li>${policy}</li>`).join('')}</ul>
                    `;
        dt += `<span class="text-nowrap px-2 m-0 more-btn" 
                            data-bs-toggle="tooltip" 
                            data-bs-placement="bottom" 
                            data-bs-html="true" 
                            title="${tooltipContent}">
                        <small style="font-size:small">..more</small>
                        </span>`;
    }

    dt += `
                       </p>
                        <p class="reviews mb-2"> 
                            ${z?.Price?.breakfast
            ? '🥣 <span class="fw-600">Free Breakfast</span>'
            : ''}  
                                &nbsp;&nbsp;&nbsp;
                            ${z?.Price?.freeCancellation == '2' ? ''
            : '✅ <span class="fw-600">Free Cancellation Allowed</span>'}  
                        </p>
                     
                    </div>
                    <div class="col-sm-3 g-4 text-end d-flex d-sm-block align-items-center">
                     <div class="text-success text-3 mb-0 mb-sm-1 order-2 ">${z?.Price?.Discount ?? 0}% Off!</div>
                       <div class="d-block text-3 text-black-50 mb-0 mb-sm-2 me-2 me-sm-0 order-1 mt-3">Starts from</div>
                      

                      <div class="fare-container" data-index="${indexx}">
                        <div class="text-6 fw-bold mb-0 mb-sm-2 m-2 me-sm-0 order-0 price-display fw-bold" style="color:#d63b05;">₹${z?.Price?.PublishedPriceRoundedOff || z?.Price?.PublishedPrice}</div>
                        <div class="fare-breakdown-container-hotel card p-3" style="display:none; background: #f8f9fa; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); min-width: 220px;border:1px solid silver">
                            <div class="fare-breakdown-row base-fare d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold text-start">Room Price</span>
                                <span class="fs-6">₹${z?.Price?.RoomPrice}</span>
                            </div>
                            <hr class="my-2"/>
                            <div class="fare-breakdown-row tax d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold">Tax</span>
                                <span class="fs-6">₹${z?.Price?.Tax}</span>
                            </div>
                            
                            <hr class="my-2"/>
                            <div class="fare-breakdown-row othercharges d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold">Other</span>
                                <span class="fs-6">₹${z?.Price?.OtherCharges}</span>
                            </div>
                            
                            <hr class="my-2"/>
                            <div class="fare-breakdown-row commission d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold">Commission</span>
                                <span class="fs-6">₹${z?.Price?.AgentCommission}</span>
                            </div>
                            <hr class="my-2"/>
                            <div class="fare-breakdown-row total d-flex justify-content-between align-items-center mt-2">
                                <span class="fs-6 fw-bold">TOTAL</span>
                                <span class="fs-5 fw-bold" style="color:#d63b05;">₹${z?.Price?.PublishedPriceRoundedOff || z?.Price?.PublishedPrice}</span>
                            </div>
                        </div>
                        </div>
                        <div class="text-black-50 mb-0 mb-sm-2 order-3 d-none d-sm-block mt-3">1 Room/Night</div>
                      <button onclick=viewNowHotel('${encodeURIComponent(JSON.stringify(z))}') class="btn btn-sm btn-primary order-4 ms-auto">Book Room</button> </div>
                  </div>
                </div>
              </div>
            </div>`;
    return dt;
}


let sessionExpired = false;
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

function hotelDeatilsUrlAjaxHit(datas, traceId) {

    $.ajax({
        url: "/hotel/details",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            HotelCode: datas?.HotelCode,
            TraceId: traceId,
            ResultIndex: datas?.ResultIndex,
        },
        success: function (data) {
            showHotelTabContent(data?.data);
        },
        error: function () {
            notify('Something went wrong', 'error');
        },
    });
}

function hotelRoomRateDetailsAjaxHit(datas, traceId) {

    $.ajax({
        url: "/hotel/room",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            HotelCode: datas?.HotelCode,
            TraceId: traceId,
            ResultIndex: datas?.ResultIndex,
        },
        success: function (data) {
            let html = viewAllHotelRoom(data?.data?.HotelRoomsDetails);

            $('#chooseroom').html(html);
        },
        error: function () {
            notify('Something went wrong', 'error');
        },
    });
}

function showHotelTabContent(viewdet) {

    storedAllHotelData = JSON.parse(sessionStorage.getItem('allHotelData'));

    let detailstabhtml = '';
    let galleryimg = '';

    detailstabhtml = `<div class="tab-pane fade show active" id="knownfor" role="tabpanel"
                        aria-labelledby="knowwnfor-tab">
                        
                        ${viewdet?.HotelDetails?.Description ? `<p class="mb-2">${viewdet?.HotelDetails.Description}</p>` : '<p class="mb-2">No description available.</p>'}
                    </div>
                    <div class="tab-pane fade" id="chooseroom" role="tabpanel" aria-labelledby="chooseroom-tab">
                       
                    </div>
                    <div class="tab-pane fade" id="amenities" role="tabpanel"
                        aria-labelledby="amenities-tab">
                      <div class="row ps-3">
                        ${viewdet?.HotelDetails?.HotelPolicy
            ?.trim()
            .replace(/,+$/, '')
            .split('|')
            .reduce((acc, curr, index, array) => {
                const itemsPerColumn = Math.ceil(array.length / 3);
                const columnIndex = Math.floor(index / itemsPerColumn);
                acc[columnIndex] = acc[columnIndex] || [];
                acc[columnIndex].push(curr.trim());
                return acc;
            }, []).map((chunk) => `<div class="col-sm-4"><ul class="simple-ul">${chunk.map(item => `<li>${item}</li>`).join('')}</ul></div>`)
            .join('')
        }
                        </div>
                    </div>`;

    $('#hotel_name_det').html(`<section class="rounded bg-white p-3 mb-2 d-flex justify-content-between ">
                            <span><span class="fs-4 fw-bold">${viewdet?.HotelDetails?.HotelName}</span>
                            <p class="opacity-8 mb-0"><i class="fas fa-map-marker-alt"></i>
                                ${viewdet?.HotelDetails?.Address}, ${viewdet?.HotelDetails?.CountryName} ${viewdet?.HotelDetails?.PinCode}</p>  </span>
                                <a target="_blank" href="https://www.google.com/maps/search/${viewdet?.HotelDetails?.HotelName}/@${viewdet?.HotelDetails?.Latitude},${viewdet?.HotelDetails?.Longitude}">
                                <img src="/images/map.png" title="Goto Map" height="100%" width="100%" style="height:45px;"/></a>
                        </section>`);

    $('#hotel_image').html(`<img src="${viewdet?.HotelDetails?.Images[0]}" width="100%" class="rounded"
        style="height: 320px; object-fit: cover;width: 100%; border-radius: 8px;"/>`);



    $('#viewdetHotelContent').html(detailstabhtml);

    galleryimg = viewdet?.HotelDetails.Images.map((valH, index) => {

        if (index < 3) {
            return `<div class="col-6 mb-2">
                        <img src="${valH}" alt="HotelImages${index}" class="img-fluid rounded" width="100%" 
                        style="height: 153px; object-fit: cover;width: 100%;">
                    </div>`;
        } else if (index === 3) {
            return `<div class="col-6">
            <div class="position-relative">
                <img src="${valH}" alt="HotelImages${index}" class="img-fluid rounded" width="100%"
                style="height: 153px; object-fit: cover;width: 100%;">
                <div style="height:95%" class="hover-overlay rounded position-absolute top-0 start-0 w-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-25">
                    <button class="btn btn-secondary btn-sm" id="viewAllImages">view all</button>
                </div>
            </div>
        </div>`;
        }
    }).join('');


    $('#galleryImgSwiperHotel').html(galleryimg);
    let allImages = viewdet?.HotelDetails?.Images.map((valH, ind) => {
        return ` <div class="carousel-item ${ind == 0 ? 'active' : ''}">
                    <img class="d-block w-100 rounded" src="${valH}" alt="Hotel Images" style="height:550px; object-fit:cover"/>
                </div>`;
    }).join('');

    $('#morehotelimg').html(allImages);

    $('#galleryImgSwiperHotel').on('click', '#viewAllImages', function () {
        $('#showmoreHotelImageModal').modal('show');
    });

    swiperDefault = document.querySelector('#swiper-default')

    if (swiperDefault) {
        new Swiper(swiperDefault, {
            slidesPerView: 'auto'
        });
    }

}

function viewAllHotelRoom(roomDet) {

    console.log(roomDet);
    let roomdet = roomDet?.Price;
    let roomdetHtml = '';

    const maxVisibleInclusion = 4;
    const hiddenInclusion = [];

    let galleryimg = '';
    let allGalleryImages = '';

    if (roomdet && Array.isArray(roomdet) && roomdet.length > 0) {
        roomdetHtml += roomdet?.map((roomd, index) => {
            let fac = '';
            let galData = roomd?.ratePlanDetails[0]?.roomDetails[0]?.hotelGallery;
            if (galData && Array.isArray(galData) && galData.length > 0) {

                allGalleryImages = galData.map((valH, ind) => {
                    return ` <div class="carousel-item ${ind == 0 ? 'active' : ''}">
                                <img class="d-block w-100 rounded" src="${valH?.imageURL}" alt=""${valH?.imageDesc}" style="height:550px; object-fit:cover"/>
                            </div>`;
                }).join('');

                galleryimg = galData.map((valH, indexxx) => {


                    if (indexxx === 0) {
                        return `<div class="position-relative">
                            <img class="img-fluid rounded align-top" src="${valH?.imageURL}" alt="${valH?.imageDesc}" style="height: 225px;width: 100%;"> 
                           
                            <div style="height: 225px;object-fit: cover;" class="hover-overlay rounded position-absolute top-0 start-0 w-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-25">
                                <button class="btn btn-secondary btn-sm" onclick="viewAllGalleryImages(${indexxx}, '${allGalleryImages}')">view all</button>
                            </div>
                        </div>`;
                    }
                }).join('');
            } else {
                galleryimg = `<img class="img-fluid rounded align-top" src="https://ik.imagekit.io/ryn4njrqfh/TravlTech/no_img_hotel.jpg?updatedAt=1742980696180" alt="Hotels" style="height: 225px;width: 100%;"> `;
            }

            // Facility
            if (roomd?.ratePlanDetails[0]?.inclusion != null) {
                roomd?.ratePlanDetails[0]?.inclusion.split(',').forEach((facility, index) => {

                    if (facility != ' ') {
                        fac += `<span class="cf border rounded badge text-1 text-nowrap px-2 m-1">${facility}</span>`;
                    }
                });
            }


            return ` <div class="row g-4" id="hotelRoom${index}">
                        <div class="col-12 col-md-5" style="height:225px;"> 
                            ${galleryimg}
                        </div>
                        <div class="col-12 col-md-7">
                            <h4 class="text-5"> ${roomd?.ratePlanDetails[0]?.roomDetails[0]?.groupName}</h4>
                            <ul class="list-inline mb-2">
                            <li class="list-inline-item"><span class="me-1 text-black-50"><i class="fas fa-bed"></i></span>
                            <span style="font-size:14px;">${roomd?.ratePlanDetails[0]?.roomDetails[0]?.hotelRoomTypeDesc}</span>
                            </li>

                            </ul>
                            <div class="mb-3">
                             <p class="hotels-amenities align-items-center mb-2 text-4" id="facilityContainer10">
                                ${fac}
                            </p>
                            </div>
                            <div class="d-flex align-items-center">
                            <div class="text-dark text-7 lh-1 fw-500 me-2 me-lg-3">₹${roomd?.totalAmount}</div>
                            <div class="d-block text-4 text-black-50 me-2 me-lg-3"></div>
                            <div class="text-success text-3 me-2 me-lg-3"> 
                            ${roomd?.ratePlanDetails[0]?.roomAvailability
                    ? '<span class="cf border rounded badge bg-label-success text-1 text-nowrap px-2 m-1">Room Available</span>'
                    : '<span class="cf border rounded badge bg-label-danger text-1 text-nowrap px-2 m-1">Room Not Available</span>'}</div>
                           
                            <div class="text-success text-3 me-2 me-lg-3"> 
                            ${roomd?.ratePlanDetails[0]?.refundable.toLowerCase() == 'true'
                    ? '<span class="cf border rounded badge bg-label-success text-1 text-nowrap px-2 m-1">Refundable</span>'
                    : '<span class="cf border rounded badge bg-label-danger text-1 text-nowrap px-2 m-1">Non-Refundable</span>'}</div>
                            <span class="text-black-50">1 Room/Night</span> </div>
                            <div class="d-flex align-items-center mt-3"> 
                            <a href="javascript:void(0)" onclick="cancelPolicy('${encodeURIComponent(roomd?.ratePlanDetails[0]?.cancellationPolicy)}',
                                    '${roomd?.ratePlanDetails[0]?.childrenPolicy ? encodeURIComponent(JSON.stringify(roomd?.ratePlanDetails[0]?.childrenPolicy)) : ''}',
                                    '${JSON.stringify(roomd?.ratePlanDetails[0]?.essentialInformation)}')">Cancellation Policy</a> 
                          <button onclick="bookNowHotel(this,'${JSON.stringify(roomd)}', '${roomDet?.hotelKey}', ${roomd?.totalAmount})" 
                          class="btn btn-sm btn-outline-primary shadow-none ms-auto select-room-btn">Select Room</button> </div>
                        </div>
                        </div>
                     <hr class="my-5"/>`;
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
            if (result.isConfirmed) {
                setTimeout(function () {
                    window.open("/hotel/booking", "_self");
                }, 2000);
            }
        });
    }

    return roomdetHtml;
}

function bookNowHotel(buton, roomd, hkey, amt) {
    $('.select-room-btn').removeClass('btn-primary').addClass('btn-outline-primary');
    $(buton).addClass('btn-primary').removeClass('btn-outline-primary');
    $('#selectroomfare').html('');
    $('#d-grid').html('');
    $('#selectroomfare').html(amt);
    $('#d-grid').html(`<button class="btn btn-primary" type="button" id="selectRoomBtn" onclick="selectedroom('${roomd}', '${hkey}')">Continue ➜</button>`);
}

function selectedroom(roomd, hkey) {
    sessionStorage.setItem("recomdet", roomd);
    sessionStorage.setItem("hkey", hkey);
    window.open("/hotel/guest/detail", "_blank");
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

function viewAllGalleryImages(id, allGalleryImages) {

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

    let roomCount = parseInt(storedFareDetails[0]?.roomCount);

    var totalPassengerCount = parseInt(storedFareDetails[0]?.adultCount);
    //   var totalPassengerCount = parseInt(storedFareDetails[0]?.adultCount) + parseInt(storedFareDetails[0]?.childCount);

    var formCount = 0;
    createForm(formCount);
    $("#addMoreForm").on("click", function () {
        if (formCount < totalPassengerCount) {
            createForm(formCount);
        }
    });



    function createForm(index) {
        let formHtml = '';
        if (storedFareDetails) {
            var adultCount = parseInt(storedFareDetails[0]?.adultCount) || 2;
            var childCount = parseInt(storedFareDetails[0]?.childCount) || 0;
        }

        let paxType;
        let heading = "";

        if (index < adultCount) {
            heading = `Adult ${index + 1}`;
            paxType = 'Adult';
        } else if (index < adultCount + childCount) {
            heading = `Child ${index - adultCount + 1}`;
            paxType = 'Child';
        }


        formHtml += `
                <div class="table-responsive border rounded mt-2 rows" style="overflow: hidden;" id="passenger-row-${index + 1}">
                 <input type="hidden" name="occupantType" id="paxtype-${index + 1}" value="${paxType}"/>
  
                          <table class="table table-bordered  mb-0 " >
                              <thead class="thead-light bg-light">
                                  <tr>
                                      <th>${heading}</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr>
                                      <td>
                                          <div class="row">
                                              <div class="col-md-3 mb-3">
                                                  <div class="form-group">
                                                      <label class="mb-1" for="room-${index + 1}">Room Select</label>
                                                      <select name="room" id="room-${index + 1
            }" class="form-control room-dropdown" required >
                <option value="">Select room</option>`;

        for (var i = 1; roomCount >= i; i++) {
            formHtml += `<option value="${i}">Room ${i}</option>`;
        }

        formHtml += `</select>
                                                  </div>
                                              </div>
                                              <div class="col-md-3 mb-3">
                                                  <div class="form-group">
                                                      <label class="mb-1" for="title-${index + 1}">Title</label>
                                                      <select name="title" id="title-${index + 1}" class="form-control title-dropdown" required >
                                                          <option value="">Select Title</option>
                                                          ${paxType === 1 ? `
                                                              <option value="MISS" >Miss</option>
                                                            <option value="MSTR">Mstr</option>`
                : `
                                                            <option value="MR">Mr.</option>
                                                            <option value="MS">Ms.</option>
                                                            <option value="MRS">Mrs.</option>`
            }
                                                      </select>
                                                  </div>
                                              </div>
                                              <div class="col-md-3 mb-3" >
                                                      <div class="form-group">
                                                          <label class="mb-1" for="firstName-${index + 1}">Given  Name</label>
                                                          <input type="text" name="firstName" maxlength="50" id="firstName-${index + 1}" 
                                                          oninput="validateName('firstName-${index + 1}')" class="form-control" placeholder="Enter Given name"  required>
                                                      </div>
                                                  </div>
                                                  <div class="col-md-3 mb-3">
                                                      <div class="form-group">
                                                          <label class="mb-1" for="lastName-${index + 1
            }">Surname</label>
                                                          <input type="text" name="lastName" maxlength="50" id="lastName-${index + 1
            }" oninput="validateName('lastName-${index + 1
            }')" class="form-control" placeholder="Enter Surname"  required>
                                                      </div>
                                                  </div>
                                                 
                                          </div>
                                      </td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
        `;
        $("#formsContainerHotel").append(formHtml);
        formCount++;

        if (formCount >= totalPassengerCount) {
            $("#addMoreForm").attr("disabled", true);
        }
    }

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
        // var totalPassengerCount = parseInt(storedFareDetails[0]?.adultCount) + parseInt(storedFareDetails[0]?.childCount);
        var totalPassengerCount = parseInt(storedFareDetails[0]?.adultCount);
        let hotelKy = sessionStorage.getItem('hkey');
        let recomdet = JSON.parse(sessionStorage.getItem('recomdet'));
        const passengers = [];
        for (var index = 0; totalPassengerCount > index; index++) {
            const title = $(`#title-${index + 1}`).val();
            const occupantType = $(`#paxtype-${index + 1}`).val();
            const firstName = $(`#firstName-${index + 1}`).val();
            const lastName = $(`#lastName-${index + 1}`).val();
            const room = $(`#room-${index + 1}`).val();

            if (!title || !occupantType || !firstName || !lastName || !room) {
                notify("Kindly add all travellers before proceeding", "error");
                return true;
            }

            const passenger = {
                title: title,
                firstName: firstName,
                lastName: lastName,
                occupantType: occupantType,
                roomId: room
            };

            passengers.push(passenger);
        }
        if (passengers.length != totalPassengerCount) {
            notify("Kindly add all travellers before proceeding", "error");
            return true;
        }

        const payload = {
            requestId: sessionStorage.getItem("rId"),
            email: $('input[name="email"]').val(),
            mobileNo: $('input[name="mobile"]').val(),
            pinCode: $('input[name="pinCode"]').val(),
            address: $('input[name="address"]').val(),
            remarks: $('input[name="remarks"]').val(),
            occupantDetails: passengers,
            hotelKey: hotelKy,
            recommendationId: recomdet?.recommendationId
        };

        localStorage.setItem('psgr', JSON.stringify(passengers));

        swal({
            type: "question",
            text: `Want to book this Hotel ?`,
            showCancelButton: true,
            confirmButtonText: 'Yes, I Want',
            cancelButtonText: 'No, Cancel',
            showLoaderOnConfirm: true,
            backdrop: true,
            allowOutsideClick: false,
        }).then((result) => {
            if (result.isConfirmed) {
                swal({
                    title: "Processing...",
                    text: "Please wait, we are fetching details",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                });
                $.ajax({
                    url: "/hotel/temp-book",
                    method: "POST",
                    contentType: "application/json",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    data: JSON.stringify(payload),
                    success: function (response) {

                        if (response?.status == "missing") {
                            swal.close();
                            notify(
                                response?.message || "Passenger details parameter missing",
                                "error"
                            );
                        } else if (response.status == "success") {
                            notify("Passenger details submitted successfully.", "success");
                            tripPaymetHit(response);
                        } else {
                            swal.close();
                            notify(
                                response?.message ||
                                "Error while submitting passenger details.",
                                "error"
                            );
                        }
                    },
                    error: function (error) {
                        swal.close();
                        notify("Failed to submit passenger details.", "error");
                    },
                });
            }
        });

    }
}


function tripPaymetHit($response) {
    $.ajax({
        url: "/hotel/payments",
        type: "POST",
        data: JSON.stringify({
            requestId: sessionStorage.getItem("rId"),
            orderRefNo: $response.data.orderRefNo,
        }),
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        contentType: "application/json",
        success: function (response) {
            swal.close();

            if (response.status == "success") {
                confirmPaymetHit(response?.data);
            } else if (response.status == "missing") {
                notify(response.message || "Some fields are missing", "error");
            } else {
                notify(response.message || "Something went worng", "error");
            }
        },
        error: function (error) {
            notify("Something went worng", "error");
        },
    });
}

function formatDate(dateStr) {
    let parts = dateStr.split("-");
    let formattedDate = new Date(parts[2], parts[1] - 1, parts[0]);
    let options = { weekday: 'short', day: '2-digit', month: 'short', year: 'numeric' };
    return formattedDate.toLocaleDateString('en-GB', options).replace(/,/g, '');
}

function confirmPaymetHit(datas) {
    // console.log(datas);
    var txtMsg = `Are you sure you want to proceed with the payment? </br>Amount: ₹ ${datas?.amount}`;

    swal({
        title: "Confirm Payment",
        html: txtMsg,
        type: "warning",
        confirmButtonText: `Pay & Confirm`,
        cancelButtonText: "Cancel",
        showCancelButton: true,
        showLoaderOnConfirm: true,
        backdrop: true,
        allowOutsideClick: false,
    }).then((result) => {
        if (result.isConfirmed) {
            swal({
                title: "Processing...",
                text: "Please wait while your booking is being confirmed.",
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                },
            });
            $.ajax({
                url: "/hotel/confirm-book",
                type: "POST",
                data: JSON.stringify({
                    requestId: sessionStorage.getItem("rId"),
                    bookingRefNo: datas?.bookingRefNo || ""
                }),
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                contentType: "application/json",
                success: function (response) {
                    swal.close();
                    let recomdet = JSON.parse(sessionStorage.getItem('recomdet'));
                    let alHotelData = JSON.parse(sessionStorage.getItem('allHotelData'));
                    let sentReqest = JSON.parse(localStorage.getItem('sentReqest'));
                    let psngr = JSON.parse(localStorage.getItem('psgr'));

                    let essentialInfo = recomdet?.ratePlanDetails[0]?.essentialInformation;

                    let checkInInfo = essentialInfo?.find(info => info.type === "Check-in")?.text || "Check-in details not available";
                    let checkOutInfo = essentialInfo?.find(info => info.type === "Check-out")?.text || "Check-out details not available";

                    let checkInFormatted = formatDate(sentReqest[0]?.chkInDate);
                    let checkOutFormatted = formatDate(sentReqest[0]?.chkOutDate);


                    if (response.status == "success") {
                        swal({
                            type: "success",
                            html: `<p><span class="badge bg-success">Booking Confirmed</span></p>
                                <div class="alert alert-light border rounded p-4">
                                    <ul class="list-unstyled">
                                        <li>Your booking is successful at <strong class="fs-5">${alHotelData?.hotelName}, ${alHotelData?.location}</strong> and your 
                                        Booking ID : <span class="badge bg-primary">${response?.data?.bookingRefNo}</span></li>
                                    </ul>
                                </div>
                                <div class="card-body px-1 pt-1 pb-0 mb-0">
                                    <p>Lead Guest:<span class="fs-4"> ${psngr[0]?.title}  ${psngr[0]?.firstName}  ${psngr[0]?.lastName}</span></p>
                                    <span><small>Check-in:</small> ${checkInFormatted}, <small>(${checkInInfo})</small></span>
                                    <br/>
                                    <span><small>Check-out:</small> ${checkOutFormatted}, <small>(${checkOutInfo})</small></span>
                                </div>`,
                            confirmButtonText: 'OK, Got it🙂',
                            showConfirmButton: true,
                            backdrop: true,
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                setTimeout(function () {
                                    window.open("/booking/history/hotels", "_self");
                                }, 1000);
                            }
                        });
                    } else {
                        notify(response.message, "error");
                    }

                    setTimeout(function () {
                        window.open("/booking/history/hotels", "_blank");
                    }, 5000);
                },
                error: function (error) {
                    notify(
                        "Something went wrong while confirming the booking.",
                        "error"
                    );
                    setTimeout(function () {
                        window.open("/booking/history/hotels", "_blank");
                    }, 2000);
                },
            });
        } else {
            setTimeout(function () {
                window.open("/booking/history/hotels", "_blank");
            }, 2000);
        }
    });
}
