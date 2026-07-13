<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use Carbon\Carbon;

class ValidBirthdayRule implements Rule
{
    private $minAge;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($minAge=18)
    {
        $this->minAge = (int) $minAge;
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
        if ( preg_match("/\//", $value) ) {
            $value = str_ireplace("/", "-", $value);
        }
        return Carbon::now()->diff(new Carbon($value))->y >= $this->minAge;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return translate(645);
    }
}
