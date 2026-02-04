<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Apilog;
use App\Models\User;
use App\Models\Report;
use App\Models\Api;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FundCallBackController extends Controller
{
    public function callback(Request $post, $api)
    {
        $url = $post->fullUrl() ?? 'Easebuzz Upi Collect Callback URL';
        $modal = 'Easebuzz Upi Collect Callback';
        $txn = null;
        $utr = null;

        try {
            $data = $post->all();

            switch ($api) {
                case 'eb':
                    if ($data['event'] === 'TRANSACTION_CREDIT') {
                        $txn = $data['data'];

                        $virtualAccountId = $txn['virtual_account']['id'] ?? null;
                        $userId = DB::table('user_van_accounts')->where('account_id', $virtualAccountId)->value('user_id');
                        if ($userId !== null) {
                            DB::table('fund_recieved_callback')->updateOrInsert(
                                ['fund_id' => $txn['id']],
                                [
                                    'event' => $data['event'],
                                    'user_id' => $userId,
                                    'remitter_full_name' => $txn['remitter_full_name'] ?? null,
                                    'remitter_account_number' => $txn['remitter_account_number'] ?? null,
                                    'remitter_ifsc' => $txn['remitter_account_ifsc'] ?? null,
                                    'remitter_phone_number' => $txn['remitter_phone_number'] ?? null,
                                    'utr' => $txn['unique_transaction_reference'] ?? null,
                                    'payment_mode' => $txn['payment_mode'] ?? null,
                                    'amount' => $txn['amount'] ?? 0,
                                    'fee' => '5',
                                    'tax' => '0.50',
                                    'narration' => $txn['narration'] ?? null,
                                    'status' => $txn['status'] ?? null,
                                    'transaction_date' => $txn['transaction_date'] ?? null,
                                    'virtual_account_id' => $txn['virtual_account']['id'] ?? null,
                                    'label' => $txn['virtual_account']['label'] ?? null,
                                    'virtual_account_number' => $txn['virtual_account']['virtual_account_number'] ?? null,
                                    'virtual_ifsc_number' => $txn['virtual_account']['virtual_ifsc_number'] ?? null,
                                ]
                            );

                            $check = Report::where('txnid', $txn['unique_transaction_reference'])->count();
                            if ($check == 0) {
                                $user = User::where('id', $userId)->first();
                                if ($user) {
                                    $opening_balance = $user->mainwallet;
                                    User::where('id', $userId)->increment('mainwallet', $txn['amount']);
                                    $closing_balance = $opening_balance + $txn['amount'];
                                    
                                    $fundapi = Api::where('code', 'fund')->first();
                                    $insert = [
                                        'number' => $user->mobile,
                                        'mobile' => $user->mobile,
                                        'provider_id' => 0,
                                        'api_id' => $fundapi->id ?? 0,
                                        'amount' => $txn['amount'],
                                        'charge' => '0.00',
                                        'profit' => '0.00',
                                        'gst' => '0.00',
                                        'tds' => '0.00',
                                        'txnid' => $txn['unique_transaction_reference'],
                                        'payid' => $txn['unique_transaction_reference'],
                                        'refno' => $txn['unique_transaction_reference'],
                                        'description' => "Fund Recieved from Dynamic QR",
                                        'remark' => "UPI Payment",
                                        'option1' => $txn['remitter_full_name'] ?? "User",
                                        'status' => 'success',
                                        'user_id' => $user->id,
                                        'credit_by' => $user->id,
                                        'credited_by' => $user->id,
                                        'rtype' => 'main',
                                        'via' => 'portal',
                                        'balance' => $opening_balance,
                                        'closing_balance' => $closing_balance,
                                        'trans_type' => 'credit',
                                        'product' => "dynamicqr"
                                    ];
                                    Report::create($insert);
                                }
                            }
                            $response = [
                                'status' => 'SUCCESS',
                                'message' => 'Processed successfully',
                                'time' => now()->format('Y-m-d H:i:s')
                            ];

                            Apilog::create([
                                'url' => $url,
                                'modal' => $modal,
                                'txnid' => $txn['unique_transaction_reference'] ?? null,
                                'header' => json_encode($post->headers->all()) ?? null,
                                'response' => json_encode($post->all()) ?? null
                            ]);
                            return response()->json($response);
                        }
                    }
            }
        } catch (\Exception $e) {

            $response = [
                'status' => 'FAILURE',
                'message' => $e->getMessage(),
                'time' => now()->format('Y-m-d H:i:s')
            ];

            Apilog::create([
                'url' => $url,
                'modal' => $modal,
                'txnid' => $utr ?? null,
                'header' => json_encode($post->headers->all()) ?? null,
                'response' => json_encode($post->all()) ?? null
            ]);

            return response()->json($response);
        }
    }
}
