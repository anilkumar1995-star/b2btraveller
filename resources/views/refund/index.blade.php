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
                        <button type="button" class="btn btn-success mb-3" onclick="refundtocustomer()">
                            💰 Refund to Customer
                        </button>
                    </div>
                </div>

                <div class="card-datatable table-responsive">
                    <table width="100%" class="table border-top mb-5" id="datatable">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>ID</th>
                                <th>User Details</th>
                                <th>Customer Details</th>
                                <th>Amount</th>
                                <th>Refund Date</th>
                                <th>Remarks</th>
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
                    <h5 class="modal-title">Add Refund</h5>
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
                                        <option value="{{ $customer->id }}" data-account="{{ $customer->account_number }}"
                                            data-ifsc="{{ $customer->ifsc_code }}" data-bank="{{ $customer->bank_name }}">
                                            {{ $customer->name }} ({{ $customer->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Refund Amount *</label>
                                <div class="input-group">
                                    <span class="input-group-text w-25">₹</span>
                                    <input type="number" step="0.01" min="1" max="100000" name="amount"
                                        id="refund_amount" class="form-control w-75" placeholder="Enter amount" required>
                                </div>
                                <small class="text-muted">Minimum ₹1 | Maximum ₹1,00,000</small>
                            </div>

                            <div class="col-md-6">
                                <label>Account Number</label>
                                <input type="text" id="show_account" name="account_number" class="form-control bg-light"
                                    readonly required>
                            </div>

                            <div class="col-md-6">
                                <label>IFSC Code</label>
                                <input type="text" id="show_ifsc" name="ifsc_code" class="form-control bg-light" readonly
                                    required>
                            </div>

                            <div class="col-md-6">
                                <label>Bank Name</label>
                                <input type="text" id="show_bank" name="bank_name" class="form-control bg-light" readonly
                                    required>
                            </div>
                            {{-- Remarke --}}

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


@endsection

@push('script')
    <script>
        $(document).ready(function() {

            $('#refund_customer').select2({
                dropdownParent: $('#customerModal'),
                placeholder: "Search Customer...",
                width: '100%'
            });


            $(document).on('change', '#refund_customer', function() {

                if ($(this).val() == '') {
                    $('#show_account').val('');
                    $('#show_ifsc').val('');
                    $('#show_bank').val('');
                    return;
                }

                let selectedOption = $(this).find(':selected');

                let account = selectedOption.data('account') || '';
                let ifsc = selectedOption.data('ifsc') || '';
                let bank = selectedOption.data('bank') || '';


                account = account.toString();
                if (account.length > 4) {
                    let masked = 'XXXXXX' + account.slice(-4);
                    $('#show_account').val(masked);
                } else {
                    $('#show_account').val(account);
                }

                // IFSC uppercase
                $('#show_ifsc').val(ifsc.toUpperCase());

                $('#show_bank').val(bank);

            });

        });


        function refundtocustomer() {
            $('#customerModal').modal('show');
        }
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
                            $('#customerModal').modal('hide');
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
                        <small>${full?.user.email ?? '-'}</small><br>
                        <span>${full?.user.mobile ?? '-'}</span>
                    `;
                    }
                },
                {
                    "data": "customer_id",
                    render: function(data, type, full, meta) {
                        return `
                        <small>${full?.customer.name ?? '-'}</small><br>
                        <small>${full?.customer.bank_name ?? '-'}</small><br>
                        <small>${full?.customer.account_number ?? '-'}</small><br>
                        <span>${full?.customer.ifsc_code ?? '-'}</span>
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
                    "data": "refund_date",
                    render: function(data, type, full, meta) {
                        return `
                        <div>
                            <div class="fw-semibold">${full?.created_at ?? '-'}</div>
                        </div>
                    `;
                    }
                },
                {
                    "data": "remarks",
                    render: function(data, type, full, meta) {
                        return `<span> ${full?.remarks ?? 'N/A'}</span>`;
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
