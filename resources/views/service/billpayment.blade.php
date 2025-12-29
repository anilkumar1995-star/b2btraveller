@extends('layouts.app')
@section('title', ucfirst($type) . ' Bill Payment')
@section('pagetitle', ucfirst($type) . ' Bill Payment')
@php
$table = 'yes';
@endphp

<style>
    .select2-container--default .select2-selection--single {
        border: 1px solid #dbdade !important;
        height: 38px !important;
        border-radius: 0.375rem !important;
        line-height: 1.5 !important;
        border-radius: 0.375rem !important;
        font-size: 0.9375rem !important;
        padding: 0.422rem 0.375rem !important;
        width: 100% !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #807c8c !important;
        line-height: 25px !important;
    }
    .select2-container--default .select2-results>.select2-results__options{
        cursor: pointer !important;
    }
</style>

@section('content')

<div class="row g-4">
    <div class="col-lg-7 col-12">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-label-primary text-white rounded-top-4">
                <h5 class="mb-0">
                    <i class="ti ti-receipt me-2"></i> Bill Payment
                </h5>
            </div>

            <div class="card-body p-4">
            <!-- 
                @if ($mydata['billnotice'])
                    <div class="alert alert-warning small">
                        {{ $mydata['billnotice'] }}
                    </div>
                @endif -->

                <form id="billpayForm" action="{{ route('billpay') }}" method="post">
                    {{ csrf_field() }}

                    <input type="hidden" name="type" value="getbilldetails">
                    <input type="hidden" name="operatorType" value="{{ $type }}">
                    <input type="hidden" name="refId">
                    <input type="hidden" name="billId">
                    <input type="hidden" name="mode" value="online">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            {{ ucfirst($type) }} Operator
                        </label>
                        <select class="form-select" name="provider_id" onchange="SETTITLE()" required id="mySelect">
                            <option value="">Select Operator</option>
                            @foreach ($providers as $provider)
                                <option value="{{ $provider->id }}">
                                    {{ $provider->name }} (Coverage: {{ strtoupper($provider->billerCoverage) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mobile Number</label>
                        <input type="text" class="form-control" name="mobileNo"
                            placeholder="Enter registered mobile number">
                    </div>

                    <div class="billdata mb-3">

                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Transaction Pin
                           
                        </label>
                        <input type="password" name="pin" class="form-control"
                            placeholder="Enter transaction pin" required>  <a href="{{ url('profile/view?tab=pinChange') }}"
                               class="float-end text-decoration-none small" target="_blank"> 
                                Forgot / Generate?
                            </a>
                    </div><br>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="submit" class="btn btn-outline-primary px-4" id="fetch">
                            <i class="ti ti-search me-1"></i> Fetch Bill
                        </button>
                        <button type="submit" class="btn btn-success px-4 submit-button" id="pay">
                            <i class="ti ti-credit-card me-1"></i> Pay Now
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


   <div class="col-lg-5 col-12">
    <div class="card shadow-sm border-0 rounded-4 h-100">
        <div class="card-header bg-label-primary fw-semibold d-flex align-items-center justify-content-between">
            <span class="text-black">
                <i class="ti ti-history me-1 text-primary"></i> Recent Transactions
            </span>
            <a href="#" class="small text-decoration-none">
                View All
            </a>
        </div>

        <div class="card-body p-0">

            @if(!empty($recentTransactions) && count($recentTransactions))
            <ul class="list-group list-group-flush">
                @foreach($recentTransactions as $txn)
                    <li class="list-group-item py-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fw-semibold">
                                    {{ $txn->providername }}
                                </div>
                                <div class="small text-muted">
                                    {{ $txn->number }}
                                </div>
                                <div class="small text-muted">
                                    {{ $txn->created_at }}
                                </div>
                            </div>

                            <div class="text-end">
                                <div class="fw-bold">
                                    ₹ {{ number_format($txn->amount, 2) }}
                                </div>

                                @if($txn->status == 'success')
                                    <span class="badge bg-success">Success</span>
                                @elseif($txn->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @else
                                    <span class="badge bg-danger">Failed</span>
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="ti ti-receipt-off fs-1 mb-2"></i>
                        <div>No recent transactions</div>
                    </div>
                @endif
        </div>
    </div>
  </div>

</div>


@endsection

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@push('script')
<script src="{{ asset('/assets/js/core/jQuery.print.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#mySelect').select2();
        var url = "{{ url('statement/fetch') }}/{{ $type }}statement/0";

        var onDraw = function() {};

        var options = [{
                "data": "name",
                render: function(data, type, full, meta) {
                    return `<div>
                            <span class='text-inverse m-l-10'><b>` + full.id + `</b> </span>
                            <div class="clearfix"></div>
                        </div><span style='font-size:13px' class="pull=right">` + full.created_at + `</span>`;
                }
            },
            {
                "data": "name",
                render: function(data, type, full, meta) {
                    return `
                        <span style='font-size:13px' class="pull=right">` + full.created_at + `</span>`;
                }
            },
            {
                "data": "username"
            },
            {
                "data": "bank",
                render: function(data, type, full, meta) {
                    return `Number - ` + full.number + `<br>Operator - ` + full.providername;
                }
            },
            {
                "data": "bank",
                render: function(data, type, full, meta) {
                    return `Ref No.  - ` + full.refno + `<br>Txnid - ` + full.txnid;
                }
            },
            {
                "data": "bank",
                render: function(data, type, full, meta) {
                    return `Amount - <i class="fa fa-inr"></i> ` + full.amount +
                        `<br>Profit - <i class="fa fa-inr"></i> ` + full.profit;
                }
            },
            {
                "data": "status",
                render: function(data, type, full, meta) {
                    if (full.status == "success") {
                        var out = `<span class="badge badge-success">Success</span>`;
                    } else if (full.status == "pending") {
                        var out = `<span class="badge badge-warning">Pending</span>`;
                    } else if (full.status == "reversed") {
                        var out = `<span class="badge badge-primary">Reversed</span>`;
                    } else {
                        var out = `<span class="badge badge-danger">Failed</span>`;
                    }

                    return out;
                }
            }
        ];

        datatableSetup(url, options, onDraw);

        $('#print').click(function() {
            $('#receipt').find('.modal-body').print();
        });

        $('#mySelect').select2({
            ajax: {
                url: "{{ url('billpay/providersByName') }}",
                type: 'post',
                minimumInputLength: 2,
                data: function(params) {
                    var query = {
                        searchname: params.term,
                        type: `{{ $type }}`,
                        page: params.page || 1,
                        _token: `{{csrf_token()}}`

                    }
                    return query;
                },
                processResults: function(item, params) {
                    // console.log(item,params);
                    let billerlist = [];

                    if (item.providers) {
                        for (let data of item.providers) {
                            billerlist.push({
                                "id": data.id,
                                "text": data.name + '\xa0\xa0\xa0\xa0\xa0' + "-\xa0\xa0Coverage :\xa0\xa0"+ data.billerCoverage.toUpperCase()
                            })

                        }
                    }
                    // console.log(billerlist);
                    return {
                        results: billerlist,
                    };
                },
                cache: true
            }
        });

        $("#billpayForm").validate({
            rules: {
                provider_id: {
                    required: true,
                    number: true,
                },
                amount: {
                    required: true,
                    number: true,
                    min: 10
                },
                biller: {
                    required: true
                },
                duedate: {
                    required: true,
                },
            },
            messages: {
                provider_id: {
                    required: "Please select recharge operator",
                    number: "Operator id should be numeric",
                },
                amount: {
                    required: "Please enter recharge amount",
                    number: "Amount should be numeric",
                    min: "Min recharge amount value rs 10",
                },
                biller: {
                    required: "Please enter biller name",
                },
                duedate: {
                    required: "Please enter biller duedate",
                }
            },
            errorElement: "p",
            errorPlacement: function(error, element) {
                if (element.prop("tagName").toLowerCase() === "select") {
                    error.insertAfter(element.closest(".form-group").find(".select2"));
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function() {
                var form = $('#billpayForm');
                var id = form.find('[name="id"]').val();
                var type = form.find('[name="type"]').val();

                form.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {

                        // if (type == "getbilldetails") {
                        swal({
                            title: 'Wait!',
                            text: 'We are fetching bill details',
                            onOpen: () => {
                                swal.showLoading()
                            },
                            allowOutsideClick: () => !swal.isLoading()
                        });
                        // }
                    },
                    complete: function() {
                        swal.close();
                    },
                    success: function(data) {

                        if (data.statuscode == "TXN") {
                            $('#billpayForm').find('[name="type"]').val("payment");
                            $('#billpayForm').find('[name="refId"]').val(data.data.refId);
                            $('#billpayForm').find('[name="mode"]').val(data.data.mode);
                            $('#billpayForm').find('[name="billId"]').val(data.data.billId);
                            $('.billdata').append(`
                                <div class="form-group mb-2">
                                    <label>Consumer Name</label>
                                    <input type="text" name="customerName" value="` + data.data.customerName + `" class="form-control" placeholder="Enter name" required="">
                                </div>
                                <div class="form-group mb-2">
                                    <label>Due Date</label>
                                    <input type="text" name="dueDate" value="` + data.data.dueDate + `" class="form-control" placeholder="Enter due date" required="">
                                </div>
                                <div class="form-group mb-2">
                                    <label>Bill Date</label>
                                    <input type="text" name="billDate" value="` + data.data.billDate + `" class="form-control" placeholder="Enter due date" required="">
                                </div>
                                
                                    <input type="hidden" name="billNumber" value="` + data.data.billNumber + `" class="form-control" placeholder="Enter due date" required="">
                                    <input type="hidden" name="billerId" value="` + data.data.billerId + `" class="form-control" placeholder="Enter due date" required="">
                                
                                <div class="form-group mb-2">
                                    <label>Amount</label>
                                    <input type="text" name="amount" value="` + data.data.amount + `" class="form-control" placeholder="Enter amount" required="">
                            </div>
                            <div class="form-group mb-2">
                                    <label>Email ID</label>
                                    <input type="text" name="email"  class="form-control" placeholder="Enter Email ID" required="">
                                </div>
                            `);

                            $('#fetch').hide();
                            $('#pay').show();

                        } else if (data.status == "success" || data.status == "pending" || data.status == "failed") {
                            // console.log('elseif')
                            form[0].reset();
                            $('#billpayForm').find('[name="type"]').val("getbilldetails");
                            form.find('select').select2().val(null).trigger('change');
                            getbalance();
                            notify("Billpayment Successfully Submitted", 'success');

                            // swal({
                            //     title: 'Success',
                            //     text: "Billpayment Successfully Submitted",
                            //     type: 'success',
                            //     onClose: () => {
                            window.location.href = "{{ url('billpayrecipt') }}/" + data.data.id;
                            //     }
                            // });                        

                        } else {
                            notify(data.message || data.status || "Something went wrong", 'error');
                        }
                    },
                    error: function(errors) {
                        swal.close();
                        // showError(errors, form);
                        notify(errors.responseJSON.status || errors.responseJSON || "Something went wrong", 'error');
                        $('#fetch').html('Fetch');
                        $('#pay').html('Pay');
                    }
                });
            }
        });
    });

    function SETTITLE() {
        var providerid = $('[name="provider_id"]').val();

        // console.log(providerid);

        if (providerid != '' && providerid != null && providerid != 'null') {
            $.ajax({
                    url: "{{ route('getprovider') }}",
                    type: 'post',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        swal({
                            title: 'Wait!',
                            text: 'We are fetching bill details',
                            onOpen: () => {
                                swal.showLoading()
                            },
                            allowOutsideClick: () => !swal.isLoading()
                        });
                    },
                    data: {
                        "provider_id": providerid
                    }
                })
                .done(function(data) {
                    swal.close();
                    $('#billpayForm').find('[name="type"]').val("getbilldetails");
                    $('.billdata').empty();
                    // $.each(data.paramname, function(i, val) {
                    //     var html = '<div>';
                    //     html += '<div class="form-group mb-2">';
                    //     html += '<label>' + data.paramname[i] + '</label>';
                    //     html += '<input type="text" name="number' + i + '" class="form-control" placeholder="Enter ' + data.paramname[i] + '">';
                    //     html += '</div>';
                    //     html += '</div>';


                    //     // alert(html)
                    //     $('.billdata').append(html);
                    // });
                    moredetails(data)
                    if (data.fetchOption == "NOT_SUPPORTED") {
                        $('#billpayForm').find('[name="type"]').val("payment");
                        $('.billdata').append(`
                                <div class="form-group mb-2">
                                    <label>Consumer Name</label>
                                    <input type="text" name="biller" class="form-control" placeholder="Enter name" required="">
                                </div>   
                                <div class="form-group mb-2">
                                    <label>Amount</label>
                                    <input type="text" name="amount"  class="form-control" placeholder="Enter amount" required="">
                            </div>
                            <div class="form-group mb-2">
                                    <label>Email ID</label>
                                    <input type="text" name="email"  class="form-control" placeholder="Enter Email ID" required="">
                                </div>
                            `);
                        $('#fetch').hide();
                        $('#pay').show();
                    }

                })
                .fail(function(errors) {
                    swal.close();
                    showError(errors, $('#billpayForm'));
                });
        }

        function moredetails(item) {
            var i = 0;
            var html = '';
            var htmlformfiled = '';
            // console.log(item);
            html = '<div>';
            html += '<div class="form-group mb-2">';
            html += '<label>Biller Coverage</label>';
            html += '<input type="text"  name="cov" class="form-control" placeholder="Enter ' + item.billerCoverage.toUpperCase() + '" value='+item.billerCoverage.toUpperCase()+' readonly>';
            html += '</div>';
            html += '</div>';
            htmlformfiled += html

            for (let z of JSON.parse(item.customerReqParam)) {
                var x = JSON.parse(z);
                // console.log(x);
                html = '<div>';
                html += '<div class="form-group mb-2">';
                html += '<label>' + x.customParamName + '</label>';
                html += '<input type="text"  name="number' + i + '" class="form-control" placeholder="Enter ' + x.customParamName + '">';
                html += '</div>';
                html += '</div>';
                htmlformfiled += html
                i = i + 1;
            }
            $('.billdata').append(htmlformfiled);




        }
    }
</script>
@endpush