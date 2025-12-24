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

      .small {
          font-size: 13px !important;
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
                  <h5 class="modal-title fw-semibold">Flight Ticket</h5>
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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.2/jQuery.print.min.js"></script>
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

          console.log("BOOKING OBJECT", booking);

          const segments = booking?.Segments || [];
          const passengers = booking?.Passenger || [];

          const firstSeg = segments[0] || {};
          const lastSeg = segments[segments.length - 1] || {};

          const originAirport = firstSeg?.Origin?.Airport || {};
          const destAirport = lastSeg?.Destination?.Airport || {};

          const departTime = firstSeg?.Origin?.DepTime;
          const arrivalTime = lastSeg?.Destination?.ArrTime;

          let html = `
    <div class="container">


        <div class="mb-3 small">
            ${new Date().toLocaleDateString()}
        </div>


        <div class="d-flex justify-content-between mb-4">
            <img src="/images/logo.png" style="height:38px;">
            <div class="text-end">
                <div class="fw-bold">Flight Ticket (One way)</div>
                <div class="small">
                    Booking ID: <b>${booking.BookingId || '-'}</b>
                </div>
            </div>
        </div>


        <div class="bg-white p-4 rounded shadow-sm">

            <h4>${originAirport.AirportName || 'Origin'} to ${destAirport.AirportName || 'Destination'}</h4>

            <div class="small mb-3">
                ${departTime ? new Date(departTime).toLocaleString() : ''}
            </div>

            <div class="row border rounded">


                <div class="col-md-3 p-3 text-center">
                    <div class="fw-semibold">${booking.ValidatingAirlineCode || 'AI'}</div>
                    <div class="mt-2 border rounded p-1">
                        <small>PNR</small><br>
                        <b>${booking.PNR || '-'}</b>
                    </div>
                </div>


                <div class="col-md-6 p-3 border-start border-end">
                    <div class="row">
                        <div class="col-6">
                            <b>${originAirport.CityName || ''}</b><br>
                            ${originAirport.AirportCode || ''}
                            ${departTime ? new Date(departTime).toLocaleTimeString([], {hour:'2-digit',minute:'2-digit'}) : ''}
                            <div class="small">${originAirport.AirportName || ''}</div>
                        </div>

                        <div class="col-6 text-end">
                            <b>${destAirport.CityName || ''}</b><br>
                            ${destAirport.AirportCode || ''}
                            ${arrivalTime ? new Date(arrivalTime).toLocaleTimeString([], {hour:'2-digit',minute:'2-digit'}) : ''}
                            <div class="small">${destAirport.AirportName || ''}</div>
                        </div>
                    </div>

                    <div class="text-center my-3 small">
                        ${
                            lastSeg?.AccumulatedDuration
                                ? Math.floor(lastSeg.AccumulatedDuration / 60) + 'h ' + (lastSeg.AccumulatedDuration % 60) + 'm'
                                : '—'
                        }
                    </div>
                </div>


                <div class="col-md-3 p-3">
                    <div class="small">
                        ${booking.IsLCC ? '<span class="text-success">LCC</span>' : '<span class="text-danger">Non-LCC</span>'}
                    </div>
                    <div class="small">
                        ${booking.NonRefundable ? '<span class="text-danger">Non-Refundable</span>' : '<span class="text-success">Refundable</span>'}
                    </div>
                </div>
            </div>


            <div class="pt-3">
                <div class="row fw-semibold small mb-2">
                    <div class="col-6">TRAVELLER</div>
                    <div class="col-3">SEAT</div>
                    <div class="col-3">E-TICKET</div>
                </div>

                ${
                    passengers.map(p => `
                          <div class="row mb-2">
                              <div class="col-6">${p.Title || ''} ${p.FirstName || ''} ${p.LastName || ''}</div>
                              <div class="col-3">${p.SeatDynamic?.map(s => s.Code).join(', ') || '–'}</div>
                              <div class="col-3 fw-semibold">${booking.PNR || '-'}</div>
                          </div>
                      `).join('')
                }
            </div>


            <div class="mt-4 p-3 bg-white rounded">
                <span class="text-success">
                    You have paid <b>INR ${booking?.Fare?.PublishedFare || '-'}</b>
                </span>
            </div>

        </div>


                    <div class="mt-4 p-4 bg-white rounded-4 shadow-sm border">

                        <div class="row g-0">

                            <div class="col-md-9 border-end">

                                <div class="p-2 px-3 fw-semibold text-white" 
                                    style="background:#d7261e; border-radius:8px 8px 0 0;">
                                    Items not allowed in the aircraft
                                </div>

                                <div class="p-3">
                                    <div class="d-flex flex-wrap gap-4">

                                        <div class="text-center" style="width:100px;">
                                            <img src="<?php echo e(asset('/images/restricted/lighter.jpeg')); ?>" style="height:50px;">
                                            <div class="small mt-1">LIGHTERS,<br>MATCHSTICKS</div>
                                        </div>

                                        <div class="text-center" style="width:120px;">
                                            <img src="<?php echo e(asset('/images/restricted/flame.jpeg')); ?>" style="height:50px;">
                                            <div class="small mt-1">FLAMMABLE<br>LIQUIDS</div>
                                        </div>

                                        <div class="text-center" style="width:100px;">
                                            <img src="<?php echo e(asset('/images/restricted/toxic.png')); ?>" style="height:50px;">
                                            <div class="small mt-1">TOXIC</div>
                                        </div>

                                        <div class="text-center" style="width:100px;">
                                            <img src="<?php echo e(asset('/images/restricted/corrosive.jpeg')); ?>" style="height:50px;">
                                            <div class="small mt-1">CORROSIVES</div>
                                        </div>

                                        <div class="text-center" style="width:100px;">
                                            <img src="<?php echo e(asset('/images/restricted/paper.png')); ?>" style="height:50px;">
                                            <div class="small mt-1">PEPPER<br>SPRAY</div>
                                        </div>

                                        <div class="text-center" style="width:120px;">
                                            <img src="<?php echo e(asset('/images/restricted/gas.png')); ?>" style="height:50px;">
                                            <div class="small mt-1">FLAMMABLE<br>GAS</div>
                                        </div>

                                        <div class="text-center" style="width:100px;">
                                            <img src="<?php echo e(asset('/images/restricted/cigrate.jpeg')); ?>" style="height:50px;">
                                            <div class="small mt-1">E-CIGARETTE</div>
                                        </div>

                                        <div class="text-center" style="width:120px;">
                                            <img src="<?php echo e(asset('/images/restricted/infection.png')); ?>" style="height:50px;">
                                            <div class="small mt-1">INFECTIOUS<br>SUBSTANCES</div>
                                        </div>

                                        <div class="text-center" style="width:130px;">
                                            <img src="<?php echo e(asset('/images/restricted/redio.jpeg')); ?>" style="height:50px;">
                                            <div class="small mt-1">RADIOACTIVE<br>MATERIALS</div>
                                        </div>

                                        <div class="text-center" style="width:130px;">
                                            <img src="<?php echo e(asset('/images/restricted/explosive.jpeg')); ?>" style="height:50px;">
                                            <div class="small mt-1">EXPLOSIVES<br>AMMUNITION</div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">

                                <div class="p-2 fw-semibold text-white text-center" 
                                    style="background:#f8a900; border-radius:8px 8px 0 0;">
                                    Items allowed only<br>in Hand Baggage
                                </div>

                                <div class="p-4 text-center">

                                    <div class="mb-4">
                                        <img src="<?php echo e(asset('/images/restricted/lithium.png')); ?>" style="height:50px;">
                                        <div class="small mt-1">LITHIUM<br>BATTERIES</div>
                                    </div>

                                    <div>
                                        <img src="<?php echo e(asset('/images/restricted/powerbank.png')); ?>" style="height:50px;">
                                        <div class="small mt-1">POWER<br>BANKS</div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>


        <div class="rounded-4 overflow-hidden border mt-4">
            <div class="p-3 d-flex justify-content-between align-items-center" style="background:#eef3ff;">
                <div class="fw-semibold small">
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


        <div class="mt-4 p-4 bg-white rounded-4 shadow-sm border"
             style="border-left:4px solid #c2c2c2;">
            <h6 class="fw-semibold mb-3">IMPORTANT INFORMATION</h6>
            <ul class="small">
                <li>Reach airport 3 hours before departure</li>
                <li>Carry valid government ID</li>
                <li>Do not share OTP or CVV</li>
            </ul>
        </div>

    </div>
    `;

          $('#ticketContent').html(html);
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