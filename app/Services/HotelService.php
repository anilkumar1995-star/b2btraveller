<?php

namespace App\Services;

use App\Helpers\AndroidCommonHelper;
use App\Helpers\HotelStaticResponseHelper;
use App\Helpers\Permission;
use App\Helpers\StaticResponseHelper;
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
        $this->authService = new BusAuthService();
    }


    private function setFullUrl($method): string
    {
        if ($method == 'citylist') {
            return $this->baseUrl . '/v1/service/traveller/hotel/city/list';
        } else if ($method == 'search') {
            return $this->baseUrl . '/v1/service/traveller/hotel/search';
        } else if ($method == 'seatlayout') {
            return $this->baseUrl . '/v1/service/traveller/hotel/info';
        } else if ($method == 'hotelroom') {
            return $this->baseUrl . '/v1/service/traveller/hotel/room';
        } else if ($method == 'hotelblock') {
            return $this->baseUrl . '/v1/service/traveller/hotel/block';
        } else if ($method == 'bookhotel') {
            return $this->baseUrl . '/v1/service/traveller/hotel/book';
        } else if ($method == 'bookingDetails') {
            return $this->baseUrl . '/v1/service/traveller/hotel/booking/details';
        } else if ($method == 'cancelhotel') {
            return $this->baseUrl . '/v1/service/traveller/hotel/booking/cancel';
        }
        return "";
    }

    public function searchCity($data)
    {
        try {
            $token = $this->authService->getToken();

            $payload = [
                "EndUserIp" => $this->ip,
                "TokenId" => $token,
            ];

            $url = $this->setFullUrl('citylist');

            $baseUrl = url('/');
            if ($baseUrl === 'http://127.0.0.1:8000') {
                $response = HotelStaticResponseHelper::buscityresponse();
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

    public function searchHotel($data)
    {
        try {
            $token = $this->authService->getToken();

            $checkIn = \Carbon\Carbon::createFromFormat('d-m-Y', $data['chkInDate'])->format('d/m/Y');

            // Nights calculate
            $nights = \Carbon\Carbon::createFromFormat('d-m-Y', $data['chkOutDate'])
                ->diffInDays(\Carbon\Carbon::createFromFormat('d-m-Y', $data['chkInDate']));

            // Room Guests with dynamic child ages
            $roomGuests = [
                [
                    "NoOfAdults" => (int)$data['adultCount'],
                    "NoOfChild" => (int)$data['childCount'],
                    "ChildAge" => $data['childCount'] > 0
                        ? array_map('intval', $data['childAges'])
                        : null
                ]
            ];
            if ($data['childCount'] > 0) {
                if ($data['childCount'] != count($data['childAges'])) {
                    return [
                        'code' => '0x0202',
                        'status' => 'failed',
                        'message' => 'Child count and ages mismatch'
                    ];
                }
            }

            if ($data['adultCount'] > 8 || $data['childCount'] > 2) {
                return [
                    'code' => '0x0202',
                    'status' => 'failed',
                    'message' => 'Max limit exceeded'
                ];
            }

            $payload = [
                "TokenId" => $token,
                "CheckInDate" => $checkIn,
                "NoOfNights" => (string)$nights,
                "CountryCode" => "IN",
                "CityId" => $data['destId'],
                "PreferredCurrency" => "INR",
                "GuestNationality" => "IN",
                "NoOfRooms" => (string)$data['roomCount'],
                "RoomGuests" => $roomGuests,
                "MaxRating" => 5,
                "IsNearBySearchAllowed" => "0"
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

    public function boardingdetail($data)
    {
        try {
            $token = $this->authService->getToken();

            $payload = [
                "EndUserIp" => $this->ip,
                "TokenId" => $token,
                "TraceId" => $data['TraceId'],
                "ResultIndex" => $data['ResultIndex'],
            ];


            $url = $this->setFullUrl('boardingpass');

            $baseUrl = url('/');
            if ($baseUrl === 'http://127.0.0.1:8000') {
                $response = HotelStaticResponseHelper::busboardingpassresponse();
            } else {
                $response = Permission::curl($url, "POST", json_encode($payload), $this->header, "yes", "boardingpass", "");
                $response = $response['response'];
            }


            if (is_string($response)) {
                $response = json_decode(($response), true);
            }

            if (isset($response['data']) && is_string($response['data'])) {
                $response['data'] = json_decode($response['data'], true);
            }

            if (isset($response['status']) && strtolower($response['status']) == 'success') {
                return ['status' => 'success', 'message' => "Boarding Details get successfully", 'data' => $response['data']];
            } else {
                return [
                    'code' => $response['code'] ?? '0x0202',
                    'status' => $response['status'] ?? 'failed',
                    'message' => $response['message'] ?? 'Boarding Details get failed'
                ];
            }
        } catch (Exception $e) {
            return ['status' => 'ERROR', 'message' => $e->getMessage()];
        }
    }



    public function seatdetail($data)
    {
        try {
            $token = $this->authService->getToken();

            $payload = [
                "EndUserIp" => $this->ip,
                "TokenId" => $token,
                "TraceId" => $data['TraceId'],
                "ResultIndex" => $data['ResultIndex'],
            ];

            $url = $this->setFullUrl('seatlayout');

            $baseUrl = url('/');
            if ($baseUrl === 'http://127.0.0.1:8000') {
                $response = HotelStaticResponseHelper::busseatlayoutresponse();
            } else {
                $response = Permission::curl($url, "POST", json_encode($payload), $this->header, "yes", "seatlayout", "");
                $response = $response['response'];
            }

            if (is_string($response)) {
                $response = json_decode(($response), true);
            }

            if (isset($response['data']) && is_string($response['data'])) {
                $response['data'] = json_decode($response['data'], true);
            }

            if (isset($response['status']) && strtolower($response['status']) == 'success') {
                return ['status' => 'success', 'message' => "Seat Layout get successfully", 'data' => $response['data']];
            } else {
                return [
                    'code' => $response['code'] ?? '0x0202',
                    'status' => $response['status'] ?? 'failed',
                    'message' => $response['message'] ?? 'Seat Layout get failed'
                ];
            }
        } catch (Exception $e) {
            return ['status' => 'ERROR', 'message' => $e->getMessage()];
        }
    }

    public function busBlocks($data)
    {
        try {
            $token = $this->authService->getToken();

            $payload = [
                "EndUserIp" => $this->ip,
                "TokenId" => $token,
                "TraceId" => $data['traceId'],
                "ResultIndex" => $data['resultIndex'],
                "BoardingPointId" => $data['boardingPointId'],
                "DroppingPointId" => $data['droppingPointId'],
                "Passenger" => $data['passenger']
            ];


            $url = $this->setFullUrl('busblock');

            // dd($response, $payload);
            $baseUrl = url('/');
            if ($baseUrl === 'http://127.0.0.1:8000') {
                // $response = StaticResponseHelper::flightfailedbookingresponse();
                $response = HotelStaticResponseHelper::busBlockStaticResponse();
            } else {
                $response = Permission::curl($url, "POST", json_encode($payload), $this->header, "yes", "block", "");
                $response = $response['response'];
            }

            if (is_string($response)) {
                $response = json_decode(($response), true);
            }

            if (isset($response['data']) && is_string($response['data'])) {
                $response['data'] = json_decode($response['data'], true);
            }

            if (isset($response['status']) && strtolower($response['status']) == 'success') {
                return ['status' => 'success', 'message' => "Bus Block successfully", 'data' => $response['data']];
            } else {
                return [
                    'code' => $response['code'] ?? '0x0202',
                    'status' => $response['status'] ?? 'failed',
                    'message' => $response['message'] ?? 'Bus Block failed'
                ];
            }
        } catch (Exception $e) {
            return ['status' => 'ERROR', 'message' => $e->getMessage()];
        }
    }

    public function bookBuss($data)
    {
        try {
            $token = $this->authService->getToken();

            $payload = [
                "EndUserIp" => $this->ip,
                "TokenId" => $token,
                "TraceId" => $data['traceId'],
                "ResultIndex" => $data['resultIndex'],
                "BoardingPointId" => $data['boardingPointId'],
                "DroppingPointId" => $data['droppingPointId'],
                "Passenger" => $data['passenger'],
                "TotalAmount" => $data['totalAmount'],
                "clientRefId" => $data['clientRefId'],
            ];

            $url = $this->setFullUrl('bookbus');

            $baseUrl = url('/');
            if ($baseUrl === 'http://127.0.0.1:8000') {
                $response = HotelStaticResponseHelper::busBookStaticResponse();
            } else {
                $response = Permission::curl($url, "POST", json_encode($payload), $this->header, "yes", "book", "");
                $response = $response['response'];
            }

            if (is_string($response)) {
                $response = json_decode(($response), true);
            }

            if (isset($response['data']) && is_string($response['data'])) {
                $response['data'] = json_decode($response['data'], true);
            }

            if (isset($response['status']) && strtolower($response['status']) == 'success') {
                return ['status' => 'success', 'message' => "Bus Booked successfully", 'data' => $response['data']];
            } else {
                return [
                    'code' => $response['code'] ?? '0x0202',
                    'status' => $response['status'] ?? 'failed',
                    'message' => $response['message'] ?? 'Bus Booking failed'
                ];
            }
        } catch (Exception $e) {
            return ['status' => 'ERROR', 'message' => $e->getMessage()];
        }
    }

    public function getDetailsBus($data)
    {
        try {
            $token = $this->authService->getToken();

            $payload = [
                "EndUserIp" => $this->ip,
                "TokenId" => $token,
                "TraceId" => $data->booking_id_api,
                "BusId" => $data->bus_id
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
                $response = HotelStaticResponseHelper::busCancelResponse();
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
}
