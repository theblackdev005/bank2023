<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\TransferMethodRule;

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
        return [
            "payment_method" => ["required", "string", new TransferMethodRule()],
            "payment_method_id" => ["required", "exists:". transfer_methods(request()->payment_method) .",id"],
            "amount" => ["required", "string"],
            "reference" => ["required", "string"],
        ];
    }
}
