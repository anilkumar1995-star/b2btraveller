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
</style>

<div class="card-datatable table-responsive p-0">
    <table class="table table-striped" id="bookingTable">
        <thead class="bg-light">
            <tr>
                <th>ID</th>
                @if (Myhelper::hasRole('admin'))
                    <th>User</th>
                @endif
                <th>Booking Details</th>
                <th>Hotel Details</th>
                <th>Hotel Id & Ticket No</th>
                <th>Amount</th>
                <th>Payment Status</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>

        <tbody>
            @php
                $statusMap = [
                    'Confirmed' => ['label' => 'Confirmed', 'class' => 'badge bg-success'],
                    'Cancelled' => ['label' => 'Cancelled', 'class' => 'badge bg-danger'],
                    'failed' => ['label' => 'Failed', 'class' => 'badge bg-danger'],
                    'pending' => ['label' => 'Pending', 'class' => 'badge bg-warning'],
                ];
            @endphp

            @forelse($bookings as $b)
                @php
                    $status = $statusMap[$b->booking_status] ?? [
                        'label' => ucfirst($b->booking_status),
                        'class' => 'badge bg-secondary',
                    ];
                    $payload = json_decode($b->raw_payload, true);
                @endphp
                <tr>
                    <td>##{{ $b->id }} <br />{{ $b->created_at }}</td>
                    @if (Myhelper::hasRole('admin'))
                        <td>
                            <b>{{ $b->user_name ?? '' }}</b><br />
                            {{ $b->user_email ?? '' }}<br />
                            {{ $b->user_mobile ?? '' }}
                        </td>
                    @endif
                    <td>
                        Booking Ref No: <b>{{ $b->booking_ref_no ?? 'N/A' }}</b> <br />
                        Order Ref ID: <b>{{ $b->order_ref_id ?? 'N/A' }}</b>
                    </td>

                    <td>
                        <b class="text-primary">{{ is_array($payload['HotelName'] ?? null) ? 'N/A' : ($payload['HotelName'] ?? 'N/A') }}</b> <br /> 
                        Check-in: {{ is_array($payload['CheckInDate'] ?? null) ? 'N/A' : ($payload['CheckInDate'] ?? 'N/A') }}<br/>
                        Rooms: {{ is_array($b->total_room) ? 0 : $b->total_room }}
                    </td>
                    <td>
                        Hotel Id: <b>{{ is_array($b->hotel_id) ? 'N/A' : ($b->hotel_id ?? 'N/A') }}</b> <br />
                        Ticket No: <b>{{ is_array($b->ticket_no) ? 'N/A' : ($b->ticket_no ?? 'N/A') }}</b>                    </td>
                    <td>₹{{ is_array($b->total_amount) ? '0.00' : number_format($b->total_amount, 2) }}</td>
                    <td>
                        <span class="badge {{ $b->payment_status == 'success' ? 'bg-success' : ($b->payment_status == 'pending' ? 'bg-warning' : 'bg-danger') }}">
                            {{ is_array($b->payment_status) ? 'N/A' : ucfirst($b->payment_status ?? 'N/A') }}
                        </span>
                    </td>

                    
                    <td class="text-center">
                        <span class="{{ is_array($status['class']) ? 'badge bg-secondary' : $status['class'] }}">
                            {{ is_array($status['label']) ? 'Unknown' : $status['label'] }}
                        </span><br />

                        <div class="dropdown mt-2">
                            <button class="btn btn-sm btn-light border dropdown-toggle" type="button"
                                id="dropdownMenuButton{{ $b->id }}" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                👁️ View
                            </button>

                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $b->id }}">
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)"
                                        onclick="checkStatus('{{ $b->order_ref_id }}')">
                                        🔄 Check Status
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="openHotelBookingDetails({{ $b->id }})">
                                        📄 View Ticket
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ Myhelper::hasRole('admin') ? 8 : 7 }}" class="text-center text-danger py-4">No Bookings Details found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Hotel Ticket Modal -->
<div class="modal fade" id="hotelTicketModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary py-2 text-white">
                <h5 class="modal-title text-white">🏨 Hotel Booking Ticket</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0" id="ticketBody">
                <div class="text-center p-5 loading-spinner">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer p-2">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-sm" onclick="printHotelTicket()">
                    <i class="ti ti-printer me-1"></i> Print Ticket
                </button>
            </div>
        </div>
    </div>
</div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.2/jQuery.print.min.js"></script>
  <script src="https://unpkg.com/bwip-js/dist/bwip-js-min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function openHotelBookingDetails(id) {
    $('#hotelTicketModal').modal('show');
    $('#ticketBody').html('<div class="text-center p-5"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Fetching ticket details...</p></div>');

    $.ajax({
        url: "{{ route('hotel.viewTicket') }}",
        type: 'POST',
        data: {
            _token: "{{ csrf_token() }}",
            id: id
        },
        success: function(res) {
            if (res.status === 'success') {
                renderHotelTicket(res.data);
            } else {
                $('#ticketBody').html('<div class="alert alert-danger m-3">' + res.message + '</div>');
            }
        },
        error: function() {
            $('#ticketBody').html('<div class="alert alert-danger m-3">Something went wrong.</div>');
        }
    });
}

function renderHotelTicket(booking) {
    const payload = JSON.parse(booking.raw_payload);
    const hotelData = payload.HotelName || 'N/A';
    
    let guests = '';
    if (payload.HotelPassenger) {
        payload.HotelPassenger.forEach((p, index) => {
            guests += `<li>${index + 1}. ${p.Title} ${p.FirstName} ${p.LastName} (${p.PaxType || 'Adult'})</li>`;
        });
    }

    let html = `
        <div class="p-4" id="printableTicket">
            <div class="d-flex justify-content-between align-items-start mb-4 border-bottom pb-3">
                <div>
                    <h3 class="mb-0 text-primary">${hotelData}</h3>
                    <p class="text-muted mb-0 small">Booking Ref No: <strong class="text-dark">${booking.booking_ref_no || 'N/A'}</strong></p>
                    <p class="text-muted mb-0 small">Ticket No: <strong class="text-dark">${booking.ticket_no || 'N/A'}</strong></p>
                    <p class="text-muted mb-0 small">Hotel ID: <strong class="text-dark">${booking.hotel_id || 'N/A'}</strong></p>
                    <hr class="my-1"/>
                    <p class="text-muted mb-0 small">Order Ref ID: <span class="text-dark">${booking.order_ref_id || 'N/A'}</span></p>
                </div>
                <div class="text-end">
                    <span class="badge ${booking.booking_status === 'Confirmed' || booking.booking_status === 'success' ? 'bg-success' : (booking.booking_status === 'pending' ? 'bg-warning' : 'bg-danger')} fs-6 mb-1">${booking.booking_status}</span>
                    <p class="mb-0 text-muted small">Date: ${new Date(booking.created_at).toLocaleDateString()}</p>
                </div>
            </div>


            <div class="row mb-4">
                <div class="col-6">
                    <h6 class="fw-bold"><i class="ti ti-calendar-event me-1"></i> Stay Duration</h6>
                    <div class="bg-light p-2 rounded">
                        <div class="d-flex justify-content-between">
                            <span class="small text-muted">Check-In:</span>
                            <span class="fw-bold">${payload.CheckInDate || 'N/A'}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="small text-muted">Check-Out:</span>
                            <span class="fw-bold">${payload.CheckOutDate || 'N/A'}</span>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <h6 class="fw-bold"><i class="ti ti-users me-1"></i> Guest Details</h6>
                    <ul class="list-unstyled mb-0 small">
                        ${guests || '<li>No guest info</li>'}
                    </ul>
                </div>
            </div>

            <div class="mb-4">
                <h6 class="fw-bold border-bottom pb-2">🏨 Hotel Information</h6>
                <div class="row">
                    <div class="col-12">
                        <p class="mb-1 small"><strong>Rooms:</strong> ${booking.total_room || 'N/A'}</p>
                        <p class="mb-1 small"><strong>Address:</strong> ${payload.Address || 'Refer to search info'}</p>
                    </div>
                </div>
            </div>

            <div class="bg-light p-3 rounded">
                <h6 class="fw-bold mb-2">💰 Payment Summary</h6>
                <div class="d-flex justify-content-between mb-1">
                    <span>Amount Paid:</span>
                    <strong class="text-success">₹${parseFloat(booking.total_amount).toFixed(2)}</strong>
                </div>
                <div class="d-flex justify-content-between small">
                    <span>Payment Mode:</span>
                    <span>Wallet</span>
                </div>
                <div class="d-flex justify-content-between small">
                    <span>Payment Status:</span>
                    <span class="text-success fw-bold">${booking.payment_status.toUpperCase()}</span>
                </div>
            </div>

            <div class="mt-4 pt-4 border-top text-center text-muted small">
                <p class="mb-1">This is an electronically generated ticket. No signature is required.</p>
                <p class="mb-0">Thank you for booking with us!</p>
            </div>
        </div>
    `;
    $('#ticketBody').html(html);
}

function printHotelTicket() {
    const printContent = document.getElementById('printableTicket').innerHTML;
    const originalContent = document.body.innerHTML;
    document.body.innerHTML = printContent;
    window.print();
    document.body.innerHTML = originalContent;
    window.location.reload(); // Reload to restore event listeners
}
</script>


<div class="d-flex justify-content-center custom-pagination mt-2 mb-3">
    {!! $bookings->links('pagination::bootstrap-5') !!}
</div>

