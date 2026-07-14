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

        if (request()->payment_method === 'recipients' && request()->recipient_mode === 'new') {
            return array_merge($rules, [
                "recipient_mode" => ["required", "in:new,existing"],
                "new_recipient_name" => ["required", "string", "max:255"],
                "new_recipient_iban" => ["required", "iban"],
                "new_recipient_bic" => ["required", "string", new ValidSwiftCode()],
            ]);
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
        ];
    }
}
