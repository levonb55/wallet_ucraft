<?php

namespace App\Repositories;

use App\Contracts\Repositories\CardRepository as CardRepositoryInterface;
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
        return Auth()->user()->cards()->active()->get();
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
