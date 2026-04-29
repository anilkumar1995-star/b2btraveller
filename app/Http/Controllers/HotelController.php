<?php

namespace App\Http\Controllers;

use App\Helpers\AndroidCommonHelper;
use App\Services\HotelAuthService;
use App\Services\HotelService;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Api;
use App\Models\Provider;
use App\Models\User;
use App\Models\Agents;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HotelController extends Controller
{
    protected $tektravels;

    public function __construct(HotelAuthService $tektravels)
    {
        $this->tektravels = $tektravels;
    }

    public function root()
    {
        return view('hotel.index-hotel');
    }

    function gust_Deatils()
    {
        return view('hotel.guest_details');
    }

    public function refreshToken()
    {
        try {
            $token = $this->tektravels->getToken();
            return response()->json([
                'success' => true,
                'token' => $token,
                'message' => 'Token refreshed successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function searchCountry(Request $request)
    {
        // dd($request->all());
        $service = new HotelService();
        $response = $service->searchCountry($request->all());

        return response()->json($response);
    }

    public function searchCity(Request $request)
    {
        $service = new HotelService();
        $response = $service->searchCity($request->all());

        return response()->json($response);
    }
    public function searchHotelName(Request $request)
    {
        $service = new HotelService();
        $response = $service->searchHotelName($request->all());

        return response()->json($response);
    }


    public function searchHotel(Request $request)
    {
        $service = new HotelService();
        $response = $service->searchHotel($request->all());

        return response()->json($response);
    }

    public function viewHotelDetails()
    {
        return view('hotel.detail');
    }

    public function detailsHotel(Request $request)
    {
        $service = new HotelService();
        $response = $service->hotelDetails($request->all());

        return response()->json($response);
    }
    public function prebooking(Request $request)
    {
        $service = new HotelService();
        $response = $service->prebooking($request->all());

        return response()->json($response);
    }

    public function book_HOTELS(Request $request)
    {
        $user = \Auth::user();
        if ($request->payment_mode === 'pg') {
            $clientRefId = AndroidCommonHelper::createPGTxnId(10);
            
            $service = new HotelService();
            $result = $service->initiatePayment($user, $request->netAmt, $clientRefId);
      
            if ($result['response'] != '') {
                $responseStatus = json_decode($result['response']);

                if (isset($responseStatus->code) && $responseStatus->code == "0x0200") {
                    $tid = substr($request->BookingId, 0, 50); 

                    $provider = Provider::where('recharge1', 'hoteltravel')->first();

                    try {
                        DB::table('hotel_bookings')->insert([
                            'user_id' => \Auth::id(),
                            'invoice_number' => null,
                            'invoice_amount' => $request->netAmt,
                            'ticket_no' => null,
                            'booking_id_api' => $tid,
                            'order_ref_id' => $clientRefId,
                            'hotel_id' => null,
                            'total_room' => $request->TotalRooms ?? 1,
                            'base_fare' => $request->base_fare ?? 0,
                            'tax' => $request->tax ?? 0,
                            'total_amount' => 2,
                            // 'total_amount' => $request->netAmt,
                            'is_pricechange' => "false",
                            'payment_status' => 'pending',
                            'booking_status' => 'pending',
                            'is_refundable' => $request->is_refundable ?? 'false',
                            'voucher_status' => $request->voucher_status ?? true,
                            'api_type' => 'book',
                            'raw_payload' => json_encode(array_merge($request->all(), ['clientRefId' => $clientRefId])),
                            'raw_response' => null,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        Report::create([
                            'number' => substr($tid, 0, 25),
                            'mobile' => $user->mobile,
                            'provider_id' => $provider->id ?? 0,
                            'api_id' => $provider->api_id ?? 0,
                            'amount' => 2,
                            // 'amount' => (float) $request->netAmt,
                            'profit' => 0,
                            'txnid' => $clientRefId,
                            'payid' => $clientRefId,
                            'status' => 'pending',
                            'user_id' => $user->id,
                            'credited_by' => $user->id,
                            'rtype' => 'main',
                            'via' => 'portal',
                            'balance' => $user->mainwallet,
                            'trans_type' => 'debit',
                            'product' => 'hoteltravel',
                            'transtype' => 'pg',
                        ]);
                    } catch (\Exception $de) {
                    }

                    return response()->json([
                        'status' => 'SUCCESS',
                        'url' => $responseStatus->data->url,
                        'message' => 'Order created successful.',
                        'data' => $responseStatus->data
                    ]);
                } else {
                    return response()->json([
                        'status' => 'failed',
                        'message' => $responseStatus->message ?? "PG Initiation failed: " . ($responseStatus->code ?? 'Unknown code')
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => "PG service no response or connection error"
                ]);
            }
        }

        /*
        try {
            DB::beginTransaction();

            // Lock wallet row
            $user = User::where('id', Auth::id())->lockForUpdate()->first();

            $lockedBalance = AndroidCommonHelper::getLockedBalance();

            if ($user->mainwallet < ((float)$request->netAmt + $lockedBalance['mainLockedBalance'])) {
                DB::rollBack();
                return response()->json([
                    'status' => 'balance_low',
                    'message' => 'Low Balance, Kindly recharge your wallet.'
                ]);
            }
            $request['netAmt'] = number_format((float)$request->netAmt, 2, '.', '');

            do {
                $request['clientRefId'] = AndroidCommonHelper::createPGTxnId(10);
            } while (Report::where('txnid', $request['clientRefId'])->exists());

            $provider = Provider::where('recharge1', 'hoteltravel')->firstOrFail();

            $request['profit']       = 0;
            $request['debitAmount']  = $request->netAmt;

            // Debit wallet
            User::where('id', $user->id)->decrement('mainwallet', $request->debitAmount);

            // Unique txnid
            do {
                $request['txnid'] = $this->transcode() . rand(1111111111, 9999999999);
            } while (Report::where('txnid', $request->txnid)->exists());

            // Create pending report
            $report = Report::create([
                'number'      => $request->BookingId,
                'mobile'      => $request->HotelPassenger[0]['Phoneno'] ?? $user->mobile,
                'provider_id' => $provider->id,
                'api_id'      => $provider->api_id,
                'amount'      => $request->netAmt,
                'profit'      => $request->profit,
                'txnid'       => $request->txnid,
                'payid'       => $request->clientRefId,
                'status'      => 'pending',
                'user_id'     => $user->id,
                'credited_by' => $user->id,
                'rtype'       => 'main',
                'via'         => 'portal',
                'balance'     => $user->mainwallet,
                'trans_type'  => 'debit',
                'product'     => 'hoteltravel',
                'transtype'   => 'mainwallet',
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Hotel booking pre-api failed', [
                'user_id' => $user->id,
                'error'   => $e->getMessage()
            ]);

            return response()->json([
                'status'  => 'failed',
                'message' => 'Transaction failed, please try again.'
            ]);
        }

        $service  = new HotelService();
        $response = $service->bookHotel($request->all());


        try {
            DB::beginTransaction();

            if (strtolower($response['status'] ?? '') == 'failed' || strtolower($response['status'] ?? '') == 'failure') {

                User::where('id', $user->id)->increment('mainwallet', $request->debitAmount);

                Report::where('id', $report->id)->update([
                    'status' => 'failed',
                    'refno'  => $request->BookingId,
                ]);

                DB::table('failed_hotel_bookings_list')->insert([
                    'user_id'        => \Auth::id(),
                    'booking_status' => 'failed',
                    'message'        => $response['message'] ?? 'Hotel booking failed',
                    'raw_response'   => json_encode($response),
                    'base_fare'      => $request->details['PriceBreakUp'][0]['RoomRate'],
                    'tax'      => $request->details['NetTax'],
                    'total_amount' => $request->netAmt,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);

                return response()->json([
                    'status'  => 'failed',
                    'message' => $response['message'] ?? 'Hotel booking failed'
                ]);
            }

            if (strtolower($response['status'] ?? '') == 'success') {

                $data = $response['data'] ?? null;
                if (!$data) {
                    throw new \Exception('Invalid API response');
                }

                DB::table('hotel_bookings')->insert([
                    'user_id' => \Auth::id(),
                    'invoice_number' => $response['data']['InvoiceNumber'],
                    'invoice_amount' => $request->netAmt,
                    'ticket_no' =>  $response['data']['ConfirmationNo'],
                    'booking_id_api' => $request->BookingId,
                    'order_ref_id' =>  $response['data']['BookingRefNo'],
                    'hotel_id' =>  $response['data']['BookingId'],
                    'total_room' => '',
                    'base_fare' => 0,
                    'tax' => 0,
                    'total_amount' => $request->netAmt,
                    'is_pricechange' => $response['data']['IsPriceChanged'] ? "true" : "false",
                    'payment_status' => 'success',
                    'booking_status' => $response['data']['HotelBookingStatus'],
                    'voucher_status' => $response['data']['VoucherStatus'],
                    'api_type' => 'book',
                    'raw_payload' => json_encode($request->all()),
                    'raw_response' => json_encode($response),
                    'is_refundable' => $request->details['IsRefundable'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Hotel Book successfully',
                    'data' => $response['data'],
                    'totalAmount' => $request->netAmt
                ]);
            }


            DB::table('hotel_bookings')
                ->where('booking_id_api', $request->BookingId)
                ->update([
                    'booking_status' => 'pending',
                    'payment_status' => 'pending',
                    'api_type' => 'book',
                    'updated_at'     => now(),
                ]);

            DB::commit();

            return response()->json([
                'status'  => 'pending',
                'message' => $response['message'] ?? 'Hotel booking pending'
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            \Log::error('Hotel booking post-api failed', [
                'user_id' => $user->id,
                'error'   => $e->getMessage()
            ]);

            return response()->json([
                'status'  => 'failed',
                'message' => 'Booking processed but final update failed. Please contact support.'
            ]);
        }
        */

    }

    public function bookingList(Request $request)
    {
        if (\Myhelper::hasRole('admin')) {
            $data['totalsuccess'] = DB::table('hotel_bookings')->where('booking_status', 'Confirmed')->sum('total_amount');
            $data['totalsuccessCount'] = DB::table('hotel_bookings')->where('booking_status', 'Confirmed')->count();
            $data['totalpending'] = DB::table('hotel_bookings')->where('booking_status', 'pending')->sum('total_amount');
            $data['totalpendingCount'] = DB::table('hotel_bookings')->where('booking_status', 'pending')->count();

            $data['totalblocked'] = DB::table('hotel_bookings')->where('booking_status', 'failed')->sum('total_amount');
            $data['totalblockedCount'] = DB::table('hotel_bookings')->where('booking_status', 'failed')->count();
            $data['totalcancelled'] = DB::table('hotel_bookings')->where('booking_status', 'Cancelled')->sum('total_amount');
            $data['totalcancelledCount'] = DB::table('hotel_bookings')->where('booking_status', 'Cancelled')->count();

        } else {
            $data['totalsuccess'] = DB::table('hotel_bookings')->where('user_id', auth()->id())->where('booking_status', 'Confirmed')->sum('total_amount');
            $data['totalsuccessCount'] = DB::table('hotel_bookings')->where('user_id', auth()->id())->where('booking_status', 'Confirmed')->count();
            $data['totalpending'] = DB::table('hotel_bookings')->where('user_id', auth()->id())->where('booking_status', 'pending')->sum('total_amount');
            $data['totalpendingCount'] = DB::table('hotel_bookings')->where('user_id', auth()->id())->where('booking_status', 'pending')->count();

            $data['totalblocked'] = DB::table('hotel_bookings')->where('user_id', auth()->id())->where('booking_status', 'failed')->sum('total_amount');
            $data['totalblockedCount'] = DB::table('hotel_bookings')->where('user_id', auth()->id())->where('booking_status', 'failed')->count();
            $data['totalcancelled'] = DB::table('hotel_bookings')->where('user_id', auth()->id())->where('booking_status', 'Cancelled')->sum('total_amount');
            $data['totalcancelledCount'] = DB::table('hotel_bookings')->where('user_id', auth()->id())->where('booking_status', 'Cancelled')->count();
        }
        
        $query = DB::table('hotel_bookings')
            ->join('users', 'users.id', '=', 'hotel_bookings.user_id');

        if (!\Myhelper::hasRole('admin')) {
            $query->where('hotel_bookings.user_id', \Auth::id());
        }

        $data['bookings'] = $query->select(
                'hotel_bookings.*',
                'users.name as user_name',
                'users.email as user_email',
                'users.mobile as user_mobile'
            )
            ->orderBy('hotel_bookings.id', 'DESC')
            ->paginate(10);


        if ($request->ajax()) {
            return view('hotel.booking-table')->with($data)->render();
        }

        return view('hotel.bookinglist')->with($data);
    }

    public function bookingListFailed(Request $request)
    {
        $query = DB::table('failed_hotel_bookings_list')
            ->join('users', 'users.id', '=', 'failed_hotel_bookings_list.user_id');

        if (!\Myhelper::hasRole('admin')) {
            $query->where('failed_hotel_bookings_list.user_id', \Auth::id());
        }

        $bookings = $query->select(
                'failed_hotel_bookings_list.*',
                'users.name as user_name',
                'users.email as user_email',
                'users.mobile as user_mobile'
            )
            ->orderBy('failed_hotel_bookings_list.id', 'DESC')
            ->paginate(10);


        if ($request->ajax()) {
            return view('hotel.booking-table-failed', compact('bookings'))->render();
        }

        return view('hotel.bookinglistfailed', compact('bookings'));
    }

    public function paymentSuccess(Request $request)
    {
        $id = $request->clientRefId ?? $request->txnid ?? $request->orderId ?? $request->id;
        $booking = DB::table('hotel_bookings')->where('order_ref_id', $id)->first();
        return view('hotel.status')->with(['status' => 'pending', 'message' => 'Payment Received, Finalizing...', 'id' => $id, 'booking' => $booking]);
    }

    public function paymentFailed(Request $request)
    {
        $id = $request->clientRefId ?? $request->txnid ?? $request->orderId ?? $request->id;        
        $booking = DB::table('hotel_bookings')->where('order_ref_id', $id)->first();
        return view('hotel.status')->with(['status' => 'pending', 'message' => 'Payment Received, Finalizing...', 'id' => $id, 'booking' => $booking]);
    }

    public function checkStatus(Request $request)
    {
        $id = $request->id;
        if (!$id) {
            return response()->json(['status' => 'failed', 'message' => 'ID missing']);
        }

        $booking = DB::table('hotel_bookings')->where('order_ref_id', $id)->first();
        if (!$booking) {
            return response()->json(['status' => 'failed', 'message' => 'Booking record not found']);
        }

        if ($booking->booking_status === 'Confirmed') {
            return response()->json([
                'status' => 'success',
                'booking_status' => 'Confirmed',
                'data' => $booking
            ]);
        }

        $service = new HotelService();
        $result = $service->checkPaymentStatus($id);
        if ($result['response'] != '') {
            $responseStatus = json_decode($result['response']);
            $isSuccess = (isset($responseStatus->status) && strtoupper($responseStatus->status) == "SUCCESS") || (isset($responseStatus->code) && $responseStatus->code == "0x0200");
            $isFailure = (isset($responseStatus->status) && (strtolower($responseStatus->status) == "failure" || strtolower($responseStatus->status) == "failed")) 
                         || (isset($responseStatus->code) && !in_array($responseStatus->code, ["0x0200", "0x0201"]));
            $isPending = (isset($responseStatus->status) && strtolower($responseStatus->status) == "pending") || (isset($responseStatus->code) && $responseStatus->code == "0x0201");

            if ($isSuccess) {
                if ($booking->payment_status !== 'success') {
                    DB::table('hotel_bookings')->where('id', $booking->id)->update(['payment_status' => 'success']);
                    Report::where('txnid', $booking->order_ref_id)
                        ->orWhere('payid', $booking->order_ref_id)
                        ->update(['status' => 'success']);
                    $booking->payment_status = 'success';
                }

                $finalResult = $this->finalizeBooking($booking);
                $booking = DB::table('hotel_bookings')->where('id', $booking->id)->first();
                
                if (!$finalResult['status']) {
                    return response()->json([
                        'status' => 'failed',
                        'booking_status' => $booking->booking_status ?? 'failed',
                        'message' => $finalResult['message'] ?? 'Unable to confirm with hotel provider.'
                    ]);
                }

                return response()->json([
                    'status' => 'success',
                    'booking_status' => 'Confirmed',
                    'data' => $booking
                ]);
            }

            if ($isFailure) {
                DB::table('hotel_bookings')
                    ->where('id', $booking->id)
                    ->update([
                        'payment_status' => 'failed',
                        'booking_status' => 'failed',
                        'payment_failed_msg' => $responseStatus->message ?? "Transaction failed",
                    ]);
                
                DB::table('reports')
                    ->where('txnid', $booking->order_ref_id)
                    ->update(['status' => 'failed']);

                return response()->json([
                    'status' => 'failed',
                    'message' => $responseStatus->message ?? "Transaction failed",
                    'data' => DB::table('hotel_bookings')->where('id', $booking->id)->first()
                ]);
            }

            if ($isPending) {
                return response()->json([
                    'status' => 'pending',
                    'message' => $responseStatus->message ?? "Transaction pending",
                    'data' => $booking
                ]);
            }
        }

        return response()->json([
            'status' => 'success',
            'booking_status' => $booking->booking_status ?? 'pending',
            'message' => (isset($responseStatus) && isset($responseStatus->message)) ? $responseStatus->message : null,
            'data' => $booking
        ]);
    }

    private function finalizeBooking($booking)
    {
        if ($booking->payment_status === 'success' && $booking->booking_status !== 'Confirmed') {
            
            $payload = json_decode($booking->raw_payload, true);
            $payload['clientRefId'] = $payload['clientRefId'] ?? $booking->order_ref_id; 

            $service = new HotelService();
            $response = $service->bookHotel($payload);
            
            if (strtolower($response['status'] ?? '') == 'success') {
                $data = $response['data'] ?? null;
                
                DB::table('hotel_bookings')
                    ->where('id', $booking->id)
                    ->update([
                        'invoice_number' => $data['InvoiceNumber'] ?? null,
                        'ticket_no' => $data['ConfirmationNo'] ?? null,
                        'voucher_status' => $data['VoucherStatus'],
                        'booking_ref_no' => $data['BookingRefNo'] ?? null,
                        'hotel_id' => $data['BookingId'] ?? null,
                        'is_pricechange' => ($data['IsPriceChanged'] ?? false) ? "true" : "false",
                        'booking_status' => $data['HotelBookingStatus'] ?? 'Confirmed',
                        'base_fare' => $data['PriceBreakUp'][0]['RoomRate'] ?? 0,
                        'tax' => $data['NetTax'] ?? 0,
                        'raw_response' => json_encode($response)
                    ]);

                return ['status' => true, 'message' => 'Confirmed'];
            } else {
                $errMsg = $response['message'] ?? 'Unknown API Error';
                
                DB::table('hotel_bookings')->where('id', $booking->id)->update([
                        'booking_status' => 'failed',
                        'booking_failed_msg' => $errMsg ?? 'Booking Failed.'
                    ]);

                DB::table('failed_hotel_bookings_list')->insert([
                    'user_id' => $booking->user_id,
                    'booking_status' => 'failed',
                    'message' => $errMsg,
                    'raw_response' => json_encode($response),
                    'raw_payload' => $booking->raw_payload,
                    'total_amount' => $booking->total_amount,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                return ['status' => false, 'message' => $errMsg];
            }
        }
        
        return ['status' => true, 'message' => 'Already Confirmed'];
    }
    public function reviewBooking()
    {
        return view('hotel.review');
    }

    public function viewTicket(Request $request)
    {
        $id = $request->id;
        $booking = DB::table('hotel_bookings')
            ->where('id', $id)
            ->first();

        if (!$booking) {
            return response()->json(['status' => 'failed', 'message' => 'Booking not found']);
        }

        try {
            $service = new HotelService();
            $response = $service->getDetailsHotel($booking->hotel_id);
            $response['record'] = $booking;

            return response()->json($response);
           
        } catch (\Exception $e) {
            return response()->json(['status' => 'failed', 'message' => 'Error fetching details: ' . $e->getMessage()]);
        }
    }

    public function refundAmount(Request $request)
    {
        if (!\Myhelper::hasRole('admin')) {
             return response()->json(['status' => 'failed', 'message' => 'Unauthorized access']);
        }

        $api = DB::table('apis')->where('code', 'orpayment')->first();
        if (!$api) {
            return response()->json(['status' => 'failed', 'message' => "Refund service is down"]);
        }

        $url = rtrim($api->url, '/') . "/v1/service/paycc/unlimit/refund";
        
        $header = [
            "Content-Type: application/json",
            "Authorization: Basic " . base64_encode($api->username . ":" . $api->password)
        ];

        $reqData = [
            "clientRefId"  => $request->clientRefId,
        ];

        $result = \Myhelper::curl($url, "POST", json_encode($reqData), $header, "yes");
       
        if ($result['response'] != '') {
            $responseStatus = json_decode($result['response']);
           
            if (isset($responseStatus->code) && ($responseStatus->code == "0x0200" || $responseStatus->code == "0x0206")) {
                $msg = $responseStatus->message ?? (($responseStatus->code == "0x0206") ? "Refund initiated successfully." : "Refund successful.");
                
                $updateData = [
                    'booking_status' => 'failed',
                    'payment_status' => 'refunded',
                ];

                if (isset($responseStatus->data->amount)) {
                    $updateData['refunded_amount'] = $responseStatus->data->amount;
                }

                DB::table('hotel_bookings')
                    ->where('order_ref_id', $request->clientRefId)
                    ->update($updateData);

                return response()->json([
                    'status'  => 'success',
                    'message' => $msg,
                    'data'    => $responseStatus
                ]);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => $responseStatus->message ?? "Refund failed"
                ]);
            }
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => "Refund service no response"
            ]);
        }
    }


    public function generateVoucher(Request $request)
    {
        $id = $request->booking_id;

        $booking = DB::table('hotel_bookings')
            ->where('booking_id_api', $id)
            ->first();

        if (!$booking) {
            return response()->json(['status' => 'failed', 'message' => 'Booking not found']);
        }

        $service = new HotelService();
        $response = $service->generateVoucher($booking->hotel_id);


        if (strtolower($response['status'] ?? '') == 'success') {
            DB::table('hotel_bookings')
                ->where('id', $booking->id)
                ->update([
                    'voucher_status' => true,
                    'booking_status' => 'Confirmed',
                    'updated_at'     => now(),
                ]);
        }

        return response()->json($response);
    }
}



