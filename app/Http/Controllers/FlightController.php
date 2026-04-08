<?php

namespace App\Http\Controllers;


use App\Helpers\AndroidCommonHelper;
use App\Models\Agents;
use App\Models\Api;
use App\Models\Apilog;
use App\Services\AuthService;
use App\Services\FlightService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Carbon\Carbon;
use App\Models\Provider;
use App\Models\Report;

class FlightController extends Controller
{
    protected $tektravels;

    public function __construct(AuthService $tektravels)
    {
        $this->tektravels = $tektravels;
    }

    public function flightBooking()
    {
        return view('flight.booking');
    }
    public function searchCity(Request $request)
    {
        $search = $request->get('query');

        if (strlen($search) < 3) {
            return response()->json([]);
        }

        $cities = DB::table('flightcity')
            ->select('*')
            ->where('airport_name', 'LIKE', "%$search%")
            ->orWhere('city', 'LIKE', "%$search%")
            ->orWhere('airport_code', 'LIKE', "%$search%")
            ->limit(10)
            ->get();

        return response()->json($cities);
    }

    public function searchlist()
    {
        return view('flight.list');
    }

    public function passengerForm()
    {
        $customers = DB::table('customer_list')
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->select(
                'id',
                'first_name',
                'last_name',
                'email',
                'mobile',
                'dob',
                'gender',
                'nationality',
                'address1',
                'address2',
                'city',
                'pan_number',
                'passport_number',
                'passport_expiry'
            )
            ->get();

        return view('flight.passengers', ['customers' => $customers]);
    }

    public function flightdetailslist()
    {
        return view('flight.detail');
    }
    public function seatlayList()
    {
        return view('flight.seatlay');
    }

    public function viewTicket(Request $request)
    {
        $booking = DB::table('bookings')->where('id', $request->booking_id)->first();

        if (!$booking) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Booking Details not found'
            ]);
        }
        $service = new FlightService();
        $response = $service->getDetailsFlight($booking);

        return response()->json($response);
    }

    public function bookingList(Request $request)
    {
        if (\Myhelper::hasRole('admin')) {
            $data['totalonewaylcc'] = DB::table('bookings')->where('payment_status', 'success')->where('is_lcc', 'true')->where('journey_type', 'oneway')->sum('total_amount');
            $data['totalonewaylccCount'] = DB::table('bookings')->where('payment_status', 'success')->where('is_lcc', 'true')->where('journey_type', 'oneway')->count();
            $data['totalonewaynonlcc'] = DB::table('bookings')->where('payment_status', 'success')->where('is_lcc', 'false')->where('journey_type', 'oneway')->sum('total_amount');
            $data['totalonewaynonlccCount'] = DB::table('bookings')->where('payment_status', 'success')->where('is_lcc', 'false')->where('journey_type', 'oneway')->count();

            $data['totalroundtriplcc'] = DB::table('bookings')->where('payment_status', 'success')->where('is_lcc', 'true')->where('journey_type', 'roundtrip')->sum('total_amount');
            $data['totalroundtriplccCount'] = DB::table('bookings')->where('payment_status', 'success')->where('is_lcc', 'true')->where('journey_type', 'roundtrip')->count();
            $data['totalroundtripnonlcc'] = DB::table('bookings')->where('payment_status', 'success')->where('is_lcc', 'false')->where('journey_type', 'roundtrip')->sum('total_amount');
            $data['totalroundtripnonlccCount'] = DB::table('bookings')->where('payment_status', 'success')->where('is_lcc', 'false')->where('journey_type', 'roundtrip')->count();
        } else {
            $data['totalonewaylcc'] = DB::table('bookings')->where('user_id', auth()->id())->where('payment_status', 'success')->where('is_lcc', 'true')->where('journey_type', 'oneway')->sum('total_amount');
            $data['totalonewaylccCount'] = DB::table('bookings')->where('user_id', auth()->id())->where('payment_status', 'success')->where('is_lcc', 'true')->where('journey_type', 'oneway')->count();
            $data['totalonewaynonlcc'] = DB::table('bookings')->where('user_id', auth()->id())->where('payment_status', 'success')->where('is_lcc', 'false')->where('journey_type', 'oneway')->sum('total_amount');
            $data['totalonewaynonlccCount'] = DB::table('bookings')->where('user_id', auth()->id())->where('payment_status', 'success')->where('is_lcc', 'false')->where('journey_type', 'oneway')->count();

            $data['totalroundtriplcc'] = DB::table('bookings')->where('user_id', auth()->id())->where('payment_status', 'success')->where('is_lcc', 'true')->where('journey_type', 'roundtrip')->sum('total_amount');
            $data['totalroundtriplccCount'] = DB::table('bookings')->where('user_id', auth()->id())->where('payment_status', 'success')->where('is_lcc', 'true')->where('journey_type', 'roundtrip')->count();
            $data['totalroundtripnonlcc'] = DB::table('bookings')->where('user_id', auth()->id())->where('payment_status', 'success')->where('is_lcc', 'false')->where('journey_type', 'roundtrip')->sum('total_amount');
            $data['totalroundtripnonlccCount'] = DB::table('bookings')->where('user_id', auth()->id())->where('payment_status', 'success')->where('is_lcc', 'false')->where('journey_type', 'roundtrip')->count();
        }
        // dd($data);
        $userId = \Auth::user()->id;

        $data['bookings'] = DB::table('bookings')
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->where('bookings.user_id', $userId)
            ->select(
                'bookings.*',
                'users.name as user_name',
                'users.email as user_email',
                'users.mobile as user_mobile'
            )
            ->orderBy('bookings.id', 'DESC')
            ->paginate(10);


        if ($request->ajax()) {
            return view('flight.booking-table')->with($data)->render();
        }

        return view('flight.bookinglist')->with($data);
    }

    public function bookingListFailed(Request $request)
    {
        $userId = \Auth::user()->id;

        $bookings = DB::table('failed_bookings_list')
            ->join('users', 'users.id', '=', 'failed_bookings_list.user_id')
            ->where('failed_bookings_list.user_id', $userId)
            ->select(
                'failed_bookings_list.*',
                'users.name as user_name',
                'users.email as user_email',
                'users.mobile as user_mobile'
            )
            ->orderBy('failed_bookings_list.id', 'DESC')
            ->paginate(10);


        if ($request->ajax()) {
            return view('flight.booking-table-failed', compact('bookings'))->render();
        }

        return view('flight.bookinglistfailed', compact('bookings'));
    }

    public function apiLog(Request $request)
    {
        $userId = \Auth::user()->id;
        if (!$userId) {
            return redirect()->route('auth');
        }

        $apilogs = DB::table('apilogs')
            ->orderBy('id', 'DESC')
            ->paginate(10);

        if ($request->ajax()) {
            return view('apilog-table', compact('apilogs'))->render();
        }

        return view('apilog', compact('apilogs'));
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

    public function search(Request $request)
    {
        $service = new FlightService();
        $response = $service->searchFlight($request->all());

        return response()->json($response);
    }

    public function fareRule(Request $request)
    {
        $service = new FlightService();
        $response = $service->fareRuleFlight($request->all());

        return response()->json($response);
    }

    public function fareQuote(Request $request)
    {
        $service = new FlightService();
        $response = $service->fareQuoteFlight($request->all());

        return response()->json($response);
    }

    public function seatdetails(Request $request)
    {
        $service = new FlightService();
        $response = $service->seatLayoutFlight($request->all());

        return response()->json($response);
    }

    public function bookFlight(Request $request)
    {
        do {
            $request['clientRefId'] = AndroidCommonHelper::makeTxnId("FLIGHT", 14);
        } while (Report::where('txnid', $request['clientRefId'])->exists());

        $service = new FlightService();
        $isLcc = ($request->input('islcc') === 'true' || $request->input('islcc') === true || $request->input('isLcc') === true);
        $response = null;

        if (!$isLcc) {
            $response = $service->bookingFlight($request->all());

            if (strtolower($response['status'] ?? '') != 'success') {
                $up = [
                    'user_id'         => \Auth::user()->id,
                    'base_fare'       => $request['passengers'][0]['Fare']['BaseFare'] ?? 0,
                    'tax'             => $request['passengers'][0]['Fare']['Tax'] ?? 0,
                    'total_amount'    => @$request['passengers'][0]['Fare']['PublishedFare'] ?? $request['passengers'][0]['Fare']['BaseFare'] ?? 0,
                    'booking_status'  => $response['status'] ?? 'failed',
                    'message'         => $response['message'] ?? 'Booking Failed',
                    'raw_response'    => json_encode($response),
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ];
                DB::table('failed_bookings_list')->insert($up);

                return response()->json([
                    'status' => $response['status'] ?? 'failed',
                    'message' => $response['message'] ?? 'Flight booking failed!'
                ]);
            }
        }

        $data = $response['data']['Response']['Response'] ?? null;
        $itinerary = $request->input('itinerary');

        if (!$isLcc && !$data) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid Data: Missing API response for non-LCC flight'
            ]);
        }

        $flightDetails = $this->extractFlightDetails($data ?: [], $itinerary ?: [], $request->all());
        
        $booking = array_merge([
            'user_id'         => \Auth::user()->id,
            'pnr'             => $flightDetails['pnr'] ?? 'PENDING',
            'booking_id_api'  => $flightDetails['booking_id_api'] ?? 'PENDING',
            'order_ref_id'    => $request['clientRefId'] ?? $response['clientRefId'] ?? null,
            'payment_status'  => 'pending',
            'booking_status'  => 'Pending',
            'ticket_status'   => 'pending',
            'raw_payload'     => json_encode($request->all()),
            'raw_response'    => json_encode($response['data'] ?? $itinerary ?? []),
            'created_at'      => now(),
            'updated_at'      => now(),
        ], $flightDetails);

        if (!$isLcc) {
            try {
                DB::table('bookings')->insert($booking);
            } catch (\Exception $e) {
                \Log::error('Flight booking insertion failed: ' . $e->getMessage());
                return response()->json(['status' => 'failed', 'message' => 'Failed to save booking record']);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Flight ' . ($isLcc ? 'ready for payment' : 'booked successfully'),
            'data' => $response['data'] ?? $itinerary
        ]);
    }

    private function calculateTotalFromPassengers($passengers)
    {
        $totalBaseFare = 0;
        $totalTax = 0;
        $totalSeat = 0;
        $totalBaggage = 0;
        $totalMeal = 0;
        $grandTotal = 0;

        foreach ($passengers as $pax) {

            $baseFare = $pax['Fare']['BaseFare'] ?? 0;
            $tax = $pax['Fare']['Tax'] ?? 0;

            $seatPrice = $this->getSSRPrice($pax['SeatDynamic'] ?? []);
            $baggagePrice = $this->getSSRPrice($pax['Baggage'] ?? []);
            $mealPrice = $this->getSSRPrice($pax['Meal'] ?? []);

            $totalBaseFare += $baseFare;
            $totalTax += $tax;
            $totalSeat += $seatPrice;
            $totalBaggage += $baggagePrice;
            $totalMeal += $mealPrice;

            $grandTotal += ($baseFare + $tax + $seatPrice + $baggagePrice + $mealPrice);
        }

        return [
            'totalBaseFare' => $totalBaseFare,
            'totalTax' => $totalTax,
            'totalSeat' => $totalSeat,
            'totalBaggage' => $totalBaggage,
            'totalMeal' => $totalMeal,
            'grandTotal' => $grandTotal
        ];
    }

    private function getSSRPrice($data)
    {
        $total = 0;

        if (empty($data)) {
            return 0;
        }
        if (isset($data[0])) {
            foreach ($data as $item) {
                $total += $item['Price'] ?? 0;
            }
        } else {
            $total += $data['Price'] ?? 0;
        }

        return $total;
    }

    public function flightTicket(Request $request)
    {
        $user = \Auth::user();

        if ($user->status !== 'active') {
            return response()->json(['status' => 'failed', 'message' => 'Your account has been blocked.']);
        }

        /*
        try {
            DB::beginTransaction();

            $user = User::where('id', $user->id)->lockForUpdate()->first();

            $lockedBalance = AndroidCommonHelper::getLockedBalance();

            $totals = $this->calculateTotalFromPassengers($request->passengers);

            $totalAmount = $totals['grandTotal'];

            if ($user->mainwallet < ($totalAmount + $lockedBalance['mainLockedBalance'])) {
                DB::rollBack();
                return response()->json([
                    'status' => 'balance_low',
                    'message' => 'Low Balance, Kindly recharge your wallet.'
                ]);
            }
            // HER CHEKC IF CLEINT REF ID PARTICUALR TRACE ID KE LIYE H TOH WHI JAYE NHI TOH NEW GENRATE HO

            if (empty($request['clientRefId'])) {
                do {
                    $request['clientRefId'] = AndroidCommonHelper::makeTxnId("FLIGHT", 14);
                } while (Report::where('txnid', $request['clientRefId'])->exists());
            } else {
                $request['clientRefId'] = $request['clientRefId'];
            }

            $provider = Provider::where('recharge1', 'flighttravel')->firstOrFail();



            $request['profit']       = 0;
            $request['debitAmount']  = $totalAmount;

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
                'amount'      => $totalAmount,
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
                'product'     => 'flighttravel',
                'transtype'   => 'mainwallet',
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            \Log::error('Flight booking pre-api failed', [
                'user_id' => $user->id,
                'error'   => $e->getMessage()
            ]);

            return response()->json([
                'status'  => 'failed',
                'message' => 'Transaction failed, please try again.'
            ]);
        }

        $service = new FlightService();
        $response = $service->FlightTicketView($request->all());
        */

        $api = Api::where('code', 'rrpayment')->first();
        if (!$api) {
            return response()->json(['status' => 'failed', 'message' => "PG service is down"]);
        }

        $agent = Agents::where('user_id', \Auth::id())->first();
        if (!$agent) {
             $agent = Agents::where('user_id', 1)->first(); 
        }

        $clientRefId = AndroidCommonHelper::makeTxnId("FLIGHT", 10);
        $url = $api->url . "v1/service/pgcollect/jio/order/generate";
        
        $header = [
            "Content-Type: application/json",
            "Authorization: Basic " . base64_encode($api->username . ":" . $api->password)
        ];

        $totals = $this->calculateTotalFromPassengers($request->all()['passengers'] ?? []);
        $totalAmount = $totals['grandTotal'];

        $reqData = [
            "email"        => $user->email,
            "name"         => $user->name,
            "merchantCode" => $agent->bc_id ?? "MID73323213401",
            "clientRefId"  => $clientRefId,
            "mobile"       => $user->mobile,
            "redirectUrl"  => route('flight.payment.success'),
            "successUrl"  => route('flight.payment.success'),
            "failedUrl"   => route('flight.payment.failed'),
            "amount"       => 1
            // "amount"       => $totalAmount
        ];

        $result = \Myhelper::curl($url, "POST", json_encode($reqData), $header, "yes");
       
        if ($result['response'] != '') {
            $responseStatus = json_decode($result['response']);
           
            if (isset($responseStatus->code) && $responseStatus->code == "0x0200") {
                $tid = $request->input('traceId', $request->input('TraceId'));
                
                $affected = DB::table('bookings')
                    ->where('booking_id_api', $tid)
                    ->update([
                        'order_ref_id' => $clientRefId,
                        'raw_payload'  => json_encode($request->all())
                    ]);

                Report::create([
                    'number'      => $tid,
                    'mobile'      => $user->mobile,
                    'provider_id' => 0,
                    'api_id'      => 0,
                    'amount'      => 1,
                    // 'amount'      => $totalAmount,
                    'profit'      => 0,
                    'txnid'       => $clientRefId,
                    'payid'       => $clientRefId,
                    'status'      => 'pending',
                    'user_id'     => $user->id,
                    'credited_by' => $user->id,
                    'rtype'       => 'main',
                    'via'         => 'portal',
                    'balance'     => $user->mainwallet,
                    'trans_type'  => 'debit',
                    'product'     => 'flighttravel',
                    'transtype'   => 'pg',
                    'description' => json_encode($request->all()),
                ]);
                return response()->json([
                    'status' => 'SUCCESS',
                    'url'    => $responseStatus->data->url,
                    'message' => 'Order created successful.',
                    'data'   => $responseStatus->data
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

    public function paymentSuccess(Request $request)
    {
        \Log::info("Flight Payment Success Request:", $request->all());
        $id = $request->clientRefId ?? $request->txnid ?? $request->orderId ?? $request->id ?? $request->ORDERID ?? $request->ORDER_ID;
        return view('flight.status')->with(['status' => 'success', 'message' => 'Payment Successful', 'id' => $id]);
    }

    public function paymentFailed(Request $request)
    {
        \Log::info("Flight Payment Failed Request:", $request->all());
        $id = $request->clientRefId ?? $request->txnid ?? $request->orderId ?? $request->id ?? $request->ORDERID ?? $request->ORDER_ID;
        return view('flight.status')->with(['status' => 'failed', 'message' => 'Payment Failed', 'id' => $id]);
    }

    public function checkStatus(Request $request)
    {
        $id = $request->id;
        $booking = DB::table('bookings')->where('order_ref_id', $id)->first();
        $report  = Report::where('txnid', $id)->first();

        if (!$booking && !$report) {
            return response()->json(['status' => 'failed', 'message' => 'Booking not found']);
        }


        if ($booking && $booking->payment_status === 'success') {
            return response()->json([
                'status' => 'success',
                'booking_status' => 'Confirmed',
                'data' => $booking
            ]);
        }

        // Check with PG
        $api = Api::where('code', 'orpayment')->first();

        if (!$api) {
            return response()->json(['status' => 'failed', 'message' => 'PG API not found']);
        }

        $url = rtrim($api->url, '/') . '/v1/service/paycc/order/' . $id;

        $auth = base64_encode(trim($api->username) . ":" . trim($api->password));
        $header = [
            "Content-Type: application/json",
            "Authorization: Basic " . $auth
        ];

        $result = \Myhelper::curl($url, "GET", "", $header, "yes");

        if ($result['response'] != '') {
            $responseStatus = json_decode($result['response']);

            if ((isset($responseStatus->status) && strtoupper($responseStatus->status) == "SUCCESS") || (isset($responseStatus->code) && $responseStatus->code == "0x0200")) {
                $finalResult = $this->finalizeBooking($booking ?? $report);
                $booking = DB::table('bookings')->where('order_ref_id', $id)->first();
                
                if (!$finalResult['status']) {
                    return response()->json([
                        'status' => 'failed',
                        'booking_status' => $booking ? $booking->payment_status : 'failed',
                        'message' => $finalResult['message'] ?? 'Unable to finalize flight ticket.'
                    ]);
                }
                
                return response()->json([
                    'status' => 'success',
                    'booking_status' => 'Confirmed',
                    'data' => $booking
                ]);
            }

            if (isset($responseStatus->status) && (strtolower($responseStatus->status) == "pending" || strtolower($responseStatus->status) == "failure")) {
                 return response()->json([
                    'status' => strtolower($responseStatus->status),
                    'message' => $responseStatus->message ?? "Transaction " . strtolower($responseStatus->status),
                    'data' => $booking
                ]);
            }
        }

        return response()->json([
            'status' => 'success',
            'booking_status' => $booking ? $booking->payment_status : 'Pending',
            'data' => $booking ?? $report
        ]);
    }

    private function finalizeBooking($bookingOrReport)
    {
        $id = $bookingOrReport->id;
        $isReport = !isset($bookingOrReport->booking_id_api);
        
        if ($isReport) {
            $report = $bookingOrReport;
            $booking = DB::table('bookings')->where('order_ref_id', $report->txnid)->first();
            $payload = json_decode($report->description, true);
        } else {
            $booking = $bookingOrReport;
            $report = Report::where('txnid', $booking->order_ref_id)->first();
            $payload = json_decode($booking->raw_payload, true);
        }

        if (!$report) {
            return ['status' => false, 'message' => 'Report record not found.'];
        }

        if ($booking && $booking->payment_status === 'success' && ($booking->ticket_status === 'Successful' || $booking->ticket_status === 'Confirmed')) {
            return ['status' => true, 'message' => 'Already finalized.'];
        }

        try {
            DB::beginTransaction();

            if ($booking) {
                DB::table('bookings')->where('id', $booking->id)->update([
                    'payment_status' => 'success',
                    'total_amount'   => $report->amount,
                    'updated_at'     => now()
                ]);
            }

            $report->update(['status' => 'success']);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return ['status' => false, 'message' => 'DB update failed: ' . $e->getMessage()];
        }

        $ticketingData = [
            'pnr'         => $booking ? $booking->pnr : ($payload['pnr'] ?? 'PENDING'),
            'bookingId'   => $booking ? $booking->booking_id_api : ($payload['traceId'] ?? 'PENDING'),
            'traceId'     => $payload['traceId'] ?? ($booking ? $booking->booking_id_api : 'PENDING'),
            'resultIndex' => $payload['resultIndex'] ?? ($booking ? $booking->result_index : 1),
            'islcc'       => $payload['islcc'] ?? $payload['isLcc'] ?? ($booking ? $booking->is_lcc : 'true'),
            'debitAmount' => $report->amount,
            'clientRefId' => $report->txnid,
            'passengers'  => $payload['passengers'] ?? [],
        ];

        $service = new FlightService();
        $response = $service->FlightTicketView($ticketingData);
        
        $status = "Failed";
        if (isset($response['status']) && strtolower($response['status']) == 'success') {
            $ticketData = $response['data']['Response']['Response'] ?? null;
            $status = "Successful";
            if ($ticketData && isset($ticketData['Status'])) {
                if ($ticketData['Status'] == 1) $status = "Successful";
                else if ($ticketData['Status'] == 2) $status = "Failed";
            }

            $finalUpdate = [
                'pnr'            => $ticketData['PNR'] ?? $ticketingData['pnr'],
                'booking_id_api' => $ticketData['BookingId'] ?? $ticketingData['bookingId'],
                'ticket_status'  => $status,
                'booking_status' => $status,
                'raw_response'   => json_encode($response['data'])
            ];

            if ($booking) {
                DB::table('bookings')->where('id', $booking->id)->update($finalUpdate);
            } else {
                $itinerary = $payload['itinerary'] ?? [];
                $flightDetails = $this->extractFlightDetails([], $itinerary, $payload);
                
                $newBooking = array_merge([
                    'user_id'         => $report->user_id,
                    'pnr'             => $finalUpdate['pnr'],
                    'booking_id_api'  => $finalUpdate['booking_id_api'],
                    'order_ref_id'    => $report->txnid,
                    'is_lcc'          => 'true',
                    'api_type'        => 'ticket',
                    'payment_status'  => 'success',
                    'booking_status'  => $status,
                    'ticket_status'   => $status,
                    'raw_payload'     => json_encode($payload),
                    'raw_response'    => $finalUpdate['raw_response'],
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ], $flightDetails);
                
                $newBooking['total_amount'] = $report->amount;
                
                DB::table('bookings')->insert($newBooking);
            }
            
            return ['status' => true, 'message' => 'Ticket generated successfully.'];
        } else {
            if ($booking) {
                DB::table('bookings')->where('id', $booking->id)->update([
                    'ticket_status'  => 'Failed',
                    'booking_status' => 'Failed'
                ]);
            } else {
                $itinerary = $payload['itinerary'] ?? [];
                $flightDetails = $this->extractFlightDetails([], $itinerary, $payload);
                $newBooking = array_merge([
                    'user_id'         => $report->user_id,
                    'pnr'             => $ticketingData['pnr'],
                    'booking_id_api'  => $ticketingData['bookingId'],
                    'order_ref_id'    => $report->txnid,
                    'is_lcc'          => 'true',
                    'api_type'        => 'ticket',
                    'payment_status'  => 'success',
                    'booking_status'  => 'Failed',
                    'ticket_status'   => 'Failed',
                    'raw_payload'     => json_encode($payload),
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ], $flightDetails);
                
                $newBooking['total_amount'] = $report->amount;
                
                DB::table('bookings')->insert($newBooking);
            }
            return ['status' => false, 'message' => $response['message'] ?? 'Ticketing failed with provider.'];
        }
    }

    private function extractFlightDetails($apiData, $itinerary = [], $request = [])
    {
        $fare = $apiData['FlightItinerary']['Fare'] ?? $itinerary['Fare'] ?? [];
        $seg = $apiData['FlightItinerary']['Segments'] ?? $itinerary['Segments'] ?? [];
        
        $originCode = 'N/A'; $originName = ''; $destCode = 'N/A'; $destName = ''; 
        $airlineCode = 'N/A'; $airlineName = ''; $flightNumber = 'N/A'; $journeyDate = now()->format('Y-m-d H:i:s');
        $journeyTypee = 'oneway';
        $isrefund = 'false';
        $islcc = 'false';

        if ($apiData) {
            $isrefund     = ($apiData['FlightItinerary']['NonRefundable'] ?? false) ? 'true' : 'false';
            $islcc        = ($apiData['FlightItinerary']['IsLCC'] ?? false) ? 'true' : 'false';
            $journeyTypee = (($apiData['FlightItinerary']['JourneyType'] ?? '') == '2') ? 'roundtrip' : 'oneway';
        } else if ($itinerary) {
            $isrefund     = ($itinerary['IsRefundable'] ?? false) ? 'true' : 'false';
            $islcc        = ($itinerary['IsLCC'] ?? false) ? 'true' : 'false';
            $journeyTypee = (($itinerary['JourneyType'] ?? '') == '2' || ($request['journeyType'] ?? '') == '2') ? 'roundtrip' : 'oneway';
        }

        if (!empty($seg)) {
            $segments = $seg[0] ?? null;
            $lastLeg = end($seg);

            if (is_array($segments) && isset($segments[0])) {
                $firstSeg = $segments[0];
                $lastSegInLeg = end($lastLeg);
                $originCode = $firstSeg['Origin']['Airport']['AirportCode'] ?? 'N/A';
                $originName = ($firstSeg['Origin']['Airport']['AirportName'] ?? '') ?: ($firstSeg['Origin']['Airport']['CityName'] ?? '');
                $destCode = $lastSegInLeg['Destination']['Airport']['AirportCode'] ?? 'N/A';
                $destName = ($lastSegInLeg['Destination']['Airport']['AirportName'] ?? '') ?: ($lastSegInLeg['Destination']['Airport']['CityName'] ?? '');
                $airlineCode = $firstSeg['Airline']['AirlineCode'] ?? 'N/A';
                $airlineName = $firstSeg['Airline']['AirlineName'] ?? '';
                $flightNumber = $firstSeg['Airline']['FlightNumber'] ?? 'N/A';
                $journeyDate = $firstSeg['Origin']['DepTime'] ?? now()->format('Y-m-d H:i:s');
            } else if (is_array($segments) && isset($segments['Origin'])) {
                $originCode = $segments['Origin']['Airport']['AirportCode'] ?? 'N/A';
                $originName = ($segments['Origin']['Airport']['AirportName'] ?? '') ?: ($segments['Origin']['Airport']['CityName'] ?? '');
                $lastSeg = end($seg);
                $destCode = $lastSeg['Destination']['Airport']['AirportCode'] ?? 'N/A';
                $destName = ($lastSeg['Destination']['Airport']['AirportName'] ?? '') ?: ($lastSeg['Destination']['Airport']['CityName'] ?? '');
                $airlineCode = $segments['Airline']['AirlineCode'] ?? 'N/A';
                $airlineName = $segments['Airline']['AirlineName'] ?? '';
                $flightNumber = $segments['Airline']['FlightNumber'] ?? 'N/A';
                $journeyDate = $segments['Origin']['DepTime'] ?? now()->format('Y-m-d H:i:s');
            }
        }

        return [
            'origin'        => trim($originCode . "-" . $originName, "- "),
            'destination'   => trim($destCode . "-" . $destName, "- "),
            'airline_code'  => trim($airlineCode . "-" . $airlineName, "- "),
            'flight_number' => $flightNumber,
            'journey_date'  => $journeyDate,
            'journey_type'  => $journeyTypee,
            'base_fare'     => $fare['BaseFare'] ?? 0,
            'tax'           => $fare['Tax'] ?? 0,
            'total_amount'  => $fare['PublishedFare'] ?? 0,
            'is_refundable' => $isrefund,
            'is_lcc'        => $islcc,
        ];
    }

    public function getCancellationCharges(Request $request)
    {
        $service = new FlightService();
        $response = $service->getCancelCharge($request->all());

        return response()->json($response);
    }

    public function cancelPage($id)
    {

        $decoded = json_decode(base64_decode($id), true);

        if (!$decoded) {
            abort(404, 'Invalid Data');
        }

        $booking = DB::table('bookings')->where('booking_id_api', $decoded)->first();

        if (!$booking) {
            abort(404, 'Booking not found');
        }

        return view('flight.cancel', compact('booking'));
    }

    public function submitCancellation(Request $request)
    {
        $bokTable = DB::table('bookings')->where('booking_id_api', $request->payload['BookingId'])->first();

        $responses = json_decode($bokTable->raw_response, true);
        $reportTable = Report::where('number', $responses['TraceId'])->first();

        if (!$reportTable) {
            return response()->json(['status' => 'failed', 'message' => 'Report not found for this booking.']);
        }
        if ($reportTable->status != 'success') {
            return response()->json(['status' => 'failed', 'message' => 'Only successful bookings can be cancelled.']);
        }
        $request['payid'] = $reportTable->payid;

        $service = new FlightService();
        $responseCancel = $service->cancelflight($request->all());


        if (strtolower($responseCancel['status']) == 'success') {
            $changeRequestId = $responseCancel['data']['Response'][0]['ChangeRequestId'];
            $up = [
                'booking_status' => 'CancellationPending',
                'ticket_status' => 'CancellationPending',
                'cancel_req' => $request->all(),
                'cancel_res' => $responseCancel,
                'change_request_id' => $changeRequestId,
                'credit_note_no' => $responseCancel['data']['Response'][0]['TicketId'],
                'cancelled_at' => now(),
            ];
            DB::table('bookings')->where('booking_id_api', $request->payload['BookingId'])->update($up);


            $response = $service->cancelflightStatus($responseCancel['data']['Response'][0], $request);

            if (strtolower($response['status']) == 'success') {
                $refundAmount = (float) $response['data']['Response']['RefundedAmount'] ?? 0.0;
                $cancellationCharge = (float) $response['data']['Response']['CancellationCharge'] ?? 0.0;

                $old = User::select('mainwallet')->where('id', $reportTable->user_id)->first();
                $oldBalance = $old->mainwallet;

                $bookingStatus = 'CancellationPending';
                $stausChng = $response['data']['Response']['ChangeRequestStatus'] ?? 0;
                if ($stausChng == 4 || $stausChng == 6) {
                    $bookingStatus = 'Cancelled';
                } elseif ($stausChng == 5) {
                    $bookingStatus = 'CancelRejected';
                }
                if ($refundAmount > 0 &&  $stausChng == 4) {
                    User::where('id', $reportTable->user_id)
                        ->where('status', 'active')
                        ->increment('mainwallet', $refundAmount);


                    $reportTable->update([
                        'status' => 'reversed',
                        'remark' => 'Booking cancelled, refund initiated.',
                        'refno'  => $bokTable->booking_id_api
                    ]);

                    Report::create([
                        'number'      => $reportTable->number,
                        'mobile'      => $reportTable->mobile,
                        'provider_id' => $reportTable->provider_id,
                        'api_id'      => $reportTable->api_id,
                        'amount'      => $refundAmount > 0 ? $refundAmount : 0,
                        "charge" => 0.0,
                        "profit" => 0.0,
                        "gst" => 0.0,
                        "tds" => 0.0,
                        'remark'      => 'Refund for cancelled booking',
                        'txnid'       => $reportTable->id,
                        'payid'       => $reportTable->payid,
                        'status'      => 'refunded',
                        'user_id'     => $reportTable->user_id,
                        'credited_by' => $reportTable->user_id,
                        'rtype'       => 'main',
                        'via'         => 'portal',
                        'balance'     =>  $oldBalance,
                        "closing_balance" => $oldBalance + $refundAmount,
                        'trans_type'  => 'credit',
                        'product'     => 'flight',
                        'transtype'   => 'mainwallet',
                        "apitxnid" => null,
                        "refno" => $reportTable->number,
                    ]);
                }

                $up = [
                    'booking_status' => $bookingStatus,
                    'ticket_status' => $bookingStatus,
                    'refunded_amount' => $refundAmount,
                    'cancel_res' => $response,
                    'cancellation_charge' => $cancellationCharge ?? 0.0,
                    'cancelled_at' => now(),
                ];
                DB::table('bookings')->where('booking_id_api', $request->payload['BookingId'])->update($up);
            }
            return response()->json($response);
        }

        return response()->json($responseCancel);
    }


    public function checkCancelStatus(Request $request)
    {
        $bokTable = DB::table('bookings')->where('booking_id_api', $request['bookingId'])->first();

        $responses = json_decode($bokTable->raw_response, true);
        $reportTable = Report::where('number', $responses['TraceId'])->first();

        if (!$reportTable) {
            return response()->json(['status' => 'failed', 'message' => 'Report not found for this booking.']);
        }
        // if ($reportTable->status != 'success') {
        //     return response()->json(['status' => 'failed', 'message' => 'Only successful bookings can be checked for cancellation status.']);
        // }
        $request['payid'] = $reportTable->payid;

        $service = new FlightService();

        $response = $service->cancelflightStatus(null, $request);

        if (strtolower($response['status']) == 'success') {
            $refundAmount = (float) $response['data']['Response']['RefundedAmount'] ?? 0.0;
            $cancellationCharge = (float) $response['data']['Response']['CancellationCharge'] ?? 0.0;

            $old = User::select('mainwallet')->where('id', $reportTable->user_id)->first();
            $oldBalance = $old->mainwallet;

            $bookingStatus = 'CancellationPending';
            $stausChng = $response['data']['Response']['ChangeRequestStatus'] ?? 0;
            if ($stausChng == 4 || $stausChng == 6) {
                $bookingStatus = 'Cancelled';
            } elseif ($stausChng == 5) {
                $bookingStatus = 'CancelRejected';
            }
            // if ($refundAmount > 0 &&  $stausChng == 4) {
            //     User::where('id', $reportTable->user_id)
            //         ->where('status', 'active')
            //         ->increment('mainwallet', $refundAmount);


            //     $reportTable->update([
            //         'status' => 'reversed',
            //         'remark' => 'Booking cancelled, refund initiated.',
            //         'refno'  => $bokTable->booking_id_api
            //     ]);

            //     Report::create([
            //         'number'      => $reportTable->number,
            //         'mobile'      => $reportTable->mobile,
            //         'provider_id' => $reportTable->provider_id,
            //         'api_id'      => $reportTable->api_id,
            //         'amount'      => $refundAmount > 0 ? $refundAmount : 0,
            //         "charge" => 0.0,
            //         "profit" => 0.0,
            //         "gst" => 0.0,
            //         "tds" => 0.0,
            //         'remark'      => 'Refund for cancelled booking',
            //         'txnid'       => $reportTable->id,
            //         'payid'       => $reportTable->payid,
            //         'status'      => 'refunded',
            //         'user_id'     => $reportTable->user_id,
            //         'credited_by' => $reportTable->user_id,
            //         'rtype'       => 'main',
            //         'via'         => 'portal',
            //         'balance'     =>  $oldBalance,
            //         "closing_balance" => $oldBalance + $refundAmount,
            //         'trans_type'  => 'credit',
            //         'product'     => 'flight',
            //         'transtype'   => 'mainwallet',
            //         "apitxnid" => null,
            //         "refno" => $reportTable->number,
            //     ]);
            // }

            $up = [
                'booking_status' => $bookingStatus,
                'ticket_status' => $bookingStatus,
                'refunded_amount' => $refundAmount,
                'cancel_res' => $response,
                'cancellation_charge' => $cancellationCharge ?? 0.0,
                'cancelled_at' => now(),
            ];
            DB::table('bookings')->where('booking_id_api', $request['bookingId'])->update($up);
        }
        return response()->json($response);
    }

    public function reviewBooking(){
        return view('flight.review_booking');
    }
}
