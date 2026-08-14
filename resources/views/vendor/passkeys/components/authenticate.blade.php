<div>
    @include('passkeys::components.partials.authenticateScript')

    <form id="passkey-login-form" method="POST" action="{{ route('passkeys.login') }}">
        @csrf
    </form>

    @if($message = session()->get('authenticatePasskey::message'))
        <div style="background: rgba(255, 77, 77, 0.1); color: #ff4d4d; padding: 0.75rem 1rem; border: 1px solid #ff4d4d; border-radius: 6px; font-size: 0.8rem; margin-bottom: 1rem;">
            {{ $message }}
        </div>
    @endif

    <div onclick="authenticateWithPasskey()"
         style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.5rem; background-color: #111; border: 1px solid #d4af37; color: #d4af37; font-weight: bold; padding: 0.75rem 1rem; border-radius: 4px; transition: opacity 0.2s; letter-spacing: 0.05em; font-size: 0.875rem; cursor: pointer; text-transform: uppercase;"
         onmouseover="this.style.opacity='0.8'"
         onmouseout="this.style.opacity='1'">
        @if ($slot->isEmpty())
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 1.5rem; height: 1.5rem;">
              <path stroke-linecap="round" stroke-linejoin="round" d="M7.864 4.243A7.5 7.5 0 0119.5 10.5c0 2.92-.556 5.709-1.568 8.268M5.742 6.364A7.465 7.465 0 004.5 10.5a7.464 7.464 0 01-1.15 3.993m1.989 3.559A11.209 11.209 0 008.25 10.5a3.75 3.75 0 117.5 0c0 .527-.021 1.049-.064 1.565M12 10.5a14.94 14.94 0 01-3.6 9.75m6.633-4.596a18.666 18.666 0 01-2.485 5.33" />
            </svg>
            HUELLA DACTILAR
        @else
            {{ $slot }}
        @endif
    </div>
</div>