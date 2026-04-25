<?php

namespace App\Http\Controllers;

use App\Helpers\AndroidCommonHelper;
use App\Models\Apilog;
use App\Models\Bus;
use App\Models\Provider;
use App\Models\Report;
use App\Models\Api;
use App\Models\Agents;
use App\Models\Ccreport;
use App\Repo\BillPaymentRepo;
use App\Services\AuthService;
use App\Services\BusAuthService;
use App\Services\BusService;
use App\Services\Traveller\BusTravelService;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Myhelper;

class BusController extends Controller
{
    protected $tektravels;

    public function __construct(BusAuthService $tektravels)
    {
        $this->tektravels = $tektravels;
    }

    public function root()
    {
        return view('bus.index-bus');
    }

    public function seatlayList()
    {
        return view('bus.seatlay');
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

    public function searchCity(Request $request)
    {
        $service = new BusService();
        $response = $service->searchCity($request->all());

        return response()->json($response);
    }


    public function search(Request $request)
    {
        $service = new BusService();
        $response = $service->searchBus($request->all());

        return response()->json($response);
    }

    public function boardingdetails(Request $request)
    {
        $service = new BusService();
        $response = $service->boardingdetail($request->all());

        return response()->json($response);
    }
    public function seatdetails(Request $request)
    {
        $service = new BusService();
        $response = $service->seatdetail($request->all());

        return response()->json($response);
    }


    public function busBlock(Request $request)
    {
        $service = new BusService();
        $response = $service->busBlocks($request->all());

        if (strtolower($response['status'] ?? '') !== 'success') {

            $baseFare = 0;
            $tax = 0;
            $totalAmount = 0;
            $totalSeats = 0;

            if (!empty($request->passenger)) {
                foreach ($request->passenger as $p) {
                    $price = $p['Seat']['Price'] ?? [];

                    $baseFare += $price['BasePrice'] ?? 0;
                    $tax += $price['Tax'] ?? 0;
                    $totalAmount += $price['PublishedPrice'] ?? 0;
                    $totalSeats++;
                }
            }

            DB::table('failed_bus_bookings_list')->insert([
                'user_id' => \Auth::id(),
                'base_fare' => $baseFare,
                'tax' => $tax,
                'total_amount' => $totalAmount,
                'booking_status' => 'failed',
                'message' => $response['message'] ?? 'Bus block failed',
                'raw_response' => json_encode($response),
                'raw_payload' => json_encode($request->all()),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'status' => 'failed',
                'message' => $response['message'] ?? 'Bus block failed'
            ]);
        }

        $data = $response['data'] ?? null;

        if (!$data || empty($data['Passenger'])) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid bus block response'
            ]);
        }

        $baseFare = 0;
        $tax = 0;
        $totalAmount = 0;
        $totalSeats = 0;

        foreach ($data['Passenger'] as $p) {
            $price = $p['Seat']['Price'] ?? [];

            $baseFare += $price['BasePrice'] ?? 0;
            $tax += $price['Tax'] ?? 0;
            $totalAmount += $price['PublishedPrice'] ?? 0;
            $totalSeats++;
        }

        $departureTime = !empty($data['DepartureTime'])
            ? Carbon::createFromFormat('m/d/Y H:i:s', str_replace('\/', '/', $data['DepartureTime']))
                ->format('Y-m-d H:i:s')
            : null;

        $arrivalTime = !empty($data['ArrivalTime'])
            ? Carbon::createFromFormat('m/d/Y H:i:s', str_replace('\/', '/', $data['ArrivalTime']))
                ->format('Y-m-d H:i:s')
            : null;
        /* ================= SUCCESS SAVE ================= */
        DB::table('bus_bookings')->insert([
            'user_id' => \Auth::id(),
            'pnr' => null,
            'booking_id_api' => $data['TraceId'],
            'ticket_no' => $data['TicketNo'] ?? null,
            'bus_id' => $data['BusId'] ?? null,

            'origin' => $data['BoardingPointdetails']['CityPointLocation'] ?? 'N/A',
            'destination' => $data['DropingPointdetails']['CityPointLocation'] ?? 'N/A',
            'travel_name' => $data['TravelName'] ?? null,
            'service_name' => $data['ServiceName'] ?? null,
            'bus_type' => $data['BusType'] ?? null,

            'journey_date' => $departureTime,
            'departure_time' => $departureTime,
            'arrival_time' => $arrivalTime,


            'boarding_point' => $data['BoardingPointdetails']['CityPointName'] ?? null,
            'dropping_point' => $data['DropingPointdetails']['CityPointName'] ?? null,
            'total_seats' => $totalSeats,
            'base_fare' => $baseFare,
            'tax' => $tax,
            'total_amount' => $totalAmount,
            'is_pricechange' => $data['IsPriceChanged'] ? "true" : "false",
            'payment_status' => 'pending',
            'booking_status' => 'blocked',
            'api_type' => 'block',

            'raw_payload' => json_encode($request->all()),
            'raw_response' => json_encode($response),

            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Bus Block successfully',
            'data' => $response['data'],
            'totalAmount' => $totalAmount
        ]);
    }

    public function bookBus(Request $request)
    {
        $user = \Auth::user();

        if ($user->status !== 'active') {
            return response()->json(['status' => 'failed', 'message' => 'Your account has been blocked.']);
        }

        /* 
        try {
            DB::beginTransaction();

            // Lock wallet row
            $user = User::where('id', $user->id)->lockForUpdate()->first();

            $lockedBalance = AndroidCommonHelper::getLockedBalance();

            if ($user->mainwallet < ((float)$request->totalAmount + $lockedBalance['mainLockedBalance'])) {
                DB::rollBack();
                return response()->json([
                    'status' => 'balance_low',
                    'message' => 'Low Balance, Kindly recharge your wallet.'
                ]);
            }

            do {
                $request['clientRefId'] = AndroidCommonHelper::createPGTxnId(10);
            } while (Report::where('txnid', $request['clientRefId'])->exists());

            $provider = Provider::where('recharge1', 'bustravel')->firstOrFail();

            $request['profit']       = 0;
            $request['debitAmount']  = $request->totalAmount;

            // Debit wallet
            User::where('id', $user->id)->decrement('mainwallet', $request->debitAmount);

            // Unique txnid
            do {
                $request['txnid'] = $this->transcode() . rand(1111111111, 9999999999);
            } while (Report::where('txnid', $request->txnid)->exists());

            // Create pending report
            $report = Report::create([
                'number'      => $request->traceId,
                'mobile'      => $request->passenger[0]['Phoneno'] ?? $user->mobile,
                'provider_id' => $provider->id,
                'api_id'      => $provider->api_id,
                'amount'      => $request->totalAmount,
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
                'product'     => 'bustravel',
                'transtype'   => 'mainwallet',
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            \Log::error('Bus booking pre-api failed', [
                'user_id' => $user->id,
                'error'   => $e->getMessage()
            ]);

            return response()->json([
                'status'  => 'failed',
                'message' => 'Transaction failed, please try again.'
            ]);
        }

        $service  = new BusService();
        $response = $service->bookBuss($request->all());

        try {
            DB::beginTransaction();

            if (strtolower($response['status'] ?? '') == 'failed' || strtolower($response['status'] ?? '') == 'failure') {

                User::where('id', $user->id)->increment('mainwallet', $request->debitAmount);

                Report::where('id', $report->id)->update([
                    'status' => 'failed',
                    'refno'  => $request->traceId,
                ]);

                DB::table('failed_bus_bookings_list')->insert([
                    'user_id'        => \Auth::id(),
                    'booking_status' => 'failed',
                    'message'        => $response['message'] ?? 'Bus booking failed',
                    'raw_response'   => json_encode($response),
                    'base_fare'      => $request->totalAmount,
                    'total_amount' => $request->totalAmount,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);



                DB::table('bus_bookings')
                    ->where('booking_id_api', $request->traceId)
                    ->update([
                        'booking_status' => 'failed',
                        'payment_status' => 'failed',
                        'api_type' => 'book',
                        'updated_at'     => now(),
                    ]);

                DB::commit();

                return response()->json([
                    'status'  => 'failed',
                    'message' => $response['message'] ?? 'Bus booking failed'
                ]);
            }

            // SUCCESS 
            if (strtolower($response['status'] ?? '') == 'success') {

                $data = $response['data'] ?? null;
                if (!$data) {
                    throw new Exception('Invalid API response');
                }

                Report::where('id', $report->id)->update([
                    'status' => 'success',
                    'refno'  => $data['TraceId'],
                ]);

                DB::table('bus_bookings')
                    ->where('booking_id_api', $data['TraceId'])
                    ->update([
                        'ticket_no'       => $data['TicketNo'] ?? null,
                        'pnr'    => $data['TravelOperatorPNR'] ?? null,
                        'invoice_number' => $data['InvoiceNumber'] ?? null,
                        'invoice_amount' => $data['InvoiceAmount'] ?? null,
                        'bus_id'          => $data['BusId'] ?? null,
                        'booking_status' => $data['BusBookingStatus'] ?? null,
                        'payment_status' => 'success',
                        'api_type' => 'book',
                        'order_ref_id'   => $data['orderRefId'] ?? null,
                        'raw_response'   => json_encode($response),
                        'updated_at'     => now(),
                    ]);

                DB::commit();

                return response()->json([
                    'status'  => 'success',
                    'message' => 'Bus booked successfully',
                    'data'    => $data
                ]);
            }


            // PENDING 
            Report::where('id', $report->id)->update([
                'status' => 'pending',
                'refno'  => $request->traceId,
            ]);

            DB::table('bus_bookings')
                ->where('booking_id_api', $request->traceId)
                ->update([
                    'booking_status' => 'pending',
                    'payment_status' => 'pending',
                    'api_type' => 'book',
                    'updated_at'     => now(),
                ]);

            DB::commit();

            return response()->json([
                'status'  => 'pending',
                'message' => $response['message'] ?? 'Bus booking pending'
            ]);
        } catch (Exception $e) {

            DB::rollBack();

            \Log::error('Bus booking post-api failed', [
                'user_id' => $user->id,
                'error'   => $e->getMessage()
            ]);

            return response()->json([
                'status'  => 'failed',
                'message' => 'Booking processed but final update failed. Please contact support.'
            ]);
        }
        */


        $api = Api::where('code', 'rrpayment')->first();
        if (!$api) {
            return response()->json(['status' => 'failed', 'message' => "PG service is down"]);
        }

        $agent = Agents::where('user_id', \Auth::id())->first();
        if (!$agent) {
            $agent = Agents::where('user_id', 1)->first();
        }

        $clientRefId = AndroidCommonHelper::createPGTxnId(10);
        $tid = $request->input('traceId') ?? $request->input('TraceId');

        $booking = DB::table('bus_bookings')->where('booking_id_api', $tid)->first();
        if (!$booking) {
            $booking = DB::table('bus_bookings')
                ->where('user_id', \Auth::id())
                ->where('booking_status', 'blocked')
                ->orderBy('id', 'desc')
                ->first();
        }

        if ($booking) {
            DB::table('bus_bookings')
                ->where('id', $booking->id)
                ->update([
                    'order_ref_id' => $clientRefId,
                    'raw_payload' => json_encode($request->all())
                ]);
        }

        $url = $api->url . "v1/service/pgcollect/order";

        $header = [
            "Content-Type: application/json",
            "Authorization: Basic " . base64_encode($api->username . ":" . $api->password)
        ];

        $reqData = [
            "email" => $user->email,
            "name" => $user->name,
            "merchantCode" => $agent->bc_id ?? "MID73323213401",
            "clientRefId" => $clientRefId,
            "mobile" => $user->mobile,
            "redirectUrl" => route('bus.payment.success'),
            "successUrl" => route('bus.payment.success'),
            "failedUrl" => route('bus.payment.failed'),
            // "amount" => (float) $request->totalAmount
            "amount" => 2
        ];

        $result = \Myhelper::curl($url, "POST", json_encode($reqData), $header, "yes");

        if ($result['response'] != '') {
            $responseStatus = json_decode($result['response']);

            if (isset($responseStatus->code) && $responseStatus->code == "0x0200") {

                Report::create([
                    'number' => $booking->booking_id_api ?? $tid,
                    'mobile' => $user->mobile,
                    'provider_id' => 0,
                    'api_id' => 0,
                    // 'amount' => (float) $request->totalAmount,
                    'amount' => 2,
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
                    'product' => 'bustravel',
                    'transtype' => 'pg',
                ]);

                return response()->json([
                    'status' => 'SUCCESS',
                    'url' => $responseStatus->data->url,
                    'message' => 'Order created successful.',
                    'data' => $responseStatus->data
                ]);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => $responseStatus->message ?? "PG Initiation failed"
                ]);
            }
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => "PG service no response"
            ]);
        }

    }

    public function generateTravellerUrl()
    {
        try {
            $service = new BusTravelService();
            $response = $service->generateUrl();
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function bookingList(Request $request)
    {
        if (\Myhelper::hasRole('admin')) {
            $data['totalsuccess'] = Bus::where('booking_status', 'Confirmed')->sum('total_amount');
            $data['totalsuccessCount'] = Bus::where('booking_status', 'Confirmed')->count();
            $data['totalpending'] = Bus::where('booking_status', 'pending')->sum('total_amount');
            $data['totalpendingCount'] = Bus::where('booking_status', 'pending')->count();

            $data['totalblocked'] = Bus::where('booking_status', 'blocked')->sum('total_amount');
            $data['totalblockedCount'] = Bus::where('booking_status', 'blocked')->count();
            $data['totalcancelled'] = Bus::where('booking_status', 'Cancelled')->sum('total_amount');
            $data['totalcancelledCount'] = Bus::where('booking_status', 'Cancelled')->count();
            
        } else {
            $data['totalsuccess'] = Bus::where('user_id', auth()->id())->where('booking_status', 'Confirmed')->sum('total_amount');
            $data['totalsuccessCount'] = Bus::where('user_id', auth()->id())->where('booking_status', 'Confirmed')->count();
            $data['totalpending'] = Bus::where('user_id', auth()->id())->where('booking_status', 'pending')->sum('total_amount');
            $data['totalpendingCount'] = Bus::where('user_id', auth()->id())->where('booking_status', 'pending')->count();

            $data['totalblocked'] = Bus::where('user_id', auth()->id())->where('booking_status', 'blocked')->sum('total_amount');
            $data['totalblockedCount'] = Bus::where('user_id', auth()->id())->where('booking_status', 'blocked')->count();
            $data['totalcancelled'] = Bus::where('user_id', auth()->id())->where('booking_status', 'Cancelled')->sum('total_amount');
            $data['totalcancelledCount'] = Bus::where('user_id', auth()->id())->where('booking_status', 'Cancelled')->count();
        }
        $query = DB::table('bus_bookings')
            ->join('users', 'users.id', '=', 'bus_bookings.user_id');

        if (!\Myhelper::hasRole('admin')) {
            $query->where('bus_bookings.user_id', \Auth::id());
        }

        $data['bookings'] = $query->select(
                'bus_bookings.*',
                'users.name as user_name',
                'users.email as user_email',
                'users.mobile as user_mobile'
            )
            ->orderBy('bus_bookings.id', 'DESC')
            ->paginate(10);


        if ($request->ajax()) {
            return view('bus.booking-table')->with($data)->render();
        }
        // $data['customers'] = DB::table('customer_list')
        //     ->where('user_id', auth()->id())
        //     ->where('status', 'active')
        //     ->get();

        return view('bus.bookinglist', $data);


        return view('bus.bookinglist')->with($data);
    }

    public function bookingListFailed(Request $request)
    {
        $query = DB::table('failed_bus_bookings_list')
            ->join('users', 'users.id', '=', 'failed_bus_bookings_list.user_id');

        if (!\Myhelper::hasRole('admin')) {
            $query->where('failed_bus_bookings_list.user_id', \Auth::id());
        }

        $bookings = $query->select(
                'failed_bus_bookings_list.*',
                'users.name as user_name',
                'users.email as user_email',
                'users.mobile as user_mobile'
            )
            ->orderBy('failed_bus_bookings_list.id', 'DESC')
            ->paginate(10);


        if ($request->ajax()) {
            return view('bus.booking-table-failed', compact('bookings'))->render();
        }

        return view('bus.bookinglistfailed', compact('bookings'));
    }

    public function viewTicket(Request $request)
    {
        $booking = DB::table('bus_bookings')->where('bus_id', $request->busId)->first();

        if (!$booking) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Booking Details not found'
            ]);
        }
        $service = new BusService();
        $response = $service->getDetailsBus($booking);

        return response()->json($response);
    }

    public function checkStatus(Request $request)
    {
        $id = $request->id;
        if (!$id) {
            return response()->json(['status' => 'failed', 'message' => 'ID missing']);
        }

        $booking = DB::table('bus_bookings')->where('order_ref_id', $id)->first();

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

        $api = Api::where('code', 'orpayment')->first();
        if (!$api) {
            return response()->json(['status' => 'failed', 'message' => 'API not found']);
        }
        if ($api) {
            $url = rtrim($api->url, '/') . '/v1/service/paycc/order/' . $id;
            $auth = base64_encode(trim($api->username) . ":" . trim($api->password));

            $header = [
                "Content-Type: application/json",
                "Authorization: Basic " . $auth
            ];

            $result = \Myhelper::curl($url, "GET", "", $header, "yes");

            if ($result['response'] != '') {
                $responseStatus = json_decode($result['response']);

                if (isset($responseStatus->status) && $responseStatus->status == "SUCCESS") {
                    DB::table('bus_bookings')->where('id', $booking->id)->update(['payment_status' => 'success']);
                    DB::table('reports')->where('txnid', $booking->order_ref_id)->orWhere('payid', $booking->order_ref_id)->update(['status' => 'success']);
                    
                    $booking = DB::table('bus_bookings')->where('id', $booking->id)->first();
                    $finalResult = $this->finalizeBooking($booking);
                    $booking = DB::table('bus_bookings')->where('id', $booking->id)->first();
                   
                    if (!$finalResult['status']) {
                        return response()->json([
                            'status' => 'failed',
                            'booking_status' => $booking->booking_status ?? 'failed',
                            'message' => $finalResult['message'] ?? 'Unable to confirm with bus provider.'
                        ]);
                    }
                }

                if (isset($responseStatus->status) && strtoupper($responseStatus->status) == "FAILURE") {
                    DB::table('bus_bookings')->where('id', $booking->id)->update([
                        'payment_status' => 'failed',
                        'booking_status' => 'failed',
                        'payment_failed_msg' => $responseStatus->message ?? "Transaction failed",
                    ]);

                    DB::table('reports')->where('txnid', $booking->order_ref_id)->update(['status' => 'failed']);

                    return response()->json([
                        'status' => 'failed',
                        'message' => $responseStatus->message ?? "Transaction failed",
                        'data' => DB::table('bus_bookings')->where('id', $booking->id)->first()
                    ]);
                }

                if (isset($responseStatus->status) && strtolower($responseStatus->status) == "pending") {
                    return response()->json([
                        'status' => 'pending',
                        'message' => $responseStatus->message ?? "Transaction pending",
                        'data' => $booking
                    ]);
                }
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
            
            if (!isset($payload['totalAmount']) && isset($booking->total_amount)) {
                $payload['totalAmount'] = $booking->total_amount;
            }
            if (!isset($payload['clientRefId'])) {
                $payload['clientRefId'] = $booking->order_ref_id;
            }

            $service = new BusService();
            $serviceResponse = $service->bookBuss($payload);
            

            if (isset($serviceResponse['status']) && strtolower($serviceResponse['status']) == 'success') {
                $data = $serviceResponse['data'] ?? [];
                
                $updateData = [
                    'booking_status' => 'Confirmed',
                    'raw_response' => json_encode($serviceResponse),
                    'updated_at' => now()
                ];

                if (isset($data['PNR']) || isset($data['TravelOperatorPNR'])) {
                   $updateData['pnr'] = $data['PNR'] ?? $data['TravelOperatorPNR'];
                }
                if (isset($data['TicketNo'])) {
                   $updateData['ticket_no'] = $data['TicketNo'];
                }

                DB::table('bus_bookings')->where('id', $booking->id)->update($updateData);
                
                return ['status' => true, 'message' => 'Confirmed'];
            } else {
                $errMsg = $serviceResponse['message'] ?? 'Unknown API Error';
                
                DB::table('bus_bookings')->where('id', $booking->id)->update([
                    'booking_status' => 'failed',
                    'booking_failed_msg' => $errMsg
                ]);

                return ['status' => false, 'message' => $errMsg];
            }
        }
        
        return ['status' => true, 'message' => 'Already Confirmed'];
    }

    public function cancelPage($id)
    {

        $decoded = json_decode(base64_decode($id), true);

        if (!$decoded) {
            abort(404, 'Invalid Data');
        }

        $booking = DB::table('bus_bookings')->where('booking_id_api', $decoded)->first();

        if (!$booking) {
            abort(404, 'Booking not found');
        }

        return view('bus.cancel', compact('booking'));
    }

    public function submitCancellation(Request $request)
    {

        $bokTable = DB::table('bus_bookings')->where('bus_id', $request->payload['BusId'])->first();

        $reportTable = Report::where('number', $bokTable->booking_id_api)->first();
        if (!$reportTable) {
            return response()->json(['status' => 'failed', 'message' => 'Report not found for this booking.']);
        }
        if ($reportTable->status != 'success') {
            return response()->json(['status' => 'failed', 'message' => 'Only successful bookings can be cancelled.']);
        }

        $request['payid'] = $reportTable->payid;

        $service = new BusService();
        $response = $service->cancelbus($request->all());

        if ($response['status'] == 'success') {
            $refundAmount = (float) $response['data']['Response'][0]['RefundedAmount'] ?? 0.0;
            $old = User::select('mainwallet')->where('id', $reportTable->user_id)->first();
            $oldBalance = $old->mainwallet;
            if ($refundAmount > 0) {
                User::where('id', $reportTable->user_id)
                    ->where('status', 'active')
                    ->increment('mainwallet', $refundAmount);
            }

            $reportTable->update([
                'status' => 'reversed',
                'remark' => 'Booking cancelled, refund initiated.',
                'refno' => $bokTable->booking_id_api
            ]);

            // new record created for refund
            Report::create([
                'number' => $reportTable->number,
                'mobile' => $reportTable->mobile,
                'provider_id' => $reportTable->provider_id,
                'api_id' => $reportTable->api_id,
                'amount' => $refundAmount > 0 ? $refundAmount : 0,
                "charge" => 0.0,
                "profit" => 0.0,
                "gst" => 0.0,
                "tds" => 0.0,
                'remark' => 'Refund for cancelled booking',
                'txnid' => $reportTable->id,
                'payid' => $reportTable->payid,
                'status' => 'refunded',
                'user_id' => $reportTable->user_id,
                'credited_by' => $reportTable->user_id,
                'rtype' => 'main',
                'via' => 'portal',
                'balance' => $oldBalance,
                "closing_balance" => $oldBalance + $refundAmount,
                'trans_type' => 'credit',
                'product' => 'bus',
                'transtype' => 'mainwallet',
                "apitxnid" => null,
                "refno" => $reportTable->number,
            ]);


            $up = [
                'booking_status' => 'Cancelled',
                'cancel_req' => $request->all(),
                'cancel_res' => $response,
                'change_request_id' => $response['data']['Response'][0]['ChangeRequestId'],
                'credit_note_no' => $response['data']['Response'][0]['CreditNoteNo'],
                'refunded_amount' => $response['data']['Response'][0]['RefundedAmount'],
                'cancellation_charge' => $response['data']['Response'][0]['CancellationCharge'],
                'cancelled_at' => now(),
            ];
            DB::table('bus_bookings')->where('bus_id', $request->payload['BusId'])->update($up);
        }

        return response()->json($response);
    }

    public function paymentSuccess(Request $request)
    {
        $id = $request->clientRefId ?? $request->txnid ?? $request->orderId ?? $request->id ?? $request->ORDERID ?? $request->ORDER_ID;
        $booking = DB::table('bus_bookings')->where('order_ref_id', $id)->first();
        return view('bus.status')->with(['status' => 'pending', 'message' => 'Payment Received, Finalizing...', 'id' => $id, 'booking' => $booking]);
    }

    public function paymentFailed(Request $request)
    {
        $id = $request->clientRefId ?? $request->txnid ?? $request->orderId ?? $request->id ?? $request->ORDERID ?? $request->ORDER_ID;
        $booking = DB::table('bus_bookings')->where('order_ref_id', $id)->first();
        return view('bus.status')->with(['status' => 'pending', 'message' => 'Payment Received, Finalizing...', 'id' => $id, 'booking' => $booking]);
    }

    public function reviewBooking()
    {
        return view('bus.review_booking');
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

                DB::table('bus_bookings')
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
}
