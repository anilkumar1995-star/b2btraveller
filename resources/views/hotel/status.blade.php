@extends('layouts.app')

@section('title', 'Payment Status | Hotel Booking')

@section('content')
    <div class="status-page-wrapper">
        <!-- Decorative Background Elements -->
        <div class="bg-decoration">
            <div class="blob blob-1"></div>
            <div class="blob blob-2"></div>
            <div class="blob blob-3"></div>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <!-- Status Card -->
                    <div class="card status-card {{ $status == 'success' ? 'success' : ($status == 'failed' ? 'failed' : 'pending') }} animate__animated animate__zoomIn"
                        id="statusCard">
                        <div class="card-body text-center p-md-4 p-3">

                            <!-- Icon Circle -->
                            <div class="status-icon-container mb-3 mx-auto" id="statusIcon">
                                @if ($status == 'success')
                                    <div class="icon-circle bg-success shadow-success">
                                        <i class="ti ti-check display-3 text-white"></i>
                                    </div>
                                @elseif ($status == 'failed')
                                    <div class="icon-circle bg-danger shadow-danger">
                                        <i class="ti ti-x display-3 text-white"></i>
                                    </div>
                                @else
                                    <div class="icon-circle bg-warning shadow-warning pulse">
                                        <i class="ti ti-loader display-3 text-white spin-icon"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Status Text -->
                            <div class="status-text animate__animated animate__fadeInUp animate__delay-1s" id="statusContent">
                                @if ($status == 'success')
                                    <h1 class="fw-extra-bold mb-2 text-dark fs-3">Booking Confirmed! 🎉</h1>
                                    <p class="lead text-muted px-md-4 mb-3 small">
                                        Great news! Your hotel reservation has been confirmed successfully.<br>
                                        <strong>Hotel:</strong> {{ $booking->hotel_name ?? 'N/A' }}<br>
                                        <strong>Confirmation No:</strong> {{ $booking->ticket_no ?? 'N/A' }}
                                    </p>
                                @elseif ($status == 'failed')
                                    <h1 class="fw-extra-bold mb-2 text-dark fs-3">Booking Failed</h1>
                                    <p class="lead text-muted px-md-4 mb-3 small">
                                        {{ $message ?? 'Oops! We couldn\'t process your reservation. Any deducted amount will be refunded automatically.' }}
                                    </p>
                                @else
                                    <h1 class="fw-extra-bold mb-2 text-dark fs-3">Processing Booking...</h1>
                                    <p class="lead text-muted px-md-4 mb-3 small">
                                        Please wait! We are confirming your hotel reservation.
                                    </p>
                                    <div class="timer-wrapper my-3">
                                        <div class="h4 fw-bold text-primary mb-1" id="timer">01:00</div>
                                        <div class="progress mt-1" style="height: 5px;">
                                            <div id="timerBar" class="progress-bar progress-bar-animated bg-primary"
                                                role="progressbar" style="width: 100%"></div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Divider -->
                            <div class="hr-divider my-3"></div>

                            <!-- Action Buttons -->
                            <div class="action-buttons d-flex flex-column flex-md-row justify-content-center gap-3 animate__animated animate__fadeInUp animate__delay-2s"
                                id="actionButtons">
                                @if ($status != 'pending')
                                    <a href="{{ route('hotel.bookingList') }}" class="btn btn-primary btn-cta shadow-sm">
                                        <i class="ti ti-file-text me-2"></i>My Bookings
                                    </a>
                                    <a href="{{ route('hotel.view') }}" class="btn btn-light btn-cta border">
                                        <i class="ti ti-hotel-service me-2"></i>New Search
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="order_ref_id" value="{{ $id ?? '' }}">

    @push('script')
        <script>
            $(document).ready(function() {
                @if ($status == 'pending')
                    let timeLeft = 60;
                    let timerElement = $('#timer');
                    let timerBar = $('#timerBar');
                    let orderRefId = $('#order_ref_id').val();
                    let pollingInterval;

                    console.log("Status Page Initialized. Order ID:", orderRefId, "Status:", "{{ $status }}");

                    // Start Timer
                    let timerInterval = setInterval(function() {
                        timeLeft--;
                        if (timeLeft <= 0) {
                            clearInterval(timerInterval);
                            clearInterval(pollingInterval);
                            handleTimeout();
                            return;
                        }

                        let minutes = Math.floor(timeLeft / 60);
                        let seconds = timeLeft % 60;
                        timerElement.text(`${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`);

                        let percentage = (timeLeft / 60) * 100;
                        timerBar.css('width', percentage + '%');
                    }, 1000);

                    if (orderRefId && orderRefId !== '') {
                        console.log("Starting polling for Order ID:", orderRefId);
                        pollingInterval = setInterval(function() {
                            checkBookingStatus();
                        }, 10000); 
                        checkBookingStatus(); 
                    } else {
                        console.error("Order ID not found, polling not started.");
                    }

                    function checkBookingStatus() {
                        console.log("Checking status for:", orderRefId);
                        $.ajax({
                            url: "{{ route('hotel.checkStatus') }}",
                            method: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: orderRefId
                            },
                            success: function(response) {
                                console.log("Status Check Response:", response);
                                if (response.status === 'success' && (response.booking_status === 'Confirmed' || response.booking_status === 'Successful')) {
                                    clearInterval(timerInterval);
                                    clearInterval(pollingInterval);
                                    handleSuccess(response.data);
                                } else if (response.status === 'failure' || response.status === 'failed' || response.status === 'FAILURE' || response.booking_status === 'failed') {
                                    clearInterval(timerInterval);
                                    clearInterval(pollingInterval);
                                    let isPaymentFailed = response.data && response.data.payment_status === 'failed';
                                    let title = isPaymentFailed ? 'Payment Failed' : 'Booking Failed';
                                    handleFailure(title, response.message || (response.data && response.data.failedMessage) || 'Hotel booking failed.');
                                } else if (response.status === 'pending' || response.status === 'PENDING' || response.booking_status === 'pending') {
                                    if (response.message) {
                                        $('#statusContent p.lead').text(response.message);
                                    }
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error("Status Check Error:", error);
                            }
                        });
                    }

                    function handleSuccess(data) {
                        $('#statusCard').removeClass('pending').addClass('success').css('border-top', '6px solid #10b981');
                        $('#statusIcon').html(`
                            <div class="icon-circle bg-success shadow-success">
                                <i class="ti ti-check display-3 text-white"></i>
                            </div>
                        `);
                        $('#statusContent').html(`
                            <h1 class="fw-extra-bold mb-2 text-dark fs-3">Booking Confirmed! 🎉</h1>
                            <p class="lead text-muted px-md-4 mb-3 small">
                                Great news! Your hotel reservation has been confirmed successfully.<br>
                                <strong>Hotel:</strong> ${data.hotel_name || 'N/A'}<br>
                                <strong>Confirmation No:</strong> ${data.ticket_no || 'N/A'}
                            </p>
                        `);
                        $('#actionButtons').html(`
                            <a href="{{ route('hotel.bookingList') }}" class="btn btn-primary btn-cta shadow-sm">
                                <i class="ti ti-file-text me-2"></i>My Bookings
                            </a>
                            <a href="{{ route('hotel.view') }}" class="btn btn-light btn-cta border">
                                <i class="ti ti-hotel-service me-2"></i>New Search
                            </a>
                        `).removeClass('d-none');
                    }

                    function handleFailure(title, message) {
                        $('#statusCard').removeClass('pending').addClass('failed').css('border-top', '6px solid #ef4444');
                        $('#statusIcon').html(`
                            <div class="icon-circle bg-danger shadow-danger">
                                <i class="ti ti-x display-3 text-white"></i>
                            </div>
                        `);
                        $('#statusContent').html(`
                            <h1 class="fw-extra-bold mb-2 text-dark fs-3">${title}</h1>
                            <p class="lead text-muted px-md-4 mb-3 small">
                                ${message}<br>
                            </p>
                        `);
                        $('#actionButtons').html(`
                            <a href="{{ route('hotel.bookingList') }}" class="btn btn-primary btn-cta shadow-sm">
                                <i class="ti ti-file-text me-2"></i>View List
                            </a>
                            <a href="{{ route('hotel.view') }}" class="btn btn-light btn-cta border">
                                <i class="ti ti-hotel-service me-2"></i>Try Again
                            </a>
                        `).removeClass('d-none');
                    }

                    function handleTimeout() {
                        $('#statusContent').html(`
                            <h1 class="fw-extra-bold mb-2 text-dark fs-3">Taking Longer Than Usual</h1>
                            <p class="lead text-muted px-md-4 mb-3 small">
                                We are still waiting for confirmation from the hotel provider. Please check your "My Bookings" list after a few minutes.
                            </p>
                        `);
                        $('#actionButtons').html(`
                            <a href="{{ route('hotel.bookingList') }}" class="btn btn-primary btn-cta shadow-sm">
                                <i class="ti ti-file-text me-2"></i>My Bookings
                            </a>
                        `).removeClass('d-none');
                        setTimeout(() => {
                            window.location.href = "{{ route('hotel.bookingList') }}";
                        }, 5000);
                    }
                @endif
            });
        </script>
    @endpush

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap');

        .status-page-wrapper {
            font-family: 'Outfit', sans-serif;
            background-color: #f8faff;
            min-height: calc(100vh - 150px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
            position: relative;
            overflow: hidden;
        }

        .status-card {
            border: none;
            border-radius: 2rem;
            background: #ffffff;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: transform 0.3s ease;
            position: relative;
            z-index: 1;
        }

        .status-card:hover {
            transform: translateY(-5px);
        }

        /* Top Accent Line */
        .status-card.success {
            border-top: 6px solid #10b981;
        }

        .status-card.failed {
            border-top: 6px solid #ef4444;
        }

        .status-card.pending {
            border-top: 6px solid #f59e0b;
        }

        .status-icon-container {
            width: 100px;
            height: 100px;
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

        .bg-success {
            background: linear-gradient(135deg, #10b981, #059669) !important;
        }

        .bg-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626) !important;
        }

        .bg-warning {
            background: linear-gradient(135deg, #f59e0b, #d97706) !important;
        }

        .shadow-success {
            box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
        }

        .shadow-danger {
            box-shadow: 0 15px 30px rgba(239, 68, 68, 0.3);
        }

        .shadow-warning {
            box-shadow: 0 15px 30px rgba(245, 158, 11, 0.3);
        }

        /* Pulse Animation */
        @keyframes pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.4);
            }

            70% {
                transform: scale(1.05);
                box-shadow: 0 0 0 20px rgba(245, 158, 11, 0);
            }

            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(245, 158, 11, 0);
            }
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        .spin-icon {
            animation: fa-spin 2s linear infinite;
        }

        @keyframes fa-spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
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

        /* Decoration Blobs */
        .bg-decoration {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.15;
            animation: float 20s infinite alternate;
        }

        .blob-1 {
            width: 400px;
            height: 400px;
            background: #3b82f6;
            top: -100px;
            right: -100px;
        }

        .blob-2 {
            width: 300px;
            height: 300px;
            background: #8b5cf6;
            bottom: -50px;
            left: -50px;
            animation-delay: -5s;
        }

        .blob-3 {
            width: 250px;
            height: 250px;
            background: #06b6d4;
            top: 40%;
            left: 20%;
            animation-delay: -10s;
        }

        @keyframes float {
            0% {
                transform: translate(0, 0) scale(1);
            }

            100% {
                transform: translate(30px, 50px) scale(1.1);
            }
        }

        @media (max-width: 576px) {
            .icon-circle {
                width: 100px;
                height: 100px;
            }
        }
    </style>

    <!-- Add Animate.css for entrance animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection