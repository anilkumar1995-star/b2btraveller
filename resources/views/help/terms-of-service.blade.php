
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms of Service | iPayment Tech Private Limited</title>
    
    <!-- Google Fonts: Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #2563eb 100%);
            --accent-color: #f59e0b;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --bg-light: #f8fafc;
            --indigo-green: #00a859;
        }

        body {
            font-family: 'Outfit', sans-serif;
            color: var(--text-main);
            background-color: var(--bg-light);
            overflow-x: hidden;
            line-height: 1.7;
        }

        .hero-section {
            background: var(--primary-gradient);
            padding: 80px 0 120px;
            color: white;
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .content-card {
            background: white;
            border-radius: 24px;
            border: none;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            padding: 4rem 3rem;
            margin-top: -80px;
            margin-bottom: 80px;
            position: relative;
            z-index: 10;
        }

        .text-green {
            color: var(--indigo-green);
        }

        /* Tabs Styling - Indigo Style */
        .nav-pills-custom {
            background: #f1f5f9;
            padding: 6px;
            border-radius: 50px;
            display: inline-flex;
            margin-bottom: 3rem;
            flex-wrap: wrap;
        }

        .nav-pills-custom .nav-link {
            color: var(--text-main);
            background: transparent;
            border-radius: 50px;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
        }

        .nav-pills-custom .nav-link.active {
            background: white;
            color: #2563eb;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        /* Accordion Styling */
        .accordion-item {
            border: none;
            margin-bottom: 15px;
            border-radius: 15px !important;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .accordion-button {
            padding: 1.5rem;
            font-weight: 600;
            color: var(--text-main);
            background: white;
            box-shadow: none !important;
        }

        .accordion-button:not(.collapsed) {
            color: #2563eb;
            background: #f8fafc;
        }

        .policy-intro {
            background: #f8fafc;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-left: 4px solid #2563eb;
        }

        .bullet-list {
            padding-left: 1.2rem;
            list-style-type: none;
        }

        .bullet-list li {
            position: relative;
            margin-bottom: 10px;
        }

        .bullet-list li::before {
            content: "•";
            color: var(--indigo-green);
            font-weight: bold;
            display: inline-block;
            width: 1em;
            margin-left: -1em;
        }
    </style>
</head>
<body>

<main>

    <!-- ================= HERO ================= -->
    <section class="hero-section">
        <div class="container">
            <h1 class="display-4 fw-bold">Terms of <span class="text-green">Service</span></h1>
            <p class="lead opacity-90">Your agreement with iPayment Tech Private Limited.</p>
        </div>
    </section>

    <!-- ================= CONTENT ================= -->
    <section class="container">
        <div class="content-card">
            
            <!-- Tabs Navigation -->
            <ul class="nav nav-pills nav-pills-custom mb-5" id="termsTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="general-tab" data-bs-toggle="pill" data-bs-target="#general-content" type="button" role="tab">General Agreement</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="flight-tab" data-bs-toggle="pill" data-bs-target="#flight-content" type="button" role="tab">Flights</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="hotel-tab" data-bs-toggle="pill" data-bs-target="#hotel-content" type="button" role="tab">Hotels</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="bus-tab" data-bs-toggle="pill" data-bs-target="#bus-content" type="button" role="tab">Buses</button>
                </li>
            </ul>

            <div class="tab-content" id="termsTabsContent">
                
                <!-- GENERAL AGREEMENT PANEL -->
                <div class="tab-pane fade show active" id="general-content" role="tabpanel">
                    <h3 class="fw-bold mb-4">Introduction & Acceptance</h3>
                    <div class="policy-intro">
                        <p class="mb-0">This agreement governs your use of the <strong>iPayment Tech</strong> portal (www.ipayments.in) and all services provided under the iPayment Tech Private Limited brand. By accessing our services, you agree to comply with these terms.</p>
                    </div>

                    <div class="accordion" id="generalAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#genOne">
                                    1. Role of iPayment Tech
                                </button>
                            </h2>
                            <div id="genOne" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <p>iPayment Tech acts strictly as a <strong>facilitator</strong> or an aggregator. We connect users with third-party service providers such as:</p>
                                    <ul class="bullet-list">
                                        <li>Airlines for flight bookings.</li>
                                        <li>Hotels for accommodation services.</li>
                                        <li>Bus operators for road transit services.</li>
                                        <li>Banks and financial institutions for digital transactions.</li>
                                    </ul>
                                    <p>We are not the end service provider and do not own or operate any aircraft, hotel, or bus fleet.</p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#genTwo">
                                    2. Eligibility & User Responsibilities
                                </button>
                            </h2>
                            <div id="genTwo" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <ul class="bullet-list">
                                        <li>Users must be at least 18 years of age to book services.</li>
                                        <li>Users are responsible for the accuracy of passenger names, contact details, and ID proof provided during booking.</li>
                                        <li>Any discrepancies in provided data resulting in booking failure or rejection by the carrier are the user's liability.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#genThree">
                                    3. Fees and Payments
                                </button>
                            </h2>
                            <div id="genThree" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <ul class="bullet-list">
                                        <li>iPayment Tech charges a nominal convenience/service fee for processing bookings.</li>
                                        <li>This service fee is <strong>non-refundable</strong> once a booking is confirmed.</li>
                                        <li>Total fare includes base price, taxes, and service fees.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FLIGHTS PANEL -->
                <div class="tab-pane fade" id="flight-content" role="tabpanel">
                    <h3 class="fw-bold mb-4">Terms for <span class="text-green">Flight Bookings</span></h3>
                    <div class="accordion" id="flightAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flightOne">
                                    Airline Policies
                                </button>
                            </h2>
                            <div id="flightOne" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <p>Your flight booking is governed by the specific terms of the operating airline:</p>
                                    <ul class="bullet-list">
                                        <li><strong>Check-in:</strong> Passengers must report at the airport within the timeframe specified by the airline (usually 2-3 hours for domestic).</li>
                                        <li><strong>Baggage:</strong> Free baggage allowance is determined by the airline fare class. Any excess baggage is payable directly to the airline.</li>
                                        <li><strong>Schedule Changes:</strong> iPayment Tech is not liable for flight delays, cancellations, or reschedules initiated by the airline.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flightTwo">
                                    Code Share Flights
                                </button>
                            </h2>
                            <div id="flightTwo" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <p>Some flights booked through the portal may be operated by partner airlines under "Code Share" agreements. The operating carrier details will be clearly shown before payment.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- HOTELS PANEL -->
                <div class="tab-pane fade" id="hotel-content" role="tabpanel">
                    <h3 class="fw-bold mb-4">Terms for <span class="text-green">Hotel Reservations</span></h3>
                    <div class="accordion" id="hotelAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#hotelOne">
                                    Hotel Rules & Check-ins
                                </button>
                            </h2>
                            <div id="hotelOne" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <ul class="bullet-list">
                                        <li>Standard check-in time is usually 12:00 PM or 2:00 PM. Early check-in is subject to hotel availability and may incur charges.</li>
                                        <li>Identification (Aadhar/Passport/PAN as per hotel policy) is mandatory for all guests at check-in.</li>
                                        <li>Meals or amenities not included in the booking voucher are payable directly to the hotel.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BUSES PANEL -->
                <div class="tab-pane fade" id="bus-content" role="tabpanel">
                    <h3 class="fw-bold mb-4">Terms for <span class="text-green">Bus Travel</span></h3>
                    <div class="accordion" id="busAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#busOne">
                                    Boarding & Travel
                                </button>
                            </h2>
                            <div id="busOne" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <ul class="bullet-list">
                                        <li>Passengers must arrive at the boarding point at least 15-30 minutes before the scheduled departure.</li>
                                        <li>iPayment Tech is not responsible if a traveler misses the bus due to delay in reaching the boarding point.</li>
                                        <li>The bus operator reserves the right to change seats for operational reasons.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
