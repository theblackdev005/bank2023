<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCardRequest extends FormRequest
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
            "number" => ["required", "creditcard"],
            "expire" => ["required", "string"],
            "cvv" => ["required", "string"],
            "card_owner" => ["required", "string"],
            "brand_name" => ["required", "string"],
        ];
    }

    public function messages()
    {
        return ['number.creditcard' => translate(842)];
    }
}
