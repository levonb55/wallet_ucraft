<?php

namespace App\Finance;

use App\Models\Card;
use App\Services\MasterCardService;
use App\Services\VisaService;

class CardServices
{
    public static function getServices()
    {
        return [
            Card::CARD_VISA => new VisaService(),
            Card::CARD_MASTERCARD => new MasterCardService()
        ];
    }
}
