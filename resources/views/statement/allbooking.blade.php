@extends('layouts.app')
@section('title', 'All Booking Statement')
@section('pagetitle', 'All Booking Statement')

@php
    $table = 'yes';
    $export = 'wallet';
@endphp

@section('content')
    <div class="row mt-4">
        <div class="col-12 col-xl-12 col-sm-12 order-1 order-lg-2 mb-4 mb-lg-0">
            <div class="card">
                <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4 ">
                    <div class="card-title mb-5">
                        <h5 class="mb-0">
                            <span>@yield('pagetitle') </span>
                        </h5>
                    </div>
                </div>
                <div class="card-datatable table-responsive">
                    <table width="100%" class="table border-top mb-5" id="datatable" role="grid"
                        aria-describedby="user-list-page-info">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Booking Id</th>
                                <th>Product</th>
                                <th>Passenger/Gues</th>
                                <th>Amount</th>
                                <th>Status</th>
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
            var url = "{{ url('statement/fetch') }}/allbooking";
            var onDraw = function() {
                $('[data-popup="tooltip"]').tooltip();
                $('[data-popup="popover"]').popover({
                    template: '<div class="popover border-teal-400"><div class="arrow"></div><h3 class="popover-title bg-teal-400"></h3><div class="popover-content"></div></div>'
                });
            };
            var options = [{
                    "data": "name",
                    render: function(data, type, full, meta) {
                        var out = "";
                        out += `</a><span style='font-size:13px' class="pull=right"></span>`;
                        return out;
                    }
                },
                {
                    "data": "name",
                    render: function(data, type, full, meta) {
                        return `${full?.created_at}`;
                    }
                },
                {
                    "data": "product",
                    render: function(data, type, full, meta) {
                        if (data == "Flight") {
                            return '<span class="badge bg-primary"><i class="fa fa-plane"></i> Flight</span>';
                        }
                        if (data == "Hotel") {
                            return '<span class="badge bg-success"><i class="fa fa-hotel"></i> Hotel</span>';
                        }
                        return '<span class="badge bg-warning"><i class="fa fa-bus"></i> Bus</span>';
                    }
                },
                {
                    data: "booking_ref_no"
                }, 
                {
                    data: "amount",
                    render: function(data) {
                        return "₹ " + data;
                    }
                }, 
                {
                    data: "payment_status",
                    render: function(data) {

                        if (data == "success") {
                            return '<span class="badge bg-success">Success</span>';
                        }

                        if (data == "pending") {
                            return '<span class="badge bg-warning">Pending</span>';
                        }

                        if (data == "failed") {
                            return '<span class="badge bg-danger">Failed</span>';
                        }

                        return '<span class="badge bg-secondary">' + data + '</span>';

                    }
                }
            ];

            datatableSetup(url, options, onDraw, '#datatable', {
                columnDefs: [{
                    orderable: false,
                    width: '80px',
                    targets: [0]
                }]
            });
        });
    </script>
@endpush
