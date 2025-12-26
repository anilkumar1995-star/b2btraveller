@extends('layouts.app')

@section('content')
    <div class="card" style="border:1px solid rgb(244, 90, 90);">
        <div class="card-header pb-0 bg-label-danger">
            <h5> ✈️ Flight Cancellation</h5>
        </div>

        <div class="card-body mt-3">
            <div class="ticket-route w-100 p-3 mb-4">

                <!-- Booking Info -->
                <div class="row mb-4 alert alert-warning">
                    <div class="col-md-3"><b>Booking ID:</b> {{ $booking->booking_id_api }}</div>
                    <div class="col-md-3 text-center border-start border-primary"><b>PNR:</b> {{ $booking->pnr }}</div>
                    <div class="col-md-3 text-center border-start border-primary"><b>Journey:</b>
                        {{ $booking->journey_type }}
                    </div>
                    <div class="col-md-3 text-end border-start border-primary"> <b>Sector:</b>
                        <?php
                        $bookDet = json_decode($booking->raw_response, true);
                        $finalDet = $bookDet['Response']['Response']['FlightItinerary'];
                        ?>
                        {{ $finalDet['Origin'] }} →
                        {{ $finalDet['Destination'] }}</div>
                </div>

                <h6>Select Passengers</h6>
                <div class="row">


                    <div class="col-md-6 h-100">
                        @foreach ($finalDet['Passenger'] as $p)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="ticket_ids[]"
                                    value="{{ $p['Ticket']['TicketId'] }}" checked required>
                                <label class="form-check-label">
                                    {{ $p['Title'] }} {{ $p['FirstName'] }} {{ $p['LastName'] }}
                                    <span class="badge bg-label-info">🎟️ {{ $p['Ticket']['TicketId'] }}</span>
                                </label>
                            </div>
                        @endforeach


                        <div class="mt-3">
                            <label class="form-label">Cancellation Remarks</label>
                            <textarea class="form-control" id="remarks" rows="3" placeholder="Enter remarks" required></textarea>
                        </div>
                    </div>

                    <div class="col-md-6 h-100">
                        <label class="form-label fw-semibold">
                            Request Type <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" id="requestType" required>
                            <option value="">Select Request Type</option>
                            <option value="0">Not Set</option>
                            <option value="1">Full Cancellation</option>
                            <option value="2">Partial Cancellation</option>
                            <option value="3">Reissuance</option>
                        </select>


                        <label class="form-label fw-semibold mt-4">
                            Cancellation Type <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" id="cancellationType" required>
                            <option value="">Select Cancellation Type</option>
                            <option value="0">Not Set</option>
                            <option value="1">No Show</option>
                            <option value="2">Flight Cancelled</option>
                            <option value="3">Others</option>
                        </select>
                    </div>
                </div>

            </div>
            <!-- Action -->
            <div class="text-end mt-4">
                <button class="btn btn-danger" id="cancelNow">
                    Cancel Flight
                </button>
            </div>

        </div>
    </div>

    <style>
        .ticket-route {
            background: #f8fafc;
            border-radius: 10px;
            border: 1px dashed #c7d2fe;
        }
    </style>
@endsection


@push('script')
    <script>
        $('#cancelNow').on('click', function() {

            let valid = true;
            let errors = [];

            // Passengers
            const tickets = $('input[name="ticket_ids[]"]:checked').map(function() {
                return $(this).val();
            }).get();

            if (tickets.length === 0) {
                valid = false;
                errors.push('Please select at least one passenger');
            }

            // Remarks
            const remarks = $('#remarks').val().trim();
            if (!remarks) {
                valid = false;
                errors.push('Cancellation remarks are required');
                $('#remarks').addClass('is-invalid');
            } else {
                $('#remarks').removeClass('is-invalid');
            }

            // Request Type
            const requestType = $('#requestType').val();
            if (requestType === '') {
                valid = false;
                errors.push('Please select Request Type');
                $('#requestType').addClass('is-invalid');
            } else {
                $('#requestType').removeClass('is-invalid');
            }

            // Cancellation Type
            const cancellationType = $('#cancellationType').val();
            if (cancellationType === '') {
                valid = false;
                errors.push('Please select Cancellation Type');
                $('#cancellationType').addClass('is-invalid');
            } else {
                $('#cancellationType').removeClass('is-invalid');
            }

            if (!valid) {
                notify('Incomplete Details', 'warning');
                return;
            }


            const payload = {
                BookingId: {{ $booking->booking_id_api }},
                RequestType: Number(requestType),
                CancellationType: Number(cancellationType),
                TicketId: tickets,
                Remarks: remarks,
                Sectors: [{
                    Origin: "{{ $finalDet['Origin'] }}",
                    Destination: "{{ $finalDet['Destination'] }}"
                }],
            };

            swal({
                title: 'Confirm Cancellation?',
                text: 'This action cannot be undone.',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Cancel Ticket',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.value) {
                    cancelFlight(payload);
                }
            });
        });

        function cancelFlight(payload) {

            $.ajax({
                url: "/flight/cancel-submit",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    payload: payload
                },
                success: function(res) {

                    if (res.status === 'success') {
                        swal({
                            type: 'success',
                            title: 'Cancelled Successfully',
                            text: res.message
                        }).then(() => {
                            window.location.href = '/flight/bookings';
                        });
                    } else {
                        swal('Error', res.message, 'error');
                    }
                },
                error: function() {
                    swal('Error', 'Unable to process cancellation', 'error');
                }
            });
        }
    </script>
@endpush
