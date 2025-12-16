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
                        <table class="table table-bordered align-middle mb-0" id="datatable">
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

<div class="modal fade" id="readMoreModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="readMoreTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <pre class="small text-wrap mb-0" id="readMoreContent"></pre>
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

        let date = new Date(full.created_at).toLocaleString('en-IN', {});

        return `
            <strong>#${full.id}</strong><br>
            <small class="text-muted">${date}</small>
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
        let text = full?.request ?? '-';
        let shortText = text.length > 120 ? text.substring(0, 120) + '...' : text;

        return `
            <pre class="mb-0 small text-wrap">${shortText}</pre>
            ${text.length > 120 
                ? `<a href="javascript:void(0)" 
                     class="text-primary fw-semibold readMore"
                     data-title="Request"
                     data-content="${encodeURIComponent(text)}">
                     Read more
                   </a>` 
                : ''}
        `;
    }
},
{
    data: "response",
    render: function (data, type, full) {
        let text = full?.response ?? '-';
        let shortText = text.length > 120 ? text.substring(0, 120) + '...' : text;

        return `
            <pre class="mb-0 small text-wrap">${shortText}</pre>
            ${text.length > 120 
                ? `<a href="javascript:void(0)" 
                     class="text-primary fw-semibold readMore"
                     data-title="Response"
                     data-content="${encodeURIComponent(text)}">
                     Read more
                   </a>` 
                : ''}
        `;
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
$(document).on('click', '.readMore', function () {
    let title = $(this).data('title');
    let content = decodeURIComponent($(this).data('content'));

    $('#readMoreTitle').text(title);
    $('#readMoreContent').text(content);

    let modal = new bootstrap.Modal(document.getElementById('readMoreModal'));
    modal.show();
});

});
</script>
@endpush
