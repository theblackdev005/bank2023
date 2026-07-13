<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\AccountTypesRule;
use App\Rules\GenderRule;
use App\Rules\ValidBirthdayRule;

class EditCustomerAccountRequest extends FormRequest
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
        $customer = admin_request_customer();

        return [
            "firstname" => ["required", "string"],
            "lastname" => ["required", "string"],
            "email" => ["required", "email", "unique:customers,email," . $customer->id . ",id"],
            "account_type" => ["required", new AccountTypesRule()],
            "currency_id" => ["required", "exists:currencies,id"],
            "language_id" => ["required", "exists:languages,id"],
            "gender" => ["required", new GenderRule()],
            "birthday" => ["required", "date", new ValidBirthdayRule()],
            "country_id" => ["required", "exists:countries,id"],
            "city" => ["required", "string"],
            "address" => ["required", "string"],
            "phone_number" => ["required", "string", "phone_number"],
            "image" => ["nullable", "image", "mimes:jpg,png,jpeg", "max:2048"],
        ];
    }
}
