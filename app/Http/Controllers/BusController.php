<?php

namespace App\Http\Controllers;

use App\Models\Apilog;
use App\Services\AuthService;
use App\Services\BusService;
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
        return response()->json($response);
    }
    public function bookBus(Request $request)
    {

        $service = new BusService();
        $response = $service->bookBuss($request->all());

        return response()->json($response);
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
}
