<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Country;

class AddRecipientRequest extends FormRequest
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
        $country    = Country::whereId(request()->bank_country_id)->firstOrFail();
        $rules      = add_recipient_validator_rules($country->iso);

        return array_merge($rules, [
            "recipient_name" => ["required", "string"],
            "recipient_address" => ["required", "string"],

            "bank_name" => ["required", "string"],
            "bank_address" => ["required", "string"],

            "currency_id" => ["required", "integer", "exists:currencies,id"],
            "bank_country_id" => ["required", "integer", "exists:countries,id"],
        ]);
    }
}
