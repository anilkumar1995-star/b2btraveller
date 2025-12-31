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
    <section class="py-0">
        <div class="card border-1">
            <div class="card-header bg-label-primary">
                <h5 class="card-title mb-0">🚌 Bus Booking Search</h5>
            </div>

            <form {{-- style="background-image: url('{{ asset('images/1.png') }}'); background-position: center center; background-repeat: no-repeat; background-size: cover;" --}} id="busSearchForm"
                class="bg-mode bg-white position-relative px-3 px-sm-4 pt-4 mb-4 mb-sm-0">
                @csrf


                <div class="row g-4 position-relative">

                    <div class="col-lg-6">
                        <div class="form-control-border form-control-transparent form-fs-md d-flex">

                            <div class="flex-grow-1">
                                <label class="mb-1"> <i class="ti ti-location fs-6 text-primary"></i> Departure</label>
                                <select class="form-select select w-100" data-search-enabled="true" name="Departure"
                                    id="DepartureId">
                                    <option value="">Select location</option>

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-control-border form-control-transparent form-fs-md d-flex">

                            <div class="flex-grow-1">
                                <label class="mb-1"> <i class="ti ti-location fs-6 text-success"></i> Destination</label>
                                <select class="form-select  select w-100" data-search-enabled="true" name="Destination"
                                    id="DestinationId">
                                    <option value="">Select location</option>

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="flex-grow-1">
                            <label class="mb-1"> <i class="ti ti-calendar fs-6 text-info"></i>Journey Date</label>
                            <input type="text" class="form-control flatpickr" data-date-format="d/m/Y"
                                placeholder="Select date" name="JourneyDate" id="JourneyDate" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <label class="mb-1"><i class="ti ti-calendar fs-6 text-danger"></i>Return Date (Optional)</label>
                        <input type="text" class="form-control flatpickr" data-date-format="Y-m-d" autocomplete="off"
                            placeholder="Select date" name="ReturnJourneyDate" id="ReturnJourneyDate">

                    </div>

                    <div class="col-lg-4">
                        <label class="w-100 mb-1"><i class="ti ti-user fs-6 text-warning"></i> Passengers</label>
                        <select class="form-select select" name="PassengerCount" id="PassengerCount" required>
                            <option value="">Select Passengers</option>
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

                    <div class="text-end mb-3">
                        <button type="submit" class="btn btn-primary">
                            Search Buses
                        </button>
                    </div>
            </form>
        </div>
    </section>
    <div class="back-top"></div>

@endsection


@push('script')
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
