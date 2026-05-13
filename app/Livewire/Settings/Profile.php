<?php

namespace App\Livewire\Settings;

use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Flux\Flux;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Profile settings')]
class Profile extends Component
{
    use ProfileValidationRules;

    public string $name = '';

    public string $email = '';

    public function mount(): void
    {
        /** @var User $user */
        $user = Auth::user();

        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function updateProfileInformation(): void
    {
        /** @var User $user */
        $user = Auth::user();

        /** @var array{name: string, email: string} $validated */
        $validated = $this->validate($this->profileRules($user->id));

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        Flux::toast(text: __('Profile updated.'), variant: 'success');
    }

    public function resendVerificationNotification(): void
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Flux::toast(text: __('A new verification link has been sent to your email address.'));
    }

    #[Computed]
    public function hasUnverifiedEmail(): bool
    {
        /** @var User $user */
        $user = Auth::user();

        return $user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail();
    }

    #[Computed]
    public function showDeleteUser(): bool
    {
        /** @var User $user */
        $user = Auth::user();

        return ! $user instanceof MustVerifyEmail
            || $user->hasVerifiedEmail();
    }
}
