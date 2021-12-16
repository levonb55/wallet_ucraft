<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\CardRepository;
use App\Http\Requests\CardRequest;
use App\Models\Card;
use App\Services\VisaService;
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

        $cards = $cards->map(function ($card, $key) {
            $visaService = new VisaService();
            return $visaService->getCardHolderInfo($card->toArray()) + [
                    'id' => $card->id,
                    'number' => $card->number,
                    'type' => $card->type
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

        $card = $this->cardRepository->getCardByTypeNumber($data);

        if (!empty($card)) {
            if ($card->show_status === Card::STATUS_DELETED) {
                $this->cardRepository->activateCard($card);
                return redirect()->route('cards.index')->with('success', 'This card successfully added!');
            }

            return redirect()->route('cards.index')->with('danger', 'This card is already registered');
        }

        try {
            $visaService = new VisaService();
            $cardHolder = $visaService->getCardHolderInfo($data);
            if (!empty($cardHolder)) {
                $this->cardRepository->create($data);
            }
        } catch (Exception $e) {
            return redirect()->route('cards.index')->with('warning', 'Something went wrong!');
        }

        return redirect()->route('cards.index')->with('success', 'This card successfully added!');
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
