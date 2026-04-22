<?php

namespace App\Services;

use App\Helpers\AndroidCommonHelper;
use App\Helpers\HotelStaticResponseHelper;
use App\Helpers\Permission;
use App\Helpers\StaticResponseHelper;
use App\Models\Agents;
use App\Models\Api;
use Illuminate\Support\Facades\Log;
use Exception;

class HotelService
{
    private $authService;
    private $authKey = "";
    private $authSecret = "";
    public $baseUrl = "";
    private $header = [];
    public $ip = [];

    public function __construct()
    {
        $getApiCred = AndroidCommonHelper::CheckServiceStatus('travelshotel');

        if ($getApiCred['status']) {
            $this->authKey = @$getApiCred['apidata']['client_id'];
            $this->authSecret = @$getApiCred['apidata']['client_secret'];
            $this->ip = @$getApiCred['apidata']['ip'];
            $this->baseUrl = rtrim(@$getApiCred['apidata']['base_url'], '/');
            $this->header = [
                "Content-Type: application/json",
                "Authorization: " . "Basic " . base64_encode("$this->authKey:$this->authSecret")
            ];
        } else {
            throw new \Exception("Travels API credentials not found or inactive");
        }
        $this->authService = new HotelAuthService();
    }


    private function setFullUrl($method): string
    {
        if ($method == 'countrylist') {
            return $this->baseUrl . '/v1/service/traveller/hotel/country';
        } else if ($method == 'citylist') {
            return $this->baseUrl . '/v1/service/traveller/hotel/city';
        } else if ($method == 'hotelList') {
            return $this->baseUrl . '/v1/service/traveller/hotel/code/list';
        } else if ($method == 'search') {
            return $this->baseUrl . '/v1/service/traveller/hotel/search';
        } else if ($method == 'hoteldetails') {
            return $this->baseUrl . '/v1/service/traveller/hotel/details';
        } else if ($method == 'prebooking') {
            return $this->baseUrl . '/v1/service/traveller/hotel/pre/booking';
        } else if ($method == 'bookHotel') {
            return $this->baseUrl . '/v1/service/traveller/hotel/booking';
        } else if ($method == 'bookingDetails') {
            return $this->baseUrl . '/v1/service/traveller/hotel/booking/details';
        // } else if ($method == 'cancelhotel') {
        //     return $this->baseUrl . '/v1/service/traveller/hotel/booking/cancel';
        }
        return "";
    }

    public function searchCountry($data)
    {
        try {
            $url = $this->setFullUrl('countrylist');

            $payload = [];

            $baseUrl = url('/');
            if ($baseUrl === 'http://127.0.0.1:8000') {
                $response = HotelStaticResponseHelper::hotelcountryresponse();
            } else {
                $response = Permission::curl($url, "GET", json_encode($payload), $this->header, "yes", "country_search", "");
                $response = $response['response'];
            }

            if (is_string($response)) {
                $response = json_decode(($response), true);
            }

            if (isset($response['data']) && is_string($response['data'])) {
                $response['data'] = json_decode($response['data'], true);
            }


            if (isset($response['status']) && strtolower($response['status']) == 'success') {
                return ['status' => 'success', 'message' => "Hotel Country Fetch successfully", 'data' => $response['data']];
            } else {

                return [
                    'code' => $response['code'] ?? '0x0202',
                    'status' => $response['status'] ?? 'failed',
                    'message' => $response['message'] ?? 'Hotel Country Fetch failed'
                ];
            }
        } catch (Exception $e) {
            return ['status' => 'ERROR', 'message' => $e->getMessage()];
        }
    }
    public function searchCity($data)
    {
        try {
            $payload = [
                "CountryCode" => $data['countryCode']
            ];

            $url = $this->setFullUrl('citylist');

            $baseUrl = url('/');
            if ($baseUrl === 'http://127.0.0.1:8000') {
                $response = HotelStaticResponseHelper::hotelcityresponse();
            } else {
                $response = Permission::curl($url, "POST", json_encode($payload), $this->header, "yes", "city_search", "");
                $response = $response['response'];
            }

            if (is_string($response)) {
                $response = json_decode(($response), true);
            }

            if (isset($response['data']) && is_string($response['data'])) {
                $response['data'] = json_decode($response['data'], true);
            }


            if (isset($response['status']) && strtolower($response['status']) == 'success') {
                return ['status' => 'success', 'message' => "Hotel City Fetch successfully", 'data' => $response['data']];
            } else {

                return [
                    'code' => $response['code'] ?? '0x0202',
                    'status' => $response['status'] ?? 'failed',
                    'message' => $response['message'] ?? 'Hotel City Fetch failed'
                ];
            }
        } catch (Exception $e) {
            return ['status' => 'ERROR', 'message' => $e->getMessage()];
        }
    }
    public function searchHotelName($data)
    {
        try {
            $payload = [
                "CityCode" => $data['cityCode']
            ];

            $url = $this->setFullUrl('hotelList');

            $baseUrl = url('/');
            if ($baseUrl === 'http://127.0.0.1:8000') {
                $response = HotelStaticResponseHelper::hotelNameresponse();
            } else {
                $response = Permission::curl($url, "POST", json_encode($payload), $this->header, "yes", "hotel_name_search", "");
                $response = $response['response'];
            }

            if (is_string($response)) {
                $response = json_decode(($response), true);
            }

            if (isset($response['data']) && is_string($response['data'])) {
                $response['data'] = json_decode($response['data'], true);
            }


            if (isset($response['status']) && strtolower($response['status']) == 'success') {
                return ['status' => 'success', 'message' => "Hotel Name Fetch successfully", 'data' => $response['data']];
            } else {

                return [
                    'code' => $response['code'] ?? '0x0202',
                    'status' => $response['status'] ?? 'failed',
                    'message' => $response['message'] ?? 'Hotel Name Fetch failed'
                ];
            }
        } catch (Exception $e) {
            return ['status' => 'ERROR', 'message' => $e->getMessage()];
        }
    }

    public function searchHotel($data)
    {
        try {
            $payload = [
                "CheckIn" => date('Y-m-d', strtotime($data['chkInDate'])),
                "CheckOut" => date('Y-m-d', strtotime($data['chkOutDate'])),

                "HotelCodes" => $data['hotelCode'], // 👈 correct id

                "GuestNationality" => "IN",

                "PaxRooms" => [
                    [
                        "Adults" => (int)$data['adultCount'],
                        "Children" => (int)$data['childCount'],
                        "ChildrenAges" => $data['childCount'] > 0
                            ? array_map('intval', $data['childAges'])
                            : null
                    ]
                ],

                "ResponseTime" => 0.1,
                "IsDetailedResponse" => true
            ];


            $url = $this->setFullUrl('search');

            $baseUrl = url('/');
            if ($baseUrl === 'http://127.0.0.1:8000') {
                $response = HotelStaticResponseHelper::hotelsearchresponse();
            } else {
                $response = Permission::curl($url, "POST", json_encode($payload), $this->header, "yes", "hotel_search", "");
                $response = $response['response'];
            }

            if (is_string($response)) {
                $response = json_decode(($response), true);
            }

            if (isset($response['data']) && is_string($response['data'])) {
                $response['data'] = json_decode($response['data'], true);
            }


            if (isset($response['status']) && strtoupper($response['status']) == 'SUCCESS') {
                return ['status' => 'success', 'message' => "Hotel search successfully", 'data' => $response['data']];
            } else {

                return [
                    'code' => $response['code'] ?? '0x0202',
                    'status' => $response['status'] ?? 'failed',
                    'message' => $response['message'] ?? 'Hotel search failed'
                ];
            }
        } catch (Exception $e) {

            return ['status' => 'ERROR', 'message' => $e->getMessage()];
        }
    }

    public function hotelDetails($data)
    {
        try {
            $payload = [
                "HotelCode" => $data['HotelCode'],
                "Language" => "EN",
                "IsRoomDetailRequired" => true
            ];


            $url = $this->setFullUrl('hoteldetails');

            $baseUrl = url('/');
            if ($baseUrl === 'http://127.0.0.1:8000') {
                $response = HotelStaticResponseHelper::hoteldetailsresponse();
            } else {
                $response = Permission::curl($url, "POST", json_encode($payload), $this->header, "yes", "hotel_details", "");
                $response = $response['response'];
            }


            if (is_string($response)) {
                $response = json_decode(($response), true);
            }

            if (isset($response['data']) && is_string($response['data'])) {
                $response['data'] = json_decode($response['data'], true);
            }

            if (isset($response['status']) && strtolower($response['status']) == 'success') {
                return ['status' => 'success', 'message' => "Hotel Details get successfully", 'data' => $response['data']];
            } else {
                return [
                    'code' => $response['code'] ?? '0x0202',
                    'status' => $response['status'] ?? 'failed',
                    'message' => $response['message'] ?? 'Hotel Details get failed'
                ];
            }
        } catch (Exception $e) {
            return ['status' => 'ERROR', 'message' => $e->getMessage()];
        }
    }

    public function prebooking($data)
    {
        try {
            $payload = [
                "BookingCode" => $data['bookingId']
            ];

            $url = $this->setFullUrl('prebooking');

            $baseUrl = url('/');
            if ($baseUrl === 'http://127.0.0.1:8000') {
                $response = HotelStaticResponseHelper::hotelprebookingresponse();
            } else {
                $response = Permission::curl($url, "POST", json_encode($payload), $this->header, "yes", "hotel_prebooking", "");
                $response = $response['response'];
            }

            if (is_string($response)) {
                $response = json_decode(($response), true);
            }

            if (isset($response['data']) && is_string($response['data'])) {
                $response['data'] = json_decode($response['data'], true);
            }

            if (isset($response['status']) && strtolower($response['status']) == 'success') {
                return ['status' => 'success', 'message' => "Hotel Pre Booking successfully", 'data' => $response['data']];
            } else {
                return [
                    'code' => $response['code'] ?? '0x0202',
                    'status' => $response['status'] ?? 'failed',
                    'message' => $response['message'] ?? 'Hotel Pre Booking failed'
                ];
            }
        } catch (Exception $e) {
            return ['status' => 'ERROR', 'message' => $e->getMessage()];
        }
    }

    public function bookHotel($data)
    {
        try {
            $payload = [
                "BookingCode" => $data['BookingId'],
                "GuestNationality" => "IN",
                "RequestedBookingMode" => 5,
                "NetAmount" => $data['netAmt'],
                "ClientRefId" => $data['clientRefId'],
                "HotelRoomsDetails" => $data['HotelPassenger'],
            ];

            $url = $this->setFullUrl('bookHotel');

            $baseUrl = url('/');
            if ($baseUrl === 'http://127.0.0.1:8000') {
                // $response = HotelStaticResponseHelper::hotelBookStaticResponse();
                $response = HotelStaticResponseHelper::hotelBookStaticResponsefailed();
            } else {
                $response = Permission::curl($url, "POST", json_encode($payload), $this->header, "yes", "book_hotel", "");
                $response = $response['response'];
            }

            if (is_string($response)) {
                $response = json_decode(($response), true);
            }

            if (isset($response['data']) && is_string($response['data'])) {
                $response['data'] = json_decode($response['data'], true);
            }

            if (isset($response['status']) && strtolower($response['status']) == 'success') {
                return ['status' => 'success', 'message' => "Hotel Booked successfully", 'data' => $response['data']];
            } else {
                return [
                    'code' => $response['code'] ?? '0x0202',
                    'status' => $response['status'] ?? 'failed',
                    'message' => $response['message'] ?? 'Hotel Booking failed'
                ];
            }
        } catch (Exception $e) {
            return ['status' => 'ERROR', 'message' => $e->getMessage()];
        }
    }

    public function getDetailsHotel($data)
    {
        try {
            $token = $this->authService->getToken();

            $payload = [
                "BookingId" => $data,
                "TokenId" => $token
            ];
            $url = $this->setFullUrl('bookingDetails');


            $baseUrl = url('/');
            if ($baseUrl === 'http://127.0.0.1:8000') {
                $response = HotelStaticResponseHelper::busbookingdetailsresponse();
            } else {
                $response = Permission::curl($url, "POST", json_encode($payload), $this->header, "yes", "bookingDetail", "");
                $response = $response['response'];
            }

            if (is_string($response)) {
                $response = json_decode(($response), true);
            }

            if (isset($response['data']) && is_string($response['data'])) {
                $response['data'] = json_decode($response['data'], true);
            }

            if (isset($response['status']) && strtolower($response['status']) == 'success') {
                return ['status' => 'success', 'message' => "Booking details get successfully", 'data' => $response['data']];
            } else {
                return [
                    'code' => $response['code'] ?? '0x0202',
                    'status' => $response['status'] ?? 'failed',
                    'message' => $response['message'] ?? 'Booking details get failed'
                ];
            }
        } catch (Exception $e) {
            return ['status' => 'ERROR', 'message' => $e->getMessage()];
        }
    }

    public function cancelbus($data)
    {
        try {
            $token = $this->authService->getToken();
            $payload = [
                "EndUserIp" => $this->ip,
                "TokenId" => $token,
                "BusId" => $data['payload']['BusId'],
                "RequestType" => $data['payload']['RequestType'],
                "Remarks" => $data['payload']['Remarks'],
                "clientRefId" => $data['payid'],
            ];

            $url = $this->setFullUrl('cancelBus');

            $baseUrl = url('/');
            if ($baseUrl === 'http://127.0.0.1:8000') {
                // $response = HotelStaticResponseHelper::busCancelResponse();
            } else {
                $response = Permission::curl($url, "POST", json_encode($payload), $this->header, "yes", "cancel_bus", "");
                $response = $response['response'];
            }

            if (is_string($response)) {
                $response = json_decode(($response), true);
            }

            if (isset($response['data']) && is_string($response['data'])) {
                $response['data'] = json_decode($response['data'], true);
            }

            if (isset($response['status']) && strtolower($response['status']) == 'success') {
                return ['status' => 'success', 'message' => "Bus Cancellation successfully", 'data' => $response['data']];
            } else {
                return [
                    'code' => $response['code'] ?? '0x0202',
                    'status' => $response['status'] ?? 'failed',
                    'message' => $response['message'] ?? 'Bus Cancellation failed'
                ];
            }
        } catch (Exception $e) {
            return ['status' => 'ERROR', 'message' => $e->getMessage()];
        }
    }
    /**
     * Initialize payment gateway collect request
     */
    public function initiatePayment($user, $amount, $clientRefId)
    {
        $api = Api::where('code', 'rrpayment')->first();
        if (!$api) {
            return ['response' => '', 'error' => 'PG service is down', 'code' => 500];
        }

        $agent = Agents::where('user_id', $user->id)->first();
        if (!$agent) {
            $agent = Agents::where('user_id', 1)->first();
        }

        $url = rtrim($api->url, '/') . "/v1/service/pgcollect/order";
        $header = [
            "Content-Type: application/json",
            "Authorization: Basic " . base64_encode($api->username . ":" . $api->password)
        ];

        $reqData = [
            "email" => $user->email,
            "name" => $user->name,
            "merchantCode" => $agent->bc_id ?? "MID73323213401",
            "clientRefId" => $clientRefId,
            "mobile" => $user->mobile,
            "redirectUrl" => route('hotel.payment.success'),
            "successUrl" => route('hotel.payment.success'),
            "failedUrl" => route('hotel.payment.failed'),
            "amount" => 1
            // "amount" => $amount
        ];

        return Permission::curl($url, "POST", json_encode($reqData), $header, "yes", "pg_collect", $clientRefId);
    }

    /**
     * Check transaction status from payment gateway
     */
    public function checkPaymentStatus($clientRefId)
    {
        $api = Api::where('code', 'orpayment')->first();
        if (!$api) {
            return ['response' => '', 'error' => 'API source not found', 'code' => 404];
        }

        $url = rtrim($api->url, '/') . '/v1/service/paycc/order/' . $clientRefId;
        $auth = base64_encode(trim($api->username) . ":" . trim($api->password));

        $header = [
            "Content-Type: application/json",
            "Authorization: Basic " . $auth
        ];

        return Permission::curl($url, "GET", "", $header, "yes", "payment_status_check", $clientRefId);
    }
}
