<div style="font-family: 'Figtree', sans-serif;">
    <h1 style="font-family: 'Playfair Display', serif; color: #d4af37; font-size: 1.2rem; letter-spacing: 0.05em; font-weight: 400; margin-bottom: 1.5rem;">
        {{ __('passkeys::passkeys.passkeys') }}
    </h1>

    <div>
        <form id="passkeyForm" wire:submit="validatePasskeyProperties" style="display: flex; align-items: flex-end; gap: 0.75rem;">
            <div style="flex: 1;">
                <label for="name" style="color: #b3923b; font-size: 0.7rem; font-weight: 500; letter-spacing: 0.15em; text-transform: uppercase; display: block; margin-bottom: 0.4rem;">
                    {{ __('passkeys::passkeys.name') }}
                </label>
                <input autocomplete="off" type="text" wire:model="name"
                       class="input-sillage"
                       placeholder="Ej. Mi teléfono">
                @error('name')
                    <span style="color: #ff4d4d; font-size: 0.75rem; display: block; margin-top: 0.4rem;">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <button type="submit"
                    style="background: linear-gradient(90deg, #b3923b 0%, #d4af37 50%, #f3e5ab 100%); color: #000; border: none; border-radius: 6px; padding: 0.65rem 1.25rem; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; cursor: pointer; transition: all 0.3s ease; white-space: nowrap;"
                    onmouseover="this.style.opacity='0.85'"
                    onmouseout="this.style.opacity='1'">
                {{ __('passkeys::passkeys.create') }}
            </button>
        </form>
    </div>

    <div style="margin-top: 2rem;">
        <ul style="list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 0.75rem;">
            @forelse($passkeys as $passkey)
                <li style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: #1a1a1a; border: 1px solid #333; border-radius: 8px;">
                    <div style="color: #fff; font-weight: 500; font-size: 0.9rem;">
                        {{ $passkey->name }}
                    </div>
                    <div style="color: #888; font-size: 0.75rem;">
                        {{ __('passkeys::passkeys.last_used') }}: {{ $passkey->last_used_at?->diffForHumans() ?? __('passkeys::passkeys.not_used_yet') }}
                    </div>
                    <div>
                        <button wire:click="deletePasskey({{ $passkey->id }})"
                                style="background: transparent; border: 1px solid #ff4d4d; color: #ff4d4d; border-radius: 4px; padding: 0.4rem 0.9rem; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; cursor: pointer; transition: all 0.2s ease;"
                                onmouseover="this.style.background='#ff4d4d'; this.style.color='#000';"
                                onmouseout="this.style.background='transparent'; this.style.color='#ff4d4d';">
                            {{ __('passkeys::passkeys.delete') }}
                        </button>
                    </div>
                </li>
            @empty
                <li style="color: #666; font-size: 0.85rem; text-align: center; padding: 1.5rem;">
                    Aún no tienes ninguna huella registrada.
                </li>
            @endforelse
        </ul>
    </div>
</div>

@include('passkeys::livewire.partials.createScript')