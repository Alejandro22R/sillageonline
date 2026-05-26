<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div>
    <div style="text-align: center !important; width: 100% !important; margin-bottom: 1.5rem !important; display: flex !important; flex-direction: column !important; align-items: center !important;">

        <div style="margin-bottom: 1rem !important; display: inline-block !important;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="55" height="55" fill="none" stroke="#d4af37" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10 2c0 1 1 1.5 2 1.5s2-.5 2-1.5" />
                <path d="M11 4c0 .8.5 1.2 1 1.2s1-.4 1-1.2" />
                <path d="M9 7h6v2H9z" fill="#d4af37" opacity="0.2"/>
                <circle cx="12" cy="6" r="1" fill="#d4af37"/>
                <path d="M10 9h4v2h-4z" />
                <path d="M7 11.5c0-1 1-1.5 2-1.5h6c1 0 2 .5 2 1.5v6c0 2.5-2 4.5-5 4.5s-5-2-5-4.5v-6z" fill="url(#gold-gradient-forgot)" opacity="0.1" />
                <path d="M7 11.5c0-1 1-1.5 2-1.5h6c1 0 2 .5 2 1.5v6c0 2.5-2 4.5-5 4.5s-5-2-5-4.5v-6z" />
                <circle cx="12" cy="16" r="2.5" />
                <path d="M12 13.5v5M9.5 16h5" opacity="0.7"/>
                <defs>
                    <linearGradient id="gold-gradient-forgot" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#b3923b" />
                        <stop offset="50%" stop-color="#d4af37" />
                        <stop offset="100%" stop-color="#f3e5ab" />
                    </linearGradient>
                </defs>
            </svg>
        </div>

        <h2 style="font-family: 'Playfair Display', serif; color: #ffffff; font-size: 1.4rem; letter-spacing: 0.1em; font-weight: 400; margin: 0 auto !important; text-align: center !important; display: block !important;">
            RECUPERAR CLAVE
        </h2>
        <p style="color: #d4af37; font-size: 0.65rem; letter-spacing: 0.2em; font-weight: 300; margin-top: 0.4rem !important; margin-bottom: 0 !important; text-align: center !important; display: block !important; text-transform: uppercase;">
            Sillage Parfums
        </p>
    </div>

    <div style="color: #999999; font-size: 0.8rem; text-align: center; line-height: 1.4; margin-bottom: 1.5rem; font-weight: 300;">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink" style="margin: 0; padding: 0;">
        <div style="margin-bottom: 1.5rem;">
            <label for="email" style="color: #b3923b; font-size: 0.7rem; font-weight: 500; letter-spacing: 0.15em; text-transform: uppercase; display: block; margin-bottom: 0.4rem;">
                EMAIL
            </label>
            <input wire:model="email" id="email"
                   class="input-sillage"
                   type="email" name="email" required autofocus placeholder="ejemplo@correo.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-500" />
        </div>

        <div style="margin-top: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
            <button type="submit" class="btn-sillage">
                {{ __('Email Password Reset Link') }}
            </button>

            <div style="text-align: center;">
                <a href="{{ route('login') }}" wire:navigate
                   style="color: #666666; font-size: 0.75rem; text-decoration: none; transition: color 0.2s;"
                   onmouseover="this.style.color='#d4af37';"
                   onmouseout="this.style.color='#666666';">
                    ← Volver al inicio de sesión
                </a>
            </div>
        </div>
    </form>
</div>
