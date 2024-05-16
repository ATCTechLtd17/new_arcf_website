<?php

namespace App\Enum;

enum ServiceType: string
{
    case TRAVEL_TOURISM = 'TRAVEL_TOURISM';
    case DOCUMENTS_CLEARING = 'DOCUMENTS_CLEARING';

    public function getLabel(): string
    {
        return match ($this) {
            self::TRAVEL_TOURISM => 'ARCF FOR TRAVEL AND TOURISM CO. L.L.C',
            self::DOCUMENTS_CLEARING => 'ARCF DOCUMENTS CLEARING SERVICES CO. L.L.C',
        };
    }

    public function getShortLabel(): string
    {
        return match ($this) {
            self::TRAVEL_TOURISM => 'FOR TRAVEL AND TOURISM CO. L.L.C',
            self::DOCUMENTS_CLEARING => 'DOCUMENTS CLEARING SERVICES CO. L.L.C',
        };
    }

    public function getLogoUrl(): string
    {
        return match ($this) {
            self::TRAVEL_TOURISM => asset('images/travel_logo.png'),
            self::DOCUMENTS_CLEARING => asset('images/documents_logo.png'),
        };
    }

    public function getAddress(): array
    {
        return match ($this) {
            self::TRAVEL_TOURISM => [
                'address' => "Central Building, Shop No. G-11,",
                'address2' => "(EMIRATES ISLAMI BANK ROAD, NEAR DEIRA PARK HOTEL,)",
                'address3' => "Naif, Deira, Dubai, UAE.",
                'phone' => "+971 4451 8790",
                'mobile' => "+971 585 380 301 (Sales)",
                'email' => "arcftravel@gmail.com",
            ],
            self::DOCUMENTS_CLEARING => [
                'address' => "ARCF DOCUMENTS CLEARING SERVICES CO. L.L.C,",
                'address2' => "PLOT NO- 235. FLAT NO- 101.",
                'address3' => "AL NAIF BUILDING, NAIF, DEIRA DUBAI, UAE.",
                'phone' => "+971 4451 8790",
                'mobile' => "+971 585 380 301 (Sales)",
                'email' => "dubaiarcf@gmail.com",
            ],
        };
    }

}
