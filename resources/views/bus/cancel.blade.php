@extends('layouts.app')
@section('title', 'Bus Cancellation')

@section('content')
    <div class="card" style="border:1px solid rgb(244, 90, 90);">
        <div class="card-header pb-0 bg-label-danger">
            <h5> 🚌 Bus Cancellation</h5>
        </div>

        <div class="card-body mt-3">
            <div class="ticket-route w-100 p-3 mb-4">

                <!-- Booking Info -->
                <div class="row mb-4 alert alert-warning">
                    <div class="col-md-4"><b>Invoice Number:</b> {{ $booking->invoice_number }} <br />
                        <b>PNR:</b> {{ $booking->pnr }}
                    </div>
                    <div class="col-md-4 text-center border-start border-primary"><b>Journey Date:</b>
                        {{ $booking->journey_date }}
                    </div>
                    <div class="col-md-4 text-end border-start border-primary"> <b>Sector:</b>

                        {{ $booking->origin }} →
                        {{ $booking->destination ?? 'N/A' }}</div>
                </div>

                <?php
                $bookDet = json_decode($booking->raw_payload, true);
                ?>
                <div class="row">


                    <div class="col-md-6">

                        <h6>Select Passengers</h6>
                        @foreach ($bookDet['passenger'] as $p)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="ticket_ids[]"
                                    value="{{ $booking->ticket_no }}" checked required>
                                <label class="form-check-label">
                                    {{ $p['Title'] }} {{ $p['FirstName'] }} {{ $p['LastName'] }}
                                    <span class="badge bg-label-info">🎟️ {{ $booking->ticket_no }}</span>
                                </label>
                            </div>
                        @endforeach



                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Cancellation Remarks</label>
                            <textarea class="form-control" id="remarks" rows="1" placeholder="Enter remarks" required></textarea>
                        </div>

                        <label class="form-label fw-semibold">
                            Request Type <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" id="requestType" required>
                            <option value="">Select Request Type</option>
                            <option value="11">Full Cancellation</option>
                        </select>
                    </div>
                </div>

            </div>
            <!-- Action -->
            <div class="text-end mt-4">
                <button class="btn btn-danger" id="cancelNow">
                    Cancel Bus
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
            if (requestType == '') {
                valid = false;
                errors.push('Please select Request Type');
                $('#requestType').addClass('is-invalid');
            } else {
                $('#requestType').removeClass('is-invalid');
            }

            if (!valid) {
                notify(errors[0] || 'Incomplete Details', 'warning');
                return;
            }

            const payload = {
                BusId: {{ $booking->bus_id }},
                RequestType: Number(requestType),
                Remarks: remarks,
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
                    cancelBus(payload);
                }
            });
        });

        function cancelBus(payload) {

            $.ajax({
                url: "/bus/cancel-submit",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    payload: payload
                },
                beforeSend: function() {
                    swal({
                        type: 'warning',
                        title: 'Processing Cancellation...',
                        text: 'Please wait while we process your request.',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                    });
                },
                success: function(res) {

                    swal.close();
                    console.log(res);
                    if (res.status === 'success') {
                        const response = res.data?.Response?.[0];

                        let details = `
                            <div class="text-ceneter">
                                <p>
                                    <span>Change Request ID:</span>
                                    <strong class="text-primary">${response?.ChangeRequestId ?? '-'}</strong>
                                </p>

                                <p>
                                    <span>Refund Amount:</span>
                                    <strong class="text-success">${response?.RefundedAmount ?? '0'}</strong>
                                </p>
                                <p>
                                    <span>Credit Note No:</span>
                                    <strong class="text-success">${response?.CreditNoteNo ?? '-'}</strong>
                                </p>

                                <p>
                                    <span>Message:</span>
                                    <strong class="text-success">
                                        ${res?.message ?? 'Bus Cancellation Successfully'}
                                    </strong>
                                </p>
                            </div>
                        `;

                        swal({
                            type: 'success',
                            html: details,
                        }).then(() => {
                            window.location.href = '/bus/booking-list';
                        });

                    } else {
                        swal('Error', res.message, 'error');
                    }
                },
                error: function() {
                    swal.close();
                    notify('Unable to process cancellation', 'error');
                }
            });
        }
    </script>
@endpush
