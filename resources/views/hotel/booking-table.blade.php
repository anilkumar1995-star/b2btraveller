<style>
    .custom-pagination .page-item .page-link {
        border-radius: 8px !important;
        padding: 6px 14px;
        border: 1px solid #dcdcdc;
        color: #333;
        font-weight: 500;
        background: #fff;
        transition: 0.2s;
    }

    .custom-pagination .page-item .page-link:hover {
        background: #eef4ff;
        border-color: #9bb0ff;
        color: #3154ff;
    }

    .custom-pagination .page-item.active .page-link {
        background: #3154ff !important;
        border-color: #3154ff !important;
        color: #fff !important;
        box-shadow: 0 2px 6px rgba(49, 84, 255, 0.4);
    }

    .custom-pagination .page-item .page-link {
        border-radius: 8px !important;
        padding: 6px 14px;
        border: 1px solid #dcdcdc;
        color: #333;
        font-weight: 500;
        background: #fff;
        transition: 0.2s;
    }

    .custom-pagination .page-item .page-link:hover {
        background: #eef4ff;
        border-color: #9bb0ff;
        color: #3154ff;
    }

    .custom-pagination .page-item.active .page-link {
        background: #3154ff !important;
        border-color: #3154ff !important;
        color: #fff !important;
        box-shadow: 0 2px 6px rgba(49, 84, 255, 0.4);
    }

    .custom-pagination .page-item.disabled .page-link {
        background: #f3f3f3;
        color: #999;
        border-color: #e1e1e1;
    }

    .pagination {
        margin-left: 5px !important;
    }

    .barcode-card {
        border: 1px solid #fdfdfdff;
        border-radius: 14px !important;
    }

    .barcode-img {
        max-height: 60px;
        object-fit: contain;
    }


    .ticket-card {
        border: 1px solid #e5e7eb;
    }

    .ticket-card .row div {
        font-size: 15px;
    }

    .shadow-sm {
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08) !important;
    }

    .rounded-4 {
        border-radius: 14px !important;
    }

    @media print {

        body {
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 100% !important;
            width: 100% !important;
        }

        .barcode-card {
            width: 100% !important;
            max-width: 100% !important;
            box-shadow: none !important;
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .barcode-card .row {
            display: flex !important;
            flex-wrap: nowrap !important;
        }

        .barcode-card .col-6 {
            width: 50% !important;
        }

        .barcode-img {
            max-width: 100% !important;
            height: auto !important;
        }

        img {
            page-break-inside: avoid;
        }
    }

    action-btn {
        background-color: rgba(49, 84, 255, 0.1);
    }

    .cursor-pointer {
        cursor: pointer;
    }

    .failed-badge-clickable {
        text-decoration: underline dotted;
        cursor: pointer;
    }
</style>

<div class="card-datatable table-responsive p-2">
    <table class="table table-striped" id="bookingTable">
        <thead class="bg-light">
            <tr>
                <th>ID</th>
                @if (Myhelper::hasRole('admin'))
                    <th>User</th>
                @endif
                <th>Booking Details</th>
                <th>Hotel</th>
                <th>Reference IDs</th>
                <th>Amount</th>
                <th>Payment Info</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>

        <tbody>
            @php
                $statusMap = [
                    'NotSet' => ['label' => 'Not Set', 'class' => 'badge bg-secondary'],
                    'Confirmed' => ['label' => 'Confirmed', 'class' => 'badge bg-success'],
                    'confirmed' => ['label' => 'Confirmed', 'class' => 'badge bg-success'],
                    'success' => ['label' => 'Confirmed', 'class' => 'badge bg-success'],
                    'Failed' => ['label' => 'Failed', 'class' => 'badge bg-danger'],
                    'failed' => ['label' => 'Failed', 'class' => 'badge bg-danger'],
                    'Cancelled' => ['label' => 'Cancelled', 'class' => 'badge bg-danger'],
                    'cancelled' => ['label' => 'Cancelled', 'class' => 'badge bg-danger'],
                    'pending' => ['label' => 'Pending', 'class' => 'badge bg-warning'],
                    'OtherFare' => ['label' => 'Other Fare', 'class' => 'badge bg-info'],
                    'OtherClass' => ['label' => 'Other Class', 'class' => 'badge bg-warning'],
                    'CancellationPending' => ['label' => 'Cancellation Pending', 'class' => 'badge bg-warning'],
                    'CancelRejected' => ['label' => 'Cancellation Rejected', 'class' => 'badge bg-danger'],
                    'BookedOther' => ['label' => 'Booked Other', 'class' => 'badge bg-primary'],
                    'NotConfirmed' => ['label' => 'Not Confirmed', 'class' => 'badge bg-dark'],
                ];

                $paymentStatusMap = [
                    'success' => ['label' => 'Success', 'class' => 'badge bg-success'],
                    'failed' => ['label' => 'Failed', 'class' => 'badge bg-danger'],
                    'pending' => ['label' => 'Pending', 'class' => 'badge bg-warning'],
                    'reversed' => ['label' => 'Reversed', 'class' => 'badge bg-info'],
                    'refunded' => ['label' => 'Refunded', 'class' => 'badge bg-info'],
                ];
            @endphp
            @if (!empty($bookings) && $bookings->count() > 0)
                @foreach ($bookings as $b)
                    @php
                        $status = $statusMap[$b->booking_status] ?? [
                            'label' => 'Unknown',
                            'class' => 'badge bg-secondary',
                        ];

                        $payStatus = $paymentStatusMap[strtolower($b->payment_status)] ?? [
                            'label' => ucfirst($b->payment_status),
                            'class' => 'badge bg-secondary',
                        ];

                        $response = json_decode($b->raw_response);
                    @endphp
                    <tr>
                        <td>##{{ $b->id }} <br />{{ $b->created_at }}</td>
                        @if (Myhelper::hasRole('admin'))
                            <td>
                                {{ $b->user_name ?? '' }}<br />
                                {{ $b->user_email ?? '' }}<br />
                                {{ $b->user_mobile ?? '' }}
                            </td>
                        @endif
                        <td>
                            Invoice: <b>{{ $b->invoice_number ?? 'N/A' }}</b> <br />
                            Booking ID: <b>{{ $response?->data?->BookingId ?? 'N/A' }}</b>
                        </td>
                        <td>
                            @php
                                $payload = json_decode($b->raw_payload);
                                $hotelName = $payload->HotelName ?? ($payload->hotel_name ?? 'N/A');
                                if (is_array($hotelName)) {
                                    $hotelName = $hotelName[0] ?? 'N/A';
                                }
                            @endphp
                            <b>{{ $hotelName }}</b>
                        </td>
                        <td>
                            Ticket No: <b>{{ $b->ticket_no ?? 'N/A' }}</b> <br />
                            TXN ID: <b>{{ $b->order_ref_id ?? 'N/A' }}</b>
                        </td>

                        <td>₹{{ $b->total_amount ?? 0 }}</td>

                        <td>
                            <span
                                class="{{ $payStatus['class'] }} {{ $b->payment_failed_msg ? 'failed-badge-clickable' : '' }}"
                                @if ($b->payment_failed_msg) onclick="showFailureMsg('{{ addslashes($b->payment_failed_msg) }}')" @endif>
                                {{ $payStatus['label'] }}
                            </span>
                        </td>
                        <td>
                            <span
                                class="{{ $status['class'] }} {{ $b->booking_failed_msg ? 'failed-badge-clickable' : '' }}"
                                @if ($b->booking_failed_msg) onclick="showFailureMsg('{{ addslashes($b->booking_failed_msg) }}')" @endif>
                                {{ $status['label'] }}
                            </span><br />
                            <div class="dropdown mt-1">
                                <button class="btn btn-sm btn-light border dropdown-toggle" type="button"
                                    id="dropdownMenuButton{{ $b->id }}" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    👁️ View
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $b->id }}">

                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)"
                                            onclick='openBookingDetails({{ $b->id }})'>
                                            📄 Booking Details
                                        </a>
                                    </li>
                                    @if (!in_array($b->payment_status, ['success', 'refunded']) && !empty($b->order_ref_id))
                                        <li>
                                            <a class="dropdown-item text-primary" href="javascript:void(0)"
                                                onclick="manualCheckStatus('{{ $b->order_ref_id }}')">
                                                🔄 Check Status
                                            </a>
                                        </li>
                                    @endif
                                    @if (in_array(strtolower($b->booking_status), ['pending']))
                                        <li>
                                            <a class="dropdown-item generate-voucher" href="javascript:void(0)"
                                                data-bookingidcancel="{{ $b->booking_id_api }}"
                                                data-bookingstatus="{{ $b->booking_status }}">
                                                🎫 Generate Voucher
                                            </a>
                                        </li>
                                    @endif
                                    @if (in_array(strtolower($b->booking_status), ['Confirmed']))
                                        <li>
                                            <a class="dropdown-item cancel-hotel" href="javascript:void(0)"
                                                data-bookingidcancel="{{ $b->booking_id_api }}"
                                                data-ticketstatus="{{ $b->voucher_status }}"
                                                data-changereqid="{{ $b->change_request_id }}"
                                                data-creditnoteno="{{ $b->credit_note_no }}"
                                                data-refundamt="{{ $b->refunded_amount }}">
                                                🏨 Cancel Hotel
                                            </a>
                                        </li>
                                    @endif
                                    {{-- @if ($b->booking_status == 'CancellationPending' && $b->order_ref_id != null)
                                          <li>
                                              <a class="dropdown-item cancel-status" href="javascript:void(0)"
                                                  data-bookingid="{{ $b->booking_id_api }}"
                                                  data-ticketstatus="{{ $b->voucher_status }}"
                                                  data-changereqid="{{ $b->change_request_id }}"
                                                  data-clientrefid="{{ $b->order_ref_id }}">
                                                  ✅ Check Cancel Status
                                              </a>
                                          </li>
                                      @endif --}}
                                    @if (Myhelper::hasRole('admin') && $b->order_ref_id != null && $b->payment_status == 'success')
                                        <li>
                                            <a class="dropdown-item text-danger" href="javascript:void(0)"
                                                onclick="refundTicket('{{ $b->order_ref_id }}')">
                                                💸 Refund Amount
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="{{ Myhelper::hasRole('admin') ? 10 : 9 }}" class="text-center text-danger">No
                        Bookings Details found.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-center custom-pagination mt-2 mb-3">
    {!! $bookings->links('pagination::bootstrap-5') !!}
</div>

<div class="modal fade" id="failureMsgModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem;">
            <div class="modal-header bg-danger text-white border-0 py-3"
                style="border-top-left-radius: 1.5rem; border-top-right-radius: 1.5rem;">
                <h5 class="modal-title fw-bold text-white mb-0"><i class="ti ti-alert-circle me-2"></i>Failure Message
                </h5>
                <button type="button" class="btn-close btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <p id="failureMsgText" class="text-muted fs-5 mb-0"></p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewTicketModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">

            <div class="modal-header border-0">
                <h4 class="modal-title fw-semibold">Hotel Ticket</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body bg-light" id="ticketContent">

            </div>

            <div class="text-center">
                <button class="btn btn-success m-3" onclick="printTicket()">
                    Print
                </button>
            </div>

        </div>
    </div>
</div>

<style>
    .ticket-route {
        background: #f8fafc;
        border-radius: 10px;
        border: 1px dashed #c7d2fe;
    }

    .city-code {
        font-size: 26px;
        font-weight: 700;
        letter-spacing: 2px;
    }

    .city-name {
        font-size: 12px;
        color: #6b7280;
    }

    .route-line {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #2563eb;
        font-size: 18px;
    }

    .route-line span {
        width: 50px;
        height: 1px;
        background: #94a3b8;
    }
</style>
<style>
    .passenger-section {
        background: #fff;
        border-radius: 12px;
    }

    .passenger-head {
        font-weight: 700;
        padding: 10px;
        border-bottom: 2px solid #2563eb;
        margin-bottom: 12px;
    }

    .passenger-card {
        border: 1px dashed #c7d2fe;
        border-radius: 12px;
        padding: 14px;
        margin-bottom: 16px;
        background: #f8fafc;
    }

    .passenger-name {
        font-size: 16px;
        font-weight: 700;
    }

    .lead-pax {
        background: #2563eb;
        color: #fff;
        font-size: 15px;
        padding: 2px 6px;
        border-radius: 6px;
        margin-left: 6px;
    }

    .passenger-pnr {
        font-weight: 700;
        letter-spacing: 1px;
    }

    .seat-box {
        background: #fff;
        padding: 10px;
        border-radius: 8px;
        margin-top: 10px;
    }

    .seat-title {
        font-weight: 600;
        margin-bottom: 6px;
    }

    .seat-row {
        display: grid;
        grid-template-columns: 1fr auto 2fr auto;
        gap: 8px;
        font-size: 16px;
        border-bottom: 1px dashed #e5e7eb;
        padding: 6px 0;
    }

    .seat-row:last-child {
        border-bottom: none;
    }

    .seat-code {
        font-weight: 700;
        color: #2563eb;
    }

    .fare-box {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
        font-size: 17px;
    }

    .fare-total {
        font-weight: 800;
    }

    .contact-box {
        margin-top: 10px;
        border-top: 1px dashed #e5e7eb;
        padding-top: 8px;
    }

    .ssr-box {
        background: #f8f9ff;
        border: 1px dashed #cfd5ff;
        padding: 12px;
        border-radius: 8px;
        font-size: 15px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    $(document).ready(function() {
        localStorage.removeItem('cancelCharge');
        localStorage.removeItem('refundAmount');
        localStorage.removeItem('cancelRemarks');
    });

    function manualCheckStatus(orderRefId) {
        Swal.fire({
            title: 'Checking Status',
            text: 'Please wait while we verify the booking status...',
            icon: 'info',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: "{{ route('hotel.checkStatus') }}",
            type: "POST",
            data: {
                id: orderRefId,
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {
                let status = res.status ? res.status.toLowerCase() : '';
                if (status === 'success' || res.booking_status === 'Confirmed') {
                    Swal.fire({
                        title: 'Update',
                        text: res.message || 'Booking Confirmed Successfully!',
                        icon: 'success'
                    }).then(() => {
                        location.reload();
                    });
                } else if (status === 'failure' || status === 'failed') {
                    let errMsg = res.message || (res.data && res.data.failedMessage) ||
                        'Transaction Failed.';
                    Swal.fire({
                        title: 'Failed',
                        text: errMsg,
                        icon: 'error'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Status',
                        text: res.message || 'Still processing. Please try again after some time.',
                        icon: 'info'
                    });
                }
            },
            error: function() {
                Swal.fire('Error', 'Unable to check status at this moment.', 'error');
            }
        });
    }

    function showFailureMsg(msg) {
        $('#failureMsgText').text(msg);
        $('#failureMsgModal').modal('show');
    }

    function refundTicket(clientRefId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to refund this transaction!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Refund it!',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return $.ajax({
                    url: "{{ route('hotel.refund') }}",
                    type: "POST",
                    data: {
                        clientRefId: clientRefId,
                        _token: "{{ csrf_token() }}"
                    }
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                const res = result.value;
                if (res && res.status === 'success') {
                    Swal.fire('Success', res.message, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    showFailureMsg(res ? res.message : 'Refund failed');
                }
            }
        });
    }

    function openBookingDetails(bookingId) {
        $('#ticketContent').html(`
                <div class="text-center py-5">
                    <div class="spinner-border text-primary"></div>
                    <p class="mt-2">Fetching booking details...</p>
                </div>
            `);
        $('#viewTicketModal').modal('show');

        $.ajax({
            url: "/hotel/booking-view",
            type: "POST",
            data: {
                id: bookingId,
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {
                if (res.status !== 'success') {
                    $('#ticketContent').html(`<div class="alert alert-danger">${res.message}</div>`);
                    return;
                }
                const booking = res?.data?.GetBookingDetailResult;
                const record = res?.record;
                if (!booking) {
                    $('#ticketContent').html(`<div class="alert alert-danger">Invalid booking data</div>`);
                    return;
                }
                getDetails(booking, record);
            },
            error: function() {
                $('#ticketContent').html(
                    `<div class="alert alert-danger text-center">Unable to fetch booking details.</div>`
                );
            }
        });
    }

    function getDetails(booking, record) {
        let rooms = booking.Rooms || [];
        let passengers = rooms.length > 0 ? (rooms[0].HotelPassenger || []) : [];
        let checkIn = booking.CheckInDate ? new Date(booking.CheckInDate).toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        }) : '-';
        let checkOut = booking.CheckOutDate ? new Date(booking.CheckOutDate).toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        }) : '-';

        let payStatusClass = 'bg-label-warning';
        let pStatus = (record?.payment_status || '').toUpperCase();
        if (pStatus === 'SUCCESS' || pStatus === 'SUCCESSFUL') payStatusClass = 'bg-success';
        else if (pStatus === 'FAILED' || pStatus === 'FAILURE') payStatusClass = 'bg-danger';
        else if (pStatus === 'REFUNDED') payStatusClass = 'bg-info';

        let totalAmount = record?.total_amount || 0;

        let status = record?.booking_status || booking.HotelBookingStatus || 'Pending';
        let statusClass = 'bg-success';
        let upperStatus = status.toUpperCase();
        if (upperStatus === 'FAILED' || upperStatus === 'FAILURE' || upperStatus === 'CANCELLED') statusClass =
            'bg-danger';
        else if (upperStatus === 'PENDING') statusClass = 'bg-warning';

        let starRating = '';
        if (booking.StarRating) {
            for (let i = 0; i < booking.StarRating; i++) {
                starRating += '<i class="fas fa-star text-warning small"></i> ';
            }
        }

        let fullAddress = booking.AddressLine1 || '';
        if (booking.AddressLine2) fullAddress += ', ' + booking.AddressLine2;
        if (booking.City) fullAddress += ', ' + booking.City;

        let html = `
            <style>
                @media print {
                    .modal-footer, .btn-close, .print-btn { display: none !important; }
                    .badge { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; border: 1px solid #ddd !important; }
                    .bg-success { background-color: #28a745 !important; color: white !important; }
                    .bg-danger { background-color: #dc3545 !important; color: white !important; }
                    .bg-warning { background-color: #ffc107 !important; color: black !important; }
                    .bg-primary { background-color: #0d6efd !important; color: white !important; }
                    .bg-light { background-color: #f8f9fa !important; }
                    .text-primary { color: #0d6efd !important; }
                    .text-success { color: #28a745 !important; }
                    .card, .border { border: 1px solid #e5e7eb !important; }
                }
            </style>
            <div id="hotelPrintArea" class="bg-white p-4 rounded shadow-sm border text-dark">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                    <img src="{{ asset('images/logo.png') }}" style="height:60px;">
                    <div class="text-end">
                        <h3 class="fw-bold mb-0 text-primary">Hotel Ticket</h3>
                        <div class="text-muted small">Booking ID: <b>${booking.BookingId || '-'}</b></div>
                        <div class="mt-1">
                            <span class="badge ${record?.is_refundable === 'true' || record?.is_refundable === true ? 'bg-success' : 'bg-danger'} ms-1">${record?.is_refundable === 'true' || record?.is_refundable === true ? 'Refundable' : 'Non-Refundable'}</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-8">
                        <h4 class="text-dark fw-bold mb-1">
                            <i class="fas fa-hotel me-2 text-primary"></i>${booking.HotelName}
                            <span class="ms-2">${starRating}</span>
                        </h4>
                        <p class="text-muted mb-1 small"><i class="fas fa-map-marker-alt me-2"></i>${fullAddress}</p>
                        <p class="text-muted small mb-0">Confirmation No: <b class="text-dark">${booking.ConfirmationNo || '-'}</b></p>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="text-muted small">Reference No</div>
                        <div class="fw-bold fs-5 text-dark">${booking.BookingRefNo || '-'}</div>
                    </div>
                </div>

                <div class="row ticket-route mb-4 py-3 mx-0 text-center shadow-sm" style="background: #f8fafc; border-radius: 12px; border: 1px dashed #c7d2fe;">
                    <div class="col-sm-5">
                        <div class="text-muted small mb-1 uppercase fw-bold">CHECK-IN</div>
                        <div class="fs-4 fw-bold text-dark">${checkIn}</div>
                        <div class="small text-muted">15:00 PM onwards</div>
                    </div>
                    <div class="col-sm-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-hotel text-primary fs-3"></i>
                    </div>
                    <div class="col-sm-5">
                        <div class="text-muted small mb-1 uppercase fw-bold">CHECK-OUT</div>
                        <div class="fs-4 fw-bold text-dark">${checkOut}</div>
                        <div class="small text-muted">Before 12:00 PM</div>
                    </div>
                </div>

                <!-- Financial Summary -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="passenger-section">
                            <div class="passenger-head" style="font-weight: 700; padding: 10px; border-bottom: 2px solid #2563eb; margin-bottom: 12px; color: #1e293b;">FARE SUMMARY</div>
                            <div class="p-3 border rounded bg-light">
                                <div class="d-flex justify-content-between mb-2 small">
                                     <span>Base Fare:</span>
                                     <span>₹${booking.NetAmount || '0.00'}</span>
                                 </div>
                                 <div class="d-flex justify-content-between mb-2 small">
                                     <span>Tax:</span>
                                     <span>₹${booking.NetTax || '0.00'}</span>
                                 </div>
                                  <div class="d-flex justify-content-between mb-2">
                                    <span class="fw-bold">Total Paid:</span>
                                    <span class="fw-bold text-primary fs-5">₹${parseFloat(booking.NetAmount || 0) + parseFloat(booking.NetTax || 0)}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Payment Status:</span>
                                    <span class="badge ${payStatusClass}">${record?.payment_status?.toUpperCase() || 'PENDING'}</span>
                                </div>
                                        </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="passenger-section">
                            <div class="passenger-head" style="font-weight: 700; padding: 10px; border-bottom: 2px solid #2563eb; margin-bottom: 12px; color: #1e293b;">BOOKING DETAILS</div>
                            <div class="p-3 border rounded bg-light">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Invoice No:</span>
                                    <span class="fw-bold">${record?.invoice_number || '-'}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Booking Date:</span>
                                    <span>${booking.BookingDate ? new Date(booking.BookingDate).toLocaleDateString('en-GB') : (record?.created_at ? new Date(record.created_at).toLocaleDateString('en-GB') : '-')}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Total Room:</span>
                                    <span class="small">${booking.NoOfRooms || record?.total_room || '1'} Room(s)</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Room Type:</span>
                                    <span class="small fw-bold">${rooms[0]?.RoomTypeName || '-'}</span>
                                </div>
                                 <div class="d-flex justify-content-between  align-items-center">
                                    <span>Booking Status:</span>
                                    <span class="badge ${statusClass}">${status.toUpperCase()}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="passenger-section mb-4">
                    <div class="passenger-head" style="font-weight: 700; padding: 10px; border-bottom: 2px solid #2563eb; margin-bottom: 12px; color: #1e293b;">GUEST DETAILS</div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Age</th>
                                    <th>Lead</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${passengers.map((p, idx) => `
                                    <tr class="text-center">
                                        <td>${idx+1}</td>
                                        <td class="text-start"><b>${p.Title} ${p.FirstName} ${p.LastName}</b></td>
                                        <td>${p.PaxType == 1 || p.PaxType == '1' ? 'Adult' : (p.PaxType == 2 || p.PaxType == '2' ? 'Child' : 'Guest')}</td>
                                        <td>${p.Age || '-'}</td>
                                        <td>${p.LeadPassenger ? '<span class="badge bg-primary">Lead</span>' : '-'}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    </div>
                    ${booking.SpecialRequest ? `
                        <div class="mt-2 p-2 border rounded bg-light-warning small">
                            <strong>Special Request:</strong> ${booking.SpecialRequest}
                        </div>
                    ` : ''}
                </div>

                <div class="room-section mb-4">
                    <div class="passenger-head" style="font-weight: 700; padding: 10px; border-bottom: 2563eb; margin-bottom: 12px; color: #1e293b;">ROOM & INCLUSION</div>
                    ${rooms.map((room, idx) => `
                        <div class="border rounded-3 p-3 bg-light mb-3">
                            <div class="row align-items-center mb-2">
                                <div class="col-md-7">
                                    <h6 class="fw-bold mb-1">Room ${idx+1}: ${room.RoomTypeName}</h6>
                                    <div class="text-primary small fw-bold"><i class="fas fa-utensils me-1"></i> Inclusion: ${room.Inclusion || 'No Meals'}</div>
                                </div>
                                <div class="col-md-5 text-end">
                                    <div class="badge bg-white border text-dark px-3 py-2">
                                        <i class="fas fa-users me-1"></i> ${room.AdultCount} Adult(s) | ${room.ChildCount} Child(ren)
                                    </div>
                                </div>
                            </div>
                            ${room.Amenities && room.Amenities.length > 0 ? `
                                <div class="mt-2 pt-2 border-top">
                                    <div class="small text-muted mb-2 fw-bold">Amenities:</div>
                                    <div class="d-flex flex-wrap gap-1">
                                        ${room.Amenities.map(amenity => `<span class="badge bg-label-secondary text-dark border fw-normal" style="font-size: 11px;">${amenity}</span>`).join('')}
                                    </div>
                                </div>
                            ` : ''}
                            ${room.RoomDescription ? `
                                <div class="mt-2 pt-2 border-top small text-muted room-desc-html">
                                    <strong class="text-dark">Description:</strong>
                                    <div class="mt-1 text-dark">${room.RoomDescription}</div>
                                </div>
                            ` : ''}
                        </div>
                    `).join('')}
                </div>

                <div class="policy-section mb-4 d-none">
                    <div class="passenger-head" style="font-weight: 700; padding: 10px; border-bottom: 2px solid #2563eb; margin-bottom: 12px; color: #1e293b;">CANCELLATION POLICY</div>
                    <div class="p-3 border rounded bg-white shadow-none" style="font-size: 13px; line-height: 1.6;">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered mb-2">
                                <thead class="table-light">
                                    <tr class="text-center">
                                        <th>From Date</th>
                                        <th>To Date</th>
                                        <th>Cancellation Charge</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${rooms[0] && rooms[0].CancelPolicies ? rooms[0].CancelPolicies.map(policy => `
                                        <tr class="text-center">
                                            <td>${policy.FromDate}</td>
                                            <td>${policy.ToDate}</td>
                                            <td class="text-danger fw-bold">${policy.ChargeType == 2 ? policy.CancellationCharge + '%' : '₹' + policy.CancellationCharge}</td>
                                        </tr>
                                    `).join('') : '<tr><td colspan="3" class="text-center">No cancellation policy available</td></tr>'}
                                </tbody>
                            </table>
                        </div>
                        ${booking.CancellationPolicy ? `
                            <div class="mt-2 small text-muted p-2 border-start border-primary border-4 bg-light">
                                <strong>Policy Summary:</strong><br/>
                                ${booking.CancellationPolicy.split('#^#')[1] ? booking.CancellationPolicy.split('#^#')[1].split('|').filter(p => p && p !== '#!#').map(p => `• ${p}<br/>`).join('') : booking.CancellationPolicy}
                            </div>
                        ` : ''}
                    </div>
                </div>

                <div class="policy-section mb-4">
                    <div class="passenger-head" style="font-weight: 700; padding: 10px; border-bottom: 2px solid #2563eb; margin-bottom: 12px; color: #1e293b;">POLICIES & IMPORTANT INFO</div>
                    <div class="p-3 border rounded bg-white shadow-none" style="font-size: 13px; line-height: 1.6;">
                        <ul class="ps-3 mb-0">
                            <li>Early check-in and late check-out are subject to availability.</li>
                            ${booking.RateConditions ? booking.RateConditions.map(cond => {
                                // Simple HTML decode for &lt; &gt;
                                let decoded = cond.replace(/&lt;/g, '<').replace(/&gt;/g, '>');
                                return `<li class="mb-2">${decoded}</li>`;
                            }).join('') : '<li>No specific policies mentioned.</li>'}
                        </ul>
                    </div>
                </div>

                <div class="alert alert-info mt-4 py-2 border-0" style="background-color: #f0f7ff; color: #0c5460;">
                    <div class="row align-items-center">
                        <div class="col-md-11">
                            <h6 class="mb-0 fw-bold">Important Note :</h6>
                            <p class="mb-0 small">Please present this voucher and a valid government-issued photo ID at the hotel front desk upon arrival.</p>
                        </div>
                    </div>
                </div>
            </div>
          `;
        $('#ticketContent').html(html);
    }

    window.printTicket = function() {
        $("#hotelPrintArea").print({
            globalStyles: true,
            mediaPrint: true,
            stylesheet: null,
            noPrintSelector: ".no-print",
            iframe: true,
            append: null,
            prepend: null,
            manuallyCopyFormValues: true,
            deferred: $.Deferred(),
            timeout: 750,
            title: "Hotel Ticket",
            doctype: '<!doctype html>'
        });
    }


    $(document).on('click', '.cancel-status', function() {

        let changereqId = $(this).data('changereqid');
        let clientrefId = $(this).data('clientrefid');
        let bookingId = $(this).data('bookingid');

        $.ajax({
            url: "/hotel/cancel-status",
            type: "POST",
            data: {
                changeReqId: changereqId,
                clientRefId: clientrefId,
                bookingId: bookingId,
                _token: "{{ csrf_token() }}"
            },
            beforeSend: function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Checking Cancellation Status',
                    text: 'Please wait while we check the cancellation status...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    allowEscapeKey: false,
                });
            },
            success: function(res) {

                if (res.status == 'success') {
                    let status = res.data.Response.ChangeRequestStatus;

                    if (status === 0) status = 'Not Set';
                    else if (status === 1) status = 'Successful';
                    else if (status === 2) status = 'Failed';
                    else if (status === 3) status = 'Invalid Request';
                    else if (status === 4) status = 'Invalid Session';
                    else if (status === 5) status = 'Invalid Credentials';
                    let refundAmount = res.data.Response.RefundedAmount;
                    let cancelCharge = res.data.Response.CancellationCharge;

                    Swal.fire({
                        title: 'Cancellation Status',
                        html: `
                                <b>Status:</b> ${status} <br>
                                <b>Refund Amount:</b> ₹${refundAmount} <br>
                                <b>Cancellation Charge:</b> ₹${cancelCharge}
                            `,
                        icon: 'success',
                        confirmButtonText: 'OK, Got it !',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: res.message ||
                            'Unable to fetch cancellation status. Please try again later.',
                        icon: 'error'
                    });
                }

            },
            error: function() {
                Swal.fire({
                    title: 'Error',
                    text: 'Unable to fetch cancellation status. Please try again later.',
                    icon: 'error'
                });
            }
        });

    });

    $(document).on('click', '.cancel-hotel', function() {

        const bookingId = $(this).data('bookingidcancel');
        const ticketStatus = $(this).data('ticketstatus');
        const depTimeStr = $(this).data('departuretime');
        const changereqid = $(this).data('changereqid');
        const creditno = $(this).data('creditnoteno');
        const amt = $(this).data('refundamt');

        const depTime = new Date(depTimeStr.replace(' ', 'T'));
        const now = new Date();
        if (ticketStatus == 'Cancelled' || ticketStatus == 'CancelRejected') {
            Swal.fire({
                title: 'Ticket Already Cancelled',
                html: `Refund Amount: ${amt} 
                  <br> Cancel Request id: ${changereqid}
                  <br> Credit Note No: ${creditno}
                  <br/>No further action is allowed.`,
                icon: 'warning',
                confirmButtonText: 'OK, Got It',
                allowOutsideClick: false,
                allowEscapeKey: false
            });
            return;
        } else if (ticketStatus == 'CancellationPending') {
            Swal.fire({
                title: 'Cancellation in Process',
                html: `Refund Amount: ${amt} <br/> Cancellation is not allowed.`,
                icon: 'warning',
                confirmButtonText: 'OK',
                allowOutsideClick: false,
                allowEscapeKey: false
            });
            return;
        } else if (ticketStatus == 'Successful') {

            if (depTime <= now) {
                Swal.fire({
                    title: 'Trip Completed',
                    text: 'Departure time has already passed. Cancellation is not allowed.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                });
                return;
            }

            Swal.fire({
                icon: 'warning',
                title: 'Please Wait',
                text: 'Checking cancellation charges...',
                allowOutsideClick: false,
                showConfirmButton: false,
                allowEscapeKey: false,
            });

            $.ajax({
                url: "/hotel/get-cancellation-charges",
                method: "POST",
                data: {
                    booking_id: bookingId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {

                    swal.close();

                    if (res.status == 'success') {

                        let cancelCharge = res.data.Response.CancellationCharge;
                        let refundAmount = res.data.Response.RefundAmount;
                        let remarks = res.data.Response.Remarks;

                        localStorage.setItem('cancelCharge', cancelCharge);
                        localStorage.setItem('refundAmount', refundAmount);
                        localStorage.setItem('cancelRemarks', remarks);

                        Swal.fire({
                            title: 'Confirm Cancellation',
                            html: `
                                <b>Cancellation Charge:</b> ₹${cancelCharge} <br>
                                <b>Refund Amount:</b> ₹${refundAmount} <br><br>
                                <b>Remarks:</b> ${remarks} <br><br>
                                Do you want to cancel this hotel?
                            `,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, Cancel Hotel',
                            cancelButtonText: 'No',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        }).then((result) => {

                            if (result.value) {

                                const encoded = btoa(JSON.stringify(bookingId));

                                window.location.href = `/hotel/cancel/${encoded}`;
                            }

                        });

                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: res.message ||
                                'Unable to fetch cancellation charges. Please try again later.',
                            icon: 'error'
                        });

                    }

                },
                error: function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'Unable to fetch cancellation charges. Please try again later.',
                        icon: 'error'
                    });
                }

            });
        } else {
            Swal.fire({
                title: 'Ticket is Not Confirmed',
                text: 'Cancellation is not allowed.',
                icon: 'warning',
                confirmButtonText: 'OK',
                allowOutsideClick: false,
                allowEscapeKey: false
            });
            return;
        }
    });
    $(document).on('click', '.generate-voucher', function() {

        const bookingId = $(this).data('bookingidcancel');
        const bookingstatus = $(this).data('bookingstatus');
        if (bookingstatus.toLowerCase() == 'pending') {

            Swal.fire({
                icon: 'warning',
                title: 'Please Wait',
                text: 'We wroking on your request...',
                allowOutsideClick: false,
                showConfirmButton: false,
                allowEscapeKey: false,
            });

            $.ajax({
                url: "/hotel/voucher",
                method: "POST",
                data: {
                    booking_id: bookingId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    swal.close();
                    let bookingStatus = response?.data?.Status;

                    if (response.status == "success" && bookingStatus == 1) {
                        Swal.fire({
                            icon: "success",
                            html: `<p><span class="badge bg-success">Voucher Confirmed</span></p>
                                    <div class="alert alert-secondary border rounded p-3">
                                        <ul class="list-unstyled mb-0">
                                            <li>Your booking Voucher is successful and your 
                                            Booking ID : <span class="badge bg-primary mb-2">${response?.data?.BookingId}</span>
                                            
                                            and <br/> Invoice Number : <span class="badge bg-primary">${response?.data?.InvoiceNumber}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body px-1 pt-1 pb-0 mb-0">
                                        <p>Booking Status<span>: ${response?.data?.HotelBookingStatus}</span></p>
                                    </div>`,
                            confirmButtonText: 'OK, Got it🙂',
                            showConfirmButton: true,
                            backdrop: true,
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.isConfirmed || result.value) {
                                location.reload();
                            }
                        });
                    } else if (bookingStatus == 3) {
                        notify("Price changed. Please verify before booking again.", "warning");
                    } else if (bookingStatus == 6) {
                        notify("Booking has been cancelled.", "error");
                    } else if (bookingStatus == 0) {
                        notify("Booking failed. Please try again.", "error");
                    } else {
                        notify(
                            response?.message ||
                            "Error while booking Hotel.",
                            "error"
                        );
                        return;
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'Unable to fetch voucher details. Please try again later.',
                        icon: 'error'
                    });
                }

            });
        } else {
            Swal.fire({
                title: 'Sorry!',
                text: 'Booking is not Vouchered yet. Please wait for some time and try again.',
                icon: 'warning',
                confirmButtonText: 'OK',
                allowOutsideClick: false,
                allowEscapeKey: false
            });
            return;
        }
    });
</script>
