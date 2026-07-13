<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class AccountValidPasswordRule implements Rule
{

    private $hashedPassword = null;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($hashedPassword)
    {
        $this->hashedPassword = $hashedPassword;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Hash::check($value, $this->hashedPassword);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return translate(40);
    }
}
