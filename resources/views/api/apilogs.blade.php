@extends('layouts.app')
@section('title', 'Api List')
@section('pagetitle', 'Api List')

@php
    $table = 'yes';
@endphp

@section('content')
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
@endsection
@push('script')
<script>
$(document).ready(function () {

    let url = "{{ url('statement/fetch') }}/apilogs/0";

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
@endpush
