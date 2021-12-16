<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\CardRepository;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $cardRepository;

    public function __construct(CardRepository $cardRepository)
    {
        $this->cardRepository = $cardRepository;
    }

    public function index()
    {
        $cards = $this->cardRepository->getActiveCards();

        return view('payments.index')->with([
            'cards' => $cards,
        ]);
    }
}
