<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminCreateTestimonialRequest extends FormRequest
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
            "country_id" => ["required", "exists:countries,id"],
            "title" => ["required", "string"],
            "message" => ["required", "string"],
            "note" => ["required"],
            "image" => ["required", "image", "mimes:jpg,png,jpeg", "max:2048"],
        ];
    }
}
