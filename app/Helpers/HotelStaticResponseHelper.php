<?php

namespace App\Helpers;

use PhpParser\Node\Stmt\Static_;

class HotelStaticResponseHelper
{
    static function hotelsearchresponse()
    {
        return '{
            "code": "0x0200",
            "message": "success",
            "status": "SUCCESS",
            "data": {
                "TraceId": "a71ebef5-42bb-4eaa-a2d7-94cf37d9d88a",
                "CityId": "130443",
                "Remarks": "india - land of mystries \"//\" \"  /// \"  ",
                "CheckInDate": "2026-04-23",
                "CheckOutDate": "2026-04-24",
                "PreferredCurrency": "INR",
                "NoOfRooms": 1,
                "RoomGuests": [
                    {
                        "NoOfAdults": 1,
                        "NoOfChild": 0,
                        "ChildAge": null
                    }
                ],
                "HotelResults": [
                    {
                        "IsHotDeal": false,
                        "ResultIndex": 5,
                        "HotelCode": "75019",
                        "HotelName": "OYO 1 Plus One Hotel Residency Near Nawada Metro Station",
                        "HotelCategory": "",
                        "StarRating": 3,
                        "HotelDescription": "Matiala Extension, Sukh Ram Park, Matiala, DelhiDid you know that we’ve got 2.5 Crore bookings since March 2020? And this is all thanks to the sanitisation &amp; safety measures followed at our properties, from disinfecting surfaces with high-quality cleaning products and maintaining social distance to using protective gear and more.LocationPlus One Hotel Residency is located in the well known Uttam Nagar area of Delhi. It is located right on Matiala Road and is surrounded by places like Chhath Pooja Ghaat, Bharat Garden, Shiv Mandir and Dwarika Medicare and Maternity Centre.Special FeaturesThis property has spacious rooms that have been well decorated with comfortable furniture. The decor is elegant and homely and each room has a beautiful false ceiling. Washrooms are clean and well maintained and the common areas are well furnished.AmenitiesWooden Floors, AC, Laundry service, Parking Facility, Geyser, Jacuzzi, Elevator, 24/7 Checkin, Room Service, Free Wifi, Modern Wardrobe, TV, Reception, Fire-Extinguisher, Bath Tub, Card Payment, Attached Bathroom, Mirror, CCTV Cameras, Power backup, Fan are among the amenities featured at this property for a comfortable stay.Whats NearbyEating joints and restaurantsnearby that serve delicious food are Grannys Flavour, Radhika Restaurant, Pizza Mania, Chatpata Tawa Tandoor and The Burger Club. ",
                        "HotelPromotion": "",
                        "HotelPolicy": "Check in After 12:00 PM|Check out Before 11:00 AM|No Triple Occupancy|Pure Vegetarian Kitchen|International Guests are Not Allowed|No Triple Occupancy | No Non Veg | No Pak/ Afghan/ Bang | specific_restrictions | One Liner | no_packages | No Foreign Guests |",
                        "Price": {
                            "CurrencyCode": "INR",
                            "RoomPrice": 803.1599999999999681676854379475116729736328125,
                            "Tax": 0,
                            "ExtraGuestCharge": 0,
                            "ChildCharge": 0,
                            "OtherCharges": 0,
                            "Discount": 0,
                            "PublishedPrice": 873,
                            "PublishedPriceRoundedOff": 873,
                            "OfferedPrice": 803.1599999999999681676854379475116729736328125,
                            "OfferedPriceRoundedOff": 803,
                            "AgentCommission": 69.840000000000003410605131648480892181396484375,
                            "AgentMarkUp": 0,
                            "ServiceTax": 0,
                            "TCS": 0,
                            "TDS": 0,
                            "ServiceCharge": 0,
                            "TotalGSTAmount": 0,
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
                        "HotelPicture": "https://images.oyoroomscdn.com/uploads/hotel_image/75019/80d102f43dbbb5bf.jpg",
                        "HotelAddress": "Matiala Extension, Sukh Ram Park, Matiala, 110059",
                        "HotelContactNo": "",
                        "HotelMap": null,
                        "Latitude": "28.6147",
                        "Longitude": "77.04683",
                        "HotelLocation": null,
                        "SupplierPrice": null,
                        "RoomDetails": []
                    },
                    {
                        "IsHotDeal": false,
                        "ResultIndex": 1,
                        "HotelCode": "106109",
                        "HotelName": "Capital O The Lazeez Hotel Near Lajpat Nagar Metro Station",
                        "HotelCategory": "",
                        "StarRating": 3,
                        "HotelDescription": "Did you know that we’ve got 2.5 Crore bookings since March 2020? And this is all thanks to the sanitisation &amp; safety measures followed at our properties, from disinfecting surfaces with high-quality cleaning products and maintaining social distance to using protective gear and more.Planning a trip to the lively city of Delhi? You might just love this stay option Lajpat Nagar. This location is the perfect mix of city life and greenery, and the stay itself well-designed, has lots of bright light, and the furniture is contemporary and comfortable. Do check out the view from here, which is quite spectacular.Getting there: The Lajpat Nagar Bus Stop and the Vinobapuri Metro Station, and also the Laj[at Nagar Railway Station are just 5 minutes away from the property.Whats nearby: Delhi is known for itâ€™s hearty and delicious food, which you can enjoy at places like Bikanervala Family Restaurant, Mazaar, and Kabul Delhi, which are 5-10 minutes away. You can also enjoy a movie at the nearby PVR 3Câ€™s Cinema, and then indulge in a relaxing evening at the Lala Lajpat Rai Memorial Park. ",
                        "HotelPromotion": "",
                        "HotelPolicy": "Check in After 12:00 PM|Check out Before 11:00 AM|International Guests are Not Allowed|specific_restrictions | One Liner | Sold Out | No Foreign Guests |",
                        "Price": {
                            "CurrencyCode": "INR",
                            "RoomPrice": 1223.59999999999990905052982270717620849609375,
                            "Tax": 0,
                            "ExtraGuestCharge": 0,
                            "ChildCharge": 0,
                            "OtherCharges": 0,
                            "Discount": 0,
                            "PublishedPrice": 1330,
                            "PublishedPriceRoundedOff": 1330,
                            "OfferedPrice": 1223.59999999999990905052982270717620849609375,
                            "OfferedPriceRoundedOff": 1224,
                            "AgentCommission": 106.400000000000005684341886080801486968994140625,
                            "AgentMarkUp": 0,
                            "ServiceTax": 0,
                            "TCS": 0,
                            "TDS": 0,
                            "ServiceCharge": 0,
                            "TotalGSTAmount": 0,
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
                        "HotelPicture": "https://images.oyoroomscdn.com/uploads/hotel_image/106109/1144cf68b16f889b.jpg",
                        "HotelAddress": "Block I, Lajpat Nagar Ii, Lajpat Nagar, 110024",
                        "HotelContactNo": "",
                        "HotelMap": null,
                        "Latitude": "28.5698651092765",
                        "Longitude": "77.24419394508004",
                        "HotelLocation": null,
                        "SupplierPrice": null,
                        "RoomDetails": []
                    },
                    {
                        "IsHotDeal": false,
                        "ResultIndex": 4,
                        "HotelCode": "106191",
                        "HotelName": "Super OYO KEY ROOMS TILAK NAGAR",
                        "HotelCategory": "",
                        "StarRating": 3,
                        "HotelDescription": "Near Tilak Nagar, Mukherji Park, DelhiDid you know that we’ve got 2.5 Crore bookings since March 2020? And this is all thanks to the sanitisation &amp; safety measures followed at our properties, from disinfecting surfaces with high-quality cleaning products and maintaining social distance to using protective gear and more.LocationLocated in Tilak Nagar, Delhi OYO Flagship 26722 is a warm and soothing property. It is close to attractions like Woodl and Park, Merino Galler, Kali Mata Mandir Dham, Shri Santoshi Mata Mandir, Nihal Vihar Park and Vir Savarkar Park.Special FeaturesThe property has nicely done rooms. The corridor is well-lit and airy.Amenities AC, TV and free internet are provided in the rooms. The property also provides other facilities like CCTV security, a refrigerator and card payment. There is a kitchen on the premises too.Whats NearbyPunjabi Ninja, Vege-Mitz, Flavour Of Momos, Biryani Lovers and Rolls Tiger are some famous restaurants nearby which can be tried for good food. ",
                        "HotelPromotion": "",
                        "HotelPolicy": "Check in After 12:00 PM|Check out Before 11:00 AM|specific_restrictions | One Liner |",
                        "Price": {
                            "CurrencyCode": "INR",
                            "RoomPrice": 1386.44000000000005456968210637569427490234375,
                            "Tax": 0,
                            "ExtraGuestCharge": 0,
                            "ChildCharge": 0,
                            "OtherCharges": 0,
                            "Discount": 0,
                            "PublishedPrice": 1507,
                            "PublishedPriceRoundedOff": 1507,
                            "OfferedPrice": 1386.44000000000005456968210637569427490234375,
                            "OfferedPriceRoundedOff": 1386,
                            "AgentCommission": 120.56000000000000227373675443232059478759765625,
                            "AgentMarkUp": 0,
                            "ServiceTax": 0,
                            "TCS": 0,
                            "TDS": 0,
                            "ServiceCharge": 0,
                            "TotalGSTAmount": 0,
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
                        "HotelPicture": "https://images.oyoroomscdn.com/uploads/hotel_image/106191/b2a3970f5f6bfa67.jpg",
                        "HotelAddress": "Gangaram Vatika, Tilak Nagar, 110018",
                        "HotelContactNo": "",
                        "HotelMap": null,
                        "Latitude": "28.64245",
                        "Longitude": "77.09876",
                        "HotelLocation": null,
                        "SupplierPrice": null,
                        "RoomDetails": []
                    },
                    {
                        "IsHotDeal": false,
                        "ResultIndex": 2,
                        "HotelCode": "106159",
                        "HotelName": "OYO Townhouse 278 Rohini Near Rithala Metro Station",
                        "HotelCategory": "",
                        "StarRating": 3,
                        "HotelDescription": "Near Near Dominos Sector 24, Rohini, Dasghara, DelhiDid you know that we’ve got 2.5 Crore bookings since March 2020? And this is all thanks to the sanitisation &amp; safety measures followed at our properties, from disinfecting surfaces with high-quality cleaning products and maintaining social distance to using protective gear and more.LocationLocated in Sector 24 Rohini, Flagship is located very close to popular malls and shopping complexes. Special FeaturesThe property has a modern look to its overall decor with extensive and beautiful marble work done in the lobby. A kitchen is provided for guests who want to prepare quick meals.AmenitiesThe hotel has roundtheclock power backup , CCTV Camera, AC, king size beds, free WiFi and television.Whats NearbyFor great street food, head to Wah Ji Wah and Lalaji. Chinese Hut and The Big Bun offer good fast food options. ",
                        "HotelPromotion": "",
                        "HotelPolicy": "Check in After 12:00 PM|Check out Before 11:00 AM|specific_restrictions |",
                        "Price": {
                            "CurrencyCode": "INR",
                            "RoomPrice": 1768.240000000000009094947017729282379150390625,
                            "Tax": 0,
                            "ExtraGuestCharge": 0,
                            "ChildCharge": 0,
                            "OtherCharges": 0,
                            "Discount": 0,
                            "PublishedPrice": 1922,
                            "PublishedPriceRoundedOff": 1922,
                            "OfferedPrice": 1768.240000000000009094947017729282379150390625,
                            "OfferedPriceRoundedOff": 1768,
                            "AgentCommission": 153.759999999999990905052982270717620849609375,
                            "AgentMarkUp": 0,
                            "ServiceTax": 0,
                            "TCS": 0,
                            "TDS": 0,
                            "ServiceCharge": 0,
                            "TotalGSTAmount": 0,
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
                        "HotelPicture": "https://images.oyoroomscdn.com/uploads/hotel_image/106159/f642e25e448493d9.jpg",
                        "HotelAddress": "Pocket 27, Sector-24, Rohini, 110085",
                        "HotelContactNo": "",
                        "HotelMap": null,
                        "Latitude": "28.73288",
                        "Longitude": "77.08628",
                        "HotelLocation": null,
                        "SupplierPrice": null,
                        "RoomDetails": []
                    },
                    {
                        "IsHotDeal": false,
                        "ResultIndex": 3,
                        "HotelCode": "106185",
                        "HotelName": "OYO Townhouse 610 Derawal Nagar",
                        "HotelCategory": "",
                        "StarRating": 3,
                        "HotelDescription": "Near Vinayak Hoptiat, Gujranwala Town, DelhiDid you know that we’ve got 2.5 Crore bookings since March 2020? And this is all thanks to the sanitisation &amp; safety measures followed at our properties, from disinfecting surfaces with high-quality cleaning products and maintaining social distance to using protective gear and more.The rooms are spacious and elegant as well as well-organised. Even the bathrooms are clean and hygienic and well-designed at this place. Location The place is located near Vinayak Hospital, Delhi.  Amenities  The rooms have beds with various options such as single beds, twin-single beds, queen-size beds and king-size beds along with bathrooms, TV, fan, a centre table and AC. Some additional facilities provided by this place are a seating area, coffee/tea maker, coffee/tea maker and mini-fridge. Whats Nearby  There are some food joints near to this place where one can enjoy food which is delicious and sumptuous. One should try these food joints for a variety of food dishes that are available over here. Expand your taste buds by trying out new flavours. ",
                        "HotelPromotion": "",
                        "HotelPolicy": "Check in After 12:00 PM|Check out Before 11:00 AM|No Triple Occupancy|International Guests are Not Allowed|No Triple Occupancy | No Pak/ Afghan/ Bang | specific_restrictions | One Liner | Sold Out | No Smoking | No Foreign Guests |",
                        "Price": {
                            "CurrencyCode": "INR",
                            "RoomPrice": 2633.0399999999999636202119290828704833984375,
                            "Tax": 0,
                            "ExtraGuestCharge": 0,
                            "ChildCharge": 0,
                            "OtherCharges": 0,
                            "Discount": 0,
                            "PublishedPrice": 2862,
                            "PublishedPriceRoundedOff": 2862,
                            "OfferedPrice": 2633.0399999999999636202119290828704833984375,
                            "OfferedPriceRoundedOff": 2633,
                            "AgentCommission": 228.960000000000007958078640513122081756591796875,
                            "AgentMarkUp": 0,
                            "ServiceTax": 0,
                            "TCS": 0,
                            "TDS": 0,
                            "ServiceCharge": 0,
                            "TotalGSTAmount": 0,
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
                        "HotelPicture": "https://images.oyoroomscdn.com/uploads/hotel_image/106185/7fbeef5b113b2e24.jpg",
                        "HotelAddress": "Lala Achintaram Marg, Derawal Nagar, 110009",
                        "HotelContactNo": "",
                        "HotelMap": null,
                        "Latitude": "28.69968",
                        "Longitude": "77.19017693772912",
                        "HotelLocation": null,
                        "SupplierPrice": null,
                        "RoomDetails": []
                    }
                ]
            }
        }';
    }

    static function hoteldetailsresponse(){
        return '{
            "code": "0x0200",
            "message": "success",
            "status": "SUCCESS",
            "data": {
                "TokenId": "256e61b3-70e0-4500-80f1-2e932b2abe83",
                "TraceId": "ab377c8a-5251-4222-bef7-0ada495e42e4",
                "HotelDetails": {
                    "HotelCode": "75019",
                    "HotelName": "OYO 1 Plus One Hotel Residency Near Nawada Metro Station",
                    "StarRating": 3,
                    "HotelURL": null,
                    "Description": "Matiala Extension, Sukh Ram Park, Matiala, DelhiDid you know that we’ve got 2.5 Crore bookings since March 2020? And this is all thanks to the sanitisation &amp; safety measures followed at our properties, from disinfecting surfaces with high-quality cleaning products and maintaining social distance to using protective gear and more.LocationPlus One Hotel Residency is located in the well known Uttam Nagar area of Delhi. It is located right on Matiala Road and is surrounded by places like Chhath Pooja Ghaat, Bharat Garden, Shiv Mandir and Dwarika Medicare and Maternity Centre.Special FeaturesThis property has spacious rooms that have been well decorated with comfortable furniture. The decor is elegant and homely and each room has a beautiful false ceiling. Washrooms are clean and well maintained and the common areas are well furnished.AmenitiesWooden Floors, AC, Laundry service, Parking Facility, Geyser, Jacuzzi, Elevator, 24/7 Checkin, Room Service, Free Wifi, Modern Wardrobe, TV, Reception, Fire-Extinguisher, Bath Tub, Card Payment, Attached Bathroom, Mirror, CCTV Cameras, Power backup, Fan are among the amenities featured at this property for a comfortable stay.Whats NearbyEating joints and restaurantsnearby that serve delicious food are Grannys Flavour, Radhika Restaurant, Pizza Mania, Chatpata Tawa Tandoor and The Burger Club.&nbsp; <br />",
                    "Attractions": null,
                    "HotelFacilities": [
                        "Geyser",
                        "Lift/elevator"
                    ],
                    "HotelPolicy": "Check in After 12:00 PM|Check out Before 11:00 AM|No Triple Occupancy|Pure Vegetarian Kitchen|International Guests are Not Allowed|No Triple Occupancy | No Non Veg | No Pak/ Afghan/ Bang | specific_restrictions | One Liner | no_packages | No Foreign Guests ||",
                    "SpecialInstructions": null,
                    "HotelPicture": null,
                    "Images": [
                        "https://images.oyoroomscdn.com/uploads/hotel_image/75019/80d102f43dbbb5bf.jpg",
                        "https://images.oyoroomscdn.com/uploads/hotel_image/75019/a45017e59ab56ccb.jpg",
                        "https://images.oyoroomscdn.com/uploads/hotel_image/75019/3824fc90bd8fdfa5.jpg",
                        "https://images.oyoroomscdn.com/uploads/hotel_image/75019/1e3faf1aa133bcb1.jpg",
                        "https://images.oyoroomscdn.com/uploads/hotel_image/75019/5a1727d2495d49a4.jpg",
                        "https://images.oyoroomscdn.com/uploads/hotel_image/75019/60802f25cd450877.jpg",
                        "https://images.oyoroomscdn.com/uploads/hotel_image/75019/bde7289bccc74252.jpg",
                        "https://images.oyoroomscdn.com/uploads/hotel_image/75019/3c3bd9b0b4bfe742.jpg",
                        "https://images.oyoroomscdn.com/uploads/hotel_image/75019/f9f707554f07cd7b.jpg",
                        "https://images.oyoroomscdn.com/uploads/hotel_image/75019/ee4d639d7d5191ab.jpg",
                        "https://images.oyoroomscdn.com/uploads/hotel_image/75019/660b3116bdced3b4.jpg",
                        "https://images.oyoroomscdn.com/uploads/hotel_image/75019/686d7968c2a247c4.jpg",
                        "https://images.oyoroomscdn.com/uploads/hotel_image/75019/37f99b96f8cccc33.jpg",
                        "https://images.oyoroomscdn.com/uploads/hotel_image/75019/d06cd5e6587a010e.jpg",
                        "https://images.oyoroomscdn.com/uploads/hotel_image/75019/a5e5240959b4986f.jpg",
                        "https://images.oyoroomscdn.com/uploads/hotel_image/75019/577d4a031685f73f.jpg",
                        "https://images.oyoroomscdn.com/uploads/hotel_image/75019/dceebe8950393b74.jpg",
                        "https://images.oyoroomscdn.com/uploads/hotel_image/75019/7c9171ba7af0ebec.jpg",
                        "https://images.oyoroomscdn.com/uploads/hotel_image/75019/4959585e69668642.jpg",
                        "https://images.oyoroomscdn.com/uploads/hotel_image/75019/9e55e0604550e9b9.jpg",
                        "https://images.oyoroomscdn.com/uploads/hotel_image/75019/d8e9c66a891f373e.jpg",
                        "https://images.oyoroomscdn.com/uploads/hotel_image/75019/9681eef228d7e8cb.jpg"
                    ],
                    "Address": "Matiala Extension, Sukh Ram Park, Matiala, ",
                    "CountryName": "",
                    "PinCode": "110059",
                    "HotelContactNo": null,
                    "FaxNumber": null,
                    "Email": null,
                    "Latitude": "28.6147",
                    "Longitude": "77.04683",
                    "RoomData": null,
                    "RoomFacilities": null,
                    "Services": null
                }
            }
        }';
    }

    static function hotelroomresponse(){
        return '{
            "code": "0x0200",
            "message": "success",
            "status": "SUCCESS",
            "data": {
                "TokenId": "256e61b3-70e0-4500-80f1-2e932b2abe83",
                "TraceId": "ab377c8a-5251-4222-bef7-0ada495e42e4",
                "IsPolicyPerStay": true,
                "IsUnderCancellationAllowed": true,
                "HotelRoomsDetails": [
                    {
                        "AvailabilityType": "Confirm",
                        "ChildCount": 0,
                        "IsTransferIncluded": false,
                        "RequireAllPaxDetails": false,
                        "RoomId": 0,
                        "RoomStatus": 0,
                        "RoomIndex": 1,
                        "RoomTypeCode": "75019|1|0",
                        "RoomDescription": "Classic",
                        "RoomTypeName": "OYO - Classic",
                        "RatePlanCode": "75019|1|0_1|0|0",
                        "RatePlan": 13,
                        "InfoSource": "FixedCombination",
                        "SequenceNo": "OYO~75019~0",
                        "DayRates": [
                            {
                                "Amount": 803.1599999999999681676854379475116729736328125,
                                "Date": "2026-04-23T00:00:00"
                            }
                        ],
                        "IsPerStay": false,
                        "SupplierPrice": null,
                        "Price": {
                            "CurrencyCode": "INR",
                            "RoomPrice": 803.1599999999999681676854379475116729736328125,
                            "Tax": 0,
                            "ExtraGuestCharge": 0,
                            "ChildCharge": 0,
                            "OtherCharges": 0,
                            "Discount": 0,
                            "PublishedPrice": 873,
                            "PublishedPriceRoundedOff": 873,
                            "OfferedPrice": 803.1599999999999681676854379475116729736328125,
                            "OfferedPriceRoundedOff": 803,
                            "AgentCommission": 69.840000000000003410605131648480892181396484375,
                            "AgentMarkUp": 0,
                            "ServiceTax": 0,
                            "TCS": 0,
                            "TDS": 27.940000000000001278976924368180334568023681640625,
                            "ServiceCharge": 0,
                            "TotalGSTAmount": 0,
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
                        "RoomPromotion": "",
                        "Amenities": [
                            "Free Breakfast"
                        ],
                        "Amenity": [],
                        "SmokingPreference": "NoPreference",
                        "BedTypes": [],
                        "HotelSupplements": [],
                        "LastCancellationDate": "2026-03-18T23:59:59",
                        "CancellationPolicies": [
                            {
                                "Charge": 100,
                                "ChargeType": 2,
                                "Currency": "INR",
                                "FromDate": "2026-03-19T00:00:00",
                                "ToDate": "2026-04-12T23:59:59"
                            },
                            {
                                "Charge": 100,
                                "ChargeType": 2,
                                "Currency": "INR",
                                "FromDate": "2026-04-13T00:00:00",
                                "ToDate": "2026-04-24T23:59:59"
                            }
                        ],
                        "LastVoucherDate": "2026-03-19T00:00:00",
                        "CancellationPolicy": "100.00% of total amount will be charged, If cancelled between 19-Mar-2026 00:00:00 and 12-Apr-2026 23:59:59.|100.00% of total amount will be charged, If cancelled between 13-Apr-2026 00:00:00 and 24-Apr-2026 23:59:59.|#!#",
                        "Inclusion": [
                            "Free Breakfast"
                        ],
                        "IsPassportMandatory": false,
                        "IsPANMandatory": false,
                        "BeddingGroup": null
                    }
                ],
                "RoomCombinations": {
                    "InfoSource": "FixedCombination",
                    "IsPolicyPerStay": true,
                    "RoomCombination": [
                        {
                            "RoomIndex": [
                                1
                            ]
                        }
                    ]
                }
            }
        }';
    }
}
