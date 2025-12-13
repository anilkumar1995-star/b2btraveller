<?php

use App\Helpers\AndroidCommonHelper;
use App\Http\Controllers\Android\AndroidCommonController;
use App\Http\Controllers\Android\FundController;
use App\Http\Controllers\Android\PayoutController;
use App\Http\Controllers\Android\UserController;
use App\Http\Controllers\CallbackController;
use App\Http\Controllers\AepsController;
use App\Http\Controllers\Android\AffliateMarketContoller;
use App\Http\Controllers\Android\AndroidFundController;
use App\Http\Controllers\Android\AndroidIPAYAepsController;
use App\Http\Controllers\Android\BillpayController;
use App\Http\Controllers\Android\ComplaintController;
use App\Http\Controllers\Android\CyrusFundController;
use App\Http\Controllers\Android\FingpayController;
use App\Http\Controllers\Android\IYDAPanCardController;
use App\Http\Controllers\Android\LicBillpayController;
use App\Http\Controllers\Android\MatmController;
use App\Http\Controllers\Android\MoneyController;
use App\Http\Controllers\Android\PancardController;
use App\Http\Controllers\Android\PdmtController;
use App\Http\Controllers\Android\RaepsController;
use App\Http\Controllers\Android\RechargeController;
use App\Http\Controllers\Android\StatusCheckController;
use App\Http\Controllers\RechargeController as Check;
use App\Http\Controllers\Android\TransactionController;
use App\Http\Controllers\BulkSMSContolloller;
use App\Http\Controllers\Callbacks\IYDACallbackContoller;
use App\Http\Controllers\Android\CcpaymentsController;  
use App\Http\Controllers\Android\UpiController;  
use App\Http\Controllers\Android\IpayDmtController;   
use App\Http\Controllers\IYDABillPayController; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::any('cron/ccsettlement/iydapayments', [IYDACallbackContoller::class, 'checkCcSattelments']);
Route::any('cron/clearccpay/iydapayments', [IYDACallbackContoller::class, 'clearpending']);
Route::any('unlimit/success', [UserController::class, 'unlimitsuccess']);
Route::any('unlimit/failed', [UserController::class, 'unlimitfailed']);
 Route::any('ccpayment/data', [UserController::class, 'ccpayment']);
Route::any('callbacks/iydapayments', [IYDACallbackContoller::class, 'iydaCallbacks']);
Route::get('recons/ccpe/update', [IYDACallbackContoller::class, 'checkCcSattelments']);
Route::any('register/user', [UserController::class, 'extRegistration']);
Route::any('external/transaction/user/report', [UserController::class, 'utilityReports']);
Route::post('android/user/login', [UserController::class, 'login'])->middleware('androidLog'); 
 Route::post('android/user/registration', [UserController::class, 'registration']);
Route::group(['prefix' => 'android/user', 'middleware' => ['apiCheck','androidLog']], function () {
  /*Android App Apis*/
  
 

  Route::any('slider', [UserController::class, 'slider']);
 
 // Route::post('login', [UserController::class, 'login']);
  Route::post('logout', [UserController::class, 'logout']);
  Route::post('walletbalance', [UserController::class, 'getbalance']);
    Route::post('walletbalancev2', [UserController::class, 'getbalanceV2']);

  Route::group(['prefix' => 'password'], function () {
    Route::post('forget/sendotp', [UserController::class, 'passwordResetRequest']);
    Route::post('forget/verify', [UserController::class, 'passwordReset']);
    Route::post('change', [UserController::class, 'changepassword']);
  });

  Route::group(['prefix' => 'tpin', 'middleware' => ['apiCheck']], function () {
    Route::post('sendotp', [UserController::class, 'getotp']);
    Route::post('verify', [UserController::class, 'setpin']);
    Route::post('reset', [UserController::class, 'resetTpin']);
    Route::any('validate', [UserController::class, 'verifyTpin']);
  });


  Route::post('profile/update', [UserController::class, 'updateprofile']);
  Route::post('commission', [UserController::class, 'getcommission']);
  Route::post('bankaccount/add', [UserController::class, 'addBankAccount']);
  Route::post('bankaccount/list', [UserController::class, 'getUserBankAccount']);
  Route::get('servicelist', [UserController::class, 'servicelist']);



  Route::group(['prefix' => 'recharge', 'middleware' => ['apiCheck']], function () {
    Route::get('operator/list', [RechargeController::class, 'providersList']);
    Route::get('operator/circle', [RechargeController::class, 'getCircle']);
    Route::get('type', [RechargeController::class, 'getRechargeType']);
    Route::post('plan/{type}', [RechargeController::class, 'getRechargePlan']);
    Route::post('transaction', [RechargeController::class, 'transaction']);
    Route::post('status', [RechargeController::class, 'statucCheck']);
  });

  Route::group(['prefix' => 'payout', 'middleware' => ['apiCheck']], function () {
    Route::post('transaction', [PayoutController::class, 'payment']);
  });


  Route::group(['prefix' => 'fund', 'middleware' => ['apiCheck']], function () {
    Route::post('{type}', [AndroidFundController::class, 'transaction']);

  });

  Route::group(['prefix' => 'upipayout', 'middleware' => ['apiCheck']], function () {
    Route::post('transaction', [UpiController::class, 'payment']);
    Route::post('bene/delete', [UpiController::class, 'beneDelete']);
    Route::post('get/upidata', [UpiController::class, 'getUpicollectData']);
    Route::post('upi/onboard', [UpiController::class, 'onboardupi']);
     
  });
  
  Route::group(['prefix' => 'affiliate', 'middleware' => ['apiCheck']], function () {  //
    // Route::get('kitList', [AffliateMarketContoller::class, 'kitList']);
    Route::get('list/{type}', [AffliateMarketContoller::class, 'affliateMarket']);
    Route::get('submitDetailList', [AffliateMarketContoller::class, 'getAffiateDetails']);
    Route::post('submitDetails', [AffliateMarketContoller::class, 'postSubmitDetails']);
  });


  Route::group(['prefix' => 'servicelink', 'middleware' => ['apiCheck']], function () {  //
    Route::get('list', [AffliateMarketContoller::class, 'getExternalLink']);
  });


  Route::group(['prefix' => 'billpayment', 'middleware' => ['apiCheck']], function () {
    Route::get('provider', [BillPayController::class, 'getprovider']);
    Route::post('/', [BillPayController::class, 'transaction']);
  });

  Route::group(['prefix' => 'aeps', 'middleware' => ['apiCheck']], function () {
    Route::group(['prefix' => 'transaction'], function () {
      Route::get('initiate', [AndroidIPAYAepsController::class, 'makeInit'])->middleware('transactionlog:aeps');
      Route::post('update', [AndroidIPAYAepsController::class, 'updateTxn'])->middleware('transactionlog:aeps');
    });
  });


  Route::group(['prefix' => 'matm', 'middleware' => ['apiCheck']], function () {
    Route::group(['prefix' => 'transaction'], function () {
      Route::post('initiate', [MatmController::class, 'microatmInitiate'])->middleware('transactionlog:matm');
      Route::post('update', [MatmController::class, 'microatmUpdate'])->middleware('transactionlog:matm');
    });
  });

  Route::group(['prefix' => 'pan', 'middleware' => ['apiCheck']], function () {
    Route::get('initiate', [IYDAPanCardController::class, 'initiatePan'])->middleware('transactionlog:pan');
  });
  

  Route::group(['prefix' => 'status', 'middleware' => ['apiCheck']], function () {
    Route::get('{type}', [StatusCheckController::class, 'allTxnCheckStatus'])->middleware('transactionlog:pan');
  });

  Route::post('reports', [TransactionController::class, 'transaction']);
  Route::get('commission', [AndroidCommonController::class, 'getCommission']);


}); 

Route::get('android/state', [UserController::class, 'GetState']);
Route::get('android/districtbystateid', [UserController::class, 'GetDistrictByState']);
Route::get('android/banklist', [UserController::class, 'getBankList']);

 Route::group(['middleware' => ['apiCheck']], function () {
         Route::any('android/cc/transaction',[CcpaymentsController :: class, 'payments']);
        Route::any('android/xdmt/transaction',[MoneyController :: class, 'transaction']);
        Route::any('android/xdmt/delete/bene',[MoneyController :: class, 'beneDelete']);
    });

Route::any('android/getdmturl', [UserController::class,'getDmtUrl'])->middleware('apiCheck'); 
Route::any('android/condmt/onboarding', [UserController::class,'getOnboarding']);//->middleware('apiCheck');


Route::any('android/introslider', [UserController::class,'IntroSlider']);

   Route::group(['middleware' => ['apiCheck']], function () {
       
    Route::group(['prefix' => 'android/user/ipaydmt'], function () {
    Route::post('getdata', [IpayDmtController::class, 'index']);  
    Route::post('transaction', [IpayDmtController::class, 'payment'])->middleware('transactionlog:ipaydmt');
  });
  
   });