
<?php $__env->startSection('title', 'Seat Layout Details'); ?>
<?php $__env->startSection('pagetitle', 'Seat Layout Details'); ?>

<?php $__env->startSection('content'); ?>
    <div class="preloader text-center">
        <div class="preloader-item">
            <div class="spinner-grow text-primary"></div>
        </div>
    </div>

    <div class="pb-4 d-none" id="seatLayoutContainer">
        <div class="card shadow-sm mb-3">
            <div class="card-body d-flex justify-content-between align-items-center">
                <p class="mb-0 text-secondary" style="font-size: 15px;">
                    📢 Note: <b class="text-warning">You may proceed with the booking without selecting any optional SSR
                        (Seat, Baggage, Meal) services.</b>
                </p>

                <button class="btn btn-primary" id="proceedBookingBtn">
                    Proceed to Booking
                </button>
            </div>
        </div>
        
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center flex-wrap">
                <div class="d-flex align-items-center">
                    <i class="fa fa-plane me-2"></i>
                    <h5 class="mb-0 text-white">Seat Selection</h5>
                </div>
                <div class="d-flex flex-wrap text-end">
                    <div class="me-3">
                        <small>Total Seat:</small> <span id="totalSeatPrice" class="fw-bold">₹0</span>
                    </div>
                </div>
            </div>

            <div class="card-body" style="overflow: auto">
                <div class="mt-3">

                    <div class="text-center">
                        <div class="legend d-inline-block">
                            <span class="legend-item"><span class="seat " style="background:#007bff">🔵</span>
                                Selected</span>
                            <span class="legend-item ms-3"><span class="seat " style="background:#4caf50">🟢</span>
                                Available</span>
                            <span class="legend-item ms-3"><span class="seat " style="background:#ff9800">🟡</span>
                                Reserved</span>
                            <span class="legend-item ms-3"><span class="seat" style="background:#f44336">🔴</span>
                                Blocked</span>
                            <span class="legend-item ms-3"><span class="seat " style="background:transparent">⚪</span>
                                NoSeatAtThisLocation</span>
                            <span class="legend-item ms-3"><span class="seat" style="background:#9e9e9e">⚪</span> Not
                                Set</span>
                        </div>
                    </div>
                </div>

                <!-- Nose Section -->
                <div id="mainPlaneWrapper"></div>
            </div>
        </div>

        
        <div class="card mb-5 shadow-sm">

            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center flex-wrap">
                <div class="d-flex align-items-center">
                    <i class="fa fa-plane me-2"></i>
                    <h5 class="mb-0 text-white" id="mealSectionHead">Meal Selection</h5>
                </div>
                <div class="d-flex flex-wrap text-end">

                    <div class="me-3">
                        <small>Total Meal:</small> <span id="totalMealPrice" class="fw-bold">₹0</span>
                    </div>

                </div>
            </div>
            <div class="card-body" id="mealContainer">

            </div>
        </div>


        
        <div class="card shadow-sm">

            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center flex-wrap">
                <div class="d-flex align-items-center">
                    <i class="fa fa-plane me-2"></i>
                    <h5 class="mb-0 text-white" id="baggageSectionHead">Baggage Selection</h5>
                </div>
                <div class="d-flex flex-wrap text-end">
                    <div>
                        <small>Total Baggage:</small> <span id="totalBaggagePrice" class="fw-bold">₹0</span>
                    </div>
                </div>
            </div>
            <div class="card-body" id="baggageContainer"></div>
        </div>

        
        
    </div>

    
    <style>
        .plane-container {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding: 40px;
            width: max-content;
            background: #ffffff;
            border-radius: 170px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin: 40px auto;
        }

        .section {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0 15px;
            text-align: center;
        }

        .seat-column {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            margin: 4px 0;
        }

        .seat {
            width: 28px;
            height: 28px;
            border: 1.5px solid #b5dcff;
            border-radius: 6px;
            text-align: center;
            font-size: 10px;
            color: #fff;
            line-height: 26px;
            margin: 2px;
            cursor: pointer;
        }

        .seat:hover {
            background: #e8f4ff;
        }

        .seat.unavailable {
            background: #ffcccc;
            border-color: #ff6666;
            color: #fff;
            cursor: not-allowed;
        }

        .seat.selected {
            background: #007bff;
            color: #fff;
        }

        .exit {
            background: #fff3cd;
            border: 1.5px solid #ffe58f;
            border-radius: 6px;
            padding: 2px 8px;
            font-size: 12px;
            font-weight: 600;
            margin: 6px 0;
        }

        .lavatory {
            background: #f1f1f1;
            border: 1.5px dashed #ccc;
            border-radius: 10px;
            padding: 10px;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: #666;
            margin: 8px 0;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    
    <script src="<?php echo e(asset('')); ?>js/flighttrip.js"></script>
    <script>
        $(document).ready(function() {

            $('#seatLayoutContainer').addClass('d-none');
            $('.preloader').removeClass('d-none');
            // Local Storage Clear ITEM
            localStorage.removeItem('selectedSeat');
            localStorage.removeItem('selectedmeal');
            localStorage.removeItem('selectedBaggage');

            const payload = JSON.parse(localStorage.getItem('payload'));
            const travelerDet = JSON.parse(localStorage.getItem('travelerDetails'));

            if (travelerDet) {
                if (payload.JourneyType == 1) {
                    const resultIndex = localStorage.getItem('ResultIndex');
                    const traceId = localStorage.getItem('TraceId');
                    if (resultIndex && traceId) {
                        getSSRDetails(resultIndex, traceId, 'departure');

                    } else {
                        console.log('No SSR details found in localStorage.');
                    }
                } else if (payload.JourneyType == 2) {
                    // notify('We will working on roundtrip ssr api integration', 'error');
                    // return;
                    const depresultIndex = localStorage.getItem('DepartureResultIndex');
                    const rettresultIndex = localStorage.getItem('ReturnResultIndex');
                    const traceId = localStorage.getItem('TraceId');

                    if (depresultIndex && rettresultIndex && traceId) {
                        getSSRDetails(depresultIndex, traceId, 'departure');
                        getSSRDetails(rettresultIndex, traceId, 'return');
                    } else {
                        console.log('No SSR details found in localStorage.');
                    }
                }
            } else {
                window.location.href = "/flight/detail";
            }

        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\flight_b2b_travel\flight_b2b_travel\resources\views/flight/seatlay.blade.php ENDPATH**/ ?>