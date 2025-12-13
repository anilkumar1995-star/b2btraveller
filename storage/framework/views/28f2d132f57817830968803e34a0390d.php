<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <span class="app-brand-link">
            <span class="app-brand-logo demo">
                
                
                

                <?php if(Auth::user()->company->logo): ?>
                    <a class="header-logo" href="<?php echo e(route('home')); ?>">
                        <img src="<?php echo e(Imagehelper::getImageUrl().Auth::user()->company->logo); ?>" class=" img-fluid rounded"
                            alt="">
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('home')); ?>" class="header-logo">
                        <img src="" class="img-fluid rounded" alt="">
                        <span><?php echo e(Auth::user()->company->companyname); ?></span>
                    </a>
                <?php endif; ?>
            </span>
            <span class="app-brand-text demo menu-text fw-bold"><?php echo e(Auth::user()->company->companyname); ?></span>


            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
                <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
            </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <?php if(Auth::user()->kyc == 'verified'): ?>
            <li class="<?php echo e(request()->routeIs('home') ? 'active' : ''); ?> menu-item ">
                <a href="<?php echo e(route('home')); ?>" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-smart-home"></i>
                    <div data-i18n="Dashboards">Dashboards</div>
                </a>

            </li>

            <?php if(Myhelper::hasNotRole('admin')): ?>
                <?php if(Myhelper::can(['recharge_service'])): ?>
                    <li class="menu-item <?php echo e(Request::is('recharge/*') ? 'active open' : ''); ?>">
                        <a href="#menu-design" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons ti ti-file-dollar"></i>
                            <div data-i18n="Utility Recharge">Utility Recharge</div>
                        </a>
                        <ul class="menu-sub" id="menu-design <?php echo e(Request::is('recharge/*') ? 'show' : ''); ?>">
                            <?php if(Myhelper::can('recharge_service')): ?>
                                <li class="menu-item <?php echo e(Request::is('recharge/mobile') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('recharge', ['type' => 'mobile'])); ?>" class="menu-link">
                                        <div data-i18n="Mobile">Mobile</div>
                                    </a>
                                </li>
                                <li class="menu-item <?php echo e(Request::is('recharge/dth') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('recharge', ['type' => 'dth'])); ?>" class="menu-link">
                                        <div data-i18n="DTH">DTH</div>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if(Myhelper::can(['billpayment_service'])): ?>
                    <li class="menu-item <?php echo e(Request::is('billpay/*') ? 'active open' : ''); ?>">
                        <a href="#userinfo" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons ti ti-smart-home"></i>
                            <div data-i18n="Bill Payment">Bill Payment</div>
                        </a>
                        <ul class="menu-sub <?php echo e(Request::is('billpay/*') ? 'show' : ''); ?>" id="userinfo">
                            <?php if(Myhelper::can('billpayment_service')): ?>
                                <li class="menu-item <?php echo e(Request::is('billpay/electricity') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('bill', ['type' => 'electricity'])); ?>" class="menu-link">
                                        <div data-i18n="Electricity">Electricity</div>
                                    </a>
                                </li>
                                <li class="menu-item <?php echo e(Request::is('billpay/postpaid') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('bill', ['type' => 'postpaid'])); ?>" class="menu-link">
                                        <div data-i18n="Postpaid">Postpaid</div>
                                    </a>
                                </li>
                                <li class="menu-item <?php echo e(Request::is('billpay/water') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('bill', ['type' => 'water'])); ?>" class="menu-link">
                                        <div data-i18n="Water">Water</div>
                                    </a>
                                </li>
                                <li class="menu-item <?php echo e(Request::is('billpay/broadband') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('bill', ['type' => 'broadband'])); ?>" class="menu-link">
                                        <div data-i18n="Broadband">Broadband</div>
                                    </a>
                                </li>
                                <li class="menu-item <?php echo e(Request::is('billpay/lpggas') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('bill', ['type' => 'lpggas'])); ?>" class="menu-link">
                                        <div data-i18n="LPG Gas">LPG Gas</div>
                                    </a>
                                </li>
                                <li class="menu-item <?php echo e(Request::is('billpay/gas') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('bill', ['type' => 'gas'])); ?>" class="menu-link">
                                        <div data-i18n="Piped Gas">Piped Gas</div>
                                    </a>
                                </li>
                                <li class="menu-item <?php echo e(Request::is('billpay/landline') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('bill', ['type' => 'landline'])); ?>" class="menu-link">
                                        <div data-i18n="Landline">Landline</div>
                                    </a>
                                </li>
                                <li class="menu-item <?php echo e(Request::is('billpay/educationfees') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('bill', ['type' => 'educationfees'])); ?>" class="menu-link">
                                        <div data-i18n="Education Fees">Education Fees</div>
                                    </a>
                                </li>
                                <li class="menu-item <?php echo e(Request::is('billpay/fastag') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('bill', ['type' => 'fastag'])); ?>" class="menu-link">
                                        <i class="menu-icon tf-icons ti ti-user"></i>
                                        <div data-i18n="Fastag">Fastag</div>
                                    </a>
                                </li>
                                <li class="menu-item <?php echo e(Request::is('billpay/loanrepayment') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('bill', ['type' => 'loanrepayment'])); ?>" class="menu-link">
                                        <div data-i18n="Loan Repayment">Loan Repayment</div>
                                    </a>
                                </li>
                                <li class="menu-item <?php echo e(Request::is('billpay/insurance') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('bill', ['type' => 'insurance'])); ?>" class="menu-link">
                                        <div data-i18n="Insurance">Insurance</div>
                                    </a>
                                </li>
                                <li class="menu-item <?php echo e(Request::is('billpay/rental') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('bill', ['type' => 'rental'])); ?>" class="menu-link">
                                        <div data-i18n="Rental">Rental</div>
                                    </a>
                                </li>
                                <li class="menu-item <?php echo e(Request::is('billpay/donation') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('bill', ['type' => 'donation'])); ?>" class="menu-link">
                                        <div data-i18n="Donation">Donation</div>
                                    </a>
                                </li>
                                
                                <li class="menu-item <?php echo e(Request::is('billpay/subscription') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('bill', ['type' => 'subscription'])); ?>" class="menu-link">
                                        <div data-i18n="Subscription">Subscription</div>
                                    </a>
                                </li>
                                <li class="menu-item <?php echo e(Request::is('billpay/hospital') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('bill', ['type' => 'hospital'])); ?>" class="menu-link">
                                        <div data-i18n="Hospital">Hospital</div>
                                    </a>
                                </li>
                                <li
                                    class="menu-item <?php echo e(Request::is('billpay/clubsandassociations') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('bill', ['type' => 'clubsandassociations'])); ?>"
                                        class="menu-link">
                                        <div data-i18n="Clubs and Associations">Clubs and Associations</div>
                                    </a>
                                </li>
                                <li class="menu-item <?php echo e(Request::is('billpay/municipalservices') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('bill', ['type' => 'municipalservices'])); ?>" class="menu-link">
                                        <div data-i18n="Municipal Services">Municipal Services</div>
                                    </a>
                                </li>
                                <li class="menu-item <?php echo e(Request::is('billpay/municipaltaxes') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('bill', ['type' => 'municipaltaxes'])); ?>" class="menu-link">
                                        <div data-i18n="Municipal Taxes">Municipal Taxes</div>
                                    </a>
                                </li>
                                <li class="menu-item <?php echo e(Request::is('billpay/housingsociety') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('bill', ['type' => 'housingsociety'])); ?>" class="menu-link">
                                        <div data-i18n="Housing Society">Housing Society</div>
                                    </a>
                                </li>
                                <li class="menu-item <?php echo e(Request::is('billpay/lifeinsurance') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('bill', ['type' => 'lifeinsurance'])); ?>" class="menu-link">
                                        <div data-i18n="Life Insurance">Life Insurance</div>
                                    </a>
                                </li>
                                <li class="menu-item <?php echo e(Request::is('billpay/cabletv') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('bill', ['type' => 'cabletv'])); ?>" class="menu-link">
                                        <div data-i18n="Cable TV">Cable TV</div>
                                    </a>
                                </li>
                                <li class="menu-item <?php echo e(Request::is('billpay/creditcard') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('bill', ['type' => 'creditcard'])); ?>" class="menu-link">
                                        <div data-i18n="Credit Card">Credit Card</div>
                                    </a>
                                </li>
                                <li class="menu-item <?php echo e(Request::is('billpay/recurringdeposit') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('bill', ['type' => 'recurringdeposit'])); ?>" class="menu-link">
                                        <div data-i18n="Recurring Deposit">Recurring Deposit</div>
                                    </a>
                                </li>
                                
                                
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if(Myhelper::can(['utipancard_service', 'nsdl_service'])): ?>
                    <li class="menu-item <?php echo e(Request::is('pancard/*') ? 'active open' : ''); ?>">
                        <a href="#utiPan" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons ti ti-id"></i>
                            <div data-i18n="PAN Card">PAN Card</div>
                        </a>
                        <ul class="menu-sub <?php echo e(Request::is('pancard/*') ? 'show' : ''); ?>" id="utiPan">
                            <?php if(Myhelper::can('utipancard_service')): ?>
                                <li class="menu-item <?php echo e(Request::is('pancard/uti') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('pancard', ['type' => 'uti'])); ?>" class="menu-link">
                                        <div data-i18n="UTI">UTI</div>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if(Myhelper::can(['dmt1_service', 'aeps_service', 'dmt2_service','dmtx_service'])): ?>
                    <li class="menu-item <?php echo e(Request::is('dmt') || Request::is('aeps') ? 'active open' : ''); ?>">
                        <a href="#bankingService" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons ti ti-file-dollar"></i>
                            <div data-i18n="Banking Service">Banking Service</div>
                        </a>
                        <ul class="menu-sub <?php echo e(Request::is('dmt') || Request::is('aeps') ? 'show' : ''); ?>"
                            id="bankingService">
                            
                             <?php if(Myhelper::can('condmt_service')): ?>
                              <li class="menu-item <?php echo e(Request::is('condmt') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(url('condmt')); ?>" class="menu-link">
                                        <div data-i18n="Con DMT">Con DMT</div>
                                    </a>
                                </li>
                                   <?php endif; ?>  
                            
                            
                              <?php if(Myhelper::can('airtel_service')): ?>        
                                <li class="menu-item <?php echo e(Request::is('ipaydmt1') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(url('ipaydmt')); ?>" class="menu-link">
                                        <div data-i18n="Ipay DMT">Ipay DMT</div>
                                    </a>
                                </li>
                                   <?php endif; ?>  
                            
                               <?php if(Myhelper::can('dmtx_service')): ?>
                                <li class="menu-item <?php echo e(Request::is('xdmt') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('dmtx')); ?>" class="menu-link">
                                        <div data-i18n="X-Payout">X-Payout</div>
                                    </a>
                                </li>
                            <?php endif; ?> 

                            <?php if(Myhelper::can('aeps_service')): ?>
                                <li class="menu-item <?php echo e(Request::is('aeps') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('aeps')); ?>" class="menu-link">
                                        <div data-i18n="AEPS">AEPS</div>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if(Myhelper::can('aeps_service') || Myhelper::can('payout_service')): ?>
                                <li class="menu-item <?php echo e(Request::is('payout') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('payout', ['type' => 'payout'])); ?>" class="menu-link">
                                        <div data-i18n="Payout">Payout</div>
                                    </a>
                                </li>
                            <?php endif; ?>
                              <?php if(Myhelper::can('upipayout_service')): ?>
                             <li class="menu-item <?php echo e(Request::is('upipay') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('upipay',['type' =>'upipay'])); ?>" class="menu-link">
                                        <div data-i18n="UPI Payout">UPI Payout</div>
                                    </a>
                                </li>
                         <?php endif; ?>        
                             <?php if(Myhelper::can('ccpay_service')): ?>
                             <li class="menu-item <?php echo e(Request::is('rentpay') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('rentpay')); ?>" class="menu-link">
                                        <div data-i18n="Card Payments">Card Payments</div>
                                    </a>
                                </li>
                                
                               <li class="menu-item <?php echo e(Request::is('ccpayout') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('ccmovefund')); ?>" class="menu-link">
                                        <div data-i18n="CC Payout">CC Payout</div>
                                    </a>
                                </li>       
                                
                                   <?php endif; ?> 
                        </ul>
                    </li>
                <?php endif; ?>

                <li class="menu-item ">
                    <a href="#serviceLink" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-link"></i>
                        <div data-i18n="Service Links">Service Links</div>
                    </a>
                    <ul class="menu-sub" id="serviceLink">
                        <?php if(sizeof($mydata['links']) > 0): ?>
                            <?php $__currentLoopData = $mydata['links']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="menu-item">
                                    <a href="<?php echo e($link->value); ?>" class="menu-link" target="_blank">
                                        <div data-i18n="<?php echo e($link->name); ?>"><?php echo e($link->name); ?></div>
                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if(Myhelper::can(['company_manager', 'change_company_profile']) ||
                    (Myhelper::hasNotRole('retailer') &&
                        isset($mydata['schememanager']) &&
                        $mydata['schememanager']->value == 'all')): ?>
                <li class="menu-item <?php echo e(Request::is('resources/*') ? 'active open' : ''); ?>">
                    <a href="#tables" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-file"></i>
                        <div data-i18n="Resources">Resources</div>
                    </a>
                    <ul class="menu-sub <?php echo e(Request::is('resources/*') ? 'show' : ''); ?>" id="tables">
                        <?php if(Myhelper::hasNotRole('retailer') && isset($mydata['schememanager']) && $mydata['schememanager']->value == 'all'): ?>
                            <li class="menu-item <?php echo e(Request::is('resources/package') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('resource', ['type' => 'package'])); ?>" class="menu-link">
                                    <div data-i18n="Scheme Manager">Scheme Manager</div>
                                </a>
                            </li>
                        <?php elseif(Myhelper::hasRole('admin')): ?>
                            <li class="menu-item <?php echo e(Request::is('resources/scheme') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('resource', ['type' => 'scheme'])); ?>" class="menu-link">
                                    <div data-i18n="Scheme Manager">Scheme Manager</div>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(Myhelper::can('company_manager')): ?>
                            <li class="menu-item <?php echo e(Request::is('resources/company') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('resource', ['type' => 'company'])); ?>" class="menu-link">
                                    <div data-i18n="Company Manager">Company Manager</div>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if(Myhelper::can('change_company_profile')): ?>
                            <li class="menu-item <?php echo e(Request::is('resources/companyprofile') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('resource', ['type' => 'companyprofile'])); ?>" class="menu-link">
                                    <div data-i18n="Company Profile">Company Profile</div>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if(Myhelper::can([
                    'view_whitelable',
                    'view_md',
                    'view_distributor',
                    'view_retailer',
                    'view_apiuser',
                    'view_other',
                    'view_kycpending',
                    'view_kycsubmitted',
                    'view_kycrejected',
                ])): ?>
                <li class="menu-item <?php echo e(Request::is('member/*') ? 'active open' : ''); ?>">
                    <a href="#member" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-users"></i>
                        <div data-i18n="Member">Member</div>
                    </a>
                    <ul class="menu-sub <?php echo e(Request::is('member/*') ? 'show' : ''); ?>" id="member">
                        <?php if(Myhelper::can(['view_whitelable'])): ?>
                            <li class="menu-item <?php echo e(Request::is('member/whitelable') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('member', ['type' => 'whitelable'])); ?>" class="menu-link">
                                    <div data-i18n="Whitelabel">Whitelabel</div>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(Myhelper::can(['view_md'])): ?>
                            <li class="menu-item <?php echo e(Request::is('member/md') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('member', ['type' => 'md'])); ?>" class=" menu-link">
                                    <div data-i18n="Master Distributor">Master Distributor</div>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(Myhelper::can(['view_distributor'])): ?>
                            <li class="menu-item <?php echo e(Request::is('member/distributor') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('member', ['type' => 'distributor'])); ?>" class="menu-link">
                                    <div data-i18n="Distributor">Distributor</div>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(Myhelper::can(['view_retailer'])): ?>
                            <li class="menu-item <?php echo e(Request::is('member/retailer') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('member', ['type' => 'retailer'])); ?>" class="menu-link">
                                    <div data-i18n="Retailer">Retailer</div>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(Myhelper::hasRole('admin') || Myhelper::hasRole('subadmin')): ?>
                            <li class="menu-item <?php echo e(Request::is('member/web') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('member', ['type' => 'web'])); ?>" class="menu-link">
                                    <div data-i18n="All Member">All Member</div>
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        
                        <?php if(Myhelper::hasRole('admin') || Myhelper::hasRole('subadmin')): ?>
                            <li class="menu-item <?php echo e(Request::is('member/kycpending') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('member', ['type' => 'kycpending'])); ?>" class="menu-link">
                                    <div data-i18n="New User">New User</div>
                                </a>
                            </li>
                        <?php endif; ?> 


                    </ul>
                </li>
            <?php endif; ?>

            <?php if(Myhelper::can(['fund_transfer', 'fund_return', 'fund_request_view', 'fund_report', 'fund_request'])): ?>
                <li
                    class="menu-item <?php echo e(Request::is('fund/tr') || Request::is('fund/runpaisapg') || Request::is('fund/requestview') || Request::is('fund/request') || Request::is('fund/requestviewall') || Request::is('fund/statement') ? 'active open' : ''); ?>">
                    <a href="#funds" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-id"></i>
                        <div data-i18n="Fund">Fund</div>
                    </a>
                    <ul class="menu-sub <?php echo e(Request::is('fund/tr') || Request::is('fund/runpaisapg') || Request::is('fund/requestview') || Request::is('fund/request') || Request::is('fund/requestviewall') || Request::is('fund/statement') ? 'show' : ''); ?>"
                        id="funds">

                        <?php if(Myhelper::can(['fund_transfer', 'fund_return'])): ?>
                            <li class="menu-item <?php echo e(Request::is('fund/tr') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('fund', ['type' => 'tr'])); ?>" class="menu-link">
                                    <div data-i18n="Transfer/Return">Transfer/Return</div>
                                </a>
                            </li>
                        <?php endif; ?>
                         
                        <?php if(Myhelper::can(['setup_bank'])): ?>
                            <li class="menu-item <?php echo e(Request::is('fund/requestview') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('fund', ['type' => 'requestview'])); ?>" class="menu-link">
                                    <div data-i18n="Request">Request</div>
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <li class="menu-item <?php echo e(Request::is('fund/wallet2walletstatement') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('fund', ['type' => 'wallet2walletstatement'])); ?>" class="menu-link">
                                    <div data-i18n="Wallet to Wallet">Wallet to Wallet</div>
                                </a>
                            </li>
                            
                        <?php if(Myhelper::hasNotRole('admin') && Myhelper::can('fund_request')): ?>
                            <li class="menu-item <?php echo e(Request::is('fund/request') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('fund', ['type' => 'request'])); ?>" class="menu-link">
                                    <div data-i18n="Load Main Wallet">Load Main Wallet</div>
                                </a>
                            </li>
                        <?php endif; ?>
                        
                            <?php if(Myhelper::hasNotRole('admin') && Myhelper::can('qr_request')): ?>
                        <li class="menu-item <?php echo e(Request::is('fund/qrrequest') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('fund', ['type' => 'qrrequest'])); ?>" class="menu-link">
                                    <div data-i18n="QR Collection">QR Collection</div>
                                </a>
                            </li>
                             <?php endif; ?>    
                        
                         <li class="menu-item <?php echo e(Request::is('fund/aeps2wallet') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('fund', ['type' => 'aeps2wallet'])); ?>" class="menu-link">
                                    <div data-i18n="AEPS Move to Main">AEPS Move to Main</div>
                                </a>
                            </li>   

                        <?php if(Myhelper::can(['fund_report'])): ?>
                            <li class="menu-item <?php echo e(Request::is('fund/requestviewall') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('fund', ['type' => 'requestviewall'])); ?>" class="menu-link">
                                    <div data-i18n="Request Report">Request Report</div>
                                </a>
                            </li>
                            
                              <li class="menu-item <?php echo e(Request::is('fund/ccrequest') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('fund', ['type' => 'ccrequest'])); ?>" class="menu-link">
                                    <div data-i18n="CC Fund Report">CC Fund Report</div>
                                </a>
                            </li>  

                            <li class="menu-item <?php echo e(Request::is('fund/statement') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('fund', ['type' => 'statement'])); ?>" class="menu-link">
                                    <div data-i18n="All Fund Report">All Fund Report</div>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>

            


            


            

            

            <?php if(Myhelper::can(['utiid_statement', 'aepsid_statement'])): ?>

                <li
                    class="menu-item <?php echo e(Request::is('statement/aepsid') || Request::is('statement/utiid') ? 'active open' : ''); ?>">
                    <a href="#agentList" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-id"></i>
                        <div data-i18n="Agent List">Agent List</div>
                    </a>
                    <ul class="menu-sub <?php echo e(Request::is('statement/aepsid') || Request::is('statement/utiid') ? 'show' : ''); ?>"
                        id="agentList">
                        <?php if(Myhelper::can('aepsid_statement')): ?>
                            <li class="menu-item <?php echo e(Request::is('statement/aepsid') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('statement', ['type' => 'aepsid'])); ?>" class="menu-link">
                                    <div data-i18n="AePS">AePS</div>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if(Myhelper::can('utiid_statement')): ?>
                            <li class="menu-item <?php echo e(Request::is('statement/utiid') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('statement', ['type' => 'utiid'])); ?>" class="menu-link">
                                    <div data-i18n="UTI">UTI</div>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if(Myhelper::can(['affiliate_service'])): ?>
                <?php if(Myhelper::hasNotRole('admin')): ?>
                    <li
                        class="menu-item <?php echo e(Request::is('affiliate') ? 'active open' : ''); ?>">
                        <a href="#affser" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons ti ti-square"></i>
                            <div data-i18n="Affiliate">Affiliate</div>
                        </a>
                        <ul class="menu-sub <?php echo e(Request::is('affiliate/list') ? 'show' : ''); ?>" id="affser">
                            <?php if(Myhelper::can(['affiliate_service']) && Myhelper::hasNotRole('admin')): ?>
                                <li class="menu-item <?php echo e(Request::is('affiliate/list') ? 'active open' : ''); ?>">
                                    <a href="<?php echo e(url('affiliate/list', ['type' => 'department'])); ?>" class="menu-link">
                                        <div data-i18n="Affiliate Service">Affiliate Service</div>
                                    </a>
                                </li>
                            <?php endif; ?>

                            
                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <?php if(Myhelper::can(['commission_settlement'])): ?>
                <?php if(Myhelper::hasNotRole('admin')): ?>
                    <li
                        class="menu-item <?php echo e(Request::is('fund/aeps') || Request::is('fund/addaccount') || Request::is('fund/aepsrequest') || Request::is('fund/payoutrequest') || Request::is('fund/aepsrequestall') ? 'active open' : ''); ?>">
                        <a href="#aepsfund" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons ti ti-square"></i>
                            <div data-i18n="Commission">Commission</div>
                        </a>
                        <ul class="menu-sub <?php echo e(Request::is('fund/aeps') || Request::is('fund/addaccount') || Request::is('fund/aepsrequest') || Request::is('fund/payoutrequest') || Request::is('fund/aepsrequestall') ? 'show' : ''); ?>" id="aepsfund">
                            <?php if(Myhelper::can(['commission_settlement']) && Myhelper::hasNotRole('admin')): ?>
                                <li class="menu-item <?php echo e(Request::is('fund/aeps') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('fund', ['type' => 'aeps'])); ?>" class="menu-link">
                                        <div data-i18n="Request">Request</div>
                                    </a>
                                </li>
                            <?php endif; ?>

                           
                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <?php if(Myhelper::can([
                    'account_statement',
                    'utiid_statement',
                    'utipancard_statement',
                    'recharge_statement',
                    'billpayment_statement',
                    'affiliate_statement'
                ])): ?>

                <li
                    class="menu-item <?php echo e(Request::is('statement/aeps') || Request::is('statement/billpay') || Request::is('statement/money') || Request::is('statement/matm') || Request::is('statement/recharge') || Request::is('statement/utipancard') || Request::is('statement/loanenquiry') || Request::is('statement/affiliateList')||Request::is('statement/cmsreport') ? 'active open' : ''); ?>">
                    <a href="#txnreport" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-file"></i>
                        <div data-i18n="Transaction Report">Transaction Report</div>
                    </a>
                    <ul class="menu-sub <?php echo e(Request::is('statement/aeps') || Request::is('statement/billpay') || Request::is('statement/money') || Request::is('statement/matm') || Request::is('statement/recharge') || Request::is('statement/utipancard') || Request::is('statement/loanenquiry') || Request::is('statement/cmsreport') || Request::is('statement/affiliateList') ? 'show' : ''); ?>"
                        id="txnreport">
                        <?php if(Myhelper::can('aeps_statement')): ?>
                            
                            <li class="menu-item <?php echo e(Request::is('statement/aepstxn') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('statement', ['type' => 'aepstxn'])); ?>" class="menu-link">
                                    <div data-i18n="All AePS Transaction">All AePS Transaction</div>
                                </a>
                            </li>
                        <?php endif; ?>
                               
                          <li class="menu-item <?php echo e(Request::is('statement/ccpayout') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('statement', ['type' => 'ccpayout'])); ?>" class="menu-link">
                                    <div data-i18n="CC Payout Statement">CC Payout Statement</div>
                                </a>
                            </li>   
                            
                          <li class="menu-item <?php echo e(Request::is('statement/dmt') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('statement', ['type' => 'dmt'])); ?>" class="menu-link">
                                    <div data-i18n="Xpayout Statement">X Payout Statement</div>
                                </a>
                            </li>       
                       <?php if(Myhelper::hasRole('admin')): ?>
                        <li class="menu-item <?php echo e(Request::is('fund/aepsrequest') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('fund', ['type' => 'aepsrequest'])); ?>" class="menu-link">
                                <div data-i18n="Commission Statement">Commission Statement</div>
                            </a>
                        </li>

                        <?php endif; ?>

                        <?php if(Myhelper::can('billpayment_statement')): ?>
                            <li class="menu-item <?php echo e(Request::is('statement/billpay') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('statement', ['type' => 'billpay'])); ?>" class="menu-link">
                                    <div data-i18n="Billpay Statement">Billpay Statement</div>
                                </a>
                            </li>
                               <li class="menu-item <?php echo e(Request::is('statement/ccpay') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('statement', ['type' => 'ccpay'])); ?>" class="menu-link">
                                    <div data-i18n="Credit Card Payment">Credit Card Payment</div>
                                </a>
                                </li>
                        <?php endif; ?>

                        <?php if(Myhelper::can('money_statement')): ?>
                            <li class="menu-item <?php echo e(Request::is('statement/money') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('statement', ['type' => 'money'])); ?>" class="menu-link">
                                    <div data-i18n="Payout Statement">Payout Statement</div>
                                </a>
                            </li>
                            <li class="menu-item <?php echo e(Request::is('statement/upipayout') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('statement', ['type' => 'upipayout'])); ?>" class="menu-link">
                                    <div data-i18n="UPI-Payout Statement">UPI-Payout Statement</div>
                                </a>
                            </li>    

                            <li class="menu-item <?php echo e(Request::is('statement/verification') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('statement', ['type' => 'verification'])); ?>" class="menu-link">
                                    <div data-i18n="Verification Statement">Verification Statement</div>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(Myhelper::can('affiliate_statement')): ?>
                            <li class="menu-item <?php echo e(Request::is('statement/affiliateList') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('statement', ['type' => 'affiliateList'])); ?>" class="menu-link">
                                    <div data-i18n="Affiliate Statement">Affiliate Statement</div>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if(Myhelper::can('matm_fund_report')): ?>
                            <li class="menu-item <?php echo e(Request::is('statement/matm') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('statement', ['type' => 'matm'])); ?>" class="menu-link">
                                    <div data-i18n="Micro ATM Statement">Micro ATM Statement</div>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if(Myhelper::can('recharge_statement')): ?>
                            <li class="menu-item <?php echo e(Request::is('statement/recharge') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('statement', ['type' => 'recharge'])); ?>" class="menu-link">
                                    <div data-i18n="Recharge Statement">Recharge Statement</div>
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="menu-item <?php echo e(Request::is('statement/vancollection') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('statement', ['type' => 'vancollection'])); ?>" class="menu-link">
                                    <div data-i18n="Collection Statement">Collection Statement</div>
                                </a>
                            </li>     
                        <?php if(Myhelper::can('utipancard_statement')): ?>
                            <li class="menu-item <?php echo e(Request::is('statement/utipancard') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('statement', ['type' => 'utipancard'])); ?>" class="menu-link">
                                    <div data-i18n="Uti Pancard Statement">Uti Pancard Statement</div>
                                </a>
                            </li>
                        <?php endif; ?>

                        
                    </ul>
                </li>
            <?php endif; ?>


            <?php if(Myhelper::can(['account_statement', 'awallet_statement'])): ?>

                <li
                    class="menu-item <?php echo e(Request::is('statement/account') || Request::is('statement/awallet') ? 'active open' : ''); ?>">
                    <a href="#walletreport" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-id"></i>
                        <div data-i18n="Wallet History">Wallet History</div>
                    </a>
                    <ul class="menu-sub <?php echo e(Request::is('statement/account') || Request::is('statement/awallet') ? 'show' : ''); ?>"
                        id="walletreport">
                        <?php if(Myhelper::can('account_statement')): ?>
                            <li class="menu-item <?php echo e(Request::is('statement/account') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('statement', ['type' => 'account'])); ?>" class="menu-link">
                                    <div data-i18n="Main Wallet">Main Wallet</div>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(Myhelper::can('awallet_statement')): ?>
                            <li class="menu-item <?php echo e(Request::is('statement/awallet') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('statement', ['type' => 'awallet'])); ?>" class="menu-link">
                                    <div data-i18n="Aeps Wallet">Aeps Wallet</div>
                                </a>
                            </li>

                            <li class="menu-item <?php echo e(Request::is('statement/commission') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('statement', ['type' => 'commission'])); ?>" class="menu-link">
                                    <div data-i18n="Commission Wallet">Commission Wallet</div>
                                </a>
                            </li>

                            
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if(Myhelper::can('Complaint')): ?>
                <li class="menu-item <?php echo e(Request::is('complaint') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('complaint')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-layout-navbar"></i>
                        <div data-i18n="Complaints">Complaints</div>
                    </a>
                </li>
            <?php endif; ?>

            <?php if(Myhelper::hasRole('admin')): ?>
                <li class="menu-item <?php echo e(Request::is('matchingpercent') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('matchingpercent')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-layout-navbar"></i>
                        <div data-i18n="Matching Percent">Matching Percent</div>
                    </a>
                </li>
            <?php endif; ?>

            <?php if(Myhelper::can(['setup_bank', 'api_manager', 'setup_operator'])): ?>
                <li class="menu-item <?php echo e(Request::is('setup/*') || Request::is('token') ? 'active open' : ''); ?>">
                    <a href="#setuptools" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-text-wrap-disabled"></i>
                        <div data-i18n="Setup Tools">Setup Tools</div>
                    </a>
                    <ul class="menu-sub <?php echo e(Request::is('setup/*') ? 'show' : ''); ?>" id="setuptools">
                        <?php if(Myhelper::hasRole('admin') || Myhelper::hasRole('subadmin')): ?>
                            <li class="menu-item <?php echo e(Request::is('token') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('securedata')); ?>" class="menu-link">
                                    <div data-i18n="Mobile User Logout">Mobile User Logout</div>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(Myhelper::can('api_manager')): ?>
                            <li class="menu-item <?php echo e(Request::is('setup/api') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('setup', ['type' => 'api'])); ?>" class="menu-link">
                                    <div data-i18n="API Manager">API Manager</div>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(Myhelper::can('setup_bank')): ?>
                            <li class="menu-item <?php echo e(Request::is('setup/bank') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('setup', ['type' => 'bank'])); ?>" class="menu-link">
                                    <div data-i18n="Bank Account">Bank Account</div>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(Myhelper::can('complaint_subject')): ?>
                            <li class="menu-item <?php echo e(Request::is('setup/complaintsub') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('setup', ['type' => 'complaintsub'])); ?>" class="menu-link">
                                    <div data-i18n="Complaint Subject">Complaint Subject</div>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(Myhelper::can('setup_operator')): ?>
                            <li class="menu-item  <?php echo e(Request::is('setup/operator') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('setup', ['type' => 'operator'])); ?>" class="menu-link">
                                    <div data-i18n="Operator Manager">Operator Manager</div>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(Myhelper::hasRole('admin')): ?>
                            <li class="menu-item <?php echo e(Request::is('setup/portalsetting') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('setup', ['type' => 'portalsetting'])); ?>" class="menu-link">
                                    <div data-i18n="Portal Setting">Portal Setting</div>
                                </a>
                            </li>
                            <li class="menu-item <?php echo e(Request::is('setup/links') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('setup', ['type' => 'links'])); ?>" class="menu-link">
                                    <div data-i18n="Quick Links">Quick Links</div>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>

            <li class="menu-item <?php echo e(Request::is('profile/*') ? 'active open' : ''); ?>">
                <a href="#accountSetting" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-file-description"></i>
                    <div data-i18n="Account Settings">Account Settings</div>
                </a>
                <ul class="menu-sub <?php echo e(Request::is('profile/*') ? 'show' : ''); ?>" id="accountSetting">
                    <li class="menu-item <?php echo e(Request::is('profile/view') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('profile')); ?>" class="menu-link">
                            <div data-i18n="Profile Setting">Profile Setting</div>
                        </a>
                    </li>
                    
                </ul>
            </li>

            <?php if(Myhelper::hasRole('apiuser') && Myhelper::can('apiuser_acc_manager')): ?>
                <li class="menu-item <?php echo e(Request::is('apisetup/*') ? 'active open' : ''); ?>">
                    <a href="#apiSetting" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-settings"></i>
                        <div data-i18n="Api Settings">Api Settings</div>
                    </a>
                    <ul class="menu-sub <?php echo e(Request::is('apisetup/*') ? 'show' : ''); ?>" id="apiSetting">
                        <li class="menu-item <?php echo e(Request::is('apisetup/setting') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('apisetup', ['type' => 'setting'])); ?>" class="menu-link">
                                <div data-i18n="Callback & Token">Callback & Token</div>
                            </a>
                        </li>
                        <li class="menu-item <?php echo e(Request::is('apisetup/operator') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('apisetup', ['type' => 'operator'])); ?>" class="menu-link">
                                <div data-i18n="Operator Code">Operator Code</div>
                            </a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>

            <!-- <li class="menu-item ">
                <a href="#driverLink" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti  ti-layout-grid"></i>
                    <div data-i18n="Driver Links">Driver Links</div>
                </a>
                <ul class="menu-sub" id="driverLink">

                    <li class="menu-item">
                        <a href="https://drive.google.com/drive/folders/10RF-h2b9lVoa_d692e5CUVnpi7Gxwr7R?usp=sharing"
                            target="_blank" class="menu-link">
                            <div data-i18n="Mantra">Mantra</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="https://drive.google.com/open?id=13FbVSOuplWlJNhwKMjTmKHkyA5CZPkh0" target="_blank"
                            class="menu-link">
                            <div data-i18n="Morpho">Morpho</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="https://drive.google.com/open?id=1-LJfFXIvgE3ZLIm5fmYGjz95IvUnQYk4" target="_blank"
                            class="menu-link">
                            <div data-i18n="Tatvik TMF20">Tatvik TMF20</div>
                        </a>
                    </li>
                </ul>
            </li> -->

            <?php if(Myhelper::hasRole('admin')): ?>
                <li class="menu-item <?php echo e(Request::is('tools/*') ? 'active open' : ''); ?>">
                    <a href="#roles" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-file"></i>
                        <div data-i18n="Roles & Permissions">Roles & Permissions</div>
                    </a>
                    <ul class="menu-sub <?php echo e(Request::is('tools/*') ? 'show' : ''); ?>" id="roles">

                        <li class="menu-item <?php echo e(Request::is('tools/roles') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('tools', ['type' => 'roles'])); ?>" class="menu-link">
                                <div data-i18n="Roles">Roles</div>
                            </a>
                        </li>
                        <li class="menu-item <?php echo e(Request::is('tools/permissions') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('tools', ['type' => 'permissions'])); ?>" class="menu-link">
                                <div data-i18n="Permission">Permission</div>
                            </a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>
        <?php endif; ?>
    </ul>
</aside>
<!-- / Menu -->
<?php /**PATH /home/incognic/login.bharatmitra.co/resources/views/layouts/sidebar.blade.php ENDPATH**/ ?>