<?php

namespace App\Services;

use App\Helpers\AndroidCommonHelper;
use App\Helpers\BusStaticResponseHelper;
use App\Helpers\Permission;
use App\Helpers\StaticResponseHelper;
use Illuminate\Support\Facades\Log;
use Exception;

class BusService
{
    private $authService;
    private $authKey = "";
    private $authSecret = "";
    public $baseUrl = "";
    private $header = [];
    public $ip = [];

    public function __construct()
    {
        $getApiCred = AndroidCommonHelper::CheckServiceStatus('travels');

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
        $this->authService = new AuthService();
    }


    private function setFullUrl($method): string
    {
        if ($method == 'citylist') {
            return $this->baseUrl . '/v1/service/traveller/bus/city/list';
        } else if ($method == 'search') {
            return $this->baseUrl . '/v1/service/traveller/bus/search';
        } else if ($method == 'seatlayout') {
            return $this->baseUrl . '/v1/service/traveller/bus/seat/layout';
        } else if ($method == 'boardingpass') {
            return $this->baseUrl . '/v1/service/traveller/bus/boarding/pass';
        } else if ($method == 'busblock') {
            return $this->baseUrl . '/v1/service/traveller/bus/block';
        } else if ($method == 'bookbus') {
            return $this->baseUrl . '/v1/service/traveller/bus/book';
        } else if ($method == 'bookingDetails') {
            return $this->baseUrl . '/v1/service/traveller/bus/booking/details';
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
                $response = BusStaticResponseHelper::buscityresponse();
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


            if (isset($response['status']) && strtoupper($response['status']) == 'SUCCESS') {
                return ['status' => 'success', 'message' => "Bus City Fetch successfully", 'data' => $response['data']];
            } else {

                return [
                    'code' => $response['code'] ?? '0x0202',
                    'status' => $response['status'] ?? 'failed',
                    'message' => $response['message'] ?? 'Bus City Fetch failed'
                ];
            }
        } catch (Exception $e) {
            return ['status' => 'ERROR', 'message' => $e->getMessage()];
        }
    }

    public function searchBus($data)
    {
        try {
            $token = $this->authService->getToken();

            $payload = [
                "EndUserIp" => $this->ip,
                "TokenId" => $token,
                "DateOfJourney" => $data['JourneyDate'] ?? date('Y-m-d'),
                "DestinationId" => $data['DestinationId'],
                "OriginId" => $data['DepartureId'],
                "BookingMode" => $data['BookingMode'] ?? "5",
                "PreferredCurrency" => $data['Currency'] ?? "INR",
            ];

            $url = $this->setFullUrl('search');

            $baseUrl = url('/');
            if ($baseUrl === 'http://127.0.0.1:8000') {
                $response = BusStaticResponseHelper::bussearchresponse();
            } else {
                $response = Permission::curl($url, "POST", json_encode($payload), $this->header, "yes", "bus_search", "");
                $response = $response['response'];
            }

            if (is_string($response)) {
                $response = json_decode(($response), true);
            }

            if (isset($response['data']) && is_string($response['data'])) {
                $response['data'] = json_decode($response['data'], true);
            }


            if (isset($response['status']) && strtoupper($response['status']) == 'SUCCESS') {
                return ['status' => 'success', 'message' => "Flight search successfully", 'data' => $response['data']];
            } else {

                return [
                    'code' => $response['code'] ?? '0x0202',
                    'status' => $response['status'] ?? 'failed',
                    'message' => $response['message'] ?? 'Flight search failed'
                ];
            }
        } catch (Exception $e) {
            dd($e);
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
                $response = BusStaticResponseHelper::busboardingpassresponse();
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

            if (isset($response['status']) && $response['status'] == 'SUCCESS') {
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
                $response = BusStaticResponseHelper::busseatlayoutresponse();
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

            if (isset($response['status']) && $response['status'] == 'SUCCESS') {
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
                $response = BusStaticResponseHelper::busBlockStaticResponse();
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

            if (isset($response['status']) && $response['status'] == 'SUCCESS') {
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
                "Passenger" => $data['passenger']
            ];


            $url = $this->setFullUrl('bookbus');

            $baseUrl = url('/');
            if ($baseUrl === 'http://127.0.0.1:8000') {
                $response = BusStaticResponseHelper::busBookStaticResponse();
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

            if (isset($response['status']) && $response['status'] == 'SUCCESS') {
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

            dd($data);
            $payload = [
                "EndUserIp" => $this->ip,
                "TokenId" => $token,
                "TraceId" => $data['traceId'],
                "BusId" => $data['busId']
            ];
            $url = $this->setFullUrl('bookingDetails');


            $baseUrl = url('/');
            if ($baseUrl === 'http://127.0.0.1:8000') {
                // $response = StaticResponseHelper::busbookingresponse();
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

            if (isset($response['status']) && $response['status'] == 'SUCCESS') {
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


    // public function getDetailsFlight($data)
    // {
    //     try {
    //         $token = $this->authService->getToken();


    //         $res = json_decode($data->raw_response, true);

    //         $det = $res['Response']['Response']['FlightItinerary']['Passenger'][0];
    //         $payload = [
    //             "EndUserIp" => $this->ip,
    //             "TokenId" => $token,
    //             "BookingId" => $data->booking_id_api,
    //             "PNR" => $data->pnr,
    //             "FirstName" => $det['FirstName'],
    //             "LastName" => $det['LastName'],
    //         ];

    //         $url = $this->setFullUrl('bookingDetails');

    //         $baseUrl = url('/');
    //         if ($baseUrl === 'http://127.0.0.1:8000') {
    //             $response = StaticResponseHelper::bookingdetStaticResponse();
    //         } else {
    //             $response = Permission::curl($url, "POST", json_encode($payload), $this->header, "yes", "booking_details", "");
    //             $response = $response['response'];
    //         }

    //         if (is_string($response)) {
    //             $response = json_decode(($response), true);
    //         }

    //         if (isset($response['data']) && is_string($response['data'])) {
    //             $response['data'] = json_decode($response['data'], true);
    //         }

    //         if (isset($response['status']) && strtolower($response['status']) == 'success') {
    //             return ['status' => 'success', 'message' => "Booking Details get successfully", 'data' => $response['data']];
    //         } else {
    //             return [
    //                 'code' => $response['code'] ?? '0x0202',
    //                 'status' => $response['status'] ?? 'failed',
    //                 'message' => $response['message'] ?? 'Booking Details get failed'
    //             ];
    //         }
    //     } catch (Exception $e) {
    //         return ['status' => 'ERROR', 'message' => $e->getMessage()];
    //     }
    // }

    // public function cancelflight($data)
    // {
    //     try {
    //         $token = $this->authService->getToken();

    //          $payload = [
    //             "EndUserIp" => $this->ip,
    //             "TokenId" => $token,
    //             "BookingId" => $data['payload']['BookingId'],
    //             "RequestType" => $data['payload']['RequestType'],
    //             "CancellationType" => $data['payload']['CancellationType'],
    //             "Remarks" => $data['payload']['Remarks'],
    //         ];

    //         if ($data['payload']['RequestType'] == 2) {
    //             if (!empty($data['payload']['TicketId'])) {
    //                 $payload['TicketId'] = $data['payload']['TicketId'];
    //             } else {
    //                 $payload['Sectors'] = $data['payload']['Sectors'][0];
    //             }
    //         }

    //         $url = $this->setFullUrl('cancelFlight');

    //         $baseUrl = url('/');
    //         if ($baseUrl === 'http://127.0.0.1:8000') {
    //             $response = StaticResponseHelper::bookingCancelStaticResponse();
    //             // $response = StaticResponseHelper::bookingFailedCancelStaticResponse();
    //         } else {
    //             $response = Permission::curl($url, "POST", json_encode($payload), $this->header, "yes", "booking_details", "");
    //             $response = $response['response'];
    //         }

    //         if (is_string($response)) {
    //             $response = json_decode(($response), true);
    //         }

    //         if (isset($response['data']) && is_string($response['data'])) {
    //             $response['data'] = json_decode($response['data'], true);
    //         }

    //         if (isset($response['status']) && strtolower($response['status']) == 'success') {
    //             return ['status' => 'success', 'message' => "Flight Cancellation successfully", 'data' => $response['data']];
    //         } else {
    //             return [
    //                 'code' => $response['code'] ?? '0x0202',
    //                 'status' => $response['status'] ?? 'failed',
    //                 'message' => $response['message'] ?? 'Flight Cancellation failed'
    //             ];
    //         }
    //     } catch (Exception $e) {
    //         return ['status' => 'ERROR', 'message' => $e->getMessage()];
    //     }
    // }
}
