<?php

namespace App\Services;

use App\Helpers\AndroidCommonHelper;
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
        }
        return "";
    }

    public function searchFlight($data)
    {
        try {
            $token = $this->authService->getToken();

            $payload = [
                "EndUserIp" => $this->ip,
                "TokenId" => $token,
                "AdultCount" => $data['AdultCount'] ?? "1",
                "ChildCount" => $data['ChildCount'] ?? "0",
                "InfantCount" => $data['InfantCount'] ?? "0",
                "DirectFlight" => $data['DirectFlight'] ?? "false",
                "OneStopFlight" => $data['OneStopFlight'] ?? "false",
                "JourneyType" => $data['JourneyType'] ?? "1",
                "PreferredAirlines" => null,
                "Sources" => null
            ];

            if ($data['JourneyType'] == 2 && isset($data['Segments']) && count($data['Segments']) == 2) {

                $payload["Segments"] = [
                    [
                        "Origin" => $data['Segments'][0]['Origin'],
                        "Destination" => $data['Segments'][0]['Destination'],
                        "FlightCabinClass" => $data['FlightCabinClass'],
                        "PreferredDepartureTime" => $data['Segments'][0]['PreferredDepartureTime'],
                        "PreferredArrivalTime" => $data['Segments'][0]['PreferredArrivalTime']
                    ],
                    [
                        "Origin" => $data['Segments'][1]['Origin'],
                        "Destination" => $data['Segments'][1]['Destination'],
                        "FlightCabinClass" => $data['FlightCabinClass'],
                        "PreferredDepartureTime" => $data['Segments'][1]['PreferredDepartureTime'],
                        "PreferredArrivalTime" => $data['Segments'][1]['PreferredArrivalTime']
                    ]
                ];
            } else {
                $payload["Segments"] = [
                    [
                        "Origin" => $data['Origin'] ?? "DEL",
                        "Destination" => $data['Destination'] ?? "BOM",
                        "FlightCabinClass" => $data['FlightCabinClass'] ?? "1",
                        "PreferredDepartureTime" => $data['PreferredDepartureTime'] ?? date('Y-m-d\TH:i:s'),
                        "PreferredArrivalTime" => @$data['PreferredArrivalTime'] ?? '',
                    ]
                ];
            }


            $url = $this->setFullUrl('search');

            // Call API using Permission::curl


            $baseUrl = url('/');
            if ($baseUrl === 'http://127.0.0.1:8000') {
                // $response = StaticResponseHelper::searchStaticResponse();
                $response = StaticResponseHelper::flightroudtripsearchresponse();
                // $response = StaticResponseHelper::flightfailedsearchresponse();
            } else {
                $response = Permission::curl($url, "POST", json_encode($payload), $this->header, "yes", "flight_search", "");
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

    public function fareRuleFlight($data)
    {
        try {
            $token = $this->authService->getToken();

            $payload = [
                "EndUserIp" => $this->ip,
                "TokenId" => $token,
                "TraceId" => $data['TraceId'],
                "ResultIndex" => $data['ResultIndex'],
            ];


            $url = $this->setFullUrl('farerule');

            // Call API using Permission::curl
            $baseUrl = url('/');
            if ($baseUrl === 'http://127.0.0.1:8000') {
                $response = StaticResponseHelper::fareRuleStaticResponse();
            } else {
                $response = Permission::curl($url, "POST", json_encode($payload), $this->header, "yes", "fare_rule", "");
                $response = $response['response'];
            }


            if (is_string($response)) {
                $response = json_decode(($response), true);
            }

            if (isset($response['data']) && is_string($response['data'])) {
                $response['data'] = json_decode($response['data'], true);
            }

            if (isset($response['status']) && $response['status'] == 'SUCCESS') {
                return ['status' => 'success', 'message' => "Fare Rule get successfully", 'data' => $response['data']];
            } else {
                return [
                    'code' => $response['code'] ?? '0x0202',
                    'status' => $response['status'] ?? 'failed',
                    'message' => $response['message'] ?? 'Fare Rule get failed'
                ];
            }
        } catch (Exception $e) {
            return ['status' => 'ERROR', 'message' => $e->getMessage()];
        }
    }

    public function fareQuoteFlight($data)
    {
        try {
            $token = $this->authService->getToken();


            $payload = [
                "EndUserIp" => $this->ip,
                "TokenId" => $token,
                "TraceId" => $data['TraceId'],
                "ResultIndex" => $data['ResultIndex'],
            ];

            $url = $this->setFullUrl('farequote');


            $baseUrl = url('/');
            if ($baseUrl === 'http://127.0.0.1:8000') {
                $response = StaticResponseHelper::fareQuoteStaticResponse();
            } else {

                $response = Permission::curl($url, "POST", json_encode($payload), $this->header, "yes", "fare_quote", "");
                $response = $response['response'];
            }


            if (is_string($response)) {
                $response = json_decode(($response), true);
            }

            if (isset($response['data']) && is_string($response['data'])) {
                $response['data'] = json_decode($response['data'], true);
            }

            if (isset($response['status']) && $response['status'] == 'SUCCESS') {
                return ['status' => 'success', 'message' => "Fare Quotation get successfully", 'data' => $response['data']];
            } else {
                return [
                    'code' => $response['code'] ?? '0x0202',
                    'status' => $response['status'] ?? 'failed',
                    'message' => $response['message'] ?? 'Fare Quotation get failed'
                ];
            }
        } catch (Exception $e) {
            return ['status' => 'ERROR', 'message' => $e->getMessage()];
        }
    }


    public function seatLayoutFlight($data)
    {
        try {
            $token = $this->authService->getToken();

            $payload = [
                "EndUserIp" => $this->ip,
                "TokenId" => $token,
                "TraceId" => $data['TraceId'],
                "ResultIndex" => $data['ResultIndex'],
            ];

            $url = $this->setFullUrl('ssr');

            $baseUrl = url('/');
            if ($baseUrl === 'http://127.0.0.1:8000') {
                // $response = StaticResponseHelper::flightSSRStaticResponse();
                $response = StaticResponseHelper::flightSSROneStaticResponse();
            } else {
                $response = Permission::curl($url, "POST", json_encode($payload), $this->header, "yes", "ssr", "");
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

    public function bookingFlight($data)
    {
        try {
            $token = $this->authService->getToken();

            $payload = [
                "EndUserIp" => $this->ip,
                "TokenId" => $token,
                "TraceId" => $data['traceId'],
                "ResultIndex" => $data['resultIndex'],
                "Passengers" => $data['passengers']
            ];


            $url = $this->setFullUrl('book');

            // dd($response, $payload);
            $baseUrl = url('/');
            if ($baseUrl === 'http://127.0.0.1:8000') {
                // $response = StaticResponseHelper::flightfailedbookingresponse();
                $response = StaticResponseHelper::flightBookStaticResponse();
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
                return ['status' => 'success', 'message' => "Flight Booking successfully", 'data' => $response['data']];
            } else {
                return [
                    'code' => $response['code'] ?? '0x0202',
                    'status' => $response['status'] ?? 'failed',
                    'message' => $response['message'] ?? 'Flight Booking failed'
                ];
            }
        } catch (Exception $e) {
            return ['status' => 'ERROR', 'message' => $e->getMessage()];
        }
    }

    public function FlightTicketView($data)
    {
        try {
            $token = $this->authService->getToken();

            $payload = [
                "EndUserIp" => $this->ip,
                "TokenId" => $token,
                "TraceId" => $data['traceId'],
                "ResultIndex" => $data['resultIndex'],
                "Passengers" => $data['passengers']
            ];


            $url = $this->setFullUrl('ticketlcc');

            $baseUrl = url('/');
            if ($baseUrl === 'http://127.0.0.1:8000') {
                $response = StaticResponseHelper::flightTicketLCCStaticResponse();
                // $response = StaticResponseHelper::flightfailedbookingresponse();
            } else {
                $response = Permission::curl($url, "POST", json_encode($payload), $this->header, "yes", "ticketlcc", "");
                $response = $response['response'];
            }


            if (is_string($response)) {
                $response = json_decode(($response), true);
            }

            if (isset($response['data']) && is_string($response['data'])) {
                $response['data'] = json_decode($response['data'], true);
            }

            if (isset($response['status']) && $response['status'] == 'SUCCESS') {
                return ['status' => 'success', 'message' => "Flight Booking successfully", 'data' => $response['data']];
            } else {
                return [
                    'code' => $response['code'] ?? '0x0202',
                    'status' => $response['status'] ?? 'failed',
                    'message' => $response['message'] ?? 'Flight Booking failed'
                ];
            }
        } catch (Exception $e) {
            return ['status' => 'ERROR', 'message' => $e->getMessage()];
        }
    }

    public function getDetailsFlight($data)
    {
        try {
            $token = $this->authService->getToken();


            $res = json_decode($data->raw_response, true);
       
            $det = $res['Response']['Response']['FlightItinerary']['Passenger'][0];
            $payload = [
                "EndUserIp" => $this->ip,
                "TokenId" => $token,
                "BookingId" => $data->booking_id_api,
                "PNR" => $data->pnr,
                "FirstName" => $det['FirstName'],
                "LastName" => $det['LastName'],
            ];

            $url = $this->setFullUrl('bookingDetails');

            $baseUrl = url('/');
            if ($baseUrl === 'http://127.0.0.1:8000') {
                $response = StaticResponseHelper::bookingdetStaticResponse();
            } else {
                $response = Permission::curl($url, "POST", json_encode($payload), $this->header, "yes", "booking_details", "");
                $response = $response['response'];
            }

            if (is_string($response)) {
                $response = json_decode(($response), true);
            }

            if (isset($response['data']) && is_string($response['data'])) {
                $response['data'] = json_decode($response['data'], true);
            }

            if (isset($response['status']) && strtolower($response['status']) == 'success') {
                return ['status' => 'success', 'message' => "Booking Details get successfully", 'data' => $response['data']];
            } else {
                return [
                    'code' => $response['code'] ?? '0x0202',
                    'status' => $response['status'] ?? 'failed',
                    'message' => $response['message'] ?? 'Booking Details get failed'
                ];
            }
        } catch (Exception $e) {
            return ['status' => 'ERROR', 'message' => $e->getMessage()];
        }
    }

    public function cancelflight($data)
    {
        try {
            $token = $this->authService->getToken();

             $payload = [
                "EndUserIp" => $this->ip,
                "TokenId" => $token,
                "BookingId" => $data['payload']['BookingId'],
                "RequestType" => $data['payload']['RequestType'],
                "CancellationType" => $data['payload']['CancellationType'],
                "Remarks" => $data['payload']['Remarks'],
            ];

            if ($data['payload']['RequestType'] == 2) {
                if (!empty($data['payload']['TicketId'])) {
                    $payload['TicketId'] = $data['payload']['TicketId'];
                } else {
                    $payload['Sectors'] = $data['payload']['Sectors'][0];
                }
            }

            $url = $this->setFullUrl('cancelFlight');

            $baseUrl = url('/');
            if ($baseUrl === 'http://127.0.0.1:8000') {
                $response = StaticResponseHelper::bookingCancelStaticResponse();
                // $response = StaticResponseHelper::bookingFailedCancelStaticResponse();
            } else {
                $response = Permission::curl($url, "POST", json_encode($payload), $this->header, "yes", "booking_details", "");
                $response = $response['response'];
            }

            if (is_string($response)) {
                $response = json_decode(($response), true);
            }

            if (isset($response['data']) && is_string($response['data'])) {
                $response['data'] = json_decode($response['data'], true);
            }

            if (isset($response['status']) && strtolower($response['status']) == 'success') {
                return ['status' => 'success', 'message' => "Flight Cancellation successfully", 'data' => $response['data']];
            } else {
                return [
                    'code' => $response['code'] ?? '0x0202',
                    'status' => $response['status'] ?? 'failed',
                    'message' => $response['message'] ?? 'Flight Cancellation failed'
                ];
            }
        } catch (Exception $e) {
            return ['status' => 'ERROR', 'message' => $e->getMessage()];
        }
    }
}
