<?php

namespace App\Services;

use Illuminate\Support\Str;

class VisaService
{
    public function getCardHolderInfo(array $data)
    {
        $response = $this->sendRequest($data);

        if(empty($response)) {
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
        $visaDummyData = config('visa_dummy');

        if(!empty($visaDummyData[$params['number']])) {
            return $visaDummyData[$params['number']];
        }

        return null;
    }
}
