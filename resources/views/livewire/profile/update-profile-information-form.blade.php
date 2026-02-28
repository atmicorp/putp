<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';

    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));
            return;
        }

        $user->sendEmailVerificationNotification();
        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header>
        <h2 style="font-size: 1rem; font-weight: 600; color: #1c1917; margin: 0;">
            {{ __('Profile Information') }}
        </h2>
        <p style="margin-top: 4px; font-size: 0.8rem; color: #6b7280;">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" style="margin-top: 24px; display: flex; flex-direction: column; gap: 20px;">

        <!-- Name -->
        <div>
            <label for="name" style="display: block; font-size: 0.8rem; font-weight: 500; color: #1c1917; margin-bottom: 6px;">
                {{ __('Name') }}
            </label>
            <input
                wire:model="name"
                id="name"
                name="name"
                type="text"
                required
                autofocus
                autocomplete="name"
                style="
                    width: 100%; padding: 9px 12px;
                    border: 1px solid #e5e7eb; border-radius: 8px;
                    font-size: 0.875rem; font-family: 'Sora', sans-serif;
                    color: #1c1917; background: #fffaf5;
                    outline: none; transition: border-color 0.15s, box-shadow 0.15s;
                "
                onfocus="this.style.borderColor='#ea580c'; this.style.boxShadow='0 0 0 3px rgba(234,88,12,0.12)'"
                onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'"
            />
            @error('name')
                <p style="margin-top: 4px; font-size: 0.75rem; color: #ef4444;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" style="display: block; font-size: 0.8rem; font-weight: 500; color: #1c1917; margin-bottom: 6px;">
                {{ __('Email') }}
            </label>
            <input
                wire:model="email"
                id="email"
                name="email"
                type="email"
                required
                autocomplete="username"
                style="
                    width: 100%; padding: 9px 12px;
                    border: 1px solid #e5e7eb; border-radius: 8px;
                    font-size: 0.875rem; font-family: 'Sora', sans-serif;
                    color: #1c1917; background: #fffaf5;
                    outline: none; transition: border-color 0.15s, box-shadow 0.15s;
                "
                onfocus="this.style.borderColor='#ea580c'; this.style.boxShadow='0 0 0 3px rgba(234,88,12,0.12)'"
                onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'"
            />
            @error('email')
                <p style="margin-top: 4px; font-size: 0.75rem; color: #ef4444;">{{ $message }}</p>
            @enderror

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div style="margin-top: 8px;">
                    <p style="font-size: 0.8rem; color: #1c1917;">
                        {{ __('Your email address is unverified.') }}
                        <button
                            wire:click.prevent="sendVerification"
                            style="
                                background: none; border: none; padding: 0;
                                font-size: 0.8rem; color: #ea580c; font-weight: 500;
                                cursor: pointer; text-decoration: underline;
                                font-family: 'Sora', sans-serif;
                            "
                        >
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p style="margin-top: 6px; font-size: 0.78rem; font-weight: 500; color: #16a34a;">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Actions -->
        <div style="display: flex; align-items: center; gap: 16px;">
            <button
                type="submit"
                style="
                    padding: 9px 20px;
                    background: #ea580c; color: #fff;
                    border: none; border-radius: 8px;
                    font-size: 0.875rem; font-weight: 600;
                    font-family: 'Sora', sans-serif;
                    cursor: pointer; transition: background 0.15s;
                "
                onmouseover="this.style.background='#c2410c'"
                onmouseout="this.style.background='#ea580c'"
            >
                {{ __('Save') }}
            </button>

            <span
                x-data="{ show: false }"
                x-on:profile-updated.window="show = true; setTimeout(() => show = false, 2000)"
                x-show="show"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                style="font-size: 0.8rem; color: #ea580c; font-weight: 500;"
            >
                {{ __('Saved.') }}
            </span>
        </div>

    </form>
</section>