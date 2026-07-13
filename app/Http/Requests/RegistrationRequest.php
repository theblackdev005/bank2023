<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\ValidBirthdayRule;
use App\Rules\AccountTypesRule;
use App\Rules\GenderRule;

class RegistrationRequest extends FormRequest
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
            "firstname" => ["required", "string"],
            "lastname" => ["required", "string"],
            "phone_number" => ["required", "string", "phone_number"],
            "email" => ["required", "email", "unique:customers,email"],
            "gender" => ["required", "integer", new GenderRule()],
            "birthday" => ["required", "date", new ValidBirthdayRule()],
            "country_id" => ["required", "exists:countries,id"],
            "city" => ["required", "string"],
            "address" => ["required", "string"],
            "account_type" => ["required", "integer", new AccountTypesRule()],
            "currency_id" => ["required", "exists:currencies,id"],
            "language_id" => ["required", "exists:languages,id"],
            "password" => ["required", "string", "confirmed", "min:6", "max:32"],
        ];
    }
}
