@extends('layouts.app')
@section('title', "Customer List")
@section('pagetitle', "Customer List")

@php
$table = "yes";
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

                <div>
                    <button type="button" class="btn btn-success mb-3" onclick="addCustomer()">
                        Add Customer
                    </button>
                </div>
            </div>

            <div class="card-datatable table-responsive">
                <table width="100%" class="table border-top mb-5" id="datatable">
                    <thead class="text-center bg-light">
                        <tr>
                            <th>ID</th>
                            <!-- <th>Created By</th> -->
                            <th>Customer Details</th>
                            <th>Account Number</th>
                            <th>Bank Details</th>
                            <th>Address</th>
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

<div class="modal" id="customerModal" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>

            <form id="customerFormCreate" action="{{ route('addcustomer') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="id">
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                <div class="modal-body">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label>Name : <b class="text-danger">*</b></label>
                            <input type="text" name="name" class="form-control" required
                                placeholder="Enter Customer Name "><span class="text-danger error-label"
                                id="error-label"></span>
                        </div>

                        <div class="col-md-6">
                            <label>Email : <b class="text-danger">*</b></label>
                            <input type="email" name="email" class="form-control" required
                                placeholder="Enter Customer Email "><span class="text-danger error-label"
                                id="error-label"></span>
                        </div>
                        <div class="col-md-6">
                            <label>Mobile : <b class="text-danger">*</b></label>
                            <input type="text" name="mobile" class="form-control" required
                                placeholder="Enter Customer Mobile Number "><span class="text-danger error-label"
                                id="error-label"></span>
                        </div>
                        <div class="col-md-6">
                            <label>Account Number: <b class="text-danger">*</b></label>
                            <input type="text" name="account_number" class="form-control" required
                                placeholder="Enter Customer Account Number "><span class="text-danger error-label"
                                id="error-label"></span>
                        </div>
                        <div class="col-md-6">
                            <label>Ifsc Code: <b class="text-danger">*</b></label>
                            <input type="text" name="ifsc" class="form-control" required
                                placeholder="Enter Customer Ifsc "><span class="text-danger error-label"
                                id="error-label"></span>
                        </div>
                        <div class="col-md-6">
                            <label>Bank Name: <b class="text-danger">*</b></label>
                            <input type="text" name="bank_name" class="form-control" required
                                placeholder="Enter Customer Bank Name "><span class="text-danger error-label"
                                id="error-label"></span>
                        </div>
                        <div class="col-md-6">
                            <label>Address: <b class="text-danger">*</b></label>
                            <input type="text" name="address" class="form-control" required
                                placeholder="Enter Customer Address "><span class="text-danger error-label"
                                id="error-label"></span>
                        </div>
                        <div class="col-md-6">
                            <label>Status: <b class="text-danger">*</b></label>
                            <select name="status" id="Status" class="form-control" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                    </div>

                    <div class="modal-footer py-0 mt-2">
                        <button class="btn btn-success" type="submit"
                            data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit
                        </button>
                    </div>
            </form>
        </div>
    </div>
</div>


@endsection

@push('script')
<script>
    function addCustomer() {
        $('#customerModal').modal('show');
    }
     $("#customerFormCreate").validate({
            submitHandler: function() {
                var form = $('form#customerFormCreate');
                form.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {
                        form.find('button:submit').html('Please wait...').attr(
                            'disabled', true).addClass('btn-secondary');
                    },
                    success: function(data) {
                        form.find('button:submit').html('Submit').attr(
                            'disabled',
                            false).removeClass('btn-secondary');
                        if (data.status == "success") {
                            $('#datatable').dataTable().api().ajax.reload();
                            notify("Customer Added Successfully", 'success');
                            $('#customerModal').modal('hide');
                        } else {
                            notify(data.status, 'error');
                        }
                    },
                    error: function(errors) {
                        form.find('button:submit').html('Submit').attr(
                            'disabled',
                            false).removeClass('btn-secondary');
                        notify(errors?.responseJSON?.message ||
                            "Something went wrong",
                            'error');
                    }
                });
            }
        });

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
            // {
            //     "data": "user_id",
            //     render: function(data, type, full, meta) {
            //         if (!full?.user) {
            //             return `<span>N/A</span>`;
            //         }
            //         return `<span>${full?.user?.name}<br>${full?.user?.agentcode}</span>`;
            //     }
            // },

           {
                 "data": "name",
                render: function (data, type, full, meta) {
                    return `
                        <strong>${full?.name ?? '-'}</strong><br>
                        <small>${full?.email ?? '-'}</small><br>
                        <span>${full?.mobile ?? '-'}</span>
                    `;
                }
            },

            {
                "data": "account_number",
                render: function(data, type, full, meta) {
                    return `<span> ${full?.account_number}</span>`;
                }
            },
            {
                 "data": "bank_name",
                render: function (data, type, full, meta) {
                    return `
                        <div>
                            <div class="fw-semibold">${full?.bank_name ?? '-'}</div>
                            <div class="">${full?.ifsc_code ?? '-'}</div>
                        </div>
                    `;
                }
            },
            {
                "data": "address",
                render: function(data, type, full, meta) {
                    return `<span> ${full?.address}</span>`;
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