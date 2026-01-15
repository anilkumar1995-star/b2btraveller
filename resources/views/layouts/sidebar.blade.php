<!-- Menu -->
<style>
    li .menu-link.active {
        background-color: #f4f6f9;
        font-weight: 600;
    }

    li .menu-link {
        font-weight: 500;
        border: 1px solid rgb(228, 225, 225);
    }
</style>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <div class="app-brand demo d-flex align-items-center justify-content-between">
        @if (Auth::user()->company->logo)
            <a href="{{ route('home') }}" class="app-brand-link d-flex align-items-center p-3">
                <img src="https://ipayments.in/img/IPAYMNT.png" class="img-fluid rounded me-2" width="100%"
                    alt="Logo">
                {{-- <img src="{{ Imagehelper::getImageUrl() . Auth::user()->company->logo }}" class="img-fluid rounded me-2"
                width="100%" alt="Logo"> --}}
            </a>
        @else
            <a href="{{ route('home') }}" class="header-logo">
                <img src="" class="img-fluid rounded" alt="">
                <span>{{ Auth::user()->company->companyname }}</span>
            </a>
        @endif
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-3">
        <li class="{{ Request::is('dashboard') ? 'active' : '' }} menu-item ">
            <a href="{{ route('home') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Dashboards">Dashboards</div>
            </a>

        </li>

        <li class="menu-item {{ Request::is('flight/*') ? 'active open' : '' }}">
            <a href="#menu-design" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-plane"></i>
                <div data-i18n="Flight">Flight</div>
            </a>
            <ul class="menu-sub" id="menu-design {{ Request::is('flight/*') ? 'show' : '' }}">

                <li class="menu-item {{ Request::is('flight/view') ? 'active' : '' }}">
                    <a href="{{ route('flight.view') }}" class="menu-link">
                        <div data-i18n="Flight Booking">Flight Booking</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('flight/booking-list') ? 'active' : '' }}">
                    <a href="{{ url('flight/booking-list') }}" class="menu-link">
                        <div data-i18n="Booking List">Booking List</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('flight/booking-list-failed') ? 'active' : '' }}">
                    <a href="{{ url('flight/booking-list-failed') }}" class="menu-link">
                        <div data-i18n="Failed List">Failed List</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ Request::is('bus/*') ? 'active open' : '' }}">
            <a href="#menu-design" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-bus"></i>
                <div data-i18n="Bus">Bus</div>
            </a>
            <ul class="menu-sub" id="menu-design {{ Request::is('bus/*') ? 'show' : '' }}">

                <li class="menu-item {{ Request::is('bus/view') ? 'active' : '' }}">
                    <a href="{{ route('bus.view') }}" class="menu-link">
                        <div data-i18n="Bus Booking">Bus Booking</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('bus/booking-list') ? 'active' : '' }}">
                    <a href="{{ url('bus/booking-list') }}" class="menu-link">
                        <div data-i18n="Booking List">Booking List</div>
                    </a>
                </li>
                 <li class="menu-item {{ Request::is('bus/booking-list-failed') ? 'active' : '' }}">
                    <a href="{{ url('bus/booking-list-failed') }}" class="menu-link">
                        <div data-i18n="Failed List">Failed List</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ Request::is('hotel/*') ? 'active open' : '' }}">
            <a href="#menu-design" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-building"></i>
                <div data-i18n="Hotel">Hotel</div>
            </a>
            <ul class="menu-sub" id="menu-design {{ Request::is('hotel/*') ? 'show' : '' }}">

                <li class="menu-item {{ Request::is('hotel/view') ? 'active' : '' }}">
                    <a href="{{ route('hotel.view') }}" class="menu-link">
                        <div data-i18n="Hotel Booking">Hotel Booking</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('hotel/booking-list') ? 'active' : '' }}">
                    <a href="{{ url('flight/booking-list') }}" class="menu-link">
                        <div data-i18n="Booking List">Booking List</div>
                    </a>
                </li>
            </ul>
        </li>


        {{--  @if (Myhelper::can(['recharge_service'])) --}}
        <li class="menu-item {{ Request::is('recharge/*') ? 'active open' : '' }}">
            <a href="#menu-design" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-file-dollar"></i>
                <div data-i18n="Utility Recharge">Recharge</div>
            </a>
            <ul class="menu-sub" id="menu-design {{ Request::is('recharge/*') ? 'show' : '' }}">

                <li class="menu-item {{ Request::is('recharge/mobile') ? 'active' : '' }}">
                    <a href="{{ route('recharge', ['type' => 'mobile']) }}" class="menu-link">
                        <div data-i18n="Mobile">Mobile</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('recharge/dth') ? 'active' : '' }}">
                    <a href="{{ route('recharge', ['type' => 'dth']) }}" class="menu-link">
                        <div data-i18n="DTH">DTH</div>
                    </a>
                </li>
                {{--  @endif --}}
            </ul>
        </li>

        <li class="menu-item {{ Request::is('billpay/*') ? 'active open' : '' }}">
            <a href="#userinfo" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Bill Payment">Bill Payment</div>
            </a>
            <ul class="menu-sub {{ Request::is('billpay/*') ? 'show' : '' }}" id="userinfo">

                <li class="menu-item {{ Request::is('billpay/electricity') ? 'active' : '' }}">
                    <a href="{{ route('bill', ['type' => 'electricity']) }}" class="menu-link">
                        <div data-i18n="Electricity">Electricity</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('billpay/postpaid') ? 'active' : '' }}">
                    <a href="{{ route('bill', ['type' => 'postpaid']) }}" class="menu-link">
                        <div data-i18n="Postpaid">Postpaid</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('billpay/water') ? 'active' : '' }}">
                    <a href="{{ route('bill', ['type' => 'water']) }}" class="menu-link">
                        <div data-i18n="Water">Water</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('billpay/broadband') ? 'active' : '' }}">
                    <a href="{{ route('bill', ['type' => 'broadband']) }}" class="menu-link">
                        <div data-i18n="Broadband">Broadband</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('billpay/lpggas') ? 'active' : '' }}">
                    <a href="{{ route('bill', ['type' => 'lpggas']) }}" class="menu-link">
                        <div data-i18n="LPG Gas">LPG Gas</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('billpay/gas') ? 'active' : '' }}">
                    <a href="{{ route('bill', ['type' => 'gas']) }}" class="menu-link">
                        <div data-i18n="Piped Gas">Piped Gas</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('billpay/landline') ? 'active' : '' }}">
                    <a href="{{ route('bill', ['type' => 'landline']) }}" class="menu-link">
                        <div data-i18n="Landline">Landline</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('billpay/educationfees') ? 'active' : '' }}">
                    <a href="{{ route('bill', ['type' => 'educationfees']) }}" class="menu-link">
                        <div data-i18n="Education Fees">Education Fees</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('billpay/fastag') ? 'active' : '' }}">
                    <a href="{{ route('bill', ['type' => 'fastag']) }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-user"></i>
                        <div data-i18n="Fastag">Fastag</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('billpay/loanrepayment') ? 'active' : '' }}">
                    <a href="{{ route('bill', ['type' => 'loanrepayment']) }}" class="menu-link">
                        <div data-i18n="Loan Repayment">Loan Repayment</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('billpay/insurance') ? 'active' : '' }}">
                    <a href="{{ route('bill', ['type' => 'insurance']) }}" class="menu-link">
                        <div data-i18n="Insurance">Insurance</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('billpay/rental') ? 'active' : '' }}">
                    <a href="{{ route('bill', ['type' => 'rental']) }}" class="menu-link">
                        <div data-i18n="Rental">Rental</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('billpay/donation') ? 'active' : '' }}">
                    <a href="{{ route('bill', ['type' => 'donation']) }}" class="menu-link">
                        <div data-i18n="Donation">Donation</div>
                    </a>
                </li>
                {{-- <li class="menu-item {{ Request::is('billpay/dthbbps') ? 'active' : '' }}">
                                    <a href="{{ route('bill', ['type' => 'dthbbps']) }}" class="menu-link">
                                        <div data-i18n="DTH Bbps">DTH Bbps</div>
                                    </a>
                                </li> --}}
                <li class="menu-item {{ Request::is('billpay/subscription') ? 'active' : '' }}">
                    <a href="{{ route('bill', ['type' => 'subscription']) }}" class="menu-link">
                        <div data-i18n="Subscription">Subscription</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('billpay/hospital') ? 'active' : '' }}">
                    <a href="{{ route('bill', ['type' => 'hospital']) }}" class="menu-link">
                        <div data-i18n="Hospital">Hospital</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('billpay/clubsandassociations') ? 'active' : '' }}">
                    <a href="{{ route('bill', ['type' => 'clubsandassociations']) }}" class="menu-link">
                        <div data-i18n="Clubs and Associations">Clubs and Associations</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('billpay/municipalservices') ? 'active' : '' }}">
                    <a href="{{ route('bill', ['type' => 'municipalservices']) }}" class="menu-link">
                        <div data-i18n="Municipal Services">Municipal Services</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('billpay/municipaltaxes') ? 'active' : '' }}">
                    <a href="{{ route('bill', ['type' => 'municipaltaxes']) }}" class="menu-link">
                        <div data-i18n="Municipal Taxes">Municipal Taxes</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('billpay/housingsociety') ? 'active' : '' }}">
                    <a href="{{ route('bill', ['type' => 'housingsociety']) }}" class="menu-link">
                        <div data-i18n="Housing Society">Housing Society</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('billpay/lifeinsurance') ? 'active' : '' }}">
                    <a href="{{ route('bill', ['type' => 'lifeinsurance']) }}" class="menu-link">
                        <div data-i18n="Life Insurance">Life Insurance</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('billpay/cabletv') ? 'active' : '' }}">
                    <a href="{{ route('bill', ['type' => 'cabletv']) }}" class="menu-link">
                        <div data-i18n="Cable TV">Cable TV</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('billpay/creditcard') ? 'active' : '' }}">
                    <a href="{{ route('bill', ['type' => 'creditcard']) }}" class="menu-link">
                        <div data-i18n="Credit Card">Credit Card</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('billpay/recurringdeposit') ? 'active' : '' }}">
                    <a href="{{ route('bill', ['type' => 'recurringdeposit']) }}" class="menu-link">
                        <div data-i18n="Recurring Deposit">Recurring Deposit</div>
                    </a>
                </li>
                {{-- <li class="menu-item {{ Request::is('billpay/mobileprepaid') ? 'active' : '' }}">
                                    <a href="{{ route('bill', ['type' => 'mobileprepaid']) }}" class="menu-link">
                                        <div data-i18n="Mobile Prepaid">Mobile prepaid</div>
                                    </a>
                                </li> --}}
                {{-- <li class="menu-item {{ Request::is('billpay/ncmcrecharge') ? 'active' : '' }}">
                                    <a href="{{ route('bill', ['type' => 'ncmcrecharge']) }}" class="menu-link">
                                        <div data-i18n="NCMC Recharge">NCMC Recharge</div>
                                    </a>
                                </li> --}}

            </ul>
        </li>



        @if (Myhelper::can([
                'view_whitelable',
                'view_md',
                'view_distributor',
                'view_retailer',
                'view_apiuser',
                'view_other',
                'view_kycpending',
                'view_kycsubmitted',
                'view_kycrejected',
            ]))
            <li class="menu-item {{ Request::is('member/*') ? 'active open' : '' }}">
                <a href="#member" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-users"></i>
                    <div data-i18n="Member">Member</div>
                </a>
                <ul class="menu-sub {{ Request::is('member/*') ? 'show' : '' }}" id="member">
                    @if (Myhelper::can(['view_whitelable']))
                        <li class="menu-item {{ Request::is('member/whitelable') ? 'active' : '' }}">
                            <a href="{{ route('member', ['type' => 'whitelable']) }}" class="menu-link">
                                <div data-i18n="Whitelabel">Whitelabel</div>
                            </a>
                        </li>
                    @endif
                    @if (Myhelper::can(['view_md']))
                        <li class="menu-item {{ Request::is('member/md') ? 'active' : '' }}">
                            <a href="{{ route('member', ['type' => 'md']) }}" class=" menu-link">
                                <div data-i18n="Master Distributor">Master Distributor</div>
                            </a>
                        </li>
                    @endif
                    @if (Myhelper::can(['view_distributor']))
                        <li class="menu-item {{ Request::is('member/distributor') ? 'active' : '' }}">
                            <a href="{{ route('member', ['type' => 'distributor']) }}" class="menu-link">
                                <div data-i18n="Distributor">Distributor</div>
                            </a>
                        </li>
                    @endif
                    @if (Myhelper::can(['view_retailer']))
                        <li class="menu-item {{ Request::is('member/retailer') ? 'active' : '' }}">
                            <a href="{{ route('member', ['type' => 'retailer']) }}" class="menu-link">
                                <div data-i18n="Retailer">Retailer</div>
                            </a>
                        </li>
                    @endif
                    @if (Myhelper::hasRole('admin') || Myhelper::hasRole('subadmin'))
                        <li class="menu-item {{ Request::is('member/web') ? 'active' : '' }}">
                            <a href="{{ route('member', ['type' => 'web']) }}" class="menu-link">
                                <div data-i18n="All Member">All Member</div>
                            </a>
                        </li>
                    @endif

                    @if (Myhelper::hasRole('admin') || Myhelper::hasRole('subadmin'))
                        <li class="menu-item {{ Request::is('member/kycpending') ? 'active' : '' }}">
                            <a href="{{ route('member', ['type' => 'kycpending']) }}" class="menu-link">
                                <div data-i18n="New User">New User</div>
                            </a>
                        </li>
                    @endif


                </ul>
            </li>
        @endif

        <li
            class="menu-item {{ Request::is('statement/aeps') || Request::is('fund/aepsrequest') || Request::is('statement/billpay') || Request::is('statement/money') || Request::is('statement/matm') || Request::is('statement/recharge') || Request::is('statement/utipancard') || Request::is('statement/loanenquiry') || Request::is('statement/affiliateList') || Request::is('statement/cmsreport') ? 'active open' : '' }}">
            <a href="#txnreport" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-file"></i>
                <div data-i18n="Transaction Report">Transaction Report</div>
            </a>
            <ul class="menu-sub {{ Request::is('statement/aeps') || Request::is('fund/aepsrequest') || Request::is('statement/billpay') || Request::is('statement/money') || Request::is('statement/matm') || Request::is('statement/recharge') || Request::is('statement/utipancard') || Request::is('statement/loanenquiry') || Request::is('statement/cmsreport') || Request::is('statement/affiliateList') ? 'show' : '' }}"
                id="txnreport">
                 {{-- @if (Myhelper::can('aeps_statement'))
                    <li class="menu-item {{ Request::is('statement/aeps') ? 'active' : '' }}">
                                <a href="{{ route('statement', ['type' => 'aeps']) }}" class="menu-link">
                                    <div data-i18n="AePS CW Statement">AePS CW Statement</div>
                                </a>
                            </li>
                    <li class="menu-item {{ Request::is('statement/aepstxn') ? 'active' : '' }}">
                        <a href="{{ route('statement', ['type' => 'aepstxn']) }}" class="menu-link">
                            <div data-i18n="All AePS Transaction">All AePS Transaction</div>
                        </a>
                    </li>
                @endif

                <li class="menu-item {{ Request::is('statement/ccpayout') ? 'active' : '' }}">
                    <a href="{{ route('statement', ['type' => 'ccpayout']) }}" class="menu-link">
                        <div data-i18n="CC Payout Statement">CC Payout Statement</div>
                    </a>
                </li>

                <li class="menu-item {{ Request::is('statement/dmt') ? 'active' : '' }}">
                    <a href="{{ route('statement', ['type' => 'dmt']) }}" class="menu-link">
                        <div data-i18n="Xpayout Statement">X Payout Statement</div>
                    </a>
                </li> --}}
                {{-- @if (Myhelper::hasRole('admin')) --}}
                    <li class="menu-item {{ Request::is('fund/aepsrequest') ? 'active' : '' }}">
                        <a href="{{ route('fund', ['type' => 'aepsrequest']) }}" class="menu-link">
                            <div data-i18n="Commission Statement">Commission Statement</div>
                        </a>
                    </li>
                {{-- @endif --}}

                {{-- @if (Myhelper::can('billpayment_statement')) --}}
                    <li class="menu-item {{ Request::is('statement/billpay') ? 'active' : '' }}">
                        <a href="{{ route('statement', ['type' => 'billpay']) }}" class="menu-link">
                            <div data-i18n="Billpay Statement">Billpay Statement</div>
                        </a>
                    </li>
                    {{-- <li class="menu-item {{ Request::is('statement/ccpay') ? 'active' : '' }}">
                        <a href="{{ route('statement', ['type' => 'ccpay']) }}" class="menu-link">
                            <div data-i18n="Credit Card Payment">Credit Card Payment</div>
                        </a>
                    </li> --}}
                {{-- @endif --}}

                {{-- @if (Myhelper::can('money_statement'))
                    <li class="menu-item {{ Request::is('statement/money') ? 'active' : '' }}">
                        <a href="{{ route('statement', ['type' => 'money']) }}" class="menu-link">
                            <div data-i18n="Payout Statement">Payout Statement</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Request::is('statement/upipayout') ? 'active' : '' }}">
                        <a href="{{ route('statement', ['type' => 'upipayout']) }}" class="menu-link">
                            <div data-i18n="UPI-Payout Statement">UPI-Payout Statement</div>
                        </a>
                    </li>

                    <li class="menu-item {{ Request::is('statement/verification') ? 'active' : '' }}">
                        <a href="{{ route('statement', ['type' => 'verification']) }}" class="menu-link">
                            <div data-i18n="Verification Statement">Verification Statement</div>
                        </a>
                    </li>
                @endif
                @if (Myhelper::can('affiliate_statement'))
                    <li class="menu-item {{ Request::is('statement/affiliateList') ? 'active' : '' }}">
                        <a href="{{ route('statement', ['type' => 'affiliateList']) }}" class="menu-link">
                            <div data-i18n="Affiliate Statement">Affiliate Statement</div>
                        </a>
                    </li>
                @endif

                @if (Myhelper::can('matm_fund_report'))
                    <li class="menu-item {{ Request::is('statement/matm') ? 'active' : '' }}">
                        <a href="{{ route('statement', ['type' => 'matm']) }}" class="menu-link">
                            <div data-i18n="Micro ATM Statement">Micro ATM Statement</div>
                        </a>
                    </li>
                @endif --}}

                {{-- @if (Myhelper::can('recharge_statement')) --}}
                    <li class="menu-item {{ Request::is('statement/recharge') ? 'active' : '' }}">
                        <a href="{{ route('statement', ['type' => 'recharge']) }}" class="menu-link">
                            <div data-i18n="Recharge Statement">Recharge Statement</div>
                        </a>
                    </li>
                {{-- @endif --}}
                {{-- <li class="menu-item {{ Request::is('statement/vancollection') ? 'active' : '' }}">
                    <a href="{{ route('statement', ['type' => 'vancollection']) }}" class="menu-link">
                        <div data-i18n="Collection Statement">Collection Statement</div>
                    </a>
                </li>
                @if (Myhelper::can('utipancard_statement'))
                    <li class="menu-item {{ Request::is('statement/utipancard') ? 'active' : '' }}">
                        <a href="{{ route('statement', ['type' => 'utipancard']) }}" class="menu-link">
                            <div data-i18n="Uti Pancard Statement">Uti Pancard Statement</div>
                        </a>
                    </li>
                @endif --}}

            </ul>
        </li>

        <li class="menu-item {{ Request::is('profile/*') ? 'active open' : '' }}">
            <a href="#accountSetting" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-file-description"></i>
                <div data-i18n="Account Settings">Account Settings</div>
            </a>
            <ul class="menu-sub {{ Request::is('profile/*') ? 'show' : '' }}" id="accountSetting">
                <li class="menu-item {{ Request::is('profile/view') ? 'active' : '' }}">
                    <a href="{{ route('profile') }}" class="menu-link">
                        <div data-i18n="Profile Setting">Profile Setting</div>
                    </a>
                </li>
            </ul>
        </li>
        @if (Myhelper::hasRole('admin'))
            <li class="menu-item {{ Request::is('api/*') ? 'active open' : '' }}">
                <a href="#apilog" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-activity"></i>
                    <div data-i18n="API Log">API Logs</div>
                </a>
                <ul class="menu-sub {{ Request::is('api/*') ? 'show' : '' }}" id="apilog">
                    <li class="menu-item {{ Request::is('api/log') ? 'active' : '' }}">
                        <a href="{{ route('apilog') }}" class="menu-link">
                            <div data-i18n="Api Log">Api Logs</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif
    </ul>
</aside>
