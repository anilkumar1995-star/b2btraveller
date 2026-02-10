<?php

namespace App\Http\Controllers;

use App\Helpers\AndroidCommonHelper;
use App\Models\Apilog;
use App\Models\Bus;
use App\Models\Provider;
use App\Models\Report;
use App\Repo\BillPaymentRepo;
use App\Services\AuthService;
use App\Services\BusService;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BusController extends Controller
{
    protected $tektravels, $billpayrepo;

    //  protected $checkServiceStatus, $api, $table, $billpayrepo, $callIydaBillpay;
    // public function __construct()
    // {
    //     $this->checkServiceStatus = AndroidCommonHelper::CheckServiceStatus('iydabillpayment');
    //     $this->billpayrepo = new BillPaymentRepo;
    //     $this->callIydaBillpay = new IYDABillPayController;
    //     $this->api = Api::where('code', 'paysprintbill')->first();
    //     $this->table = DB::table('billpay_providers');
    // }
    public function __construct(AuthService $tektravels)
    {
        $this->tektravels = $tektravels;
        $this->billpayrepo = new BillPaymentRepo;
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
            'data'    => $response['data'],
            'totalAmount' => $totalAmount
        ]);
    }

    public function bookBus(Request $request)
    {
        $user = \Auth::user();

        if ($user->status !== 'active') {
            return response()->json(['status' => 'failed', 'message' => 'Your account has been blocked.']);
        }

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
                $request['clientRefId'] = AndroidCommonHelper::makeTxnId("BUS", 14);
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

            /* ---------- SUCCESS ---------- */
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


            /* ---------- PENDING ---------- */
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
        // $data['customers'] = DB::table('customer_list')
        //     ->where('user_id', auth()->id())
        //     ->where('status', 'active')
        //     ->get();

        return view('bus.bookinglist', $data);


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
                'refno'  => $bokTable->booking_id_api
            ]);

            // new record created for refund
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
                'product'     => 'bus',
                'transtype'   => 'mainwallet',
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
}
