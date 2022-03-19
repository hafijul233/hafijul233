<?php

namespace App\Rules;

use App\Services\Backend\Common\ValidationService;
use Illuminate\Contracts\Validation\Rule;

class UniqueEmail implements Rule
{
    /**
     * @var ValidationService
     */
    private $validationService;

    /**
     * Create a new rule instance.
     */
    public function __construct()
    {
        $this->validationService = new ValidationService();
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
        return $this->validationService->UniqueEmail($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Email already exists';
    }
}
