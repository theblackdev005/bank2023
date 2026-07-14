<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
        $rules = [];

        if ( LOGIN_USING_ACCOUNTNUMBER_AND_BIRTHDATE ) {
            $rules = [
                "account_number" => ["required", "exists:customers,username"],

                "birth_date" => ["nullable", "array", "size:3"],
                "birth_date.day" => ["required", "string", ],
                "birth_date.month" => ["required", "string", ],
                "birth_date.year" => ["required", "integer", ],
            ];
        } elseif ( LOGIN_USING_EMAIL_AND_PASSWORD ) {
            $rules = [
                "email" => ["required", "exists:customers,email"],
                "password" => ["required",],
            ];
        } else {
            $rules = [
                "username" => ["required", "exists:customers,username"],
                "password" => ["required",],
            ];
        }

        $rules['timezone'] = ['nullable', 'timezone'];

        return $rules;
    }
}
