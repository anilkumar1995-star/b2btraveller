@extends('layouts.app')
@section('title', 'Hotel Booking Search')
@section('pagetitle', 'Hotel Booking Search')


@section('content')

    <style>
        .fare-breakdown-container-hotel {
            width: 20%;
            position: absolute;
            top: 100;
            right: 0;
            z-index: 10;
            display: none;
        }

        .tooltip-inner ul {
            list-style-type: disc !important;
            padding-left: 20px !important;
            margin: 10px 0 0 0 !important;
        }

        .tooltip-inner li {
            text-align: left !important;
        }

        .tooltip-inner {
            background: #ffffff;
            color: #b2b2b2;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
        }

        .bs-tooltip-bottom .tooltip-arrow::before {
            border-bottom-color: #ffffff !important;
        }
    </style>


    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 2px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background-color: transparent;
        }

        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #c0c1c3 transparent;
        }
    </style>

    <section class="py-0">
        <div class="card border-1">
            <div class="card-header bg-label-primary">
                <h5 class="card-title mb-0">🏨 Find the top Hotels nearby.</h5>
            </div>

            <form method="post" class="bg-mode bg-white position-relative px-3 px-sm-4 pt-4 mb-4 mb-sm-0">
                @csrf


                <div class="row g-4 position-relative">

                    <div class="col-lg-4">

                        <div class="form-control-border form-control-transparent form-fs-md d-flex">
                            <i class="ti ti-geo-alt fs-3 me-2 mt-2"></i>
                            <div class="flex-grow-1">
                                <label>Location</label>
                                <select class="form-select  select" data-search-enabled="true" name="cityName"
                                    id="cityName">
                                    <option value="">Select location</option>
                                    <option value="130443" selected>Testing City / Hotel</option>

                                </select>
                            </div>
                        </div>
                    </div>


                    <!-- Checkin Checkout -->
                    <div class="col-lg-4">


                        <label>Check-In / Check-Out</label>
                        <div class="input-group">
                            <input id="checkin" name="chkInDate" type="text" class="form-control" required=""
                                placeholder="Check In Date">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                            <input id="checkout" value="" name="chkOutDate" type="text" class="form-control"
                                required="" placeholder="Check Out Date">
                        </div>
                    </div>

                    <!-- Guest & Rooms -->
                    <div class="col-lg-4">
                        <label class="form-label fw-semibold">Guests & Rooms</label>

                        <div class="dropdown travellers-class" onclick="totalRoomsAndGuest()">
                            <input type="text" id="guestAndRooms"
                                class="form-control selection-result travellers-class-input" data-bs-auto-close="outside"
                                data-bs-toggle="dropdown" name="flight-travellers-class" placeholder="Room, Guests"
                                readonly="" required="" value="1 Rooms / 1 Guests" onkeypress="return false;">

                            <ul class="dropdown-menu p-3 w-100 travellers-dropdown" style="height: 265px;overflow-y: auto;">

                                <!-- Rooms -->
                                <li class="d-flex justify-content-between">
                                    <div>
                                        <strong>Rooms</strong><br>
                                        <small>(Max 6 rooms)</small>
                                    </div>

                                    <div class="d-flex align-items-center gap-2">
                                        <button type="button" class="btn btn-sm btn-light"
                                            onClick="decrement3()">-</button>
                                        <span id="room" name="room">1</span>
                                        <button type="button" class="btn btn-sm btn-light"
                                            onClick="increment3()">+</button>
                                    </div>
                                </li>

                                <!-- Adults -->
                                <li class="d-flex justify-content-between mb-2">
                                    <div>
                                        <strong>Adults</strong><br>
                                        <small>(13+ years)</small>
                                    </div>

                                    <div class="d-flex align-items-center gap-2">
                                        <button type="button" class="btn btn-sm btn-light"
                                            onClick="decrement1()">-</button>
                                        <span id="adult" name="adultCount">2</span>
                                        <button type="button" class="btn btn-sm btn-light"
                                            onClick="increment1()">+</button>
                                    </div>
                                </li>

                                <!-- Child -->
                                <li class="d-flex justify-content-between mb-2">
                                    <div>
                                        <strong>Children</strong><br>
                                        <small>(Below 13)</small>
                                    </div>

                                    <div class="d-flex align-items-center gap-2">
                                        <button type="button" class="btn btn-sm btn-light"
                                            onClick="decrement2()">-</button>
                                        <span class="child" id="children" name="childCount">0</span>
                                        <button type="button" class="btn btn-sm btn-light"
                                            onClick="increment2()">+</button>
                                    </div>
                                </li>

                                <div class="row align-items-center">
                                    <div class="col-sm-12">
                                        <div id="child-age-container">
                                        </div>
                                    </div>

                                </div>

                                <div class="d-grid">
                                    <button class="btn btn-primary submit-done" type="button">Done</button>
                                </div>

                            </ul>
                        </div>
                    </div>

                    <div class="text-end mb-3">
                        <button class="btn btn-primary" type="button" id="searchhotel"
                            onclick="searchHotel()">Search</button>
                    </div>
            </form>


        </div>
    </section>

    <div class="wrapper">
        <div class="row mt-3" style="position: relative;">
            {{-- <div class="col-3">
                <div class="preview-card-side" style="position: sticky;top: 
                0px;">

                </div>
            </div> --}}
            <div class="col-12">
                <div class="preview-card-body">

                </div>
            </div>
        </div>
    </div>

    <div class="back-top"></div>

@endsection


@push('script')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.4/nouislider.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.4/nouislider.min.js"></script>

    <script src="{{ asset('') }}js/hotel.js"></script>
    <script src="{{ asset('') }}js/inputFormValidation.js"></script>
    <script>
        $(document).ready(function() {
            localStorage.clear();

            $('#cityName').select2({
                placeholder: 'Type at least 3 characters',
                minimumInputLength: 3,
                ajax: {
                    url: "/hotel/search-city",
                    dataType: 'json',
                    delay: 300,
                    data: function(params) {
                        return {
                            query: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.airport_code,
                                    text: item.airport_name + ' - ' + item.airport_code + ' (' +
                                        item.city + ')',
                                    country_code: item.country_code,
                                    country_name: item.country_name
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
