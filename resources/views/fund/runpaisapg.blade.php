@extends('layouts.app')
@section('title', 'Wallet Load Request')
@section('pagetitle', 'Runpaisa PG Request')

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
$mode = 'PROD';
if ($mode == 'PROD') {
$url = 'https://pay.easebuzz.in/payment/initiateLink';
} else {
$url = 'https://pay.easebuzz.in/payment/initiateLink';
}
@endphp

@section('content')
<div class="row mt-4">
    <div class="col-12 col-xl-12 col-sm-12 order-1 order-lg-2 mb-4 mb-lg-0">
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4 ">
                <div class="card-title mb-5">
                    <h5 class="mb-0">
                        <span>@yield('pagetitle')</span>
                    </h5>
                </div>
                <div class="col-sm-12 col-md-3 mb-5">
                    @if (Myhelper::hasNotRole('admin'))
                    <div class="user-list-files d-flex float-right">
                        <button class="btn btn-success me-1 text-white" data-loading-text="<b><i class='fa fa-spin fa-spinner'></i></b> Searching" data-bs-toggle="offcanvas" data-bs-target="#fundRequestModal">
                            New Request</button>
                        <button class="btn btn-success ms-1 text-white" data-loading-text="<b><i class='fa fa-spin fa-spinner'></i></b> Searching" data-bs-toggle="offcanvas" data-bs-target="#linkRequestModal">
                            Get Link</button>
                    </div>
                    @endif
                </div>
            </div>
            <div class="card-datatable table-responsive datatable-scroll" id="datatable_wrapper">
                <table width="100%" class="table dataTable border-top mb-5" id="datatable" role="grid" aria-describedby="datatable_info">
                    <thead class=" text-center bg-light">
                        <tr>
                            <th>#</th>
                            <th>User Details</th>
                            <th>Refrence Details</th>
                            <th>Amount</th>
                            <th>Remark</th>
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
<div class="offcanvas offcanvas-end" id="fundRequestModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
   
            <div class="offcanvas-header bg-primary">
                 <div class="text-center">
                    <h4 class="text-white">Wallet Fund Request</h4>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
               
            </div>
                <form id="pgRequestForm" action="{{ route('runpaisaTransaction') }}" method="post">
                    <div class=" offcanvas-body">
                        <input type="hidden" name="user_id">
                        <input type="hidden" name="type" value="pgdirect">
                        {{ csrf_field() }}
                        <div class="row">

                            <div class="form-group my-1 col-md-6">
                                <label>Amount</label>
                                <input type="number" name="amount" step="any" class="form-control my-1" placeholder="Enter Amount" required="">
                            </div>
                            <div class="form-group my-1 col-md-6">
                                <label>Mobile</label>
                                <input type="tel" maxlength="10" name="mobile" step="any" class="form-control my-1" placeholder="Enter Mobile" required="">
                            </div>
                            <div class="form-group my-1 col-md-12">
                                <label>Email</label>
                                <input type="text" name="email" step="any" class="form-control my-1" placeholder="Enter Email" required="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group my-1 col-md-12">
                                <label>Remark</label>
                                <textarea name="remark" class="form-control my-1" rows="2" placeholder="Enter Remark" required=""></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary me-2" data-dismiss="offcanvas" aria-hidden="true">Close</button>
                        <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
                    </div>
                </form>
           
</div>
<div class="offcanvas offcanvas-end" id="linkRequestModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
   
            <div class="offcanvas-header bg-primary">
                <div class="text-center">
                    <h4 class="text-white">Get Payment Links</h4>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
               
            </div>
                <form id="linkRequestForm" action="{{ route('runpaisaTransaction') }}" method="post">
                    <div class="offcanvas-body">
                        <input type="hidden" name="user_id">
                        <input type="hidden" name="type" value="pgdirect">
                        {{ csrf_field() }}
                        <div class="row">

                            <div class="form-group my-1 col-md-6">
                                <label>Amount</label>
                                <input type="number" name="amount" step="any" class="form-control my-1" placeholder="Enter Amount" required="">
                            </div>
                            <div class="form-group my-1 col-md-6">
                                <label>Mobile</label>
                                <input type="tel" maxlength="10" name="mobile" step="any" class="form-control my-1" placeholder="Enter Mobile" required="">
                            </div>
                            <div class="form-group my-1 col-md-12">
                                <label>Email</label>
                                <input type="text" name="email" step="any" class="form-control my-1" placeholder="Enter Email" required="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group my-1 col-md-12">
                                <label>Remark</label>
                                <textarea name="remark" class="form-control my-1" rows="2" placeholder="Enter Remark" required=""></textarea>
                            </div>
                        </div>

                        <div class="mydiv">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary me-2" data-dismiss="offcanvas" aria-hidden="true">Close</button>
                        <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
                    </div>
                </form>
            
</div>
@endsection

@push('script')
<script type="text/javascript">
    $(document).ready(function() {
        var url = "{{ url('statement/fetch') }}/fundrequest/0";
        var onDraw = function() {};
        var options = [{
                "data": "name",
                render: function(data, type, full, meta) {
                    return `<span class='text-inverse m-l-10'><b>` + full.id + `</b> </span><br>
                        <span style='font-size:13px'>` + full.updated_at + `</span>`;
                }
            },
            {
                "data": "username"
            },
            {
                "data": "bank",
                render: function(data, type, full, meta) {

                    return `Ref No. - ` + full.ref_no + `<br>Paymode - ` + full.paymode;
                }
            },
            {
                "data": "amount"
            },
            {
                "data": "remark"
            },
            {
                "data": "action",
                render: function(data, type, full, meta) {
                    var out = '';
                    if (full.status == "success" || full.status == "approved") {
                        out += `<label class="bg-success badge badge-success">Approved</label>`;
                    } else if (full.status == "pending") {
                        out += `<label class="bg-warning badge badge-warning">Pending</label>`;
                    } else if (full.status == "failed") {
                        out += `<label class="bg-danger badge badge-danger">Rejected</label>`;
                    }

                    return out;
                }
            }
        ];

        datatableSetup(url, options, onDraw);

        $("#pgRequestForm").validate({
            rules: {

                amount: {
                    required: true
                }

            },
            messages: {

                amount: {
                    required: "Please enter request amount",
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
                var form = $('#pgRequestForm');
                form.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {
                        form.find('button:submit').html('Please wait...').attr('disabled',true).addClass('btn-secondary');
                    },
                    complete: function() {
                        form.find('button:submit').html('Submit').attr('disabled',false).removeClass('btn-secondary');
                    },
                    success: function(data) {
                        console.log(data.data);
                        if (data.status == "TXN") {

                            window.open(data.data, '_blank');

                        } else {
                            notify(data.message || data.status, 'warning');
                        }
                    },
                    error: function(errors) {
                        showError(errors, form);
                    }
                });
            }
        });

        $("#linkRequestForm").validate({
            rules: {

                amount: {
                    required: true
                }

            },
            messages: {

                amount: {
                    required: "Please enter request amount",
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
                var form = $('#linkRequestForm');
                form.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {
                        form.find('button:submit').html('Please wait...').attr('disabled',true).addClass('btn-secondary');
                    },
                    complete: function() {
                        form.find('button:submit').html('Submit').attr('disabled',false).removeClass('btn-secondary');
                    },
                    success: function(data) {
                        console.log(data.data);
                        if (data.status == "TXN") {

                            // window.open(data.data,'_blank');
                            // swal({
                            //   title: "Link Genrated</small>",
                            //   text:   "<p>" +data.data + "</p>",
                            //   html: true
                            // });
                            myFunction(data.data)
                            swal({
                                title: "Link Genrated",
                                text: "A custom <span style='color:#F8BB86'>html<span> message.",
                                html: "<span id='myInput'>" + data.data +
                                    "</span> <button><i class='fa fa-copy'></i></button>"
                            });
                        } else {
                            notify(data.message || data.status, 'warning');
                        }
                    },
                    error: function(errors) {
                        showError(errors, form);
                    }
                });
            }
        });

    });


    function fundRequest(id = "none") {
        if (id != "none") {
            $('#fundRequestForm').find('[name="fundbank_id"]').select2().val(id).trigger('change');
        }
        $('#fundRequestModal').offcanvas('show');
    }

    function myFunction(copyText) {

        navigator.clipboard.writeText(copyText);

    }
</script>
@endpush