
<?php $__env->startSection('title', 'Api List'); ?>
<?php $__env->startSection('pagetitle', 'Api List'); ?>

<?php
    $table = 'yes';
?>

<?php $__env->startSection('content'); ?>
<div class="content">


    <!-- Card -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">

                <div class="card-body p-3 p-md-4">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle mb-0" id="datatable">
                            <thead class="bg-light text-center">
                                <tr>
                                     <th class="sorting">Id</th>
                                        <th class="sorting">URL</th>
                                        <th class="sorting">Request</th>
                                        <th class="sorting">Response</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
<script>
$(document).ready(function () {

    let url = "<?php echo e(url('statement/fetch')); ?>/apilogs/0";

    let options = [
        {
            data: "id",
            render: function (data, type, full) {
                return `
                    <strong>#${full?.id}</strong><br>
                    <small class="text-muted">${full?.created_at}</small>
                `;
            }
        },
        {
            data: "url",
            render: function (data, type, full) {
                return `<small class="text-muted">${full?.url ?? '-'}</small>`;
            }
        },
        {
            data: "request",
            render: function (data, type, full) {
                return `<pre class="mb-0 small text-wrap">${full?.request ?? '-'}</pre>`;
            }
        },
        {
            data: "response",
            render: function (data, type, full) {
                return `<pre class="mb-0 small text-wrap">${full?.response ?? '-'}</pre>`;
            }
        }
    ];

    datatableSetup(url, options, function(){}, '#datatable', {
        searching: true,
        ordering: true,
        pageLength: 10,
        columnDefs: [
            { orderable: false, targets: [2,3] }
        ]
    });

});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wampp\www\b2btraveller\resources\views/api/apilogs.blade.php ENDPATH**/ ?>