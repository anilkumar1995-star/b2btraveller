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

    /* Reset */
    html, body {
        margin: 0 !important;
        padding: 0 !important;
        height: auto !important;
        overflow: hidden !important;
    }

    /* Hide everything */
    body * {
        visibility: hidden !important;
    }

    /* Show only ticket */
    #ticketContent,
    #ticketContent * {
        visibility: visible !important;
    }

    #ticketContent {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        padding: 10px !important;
        margin: 0 !important;
    }

    /* Remove bootstrap spacing */
    .container,
    .card,
    .ticket-card {
        margin: 0 !important;
        padding: 10px !important;
        box-shadow: none !important;
    }

    /* Prevent page break */
    .ticket-card,
    .passenger-card,
    .barcode-card {
        page-break-inside: avoid !important;
        break-inside: avoid !important;
    }

    /* Hide UI */
    .modal-header,
    .modal-footer,
    .btn,
    .dropdown,
    .pagination,
    .card-datatable,
    table {
        display: none !important;
    }
}


      action-btn {
          background-color: rgba(49, 84, 255, 0.1);
      }
  </style>

  <div class="card-datatable table-responsive p-2">
      <table class="table table-striped" id="bookingTable">
          <thead class="bg-light">
              <tr>
                  <th width="10%">ID</th>
                  <th width="10%">User</th>
                  <th width="15%">Booking Details</th>
                  <th width="15%">Bus Details</th>
                  <th width="10%">Amount</th>
                  <th width="10%">Type</th>
                  <th class="text-center" width="10%">Action</th>
              </tr>
          </thead>

          <tbody>
              @php
                  $statusMap = [
                      1 => ['label' => 'Tentative', 'class' => 'badge bg-warning text-dark'],
                      2 => ['label' => 'Confirmed', 'class' => 'badge bg-success'],
                      3 => ['label' => 'Cancelled', 'class' => 'badge bg-secondary'],
                      4 => ['label' => 'Failed', 'class' => 'badge bg-danger'],
                      5 => ['label' => 'Pending', 'class' => 'badge bg-info'],

                      'Tentative' => ['label' => 'Tentative', 'class' => 'badge bg-warning text-dark'],
                      'Confirmed' => ['label' => 'Confirmed', 'class' => 'badge bg-success'],
                      'Cancelled' => ['label' => 'Cancelled', 'class' => 'badge bg-secondary'],
                      'Failed' => ['label' => 'Failed', 'class' => 'badge bg-danger'],
                      'Pending' => ['label' => 'Pending', 'class' => 'badge bg-info'],
                  ];

              @endphp

              @if (!empty($bookings) && $bookings->count() > 0)
                  @foreach ($bookings as $b)
                      @php
                          $status = $statusMap[$b->booking_status] ?? [
                              'label' => 'N/A',
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
                          <td>Bus Id:
                              <b>{{ $b->bus_id ?? 'N/A' }}</b>
                              <br />
                              PNR: <b>{{ $b->pnr ?? 'N/A' }}</b><br />
                              Route: {{ $b->origin ?? 'N/A' }} → {{ $b->destination ?? 'N/A' }}
                          </td>

                          <td>{{ $b->travel_name }} - [{{ $b->bus_type }}] <br />
                              Journey : <b>{{ \Carbon\Carbon::parse($b->departure_time)->format('d M Y, h:i A') }}</b>
                              →
                              <b> {{ \Carbon\Carbon::parse($b->arrival_time)->format('d M Y, h:i A') }}</b>
                          </td>

                          <td>₹{{ $b->total_amount ?? 0 }}</td>

                          <td>
                              {!! $b->is_pricechange == 'true'
                                  ? '<span class="text-success">Price Change</span>'
                                  : '<span class="text-danger">Price Not Change</span>' !!}
                              <br />
                              Total Seat: <span class="badge bg-info">{{ $b->total_seats }}</span>
                          </td>
                          <td>
                              <span class="{{ $status['class'] }}">
                                  {{ $status['label'] }}
                              </span>
                              <br />
                              <div class="dropdown mt-1">
                                  <button class="btn btn-sm btn-light border dropdown-toggle" type="button"
                                      id="dropdownMenuButton{{ $b->id }}" data-bs-toggle="dropdown"
                                      aria-expanded="false">
                                      👁️ View
                                  </button>

                                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $b->id }}">


                                      <li>
                                          <a class="dropdown-item" href="javascript:void(0)"
                                              onclick="openBookingDetails({{ $b->bus_id }})">
                                              📄 Booking Details
                                          </a>
                                      </li>
                                      <li>
                                          <a class="dropdown-item cancel-flight" href="javascript:void(0)">
                                              {{-- data-bookingidcancel="{{ $b->booking_id_api }}"
                                              data-ticketstatus="{{ $b->ticket_status }}" --}}
                                              ✈️ Cancel Bus
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

  <div class="modal fade" id="viewTicketModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-fullscreen">
          <div class="modal-content">

              <div class="modal-header border-0">
                  <h4 class="modal-title fw-semibold">Bus Ticket</h4>
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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.2/jQuery.print.min.js"></script>

  <script src="https://unpkg.com/bwip-js/dist/bwip-js-min.js"></script>
  <script src="{{ asset('') }}js/busbook.js"></script>
  <script type="text/javascript">
      function openBookingDetails(busId) {

          $('#ticketContent').html(`
                <div class="text-center py-5">
                    <div class="spinner-border text-primary"></div>
                    <p class="mt-2">Fetching booking details...</p>
                </div>
            `);

          $('#viewTicketModal').modal('show');

          $.ajax({
              url: "/bus/booking-view",
              type: "POST",
              data: {
                  busId: busId,
                  _token: "{{ csrf_token() }}"
              },
              success: function(res) {

                  if (res.status !== 'success') {
                      $('#ticketContent').html(`<div class="alert alert-danger">${res.message}</div>`);
                      return;
                  }

                  const booking = res?.data?.Response;

                  if (!booking) {
                      $('#ticketContent').html(`<div class="alert alert-danger">Invalid booking data</div>`);
                      return;
                  }

                  getDetails(booking);
              },
              error: function() {
                  $('#ticketContent').html(`
                    <div class="alert alert-danger text-center">
                        Unable to fetch booking details.
                    </div>
                `);
              }
          });
      }

      //   function getSsrIcon(code) {
      //       switch (code) {
      //           case 'SEAT':
      //               return '💺';
      //           case 'MEAL':
      //               return '🍱';
      //           case 'BAGGAGE':
      //               return '🧳';
      //           case 'WCHR':
      //               return '♿';
      //           case 'PETC':
      //               return '🐶';
      //           default:
      //               return '📝';
      //       }
      //   }

      //   function renderSSR(ssrList = []) {

      //       if (!ssrList.length) {
      //           return `<div class="text-muted small">No special services selected</div>`;
      //       }

      //       return ssrList.map(ssr => `
    //             <div class="d-flex justify-content-between border-bottom py-1">
    //                 <div>
    //                     ${getSsrIcon(ssr.SsrCode)}
    //                     <b>${ssr.SsrCode}</b>
    //                     <div class="text-muted small">${ssr.Detail}</div>
    //                 </div>
    //                 <div class="fw-semibold">₹${ssr.Price || 0}</div>
    //             </div>
    //         `).join('');
      //   }


      //   function getTicketStatus(status) {

      //       // STRING STATUS (current case)
      //       if (typeof status === 'string') {
      //           if (status === 'OK') {
      //               return {
      //                   text: 'Confirmed',
      //                   badge: 'bg-success'
      //               };
      //           }
      //           return {
      //               text: status,
      //               badge: 'bg-danger'
      //           };
      //       }

      //       // NUMBER STATUS (future / other APIs)
      //       const statusMap = {
      //           0: {
      //               text: 'Failed',
      //               badge: 'bg-danger'
      //           },
      //           1: {
      //               text: 'Successful',
      //               badge: 'bg-success'
      //           },
      //           2: {
      //               text: 'Not Saved',
      //               badge: 'bg-warning text-dark'
      //           },
      //           3: {
      //               text: 'Not Created',
      //               badge: 'bg-warning text-dark'
      //           },
      //           4: {
      //               text: 'Not Allowed',
      //               badge: 'bg-secondary'
      //           },
      //           5: {
      //               text: 'In Progress',
      //               badge: 'bg-info'
      //           },
      //           6: {
      //               text: 'Already Created',
      //               badge: 'bg-primary'
      //           },
      //           8: {
      //               text: 'Price Changed',
      //               badge: 'bg-danger'
      //           },
      //           9: {
      //               text: 'Other Error',
      //               badge: 'bg-danger'
      //           }
      //       };

      //       return statusMap[status] || {
      //           text: 'Unknown',
      //           badge: 'bg-dark'
      //       };
      //   }


    function getDetails(booking) {
    console.log(booking);

    const passengers = booking?.Passenger || [];
    const board = booking?.BoardingPointdetails || {};
    const drop = booking?.DroppingPointdetails || {};

    let html = `
    <div class="container">

        <!-- TICKET CARD -->
        <div class="card ticket-card shadow-sm rounded-4 p-4 mb-3">

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                <div>
                    <h4 class="mb-0">${booking.TravelName}</h4>
                    <div class="text-muted">${booking.BusType}</div>
                </div>
                <div class="text-end">
                    <div class="fw-semibold">Ticket No</div>
                    <div class="fs-5">${booking.TicketNo}</div>
                </div>
            </div>

            <!-- ROUTE -->
            <div class="ticket-route p-3 mb-3">
                <div class="row align-items-center text-center">
                    <div class="col-sm-4">
                        <div class="city-code">${booking.Origin}</div>
                        <div class="city-name">${board.CityPointName || ''}</div>
                        <div class="fw-semibold">
                            ${board.CityPointTime ? new Date(board.CityPointTime).toLocaleString() : '-'}
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="route-line justify-content-center">
                            <span></span> 🚌 <span></span>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="city-code">${booking.Destination}</div>
                        <div class="city-name">${drop.CityPointName || ''}</div>
                        <div class="fw-semibold">
                            ${booking.ArrivalTime ? new Date(booking.ArrivalTime).toLocaleString() : '-'}
                        </div>
                    </div>
                </div>
            </div>

            <!-- BOOKING INFO -->
            <div class="row text-center mb-3">
                <div class="col">
                    <b>Seats</b><br>${booking.NoOfSeats}
                </div>
                <div class="col">
                    <b>Status</b><br>
                    <span class="badge bg-success">Confirmed</span>
                </div>
                <div class="col">
                    <b>Invoice</b><br>${booking.InvoiceNumber}
                </div>
                <div class="col">
                    <b>Amount</b><br>₹${booking.InvoiceAmount}
                </div>
            </div>

            <!-- PASSENGERS -->
            <div class="passenger-section p-3">
                <div class="passenger-head">Passenger Details</div>

                ${passengers.map((p, i) => `
                    <div class="passenger-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="passenger-name">
                                    ${p.Title} ${p.FirstName || ''}
                                    ${p.LeadPassenger ? '<span class="lead-pax">Lead</span>' : ''}
                                </div>
                                <div class="text-muted">
                                    Age: ${p.Age} | ${p.Gender == 1 ? 'Male' : 'Female'}
                                </div>
                            </div>

                            <div class="barcode-card p-2 text-center">
                                <canvas id="barcodeCanvas${i}" class="barcode-img"></canvas>
                            </div>
                        </div>
                    </div>
                `).join('')}
            </div>

            <!-- CANCELLATION -->
            <div class="mt-4">
                <h6 class="fw-semibold">Cancellation Policy</h6>
                ${booking.CancelPolicy?.map(c => `
                    <div class="small text-muted">
                        ${c.PolicyString} — <b>${c.CancellationCharge}%</b>
                    </div>
                `).join('')}
            </div>

            <!-- PAYMENT -->
            <div class="mt-4 p-3 bg-light rounded text-end">
                <div class="fw-semibold">Total Paid</div>
                <h4 class="text-success mb-0">
                    ₹${booking.Price?.PublishedPriceRoundedOff}
                </h4>
            </div>

        </div>
    </div>
    `;

    $('#ticketContent').html(html);

    // BARCODE
    setTimeout(() => {
        passengers.forEach((p, i) => {
            makeBarcode(i, booking.TicketNo + '-' + (i + 1));
        });
    }, 100);
}



        function makeBarcode(i, barcode) {
            const canvas = document.getElementById("barcodeCanvas" + i);

            if (!canvas) return;

            try {
                bwipjs.toCanvas(canvas, {
                    bcid: 'pdf417',
                    text: barcode,
                    scale: 2,
                    height: 8,
                    columns: 6,
                    rows: 3,
                    includetext: false,
                    paddingwidth: 10,
                    paddingheight: 10,
                });
            } catch (e) {
                $(canvas).replaceWith(`<code class="text-primary">${barcode}</code>`);
            }
        }

        function printTicket() {
           
            window.print();
          
        }

      //   $(document).on('click', '.generate-ticket', function() {

      //       const payload = $(this).data('payload');
      //       let journeyType = $(this).data('journeytype');

      //       swal({
      //           title: "Generate Ticket?",
      //           html: `
    //             <p>Are you sure you want to generate the ticket?</p>
    //             <small class="text-muted">Once generated, it cannot be reversed.</small>
    //         `,
      //           type: "warning",
      //           showCancelButton: true,
      //           confirmButtonText: "Yes, Generate",
      //           cancelButtonText: "Cancel",
      //           allowOutsideClick: false,
      //           allowEscapeKey: false
      //       }).then((result) => {
      //           if (result.value || result === true) {
      //               ViewTicketAjax(payload, '/flight/ticket', 'departure', journeyType === 'oneway' ? '1' :
      //                   '2', 'table');
      //           }
      //       });

      //   });


      //   $(document).on('click', '.cancel-flight', function() {

      //       const bookingId = $(this).data('bookingidcancel');
      //       const ticketStatus = $(this).data('ticketstatus');

      //       if (ticketStatus !== 'Successful') {
      //           swal({
      //               title: 'Ticket is Not Confirmed',
      //               text: 'Cancellation is not allowed.',
      //               type: 'warning',
      //               confirmButtonText: 'OK',
      //               allowOutsideClick: false,
      //               allowEscapeKey: false
      //           });
      //           return;
      //       }

      //       const encoded = btoa(JSON.stringify(bookingId));
      //       swal({
      //           title: 'Cancel this flight?',
      //           text: 'Cancellation charges may apply.',
      //           type: 'warning',
      //           showCancelButton: true,
      //           confirmButtonText: 'Yes, Cancel Flight',
      //           allowOutsideClick: false,
      //           allowEscapeKey: false,
      //           cancelButtonText: 'No',
      //       }).then((result) => {
      //           if (result.value) {
      //               window.location.href = `/flight/cancel/${encoded}`;
      //           }
      //       });

      //   });
  </script>
