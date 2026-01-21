@extends('layouts.app')
@section('title', 'Seat Layout Details')
@section('pagetitle', 'Seat Layout Details')

@section('content')
    <style>
        .swal2-container {
            z-index: 20000 !important;
        }
    </style>
    <div class="preloader text-center">
        <div class="preloader-item">
            <div class="spinner-grow text-primary"></div>
        </div>
    </div>

    <div class="pb-4 d-none" id="seatLayoutContainer">


        <div id="boardingpassdetails" class="card mb-3"></div>

        <div id="seatlayoutdetails"></div>

        <div class="card shadow-sm mt-3">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5 class="mb-0">🪑 Please carefully select your seat & boarding point before proceeding</h5>
                <button class="btn btn-primary" disabled id="proceedBookingBtn">
                    Proceed to Add Details
                </button>
            </div>
        </div>
    </div>

    {{-- Offcanvas --}}

    <div class="offcanvas offcanvas-end w-50" tabindex="-1" id="passengerOffcanvas" style="overflow-y:scroll"
        aria-labelledby="passengerOffcanvasLabel">
        <div class="offcanvas-content">
            <div class="offcanvas-header bg-primary">
                <h5 id="passengerOffcanvasLabel" class="text-white mb-0">Passneger Details</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <form id="passengerForm">
                <div class="offcanvas-body pb-0">

                    <div class="card card-body border mb-3">
                        <div class="bg-light bg-opacity-10 rounded-2 p-3">
                            <p class="h6 fw-light small mb-0">
                                <span class="badge bg-danger me-2">Note</span>
                                Please make sure you enter the name as per your passport.
                            </p>
                        </div>
                        <h5 class="mt-4">Booking details will be sent to</h5>
                        <div class="row g-3 g-md-4">
                            <div class="col-md-3">
                                <label class="form-label">Cell Code<span class="text-danger">*</span></label>
                                <select class="form-select required-field" name="cellcode">
                                    <option value="">Select</option>
                                    <option value="+91" selected>+91</option>
                                    <option value="+1">+1</option>
                                    <option value="+44">+44</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Mobile Number<span class="text-danger">*</span></label>
                                <input type="text" class="form-control required-contact contact-phone"
                                    placeholder="Enter your mobile number">
                            </div>

                            <div class="col-md-5">
                                <label class="form-label">Email Address<span class="text-danger">*</span></label>
                                <input type="email" class="form-control required-contact contact-email"
                                    placeholder="Enter your email address">
                            </div>
                        </div>


                    </div>

                    <div id="passengerOffcanvasBody"></div>

                </div>
                <div class="offcanas-footer px-4 pb-2 d-grid">
                    <button id="confirmPassengers" type="button" disabled="true" class="btn btn-primary mb-0">
                        Proceed To Bus Block
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .is-invalid {
            border-color: #dc3545 !important;
        }

        /* ================= LEGEND ================= */
        .legend-panel {
            width: 100%;
            padding: 15px;
        }

        .legend-title {
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 12px;
            color: #333;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            font-size: 12px;
            color: #666;
        }

        .legend-box {
            width: 32px;
            height: 20px;
            border-radius: 3px;
            border: 1.5px solid;
            flex-shrink: 0;
        }

        .legend-box.booked-seat {
            background: #e63535;
            border-color: #e63535;
        }

        .legend-box.ladies-seat {
            background: #e454c0;
            border-color: #e454c0;
        }

        .legend-box.male-seat {
            background: #e2e454;
            border-color: #e2e454;
        }

        .legend-box.sleeper {
            width: 48px;
        }

        .legend-box.available-sleeper {
            background: #64b5f6;
            border-color: #64b5f6;
        }

        .legend-box.selected-sleeper {
            background: #4dc243;
            border-color: #4dc243;
        }

        .legend-divider {
            border: none;
            border-top: 1px solid #e0e0e0;
            margin: 15px 0;
        }

        /* ================= BUS LAYOUT ================= */
        .bus {
            position: relative;
        }

        .driver-right {
            position: absolute;
            right: 5px;
            top: 40px;
            font-size: 26px;
        }

        .deck-title {
            font-weight: 600;
            margin-bottom: 10px;
        }

        /* ================= ROW ================= */
        .bus-row {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 12px;
        }

        /* aisle gap */
        .bus-row .seat:nth-child(3) {
            margin-left: 25px;
        }

        /* ================= SEAT ================= */
        .seat {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            border: 1.5px solid #0d6efd;
            background: #e7f1ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            position: relative;
            transition: 0.2s;
        }

        /* Hover */
        .seat:hover {
            transform: scale(1.05);
        }

        /* Sleeper */
        .seat.sleeper {
            width: 50px;
            height: 90px;
        }

        /* Booked */
        .seat.booked {
            background: #f7a0a0;
            border-color: #e63535;
            cursor: not-allowed;
            opacity: 0.7;
        }

        /* Selected */
        .seat.selected {
            background: #4dc243 !important;
            border-color: #4dc243 !important;
            color: #fff !important;
        }

        /* Ladies */
        .seat.ladies {
            background: #fde2f0;
            border-color: #d63384;
        }

        /* Male */
        .seat.male {
            background: #e4e69e;
            border-color: #e2e454;
        }

        /* ================= ICON ================= */
        .icon {
            font-size: 16px;
        }

        /* ================= TOOLTIP ================= */
        .seat[data-tooltip]:hover::before {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 120%;
            left: 50%;
            transform: translateX(-50%);
            background: #333;
            color: #fff;
            font-size: 11px;
            padding: 6px 8px;
            border-radius: 4px;
            white-space: nowrap;
            z-index: 10;
        }

        .seat[data-tooltip]:hover::after {
            content: '';
            position: absolute;
            bottom: 110%;
            left: 50%;
            transform: translateX(-50%);
            border: 5px solid transparent;
            border-top-color: #333;
            z-index: 10;
        }
    </style>

@endsection

@push('script')
    <script src="{{ asset('') }}js/busbook.js"></script>
    <script>
        $(document).ready(function() {

            $('#seatLayoutContainer').addClass('d-none');
            $('.preloader').removeClass('d-none');

            const payload = JSON.parse(localStorage.getItem('payload'));
            const resultIndex = localStorage.getItem('BusResultIndex');
            const traceId = localStorage.getItem('TraceId');

            if (!payload || !resultIndex || !traceId) {
                swal({
                    title: "Data Missing",
                    html: "Your booking session missing some info, <br/> Please try again",
                    type: "error",
                    confirmButtonText: "Search Bus Again",
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then(() => {
                    window.location.href = "/bus/view";
                });
                return;
            }

            if (resultIndex) {
                getboradingDetails(resultIndex, traceId);
                getSeatDetails(resultIndex, traceId);
            } else {
                window.location.href = "/bus/view";
            }

        });
    </script>
@endpush
