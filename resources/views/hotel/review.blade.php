@extends('layouts.app')
@section('title', 'Review Your Booking')
@section('pagetitle', 'Review Your Booking')

@push('style')
<style>
    .swal2-icon {
        transform: scale(0.7) !important;
        margin-top: 10px !important;
        margin-bottom: -10px !important;
    }
    .swal2-popup {
        padding-bottom: 20px !important;
        border-radius: 12px !important;
    }
    .swal2-title {
        padding-top: 0 !important;
        font-size: 1.5rem !important;
    }
</style>
@endpush

@section('content')

<main>
    <section>
        <div class="row">
            <!-- Left Column: Hotel & Guest Details -->
            <div class="col-lg-8">
                <!-- Hotel Summary Card -->
                <div class="card mb-4 border shadow-sm">
                    <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 card-title">🏨 Hotel Summary</h5>
                        <span id="refundable-badge" class="badge bg-success">Refundable</span>
                    </div>
                    <div class="card-body mt-3">
                        <div class="row align-items-center">
                            <div class="col-md-3 mb-3 mb-md-0">
                                <img id="hotel-img" src="" alt="Hotel" class="img-fluid rounded border" style="height: 120px; width: 100%; object-fit: cover;">
                            </div>
                            <div class="col-md-9">
                                <h4 id="hotel-name" class="text-primary mb-1">Hotel Loading...</h4>
                                <p id="hotel-rating" class="mb-2 text-warning"></p>
                                <div class="d-flex flex-wrap gap-3 mt-2">
                                    <div class="review-info-item">
                                        <small class="text-muted d-block">Check-In</small>
                                        <strong id="checkin-date" class="text-dark">--</strong>
                                    </div>
                                    <div class="vr mx-2"></div>
                                    <div class="review-info-item">
                                        <small class="text-muted d-block">Check-Out</small>
                                        <strong id="checkout-date" class="text-dark">--</strong>
                                    </div>
                                    <div class="vr mx-2"></div>
                                    <div class="review-info-item">
                                        <small class="text-muted d-block">Rooms & Guests</small>
                                        <strong id="stay-details" class="text-dark">--</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Guest Details Card -->
                <div class="card mb-4 border shadow-sm">
                    <div class="card-header bg-light border-bottom">
                        <h5 class="mb-0 card-title">👤 Guest Details</h5>
                    </div>
                    <div class="card-body mt-3">
                        <div id="guest-list-container" class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Guest Name</th>
                                        <th>Type</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody id="guest-list-body">
                                    <tr>
                                        <td colspan="4" class="text-center">Loading guest details...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Contact Information Card -->
                <div class="card mb-4 border shadow-sm">
                    <div class="card-header bg-light border-bottom">
                        <h5 class="mb-0 card-title">📞 Contact Information</h5>
                    </div>
                    <div class="card-body mt-3">
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted d-block">Email Address</small>
                                <strong id="contact-email">--</strong>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Mobile Number</small>
                                <strong id="contact-mobile">--</strong>
                            </div>
                        </div>
                        <div class="alert alert-info mt-3 mb-0" role="alert">
                            <i class="ti ti-info-circle me-1"></i> Your hotel voucher and receipt will be sent to this email/mobile.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Fare Summary -->
            <div class="col-lg-4">
                <div class="sticky-top" style="top: 20px;">
                    <div class="card border shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0 text-white">💰 Fare Summary</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush mb-3">
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>Base Rate</span>
                                    <strong id="base-rate">₹0.00</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>Taxes & Fees</span>
                                    <strong id="tax-amount">₹0.00</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-light-success p-2 rounded mt-2">
                                    <span class="fw-bold text-dark">Total Amount</span>
                                    <strong id="total-amount" class="text-success fs-4">₹0.00</strong>
                                </li>
                            </ul>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="terms-agree" checked>
                                <label class="form-check-label small" for="terms-agree">
                                    By proceeding, I agree to the Cancellation Policy and Booking Terms.
                                </label>
                            </div>

                            <div class="row g-2">
                                <div class="col-6">
                                    <button id="final-pay-btn" class="btn btn-primary w-100">
                                        <i class="ti ti-lock me-1"></i> Pay Now
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button onclick="window.history.back()" class="btn btn-outline-secondary w-100">
                                        <i class="ti ti-arrow-left me-1"></i> Back
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-secondary mt-3 mb-0" role="alert">
                        <small class="text-center">
                            <i class="ti ti-shield-check me-1 text-success"></i> 
                          Safe & secure checkout for your payments.
                        </small>
                    </div>

                    <!-- Countdown Timer -->
                    <div class="card mt-3 border-danger bg-light-danger shadow-sm">
                        <div class="card-body py-2 px-3 text-center">
                            <p class="text-danger mb-0 small fw-bold">
                                <i class="ti ti-clock me-1 animate-pulse"></i> 
                                Your Booking Session will Expire in <span id="countdown-timer" class="fs-6">--:--</span> min. You must complete the booking within the time.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('script')
<script src="{{ asset('') }}js/hotel.js"></script>
<script>
$(document).ready(function() {
    // Initialize Countdown
    if (typeof updateCountdown === 'function') {
        updateCountdown();
        setInterval(updateCountdown, 1000);
    }
    // Collect data from storage
    const recomdet = JSON.parse(sessionStorage.getItem('recomdet'));
    const alHotelData = JSON.parse(sessionStorage.getItem('allHotelData'));
    const sentReqest = JSON.parse(localStorage.getItem('sentReqest'));
    const passengers = JSON.parse(localStorage.getItem('psgr'));
    const netAmt = sessionStorage.getItem('amt');
    const hotelKy = sessionStorage.getItem('hkey');

    if (!recomdet || !passengers) {
        swal({
            title: 'Session Error',
            text: 'Your booking information is missing. Please search again.',
            type: 'error'
        }).then(() => {
            window.location.href = "{{ route('hotel.view') }}";
        });
        return;
    }

    // Populate Hotel Info
    $('#hotel-name').text(alHotelData?.Name || 'Hotel Name');
    $('#hotel-img').attr('src', alHotelData?.HotelPicture || 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400');
    
    // Rating
    let stars = '';
    for (let i = 0; i < (alHotelData?.StarRating || 0); i++) {
        stars += '<i class="fas fa-star"></i> ';
    }
    $('#hotel-rating').html(stars);

    // Dates & Stay
    const searchData = sentReqest?.[0];
    $('#checkin-date').text(searchData?.chkInDate || '--');
    $('#checkout-date').text(searchData?.chkOutDate || '--');
    $('#stay-details').text(`${searchData?.roomCount || 1} Room(s), ${ (searchData?.adultCount || 0) + (searchData?.childCount || 0) } Guest(s)`);

    // Refundable logic
    if (alHotelData?.IsRefundable) {
        $('#refundable-badge').text('Refundable').addClass('bg-success').removeClass('bg-danger');
    } else {
        $('#refundable-badge').text('Non-Refundable').addClass('bg-danger').removeClass('bg-success');
    }

    // Guest List
    let guestHtml = '';
    passengers.forEach((p, index) => {
        guestHtml += `
            <tr>
                <td>${index + 1}</td>
                <td class="fw-bold">${p.Title} ${p.FirstName} ${p.LastName} ${index === 0 ? '<span class="badge bg-label-primary px-1 ms-1">Lead</span>' : ''}</td>
                <td><span class="badge bg-label-info">${p.PaxType || 'Adult'}</span></td>
                <td class="small">
                    ${p.Age ? 'Age: ' + p.Age : ''}
                    ${p.PassportNo ? ' | Passport: ' + p.PassportNo : ''}
                    ${p.PAN ? ' | PAN: ' + p.PAN : ''}
                </td>
            </tr>
        `;
    });
    $('#guest-list-body').html(guestHtml);

    // Contact
    $('#contact-email').text(passengers[0]?.Email || '--');
    $('#contact-mobile').text(passengers[0]?.Phoneno || '--');

    // Fare Summary
    $('#base-rate').text('₹' + (recomdet?.PriceBreakUp?.[0]?.RoomRate || 0).toFixed(2));
    $('#tax-amount').text('₹' + (recomdet?.NetTax || 0).toFixed(2));
    $('#total-amount').text('₹' + parseFloat(netAmt).toFixed(2));

    // Handle Payment Button
    $('#final-pay-btn').on('click', function() {
        if (!$('#terms-agree').is(':checked')) {
            swal('Agreement Required', 'Please agree to the terms and cancellation policy to proceed.', 'warning');
            return;
        }

        swal({
            title: "Confirm Booking",
            text: "Are you sure you want to proceed to payment?",
            type: "question",
            showCancelButton: true,
            confirmButtonText: "Yes, Pay Now",
            cancelButtonText: "Review Again"
        }).then((result) => {
            if (result.isConfirmed || result.value) {
                // Same logic as submitGuestDetails success state
                swal({
                    title: "Processing...",
                    text: "Redirecting to secure payment gateway.",
                    type: "warning",
                    showConfirmButton: false,
                    allowOutsideClick: false
                });

                const finalPayload = {
                    netAmt: parseFloat(netAmt).toFixed(2),
                    hotelKy: hotelKy,
                    BookingId: recomdet?.BookingCode,
                    HotelPassenger: passengers,
                    payment_mode: 'pg',
                    HotelName: alHotelData?.Name || recomdet?.HotelName,
                    CheckInDate: sentReqest[0]?.chkInDate,
                    CheckOutDate: sentReqest[0]?.chkOutDate,
                    Address: alHotelData?.Address,
                    TotalRooms: sentReqest[0]?.roomCount,
                    base_fare: (recomdet?.PriceBreakUp?.[0]?.RoomRate || 0).toFixed(2),
                    tax: (recomdet?.NetTax || 0).toFixed(2),
                    is_refundable: alHotelData?.IsRefundable ? 'true' : 'false',
                    voucher_status: 'Pending'
                };


                $.ajax({
                    url: "/hotel/booking",
                    method: "POST",
                    contentType: "application/json",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    data: JSON.stringify(finalPayload),
                    success: function (response) {
                        if (response.url) {
                            window.location.href = response.url;
                            return;
                        }

                        swal.close();
                        let bookingStatus = response?.data?.Status;
                        if (response.status == "success" && (bookingStatus == 1 || bookingStatus == "1")) {
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
                                        <p>Lead Guest:<span class="fs-4"> ${passengers[0]?.Title} ${passengers[0]?.FirstName} ${passengers[0]?.LastName}</span></p>
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
                            swal("Price changed", "Please verify before booking again.", "warning");
                        } else if (bookingStatus == 6) {
                            swal("Cancelled", "Booking has been cancelled.", "error");
                        } else if (bookingStatus == 0) {
                            swal("Failed", "Booking failed. Please try again.", "error");
                        } else {
                            swal('Error', response.message || 'Booking failed.', 'error').then(() => {
                                window.location.href = "/hotel/view";
                            });
                        }
                    },
                    error: function () {
                        swal.close();
                        swal('Error', 'Something went wrong during payment initiation.', 'error');
                    }
                });

            }
        });
    });
});
</script>
@endpush
