<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneNumber implements Rule
{
    protected $countryCode = [];

    public function __construct($country_code = '')
    {
        if (!is_array($country_code)) {
            $country_code = array($country_code);
        }

        $this->countryCode = $country_code;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return preg_match('/01[0-9]{9}/i', $value) > 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute must have valid (01xxxxxxxxx) format.';
    }
}
