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
        .loader {
            position: absolute;
            right: 10px;
            top: 50%;
            width: 16px;
            height: 16px;
            border: 2px solid #ccc;
            border-top: 2px solid #007bff;
            border-radius: 50%;
            transform: translateY(-50%);
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg) translateY(-50%);
            }
        }

        .select2-container {
            width: 100% !important;
        }

        body {
            overflow-x: hidden !important;
        }

        .select2-dropdown {
            overflow-x: hidden !important;
        }

        .select2-results__options {
            overflow-x: hidden !important;
        }

        .select2-results__option {
            white-space: normal !important;
            word-break: break-word;
        }

        .select2-results__options {
            max-height: 200px;
            overflow-y: auto;
        }

        .select2-dropdown {
            overflow-x: hidden !important;
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

            <form method="post" class="bg-mode bg-white position-relative px-3 px-sm-4 py-4 mb-4 mb-sm-0">
                @csrf


                <div class="row g-3 position-relative">

                    <div class="col-md-3">

                        <div class="form-control-border form-control-transparent form-fs-md d-flex">

                            <div class="flex-grow-1">
                                <label class="mb-1"> <i class="ti ti-map fs-5"></i> Country</label>
                                <select class="form-select  select" data-search-enabled="true" name="countryCode"
                                    id="countryCode" required>
                                    <option value="">Select location</option>
                                    {{-- <option value="IN" selected>India</option> --}}

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">

                        <div class="form-control-border form-control-transparent form-fs-md d-flex">

                            <div class="flex-grow-1">
                                <label class="mb-1"><i class="ti ti-map fs-5"></i> City</label>
                                <select class="form-select  select" data-search-enabled="true" name="cityCode"
                                    id="cityCode" required>
                                    <option value="">Select City</option>
                                    {{-- <option value="126666" selected>Kumarakom</option> --}}

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">

                        <div class="form-control-border form-control-transparent form-fs-md d-flex">

                            <div class="flex-grow-1">
                                <label class="mb-1"><i class="ti ti-building fs-5"></i> Hotel List</label>
                                <select class="form-select  select" data-search-enabled="true" name="hotelCode"
                                    id="hotelCode" required>
                                    <option value="">Select Hotel List</option>
                                    {{-- <option value="1279415" selected>Testing Hotel (Lucknow)</option> --}}

                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Checkin Checkout -->
                    <div class="col-md-4 mt-3">


                        <label>Check-In</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt fs-6"></i>
                            </span>
                            <input id="checkin" name="chkInDate" type="text" class="form-control" required=""
                                placeholder="Check In Date">
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">


                        <label>Check-Out</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt fs-6"></i>
                            </span>
                            <input id="checkout" value="" name="chkOutDate" type="text" class="form-control"
                                required="" placeholder="Check Out Date">
                        </div>
                    </div>

                    <!-- Guest & Rooms -->
                    <div class="col-md-4 mt-3">
                        <label class="mb-1"> <i class="ti ti-user fs-5 fw-bold"></i> Guests & Rooms</label>

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
                                        <small>(18+ years)</small>
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
                                        <small>(Below 18 yr)</small>
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


                </div>
                <div class="text-end mt-3">
                    <button class="btn btn-primary" type="button" id="searchhotel" onclick="searchHotel()"><i
                            class="ti ti-search fs-6"></i>Find Hotel</button>
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

    <div class="modal fade" id="cancelPolicyModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Cancellation Policy</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" id="cancelPolicyBody">
                    <!-- Dynamic Table -->
                </div>

            </div>
        </div>
    </div>

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

            $('#cityCode').prop('disabled', true);
            $('#hotelCode').prop('disabled', true);

            $('#countryCode').select2({
                placeholder: 'Type at least 2 characters',
                minimumInputLength: 2,
                ajax: {
                    url: "/hotel/search-country",
                    dataType: 'json',
                    delay: 300,
                    data: function(params) {
                        return {
                            query: params.term
                        };
                    },
                    processResults: function(data, params) {
                        let searchTerm = (params.term || '').toLowerCase();
                        let countrylist = data?.data?.CountryList || [];

                        let filtered = countrylist.filter(function(item) {
                            return item.Name.toLowerCase().includes(searchTerm) ||
                                item.Code.toLowerCase().includes(searchTerm);
                        });

                        return {
                            results: $.map(filtered, function(item) {
                                return {
                                    id: item.Code,
                                    text: item.Name + ' (' + item.Code + ')'
                                };
                            })
                        };
                    },
                    cache: true
                }
            });

            $('#countryCode').on('change', function() {
                $('#cityCode').prop('disabled', false);
                let countryCode = $(this).val();

                // reset city & hotel
                $('#cityCode').val(null).trigger('change');
                $('#hotelCode').val(null).trigger('change');

                $('#cityCode').select2({
                    placeholder: 'Type at least 3 characters',
                    minimumInputLength: 3,
                    placeholder: 'Search City',
                    ajax: {
                        url: "/hotel/search-city",
                        dataType: 'json',
                        delay: 300,
                        beforeSend: function() {
                            $('#cityCode').siblings('.select2-container').append(
                                '<span class="loader"></span>');
                        },
                        complete: function() {
                            $('.loader').remove();
                        },
                        data: function(params) {
                            return {
                                countryCode: countryCode
                            };
                        },
                        processResults: function(data, params) {
                            let searchTerm = (params.term || '').toLowerCase();

                            let citylist = data?.data?.CityList || [];

                            let filtered = citylist.filter(function(item) {
                                return item.Name.toLowerCase().includes(searchTerm) ||
                                    item.Code.toLowerCase().includes(searchTerm);
                            });

                            return {
                                results: $.map(filtered, function(item) {
                                    return {
                                        id: item.Code,
                                        text: item.Name + ' (' + item.Code + ')'
                                    };
                                })
                            };
                        },
                        cache: true
                    }
                });

            });

            $('#cityCode').on('change', function() {
                $('#hotelCode').prop('disabled', false);
                let cityCode = $(this).val();

                // reset hotel
                $('#hotelCode').val(null).trigger('change');

                $('#hotelCode').select2({
                    placeholder: 'Search Hotel',
                    ajax: {
                        url: "/hotel/search-hotelName",
                        dataType: 'json',
                        delay: 300,
                        beforeSend: function() {
                            $('#hotelCode').siblings('.select2-container').append(
                                '<span class="loader"></span>');
                        },
                        complete: function() {
                            $('.loader').remove();
                        },
                        data: function(params) {
                            return {
                                query: params.term,
                                cityCode: cityCode
                            };
                        },
                        processResults: function(data, params) {

                            let searchTerm = (params.term || '').toLowerCase();

                            let hotellist = data?.data?.Hotels || [];

                            let filtered = hotellist.filter(function(item) {
                                return item.HotelName.toLowerCase().includes(
                                    searchTerm) ||
                                    item.HotelCode.toLowerCase().includes(searchTerm);
                            });
                            return {
                                results: $.map(filtered, function(item) {
                                    return {
                                        id: item.HotelCode,
                                        text: item.HotelName + ' (' + item.HotelCode +
                                            ')'
                                    };
                                })
                            };
                        },
                        cache: true
                    }
                });

            });
        });
    </script>
@endpush
