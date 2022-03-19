<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MinLength implements Rule
{
    private $limit = null;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($limit)
    {
        $this->limit = $limit;
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
        return (!(strlen($value) < $this->limit));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute must be at least ' . $this->limit . ' characters.';
    }
}
