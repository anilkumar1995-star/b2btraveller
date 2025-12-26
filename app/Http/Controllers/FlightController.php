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
        $service = new FlightService();
        $response = $service->bookingFlight($request->all());

        if (strtolower($response['status']) != 'success') {
            $up = [
                'user_id'         => \Auth::user()->id,
                'base_fare'       => $request['passengers'][0]['Fare']['BaseFare'],
                'tax'             => $request['passengers'][0]['Fare']['Tax'],
                'total_amount'    => $request['passengers'][0]['Fare']['PublishedFare'],
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
            ], 400);
        }

        $data = $response['data']['Response']['Response'] ?? null;


        if (!$data) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid Data, Something went worng'
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

            'payment_status'  => 'success',
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

    public function flightTicket(Request $request)
    {
        $service = new FlightService();
        $response = $service->FlightTicketView($request->all());

        if (strtolower($response['status']) != 'success') {
            $up = [
                'user_id'         => \Auth::user()->id,
                'base_fare'       => $request['passengers'][0]['Fare']['BaseFare'],
                'tax'             => $request['passengers'][0]['Fare']['Tax'],
                'total_amount'    => $request['passengers'][0]['Fare']['PublishedFare'],
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
                    'ticket_status'   => 'confirmed',
                    'api_type'        => 'ticket',
                    'raw_response'    => json_encode($response['data']),
                    'updated_at'      => now(),
                ]);
        } else {
            $booking = [
                'user_id'         => \Auth::user()->id,
                'pnr'             => $pnr,
                'booking_id_api'  => $bookingId,
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

                'payment_status'  => 'success',
                'booking_status'  => $status,
                'ticket_status' => 'confirmed',
                'api_type' => 'ticket',
                'raw_response'    => json_encode($response['data']),
                'raw_payload'     => json_encode($request->all()),
                'created_at'      => now(),
                'updated_at'      => now(),
            ];
            DB::table('bookings')->insert($booking);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Flight Ticket Done Successfully',
            'data' => $response['data']
        ]);
        // return response()->json($response);
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
        $service = new FlightService();
        $response = $service->cancelflight($request->all());

        return response()->json($response);
    }
}
