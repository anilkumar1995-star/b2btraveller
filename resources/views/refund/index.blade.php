@extends('layouts.app')
@section('title', 'Refund List')
@section('pagetitle', 'Refund List')

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

                    <div>


                        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal"
                            data-bs-target="#refundModal">
                            💰 Refund to Customer
                        </button>
                        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                            data-bs-target="#customerModal">
                            + Add Customer
                        </button>
                    </div>
                </div>

                <div class="card-datatable table-responsive">
                    <table width="100%" class="table border-top mb-5" id="datatable">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>ID</th>
                                <th>User Info</th>
                                <th>Customer Info</th>
                                <th>Bank Info</th>
                                <th>Amount</th>
                                <th>Refund/Remarks</th>
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



    <div class="modal" id="refundModal" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Refund to Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>

                <form id="refundForm" method="POST" action="{{ route('createrefund') }}">
                    @csrf

                    <div class="modal-body">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label>Select Customer *</label>
                                <select class="form-control" id="refund_customer" name="customer_id" required>
                                    <option value="">-- Select Customer --</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">
                                            {{ $customer->first_name }} {{ $customer->last_name }} ({{ $customer->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Refund Amount *</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="width: 10%">₹</span>
                                    <input type="number" style="width: 90%" step="0.01" min="1" max="100000"
                                        name="amount" id="refund_amount" class="form-control w-75"
                                        placeholder="Enter amount" required>
                                </div>
                                <small class="text-muted">Minimum ₹1 | Maximum ₹1,00,000</small>
                            </div>

                            <div class="col-md-6">
                                <label>Account Number</label>
                                <input type="text" name="account_number" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label>IFSC Code</label>
                                <input type="text" name="ifsc_code" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label>Bank Name</label>
                                <input type="text" name="bank_name" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label>Remarks</label>
                                <textarea name="remarks" class="form-control" rows="1" placeholder="Enter remarks (optional)"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Refund Amount</button>
                    </div>

                </form>


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
                            <div class="col-md-4">
                                <label>First Name : <b class="text-danger">*</b></label>
                                <input type="text" name="first_name" class="form-control" required
                                    placeholder="Enter Customer First Name "><span class="text-danger error-label"
                                    id="error-label"></span>
                            </div>
                            <div class="col-md-4">
                                <label>Last Name : <b class="text-danger">*</b></label>
                                <input type="text" name="last_name" class="form-control" required
                                    placeholder="Enter Customer Last Name "><span class="text-danger error-label"
                                    id="error-label"></span>
                            </div>

                            <div class="col-md-4">
                                <label>Email : <b class="text-danger">*</b></label>
                                <input type="email" name="email" class="form-control" required
                                    placeholder="Enter Customer Email "><span class="text-danger error-label"
                                    id="error-label"></span>
                            </div>
                            <div class="col-md-4">
                                <label>Mobile : <b class="text-danger">*</b></label>
                                <input type="text" name="mobile" class="form-control" required
                                    placeholder="Enter Customer Mobile Number "><span class="text-danger error-label"
                                    id="error-label"></span>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Gender<span class="text-danger">*</span></label>
                                <select class="form-select required-field" name="gender">
                                    <option value="">Select</option>
                                    <option value="1">Male</option>
                                    <option value="2">Female</option>
                                    <option value="3">Other</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Date of Birth: <b class="text-danger">*</b></label>
                                <input type="date" name="dob" class="form-control" required><span
                                    class="text-danger error-label" id="error-label"></span>
                            </div>
                            <div class="col-md-4">
                                <label>Nationality: <b class="text-danger">*</b></label>
                                {{-- select bnao --}}
                                <select name="nationality" class="form-control" required>
                                    <option value="">Select Nationality</option>
                                    <option value="IN">Indian</option>
                                    <option value="US">American</option>
                                    <option value="GB">British</option>
                                    <option value="CA">Canadian</option>
                                    <option value="AU">Australian</option>
                                    <option value="DE">German</option>
                                    <option value="FR">French</option>
                                    <option value="JP">Japanese</option>
                                    <option value="CN">Chinese</option>
                                    <option value="Other">Other</option>
                                </select>

                            </div>
                            <div class="col-md-4">
                                <label>Address Line 1: <b class="text-danger">*</b></label>
                                <input type="text" name="address1" class="form-control" required
                                    placeholder="Enter Customer Address Line 1 "><span class="text-danger error-label"
                                    id="error-label"></span>
                            </div>
                            <div class="col-md-4">
                                <label>Address Line 2: <b class="text-danger">*</b></label>
                                <input type="text" name="address2" class="form-control" required
                                    placeholder="Enter Customer Address Line 2 "><span class="text-danger error-label"
                                    id="error-label"></span>
                            </div>
                            <div class="col-md-4">
                                <label>City: <b class="text-danger">*</b></label>
                                <input type="text" name="city" class="form-control" required
                                    placeholder="Enter Customer City "><span class="text-danger error-label"
                                    id="error-label"></span>
                            </div>
                            <div class="col-md-4">
                                <label>Pan Number: <b class="text-danger">*</b></label>
                                <input type="text" name="pan_number" class="form-control" required
                                    placeholder="Enter Customer Pan Number "><span class="text-danger error-label"
                                    id="error-label"></span>
                            </div>
                            <div class="col-md-4">
                                <label>Passport Number: <b class="text-danger">*</b></label>
                                <input type="text" name="passport_number" class="form-control" required
                                    placeholder="Enter Customer Passport Number "><span class="text-danger error-label"
                                    id="error-label"></span>
                            </div>
                            <div class="col-md-4">
                                <label>Passport Expiry Date: <b class="text-danger">*</b></label>
                                <input type="date" name="passport_expiry" class="form-control" required><span
                                    class="text-danger error-label" id="error-label"></span>
                            </div>
                            <div class="col-md-4">
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

            $('#refund_customer').select2({
                dropdownParent: $('#refundModal'),
                placeholder: "Search Customer...",
                width: '100%'
            });
        });


        $("#refundForm").validate({
            submitHandler: function() {
                var form = $('form#refundForm');
                form.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {
                        form.find('button:submit').html('Please wait...').attr(
                            'disabled', true).addClass('btn-secondary');
                    },
                    success: function(data) {
                        form.find('button:submit').html('Refund Amount').attr(
                            'disabled',
                            false).removeClass('btn-secondary');
                        if (data.status == "success") {
                            $('#datatable').dataTable().api().ajax.reload();
                            notify("Refund Added Successfully", 'success');
                            $('#refundModal').modal('hide');
                        } else {
                            notify(data.status, 'error');
                        }
                    },
                    error: function(errors) {
                        form.find('button:submit').html('Refund Amount').attr(
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
            var url = "{{ url('statement/fetch') }}/refundlist/0";

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
                        <strong>${full?.user.name ?? '-'}</strong><br>
                        <span>${full?.user.email ?? '-'}</span><br>
                        <span>${full?.user.mobile ?? '-'}</span>
                    `;
                    }
                },
                {
                    "data": "customer_id",
                    render: function(data, type, full, meta) {
                        return `
                        <span>${full?.customer.name ?? '-'}</span><br>
                        <span>${full?.customer.email ?? '-'}</span><br>
                        <span>${full?.customer.mobile ?? '-'}</span><br>
                        
                    `;
                    }
                },
                {
                    "data": "bank_name",
                    render: function(data, type, full, meta) {
                        return `
                        <span>${full?.bank_name ?? '-'}</span><br>
                        <span>${full?.account_number ?? '-'}</span><br>
                        <span>${full?.ifsc_code ?? '-'}</span><br>
                        
                    `;
                    }
                },
                {
                    "data": "amount",
                    render: function(data, type, full, meta) {
                        return `₹<span>${full?.amount}</span>`;
                    }
                },
                {
                    "data": "remarks",
                    render: function(data, type, full, meta) {
                        return ` <div class="fw-semibold">${full?.created_at ?? '-'}</div>
                        <span> ${full?.remarks ?? 'N/A'}</span>`;
                    }
                },
                {
                    "data": "status",
                    render: function(data, type, full, meta) {
                        const status = full?.status === 'success';
                        if (status) {
                            return `<span class="btn btn-sm btn-success ">Success</span>`;
                        } else {
                            return `<span class="btn btn-sm btn-danger ">Failed</span>`;
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
