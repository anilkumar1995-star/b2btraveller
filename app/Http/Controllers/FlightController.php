<?php

namespace App\Http\Controllers;

use App\Models\Apilog;
use App\Services\AuthService;
use App\Services\FlightService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            ->select('airport_code', 'airport_name', 'city')
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
    public function flightdetailslist()
    {
        return view('flight.detail');
    }
    public function seatlayList()
    {
        return view('flight.seatlay');
    }
    public function bookingList(Request $request)
    {
        $userId = \Auth::user()->id;

        $bookings = DB::table('bookings')
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
            return view('flight.booking-table', compact('bookings'))->render();
        }

        return view('flight.bookinglist', compact('bookings'));
    }

    public function apiLog(Request $request)
    {
        $userId = \Auth::user()->id;
        if(!$userId){
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
        $service = new FlightService();
        $response = $service->bookingFlight($request->all());


        // return response()->json($response);
        if ($response['status'] != 'success') {
            return response()->json([
                'status' => 'failed',
                'message' => 'Flight booking failed!'
            ], 400);
        }

        $data = $response['data']['Response']['Response'] ?? null;


        if (!$data) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid, Something went worng'
            ], 400);
        }


        // Extracting required fields
        $pnr              = $data['PNR'] ?? null;
        $bookingId        = $data['BookingId'] ?? null;
        $islcc        = $data['FlightItinerary']['IsLCC'] ? 'true' : 'false';
        $isrefund        = $data['FlightItinerary']['NonRefundable'] ? 'true' : 'false';
        $fare             = $data['FlightItinerary']['Fare'] ?? [];


        $seg        = $data['FlightItinerary']['Segments'] ?? null;
        $segments         = $seg[0] ?? null;

        // NotSet = 0, Successful = 1, Failed = 2, OtherFare = 3, OtherClass = 4, BookedOther = 5, NotConfirmed = 6]
        $status = "";
        if ($data['Status'] = 0) {
            $status = "Not Set";
        } else  if ($data['Status'] = 1) {
            $status = "Successful";
        } else  if ($data['Status'] = 2) {
            $status = "Failed";
        } else  if ($data['Status'] = 3) {
            $status = "OtherFare";
        } else  if ($data['Status'] = 4) {
            $status = "OtherClass";
        } else  if ($data['Status'] = 5) {
            $status = "BookedOther";
        } else if ($data['Status'] = 6) {
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

        // Fare details
        $baseFare         = $fare['BaseFare'] ?? 0;
        $tax              = $fare['Tax'] ?? 0;
        $totalAmount      = ($fare['PublishedFare'] ?? 0);

        // Store in DB
        $booking = [
            'user_id'         => \Auth::user()->id,
            'pnr'             => $pnr,
            'booking_id_api'  => $bookingId,
            'origin'          => $origin . "-" .  $originName,
            'destination'     => $destination . "-" .  $destinationName,
            'airline_code'    => $airlineCode . "-" .  $airlineName,
            'flight_number'   => $flightNumber,
            'journey_date'    => $journeyDate,

            'base_fare'       => $baseFare,
            'tax'             => $tax,
            'total_amount'    => $totalAmount,
            'is_refundable'    => $isrefund,
            'is_lcc'    => $islcc,

            'payment_status'  => 'success',
            'booking_status'  => $status,

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

     public function flightTicket(Request $request)
    {
        $service = new FlightService();
        $response = $service->FlightTicketView($request->all());
// dd($response);
        return response()->json($response);
    }
}
