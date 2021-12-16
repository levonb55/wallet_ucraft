<?php

namespace App\Repositories;

use App\Contracts\Repositories\CardRepository as CardRepositoryInterface;
use App\Finance\CardServices;
use App\Models\Card;
use Illuminate\Support\Facades\Auth;

class CardRepository implements CardRepositoryInterface
{
    public function create($data)
    {
        return Card::create([
            'user_id' => Auth::id(),
            'type' => $data['type'],
            'number' => $data['number'],
            'show_status' => Card::STATUS_ACTIVE
        ]);
    }

    public function getActiveCards()
    {
        $cards = Auth()->user()->cards()->active()->get();

        return $cards->map(function ($card, $key) {
            $cardService = CardServices::getServices()[$card->type];
            return $cardService->getCardHolderInfo($card->toArray()) + [
                    'id' => $card->id,
                    'number' => $card->number,
                    'type' => $card->type
                ];
        });
    }

    public function getCardByTypeNumber($data)
    {
        return Card::where([
            'type' => $data['type'],
            'number' => $data['number'],
        ])->first();
    }

    public function activateCard($card)
    {
        return $card->update(['show_status' => Card::STATUS_ACTIVE]);
    }

    public function deleteCard($card)
    {
        return $card->update(['show_status' => Card::STATUS_DELETED]);
    }
}
