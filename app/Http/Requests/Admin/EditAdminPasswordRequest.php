<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\AccountValidPasswordRule;

class EditAdminPasswordRequest extends FormRequest
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
            "old_password" => ["required", "string", new AccountValidPasswordRule( admin()->password )],
            "new_password" => ["required", "string", "confirmed", "min:8", "max:32"],
        ];
    }
}
