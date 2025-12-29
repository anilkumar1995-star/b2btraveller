
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous">

<!-- Font Awesome (icons ke liye, optional but useful) -->
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
      integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Bootstrap JS Bundle (Popper included) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

<main class="bg-light">

<!-- ================= HERO ================= -->
<section class="py-6">
    <div class="container">

        <div class="card border-0 shadow-lg text-center text-white overflow-hidden"
             style="background: linear-gradient(135deg,#4f46e5,#2563eb);">

            <div class="card-body py-5 px-4">

                <h1 class="fw-bold mb-2">How can we help you?</h1>
                <p class="opacity-75 mb-4">
                    Find answers, guides & documentation
                </p>

                <!-- Search -->
                <form class="row justify-content-center mb-4">
                    <div class="col-lg-6">
                        <div class="input-group input-group-lg shadow rounded-pill bg-white">
                            <input type="text"
                                   class="form-control border-0 rounded-start-pill px-4"
                                   placeholder="Search for help articles...">
                            <button class="btn btn-primary rounded-end-pill px-4">
                                Search
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Popular -->
                <div>
                    <small class="text-white-50 d-block mb-2">
                        Popular questions
                    </small>
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="#" class="link-light text-decoration-underline">
                            Upload data
                        </a>
                        <a href="#" class="link-light text-decoration-underline">
                            Installation guide
                        </a>
                        <a href="#" class="link-light text-decoration-underline">
                            Expired tickets
                        </a>
                        <a href="#" class="fw-semibold link-light">
                            View all →
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

<!-- ================= ARTICLE ================= -->
<section class="pb-6 mt-n5">
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-lg-10">

                <div class="card border-0 shadow-sm rounded-4">

                    <!-- Header -->
                    <div class="card-header bg-white border-0 p-4">
                        <h3 class="fw-bold mb-1">
                            Get started with Node.js
                        </h3>
                        <small class="text-muted">
                            Last updated 7 months ago · by
                            <strong>Sam Lanson</strong>
                        </small>
                    </div>

                    <!-- Body -->
                    <div class="card-body p-4">

                        <p class="text-muted lh-lg">
                            Started several mistakes joy say painful removed reached end.
                            <strong>Talent men wicket add garden.</strong>
                        </p>

                        <a href="#" class="btn btn-primary mb-4">
                            <i class="fa-brands fa-node-js me-2"></i>
                            Download Node.js
                        </a>

                        <h5 class="fw-semibold mt-4">
                            Table of contents
                        </h5>

                        <div class="alert alert-warning d-flex align-items-start gap-2">
                            <i class="fa-solid fa-circle-info mt-1"></i>
                            <div>
                                <strong>Note:</strong> Important setup instructions included.
                                <a href="#" class="alert-link">View more</a>
                            </div>
                        </div>

                        <ul class="lh-lg text-muted">
                            <li>Understanding Node.js basics</li>
                            <li>Installing required packages</li>
                            <li><strong>Running your first server</strong></li>
                            <li>Error handling & debugging</li>
                            <li>Production best practices</li>
                        </ul>

                        <p class="text-muted lh-lg mb-0">
                            Improved own provided blessing may peculiar domestic.
                            <u>Off melancholy alteration principles old.</u>
                        </p>

                    </div>

                    <!-- Footer -->
                    <div class="card-footer bg-white border-0 p-4 pt-0">
                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between
                                    bg-light rounded-3 p-3 gap-3">

                            <h6 class="mb-0">
                                Was this article helpful?
                            </h6>

                            <small class="text-muted">
                                20 out of 45 found this helpful
                            </small>

                            <div class="btn-group">
                                <button class="btn btn-outline-success btn-sm">
                                    <i class="fa-solid fa-thumbs-up me-1"></i>Yes
                                </button>
                                <button class="btn btn-outline-danger btn-sm">
                                    No <i class="fa-solid fa-thumbs-down ms-1"></i>
                                </button>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</section>

</main>
<?php /**PATH D:\wampp\www\b2btraveller\resources\views/help/about.blade.php ENDPATH**/ ?>