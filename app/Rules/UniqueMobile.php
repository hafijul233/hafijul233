<?php

namespace App\Rules;

use App\Services\Auth\VerifyService;
use Illuminate\Contracts\Validation\Rule;

class UniqueMobile implements Rule
{
    /**
     * @var VerifyService
     */
    protected $verifyService;

    /**
     * Create a new rule instance.
     */
    public function __construct()
    {
        $this->verifyService = new VerifyService();
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
        return $this->verifyService->verifyMobile($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Phone Number already exists';
    }
}
