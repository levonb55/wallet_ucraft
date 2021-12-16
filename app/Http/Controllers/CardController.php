<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\CardRepository;
use App\Finance\CardServices;
use App\Http\Requests\CardRequest;
use App\Models\Card;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
    private $cardRepository;

    public function __construct(CardRepository $cardRepository)
    {
        $this->cardRepository = $cardRepository;
    }

    public function index()
    {
        $cards = $this->cardRepository->getActiveCards();

        return view('cards.index')->with([
            'cards' => $cards,
            'totalBalance' => $cards->sum('amount')
        ]);
    }

    public function store(CardRequest $request)
    {
        $data = $request->validated();

        $card = $this->cardRepository->getCardByTypeNumber($data);

        if (!empty($card)) {
            if ($card->show_status === Card::STATUS_DELETED) {
                $this->cardRepository->activateCard($card);
                return redirect()->route('cards.index')->with('success', 'This card successfully added!');
            }

            return redirect()->route('cards.index')->with('danger', 'This card is already registered');
        }

        try {
            $cardService = CardServices::getServices()[$data['type']];
            $cardHolder = $cardService->getCardHolderInfo($data);
            if (!empty($cardHolder)) {
                $this->cardRepository->create($data);
                return redirect()->route('cards.index')->with('success', 'This card successfully added!');
            }

            return redirect()->route('cards.index')->with('danger', 'That card doesn\'t exist!');
        } catch (Exception $e) {
            return redirect()->route('cards.index')->with('warning', 'Something went wrong!');
        }
    }

    public function destroy(Card $card)
    {
        if ($card->user_id === Auth::id()) {
            $this->cardRepository->deleteCard($card);
            return redirect()->route('cards.index')->with('success', 'You removed that card!');
        }

        return redirect()->route('cards.index')->with('warning', 'Something went wrong!');
    }
}
