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
                                      <?php if($b->is_lcc !== 'true'): ?>
                                          <li>
                                              <a class="dropdown-item" href="javascript:void(0)"
                                                  data-id="<?php echo e($b->id); ?>">
                                                  🎫 View Ticket
                                              </a>
                                          </li>
                                      <?php endif; ?>


                                      <li>
                                          <a class="dropdown-item view-ticket-btn" href="javascript:void(0)"
                                              data-bs-toggle="modal" data-bs-target="#viewTicketModal"
                                              data-id="<?php echo e($b->id); ?>">
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

  <script type="text/javascript">
      $(document).on('click', '.view-ticket-btn', function() {

          let bookingId = $(this).data('id');

          $('#viewTicketModal').modal('show');

          $("#ticketContent").html(`
        <div class="p-5 text-center">
            <div class="spinner-border text-primary"></div>
            <div class="mt-2 fw-bold text-primary">Loading ticket...</div>
        </div>
    `);

          $.ajax({
              url: "booking/view/" + bookingId,
              type: "GET",
              success: function(booking) {
                  let html = `
                <div class="container">

                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="small">
                            ${ new Date(booking.created_at).toLocaleDateString() }
                        </div>
                    </div>

                    <!-- HEADER -->
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <img src="<?php echo e(asset('/images/logo.png')); ?>" style="height:38px; margin-bottom:20px;" />

                        <div class="text-end">
                            <div class="fw-bold">Flight Ticket <span>(One way)</span></div>
                            <div class="small">
                                Booking ID:
                                <span class="fw-bold text-dark">${ booking.booking_id_api }</span>
                            </div>
                        </div>
                    </div>

                    <!-- BARCODE -->
                    <div class="barcode-card p-4 bg-white rounded-4 shadow-sm">

                        <div class="mb-3 fw-semibold" style="font-size:15px;">
                            Barcode(s) for your journey
                            <span class="text-primary">${ booking.origin }  to  ${ booking.destination }</span> on
                            <span class="text-primary">${ booking.airline_code }</span>
                        </div>

                        <hr>

                        <div class="row align-items-center mb-4">
                            <div class="col-6"><div style="font-size:17px;">Passenger 1</div></div>
                            <div class="col-6 d-flex justify-content-end align-items-center">
                                <img src="<?php echo e(asset('mmt-logo.png')); ?>" class="barcode-img">
                            </div>
                        </div>

                    </div>

                    <!-- MAIN TICKET -->
                    <div class="ticket-card bg-white p-4 rounded-4 shadow-sm mt-4">

                        <h4 class="fw-semibold mb-1">${ booking.origin } to ${ booking.destination }</h4>

                        <div class="mb-3 small">
                            ${ new Date(booking.journey_date).toLocaleString() }
                        </div>

                        <div class="row g-0 border rounded-4 overflow-hidden">

                            <div class="col-md-3 p-3 d-flex flex-column justify-content-center">
                             <div class="d-flex align-items-center mb-2">
                                    <img src="https://upload.wikimedia.org/wikipedia/en/1/15/SpiceJet_logo.png"
                                        style="height:40px;" alt="airline">
                                </div>

                                <div class="fw-semibold fs-5">${ booking.airline_code }</div>
                                <div class="mb-2">${ booking.flight_number }</div>

                                    <div class="d-flex border rounded overflow-hidden" style="width:150px;">

                                    <div class="bg-primary bg-opacity-10 px-2 py-1 d-flex align-items-center" style="width:40%;">
                                        <span class="small text-dark fw-semibold">PNR</span>
                                    </div>

                                    <div class="px-2 py-1 d-flex align-items-center" style="width:60%; white-space:nowrap;">
                                        <span class="fw-bold text-primary">${ booking.pnr }</span>
                                    </div>

                                </div>



                            </div>

                        <!-- MIDDLE BLOCK -->
                            <div class="col-md-6 p-4 border-start border-end">

                                <div class="row text-center">

                                    <div class="col-6 text-start">

                                        <div class="fw-semibold" style="font-size:18px;">
                                            ${ booking.origin ?? "Ahmedabad" }
                                        </div>

                                        <div>
                                            ${ (booking.origin_code ?? "AMD") }
                                            <span class="fw-bold text-dark">
                                                ${ booking.depart_time ?? "18:10 hrs" }
                                            </span>
                                        </div>

                                        <div class="small">
                                            ${ booking.journey_date 
                                                ? new Date(booking.journey_date).toLocaleDateString("en-GB",{day:"2-digit",month:"short"})
                                                : "Wed, 22 Oct" }
                                        </div>

                                        <div class="mt-2 small">
                                            ${ booking.origin_airport ?? "Sardar Vallabhbhai Patel<br>International Airport Terminal 2" }
                                        </div>

                                    </div>


                                    <div class="col-6 text-end">

                                        <div class="fw-semibold" style="font-size:18px;">
                                            ${ booking.destination ?? "Varanasi" }
                                        </div>

                                        <div>
                                            ${ (booking.destination_code ?? "VNS") }
                                            <span class="fw-bold text-dark">
                                                ${ booking.arrival_time ?? "20:00 hrs" }
                                            </span>
                                        </div>

                                        <div class="small">
                                            ${ booking.journey_date 
                                                ? new Date(booking.journey_date).toLocaleDateString("en-GB",{day:"2-digit",month:"short"})
                                                : "Wed, 22 Oct" }
                                        </div>

                                        <div class="mt-2 small">
                                            ${ booking.destination_airport ?? "Varanasi Airport" }
                                        </div>

                                    </div>

                                </div>

                                <!-- Duration dots -->
                                <div class="text-center my-3 small">
                                    ${ booking.duration ?? "1h 50m" } <br>
                                    <span style="letter-spacing:4px;">• • • • ● • • • •</span>
                                </div>

                            </div>


                        <div class="col-md-3 p-3">

                            <!-- LCC / Non-LCC -->
                            <div class="small mb-2">
                                ${
                                    booking.is_lcc === "true" ? 
                                        "<span class='text-success'>LCC</span>" :
                                    booking.is_lcc === "false" ?
                                        "<span class='text-danger'>Non-LCC</span>" :
                                        "<span class='text-success'>LCC</span>"
                                }
                            </div>

                            <!-- Refundable / Non-Refundable -->
                            <div class="small">
                                ${
                                    booking.is_refundable === "true" ? 
                                        "<span class='text-success'>Refundable</span>" :
                                    booking.is_refundable === "false" ?
                                        "<span class='text-danger'>Non-Refundable</span>" :
                        
                                        "<span class='text-danger'>Non-Refundable</span>"
                                }
                            </div>

                        </div>


                        </div>

                    <div class="pt-3">

                        <div class="row fw-semibold small mb-2">
                            <div class="col-5">TRAVELLER</div>
                            <div class="col-2">SEAT</div>
                            <div class="col-2">MEAL</div>
                            <div class="col-3">E-TICKET NO</div>
                        </div>

                            ${
                                booking.passengers && booking.passengers.length > 0 
                                ? 
                                booking.passengers.map((p, index) => `
                                      <div class="row mb-2">
                                          <div class="col-5">
                                              ${ p.name ?? `Passenger ${index+1}` }
                                              <span class="small">${ p.type ?? "Adult" }</span>
                                          </div>
                                          <div class="col-2">${ p.seat ?? "–" }</div>
                                          <div class="col-2">${ p.meal ?? "–" }</div>
                                          <div class="col-3 fw-semibold">${ p.eticket ?? booking.pnr }</div>
                                      </div>
                                  `).join("") 

                                : 
                                `
                                      <div class="row mb-2">
                                          <div class="col-5">
                                              Passenger 1 <span class="small">Adult</span>
                                          </div>
                                          <div class="col-2">–</div>
                                          <div class="col-2">–</div>
                                          <div class="col-3 fw-semibold">${ booking.pnr }</div>
                                      </div>
                                  `
                            }

                        </div>


                    </div>

                    <div class="mt-4">
                        <div class="small fw-semibold  mb-2"
                            style="border-left:4px solid #2a7c6f; padding-left:10px;">
                            YOU HAVE ALSO BOUGHT
                        </div>

                        <div class="p-4 bg-white rounded-4 shadow-sm border mb-3">

                            <div class="d-flex mb-3">

                                <img src="<?php echo e(asset('/images/restricted/reliance.png')); ?>" style="height:100px;" class="me-3">

                                <div class="flex-grow-1">

                                    <div class="fw-semibold mb-1">TRIP SECURE</div>

                                    <div class="mb-2">
                                        You have purchased Trip Secure powered by Across Assist and Reliance General Insurance.
                                    </div>

                                    <div class="small tex-muted">
                                        <strong>Reference Nos. :</strong><br>
                                        MTMINFDF41527305154906-P1C1X1<br>
                                        MTMINFDF41527305154906-P2C1X1<br>
                                        MTMINFDF41527305154906-P3C1X1
                                    </div>

                                </div>

                            </div>

                    
                        </div>
                          <div class="p-3 rounded-3 mb-2 bg-white">
                                <span class="text-success">You have paid <span class="fw-bold text-dark">INR ${booking.total_amount}</span></span>

                                <span class="ms-3 px-2 py-1 rounded-2"
                                    style="background:#e8eaef; font-size:12px;">
                                    You saved INR 710
                                </span>
                            </div>


                        <div class="rounded-4 overflow-hidden border">

                            <div class="p-3 d-flex justify-content-between align-items-center"
                                style="background:#eef3ff;">
                                <div class="fw-semibold small">
                                    <img src="<?php echo e(asset('/images/restricted/digiyatra.png')); ?>"
                                        style="height:20px;" class="me-2">
                                    DIGI YATRA
                                </div>

                                <img src="<?php echo e(asset('/images/restricted/digiyatra2.jpeg')); ?>"
                                    style="height:30px;">
                            </div>

                            <div class="p-3" style="background:#e8ffec; font-size:14px;">

                                <div class="fw-semibold mb-2">Avoid Long Queues at the Airport with DigiYatra</div>

                                <div class="mb-2">
                                    Use DigiYatra — the Ministry of Civil Aviation’s mobile app.
                                </div>

                                <div class="mb-1"><strong>Step 1:</strong> Verify identity using Aadhaar</div>
                                <div class="mb-3"><strong>Step 2:</strong> Update boarding pass</div>

                                <a href="#" class="fw-semibold text-primary">Know More</a>
                            </div>

                        </div>

                    </div>

                    <!-- ITEMS NOT ALLOWED SECTION -->
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

                    <!-- IMPORTANT INFORMATION -->
                    <div class="mt-4 p-4 bg-white rounded-4 shadow-sm border"
                        style="border-left:4px solid #c2c2c2;">

                        <h6 class="fw-semibold mb-3">IMPORTANT INFORMATION</h6>

                        <ul class="small" style="line-height:1.7;">

                            <li><strong>Check-in Time :</strong> Reach airport 3 hours before departure.</li>

                            <li><strong>DGCA passenger charter :</strong> 
                                <a href="#" class="text-primary">Here</a>
                            </li>

                            <li><strong>Baggage Info :</strong>
                                1 Check-in + 1 Cabin bag allowed.
                            </li>

                            <li><strong>Unaccompanied Minors :</strong> Rules apply.</li>

                            <li><strong>Valid ID :</strong> Carry Aadhaar, PAN, DL etc.</li>

                            <li>Do not share OTP, CVV, Password with anyone.</li>

                        </ul>
                    </div>

                    <!-- CONTACTS & HOTEL -->
                    <div class="mt-4 text-center small">

                    You can view all <a href="#" class="text-primary">cancellation, date change and baggage related information here</a>,
                                        If you want to manage your booking, you can visit MyTrips section using this
                                        <a href="#" class="text-primary">link</a>
                                <div class="mt-4 p-3 bg-white rounded-4 shadow-sm border text-start">

                                    <div class="mb-2 fw-semibold">
                                        Contact MakeMyTrip <span class="text-dark">+91124 4628747</span>
                                    </div>

                                    <div class="fw-semibold">
                                        Contact SPICE JET <span class="text-dark">0124-4983410</span>
                                    </div>

                                    <a href="#" class="mt-2 d-block text-primary">Click here to know more</a>
                                </div>

                                <div class="mt-4 p-3 bg-white rounded-4 shadow-sm border text-start">

                                    <div class="d-flex">
                                        <img src="<?php echo e(asset('/images/restricted/hotel.jpeg')); ?>"
                                            style="height:100px; border-radius:8px;">

                                        <div class="ms-3">
                                            <div class="fw-semibold text-dark mb-1" style="font-size:18px;">
                                                Enjoy the Perfect Stay with Sarovar Hotels!
                                            </div>

                                            <a href="#" class="btn btn-primary btn-sm px-3">EXPLORE STAYS</a>
                                        </div>

                                        <div class="ms-auto">
                                            <img src="<?php echo e(asset('/images/restricted/sarover.png')); ?>">
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- STATIC END -->

                        </div>
                        `;

                  $("#ticketContent").html(html);
              },
              error: function() {
                  $("#ticketContent").html(`
                            <div class="p-4 text-danger fw-bold">Failed to load ticket!</div>
                        `);
              }
          });


      });



      function printTicket() {
          const printContent = document.getElementById("ticketContent").innerHTML;
          const originalContent = document.body.innerHTML;

          document.body.innerHTML = printContent;
          window.print();
          document.body.innerHTML = originalContent;

          location.reload();
      }
  </script>
<?php /**PATH C:\wamp64\www\flight_b2b_travel\flight_b2b_travel\resources\views/flight/booking-table.blade.php ENDPATH**/ ?>