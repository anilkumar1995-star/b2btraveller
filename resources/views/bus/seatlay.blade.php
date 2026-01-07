@extends('layouts.app')
@section('title', 'Seat Layout Details')
@section('pagetitle', 'Seat Layout Details')

@section('content')
    <div class="preloader text-center">
        <div class="preloader-item">
            <div class="spinner-grow text-primary"></div>
        </div>
    </div>

    <div class="pb-4 d-none" id="seatLayoutContainer">
        <div class="card shadow-sm mb-3">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5 class="mb-0">🪑 Please carefully select your seat & boarding point before proceeding</h5>
                <button class="btn btn-primary" disabled id="proceedBookingBtn">
                    Proceed to Booking
                </button>
            </div>
        </div>

        <div id="boardingpassdetails" class="card mb-3"></div>

        <div id="seatlayoutdetails"></div>

    </div>

    <style>
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
            background: #4dc243;
            border-color: #4dc243;
            color: #fff;
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
    <script src="{{ asset('') }}js/bustrip.js"></script>
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
                getSeatDetails(resultIndex, traceId);
                getboradingDetails(resultIndex, traceId);
            } else {
                window.location.href = "/bus/view";
            }

        });
    </script>
@endpush
