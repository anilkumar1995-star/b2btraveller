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
          <thead class="bg-light">
              <tr>
                  <th>ID</th>
                  <th>User</th>
                  <th>Total Amount</th>
                  <th>Status</th>
                  <th>Message</th>
              </tr>
          </thead>

          <tbody>
              <?php if(!empty($bookings) && $bookings->count() > 0): ?>
                  <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                          <td>##<?php echo e($b->id); ?> <br /><?php echo e($b->created_at); ?></td>
                          <td>
                              <?php echo e($b->user_name ?? ''); ?><br />
                              <?php echo e($b->user_email ?? ''); ?><br />
                              <?php echo e($b->user_mobile ?? ''); ?>

                          </td>
                          <td>₹<?php echo e($b->total_amount ?? 0); ?></td>
                          <td><span class="badge bg-danger"><?php echo e($b->booking_status ?? 'N/A'); ?></span></td>
                          <td><?php echo e($b->message ?? 'N/A'); ?></td>

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
<?php /**PATH C:\wamp64\www\flight_b2b_travel\flight_b2b_travel\resources\views/flight/booking-table-failed.blade.php ENDPATH**/ ?>