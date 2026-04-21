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
                $request['clientRefId'] = AndroidCommonHelper::makeTxnId("HOTEL", 14);
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
        // dd($data);
        $userId = \Auth::user()->id;

        $data['bookings'] = DB::table('hotel_bookings')
            ->join('users', 'users.id', '=', 'hotel_bookings.user_id')
            ->where('hotel_bookings.user_id', $userId)
            ->select(
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
        $userId = \Auth::user()->id;

        $bookings = DB::table('failed_hotel_bookings_list')
            ->join('users', 'users.id', '=', 'failed_hotel_bookings_list.user_id')
            ->where('failed_hotel_bookings_list.user_id', $userId)
            ->select(
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

    public function viewTicket(Request $request)
    {
        $booking = DB::table('hotel_bookings')->where('hotel_id', $request->data['BookingId'])->first();

        if (!$booking) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Booking Details not found'
            ]);
        }
        $service = new HotelService();
        $response = $service->getDetailsHotel($booking->hotel_id);

        return response()->json($response);
    }
}
