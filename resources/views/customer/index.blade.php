@extends('layouts.app')
@section('title', 'Customer List')
@section('pagetitle', 'Customer List')

@php
    $table = 'yes';
@endphp

@section('content')
    <div class="row mt-4">
        <div class="col-12 col-xl-12 col-sm-12 order-1 order-lg-2 mb-4 mb-lg-0">
            <div class="card">
                <div class="card-header bg-light pb-0 d-flex justify-content-between position-relative align-items-center">
                    <div class="card-title">
                        <h5 class="mb-0">
                            <span>@yield('pagetitle')</span>
                        </h5>
                    </div>


                </div>

                <div class="card-datatable table-responsive">
                    <table width="100%" class="table border-top mb-5" id="datatable">
                        <thead class="text-center bg-light">
                            <tr>
                                <th width="10%">ID</th>
                                <th width="20%">Customer Details</th>
                                <th width="20%">Id Details</th>
                                <th width="15%">Address</th>
                                <th width="20%">Other Details</th>
                                <th width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



@endsection

@push('script')
    <script>
        $(document).ready(function() {
            var url = "{{ url('statement/fetch') }}/customerlist/0";

            var onDraw = function() {
                $('[data-popup="tooltip"]').tooltip();
                $('[data-popup="popover"]').popover({
                    template: '<div class="popover border-teal-400"><div class="arrow"></div><h3 class="popover-title bg-teal-400"></h3><div class="popover-content"></div></div>'
                });
            };

            var options = [{
                    "data": "id",
                    render: function(data, type, full, meta) {
                        return `<span>###${full?.id}<br/>${full?.created_at}</span>`;
                    }
                },


                {
                    "data": "name",
                    render: function(data, type, full, meta) {
                        return `
                        <span><b>Name</b>- ${full?.first_name ?? '-'} ${full?.last_name ?? '-'}</span><br>
                        <span>${full?.email ?? '-'}</span><br>
                        <span><b>Mobile</b>- ${full?.mobile ?? '-'}</span>
                    `;
                    }
                },
                {
                    "data": "name",
                    render: function(data, type, full, meta) {
                        return `
                            <span><b>Pan</b>- ${full?.pan_number ?? '-'}</span><br>
                            <span><b>Passport</b>- ${full?.passport_number ?? '-'}</span><br>
                            <span><b>Expiry</b>- ${full?.passport_expiry ?? '-'}</span>
                        `;
                    }
                },
                {
                    "data": "address",
                    render: function(data, type, full, meta) {
                        return `<span> ${full?.address1 ?? '-'}, ${full?.address2 ?? '-'} ${full?.city ?? '-'}</span>`;
                    }
                },
                {
                    "data": "id",
                    render: function(data, type, full, meta) {
                        return `<span><b>Gender</b>- ${full?.gender == '2' ? 'Female' : 'Male'} 
                            <br/><b>DOB</b>- ${full?.dob ?? '-'}
                            <br/><b>Nationality</b>- ${full?.nationality ?? '-'}
                            </span>`;
                    }
                },
                {
                    "data": "status",
                    render: function(data, type, full, meta) {
                        const status = full?.status === 'active';
                        if (status) {
                            return `<span class="btn btn-sm btn-success ">Active</span>`;
                        } else {
                            return `<span class="btn btn-sm btn-danger ">In Active</span>`;
                        }
                    }
                },

            ];

            datatableSetup(url, options, onDraw, '#datatable', {
                searching: true,
                columnDefs: [{
                    orderable: false,
                    searchable: false,
                    width: '80px',
                    targets: [0]
                }]
            });
        });
    </script>
@endpush
