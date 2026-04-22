@extends('layouts.app')
@section('title', 'Hotel Bookings')
@section('pagetitle', 'Hotel Bookings')

@section('content')
<style>
    .swal2-icon {
        font-size: 10px !important;
        margin: 8px auto !important;
    }
    .swal2-popup {
        padding: 0 0 1.25em !important;
    }
    .swal2-title {
        padding-top: 0 !important;
    }
</style>

<main>

    <section>
        <div class="row">
            <!-- Total Success Bookings -->
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card border h-100">
                    <div class="card-body bg-label-success">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-3">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="ti ti-building-community"></i>
                                </span>
                            </div>
                            <p class="mb-0 text-success fw-bold" data-bs-toggle="tooltip" title="₹ {{ number_format(is_array($totalsuccess) ? 0 : $totalsuccess, 2) }}">
                                ₹ {{ number_format(is_array($totalsuccess) ? 0 : $totalsuccess, 2) }}
                            </p>
                        </div>
                        <span class="mb-1 fw-bold">Total Success Bookings</span>
                        <p class="mb-0">
                            <span class="text-heading fw-bold me-1">{{ is_array($totalsuccessCount) ? 0 : $totalsuccessCount }}</span>
                            <span class="text-body-secondary">Counts</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Total Pending Bookings -->
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card border h-100">
                    <div class="card-body bg-label-warning">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-3">
                                <span class="avatar-initial rounded bg-label-info">
                                    <i class="ti ti-clock"></i>
                                </span>
                            </div>
                            <p class="mb-0 text-warning fw-bold" data-bs-toggle="tooltip" title="₹ {{ number_format(is_array($totalpending) ? 0 : $totalpending, 2) }}">
                                ₹ {{ number_format(is_array($totalpending) ? 0 : $totalpending, 2) }}
                            </p>
                        </div>
                        <span class="mb-1 fw-bold">Total Pending Bookings</span>
                        <p class="mb-0">
                            <span class="text-heading fw-bold me-1">{{ is_array($totalpendingCount) ? 0 : $totalpendingCount }}</span>
                            <span class="text-body-secondary">Counts</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Total Blocked/Failed Bookings -->
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card border h-100">
                    <div class="card-body bg-label-info">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-3">
                                <span class="avatar-initial rounded bg-label-warning">
                                    <i class="ti ti-ban"></i>
                                </span>
                            </div>
                            <p class="mb-0 text-info fw-bold" data-bs-toggle="tooltip" title="₹ {{ number_format(is_array($totalblocked) ? 0 : $totalblocked, 2) }}">
                                ₹ {{ number_format(is_array($totalblocked) ? 0 : $totalblocked, 2) }}
                            </p>
                        </div>
                        <span class="mb-1 fw-bold">Total Blocked Bookings</span>
                        <p class="mb-0">
                            <span class="text-heading fw-bold me-1">{{ is_array($totalblockedCount) ? 0 : $totalblockedCount }}</span>
                            <span class="text-body-secondary">Counts</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Total Cancelled Bookings -->
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card border h-100">
                    <div class="card-body bg-label-danger">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-3">
                                <span class="avatar-initial rounded bg-label-danger">
                                    <i class="ti ti-trash"></i>
                                </span>
                            </div>
                            <p class="mb-0 text-danger fw-bold" data-bs-toggle="tooltip" title="₹ {{ number_format(is_array($totalcancelled) ? 0 : $totalcancelled, 2) }}">
                                ₹ {{ number_format(is_array($totalcancelled) ? 0 : $totalcancelled, 2) }}
                            </p>
                        </div>
                        <span class="mb-1 fw-bold">Total Cancelled Bookings</span>
                        <p class="mb-0">
                            <span class="text-heading fw-bold me-1">{{ is_array($totalcancelledCount) ? 0 : $totalcancelledCount }}</span>
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
                        <span>Booking List</span>
                    </h4>
                </div>
            </div>
            <div class="card-body">
                <div id="booking-container" class="overflow-auto">
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
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                fetchBookings(url);
            });

            function fetchBookings(url) {
                $.ajax({
                    url: url,
                    success: function(data) {
                        $('#booking-container').html(data);
                    }
                });
            }

            window.checkStatus = function(id) {
                Swal.fire({
                    title: "Checking Status...",
                    text: "Please wait while we verify your booking status.",
                    icon: "info",
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "{{ route('hotel.checkStatus') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    success: function(response) {
                        Swal.close();
                        if (response.status === 'success' || response.status === 'SUCCESS') {
                            Swal.fire("Success", response.message || "Status updated successfully!", "success")
                                .then(() => {
                                    fetchBookings(window.location.href);
                                });
                        } else if (response.status === 'pending') {
                            Swal.fire("Pending", response.message || "Transaction is still pending.",
                                "warning");
                        } else {
                            Swal.fire("Error", response.message || "Unable to update status.", "error");
                        }
                    },
                    error: function() {
                        Swal.close();
                        Swal.fire("Error", "Something went wrong.", "error");
                    }
                });
            }
        });
    </script>
@endpush