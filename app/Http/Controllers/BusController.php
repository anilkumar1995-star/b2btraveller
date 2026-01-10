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

        dd($response);
        return response()->json($response);
    }
    public function bookBus(Request $request)
    {
        $service = new BusService();
        $response = $service->bookBuss($request->all());

        return response()->json($response);
    }
}
