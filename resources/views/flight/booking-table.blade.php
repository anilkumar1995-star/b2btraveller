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
  <div class="card-datatable table-responsive p-2">
      <table class="table table-striped">
          <thead class="bg-light text-center">
              <tr>
                  <th>ID</th>
                  <th>User</th>
                  <th>Booking Details</th>
                  <th>Route</th>
                  <th>Amount</th>
                  <th>Type</th>
                  <th class="text-center">Action</th>
              </tr>
          </thead>

          <tbody>
              @php
                  $statusMap = [
                      'NotSet' => ['label' => 'Not Set', 'class' => 'badge bg-secondary'],
                      'Successful' => ['label' => 'Successful', 'class' => 'badge bg-success'],
                      'Failed' => ['label' => 'Failed', 'class' => 'badge bg-danger'],
                      'OtherFare' => ['label' => 'Other Fare', 'class' => 'badge bg-info'],
                      'OtherClass' => ['label' => 'Other Class', 'class' => 'badge bg-warning'],
                      'BookedOther' => ['label' => 'Booked Other', 'class' => 'badge bg-primary'],
                      'NotConfirmed' => ['label' => 'Not Confirmed', 'class' => 'badge bg-dark'],
                  ];
              @endphp
              {{-- @dd($bookings); --}}
              @if (!empty($bookings) && $bookings->count() > 0)
                  @foreach ($bookings as $b)
                      @php
                          $status = $statusMap[$b->booking_status] ?? [
                              'label' => 'Unknown',
                              'class' => 'badge bg-secondary',
                          ];
                      @endphp
                      <tr>
                          <td>##{{ $b->id }} <br />{{ $b->created_at }}</td>
                          <td>
                              {{ $b->user_name ?? '' }}<br />
                              {{ $b->user_email ?? '' }}<br />
                              {{ $b->user_mobile ?? '' }}
                          </td>
                          <td>PNR: <b>{{ $b->pnr ?? 'N/A' }}</b> <br /> Booking Id:
                              <b>{{ $b->booking_id_api ?? 'N/A' }}</b>
                              <br />{{ $b->airline_code }} - [{{ $b->flight_number }}]
                          </td>

                          <td>{{ $b->origin }} <br /> {{ $b->destination }}</td>
                          <td>₹{{ $b->total_amount ?? 0 }}</td>

                          <td>{!! $b->is_lcc === 'true' ? '<span class="text-success">LCC</span>' : '<span class="text-danger">Non-LCC</span>' !!}

                              <br>

                              {!! $b->is_refundable === 'true'
                                  ? '<span class="text-success">Refundable</span>'
                                  : '<span class="text-danger">Non-Refundable</span>' !!}
                          </td>
                          <td>
                              <span class="{{ $status['class'] }}">
                                  {{ $status['label'] }}
                              </span><br />
                              <div class="dropdown mt-1">
                                  <button class="btn btn-sm btn-light border dropdown-toggle" type="button"
                                      id="dropdownMenuButton{{ $b->id }}" data-bs-toggle="dropdown"
                                      aria-expanded="false">
                                      👁️ View
                                  </button>

                                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $b->id }}">
                                      @if ($b->is_lcc !== 'true')
                                          <li>
                                              <a class="dropdown-item" href="javascript:void(0)"  data-id="{{ $b->id }}>
                                                  🎫 View Ticket
                                              </a>
                                          </li>
                                      @endif


                                      <li>
                                          <a class="dropdown-item booking-details d-none" href="javascript:void(0)"  data-id="{{ $b->id }}>
                                              📄 Booking Details
                                          </a>
                                      </li>
                                      <li>
                                          <a class="dropdown-item cancel-flight" href="javascript:void(0)"  data-id="{{ $b->id }}>
                                              ✈️ Cancel Flight
                                          </a>
                                      </li>
                                  </ul>
                              </div>
                          </td>
                      </tr>
                  @endforeach
              @else
                  <tr>
                      <td colspan="7" class="text-center text-danger">No Bookings Details found.</td>
                  </tr>
              @endif
          </tbody>
      </table>
  </div>

  <div class="d-flex justify-content-center custom-pagination mt-2 mb-3">
      {!! $bookings->links('pagination::bootstrap-5') !!}
  </div>
