<?php

namespace App\Services;

use Illuminate\Support\Str;

class MasterCardService
{
    public function getCardHolderInfo(array $data)
    {
        $response = $this->sendRequest($data);

        if (empty($response)) {
            return null;
        }

        return [
            'name' => $response['name'],
            'expiration_date' => $response['expiration'],
            'cvc' => $response['cvc'],
            'amount' => $response['amount'],
            'currency' => $response['currency'],
        ];
    }

    public function sendRequest(array $params)
    {
        $masterCardDummyData = config('mastercard_dummy');

        if (!empty($masterCardDummyData[$params['number']])) {
            return $masterCardDummyData[$params['number']];
        }

        return null;
    }
}
