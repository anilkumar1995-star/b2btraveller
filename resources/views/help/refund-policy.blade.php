
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund & Cancellation Policy | iPaymnt Tech Private Limited</title>
    
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

        .table-custom {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .table-custom thead {
            background: #f8fafc;
        }
    </style>
</head>
<body>

<main>

    <!-- ================= HERO ================= -->
    <section class="hero-section">
        <div class="container">
            <h1 class="display-4 fw-bold">Refund & <span class="text-green">Cancellation</span></h1>
            <p class="lead opacity-90">Transparent policies for iPaymnt Tech travel and digital services.</p>
        </div>
    </section>

    <!-- ================= CONTENT ================= -->
    <section class="container">
        <div class="content-card">
            
            <!-- Tabs Navigation -->
            <ul class="nav nav-pills nav-pills-custom mb-5" id="policyTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="general-tab" data-bs-toggle="pill" data-bs-target="#general-content" type="button" role="tab">General Policy</button>
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

            <div class="tab-content" id="policyTabsContent">
                
                <!-- GENERAL POLICY PANEL -->
                <div class="tab-pane fade show active" id="general-content" role="tabpanel">
                    <h3 class="fw-bold mb-4">iPaymnt Tech Refund and Cancellation Policy</h3>
                    <div class="policy-intro">
                        <p class="mb-0">At <strong>iPaymnt Tech</strong>, our goal is to ensure complete customer satisfaction. If you are dissatisfied with our services or products, we will make every effort to address your concerns. However, a refund will only be provided if the reasons for dissatisfaction are genuine and substantiated following a thorough investigation.</p>
                    </div>

                    <div class="accordion" id="generalAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#genOne">
                                    Cancellation Guidelines
                                </button>
                            </h2>
                            <div id="genOne" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <ul class="bullet-list">
                                        <li>If you wish to cancel your service or subscription, please contact us through the "Contact Us" link on our website.</li>
                                        <li>Cancellations must be requested at least <strong>7 business days</strong> before the end of the current service period.</li>
                                        <li>Requests received after the 7-day window will be treated as cancellations for the next service period.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#genTwo">
                                    Refund Eligibility & Processing
                                </button>
                            </h2>
                            <div id="genTwo" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <ul class="bullet-list">
                                        <li><strong>Registration Fees:</strong> Please note that the registration fee is non-refundable.</li>
                                        <li><strong>Payment Method:</strong> If payment was made via credit card, the refund will be issued to the original credit card. For other gateways, it will be issued to the original source account.</li>
                                        <li><strong>Review Process:</strong> If dissatisfaction arises and is proven, we will process a refund after a thorough review.</li>
                                        <li><strong>Timeline:</strong> Standard refunds take 7-10 business days to reflect in your account.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FLIGHTS PANEL -->
                <div class="tab-pane fade" id="flight-content" role="tabpanel">
                    <h3 class="fw-bold mb-4">Flight <span class="text-green">Cancellation & Refunds</span></h3>
                    <p class="text-muted mb-4">iPaymnt Tech acts as a facilitator; flight cancellation charges depend strictly on the airline's specific fare rules.</p>
                    
                    <div class="accordion" id="flightAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flightOne">
                                    Airline Cancellation Charges
                                </button>
                            </h2>
                            <div id="flightOne" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <p>Cancellation charges vary by airline and ticket class:</p>
                                    <ul class="bullet-list">
                                        <li><strong>Refundable Tickets:</strong> A cancellation fee (ranging from ₹1,500 to ₹4,000) is deducted by the airline.</li>
                                        <li><strong>Non-Refundable Tickets:</strong> Only the statutory taxes (like UDF/PSF) are refunded.</li>
                                        <li><strong>iPayment Service Fee:</strong> A nominal convenience/service fee charged at the time of booking is non-refundable.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flightTwo">
                                    Special Cases (No-Show & Cancellations)
                                </button>
                            </h2>
                            <div id="flightTwo" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <p>Important rules for travelers:</p>
                                    <ul class="bullet-list">
                                        <li><strong>No-Show:</strong> If you do not board the flight, the booking is treated as a "No-Show" and typically no refund is provided.</li>
                                        <li><strong>Airline Cancellations:</strong> If the airline cancels the flight, a 100% refund of the airfare is usually provided, excluding convenience fees.</li>
                                        <li><strong>Timeline:</strong> Flight refunds are processed within 72 hours from our end, but may take 7 days to reach your bank.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- HOTELS PANEL -->
                <div class="tab-pane fade" id="hotel-content" role="tabpanel">
                    <h3 class="fw-bold mb-4">Hotel <span class="text-green">Cancellation Policy</span></h3>
                    <div class="accordion" id="hotelAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#hotelOne">
                                    Standard Hotel Rules
                                </button>
                            </h2>
                            <div id="hotelOne" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <ul class="bullet-list">
                                        <li><strong>Free Cancellation:</strong> Many hotels allow free cancellation if made more than 48-72 hours before check-in.</li>
                                        <li><strong>Partial Refund:</strong> Cancellations made within 24-48 hours may incur a 1-night stay charge.</li>
                                        <li><strong>Non-Refundable Rooms:</strong> Bookings labeled as "Non-Refundable" will not receive any money back upon cancellation.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BUSES PANEL -->
                <div class="tab-pane fade" id="bus-content" role="tabpanel">
                    <h3 class="fw-bold mb-4">Bus <span class="text-green">Booking Policy</span></h3>
                    <div class="accordion" id="busAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#busOne">
                                    Cancellation Timeline
                                </button>
                            </h2>
                            <div id="busOne" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <div class="table-responsive">
                                        <table class="table table-custom">
                                            <thead>
                                                <tr>
                                                    <th>Time of Cancellation</th>
                                                    <th>Refund Percentage</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>More than 24 hours before</td>
                                                    <td>80% - 100% (minus fees)</td>
                                                </tr>
                                                <tr>
                                                    <td>12 - 24 hours before</td>
                                                    <td>50% Refund</td>
                                                </tr>
                                                <tr>
                                                    <td>Less than 6 hours before</td>
                                                    <td>No Refund</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <p class="small text-muted mt-2">*Specific percentages vary by bus operator (VRL, SRS, etc.).</p>
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
