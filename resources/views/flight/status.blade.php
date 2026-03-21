@extends('layouts.app')

@section('title', 'Payment Status | Flight Booking')

@section('content')
<div class="status-page-wrapper">
    <div class="container py-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Status Card -->
                <div class="card status-card {{ $status == 'success' ? 'pending' : 'failed' }} animate__animated animate__zoomIn" id="statusCard">
                    <div class="card-body text-center p-md-5 p-4">
                        
                        <!-- Icon Circle -->
                        <div class="status-icon-container mb-4 mx-auto" id="statusIcon">
                            @if($status == 'success')
                                <div class="icon-circle bg-warning shadow-warning pulse">
                                    <i class="ti ti-loader display-3 text-white spin-icon"></i>
                                </div>
                            @else
                                <div class="icon-circle bg-danger shadow-danger">
                                    <i class="ti ti-x display-3 text-white"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Status Text -->
                        <div class="status-text animate__animated animate__fadeInUp animate__delay-1s" id="statusContent">
                            @if($status == 'success')
                                <h1 class="fw-extra-bold mb-3 text-dark">Processing Flight Booking...</h1>
                                <p class="lead text-muted px-md-4">
                                    Your payment is successful! We are now confirming your flight ticket with the airline. This may take a moment.
                                </p>
                                <div class="timer-wrapper my-4">
                                    <div class="h3 fw-bold text-primary" id="timer">01:00</div>
                                    <div class="progress mt-2" style="height: 6px;">
                                        <div id="timerBar" class="progress-bar progress-bar-animated bg-primary" role="progressbar" style="width: 100%"></div>
                                    </div>
                                </div>
                            @else
                                <h1 class="fw-extra-bold mb-3 text-dark">Payment Failed</h1>
                                <p class="lead text-muted px-md-4">
                                    Oops! We couldn't process your payment. Don't worry, if any money was deducted, it will be refunded automatically. Please try again.
                                </p>
                            @endif
                        </div>

                        <!-- Divider -->
                        <div class="hr-divider my-4"></div>

                        <!-- Action Buttons -->
                        <div class="action-buttons d-flex flex-column flex-md-row justify-content-center gap-3 animate__animated animate__fadeInUp animate__delay-2s" id="actionButtons">
                            @if($status != 'success')
                                <a href="{{ route('flight.bookingList') }}" class="btn btn-primary btn-cta shadow-sm">
                                    <i class="ti ti-file-text me-2"></i>My Bookings
                                </a>
                                <a href="{{ route('flight.view') }}" class="btn btn-light btn-cta border">
                                    <i class="ti ti-plane me-2"></i>New Search
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Support Footer -->
                <div class="text-center mt-4 animate__animated animate__fadeInUp animate__delay-3s">
                    <p class="text-muted small">
                        Need help? <a href="#" class="text-primary fw-bold text-decoration-none">Contact Support</a> or call us at <strong>+91 123 456 7890</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="order_ref_id" value="{{ $id ?? '' }}">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        @if($status == 'success' && isset($id))
            let timeLeft = 60;
            let timerElement = $('#timer');
            let timerBar = $('#timerBar');
            let orderRefId = $('#order_ref_id').val();
            let pollingInterval;

            // Start Timer
            let timerInterval = setInterval(function() {
                timeLeft--;
                let minutes = Math.floor(timeLeft / 60);
                let seconds = timeLeft % 60;
                timerElement.text(`${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`);
                
                let percentage = (timeLeft / 60) * 100;
                timerBar.css('width', percentage + '%');

                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    clearInterval(pollingInterval);
                    handleTimeout();
                }
            }, 1000);

            // Start Polling every 10 seconds
            pollingInterval = setInterval(function() {
                checkBookingStatus();
            }, 10000);

            // Initial check
            checkBookingStatus();

            function checkBookingStatus() {
                $.ajax({
                    url: "{{ route('flight.checkStatus') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: orderRefId
                    },
                    success: function(response) {
                        if (response.status === 'success' && response.booking_status === 'Confirmed') {
                            clearInterval(timerInterval);
                            clearInterval(pollingInterval);
                            handleSuccess(response.data);
                        } else if (response.booking_status === 'failed') {
                            clearInterval(timerInterval);
                            clearInterval(pollingInterval);
                            handleFailure(response.message || 'Flight booking failed.');
                        }
                    }
                });
            }

            function handleSuccess(data) {
                $('#statusCard').removeClass('pending').addClass('success').css('border-top', '6px solid #10b981');
                $('#statusIcon').html(`
                    <div class="icon-circle bg-success shadow-success pulse">
                        <i class="ti ti-check display-3 text-white"></i>
                    </div>
                `);
                $('#statusContent').html(`
                    <h1 class="fw-extra-bold mb-3 text-dark">Booking Confirmed! 🎉</h1>
                    <p class="lead text-muted px-md-4">
                        Great news! Your flight ticket has been confirmed successfully.<br>
                        <strong>PNR:</strong> ${data.pnr || 'N/A'}<br>
                        <strong>Booking Id:</strong> ${data.booking_id || 'N/A'}
                    </p>
                `);
                $('#actionButtons').html(`
                    <a href="{{ route('flight.bookingList') }}" class="btn btn-primary btn-cta shadow-sm">
                        <i class="ti ti-file-text me-2"></i>My Bookings
                    </a>
                    <a href="{{ route('flight.view') }}" class="btn btn-light btn-cta border">
                        <i class="ti ti-plane me-2"></i>New Search
                    </a>
                `);
            }

            function handleFailure(message) {
                $('#statusCard').removeClass('pending').addClass('failed').css('border-top', '6px solid #ef4444');
                $('#statusIcon').html(`
                    <div class="icon-circle bg-danger shadow-danger">
                        <i class="ti ti-x display-3 text-white"></i>
                    </div>
                `);
                $('#statusContent').html(`
                    <h1 class="fw-extra-bold mb-3 text-dark">Booking Failed</h1>
                    <p class="lead text-muted px-md-4">
                        ${message}<br>Any amount deducted will be refunded as per policy.
                    </p>
                `);
                $('#actionButtons').html(`
                    <a href="{{ route('flight.bookingList') }}" class="btn btn-primary btn-cta shadow-sm">
                        <i class="ti ti-file-text me-2"></i>View List
                    </a>
                    <a href="{{ route('flight.view') }}" class="btn btn-light btn-cta border">
                        <i class="ti ti-plane me-2"></i>Try Again
                    </a>
                `);
            }

            function handleTimeout() {
                $('#statusContent').html(`
                    <h1 class="fw-extra-bold mb-3 text-dark">Taking Longer Than Usual</h1>
                    <p class="lead text-muted px-md-4">
                        We are still waiting for confirmation from the airline. Please check your "My Bookings" list after a few minutes.
                    </p>
                `);
                $('#actionButtons').html(`
                    <a href="{{ route('flight.bookingList') }}" class="btn btn-primary btn-cta shadow-sm">
                        <i class="ti ti-file-text me-2"></i>My Bookings
                    </a>
                `);
                setTimeout(() => {
                    window.location.href = "{{ route('flight.bookingList') }}";
                }, 5000);
            }
        @endif
    });
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap');

    .status-page-wrapper {
        font-family: 'Outfit', sans-serif;
        background-color: #f8faff;
        min-height: calc(100vh - 100px);
    }

    .status-card {
        border: none;
        border-radius: 2rem;
        background: #ffffff;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .status-card:hover {
        transform: translateY(-5px);
    }

    /* Top Accent Line */
    .status-card.success { border-top: 6px solid #10b981; }
    .status-card.failed { border-top: 6px solid #ef4444; }
    .status-card.pending { border-top: 6px solid #f59e0b; }

    .status-icon-container {
        width: 120px;
        height: 120px;
        position: relative;
    }

    .icon-circle {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 2;
    }

    .bg-success { background: linear-gradient(135deg, #10b981, #059669) !important; }
    .bg-danger { background: linear-gradient(135deg, #ef4444, #dc2626) !important; }
    .bg-warning { background: linear-gradient(135deg, #f59e0b, #d97706) !important; }

    .shadow-success { box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3); }
    .shadow-danger { box-shadow: 0 15px 30px rgba(239, 68, 68, 0.3); }
    .shadow-warning { box-shadow: 0 15px 30px rgba(245, 158, 11, 0.3); }

    /* Pulse Animation */
    @keyframes pulse {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.4); }
        70% { transform: scale(1.05); box-shadow: 0 0 0 20px rgba(245, 158, 11, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
    }

    .pulse {
        animation: pulse 2s infinite;
    }

    .spin-icon {
        animation: fa-spin 2s linear infinite;
    }
    @keyframes fa-spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .fw-extra-bold {
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    .hr-divider {
        height: 1px;
        background: linear-gradient(to right, transparent, #e2e8f0, transparent);
    }

    .btn-cta {
        padding: 0.8rem 2rem;
        border-radius: 1rem;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn-primary:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(var(--bs-primary-rgb), 0.2) !important;
    }

    .btn-light:hover {
        background-color: #f1f5f9;
        transform: scale(1.05);
    }

    .lead {
        font-size: 1.1rem;
        line-height: 1.6;
    }

    @media (max-width: 576px) {
        .icon-circle {
            width: 100px;
            height: 100px;
        }
    }
</style>

<!-- Add Animate.css for entrance animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@endsection
