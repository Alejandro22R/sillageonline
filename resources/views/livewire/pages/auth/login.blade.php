<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div style="text-align: center !important; width: 100% !important; margin-bottom: 2rem !important; display: flex !important; flex-direction: column !important; align-items: center !important;">

        <div style="margin-bottom: 1rem !important; display: inline-block !important;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="55" height="55" fill="none" stroke="#d4af37" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10 2c0 1 1 1.5 2 1.5s2-.5 2-1.5" />
                <path d="M11 4c0 .8.5 1.2 1 1.2s1-.4 1-1.2" />
                <path d="M9 7h6v2H9z" fill="#d4af37" opacity="0.2"/>
                <circle cx="12" cy="6" r="1" fill="#d4af37"/>
                <path d="M10 9h4v2h-4z" />
                <path d="M7 11.5c0-1 1-1.5 2-1.5h6c1 0 2 .5 2 1.5v6c0 2.5-2 4.5-5 4.5s-5-2-5-4.5v-6z" fill="url(#gold-gradient)" opacity="0.1" />
                <path d="M7 11.5c0-1 1-1.5 2-1.5h6c1 0 2 .5 2 1.5v6c0 2.5-2 4.5-5 4.5s-5-2-5-4.5v-6z" />
                <circle cx="12" cy="16" r="2.5" />
                <path d="M12 13.5v5M9.5 16h5" opacity="0.7"/>
                <defs>
                    <linearGradient id="gold-gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#b3923b" />
                        <stop offset="50%" stop-color="#d4af37" />
                        <stop offset="100%" stop-color="#f3e5ab" />
                    </linearGradient>
                </defs>
            </svg>
        </div>

        <h2 style="font-family: 'Playfair Display', serif; color: #ffffff; font-size: 1.4rem; letter-spacing: 0.1em; font-weight: 400; margin: 0 auto !important; text-align: center !important; display: block !important;">
            INICIAR SESIÓN
        </h2>
        <p style="color: #d4af37; font-size: 0.65rem; letter-spacing: 0.2em; font-weight: 300; margin-top: 0.4rem !important; margin-bottom: 0 !important; text-align: center !important; display: block !important; text-transform: uppercase;">
            ACCESO EXCLUSIVO
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" style="margin: 0; padding: 0;">
        <div style="margin-bottom: 1.25rem;">
            <label for="email" style="color: #b3923b; font-size: 0.7rem; font-weight: 500; letter-spacing: 0.15em; text-transform: uppercase; display: block; margin-bottom: 0.4rem;">
                EMAIL
            </label>
            <input wire:model="form.email" id="email"
                   class="input-sillage"
                   type="email" name="email" required autofocus autocomplete="username" placeholder="ejemplo@correo.com" />

            @error('form.email')
                <span style="color: #ff4d4d !important; font-size: 0.75rem; display: block; margin-top: 0.4rem; font-weight: 400; letter-spacing: 0.02em;">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div style="margin-bottom: 1.25rem;">
            <label for="password" style="color: #b3923b; font-size: 0.7rem; font-weight: 500; letter-spacing: 0.15em; text-transform: uppercase; display: block; margin-bottom: 0.4rem;">
                PASSWORD
            </label>
            <input wire:model="form.password" id="password"
                   class="input-sillage"
                   type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />

            @error('form.password')
                <span style="color: #ff4d4d !important; font-size: 0.75rem; display: block; margin-top: 0.4rem; font-weight: 400; letter-spacing: 0.02em;">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.75rem; margin-top: 1.5rem; margin-bottom: 1.5rem;">
            <label for="remember" style="display: inline-flex; align-items: center; cursor: pointer; color: #aaaaaa;">
                <input wire:model="form.remember" id="remember" type="checkbox" name="remember"
                       style="accent-color: #d4af37; border-radius: 4px; border: 1px solid #333; background: #1a1a1a;">
                <span style="margin-left: 0.5rem; user-select: none;">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" wire:navigate
                   style="color: #888888; text-decoration: none; border-bottom: 1px solid #333; padding-bottom: 1px; transition: color 0.2s;"
                   onmouseover="this.style.color='#d4af37'; this.style.borderColor='#d4af37';"
                   onmouseout="this.style.color='#888888'; this.style.borderColor='#333';">
                     Forgot your password?
                </a>
            @endif
        </div>

        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn-sillage">
                LOG IN
            </button>
        </div>
    </form>
</div>
