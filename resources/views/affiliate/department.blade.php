@extends('layouts.app')
@section('title', 'Affiliate Services')
@section('pagetitle', 'Affiliate Service')

@php
    // $table = 'yes';

    // $status['type'] = 'Fund';
    // $status['data'] = [
    //     'success' => 'Success',
    //     'pending' => 'Pending',
    //     'failed' => 'Failed',
    //     'approved' => 'Approved',
    //     'rejected' => 'Rejected',
    // ];
@endphp

@section('content')
    <div class="row">
        <div class="col-12 col-xl-12 col-sm-12 order-1 order-lg-2 my-3 mb-lg-0">
            @if (isset($data['errorMesssage']))
                <script>
                    swal({
                        type: 'error',
                        title: "Error!",
                        text: `{{ $data['errorMesssage'] }}`,
                        icon: "error",
                        button: "OK",
                        showConfirmButton: true,
                        allowOutsideClick: false,
                    }).then((result) => {
                        window.location.href = '/affiliate/list/department';
                    });
                </script>
            @else
                @if (isset($data['departmentList']) && count((array) $data['departmentList']) > 0)
                    @foreach ($data['departmentList'] as $depList)
                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <div class="card ">
                                    {{-- <a href="javascript:void(0)" onclick="fundRequest({{ $depList->id }})"> --}}
                                    <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4 ">
                                        <div class="card-title">
                                            <h5 class="mb-3">
                                                <span>{{ $depList->label }}</span>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            @foreach ($depList->category_list as $catList)
                                                <div class="col-lg-2 col-sm-3 col-xs-3 col-3 cursor-pointer"
                                                    onclick="getProduct('0',{{ $catList->id }})">
                                                    <div>
                                                        <img src="https://images.incomeowl.in/incomeowl/{{ $catList->img }}"
                                                            height="90px" width="90px">
                                                    </div>
                                                    {{-- <a href="javascript:void(0)" onclick="getProduct({{ $depList->id }},{{ $catList->id }})"> --}}

                                                    <div>{{ $catList->label }} </div>

                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    {{-- </a> --}}
                                    {{-- </div> --}}
                                </div>

                            </div>
                        </div>
                    @endforeach
                    <div class="text-center mt-3">
                        <button class="btn btn-primary " id="shareButton" onclick="getProduct('2',{{ $depList->id }})" type="button">
                            <i class="ti ti-eye ti-xs"></i> View More</button>
                    </div>
                @endif

                @if (isset($data['productInfo']) && count((array) $data['productInfo']) > 0)
                    <div class="row">
                        @foreach ($data['productInfo'] as $depList)
                            {{-- @dd($depList); --}}
                            <div class="col-sm-12 col-lg-6 mb-3">
                                <div class="card">
                                    <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4 ">

                                        <div class="card-title mb-5 ">
                                            <h5 class="mb-0">
                                                <span>
                                                    <img src="https://images.incomeowl.in/incomeowl/{{ $depList->image }}"
                                                        width="75px" />
                                                </span><br />
                                                <span>{{ $depList->name }}</span>
                                            </h5>
                                        </div>
                                        <div class="mb-3">
                                            <div class="user-list-files d-flex float-right">

                                                <div class="bg-label-success px-3 py-2 rounded me-auto mb-3">
                                                    <h6 class="mb-0">earn<span class="text-success fw-normal"> upto
                                                            &#8377;</span>
                                                    </h6>
                                                    <span><b class="text-success"> {{ $depList->earning }}</b></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <ul class="pt-0">
                                                    @foreach ($depList->Benefits as $catList)
                                                        <li>{{ $catList->name }}</li>
                                                    @endforeach
                                                </ul>
                                                <div class="bg-lighter px-3 row rounded">
                                                    <div class="pt-2 me-auto mb-3 col-4">
                                                        <h6 class="mb-0"><span class="text-body fw-normal">Joining Fee
                                                                <br />
                                                            </span>&#8377; {{ $depList->opening_charge }}</h6>

                                                    </div>
                                                    <div class="pt-2 me-auto mb-3 col-4">
                                                        <h6 class="mb-0"><span class="text-body fw-normal">Annual
                                                                Fee<br />
                                                            </span>&#8377; {{ $depList->annual_fee }}</h6>
                                                    </div>
                                                    <div class="pt-2 me-auto mb-3 col-4">
                                                        <h6 class="mb-0"><span class="text-body fw-normal">Approval Rate
                                                                <br />
                                                            </span>{{ $depList->approval_rate == '0' ? 'No Rating' : ($depList->approval_rate == '1' ? 'Excellent' : ($depList->approval_rate == '2' ? 'Low' : ($depList->approval_rate == '3' ? 'Good' : 'Unknown Rating'))) }}
                                                        </h6>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="float-end mt-3">
                                            <button class="btn btn-outline-success btn-sm" id="shareButton"
                                                onclick="sharefunction({{ $depList->id }})" type="button">
                                                <i class="fa fa-share"></i> Share</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if (isset($data['categoryInfo']) && count((array) $data['categoryInfo']) > 0)
                {{-- @foreach ($data['categoryInfo'] as $catlist) --}}
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <div class="card ">
                                {{-- <a href="javascript:void(0)" onclick="fundRequest({{ $catlist->id }})"> --}}
                                <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4 ">
                                    <div class="card-title">
                                        <h5 class="mb-3">
                                            <span>{{ "Product List" }}</span>
                                        </h5>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach ($data['categoryInfo'] as $catList)
                                            <div class="col-lg-2 col-sm-3 col-xs-3 col-3 cursor-pointer" onclick="getProduct(0,{{ $catList->id }})" style="padding-bottom: 20px;">
                                                <div>
                                                    <img src="https://images.incomeowl.in/incomeowl/{{ $catList->img }}" height="90px" width="90px">
                                                </div>
                                                {{-- <a href="javascript:void(0)" onclick="getProduct({{ $catlist->id }},{{ $catList->id }})"> --}}

                                                <div style="padding-bottom: 20px;" ><centre>{{ $catList->label }} </centre></div>

                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- </a> --}}
                                {{-- </div> --}}
                            </div>

                        </div>
                    </div>
                {{-- @endforeach --}}
            @endif
            @endif

        </div>
    </div>

    <div class="modal fade" id="referAndEarn" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-simple modal-refer-and-earn">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-3">
                        <h3>Share</h3>

                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-3 ">
                            <div class="d-flex justify-content-center mb-2">
                                <a href="https://www.facebook.com" target="_blank">
                                    <div class="modal-refer-and-earn-step bg-label-primary" style="width:50px;height:50px">
                                        <i class="ti ti-brand-facebook"></i>
                                    </div>
                                </a>
                            </div>

                        </div>
                        <div class="col-12 col-lg-3 ">
                            <a href="https://www.whatsapp.com" target="_blank">
                                <div class="d-flex justify-content-center mb-2">
                                    <div class="modal-refer-and-earn-step bg-label-success" style="width:50px;height:50px">
                                        <i class="ti ti-brand-whatsapp"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-lg-3 ">
                            <a href="https://www.instagram.com" target="_blank">
                                <div class="d-flex justify-content-center mb-2">
                                    <div class="modal-refer-and-earn-step bg-label-danger" style="width:50px;height:50px">
                                        <i class="ti ti-brand-instagram"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-lg-3 ">
                            <a href="https://www.gmail.com" target="_blank">
                                <div class="d-flex justify-content-center mb-2">
                                    <div class="modal-refer-and-earn-step bg-label-warning" style="width:50px;height:50px">
                                        <i class="ti ti-mail"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <hr class="my-3" />
                    <h5 class="mt-1">Copy the link</h5>
                    <form class="row g-3" onsubmit="return false" id="linkvalform">
                        <div class="col-lg-12">
                            <label class="form-label" for="modalLink">You can also copy and send it or share it on your
                                social media. 🥳</label>
                            <div class="input-group input-group-merge">
                                <input type="text" id="modalLink" class="form-control" value="" readonly/>
                                <span class="input-group-text text-primary cursor-pointer" id="copylink">Copy
                                    link</span>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

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
        function getProduct(depId, catId) {
            if (depId == '0') {
                window.location.href = "{{ url('/') }}/affiliate/list/product?categoryId=" + catId;
            }
            else if(depId == '1') {
                window.location.href = "{{ url('/') }}/affiliate/list/category?departmentId=" + catId;
            }else{
                window.location.href = "{{ url('/') }}/affiliate/list/category"
            }
        }

        function sharefunction(id) {
            $.ajax({
                    url: `{{ url('/') }}/affiliate/list/productById?productId=` + id,
                    type: 'get',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        swal({
                            title: 'Wait!',
                            text: 'We are getting link for your',
                            onOpen: () => {
                                swal.showLoading()
                            },
                            allowOutsideClick: () => !swal.isLoading()
                        });
                    }
                })
                .done(function(data) {
                    swal.close();
                    console.log(data);
                    notify(data?.message, 'success');
                    $('#referAndEarn').modal('show');
                    $('#linkvalform').find('input[type="text"]').val(data?.data?.link);
                })
                .fail(function(errors) {
                    swal.close();
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const inputBox = document.getElementById('modalLink');
            const copyButton = document.getElementById('copylink');

            copyButton.addEventListener('click', function() {
                inputBox.select();
                inputBox.setSelectionRange(0, 99999);

                try {
                    document.execCommand('copy');
                    notify('Text copied to clipboard!', 'success');
                } catch (err) {
                    notify('Failed to copy text. Please try again.', 'error');
                }
            });
        });
    </script>
@endpush
