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
                  <th>ID</th>
                  <th>User</th>
                  <th>Booking Details</th>
                  <th>Route</th>
                  <th>Amount</th>
                  <th>Type</th>
                  <th>Ticket Status</th>
                  <th class="text-center">Action</th>
              </tr>
          </thead>

          <tbody>
              <?php
                  $statusMap = [
                      'NotSet' => ['label' => 'Not Set', 'class' => 'badge bg-secondary'],
                      'Successful' => ['label' => 'Successful', 'class' => 'badge bg-success'],
                      'Failed' => ['label' => 'Failed', 'class' => 'badge bg-danger'],
                      'OtherFare' => ['label' => 'Other Fare', 'class' => 'badge bg-info'],
                      'OtherClass' => ['label' => 'Other Class', 'class' => 'badge bg-warning'],
                      'BookedOther' => ['label' => 'Booked Other', 'class' => 'badge bg-primary'],
                      'NotConfirmed' => ['label' => 'Not Confirmed', 'class' => 'badge bg-dark'],
                  ];
              ?>
              
              <?php if(!empty($bookings) && $bookings->count() > 0): ?>
                  <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php
                          $status = $statusMap[$b->booking_status] ?? [
                              'label' => 'Unknown',
                              'class' => 'badge bg-secondary',
                          ];
                      ?>
                      <tr>
                          <td>##<?php echo e($b->id); ?> <br /><?php echo e($b->created_at); ?></td>
                          <td>
                              <?php echo e($b->user_name ?? ''); ?><br />
                              <?php echo e($b->user_email ?? ''); ?><br />
                              <?php echo e($b->user_mobile ?? ''); ?>

                          </td>
                          <td>PNR: <b><?php echo e($b->pnr ?? 'N/A'); ?></b> <br /> Booking Id:
                              <b><?php echo e($b->booking_id_api ?? 'N/A'); ?></b>
                              <br /><?php echo e($b->airline_code); ?> - [<?php echo e($b->flight_number); ?>]
                          </td>

                          <td><?php echo e($b->origin); ?> <br /> <?php echo e($b->destination); ?></td>
                          <td>₹<?php echo e($b->total_amount ?? 0); ?></td>

                          <td><?php echo $b->is_lcc === 'true' ? '<span class="text-success">LCC</span>' : '<span class="text-danger">Non-LCC</span>'; ?>


                              <br>

                              <?php echo $b->is_refundable === 'true'
                                  ? '<span class="text-success">Refundable</span>'
                                  : '<span class="text-danger">Non-Refundable</span>'; ?>

                              <br />
                              <span class="badge bg-info"><?php echo e($b->journey_type); ?></span>
                          </td>
                          <td><?php echo $b->ticket_status == 'pending'
                              ? '<span class="badge bg-warning">Pending</span>'
                              : '<span class="badge bg-success">Confirmed</span>'; ?>


                          </td>
                          <td>
                              <span class="<?php echo e($status['class']); ?>">
                                  <?php echo e($status['label']); ?>

                              </span><br />
                              <div class="dropdown mt-1">
                                  <button class="btn btn-sm btn-light border dropdown-toggle" type="button"
                                      id="dropdownMenuButton<?php echo e($b->id); ?>" data-bs-toggle="dropdown"
                                      aria-expanded="false">
                                      👁️ View
                                  </button>

                                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo e($b->id); ?>">

                                      <?php if($b->is_lcc !== 'true' && $b->ticket_status === 'pending'): ?>
                                          <li>
                                              <a class="dropdown-item  generate-ticket" href="javascript:void(0)"
                                                  data-id="<?php echo e($b->id); ?>"
                                                  data-journeytype = "<?php echo e($b->journey_type); ?>"
                                                  data-payload='<?php echo json_encode(json_decode($b->raw_payload), 15, 512) ?>'>
                                                  🎫 Generate Ticket
                                              </a>
                                          </li>
                                      <?php endif; ?>


                                      <li>
                                          <a class="dropdown-item" href="javascript:void(0)"
                                              onclick="openBookingDetails(<?php echo e($b->id); ?>)">
                                              📄 Booking Details
                                          </a>
                                      </li>
                                      <li>
                                          <a class="dropdown-item cancel-flight" href="javascript:void(0)"
                                              data-id="<?php echo e($b->id); ?>">
                                              ✈️ Cancel Flight
                                          </a>
                                      </li>
                                  </ul>
                              </div>
                          </td>
                      </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php else: ?>
                  <tr>
                      <td colspan="7" class="text-center text-danger">No Bookings Details found.</td>
                  </tr>
              <?php endif; ?>
          </tbody>
      </table>
  </div>

  <div class="d-flex justify-content-center custom-pagination mt-2 mb-3">
      <?php echo $bookings->links('pagination::bootstrap-5'); ?>

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
  </style>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.2/jQuery.print.min.js"></script>

  <script src="https://unpkg.com/bwip-js/dist/bwip-js-min.js"></script>
  <script src="<?php echo e(asset('')); ?>js/flight.js"></script>
  <script type="text/javascript">
      function openBookingDetails(bookingId) {

          $('#ticketContent').html(`
                <div class="text-center py-5">
                    <div class="spinner-border text-primary"></div>
                    <p class="mt-2">Fetching booking details...</p>
                </div>
            `);

          $('#viewTicketModal').modal('show');

          $.ajax({
              url: "/flight/booking-view",
              type: "POST",
              data: {
                  booking_id: bookingId,
                  _token: "<?php echo e(csrf_token()); ?>"
              },
              success: function(res) {

                  if (res.status !== 'success') {
                      $('#ticketContent').html(`<div class="alert alert-danger">${res.message}</div>`);
                      return;
                  }

                  // ✅ EXACT OBJECT YOU SHARED
                  const booking = res?.data?.Response?.FlightItinerary;

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



      function getDetails(booking) {


          const segments = booking?.Segments || [];
          const passengers = booking?.Passenger || [];

          const firstSeg = segments[0] || {};
          const lastSeg = segments[segments.length - 1] || {};

          const originAirport = firstSeg?.Origin?.Airport || {};
          const destAirport = lastSeg?.Destination?.Airport || {};

          const departTime = firstSeg?.Origin?.DepTime;
          const arrivalTime = lastSeg?.Destination?.ArrTime;

          let html = `
            <div>
                <div class="bg-white p-4 rounded shadow-sm">

                    <div class="d-flex justify-content-between mb-4">
                    <img src="/images/logo.png" style="height:58px;">
                    <div class="text-end">
                        <div class="fw-bold">Flight Ticket (${booking.JourneyType == '1' ? 'One-way' : 'Roundtrip'})</div>
                        <div>
                           <h4> Booking ID: ${booking.BookingId || '-'}</h4>
                        </div>
                    </div>
                </div>
                <h4>${originAirport.AirportName || 'Origin'} to ${destAirport.AirportName || 'Destination'}</h4>

                <div class="row ticket-route">


                    <div class="col-sm-6 p-3 text-center ticket-route">
                        <div class="mt-2 border rounded p-1  bg-label-warning">
                            PNR<br>
                            <b>${booking.PNR || '-'}</b>
                        </div>

                        <br/>
                        <div>
                            ${booking.IsLCC ? '<span class="text-success">LCC</span>' : '<span class="text-danger">Non-LCC</span>'}
                        </div>
                        <div>
                            ${booking.NonRefundable ? '<span class="text-danger">Non-Refundable</span>' : '<span class="text-success">Refundable</span>'}
                        </div>
                    </div>

                    <div class="col-sm-6 p-3 ticket-route">

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-start">
                                <div class="city-code">${originAirport.AirportCode || ''}</div>
                                <div class="city-name">${originAirport.CityName || ''}</div>
                                <div>
                                        ${departTime ? new Date(departTime).toLocaleDateString() : ''}<br>
                                        <strong>
                                            ${departTime ? new Date(departTime).toLocaleTimeString([], {hour:'2-digit',minute:'2-digit'}) : ''}
                                        </strong>
                                    </div>
                            </div>

                            <div class="text-center">
                                <h5>${
                                        lastSeg?.AccumulatedDuration
                                            ? Math.floor(lastSeg.AccumulatedDuration / 60) + 'h ' + (lastSeg.AccumulatedDuration % 60) + 'm'
                                            : '—'
                                    }</h5>
                                    <hr/>
                                
                                    <div class="route-line">
                                        <span></span>
                                        ✈️
                                        <span></span>
                                    </div>
                            </div>
                            <div class="text-end">
                                <div class="city-code">${destAirport.AirportCode || ''}</div>
                                <div class="city-name">${destAirport.CityName || ''}</div>
                                    <div class="text-end">
                                ${arrivalTime ? new Date(arrivalTime).toLocaleDateString() : ''}<br>
                                <strong>
                                    ${arrivalTime ? new Date(arrivalTime).toLocaleTimeString([], {hour:'2-digit',minute:'2-digit'}) : ''}
                                </strong>
                            </div>
                            </div>
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
                                            <div class="col-8 passenger-name">
                                                ${p.Title} ${p.FirstName} ${p.LastName}
                                                ${p.IsLeadPax ? '<span class="lead-pax">Lead</span>' : ''}
                                            </div>

                                            <div class="col-4 text-end passenger-pnr">
                                                E-Ticket: ${booking.PNR || '-'}
                                            </div>
                                        </div>

                                        <div class="row text-muted mb-2">
                                            <div class="col-4"><b>DOB:</b> ${new Date(p.DateOfBirth).toLocaleDateString()}</div>
                                            <div class="col-4"><b>Gender:</b> ${p.Gender == 1 ? 'Male' : 'Female'}</div>
                                            <div class="col-4"><b>Nationality:</b> ${p.Nationality}</div>
                                        </div>

                                        <div class="seat-box">
                                            <div class="seat-title">Seat Details</div>
                                            ${
                                                p.SeatDynamic?.map(s => `
                            <div class="seat-row">
                                <span>${s.Origin} → ${s.Destination}</span>
                                <span class="seat-code">${s.Code}</span>
                                <span class="seat-type">${s.Text}</span>
                                <span>₹${s.Price}</span>
                            </div>
                        `).join('') || '<div class="seat-row">No seat selected</div>'
                                            }
                                        </div>

                                        <div class="fare-box">
                                            <div><b>Base Fare:</b> ₹${p.Fare.BaseFare}</div>
                                            <div><b>Tax:</b> ₹${p.Fare.Tax}</div>
                                            <div><b>Seat Charges:</b> ₹${p.Fare.TotalSeatCharges}</div>
                                            <div class="fare-total">
                                                Total: ₹${p.Fare.PublishedFare}
                                            </div>
                                        </div>

                                        <div class="contact-box">
                                            <div><b>Mobile:</b> ${p.ContactNo}</div>
                                            <div><b>Email:</b> ${p.Email}</div>
                                            <div><b>City:</b> ${p.City}, ${p.CountryCode}</div>
                                        </div>

                                        <div class="barcode text-center mt-3">
                                            <canvas id="barcodeCanvas${index}"></canvas>
                                        </div>

                                    </div>
                                    `).join('')
                    }
                </div>
                    <div class="mt-4 p-3 bg-white rounded text-end">
                        <span class="text-success">
                            You have paid <h4>INR ${booking?.Fare?.PublishedFare || '-'}</h4>
                        </span>
                    </div>

                      <div class="ticket-route">

                    <div class="row g-0">

                        <div class="col-sm-9 border-end">

                            <div class="p-2 px-3 fw-semibold text-white" 
                                style="background:#d7261e; border-radius:8px 8px 0 0;">
                                Items not allowed in the aircraft
                            </div>

                            <div class="p-3">
                                <div class="d-flex flex-wrap gap-4">

                                    <div class="text-center" style="width:100px;">
                                        <img src="<?php echo e(asset('/images/restricted/lighter.jpeg')); ?>" style="height:50px;">
                                        <div class="mt-1">LIGHTERS,<br>MATCHSTICKS</div>
                                    </div>

                                    <div class="text-center" style="width:120px;">
                                        <img src="<?php echo e(asset('/images/restricted/flame.jpeg')); ?>" style="height:50px;">
                                        <div class="mt-1">FLAMMABLE<br>LIQUIDS</div>
                                    </div>

                                    <div class="text-center" style="width:100px;">
                                        <img src="<?php echo e(asset('/images/restricted/toxic.png')); ?>" style="height:50px;">
                                        <div class="mt-1">TOXIC</div>
                                    </div>

                                    <div class="text-center" style="width:100px;">
                                        <img src="<?php echo e(asset('/images/restricted/corrosive.jpeg')); ?>" style="height:50px;">
                                        <div class="mt-1">CORROSIVES</div>
                                    </div>

                                    <div class="text-center" style="width:100px;">
                                        <img src="<?php echo e(asset('/images/restricted/paper.png')); ?>" style="height:50px;">
                                        <div class="mt-1">PEPPER<br>SPRAY</div>
                                    </div>

                                    <div class="text-center" style="width:120px;">
                                        <img src="<?php echo e(asset('/images/restricted/gas.png')); ?>" style="height:50px;">
                                        <div class="mt-1">FLAMMABLE<br>GAS</div>
                                    </div>

                                    <div class="text-center" style="width:100px;">
                                        <img src="<?php echo e(asset('/images/restricted/cigrate.jpeg')); ?>" style="height:50px;">
                                        <div class="mt-1">E-CIGARETTE</div>
                                    </div>

                                    <div class="text-center" style="width:120px;">
                                        <img src="<?php echo e(asset('/images/restricted/infection.png')); ?>" style="height:50px;">
                                        <div class="mt-1">INFECTIOUS<br>SUBSTANCES</div>
                                    </div>

                                    <div class="text-center" style="width:130px;">
                                        <img src="<?php echo e(asset('/images/restricted/redio.jpeg')); ?>" style="height:50px;">
                                        <div class="mt-1">RADIOACTIVE<br>MATERIALS</div>
                                    </div>

                                    <div class="text-center" style="width:130px;">
                                        <img src="<?php echo e(asset('/images/restricted/explosive.jpeg')); ?>" style="height:50px;">
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
                                    <img src="<?php echo e(asset('/images/restricted/lithium.png')); ?>" style="height:50px;">
                                    <div class="mt-1">LITHIUM<br>BATTERIES</div>
                                </div>

                                <div>
                                    <img src="<?php echo e(asset('/images/restricted/powerbank.png')); ?>" style="height:50px;">
                                    <div class="mt-1">POWER<br>BANKS</div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                
                
                <div class="rticket-route mt-4">
                    <div class="p-3 d-flex justify-content-between align-items-center" style="background:#eef3ff;">
                        <div class="fw-semibold ">
                            <img src="/images/restricted/digiyatra.png" style="height:20px;" class="me-2">
                            DIGI YATRA
                        </div>
                        <img src="/images/restricted/digiyatra2.jpeg" style="height:30px;">
                    </div>
                    <div class="p-3" style="background:#e8ffec; font-size:14px;">
                        <div class="fw-semibold mb-2">Avoid Long Queues at the Airport with DigiYatra</div>
                        <div class="mb-1"><strong>Step 1:</strong> Verify identity using Aadhaar</div>
                        <div class="mb-3"><strong>Step 2:</strong> Update boarding pass</div>
                    </div>
                </div>


                <div class="ticket-route mt-4"
                    style="border-left:4px solid #c2c2c2;">
                    <h6 class="fw-semibold mb-3">IMPORTANT INFORMATION</h6>
                    <ul class="">
                        <li>Reach airport 3 hours before departure</li>
                        <li>Carry valid government ID</li>
                        <li>Do not share OTP or CVV</li>
                    </ul>
                </div>
                </div>


              



            </div>
            `;


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
          const printContent = document.getElementById("ticketContent").innerHTML;
          const originalContent = document.body.innerHTML;

          document.body.innerHTML = printContent;
          window.print();
          document.body.innerHTML = originalContent;

          location.reload();
      }

      $(document).on('click', '.generate-ticket', function() {

          const payload = $(this).data('payload');
          let journeyType = $(this).data('journeytype');

          swal({
              title: "Generate Ticket?",
              html: `
            <p>Are you sure you want to generate the ticket?</p>
            <small class="text-muted">Once generated, it cannot be reversed.</small>
        `,
              type: "warning",
              showCancelButton: true,
              confirmButtonText: "Yes, Generate",
              cancelButtonText: "Cancel",
              allowOutsideClick: false,
              allowEscapeKey: false
          }).then((result) => {
              if (result.value || result === true) {
                  ViewTicketAjax(payload, '/flight/ticket', 'departure', journeyType === 'oneway' ? '1' :
                      '2', 'table');
              }
          });

      });
  </script>
<?php /**PATH C:\wamp64\www\flight_b2b_travel\flight_b2b_travel\resources\views/flight/booking-table.blade.php ENDPATH**/ ?>