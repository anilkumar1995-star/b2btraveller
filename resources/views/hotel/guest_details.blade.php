@extends('layouts.app')
@section('title', 'Guest Details')
@section('pagetitle', 'Guest Details')


@section('content')

        <div class="row">
            <div class="col-md-8">
                <div class="shadow-md card mb-0 rounded p-3 confirm-details">
                    <h4 class="text-5 mb-0">Passenger Details</h4>
                      <hr class="mx-0">
                    <div class="my-0 py-0">
                        <form id="passengerForm">
                            {{-- <div class="table-responsive border rounded my-2 rows" id="passenger-row-0">
                                <table class="table table-bordered  mb-0 ">
                                    <thead class="thead-light bg-light">
                                        <tr>
                                            <th>Contact Information (Your ticket and Hotel info
                                                will be sent here)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="hidden" name="remarks" id="remarks" value="Hotel Book" />
                                                <div class="row">
                                                    <div class="col-md-4 mb-3">
                                                        <div class="form-group">
                                                            <label class="mb-1" for="mobile">Mobile
                                                                Number</label>
                                                            <input type="text" name="mobile" maxlength="10"
                                                                id="mobile" oninput="validatePhone('mobile')"
                                                                class="form-control" placeholder="Enter Mobile Number"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <div class="form-group">
                                                            <label class="mb-1" for="email">Email
                                                                Id</label>
                                                            <input type="email" name="email" maxlength="60"
                                                                id="email" oninput="validateEmail('email')"
                                                                class="form-control" placeholder="Enter Email Id"
                                                                required>
                                                        </div>
                                                    </div>

                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div> --}}

                            <div id="formsContainerHotel">

                            </div>
                            {{-- <button id="addMoreForm" class="btn btn-success btn-sm mt-2" type="button">+ More Passenger
                                Details</button> --}}
                        </form>
                    </div>


                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-3" id="fare-details-info-hotel">

                        </div>
                    </div>
                </div>
            
                <div class="card text-center">
                    <h6 class="text-danger text-center mb-0 mt-2 p-3"><i class="far fa-clock"></i>
                        Your Booking Session will Expire in <span id="countdown">10:00</span> min.
                        You must complete the booking within the time .</h6>
                </div>
            </div>
        </div>

@endsection


@push('script')
    <script src="{{ asset('') }}js/hotel.js"></script>
    <script src="{{ asset('') }}js/inputFormValidation.js"></script>
    <script>
        $(document).ready(function() {
            // updateCountdown();
            // setInterval(updateCountdown, 1000);
            // try {
            let hotelKy = sessionStorage.getItem('hkey');
            let netAmt = sessionStorage.getItem('amt');
            let recomdet = JSON.parse(sessionStorage.getItem('recomdet'));
            let sendreqt = JSON.parse(localStorage.getItem('sentReqest'));


            function calculateDaysDifference(chkInDate, chkOutDate) {
                const date1 = new Date(chkInDate.split("-").reverse().join("-"));
                const date2 = new Date(chkOutDate.split("-").reverse().join("-"));
                const diffTime = Math.abs(date2 - date1);
                return Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            }

            $('#fare-details-info-hotel').html(` <aside class=" mt-4 mt-lg-0">
                    <div class="bg-white shadow-md rounded p-3">
                      <h4 class="text-5">Invoice Details</h4>
                      <hr class="mx-0">
                      <ul class="list-unstyled">
                        <li class="mb-2 fw-500">Base price <span class="float-end text-4 fw-500 text-dark">₹${recomdet?.PriceBreakUp[0]?.RoomRate.toFixed(2)}</span><br/>
                            <span class="text-muted text-1 fw-400" id="stayDetails">
                                ${calculateDaysDifference(sendreqt[0]?.chkInDate, sendreqt[0]?.chkOutDate)} Nights, ${sendreqt[0]?.roomCount} Rooms, ${sendreqt[0]?.adultCount + sendreqt[0]?.childCount} Guests
                            </span>
                        </li>
                        <li class="mb-2 fw-500">Taxes &amp; Fees <span class="float-end text-4 fw-500 text-dark">₹${recomdet?.NetTax.toFixed(2)}</span></li>
                      </ul>
                      <hr/>
                      <div class="text-dark bg-light-4 text-4 fw-600 p-2"> Total Amount <span class="float-end text-6">₹${recomdet?.NetAmount.toFixed(2)}</span> </div>
                     
                      <div class="my-2">
                        <span class="my-2"><b>Note:</b> This charges are payable at hotel in local currency and many vary slightly based on exchange rates.</span>
                     </div>
                      <div class="d-grid mt-2">                                           
                        <button class="btn btn-primary" id="submitButton"  onclick="submitGuestDetails()">Proceed To Review</button>
                      </div>
                      
                    </div>
                  </aside>
                 `);
        });
    </script>
@endpush
