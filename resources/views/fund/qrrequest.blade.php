@extends('layouts.app')
@section('title', 'Wallet Load Request')
@section('pagetitle', 'Wallet Load Request')

@php
    $table = 'yes';

    $status['type'] = 'Fund';
    $status['data'] = [
        'success' => 'Success',
        'pending' => 'Pending',
        'failed' => 'Failed',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
    ];
@endphp

@section('content')
   

    <div class="row mt-4">
        <div class="col-12 col-xl-12 col-sm-12 order-1 order-lg-2 mb-4 mb-lg-0">
            <div class="card">
                <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">
                            <span>@yield('pagetitle') </span>
                        </h5>
                    </div>
                    <div class="col-sm-12 col-md-4 mb-5">

                        <div class="user-list-files d-flex float-end">
                          
                               @if($dynamicqr)
                                   <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#qrModal">
                                <i class="ti ti-plus ti-xs"></i> QR Collection</button>
                                  
                               @else
                               
                                 <button type="button" class="btn btn-primary" data-bs-toggle="offcanvas"
                                data-bs-target="#collectionRequestModal">
                                <i class="ti ti-plus ti-xs"></i> QR Collection</button>
                                @endif
                        </div>
                        
                    
                    </div>
                </div>

                <div class="card-datatable table-responsive">
                    <table width="100%" class="table border-top mb-5" id="datatable" role="grid"
                        aria-describedby="user-list-page-info">
                        <thead class=" text-center bg-light">
                            <tr>
                                <th>#</th>
                                <th>User Details</th>
                                <th>Refrence Details</th>
                                <th>Amount</th>
                                <th>Remark</th>
                                <th>Status</th>
                                 <th>Settlement</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>


    <div class="offcanvas offcanvas-end" id="fundRequestModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-dropback="static">

        <div class="offcanvas-header bg-primary">
            <h4 id="exampleModalLabel" class="text-white">Wallet Fund Request</h4>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                <span aria-hidden="true"></span>
            </button>
        </div>
        <form id="fundRequestForm" action="{{ route('fundtransaction') }}" method="post">
            <div class="offcanvas-body">
                <input type="hidden" name="user_id">
                <input type="hidden" name="type" value="request">
                {{ csrf_field() }}
                <div class="row">
                    <div class="form-group col-md-6 my-1">
                        <label>Deposit Bank</label>
                        <select name="fundbank_id" class="form-control my-1" id="select" required>
                            <option value="">Select Bank</option>
                            @foreach ($banks as $bank)
                                <option value="{{ $bank->id }}">{{ $bank->name }} ( {{ $bank->account }} )</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6 my-1">
                        <label>Amount</label>
                        <input type="number" name="amount" step="any" class="form-control my-1"
                            placeholder="Enter Amount" required="">
                    </div>
                    <div class="form-group col-md-6 my-1">
                        <label>Payment Mode</label>
                        <select name="paymode" class="form-control my-1" id="select" required>
                            <option value="">Select Paymode</option>
                            @foreach ($paymodes as $paymode)
                                <option value="{{ $paymode->name }}">{{ $paymode->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6 my-1">
                        <label>Pay Date</label>
                        <input type="text" name="paydate" class="form-control mydate" placeholder="Select date">
                    </div>
                    <div class="form-group col-md-6 my-1">
                        <label>Ref No.</label>
                        <input type="text" name="ref_no" class="form-control my-1" placeholder="Enter Refrence Number"
                            required="">
                    </div>
                    <div class="form-group col-md-6 my-1">
                        <label>Pay Slip (Optional)</label>
                        <input type="file" name="payslips" class="form-control my-1">
                    </div>
                    <div class="form-group col-md-12">
                        <label>Remark</label>
                        <textarea name="remark" class="form-control my-1" rows="2" placeholder="Enter Remark"></textarea>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" type="submit"
                    data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
            </div>
        </form>

    </div>

    
      <div class="offcanvas offcanvas-end" id="collectionRequestModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-dropback="static">

        <div class="offcanvas-header bg-primary">
            <h4 id="exampleModalLabel" class="text-white">QR Collection</h4>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                <span aria-hidden="true"></span>
            </button>
        </div>
        <form id="pgRequestForm" action="{{ route('fundtransaction') }}" method="post">
            <div class="offcanvas-body">
                  <input type="hidden" name="user_id">
                  <input type="hidden" name="type" value="dynamicqr">
                {{ csrf_field() }}
                <div class="row">
                  
                    <div class="form-group col-md-12 my-1">
                        <label>Label</label>
                        <input type="text" name="label" step="any" value="{{\Auth::user()->shopname}}"  class="form-control my-1"
                            placeholder="Enter label" required="">
                    </div>
                    
                     <div class="form-group col-md-12 my-1">
                        <label>Virtual AccountNumber</label>
                        <input type="text" name="virtualAccountNumber" step="any" value=""  class="form-control my-1"
                            placeholder="Enter virtual AccountNumber" required="">
                    </div>
                    
                    <div class="form-group col-md-12 my-1">
                        <label>Virtual Payment Address</label>
                        <input type="text" name="virtualPaymentAddress" step="any" value=""  class="form-control my-1"
                            placeholder="Enter virtual Payment Address" required="">
                    </div>
                    
                      <div class="form-group col-md-12 my-1">
                        <label> Account Number</label>
                        <input type="text" name="account_number" step="any" value=""  class="form-control my-1"
                            placeholder="Enter Account Number" required="">
                    </div>
                    
                    <div class="form-group col-md-12 my-1">
                        <label>Account IFSC</label>
                        <input type="text" name="account_ifsc" step="any" value=""  class="form-control my-1"
                            placeholder="Enter account ifsc" required="">
                    </div> 
                   
                    <div class="form-group col-md-12">
                        <label>Remark</label>
                        <textarea name="remark" class="form-control my-1" rows="2" placeholder="Enter Remark"></textarea>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" type="submit"
                    data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
            </div>
        </form>

    </div>

  @if($dynamicqr)
   
    
    <div class="modal fade" id="qrModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!--<h5 class="modal-title">QrCode Scan & Pay</h5>-->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row text-center">
                    <div class="col-md-4 mb-3 border-end" id="qrOnlyDownload">
                        <h6 class="fw-bold mb-3">{{ \Auth::user()->company->companyname }} QR Code</h6>
                        <img id="qr-image" src="{{ $dynamicqr->qrcode ?? "" }}" alt="QR Code" class="img-fluid rounded border" width="70%"/>
                    </div>

                    <div class="col-md-4 mb-3 border-end">
                        <h6 class="fw-bold mb-5">Account Details</h6>
                        <p><strong class="text-primary">Name </strong> :  <span class="fs-5">{{ $dynamicqr->label ?? '' }} </span></p>
                        <p><strong class="text-primary">Virtual A/C </strong> : <span class="fs-5">{{ $dynamicqr->virtualAccountNumber ?? '' }}</span></p>
                        <p><strong class="text-primary">IFSC </strong> : <span class="fs-5">{{ $dynamicqr->virtualifsc ?? '' }}</span></p>
                       
                    </div>

                    <div class="col-md-4 mb-3">
                        <h6 class="fw-bold mb-5">VPA Details</h6>
                        <p><strong class="text-primary">VPA </strong> :  <span class="fs-5">{{ $dynamicqr->virtualPaymentAddress ?? '' }}</span></p>
                         <p><strong class="text-primary">Merchant Code </strong> : <span class="fs-5">{{ $dynamicqr->merchent ?? '' }}</span></p>
                          <hr class="my-1"/>
                           <h6 class="fw-bold mb-1">Whitelist Account</h6>
                            <p><strong class="text-primary">AC NO</strong> :  <span class="fs-5">{{ $dynamicqr->account ?? '' }}</span></p>
                             <p><strong class="text-primary">IFSC Code </strong> : <span class="fs-5">{{ $dynamicqr->ifsc ?? '' }}</span></p>
                         <hr class="my-1"/>
                         
                         <button type="button" class="btn btn-primary" id="downloadQRBtn">Download</button>
                    </div>
                </div>
                
                <p class=" small text-center mt-3"> <span>Note ðŸ“¢: </span> <span class="text-warning">Scan the QR or use the details below to complete your payment securely.</span></p>
            </div>
            
           
            

        </div>
    </div>
</div>

  @endif

@endsection

@push('style')
@endpush

@push('script')
    <script src="{{ asset('/assets/js/core/jQuery.print.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js">
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
              $('#downloadQRBtn').on('click', function () {
                const imageSrc = $('#qr-image').attr('src');
                const fileName = 'qr-code.png';
    
                const link = $('<a>')
                    .attr('href', imageSrc)
                    .attr('download', fileName)
                    .css('display', 'none');
    
                $('body').append(link);
                link[0].click();
                link.remove();
            });
            var url = "{{ url('statement/fetch') }}/qrfundrequest/0";
            var onDraw = function() {};
            var options = [{
                    "data": "name",
                    render: function(data, type, full, meta) {
                        return `<span class='text-inverse m-l-10'><b>` + full.id + `</b> </span><br>
                        <span style='font-size:13px'>` + full.updated_at + `</span>`;
                    }
                },
                {
                    "data": "bank",
                    render: function(data, type, full, meta) {
                        return full.user.name +" - "+ full.user.mobile;
                    }
                },
                {
                    "data": "bank",
                    render: function(data, type, full, meta) {
                       
                        return `Ref No. - ` + full.refno + `<br>TXN Id - ` + full.txnid + `<br>Pay Id - ` + full.payid;
                    }
                },
                {
                    "data": "amount",
                    render: function(data, type, full, meta) {
                        return `Amount - ` + full?.amount;

                    }
                },
                {
                    "data": "remark"
                },
                {
                    "data": "action",
                    render: function(data, type, full, meta) {
                        var out = '';
                        if (full.status == "success") {
                            out += `<span class="badge badge-success bg-success">success</span>`;
                        } else if (full.status == "processing") {
                            out += `<span class="badge badge-warning bg-warning"> Processing</span>`;
                        } else if (full.status == "rejected") {
                            out += `<span class="badge badge-danger bg-danger">Rejected</span>`;
                        }
                        return out;
                    }
                },
                {
                    "data": "action",
                    render: function(data, type, full, meta) {
                        var out = '';
                        if (full.settlement == "success") {
                            out += `<span class="badge badge-success bg-success">success</span>`;
                        } else if (full.settlement == "pending") {
                            out += `<span class="badge badge-warning bg-warning"> Processing</span>`;
                        } else if (full.settlement == "processing") {
                            out += `<span class="badge badge-danger bg-danger">T+1</span>`;
                        }

                        return out;
                    }
                },             
            ];

            datatableSetup(url, options, onDraw);

            $("#createVpaForm").validate({
                rules: {
                    account: {
                        required: true
                    },
                    vpa: {
                        required: true
                    },
                    pincode: {
                        required: true
                    },
                    state: {
                        required: true
                    },
                    city: {
                        required: true
                    },
                    address: {
                        required: true
                    },
                    mobile: {
                        required: true
                    },
                    ifsc: {
                        required: true
                    },

                },
                messages: {
                    account: {
                        required: "Please enter a/c number",
                    },
                    vpa: {
                        required: "Please enter request vpa",
                    },
                    pincode: {
                        required: "Please select payment mode",
                    },
                    state: {
                        required: "Please enter State",
                    },
                    city: {
                        required: "Please enter city",
                    },
                    address: {
                        required: "Please enter address",
                    },
                    mobile: {
                        required: "Please enter mobile",
                    },
                    ifsc: {
                        required: "Please enter ifsc",
                    },
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
                    var form = $('#createVpaForm');
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Submit').attr('disabled',
                                false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                form[0].reset();
                                form.closest('.modal').modal('hide');
                                notify(data.message, 'success');
                                $('#datatable').dataTable().api().ajax.reload();
                            } else {
                                notify(data.message, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors, form);
                        }
                    });
                }
            });

            $("#pgRequestForm").validate({
                rules: {
                    amount: {
                        required: true
                    },

                },
                messages: {
                    amount: {
                        required: "Please enter amount",
                    },

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
                    var form = $('#pgRequestForm');
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Submit').attr('disabled',
                                false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                form[0].reset();
                                notify(data.message);
                                window.location.reload();
                            } else {
                                notify(data.message, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors, form);
                        }
                    });
                }
            });


            $("#fundRequestForm").validate({
                rules: {
                    fundbank_id: {
                        required: true
                    },
                    amount: {
                        required: true
                    },
                    paymode: {
                        required: true
                    },
                    ref_no: {
                        required: true
                    },
                },
                messages: {
                    fundbank_id: {
                        required: "Please select deposit bank",
                    },
                    amount: {
                        required: "Please enter request amount",
                    },
                    paymode: {
                        required: "Please select payment mode",
                    },
                    ref_no: {
                        required: "Please enter transaction refrence number",
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
                    var form = $('#fundRequestForm');
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Submit').attr('disabled',
                                false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                form[0].reset();
                                form.closest('.offcanvas').offcanvas('hide');
                                notify("Fund Request submitted Successfull", 'success');
                                $('#datatable').dataTable().api().ajax.reload();
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors, form);
                        }
                    });
                }
            });
        });

        function onboarding() {
            var actiontype = "dynamicqr";
            $.ajax({
                    url: "{{ route('fundtransaction') }}",
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
                        "type": actiontype
                    }
                })
                .done(function(data) {
                    swal.close();

                    // var vpa="{{ $agent->vpaaddress ?? '' }}";
                    //  var merchantBusinessName="{{ $agent->merchantBusinessName ?? '' }}";
                    //var vpastring='upi://pay?pa='+vpa+'&pn='+merchantBusinessName+'&tr=EZV2021101113322400027817&am=&cu=INR';
                    var vpastring = data.data;
                    jQuery(".qrimage").qrcode({
                        width: 250,
                        height: 250,
                        text: vpastring
                    });
                    $('#qrModal').modal();
                    notify(data.status);
                })
                .fail(function(errors) {
                    swal.close();
                    showError(errors, $('#billpayForm'));
                });
        }

        function fundRequest(id = "none") {
            if (id != "none") {
                $('#fundRequestForm').find('[name="fundbank_id"]').val(id).trigger('change');
            }
            $('#fundRequestModal').offcanvas('show');
        }
    </script>
@endpush
