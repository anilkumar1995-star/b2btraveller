
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | iPayment Tech Private Limited</title>
    
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
        }

        body {
            font-family: 'Outfit', sans-serif;
            color: var(--text-main);
            background-color: var(--bg-light);
            overflow-x: hidden;
        }

        .hero-section {
            background: var(--primary-gradient);
            padding: 100px 0 160px;
            color: white;
            position: relative;
            z-index: 1;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            bottom: -50px;
            left: 0;
            right: 0;
            height: 100px;
            background: var(--bg-light);
            clip-path: ellipse(60% 50px at 50% 100%);
            z-index: -1;
        }

        .about-card {
            background: white;
            border-radius: 24px;
            border: none;
            box-shadow: 0 20px 40px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }

        .section-title {
            font-weight: 700;
            position: relative;
            margin-bottom: 2rem;
            padding-bottom: 0.5rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 4px;
            background: var(--accent-color);
            border-radius: 2px;
        }

        .text-center .section-title::after {
            left: 50%;
            transform: translateX(-50%);
        }

        .service-icon {
            width: 70px;
            height: 70px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 18px;
            font-size: 28px;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .service-card:hover .service-icon {
            background: var(--primary-gradient);
            color: white;
            transform: translateY(-5px);
        }

        .impact-badge {
            background: #fff;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.1);
            text-align: center;
            height: 100%;
        }

        .impact-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2563eb;
            display: block;
        }

        .mission-vision-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            height: 100%;
            border-left: 6px solid #2563eb;
        }

        .about-image {
            border-radius: 30px;
            box-shadow: 20px 20px 60px rgba(0,0,0,0.1);
        }

        .lead-text {
            font-size: 1.15rem;
            line-height: 1.8;
            color: var(--text-muted);
        }

        .travel-tag {
            background: rgba(255,255,255,0.2);
            padding: 5px 15px;
            border-radius: 30px;
            font-size: 0.9rem;
            backdrop-filter: blur(5px);
        }

    </style>
</head>
<body>

<main>

    <!-- ================= HERO ================= -->
    <section class="hero-section text-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <span class="travel-tag mb-3 d-inline-block">iPayment Tech Private Limited</span>
                    <h1 class="display-3 fw-bold mb-3">Empowering Rural India</h1>
                    <p class="lead opacity-90 mb-0">Bridging the urban-rural divide through Digital Finance & World-Class Travel Solutions.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= MAIN ABOUT ================= -->
    <section class="py-5" style="margin-top: -80px;">
        <div class="container">
            <div class="card about-card p-4 p-md-5">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6">
                        <h2 class="section-title">About iPayment Tech</h2>
                        <p class="lead-text mb-4">
                            iPayment Tech Private Limited is at the forefront of driving financial inclusion and digital empowerment in rural India. Our goal is to ensure that everyone, regardless of location, has easy access to essential financial services.
                        </p>
                        <p class="lead-text">
                            By bridging the urban-rural divide, we aim to transform the way rural communities access banking, financial products, and digital services. With a strong network of <strong>2.5 lakh+ retail touchpoints</strong>, we are committed to providing seamless last-mile delivery.
                        </p>
                    </div>
                    <div class="col-lg-6 text-center">
                        <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&q=80&w=800" alt="Travel and Tech" class="img-fluid about-image">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= TRAVEL SERVICES ================= -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Our Premium Travel Solutions</h2>
                <p class="text-muted">Fast, Secure, and Transparent Booking Experience</p>
            </div>
            
            <div class="row g-4 leading-relaxed">
                <!-- Flight Booking -->
                <div class="col-md-4">
                    <div class="card about-card h-100 service-card p-4">
                        <div class="service-icon">
                            <i class="fa-solid fa-plane-up"></i>
                        </div>
                        <h4 class="fw-bold">Flight Ticket Booking</h4>
                        <p class="text-muted">Book domestic and international flights at competitive prices. Our agents provide fast confirmations and reliable support for all major airlines.</p>
                    </div>
                </div>
                
                <!-- Bus Booking -->
                <div class="col-md-4">
                    <div class="card about-card h-100 service-card p-4 text-primary-emphasis" style="background: #f0f7ff;">
                        <div class="service-icon" style="background: #2563eb; color: #fff;">
                            <i class="fa-solid fa-bus"></i>
                        </div>
                        <h4 class="fw-bold">Bus Reservations</h4>
                        <p class="text-muted">Access over thousands of routes across India. Seamlessly reserve seats with instant ticket delivery through our extensive retail network.</p>
                    </div>
                </div>

                <!-- Hotel Booking -->
                <div class="col-md-4">
                    <div class="card about-card h-100 service-card p-4">
                        <div class="service-icon">
                            <i class="fa-solid fa-hotel"></i>
                        </div>
                        <h4 class="fw-bold">Hotel Reservations</h4>
                        <p class="text-muted">Secure affordable and premium hotel accommodations effortlessly. We bring transparency and variety to customers in every corner of the country.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= IMPACT ================= -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5">
                    <h2 class="section-title">Our Impact</h2>
                    <p class="lead-text">
                        In a short time, we have impacted the lives of over <strong>1 million people daily</strong> by offering a wide range of services. Our dedicated network of retail touchpoints is supported by a team of experts who ensure each location is equipped to meet the unique needs of local communities.
                    </p>
                </div>
                <div class="col-lg-7">
                    <div class="row g-4">
                        <div class="col-sm-6">
                            <div class="impact-badge">
                                <span class="impact-number">2.5 Lakh+</span>
                                <p class="mb-0 text-muted fw-semibold">Retail Points</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="impact-badge">
                                <span class="impact-number">10 Lakh+</span>
                                <p class="mb-0 text-muted fw-semibold">Daily Customers</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= MISSION & VISION ================= -->
    <section class="py-5 mb-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="mission-vision-card shadow-sm">
                        <div class="d-flex align-items-center mb-3">
                            <div class="fs-2 text-primary me-3"><i class="fa-solid fa-bullseye"></i></div>
                            <h3 class="fw-bold mb-0">Our Mission</h3>
                        </div>
                        <p class="text-muted lh-lg">
                            Our mission is to expand the reach of digital banking and travel services to every corner of India, ensuring that every citizen has access to secure, efficient, and user-friendly financial and travel solutions through our wide network of retail touchpoints.
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mission-vision-card shadow-sm" style="border-left-color: var(--accent-color);">
                        <div class="d-flex align-items-center mb-3">
                            <div class="fs-2 text-warning me-3"><i class="fa-solid fa-eye"></i></div>
                            <h3 class="fw-bold mb-0">Our Vision</h3>
                        </div>
                        <p class="text-muted lh-lg">
                            Our vision is to foster self-employment opportunities and enhance digital and travel services across rural areas, driving financial inclusion while creating a sustainable and inclusive digital economy for millions of people in India.
                        </p>
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
