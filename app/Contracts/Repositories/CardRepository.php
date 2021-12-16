<?php

namespace App\Contracts\Repositories;

interface CardRepository
{
    public function create($data);

    public function getActiveCards();

    public function getCardByTypeNumber($data);

    public function activateCard($card);

    public function deleteCard($card);
}
