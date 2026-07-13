<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminCreateFeeRequest extends FormRequest
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
            "name" => ["required", "string"],
            "cost" => ["required", "integer"],
            "percentage" => ["required", "integer"],
            "instructions" => ["required", "string"],
            "delay_frequence" => ["required", "integer"],
            "delay_interval" => ["required", "integer"],
        ];
    }
}
