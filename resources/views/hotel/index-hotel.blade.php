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
                <h5 class="card-title mb-0">🏨 Find the top Hotels nearby.</h5>
            </div>

            <form {{-- style="background-image: url('{{ asset('images/1.png') }}'); background-position: center center; background-repeat: no-repeat; background-size: cover;" --}} id="hotelSearchForm"
                class="bg-mode bg-white position-relative px-3 px-sm-4 pt-4 mb-4 mb-sm-0">
                @csrf


                <div class="row g-4 position-relative">

                    <div class="col-lg-4">
                        <div class="form-control-border form-control-transparent form-fs-md d-flex">
                            <i class="ti ti-geo-alt fs-3 me-2 mt-2"></i>
                            <div class="flex-grow-1">
                                <label>Location</label>
                                <select class="form-select  select" data-search-enabled="true" name="Destination"
                                    id="Destination">
                                    <option value="">Select location</option>

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <label>Check in - out</label>
                        <div class="input-daterange input-group rounded">
                            <input type="text" class="form-control flatpickr" id="fromDate">
                            <span class="input-group-text position-relative">
                               <i class="fa-solid fa-right-left"></i>
                            </span>
                            <input type="text" class="form-control flatpickr" id="toDate">
                        </div>

                    </div>


                    <div class="col-lg-4">
                        <div class="form-control-border form-control-transparent form-fs-md d-flex">
                            <i class="ti ti-person fs-3 me-2 mt-2"></i>
                            <div class="w-100">
                                <label>Guests & rooms</label>
                                <div class="dropdown guest-selector me-2">
                                    <input type="text" class="form-guest-selector form-control selection-result"
                                        value="2 Guests 1 Room" data-bs-auto-close="outside" data-bs-toggle="dropdown">

                                    <ul class="dropdown-menu guest-selector-dropdown p-2">
                                        <li class="d-flex justify-content-between">
                                            <div>
                                                <h6 class="mb-0">Adults</h6>
                                                <small>Ages 13 or above</small>
                                            </div>

                                            <div class="hstack gap-1 align-items-center">
                                                <button type="button" class="btn btn-link adult-remove p-1 mb-0"><i
                                                        class="ti ti-minus  fs-5 fa-fw"></i></button>
                                                <h6 class="guest-selector-count mb-0 adults">2</h6>
                                                <button type="button" class="btn btn-link adult-add p-1 mb-0"><i
                                                        class="ti ti-plus fs-5 fa-fw"></i></button>
                                            </div>
                                        </li>

                                        <li class="dropdown-divider"></li>

                                        <li class="d-flex justify-content-between">
                                            <div>
                                                <h6 class="mb-0">Child</h6>
                                                <small>Ages 13 below</small>
                                            </div>

                                            <div class="hstack gap-1 align-items-center">
                                                <button type="button" class="btn btn-link child-remove p-1 mb-0"><i
                                                        class="ti ti-minus  fs-5 fa-fw"></i></button>
                                                <h6 class="guest-selector-count mb-0 child">0</h6>
                                                <button type="button" class="btn btn-link child-add p-1 mb-0"><i
                                                        class="ti ti-plus fs-5 fa-fw"></i></button>
                                            </div>
                                        </li>

                                        <li class="dropdown-divider"></li>

                                        <li class="d-flex justify-content-between">
                                            <div>
                                                <h6 class="mb-0">Rooms</h6>
                                                <small>Max room 8</small>
                                            </div>

                                            <div class="hstack gap-1 align-items-center">
                                                <button type="button" class="btn btn-link room-remove p-1 mb-0"><i
                                                        class="ti ti-minus  fs-5 fa-fw"></i></button>
                                                <h6 class="guest-selector-count mb-0 rooms">1</h6>
                                                <button type="button" class="btn btn-link room-add p-1 mb-0"><i
                                                        class="ti ti-plus fs-5 fa-fw"></i></button>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-end mb-3">
                        <button type="submit" class="btn btn-primary">
                            Search Hotels
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
            $('.select').select2();

            $('.flatpickr').datepicker({
                'autoclose': true,
                'clearBtn': true,
                'todayHighlight': true,
                'format': 'yyyy-mm-dd',
                'startDate': new Date()
            });
        });
        $(document).on('submit', '#hotelSearchForm', function(e) {
            e.preventDefault();

            swal({
                type: 'info',
                title: 'Coming Soon',
                text: 'Hotel booking feature will be available soon!',
                confirmButtonText: 'Okay'
            });
        });
    </script>
@endpush
