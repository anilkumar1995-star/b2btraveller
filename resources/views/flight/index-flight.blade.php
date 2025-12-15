@extends('layouts.app')
@section('title', 'Booking Search')
@section('pagetitle', 'Booking Search')


@section('content')
    <style>
        .nav-tabs .nav-link.active {
            background-color: rgb(103, 103, 233) !important;
            color: white !important;
        }

        .btn-flip-icon {
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        @media (max-width: 767.98px) {
            .btn-flip-icon {
                position: absolute;
                left: 50%;
                top: 100%;
                transform: translate(-50%, -50%);
                margin-top: 0.5rem;
            }

            .btn-flip-icon i {
                transform: rotate(270deg);
            }
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid #dbdade !important;
            height: 38px !important;
            border-radius: 0.375rem !important;
            line-height: 1.5 !important;
            border-radius: 0.375rem !important;
            font-size: 0.9375rem !important;
            padding: 0.422rem 0.375rem !important;
            width: 100% !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #807c8c !important;
            line-height: 25px !important;
        }

        .select2-container--default .select2-results>.select2-results__options {
            cursor: pointer !important;
        }
    </style>



    <main>
        <section class="py-0">
            <!-- Background image -->
            <div class="rounded-3">
                <!-- Banner title -->
                {{-- <div class="row">
                        <div class="col-md-10 mx-auto text-center">
                            <h1 class="text-dark display-3 mb-5">Ready to take off?</h1>
                        </div>
                    </div> --}}

                <!-- Booking from START -->
                <form
                    style="background-image: url('{{ asset('images/1.png') }}'); background-position: center center; background-repeat: no-repeat; background-size: cover;"
                    id="flightSearchForm" class="bg-mode bg-white position-relative px-3 px-sm-4 pt-4 mb-4 mb-sm-0">
                    @csrf
                    <!-- Svg decoration -->
                    <figure class="position-absolute top-0 start-0 h-100 ms-n2 ms-sm-n1">
                        <svg class="h-100" viewBox="0 0 12.9 324" style="enable-background:new 0 0 12.9 324;">
                            <path class="fill-mode"
                                d="M9.8,316.4c1.1-26.8,2-53.4,1.9-80.2c-0.1-18.2-0.8-36.4-1.2-54.6c-0.2-8.9-0.2-17.7,0.8-26.6 c0.5-4.5,1.1-9,1.4-13.6c0.1-1.9,0.1-3.7,0.1-5.6c-0.2-0.2-0.6-1.5-0.2-3.1c-0.3-1.8-0.4-3.7-0.4-5.5c-1.2-3-1.8-6.3-1.7-9.6 c0.9-19,0.5-38.1,0.8-57.2c0.3-17.1,0.6-34.2,0.2-51.3c-0.1-0.6-0.1-1.2-0.1-1.7c0-0.8,0-1.6,0-2.4c0-0.5,0-1.1,0-1.6 c0-1.2,0-2.3,0.2-3.5H0v11.8c3.3,0,6.1,2.8,6.1,6.1c0,3.4-2.8,6.1-6.1,6.1V31c3.3,0,6.1,2.7,6.1,6.1S3.3,43.3,0,43.3v6.9 c3.3,0,6.1,2.8,6.1,6.1c0,3.4-2.8,6.1-6.1,6.1v6.9c3.3,0,6.1,2.8,6.1,6.1c0,3.4-2.8,6.1-6.1,6.1v6.9c3.3,0,6.1,2.8,6.1,6.1 s-2.8,6.1-6.1,6.1v6.9c3.3,0,6.1,2.8,6.1,6.1c0,3.4-2.8,6.1-6.1,6.1v6.9c3.3,0,6.1,2.8,6.1,6.1c0,3.4-2.8,6.1-6.1,6.1v6.9 c3.3,0,6.1,2.8,6.1,6.1c0,3.4-2.8,6.1-6.1,6.1v6.9c3.3,0,6.1,2.8,6.1,6.1c0,3.4-2.8,6.1-6.1,6.1v6.9c3.3,0,6.1,2.8,6.1,6.1 c0,3.4-2.8,6.1-6.1,6.1v6.9c3.3,0,6.1,2.7,6.1,6.1c0,3.4-2.8,6.1-6.1,6.1v6.9c3.3,0,6.1,2.8,6.1,6.1c0,3.4-2.8,6.1-6.1,6.1v6.9 c3.3,0,6.1,2.8,6.1,6.1c0,3.4-2.8,6.1-6.1,6.1v6.9c3.3,0,6.1,2.8,6.1,6.1c0,3.4-2.8,6.1-6.1,6.1v6.9c3.3,0,6.1,2.7,6.1,6.1 c0,3.4-2.8,6.1-6.1,6.1v6.9c3.3,0,6.1,2.8,6.1,6.1c0,3.4-2.8,6.1-6.1,6.1V324h9.5C9.6,321.4,9.7,318.8,9.8,316.4z" />
                        </svg>
                    </figure>

                    <!-- Svg decoration -->
                    <figure class="position-absolute top-0 end-0 h-100 rotate-180 me-n2 me-sm-n1">
                        <svg class="h-100" viewBox="0 0 21 324" style="enable-background:new 0 0 21 324;">
                            <path class="fill-mode"
                                d="M9.8,316.4c1.1-26.8,2-53.4,1.9-80.2c-0.1-18.2-0.8-36.4-1.2-54.6c-0.2-8.9-0.2-17.7,0.8-26.6 c0.5-4.5,1.1-9,1.4-13.6c0.1-1.9,0.1-3.7,0.1-5.6c-0.2-0.2-0.6-1.5-0.2-3.1c-0.3-1.8-0.4-3.7-0.4-5.5c-1.2-3-1.8-6.3-1.7-9.6 c0.9-19,0.5-38.1,0.8-57.2c0.3-17.1,0.6-34.2,0.2-51.3c-0.1-0.6-0.1-1.2-0.1-1.7c0-0.8,0-1.6,0-2.4c0-0.5,0-1.1,0-1.6 c0-1.2,0-2.3,0.2-3.5H0v11.8c3.3,0,6.1,2.8,6.1,6.1c0,3.4-2.8,6.1-6.1,6.1V31c3.3,0,6.1,2.7,6.1,6.1S3.3,43.3,0,43.3v6.9 c3.3,0,6.1,2.8,6.1,6.1c0,3.4-2.8,6.1-6.1,6.1v6.9c3.3,0,6.1,2.8,6.1,6.1c0,3.4-2.8,6.1-6.1,6.1v6.9c3.3,0,6.1,2.8,6.1,6.1 s-2.8,6.1-6.1,6.1v6.9c3.3,0,6.1,2.8,6.1,6.1c0,3.4-2.8,6.1-6.1,6.1v6.9c3.3,0,6.1,2.8,6.1,6.1c0,3.4-2.8,6.1-6.1,6.1v6.9 c3.3,0,6.1,2.8,6.1,6.1c0,3.4-2.8,6.1-6.1,6.1v6.9c3.3,0,6.1,2.8,6.1,6.1c0,3.4-2.8,6.1-6.1,6.1v6.9c3.3,0,6.1,2.8,6.1,6.1 c0,3.4-2.8,6.1-6.1,6.1v6.9c3.3,0,6.1,2.7,6.1,6.1c0,3.4-2.8,6.1-6.1,6.1v6.9c3.3,0,6.1,2.8,6.1,6.1c0,3.4-2.8,6.1-6.1,6.1v6.9 c3.3,0,6.1,2.8,6.1,6.1c0,3.4-2.8,6.1-6.1,6.1v6.9c3.3,0,6.1,2.8,6.1,6.1c0,3.4-2.8,6.1-6.1,6.1v6.9c3.3,0,6.1,2.7,6.1,6.1 c0,3.4-2.8,6.1-6.1,6.1v6.9c3.3,0,6.1,2.8,6.1,6.1c0,3.4-2.8,6.1-6.1,6.1V324h9.5C9.6,321.4,9.7,318.8,9.8,316.4z" />
                        </svg>
                    </figure>

                    <div class="row g-4 position-relative">

                        <!-- Nav tabs START -->
                        <div class="col-lg-6">
                            <ul class="nav nav-pills nav-pills-dark" id="pills-tab" role="tablist">
                                <li class="nav-item bg-light rounded" role="presentation">
                                    <button class="nav-link rounded-start rounded-0 mb-0 active" id="pills-one-way-tab"
                                        data-bs-toggle="pill" data-bs-target="#pills-one-way" type="button" role="tab"
                                        aria-selected="true">One Way</button>
                                </li>
                                <li class="nav-item bg-light rounded" role="presentation">
                                    <button class="nav-link rounded-end rounded-0 mb-0" id="pills-round-trip-tab"
                                        data-bs-toggle="pill" data-bs-target="#pills-round-trip" type="button"
                                        role="tab" aria-selected="false">Round Trip</button>
                                </li>
                            </ul>
                        </div>

                        <div class="col-lg-6 d-flex justify-content-end">
                            <div class="form-check me-3">
                                <input class="form-check-input" type="checkbox" name="FlightType[]" value="direct"
                                    id="directFlight">
                                <label class="form-check-label" for="directFlight">Direct Flight</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="FlightType[]" value="onestop"
                                    id="oneStopFlight">
                                <label class="form-check-label" for="oneStopFlight">One Stop Flight</label>
                            </div>
                        </div>

                        <!-- Nav tabs END -->

                        <!-- Ticket class -->
                        <div class="col-lg-3 ms-auto">
                            <div class="form-control-bg-light form-fs-md">
                                <select class="form-select js-choice select" name="FlightCabinClass" id="FlightCabinClass"
                                    required>
                                    <option value="">Select Class</option>
                                    <option value="1">All Class</option>
                                    <option value="2" selected>Economy</option>
                                    <option value="3">Premium Economy</option>
                                    <option value="4">Business</option>
                                    <option value="5">Premium Business</option>
                                    <option value="6">First Class</option>
                                </select>
                            </div>
                        </div>

                        <!-- Ticket Travelers -->
                        <div class="col-lg-3 ms-auto">
                            <div class="form-control-bg-light form-fs-md">
                                <select class="form-select js-choice select" name="AdultCount" id="AdultCount" required>
                                    <option value="">Select Adult (18+ Yr)</option>
                                    <option value="1" selected>1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 ms-auto">
                            <div class="form-control-bg-light form-fs-md">
                                <select class="form-select js-choice select" name="ChildCount" id="ChildCount" required>
                                    <option value="">Select Child (2-18 Yr)</option>
                                    <option value="0" selected>0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 ms-auto">
                            <div class="form-control-bg-light form-fs-md">
                                <select class="form-select js-choice select" name="InfantCount" id="InfantCount" required>
                                    <option value="">Select Infant (0-2 Yr)</option>
                                    <option value="0" selected>0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>

                        <!-- Tab content START -->
                        <div class="tab-content mt-4" id="pills-tabContent">
                            <!-- One way tab START -->
                            <div class="tab-pane fade show active" id="pills-one-way" role="tabpanel"
                                aria-labelledby="pills-one-way-tab">
                                <div class="row g-3">
                                    <!-- Leaving From -->
                                    <div class="col-md-6 col-lg-4 position-relative">
                                        <div class="form-border-transparent form-fs-lg bg-light rounded-3 h-100 p-3">
                                            <!-- Input field -->
                                            <label class="mb-1 w-100"><i class="bi bi-geo-alt me-2"></i>Origin</label>
                                            <select class="form-select js-choice select" data-search-enabled="true"
                                                name="Origin" id="Origin">
                                                <option value="">Select location</option>
                                                @foreach ($cityList as $city)
                                                    <option value="{{ $city->airport_code }}">
                                                        {{ $city->airport_name }} -
                                                        {{ $city->airport_code }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>

                                        <!-- Auto fill button -->
                                        <div class="btn-flip-icon mt-3 mt-md-0">
                                            <button type="button" class="btn mb-0"><i
                                                    class="fa-solid fa-right-left"></i></button>
                                        </div>
                                    </div>

                                    <!-- Going To -->
                                    <div class="col-md-6 col-lg-4">
                                        <div class="form-border-transparent form-fs-lg bg-light rounded-3 h-100 p-3">
                                            <!-- Input field -->
                                            <label class="mb-1 w-100"><i class="bi bi-send me-2"></i>Destination</label>
                                            <select class="form-select js-choice select" data-search-enabled="true"
                                                id="Destination" name="Destination">
                                                <option value="">Select location</option>
                                                @foreach ($cityList as $city)
                                                    <option value="{{ $city->airport_code }}">
                                                        {{ $city->airport_name }} -
                                                        {{ $city->airport_code }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <input type="hidden" name="JourneyType" value="1">

                                    <!-- Departure -->
                                    <div class="col-lg-4">
                                        <div class="form-border-transparent form-fs-lg bg-light rounded-3 h-100 p-3">
                                            <label class="mb-1"><i class="bi bi-calendar me-2"></i>Departure</label>
                                            <input type="text" class="form-control flatpickr" data-date-format="Y-m-d"
                                                placeholder="Select date" name="PreferredDepartureTime"
                                                autocomplete="off" id="PreferredDepartureTime">
                                        </div>
                                    </div>

                                    <div class="col-12 text-end pt-0">
                                        <button type="submit" class="btn btn-primary mb-n4">Find Ticket <i
                                                class="bi bi-arrow-right ps-3"></i></button>
                                    </div>
                                </div>
                            </div>
                            <!-- One way tab END -->

                            <!-- Round way tab END -->
                            <div class="tab-pane fade" id="pills-round-trip" role="tabpanel"
                                aria-labelledby="pills-round-trip-tab">
                                <div class="row g-4">

                                    <!-- Leaving From -->
                                    <div class="col-md-6 col-xl-3 position-relative">
                                        <div class="form-border-transparent form-fs-lg bg-light rounded-3 h-100 p-3">
                                            <!-- Input field -->
                                            <label class="mb-1 w-100"><i class="bi bi-geo-alt me-2"></i>Origin</label>
                                            <select class="form-select js-choice select w-100" data-search-enabled="true"
                                                name="Origin" id="roundOrigin">
                                                <option value="">Select location</option>

                                                {{-- <option value="DEL" selected>DEL</option> --}}
                                                @foreach ($cityList as $city)
                                                    <option value="{{ $city->airport_code }}">
                                                        {{ $city->airport_name }} -
                                                        {{ $city->airport_code }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Auto fill button -->
                                        <div class="btn-flip-icon mt-3 mt-md-0">
                                            <button type="button" class="btn mb-0"><i
                                                    class="fa-solid fa-right-left"></i></button>
                                        </div>
                                    </div>

                                    <!-- Going To -->
                                    <div class="col-md-6 col-xl-3">
                                        <div class="form-border-transparent form-fs-lg bg-light rounded-3 h-100 p-3">
                                            <!-- Input field -->
                                            <label class="mb-1 w-100"><i class="bi bi-send me-2"></i>Destination</label>
                                            <select class="form-select js-choice select w-100" data-search-enabled="true"
                                                id="roundDestination" name="Destination">
                                                <option value="">Select location</option>
                                                {{-- <option value="CCU" selected>CCU</option> --}}
                                                @foreach ($cityList as $city)
                                                    <option value="{{ $city->airport_code }}">
                                                        {{ $city->airport_name }} -
                                                        {{ $city->airport_code }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <!-- Departure -->
                                    <div class="col-md-6 col-xl-3">
                                        <div class="form-border-transparent form-fs-lg bg-light rounded-3 h-100 p-3">
                                            <label class="mb-1"><i class="bi bi-calendar me-2"></i>Departure</label>
                                            <input type="text" class="form-control flatpickr"
                                                name="PreferredDepartureTime" id="roundDeparture" autocomplete="off"
                                                data-date-format="Y-m-d" placeholder="Select date">
                                        </div>
                                    </div>

                                    <!-- Return -->
                                    <div class="col-md-6 col-xl-3">
                                        <div class="form-border-transparent form-fs-lg bg-light rounded-3 h-100 p-3">
                                            <label class="mb-1"><i class="bi bi-calendar me-2"></i>Return</label>
                                            <input type="text" class="form-control flatpickr" id="roundReturn"
                                                name="PreferredArrivalTime" data-date-format="Y-m-d" autocomplete="off"
                                                placeholder="Select date">
                                        </div>
                                    </div>

                                    <input type="hidden" name="JourneyType" value="2">

                                    <div class="col-12 text-end pt-0">
                                        <button type="submit" class="btn btn-primary mb-n4">Find Ticket <i
                                                class="bi bi-arrow-right ps-3"></i></button>
                                    </div>
                                </div>
                            </div>
                            <!-- Round way tab END -->
                        </div>
                        <!-- Tab content END -->
                    </div>
                </form>




                <!-- Booking from END -->
            </div>
        </section>

        <section class="all_flight_list d-none mt-3">

            <div class="row">

                <!-- Left sidebar START -->
                <aside class="col-xl-4 col-xxl-3">
                    <!-- Responsive offcanvas body START -->
                    <div class="offcanvas-xl offcanvas-end" tabindex="-1" id="offcanvasSidebar"
                        aria-labelledby="offcanvasSidebarLabel">
                        <!-- Offcanvas header -->
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasSidebarLabel">Advance Filters</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                data-bs-target="#offcanvasSidebar" aria-label="Close"></button>
                        </div>

                        <!-- Offcanvas body -->
                        <div class="offcanvas-body flex-column p-3 p-xl-0">
                            <form class="rounded-3 shadow">
                                <!-- Popular filters START -->
                                <div class="card card-body rounded-0 rounded-top p-4">
                                    <!-- Title -->
                                    <h6 class="mb-2">Popular Filters</h6>
                                    <!-- Popular filters group -->
                                    <div class="col-12">
                                        <!-- Checkbox -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="popolarType1">
                                                <label class="form-check-label" for="popolarType1">Refundable
                                                    Fare</label>
                                            </div>
                                            <span class="small">(41)</span>
                                        </div>
                                        <!-- Checkbox -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="popolarType2">
                                                <label class="form-check-label" for="popolarType2">1 Stop</label>
                                            </div>
                                            <span class="small">(20)</span>
                                        </div>
                                        <!-- Checkbox -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="popolarType3">
                                                <label class="form-check-label" for="popolarType3">Late
                                                    Departure</label>
                                            </div>
                                            <span class="small">(4)</span>
                                        </div>
                                        <!-- Checkbox -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="popolarType4">
                                                <label class="form-check-label" for="popolarType4">Non-Stop</label>
                                            </div>
                                            <span class="small">(2)</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Popular filters END -->

                                <hr class="my-0"> <!-- Divider -->

                                <!-- Price START -->
                                <div class="card card-body rounded-0 p-4">
                                    <!-- Title -->
                                    <h6 class="mb-2">Price</h6>
                                    <!-- Price group -->
                                    {{-- <div class="position-relative">
                                            <div class="noui-wrapper">
                                                <div class="d-flex justify-content-between">
                                                    <input type="range" class="text-body w-100 input-with-range-min" min="0" max="1000"
                                                        value="100" id="priceRangeMin">
                                                </div>
                                                
                                            </div>
                                        </div> --}}
                                    <div id="price-slider"></div>

                                    <div class="d-flex justify-content-between mt-2">
                                        <div>
                                            Min Price: <span id="min-price" class="fw-bold"></span>
                                        </div>
                                        <div>
                                            Max Price: <span id="max-price" class="fw-bold"></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Price END -->

                                <hr class="my-0"> <!-- Divider -->

                                <!-- Onward stops START -->
                                <div class="card card-body rounded-0 p-4">
                                    <!-- Title -->
                                    <h6 class="mb-2">Onward Stops</h6>
                                    <!-- Onward stops group -->
                                    <ul class="list-inline mb-0 g-3">
                                        <!-- Item -->
                                        <li class="list-inline-item mb-0">
                                            <input type="checkbox" class="btn-check" id="btn-check-c1">
                                            <label class="btn btn-sm btn-light btn-primary-soft-check"
                                                for="btn-check-c1">Direct</label>
                                        </li>
                                        <!-- Item -->
                                        <li class="list-inline-item mb-0">
                                            <input type="checkbox" class="btn-check" id="btn-check-c2">
                                            <label class="btn btn-sm btn-light btn-primary-soft-check"
                                                for="btn-check-c2">1 Stop</label>
                                        </li>
                                        <!-- Item -->
                                        <li class="list-inline-item mb-0">
                                            <input type="checkbox" class="btn-check" id="btn-check-c3">
                                            <label class="btn btn-sm btn-light btn-primary-soft-check"
                                                for="btn-check-c3">2+ Stops</label>
                                        </li>
                                    </ul>
                                </div>
                                <!-- Onward stops END -->

                                <hr class="my-0"> <!-- Divider -->

                                <!-- Return Stops START -->
                                <div class="card card-body rounded-0 p-4">
                                    <!-- Title -->
                                    <h6 class="mb-2">Return Stops</h6>
                                    <!-- Return Stops group -->
                                    <ul class="list-inline mb-0 g-3">
                                        <!-- Item -->
                                        <li class="list-inline-item mb-0">
                                            <input type="checkbox" class="btn-check" id="btn-check-6">
                                            <label class="btn btn-sm btn-light btn-primary-soft-check"
                                                for="btn-check-6">Direct</label>
                                        </li>
                                        <!-- Item -->
                                        <li class="list-inline-item mb-0">
                                            <input type="checkbox" class="btn-check" id="btn-check-7">
                                            <label class="btn btn-sm btn-light btn-primary-soft-check" for="btn-check-7">1
                                                Stop</label>
                                        </li>
                                        <!-- Item -->
                                        <li class="list-inline-item mb-0">
                                            <input type="checkbox" class="btn-check" id="btn-check-8">
                                            <label class="btn btn-sm btn-light btn-primary-soft-check"
                                                for="btn-check-8">2+ Stops</label>
                                        </li>
                                    </ul>
                                </div>
                                <!-- Return Stops END -->

                                <hr class="my-0"> <!-- Divider -->

                                <!-- Preferred Airline START -->
                                <div class="card card-body rounded-0 p-4">
                                    <!-- Title -->
                                    <h6 class="mb-2">Preferred Airline</h6>
                                    <!-- Preferred Airline group -->
                                    <div class="col-12">
                                        <!-- Checkbox -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="airlineType1">
                                            <label class="form-check-label" for="airlineType1">
                                                <img src="{{ asset('images/12.svg') }}" class="h-15px fa-fw me-2"
                                                    alt="">Blogzine
                                            </label>
                                        </div>
                                        <!-- Checkbox -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="airlineType2">
                                            <label class="form-check-label" for="airlineType2">
                                                <img src="{{ asset('images/13.svg') }}" class="h-15px fa-fw me-2"
                                                    alt="">Wizixo
                                            </label>
                                        </div>
                                        <!-- Checkbox -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="airlineType3">
                                            <label class="form-check-label" for="airlineType3">
                                                <img src="{{ asset('images/14.svg') }}" class="h-15px fa-fw me-2"
                                                    alt="">Folio airline
                                            </label>
                                        </div>
                                        <!-- Checkbox -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="airlineType4">
                                            <label class="form-check-label" for="airlineType4">
                                                <img src="{{ asset('images/15.svg') }}" class="h-15px fa-fw me-2"
                                                    alt="">Booking
                                            </label>
                                        </div>

                                        <!-- Collapse body -->
                                        <div class="multi-collapse collapse" id="airlineCollapes">
                                            <!-- Checkbox -->
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="airlineType7">
                                                <label class="form-check-label" for="airlineType7">
                                                    <img src="{{ asset('images/15.svg') }}" class="h-15px fa-fw me-2"
                                                        alt="">Formex
                                                </label>
                                            </div>
                                            <!-- Checkbox -->
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="airlineType8">
                                                <label class="form-check-label" for="airlineType8">
                                                    <img src="{{ asset('images/13.svg') }}" class="h-15px fa-fw me-2"
                                                        alt="">Realty
                                                </label>
                                            </div>
                                            <!-- Checkbox -->
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="airlineType9">
                                                <label class="form-check-label" for="airlineType9">
                                                    <img src="{{ asset('images/12.svg') }}" class="h-15px fa-fw me-2"
                                                        alt="">rocyon
                                                </label>
                                            </div>
                                        </div>
                                        <!-- Collapse button -->
                                        <a class="p-0 mb-0 mt-2 btn-more d-flex align-items-center collapsed"
                                            data-bs-toggle="collapse" href="#airlineCollapes" role="button"
                                            aria-expanded="false" aria-controls="airlineCollapes">
                                            See <span class="see-more ms-1">more</span><span
                                                class="see-less ms-1">less</span><i
                                                class="fa-solid fa-angle-down ms-2"></i>
                                        </a>
                                    </div>
                                </div>
                                <!-- Preferred Airline END -->

                                <hr class="my-0"> <!-- Divider -->

                                <!-- Layover Airport START -->
                                <div class="card card-body rounded-0 rounded-bottom p-4">
                                    <!-- Title -->
                                    <h6 class="mb-2">Layover Airport</h6>
                                    <!-- Layover Airport group -->
                                    <div class="col-12">
                                        <!-- Checkbox -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="lauoverType1">
                                                <label class="form-check-label" for="lauoverType1">Abu Dhabi</label>
                                            </div>
                                            <span class="small">(01)</span>
                                        </div>
                                        <!-- Checkbox -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="lauoverType2">
                                                <label class="form-check-label" for="lauoverType2">Amsterdam</label>
                                            </div>
                                            <span class="small">(02)</span>
                                        </div>
                                        <!-- Checkbox -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="lauoverType3">
                                                <label class="form-check-label" for="lauoverType3">Chicago</label>
                                            </div>
                                            <span class="small">(02)</span>
                                        </div>
                                        <!-- Checkbox -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="lauoverType4">
                                                <label class="form-check-label" for="lauoverType4">Doha</label>
                                            </div>
                                            <span class="small">(03)</span>
                                        </div>

                                        <!-- Collapse body -->
                                        <div class="multi-collapse collapse" id="lauoverCollapes">
                                            <!-- Checkbox -->
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="lauoverType7">
                                                    <label class="form-check-label" for="lauoverType7">Dubai</label>
                                                </div>
                                                <span class="small">(04)</span>
                                            </div>
                                            <!-- Checkbox -->
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="lauoverType8">
                                                    <label class="form-check-label" for="lauoverType8">New
                                                        Delhi</label>
                                                </div>
                                                <span class="small">(15)</span>
                                            </div>
                                            <!-- Checkbox -->
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="lauoverType9">
                                                    <label class="form-check-label" for="lauoverType9">Paris</label>
                                                </div>
                                                <span class="small">(04)</span>
                                            </div>
                                        </div>
                                        <!-- Collapse button -->
                                        <a class="btn-more d-flex align-items-center collapsed p-0 mb-0 mt-2"
                                            data-bs-toggle="collapse" href="#lauoverCollapes" role="button"
                                            aria-expanded="false" aria-controls="lauoverCollapes">
                                            See <span class="see-more ms-1">more</span><span
                                                class="see-less ms-1">less</span><i
                                                class="fa-solid fa-angle-down ms-2"></i>
                                        </a>
                                    </div>
                                </div>
                                <!-- Layover Airport END -->
                            </form><!-- Form End -->
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between p-2 p-xl-0 mt-xl-4">
                            <button class="btn btn-link p-0 mb-0">Clear all</button>
                            <button class="btn btn-primary mb-0">Filter Result</button>
                        </div>

                    </div>
                    <!-- Responsive offcanvas body END -->
                </aside>
                <!-- Left sidebar END -->

                <!-- Main content START -->
                <div class="col-xl-8 col-xxl-9">
                    <ul class="nav nav-tabs mb-3 d-none w-100" id="roundTabs">
                        <li class="nav-item w-50 rounded">
                            <button class="nav-link active w-100" id="tabDeparture">Departure</button>
                        </li>
                        <li class="nav-item w-50 rounded">
                            <button class="nav-link w-100" id="tabReturn">Return</button>
                        </li>
                    </ul>

                    <div class="vstack gap-4" id="search_flight_list">

                    </div>
                </div>
                <!-- Main content END -->
            </div> <!-- Row END -->

        </section>

    </main>




    <div class="modal fade" id="flightdetail" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">✈️ Flight Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-pills nav-justified bg-opacity-10 rounded p-2 mb-3 border bg-light">
                        <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill"
                                data-bs-target="#info-tab">Flight Info</button></li>
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="pill"
                                data-bs-target="#fare-tab">Fare Detail</button></li>
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="pill"
                                data-bs-target="#baggage-tab">Baggage Rules</button></li>
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="pill"
                                data-bs-target="#policy-tab">Cancellation Policy</button></li>
                    </ul>

                    <div class="tab-content pt-0 mt-0">
                        <div class="tab-pane fade show active" id="info-tab"></div>
                        <div class="tab-pane fade" id="fare-tab">
                            <div class="card card-body border">
                                <h6>Base Fare: ₹10,000</h6>
                                <h6>Taxes: ₹500</h6>
                                <h5>Total: ₹10,500</h5>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="baggage-tab">
                            <div class="card card-body border">
                                <p>Cabin: 7kg | Check-in: 15kg</p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="policy-tab">
                            <div class="card card-body border">
                                <p>Non-refundable within 24 hours of departure.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="back-top"></div>
@endsection


@push('script')
    <script src="{{ asset('') }}js/flight.js"></script>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css"> --}}

    {{-- <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script> --}}

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.4/nouislider.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.4/nouislider.min.js"></script>


    <script>
        $(document).ready(function() {
            localStorage.clear();
            $('.select').select2();

            $('.flatpickr').datepicker({
                'autoclose': true,
                'clearBtn': true,
                'todayHighlight': true,
                'format': 'yyyy-mm-dd',
                'startDate': new Date()
            });

            var priceSlider = document.getElementById('price-slider');

            // Create slider
            noUiSlider.create(priceSlider, {
                start: [100, 900], // Default values
                connect: true,
                step: 10,
                range: {
                    'min': 0,
                    'max': 2000
                }
            });

            // Update on slide
            priceSlider.noUiSlider.on('update', function(values) {
                $('#min-price').text(Math.floor(values[0]));
                $('#max-price').text(Math.floor(values[1]));
            });
        });
    </script>
@endpush
