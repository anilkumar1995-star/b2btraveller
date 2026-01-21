@extends('layouts.app')
@section('title', ucwords($user->name) . ' Profile')
@section('bodyClass', 'has-detached-left')
@section('pagetitle', ucwords($user->name) . ' Profile')

@php
    $table = 'yes';
@endphp
@section('content')

    <div class="row">
        <div class="col-lg-12 ">
            <div class="card h-100">
                <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">
                            <h4>My Profile</h4>
                        </h5>
                    </div>
                </div>

                <div class="card-body">
                    <div class=" rounded mt-5">
                        <div class="row gap-4 gap-sm-0">
                            <div class="">
                                <ul class="nav nav-tabs nav-pills" role="tablist">
                                    <li class="nav-item">
                                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-justified-profile" aria-controls="navs-justified-profile"
                                            aria-selected="true">
                                            Profile Details
                                        </button>
                                    </li>
                                    @if ((Auth::id() == $user->id && Myhelper::can('password_reset')) || Myhelper::can('member_password_reset'))
                                        <li class="nav-item">
                                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                data-bs-target="#navs-justified-password"
                                                aria-controls="navs-justified-password" aria-selected="false">
                                                Password Manager
                                            </button>
                                        </li>
                                    @endif
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-justified-pin" aria-controls="navs-justified-pin"
                                            aria-selected="false">
                                            Pin Manager
                                        </button>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="navs-justified-profile" role="tabpanel">
                                        <form id="profileForm" action="{{ route('profileUpdate') }}" method="post"
                                            enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="id" value="{{ $user->id }}">
                                            <input type="hidden" name="actiontype" value="profile">

                                            <div class="row">
                                                <div class="form-group col-md-4 my-1">
                                                    <label>Name</label>
                                                    <input type="text" name="name" class="form-control my-1"
                                                        value="{{ $user->name }}" required=""
                                                        placeholder="Enter Value">
                                                </div>
                                                <div class="form-group col-md-4 my-1">
                                                    <label>Mobile</label>
                                                    <input type="tel" maxlength="10"
                                                        {{ Myhelper::hasNotRole('admin') ? 'disabled=""' : 'name=mobile' }}
                                                        required="" value="{{ $user->mobile }}" class="form-control my-1"
                                                        placeholder="Enter Value">
                                                </div>
                                                <div class="form-group col-md-4 my-1">
                                                    <label>Email</label>
                                                    <input type="email" name="email" class="form-control my-1"
                                                        value="{{ $user->email }}" required=""
                                                        placeholder="Enter Value">
                                                </div>

                                                <div class="form-group col-md-4 my-1">
                                                    <label>State</label>
                                                    <select name="state" class="form-control my-1" required="">
                                                        <option value="">Select State</option>
                                                        @foreach ($state as $state)
                                                            <option value="{{ $state->state }}">{{ $state->state }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4 my-1">
                                                    <label>City</label>
                                                    <input type="text" name="city" class="form-control my-1"
                                                        value="{{ $user->city }}" required=""
                                                        placeholder="Enter Value">
                                                </div>
                                                <div class="form-group col-md-4 my-1">
                                                    <label>PIN Code</label>
                                                    <input type="tel" name="pincode" class="form-control my-1"
                                                        value="{{ $user->pincode }}" required="" maxlength="6"
                                                        minlength="6" placeholder="Enter Value">
                                                </div>

                                                <div class="form-group col-md-4 my-1">
                                                    <label>Gender</label>
                                                    <select name="gender" class="form-control my-1" required="">
                                                        <option value="">Select Gender</option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4 my-1">
                                                    <label>Address</label>
                                                    <input type="text" name="address" class="form-control my-1"
                                                        rows="3" required="" placeholder="Enter Value"
                                                        value="{{ $user->address }}"></input>
                                                </div>
                                                @if (Myhelper::hasRole('admin'))
                                                    <div class="form-group col-md-4 my-1">
                                                        <label>Security PIN</label>
                                                        <input type="password" name="mpin" autocomplete="off"
                                                            class="form-control my-1" required="">
                                                    </div>
                                                @endif

                                                @if ((Auth::id() == $user->id && Myhelper::can('profile_edit')) || Myhelper::can('member_profile_edit'))
                                                    <div class="col-sm-12">
                                                        <button class="btn btn-primary pull-right  mt-2" type="submit"
                                                            data-loading-text="<i class='fa fa-spin fa-spinner'></i> Updating...">Update
                                                            Profile</button>
                                                    </div>
                                                @endif
                                            </div>
                                        </form>
                                    </div>



                                    <div class="tab-pane fade " id="navs-justified-password" role="tabpanel">
                                        <form id="passwordForm" action="{{ route('profileUpdate') }}" method="post"
                                            enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="id" value="{{ $user->id }}">
                                            <input type="hidden" name="actiontype" value="password">
                                            <div class="panel panel-default">

                                                <div class="panel-body p-b-0">
                                                    <div class="row">
                                                        @if (Auth::id() == $user->id || (Myhelper::hasNotRole('admin') && !Myhelper::can('member_password_reset')))
                                                            <div class="form-group col-md-4 my-1">
                                                                <label>Old Password</label>
                                                                <input type="password" name="oldpassword"
                                                                    class="form-control my-1" required=""
                                                                    placeholder="Enter Value">
                                                            </div>
                                                        @endif

                                                        <div class="form-group col-md-4 my-1">
                                                            <label>New Password</label>
                                                            <input type="password" name="password" id="password"
                                                                class="form-control my-1" required=""
                                                                placeholder="Enter Value">
                                                        </div>

                                                        @if (Auth::id() == $user->id || (Myhelper::hasNotRole('admin') && !Myhelper::can('member_password_reset')))
                                                            <div class="form-group col-md-4 my-1">
                                                                <label>Confirmed Password</label>
                                                                <input type="password" name="password_confirmation"
                                                                    class="form-control my-1" required=""
                                                                    placeholder="Enter Value">
                                                            </div>
                                                        @endif
                                                        @if (Myhelper::hasRole('admin'))
                                                            <div class="form-group col-md-4 my-1">
                                                                <label>Security PIN</label>
                                                                <input type="password" name="mpin" autocomplete="off"
                                                                    class="form-control my-1" required="">
                                                            </div>
                                                        @endif
                                                        <div class="col-sm-12">
                                                            <button class="btn btn-primary mt-2 pull-right" type="submit"
                                                                data-loading-text="<i class='fa fa-spin fa-spinner'></i> Resetting...">Password
                                                                Reset</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="tab-pane fade" id="navs-justified-pin" role="tabpanel">
                                        <form id="pinForm" action="{{ route('setpin') }}" method="post"
                                            enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="id" value="{{ $user->id }}">
                                            <input type="hidden" name="mobile" value="{{ $user->mobile }}">
                                            <div class="row">
                                                <div class="form-group col-md-4 my-1">
                                                    <label>New PIN</label>
                                                    <input type="password" name="pin" id="pin"
                                                        class="form-control my-1" required=""
                                                        placeholder="Enter Value">
                                                </div>
                                                <div class="form-group col-md-4 my-1">
                                                    <label>Confirmed PIN</label>
                                                    <input type="password" name="pin_confirmation"
                                                        class="form-control my-1" required=""
                                                        placeholder="Enter Value">
                                                </div>
                                                <div class="form-group col-md-4 my-1">
                                                    <label>OTP</label>
                                                    <input type="password" name="otp" class="form-control my-1"
                                                        Placeholder="Otp" required>
                                                    <a href="javascript:void(0)" onclick="OTPRESEND()"
                                                        class="text-primary pull-right fw-bloder">Send OTP</a>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <button class="btn btn-primary mt-2 float-right" type="submit"
                                                        data-loading-text="<i class='fa fa-spin fa-spinner'></i> Resetting...">Reset
                                                        Pin</button>

                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                    {{-- 
                                    <div class="tab-pane fade " id="navs-justified-bank" role="tabpanel">
                                        <form id="bankForm" action="{{ route('profileUpdate') }}" method="post">

                                            {{ csrf_field() }}
                                            <input type="hidden" name="id" value="{{ $user->id }}">
                                            <input type="hidden" name="actiontype" value="bankdata">


                                            <div class="row">
                                                <div class="form-group col-md-4 my-1">
                                                    <label>Account Number</label>
                                                    <input type="text" name="account" class="form-control my-1"
                                                        value="{{ @$user->userbanks['accountNo'] }}" required=""
                                                        placeholder="Enter Value"
                                                        @if ((@$user->userbanks['accountNo'] != null || @$user->userbanks['accountNo'] != '') && \Myhelper::hasNotRole('admin')) readonly @endif>
                                                </div>

                                                <div class="form-group col-md-4 my-1">
                                                    <label>Bank Name</label>
                                                    <input type="text" name="bank" class="form-control my-1"
                                                        value="{{ @$user->userbanks['bankName'] }}"
                                                        placeholder="Enter Value"
                                                        @if ((@$user->userbanks['accountNo'] != null || @$user->userbanks['accountNo'] != '') && \Myhelper::hasNotRole('admin')) readonly @endif>
                                                </div>

                                                <div class="form-group col-md-4 my-1">
                                                    <label>IFSC Code</label>
                                                    <input type="text" name="ifsc" class="form-control my-1"
                                                        value="{{ @$user->userbanks['ifscCode'] }}" required=""
                                                        placeholder="Enter Value"
                                                        @if ((@$user->userbanks['accountNo'] != null || @$user->userbanks['accountNo'] != '') && \Myhelper::hasNotRole('admin')) readonly @endif>
                                                </div>
                                            </div>

                                            @if (@$user->userbanks['accountNo'] == null || @$user->userbanks['accountNo'] == '' || \Myhelper::hasRole('admin'))
                                                <div class="row">
                                                    <div class="form-group col-md-4 my-1">
                                                        <label>Security PIN</label>
                                                        <input type="password" name="mpin" autocomplete="off"
                                                            class="form-control my-1" required=""
                                                            placeholder="Enter security pin">
                                                    </div>
                                                </div>



                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <button class="btn btn-primary mt-2 pull-right" type="submit"
                                                            data-loading-text="<i class='fa fa-spin fa-spinner'></i> Changing...">Update</button>
                                                    </div>
                                                </div>
                                            @endif


                                        </form>
                                    </div> --}}



                                    {{-- <div class="tab-pane fade my-1" id="navs-justified-certificate" role="tabpanel">
                                        <form id="certificateForm" action="{{ route('profileUpdate') }}" method="post">
                                            {{ csrf_field() }}
                                            @if (\Myhelper::hasRole('admin'))
                                                <input type="hidden" name="id" value="{{ $user->id }}">
                                                <input type="hidden" name="actiontype" value="certificate">
                                                <div class="row">
                                                    <div class="form-group col-md-4 my-1">
                                                        <label>CMO (Cheif Marketing Officer)</label>
                                                        <input type="text" name="cmo" id="cmo"
                                                            class="form-control my-1" required=""
                                                            placeholder="Enter CMO name"
                                                            value="{{ @json_decode(@$user->bene_id1)->cmo }}">
                                                    </div>
                                                    <div class="form-group col-md-4 my-1">
                                                        <label>COO (Cheif Operating Officer)</label>
                                                        <input type="text" name="coo" class="form-control my-1"
                                                            required="" placeholder="Enter COO name"
                                                            value="{{ @json_decode(@$user->bene_id1)->coo }}">
                                                    </div>

                                                    <div class="col-md-4">
                                                        <button class="btn btn-primary pull-right" style="margin-top:30px"
                                                            type="submit"
                                                            data-loading-text="<i class='fa fa-spin fa-spinner'></i> Changing...">Update</button>

                                                    </div>
                                                </div>
                                        </form>
                                        @endif

                                        <div class="row">
                                            <div class="form-group col-md-4 my-1">
                                                <label><i class="fa fa-eye fa-sm"></i> Certificate</label>
                                                <a target="_blank" href={{ url('/') . '/certificate' }}>(Click here to
                                                    view certificate)</a>
                                            </div>
                                            <div class="form-group col-md-4 my-1">
                                                <label><i class="fa fa-eye fa-sm"></i> ID Card</label>
                                                <a target="_blank" href={{ url('/') . '/idcard' }}>(Click here to view ID
                                                    Card)</a>
                                            </div>
                                        </div>


                                    </div> --}}


                                    @if (\Myhelper::hasRole('admin'))


                                        <div class="tab-pane fade my-1" id="navs-justified-role" role="tabpanel">
                                            <form id="roleForm" action="{{ route('profileUpdate') }}" method="post">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="id" value="{{ $user->id }}">
                                                <input type="hidden" name="actiontype" value="rolemanager">
                                                <div class="row">
                                                    <div class="form-group col-md-4 my-1">
                                                        <label>Member Role</label>
                                                        <select name="role_id" class="form-control my-1" required="">
                                                            <option value="">Select Role</option>
                                                            @foreach ($roles as $role)
                                                                <option value="{{ $role->id }}">{{ $role->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @if (Myhelper::hasRole('admin'))
                                                        <div class="form-group col-md-4 my-1">
                                                            <label>Security PIN</label>
                                                            <input type="password" name="mpin" autocomplete="off"
                                                                class="form-control my-1" required="">
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <button class="btn btn-primary mt-2 pull-right" type="submit"
                                                            data-loading-text="<i class='fa fa-spin fa-spinner'></i> Changing...">Change</button>

                                                    </div>
                                                </div>
                                            </form>
                                        </div>



                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>

    {{-- capping modal --}}
    {{-- <div class="modal fade" id="cappingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <form id="cappingStatusForm" method="POST" action="">
                        @csrf
                        <input type="hidden" name="Id">
                        <input type="hidden" name="userId">
                        <input type="hidden" name="capAmount">
                        <input type="hidden" name="walletType">

                        <div class="mb-2">
                            <label for="newStatus">Approved By Name</label>
                            <input class="form-control" type="text" name="approved_by"
                                placeholder="Approved By Name" />
                        </div>

                        <div class="mb-2">
                            <label for="newStatus">Select Status</label>
                            <select class="form-control" name="newStatus" id="newStatus" required>
                                <option value="">Select</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Reject</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}

@endsection


@push('script')
    <script type="text/javascript">
        $(document).ready(function() {
          
            $('[name="state"]').val('{{ $user->state }}').trigger('change');
            $('[name="gender"]').val('{{ $user->gender }}').trigger('change');
            @if (\Myhelper::hasRole('admin'))
                $('[name="parent_id"]').val('{{ $user->parent_id }}').trigger('change');
                $('[name="role_id"]').val('{{ $user->role_id }}').trigger('change');
            @endif
            // $('[href="#{{ $tab }}"]').trigger('click');
            $("#profileForm").validate({
                rules: {
                    name: {
                        required: true,
                    },
                    mobile: {
                        required: true,
                        minlength: 10,
                        number: true,
                        maxlength: 10
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    state: {
                        required: true,
                    },
                    city: {
                        required: true,
                    },
                    pincode: {
                        required: true,
                        minlength: 6,
                        number: true,
                        maxlength: 6
                    },
                    address: {
                        required: true,
                    }
                },
                messages: {
                    name: {
                        required: "Please enter name",
                    },
                    mobile: {
                        required: "Please enter mobile",
                        number: "Mobile number should be numeric",
                        minlength: "Your mobile number must be 10 digit",
                        maxlength: "Your mobile number must be 10 digit"
                    },
                    email: {
                        required: "Please enter email",
                        email: "Please enter valid email address",
                    },
                    state: {
                        required: "Please select state",
                    },
                    city: {
                        required: "Please enter city",
                    },
                    pincode: {
                        required: "Please enter pincode",
                        number: "Mobile number should be numeric",
                        minlength: "Your mobile number must be 6 digit",
                        maxlength: "Your mobile number must be 6 digit"
                    },
                    address: {
                        required: "Please enter address",
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase().toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('form#profileForm');
                    form.find('span.text-danger').remove();
                    $('form#profileForm').ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Update Profile').attr(
                                'disabled', false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                notify("Profile Successfully Updated", 'success');
                                window.location.reload();
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors, form.find('.panel-body'));
                        }
                    });
                }
            });

            $("#kycForm").validate({
                rules: {
                    aadharcard: {
                        required: true,
                        minlength: 12,
                        number: true,
                        maxlength: 12
                    },
                    pancard: {
                        required: true,
                    },
                    shopname: {
                        required: true,
                    }
                },
                messages: {
                    aadharcard: {
                        required: "Please enter aadharcard",
                        number: "Mobile number should be numeric",
                        minlength: "Your mobile number must be 12 digit",
                        maxlength: "Your mobile number must be 12 digit"
                    },
                    pancard: {
                        required: "Please enter pancard",
                    },
                    shopname: {
                        required: "Please enter shop name",
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase().toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('form#kycForm');
                    form.find('span.text-danger').remove();
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Update Profile').attr(
                                'disabled', false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                notify("Profile Successfully Updated", 'success');
                                window.location.reload();
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors, form.find('.panel-body'));
                            form.find('button:submit').html('Update Profile').attr(
                                'disabled', false).removeClass('btn-secondary');

                        }
                    });
                }
            });

            $("#passwordForm").validate({
                rules: {
                    @if (Auth::id() == $user->id || (Myhelper::hasNotRole('admin') && !Myhelper::can('member_password_reset')))
                        oldpassword: {
                            required: true,
                        },
                        password_confirmation: {
                            required: true,
                            minlength: 8,
                            equalTo: "#password"
                        },
                    @endif
                    password: {
                        required: true,
                        minlength: 8,
                    }
                },
                messages: {
                    @if (Auth::id() == $user->id || (Myhelper::hasNotRole('admin') && !Myhelper::can('member_password_reset')))
                        oldpassword: {
                            required: "Please enter old password",
                        },
                        password_confirmation: {
                            required: "Please enter confirmed password",
                            minlength: "Your password lenght should be atleast 8 character",
                            equalTo: "New password and confirmed password should be equal"
                        },
                    @endif
                    password: {
                        required: "Please enter new password",
                        minlength: "Your password lenght should be atleast 8 character",
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase().toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('form#passwordForm');
                    form.find('span.text-danger').remove();
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Password Reset').attr(
                                'disabled', false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                notify("Password Successfully Changed", 'success');
                                window.location.reload();
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors, form.find('.panel-body'));
                        }
                    });
                }
            });

            $("#memberForm").validate({
                rules: {
                    parent_id: {
                        required: true
                    }
                },
                messages: {
                    parent_id: {
                        required: "Please select parent member"
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase().toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('form#memberForm');
                    form.find('span.text-danger').remove();
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Change').attr('disabled',
                                false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                notify("Mapping Successfully Changed", 'success');
                                window.location.reload();
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors);
                        }
                    });
                }
            });

            $("#certificateForm").validate({
                rules: {
                    coo: {
                        required: true
                    },
                    cmo: {
                        required: true
                    }
                },
                messages: {
                    coo: {
                        required: "Please enter COO name"
                    },
                    cmo: {
                        required: "Please enter CMO name"
                    }

                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase().toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('form#certificateForm');
                    form.find('span.text-danger').remove();
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Change').attr('disabled',
                                false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                notify("Mapping Successfully Changed", 'success');
                                window.location.reload();
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors);
                        }
                    });
                }
            });

            $("#roleForm").validate({
                rules: {
                    role_id: {
                        required: true
                    }
                },
                messages: {
                    role_id: {
                        required: "Please select member role"
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase().toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('form#roleForm');
                    form.find('span.text-danger').remove();
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Change').attr('disabled',
                                false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                notify("Role Successfully Changed", 'success');
                                window.location.reload();
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors);
                        }
                    });
                }
            });

            $("#bankForm").validate({
                rules: {
                    account: {
                        required: true
                    },
                    bank: {
                        required: true
                    },
                    ifsc: {
                        required: true
                    }
                },
                messages: {
                    account: {
                        required: "Please enter member account"
                    },
                    bank: {
                        required: "Please enter member bank"
                    },
                    ifsc: {
                        required: "Please enter bank ifsc"
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase().toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('form#bankForm');
                    form.find('span.text-danger').remove();
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
                                notify("Bank Details Successfully Changed", 'success');
                                window.location.reload();
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors, form.find('.panel-body'));
                        }
                    });
                }
            });

            $("#pinForm").validate({
                rules: {
                    oldpin: {
                        required: true,
                    },
                    pin_confirmation: {
                        required: true,
                        minlength: 4,
                        equalTo: "#pin"
                    },
                    pin: {
                        required: true,
                        minlength: 4,
                    }
                },
                messages: {
                    oldpin: {
                        required: "Please enter old pin",
                    },
                    pin_confirmation: {
                        required: "Please enter confirmed pin",
                        minlength: "Your pin lenght should be atleast 4 character",
                        equalTo: "New pin and confirmed pin should be equal"
                    },
                    pin: {
                        required: "Please enter new pin",
                        minlength: "Your pin lenght should be atleast 4 character",
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase().toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('form#pinForm');
                    form.find('span.text-danger').remove();
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Reset Pin').attr('disabled',
                                false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                form[0].reset();
                                notify("Pin Successfully Changed", 'success');
                                window.location.reload();
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            // showError(errors, form.find('.panel-body'));
                            form.find('button:submit').html('Reset Pin').attr('disabled',
                                false).removeClass('btn-secondary');
                            console.log(errors.responseJSON.status);
                            notify(errors.responseJSON[0] || errors.responseJSON.status ||
                                "Something went wrong", 'error');
                        }
                    });
                }
            });


            // Wallet Lock Form AJAX Submission
            $("#walletLockForm").validate({
                rules: {
                    amount: {
                        required: true,
                        number: true
                    },
                    wallet_type: {
                        required: true
                    },
                    status: {
                        required: true
                    }
                },
                messages: {
                    amount: {
                        required: "Please enter amount",
                        number: "Amount must be numeric"
                    },
                    wallet_type: {
                        required: "Please select wallet type"
                    },
                    status: {
                        required: "Please select status"
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                submitHandler: function() {
                    var form = $('#walletLockForm');
                    form.find('span.text-danger').remove();
                    var btn = form.find('button[type="submit"]');
                    btn.html('Please wait...').attr('disabled', true).addClass('btn-secondary');
                    $.ajax({
                        url: 'wallet-lock-store',
                        type: 'POST',
                        data: form.serialize(),
                        dataType: 'json',
                        success: function(data) {
                            if (data.status === 'success') {
                                notify(data.message ||
                                    'Wallet lock amount added successfully', 'success');
                                form[0].reset();
                            } else {
                                notify(data.message || 'Something went wrong', 'error');
                            }
                        },
                        error: function(xhr) {
                            notify('Server error, please try again.', 'error');
                        },
                        complete: function() {
                            btn.html('Save').attr('disabled', false).removeClass(
                                'btn-secondary');
                        }
                    });
                }
            });


            $("#cappingStatusForm").validate({
                rules: {
                    capAmount: {
                        required: true,
                        number: true
                    },
                    walletType: {
                        required: true
                    },
                    newStatus: {
                        required: true
                    },
                    approved_by: {
                        required: true
                    },
                    userId: {
                        required: true
                    }
                },
                messages: {
                    capAmount: {
                        required: "Please enter amount",
                        number: "Amount must be numeric"
                    },
                    walletType: {
                        required: "Please select wallet type"
                    },
                    newStatus: {
                        required: "Please select status"
                    },
                    approved_by: {
                        required: "Please Enter Approved By Name"
                    },
                    userId: {
                        required: "User ID is required"
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                submitHandler: function() {
                    var form = $('#cappingStatusForm');
                    form.find('span.text-danger').remove();
                    var btn = form.find('button[type="submit"]');
                    btn.html('Please wait...').attr('disabled', true).addClass('btn-secondary');
                    $.ajax({
                        url: 'walletLockapprove',
                        type: 'POST',
                        data: form.serialize(),
                        dataType: 'json',
                        success: function(data) {
                            if (data.status === 'success') {
                                notify(data.message ||
                                    'Capping status updated successfully', 'success');
                                $('#cappingModal').modal('hide');
                                $('#datatable').DataTable().ajax.reload();
                            } else {
                                notify(data.message || 'Something went wrong', 'error');
                            }
                        },
                        error: function(xhr) {
                            notify('Server error, please try again.', 'error');
                        },
                        complete: function() {
                            btn.html('Update Status').attr('disabled', false).removeClass(
                                'btn-secondary');
                        }
                    });
                }
            });
        });

        function OTPRESEND() {
            var mobile = "{{ Auth::user()->mobile }}";
            if (mobile.length > 0) {
                $.ajax({
                        url: '{{ route('getotp') }}',
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            'mobile': mobile
                        },
                        beforeSend: function() {
                            swal({
                                title: 'Wait!',
                                text: 'Please wait, we are working on your request',
                                onOpen: () => {
                                    swal.showLoading()
                                }
                            });
                        },
                        complete: function() {
                            swal.close();
                        }
                    })
                    .done(function(data) {
                        if (data.status == "TXN") {
                            notify("Otp sent successfully", 'success');
                        } else {
                            notify(data.message, 'warning');
                        }
                    })
                    .fail(function() {
                        notify("Something went wrong, try again", 'warning');
                    });
            } else {
                notify("Enter your registered mobile number", 'warning');
            }
        }

        function changeStatus(id, wallet_type, user_id, amount, status) {
            $('[name="Id"]').val(id);
            $('[name="walletType"]').val(wallet_type);
            $('[name="userId"]').val(user_id);
            $('[name="capAmount"]').val(amount);
            $('#cappingModal').modal('show');
        }
    </script>
@endpush
