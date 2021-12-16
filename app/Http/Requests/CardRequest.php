<?php

namespace App\Http\Requests;

use App\Models\Card;
use Illuminate\Foundation\Http\FormRequest;

class CardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'required|string|in:' . implode(',',Card::getCards()),
            'number' => 'required|string|size:16',
            'cardholder_name' => 'required|string|max:255',
            'expiration_date' => 'required|date',
            'cvc' => 'required|integer|digits:3'
        ];
    }
}
