<?php

namespace App\Helpers;

use PhpParser\Node\Stmt\Static_;

class HotelStaticResponseHelper
{
    static function hotelcountryresponse()
    {
        return '{
        "code": "0x0200",
        "message": "success",
        "status": "SUCCESS",
        "data": {
            "CountryList": [
                    {
                        "Code": "AF",
                        "Name": "Afghanistan"
                    },
                    {
                        "Code": "AL",
                        "Name": "Albania"
                    },
                    {
                        "Code": "DZ",
                        "Name": "Algeria"
                    },
                    {
                        "Code": "AS",
                        "Name": "American Samoa"
                    },
                    {
                        "Code": "AD",
                        "Name": "Andorra"
                    },
                    {
                        "Code": "AO",
                        "Name": "Angola"
                    },
                    {
                        "Code": "AI",
                        "Name": "Anguilla"
                    },
                    {
                        "Code": "AQ",
                        "Name": "Antarctica"
                    },
                    {
                        "Code": "AG",
                        "Name": "Antigua & Barbuda"
                    },
                    {
                        "Code": "AR",
                        "Name": "Argentina"
                    },
                    {
                        "Code": "AM",
                        "Name": "Armenia"
                    },
                    {
                        "Code": "AW",
                        "Name": "Aruba"
                    },
                    {
                        "Code": "AU",
                        "Name": "Australia"
                    },
                    {
                        "Code": "AT",
                        "Name": "Austria"
                    },
                    {
                        "Code": "AZ",
                        "Name": "Azerbaijan"
                    },
                    {
                        "Code": "BS",
                        "Name": "Bahamas"
                    },
                    {
                        "Code": "BH",
                        "Name": "Bahrain"
                    },
                    {
                        "Code": "BD",
                        "Name": "Bangladesh"
                    },
                    {
                        "Code": "BB",
                        "Name": "Barbados"
                    },
                    {
                        "Code": "BY",
                        "Name": "Belarus (Belorussia)"
                    },
                    {
                        "Code": "BE",
                        "Name": "Belgium"
                    },
                    {
                        "Code": "BZ",
                        "Name": "Belize"
                    },
                    {
                        "Code": "BJ",
                        "Name": "Benin"
                    },
                    {
                        "Code": "BM",
                        "Name": "Bermuda"
                    },
                    {
                        "Code": "BT",
                        "Name": "Bhutan"
                    },
                    {
                        "Code": "BO",
                        "Name": "Bolivia"
                    },
                    {
                        "Code": "BQ",
                        "Name": "Bonaire Saba Sint Eustatius"
                    },
                    {
                        "Code": "BA",
                        "Name": "Bosnia and Herzegowina"
                    },
                    {
                        "Code": "BW",
                        "Name": "Botswana"
                    },
                    {
                        "Code": "BV",
                        "Name": "Bouvet Islands"
                    },
                    {
                        "Code": "BR",
                        "Name": "Brazil"
                    },
                    {
                        "Code": "IO",
                        "Name": "British Indian Ocean Territory"
                    },
                    {
                        "Code": "VG",
                        "Name": "British Virgin Islands"
                    },
                    {
                        "Code": "BN",
                        "Name": "Brunei Darussalam"
                    },
                    {
                        "Code": "BG",
                        "Name": "Bulgaria"
                    },
                    {
                        "Code": "BF",
                        "Name": "Burkina Faso"
                    },
                    {
                        "Code": "BI",
                        "Name": "Burundi"
                    },
                    {
                        "Code": "KH",
                        "Name": "Cambodia"
                    },
                    {
                        "Code": "CM",
                        "Name": "Cameroon"
                    },
                    {
                        "Code": "CA",
                        "Name": "Canada"
                    },
                    {
                        "Code": "CB",
                        "Name": "Canada Buffer"
                    },
                    {
                        "Code": "CV",
                        "Name": "Cape Verde"
                    },
                    {
                        "Code": "KY",
                        "Name": "Cayman Islands"
                    },
                    {
                        "Code": "CF",
                        "Name": "Central African Republic"
                    },
                    {
                        "Code": "TD",
                        "Name": "Chad"
                    },
                    {
                        "Code": "CL",
                        "Name": "Chile"
                    },
                    {
                        "Code": "CN",
                        "Name": "China"
                    },
                    {
                        "Code": "CX",
                        "Name": "Christmas Islands"
                    },
                    {
                        "Code": "CC",
                        "Name": "Cocos (Keeling) Island"
                    },
                    {
                        "Code": "CO",
                        "Name": "Colombia"
                    },
                    {
                        "Code": "KM",
                        "Name": "Comoros"
                    },
                    {
                        "Code": "CG",
                        "Name": "Congo"
                    },
                    {
                        "Code": "CD",
                        "Name": "Congo (Rep. Dem.)"
                    },
                    {
                        "Code": "CK",
                        "Name": "Cook Islands"
                    },
                    {
                        "Code": "CR",
                        "Name": "Costa Rica"
                    },
                    {
                        "Code": "HR",
                        "Name": "Croatia"
                    },
                    {
                        "Code": "CW",
                        "Name": "Curacao"
                    },
                    {
                        "Code": "CY",
                        "Name": "Cyprus"
                    },
                    {
                        "Code": "CZ",
                        "Name": "Czech Republic"
                    },
                    {
                        "Code": "DK",
                        "Name": "Denmark"
                    },
                    {
                        "Code": "DJ",
                        "Name": "Djibouti"
                    },
                    {
                        "Code": "DO",
                        "Name": "Dominican Republic"
                    },
                    {
                        "Code": "DM",
                        "Name": "Dominicana"
                    },
                    {
                        "Code": "TP",
                        "Name": "East Timor"
                    },
                    {
                        "Code": "EC",
                        "Name": "Ecuador"
                    },
                    {
                        "Code": "EG",
                        "Name": "Egypt"
                    },
                    {
                        "Code": "SV",
                        "Name": "El Salvador"
                    },
                    {
                        "Code": "GQ",
                        "Name": "Equatorial Guinea"
                    },
                    {
                        "Code": "ER",
                        "Name": "Eritrea"
                    },
                    {
                        "Code": "EE",
                        "Name": "Estonia"
                    },
                    {
                        "Code": "ET",
                        "Name": "Ethiopia"
                    },
                    {
                        "Code": "EU",
                        "Name": "European Monetary Union"
                    },
                    {
                        "Code": "FK",
                        "Name": "Falkland Islands"
                    },
                    {
                        "Code": "FO",
                        "Name": "Faroe Islands"
                    },
                    {
                        "Code": "FJ",
                        "Name": "Fiji Islands"
                    },
                    {
                        "Code": "FI",
                        "Name": "Finland"
                    },
                    {
                        "Code": "FR",
                        "Name": "France"
                    },
                    {
                        "Code": "GF",
                        "Name": "French Guiana"
                    },
                    {
                        "Code": "PF",
                        "Name": "French Polynesia"
                    },
                    {
                        "Code": "TF",
                        "Name": "French Southern Territories"
                    },
                    {
                        "Code": "GA",
                        "Name": "Gabon"
                    },
                    {
                        "Code": "GM",
                        "Name": "Gambia"
                    },
                    {
                        "Code": "GE",
                        "Name": "Georgia"
                    },
                    {
                        "Code": "DE",
                        "Name": "Germany"
                    },
                    {
                        "Code": "GH",
                        "Name": "Ghana"
                    },
                    {
                        "Code": "GI",
                        "Name": "Gibralter"
                    },
                    {
                        "Code": "GR",
                        "Name": "Greece"
                    },
                    {
                        "Code": "GL",
                        "Name": "Greenland"
                    },
                    {
                        "Code": "GD",
                        "Name": "Grenada"
                    },
                    {
                        "Code": "GP",
                        "Name": "Guadeloupe"
                    },
                    {
                        "Code": "GU",
                        "Name": "Guam"
                    },
                    {
                        "Code": "GT",
                        "Name": "Guatemala"
                    },
                    {
                        "Code": "GN",
                        "Name": "Guinea"
                    },
                    {
                        "Code": "GW",
                        "Name": "Guinea-Bissau"
                    },
                    {
                        "Code": "GY",
                        "Name": "Guyana"
                    },
                    {
                        "Code": "HT",
                        "Name": "Haiti"
                    },
                    {
                        "Code": "HM",
                        "Name": "Heard & Mcdonald Islands"
                    },
                    {
                        "Code": "HN",
                        "Name": "Honduras"
                    },
                    {
                        "Code": "HK",
                        "Name": "Hongkong"
                    },
                    {
                        "Code": "HU",
                        "Name": "Hungary"
                    },
                    {
                        "Code": "IS",
                        "Name": "Iceland"
                    },
                    {
                        "Code": "IN",
                        "Name": "India"
                    },
                    {
                        "Code": "ID",
                        "Name": "Indonesia"
                    },
                    {
                        "Code": "IQ",
                        "Name": "Iraq"
                    },
                    {
                        "Code": "IE",
                        "Name": "Ireland"
                    },
                    {
                        "Code": "IL",
                        "Name": "Israel"
                    },
                    {
                        "Code": "IT",
                        "Name": "Italy"
                    },
                    {
                        "Code": "CI",
                        "Name": "Ivory Coast"
                    },
                    {
                        "Code": "JM",
                        "Name": "Jamaica"
                    },
                    {
                        "Code": "JP",
                        "Name": "Japan"
                    },
                    {
                        "Code": "JO",
                        "Name": "Jordan"
                    },
                    {
                        "Code": "KZ",
                        "Name": "Kazakhstan"
                    },
                    {
                        "Code": "KE",
                        "Name": "Kenya"
                    },
                    {
                        "Code": "KI",
                        "Name": "Kiribati"
                    },
                    {
                        "Code": "XK",
                        "Name": "Kosovo"
                    },
                    {
                        "Code": "KW",
                        "Name": "Kuwait"
                    },
                    {
                        "Code": "KG",
                        "Name": "Kyrgyzstan"
                    },
                    {
                        "Code": "LA",
                        "Name": "Lao Peoples Democratic Republic"
                    },
                    {
                        "Code": "LV",
                        "Name": "Latvia"
                    },
                    {
                        "Code": "LB",
                        "Name": "Lebanon"
                    },
                    {
                        "Code": "LS",
                        "Name": "Lesotho"
                    },
                    {
                        "Code": "LR",
                        "Name": "Liberia"
                    },
                    {
                        "Code": "LY",
                        "Name": "Libyan Arab Jamahiriya"
                    },
                    {
                        "Code": "LI",
                        "Name": "Liechtenstein"
                    },
                    {
                        "Code": "LT",
                        "Name": "Lithuania"
                    },
                    {
                        "Code": "QL",
                        "Name": "Lithuania (Dummy Code)"
                    },
                    {
                        "Code": "LU",
                        "Name": "Luxembourg"
                    },
                    {
                        "Code": "MO",
                        "Name": "Macau"
                    },
                    {
                        "Code": "MK",
                        "Name": "Macedonia"
                    },
                    {
                        "Code": "MG",
                        "Name": "Madagascar"
                    },
                    {
                        "Code": "MW",
                        "Name": "Malawi"
                    },
                    {
                        "Code": "MY",
                        "Name": "Malaysia"
                    },
                    {
                        "Code": "MV",
                        "Name": "Maldives"
                    },
                    {
                        "Code": "ML",
                        "Name": "Mali"
                    },
                    {
                        "Code": "MT",
                        "Name": "Malta"
                    },
                    {
                        "Code": "MH",
                        "Name": "Marshall Islands"
                    },
                    {
                        "Code": "MQ",
                        "Name": "Martinique"
                    },
                    {
                        "Code": "MR",
                        "Name": "Mauritania"
                    },
                    {
                        "Code": "MU",
                        "Name": "Mauritius"
                    },
                    {
                        "Code": "YT",
                        "Name": "Mayotte"
                    },
                    {
                        "Code": "MX",
                        "Name": "Mexico"
                    },
                    {
                        "Code": "MB",
                        "Name": "Mexico Buffer"
                    },
                    {
                        "Code": "FM",
                        "Name": "Micronesia"
                    },
                    {
                        "Code": "MD",
                        "Name": "Moldova"
                    },
                    {
                        "Code": "MC",
                        "Name": "Monaco"
                    },
                    {
                        "Code": "MN",
                        "Name": "Mongolia"
                    },
                    {
                        "Code": "ME",
                        "Name": "Montenegro"
                    },
                    {
                        "Code": "MS",
                        "Name": "Montserrat"
                    },
                    {
                        "Code": "MA",
                        "Name": "Morocco"
                    },
                    {
                        "Code": "MZ",
                        "Name": "Mozambique"
                    },
                    {
                        "Code": "MM",
                        "Name": "Myanmar"
                    },
                    {
                        "Code": "NA",
                        "Name": "Namibia"
                    },
                    {
                        "Code": "ZZ",
                        "Name": "Namibia1"
                    },
                    {
                        "Code": "NR",
                        "Name": "Nauru"
                    },
                    {
                        "Code": "NP",
                        "Name": "Nepal"
                    },
                    {
                        "Code": "NL",
                        "Name": "Netherlands"
                    },
                    {
                        "Code": "AN",
                        "Name": "Netherlands Antilles"
                    },
                    {
                        "Code": "NC",
                        "Name": "New Caledonia"
                    },
                    {
                        "Code": "NZ",
                        "Name": "New Zealand"
                    },
                    {
                        "Code": "NI",
                        "Name": "Nicaragua"
                    },
                    {
                        "Code": "NE",
                        "Name": "Niger"
                    },
                    {
                        "Code": "NG",
                        "Name": "Nigeria"
                    },
                    {
                        "Code": "NU",
                        "Name": "Niue"
                    },
                    {
                        "Code": "NF",
                        "Name": "Norfolk Islands"
                    },
                    {
                        "Code": "MP",
                        "Name": "Northern Mariana Islands"
                    },
                    {
                        "Code": "NO",
                        "Name": "Norway"
                    },
                    {
                        "Code": "OT",
                        "Name": "NotAvailable"
                    },
                    {
                        "Code": "OM",
                        "Name": "Oman"
                    },
                    {
                        "Code": "PK",
                        "Name": "Pakistan"
                    },
                    {
                        "Code": "PW",
                        "Name": "Palau"
                    },
                    {
                        "Code": "PS",
                        "Name": "Palestinian Occ. Territories"
                    },
                    {
                        "Code": "PA",
                        "Name": "Panama"
                    },
                    {
                        "Code": "PG",
                        "Name": "Papua New Guinea"
                    },
                    {
                        "Code": "PY",
                        "Name": "Paraguay"
                    },
                    {
                        "Code": "PE",
                        "Name": "Peru"
                    },
                    {
                        "Code": "PH",
                        "Name": "Philippines"
                    },
                    {
                        "Code": "PL",
                        "Name": "Poland"
                    },
                    {
                        "Code": "PT",
                        "Name": "Portugal"
                    },
                    {
                        "Code": "PR",
                        "Name": "Puerto Rico"
                    },
                    {
                        "Code": "QA",
                        "Name": "Qatar"
                    },
                    {
                        "Code": "RE",
                        "Name": "Reunion"
                    },
                    {
                        "Code": "RO",
                        "Name": "Romania"
                    },
                    {
                        "Code": "RU",
                        "Name": "Russian Federation"
                    },
                    {
                        "Code": "RW",
                        "Name": "Rwanda"
                    },
                    {
                        "Code": "LC",
                        "Name": "Saint Lucia"
                    },
                    {
                        "Code": "MF",
                        "Name": "Saint Martin (French part)"
                    },
                    {
                        "Code": "WS",
                        "Name": "Samoa"
                    },
                    {
                        "Code": "SM",
                        "Name": "San Marino"
                    },
                    {
                        "Code": "ST",
                        "Name": "Sao Tome & Principe"
                    },
                    {
                        "Code": "SA",
                        "Name": "Saudi Arabia"
                    },
                    {
                        "Code": "SN",
                        "Name": "Senegal"
                    },
                    {
                        "Code": "RS",
                        "Name": "Serbia"
                    },
                    {
                        "Code": "SC",
                        "Name": "Seychelles"
                    },
                    {
                        "Code": "SL",
                        "Name": "Sierra Leone"
                    },
                    {
                        "Code": "SG",
                        "Name": "Singapore"
                    },
                    {
                        "Code": "SX",
                        "Name": "Sint Maarten (Dutch part)"
                    },
                    {
                        "Code": "SK",
                        "Name": "Slovakia"
                    },
                    {
                        "Code": "SI",
                        "Name": "Slovenia"
                    },
                    {
                        "Code": "SB",
                        "Name": "Solomon Islands"
                    },
                    {
                        "Code": "SO",
                        "Name": "Somalia"
                    },
                    {
                        "Code": "ZA",
                        "Name": "South Africa"
                    },
                    {
                        "Code": "GS",
                        "Name": "South Georgia & South Sandwich"
                    },
                    {
                        "Code": "KR",
                        "Name": "South Korea"
                    },
                    {
                        "Code": "SS",
                        "Name": "South Sudan"
                    },
                    {
                        "Code": "SU",
                        "Name": "Soviet Union"
                    },
                    {
                        "Code": "ES",
                        "Name": "Spain"
                    },
                    {
                        "Code": "LK",
                        "Name": "Sri Lanka"
                    },
                    {
                        "Code": "BL",
                        "Name": "St. Barthelemy"
                    },
                    {
                        "Code": "SH",
                        "Name": "St. Helena"
                    },
                    {
                        "Code": "KN",
                        "Name": "St. Kitts and Nevis"
                    },
                    {
                        "Code": "PM",
                        "Name": "St. Pierre & Miquelon"
                    },
                    {
                        "Code": "VC",
                        "Name": "St. Vincent & the Grenadines"
                    },
                    {
                        "Code": "SD",
                        "Name": "Sudan"
                    },
                    {
                        "Code": "SR",
                        "Name": "Suriname"
                    },
                    {
                        "Code": "SJ",
                        "Name": "Svalbard & Jan Mayen Islands"
                    },
                    {
                        "Code": "SZ",
                        "Name": "Swaziland"
                    },
                    {
                        "Code": "SE",
                        "Name": "Sweden"
                    },
                    {
                        "Code": "CH",
                        "Name": "Switzerland"
                    },
                    {
                        "Code": "TW",
                        "Name": "Taiwan"
                    },
                    {
                        "Code": "TJ",
                        "Name": "Tajikistan"
                    },
                    {
                        "Code": "TZ",
                        "Name": "Tanzania"
                    },
                    {
                        "Code": "TH",
                        "Name": "Thailand"
                    },
                    {
                        "Code": "TG",
                        "Name": "Togo"
                    },
                    {
                        "Code": "TK",
                        "Name": "Tokelau"
                    },
                    {
                        "Code": "TO",
                        "Name": "Tonga"
                    },
                    {
                        "Code": "TT",
                        "Name": "Trinidad and Tobago"
                    },
                    {
                        "Code": "TN",
                        "Name": "Tunisia"
                    },
                    {
                        "Code": "TC",
                        "Name": "Turcs & Caicos Islands"
                    },
                    {
                        "Code": "TR",
                        "Name": "Turkey"
                    },
                    {
                        "Code": "TM",
                        "Name": "Turkmenistan"
                    },
                    {
                        "Code": "TV",
                        "Name": "Tuvalu"
                    },
                    {
                        "Code": "UM",
                        "Name": "U.S. Minor Outlaying Islands"
                    },
                    {
                        "Code": "UG",
                        "Name": "Uganda"
                    },
                    {
                        "Code": "UA",
                        "Name": "Ukraine"
                    },
                    {
                        "Code": "AE",
                        "Name": "United Arab Emirates"
                    },
                    {
                        "Code": "GB",
                        "Name": "United Kingdom"
                    },
                    {
                        "Code": "UY",
                        "Name": "Uruguay"
                    },
                    {
                        "Code": "US",
                        "Name": "USA"
                    },
                    {
                        "Code": "UZ",
                        "Name": "Uzbekistan"
                    },
                    {
                        "Code": "VU",
                        "Name": "Vanuatu"
                    },
                    {
                        "Code": "VA",
                        "Name": "Vatican City State"
                    },
                    {
                        "Code": "VE",
                        "Name": "Venezuela"
                    },
                    {
                        "Code": "VN",
                        "Name": "Vietnam"
                    },
                    {
                        "Code": "VI",
                        "Name": "Virgin Islands (US)"
                    },
                    {
                        "Code": "WF",
                        "Name": "Wallis & Futuna Islands"
                    },
                    {
                        "Code": "EH",
                        "Name": "Western Sahara"
                    },
                    {
                        "Code": "YE",
                        "Name": "Yemen"
                    },
                    {
                        "Code": "YU",
                        "Name": "Yugoslavia"
                    },
                    {
                        "Code": "ZM",
                        "Name": "Zambia"
                    },
                    {
                        "Code": "ZW",
                        "Name": "Zimbabwe"
                    }
                ]
            }
        }';
    }

    static function hotelcityresponse(){
         return '{
            "code": "0x0200",
            "message": "success",
            "status": "SUCCESS",
            "data": {
                "CityList": [
                    {
                        "Code": "268880",
                        "Name": "Abohar,   Punjab"
                    },
                    {
                        "Code": "105141",
                        "Name": "Abu Road,   Rajasthan"
                    },
                    {
                        "Code": "102138",
                        "Name": "Adoor,   kerala"
                    },
                    {
                        "Code": "101615",
                        "Name": "Adyar,   Tamil Nadu"
                    },
                    {
                        "Code": "100667",
                        "Name": "Agartala,   Tripura"
                    },
                    {
                        "Code": "100578",
                        "Name": "Agatti,   Lakshadweep"
                    },
                    {
                        "Code": "394603",
                        "Name": "Agonda"
                    },
                    {
                        "Code": "100589",
                        "Name": "Agra,   Uttar Pradesh"
                    },
                    {
                        "Code": "100263",
                        "Name": "Ahmedabad,   Gujarat"
                    },
                    {
                        "Code": "100363",
                        "Name": "Ahmednagar,   Maharashtra"
                    },
                    {
                        "Code": "100797",
                        "Name": "Ahmedpur Mandvi,   Gujarat"
                    },
                    {
                        "Code": "260619",
                        "Name": "Ahwa,   Gujarat"
                    },
                    {
                        "Code": "100273",
                        "Name": "Aizawl,   Mizoram"
                    },
                    {
                        "Code": "100686",
                        "Name": "Ajabgarh,   Rajasthan"
                    },
                    {
                        "Code": "100804",
                        "Name": "Ajmer,   Rajasthan"
                    },
                    {
                        "Code": "100689",
                        "Name": "Akola,   Maharashtra"
                    },
                    {
                        "Code": "101625",
                        "Name": "Alibaug,   Maharashtra"
                    },
                    {
                        "Code": "100420",
                        "Name": "Aligarh,   Uttar Pradesh"
                    },
                    {
                        "Code": "148835",
                        "Name": "Alipurduar,   West Bengal"
                    },
                    {
                        "Code": "161104",
                        "Name": "Alkapuri,   Gujarat"
                    },
                    {
                        "Code": "109524",
                        "Name": "Alleppey/Alappuzha,   Kerala"
                    },
                    {
                        "Code": "100203",
                        "Name": "Almora,   Uttarakhand"
                    },
                    {
                        "Code": "151339",
                        "Name": "Along,   Arunachal Pradesh"
                    },
                    {
                        "Code": "101349",
                        "Name": "Alto Porvorim,   Goa"
                    },
                    {
                        "Code": "109093",
                        "Name": "Alwar,   Rajasthan"
                    },
                    {
                        "Code": "418099",
                        "Name": "Amalapuram,   Andhra Pradesh"
                    },
                    {
                        "Code": "305707",
                        "Name": "Ambaji,   Gujarat"
                    },
                    {
                        "Code": "100881",
                        "Name": "Ambala,   Haryana"
                    },
                    {
                        "Code": "105159",
                        "Name": "Amer,   Rajasthan"
                    },
                    {
                        "Code": "101128",
                        "Name": "Amravati,   Maharashtra"
                    },
                    {
                        "Code": "299784",
                        "Name": "Amreli,   Gujarat"
                    },
                    {
                        "Code": "101129",
                        "Name": "Amritsar,   Punjab"
                    },
                    {
                        "Code": "252072",
                        "Name": "Anachal,   Kerala"
                    },
                    {
                        "Code": "109446",
                        "Name": "Anand,   Gujarat"
                    },
                    {
                        "Code": "105160",
                        "Name": "Anandpur,   Punjab"
                    },
                    {
                        "Code": "308358",
                        "Name": "Anandpur Sahib,   Punjab"
                    },
                    {
                        "Code": "153877",
                        "Name": "Anantapur District"
                    },
                    {
                        "Code": "153814",
                        "Name": "Andaman and Nicobar Islands"
                    },
                    {
                        "Code": "102166",
                        "Name": "Angul,   Odisha"
                    },
                    {
                        "Code": "160388",
                        "Name": "Anjar,   Gujarat"
                    },
                    {
                        "Code": "101146",
                        "Name": "Anjuna,   Goa"
                    },
                    {
                        "Code": "101147",
                        "Name": "Ankleshwar,   Gujarat"
                    },
                    {
                        "Code": "417883",
                        "Name": "Annavaram,   Andhra Pradesh"
                    },
                    {
                        "Code": "104724",
                        "Name": "Arambol,   Goa"
                    },
                    {
                        "Code": "109167",
                        "Name": "Arcot,   Tamil Nadu"
                    },
                    {
                        "Code": "109973",
                        "Name": "Aronda,   Maharashtra "
                    },
                    {
                        "Code": "161026",
                        "Name": "Arookutty,   Kerala"
                    },
                    {
                        "Code": "109872",
                        "Name": "Arpora,   Goa"
                    },
                    {
                        "Code": "294336",
                        "Name": "Arrah,   Bihar"
                    },
                    {
                        "Code": "101068",
                        "Name": "Arrosim Beach,   Goa"
                    },
                    {
                        "Code": "110211",
                        "Name": "Asansol,   West Bengal"
                    },
                    {
                        "Code": "151836",
                        "Name": "Ashtamudi,   Kerala"
                    },
                    {
                        "Code": "404579",
                        "Name": "Ashvem,   Goa"
                    },
                    {
                        "Code": "150412",
                        "Name": "Athirapally,   Kerala"
                    },
                    {
                        "Code": "105178",
                        "Name": "Athirapilly,   Kerala"
                    },
                    {
                        "Code": "110248",
                        "Name": "Auli,   Uttarakhand"
                    },
                    {
                        "Code": "110349",
                        "Name": "Aurangabad,   Maharashtra"
                    },
                    {
                        "Code": "109665",
                        "Name": "Auroville,   Tamil Nadu"
                    },
                    {
                        "Code": "110358",
                        "Name": "Ayodhya,   Uttar Pradesh"
                    },
                    {
                        "Code": "302986",
                        "Name": "Azamgarh,   Uttar Pradesh"
                    },
                    {
                        "Code": "110041",
                        "Name": "B. R. Hills,   Mizoram"
                    },
                    {
                        "Code": "111073",
                        "Name": "Badami,   Karnataka"
                    },
                    {
                        "Code": "150171",
                        "Name": "Baddi,   Himachal Pradesh"
                    },
                    {
                        "Code": "109814",
                        "Name": "Badrinath,   Uttarakhand"
                    },
                    {
                        "Code": "110640",
                        "Name": "Baga,   Goa"
                    },
                    {
                        "Code": "300972",
                        "Name": "Bagalkot,   Karnataka"
                    },
                    {
                        "Code": "294442",
                        "Name": "Bagar,   Rajasthan"
                    },
                    {
                        "Code": "150697",
                        "Name": "Bagdogra,   WEST BENGAL"
                    },
                    {
                        "Code": "295633",
                        "Name": "Bahadurgarh,   Haryana"
                    },
                    {
                        "Code": "291124",
                        "Name": "Bahraich,   Uttar Pradesh"
                    },
                    {
                        "Code": "151842",
                        "Name": "Baiguney,   Sikkim"
                    },
                    {
                        "Code": "101485",
                        "Name": "Baindur,   Karnataka"
                    },
                    {
                        "Code": "110659",
                        "Name": "Bakkhali,   West Bengal"
                    },
                    {
                        "Code": "148857",
                        "Name": "Balaghat,   Madhya Pradesh"
                    },
                    {
                        "Code": "105188",
                        "Name": "Balangir,   Odisha"
                    },
                    {
                        "Code": "111097",
                        "Name": "Balasinore,   Gujrat"
                    },
                    {
                        "Code": "295632",
                        "Name": "Balasore,   Odisha"
                    },
                    {
                        "Code": "110483",
                        "Name": "Ballari,   Karnataka"
                    },
                    {
                        "Code": "301775",
                        "Name": "Ballia,   Uttar Pradesh"
                    },
                    {
                        "Code": "110977",
                        "Name": "Balrampur,   Uttar Pradesh"
                    },
                    {
                        "Code": "150951",
                        "Name": "Balurghat,   West Bengal"
                    },
                    {
                        "Code": "111121",
                        "Name": "Bandhavgarh-Nationalpark,   Madhya Pradesh"
                    },
                    {
                        "Code": "110851",
                        "Name": "Bandipur,   Tamil Nadu"
                    },
                    {
                        "Code": "110853",
                        "Name": "Bangaram Island,   Lakshadweep"
                    },
                    {
                        "Code": "294440",
                        "Name": "Banjar"
                    },
                    {
                        "Code": "418092",
                        "Name": "Banswara,   Rajasthan"
                    },
                    {
                        "Code": "110855",
                        "Name": "Baramati,   Maharashtra"
                    },
                    {
                        "Code": "274840",
                        "Name": "Barasat"
                    },
                    {
                        "Code": "110425",
                        "Name": "Baratang Island,   Andaman & Nicobar"
                    },
                    {
                        "Code": "105028",
                        "Name": "Barauni,   Bihar"
                    },
                    {
                        "Code": "110789",
                        "Name": "Barbil,   Odisha"
                    },
                    {
                        "Code": "110512",
                        "Name": "Bardez,   Goa"
                    },
                    {
                        "Code": "111009",
                        "Name": "Bareilly,   Uttar Pradesh"
                    },
                    {
                        "Code": "298690",
                        "Name": "Barkot,   Uttarakhand"
                    },
                    {
                        "Code": "111142",
                        "Name": "Barmer,   Rajasthan"
                    },
                    {
                        "Code": "307085",
                        "Name": "Barnala,   Punjab"
                    },
                    {
                        "Code": "417419",
                        "Name": "Barsana,   Uttar Pradesh"
                    },
                    {
                        "Code": "111028",
                        "Name": "Basara,   Telangana"
                    },
                    {
                        "Code": "160986",
                        "Name": "Basti,   Uttar Pradesh"
                    },
                    {
                        "Code": "370731",
                        "Name": "Bayad,   Gujarat"
                    },
                    {
                        "Code": "102213",
                        "Name": "Beawar,   Rajasthan"
                    },
                    {
                        "Code": "161013",
                        "Name": "Becharaji,   Gujarat"
                    },
                    {
                        "Code": "234393",
                        "Name": "Begun,   Rajasthan"
                    },
                    {
                        "Code": "307801",
                        "Name": "Begusarai,   Bihar"
                    },
                    {
                        "Code": "110564",
                        "Name": "Behror,   Rajasthan"
                    },
                    {
                        "Code": "110566",
                        "Name": "Bekal,   Kerala"
                    },
                    {
                        "Code": "111427",
                        "Name": "Belagavi,   Karnataka"
                    },
                    {
                        "Code": "417940",
                        "Name": "Belmonte Mezzagno"
                    },
                    {
                        "Code": "111440",
                        "Name": "Belur & Halebid,   Karnataka"
                    },
                    {
                        "Code": "150242",
                        "Name": "Benaulim,   Goa"
                    },
                    {
                        "Code": "111124",
                        "Name": "Bengaluru/Bangalore,   Karnataka"
                    },
                    {
                        "Code": "110618",
                        "Name": "Betalbatim Beach,   Goa"
                    },
                    {
                        "Code": "111749",
                        "Name": "Betul,   Madhya Pradesh"
                    },
                    {
                        "Code": "161003",
                        "Name": "Bhabua,   Bihar"
                    },
                    {
                        "Code": "108056",
                        "Name": "Bhagalpur,   Bihar"
                    },
                    {
                        "Code": "151811",
                        "Name": "Bhalukpong,   Arunachal Pradesh"
                    },
                    {
                        "Code": "111694",
                        "Name": "Bhandardara,   Maharashtra "
                    },
                    {
                        "Code": "111484",
                        "Name": "Bharatpur,   Rajasthan"
                    },
                    {
                        "Code": "105046",
                        "Name": "Bharmour,   Himachal Pradesh"
                    },
                    {
                        "Code": "111195",
                        "Name": "Bharuch,   Gujarat"
                    },
                    {
                        "Code": "111292",
                        "Name": "Bhatinda,   Punjab"
                    },
                    {
                        "Code": "111485",
                        "Name": "Bhavnagar,   Gujarat"
                    },
                    {
                        "Code": "101318",
                        "Name": "Bhayandar,   Maharashtra "
                    },
                    {
                        "Code": "144227",
                        "Name": "Bheeramballi,   Karnataka"
                    },
                    {
                        "Code": "105400",
                        "Name": "Bhilai,   Chhattisgarh"
                    },
                    {
                        "Code": "105648",
                        "Name": "Bhilwara,   Rajasthan"
                    },
                    {
                        "Code": "111196",
                        "Name": "Bhimtal,   Uttarakhand"
                    },
                    {
                        "Code": "109000",
                        "Name": "Bhiwadi,   Rajasthan"
                    },
                    {
                        "Code": "144229",
                        "Name": "Bhiwandi,   Maharashtra"
                    },
                    {
                        "Code": "154216",
                        "Name": "Bhiwani district,   Haryana"
                    },
                    {
                        "Code": "111486",
                        "Name": "Bhogapuram,   Andhra Pradesh"
                    },
                    {
                        "Code": "111932",
                        "Name": "Bhopal,   Madhya Pradesh"
                    },
                    {
                        "Code": "105649",
                        "Name": "Bhowali,   Uttarakhand "
                    },
                    {
                        "Code": "111558",
                        "Name": "Bhubaneswar,   Odisha"
                    },
                    {
                        "Code": "144230",
                        "Name": "Bhuj,   Gujarat"
                    },
                    {
                        "Code": "108057",
                        "Name": "Bhuntar,   Himachal Pradesh"
                    },
                    {
                        "Code": "161001",
                        "Name": "Bihar Shariff,   Bihar"
                    },
                    {
                        "Code": "105736",
                        "Name": "Bijainagar,   Rajasthan"
                    },
                    {
                        "Code": "111499",
                        "Name": "Bijaipur,   Rajasthan"
                    },
                    {
                        "Code": "417015",
                        "Name": "Bijanbari,   West Bengal"
                    },
                    {
                        "Code": "144247",
                        "Name": "Bikaner,   Rajasthan"
                    },
                    {
                        "Code": "111574",
                        "Name": "Bilaspur,   Chhattisgarh"
                    },
                    {
                        "Code": "111212",
                        "Name": "Binsar,   Uttarakhand"
                    },
                    {
                        "Code": "267778",
                        "Name": "Bir,   Himachal Pradesh"
                    },
                    {
                        "Code": "280430",
                        "Name": "Bisalpur,   Rajasthan"
                    },
                    {
                        "Code": "111216",
                        "Name": "Bishangarh,   Rajasthan"
                    },
                    {
                        "Code": "112643",
                        "Name": "Bodhgaya,   Bihar"
                    },
                    {
                        "Code": "112649",
                        "Name": "Bogmallo,   Goa"
                    },
                    {
                        "Code": "263258",
                        "Name": "Boisar,   Maharashtra"
                    },
                    {
                        "Code": "112228",
                        "Name": "Bokaro,   Jharkhand"
                    },
                    {
                        "Code": "111364",
                        "Name": "Bokkapuram,   Tamil Nadu"
                    },
                    {
                        "Code": "111264",
                        "Name": "Bomdila,   Arunachal Pradesh"
                    },
                    {
                        "Code": "356153",
                        "Name": "Bommaraspet,   Telangana"
                    },
                    {
                        "Code": "151843",
                        "Name": "Bongaigaon,   Assam"
                    },
                    {
                        "Code": "112272",
                        "Name": "Brahmapur,   Odisha"
                    },
                    {
                        "Code": "346602",
                        "Name": "Bulandshahr,   Uttar Pradesh"
                    },
                    {
                        "Code": "293567",
                        "Name": "Buldana,   Maharashtra"
                    },
                    {
                        "Code": "113081",
                        "Name": "Bundi,   Rajasthan"
                    },
                    {
                        "Code": "160993",
                        "Name": "Burdwan,   West Bengal"
                    },
                    {
                        "Code": "148834",
                        "Name": "Burhanpur,   Madhya Pradesh"
                    },
                    {
                        "Code": "112868",
                        "Name": "Calangute,   Goa"
                    },
                    {
                        "Code": "113160",
                        "Name": "Canacona,   Goa"
                    },
                    {
                        "Code": "105699",
                        "Name": "Candolim,   Goa"
                    },
                    {
                        "Code": "144510",
                        "Name": "Candolim Beach,   Goa"
                    },
                    {
                        "Code": "113347",
                        "Name": "Cansaulim Beach,   Goa"
                    },
                    {
                        "Code": "150965",
                        "Name": "Car Nicobar,   Andaman & Nicobar"
                    },
                    {
                        "Code": "112913",
                        "Name": "Caranzalem,   Goa"
                    },
                    {
                        "Code": "113566",
                        "Name": "Cauvery,   Karnataka"
                    },
                    {
                        "Code": "114566",
                        "Name": "Cavelossim,   Goa"
                    },
                    {
                        "Code": "113675",
                        "Name": "Chail,   Himachal Pradesh"
                    },
                    {
                        "Code": "114601",
                        "Name": "Chakan,   Maharashtra"
                    },
                    {
                        "Code": "150284",
                        "Name": "Chalakudy,   Kerala"
                    },
                    {
                        "Code": "417515",
                        "Name": "Challakere"
                    },
                    {
                        "Code": "114703",
                        "Name": "Chamba,   Uttarakhand"
                    },
                    {
                        "Code": "114936",
                        "Name": "Chamoli,   Uttarakhand"
                    },
                    {
                        "Code": "105721",
                        "Name": "Champakulam,   Kerala"
                    },
                    {
                        "Code": "114107",
                        "Name": "Chandigarh,   Chandigarh"
                    },
                    {
                        "Code": "102259",
                        "Name": "Chandipur,   Odisha"
                    },
                    {
                        "Code": "105246",
                        "Name": "Chandrapur,   Maharashtra "
                    },
                    {
                        "Code": "417335",
                        "Name": "Chandrapur district,   Maharashtra"
                    },
                    {
                        "Code": "113683",
                        "Name": "Changanassery,   Kerala"
                    },
                    {
                        "Code": "105247",
                        "Name": "Changodar,   Gujarat"
                    },
                    {
                        "Code": "417528",
                        "Name": "Chapra"
                    },
                    {
                        "Code": "114117",
                        "Name": "Charholi Budruk,   Maharashtra"
                    },
                    {
                        "Code": "417037",
                        "Name": "Chatra,   Jharkhand"
                    },
                    {
                        "Code": "114960",
                        "Name": "Chaukori,   Uttarakhand"
                    },
                    {
                        "Code": "364172",
                        "Name": "Chavakkad"
                    },
                    {
                        "Code": "127343",
                        "Name": "Chennai,   Tamil Nadu"
                    },
                    {
                        "Code": "114523",
                        "Name": "Cherai,   Kerala"
                    },
                    {
                        "Code": "106208",
                        "Name": "Cherai Beach,   Kerala"
                    },
                    {
                        "Code": "161025",
                        "Name": "Cherrapunji,   Meghalaya"
                    },
                    {
                        "Code": "160465",
                        "Name": "Chhatarpur"
                    },
                    {
                        "Code": "108141",
                        "Name": "Chhindwara,   Madhya Pradesh"
                    },
                    {
                        "Code": "114977",
                        "Name": "Chhota Udaipur,   Gujrat"
                    },
                    {
                        "Code": "114793",
                        "Name": "Chidambaram,   Tamil Nadu"
                    },
                    {
                        "Code": "379302",
                        "Name": "Chikkaballapur,   Karnataka"
                    },
                    {
                        "Code": "114986",
                        "Name": "Chikkamagaluru,   Karnataka"
                    },
                    {
                        "Code": "114987",
                        "Name": "Chikmaglur,   Karnataka"
                    },
                    {
                        "Code": "148870",
                        "Name": "CHILLING,   Jammu and Kashmir"
                    },
                    {
                        "Code": "256989",
                        "Name": "Chimur"
                    },
                    {
                        "Code": "114357",
                        "Name": "Chinakakani,   Andhra Pradesh"
                    },
                    {
                        "Code": "114660",
                        "Name": "Chinnakanal,   Kerala"
                    },
                    {
                        "Code": "114801",
                        "Name": "Chintpuri,   Himachal Pradesh"
                    },
                    {
                        "Code": "114272",
                        "Name": "Chiplun,   Maharashtra"
                    },
                    {
                        "Code": "274833",
                        "Name": "Chirawa,   Rajasthan"
                    },
                    {
                        "Code": "225402",
                        "Name": "Chitradurga,   Karnataka"
                    },
                    {
                        "Code": "153978",
                        "Name": "Chitradurga District"
                    },
                    {
                        "Code": "114803",
                        "Name": "Chitrakoot,   Madhya Pradesh"
                    },
                    {
                        "Code": "114804",
                        "Name": "Chittaurgarh,   Rajasthan"
                    },
                    {
                        "Code": "108144",
                        "Name": "Chittorgarh,   Rajasthan"
                    },
                    {
                        "Code": "114758",
                        "Name": "Choglamsar,   Jammu And Kashmir"
                    },
                    {
                        "Code": "160626",
                        "Name": "Chomu"
                    },
                    {
                        "Code": "114811",
                        "Name": "Chorao Island,   Goa"
                    },
                    {
                        "Code": "286831",
                        "Name": "Chottanikkara"
                    },
                    {
                        "Code": "114817",
                        "Name": "Chowara,   Kerala"
                    },
                    {
                        "Code": "114823",
                        "Name": "Chundale,   Kerala"
                    },
                    {
                        "Code": "114554",
                        "Name": "Churu,   Rajasthan"
                    },
                    {
                        "Code": "144735",
                        "Name": "Coimbatore,   Tamil Nadu"
                    },
                    {
                        "Code": "115840",
                        "Name": "Colva,   Goa"
                    },
                    {
                        "Code": "301104",
                        "Name": "Cooch Behar,   West Bengal"
                    },
                    {
                        "Code": "102287",
                        "Name": "Coochbehar,   West Bengal"
                    },
                    {
                        "Code": "115864",
                        "Name": "Coonoor,   Tamil Nadu"
                    },
                    {
                        "Code": "115400",
                        "Name": "Coorg,   Karnataka"
                    },
                    {
                        "Code": "305701",
                        "Name": "Courtallam,   Tamil Nadu"
                    },
                    {
                        "Code": "115526",
                        "Name": "Covelong,   Tamil Nadu"
                    },
                    {
                        "Code": "116021",
                        "Name": "Cuttack,   Orissa"
                    },
                    {
                        "Code": "104936",
                        "Name": "Dadahu,   Himachal Pradesh"
                    },
                    {
                        "Code": "238716",
                        "Name": "Dahegam,   Gujarat"
                    },
                    {
                        "Code": "115176",
                        "Name": "Dahej,   Gujarat"
                    },
                    {
                        "Code": "154007",
                        "Name": "Dakshina Kannada District,   Karnataka"
                    },
                    {
                        "Code": "116613",
                        "Name": "Dalhousie,   Himachal Pradesh"
                    },
                    {
                        "Code": "116035",
                        "Name": "Daman,   Daman and Diu"
                    },
                    {
                        "Code": "116039",
                        "Name": "Dandeli,   Karnataka"
                    },
                    {
                        "Code": "116624",
                        "Name": "Dankuni,   West Bengal"
                    },
                    {
                        "Code": "115634",
                        "Name": "Dapoli,   Maharashtra"
                    },
                    {
                        "Code": "105998",
                        "Name": "Darbhanga,   Bihar"
                    },
                    {
                        "Code": "116264",
                        "Name": "Darjeeling,   West Bengal"
                    },
                    {
                        "Code": "402770",
                        "Name": "Dasada,   Gujarat"
                    },
                    {
                        "Code": "101849",
                        "Name": "Daund,   Maharashtra "
                    },
                    {
                        "Code": "144874",
                        "Name": "Dausa,   Rajasthan"
                    },
                    {
                        "Code": "280566",
                        "Name": "Davanagere,   Karnataka"
                    },
                    {
                        "Code": "148900",
                        "Name": "DEEPYOKMA,   Jammu and Kashmir"
                    },
                    {
                        "Code": "116164",
                        "Name": "Dehradun,   Uttarakhand"
                    },
                    {
                        "Code": "418069",
                        "Name": "Delhi NCR"
                    },
                    {
                        "Code": "116074",
                        "Name": "Deogarh,   Rajasthan"
                    },
                    {
                        "Code": "105482",
                        "Name": "Deoghar,   Jharkhand"
                    },
                    {
                        "Code": "301589",
                        "Name": "Dera Bassi,   Punjab"
                    },
                    {
                        "Code": "117352",
                        "Name": "Devikulam,   Kerala"
                    },
                    {
                        "Code": "106255",
                        "Name": "Devprayag,   Uttarakhand"
                    },
                    {
                        "Code": "104946",
                        "Name": "Dhanachuli,   Uttarakhand"
                    },
                    {
                        "Code": "106006",
                        "Name": "Dhanaulti,   Uttarakhand "
                    },
                    {
                        "Code": "150731",
                        "Name": "Dhanbad,   Jharkhand"
                    },
                    {
                        "Code": "154074",
                        "Name": "Dhar District,   Madhya Pradesh"
                    },
                    {
                        "Code": "102310",
                        "Name": "Dharampur,   Himachal Pradesh"
                    },
                    {
                        "Code": "115880",
                        "Name": "Dharamshala,   HIMACHAL PRADESH"
                    },
                    {
                        "Code": "302737",
                        "Name": "Dhari,   Gujarat"
                    },
                    {
                        "Code": "144913",
                        "Name": "Dharmapuri,   Tamil Nadu"
                    },
                    {
                        "Code": "105779",
                        "Name": "Dhela,   Uttarakhand"
                    },
                    {
                        "Code": "116338",
                        "Name": "Dhikuli,   Uttarakhand "
                    },
                    {
                        "Code": "245095",
                        "Name": "Dholavira,   Gujarat"
                    },
                    {
                        "Code": "115881",
                        "Name": "Dholpur,   Rajasthan"
                    },
                    {
                        "Code": "116087",
                        "Name": "Dhule,   Maharashtra"
                    },
                    {
                        "Code": "115884",
                        "Name": "Dibrugarh,   Assam"
                    },
                    {
                        "Code": "115894",
                        "Name": "Digha,   West Bengal"
                    },
                    {
                        "Code": "115896",
                        "Name": "Dimapur,   Nagaland"
                    },
                    {
                        "Code": "160727",
                        "Name": "Dindi,   Andhra Pradesh"
                    },
                    {
                        "Code": "106010",
                        "Name": "Dindigul,   tamil Nadu"
                    },
                    {
                        "Code": "151439",
                        "Name": "Dirang,   Arunachal Pradesh"
                    },
                    {
                        "Code": "115899",
                        "Name": "Diuu"
                    },
                    {
                        "Code": "295356",
                        "Name": "Diveagar"
                    },
                    {
                        "Code": "408733",
                        "Name": "Doddaballapura,   Karnataka"
                    },
                    {
                        "Code": "144950",
                        "Name": "Dooars,   West Bengal"
                    },
                    {
                        "Code": "116460",
                        "Name": "Dundlod,   Rajasthan"
                    },
                    {
                        "Code": "144996",
                        "Name": "Dungarpur,   Rajasthan"
                    },
                    {
                        "Code": "117048",
                        "Name": "Durg,   Chhattisgarh"
                    },
                    {
                        "Code": "115958",
                        "Name": "Durgapur,   West Bengal"
                    },
                    {
                        "Code": "108863",
                        "Name": "Dwarka,   Gujarat"
                    },
                    {
                        "Code": "117110",
                        "Name": "Edava,   Kerala"
                    },
                    {
                        "Code": "417865",
                        "Name": "Eluru,   Andhra Pradesh"
                    },
                    {
                        "Code": "145110",
                        "Name": "Ernakulam,   Kerala"
                    },
                    {
                        "Code": "333373",
                        "Name": "Erode,   Tamil Nadu"
                    },
                    {
                        "Code": "153847",
                        "Name": "Etah District"
                    },
                    {
                        "Code": "118129",
                        "Name": "Faridabad,   Haryana"
                    },
                    {
                        "Code": "297864",
                        "Name": "Faridkot,   Punjab"
                    },
                    {
                        "Code": "102458",
                        "Name": "Fatehabad,   Haryana "
                    },
                    {
                        "Code": "118805",
                        "Name": "Fatehgarh,   Uttar Pradesh"
                    },
                    {
                        "Code": "117771",
                        "Name": "Fatehpur Sikri,   Uttar Pradesh"
                    },
                    {
                        "Code": "404366",
                        "Name": "Firozabad,   Uttar Pradesh"
                    },
                    {
                        "Code": "370828",
                        "Name": "Fort Kochi"
                    },
                    {
                        "Code": "305606",
                        "Name": "Gachibowli,   Telangana"
                    },
                    {
                        "Code": "402273",
                        "Name": "Gadag-Betageri,   Karnataka"
                    },
                    {
                        "Code": "117993",
                        "Name": "Gandhidham,   Gujarat"
                    },
                    {
                        "Code": "119071",
                        "Name": "Gandhinagar,   Gujarat"
                    },
                    {
                        "Code": "160995",
                        "Name": "Gandipet,   Telangana"
                    },
                    {
                        "Code": "101509",
                        "Name": "Gangavathi,   Karnataka"
                    },
                    {
                        "Code": "119613",
                        "Name": "Gangotri,   Uttarakhand"
                    },
                    {
                        "Code": "119221",
                        "Name": "Gangtok,   Sikkim"
                    },
                    {
                        "Code": "119222",
                        "Name": "Ganpatipule,   Maharashtra"
                    },
                    {
                        "Code": "200705",
                        "Name": "Garhmukteshwar,   Uttar Pradesh"
                    },
                    {
                        "Code": "119358",
                        "Name": "Gaya,   Bihar"
                    },
                    {
                        "Code": "160390",
                        "Name": "Geyzing,   Sikkim"
                    },
                    {
                        "Code": "295489",
                        "Name": "Ghanerao"
                    },
                    {
                        "Code": "118973",
                        "Name": "Ghaziabad,   Uttar Pradesh"
                    },
                    {
                        "Code": "106106",
                        "Name": "Giridih,   Jharkhand"
                    },
                    {
                        "Code": "118719",
                        "Name": "Glenburn,   West Bengal"
                    },
                    {
                        "Code": "119805",
                        "Name": "Goa,   Goa"
                    },
                    {
                        "Code": "108256",
                        "Name": "Goa Velha,   Goa"
                    },
                    {
                        "Code": "261602",
                        "Name": "Godhra,   Gujarat"
                    },
                    {
                        "Code": "118733",
                        "Name": "Gokarna,   Karnataka"
                    },
                    {
                        "Code": "417924",
                        "Name": "Gokul,   Mathura"
                    },
                    {
                        "Code": "251229",
                        "Name": "Gomti Nagar,   Uttar Pradesh"
                    },
                    {
                        "Code": "417511",
                        "Name": "Gondal,   Gujarat"
                    },
                    {
                        "Code": "382623",
                        "Name": "Gondia,   Maharashtra"
                    },
                    {
                        "Code": "262960",
                        "Name": "Gopalganj,   Bihar"
                    },
                    {
                        "Code": "120368",
                        "Name": "Gopalpur on Sea,   Odisha"
                    },
                    {
                        "Code": "256969",
                        "Name": "Gorai,   Maharashtra"
                    },
                    {
                        "Code": "120371",
                        "Name": "Gorakhpur,   Uttar Pradesh"
                    },
                    {
                        "Code": "102486",
                        "Name": "Gosaba,   West Bengal"
                    },
                    {
                        "Code": "108265",
                        "Name": "Govardhan,   Uttar Pradesh"
                    },
                    {
                        "Code": "145430",
                        "Name": "Greater Noida,   Uttar Pradesh"
                    },
                    {
                        "Code": "102499",
                        "Name": "Gudalur,   Tamil Nadu"
                    },
                    {
                        "Code": "105832",
                        "Name": "Guirim,   Goa"
                    },
                    {
                        "Code": "153893",
                        "Name": "Gujarat,   Gujarat"
                    },
                    {
                        "Code": "119924",
                        "Name": "Gulmarg,   Jammu and Kashmir"
                    },
                    {
                        "Code": "280781",
                        "Name": "Gummidipundi,   Tamil Nadu"
                    },
                    {
                        "Code": "150594",
                        "Name": "Guna,   Madhya Pradesh"
                    },
                    {
                        "Code": "106131",
                        "Name": "Guntur,   Andhra Pradesh"
                    },
                    {
                        "Code": "300176",
                        "Name": "Guptkashi,   Uttarakhand"
                    },
                    {
                        "Code": "301389",
                        "Name": "Gurdaspur"
                    },
                    {
                        "Code": "119513",
                        "Name": "Gurugram/Gurgaon,   Haryana"
                    },
                    {
                        "Code": "119517",
                        "Name": "Guruvayur,   Kerala"
                    },
                    {
                        "Code": "121139",
                        "Name": "Guwahati,   Assam"
                    },
                    {
                        "Code": "120439",
                        "Name": "Gwalior,   Madhya Pradesh"
                    },
                    {
                        "Code": "161000",
                        "Name": "Hajipur,   Bihar"
                    },
                    {
                        "Code": "120588",
                        "Name": "Haldwani,   Uttarakhand"
                    },
                    {
                        "Code": "121175",
                        "Name": "Hampi,   Karnataka"
                    },
                    {
                        "Code": "119961",
                        "Name": "Hansi,   Haryana"
                    },
                    {
                        "Code": "120206",
                        "Name": "Hanumangarh,   Rajasthan"
                    },
                    {
                        "Code": "121186",
                        "Name": "Haridwar,   Uttarakhand"
                    },
                    {
                        "Code": "257027",
                        "Name": "Hasanganj,   Uttar Pradesh"
                    },
                    {
                        "Code": "120871",
                        "Name": "Hassan,   Karnataka"
                    },
                    {
                        "Code": "417919",
                        "Name": "Hatgad,   Maharashtra"
                    },
                    {
                        "Code": "119978",
                        "Name": "Havelock Island,   Andaman & Nicobar"
                    },
                    {
                        "Code": "102512",
                        "Name": "Hebbal,   Karnataka"
                    },
                    {
                        "Code": "148892",
                        "Name": "Hemis Skupachan,   Jammu and Kashmir"
                    },
                    {
                        "Code": "121355",
                        "Name": "Hinjawadi,   Maharashtra "
                    },
                    {
                        "Code": "105850",
                        "Name": "Hisar,   Haryana "
                    },
                    {
                        "Code": "145660",
                        "Name": "Hooghly,   West Bengal"
                    },
                    {
                        "Code": "121396",
                        "Name": "Hosapete,   Karnataka"
                    },
                    {
                        "Code": "153950",
                        "Name": "Hoshangabad District"
                    },
                    {
                        "Code": "121557",
                        "Name": "Hoshiarpur,   Punjab"
                    },
                    {
                        "Code": "355946",
                        "Name": "Hoskote"
                    },
                    {
                        "Code": "121290",
                        "Name": "Hosur,   KARNATAKA"
                    },
                    {
                        "Code": "145687",
                        "Name": "Howrah,   West Bengal"
                    },
                    {
                        "Code": "150235",
                        "Name": "Hubballi,   Karnataka"
                    },
                    {
                        "Code": "338277",
                        "Name": "Hubli (HBX),   Hubli"
                    },
                    {
                        "Code": "121570",
                        "Name": "Hudikeri,   Karnataka"
                    },
                    {
                        "Code": "393866",
                        "Name": "Hunder"
                    },
                    {
                        "Code": "355802",
                        "Name": "Hunsur,   Karnataka"
                    },
                    {
                        "Code": "145710",
                        "Name": "Hyderabad,   Andra Pradesh"
                    },
                    {
                        "Code": "102531",
                        "Name": "Ichalkaranji,   Maharashtra"
                    },
                    {
                        "Code": "154222",
                        "Name": "Idukki District"
                    },
                    {
                        "Code": "121984",
                        "Name": "Igatpuri,   Maharashtra"
                    },
                    {
                        "Code": "122108",
                        "Name": "Imphal,   Manipur"
                    },
                    {
                        "Code": "121726",
                        "Name": "Indore,   Madhya Pradesh"
                    },
                    {
                        "Code": "122732",
                        "Name": "Itanagar,   Arunachal Pradesh"
                    },
                    {
                        "Code": "121509",
                        "Name": "Jabalpur,   Madhya Pradesh"
                    },
                    {
                        "Code": "150469",
                        "Name": "Jagdalpur,   Chhattisgarh"
                    },
                    {
                        "Code": "122175",
                        "Name": "Jaipur,   Rajasthan"
                    },
                    {
                        "Code": "122326",
                        "Name": "Jaisalmer,   Rajasthan"
                    },
                    {
                        "Code": "268917",
                        "Name": "Jajapur"
                    },
                    {
                        "Code": "122327",
                        "Name": "Jalandhar,   Punjab"
                    },
                    {
                        "Code": "160994",
                        "Name": "Jaldapara,   West Bengal"
                    },
                    {
                        "Code": "122177",
                        "Name": "Jalgaon,   Maharashtra"
                    },
                    {
                        "Code": "103931",
                        "Name": "Jalna,   Maharashtra"
                    },
                    {
                        "Code": "123420",
                        "Name": "Jalore,   Rajasthan"
                    },
                    {
                        "Code": "122328",
                        "Name": "Jalpaiguri,   West Bengal"
                    },
                    {
                        "Code": "105614",
                        "Name": "Jambulne,   Maharashtra"
                    },
                    {
                        "Code": "121783",
                        "Name": "Jammu,   Jammu and Kashmir"
                    },
                    {
                        "Code": "122329",
                        "Name": "Jamnagar,   Gujarat"
                    },
                    {
                        "Code": "123422",
                        "Name": "Jamshedpur,   Jharkhand"
                    },
                    {
                        "Code": "280676",
                        "Name": "Jamui,   Bihar"
                    },
                    {
                        "Code": "251261",
                        "Name": "Jangipur,   West Bengal"
                    },
                    {
                        "Code": "161002",
                        "Name": "Jaunpur,   Uttar Pradesh"
                    },
                    {
                        "Code": "161021",
                        "Name": "Jawai,   Rajasthan"
                    },
                    {
                        "Code": "301375",
                        "Name": "Jawhar,   Maharashtra"
                    },
                    {
                        "Code": "122763",
                        "Name": "Jeypore,   Odisha"
                    },
                    {
                        "Code": "105885",
                        "Name": "Jhadol,   Rajasthan"
                    },
                    {
                        "Code": "122199",
                        "Name": "Jhansi,   Uttar Pradesh"
                    },
                    {
                        "Code": "295101",
                        "Name": "Jharsuguda,   Odisha"
                    },
                    {
                        "Code": "148844",
                        "Name": "Jhunjhunu,   Rajasthan"
                    },
                    {
                        "Code": "257230",
                        "Name": "Jibhi,   Himachal Pradesh"
                    },
                    {
                        "Code": "115501",
                        "Name": "Jim Corbett National Park,   Uttarakhand"
                    },
                    {
                        "Code": "123445",
                        "Name": "Jispa,   Himachal Pradesh"
                    },
                    {
                        "Code": "145836",
                        "Name": "Jodhpur,   Rajasthan"
                    },
                    {
                        "Code": "122215",
                        "Name": "Jorhat,   Assam"
                    },
                    {
                        "Code": "160632",
                        "Name": "Joshimath"
                    },
                    {
                        "Code": "105627",
                        "Name": "Junagadh,   Gujarat"
                    },
                    {
                        "Code": "122370",
                        "Name": "Junagarh,   Gujrat"
                    },
                    {
                        "Code": "123469",
                        "Name": "Jwalamukhi,   Himachal Pradesh"
                    },
                    {
                        "Code": "150397",
                        "Name": "Kadapa,   Andhra Pradesh"
                    },
                    {
                        "Code": "355405",
                        "Name": "Kadi,   Gujarat"
                    },
                    {
                        "Code": "145856",
                        "Name": "Kadmat Island,   Lakshadweep"
                    },
                    {
                        "Code": "151112",
                        "Name": "Kailashahar,   Tripura"
                    },
                    {
                        "Code": "123476",
                        "Name": "Kakinada,   Andhra Pradesh"
                    },
                    {
                        "Code": "104092",
                        "Name": "Kalady,   Kerala"
                    },
                    {
                        "Code": "269264",
                        "Name": "Kalamassery"
                    },
                    {
                        "Code": "122388",
                        "Name": "Kaliel,   Tamil Nadu"
                    },
                    {
                        "Code": "122511",
                        "Name": "Kalimpong,   West Bengal"
                    },
                    {
                        "Code": "293190",
                        "Name": "Kallakurichi,   Tamil Nadu"
                    },
                    {
                        "Code": "368724",
                        "Name": "Kalol,   Gujarat"
                    },
                    {
                        "Code": "105633",
                        "Name": "Kalpatta,   Kerala"
                    },
                    {
                        "Code": "121837",
                        "Name": "Kalpetta,   Kerala"
                    },
                    {
                        "Code": "145872",
                        "Name": "Kalyan,   Maharashtra"
                    },
                    {
                        "Code": "151198",
                        "Name": "Kamalpur,   Tripura"
                    },
                    {
                        "Code": "121841",
                        "Name": "Kamba,   Gujrat"
                    },
                    {
                        "Code": "306364",
                        "Name": "Kamshet,   Maharashtra"
                    },
                    {
                        "Code": "122406",
                        "Name": "Kanadukathan,   Tamil Nadu"
                    },
                    {
                        "Code": "338739",
                        "Name": "Kanatal"
                    },
                    {
                        "Code": "122824",
                        "Name": "Kanchipuram,   Tamil Nadu"
                    },
                    {
                        "Code": "122253",
                        "Name": "Kandaghat,   Himachal Pradesh"
                    },
                    {
                        "Code": "151469",
                        "Name": "Kandla,   Gujarat"
                    },
                    {
                        "Code": "153910",
                        "Name": "Kangra District"
                    },
                    {
                        "Code": "122826",
                        "Name": "Kangra Valley,   Himachal Pradesh"
                    },
                    {
                        "Code": "122931",
                        "Name": "Kanha,   Madhya Pradesh"
                    },
                    {
                        "Code": "299954",
                        "Name": "Kankavli,   Maharashtra"
                    },
                    {
                        "Code": "417856",
                        "Name": "Kannauj,   Uttar Pradesh"
                    },
                    {
                        "Code": "122256",
                        "Name": "Kanniyakumari,   Tamil Nadu"
                    },
                    {
                        "Code": "122522",
                        "Name": "Kannur,   Kerala"
                    },
                    {
                        "Code": "153898",
                        "Name": "Kannur District"
                    },
                    {
                        "Code": "122932",
                        "Name": "Kanpur,   Uttar Pradesh"
                    },
                    {
                        "Code": "151841",
                        "Name": "Kantal,   Uttarakhand"
                    },
                    {
                        "Code": "370728",
                        "Name": "Kanthi,   West Bengal"
                    },
                    {
                        "Code": "123084",
                        "Name": "Kanyakumari,   Tamil Nadu"
                    },
                    {
                        "Code": "122525",
                        "Name": "Kappad,   Kerala"
                    },
                    {
                        "Code": "300642",
                        "Name": "Kapurthala"
                    },
                    {
                        "Code": "123503",
                        "Name": "Karad,   Maharashtra"
                    },
                    {
                        "Code": "123204",
                        "Name": "Karaikudi,   Tamil Nadu"
                    },
                    {
                        "Code": "148869",
                        "Name": "Karauli,   Rajasthan"
                    },
                    {
                        "Code": "153890",
                        "Name": "Karauli District"
                    },
                    {
                        "Code": "122938",
                        "Name": "Kargil,   Jammu and Kashmir"
                    },
                    {
                        "Code": "103950",
                        "Name": "Karimnagar,   Telangana"
                    },
                    {
                        "Code": "160750",
                        "Name": "Karjat City"
                    },
                    {
                        "Code": "122275",
                        "Name": "Karnal,   Haryana"
                    },
                    {
                        "Code": "123217",
                        "Name": "Karur,   Tamil Nadu"
                    },
                    {
                        "Code": "123098",
                        "Name": "Karwar,   Karnataka"
                    },
                    {
                        "Code": "123218",
                        "Name": "Kasarde,   Maharashtra"
                    },
                    {
                        "Code": "122848",
                        "Name": "Kasargod,   Kerala"
                    },
                    {
                        "Code": "122950",
                        "Name": "Kasauli,   Himachal Pradesh"
                    },
                    {
                        "Code": "417942",
                        "Name": "Kasganj,   Uttar Pradesh"
                    },
                    {
                        "Code": "123518",
                        "Name": "Kashid,   Maharashtra"
                    },
                    {
                        "Code": "123519",
                        "Name": "Kashipur,   Uttarakhand"
                    },
                    {
                        "Code": "102540",
                        "Name": "Kasol,   Himachal Pradesh"
                    },
                    {
                        "Code": "123108",
                        "Name": "Kathgodam,   Uttarakhand "
                    },
                    {
                        "Code": "108361",
                        "Name": "Katihar,   Bihar"
                    },
                    {
                        "Code": "151859",
                        "Name": "KATPADI,   TAMIL NADU"
                    },
                    {
                        "Code": "124184",
                        "Name": "Katra,   Jammu and Kashmir"
                    },
                    {
                        "Code": "123227",
                        "Name": "Kausani,   Uttarakhand"
                    },
                    {
                        "Code": "123527",
                        "Name": "Kaziranga,   Assam"
                    },
                    {
                        "Code": "123231",
                        "Name": "Kedarnath,   Uttarakhand"
                    },
                    {
                        "Code": "122978",
                        "Name": "Kerala,   Kerala"
                    },
                    {
                        "Code": "150615",
                        "Name": "Keshod,   Gujarat"
                    },
                    {
                        "Code": "161022",
                        "Name": "Kevadia,   Gujarat"
                    },
                    {
                        "Code": "123258",
                        "Name": "Khajjiar,   Himachal Pradesh"
                    },
                    {
                        "Code": "122580",
                        "Name": "Khajuraho,   Madhya Pradesh"
                    },
                    {
                        "Code": "123259",
                        "Name": "Khandala,   Maharashtra"
                    },
                    {
                        "Code": "102545",
                        "Name": "Khandela,   Rajasthan"
                    },
                    {
                        "Code": "106186",
                        "Name": "Khandwa,   Madhya Pradesh"
                    },
                    {
                        "Code": "280867",
                        "Name": "Kharagpur,   West Bengal"
                    },
                    {
                        "Code": "205200",
                        "Name": "Kharar,   Punjab"
                    },
                    {
                        "Code": "293579",
                        "Name": "Khargone,   Madhya Pradesh"
                    },
                    {
                        "Code": "101671",
                        "Name": "Khas Nagrota,   Himachal Pradesh"
                    },
                    {
                        "Code": "160988",
                        "Name": "Khawasa,   Madhya Pradesh"
                    },
                    {
                        "Code": "153813",
                        "Name": "Kheri District,   Uttar Pradesh"
                    },
                    {
                        "Code": "122998",
                        "Name": "Khilchipur,   Madhya Pradesh"
                    },
                    {
                        "Code": "123676",
                        "Name": "Khimsar,   Rajasthan"
                    },
                    {
                        "Code": "404666",
                        "Name": "Khiyansaria,   Rajasthan"
                    },
                    {
                        "Code": "295097",
                        "Name": "Khopoli,   Maharashtra"
                    },
                    {
                        "Code": "151837",
                        "Name": "Kidanganad,   Kerala"
                    },
                    {
                        "Code": "108369",
                        "Name": "Kihim,   Maharashtra"
                    },
                    {
                        "Code": "417524",
                        "Name": "Kishanganj,   Bihar"
                    },
                    {
                        "Code": "148902",
                        "Name": "Kishangarh,   Rajasthan"
                    },
                    {
                        "Code": "101204",
                        "Name": "Kochi,   Kerala"
                    },
                    {
                        "Code": "154023",
                        "Name": "Kodagu,   Karnataka"
                    },
                    {
                        "Code": "123608",
                        "Name": "Kodaikanal,   Tamil Nadu"
                    },
                    {
                        "Code": "300919",
                        "Name": "Koderma"
                    },
                    {
                        "Code": "352597",
                        "Name": "Kodungallur,   Kerala"
                    },
                    {
                        "Code": "304539",
                        "Name": "Kolad,   Maharashtra"
                    },
                    {
                        "Code": "161007",
                        "Name": "Kolaghat,   West Bengal"
                    },
                    {
                        "Code": "123875",
                        "Name": "Kolhapur,   Maharashtra"
                    },
                    {
                        "Code": "262894",
                        "Name": "Koliyaak,   Gujarat"
                    },
                    {
                        "Code": "113128",
                        "Name": "Kolkata/Calcutta,   West Bengal"
                    },
                    {
                        "Code": "123877",
                        "Name": "Kollam,   Kerala"
                    },
                    {
                        "Code": "123879",
                        "Name": "Konark,   Odisha"
                    },
                    {
                        "Code": "103877",
                        "Name": "Kondotty,   Kerala"
                    },
                    {
                        "Code": "241214",
                        "Name": "Koppal,   Karnataka"
                    },
                    {
                        "Code": "286380",
                        "Name": "Korba,   Chhattisgarh"
                    },
                    {
                        "Code": "124966",
                        "Name": "Kota,   Rajasthan"
                    },
                    {
                        "Code": "396075",
                        "Name": "Kotabagh,   Uttarakhand"
                    },
                    {
                        "Code": "123312",
                        "Name": "Kotagiri,   Tamil Nadu"
                    },
                    {
                        "Code": "260573",
                        "Name": "Kotda Sangani,   Gujarat"
                    },
                    {
                        "Code": "418091",
                        "Name": "Kotdwar,   Uttarakhand"
                    },
                    {
                        "Code": "124008",
                        "Name": "Kothamangalam,   Kerala"
                    },
                    {
                        "Code": "101696",
                        "Name": "Koti,   Telangana"
                    },
                    {
                        "Code": "123314",
                        "Name": "Kotputli,   Rajasthan"
                    },
                    {
                        "Code": "123891",
                        "Name": "Kottayam,   Kerala"
                    },
                    {
                        "Code": "101967",
                        "Name": "Kottivakkam,   Tamil Nadu"
                    },
                    {
                        "Code": "123897",
                        "Name": "Kovalam,   Kerala"
                    },
                    {
                        "Code": "144475",
                        "Name": "Kozhikode,   Kerala"
                    },
                    {
                        "Code": "123334",
                        "Name": "Krishnagiri,   Tamil Nadu"
                    },
                    {
                        "Code": "123914",
                        "Name": "Kuchaman,   Rajasthan"
                    },
                    {
                        "Code": "103727",
                        "Name": "Kudal,   Goa"
                    },
                    {
                        "Code": "124997",
                        "Name": "Kudasan,   Gujrat"
                    },
                    {
                        "Code": "371051",
                        "Name": "Kufri"
                    },
                    {
                        "Code": "146047",
                        "Name": "Kullu,   HIMACHAL PRADESH"
                    },
                    {
                        "Code": "123344",
                        "Name": "Kumarakom,   Kerala"
                    },
                    {
                        "Code": "125002",
                        "Name": "Kumbakonam,   Tamil Nadu"
                    },
                    {
                        "Code": "150174",
                        "Name": "Kumbalgarh,   Rajasthan"
                    },
                    {
                        "Code": "123774",
                        "Name": "Kumbhalgarh,   Rajasthan"
                    },
                    {
                        "Code": "402772",
                        "Name": "Kumharsain,   Himachal Pradesh"
                    },
                    {
                        "Code": "146051",
                        "Name": "Kumily,   Kerala"
                    },
                    {
                        "Code": "103888",
                        "Name": "Kundapur,   Karnataka"
                    },
                    {
                        "Code": "103728",
                        "Name": "Kurnool,   Andhra Pradesh"
                    },
                    {
                        "Code": "159580",
                        "Name": "Kurseong,   West Bengal"
                    },
                    {
                        "Code": "151844",
                        "Name": "Kurukshetra,   Haryana"
                    },
                    {
                        "Code": "105541",
                        "Name": "Kuruppanthara,   Kerala"
                    },
                    {
                        "Code": "124044",
                        "Name": "Kushalnagar,   Karnataka"
                    },
                    {
                        "Code": "124045",
                        "Name": "Kushinagar,   Uttar Pradesh"
                    },
                    {
                        "Code": "122798",
                        "Name": "Kutch,   Gujrat"
                    },
                    {
                        "Code": "244233",
                        "Name": "Lachen,   Sikkim"
                    },
                    {
                        "Code": "262996",
                        "Name": "Lachhmangarh,   Rajasthan"
                    },
                    {
                        "Code": "146091",
                        "Name": "Lachung,   Sikkim"
                    },
                    {
                        "Code": "150363",
                        "Name": "Ladakh,   Ladakh"
                    },
                    {
                        "Code": "146104",
                        "Name": "Lahaul and Spiti,   Himachal Pradesh"
                    },
                    {
                        "Code": "161005",
                        "Name": "Lakhimpur,   Uttar Pradesh"
                    },
                    {
                        "Code": "124514",
                        "Name": "Lakkidi,   Kerala"
                    },
                    {
                        "Code": "153914",
                        "Name": "Lakshadweep"
                    },
                    {
                        "Code": "103751",
                        "Name": "Lansdowne,   Uttarakhand"
                    },
                    {
                        "Code": "148903",
                        "Name": "Lataguri,   West Bengal"
                    },
                    {
                        "Code": "125485",
                        "Name": "Latur,   Maharashtra"
                    },
                    {
                        "Code": "146184",
                        "Name": "Lava,   Maharashtra"
                    },
                    {
                        "Code": "125144",
                        "Name": "Leh,   Jammu and Kashmir"
                    },
                    {
                        "Code": "148896",
                        "Name": "LINGSHED,   Jammu and Kashmir"
                    },
                    {
                        "Code": "126630",
                        "Name": "Lonavala,   Maharashtra"
                    },
                    {
                        "Code": "126666",
                        "Name": "Lucknow,   Uttar Pradesh"
                    },
                    {
                        "Code": "125928",
                        "Name": "Ludhiana,   Punjab"
                    },
                    {
                        "Code": "125651",
                        "Name": "Luni,   Rajasthan"
                    },
                    {
                        "Code": "418067",
                        "Name": "Madgaon"
                    },
                    {
                        "Code": "243580",
                        "Name": "Madhapur,   Telangana"
                    },
                    {
                        "Code": "160999",
                        "Name": "Madhubani,   Bihar"
                    },
                    {
                        "Code": "104313",
                        "Name": "Madikeri,   Karnataka"
                    },
                    {
                        "Code": "127067",
                        "Name": "Madurai,   Tamil Nadu"
                    },
                    {
                        "Code": "125684",
                        "Name": "Mahabaleshwar,   Maharashtra"
                    },
                    {
                        "Code": "126117",
                        "Name": "Mahabalipuram,   TAMIL NADU"
                    },
                    {
                        "Code": "103781",
                        "Name": "Mahad,   Maharashtra"
                    },
                    {
                        "Code": "104316",
                        "Name": "Mahansar,   Rajasthan"
                    },
                    {
                        "Code": "417923",
                        "Name": "Maharajganj"
                    },
                    {
                        "Code": "126265",
                        "Name": "Maheshwar,   Madhya Pradesh"
                    },
                    {
                        "Code": "371686",
                        "Name": "Mahipalpur,   National Capital Territory of Delhi"
                    },
                    {
                        "Code": "104318",
                        "Name": "Majorda,   Goa"
                    },
                    {
                        "Code": "146447",
                        "Name": "Malappuram,   Kerala"
                    },
                    {
                        "Code": "102599",
                        "Name": "Malayattoor,   kerala"
                    },
                    {
                        "Code": "150632",
                        "Name": "Malda,   West Bengal"
                    },
                    {
                        "Code": "417300",
                        "Name": "Malout,   Punjab"
                    },
                    {
                        "Code": "127105",
                        "Name": "Malpura,   Rajasthan"
                    },
                    {
                        "Code": "126958",
                        "Name": "Malvan,   Maharashtra"
                    },
                    {
                        "Code": "126139",
                        "Name": "Mamallapuram,   Tamil Nadu"
                    },
                    {
                        "Code": "126388",
                        "Name": "Manali,   Himachal pradesh"
                    },
                    {
                        "Code": "375619",
                        "Name": "Mandarmani,   West Bengal"
                    },
                    {
                        "Code": "104156",
                        "Name": "Mandarmoni,   West Bengal"
                    },
                    {
                        "Code": "263259",
                        "Name": "Mandav"
                    },
                    {
                        "Code": "126802",
                        "Name": "Mandawa,   Rajasthan"
                    },
                    {
                        "Code": "146462",
                        "Name": "Mandi,   Himachal Pradesh"
                    },
                    {
                        "Code": "160389",
                        "Name": "Mandla,   Madhya Pradesh"
                    },
                    {
                        "Code": "104482",
                        "Name": "Mandrem,   Goa"
                    },
                    {
                        "Code": "126805",
                        "Name": "Mangaluru,   Karnataka"
                    },
                    {
                        "Code": "104157",
                        "Name": "Manipal,   Karnataka"
                    },
                    {
                        "Code": "126810",
                        "Name": "Manmad,   Maharashtra"
                    },
                    {
                        "Code": "104323",
                        "Name": "Mapusa,   Goa"
                    },
                    {
                        "Code": "146481",
                        "Name": "Maradu,   Kerala"
                    },
                    {
                        "Code": "146484",
                        "Name": "Marari Beach,   Kerala"
                    },
                    {
                        "Code": "126817",
                        "Name": "Mararikulam,   KERALA"
                    },
                    {
                        "Code": "336934",
                        "Name": "Marchula,   Uttarakhand"
                    },
                    {
                        "Code": "106481",
                        "Name": "Margao,   Goa"
                    },
                    {
                        "Code": "299743",
                        "Name": "Marmagao,   Goa"
                    },
                    {
                        "Code": "146533",
                        "Name": "Mashobra,   Himachal Pradesh"
                    },
                    {
                        "Code": "146545",
                        "Name": "Matheran,   Maharashtra"
                    },
                    {
                        "Code": "127857",
                        "Name": "Mathura,   Uttar Pradesh"
                    },
                    {
                        "Code": "126911",
                        "Name": "Mayiladuthurai,   Tamil Nadu"
                    },
                    {
                        "Code": "104040",
                        "Name": "McLeod Ganj,   Himachal Pradesh"
                    },
                    {
                        "Code": "146575",
                        "Name": "Meerut,   Uttar Pradesh"
                    },
                    {
                        "Code": "151812",
                        "Name": "Mehsana,   Gujarat"
                    },
                    {
                        "Code": "161036",
                        "Name": "Melaghar,   Tripura"
                    },
                    {
                        "Code": "295351",
                        "Name": "Mendarda"
                    },
                    {
                        "Code": "104345",
                        "Name": "Meppadi,   Kerala"
                    },
                    {
                        "Code": "128829",
                        "Name": "Mettupalayam,   Tamil Nadu"
                    },
                    {
                        "Code": "300324",
                        "Name": "Mhow,   Madhya Pradesh"
                    },
                    {
                        "Code": "150356",
                        "Name": "Midnapur,   West Bengal"
                    },
                    {
                        "Code": "106510",
                        "Name": "Mirik,   West Bengal"
                    },
                    {
                        "Code": "151864",
                        "Name": "Mirzapur,   Uttar Pradesh"
                    },
                    {
                        "Code": "128914",
                        "Name": "Mobor Beach,   Goa"
                    },
                    {
                        "Code": "370782",
                        "Name": "Modasa,   Gujarat"
                    },
                    {
                        "Code": "299281",
                        "Name": "Moga"
                    },
                    {
                        "Code": "106514",
                        "Name": "Mohali,   Punjab"
                    },
                    {
                        "Code": "102819",
                        "Name": "Mohan,   Uttar Pradesh"
                    },
                    {
                        "Code": "103825",
                        "Name": "Mohania,   Bihar"
                    },
                    {
                        "Code": "364153",
                        "Name": "Mohanlalganj,   Uttar Pradesh"
                    },
                    {
                        "Code": "101894",
                        "Name": "Mollem,   Goa"
                    },
                    {
                        "Code": "129615",
                        "Name": "Moradabad,   Uttar Pradesh"
                    },
                    {
                        "Code": "102834",
                        "Name": "Morbi,   Gujarat"
                    },
                    {
                        "Code": "129044",
                        "Name": "Morjim,   Goa"
                    },
                    {
                        "Code": "146752",
                        "Name": "Mount Abu,   Rajasthan"
                    },
                    {
                        "Code": "151863",
                        "Name": "Mughalsarai,   Uttar Pradesh"
                    },
                    {
                        "Code": "129690",
                        "Name": "Mukkam,   Kerala"
                    },
                    {
                        "Code": "129415",
                        "Name": "Mukteshwar,   Uttarakhand"
                    },
                    {
                        "Code": "301296",
                        "Name": "Muktsar,   Punjab"
                    },
                    {
                        "Code": "146768",
                        "Name": "Mukundgarh,   Rajasthan"
                    },
                    {
                        "Code": "129695",
                        "Name": "Mullor"
                    },
                    {
                        "Code": "237563",
                        "Name": "Mulshi,   Maharashtra"
                    },
                    {
                        "Code": "144306",
                        "Name": "Mumbai/Bombay,   Maharashtra"
                    },
                    {
                        "Code": "381757",
                        "Name": "Mundra,   Gujarat"
                    },
                    {
                        "Code": "128573",
                        "Name": "Munnar,   Kerala"
                    },
                    {
                        "Code": "146776",
                        "Name": "Munsiyari,   Uttarakhand"
                    },
                    {
                        "Code": "129232",
                        "Name": "Muradabad,   Uttar Pradesh"
                    },
                    {
                        "Code": "128030",
                        "Name": "Murbad,   Maharashtra"
                    },
                    {
                        "Code": "129104",
                        "Name": "Murinjapuzha,   Kerala"
                    },
                    {
                        "Code": "295707",
                        "Name": "Murthal,   Haryana"
                    },
                    {
                        "Code": "129434",
                        "Name": "Murud,   Maharashtra"
                    },
                    {
                        "Code": "130341",
                        "Name": "Mussoorie,   Uttarakhand"
                    },
                    {
                        "Code": "150392",
                        "Name": "Muzaffarnagar,   Uttar Pradesh"
                    },
                    {
                        "Code": "151536",
                        "Name": "Muzaffarpur,   Bihar"
                    },
                    {
                        "Code": "128698",
                        "Name": "Mysuru,   Karnataka"
                    },
                    {
                        "Code": "417527",
                        "Name": "Nabadwip"
                    },
                    {
                        "Code": "153797",
                        "Name": "Nadia District,   West Bengal"
                    },
                    {
                        "Code": "104506",
                        "Name": "Nadiad,   Gujarat"
                    },
                    {
                        "Code": "130352",
                        "Name": "Nadukani,   Kerala"
                    },
                    {
                        "Code": "274813",
                        "Name": "Nagaon,   Assam"
                    },
                    {
                        "Code": "129447",
                        "Name": "Nagapattinam,   Tamil Nadu"
                    },
                    {
                        "Code": "160628",
                        "Name": "Nagaur,   Rajasthan"
                    },
                    {
                        "Code": "104260",
                        "Name": "Naggar,   Himachal Pradesh"
                    },
                    {
                        "Code": "129723",
                        "Name": "Nagpur,   Maharashtra"
                    },
                    {
                        "Code": "338761",
                        "Name": "Nahan,   Himachal Pradesh"
                    },
                    {
                        "Code": "130354",
                        "Name": "Nahar Magra,   Rajasthan"
                    },
                    {
                        "Code": "160877",
                        "Name": "NAIMISHARANYA,   UTTAR PRADESH"
                    },
                    {
                        "Code": "129726",
                        "Name": "Nainital,   Uttarakhand"
                    },
                    {
                        "Code": "130357",
                        "Name": "Nakinda,   Maharashtra"
                    },
                    {
                        "Code": "129257",
                        "Name": "Nalagarh,   Himachal Pradesh"
                    },
                    {
                        "Code": "151833",
                        "Name": "Naldehra,   Himachal"
                    },
                    {
                        "Code": "130105",
                        "Name": "Nalkeri,   Karnataka"
                    },
                    {
                        "Code": "104509",
                        "Name": "Namakkal,   Tamil Nadu"
                    },
                    {
                        "Code": "130358",
                        "Name": "Namchi,   Sikkim"
                    },
                    {
                        "Code": "129732",
                        "Name": "Nanded,   Maharashtra"
                    },
                    {
                        "Code": "299841",
                        "Name": "Nandurbar,   Maharashtra"
                    },
                    {
                        "Code": "160634",
                        "Name": "Narendranagar,   Uttarakhand"
                    },
                    {
                        "Code": "102033",
                        "Name": "Narkanda,   Himachal Pradesh"
                    },
                    {
                        "Code": "129163",
                        "Name": "Narlai,   Rajasthan"
                    },
                    {
                        "Code": "418060",
                        "Name": "Narmadapuram,   Madhya Pradesh"
                    },
                    {
                        "Code": "146814",
                        "Name": "Nashik,   Maharashtra"
                    },
                    {
                        "Code": "151845",
                        "Name": "Nathdwara,   Rajasthan"
                    },
                    {
                        "Code": "146820",
                        "Name": "Nattika,   Kerala"
                    },
                    {
                        "Code": "128734",
                        "Name": "Navi Mumbai,   Maharashtra"
                    },
                    {
                        "Code": "300782",
                        "Name": "Navsari,   Gujarat"
                    },
                    {
                        "Code": "146825",
                        "Name": "Nawalgarh,   Rajasthan"
                    },
                    {
                        "Code": "151846",
                        "Name": "Nawanshahar,   Punjab"
                    },
                    {
                        "Code": "154145",
                        "Name": "Nawanshahr,   Punjab"
                    },
                    {
                        "Code": "150203",
                        "Name": "Nedumbassery,   Kerala"
                    },
                    {
                        "Code": "129816",
                        "Name": "Neeleshwar,   Kerala"
                    },
                    {
                        "Code": "130137",
                        "Name": "Neemrana,   RAJASTHAN"
                    },
                    {
                        "Code": "235963",
                        "Name": "Neemuch,   Madhya Pradesh"
                    },
                    {
                        "Code": "129189",
                        "Name": "Neil Island,   Andaman & Nicobar"
                    },
                    {
                        "Code": "358240",
                        "Name": "Nelamangala,   Karnataka"
                    },
                    {
                        "Code": "129289",
                        "Name": "Nellore,   Andhra Pradesh"
                    },
                    {
                        "Code": "129827",
                        "Name": "Nerul,   Maharashtra"
                    },
                    {
                        "Code": "130443",
                        "Name": "New Delhi / Delhi,   DELHI"
                    },
                    {
                        "Code": "287941",
                        "Name": "New Digha,   West Bengal"
                    },
                    {
                        "Code": "150649",
                        "Name": "Neyveli,   Tamil Nadu"
                    },
                    {
                        "Code": "346564",
                        "Name": "Nilambur,   Kerala"
                    },
                    {
                        "Code": "104531",
                        "Name": "Nilgiri,   Tamil Nadu"
                    },
                    {
                        "Code": "129477",
                        "Name": "Nimaj,   Rajasthan"
                    },
                    {
                        "Code": "130205",
                        "Name": "Noida,   UTTAR PRADESH"
                    },
                    {
                        "Code": "153921",
                        "Name": "North Goa,   Goa"
                    },
                    {
                        "Code": "150162",
                        "Name": "North Lakhimpur,   Assam"
                    },
                    {
                        "Code": "106556",
                        "Name": "North Paravur,   Kerala"
                    },
                    {
                        "Code": "153975",
                        "Name": "North Sikkim,   Sikkim"
                    },
                    {
                        "Code": "150357",
                        "Name": "NYERAK,   Jammu Kashmir"
                    },
                    {
                        "Code": "131276",
                        "Name": "Omkareshwar,   Madhya Pradesh"
                    },
                    {
                        "Code": "130990",
                        "Name": "Ooty,   Tamil Nadu"
                    },
                    {
                        "Code": "130252",
                        "Name": "Orchha,   Madhya Pradesh"
                    },
                    {
                        "Code": "132015",
                        "Name": "Pachmarhi,   Madhya Pradesh"
                    },
                    {
                        "Code": "130852",
                        "Name": "Padappai,   Tamil Nadu"
                    },
                    {
                        "Code": "131375",
                        "Name": "Pahalgam,   Jammu and Kashmir"
                    },
                    {
                        "Code": "131721",
                        "Name": "Pakhal,   Telangana"
                    },
                    {
                        "Code": "132025",
                        "Name": "Palakkad,   Kerala"
                    },
                    {
                        "Code": "153808",
                        "Name": "Palakkad District"
                    },
                    {
                        "Code": "147070",
                        "Name": "Palampur,   Himachal Pradesh"
                    },
                    {
                        "Code": "130749",
                        "Name": "Palani,   Tamil Nadu"
                    },
                    {
                        "Code": "130316",
                        "Name": "Palanpur,   Gujrat"
                    },
                    {
                        "Code": "292291",
                        "Name": "Palghar"
                    },
                    {
                        "Code": "147075",
                        "Name": "Pali,   Rajasthan"
                    },
                    {
                        "Code": "294433",
                        "Name": "Palia Kalan,   Uttar Pradesh"
                    },
                    {
                        "Code": "362198",
                        "Name": "Palolem,   Goa"
                    },
                    {
                        "Code": "241457",
                        "Name": "Palwal,   Haryana"
                    },
                    {
                        "Code": "131398",
                        "Name": "Panaji,   Goa"
                    },
                    {
                        "Code": "131394",
                        "Name": "Panchgani,   Maharashtra"
                    },
                    {
                        "Code": "131002",
                        "Name": "Panchkula,   Haryana"
                    },
                    {
                        "Code": "261909",
                        "Name": "Pandharpur,   Maharashtra"
                    },
                    {
                        "Code": "147083",
                        "Name": "Pandikkad,   Kerala"
                    },
                    {
                        "Code": "106580",
                        "Name": "Pangong Tso Lake,   Jammu And Kashmir"
                    },
                    {
                        "Code": "298741",
                        "Name": "Panhala,   Maharashtra"
                    },
                    {
                        "Code": "147088",
                        "Name": "Panipat,   Haryana"
                    },
                    {
                        "Code": "131437",
                        "Name": "Panna,   Madhya Pradesh"
                    },
                    {
                        "Code": "150800",
                        "Name": "Pantnagar,   Uttarakhand"
                    },
                    {
                        "Code": "131544",
                        "Name": "Panvel,   Maharashtra "
                    },
                    {
                        "Code": "353074",
                        "Name": "Paradeep,   Odisha"
                    },
                    {
                        "Code": "131406",
                        "Name": "Paragpur,   Himachal Pradesh"
                    },
                    {
                        "Code": "418061",
                        "Name": "Paralakhemundi,   Odisha"
                    },
                    {
                        "Code": "131552",
                        "Name": "Paravur,   Kerala"
                    },
                    {
                        "Code": "151861",
                        "Name": "Parbhani,   Maharashtra"
                    },
                    {
                        "Code": "132055",
                        "Name": "Parra,   Goa"
                    },
                    {
                        "Code": "147106",
                        "Name": "Parwanoo,   Himachal Pradesh"
                    },
                    {
                        "Code": "315734",
                        "Name": "Patan,   Gujarat"
                    },
                    {
                        "Code": "106662",
                        "Name": "Pateri,   Bihar"
                    },
                    {
                        "Code": "131027",
                        "Name": "Pathanamthitta,   Kerala"
                    },
                    {
                        "Code": "132705",
                        "Name": "Pathankot,   Punjab"
                    },
                    {
                        "Code": "106663",
                        "Name": "Patiala,   Punjab"
                    },
                    {
                        "Code": "132429",
                        "Name": "Patna,   Bihar"
                    },
                    {
                        "Code": "418068",
                        "Name": "Patnem"
                    },
                    {
                        "Code": "131028",
                        "Name": "Patnitop,   Jammu and Kashmir"
                    },
                    {
                        "Code": "161105",
                        "Name": "Peermade,   Kerala"
                    },
                    {
                        "Code": "147140",
                        "Name": "Pelling,   Sikkim"
                    },
                    {
                        "Code": "132089",
                        "Name": "Pench,   Madhya Pradesh"
                    },
                    {
                        "Code": "132724",
                        "Name": "Pench Nationalpark,   Madhya Pradesh"
                    },
                    {
                        "Code": "102750",
                        "Name": "Perambalur,   Tamil Nadu"
                    },
                    {
                        "Code": "157867",
                        "Name": "Perintalmanna,   Kerala"
                    },
                    {
                        "Code": "103270",
                        "Name": "Perinthalmanna,   Kerala"
                    },
                    {
                        "Code": "132133",
                        "Name": "Periyar,   Kerala"
                    },
                    {
                        "Code": "131597",
                        "Name": "Pernem,   Goa"
                    },
                    {
                        "Code": "132753",
                        "Name": "Phagwara,   Punjab"
                    },
                    {
                        "Code": "131523",
                        "Name": "Phalodi,   Rajasthan"
                    },
                    {
                        "Code": "106676",
                        "Name": "Phaltan,   Maharashtra "
                    },
                    {
                        "Code": "133418",
                        "Name": "Pimpri-Chinchwad,   Maharashtra"
                    },
                    {
                        "Code": "132183",
                        "Name": "Pinjore,   Haryana"
                    },
                    {
                        "Code": "295095",
                        "Name": "Pithoragarh,   Uttarakhand"
                    },
                    {
                        "Code": "133214",
                        "Name": "Pokhran,   Rajasthan"
                    },
                    {
                        "Code": "132282",
                        "Name": "Pollachi,   Tamil Nadu"
                    },
                    {
                        "Code": "132292",
                        "Name": "Ponmudi,   Kerala"
                    },
                    {
                        "Code": "133497",
                        "Name": "Poovar,   Kerala"
                    },
                    {
                        "Code": "133551",
                        "Name": "Porbandar,   Gujarat"
                    },
                    {
                        "Code": "133556",
                        "Name": "Port Blair,   Andaman And Nicobar"
                    },
                    {
                        "Code": "151840",
                        "Name": "Pragpur,   Himachal Pradesh"
                    },
                    {
                        "Code": "100307",
                        "Name": "Prayagraj (Formally-Allahabad),   Uttar Pradesh"
                    },
                    {
                        "Code": "280675",
                        "Name": "Proddatur,   Andhra Pradesh"
                    },
                    {
                        "Code": "132561",
                        "Name": "Puducherry/Pondicherry,   Tamil Nadu"
                    },
                    {
                        "Code": "106703",
                        "Name": "Pudukkotai,   Tamil Nadu"
                    },
                    {
                        "Code": "394717",
                        "Name": "Pudukkottai,   Tamil Nadu"
                    },
                    {
                        "Code": "134170",
                        "Name": "Pulamanthole,   Kerala"
                    },
                    {
                        "Code": "133133",
                        "Name": "Pune,   Maharashtra"
                    },
                    {
                        "Code": "147410",
                        "Name": "Purakkad,   Kerala"
                    },
                    {
                        "Code": "275226",
                        "Name": "Purasaiwakkam,   Tamil Nadu"
                    },
                    {
                        "Code": "153873",
                        "Name": "Purba Medinipur District,   West Bengal"
                    },
                    {
                        "Code": "132593",
                        "Name": "Puri,   Orissa"
                    },
                    {
                        "Code": "293576",
                        "Name": "Purnia,   Bihar"
                    },
                    {
                        "Code": "306303",
                        "Name": "Purulia,   West Bengal"
                    },
                    {
                        "Code": "134001",
                        "Name": "Pushkar,   Rajasthan"
                    },
                    {
                        "Code": "134178",
                        "Name": "Puttaparthi,   Andhra Pradesh"
                    },
                    {
                        "Code": "254863",
                        "Name": "Raebareli,   Uttar Pradesh"
                    },
                    {
                        "Code": "147442",
                        "Name": "Raigad,   Maharashtra"
                    },
                    {
                        "Code": "237311",
                        "Name": "Raigarh,   Chhattisgarh"
                    },
                    {
                        "Code": "133672",
                        "Name": "Raipur,   Rajasthan"
                    },
                    {
                        "Code": "134040",
                        "Name": "Rajahmahendravaram,   Andhra Pradesh"
                    },
                    {
                        "Code": "102941",
                        "Name": "Rajakkad,   Kerala"
                    },
                    {
                        "Code": "102942",
                        "Name": "Rajapalayam,   Tamil Nadu"
                    },
                    {
                        "Code": "134041",
                        "Name": "Rajgarh,   Himachal Pradesh"
                    },
                    {
                        "Code": "133175",
                        "Name": "Rajgir,   Bihar"
                    },
                    {
                        "Code": "134211",
                        "Name": "Rajkot,   Gujarat"
                    },
                    {
                        "Code": "298575",
                        "Name": "Rajnandgaon"
                    },
                    {
                        "Code": "304525",
                        "Name": "Rajpipla"
                    },
                    {
                        "Code": "153963",
                        "Name": "Rajsamand"
                    },
                    {
                        "Code": "151654",
                        "Name": "Ramagundam,   Telangana"
                    },
                    {
                        "Code": "133177",
                        "Name": "Ramakkalmedu,   Kerala"
                    },
                    {
                        "Code": "404831",
                        "Name": "Ramanathapuram,   Tamil Nadu"
                    },
                    {
                        "Code": "134213",
                        "Name": "Ramathra Fort,   Rajasthan"
                    },
                    {
                        "Code": "133179",
                        "Name": "Rameshwaram,   Tamil Nadu"
                    },
                    {
                        "Code": "151860",
                        "Name": "Rameswaram,   TAMIL NADU"
                    },
                    {
                        "Code": "132621",
                        "Name": "Ramgarh,   Uttarakhand"
                    },
                    {
                        "Code": "134214",
                        "Name": "Ramnagar,   Uttarakhand"
                    },
                    {
                        "Code": "133676",
                        "Name": "Ranakpur,   Rajasthan"
                    },
                    {
                        "Code": "133760",
                        "Name": "Ranchi,   Jharkhand"
                    },
                    {
                        "Code": "133838",
                        "Name": "Ranikhet,   Uttarakhand"
                    },
                    {
                        "Code": "134224",
                        "Name": "Ranthambore Nationalpark,   Rajasthan"
                    },
                    {
                        "Code": "102675",
                        "Name": "Ratlam,   Madhya Pradesh"
                    },
                    {
                        "Code": "133687",
                        "Name": "Ratnagiri,   Maharashtra"
                    },
                    {
                        "Code": "133295",
                        "Name": "Ravangla,   Sikkim"
                    },
                    {
                        "Code": "295703",
                        "Name": "Razole,   Andhra Pradesh"
                    },
                    {
                        "Code": "102683",
                        "Name": "Renigunta,   Andhra Pradesh"
                    },
                    {
                        "Code": "150930",
                        "Name": "Rewa,   Madhya Pradesh"
                    },
                    {
                        "Code": "147501",
                        "Name": "Rewari,   Delhi National Territory"
                    },
                    {
                        "Code": "102954",
                        "Name": "Rinchenpong,   Sikkim"
                    },
                    {
                        "Code": "134932",
                        "Name": "Rishikesh,   Uttarakhand"
                    },
                    {
                        "Code": "147554",
                        "Name": "Rohet,   Rajasthan"
                    },
                    {
                        "Code": "103217",
                        "Name": "Rohetgarh,   Rajasthan"
                    },
                    {
                        "Code": "134058",
                        "Name": "Rohtak,   Haryana"
                    },
                    {
                        "Code": "150180",
                        "Name": "Roorkee,   Uttarakhand"
                    },
                    {
                        "Code": "134643",
                        "Name": "Rourkela,   Orissa"
                    },
                    {
                        "Code": "135778",
                        "Name": "Rudraprayag,   Uttarakhand"
                    },
                    {
                        "Code": "150359",
                        "Name": "Rudrapur,   Uttarakhand"
                    },
                    {
                        "Code": "150936",
                        "Name": "Rupsi,   Assam"
                    },
                    {
                        "Code": "267858",
                        "Name": "Sagar,   Madhya Pradesh"
                    },
                    {
                        "Code": "272583",
                        "Name": "Sagara,   Karnataka"
                    },
                    {
                        "Code": "103325",
                        "Name": "Saharanpur,   Uttar Pradesh"
                    },
                    {
                        "Code": "147607",
                        "Name": "Sahibzada Ajit Singh Nagar,   Punjab"
                    },
                    {
                        "Code": "394732",
                        "Name": "Sakleshpur,   Karnataka"
                    },
                    {
                        "Code": "103491",
                        "Name": "Salasar,   Rajasthan"
                    },
                    {
                        "Code": "154057",
                        "Name": "Salcete,   Goa"
                    },
                    {
                        "Code": "135916",
                        "Name": "Salem,   Tamil Nadu"
                    },
                    {
                        "Code": "135694",
                        "Name": "Saligao,   Goa"
                    },
                    {
                        "Code": "272466",
                        "Name": "Samastipur,   Bihar"
                    },
                    {
                        "Code": "103344",
                        "Name": "Samayapuram,   Tamil Nadu"
                    },
                    {
                        "Code": "103345",
                        "Name": "Sambalpur,   Odisha"
                    },
                    {
                        "Code": "103346",
                        "Name": "Samode,   Rajasthan"
                    },
                    {
                        "Code": "106770",
                        "Name": "Sanand,   Gujarat"
                    },
                    {
                        "Code": "135522",
                        "Name": "Sanchi,   Madhya Pradesh"
                    },
                    {
                        "Code": "417319",
                        "Name": "Sanchore,   Rajasthan"
                    },
                    {
                        "Code": "202708",
                        "Name": "Sangla,   Himachal Pradesh"
                    },
                    {
                        "Code": "136501",
                        "Name": "Sangli,   Maharashtra"
                    },
                    {
                        "Code": "394926",
                        "Name": "Saputara"
                    },
                    {
                        "Code": "205218",
                        "Name": "Sarchu,   Sarchu"
                    },
                    {
                        "Code": "136093",
                        "Name": "Sardargarh,   Rajasthan"
                    },
                    {
                        "Code": "135586",
                        "Name": "Sariska National Park,   Rajasthan"
                    },
                    {
                        "Code": "136555",
                        "Name": "Sasan Gir,   Gujarat"
                    },
                    {
                        "Code": "261894",
                        "Name": "Sasaram"
                    },
                    {
                        "Code": "136409",
                        "Name": "Satara,   Maharashtra"
                    },
                    {
                        "Code": "147780",
                        "Name": "Satna,   Madhya Pradesh"
                    },
                    {
                        "Code": "148897",
                        "Name": "Satpura,   Madhya Pradesh"
                    },
                    {
                        "Code": "151847",
                        "Name": "Sattal,   Uttarakhand"
                    },
                    {
                        "Code": "136656",
                        "Name": "Sawai Madhopur,   Rajasthan"
                    },
                    {
                        "Code": "136748",
                        "Name": "Secunderabad,   Telangana"
                    },
                    {
                        "Code": "136766",
                        "Name": "Seoni,   Madhya Pradesh"
                    },
                    {
                        "Code": "222992",
                        "Name": "Seraikela,   Jharkhand"
                    },
                    {
                        "Code": "150360",
                        "Name": "Shahpur,   Maharashtra"
                    },
                    {
                        "Code": "137380",
                        "Name": "Shahpura,   Rajasthan"
                    },
                    {
                        "Code": "136285",
                        "Name": "Shamirpet,   Telangana"
                    },
                    {
                        "Code": "107371",
                        "Name": "Shamshabad,   Telangana"
                    },
                    {
                        "Code": "137568",
                        "Name": "Shantiniketan,   West Bengal"
                    },
                    {
                        "Code": "268822",
                        "Name": "Shegaon,   Maharashtra"
                    },
                    {
                        "Code": "138670",
                        "Name": "Shillong,   Meghalaya"
                    },
                    {
                        "Code": "138673",
                        "Name": "Shimla,   Himachal Pradesh"
                    },
                    {
                        "Code": "154080",
                        "Name": "Shimoga district"
                    },
                    {
                        "Code": "148898",
                        "Name": "SHINGRAK,   Jammu and Kashmir"
                    },
                    {
                        "Code": "137316",
                        "Name": "Shirdi,   Maharashtra"
                    },
                    {
                        "Code": "147891",
                        "Name": "Shivamogga,   Karnataka"
                    },
                    {
                        "Code": "137750",
                        "Name": "Shivpuri,   Madhya Pradesh"
                    },
                    {
                        "Code": "106639",
                        "Name": "Sholayur,   Kerala"
                    },
                    {
                        "Code": "137404",
                        "Name": "Siana,   Rajasthan"
                    },
                    {
                        "Code": "136312",
                        "Name": "Sikar,   Rajasthan"
                    },
                    {
                        "Code": "153976",
                        "Name": "Sikkim"
                    },
                    {
                        "Code": "150361",
                        "Name": "Silchar,   Assam"
                    },
                    {
                        "Code": "147912",
                        "Name": "Siliguri,   West Bengal"
                    },
                    {
                        "Code": "147914",
                        "Name": "Silvassa,   Dadra and Nagar Have"
                    },
                    {
                        "Code": "137470",
                        "Name": "Sindhudi,   Gujarat"
                    },
                    {
                        "Code": "153859",
                        "Name": "Sindhudurg"
                    },
                    {
                        "Code": "106649",
                        "Name": "Singrauli,   Madhya Pradesh"
                    },
                    {
                        "Code": "138010",
                        "Name": "Siolim,   Goa"
                    },
                    {
                        "Code": "106650",
                        "Name": "Sirkazhi,   Tamil Nadu"
                    },
                    {
                        "Code": "154070",
                        "Name": "Sirmaur District"
                    },
                    {
                        "Code": "103180",
                        "Name": "Sirsa,   Haryana "
                    },
                    {
                        "Code": "107226",
                        "Name": "Sitalakhet,   Uttarakhand "
                    },
                    {
                        "Code": "293199",
                        "Name": "Sitapur,   Uttar Pradesh"
                    },
                    {
                        "Code": "106898",
                        "Name": "Sitlakhet,   Uttarakhand "
                    },
                    {
                        "Code": "106651",
                        "Name": "Skara,   Maharashtra "
                    },
                    {
                        "Code": "302824",
                        "Name": "Sohagpur"
                    },
                    {
                        "Code": "138127",
                        "Name": "Solan,   Himachal Pradesh"
                    },
                    {
                        "Code": "154112",
                        "Name": "Solan District"
                    },
                    {
                        "Code": "138128",
                        "Name": "Solapur,   Maharashtra"
                    },
                    {
                        "Code": "138049",
                        "Name": "Somnath,   Gujarat"
                    },
                    {
                        "Code": "138484",
                        "Name": "Sonamarg,   Jammu And Kashmir"
                    },
                    {
                        "Code": "151848",
                        "Name": "Sonipat,   Haryana"
                    },
                    {
                        "Code": "151835",
                        "Name": "Sonmarg,   Jammu and Kashmir"
                    },
                    {
                        "Code": "154101",
                        "Name": "South 24 Parganas"
                    },
                    {
                        "Code": "153958",
                        "Name": "South Goa"
                    },
                    {
                        "Code": "376717",
                        "Name": "Spangmik,   Ladakh"
                    },
                    {
                        "Code": "138523",
                        "Name": "Sravasti,   Uttar Pradesh"
                    },
                    {
                        "Code": "107250",
                        "Name": "Sri Ganganagar,   Rajasthan"
                    },
                    {
                        "Code": "137118",
                        "Name": "Srikakulam,   Andhra Pradesh"
                    },
                    {
                        "Code": "299949",
                        "Name": "Srikalahasti"
                    },
                    {
                        "Code": "139456",
                        "Name": "Srinagar,   Jammu and Kashmir"
                    },
                    {
                        "Code": "103198",
                        "Name": "Srinagar, Uttarakhand,   Uttarakhand"
                    },
                    {
                        "Code": "417859",
                        "Name": "Sringeri or Shringeri,   Karnataka"
                    },
                    {
                        "Code": "138370",
                        "Name": "Sriperumbudur,   Tamil Nadu"
                    },
                    {
                        "Code": "108572",
                        "Name": "Stok,   Jammu And Kashmir"
                    },
                    {
                        "Code": "107078",
                        "Name": "Sultan Bathery,   Kerala"
                    },
                    {
                        "Code": "151849",
                        "Name": "Sultanpur,   Uttar Pradesh"
                    },
                    {
                        "Code": "286488",
                        "Name": "Sundarnagar,   Himachal Pradesh"
                    },
                    {
                        "Code": "140235",
                        "Name": "Sunderban,   West Bengal"
                    },
                    {
                        "Code": "107275",
                        "Name": "Sungal,   Jammu Kashmir"
                    },
                    {
                        "Code": "151866",
                        "Name": "Surajgarh,   Rajasthan"
                    },
                    {
                        "Code": "139526",
                        "Name": "Surat,   Gujarat"
                    },
                    {
                        "Code": "107754",
                        "Name": "Suratgarh,   Rajasthan"
                    },
                    {
                        "Code": "305699",
                        "Name": "Surendranagar,   Gujarat"
                    },
                    {
                        "Code": "151834",
                        "Name": "Taboda,   Maharashtra"
                    },
                    {
                        "Code": "151850",
                        "Name": "Tadoba,   Maharashtra"
                    },
                    {
                        "Code": "161006",
                        "Name": "Taki,   West Bengal"
                    },
                    {
                        "Code": "139669",
                        "Name": "Tala,   Maharashtra"
                    },
                    {
                        "Code": "273102",
                        "Name": "Talala,   Gujarat"
                    },
                    {
                        "Code": "139974",
                        "Name": "Tarangambadi,   Tamil Nadu"
                    },
                    {
                        "Code": "150362",
                        "Name": "Tarapith,   West Bengal"
                    },
                    {
                        "Code": "139699",
                        "Name": "Tawang,   Arunachal Pradesh"
                    },
                    {
                        "Code": "160633",
                        "Name": "Tehri,   Uttarakhand"
                    },
                    {
                        "Code": "139069",
                        "Name": "Tezpur,   Assam"
                    },
                    {
                        "Code": "106383",
                        "Name": "Thakurdwara,   Uttar Pradesh"
                    },
                    {
                        "Code": "139071",
                        "Name": "Thalassery,   Kerala"
                    },
                    {
                        "Code": "140020",
                        "Name": "Thane,   Maharashtra"
                    },
                    {
                        "Code": "300755",
                        "Name": "Thanesar"
                    },
                    {
                        "Code": "139605",
                        "Name": "Thanjavur,   Tamil Nadu"
                    },
                    {
                        "Code": "138628",
                        "Name": "Thanneermukkom,   Kerala"
                    },
                    {
                        "Code": "139609",
                        "Name": "Thekkady,   Kerala"
                    },
                    {
                        "Code": "139744",
                        "Name": "Theni,   Tamil Nadu"
                    },
                    {
                        "Code": "299948",
                        "Name": "Theog"
                    },
                    {
                        "Code": "140415",
                        "Name": "Thiksey,   Jammu And Kashmir"
                    },
                    {
                        "Code": "302786",
                        "Name": "Thirukkadaiyur,   Tamil Nadu"
                    },
                    {
                        "Code": "338807",
                        "Name": "Thirumayam,   Tamil Nadu"
                    },
                    {
                        "Code": "148901",
                        "Name": "Thiruvananthapuram,   Kerala"
                    },
                    {
                        "Code": "106955",
                        "Name": "Thodupuzha,   Kerala"
                    },
                    {
                        "Code": "141231",
                        "Name": "Thoothukudi,   Tamil Nadu"
                    },
                    {
                        "Code": "140032",
                        "Name": "Thrissur,   Kerala"
                    },
                    {
                        "Code": "106958",
                        "Name": "Thumkunta,   Telangana"
                    },
                    {
                        "Code": "150287",
                        "Name": "TIB BAGO,   Jammu and Kashmir"
                    },
                    {
                        "Code": "333310",
                        "Name": "Tindivanam,   Tamil Nadu"
                    },
                    {
                        "Code": "107782",
                        "Name": "Tinsukia,   Assam"
                    },
                    {
                        "Code": "105896",
                        "Name": "Tiracol,   Tiracol"
                    },
                    {
                        "Code": "399762",
                        "Name": "Tiruchendur"
                    },
                    {
                        "Code": "148240",
                        "Name": "Tiruchirappalli,   Tamil Nadu"
                    },
                    {
                        "Code": "140310",
                        "Name": "Tirunelveli,   Tamil Nadu"
                    },
                    {
                        "Code": "281412",
                        "Name": "Tirunelveli District"
                    },
                    {
                        "Code": "140311",
                        "Name": "Tirupati,   Andhra Pradesh"
                    },
                    {
                        "Code": "141054",
                        "Name": "Tiruppur,   Tamil Nadu"
                    },
                    {
                        "Code": "106394",
                        "Name": "Tiruttani,   Tamil Nadu"
                    },
                    {
                        "Code": "139315",
                        "Name": "Tiruvannamalai,   Tamil Nadu"
                    },
                    {
                        "Code": "106963",
                        "Name": "Titwala,   Maharashtra"
                    },
                    {
                        "Code": "280875",
                        "Name": "Tosh,   Himachal Pradesh"
                    },
                    {
                        "Code": "106849",
                        "Name": "Trimbak,   Maharashtra "
                    },
                    {
                        "Code": "139820",
                        "Name": "Trivandrum,   Kerala"
                    },
                    {
                        "Code": "106856",
                        "Name": "Tura,   Meghalaya"
                    },
                    {
                        "Code": "141528",
                        "Name": "Turia,   West Bengal"
                    },
                    {
                        "Code": "140098",
                        "Name": "Uchiyarda,   Rajasthan"
                    },
                    {
                        "Code": "140522",
                        "Name": "Udaipur,   Rajasthan"
                    },
                    {
                        "Code": "377670",
                        "Name": "Udumalaipettai,   Tamil Nadu"
                    },
                    {
                        "Code": "148363",
                        "Name": "Udupi,   Karnataka"
                    },
                    {
                        "Code": "140701",
                        "Name": "Ujjain,   Madhya Pradesh"
                    },
                    {
                        "Code": "157929",
                        "Name": "Ukhimath,   Uttarakhand"
                    },
                    {
                        "Code": "299947",
                        "Name": "Ulhasnagar,   Maharashtra"
                    },
                    {
                        "Code": "141832",
                        "Name": "Umaria,   Madhya Pradesh"
                    },
                    {
                        "Code": "141097",
                        "Name": "Una,   Himachal Pradesh"
                    },
                    {
                        "Code": "148374",
                        "Name": "Unchagaon,   Uttar Pradesh"
                    },
                    {
                        "Code": "286704",
                        "Name": "Unjha,   Gujarat"
                    },
                    {
                        "Code": "300441",
                        "Name": "Unnao,   Uttar Pradesh"
                    },
                    {
                        "Code": "107938",
                        "Name": "Uruli Kanchan,   Maharashtra"
                    },
                    {
                        "Code": "141578",
                        "Name": "Utorda Beach,   Goa"
                    },
                    {
                        "Code": "385613",
                        "Name": "Uttan,   Maharashtra"
                    },
                    {
                        "Code": "154207",
                        "Name": "Uttara Kannada District"
                    },
                    {
                        "Code": "140143",
                        "Name": "Uttarkashi,   Uttarakhand"
                    },
                    {
                        "Code": "141587",
                        "Name": "Vadodara,   Gujarat"
                    },
                    {
                        "Code": "148406",
                        "Name": "Vagamon,   Kerala"
                    },
                    {
                        "Code": "148407",
                        "Name": "Vagator,   Goa"
                    },
                    {
                        "Code": "107944",
                        "Name": "Vaikom,   Kerala"
                    },
                    {
                        "Code": "107210",
                        "Name": "Vajrahalli,   Karnataka"
                    },
                    {
                        "Code": "140593",
                        "Name": "Vallikunnam,   Kerala"
                    },
                    {
                        "Code": "160640",
                        "Name": "Valparai,   Tamil Nadu"
                    },
                    {
                        "Code": "238713",
                        "Name": "Valsad,   Gujarat"
                    },
                    {
                        "Code": "141615",
                        "Name": "Vandanmedu,   Kerala"
                    },
                    {
                        "Code": "141147",
                        "Name": "Vapi,   Gujarat"
                    },
                    {
                        "Code": "141618",
                        "Name": "Varanasi,   Uttar Pradesh"
                    },
                    {
                        "Code": "200830",
                        "Name": "Varca,   Goa"
                    },
                    {
                        "Code": "141450",
                        "Name": "Varca Beach,   Goa"
                    },
                    {
                        "Code": "141976",
                        "Name": "Varkala,   Kerala"
                    },
                    {
                        "Code": "141980",
                        "Name": "Vasai,   Maharashtra "
                    },
                    {
                        "Code": "107855",
                        "Name": "Vasco da Gama,   Goa"
                    },
                    {
                        "Code": "148446",
                        "Name": "Vayalar,   Kerala"
                    },
                    {
                        "Code": "257036",
                        "Name": "Vayittiri"
                    },
                    {
                        "Code": "141630",
                        "Name": "Vazhoor,   Kerala"
                    },
                    {
                        "Code": "148450",
                        "Name": "Velankanni,   Tamil Nadu"
                    },
                    {
                        "Code": "148459",
                        "Name": "Vellore,   Tamil Nadu"
                    },
                    {
                        "Code": "142295",
                        "Name": "Velsao Beach,   Goa"
                    },
                    {
                        "Code": "142563",
                        "Name": "Veraval,   Gujarat"
                    },
                    {
                        "Code": "107957",
                        "Name": "Verem,   Goa"
                    },
                    {
                        "Code": "111949",
                        "Name": "Vijayapura/Bijapur,   Karnataka"
                    },
                    {
                        "Code": "148500",
                        "Name": "Vijayawada,   Andhra Pradesh"
                    },
                    {
                        "Code": "417561",
                        "Name": "Vikasnagar,   Uttarakhand"
                    },
                    {
                        "Code": "333311",
                        "Name": "Viluppuram,   Tamil Nadu"
                    },
                    {
                        "Code": "409965",
                        "Name": "Virudhunagar,   Tamil Nadu"
                    },
                    {
                        "Code": "142198",
                        "Name": "Vizag/Visakhapatnam,   Andhra Pradesh"
                    },
                    {
                        "Code": "141371",
                        "Name": "Vizhinjam,   Kerala"
                    },
                    {
                        "Code": "107391",
                        "Name": "Vizianagaram,   Andhra Pradesh"
                    },
                    {
                        "Code": "141391",
                        "Name": "Vrindavan,   Uttar Pradesh"
                    },
                    {
                        "Code": "151612",
                        "Name": "Vythiri,   Kerala"
                    },
                    {
                        "Code": "107703",
                        "Name": "Wakad,   Maharashtra"
                    },
                    {
                        "Code": "107887",
                        "Name": "Wandoor"
                    },
                    {
                        "Code": "141960",
                        "Name": "Wankaner,   Gujrat"
                    },
                    {
                        "Code": "151614",
                        "Name": "Warangal,   Telangana"
                    },
                    {
                        "Code": "148630",
                        "Name": "Wayanad,   Kerala"
                    },
                    {
                        "Code": "153886",
                        "Name": "West Godavari District"
                    },
                    {
                        "Code": "143481",
                        "Name": "Wuste Thar,   Rajasthan"
                    },
                    {
                        "Code": "143798",
                        "Name": "Yavatmal,   Maharashtra"
                    },
                    {
                        "Code": "148767",
                        "Name": "Yelagiri,   Tamil Nadu"
                    },
                    {
                        "Code": "348599",
                        "Name": "Yelahanka,   Karnataka"
                    },
                    {
                        "Code": "143329",
                        "Name": "Yercaud,   Tamil Nadu"
                    },
                    {
                        "Code": "150396",
                        "Name": "Yuksom,   Sikkim"
                    },
                    {
                        "Code": "150387",
                        "Name": "ZARIBAGO,   Jammu and Kashmir"
                    },
                    {
                        "Code": "150248",
                        "Name": "Zirakpur,   Punjab"
                    }
                ]
            }
        }';
    }

    static function hotelNameresponse(){
        return '{
            "code": "0x0200",
            "message": "success",
            "status": "SUCCESS",
            "data": {
                "Hotels": [
                    {
                        "HotelCode": "1014840",
                        "HotelName": "Lakshmi Hotel & Resorts",
                        "Latitude": "9.620092",
                        "Longitude": "76.430469",
                        "HotelRating": "ThreeStar",
                        "Address": "Kumarakom North Kottayam Kottayam",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1016339",
                        "HotelName": "Coconut Lagoon",
                        "Latitude": "9.633116",
                        "Longitude": "76.418683",
                        "HotelRating": "FourStar",
                        "Address": "Kumarakom 686563,Kottayam District,Kerala Kavanattinkara Kumarakom",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1060310",
                        "HotelName": "Coconut Creek Kerala Homestay at Kumarakom",
                        "Latitude": "9.582016",
                        "Longitude": "76.423894",
                        "HotelRating": "ThreeStar",
                        "Address": "New Nazareth Church Road kumarakom p.o, kottayam, kerala Near Nazareth ChurchPonnattusserilKumarakom 686563",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1078231",
                        "HotelName": "Backwater Retreat Houseboat",
                        "Latitude": "9.628721",
                        "Longitude": "76.42916",
                        "HotelRating": "ThreeStar",
                        "Address": "Kottayam Kumarakom 686004",
                        "CountryName": "India",
                        "CountryCode": "in",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1085952",
                        "HotelName": "OYO 26874 Manor Backwater Resort",
                        "Latitude": "9.637585",
                        "Longitude": "76.432122",
                        "HotelRating": "ThreeStar",
                        "Address": "0 Kareemadom Rd, Cheepunkal, P.O. KumarakomKottayam DistrictKerala",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1085954",
                        "HotelName": "Tharavadu Heritage Home",
                        "Latitude": "9.592271",
                        "Longitude": "76.437185",
                        "HotelRating": "ThreeStar",
                        "Address": "Govt. Boat Jetty, Kumarakom Kottayam Kottayam",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1085956",
                        "HotelName": "Paradise Resorts",
                        "Latitude": "9.594502",
                        "Longitude": "76.430789",
                        "HotelRating": "TwoStar",
                        "Address": "Kumarakom South, Kottayam KottayamKerala 686563",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1085977",
                        "HotelName": "ILLIKKALAM LAKESIDE COTTAGES",
                        "Latitude": "9.583419",
                        "Longitude": "76.433542",
                        "HotelRating": "ThreeStar",
                        "Address": "New Nazrath Road Kumarakom South, Kottayam District Kumarakom South, Kottayam District",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1085984",
                        "HotelName": "Lake Palace Family Resort",
                        "Latitude": "9.596225",
                        "Longitude": "76.4306",
                        "HotelRating": "FourStar",
                        "Address": "Kumarakom P.O Kottayam",
                        "CountryName": "India",
                        "CountryCode": "in",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1085985",
                        "HotelName": "Puthookkadans Orchid Residency",
                        "Latitude": "9.589134",
                        "Longitude": "76.52122",
                        "HotelRating": "ThreeStar",
                        "Address": "Pulimoodu Junction Kottayam",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1089520",
                        "HotelName": "Taj Kumarakom Resort & Spa, Kerala",
                        "Latitude": "9.62703",
                        "Longitude": "76.429233",
                        "HotelRating": "FiveStar",
                        "Address": "1/404 Kumarakom,Kottayam 686563,Kerala Kottayam 686563Kerala",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kottayam"
                    },
                    {
                        "HotelCode": "1089542",
                        "HotelName": "Abad Whispering Palms",
                        "Latitude": "9.576454",
                        "Longitude": "76.423396",
                        "HotelRating": "ThreeStar",
                        "Address": "New Nazarath Road,Kumarakom 686563,Kerala Kumarakom 686563Kerala",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1127181",
                        "HotelName": "Club Mahindra Kumarakom",
                        "Latitude": "9.619875",
                        "Longitude": "76.43889",
                        "HotelRating": "ThreeStar",
                        "Address": "Near Chakarampady Bus Stand Kumarakom North 686563KottayamKerala",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1127187",
                        "HotelName": "Green Fields",
                        "Latitude": "9.644717",
                        "Longitude": "76.430441",
                        "HotelRating": "ThreeStar",
                        "Address": "SH 42, Kaipuzhamuttu, Kottayam KaipuzhamuttuKumarakom 686563Kottayam",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1127189",
                        "HotelName": "Green Garden Holiday Homes",
                        "Latitude": "9.635505",
                        "Longitude": "76.431366",
                        "HotelRating": "FourStar",
                        "Address": "Cheepunkal Post Office Kumarakom 686563",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1127197",
                        "HotelName": "Kodianthara Heritage Farm House",
                        "Latitude": "9.593913",
                        "Longitude": "76.43579",
                        "HotelRating": "TwoStar",
                        "Address": "Appithara Road Kumarakom Junction",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1127203",
                        "HotelName": "Royal Riviera Hotel And Resort",
                        "Latitude": "9.638642",
                        "Longitude": "76.42742",
                        "HotelRating": "FourStar",
                        "Address": "Near Post Office Cheepunkal",
                        "CountryName": "India",
                        "CountryCode": "in",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1127204",
                        "HotelName": "Saro Lake County",
                        "Latitude": "9.619611",
                        "Longitude": "76.426528",
                        "HotelRating": "ThreeStar",
                        "Address": "1/392 A&B Bankpady Kottayam Kottayam",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1127207",
                        "HotelName": "Vembanad Lake Villas",
                        "Latitude": "9.76857",
                        "Longitude": "76.37825",
                        "HotelRating": "FiveStar",
                        "Address": "Palackal, Panambukadu,Vaikom (20 Km from North Kumarakom) PanambukaduVaikomKumarakom 686141",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1197543",
                        "HotelName": "The Pride Emarald Alappuzha",
                        "Latitude": "9.589",
                        "Longitude": "76.4382",
                        "HotelRating": "FourStar",
                        "Address": "Kovilakom Kodamthuruthe Kuthiathode Cherthala KuthiyathodeCherthalaAlappuzha 688533",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Alleppey"
                    },
                    {
                        "HotelCode": "1207658",
                        "HotelName": "Kumarakom Lake Resort",
                        "Latitude": "9.612288",
                        "Longitude": "76.433322",
                        "HotelRating": "FiveStar",
                        "Address": "Kumarakom North P.O, Pallichira,,Kottayam 686566 Kottayam 686566",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1226334",
                        "HotelName": "Backwater Ripples",
                        "Latitude": "9.5882",
                        "Longitude": "76.4252",
                        "HotelRating": "FourStar",
                        "Address": "Nazerath Church Road Kumarakom",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1257059",
                        "HotelName": "The Zuri Kumarakom Kerala Resort & Spa",
                        "Latitude": "9.592146",
                        "Longitude": "76.425205",
                        "HotelRating": "FiveStar",
                        "Address": "V 235 A1 to A54,Karottukayal,Kumarakom,Kottayam,Kerala 686563 KumarakomKottayam 686563Kerala",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1285692",
                        "HotelName": "Golden Waters",
                        "Latitude": "9.619435",
                        "Longitude": "76.43882",
                        "HotelRating": "FourStar",
                        "Address": "Kumarakom Tourist Complex Kumarakom North",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1285693",
                        "HotelName": "KTDC Water Scapes Kunarakom",
                        "Latitude": "9.627555",
                        "Longitude": "76.42938",
                        "HotelRating": "FourStar",
                        "Address": "Kumarakom North,Kottayam 686563,Kerala Kottayam 686563Kerala",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1285707",
                        "HotelName": "Coco Bay Resort",
                        "Latitude": "9.618555",
                        "Longitude": "76.427474",
                        "HotelRating": "ThreeStar",
                        "Address": "Kumarakom North Kottayam Kottayam",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1317210",
                        "HotelName": "Lakesong Kumarakom",
                        "Latitude": "9.59465",
                        "Longitude": "76.42597",
                        "HotelRating": "FourStar",
                        "Address": "V/141 S - V/141 Q, Lake Song Resort Ammankari Road, Kumarakom",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1317346",
                        "HotelName": "Lemon Tree Vembanad Lake Resort Kerala",
                        "Latitude": "9.618756",
                        "Longitude": "76.371749",
                        "HotelRating": "FourStar",
                        "Address": "Jana Sakthi Road,Kayippuram,Muhamma,Alleppey,Kerala 688525 West of Kumarakom Muhamma, AlleppeyKayippuramKumarakom 688525",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Alleppey"
                    },
                    {
                        "HotelCode": "1375453",
                        "HotelName": "Ashirwad Heritage Resort",
                        "Latitude": "9.614399",
                        "Longitude": "76.432981",
                        "HotelRating": "ThreeStar",
                        "Address": "Chakrampady, Kottayam ChakrampadyKumarakom 686563Kerala",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1401621",
                        "HotelName": "Shivaganga Houseboat",
                        "Latitude": "9.64279",
                        "Longitude": "76.41957",
                        "HotelRating": "OneStar",
                        "Address": "Shivaganga Holidayscheeppunkal P.O Post Office CheeppunkalKumarakom 686563Kottayam",
                        "CountryName": "India",
                        "CountryCode": "in",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1416532",
                        "HotelName": "Dubai Hotel Kumarakom",
                        "Latitude": "9.592151",
                        "Longitude": "76.441086",
                        "HotelRating": "ThreeStar",
                        "Address": "Opposite Attamangalam Church Kottyam Kumarakom Rd Kottayam, Kerala686563 Kottayam",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1450001",
                        "HotelName": "Park Regis Aveda Kumarakom",
                        "Latitude": "9.58928",
                        "Longitude": "76.425557",
                        "HotelRating": "FiveStar",
                        "Address": "V 240 A Amankari Road Village Kottayam District Kerala KottayamKumarakom 686563Kerala",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1482495",
                        "HotelName": "Royal Life Houseboat",
                        "Latitude": "9.6233",
                        "Longitude": "76.42629",
                        "HotelRating": "ThreeStar",
                        "Address": "Boarding either from Kaippuram Jetty or at Kumarakom near Hotel Taj Vivanta 686563",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1495238",
                        "HotelName": "Leisure Vacations Goldfield Lake Resort",
                        "Latitude": "9.58385",
                        "Longitude": "76.422754",
                        "HotelRating": "ThreeStar",
                        "Address": "Near Nazareth Church, Block 12 Block 12Kumarakom 686563",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1506597",
                        "HotelName": "Backwater Breeze Hotel",
                        "Latitude": "9.64158",
                        "Longitude": "76.4196",
                        "HotelRating": "OneStar",
                        "Address": "Near St.Antonys Church Cheepumakal P.O.Kottayam. KumarakomCheepumakal Post OfficeKottayam 686563",
                        "CountryName": "India",
                        "CountryCode": "in",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1514285",
                        "HotelName": "Aswini Residency",
                        "Latitude": "9.6934957504",
                        "Longitude": "76.344367981",
                        "HotelRating": "ThreeStar",
                        "Address": "T.B Road Kodathikavala Cherthala KodathikavalaCherthalaKerala 688524",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1514679",
                        "HotelName": "Aqualillies Water Front Heritage Homestay",
                        "Latitude": "9.62081",
                        "Longitude": "76.4448",
                        "HotelRating": "All",
                        "Address": "Oruvettithara Police Staion Roadnear Attippedika Bus Standkumarakom P.O. Kottayam Kerala AttippedikaKumarakom Post OfficeKottayam 686563",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1532128",
                        "HotelName": "Vismaya - A Heritage Villa",
                        "Latitude": "9.70332",
                        "Longitude": "76.36318",
                        "HotelRating": "All",
                        "Address": "Near Chenganda bridge Cherthala, Kerala 688541 ",
                        "CountryName": "India",
                        "CountryCode": "in",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1537984",
                        "HotelName": "Royal Grove",
                        "Latitude": "9.58669",
                        "Longitude": "76.42478",
                        "HotelRating": "All",
                        "Address": "Near Nazreth Chruch KumarakomKerala",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1545670",
                        "HotelName": "Cassia Mansion",
                        "Latitude": "9.6522960663",
                        "Longitude": "76.299766541",
                        "HotelRating": "TwoStar",
                        "Address": "Kamyakam Arthunkal Mararikulam Road ArthunkalAlappuzha 688530Kerala",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1569608",
                        "HotelName": "Travancore Palace",
                        "Latitude": "9.65806",
                        "Longitude": "76.33735",
                        "HotelRating": "ThreeStar",
                        "Address": "NH 47 11th Mile Cherthala Post OfficeCherthala 688524Kerala",
                        "CountryName": "India",
                        "CountryCode": "in",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1623244",
                        "HotelName": "Kananavasan Holidays",
                        "Latitude": "9.62618348656224",
                        "Longitude": "76.4243477582932",
                        "HotelRating": "All",
                        "Address": "Kavanattinkara Kumarakom 686563Kottayam DistrictKerala",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1690546",
                        "HotelName": "Vinnca Lake House",
                        "Latitude": "9.60798",
                        "Longitude": "76.43061",
                        "HotelRating": "ThreeStar",
                        "Address": "Pallichira P.O. Kumarakam Kottayam PO KumarakamKottayam 686563Kerala",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1738310",
                        "HotelName": "Aquarius Hotel",
                        "Latitude": "9.74974",
                        "Longitude": "76.39245",
                        "HotelRating": "ThreeStar",
                        "Address": "Kacherikavala Vaikom 686141Kottayam DistrictKerala",
                        "CountryName": "India",
                        "CountryCode": "in",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1739933",
                        "HotelName": "Kumarakom Heritage Kumarakom",
                        "Latitude": "9.63701",
                        "Longitude": "76.4253",
                        "HotelRating": "ThreeStar",
                        "Address": "Kumarakom Cumbam Road AchinakamVechoorKumarakom 686144",
                        "CountryName": "India",
                        "CountryCode": "in",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1771176",
                        "HotelName": "Niraamaya Retreats Backwaters & Beyond",
                        "Latitude": "9.610203",
                        "Longitude": "76.431916",
                        "HotelRating": "FiveStar",
                        "Address": "Pallichira Vayitharamattom Kumarakom 686563",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1796329",
                        "HotelName": "GKs Riverview Homestay",
                        "Latitude": "9.63306",
                        "Longitude": "76.48026",
                        "HotelRating": "ThreeStar",
                        "Address": "Thekkekaryil PulikkuttisseryKottayamKerala",
                        "CountryName": "India",
                        "CountryCode": "in",
                        "CityName": "Kottayam"
                    },
                    {
                        "HotelCode": "1889564",
                        "HotelName": "Heaven On Earth Water Front",
                        "Latitude": "9.68136",
                        "Longitude": "76.41218",
                        "HotelRating": "All",
                        "Address": "Lake Vechoor Villas Kumarakom 686144",
                        "CountryName": "India",
                        "CountryCode": "in",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1889772",
                        "HotelName": "Kumarakom Wood Castle Serviced Appartments",
                        "Latitude": "9.63132",
                        "Longitude": "76.42976",
                        "HotelRating": "All",
                        "Address": "Kumarakom Cumbam Road Cheepunkal Post OfficeKumarakom 686563",
                        "CountryName": "India",
                        "CountryCode": "in",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1891175",
                        "HotelName": "Pearlspot Resorts and Spa",
                        "Latitude": "9.6301",
                        "Longitude": "76.42979",
                        "HotelRating": "All",
                        "Address": "Tharavadu Toddy Shop KavanatinkaraKumarakom 686563",
                        "CountryName": "India",
                        "CountryCode": "in",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "1891192",
                        "HotelName": "Hashes hotels",
                        "Latitude": "9.61771",
                        "Longitude": "76.42955",
                        "HotelRating": "All",
                        "Address": "Near Bird Sanctuary ChakrampadiKavanattinkaraKumarakom 686563",
                        "CountryName": "India",
                        "CountryCode": "in",
                        "CityName": "Kumarakom"
                    },
                    {
                        "HotelCode": "5201319",
                        "HotelName": "OYO 23047 Rkv Golden Petal Houseboat 3 Bhk",
                        "Latitude": "9.466461",
                        "Longitude": "76.361348",
                        "HotelRating": "ThreeStar",
                        "Address": "Rkv Golden Petal Houseboat 3 Bhk Pallathuruthy ",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Alleppey"
                    },
                    {
                        "HotelCode": "5202290",
                        "HotelName": "OYO 23103 Ganga 5bhk Deluxe Houseboat",
                        "Latitude": "9.643425",
                        "Longitude": "76.419302",
                        "HotelRating": "TwoStar",
                        "Address": "Ganga 5 Bhk Deluxe Sharing Houseboat Cheeppunkal Kavanattinkara Kumarakom Cheeppunkal, Kavanattinkara, Kumarakom ",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Alleppey"
                    },
                    {
                        "HotelCode": "5242244",
                        "HotelName": "GuestHouser 1 BR Houseboat ee6e",
                        "Latitude": "9.501417",
                        "Longitude": "76.350984",
                        "HotelRating": "ThreeStar",
                        "Address": "Cosy Tours Cosy Regency F.P. ",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Alleppey"
                    },
                    {
                        "HotelCode": "5345155",
                        "HotelName": "UDS Backwater Resort",
                        "Latitude": "9.527561",
                        "Longitude": "76.354817",
                        "HotelRating": "FourStar",
                        "Address": "Miyyath Punnamada Road ",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Alleppey"
                    },
                    {
                        "HotelCode": "5453624",
                        "HotelName": "OYO 16841 Sree Vinayaka",
                        "Latitude": "9.489435",
                        "Longitude": "76.36525",
                        "HotelRating": "ThreeStar",
                        "Address": "Sree Vinayaka Houseboat Chungam Out Post Near Chungam Police Station Nr chungam police station ",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Alleppey"
                    },
                    {
                        "HotelCode": "5544452",
                        "HotelName": "OYO 1079 Ashirwad Heritage Resort",
                        "Latitude": "9.61435",
                        "Longitude": "76.4333",
                        "HotelRating": "ThreeStar",
                        "Address": "Sh42 Chakrampady ",
                        "CountryName": "India",
                        "CountryCode": "IN",
                        "CityName": "Kumarakom"
                    }
                ]
            }
        }';
    }

    static function hotelsearchresponse()
    {
        return '{
            "code": "0x0200",
            "message": "success",
            "status": "SUCCESS",
            "data": {
                "HotelResults": [
                    {
                        "HotelCode": "1279415",
                        "Currency": "INR",
                        "Rooms": [
                            {
                                "Name": [
                                    "Ocean King Room,1 King Bed,NonSmoking"
                                ],
                                "BookingCode": "1279415!TB!1!TB!da280bcc-327b-11f1-bdca-ba9013e35c3f!TB!N!TB!AFF!",
                                "Inclusion": "Free water park passes,Free valet parking,Free self parking",
                                "DayRates": [
                                    [
                                        {
                                            "BasePrice": 25277.25
                                        }
                                    ]
                                ],
                                "TotalFare": 31248.13000000000101863406598567962646484375,
                                "TotalTax": 5970.8900000000003274180926382541656494140625,
                                "CancelPolicies": [
                                    {
                                        "FromDate": "06-04-2026 00:00:00",
                                        "ChargeType": "Fixed",
                                        "CancellationCharge": 0
                                    },
                                    {
                                        "FromDate": "07-04-2026 00:00:00",
                                        "ChargeType": "Percentage",
                                        "CancellationCharge": 100
                                    }
                                ],
                                "MealType": "Room_Only",
                                "IsRefundable": false,
                                "Supplements": [
                                    [
                                        {
                                            "Index": 1,
                                            "Type": "AtProperty",
                                            "Description": "mandatory_tax",
                                            "Price": 20,
                                            "Currency": "AED"
                                        }
                                    ]
                                ],
                                "WithTransfers": false
                            },
                            {
                                "Name": [
                                    "Palm King Room,1 King Bed,NonSmoking"
                                ],
                                "BookingCode": "1279415!TB!2!TB!da280bcc-327b-11f1-bdca-ba9013e35c3f!TB!N!TB!AFF!",
                                "Inclusion": "Free water park passes,Free valet parking,Free self parking",
                                "DayRates": [
                                    [
                                        {
                                            "BasePrice": 27036.02999999999883584678173065185546875
                                        }
                                    ]
                                ],
                                "TotalFare": 33421.449999999997089616954326629638671875,
                                "TotalTax": 6385.420000000000072759576141834259033203125,
                                "CancelPolicies": [
                                    {
                                        "FromDate": "06-04-2026 00:00:00",
                                        "ChargeType": "Fixed",
                                        "CancellationCharge": 0
                                    },
                                    {
                                        "FromDate": "07-04-2026 00:00:00",
                                        "ChargeType": "Percentage",
                                        "CancellationCharge": 100
                                    }
                                ],
                                "MealType": "Room_Only",
                                "IsRefundable": false,
                                "Supplements": [
                                    [
                                        {
                                            "Index": 1,
                                            "Type": "AtProperty",
                                            "Description": "mandatory_tax",
                                            "Price": 20,
                                            "Currency": "AED"
                                        }
                                    ]
                                ],
                                "WithTransfers": false
                            },
                            {
                                "Name": [
                                    "Ocean Queen Room,2 Queen Beds,NonSmoking"
                                ],
                                "BookingCode": "1279415!TB!3!TB!da280bcc-327b-11f1-bdca-ba9013e35c3f!TB!N!TB!AFF!",
                                "Inclusion": "Free water park passes,Free valet parking,Free self parking",
                                "DayRates": [
                                    [
                                        {
                                            "BasePrice": 27475.49000000000160071067512035369873046875
                                        }
                                    ]
                                ],
                                "TotalFare": 33965.1500000000014551915228366851806640625,
                                "TotalTax": 6489.670000000000072759576141834259033203125,
                                "CancelPolicies": [
                                    {
                                        "FromDate": "06-04-2026 00:00:00",
                                        "ChargeType": "Fixed",
                                        "CancellationCharge": 0
                                    },
                                    {
                                        "FromDate": "07-04-2026 00:00:00",
                                        "ChargeType": "Percentage",
                                        "CancellationCharge": 100
                                    }
                                ],
                                "MealType": "Room_Only",
                                "IsRefundable": false,
                                "Supplements": [
                                    [
                                        {
                                            "Index": 1,
                                            "Type": "AtProperty",
                                            "Description": "mandatory_tax",
                                            "Price": 20,
                                            "Currency": "AED"
                                        }
                                    ]
                                ],
                                "WithTransfers": false
                            },
                            {
                                "Name": [
                                    "Ocean King Room,1 King Bed,NonSmoking"
                                ],
                                "BookingCode": "1279415!TB!4!TB!da280bcc-327b-11f1-bdca-ba9013e35c3f!TB!N!TB!AFF!",
                                "Inclusion": "Free water park passes,Free breakfast,Free valet parking,Free self parking",
                                "DayRates": [
                                    [
                                        {
                                            "BasePrice": 28852.75
                                        }
                                    ]
                                ],
                                "TotalFare": 35668.72000000000116415321826934814453125,
                                "TotalTax": 6815.97999999999956344254314899444580078125,
                                "CancelPolicies": [
                                    {
                                        "FromDate": "06-04-2026 00:00:00",
                                        "ChargeType": "Fixed",
                                        "CancellationCharge": 0
                                    },
                                    {
                                        "FromDate": "07-04-2026 00:00:00",
                                        "ChargeType": "Percentage",
                                        "CancellationCharge": 100
                                    }
                                ],
                                "MealType": "BreakFast",
                                "IsRefundable": false,
                                "Supplements": [
                                    [
                                        {
                                            "Index": 1,
                                            "Type": "AtProperty",
                                            "Description": "mandatory_tax",
                                            "Price": 20,
                                            "Currency": "AED"
                                        }
                                    ]
                                ],
                                "WithTransfers": false
                            },
                            {
                                "Name": [
                                    "Palm King Room,1 King Bed,NonSmoking"
                                ],
                                "BookingCode": "1279415!TB!5!TB!da280bcc-327b-11f1-bdca-ba9013e35c3f!TB!N!TB!AFF!",
                                "Inclusion": "Free water park passes,Free breakfast,Free valet parking,Free self parking",
                                "DayRates": [
                                    [
                                        {
                                            "BasePrice": 30611.5
                                        }
                                    ]
                                ],
                                "TotalFare": 37841.919999999998253770172595977783203125,
                                "TotalTax": 7230.4300000000002910383045673370361328125,
                                "CancelPolicies": [
                                    {
                                        "FromDate": "06-04-2026 00:00:00",
                                        "ChargeType": "Fixed",
                                        "CancellationCharge": 0
                                    },
                                    {
                                        "FromDate": "07-04-2026 00:00:00",
                                        "ChargeType": "Percentage",
                                        "CancellationCharge": 100
                                    }
                                ],
                                "MealType": "BreakFast",
                                "IsRefundable": false,
                                "Supplements": [
                                    [
                                        {
                                            "Index": 1,
                                            "Type": "AtProperty",
                                            "Description": "mandatory_tax",
                                            "Price": 20,
                                            "Currency": "AED"
                                        }
                                    ]
                                ],
                                "WithTransfers": false
                            }
                        ]
                    }
                ]
            }
        }';
    }

    static function hoteldetailsresponse()
    {
        return '{
            "code": "0x0200",
            "message": "success",
            "status": "SUCCESS",
            "data": {
                "HotelDetails": [
                    {
                        "HotelCode": "6272321",
                        "HotelName": "Hotel Blossom Inn",
                        "Description": "<p>HeadLine : In Lucknow (Gomti Nagar)</p><p>Location : With a stay at Hotel Blossom Inn in Lucknow (Gomti Nagar), you ll be within a 10-minute drive of Ambedkar Memorial Park and Wave Mall Lucknow.  This hotel is 2.9 mi (4.6 km) from Chakra Tirth Temple and 3 mi (4.9 km) from Indira Gandhi Pratishthan.</p><p>Rooms : Make yourself at home in one of the 70 guestrooms. Complimentary wireless internet access is available to keep you connected.</p><p>CheckIn Instructions : <ul>  <li>Extra-person charges may apply and vary depending on property policy</li><li>Government-issued photo identification and a credit card, debit card, or cash deposit may be required at check-in for incidental charges</li><li>Special requests are subject to availability upon check-in and may incur additional charges; special requests cannot be guaranteed</li><li>This property accepts credit cards, debit cards, and cash</li>  </ul></p><p>Special Instructions : Information provided by the property may be translated using automated translation tools.</p><br/><b>Disclaimer notification: Amenities are subject to availability and may be chargeable as per the hotel policy.</b>",
                        "HotelFacilities": [
                            "No accessible shuttle",
                            "secured parking",
                            "Wheelchair accessible – no",
                            "Free self parking"
                        ],
                        "Attractions": {
                            "1) ": "Sahara Hospital",
                            "2) ": "Shah Najaf Imambara",
                            "3) ": "Ambedkar Memorial Park",
                            "4) ": "Botanical Gardens",
                            "5) ": "Moti Mahal",
                            "6) ": "Sikandar Bagh",
                            "7) ": "State Museum Lucknow",
                            "8) ": "Chakra Tirth Temple",
                            "9) ": "One Awadh Center",
                            "10) ": "Colvin Taluqdars  College",
                            "11) ": "Constantia House",
                            "12) ": "Wave Mall Lucknow",
                            "13) ": "Indira Gandhi Pratishthan",
                            "14) ": "La Martiniere",
                            "15) ": "Lucknow (LKO-Amausi Intl.)",
                            "16) ": "Lucknow Zoo"
                        },
                        "Images": [
                            "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJpsgfeRxKXs2xos3ymiSK0g==",
                            "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJc6SaGthFNlIljavplFPzSw==",
                            "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJ3ONC/KAH4ykxTF7NMMBkow==",
                            "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJYWsrfKmEVwi/t72c6jX9YQ==",
                            "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJ702YLw/lB3cp1TOua+htMQ==",
                            "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJM9N/abwdvQ9Fn3ouAgcjRQ==",
                            "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJo7q7laG18zcnhnYFy1F0dQ==",
                            "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJimqT2rWcYHoYpfjGbHaZNg==",
                            "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJS9PBM+UhHoTToyb/ersOdg==",
                            "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJlFNBtiMC+w90pznkzH5rCA==",
                            "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJK2sj369ljp0oHUxMT/Us3w==",
                            "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJhfC5Fab5hsY73X5GMzUi/Q==",
                            "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJAfgzugsZafV9xEESIucO+Q==",
                            "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJGdSGhD1e0npRS/5gQH8bNg==",
                            "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJ8Hh7pZec4/hcoBRkvUTrgg==",
                            "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJ7jy4ZSjmiKScJQ/WvzspZw==",
                            "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJvTLnSJIgmcn/2XF+UxPyig==",
                            "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJkbkfBhsLOtVIJG55gT/U6g==",
                            "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJE8RZ4uj03hJ8FRgpgGTgsQ==",
                            "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJNaMo0wZnZld1Qg8qWd7Vig==",
                            "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJayPVrRvlVsLhSixoRSSy1w==",
                            "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJo+GLOxbK8WAIZml/m2PNTA==",
                            "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJ+vFST6Qxlr58hNSjlAJ4oQ=="
                        ],
                        "Address": "619 Sector 12 Rd  Sector 12 Indira Nagar, ",
                        "PinCode": "226028",
                        "CityId": "126666",
                        "CountryName": "India",
                        "PhoneNumber": "91-9044354101",
                        "Email": "",
                        "HotelWebsiteUrl": "https://www.agoda.com/partners/partnersearch.aspx?hid=52012539",
                        "FaxNumber": "",
                        "Map": "26.864815|80.9723",
                        "HotelRating": 2,
                        "CityName": "Lucknow",
                        "CountryCode": "IN",
                        "CheckInTime": "10:00 AM",
                        "CheckOutTime": "11:30 AM",
                        "HotelFees": {
                            "HotelId": "6272321",
                            "Optional": [],
                            "Mandatory": []
                        },
                        "RoomDetails": [
                            {
                                "RoomName": "Deluxe Room with Double Bed - No Smoking",
                                "imageURL": [
                                    "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJK2sj369ljp0oHUxMT/Us3w==",
                                    "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJpsgfeRxKXs2xos3ymiSK0g==",
                                    "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJ+vFST6Qxlr58hNSjlAJ4oQ==",
                                    "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJo7q7laG18zcnhnYFy1F0dQ==",
                                    "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJkbkfBhsLOtVIJG55gT/U6g==",
                                    "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJS9PBM+UhHoTToyb/ersOdg==",
                                    "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJimqT2rWcYHoYpfjGbHaZNg==",
                                    "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJ7jy4ZSjmiKScJQ/WvzspZw==",
                                    "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJM9N/abwdvQ9Fn3ouAgcjRQ==",
                                    "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJvTLnSJIgmcn/2XF+UxPyig==",
                                    "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJ8Hh7pZec4/hcoBRkvUTrgg==",
                                    "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJo+GLOxbK8WAIZml/m2PNTA=="
                                ],
                                "RoomId": 17502995,
                                "RoomSize": "0 ft",
                                "RoomDescription": "1 Double Bed Internet - Free WiFi 500 Mbps good for 6 people or 10 devices Comfort - Daily housekeeping, fresh towels every 2 days, fresh bed sheets every 2 days Need to Know - No cribs infant beds or rollaway/extra beds available Non-Smoking"
                            },
                            {
                                "RoomName": "Executive Room with Double Bed - No Smoking",
                                "imageURL": [
                                    "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJNaMo0wZnZld1Qg8qWd7Vig==",
                                    "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJGdSGhD1e0npRS/5gQH8bNg==",
                                    "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJayPVrRvlVsLhSixoRSSy1w==",
                                    "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJAfgzugsZafV9xEESIucO+Q==",
                                    "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJ702YLw/lB3cp1TOua+htMQ==",
                                    "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJlFNBtiMC+w90pznkzH5rCA==",
                                    "https://api.tbotechnology.in//imageresource.aspx?img=FbrGPTrju5e5v0qrAGTD8pPBsj8/wYA5F3wAmN3NGLVzbNHvMIe1rs0a7ZnJlLfNQ2MeBi9XuBSQcdoH0HiGeLDDSXQ1/NWJYWsrfKmEVwi/t72c6jX9YQ=="
                                ],
                                "RoomId": 17503019,
                                "RoomSize": "0 ft",
                                "RoomDescription": "1 Double Bed Layout - Bedroom and living room Internet - Free WiFi 500 Mbps good for 6 people or 10 devices Comfort - Daily housekeeping, fresh towels every 2 days, fresh bed sheets every 2 days Need to Know - No cribs infant beds or rollaway/extra beds available Non-Smoking"
                            }
                        ]
                    }
                ]
            }
        }';
    }

    static function hotelprebookingresponse()
    {
        return '{
            "code": "0x0200",
            "message": "success",
            "status": "SUCCESS",
            "data": {
                "HotelResult": [
                    {
                        "HotelCode": "1279415",
                        "Currency": "INR",
                        "Rooms": [
                            {
                                "Name": [
                                    "Palm King Room,1 King Bed"
                                ],
                                "BookingCode": "1279415!TB!2!TB!da280bcc-327b-11f1-bdca-ba9013e35c3f!TB!N!TB!AFF!",
                                "Inclusion": "Free water park passes,Free valet parking,Free self parking",
                                "DayRates": [
                                    [
                                        {
                                            "BasePrice": 27036.02999999999883584678173065185546875
                                        }
                                    ]
                                ],
                                "TotalFare": 33421.449999999997089616954326629638671875,
                                "TotalTax": 6385.420000000000072759576141834259033203125,
                                "NetAmount": 33425.07294156900024972856044769287109375,
                                "NetTax": 6389.0440565190028792130760848522186279296875,
                                "CancelPolicies": [
                                    {
                                        "FromDate": "06-04-2026 00:00:00",
                                        "ChargeType": "Fixed",
                                        "CancellationCharge": 0
                                    },
                                    {
                                        "FromDate": "07-04-2026 00:00:00",
                                        "ChargeType": "Percentage",
                                        "CancellationCharge": 100
                                    }
                                ],
                                "MealType": "Room_Only",
                                "IsRefundable": false,
                                "Supplements": [
                                    [
                                        {
                                            "Index": 1,
                                            "Type": "AtProperty",
                                            "Description": "mandatory_tax",
                                            "Price": 20,
                                            "Currency": "AED"
                                        }
                                    ]
                                ],
                                "WithTransfers": false,
                                "Amenities": [
                                    "Furnished balcony or patio",
                                    "Premium bedding",
                                    "Satellite TV service",
                                    "In-room childcare (surcharge)",
                                    "In-room climate control (air conditioning)",
                                    "Blackout drapes/curtains",
                                    "Bidet",
                                    "Desk",
                                    "WiFi speed - 100+ Mbps (good for 1–2 people or up to 6 devices)",
                                    "Premium TV channels",
                                    "Soap",
                                    "Connecting/adjoining rooms available",
                                    "Toothbrush and toothpaste available",
                                    "Toilet paper",
                                    "Shampoo",
                                    "Slippers",
                                    "In-room massage available",
                                    "Rollaway/extra beds (surcharge)",
                                    "Pay movies",
                                    "Free newspaper",
                                    "Television",
                                    "High pile carpet in room",
                                    "Smoking and Non-Smoking",
                                    "Turndown service",
                                    "Iron/ironing board (on request)",
                                    "Soundproofed rooms",
                                    "Laptop-friendly workspace",
                                    "Minibar",
                                    "Wardrobe or closet",
                                    "Bathtub or shower",
                                    "Coffee/tea maker",
                                    "Daily housekeeping",
                                    "Free WiFi",
                                    "Hypo-allergenic bedding available",
                                    "Phone",
                                    "iPod docking station",
                                    "Restaurant dining guide",
                                    "Towels provided",
                                    "Bedsheets provided",
                                    "LED TV",
                                    "Wireless internet access",
                                    "TV size measurement: inch",
                                    "Private bathroom",
                                    "Bathrobes",
                                    "Free toiletries",
                                    "Hair dryer",
                                    "TV size: 60",
                                    "Rainfall showerhead",
                                    "In-room safe",
                                    "Room service (24 hours)",
                                    "Free bottled water",
                                    "Free cribs/infant beds"
                                ],
                                "LastCancellationDeadline": "06-04-2026 23:59:59",
                                "PriceBreakUp": [
                                    {
                                        "RoomRate": 27217.27681099999972502700984477996826171875,
                                        "RoomTax": 6385.4190980000030322116799652576446533203125,
                                        "AgentCommission": 181.247925949999995509642758406698703765869140625,
                                        "TaxBreakup": [
                                            {
                                                "TaxType": "Tax_TDS",
                                                "TaxableAmount": 181.247925949999995509642758406698703765869140625,
                                                "TaxPercentage": 2,
                                                "TaxAmount": 3.624958519000000212173517866176553070545196533203125
                                            }
                                        ]
                                    }
                                ]
                            }
                        ],
                        "RateConditions": [
                            "Early check out will attract full cancellation charge unless otherwise specified",
                            "CheckIn Time-Begin: 3:00 PM ",
                            " CheckIn Time-End: midnight",
                            "CheckOut Time: 12:00 PM",
                            "CheckIn Instructions: &lt;ul&gt;  &lt;li&gt;Extra-person charges may apply and vary depending on property policy&lt;/li&gt;&lt;li&gt;Government-issued photo identification and a credit card, debit card, or cash deposit may be required at check-in for incidental charges&lt;/li&gt;&lt;li&gt;Special requests are subject to availability upon check-in and may incur additional charges; special requests cannot be guaranteed&lt;/li&gt;&lt;li&gt;This property accepts credit cards; cash is not accepted&lt;/li&gt;&lt;li&gt;Cashless transactions are available&lt;/li&gt;&lt;li&gt;Safety features at this property include a fire extinguisher, a smoke detector, a security system, and a first aid kit&lt;/li&gt;&lt;li&gt;This property has outdoor spaces, such as balconies, patios, terraces which may not be suitable for children; if you have concerns, we recommend contacting the property prior to your arrival to confirm they can accommodate you in a suitable room&lt;/li&gt;&lt;li&gt;Please note that cultural norms and guest policies may differ by country and by property; the policies listed are provided by the property&lt;/li&gt;  &lt;/ul&gt; ",
                            " Special Instructions : This property offers transfers from the airport (surcharges may apply). Guests must contact the property with arrival details before travel, using the contact information on the booking confirmation. Front desk staff will greet guests on arrival at the property. For any questions, please contact the property using the information on the booking confirmation. Information provided by the property may be translated using automated translation tools. Guests should notify the property in advance of their flight details. Water park at Aquaventure  may not be open daily. Guests should contact the property directly for hours of operation. All guests must show a valid passport or Emirates ID (for UAE residents) at check-in. These are the only forms of identification accepted at this property. Guests booked in a Suite must contact this property at least 48 hours in advance to schedule airport transportation.",
                            "Minimum CheckIn Age : 21",
                            "Mandatory Fees: &lt;p&gt;Youll be asked to pay the following charges at the property. Fees may include applicable taxes:&lt;/p&gt; &lt;ul&gt;&lt;li&gt;New Years Eve (December 31) Gala Dinner per adult: AED 1350&lt;/li&gt;&lt;li&gt;New Years Eve (December 31) Gala Dinner per child: AED 625 (from 4 to 13 years old)&lt;/li&gt;&lt;li&gt;A tax is imposed by the city: AED 20.00 per accommodation, per night&lt;/li&gt;A tourism fee is imposed by the city and collected at the property. The fee is AED 20 for the first bedroom per night, and increases by AED 20 per night for each additional bedroom. &lt;/ul&gt; &lt;p&gt;We have included all charges provided to us by the property. &lt;/p&gt; ",
                            " Optional Fees: &lt;ul&gt; &lt;li&gt;Fee for buffet breakfast: approximately AED 200 per person&lt;/li&gt;&lt;li&gt;Airport shuttle fee: AED 900 per vehicle (roundtrip, maximum occupancy 4)&lt;/li&gt;&lt;li&gt;Rollaway bed fee: AED 797.0 per night&lt;/li&gt;&lt;/ul&gt; &lt;p&gt;The above list may not be comprehensive. Fees and deposits may not include tax and are subject to change. &lt;/p&gt;",
                            "Cards Accepted: Visa,Debit cards not accepted,Cash not accepted,American Express,Mastercard",
                            "&lt;ul&gt;  &lt;li&gt;Reservations are required for massage services and spa treatments. Reservations can be made by contacting the hotel prior to arrival, using the contact information on the booking confirmation. &lt;/li&gt; &lt;li&gt;One child 13 years old or younger stays free when occupying the parent or guardians room, using existing bedding. &lt;/li&gt;&lt;li&gt;Only registered guests are allowed in the guestrooms. &lt;/li&gt; &lt;li&gt;The property has connecting/adjoining rooms, which are subject to availability and can be requested by contacting the property using the number on the booking confirmation. &lt;/li&gt;&lt;li&gt;A car is not required for transportation to and from this property. &lt;/li&gt;&lt;li&gt;Cashless payment methods are available for all transactions.&lt;/li&gt;&lt;li&gt;Contactless check-in and contactless check-out are available.&lt;/li&gt; &lt;/ul&gt;,Pets not allowed,Property does not require health documentation at check-in,Professional property host/manager,Contactless check-out is available,EarthCheck,Cashless transactions are available,Contactless check-in is available,Property does not offer onsite COVID-19 testing"
                        ]
                    }
                ]
            }
        }';
    }
}
