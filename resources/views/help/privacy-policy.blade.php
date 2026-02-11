
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy | iPayment Tech Private Limited</title>
    
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
            --indigo-green: #10b981;
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
        }

        .breadcrumb-item + .breadcrumb-item::before {
            color: rgba(255,255,255,0.6);
            content: "›";
            font-size: 1.2rem;
            vertical-align: middle;
        }
        .breadcrumb-item a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            font-size: 0.9rem;
        }
        .breadcrumb-item.active {
            color: white;
            font-size: 0.9rem;
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
            z-index: 10; /* Ensure card is above hero */
        }

        .text-green {
            color: #00a859; /* Custom green from reference */
        }

        /* Tabs Styling - Indigo Style */
        .nav-pills-custom {
            background: #f1f5f9;
            padding: 6px;
            border-radius: 50px;
            display: inline-flex;
            margin-bottom: 3rem;
        }

        .nav-pills-custom .nav-link {
            color: var(--text-main);
            background: transparent;
            border-radius: 50px;
            padding: 10px 35px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
        }

        .nav-pills-custom .nav-link.active {
            background: white;
            color: #2563eb;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .nav-pills-custom .nav-link:hover:not(.active) {
            background: rgba(255,255,255,0.5);
        }

        /* Accordion Styling */
        .accordion-item {
            border: none;
            margin-bottom: 15px;
            border-radius: 15px !important;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
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

        .accordion-button::after {
            background-size: 1rem;
        }

        .accordion-body {
            padding: 1.5rem;
            color: var(--text-muted);
            background: white;
        }

        .policy-intro {
            background: #f8fafc;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-left: 4px solid var(--primary-gradient);
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
           
            <h1 class="display-4 fw-bold">Privacy <span class="text-green">Policy</span></h1>
        </div>
    </section>

    <!-- ================= CONTENT ================= -->
    <section class="container">
        <div class="content-card">
            
            <!-- Tabs Navigation -->
            <ul class="nav nav-pills nav-pills-custom mb-5" id="policyTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="privacy-tab" data-bs-toggle="pill" data-bs-target="#privacy-content" type="button" role="tab">Privacy Policy</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="cookie-tab" data-bs-toggle="pill" data-bs-target="#cookie-content" type="button" role="tab">Cookie Policy</button>
                </li>
            </ul>

            <div class="tab-content" id="policyTabsContent">
                
                <!-- PRIVACY POLICY PANEL -->
                <div class="tab-pane fade show active" id="privacy-content" role="tabpanel">
                    <h3 class="fw-bold mb-4">Introduction</h3>
                    <div class="policy-intro">
                        <p class="mb-3">This privacy notice will explain how our organization, <strong>iPayment Tech Private Limited</strong> (“iPayment Tech”, also referred to below as “we”, “our” and “us”), uses the Personal Information we collect from you when you use our services. </p>
                        <p class="mb-3">iPayment Tech provides several products and services including <strong>Flight Bookings, Hotel Reservations, Bus Tickets, and Digital Financial Services</strong>, each with their own Personal Information processing needs. This privacy notice applies to our website (www.ipayments.in), online portal, mobile applications, and any other means through which we may collect your Personal Information.</p>
                        <p class="mb-0"><strong>Data Controller:</strong> iPayment Tech Private Limited, can be considered the Data Controller for the Personal Information that we process in connection with our products, services and offers.</p>
                    </div>

                    <div class="accordion" id="privacyAccordion">
                        
                        <!-- 1. Legal Basis -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                    1. What is our legal basis for processing your Personal Information?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#privacyAccordion">
                                <div class="accordion-body">
                                    <p>iPayment Tech will only process your Personal Information where we have a legal basis to do so:</p>
                                    <ul class="bullet-list">
                                        <li><strong>Performance of a contract:</strong> When you book flight tickets, hotels, or buses, we process details to fulfill your travel plans.</li>
                                        <li><strong>Public interest:</strong> As a travel aggregator, we may process info for security and safety maintenance.</li>
                                        <li><strong>Legitimate interests:</strong> To offer effective services and conduct our business operations.</li>
                                        <li><strong>Compliance with legal obligations:</strong> For border control, immigration, tax reasons, and law enforcement requests.</li>
                                        <li><strong>Consent:</strong> For sending tailored marketing, promotions, and special updates.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Data Collection -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                    2. What Personal Information do we collect?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#privacyAccordion">
                                <div class="accordion-body">
                                    <p>The Personal Information collected differs according to the purpose:</p>
                                    <h6 class="fw-bold mt-3">2.1 Personal Data</h6>
                                    <ul class="bullet-list">
                                        <li>Name, physical address, and date of birth</li>
                                        <li>Telephone number and e-mail address</li>
                                        <li>Valid travel documents (Passport/Visa for international bookings)</li>
                                        <li>Flight/Bus itinerary and booking information (PNR numbers)</li>
                                        <li>Government ID card details (where applicable for check-ins)</li>
                                    </ul>
                                    <h6 class="fw-bold mt-3">2.2 Sensitive Personal Data</h6>
                                    <ul class="bullet-list">
                                        <li><strong>Financial Info:</strong> Credit/Debit card or payment instrument details for transactions.</li>
                                        <li><strong>Health Data:</strong> If you require medical assistance, wheelchairs, or specific meal requirements for medical reasons.</li>
                                    </ul>
                                    <h6 class="fw-bold mt-3">2.3 Technical Data</h6>
                                    <p>IP addresses, Geo Location, browser type, and device identifiers collected via our portal.</p>
                                </div>
                            </div>
                        </div>

                        <!-- 3. How we collect -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                    3. How do we collect your personal information?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#privacyAccordion">
                                <div class="accordion-body">
                                    <p>You directly provide iPayment Tech with most of the data. We collect it when:</p>
                                    <ul class="bullet-list">
                                        <li>You book a flight, bus, or hotel on our platform.</li>
                                        <li>You create an online account or subscribe to our newsletter.</li>
                                        <li>You contact our customer care or use our chatbot.</li>
                                        <li>We receive data from our Partners (Airlines, Hotel chains, Bus operators) to handle your reservations.</li>
                                        <li>Public authorities provide data for safety (e.g., security watchlists).</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 4. How we use -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                                    4. How do we use your Personal Information?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#privacyAccordion">
                                <div class="accordion-body">
                                    <p>We use your data for:</p>
                                    <ul class="bullet-list">
                                        <li><strong>Providing Services:</strong> Processing bookings, verifying identity, and sending itinerary updates.</li>
                                        <li><strong>Loyalty Programs:</strong> Managing rewards and cashback offers.</li>
                                        <li><strong>Business Operations:</strong> Fraud prevention, record-keeping, and customer support.</li>
                                        <li><strong>Marketing:</strong> Delivering special offers and travel deals based on your preferences.</li>
                                        <li><strong>Safety:</strong> Complying with aviation and transit security regulations.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Retention -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive">
                                    5. How long do we retain your Personal Information?
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#privacyAccordion">
                                <div class="accordion-body">
                                    <p>We store your Personal Information for as long as necessary to fulfill the purpose for which it was collected, or to meet any legal, business, or reporting requirements. When deleting, we use secure methods to render the data impossible to recover.</p>
                                </div>
                            </div>
                        </div>

                         <!-- 6. Security -->
                         <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix">
                                    6. How do we ensure security of your Personal Information?
                                </button>
                            </h2>
                            <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#privacyAccordion">
                                <div class="accordion-body">
                                    <p>All data is secured using strict procedures. We implement appropriate organizational and technical measures aligned with industry standards (ISO 27001 models) to prevent unauthorized access, loss, or alteration.</p>
                                </div>
                            </div>
                        </div>

                        <!-- 7. Disclosure -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven">
                                    7. Disclosure of your Personal Information
                                </button>
                            </h2>
                            <div id="collapseSeven" class="accordion-collapse collapse" data-bs-parent="#privacyAccordion">
                                <div class="accordion-body">
                                    <ul class="bullet-list">
                                        <li><strong>Service Providers:</strong> Shared with Airlines, Hotels, and Bus Operators to complete your travel.</li>
                                        <li><strong>Partner Banks:</strong> For processing payments and managing loyalty benefits.</li>
                                        <li><strong>Legal Disclosures:</strong> Required by law enforcement or government agencies for identity verification.</li>
                                        <li><strong>Business Transactions:</strong> In case of mergers or acquisitions.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                         <!-- 8. Rights -->
                         <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight">
                                    8. What are your data subject rights?
                                </button>
                            </h2>
                            <div id="collapseEight" class="accordion-collapse collapse" data-bs-parent="#privacyAccordion">
                                <div class="accordion-body">
                                    <p>Every user is entitled to:</p>
                                    <ul class="bullet-list">
                                        <li><strong>Right to inform/access:</strong> Know what we process and request copies.</li>
                                        <li><strong>Right to rectification:</strong> Correct inaccurate info.</li>
                                        <li><strong>Right to erasure:</strong> Request deletion when no longer needed.</li>
                                        <li><strong>Right to data portability:</strong> Receive data in a readable format.</li>
                                        <li><strong>Right to object:</strong> Object to profiling or automated decision making.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 12. Contact -->
                         <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseContact">
                                    12. How to contact us
                                </button>
                            </h2>
                            <div id="collapseContact" class="accordion-collapse collapse" data-bs-parent="#privacyAccordion">
                                <div class="accordion-body">
                                    <p>If you have questions about iPayment Tech’s privacy notice, contact us:</p>
                                    <p class="mb-1"><strong>Email:</strong> <a href="mailto:info@ipayments.org.in">info@ipayments.org.in</a></p>
                                    <p class="mb-1"><strong>Grievance Officer:</strong> AppellateAuthority@ipayments.in</p>
                                    <p class="mb-1"><strong>Customer Support:</strong> +91 9147317821</p>
                                    <p><strong>Office:</strong> E34 Krishana Apartment North SK Puri, Patna, Bihar - 800013</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- COOKIE POLICY PANEL -->
                <div class="tab-pane fade" id="cookie-content" role="tabpanel">
                    <h3 class="fw-bold mb-4">iPayment Tech’s <span class="text-green">Cookie Policy</span></h3>
                    <p class="text-secondary mb-4">To improve the user experience, iPayment Tech sets and uses cookies on its website and third-party providers. This enables us to remember your preferences and deliver better services.</p>
                    
                    <h4 class="fw-bold mb-3">What is a <span class="text-green">cookie</span>?</h4>
                    <p class="text-secondary mb-4">A cookie is a small amount of data generated by a website and saved by your web browser. It is used to identify the user or device and to remember information like login status or search history.</p>

                    <h4 class="fw-bold mb-3">Types of cookies and <span class="text-green">why we use them</span></h4>
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <div class="p-4 bg-light rounded-4 h-100">
                                <h6 class="fw-bold"><i class="fa-solid fa-shield-halved text-primary me-2"></i> Strictly Necessary</h6>
                                <p class="small text-muted mb-0">Essential for the website to function (e.g., flight selection, cart items, secure logins).</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-4 bg-light rounded-4 h-100">
                                <h6 class="fw-bold"><i class="fa-solid fa-chart-line text-success me-2"></i> Performance</h6>
                                <p class="small text-muted mb-0">Help us measure traffic and see which travel search pages are most popular.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-4 bg-light rounded-4 h-100">
                                <h6 class="fw-bold"><i class="fa-solid fa-sliders text-warning me-2"></i> Functionality</h6>
                                <p class="small text-muted mb-0">Remember choices like your preferred language or region for localized travel packages.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-4 bg-light rounded-4 h-100">
                                <h6 class="fw-bold"><i class="fa-solid fa-bullseye text-danger me-2"></i> Targeting</h6>
                                <p class="small text-muted mb-0">Used to build a profile of your interests and show you relevant travel adverts on other sites.</p>
                            </div>
                        </div>
                    </div>

                    <h4 class="fw-bold mb-3">Managing website cookies</h4>
                    <p class="text-secondary">You can manage website cookies in your browser settings. You always have the choice to accept, reject, or delete cookies. Note that rejecting essential cookies may impact the booking process on iPayments portal.</p>
                </div>

            </div>
        </div>
    </section>

</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
