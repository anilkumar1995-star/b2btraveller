<?php

namespace App\Http\Controllers;

use App\Services\HotelAuthService;
use App\Services\HotelService;
use Illuminate\Http\Request;

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

    public function viewHotelDetails(){
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

    
}
