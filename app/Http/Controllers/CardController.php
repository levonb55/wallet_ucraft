<?php

namespace App\Http\Controllers;

use App\Http\Requests\CardRequest;
use App\Models\Card;
use App\Services\VisaService;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
    public function index()
    {
        $cards = Auth()->user()->cards()->active()->get()->collect();

        $cards = $cards->map(function ($card, $key) {
            $visaService = new VisaService();
            return $visaService->getCardHolderInfo($card->toArray()) + [
                    'id' => $card->id,
                    'number' => $card->number,
                    'type' => Card::CARD_VISA
                ];
        });

        return view('cards.index')->with([
            'cards' => $cards,
            'totalBalance' => $cards->sum('amount')
        ]);
    }

    public function store(CardRequest $request)
    {
        $data = $request->validated();

        $card = Card::where([
            'type' => Card::CARD_VISA,
            'number' => $data['number'],
        ])->first();

        if (!empty($card)) {
            if ($card->show_status === Card::STATUS_DELETED) {
                $card->update(['show_status' => Card::STATUS_ACTIVE]);
                return redirect()->route('cards.index')->with('success', 'This card successfully added!');
            }

            return redirect()->route('cards.index')->with('danger', 'This card is already registered');
        }

        try {
            $visaService = new VisaService();
            $cardHolder = $visaService->getCardHolderInfo($data);
            if (!empty($cardHolder)) {
                Card::create([
                    'user_id' => Auth::id(),
                    'type' => Card::CARD_VISA,
                    'number' => $data['number'],
                    'show_status' => Card::STATUS_ACTIVE
                ]);
            }
        } catch (Exception $e) {
            return redirect()->route('cards.index')->with('warning', 'Something went wrong!');
        }

        return redirect()->route('cards.index')->with('success', 'This card successfully added!');
    }

    public function destroy(Card $card)
    {
        if ($card->user_id === Auth::id()) {
            $card->update(['show_status' => Card::STATUS_DELETED]);
            return redirect()->route('cards.index')->with('success', 'You removed that card!');
        }

        return redirect()->route('cards.index')->with('warning', 'Something went wrong!');
    }
}
