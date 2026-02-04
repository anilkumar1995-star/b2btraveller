@extends('layouts.app')
@section('title', "UPI Collect")
@section('pagetitle', "UPI Collect")

@php
$table = "yes";
@endphp

@section('content')
  <style>
        .select2-container {
            border: 1px solid silver;
            border-radius: 4px;
        }

        .select2-dropdown {
            background: white !important;
        }
    </style>
 
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
                <table width="100%" class="table border-top mb-5" id="datatable" role="grid" aria-describedby="user-list-page-info">
                    <thead class=" text-center bg-light">
                        <tr>
                            <th>ID</th>
                            <th>Van Created By</th>
                            <th>Event</th>
                            <th>Remitter Name </th>
                            <th>Remitter A/C No. </th>
                            <th>Remitter Ifsc </th>
                            <th>Mobile No. </th>
                            <th>Payment Mode </th>
                            <th>Utr </th>
                            <th>Amount </th>
                            <th>Status </th>
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

@push('style')
  
@endpush

@push('script')
     <script type="text/javascript">
    
        $(document).ready(function() {

            var url = "{{ url('statement/fetch') }}/upicollect/0";

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
                    "data": "user_id",
                    render: function(data, type, full, meta) {
                        if (!full?.user) {
                            return `<span>N/A</span>`;
                        }
                        return `<span>${full?.user?.name}<br>${full?.user?.agentcode}</span>`;
                    }
                },
                 {
                    "data": "user_id",
                    render: function(data, type, full, meta) {
                        return `<span>${full?.event}</span>`;
                    }
                },

                {
                    "data": "event",
                    render: function(data, type, full, meta) {
                        return `<span> ${full?.remitter_full_name}</span>`;
                    }
                },

                {
                    "data": "fund_id",
                    render: function(data, type, full, meta) {
                        return `${full.remitter_account_number}`;
                    }
                },
                {
                    "data": "user_id",
                    render: function(data, type, full, meta) {
                        return `${full.remitter_ifsc}`;
                    }
                },
                {
                    "data": "user_id",
                    render: function(data, type, full, meta) {
                        return full.remitter_phone_number ? full.remitter_phone_number : "N/A";
                    }
                },
                {
                    "data": "user_id",
                    render: function(data, type, full, meta) {
                        return `${full.payment_mode}`;
                    }
                },
                {
                    "data": "user_id",
                    render: function(data, type, full, meta) {
                        return `${full.utr}`;
                    }
                },
                {
                    "data": "user_id",
                    render: function(data, type, full, meta) {
                        return `₹${full.amount ? full.amount : '0'}`;
                    }
                },
                {
                    "data": "user_id",
                    render: function(data, type, full, meta) {
                        if (full.status == "unsettled") {
                            return `<span class="badge bg-success">Completed</span>`;
                        } else if (full.status == "received") {
                            return `<span class="badge bg-success">${full.status}</span>`;
                        }
                        else {
                            return `<span class="badge bg-danger">${full.status}</span>`;
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

