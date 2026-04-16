@extends('layouts.app')
@section('title', 'Hotel Details')
@section('pagetitle', 'Hotel Details')


@section('content')
    <style>
        .hover-overlay {
            opacity: 0.6;
            transition: opacity 0.3s ease-in-out;
        }

        .hover-overlay:hover {
            opacity: 0.8;
            transition: opacity 0.3s ease-in-out;
        }

        .hover-overlay button {
            z-index: 1;
        }

        .hotel-room-img {
            width: 100%;
            height: 220px;
            overflow: hidden;
            border-radius: 10px;
            position: relative;
        }

        .hotel-room-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* 🔥 main fix */
            display: block;
        }
    </style>
    <style>
        .fare-breakdown-container-hotel-details {
            width: 20%;
            position: absolute;
            top: 100;
            right: 0;
            z-index: 10;
            display: none;
        }
    </style>

    <div class="rounded">

        <div class="wrapper">

            <div class="row mt-3">
                <div class="col-lg-8">
                    <div id="hotel_name_det">

                    </div>
                    <div class="bg-white shadow-md rounded p-3 p-sm-4 confirm-details">

                        <!-- Hotel Photo Slideshow
                                                      ============================================= -->

                        <div class="row">

                            <div class="col-6" id="hotel_image"></div>
                            <div class="col-6">
                                <div class="row" id="galleryImgSwiperHotel">

                                </div>

                            </div>
                        </div>

                        <!-- Hotel Photo Slideshow end -->

                        <div class="tabcontentChooseroom">
                            <ul class="nav nav-tabs mx-0 nav-fill border-bottom" role="tablist" style="overflow:hidden">
                                <li class="nav-item">
                                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#knownfor" aria-controls="#knownfor" aria-selected="true">
                                        <i class="fa-solid fa-record-vinyl"></i>&nbsp;Known For </button>
                                </li>

                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#amenities" aria-controls="#amenities" aria-selected="true"><i
                                            class="fa-solid fa-hands-holding-circle"></i>&nbsp; Amenities </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="attractions-tab" data-bs-toggle="tab"
                                        data-bs-target="#attractions">
                                        <i class="fa-solid fa-hand-pointer"></i>&nbsp; Attractions
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        id="chooseroom-tab" data-bs-target="#chooseroom" aria-controls="#chooseroom"
                                        aria-selected="true"><i class="fa-solid fa-hand-pointer"></i>&nbsp; Choose Room
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content px-1 pb-0 mb-0" id="viewdetHotelContent">

                            </div>


                        </div>
                    </div>

                    
                </div>
                <aside class="col-lg-4 mt-4 mt-lg-0" id="search_param_det">

                </aside>

            </div>
        </div>

        <div class="modal fade" id="showmoreHotelImageModal" tabindex="-1" role="dialog" aria-hidden="undefined"
            data-bs-backdrop="static" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="carouselExample" class="carousel slide rounded" data-bs-ride="carousel">
                            {{-- <div class="carousel-indicators">
                          <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                          <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="1" aria-label="Slide 2"></button>
                          <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        </div> --}}
                            <div class="carousel-inner rounded" id="morehotelimg">


                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExample" role="button" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExample" role="button" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="showmoreHotelImageGalleryModal" tabindex="-1" role="dialog" aria-hidden="undefined"
            data-bs-backdrop="static" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="carouselExampleg" class="carousel slide rounded" data-bs-ride="carousel">

                            <div class="carousel-inner rounded" id="morehotelimgGallery">


                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleg" role="button" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleg" role="button" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="showCancelPolicyModal" tabindex="-1" role="dialog" aria-hidden="undefined"
            data-bs-backdrop="static" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="card-title">Cancellation Policy</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="showAllDetailsModal">
            <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header bg-light">
                        <h5>Room Full Details</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body" id="roomDetailsBody">
                        <p class="text-center">Loading...</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script src="{{ asset('') }}js/hotel.js"></script>
    <script src="{{ asset('') }}js/inputFormValidation.js"></script>
    <script>
        $(document).ready(function() {
            updateCountdown();
            setInterval(updateCountdown, 1000);

            sessionStorage.removeItem('hkey');
            sessionStorage.removeItem('recomdet');

            storedAllHotelData = JSON.parse(sessionStorage.getItem('allHotelData'));
            sendReq = JSON.parse(localStorage.getItem('sentReqest'));
            hotelcode = localStorage.getItem('hotelcode');

            hotelDeatilsUrlAjaxHit(storedAllHotelData, hotelcode);
            preBookingDetailsAjaxHit(storedAllHotelData?.BookingCode);


            let htmlsearchparam = '';

            htmlsearchparam += ` <div class="sticky-top"><div class="bg-white shadow-md rounded p-3">
                      <p class="reviews text-center"> <span class="reviews-score rounded fw-600 px-2 py-1">✅</span> <span class="fw-600">Excellent</span> </p>
                      <hr class="mx-n3">
                     
                        <div class="row g-3">
                       
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <input class="form-control" readonly placeholder="Check In" value="${sendReq[0]?.chkInDate}">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>    
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <input class="form-control" readonly placeholder="Check Out" value="${sendReq[0]?.chkOutDate}">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>   
                            </div>   
                                
                            <div class="col-12">
                                <div class="input-group">
                                <input class="travellers-class-input form-control" placeholder="Rooms / Guests" readonly value="${sendReq[0]?.roomCount} Room / ${sendReq[0]?.adultCount + sendReq[0]?.childCount} Guests">
                                    <span class="input-group-text"><i class="fas fa-caret-down"></i></span>
                                </div>   
                            </div>  
                        
                            <div class="col-12">
                                <div class="input-group">
                                <input class="travellers-class-input form-control" placeholder="Destination Name" readonly value="${sendReq[0]?.hotelName}">
                                    <span class="input-group-text"><i class="fas fa-caret-down"></i></span>
                                </div>   
                            </div> 

                         
                        </div>
                        <div class="d-flex align-items-center my-4">
                            <div class="text-7 lh-1 fw-500 me-2 me-lg-3 text-success fs-5">₹<span id="selectroomfare">${storedAllHotelData?.TotalFare}</span></div>
                                
                                <div class="text-black-50 ms-auto">1 Room/Night</div>
                            </div>
                            <div class="d-grid" id="d-grid">
                                <button class="btn btn-primary float-end mb-2" data-bs-toggle="modal" data-bs-target="#showAllDetailsModal">
                                    🏨 View Full Details
                                </button>
                            </div>
                        <h6 class="text-danger text-center mb-0 mt-4"><i class="far fa-clock"></i> Your Booking Session will Expire in <span id="countdown-timer">10:00</span> min. You must complete the booking within the time .</h6>
                        </div>
                    
                        <div class="card mt-3">
                            <div class="card-body">
                                <ul class="simple-ul ms-4">
                                    <li>Age between 0-18 considered children</li>
                                    <li>Age above 18 considered adults(Extra person charges may apply depending on property
                                        policy) </li>
                                </ul>
                            </div>
                        </div>
                    </div>`;


            $('#search_param_det').html(htmlsearchparam);


            $('#bookNowBtn').on('click', function() {
                $('html, body').animate({
                    scrollTop: $('.tabcontentChooseroom').offset().top
                }, 1000);
                $('.nav-tabs .nav-link').removeClass('active');
                $('.tab-pane').removeClass('show active');

                $('#chooseroom-tab').addClass('active');

                $('#chooseroom').addClass('show active');
            });
        });
    </script>
@endpush
