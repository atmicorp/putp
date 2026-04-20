<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <style>
        :root {
            --orange:        #EA580C;
            --orange-dark:   #C2410C;
            --orange-light:  #FFF7ED;
            --orange-border: #FED7AA;
            --navy:          #0F2A47;
            --muted:         #64748B;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: #fff;
            border-radius: 16px;
            padding: 40px 32px;
            box-shadow: 0 20px 60px -20px rgba(234, 88, 12, .25),
                        0 4px 16px rgba(0, 0, 0, .04);
        }

        .login-logo-wrap {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .login-logo {
            width: 80px; height: 80px;
            object-fit: contain;
            padding: 8px;
            background: var(--orange-light);
            border: 1px solid var(--orange-border);
            border-radius: 16px;
        }

        .login-title {
            text-align: center;
            font-size: 22px;
            font-weight: 700;
            color: var(--navy);
            margin: 0 0 6px;
        }
        .login-sub {
            text-align: center;
            font-size: 13px;
            color: var(--muted);
            margin: 0 0 28px;
        }

        .login-status {
            background: #ECFDF5;
            border: 1px solid #A7F3D0;
            color: #065F46;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .field { margin-bottom: 18px; }
        .field-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--navy);
            margin-bottom: 6px;
        }
        .field-input {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            font-size: 14px;
            color: var(--navy);
            background: #fff;
            transition: all .2s;
            font-family: inherit;
            box-sizing: border-box;
        }
        .field-input:focus {
            outline: none;
            border-color: var(--orange);
            box-shadow: 0 0 0 3px rgba(234, 88, 12, .15);
        }
        .field-error {
            display: block;
            margin-top: 6px;
            font-size: 12px;
            color: #DC2626;
        }

        .field-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 12px;
        }
        .remember-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--muted);
            cursor: pointer;
        }
        .remember-check {
            width: 16px; height: 16px;
            accent-color: var(--orange);
            cursor: pointer;
        }
        .forgot-link {
            font-size: 13px;
            color: var(--orange);
            text-decoration: none;
            font-weight: 500;
        }
        .forgot-link:hover {
            color: var(--orange-dark);
            text-decoration: underline;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background: var(--orange);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s;
            font-family: inherit;
            text-transform: uppercase;
            letter-spacing: .5px;
        }
        .login-btn:hover {
            background: var(--orange-dark);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px -6px rgba(234, 88, 12, .5);
        }
        .login-btn:active { transform: translateY(0); }
    </style>

    <div class="login-card">
        {{-- LOGO --}}
        <div class="login-logo-wrap">
            <img src="{{ asset('logopoltek.png') }}" alt="Logo Poltek" class="login-logo">
        </div>

        <h1 class="login-title">Selamat Datang</h1>
        <p class="login-sub">Silakan masuk ke akun Anda</p>

        {{-- Session Status --}}
        @if (session('status'))
            <div class="login-status">{{ session('status') }}</div>
        @endif

        <form wire:submit="login">
            {{-- Email --}}
            <div class="field">
                <label for="email" class="field-label">{{ __('Email') }}</label>
                <input wire:model="form.email" id="email" type="email" name="email"
                       class="field-input" required autofocus autocomplete="username"
                       placeholder="nama@email.com">
                @error('form.email') <span class="field-error">{{ $message }}</span> @enderror
            </div>

            {{-- Password --}}
            <div class="field">
                <label for="password" class="field-label">{{ __('Password') }}</label>
                <input wire:model="form.password" id="password" type="password" name="password"
                       class="field-input" required autocomplete="current-password"
                       placeholder="••••••••">
                @error('form.password') <span class="field-error">{{ $message }}</span> @enderror
            </div>

            {{-- Remember + Forgot --}}
            <div class="field-row">
                <label for="remember" class="remember-label">
                    <input wire:model="form.remember" id="remember" type="checkbox"
                           name="remember" class="remember-check">
                    {{ __('Remember me') }}
                </label>

                @if (Route::has('password.request'))
                    <a class="forgot-link" href="{{ route('password.request') }}" wire:navigate>
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <button type="submit" class="login-btn">{{ __('Log in') }}</button>
        </form>
    </div>
</div>
