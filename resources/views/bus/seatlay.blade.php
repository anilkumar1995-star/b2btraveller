@extends('layouts.app')
@section('title', 'Seat Layout Details')
@section('pagetitle', 'Seat Layout Details')

@section('content')
    <div class="preloader text-center">
        <div class="preloader-item">
            <div class="spinner-grow text-primary"></div>
        </div>
    </div>

    <div class="pb-4 d-none" id="seatLayoutContainer">
        <div class="card shadow-sm mb-3">
            <div class="card-body d-flex justify-content-between align-items-center">


                <button class="btn btn-primary" id="proceedBookingBtn">
                    Proceed to Booking
                </button>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script src="{{ asset('') }}js/bustrip.js"></script>
    <script>
        $(document).ready(function() {

            $('#seatLayoutContainer').addClass('d-none');
            $('.preloader').removeClass('d-none');

            const payload = JSON.parse(localStorage.getItem('payload'));
            const resultIndex = localStorage.getItem('BusResultIndex');
            const traceId = localStorage.getItem('TraceId');

            if (!payload || !resultIndex || !traceId) {
                swal({
                    title: "Data Missing",
                    html: "Your booking session missing some info, <br/> Please try again",
                    type: "error",
                    confirmButtonText: "Search Bus Again",
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then(() => {
                    window.location.href = "/bus/view";
                });
                return;
            }

            if (resultIndex) {
                notify("Fetching Seat Layout Details...", "info");
                return;
                // getSeatDetails(resultIndex, traceId);
                // getboradingDetails(resultIndex, traceId);
            } else {
                window.location.href = "/bus/view";
            }

        });
    </script>
@endpush
