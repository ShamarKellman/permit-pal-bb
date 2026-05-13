<?php

namespace App\Concerns;

use Illuminate\Validation\Rules\Password;

trait PasswordValidationRules
{
    /**
     * @return array<int, Password|string>
     */
    protected function passwordRules(): array
    {
        return ['required', 'string', Password::default(), 'confirmed'];
    }

    /**
     * @return list<string>
     */
    protected function currentPasswordRules(): array
    {
        return ['required', 'string', 'current_password'];
    }
}
