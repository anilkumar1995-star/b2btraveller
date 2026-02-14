

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | iPaymnt Tech Private Limited</title>
    
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
            --bg-light: #f1f5f9;
        }

        body {
            font-family: 'Outfit', sans-serif;
            color: var(--text-main);
            background-color: var(--bg-light);
            overflow-x: hidden;
        }

        .hero-section {
            background: var(--primary-gradient);
            padding: 80px 0 120px;
            color: white;
            text-align: center;
        }

        .contact-card {
            background: white;
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            height: 100%;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .contact-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(79, 70, 229, 0.1);
        }

        .icon-box {
            width: 70px;
            height: 70px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 28px;
            margin-bottom: 1.5rem;
        }

        .office-title {
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 1rem;
            color: #1e1b4b;
        }

        .office-address {
            color: var(--text-muted);
            line-height: 1.6;
            font-size: 0.95rem;
        }

        .support-link {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            display: block;
            margin-top: 5px;
        }

        .whatsapp-btn {
            background: #25d366;
            color: white;
            padding: 8px 15px;
            border-radius: 30px;
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            font-weight: 600;
            margin-top: 15px;
            transition: background 0.3s ease;
        }

        .whatsapp-btn:hover {
            background: #128c7e;
            color: white;
        }

        .section-tag {
            background: rgba(255,255,255,0.2);
            padding: 5px 20px;
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1rem;
            display: inline-block;
        }

    </style>
</head>
<body>

<main>
    <!-- ================= HERO ================= -->
    <section class="hero-section">
        <div class="container">
            <span class="section-tag">Get In Touch</span>
            <h1 class="display-4 fw-bold mb-3">Contact iPaymnt Tech</h1>
            <p class="lead opacity-90 mx-auto col-lg-7">Have questions about our travel or digital services? Our teams across India are here to help you grow your business.</p>
        </div>
    </section>

    <!-- ================= CONTACT CARDS ================= -->
    <section class="py-5" style="margin-top: -60px;">
        <div class="container">
            <div class="row g-4 justify-content-center">
                
                <!-- Registered Office -->
                <div class="col-lg-4 col-md-6">
                    <div class="contact-card">
                        <div class="icon-box">
                            <i class="fa-solid fa-building-circle-check"></i>
                        </div>
                        <h3 class="office-title">Registered Office</h3>
                        <p class="office-address">
                            iPaymnt Tech Private Limited<br>
                            E34 Krishana Apartment North SK Puri<br>
                            Patna, Bihar, India - 800013
                        </p>
                    </div>
                </div>

                <!-- Corporate Office 1 (Kolkata) -->
                <div class="col-lg-4 col-md-6">
                    <div class="contact-card">
                        <div class="icon-box" style="background: #fff7ed; color: #ea580c;">
                            <i class="fa-solid fa-city"></i>
                        </div>
                        <h3 class="office-title">Corporate Office (Kolkata)</h3>
                        <p class="office-address">
                            iPaymnt Tech Private Limited<br>
                            ANO706 Astra Tower, Action Area 2C<br>
                            New Town, Kolkata, West Bengal, India - 700135
                        </p>
                    </div>
                </div>

                <!-- Corporate Office 2 (Lucknow) -->
                <div class="col-lg-4 col-md-6">
                    <div class="contact-card">
                        <div class="icon-box">
                            <i class="fa-solid fa-landmark"></i>
                        </div>
                        <h3 class="office-title">Corporate Office (Lucknow)</h3>
                        <p class="office-address">
                            iPayments Private Limited<br>
                            CP-19, 2nd Floor, Vibhutikhand<br>
                            Gomtinagar, Lucknow, UP, India - 226010
                        </p>
                    </div>
                </div>

                <!-- Email Contact -->
                <div class="col-lg-4 col-md-6">
                    <div class="contact-card">
                        <div class="icon-box" style="background: #e0e7ff; color: #4338ca;">
                            <i class="fa-solid fa-envelope-open-text"></i>
                        </div>
                        <h3 class="office-title">Email Us</h3>
                        <p class="office-address mb-0">For general inquiries and support:</p>
                        <a href="mailto:info@ipayments.org.in" class="support-link">info@ipayments.org.in</a>
                    </div>
                </div>

                <!-- Phone Contact -->
                <div class="col-lg-4 col-md-6">
                    <div class="contact-card">
                        <div class="icon-box" style="background: #f0fdf4; color: #16a34a;">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <h3 class="office-title">Customer Support</h3>
                        <p class="office-address mb-0">Speak with our experts:</p>
                        <a href="tel:+919147317821" class="support-link">+91 9147317821</a>
                        
                        <a href="https://wa.me/919147173395" class="whatsapp-btn">
                            <i class="fa-brands fa-whatsapp me-2 fs-5"></i> Chat on WhatsApp
                        </a>
                        <small class="text-muted mt-2 d-block">+91 9147173395</small>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ================= MAP / BOTTOM SECTION ================= -->
    <section class="py-5 bg-white mt-4">
        <div class="container text-center">
            <h2 class="fw-bold mb-4">Connect With Our Network</h2>
            <p class="text-muted mx-auto col-md-8">With over 2.5 lakh retail touchpoints, we are always close to you. Visit your nearest service point for instant flight, bus, and hotel bookings.</p>
        </div>
    </section>

</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
