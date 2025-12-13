@extends('layouts.app')
@section('title', 'ID Card')
@section('pagetitle', 'ID Card')


<?php

$getDet = App\Models\Agents::where('user_id', Auth::user()->id)->first(['bc_id']);
$getDet = @$getDet->bc_id ?? Auth::user()->id;

?>


@section('content')
<style>
    .datatable-img {
    background-image: url('{{asset('assets/')}}/idcardImg.jpg');
    background-size: 100% 100%;
}

@media print {
    .datatable-img {
        -webkit-print-color-adjust: exact !important; /* For Chrome */
        background-image: url('{{asset('assets/')}}/idcardImg.jpg') !important;
    }
}
</style>


    <div class="row">
        <div class="col-12 col-xl-12 col-sm-12 order-1 order-lg-2 mb-lg-0">
            <div class="card">

                <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4 ">
                    <div class="card-title">
                        <h4 class="mb-0">
                            <span>ID Card</span>
                        </h4>
                    </div>
                    <div class="col-sm-12 col-md-1 ">
                        <div class=" d-flex float-right">
                            <button type="button" class="btn btn-primary text-white" id="print"> <i
                                    class="ti ti-printer"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body" id="printable">
                    <div class="card-table table-responsive p-2" style="overflow-y:hidden">

                        <table class="mx-auto border datatable-img"
                            style="height:420px;width:auto">
                            {{-- background-image:url('{{ asset('assets/') }}/idcardImg.jpg');background-size:100% 100%; --}}
                            
                            <tr style="width: 100%">
                                <td colspan="2" style="width: 100%;text-align:center">

                                    @if (Auth::user()->company->logo)
                                        <div style="width:50px;height:30px;position: relative;top:-5px;" class="mx-auto">
                                            <img src="{{ Imagehelper::getImageUrl() . Auth::user()->company->logo }}"
                                                class=" img-responsive" alt="" width="100%" height="100%">
                                        </div>
                                    @else
                                        <div style="height:30px;position: relative;top:-5px;" class="mx-auto">
                                            <span class="fw-bold fs-6">{{ Auth::user()->company->companyname }}</span>
                                        </div>
                                    @endif

                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">

                                    <div style="width:107px;height:80x !important;border-radius:50%;overflow:hidden;position: relative;top:-7px;"
                                        class="mx-auto">

                                        @if (Auth::user()->profile)
                                            <img src="{{ Imagehelper::getImageUrl() . Auth::user()->profile }}"
                                                class="img-responsive" alt="" width="100%" height="100px">
                                        @else
                                            <img src="{{ asset('assets/') }}/idcardimage.jpg" class="img-responsive"
                                                alt="" width="100%" height="100px">
                                        @endif
                                        <div>

                                </td>
                            </tr>


                            <tr>
                                <td colspan="2" style="padding:0px 50px;position: relative;top: -60px;color: black;">
                                    <div style="text-align: center"> {{ strtoupper(Auth::user()->name) }}
                                        <br>
                                        (<u><i>{{ strtoupper(Auth::user()->role->name) }}</i></u>)
                                    </div>


                                    <strong>ID : </strong>{{ $getDet }}<br>
                                    <strong>Mobile : </strong>{{ strtoupper(Auth::user()->mobile) }}<br>
                                    <strong>Email : </strong>{{ strtolower(Auth::user()->email) }}<br>

                                </td>
                            </tr>

                        </table>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('script')
<script src="{{ asset('/assets/js/core/jQuery.print.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#print').click(function() {
            $('#printable').print();
        });
    });
</script>

    {{-- <script type="text/javascript">
        $(document).ready(function() {
            $('#print').click(function() {
                openWin();
            });
        });
    </script>
    <script type="text/javascript">
        function openWin() {
            var body = $('#printable').html();
            var myWindow = window.open('', '', 'width=800,height=600');

            myWindow.document.write(body);

            myWindow.document.close();
            myWindow.focus();
            myWindow.print();
            myWindow.close();
        }
    </script> --}}
@endpush
