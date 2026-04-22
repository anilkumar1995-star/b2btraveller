@extends('layouts.app')
@section('title', 'Failed Hotel Bookings')
@section('pagetitle', 'Failed Hotel Bookings')

@section('content')
    <main>
        <section>
            <div class="card">
                <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4 ">
                    <div class="card-title mb-5">
                        <h4 class="mb-0">
                            <span>@yield('pagetitle') </span>
                        </h4>
                    </div>
                </div>
                <div class="card-body">
                    <div id="booking-container" class="overflow-auto">
                        @include('hotel.booking-table-failed')
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
        swal({
            title: "Checking Status...",
            text: "Please wait while we verify your booking status.",
            type: "info",
            showConfirmButton: false,
            allowOutsideClick: false
        });

        $.ajax({
            url: "{{ route('hotel.checkStatus') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id
            },
            success: function(response) {
                swal.close();
                if (response.status === 'success' || response.status === 'SUCCESS') {
                    notify(response.message || "Status updated successfully!", "success");
                    fetchBookings(window.location.href);
                } else if (response.status === 'pending') {
                    notify(response.message || "Transaction is still pending. Please wait.", "warning");
                } else {
                    notify(response.message || "Unable to update status.", "error");
                }
            },
            error: function() {
                swal.close();
                notify("Something went wrong.", "error");
            }
        });
    }
});
</script>
@endpush
