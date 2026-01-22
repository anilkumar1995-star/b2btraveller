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
                  <h4 class="modal-title fw-semibold">Flight Ticket</h4>
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

          const originBusDet = booking?.BoardingPointdetails || {};
          const dropBusDet = booking?.DroppingPointdetails || {};

          const departTime = booking?.DepartureTime;
          const arrivalTime = booking?.ArrTime;

          let html = '';

          html += `<div>
                    <div class="bg-white p-4 rounded shadow-sm">

                        <div class="d-flex justify-content-between mb-4">
                            <img src="{{ asset('images/logo.png') }}" style="height:58px;">
                            <div class="text-end">
                                <div class="fw-bold">${booking.TravelName}</div>

                                <div class="text-muted small">
                                    ${booking.AirlineCode} (${segments[0]?.Airline?.AirlineName}) •
                                    ${segments[0]?.Airline?.FlightNumber}
                                </div>
                                <div>
                                    <h4> Booking ID: ${booking.BookingId || '-'}</h4>
                                </div>
                            </div>
                        </div>
                        <h4>✈️ ${originBusDet.AirportName || booking.Origin} → ${dropBusDet.AirportName || booking.Destination}</h4>

                        <div class="row ticket-route">


                            <div class="col-sm-6 p-3 text-center ticket-route">
                                <div class="mt-2 border rounded p-1  bg-label-warning">
                                    <span> PNR :
                                        <b>${booking.PNR || '-'}</b></span>
                                    <br />
                                    Invoice Number : <b>${booking.InvoiceNo || '-'}</b>
                                </div>

                                <br />
                                <div>
                                    ${booking.IsDomestic ? '<span class="text-success">DOMESTIC</span>' : '<span class="text-danger">INTERNATIONAL</span>'} |
                                    ${booking.IsAutoReissuanceAllowed ? '<span class="text-success">Auto Reissuance Allowed</span>' :
                                    '<span class="text-danger">Auto Reissuance Not Allowed</span>'} |
                                    ${booking.IsSeatsBooked ? '<span class="text-success">Seat Booked</span>' : '<span class="text-danger">Seat Not Booked</span>'} | ${booking.IsLCC ? '<span class="text-success">LCC</span>' : '<span class="text-danger">Non-LCC</span>'}
                                    |
                                    ${booking.NonRefundable ? '<span class="text-danger">Non-Refundable</span>' : '<span class="text-success">Refundable</span>'}
                                    <br />
                                    Airline Toll Free: ${booking.AirlineTollFreeNo
                                    ? `<a href="tel:${booking.AirlineTollFreeNo}" class="text-primary fw-semibold">
                                                  📞 ${booking.AirlineTollFreeNo}
                                              </a>`
                                    : '-'
                                    }
                                </div>
                            </div>

                            <div class="col-sm-6 p-3 ticket-route">

                                <div class="d-flex justify-content-between align-items-center">

                                    <div class="text-start">
                                        <div class="city-code">${originBusDet.AirportCode || ''}</div>
                                        <div class="city-name">${originBusDet.CityName || ''}</div>
                                        <div>
                                            ${departTime ? new Date(departTime).toLocaleDateString() : ''}<br>
                                            <strong>
                                                ${departTime ? new Date(departTime).toLocaleTimeString([],
                                                {hour:'2-digit',minute:'2-digit'}) : ''}
                                            </strong>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <h5>${
                                            lastSeg?.Duration
                                            ? Math.floor(lastSeg?.Duration / 60) + 'h ' + (lastSeg?.Duration % 60) + 'm'
                                            : '—'
                                            }</h5>
                                        <div class="route-line">
                                            <span></span>
                                            ✈️
                                            <span></span>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="city-code">${dropBusDet.AirportCode || ''}</div>
                                        <div class="city-name">${dropBusDet.CityName || ''}</div>
                                        <div class="text-end">
                                            ${arrivalTime ? new Date(arrivalTime).toLocaleDateString() : ''}<br>
                                            <strong>
                                                ${arrivalTime ? new Date(arrivalTime).toLocaleTimeString([],
                                                {hour:'2-digit',minute:'2-digit'}) : ''}
                                            </strong>
                                        </div>

                                    </div>

                                </div>


                                <hr>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-start"><b>Aircraft:</b> ${firstSeg.Craft}</div>
                                    <div class="text-enter"><b>Fare Type:</b> ${booking.FareType}</div>
                                    <div class="text-end"><b>Fare Class:</b> ${booking.SupplierFareClasses}</div>
                                </div>
                            </div>
                        </div>
                    

                        <div class="pt-3 passenger-section">

                            <div class="passenger-head">
                                PASSENGER DETAILS
                            </div>


                            ${passengers.map((p, index) => `
                                      <div class="passenger-card">

                                          <div class="row align-items-center mb-2">
                                              <div class="col-5 text-start">
                                                  <b>${p.Title} ${p.FirstName} ${p.LastName}</b> | ${p.Gender == 1 ? 'Male' : 'Female'} |
                                                  ${p.Nationality} <span class="badge bg-label-success">${booking.PNR || '-'}</span>
                                                  ${p.IsLeadPax ? '<span class="lead-pax">Lead</span>' : ''}
                                                  <div class="contact-box w-50 text-start">
                                                      <div class="mb-1"><b>Mobile:</b> ${p.ContactNo}</div>
                                                      <div class="mb-1"><b>Email:</b> ${p.Email}</div>
                                                      <div class="mb-1"><b>City:</b> ${p.City}, ${p.CountryCode}</div>
                                                      <div class="mb-1"><b>DOB:</b> ${new Date(p.DateOfBirth).toLocaleDateString()}</div>
                                                  </div>
                                              </div>

                                              <div class="col-3 text-start">
                                                  <h5>Invoice Details</h5>
                                                  <div class="mb-1"><b>Invoice No:</b> ${booking.InvoiceNo}</div>
                                                  <div class="mb-1"><b>Invoice Amount:</b> ₹${booking.InvoiceAmount}</div>
                                                  <div class="mb-1"><b>Created On:</b> ${new Date(booking.InvoiceCreatedOn).toLocaleString()}</div>
                                              </div>
                                              <div class="col-4 text-end">
                                                  <h5>Ticket Details</h5>
                                                  ${p.Ticket ? `
                                        <div class="mb-1"><b>Issued On: </b> ${new Date(p.Ticket.IssueDate).toLocaleString()}</div>
                                        <div class="mb-1">${(() => {
                                            const s = getTicketStatus(p.Ticket.Status);
                                            return `
                                                      <div class="mb-1">
                                                          <b>Status:</b>
                                                          <span class="badge ${s.badge}">${s.text}</span>
                                                      </div>
                                                      `;
                                            })()}
                                        </div>
                                        <div class="mb-1"><b>Validating Airline: </b> ${p.Ticket.ValidatingAirline}</div>
                                        <div class="mb-1"><b>Ticket Id: </b> ${p.Ticket.TicketId}</div>
                                        ` : `
                                        <div class="mb-1 text-danger">
                                            <b>Status:</b> Ticket not generated
                                        </div>
                                        `}

                                              </div>
                                          </div>

                                          <div class="seat-box">
                                              <div class="seat-title">Seat Details</div>
                                              ${p.SeatDynamic?.map(s => `
                                    <div class="seat-row">
                                        <span>${s.Origin} → ${s.Destination}</span>
                                        <span class="seat-code">${s.Code}</span>
                                        <span class="seat-type">${s.Text}</span>
                                        <span>₹${s.Price}</span>
                                    </div>
                                    `).join('') || '<div class="seat-row">No seat selected</div>'
                                              }
                                          </div>

                                          <div class="ssr-box mt-3">
                                              <div class="seat-title">Special Service Requests (SSR)</div>
                                              ${renderSSR(p.Ssr)}
                                          </div>
                                          <div class="baggage-allow-box mt-2">
                                              <div class="seat-title">Baggage Allowance</div>


                                              <div class="row text-muted mb-2">
                                                  ${p.SegmentAdditionalInfo?.map(b => `
                                            <div class="col-4 text-start">
                                                <b>Check-in :</b>
                                                <span>${b.Baggage || '-'}</span>
                                            </div>
                                            <div class="col-4 text-center">
                                                <b>Cabin :</b>
                                                <span>${b.CabinBaggage || '-'}</span>
                                            </div>
                                            <div class="col-4 text-end">
                                                <b>Meal :</b>
                                                <span>${b.Meal || 'Not Included'}</span>
                                            </div>
                                        `).join('')}
                                              </div>
                                          </div>
                                          <hr />
                                          <div class="fare-box">
                                              <div><b>Base Fare:</b> ₹${p.Fare.BaseFare}</div>
                                              <div><b>Tax:</b> ₹${p.Fare.Tax}</div>
                                              <div><b>Seat Charges:</b> ₹${p.Fare.TotalSeatCharges}</div>
                                              <div class="fare-total">
                                                  Total: ₹${p.Fare.PublishedFare}
                                              </div>
                                          </div>
                                          <div class="barcode text-center mt-3">
                                              <canvas id="barcodeCanvas${index}"></canvas>
                                          </div>

                                      </div>
                                      `).join('')}
                        </div>
                        <div class="mt-4 p-3 bg-white rounded text-end">
                            <span class="text-success">
                                You have paid <h4>INR ${booking?.Fare?.PublishedFare || '-'}</h4>
                            </span>
                        </div>

                        <div class="ticket-route">

                            <div class="row g-0">

                                <div class="col-sm-9 border-end">

                                    <div class="p-2 px-3 fw-semibold text-white" style="background:#d7261e; border-radius:8px 8px 0 0;">
                                        Items not allowed in the aircraft
                                    </div>

                                    <div class="p-3">
                                        <div class="d-flex flex-wrap gap-4">

                                            <div class="text-center" style="width:100px;">
                                                <img src="{{ asset('/images/restricted/lighter.jpeg') }}" style="height:50px;">
                                                <div class="mt-1">LIGHTERS,<br>MATCHSTICKS</div>
                                            </div>

                                            <div class="text-center" style="width:120px;">
                                                <img src="{{ asset('/images/restricted/flame.jpeg') }}" style="height:50px;">
                                                <div class="mt-1">FLAMMABLE<br>LIQUIDS</div>
                                            </div>

                                            <div class="text-center" style="width:100px;">
                                                <img src="{{ asset('/images/restricted/toxic.png') }}" style="height:50px;">
                                                <div class="mt-1">TOXIC</div>
                                            </div>

                                            <div class="text-center" style="width:100px;">
                                                <img src="{{ asset('/images/restricted/corrosive.jpeg') }}" style="height:50px;">
                                                <div class="mt-1">CORROSIVES</div>
                                            </div>

                                            <div class="text-center" style="width:100px;">
                                                <img src="{{ asset('/images/restricted/paper.png') }}" style="height:50px;">
                                                <div class="mt-1">PEPPER<br>SPRAY</div>
                                            </div>

                                            <div class="text-center" style="width:120px;">
                                                <img src="{{ asset('/images/restricted/gas.png') }}" style="height:50px;">
                                                <div class="mt-1">FLAMMABLE<br>GAS</div>
                                            </div>

                                            <div class="text-center" style="width:100px;">
                                                <img src="{{ asset('/images/restricted/cigrate.jpeg') }}" style="height:50px;">
                                                <div class="mt-1">E-CIGARETTE</div>
                                            </div>

                                            <div class="text-center" style="width:120px;">
                                                <img src="{{ asset('/images/restricted/infection.png') }}" style="height:50px;">
                                                <div class="mt-1">INFECTIOUS<br>SUBSTANCES</div>
                                            </div>

                                            <div class="text-center" style="width:130px;">
                                                <img src="{{ asset('/images/restricted/redio.jpeg') }}" style="height:50px;">
                                                <div class="mt-1">RADIOACTIVE<br>MATERIALS</div>
                                            </div>

                                            <div class="text-center" style="width:130px;">
                                                <img src="{{ asset('/images/restricted/explosive.jpeg') }}" style="height:50px;">
                                                <div class="mt-1">EXPLOSIVES<br>AMMUNITION</div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">

                                    <div class="p-2 fw-semibold text-white text-center"
                                        style="background:#f8a900; border-radius:8px 8px 0 0;">
                                        Items allowed only<br>in Hand Baggage
                                    </div>

                                    <div class="p-4 text-center">

                                        <div class="mb-4">
                                            <img src="{{ asset('/images/restricted/lithium.png') }}" style="height:50px;">
                                            <div class="mt-1">LITHIUM<br>BATTERIES</div>
                                        </div>

                                        <div>
                                            <img src="{{ asset('/images/restricted/powerbank.png') }}" style="height:50px;">
                                            <div class="mt-1">POWER<br>BANKS</div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                        `;


          html += `<div class="rticket-route mt-4 ticket-route">
                            <div class="p-3 d-flex justify-content-between align-items-center" style="background:#eef3ff;">
                                <div class="fw-semibold ">
                                    🪶 Fare Rules
                                </div>
                            </div>
                            <div class="p-3" style="background:#e8ffec; font-size:14px;">`;

          booking.FareRules.forEach(r => {
              html += `
                                <div class="mb-3">
                                    <b>${r.Origin} → ${r.Destination}</b>
                                    <div class="small">${r.FareRuleDetail}</div>
                                </div>`;
          });

          html += `
                            </div>
                        </div>

                        <div class="ticket-route mt-4" style="border-left:4px solid #c2c2c2;">
                            <h6 class="fw-semibold my-3">IMPORTANT INFORMATION</h6>
                            <ul class="">
                                <li>Reach airport 3 hours before departure</li>
                                <li>Carry valid government ID</li>
                                <li>Do not share OTP or CVV</li>
                            </ul>
                        </div>
                    </div>
                </div>`;

          $('#ticketContent').html(html);

          setTimeout(() => {
              passengers.forEach((p, index) => {
                  let barcode = booking.PNR;
                  if (p.BarcodeDetails && p.BarcodeDetails.Barcode && p.BarcodeDetails.Barcode.length >
                      0) {
                      barcode = p.BarcodeDetails.Barcode[0].Content ?? "N/A";
                  }
                  makeBarcode(index, barcode);
              });
          }, 100);
      }


    //   function makeBarcode(i, barcode) {
    //       const canvas = document.getElementById("barcodeCanvas" + i);

    //       if (!canvas) return;

    //       try {
    //           bwipjs.toCanvas(canvas, {
    //               bcid: 'pdf417',
    //               text: barcode,
    //               scale: 2,
    //               height: 8,
    //               columns: 6,
    //               rows: 3,
    //               includetext: false,
    //               paddingwidth: 10,
    //               paddingheight: 10,
    //           });
    //       } catch (e) {
    //           $(canvas).replaceWith(`<code class="text-primary">${barcode}</code>`);
    //       }
    //   }

    //   function printTicket() {
    //       const printContent = document.getElementById("ticketContent").innerHTML;
    //       const originalContent = document.body.innerHTML;

    //       document.body.innerHTML = printContent;
    //       window.print();
    //       document.body.innerHTML = originalContent;

    //       location.reload();
    //   }

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
