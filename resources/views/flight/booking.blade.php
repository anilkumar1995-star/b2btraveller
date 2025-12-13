@extends('layouts.app')
@section('title', 'Booking Page')
@section('pagetitle', 'Booking Page')

@section('content')
    <main>
        <section>
            <!-- Pre loader -->
            <div class="preloader text-center">
                <div class="preloader-item">
                    <div class="spinner-grow text-primary"></div>
                </div>
            </div>
            <div class="d-none" id="bookingData">

                <div class="row g-4 g-xl-5">
                    <!-- Left Content START -->
                    <div class="col-xl-8">
                        <div class="card border" id="bookingSummaryCard">
                            <div class="card-header d-flex justify-content-between align-items-center border-bottom">
                                <h5 class="mb-0 card-title">Your Booking 🔖</h5>

                          
                                <a href="{{ route('flight.bookingList') }}" class="btn btn-primary">Review booking</a>
                            </div>


                            <!-- Card body -->
                            <div class="card-body mt-2">
                                <div class="row">
                                    <div class="mb-3 col-6">
                                        <small class="text-muted"><i class="bi bi-hash me-1"></i>PNR</small>
                                        <h5 id="pnrText">--</h5>
                                    </div>
                                    <div class="mb-3 col-6 text-end">
                                        <small class="text-muted"><i class="bi bi-hash me-1"></i>Booking Id</small>
                                        <h5 id="bookingId">--</h5>
                                    </div>
                                </div>


                                <div id="segmentList"></div>

                                <!-- Traveler detail -->
                                <small><i class="bi bi-person me-1"></i>Traveler detail</small>
                                <div id="travelerList"></div>
                            </div>

                            <!-- Card footer -->

                        </div>

                    </div>
                    <!-- Left Content END -->

                    <!-- Right content START -->
                    <aside class="col-xl-4">
                        <div class=" sticky-top">
                            <div class="row g-4">
                                <!-- Fare summary START -->
                                <div class="col-md-6 col-xl-12">
                                    <div class="card bg-light rounded-2">
                                        <!-- card header -->
                                        <div class="card-header border-bottom bg-light">
                                            <h5 class="card-title mb-0">Fare Summary</h5>
                                        </div>

                                        <!-- Card body -->
                                        <div class="card-body">
                                            <ul class="list-group list-group-borderless">
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span class="h6 fw-normal mb-0">Base Fare
                                                        <a tabindex="0" data-bs-toggle="popover" data-bs-trigger="focus"
                                                            data-bs-placement="bottom"
                                                            data-bs-content="COVID-19 test required Vaccinated travelers can visit">
                                                            <i class="bi bi-info-circle"></i>
                                                        </a>
                                                    </span>
                                                    <span class="fs-5" id="fareBaseFare">0</span>
                                                </li>
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span class="h6 fw-normal mb-0">Discount</span>
                                                    <span class="fs-5 text-success" id="fareDiscount">0</span>
                                                </li>
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span class="h6 fw-normal mb-0">Tax</span>
                                                    <span class="fs-5 text-success" id="fareTax">0</span>
                                                </li>
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span class="h6 fw-normal mb-0">Other Services</span>
                                                    <span class="fs-5" id="fareOther">0</span>
                                                </li>
                                            </ul>
                                        </div>

                                        <!-- Card footer -->
                                        <div class="card-footer border-top bg-light">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="h5 fw-normal mb-0">Total Fare</span>
                                                <span class="h5 fw-normal mb-0" id="fareTotal">0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Fare summary END -->
                            </div>
                            <div>
                                <h5 class="mt-3 mb-2">Fare Rules</h5>
                                <div id="fareRuleList"></div>

                            </div>
                        </div>
                    </aside>
                    <!-- Right content END -->
                </div>
            </div>
        </section>

         <div id="fareRuleListModal"></div>

    </main>

@endsection



@push('script')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf417-js/2.1.7/pdf417.min.js"></script> --}}
    <script src="https://unpkg.com/bwip-js/dist/bwip-js-min.js"></script>

    <script src="{{ asset('') }}js/flight.js"></script>
    <script>
        $(document).ready(function() {
            $('#bookingData').addClass('d-none');
            $('.preloader').removeClass('d-none');
            hitBookingAPI();
        });
    </script>
@endpush
