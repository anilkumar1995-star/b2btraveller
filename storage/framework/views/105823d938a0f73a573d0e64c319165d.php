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
                      <td>PNR: <b><?php echo e($b->pnr ?? 'N/A'); ?></b> <br /> Booking Id: <b><?php echo e($b->booking_id_api ?? 'N/A'); ?></b>
                          <br /><?php echo e($b->airline_code); ?> - [<?php echo e($b->flight_number); ?>]
                      </td>

                      <td><?php echo e($b->origin); ?> <br /> <?php echo e($b->destination); ?></td>
                      <td>₹<?php echo e($b->total_amount ?? 0); ?></td>

                      <td><?php echo $b->is_lcc === 'true' ? '<span class="text-success">LCC</span>' : '<span class="text-danger">Non-LCC</span>'; ?>


                          <br>

                          <?php echo $b->is_refundable === 'true'
                              ? '<span class="text-success">Refundable</span>'
                              : '<span class="text-danger">Non-Refundable</span>'; ?>

                      </td>
                      <td>
                        <span class="<?php echo e($status['class']); ?>">
                              <?php echo e($status['label']); ?>

                          </span><br/>
                          <div class="dropdown mt-1">
                              <button class="btn btn-sm btn-light border dropdown-toggle" type="button"
                                  id="dropdownMenuButton<?php echo e($b->id); ?>" data-bs-toggle="dropdown"
                                  aria-expanded="false">
                                  👁️ View
                              </button>

                              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo e($b->id); ?>">
                                  <li>
                                      <a class="dropdown-item" href="javascript:void(0)">
                                          🎫 View Ticket
                                      </a>
                                  </li>

                                  <li>
                                      <a class="dropdown-item" href="javascript:void(0)">
                                          📄 Booking Details
                                      </a>
                                  </li>
                                  <li>
                                      <a class="dropdown-item" href="javascript:void(0)">
                                          ✈️ Cancel Flight
                                      </a>
                                  </li>
                              </ul>
                          </div>
                      </td>
                  </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
      </table>
  </div>

  <div class="d-flex justify-content-center custom-pagination mt-2 mb-3">
      <?php echo $bookings->links('pagination::bootstrap-5'); ?>

  </div>
<?php /**PATH C:\wamp64\www\flight_b2b_travel\flight_b2b_travel\resources\views/flight/booking-table.blade.php ENDPATH**/ ?>