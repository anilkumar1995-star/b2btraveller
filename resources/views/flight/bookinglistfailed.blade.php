@extends('layouts.app')
@section('title', 'Booking Failed List')
@section('pagetitle', 'Booking Failed List')


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
                        @include('flight.booking-table-failed')
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
