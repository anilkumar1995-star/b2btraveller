@extends('layouts.app')
@section('title', 'Bill Payment')
@section('pagetitle', 'Bill Payment')


@section('content')
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
{{-- <title>Document</title> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script> --}}
<style>
    tr {
        padding: 2px;
    }

    .fw-bold1 {
        font-weight: 500;
        padding: 4px;
    }
</style>

<div class="card border mb-3">
    <div class="card-header mb-3 bg-label-primary recharge-header
            d-flex align-items-center justify-content-between">

        <div class="d-flex align-items-center gap-2">
            <i class="fa fa-receipt text-primary fs-5"></i>
            <h5 class="mb-0">Bill Payments</h5>
        </div>
        <div class="text-black fs-4">
            Transaction Details
        </div>

        <div>
            <img src="https://ipayments.in/img/IPAYMNT.png"
                alt="Logo" class="img-fluid"
                style="height:30px">
        </div>

    </div>

    <div class="card-body p-4" id="billrecipt">

        @if(isset($error) && !empty($error))
        <div class="alert alert-danger text-center">
            {{ $error }}
            <div class="mt-3">
                <a href="{{ route('home') }}" class="btn btn-outline-primary btn-sm">
                    Go To Dashboard
                </a>
            </div>
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-borderless table-sm mb-0">
                <tbody>
                    <tr>
                        <td class="fw-semibold">Biller Name</td>
                        <td>{{ @$order->billerName ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Operator Name</td>
                        <td>{{ @$order->providername ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Bill Number</td>
                        <td>{{ @$order->billerNo ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Bill Date</td>
                        <td>{{ @$order->option2 ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Bill Due Date</td>
                        <td>{{ @$order->option3 ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Transaction Date</td>
                        <td>{{ @$order->created_at ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Transaction ID</td>
                        <td>{{ @$order->txnid ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Reference No</td>
                        <td>{{ @$order->refno ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Amount</td>
                        <td><strong>₹ {{ number_format(@$order->amount ?? 0, 2) }}</strong></td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Status</td>
                        <td>
                            <span class="badge 
                                                    {{ ($order->status ?? '') == 'success' ? 'bg-success' :
                                                    (($order->status ?? '') == 'pending' ? 'bg-warning' :
                                                    (($order->status ?? '') ? 'bg-danger' : 'bg-secondary')) }}">
                                {{ strtoupper(@$order->status ?? 'N/A') }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Remark</td>
                        <td>{{ @$order->remark ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Description</td>
                        <td>{{ @$order->description ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endif

    </div>
    @if(!isset($error) || empty($error))
    <div class="card-footer mb-2 bg-white border-0 text-center">
        <button class="btn btn-primary px-4" type="button" id="print">
            <i class="fa fa-print me-1"></i> Print Receipt
        </button>
    </div>
    @endif
</div>

@endsection

@push('script')
<script src="{{ asset('/assets/js/core/jQuery.print.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#print').on('click', function() {

            @if(isset($error) && !empty($error))
            alert('Receipt not available for printing');
            return false;
            @endif

            $('#billrecipt').print();
        });

    });
</script>
@endpush