<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\GenderRule;
use App\Rules\ValidBirthdayRule;
use App\Rules\AccountValidPasswordRule;

class EditAccountRequest extends FormRequest
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
        $customer = customer();
        
        return [
            "email" => ["present", "nullable", "email", "unique:customers,email," . $customer->id . ",id"],
            "gender" => ["present", "nullable", "integer", new GenderRule()],
            "birthday" => ["present", "nullable", "date", new ValidBirthdayRule()],
            "phone_number" => ["present", "nullable", "string", "phone_number"],
            "country_id" => ["present", "nullable", "exists:countries,id"],
            "currency_id" => ["present", "nullable", "exists:currencies,id"],
            "language_id" => ["present", "nullable", "exists:languages,id"],
            "city" => ["present", "nullable", "string"],
            "address" => ["present", "nullable", "string"],
            "image" => ["nullable", "image", "mimes:jpg,png,jpeg", "max:2048"],

            "password" => ["present", "nullable", "string", new AccountValidPasswordRule( customer()->password )],
        ];
    }
}
