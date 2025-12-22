@extends('layouts.app')
@section('title', 'Booking List')
@section('pagetitle', 'Booking List')


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
                    <div id="bookingTable" class="overflow-auto">
                        @include('flight.booking-table')
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

            // $(document).on('click', '.view-ticket', function() {
            //     const bookingId = $(this).data('id');

            //     $(this).addClass('d-none');

            //     $(`.booking-details[data-id="${bookingId}"]`).removeClass('d-none');
            // });

        });
    </script>
@endpush
