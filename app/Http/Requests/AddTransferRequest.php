<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\TransferMethodRule;
use App\Rules\ValidSwiftCode;

class AddTransferRequest extends FormRequest
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
        $rules = [
            "payment_method" => ["required", "string", new TransferMethodRule()],
            "amount" => ["required", "numeric", "gt:0", "regex:/^\d+(?:\.\d{1,2})?$/"],
            "reference" => ["required", "string"],
        ];

        if (request()->payment_method === 'recipients') {
            $rules["recipient_mode"] = ["required", "in:new,existing"];

            if (request()->recipient_mode === 'new') {
                return array_merge($rules, [
                "new_recipient_name" => ["required", "string", "max:255"],
                "new_recipient_iban" => ["required", "iban"],
                "new_recipient_bic" => ["required", "string", new ValidSwiftCode()],
                ]);
            }
        } elseif (request()->payment_method === 'paypal') {
            $rules["paypal_mode"] = ["required", "in:new,existing"];

            if (request()->paypal_mode === 'new') {
                return array_merge($rules, [
                    "new_paypal_email" => ["required", "email", "max:255"],
                ]);
            }
        } elseif (request()->payment_method === 'cards') {
            $rules["card_mode"] = ["required", "in:new,existing"];

            if (request()->card_mode === 'new') {
                return array_merge($rules, [
                    "new_card_owner" => ["required", "string", "max:255"],
                    "new_card_number" => ["required", "creditcard"],
                    "new_card_expire" => ["required", "regex:/^(0[1-9]|1[0-2])\/\d{4}$/"],
                    "new_card_cvv" => ["required", "digits_between:3,4"],
                ]);
            }
        }

        return array_merge($rules, [
            "payment_method_id" => ["required", "exists:". transfer_methods(request()->payment_method) .",id"],
        ]);
    }

    public function attributes()
    {
        return [
            'new_recipient_name' => translate(323),
            'new_recipient_iban' => translate(325),
            'new_recipient_bic' => translate(317),
            'new_paypal_email' => translate(617),
            'new_card_owner' => translate(614),
            'new_card_number' => translate(611),
            'new_card_expire' => translate(612),
            'new_card_cvv' => translate(613),
        ];
    }

    public function messages()
    {
        return [
            'new_card_number.creditcard' => translate(842),
        ];
    }
}
