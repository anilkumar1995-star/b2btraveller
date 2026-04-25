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

    .custom-pagination .page-item.disabled .page-link {
        background: #f3f3f3;
        color: #999;
        border-color: #e1e1e1;
    }

    .pagination {
        margin-left: 5px !important;
    }
</style>

<div class="card-datatable table-responsive p-2">
    <table class="table table-striped" id="failedBookingTable">
        <thead class="bg-light">
            <tr>
                <th>ID</th>
                @if (Myhelper::hasRole('admin'))
                    <th>User</th>
                @endif
                <th>Hotel</th>
                <th>Total Amount</th>
                <th>Payment Status</th>
                <th>Status</th>
                <th>Message</th>
            </tr>
        </thead>

        <tbody>
            @forelse($bookings as $b)
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
                        @php
                            $payload = json_decode($b->raw_payload);
                            $hotelName = $payload->HotelName ?? $payload->hotel_name ?? 'N/A';
                            if (is_array($hotelName)) {
                                $hotelName = $hotelName[0] ?? 'N/A';
                            }
                        @endphp
                        <b>{{ $hotelName }}</b>
                    </td>
                    <td>₹{{ number_format($b->total_amount ?? 0, 2) }}</td>
                    <td>
                        <span class="badge bg-danger">Failed</span>
                    </td>
                    <td>
                        <span class="badge bg-danger">{{ $b->booking_status ?? 'failed' }}</span>
                    </td>
                    <td>
                        {{ $b->message ?? 'N/A' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ Myhelper::hasRole('admin') ? 7 : 6 }}" class="text-center text-danger py-4">No Failed Bookings Details found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-center custom-pagination mt-2 mb-3">
    {!! $bookings->links('pagination::bootstrap-5') !!}
</div>
