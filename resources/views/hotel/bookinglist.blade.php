@extends('layouts.app')
@section('title', 'Booking List')
@section('pagetitle', 'Booking List')


@section('content')
    <main>
        <section>
              <div class="row">
                 <div class="col-lg-3 col-sm-6">
                    <div class="card border h-100">
                        <div class="card-body bg-label-success">
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar me-3">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="ti ti-bus"></i>
                                    </span>
                                </div>
                                <p class="mb-0 text-success" data-bs-toggle="tooltip" title=""
                                    data-bs-original-title="₹ {{ number_format($totalsuccess ?? 0, 2) }}"
                                    id="total_booking_amount">
                                    ₹ {{ number_format($totalsuccess ?? 0, 2) }}
                            </p>
                            </div>
                            <span class="mb-1 fw-bold">Total Success Bookings</span>
                            <p class="mb-0">
                                <span class="text-heading fw-bold me-1" id="booking_count">{{ $totalsuccessCount ?? 0 }}</span>
                                <span class="text-body-secondary">Counts</span>
                            </p>
                        </div>
                    </div>
                </div>
                 <div class="col-lg-3 col-sm-6">
                    <div class="card border h-100">
                        <div class="card-body bg-label-warning">
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar me-3">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="ti ti-clock"></i>

                                    </span>
                                </div>
                                <p class="mb-0 text-success" data-bs-toggle="tooltip" title=""
                                    data-bs-original-title="₹ {{ number_format($totalpending ?? 0, 2) }}"
                                    id="total_booking_amount">
                                    ₹ {{ $totalpending ?? 0 }}
                              </p>
                            </div>
                            <span class="mb-1 fw-bold">Total Pending Bookings</span>
                            <p class="mb-0">
                                <span class="text-heading fw-bold me-1" id="booking_count">{{ $totalpendingCount ?? 0 }}</span>
                                <span class="text-body-secondary">Counts</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="card border h-100">
                        <div class="card-body bg-label-info">
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar me-3">
                                    <span class="avatar-initial rounded bg-label-warning">
                                      <i class="ti ti-tag"></i>
                                    </span>
                                </div>
                                <p class="mb-0 text-success" data-bs-toggle="tooltip" title=""
                                    data-bs-original-title="₹ {{ number_format($totalblocked ?? 0, 2) }}"
                                    id="total_booking_amount">
                                    ₹ {{ $totalblocked ?? 0 }}
                                </p>
                            </div>
                            <span class="mb-1 fw-bold">Total Blocked Bookings</span>
                            <p class="mb-0">
                                <span class="text-heading fw-bold me-1" id="booking_count"> {{ $totalblockedCount ?? 0 }} </span>
                                <span class="text-body-secondary fs-13">Counts</span>
                            </p>
                        </div>
                    </div>
                </div>
                  <div class="col-lg-3 col-sm-6">
                    <div class="card border h-100">
                        <div class="card-body bg-label-danger">
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar me-3">
                                    <span class="avatar-initial rounded bg-label-warning">
                                     <i class="ti ti-ban"></i>
                                    </span>
                                </div>
                                <p class="mb-0 text-success" data-bs-toggle="tooltip" title=""
                                    data-bs-original-title="₹ {{ number_format($totalcancelled ?? 0, 2) }}"
                                    id="total_booking_amount">
                                    ₹ {{ $totalcancelled ?? 0 }}
                                </p>
                            </div>
                            <span class="mb-1 fw-bold">Total Cancelled Bookings</span>
                            <p class="mb-0">
                                <span class="text-heading fw-bold me-1" id="booking_count"> {{ $totalcancelledCount ?? 0 }} </span>
                                <span class="text-body-secondary">Counts</span>
                            </p>
                        </div>
                    </div>
                </div>   
            </div>
            <div class="card mt-3">
                <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4 ">
                    <div class="card-title mb-5">
                        <h4 class="mb-0">
                            <span>@yield('pagetitle') </span>
                        </h4>
                    </div>
                </div>
                <div class="card-body">
                    <div id="bookingTable" class="overflow-auto">
                        @include('hotel.booking-table')
                    </div>
                </div>
            </div>
        </section>


    </main>

@endsection


@push('script')
    <script>
        $(document).ready(function() {

            // When clicking next/previous page
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                loadBookings(url);
            });

            function loadBookings(url) {
                $.ajax({
                    url: url,
                    success: function(data) {
                        $("#bookingTable").html(data);
                    }
                });
            }
        });
    </script>
@endpush
