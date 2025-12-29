@extends('layouts.base')

@section('content')
    <!-- **************** MAIN CONTENT START **************** -->
    <main>

        <!-- =======================
    Search START -->
        <section class="pt-2">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- Booking from START -->
                        <form class="card shadow p-4">
                            <div class="row g-4">
                                <!-- From -->
                                <div class="col-lg-3">
                                    <div class="form-size-lg">
                                        <label class="form-label">From</label>
                                        <select class="form-select js-choice" data-search-enabled="true">
                                            <option value="">Select location</option>
                                            <option selected>Mumbai</option>
                                            <option>Delhi</option>
                                            <option>Bangalore</option>
                                            <option>Hyderabad</option>
                                            <option>Chennai</option>
                                            <option>Kolkata</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- To -->
                                <div class="col-lg-3">
                                    <div class="form-size-lg">
                                        <label class="form-label">To</label>
                                        <select class="form-select js-choice" data-search-enabled="true">
                                            <option value="">Select location</option>
                                            <option>Mumbai</option>
                                            <option selected>Pune</option>
                                            <option>Bangalore</option>
                                            <option>Hyderabad</option>
                                            <option>Chennai</option>
                                            <option>Kolkata</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Date -->
                                <div class="col-lg-3">
                                    <div class="form-size-lg">
                                        <label class="form-label">Journey Date</label>
                                        <input type="text" class="form-control flatpickr" value="29/11/2023">
                                    </div>
                                </div>

                                <!-- Passengers -->
                                <div class="col-lg-2">
                                    <div class="form-size-lg">
                                        <label class="form-label">Passengers</label>
                                        <select class="form-select">
                                            <option>1</option>
                                            <option selected>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Button -->
                                <div class="col-lg-1">
                                    <div class="d-grid">
                                        {{-- <a class="btn btn-lg btn-primary mb-0" href="#">Search</a> --}}
                                        <div class="btn-position-md-middle">
                                            <a class="icon-lg btn btn-round btn-primary mb-0"
                                                href="{{ route('second', ['bus', 'list']) }}"><i
                                                    class="bi bi-search fa-fw"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- Booking from END -->
                    </div>
                </div>
            </div>
        </section>
        <!-- =======================
    Search END -->

        <!-- =======================
    Bus list START -->
        <section class="pt-0">
            <div class="container">
                <div class="row">
                    <!-- Left sidebar START -->
                    <div class="col-lg-4 col-xl-3">
                        <!-- Responsive offcanvas body START -->
                        <div class="offcanvas-lg offcanvas-end" tabindex="-1" id="offcanvasSidebar">
                            <!-- Offcanvas header -->
                            <div class="offcanvas-header justify-content-end pb-2">
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                    data-bs-target="#offcanvasSidebar" aria-label="Close"></button>
                            </div>

                            <!-- Offcanvas body -->
                            <div class="offcanvas-body p-3 p-lg-0">
                                <div class="card bg-light rounded-3">
                                    <!-- Card body -->
                                    <div class="card-body">
                                        <!-- Title -->
                                        <h5>Filters</h5>

                                        <!-- Price range START -->
                                        <div class="mb-4">
                                            <h6 class="mb-2">Price Range</h6>
                                            <div class="position-relative">
                                                <input type="range" class="form-range" min="100" max="2000"
                                                    step="100">
                                                <div class="position-absolute top-100 start-0 translate-middle">₹100</div>
                                                <div class="position-absolute top-100 end-0 translate-middle">₹2000</div>
                                            </div>
                                        </div>
                                        <!-- Price range END -->

                                        <hr> <!-- Divider -->

                                        <!-- Departure time START -->
                                        <div class="mb-4">
                                            <h6 class="mb-2">Departure Time</h6>
                                            <ul class="list-inline mb-0">
                                                <!-- Morning -->
                                                <li class="list-inline-item">
                                                    <input type="checkbox" class="btn-check" id="btn-morning">
                                                    <label class="btn btn-light btn-primary-soft-check"
                                                        for="btn-morning">Morning</label>
                                                </li>
                                                <!-- Afternoon -->
                                                <li class="list-inline-item">
                                                    <input type="checkbox" class="btn-check" id="btn-afternoon">
                                                    <label class="btn btn-light btn-primary-soft-check"
                                                        for="btn-afternoon">Afternoon</label>
                                                </li>
                                                <!-- Evening -->
                                                <li class="list-inline-item">
                                                    <input type="checkbox" class="btn-check" id="btn-evening">
                                                    <label class="btn btn-light btn-primary-soft-check"
                                                        for="btn-evening">Evening</label>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- Departure time END -->

                                        <hr> <!-- Divider -->

                                        <!-- Bus type START -->
                                        <div class="mb-4">
                                            <h6 class="mb-2">Bus Type</h6>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item">
                                                    <input type="checkbox" class="btn-check" id="btn-ac">
                                                    <label class="btn btn-light btn-primary-soft-check"
                                                        for="btn-ac">AC</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="checkbox" class="btn-check" id="btn-nonac">
                                                    <label class="btn btn-light btn-primary-soft-check" for="btn-nonac">Non
                                                        AC</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="checkbox" class="btn-check" id="btn-sleeper">
                                                    <label class="btn btn-light btn-primary-soft-check"
                                                        for="btn-sleeper">Sleeper</label>
                                                </li>
                                                <li class="list-inline-item">
                                                    <input type="checkbox" class="btn-check" id="btn-seater">
                                                    <label class="btn btn-light btn-primary-soft-check"
                                                        for="btn-seater">Seater</label>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- Bus type END -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Responsive offcanvas body END -->
                    </div>
                    <!-- Left sidebar END -->

                    <!-- Main content START -->
                    <div class="col-lg-8 col-xl-9">

                        <!-- List items START -->
                        <div class="vstack gap-4">

                            <!-- Bus item START -->
                            <div class="card border">
                                <!-- Card body -->
                                <div class="card-body p-4">
                                    <div class="row g-4">
                                        <!-- Bus image -->
                                        <div class="col-md-3">
                                            <img src="{{ asset('images/category/bus/03.svg') }}" class="rounded-2"
                                                alt="">
                                        </div>

                                        <!-- Bus info -->
                                        <div class="col-md-9">
                                            <div class="row g-4">
                                                <!-- Info -->
                                                <div class="col-md-8">
                                                    <h5 class="card-title mb-1">Sharma Travels</h5>
                                                    <ul class="list-inline mb-0">
                                                        <li class="list-inline-item me-0"><i
                                                                class="bi bi-star-fill text-warning"></i></li>
                                                        <li class="list-inline-item me-0"><i
                                                                class="bi bi-star-fill text-warning"></i></li>
                                                        <li class="list-inline-item me-0"><i
                                                                class="bi bi-star-fill text-warning"></i></li>
                                                        <li class="list-inline-item me-0"><i
                                                                class="bi bi-star-fill text-warning"></i></li>
                                                        <li class="list-inline-item"><i
                                                                class="bi bi-star-fill text-warning"></i></li>
                                                    </ul>

                                                    <!-- Journey time and amenities -->
                                                    <ul class="nav nav-divider align-items-center mt-2">
                                                        <li class="nav-item">
                                                            <div class="d-flex align-items-center">
                                                                <i class="bi bi-clock-fill"></i>
                                                                <span class="ms-2">5:00 AM - 9:00 AM</span>
                                                            </div>
                                                        </li>
                                                        <li class="nav-item">AC Sleeper</li>
                                                    </ul>

                                                    <!-- Seats info -->
                                                    <div class="mt-2 text-success">
                                                        <i class="bi bi-chair-fill me-1"></i>20 seats available
                                                    </div>
                                                </div>

                                                <!-- Price and button -->
                                                <div class="col-md-4 text-md-end">
                                                    <h5 class="mb-1">₹800</h5>
                                                    <span class="mb-2 d-block">Per person</span>
                                                    <a href="{{ route('second', ['bus', 'booking']) }}"
                                                        class="btn btn-primary mb-0">Select Seats</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Bus item END -->

                            <!-- Bus item START -->
                            <div class="card border">
                                <!-- Card body -->
                                <div class="card-body p-4">
                                    <div class="row g-4">
                                        <!-- Bus image -->
                                        <div class="col-md-3">
                                            <img src="{{ asset('images/category/bus/04.svg') }}" class="rounded-2"
                                                alt="">
                                        </div>

                                        <!-- Bus info -->
                                        <div class="col-md-9">
                                            <div class="row g-4">
                                                <!-- Info -->
                                                <div class="col-md-8">
                                                    <h5 class="card-title mb-1">Royal Bus Service</h5>
                                                    <ul class="list-inline mb-0">
                                                        <li class="list-inline-item me-0"><i
                                                                class="bi bi-star-fill text-warning"></i></li>
                                                        <li class="list-inline-item me-0"><i
                                                                class="bi bi-star-fill text-warning"></i></li>
                                                        <li class="list-inline-item me-0"><i
                                                                class="bi bi-star-fill text-warning"></i></li>
                                                        <li class="list-inline-item me-0"><i
                                                                class="bi bi-star-fill text-warning"></i></li>
                                                        <li class="list-inline-item"><i
                                                                class="bi bi-star text-warning"></i></li>
                                                    </ul>

                                                    <!-- Journey time and amenities -->
                                                    <ul class="nav nav-divider align-items-center mt-2">
                                                        <li class="nav-item">
                                                            <div class="d-flex align-items-center">
                                                                <i class="bi bi-clock-fill"></i>
                                                                <span class="ms-2">7:00 AM - 11:00 AM</span>
                                                            </div>
                                                        </li>
                                                        <li class="nav-item">AC Seater</li>
                                                    </ul>

                                                    <!-- Seats info -->
                                                    <div class="mt-2 text-success">
                                                        <i class="bi bi-chair-fill me-1"></i>15 seats available
                                                    </div>
                                                </div>

                                                <!-- Price and button -->
                                                <div class="col-md-4 text-md-end">
                                                    <h5 class="mb-1">₹650</h5>
                                                    <span class="mb-2 d-block">Per person</span>
                                                    <a href="{{ route('second', ['bus', 'booking']) }}"
                                                        class="btn btn-primary mb-0">Select Seats</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Bus item END -->

                            <!-- Bus item START -->
                            <div class="card border">
                                <!-- Card body -->
                                <div class="card-body p-4">
                                    <div class="row g-4">
                                        <!-- Bus image -->
                                        <div class="col-md-3">
                                            <img src="{{ asset('images/category/bus/05.svg') }}" class="rounded-2"
                                                alt="">
                                        </div>

                                        <!-- Bus info -->
                                        <div class="col-md-9">
                                            <div class="row g-4">
                                                <!-- Info -->
                                                <div class="col-md-8">
                                                    <h5 class="card-title mb-1">City Express</h5>
                                                    <ul class="list-inline mb-0">
                                                        <li class="list-inline-item me-0"><i
                                                                class="bi bi-star-fill text-warning"></i></li>
                                                        <li class="list-inline-item me-0"><i
                                                                class="bi bi-star-fill text-warning"></i></li>
                                                        <li class="list-inline-item me-0"><i
                                                                class="bi bi-star-fill text-warning"></i></li>
                                                        <li class="list-inline-item me-0"><i
                                                                class="bi bi-star-fill text-warning"></i></li>
                                                        <li class="list-inline-item"><i
                                                                class="bi bi-star-half text-warning"></i></li>
                                                    </ul>

                                                    <!-- Journey time and amenities -->
                                                    <ul class="nav nav-divider align-items-center mt-2">
                                                        <li class="nav-item">
                                                            <div class="d-flex align-items-center">
                                                                <i class="bi bi-clock-fill"></i>
                                                                <span class="ms-2">9:00 AM - 1:00 PM</span>
                                                            </div>
                                                        </li>
                                                        <li class="nav-item">Non AC Seater</li>
                                                    </ul>

                                                    <!-- Seats info -->
                                                    <div class="mt-2 text-danger">
                                                        <i class="bi bi-chair-fill me-1"></i>Only 5 seats left
                                                    </div>
                                                </div>

                                                <!-- Price and button -->
                                                <div class="col-md-4 text-md-end">
                                                    <h5 class="mb-1">₹500</h5>
                                                    <span class="mb-2 d-block">Per person</span>
                                                    <a href="{{ route('second', ['bus', 'booking']) }}"
                                                        class="btn btn-primary mb-0">Select Seats</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Bus item END -->

                        </div>
                        <!-- List items END -->

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination pagination-primary-soft mb-0">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1">Prev</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item active"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                    </div>
                    <!-- Main content END -->
                </div>
            </div>
        </section>
        <!-- =======================
    Bus list END -->

    </main>
    <!-- **************** MAIN CONTENT END **************** -->
@endsection
