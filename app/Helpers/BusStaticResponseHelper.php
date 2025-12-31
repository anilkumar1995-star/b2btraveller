<?php

namespace App\Helpers;

class BusStaticResponseHelper
{

    static public function buscityresponse()
    {
        return '{
            "code": "0x0200",
            "message": "success",
            "status": "SUCCESS",
            "data": [
                {
                    "CityId": 9252,
                    "CityName": " Bharuch (bypass)"
                },
                {
                    "CityId": 16347,
                    "CityName": " Model Colony,Nashik"
                },
                {
                    "CityId": 16537,
                    "CityName": " Mumbai Naka,Nashik"
                },
                {
                    "CityId": 15949,
                    "CityName": "(Area)Dadar.,Mumbai"
                },
                {
                    "CityId": 16914,
                    "CityName": "26 Bb, Rajasthan"
                },
                {
                    "CityId": 5271,
                    "CityName": "26th Mile(kerala)"
                },
                {
                    "CityId": 16880,
                    "CityName": "29BB, Rajasthan"
                },
                {
                    "CityId": 1931,
                    "CityName": "A K Pora"
                },
                {
                    "CityId": 16133,
                    "CityName": "A P M C,Ahmedabad"
                },
                {
                    "CityId": 5392,
                    "CityName": "A.i .area"
                },
                {
                    "CityId": 3644,
                    "CityName": "A.konduru"
                },
                {
                    "CityId": 25,
                    "CityName": "A.r.t.c. Diphu"
                },
                {
                    "CityId": 5451,
                    "CityName": "A.S.Peta"
                },
                {
                    "CityId": 8183,
                    "CityName": "Aachara"
                },
                {
                    "CityId": 3000,
                    "CityName": "Aade(maharashtra)"
                },
                {
                    "CityId": 10670,
                    "CityName": "Aadivare"
                },
                {
                    "CityId": 7390,
                    "CityName": "Aadsar"
                },
                {
                    "CityId": 7954,
                    "CityName": "Aamaran"
                },
                {
                    "CityId": 10170,
                    "CityName": "Aambala (Gujarat)"
                }
            ]
        }';
    }

    static public function bussearchresponse()
    {
        return '{
            "code": "0x0200",
            "message": "success",
            "status": "SUCCESS",
            "data": {
                "TraceId": "ba4fb27b-3559-44c2-8ada-7f401e0c9fd6",
                "Origin": "Lucknow",
                "Destination": "Allahabad",
                "Results": [
                    {
                        "ResultIndex": 1,
                        "ArrivalTime": "2026-01-01T07:00:00",
                        "AvailableSeats": 22,
                        "DepartureTime": "2025-12-31T22:00:00",
                        "RouteId": "2002037354780030786",
                        "BusType": "Volvo A/C Seater/Sleeper Luxury (2+2)",
                        "ServiceName": "Seat Seller",
                        "TravelName": "test-travels",
                        "IdProofRequired": false,
                        "IsDropPointMandatory": false,
                        "LiveTrackingAvailable": false,
                        "MTicketEnabled": true,
                        "MaxSeatsPerTicket": 6,
                        "OperatorId": 10419079,
                        "PartialCancellationAllowed": true,
                        "BoardingPointsDetails": [
                            {
                                "CityPointIndex": 1,
                                "CityPointLocation": "Gomti Nagar, Lucknow",
                                "CityPointName": "Gomti Nagar, Lucknow (Pickup Bus)",
                                "CityPointTime": "2025-12-31T22:00:00"
                            },
                            {
                                "CityPointIndex": 2,
                                "CityPointLocation": "Phoenix Mall,Lucknow",
                                "CityPointName": "Phoenix Mall,Lucknow (Pickup Bus)",
                                "CityPointTime": "2025-12-31T23:00:00"
                            }
                        ],
                        "DroppingPointsDetails": [
                            {
                                "CityPointIndex": 1,
                                "CityPointLocation": "Bus Stand ,Allahabad",
                                "CityPointName": "Bus Stand ,Allahabad (Pickup Bus)",
                                "CityPointTime": "2026-01-01T07:00:00"
                            }
                        ],
                        "BusPrice": {
                            "CurrencyCode": "INR",
                            "BasePrice": 105,
                            "Tax": 0,
                            "OtherCharges": 0,
                            "Discount": 0,
                            "PublishedPrice": 105,
                            "PublishedPriceRoundedOff": 105,
                            "OfferedPrice": 75,
                            "OfferedPriceRoundedOff": 75,
                            "AgentCommission": 30,
                            "AgentMarkUp": 0,
                            "TDS": 12,
                            "GST": {
                                "CGSTAmount": 0,
                                "CGSTRate": 0,
                                "CessAmount": 0,
                                "CessRate": 0,
                                "IGSTAmount": 0,
                                "IGSTRate": 18,
                                "SGSTAmount": 0,
                                "SGSTRate": 0,
                                "TaxableAmount": 0
                            }
                        },
                        "CancellationPolicies": [
                            {
                                "CancellationCharge": 10,
                                "CancellationChargeType": 2,
                                "PolicyString": "Till 17:00 on 30 Dec 2025",
                                "TimeBeforeDept": "29$-1",
                                "FromDate": "2025-12-30T11:26:36",
                                "ToDate": "2025-12-30T17:00:00"
                            },
                            {
                                "CancellationCharge": 50,
                                "CancellationChargeType": 2,
                                "PolicyString": "Between 17:00 on 30 Dec 2025 - 05:00 on 31 Dec 2025",
                                "TimeBeforeDept": "17$29",
                                "FromDate": "2025-12-30T17:00:00",
                                "ToDate": "2025-12-31T05:00:00"
                            },
                            {
                                "CancellationCharge": 100,
                                "CancellationChargeType": 2,
                                "PolicyString": "After 05:00 on 31 Dec 2025",
                                "TimeBeforeDept": "0$17",
                                "FromDate": "2025-12-31T05:00:00",
                                "ToDate": "2026-01-01T07:00:00"
                            }
                        ]
                    }
                ]
            }
        }';
    }
}
