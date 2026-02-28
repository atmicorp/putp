<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');
            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');
        $this->dispatch('password-updated');
    }
}; ?>

<section>
    <header>
        <h2 style="font-size: 1rem; font-weight: 600; color: #1c1917; margin: 0;">
            {{ __('Update Password') }}
        </h2>
        <p style="margin-top: 4px; font-size: 0.8rem; color: #6b7280;">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form wire:submit="updatePassword" style="margin-top: 24px; display: flex; flex-direction: column; gap: 20px;">

        <!-- Current Password -->
        <div>
            <label for="update_password_current_password" style="display: block; font-size: 0.8rem; font-weight: 500; color: #1c1917; margin-bottom: 6px;">
                {{ __('Current Password') }}
            </label>
            <input
                wire:model="current_password"
                id="update_password_current_password"
                name="current_password"
                type="password"
                autocomplete="current-password"
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
            @error('current_password')
                <p style="margin-top: 4px; font-size: 0.75rem; color: #ef4444;">{{ $message }}</p>
            @enderror
        </div>

        <!-- New Password -->
        <div>
            <label for="update_password_password" style="display: block; font-size: 0.8rem; font-weight: 500; color: #1c1917; margin-bottom: 6px;">
                {{ __('New Password') }}
            </label>
            <input
                wire:model="password"
                id="update_password_password"
                name="password"
                type="password"
                autocomplete="new-password"
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
            @error('password')
                <p style="margin-top: 4px; font-size: 0.75rem; color: #ef4444;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="update_password_password_confirmation" style="display: block; font-size: 0.8rem; font-weight: 500; color: #1c1917; margin-bottom: 6px;">
                {{ __('Confirm Password') }}
            </label>
            <input
                wire:model="password_confirmation"
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                autocomplete="new-password"
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
            @error('password_confirmation')
                <p style="margin-top: 4px; font-size: 0.75rem; color: #ef4444;">{{ $message }}</p>
            @enderror
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
                x-on:password-updated.window="show = true; setTimeout(() => show = false, 2000)"
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