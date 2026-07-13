<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminCreatingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return admin()->isSuper();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => ["required", "string", "unique:admins,name"],
            "username" => ["required", "string", "unique:admins,username"],
            "email" => ["required", "email", "unique:admins,email"],
            "password" => ["required", "string"],
            "enable" => ["nullable", "string"],
        ];
    }
}
