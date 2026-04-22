@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="card shadow-sm border-0 rounded-lg p-5">
                <div id="status-icon" class="mb-4">
                    @if($status == 'success')
                        <div class="text-success" style="font-size: 5rem;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    @else
                        <div class="text-danger" style="font-size: 5rem;">
                            <i class="fas fa-times-circle"></i>
                        </div>
                    @endif
                </div>

                <h2 id="status-title" class="mb-3">
                    {{ $status == 'success' ? 'Payment Successful!' : 'Payment Failed' }}
                </h2>
                
                <p id="status-message" class="text-muted mb-4 fs-5">
                    {{ $message }}
                </p>

                <div id="booking-details" class="alert alert-light bg-light border rounded p-4 mb-4" @if($status != 'success') style="display:none;" @endif>
                    <div class="row text-start">
                        <div class="col-sm-6 mb-2">
                            <strong>Transaction ID:</strong><br>
                            <span class="text-primary">{{ $id }}</span>
                        </div>
                        <div id="polling-container" class="col-sm-12 mt-3 text-center">
                            <div class="spinner-border text-primary spinner-border-sm me-2" role="status"></div>
                            <span id="polling-text" class="text-muted">Wait for hotel confirmation...</span>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <a href="{{ route('hotel.view') }}" class="btn btn-outline-primary px-4">Back to Home</a>
                    @if($status == 'success')
                        <a href="{{ route('hotel.bookingList') }}" id="view-booking-btn" class="btn btn-primary px-4" style="display:none;">View Booking</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
<script>
$(document).ready(function() {
    @if($status == 'success' && $id)
        let pollCount = 0;
        const maxPolls = 10; 
        const pollInterval = 10000;

        function checkStatus() {
            $.ajax({
                url: "{{ route('hotel.checkStatus') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: "{{ $id }}"
                },
                success: function(response) {
                    if (response.booking_status === 'Confirmed') {
                        $('#polling-container').hide();
                        $('#status-icon').html('<div class="text-success animated bounceIn" style="font-size: 5rem;"><i class="fas fa-check-double"></i></div>');
                        $('#status-title').text('Booking Confirmed! 🎉');
                        $('#status-message').text('Your hotel reservation is now confirmed. Safe travels!');
                        $('#view-booking-btn').show();
                    } else if (response.booking_status === 'failed') {
                        $('#polling-container').hide();
                        $('#status-icon').html('<div class="text-danger" style="font-size: 5rem;"><i class="fas fa-exclamation-triangle"></i></div>');
                        $('#status-title').text('Booking Failed');
                        $('#status-message').text(response.message || 'Payment was successful, but we could not confirm the booking with the hotel. Our support team will contact you.');
                    } else if (pollCount < maxPolls) {
                        pollCount++;
                        const currentStatus = response.booking_status ? response.booking_status.charAt(0).toUpperCase() + response.booking_status.slice(1) : 'Processing';
                        $('#polling-text').html(`Please wait, confirming your booking...<br/><small class="text-primary font-bold">Status: <b>${currentStatus}</b> (${pollCount}/${maxPolls})</small>`);
                        setTimeout(checkStatus, pollInterval);
                    } else {
                        $('#polling-container').html('<div class="alert alert-warning py-2 mb-0 mt-3"><i class="fas fa-clock me-1"></i> Timeout: Booking is taking longer than expected. Please check your Booking List in a few minutes.</div>');
                        $('#view-booking-btn').show();
                    }

                },
                error: function() {
                    if (pollCount < maxPolls) {
                        pollCount++;
                        setTimeout(checkStatus, pollInterval);
                    }
                }
            });
        }

        setTimeout(checkStatus, 1000);
    @endif
});
</script>
@endpush
@endsection
