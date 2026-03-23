<?php

namespace App\Http\Controllers;


use App\Helpers\AndroidCommonHelper;
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
        $response = $service->bookingFlight($request->all());

        if (strtolower($response['status']) != 'success') {
            $up = [
                'user_id'         => \Auth::user()->id,
                'base_fare'       => $request['passengers'][0]['Fare']['BaseFare'],
                'tax'             => $request['passengers'][0]['Fare']['Tax'],
                'total_amount'    => @$request['passengers'][0]['Fare']['PublishedFare'] ?? $request['passengers'][0]['Fare']['BaseFare'],
                'booking_status'  => $response['status'],
                'message'         => $response['message'],
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

        $data = $response['data']['Response']['Response'] ?? null;


        if (!$data) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid Data, Something went worng'
            ]);
        }


        // Extracting required fields
        $pnr              = $data['PNR'] ?? null;
        $bookingId        = $data['BookingId'] ?? null;
        $islcc        = $data['FlightItinerary']['IsLCC'] ? 'true' : 'false';
        $isrefund        = $data['FlightItinerary']['NonRefundable'] ? 'true' : 'false';
        $fare             = $data['FlightItinerary']['Fare'] ?? [];


        $seg        = $data['FlightItinerary']['Segments'] ?? null;
        $segments         = $seg[0] ?? null;

        $status = "";
        if ($data['Status'] == 0) {
            $status = "Not Set";
        } else  if ($data['Status'] == 1) {
            $status = "Successful";
        } else  if ($data['Status'] == 2) {
            $status = "Failed";
        } else  if ($data['Status'] == 3) {
            $status = "OtherFare";
        } else  if ($data['Status'] == 4) {
            $status = "OtherClass";
        } else  if ($data['Status'] == 5) {
            $status = "BookedOther";
        } else if ($data['Status'] == 6) {
            $status = "NotConfirmed";
        }

        // segment length

        $lastSegment = $seg[count($seg) - 1];


        // Flight Details
        $origin           = $segments['Origin']['Airport']['AirportCode'] ?? null;
        $originName           = $segments['Origin']['Airport']['AirportName'] ?? null;
        $destination = $lastSegment['Destination']['Airport']['AirportCode'] ?? null;
        $destinationName = $lastSegment['Destination']['Airport']['AirportName'] ?? null;

        $airlineCode      = $segments['Airline']['AirlineCode'] ?? null;
        $airlineName      = $segments['Airline']['AirlineName'] ?? null;

        $flightNumber     = $segments['Airline']['FlightNumber'] ?? null;
        $journeyDate      = $segments['Origin']['DepTime'] ?? null;
        $journeyTypee     = $data['FlightItinerary']['JourneyType'] == '2' ? 'roundtrip' : 'oneway';

        // Fare details
        $baseFare         = $fare['BaseFare'] ?? 0;
        $tax              = $fare['Tax'] ?? 0;
        $totalAmount      = ($fare['PublishedFare'] ?? 0);


        $booking = [
            'user_id'         => \Auth::user()->id,
            'pnr'             => $pnr,
            'booking_id_api'  => $bookingId,
            'order_ref_id'    => $request['clientRefId'] ?? $response['clientRefId'] ?? null,
            'origin'          => $origin . "-" .  $originName,
            'destination'     => $destination . "-" .  $destinationName,
            'airline_code'    => $airlineCode . "-" .  $airlineName,
            'flight_number'   => $flightNumber,
            'journey_date'    => $journeyDate,
            'journey_type'    => $journeyTypee,
            'raw_payload'     => json_encode($request->all()),
            'base_fare'       => $baseFare,
            'tax'             => $tax,
            'total_amount'    => $totalAmount,
            'is_refundable'    => $isrefund,
            'is_lcc'    => $islcc,
            'api_type' => 'book',

            'payment_status'  => 'pending',
            'booking_status'  => $status,
            'ticket_status' => 'pending',
            'raw_response'    => json_encode($response['data']),

            'created_at'      => now(),
            'updated_at'      => now(),
        ];

        DB::table('bookings')->insert($booking);

        return response()->json([
            'status' => 'success',
            'message' => 'Flight Booking Successfully',
            'data' => $response['data']
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

        $api = \App\Models\Api::where('code', 'rrpayment')->first();
        if (!$api) {
            return response()->json(['status' => 'failed', 'message' => "PG service is down"]);
        }

        $agent = \App\Models\Agents::where('user_id', \Auth::id())->first();
        if (!$agent) {
             $agent = \App\Models\Agents::where('user_id', 1)->first(); 
        }

        $clientRefId = AndroidCommonHelper::makeTxnId("FLIGHT", 10);
        $url = $api->url . "v1/service/pgcollect/order";
        
        $header = [
            "Content-Type: application/json",
            "Authorization: Basic " . base64_encode($api->username . ":" . $api->password)
        ];

        $totals = $this->calculateTotalFromPassengers($request->all()['passengers'] ?? []);
        $totalAmount = $totals['grandTotal'];

        $reqData = [
            "email"        => $user->email,
            "name"         => $user->name,
            "merchantCode" => $agent->bc_id ?? "MID7332321140",
            "clientRefId"  => $clientRefId,
            "mobile"       => $user->mobile,
            "successUrl"  => route('flight.payment.success'),
            "failedUrl"   => route('flight.payment.failed'),
            "amount"       => $totalAmount
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
                    'amount'      => $totalAmount,
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
        $id = $request->clientRefId ?? $request->txnid;
        return view('flight.status')->with(['status' => 'success', 'message' => 'Payment Successful', 'id' => $id]);
    }

    public function paymentFailed(Request $request)
    {
        $id = $request->clientRefId ?? $request->txnid;
        return view('flight.status')->with(['status' => 'failed', 'message' => 'Payment Failed', 'id' => $id]);
    }

    public function checkStatus(Request $request)
    {
        $booking = DB::table('bookings')->where('order_ref_id', $request->id)->first();
        if ($booking) {
            return response()->json([
                'status' => 'success',
                'booking_status' => $booking->payment_status == 'success' ? 'Confirmed' : $booking->payment_status,
                'data' => $booking
            ]);
        }
        return response()->json(['status' => 'failed', 'message' => 'Booking not found']);
    }

        /*
        try {
            DB::beginTransaction();
            if (strtolower($response['status'] ?? '') == 'failed' || strtolower($response['status'] ?? '') == 'failure') {

                User::where('id', $user->id)->increment('mainwallet', $request->debitAmount);

                Report::where('id', $report->id)->update([
                    'status' => 'failed',
                    'refno'  => $request->traceId,
                ]);

                DB::table('failed_bookings_list')->insert([
                    'user_id'         => \Auth::user()->id,
                    'base_fare'       => $request['passengers'][0]['Fare']['BaseFare'],
                    'tax'             => $request['passengers'][0]['Fare']['Tax'],
                    'total_amount'    => @$request['passengers'][0]['Fare']['PublishedFare'] ?? $request['passengers'][0]['Fare']['BaseFare'],
                    'booking_status'  => $response['status'],
                    'message'         => $response['message'],
                    'raw_response'    => json_encode($response),
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);



                DB::table('bookings')
                    ->where('booking_id_api', $request->traceId)
                    ->update([
                        'booking_status' => 'failed',
                        'payment_status' => 'failed',
                        'api_type' => 'ticket',
                        'updated_at'     => now(),
                    ]);

                DB::commit();

                return response()->json([
                    'status' => $response['status'] ?? 'failed',
                    'message' => $response['message'] ?? 'Flight booking failed!'
                ]);
            }

            // ---------- SUCCESS ----------
            if (strtolower($response['status'] ?? '') == 'success') {

                $data = $response['data']['Response']['Response'] ?? null;

                if (!$data) {
                    throw new Exception('Invalid API response');
                }

                Report::where('id', $report->id)->update([
                    'status' => 'success',
                    'refno'  => $response['data']['TraceId'],
                ]);


                $pnr         = $data['PNR'] ?? null;
                $bookingId   = $data['BookingId'] ?? null;
                $islcc       = $data['FlightItinerary']['IsLCC'] ? 'true' : 'false';
                $isrefund    = $data['FlightItinerary']['NonRefundable'] ? 'true' : 'false';
                $fare        = $data['FlightItinerary']['Fare'] ?? [];
                $seg         = $data['FlightItinerary']['Segments'] ?? null;
                $segments    = $seg[0] ?? null;


                $status = "";

                if ($islcc == "true") {
                    if ($data['Status'] == 0) {
                        $status = "Not Set";
                    } else  if ($data['Status'] == 1) {
                        $status = "Successful";
                    } else  if ($data['Status'] == 2) {
                        $status = "Failed";
                    } else  if ($data['Status'] == 3) {
                        $status = "OtherFare";
                    } else  if ($data['Status'] == 4) {
                        $status = "OtherClass";
                    } else  if ($data['Status'] == 5) {
                        $status = "BookedOther";
                    } else if ($data['Status'] == 6) {
                        $status = "NotConfirmed";
                    }
                } else {
                    $status = "Successful";
                }

                $ticketstatus = "";
                if ($data['TicketStatus'] == 0) {
                    $ticketstatus = "Failed";
                } else  if ($data['TicketStatus'] == 1) {
                    $ticketstatus = "Successful";
                } else  if ($data['TicketStatus'] == 2) {
                    $ticketstatus = "NotSaved";
                } else  if ($data['TicketStatus'] == 3) {
                    $ticketstatus = "NotCreated";
                } else  if ($data['TicketStatus'] == 4) {
                    $ticketstatus = "NotAllowed";
                } else  if ($data['TicketStatus'] == 5) {
                    $ticketstatus = "InProgress";
                } else if ($data['TicketStatus'] == 6) {
                    $ticketstatus = "TicketeAlreadyCreated";
                } else if ($data['TicketStatus'] == 8) {
                    $ticketstatus = "PriceChanged";
                } else if ($data['TicketStatus'] == 9) {
                    $ticketstatus = "OtherError";
                }

                // segment length

                $lastSegment = $seg[count($seg) - 1];


                // Flight Details
                $origin           = $segments['Origin']['Airport']['AirportCode'] ?? null;
                $originName           = $segments['Origin']['Airport']['AirportName'] ?? null;
                $destination = $lastSegment['Destination']['Airport']['AirportCode'] ?? null;
                $destinationName = $lastSegment['Destination']['Airport']['AirportName'] ?? null;

                $airlineCode      = $segments['Airline']['AirlineCode'] ?? null;
                $airlineName      = $segments['Airline']['AirlineName'] ?? null;

                $flightNumber     = $segments['Airline']['FlightNumber'] ?? null;
                $journeyDate      = $segments['Origin']['DepTime'] ?? null;
                $journeyTypee     = $data['FlightItinerary']['JourneyType'] == '2' ? 'roundtrip' : 'oneway';

                // Fare details
                $baseFare         = $fare['BaseFare'] ?? 0;
                $tax              = $fare['Tax'] ?? 0;
                $totalAmount      = ($fare['PublishedFare'] ?? 0);

                // Store in DB
                $existingBooking = DB::table('bookings')
                    ->where('booking_id_api', $bookingId)
                    ->where('pnr', $pnr)
                    ->first();

                if ($existingBooking) {
                    $up = DB::table('bookings')
                        ->where('booking_id_api', $existingBooking->booking_id_api)
                        ->where('pnr', $existingBooking->pnr)
                        ->update([
                            'base_fare'       => $baseFare,
                            'tax'             => $tax,
                            'total_amount'    => $totalAmount,
                            'ticket_status'   => $ticketstatus,
                            'api_type'        => 'ticket',
                            'raw_response'    => json_encode($response['data']),
                            'updated_at'      => now(),
                        ]);
                } else {
                    $booking = [
                        'user_id'         => \Auth::user()->id,
                        'pnr'             => $pnr,
                        'booking_id_api'  => $bookingId,
                        'order_ref_id'  => $request->clientRefId ?? null,
                        'origin'          => $origin . "-" .  $originName,
                        'destination'     => $destination . "-" .  $destinationName,
                        'airline_code'    => $airlineCode . "-" .  $airlineName,
                        'flight_number'   => $flightNumber,
                        'journey_date'    => $journeyDate,
                        'journey_type'    => $journeyTypee,
                        'base_fare'       => $baseFare,
                        'tax'             => $tax,
                        'total_amount'    => $totalAmount,
                        'is_refundable'    => $isrefund,
                        'is_lcc'    => $islcc,

                        'payment_status'  => 'pending',
                        'booking_status'  => $status,
                        'ticket_status' => $ticketstatus,
                        'api_type' => 'ticket',
                        'raw_response'    => json_encode($response['data']),
                        'raw_payload'     => json_encode($request->all()),
                        'created_at'      => now(),
                        'updated_at'      => now(),
                    ];
                    DB::table('bookings')->insert($booking);
                }


                DB::commit();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Flight Ticket Done Successfully',
                    'data' => $response['data']
                ]);
            }


            // ---------- PENDING ----------
            Report::where('id', $report->id)->update([
                'status' => 'pending',
                'refno'  => $request->traceId,
            ]);

            DB::table('bookings')
                ->where('booking_id_api', $request->traceId)
                ->update([
                    'booking_status' => 'pending',
                    'payment_status' => 'pending',
                    'api_type' => 'ticket',
                    'updated_at'     => now(),
                ]);

            DB::commit();

            return response()->json([
                'status'  => 'pending',
                'message' => $response['message'] ?? 'Flight booking pending'
            ]);
        }
    }
*/


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

    // public function submitCancellation(Request $request)
    // {
    //     $bokTable = DB::table('bookings')->where('booking_id_api', $request->payload['BookingId'])->first();

    //     $responses = json_decode($bokTable->raw_response, true);
    //     $reportTable = Report::where('number', $responses['TraceId'])->first();

    //     if (!$reportTable) {
    //         return response()->json(['status' => 'failed', 'message' => 'Report not found for this booking.']);
    //     }
    //     if ($reportTable->status != 'success') {
    //         return response()->json(['status' => 'failed', 'message' => 'Only successful bookings can be cancelled.']);
    //     }
    //     $request['payid'] = $reportTable->payid;

    //     $service = new FlightService();
    //     $response = $service->cancelflight($request->all());


    //     if ($response['status'] == 'success') {


    //         $refundAmount = (float) $request->payload['RefundAmount'] ?? 0.0;
    //         $old = User::select('mainwallet')->where('id', $reportTable->user_id)->first();
    //         $oldBalance = $old->mainwallet;
    //         if ($refundAmount > 0) {
    //             User::where('id', $reportTable->user_id)
    //                 ->where('status', 'active')
    //                 ->increment('mainwallet', $refundAmount);
    //         }

    //         $reportTable->update([
    //             'status' => 'reversed',
    //             'remark' => 'Booking cancelled, refund initiated.',
    //             'refno'  => $bokTable->booking_id_api
    //         ]);

    //         Report::create([
    //             'number'      => $reportTable->number,
    //             'mobile'      => $reportTable->mobile,
    //             'provider_id' => $reportTable->provider_id,
    //             'api_id'      => $reportTable->api_id,
    //             'amount'      => $refundAmount > 0 ? $refundAmount : 0,
    //             "charge" => 0.0,
    //             "profit" => 0.0,
    //             "gst" => 0.0,
    //             "tds" => 0.0,
    //             'remark'      => 'Refund for cancelled booking',
    //             'txnid'       => $reportTable->id,
    //             'payid'       => $reportTable->payid,
    //             'status'      => 'refunded',
    //             'user_id'     => $reportTable->user_id,
    //             'credited_by' => $reportTable->user_id,
    //             'rtype'       => 'main',
    //             'via'         => 'portal',
    //             'balance'     =>  $oldBalance,
    //             "closing_balance" => $oldBalance + $refundAmount,
    //             'trans_type'  => 'credit',
    //             'product'     => 'flight',
    //             'transtype'   => 'mainwallet',
    //             "apitxnid" => null,
    //             "refno" => $reportTable->number,
    //         ]);


    //         $up = [
    //             'booking_status' => 'Cancelled',
    //             'ticket_status' => 'Cancelled',
    //             'cancel_req' => $request->all(),
    //             'cancel_res' => $response,
    //             'change_request_id' => $response['data']['Response'][0]['ChangeRequestId'],
    //             'credit_note_no' => $response['data']['Response'][0]['TicketId'],
    //             'refunded_amount' => $refundAmount,
    //             'cancellation_charge' => $request->payload['CancellationCharge'] ?? 0.0,
    //             'cancelled_at' => now(),
    //         ];
    //         DB::table('bookings')->where('booking_id_api', $request->payload['BookingId'])->update($up);
    //     }

    //     return response()->json($response);
    // }
}
