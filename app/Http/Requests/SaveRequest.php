<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100'],
            'lastname' => ['string', 'max:100'],
            'addresses' => ['array', 'min:1'],
            'phones' => ['required', 'array', 'min:1'],
            'phones.*'  => ['required', 'numeric', 'distinct', 'digits:10'],
            'addresses.*'  => ['required', 'string', 'distinct'],
        ];
    }
}
