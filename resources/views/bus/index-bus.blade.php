@extends('layouts.app')
@section('title', 'Bus Booking Search')
@section('pagetitle', 'Bus Booking Search')


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


        .select2-container--default {
            width: 100% !important;
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
    <section class="pb-2">
        <div class="card border-1">
            <div class="card-header bg-label-primary">
                <h5 class="card-title mb-0">🚌 Bus Booking Search</h5>
            </div>

            <form {{-- style="background-image: url('{{ asset('images/1.png') }}'); background-position: center center; background-repeat: no-repeat; background-size: cover;" --}} id="busSearchForm"
                class="bg-mode bg-white position-relative px-3 px-sm-4 pt-4 mb-4 mb-sm-0">
                @csrf

                <div class="row g-4 position-relative">

                    <div class="col-lg-4">
                        <div class="form-control-border form-control-transparent form-fs-md d-flex">

                            <div class="flex-grow-1">
                                <label class="mb-1"> <i class="ti ti-location fs-6 text-primary"></i> Departure</label>
                                <select class="form-select select w-100" data-search-enabled="true" name="Departure"
                                    id="DepartureId" required>
                                    <option value="">Select location</option>

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-control-border form-control-transparent form-fs-md d-flex">

                            <div class="flex-grow-1">
                                <label class="mb-1"> <i class="ti ti-location fs-6 text-success"></i> Destination</label>
                                <select class="form-select  select w-100" data-search-enabled="true" name="Destination"
                                    id="DestinationId" required>
                                    <option value="">Select location</option>

                                </select>
                            </div>
                        </div>
                    </div>



                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="mb-1">
                                Journey Date
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="ti ti-calendar text-info"></i>
                                </span>

                                <input type="text" class="form-control flatpickr" data-date-format="Y-m-d"
                                    placeholder="Select date" name="JourneyDate" id="JourneyDate" autocomplete="off"
                                    required>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="Currency" id="Currency" value="INR" required>
                    <input type="hidden" name="BookingMode" id="BookingMode" value="5" required>

                    <div class="text-end mb-3">
                        <button type="submit" class="btn btn-primary">
                            Search Buses
                        </button>
                    </div>
            </form>
        </div>

    </section>

    <section class="pt-2 d-none" id="busContainerList">
        <div class="row">

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
                        <form class="rounded-3 shadow-sm">
                            <!-- Popular filters START -->
                            <div class="card card-body rounded-0 rounded-top p-4">
                                <h6 class="mb-2">Popular Filters</h6>
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="refundableFare">
                                            <label class="form-check-label" for="refundableFare">Refundable</label>
                                        </div>
                                        <span class="small">(10)</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="mTicket">
                                            <label class="form-check-label" for="mTicket">E-Ticket Available</label>
                                        </div>
                                        <span class="small">(15)</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Popular filters END -->

                            <hr class="my-0">

                            <!-- Price START -->
                            <div class="card card-body rounded-0 p-4">
                                <!-- Title -->
                                <h6 class="mb-2">Price</h6>
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

                            <hr class="my-0">

                            <!-- Bus Type START -->
                            <div class="card card-body rounded-0 p-4">
                                <h6 class="mb-2">Bus Type</h6>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="volvoAC">
                                        <label class="form-check-label" for="volvoAC">Volvo A/C Seater/Sleeper</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="nonAC">
                                        <label class="form-check-label" for="nonAC">Non-AC</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="sleeper">
                                        <label class="form-check-label" for="sleeper">Sleeper</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Bus Type END -->

                            <hr class="my-0">

                            <!-- Boarding Point START -->
                            <div class="card card-body rounded-0 p-4">
                                <h6 class="mb-2">Boarding Point</h6>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gomtiNagar">
                                        <label class="form-check-label" for="gomtiNagar">Gomti Nagar, Lucknow</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="phoenixMall">
                                        <label class="form-check-label" for="phoenixMall">Phoenix Mall, Lucknow</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Boarding Point END -->

                            <hr class="my-0">

                            <!-- Dropping Point START -->
                            <div class="card card-body rounded-0 rounded-bottom p-4">
                                <h6 class="mb-2">Dropping Point</h6>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="allahabadBusStand">
                                        <label class="form-check-label" for="allahabadBusStand">Bus Stand,
                                            Allahabad</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Dropping Point END -->

                        </form>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between p-2 p-xl-0 mt-xl-4">
                        <button class="btn btn-secondary mb-0">Clear all</button>
                        <button class="btn btn-primary mb-0">Filter Result</button>
                    </div>
                </div>
                <!-- Responsive offcanvas body END -->
            </aside>

            <div class="col-8">
                <div id="busResults" class="row g-4">
                </div>
            </div>
        </div>

    </section>
    <div class="back-top"></div>

@endsection


@push('script')
    <script src="{{ asset('') }}js/bustrip.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.4/nouislider.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.4/nouislider.min.js"></script>


    <script>
        $(document).ready(function() {
            localStorage.clear();
            // $('.select').select2();

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


            $('#DepartureId, #DestinationId').select2({
                placeholder: 'Type at least 3 characters',
                minimumInputLength: 3,
                ajax: {
                    url: "{{ route('bus.search.city') }}",
                    dataType: 'json',
                    delay: 300,
                    data: function(params) {
                        return {
                            query: params.term
                        };
                    },
                    processResults: function(response, params) {

                        let keyword = params.term.trim().toLowerCase();

                        let exact = [];
                        let startsWith = [];
                        let contains = [];

                        response.data.forEach(function(item) {
                            let city = item.CityName.trim().toLowerCase();

                            if (city === keyword) {
                                exact.push(item);
                            } else if (city.startsWith(keyword)) {
                                startsWith.push(item);
                            } else if (city.includes(keyword)) {
                                contains.push(item);
                            }
                        });

                        // 🔥 exact → startsWith → contains
                        let finalList = [...exact, ...startsWith, ...contains].slice(0, 20);

                        return {
                            results: finalList.map(function(item) {
                                return {
                                    id: item.CityId,
                                    text: item.CityName.trim()
                                };
                            })
                        };
                    },
                    cache: true
                }
            });

        });
    </script>
@endpush
