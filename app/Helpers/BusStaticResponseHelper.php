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
            "code": "0x0200",
            "message": "success",
            "status": "SUCCESS",
            "data": {
                "TokenId": "f5d0714f-3b37-4f76-b039-c28a5554bcf2",
                "TraceId": "ba4fb27b-3559-44c2-8ada-7f401e0c9fd6",
                "FareRules": {
                    "AvailableSeats": "22",
                    "HTMLLayout": "<div class=\'outerseat\'><div class=\'busSeatlft\'><div class=\'upper\'></div></div><div class=\'busSeatrgt\'><div class=\'busSeat\'><div class=\'seatcontainer clearfix\'><div id=\"200203735478003078617\"  style=\"top:0px;left:0px;display:block;\" class=\"hseat\" onclick=\"javascript:AddRemoveSeat(TBSelectedSeats.value,\'17\',TBSelectedSeatsPrice.value,\'210.00\')\"></div><div id=\"200203735478003078621\"  style=\"top:0px;left:45px;display:block;\" class=\"bhseat\"></div><div id=\"200203735478003078618\"  style=\"top:30px;left:0px;display:block;\" class=\"hseat\" onclick=\"javascript:AddRemoveSeat(TBSelectedSeats.value,\'18\',TBSelectedSeatsPrice.value,\'210.00\')\"></div><div id=\"200203735478003078622\"  style=\"top:30px;left:45px;display:block;\" class=\"bhseat\"></div><div id=\"200203735478003078619\"  style=\"top:100px;left:0px;display:block;\" class=\"hseat\" onclick=\"javascript:AddRemoveSeat(TBSelectedSeats.value,\'19\',TBSelectedSeatsPrice.value,\'210.00\')\"></div><div id=\"200203735478003078623\"  style=\"top:100px;left:45px;display:block;\" class=\"rhseat\" onclick=\"javascript:AddRemoveSeat(TBSelectedSeats.value,\'23\',TBSelectedSeatsPrice.value,\'210.00\')\"></div><div id=\"200203735478003078620\"  style=\"top:130px;left:0px;display:block;\" class=\"hseat\" onclick=\"javascript:AddRemoveSeat(TBSelectedSeats.value,\'20\',TBSelectedSeatsPrice.value,\'210.00\')\"></div><div id=\"200203735478003078624\"  style=\"top:130px;left:45px;display:block;\" class=\"rhseat\" onclick=\"javascript:AddRemoveSeat(TBSelectedSeats.value,\'24\',TBSelectedSeatsPrice.value,\'210.00\')\"></div></div></div></div><div class=\'clr\'></div></div><div class=\'outerlowerseat\'><div class=\'busSeatlft\'><div class=\'lower\'></div></div><div class=\'busSeatrgt\'><div class=\'busSeat\'><div class=\'seatcontainer clearfix\'><div id=\"20020373547800307861\"  style=\"top:0px;left:0px;display:block;\" class=\"nseat\" onclick=\"javascript:AddRemoveSeat(TBSelectedSeats.value,\'1\',TBSelectedSeatsPrice.value,\'105.00\')\"></div><div id=\"20020373547800307865\"  style=\"top:0px;left:25px;display:block;\" class=\"nseat\" onclick=\"javascript:AddRemoveSeat(TBSelectedSeats.value,\'5\',TBSelectedSeatsPrice.value,\'105.00\')\"></div><div id=\"20020373547800307869\"  style=\"top:0px;left:50px;display:block;\" class=\"nseat\" onclick=\"javascript:AddRemoveSeat(TBSelectedSeats.value,\'9\',TBSelectedSeatsPrice.value,\'105.00\')\"></div><div id=\"200203735478003078613\" style=\"top:0px;left:75px;display:block;\" class=\"rseat\" onclick=\"javascript:AddRemoveSeat(TBSelectedSeats.value,\'13\',TBSelectedSeatsPrice.value,\'105.00\')\"></div><div id=\"20020373547800307862\"  style=\"top:30px;left:0px;display:block;\" class=\"nseat\" onclick=\"javascript:AddRemoveSeat(TBSelectedSeats.value,\'2\',TBSelectedSeatsPrice.value,\'105.00\')\"></div><div id=\"20020373547800307866\"  style=\"top:30px;left:25px;display:block;\" class=\"nseat\" onclick=\"javascript:AddRemoveSeat(TBSelectedSeats.value,\'6\',TBSelectedSeatsPrice.value,\'105.00\')\"></div><div id=\"200203735478003078610\"  style=\"top:30px;left:50px;display:block;\" class=\"nseat\" onclick=\"javascript:AddRemoveSeat(TBSelectedSeats.value,\'10\',TBSelectedSeatsPrice.value,\'105.00\')\"></div><div id=\"200203735478003078614\" style=\"top:30px;left:75px;display:block;\" class=\"rseat\" onclick=\"javascript:AddRemoveSeat(TBSelectedSeats.value,\'14\',TBSelectedSeatsPrice.value,\'105.00\')\"></div><div id=\"20020373547800307863\"  style=\"top:80px;left:0px;display:block;\" class=\"nseat\" onclick=\"javascript:AddRemoveSeat(TBSelectedSeats.value,\'3\',TBSelectedSeatsPrice.value,\'105.00\')\"></div><div id=\"20020373547800307867\"  style=\"top:80px;left:25px;display:block;\" class=\"nseat\" onclick=\"javascript:AddRemoveSeat(TBSelectedSeats.value,\'7\',TBSelectedSeatsPrice.value,\'105.00\')\"></div><div id=\"200203735478003078611\"  style=\"top:80px;left:50px;display:block;\" class=\"nseat\" onclick=\"javascript:AddRemoveSeat(TBSelectedSeats.value,\'11\',TBSelectedSeatsPrice.value,\'105.00\')\"></div><div id=\"200203735478003078615\"  style=\"top:80px;left:75px;display:block;\" class=\"nseat\" onclick=\"javascript:AddRemoveSeat(TBSelectedSeats.value,\'15\',TBSelectedSeatsPrice.value,\'105.00\')\"></div><div id=\"20020373547800307864\"  style=\"top:110px;left:0px;display:block;\" class=\"nseat\" onclick=\"javascript:AddRemoveSeat(TBSelectedSeats.value,\'4\',TBSelectedSeatsPrice.value,\'105.00\')\"></div><div id=\"20020373547800307868\"  style=\"top:110px;left:25px;display:block;\" class=\"nseat\" onclick=\"javascript:AddRemoveSeat(TBSelectedSeats.value,\'8\',TBSelectedSeatsPrice.value,\'105.00\')\"></div><div id=\"200203735478003078612\"  style=\"top:110px;left:50px;display:block;\" class=\"nseat\" onclick=\"javascript:AddRemoveSeat(TBSelectedSeats.value,\'12\',TBSelectedSeatsPrice.value,\'105.00\')\"></div><div id=\"200203735478003078616\"  style=\"top:110px;left:75px;display:block;\" class=\"nseat\" onclick=\"javascript:AddRemoveSeat(TBSelectedSeats.value,\'16\',TBSelectedSeatsPrice.value,\'105.00\')\"></div></div></div></div><div class=\'clr\'></div></div>",
                    "SeatLayout": {
                        "NoOfColumns": 1,
                        "NoOfRows": 8,
                        "SeatDetails": [
                            [
                                {
                                    "ColumnNo": "000",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "000",
                                    "SeatFare": 105,
                                    "SeatIndex": 1,
                                    "SeatName": "1",
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
                                {
                                    "ColumnNo": "001",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "000",
                                    "SeatFare": 105,
                                    "SeatIndex": 5,
                                    "SeatName": "5",
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
                                {
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
                                {
                                    "ColumnNo": "003",
                                    "Height": 1,
                                    "IsLadiesSeat": true,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "000",
                                    "SeatFare": 105,
                                    "SeatIndex": 13,
                                    "SeatName": "13",
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
                                    "SeatFare": 105,
                                    "SeatIndex": 2,
                                    "SeatName": "2",
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
                                {
                                    "ColumnNo": "001",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "001",
                                    "SeatFare": 105,
                                    "SeatIndex": 6,
                                    "SeatName": "6",
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
                                {
                                    "ColumnNo": "002",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "001",
                                    "SeatFare": 105,
                                    "SeatIndex": 10,
                                    "SeatName": "10",
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
                                {
                                    "ColumnNo": "003",
                                    "Height": 1,
                                    "IsLadiesSeat": true,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "001",
                                    "SeatFare": 105,
                                    "SeatIndex": 14,
                                    "SeatName": "14",
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
                                }
                            ],
                            [
                                {
                                    "ColumnNo": "000",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "003",
                                    "SeatFare": 105,
                                    "SeatIndex": 3,
                                    "SeatName": "3",
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
                                {
                                    "ColumnNo": "001",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "003",
                                    "SeatFare": 105,
                                    "SeatIndex": 7,
                                    "SeatName": "7",
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
                                {
                                    "ColumnNo": "002",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "003",
                                    "SeatFare": 105,
                                    "SeatIndex": 11,
                                    "SeatName": "11",
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
                                {
                                    "ColumnNo": "003",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "003",
                                    "SeatFare": 105,
                                    "SeatIndex": 15,
                                    "SeatName": "15",
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
                                }
                            ],
                            [
                                {
                                    "ColumnNo": "000",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "004",
                                    "SeatFare": 105,
                                    "SeatIndex": 4,
                                    "SeatName": "4",
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
                                {
                                    "ColumnNo": "001",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "004",
                                    "SeatFare": 105,
                                    "SeatIndex": 8,
                                    "SeatName": "8",
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
                                {
                                    "ColumnNo": "002",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "004",
                                    "SeatFare": 105,
                                    "SeatIndex": 12,
                                    "SeatName": "12",
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
                                {
                                    "ColumnNo": "003",
                                    "Height": 1,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": false,
                                    "RowNo": "004",
                                    "SeatFare": 105,
                                    "SeatIndex": 16,
                                    "SeatName": "16",
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
                                }
                            ],
                            [
                                {
                                    "ColumnNo": "000",
                                    "Height": 2,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": true,
                                    "RowNo": "000",
                                    "SeatFare": 210,
                                    "SeatIndex": 17,
                                    "SeatName": "17",
                                    "SeatStatus": true,
                                    "SeatType": 2,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": 210,
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": 210,
                                        "PublishedPriceRoundedOff": 210,
                                        "OfferedPrice": 180,
                                        "OfferedPriceRoundedOff": 180,
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
                                {
                                    "ColumnNo": "002",
                                    "Height": 2,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": true,
                                    "RowNo": "000",
                                    "SeatFare": 210,
                                    "SeatIndex": 21,
                                    "SeatName": "21",
                                    "SeatStatus": false,
                                    "SeatType": 2,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": 210,
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": 210,
                                        "PublishedPriceRoundedOff": 210,
                                        "OfferedPrice": 180,
                                        "OfferedPriceRoundedOff": 180,
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
                                    "SeatFare": 210,
                                    "SeatIndex": 18,
                                    "SeatName": "18",
                                    "SeatStatus": true,
                                    "SeatType": 2,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": 210,
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": 210,
                                        "PublishedPriceRoundedOff": 210,
                                        "OfferedPrice": 180,
                                        "OfferedPriceRoundedOff": 180,
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
                                {
                                    "ColumnNo": "002",
                                    "Height": 2,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": true,
                                    "RowNo": "001",
                                    "SeatFare": 210,
                                    "SeatIndex": 22,
                                    "SeatName": "22",
                                    "SeatStatus": false,
                                    "SeatType": 2,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": 210,
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": 210,
                                        "PublishedPriceRoundedOff": 210,
                                        "OfferedPrice": 180,
                                        "OfferedPriceRoundedOff": 180,
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
                                }
                            ],
                            [
                                {
                                    "ColumnNo": "000",
                                    "Height": 2,
                                    "IsLadiesSeat": false,
                                    "IsMalesSeat": false,
                                    "IsUpper": true,
                                    "RowNo": "003",
                                    "SeatFare": 210,
                                    "SeatIndex": 19,
                                    "SeatName": "19",
                                    "SeatStatus": true,
                                    "SeatType": 2,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": 210,
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": 210,
                                        "PublishedPriceRoundedOff": 210,
                                        "OfferedPrice": 180,
                                        "OfferedPriceRoundedOff": 180,
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
                                {
                                    "ColumnNo": "002",
                                    "Height": 2,
                                    "IsLadiesSeat": true,
                                    "IsMalesSeat": false,
                                    "IsUpper": true,
                                    "RowNo": "003",
                                    "SeatFare": 210,
                                    "SeatIndex": 23,
                                    "SeatName": "23",
                                    "SeatStatus": true,
                                    "SeatType": 2,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": 210,
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": 210,
                                        "PublishedPriceRoundedOff": 210,
                                        "OfferedPrice": 180,
                                        "OfferedPriceRoundedOff": 180,
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
                                    "SeatFare": 210,
                                    "SeatIndex": 20,
                                    "SeatName": "20",
                                    "SeatStatus": true,
                                    "SeatType": 2,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": 210,
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": 210,
                                        "PublishedPriceRoundedOff": 210,
                                        "OfferedPrice": 180,
                                        "OfferedPriceRoundedOff": 180,
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
                                {
                                    "ColumnNo": "002",
                                    "Height": 2,
                                    "IsLadiesSeat": true,
                                    "IsMalesSeat": false,
                                    "IsUpper": true,
                                    "RowNo": "004",
                                    "SeatFare": 210,
                                    "SeatIndex": 24,
                                    "SeatName": "24",
                                    "SeatStatus": true,
                                    "SeatType": 2,
                                    "Width": 1,
                                    "Price": {
                                        "CurrencyCode": "INR",
                                        "BasePrice": 210,
                                        "Tax": 0,
                                        "OtherCharges": 0,
                                        "Discount": 0,
                                        "PublishedPrice": 210,
                                        "PublishedPriceRoundedOff": 210,
                                        "OfferedPrice": 180,
                                        "OfferedPriceRoundedOff": 180,
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
