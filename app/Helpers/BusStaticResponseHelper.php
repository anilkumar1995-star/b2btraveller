<?php

namespace App\Helpers;

use PhpParser\Node\Stmt\Static_;

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

    static public function busboardingpassresponse()
    {
        return '{
            "code": "0x0200",
            "message": "success",
            "status": "SUCCESS",
            "data": {
                "TokenId": "f5d0714f-3b37-4f76-b039-c28a5554bcf2",
                "TraceId": "ba4fb27b-3559-44c2-8ada-7f401e0c9fd6",
                "BoardingPointsDetails": [
                    {
                        "CityPointAddress": "Test",
                        "CityPointContactNumber": "0987654321",
                        "CityPointIndex": 1,
                        "CityPointLandmark": "Gomti Nagar",
                        "CityPointLocation": "Gomti Nagar, Lucknow",
                        "CityPointName": "Gomti Nagar, Lucknow (Pickup Bus)",
                        "CityPointTime": "2025-12-31T22:00:00"
                    },
                    {
                        "CityPointAddress": "Test",
                        "CityPointContactNumber": "0987654321",
                        "CityPointIndex": 2,
                        "CityPointLandmark": "test1",
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
                ]
            }
        }';
    }

    public static function busseatlayoutresponse()
    {
        return '{
            "status": "success",
            "message": "Seat Layout get successfully",
            "data": {
                "TokenId": "aeb3a6bb-1ee2-485a-83a6-f4fff8a2eac6",
                "TraceId": "c4c50e5a-dd60-49a4-b5b9-0238d4973651",
                "FareRules": {
                    "AvailableSeats": "41",
                    "SeatLayout": {
                        "NoOfColumns": 1,
                        "NoOfRows": 7,
                        "SeatDetails": [
                            [
                                {
                                    "ColumnNo": "000",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "000",
                                    "SeatFare": "210.00",
                                    "SeatIndex": 4,
                                    "SeatName": "2",
                                    "SeatStatus": true,
                                    "SeatType": 1,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": "210.00",
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": "210.00",
                                        "PublishedPriceRoundedOff": 210,
                                        "OfferedPrice": "197.40",
                                        "OfferedPriceRoundedOff": 197,
                                        "AgentCommission": 12.5999999999999996447286321199499070644378662109375,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.25,
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
                                    }
                                },
                                {
                                    "ColumnNo": "001",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "000",
                                    "SeatFare": "210.00",
                                    "SeatIndex": 7,
                                    "SeatName": "4",
                                    "SeatStatus": true,
                                    "SeatType": 1,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": "210.00",
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": "210.00",
                                        "PublishedPriceRoundedOff": 210,
                                        "OfferedPrice": "197.40",
                                        "OfferedPriceRoundedOff": 197,
                                        "AgentCommission": 12.5999999999999996447286321199499070644378662109375,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.25,
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
                                    }
                                },
                                {
                                    "ColumnNo": "002",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "000",
                                    "SeatFare": "210.00",
                                    "SeatIndex": 12,
                                    "SeatName": "6",
                                    "SeatStatus": true,
                                    "SeatType": 1,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": "210.00",
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": "210.00",
                                        "PublishedPriceRoundedOff": 210,
                                        "OfferedPrice": "197.40",
                                        "OfferedPriceRoundedOff": 197,
                                        "AgentCommission": 12.5999999999999996447286321199499070644378662109375,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.25,
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
                                    }
                                },
                                {
                                    "ColumnNo": "003",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "000",
                                    "SeatFare": "210.00",
                                    "SeatIndex": 15,
                                    "SeatName": "8",
                                    "SeatStatus": true,
                                    "SeatType": 1,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": "210.00",
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": "210.00",
                                        "PublishedPriceRoundedOff": 210,
                                        "OfferedPrice": "197.40",
                                        "OfferedPriceRoundedOff": 197,
                                        "AgentCommission": 12.5999999999999996447286321199499070644378662109375,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.25,
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
                                    }
                                },
                                {
                                    "ColumnNo": "004",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "000",
                                    "SeatFare": "210.00",
                                    "SeatIndex": 20,
                                    "SeatName": "10",
                                    "SeatStatus": true,
                                    "SeatType": 1,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": "210.00",
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": "210.00",
                                        "PublishedPriceRoundedOff": 210,
                                        "OfferedPrice": "197.40",
                                        "OfferedPriceRoundedOff": 197,
                                        "AgentCommission": 12.5999999999999996447286321199499070644378662109375,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.25,
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
                                    }
                                },
                                {
                                    "ColumnNo": "005",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "000",
                                    "SeatFare": "210.00",
                                    "SeatIndex": 23,
                                    "SeatName": "12",
                                    "SeatStatus": true,
                                    "SeatType": 1,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": "210.00",
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": "210.00",
                                        "PublishedPriceRoundedOff": 210,
                                        "OfferedPrice": "197.40",
                                        "OfferedPriceRoundedOff": 197,
                                        "AgentCommission": 12.5999999999999996447286321199499070644378662109375,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.25,
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
                                    }
                                },
                                {
                                    "ColumnNo": "006",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "000",
                                    "SeatFare": "210.00",
                                    "SeatIndex": 28,
                                    "SeatName": "14",
                                    "SeatStatus": true,
                                    "SeatType": 1,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": "210.00",
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": "210.00",
                                        "PublishedPriceRoundedOff": 210,
                                        "OfferedPrice": "197.40",
                                        "OfferedPriceRoundedOff": 197,
                                        "AgentCommission": 12.5999999999999996447286321199499070644378662109375,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.25,
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
                                    }
                                },
                                {
                                    "ColumnNo": "007",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "000",
                                    "SeatFare": "210.00",
                                    "SeatIndex": 31,
                                    "SeatName": "16",
                                    "SeatStatus": true,
                                    "SeatType": 1,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": "210.00",
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": "210.00",
                                        "PublishedPriceRoundedOff": 210,
                                        "OfferedPrice": "197.40",
                                        "OfferedPriceRoundedOff": 197,
                                        "AgentCommission": 12.5999999999999996447286321199499070644378662109375,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.25,
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
                                    }
                                },
                                {
                                    "ColumnNo": "008",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "000",
                                    "SeatFare": "210.00",
                                    "SeatIndex": 36,
                                    "SeatName": "18",
                                    "SeatStatus": true,
                                    "SeatType": 1,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": "210.00",
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": "210.00",
                                        "PublishedPriceRoundedOff": 210,
                                        "OfferedPrice": "197.40",
                                        "OfferedPriceRoundedOff": 197,
                                        "AgentCommission": 12.5999999999999996447286321199499070644378662109375,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.25,
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
                                    }
                                },
                                {
                                    "ColumnNo": "009",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "000",
                                    "SeatFare": "210.00",
                                    "SeatIndex": 39,
                                    "SeatName": "20",
                                    "SeatStatus": true,
                                    "SeatType": 1,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": "210.00",
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": "210.00",
                                        "PublishedPriceRoundedOff": 210,
                                        "OfferedPrice": "197.40",
                                        "OfferedPriceRoundedOff": 197,
                                        "AgentCommission": 12.5999999999999996447286321199499070644378662109375,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.25,
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
                                    }
                                }
                            ],
                            [
                                {
                                    "ColumnNo": "000",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "001",
                                    "SeatFare": "210.00",
                                    "SeatIndex": 5,
                                    "SeatName": "1",
                                    "SeatStatus": true,
                                    "SeatType": 1,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": "210.00",
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": "210.00",
                                        "PublishedPriceRoundedOff": 210,
                                        "OfferedPrice": "197.40",
                                        "OfferedPriceRoundedOff": 197,
                                        "AgentCommission": 12.5999999999999996447286321199499070644378662109375,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.25,
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
                                    }
                                },
                                {
                                    "ColumnNo": "001",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "001",
                                    "SeatFare": "210.00",
                                    "SeatIndex": 8,
                                    "SeatName": "3",
                                    "SeatStatus": true,
                                    "SeatType": 1,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": "210.00",
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": "210.00",
                                        "PublishedPriceRoundedOff": 210,
                                        "OfferedPrice": "197.40",
                                        "OfferedPriceRoundedOff": 197,
                                        "AgentCommission": 12.5999999999999996447286321199499070644378662109375,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.25,
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
                                    }
                                },
                                {
                                    "ColumnNo": "002",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "001",
                                    "SeatFare": "210.00",
                                    "SeatIndex": 13,
                                    "SeatName": "5",
                                    "SeatStatus": true,
                                    "SeatType": 1,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": "210.00",
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": "210.00",
                                        "PublishedPriceRoundedOff": 210,
                                        "OfferedPrice": "197.40",
                                        "OfferedPriceRoundedOff": 197,
                                        "AgentCommission": 12.5999999999999996447286321199499070644378662109375,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.25,
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
                                    }
                                },
                                {
                                    "ColumnNo": "003",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "001",
                                    "SeatFare": "210.00",
                                    "SeatIndex": 16,
                                    "SeatName": "7",
                                    "SeatStatus": true,
                                    "SeatType": 1,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": "210.00",
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": "210.00",
                                        "PublishedPriceRoundedOff": 210,
                                        "OfferedPrice": "197.40",
                                        "OfferedPriceRoundedOff": 197,
                                        "AgentCommission": 12.5999999999999996447286321199499070644378662109375,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.25,
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
                                    }
                                },
                                {
                                    "ColumnNo": "004",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "001",
                                    "SeatFare": "210.00",
                                    "SeatIndex": 21,
                                    "SeatName": "9",
                                    "SeatStatus": true,
                                    "SeatType": 1,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": "210.00",
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": "210.00",
                                        "PublishedPriceRoundedOff": 210,
                                        "OfferedPrice": "197.40",
                                        "OfferedPriceRoundedOff": 197,
                                        "AgentCommission": 12.5999999999999996447286321199499070644378662109375,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.25,
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
                                    }
                                },
                                {
                                    "ColumnNo": "005",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "001",
                                    "SeatFare": "210.00",
                                    "SeatIndex": 24,
                                    "SeatName": "11",
                                    "SeatStatus": true,
                                    "SeatType": 1,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": "210.00",
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": "210.00",
                                        "PublishedPriceRoundedOff": 210,
                                        "OfferedPrice": "197.40",
                                        "OfferedPriceRoundedOff": 197,
                                        "AgentCommission": 12.5999999999999996447286321199499070644378662109375,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.25,
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
                                    }
                                },
                                {
                                    "ColumnNo": "006",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "001",
                                    "SeatFare": "210.00",
                                    "SeatIndex": 29,
                                    "SeatName": "13",
                                    "SeatStatus": true,
                                    "SeatType": 1,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": "210.00",
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": "210.00",
                                        "PublishedPriceRoundedOff": 210,
                                        "OfferedPrice": "197.40",
                                        "OfferedPriceRoundedOff": 197,
                                        "AgentCommission": 12.5999999999999996447286321199499070644378662109375,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.25,
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
                                    }
                                },
                                {
                                    "ColumnNo": "007",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "001",
                                    "SeatFare": "210.00",
                                    "SeatIndex": 32,
                                    "SeatName": "15",
                                    "SeatStatus": true,
                                    "SeatType": 1,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": "210.00",
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": "210.00",
                                        "PublishedPriceRoundedOff": 210,
                                        "OfferedPrice": "197.40",
                                        "OfferedPriceRoundedOff": 197,
                                        "AgentCommission": 12.5999999999999996447286321199499070644378662109375,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.25,
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
                                    }
                                },
                                {
                                    "ColumnNo": "008",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "001",
                                    "SeatFare": "210.00",
                                    "SeatIndex": 37,
                                    "SeatName": "17",
                                    "SeatStatus": true,
                                    "SeatType": 1,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": "210.00",
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": "210.00",
                                        "PublishedPriceRoundedOff": 210,
                                        "OfferedPrice": "197.40",
                                        "OfferedPriceRoundedOff": 197,
                                        "AgentCommission": 12.5999999999999996447286321199499070644378662109375,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.25,
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
                                    }
                                },
                                {
                                    "ColumnNo": "009",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "001",
                                    "SeatFare": "210.00",
                                    "SeatIndex": 40,
                                    "SeatName": "19",
                                    "SeatStatus": true,
                                    "SeatType": 1,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": "210.00",
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": "210.00",
                                        "PublishedPriceRoundedOff": 210,
                                        "OfferedPrice": "197.40",
                                        "OfferedPriceRoundedOff": 197,
                                        "AgentCommission": 12.5999999999999996447286321199499070644378662109375,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.25,
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
                                    }
                                }
                            ],
                            [
                                {
                                    "ColumnNo": "009",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "002",
                                    "SeatFare": 210,
                                    "SeatIndex": 41,
                                    "SeatName": "21",
                                    "SeatStatus": true,
                                    "SeatType": 1,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": 210,
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": 210,
                                        "PublishedPriceRoundedOff": 210,
                                        "OfferedPrice": 197.400000000000005684341886080801486968994140625,
                                        "OfferedPriceRoundedOff": 197,
                                        "AgentCommission": 12.5999999999999996447286321199499070644378662109375,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.25,
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
                                    }
                                }
                            ],
                            [
                                {
                                    "ColumnNo": "000",
                                    "Height": 2,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "003",
                                    "SeatFare": 420,
                                    "SeatIndex": 6,
                                    "SeatName": "L1",
                                    "SeatStatus": true,
                                    "SeatType": 2,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": 420,
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": 420,
                                        "PublishedPriceRoundedOff": 420,
                                        "OfferedPrice": 394.80000000000001136868377216160297393798828125,
                                        "OfferedPriceRoundedOff": 395,
                                        "AgentCommission": 25.199999999999999289457264239899814128875732421875,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.5,
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
                                    }
                                },
                                {
                                    "ColumnNo": "002",
                                    "Height": 2,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "003",
                                    "SeatFare": 420,
                                    "SeatIndex": 14,
                                    "SeatName": "L2",
                                    "SeatStatus": true,
                                    "SeatType": 2,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": 420,
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": 420,
                                        "PublishedPriceRoundedOff": 420,
                                        "OfferedPrice": 394.80000000000001136868377216160297393798828125,
                                        "OfferedPriceRoundedOff": 395,
                                        "AgentCommission": 25.199999999999999289457264239899814128875732421875,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.5,
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
                                    }
                                },
                                {
                                    "ColumnNo": "004",
                                    "Height": 2,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "003",
                                    "SeatFare": 420,
                                    "SeatIndex": 22,
                                    "SeatName": "L3",
                                    "SeatStatus": true,
                                    "SeatType": 2,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": 420,
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": 420,
                                        "PublishedPriceRoundedOff": 420,
                                        "OfferedPrice": 394.80000000000001136868377216160297393798828125,
                                        "OfferedPriceRoundedOff": 395,
                                        "AgentCommission": 25.199999999999999289457264239899814128875732421875,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.5,
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
                                    }
                                },
                                {
                                    "ColumnNo": "006",
                                    "Height": 2,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "003",
                                    "SeatFare": 420,
                                    "SeatIndex": 30,
                                    "SeatName": "L4",
                                    "SeatStatus": true,
                                    "SeatType": 2,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": 420,
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": 420,
                                        "PublishedPriceRoundedOff": 420,
                                        "OfferedPrice": 394.80000000000001136868377216160297393798828125,
                                        "OfferedPriceRoundedOff": 395,
                                        "AgentCommission": 25.199999999999999289457264239899814128875732421875,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.5,
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
                                    }
                                },
                                {
                                    "ColumnNo": "008",
                                    "Height": 2,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "003",
                                    "SeatFare": 420,
                                    "SeatIndex": 38,
                                    "SeatName": "L5",
                                    "SeatStatus": true,
                                    "SeatType": 2,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": 420,
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": 420,
                                        "PublishedPriceRoundedOff": 420,
                                        "OfferedPrice": 394.80000000000001136868377216160297393798828125,
                                        "OfferedPriceRoundedOff": 395,
                                        "AgentCommission": 25.199999999999999289457264239899814128875732421875,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.5,
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
                                    }
                                }
                            ],
                            [
                                {
                                    "ColumnNo": "000",
                                    "Height": 2,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": true,
                                    "RowNo": "001",
                                    "SeatFare": 420,
                                    "SeatIndex": 1,
                                    "SeatName": "S2",
                                    "SeatStatus": true,
                                    "SeatType": 2,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": 420,
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": 420,
                                        "PublishedPriceRoundedOff": 420,
                                        "OfferedPrice": 394.80000000000001136868377216160297393798828125,
                                        "OfferedPriceRoundedOff": 395,
                                        "AgentCommission": 25.199999999999999289457264239899814128875732421875,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.5,
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
                                    }
                                },
                                {
                                    "ColumnNo": "002",
                                    "Height": 2,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": true,
                                    "RowNo": "001",
                                    "SeatFare": 420,
                                    "SeatIndex": 9,
                                    "SeatName": "S4",
                                    "SeatStatus": true,
                                    "SeatType": 2,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": 420,
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": 420,
                                        "PublishedPriceRoundedOff": 420,
                                        "OfferedPrice": 394.80000000000001136868377216160297393798828125,
                                        "OfferedPriceRoundedOff": 395,
                                        "AgentCommission": 25.199999999999999289457264239899814128875732421875,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.5,
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
                                    }
                                },
                                {
                                    "ColumnNo": "004",
                                    "Height": 2,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": true,
                                    "RowNo": "001",
                                    "SeatFare": 420,
                                    "SeatIndex": 17,
                                    "SeatName": "S6",
                                    "SeatStatus": true,
                                    "SeatType": 2,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": 420,
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": 420,
                                        "PublishedPriceRoundedOff": 420,
                                        "OfferedPrice": 394.80000000000001136868377216160297393798828125,
                                        "OfferedPriceRoundedOff": 395,
                                        "AgentCommission": 25.199999999999999289457264239899814128875732421875,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.5,
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
                                    }
                                },
                                {
                                    "ColumnNo": "006",
                                    "Height": 2,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": true,
                                    "RowNo": "001",
                                    "SeatFare": 420,
                                    "SeatIndex": 25,
                                    "SeatName": "S8",
                                    "SeatStatus": true,
                                    "SeatType": 2,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": 420,
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": 420,
                                        "PublishedPriceRoundedOff": 420,
                                        "OfferedPrice": 394.80000000000001136868377216160297393798828125,
                                        "OfferedPriceRoundedOff": 395,
                                        "AgentCommission": 25.199999999999999289457264239899814128875732421875,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.5,
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
                                    }
                                },
                                {
                                    "ColumnNo": "008",
                                    "Height": 2,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": true,
                                    "RowNo": "001",
                                    "SeatFare": 420,
                                    "SeatIndex": 33,
                                    "SeatName": "S10",
                                    "SeatStatus": true,
                                    "SeatType": 2,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": 420,
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": 420,
                                        "PublishedPriceRoundedOff": 420,
                                        "OfferedPrice": 394.80000000000001136868377216160297393798828125,
                                        "OfferedPriceRoundedOff": 395,
                                        "AgentCommission": 25.199999999999999289457264239899814128875732421875,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.5,
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
                                    }
                                }
                            ],
                            [
                                {
                                    "ColumnNo": "000",
                                    "Height": 2,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": true,
                                    "RowNo": "002",
                                    "SeatFare": 420,
                                    "SeatIndex": 2,
                                    "SeatName": "S1",
                                    "SeatStatus": true,
                                    "SeatType": 2,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": 420,
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": 420,
                                        "PublishedPriceRoundedOff": 420,
                                        "OfferedPrice": 394.80000000000001136868377216160297393798828125,
                                        "OfferedPriceRoundedOff": 395,
                                        "AgentCommission": 25.199999999999999289457264239899814128875732421875,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.5,
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
                                    }
                                },
                                {
                                    "ColumnNo": "002",
                                    "Height": 2,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": true,
                                    "RowNo": "002",
                                    "SeatFare": 420,
                                    "SeatIndex": 10,
                                    "SeatName": "S3",
                                    "SeatStatus": true,
                                    "SeatType": 2,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": 420,
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": 420,
                                        "PublishedPriceRoundedOff": 420,
                                        "OfferedPrice": 394.80000000000001136868377216160297393798828125,
                                        "OfferedPriceRoundedOff": 395,
                                        "AgentCommission": 25.199999999999999289457264239899814128875732421875,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.5,
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
                                    }
                                },
                                {
                                    "ColumnNo": "004",
                                    "Height": 2,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": true,
                                    "RowNo": "002",
                                    "SeatFare": 420,
                                    "SeatIndex": 18,
                                    "SeatName": "S5",
                                    "SeatStatus": true,
                                    "SeatType": 2,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": 420,
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": 420,
                                        "PublishedPriceRoundedOff": 420,
                                        "OfferedPrice": 394.80000000000001136868377216160297393798828125,
                                        "OfferedPriceRoundedOff": 395,
                                        "AgentCommission": 25.199999999999999289457264239899814128875732421875,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.5,
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
                                    }
                                },
                                {
                                    "ColumnNo": "006",
                                    "Height": 2,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": true,
                                    "RowNo": "002",
                                    "SeatFare": 420,
                                    "SeatIndex": 26,
                                    "SeatName": "S7",
                                    "SeatStatus": true,
                                    "SeatType": 2,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": 420,
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": 420,
                                        "PublishedPriceRoundedOff": 420,
                                        "OfferedPrice": 394.80000000000001136868377216160297393798828125,
                                        "OfferedPriceRoundedOff": 395,
                                        "AgentCommission": 25.199999999999999289457264239899814128875732421875,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.5,
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
                                    }
                                },
                                {
                                    "ColumnNo": "008",
                                    "Height": 2,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": true,
                                    "RowNo": "002",
                                    "SeatFare": 420,
                                    "SeatIndex": 34,
                                    "SeatName": "S9",
                                    "SeatStatus": true,
                                    "SeatType": 2,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": 420,
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": 420,
                                        "PublishedPriceRoundedOff": 420,
                                        "OfferedPrice": 394.80000000000001136868377216160297393798828125,
                                        "OfferedPriceRoundedOff": 395,
                                        "AgentCommission": 25.199999999999999289457264239899814128875732421875,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.5,
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
                                    }
                                }
                            ],
                            [
                                {
                                    "ColumnNo": "000",
                                    "Height": 2,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": true,
                                    "RowNo": "004",
                                    "SeatFare": 420,
                                    "SeatIndex": 3,
                                    "SeatName": "S11",
                                    "SeatStatus": true,
                                    "SeatType": 2,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": 420,
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": 420,
                                        "PublishedPriceRoundedOff": 420,
                                        "OfferedPrice": 394.80000000000001136868377216160297393798828125,
                                        "OfferedPriceRoundedOff": 395,
                                        "AgentCommission": 25.199999999999999289457264239899814128875732421875,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.5,
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
                                    }
                                },
                                {
                                    "ColumnNo": "002",
                                    "Height": 2,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": true,
                                    "RowNo": "004",
                                    "SeatFare": 420,
                                    "SeatIndex": 11,
                                    "SeatName": "S12",
                                    "SeatStatus": true,
                                    "SeatType": 2,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": 420,
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": 420,
                                        "PublishedPriceRoundedOff": 420,
                                        "OfferedPrice": 394.80000000000001136868377216160297393798828125,
                                        "OfferedPriceRoundedOff": 395,
                                        "AgentCommission": 25.199999999999999289457264239899814128875732421875,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.5,
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
                                    }
                                },
                                {
                                    "ColumnNo": "004",
                                    "Height": 2,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": true,
                                    "RowNo": "004",
                                    "SeatFare": 420,
                                    "SeatIndex": 19,
                                    "SeatName": "S13",
                                    "SeatStatus": true,
                                    "SeatType": 2,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": 420,
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": 420,
                                        "PublishedPriceRoundedOff": 420,
                                        "OfferedPrice": 394.80000000000001136868377216160297393798828125,
                                        "OfferedPriceRoundedOff": 395,
                                        "AgentCommission": 25.199999999999999289457264239899814128875732421875,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.5,
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
                                    }
                                },
                                {
                                    "ColumnNo": "006",
                                    "Height": 2,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": true,
                                    "RowNo": "004",
                                    "SeatFare": 420,
                                    "SeatIndex": 27,
                                    "SeatName": "S14",
                                    "SeatStatus": true,
                                    "SeatType": 2,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": 420,
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": 420,
                                        "PublishedPriceRoundedOff": 420,
                                        "OfferedPrice": 394.80000000000001136868377216160297393798828125,
                                        "OfferedPriceRoundedOff": 395,
                                        "AgentCommission": 25.199999999999999289457264239899814128875732421875,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.5,
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
                                    }
                                },
                                {
                                    "ColumnNo": "008",
                                    "Height": 2,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": true,
                                    "RowNo": "004",
                                    "SeatFare": 420,
                                    "SeatIndex": 35,
                                    "SeatName": "S15",
                                    "SeatStatus": true,
                                    "SeatType": 2,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": 420,
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": 420,
                                        "PublishedPriceRoundedOff": 420,
                                        "OfferedPrice": 394.80000000000001136868377216160297393798828125,
                                        "OfferedPriceRoundedOff": 395,
                                        "AgentCommission": 25.199999999999999289457264239899814128875732421875,
                                        "AgentMarkUp": 0,
                                        "TDS": 0.5,
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
                                    }
                                }
                            ]
                        ]
                    }
                }
            }
        }';
    }

    public static function busBlockStaticResponse()
    {
        return '{
            "code": "0x0200",
            "message": "success",
            "status": "SUCCESS",
            "data": {
                "TokenId": "72587378-8e96-47a4-a1b8-8705a6947471",
                "TraceId": "4c91e438-4f9f-476d-8b04-192f7cd3d762",
                "IsPriceChanged": false,
                "ArrivalTime": "01\\\/18\\\/2026 07:00:00",
                "BusType": "Volvo A\\\/C Seater\\\/Sleeper Luxury (2+2)",
                "DepartureTime": "01\\\/17\\\/2026 22:00:00",
                "ServiceName": "Seat Seller",
                "TravelName": "test-travels",
                "BoardingPointdetails": {
                    "CityPointIndex": 1,
                    "CityPointLocation": "Gomti Nagar, Lucknow",
                    "CityPointName": "Gomti Nagar, Lucknow (Pickup Bus)",
                    "CityPointTime": "2026-01-17T22:00:00"
                },
                "CancelPolicy": [
                    {
                        "CancellationCharge": 10,
                        "CancellationChargeType": 2,
                        "PolicyString": "Till 17:00 on 16 Jan 2026",
                        "TimeBeforeDept": "29$-1",
                        "FromDate": "2026-01-12T11:37:29",
                        "ToDate": "2026-01-16T17:00:00"
                    },
                    {
                        "CancellationCharge": 50,
                        "CancellationChargeType": 2,
                        "PolicyString": "Between 17:00 on 16 Jan 2026 - 05:00 on 17 Jan 2026",
                        "TimeBeforeDept": "17$29",
                        "FromDate": "2026-01-16T17:00:00",
                        "ToDate": "2026-01-17T05:00:00"
                    },
                    {
                        "CancellationCharge": 100,
                        "CancellationChargeType": 2,
                        "PolicyString": "After 05:00 on 17 Jan 2026",
                        "TimeBeforeDept": "0$17",
                        "FromDate": "2026-01-17T05:00:00",
                        "ToDate": "2026-01-18T07:00:00"
                    }
                ],
                "DropingPointdetails": null,
                "Passenger": [
                    {
                        "LeadPassenger": true,
                        "Title": "Mrs",
                        "Address": "lucknow",
                        "Age": 21,
                        "City": null,
                        "Email": "shivani@ipayments.org.in",
                        "FirstName": "Shivani",
                        "Gender": 2,
                        "IdNumber": null,
                        "IdType": null,
                        "LastName": "Pandey",
                        "Phoneno": "7007422419",
                        "Seat": {
                            "ColumnNo": "002",
                            "Height": 1,
                            "IsLadiesSeat": false,
                            "IsMalesSeat": false,
                            "IsUpper": false,
                            "RowNo": "000",
                            "SeatFare": 105,
                            "SeatIndex": 9,
                            "SeatName": "9",
                            "SeatStatus": true,
                            "SeatType": 1,
                            "Width": 1,
                            "Price": {
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
                            }
                        },
                        "State": null
                    }
                ]
            }
        }';
    }

    public static function busBookStaticResponse()
    {
        return '{"code":"0x0202","status":"FAILURE","message":"Insufficient funds "}';
        return '{
            "code": "0x0200",
            "message": "success",
            "status": "SUCCESS",
            "data": {
                "TokenId": "e93acaa6-7598-4f75-87cb-b48fd2a94aae",
                "TraceId": "8a066cd9-a597-46a5-b5c9-31c706340912",
                "BusBookingStatus": "Confirmed",
                "InvoiceAmount": -6,
                "InvoiceNumber": "MW/2526/22338",
                "BusId": 37310,
                "TicketNo": "2BJ44AEM",
                "TravelOperatorPNR": "2BJ44AEM"
            }
        }';
    }


    public static function busbookingdetailsresponse()
    {
        
        return '{"code":"0x0200","message":"success","status":"SUCCESS","data":{"TokenId":"6c1a81bd-74a6-45f4-ad02-decc1b96b395","TraceId":"9bbaec78-2a95-4627-8ea4-4ee8f3cf6b1a","Response":{"IsDomestic":false,"TicketNo":"2B3VTFMX","ArrivalTime":"2026-01-24T02:00:00","BlockDuration":7,"BookingMode":0,"BusId":37314,"BusType":"Mercedes Benz A\/C Seater\/Sleeper Multi Axle (2+3)","DateOfJourney":"2026-01-23","DepartureTime":"2026-01-23T19:00:00","Destination":"Hyderabad","DestinationId":9573,"NoOfSeats":3,"Origin":"Bangalore","Passenger":[{"LeadPassenger":true,"Title":"Mr","Address":"lko","Age":24,"City":"","Email":"shivani@ipayments.org.in","FirstName":"Sunil","Gender":1,"IdNumber":null,"IdType":null,"LastName":"Kumar","Phoneno":"8933099158","Seat":{"IsLadiesSeat":false,"IsMalesSeat":false,"IsUpper":false,"SeatFare":53,"SeatId":45392,"SeatName":"1","SeatStatus":false,"SeatType":2,"Price":{"CurrencyCode":"INR","BasePrice":52.5,"Tax":0,"OtherCharges":0,"Discount":0,"PublishedPrice":52.5,"PublishedPriceRoundedOff":53,"OfferedPrice":22.5,"OfferedPriceRoundedOff":23,"AgentCommission":30,"AgentMarkUp":0,"TDS":12,"GST":{"CGSTAmount":0,"CGSTRate":0,"CessAmount":0,"CessRate":0,"IGSTAmount":0,"IGSTRate":18,"SGSTAmount":0,"SGSTRate":0,"TaxableAmount":0}}},"State":""},{"LeadPassenger":false,"Title":"Mrs","Address":"lko","Age":22,"City":"","Email":"shivani@ipayments.org.in","FirstName":"Shivani","Gender":2,"IdNumber":null,"IdType":null,"LastName":"Pandey","Phoneno":"8933099158","Seat":{"IsLadiesSeat":false,"IsMalesSeat":false,"IsUpper":false,"SeatFare":53,"SeatId":45393,"SeatName":"2","SeatStatus":false,"SeatType":2,"Price":{"CurrencyCode":"INR","BasePrice":52.5,"Tax":0,"OtherCharges":0,"Discount":0,"PublishedPrice":52.5,"PublishedPriceRoundedOff":53,"OfferedPrice":22.5,"OfferedPriceRoundedOff":23,"AgentCommission":30,"AgentMarkUp":0,"TDS":12,"GST":{"CGSTAmount":0,"CGSTRate":0,"CessAmount":0,"CessRate":0,"IGSTAmount":0,"IGSTRate":18,"SGSTAmount":0,"SGSTRate":0,"TaxableAmount":0}}},"State":""},{"LeadPassenger":false,"Title":"Mr","Address":"lko","Age":15,"City":"","Email":"shivani@ipayments.org.in","FirstName":"Aman","Gender":1,"IdNumber":null,"IdType":null,"LastName":"Kumar","Phoneno":"8933099158","Seat":{"IsLadiesSeat":false,"IsMalesSeat":false,"IsUpper":false,"SeatFare":53,"SeatId":45394,"SeatName":"3","SeatStatus":false,"SeatType":2,"Price":{"CurrencyCode":"INR","BasePrice":52.5,"Tax":0,"OtherCharges":0,"Discount":0,"PublishedPrice":52.5,"PublishedPriceRoundedOff":53,"OfferedPrice":22.5,"OfferedPriceRoundedOff":23,"AgentCommission":30,"AgentMarkUp":0,"TDS":12,"GST":{"CGSTAmount":0,"CGSTRate":0,"CessAmount":0,"CessRate":0,"IGSTAmount":0,"IGSTRate":18,"SGSTAmount":0,"SGSTRate":0,"TaxableAmount":0}}},"State":""}],"RouteId":"2000000155010015796","ServiceName":"Seat Seller","SourceId":8463,"Status":2,"TravelName":"bogds186","TravelOperatorPNR":"2B3VTFMX","BoardingPointdetails":{"CityPointAddress":"","CityPointContactNumber":"","CityPointLandmark":"","CityPointLocation":"Peenya","CityPointName":"Peenya","CityPointTime":"2026-01-23T19:00:00"},"CancelPolicy":[{"CancellationCharge":10,"CancellationChargeType":2,"PolicyString":"Till 04:00 on 23 Jan 2026","TimeBeforeDept":"15$-1","FromDate":"2026-01-21T14:36:01","ToDate":"2026-01-23T04:00:00"},{"CancellationCharge":50,"CancellationChargeType":2,"PolicyString":"Between 04:00 on 23 Jan 2026 - 09:00 on 23 Jan 2026","TimeBeforeDept":"10$15","FromDate":"2026-01-23T04:00:00","ToDate":"2026-01-23T09:00:00"}],"Price":{"CurrencyCode":"INR","BasePrice":157.5,"Tax":0,"OtherCharges":0,"Discount":0,"PublishedPrice":157.5,"PublishedPriceRoundedOff":158,"OfferedPrice":67.5,"OfferedPriceRoundedOff":68,"AgentCommission":90,"AgentMarkUp":0,"TDS":36,"GST":{"CGSTAmount":0,"CGSTRate":0,"CessAmount":0,"CessRate":0,"IGSTAmount":0,"IGSTRate":18,"SGSTAmount":0,"SGSTRate":0,"TaxableAmount":0}},"InvoiceNumber":"MW\/2526\/22344","InvoiceCreatedOn":"2026-01-21T09:07:47","InvoiceCreatedBy":58200,"InvoiceAmount":104,"InvoiceCreatedByName":"Deepak Deepak","InvoiceLastModifiedBy":58200,"InvoiceLastModifiedByName":"Deepak Deepak","InvoiceStatus":3,"BookingHistory":[{"CreatedBy":58200,"CreatedByName":"Deepak Deepak","CreatedOn":"2026-01-21T09:07:47","EventCategory":1,"LastModifiedBy":58200,"LastModifiedByName":"Deepak Deepak","LastModifiedOn":"2026-01-21T09:07:47","Remarks":"Booking is Saved and Invoice Generated.(Booked By BookingAPI , through New BookingEngine Service). "},{"CreatedBy":58200,"CreatedByName":"Deepak Deepak","CreatedOn":"2026-01-21T09:08:20","EventCategory":2,"LastModifiedBy":58200,"LastModifiedByName":"Deepak Deepak","LastModifiedOn":"2026-01-21T09:08:20","Remarks":"Booking Confirmed "}]}}}';
    }

    public static function busCancelResponse()
    {
        return '{
            "status": "success",
            "message": "Bus Cancellation successfully",
            "data": {
                "TokenId": "d3ba7c96-7c6b-4baf-aa83-585c8b1d18a2",
                "Response": [
                    {
                        "CancellationChargeBreakUp": {
                            "CancellationFees": -8,
                            "CancellationServiceCharge": 0
                        },
                        "ChangeRequestId": 5701,
                        "CreditNoteNo": "MZ\/2526\/2368",
                        "ChangeRequestStatus": 3,
                        "CreditNoteCreatedOn": "2026-01-24T17:10:27",
                        "TotalPrice": -7.5,
                        "RefundedAmount": 0,
                        "CancellationCharge": -8,
                        "TotalServiceCharge": 0,
                        "TotalGSTAmount": 0,
                        "GST": {
                            "CGSTAmount": 0,
                            "CGSTRate": 0,
                            "CessAmount": 0,
                            "CessRate": 0,
                            "IGSTAmount": 0,
                            "IGSTRate": 0,
                            "SGSTAmount": 0,
                            "SGSTRate": 0,
                            "TaxableAmount": 0
                        }
                    }
                ]
            }
        }';
    }
}
