<?php

namespace App\Http\Controllers;

use App\Models\Apilog;
use App\Services\AuthService;
use App\Services\BusService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BusController extends Controller
{
    protected $tektravels;

    public function __construct(AuthService $tektravels)
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

            $baseFare    = 0;
            $tax         = 0;
            $totalAmount = 0;
            $totalSeats  = 0;

            if (!empty($request->passenger)) {
                foreach ($request->passenger as $p) {
                    $price = $p['Seat']['Price'] ?? [];

                    $baseFare    += $price['BasePrice'] ?? 0;
                    $tax         += $price['Tax'] ?? 0;
                    $totalAmount += $price['PublishedPrice'] ?? 0;
                    $totalSeats++;
                }
            }

            DB::table('failed_bus_bookings_list')->insert([
                'user_id'        => \Auth::id(),
                'base_fare'      => $baseFare,
                'tax'            => $tax,
                'total_amount'   => $totalAmount,
                'booking_status' => 'failed',
                'message'        => $response['message'] ?? 'Bus block failed',
                'raw_response'   => json_encode($response),
                'raw_payload'    => json_encode($request->all()),
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            return response()->json([
                'status'  => 'failed',
                'message' => $response['message'] ?? 'Bus block failed'
            ]);
        }

        $data = $response['data'] ?? null;

        if (!$data || empty($data['Passenger'])) {
            return response()->json([
                'status'  => 'failed',
                'message' => 'Invalid bus block response'
            ]);
        }

        $baseFare     = 0;
        $tax          = 0;
        $totalAmount  = 0;
        $totalSeats   = 0;

        foreach ($data['Passenger'] as $p) {
            $price = $p['Seat']['Price'] ?? [];

            $baseFare    += $price['BasePrice'] ?? 0;
            $tax         += $price['Tax'] ?? 0;
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
            'user_id'        => \Auth::id(),
            'pnr'            => null,
            'booking_id_api' => $data['TraceId'],
            'ticket_no' => $data['TicketNo'] ?? null,
            'bus_id' => $data['BusId'] ?? null,

            'origin'         => $data['BoardingPointdetails']['CityPointLocation'] ?? null,
            'destination'    => $data['DropingPointdetails']['CityPointLocation'] ?? null,
            'travel_name'    => $data['TravelName'] ?? null,
            'service_name'    => $data['ServiceName'] ?? null,
            'bus_type'       => $data['BusType'] ?? null,

            'journey_date'   => $departureTime,
            'departure_time' => $departureTime,
            'arrival_time'   => $arrivalTime,


            'boarding_point' => $data['BoardingPointdetails']['CityPointName'] ?? null,
            'dropping_point' => $data['DropingPointdetails']['CityPointName'] ?? null,
            'total_seats'    => $totalSeats,
            'base_fare'      => $baseFare,
            'tax'            => $tax,
            'total_amount'   => $totalAmount,
            'is_pricechange' => $data['IsPriceChanged'] ? "true" : "false",
            'payment_status' => 'pending',
            'booking_status' => 'blocked',
            'api_type'       => 'block',

            'raw_payload'    => json_encode($request->all()),
            'raw_response'   => json_encode($response),

            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Bus Block successfully',
            'data'    => $response['data']
        ]);
    }

    public function bookBus(Request $request)
    {

        $service = new BusService();
        $response = $service->bookBuss($request->all());

        if (strtolower($response['status'] ?? '') !== 'success') {

            // 1️⃣ Failed table me insert
            DB::table('failed_bus_bookings_list')->insert([
                'user_id'        => \Auth::id(),
                'booking_id_api' => $request->traceId ?? null,
                'booking_status' => 'failed',
                'message'        => $response['message'] ?? 'Bus booking failed',
                'raw_payload'    => json_encode($request->all()),
                'raw_response'   => json_encode($response),
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            // 2️⃣ Main bus_bookings ko failed mark karo
            DB::table('bus_bookings')
                ->where('booking_id_api', $request->traceId)
                ->update([
                    'booking_status' => 'failed',
                    'payment_status' => 'failed',
                    'api_type' => 'book',
                    'updated_at'     => now(),
                ]);

            return response()->json([
                'status'  => 'failed',
                'message' => $response['message'] ?? 'Bus booking failed'
            ]);
        }

        $data = $response['data'] ?? null;

        if (!$data) {
            return response()->json([
                'status'  => 'failed',
                'message' => 'Invalid bus book response'
            ]);
        }

        DB::table('bus_bookings')
            ->where('booking_id_api', $data['TraceId'])
            ->update([
                'ticket_no'       => $data['TicketNo'] ?? null,
                'pnr'    => $data['TravelOperatorPNR'] ?? null,
                'invoice_number' => $data['InvoiceNumber'] ?? null,
                'invoice_amount' => $data['InvoiceAmount'] ?? null,
                'bus_id'          => $data['BusId'] ?? null,

                'booking_status' => $data['BusBookingStatus'] ?? null,
                'payment_status' => 'pending',
                'api_type' => 'book',

                'raw_response'   => json_encode($response),
                'updated_at'     => now(),
            ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Bus Booked successfully',
            'data'    => $data
        ]);
    }


    public function bookingList(Request $request)
    {
        $userId = \Auth::user()->id;

        $data['bookings'] = DB::table('bus_bookings')
            ->join('users', 'users.id', '=', 'bus_bookings.user_id')
            ->where('bus_bookings.user_id', $userId)
            ->select(
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

        return view('bus.bookinglist')->with($data);
    }

    public function bookingListFailed(Request $request)
    {
        $userId = \Auth::user()->id;

        $bookings = DB::table('failed_bus_bookings_list')
            ->join('users', 'users.id', '=', 'failed_bus_bookings_list.user_id')
            ->where('failed_bus_bookings_list.user_id', $userId)
            ->select(
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
        $service = new BusService();
        $response = $service->cancelbus($request->all());

        dd($request, $response);


        return response()->json($response);
    }
}
