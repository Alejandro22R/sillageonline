<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div
        x-data="{
            state: $wire.entangle('{{ $getStatePath() }}').live,
            lectorId: '{{ $getLectorId() }}',
            mostrando: false,
            mensaje: 'Apunta la cámara al código de barras…',
            lector: null,

            cargarLibreria() {
                return new Promise((resolve, reject) => {
                    if (window.Html5Qrcode) {
                        resolve();
                        return;
                    }
                    const existente = document.getElementById('html5-qrcode-lib');
                    if (existente) {
                        existente.addEventListener('load', () => resolve());
                        existente.addEventListener('error', reject);
                        return;
                    }
                    const script = document.createElement('script');
                    script.id = 'html5-qrcode-lib';
                    script.src = 'https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/html5-qrcode.min.js';
                    script.onload = () => resolve();
                    script.onerror = reject;
                    document.head.appendChild(script);
                });
            },

            async abrir() {
                this.mostrando = true;
                this.mensaje = 'Apunta la cámara al código de barras…';

                try {
                    await this.cargarLibreria();
                } catch (e) {
                    this.mensaje = 'No se pudo cargar el lector. Revisa tu conexión a internet.';
                    return;
                }

                await this.$nextTick();

                try {
                    this.lector = new window.Html5Qrcode(this.lectorId, {
                        formatsToSupport: [
                            Html5QrcodeSupportedFormats.EAN_13,
                            Html5QrcodeSupportedFormats.EAN_8,
                            Html5QrcodeSupportedFormats.UPC_A,
                            Html5QrcodeSupportedFormats.UPC_E,
                            Html5QrcodeSupportedFormats.CODE_128,
                            Html5QrcodeSupportedFormats.CODE_39,
                            Html5QrcodeSupportedFormats.ITF,
                            Html5QrcodeSupportedFormats.CODABAR,
                            Html5QrcodeSupportedFormats.QR_CODE,
                        ],
                        verbose: false,
                    });

                    await this.lector.start(
                        { facingMode: 'environment' },
                        { fps: 10, qrbox: { width: 260, height: 150 } },
                        (decodedText) => {
                            this.state = decodedText;
                            this.cerrar();
                        },
                        () => {}
                    );
                } catch (e) {
                    this.mensaje = 'No se pudo acceder a la cámara: ' + (e && e.message ? e.message : e);
                }
            },

            cerrar() {
                if (this.lector) {
                    const lectorActual = this.lector;
                    this.lector = null;
                    lectorActual.stop()
                        .then(() => lectorActual.clear())
                        .catch(() => {});
                }
                this.mostrando = false;
            },
        }"
        wire:ignore.self
    >
        <div style="display:flex; gap:8px; align-items:center;">
            <input
                type="text"
                x-model="state"
                placeholder="{{ $getScannerPlaceholder() }}"
                class="fi-input"
                style="flex:1 1 auto; min-width:0;"
                {{ $isDisabled() ? 'disabled' : '' }}
            />

            <button
                type="button"
                @click="abrir()"
                style="flex-shrink:0; display:inline-flex; align-items:center; gap:6px; padding:8px 14px; border-radius:8px; border:1px solid #D4AF37; color:#D4AF37; background:transparent; font-size:13px; font-weight:600; white-space:nowrap; cursor:pointer;"
            >
                <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7V5a2 2 0 012-2h2M17 3h2a2 2 0 012 2v2M21 17v2a2 2 0 01-2 2h-2M7 21H5a2 2 0 01-2-2v-2M7 12h10" />
                </svg>
                Escanear
            </button>
        </div>

        {{-- Overlay de la cámara --}}
        <div
            x-show="mostrando"
            x-cloak
            style="position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,.92); display:flex; flex-direction:column; align-items:center; justify-content:center; padding:16px;"
        >
            <div :id="lectorId" style="width:100%; max-width:420px; border-radius:12px; overflow:hidden;"></div>
            <p x-text="mensaje" style="color:#fff; font-size:13px; margin-top:14px; text-align:center;"></p>
            <button
                type="button"
                @click="cerrar()"
                style="margin-top:18px; padding:10px 22px; border-radius:9999px; border:1px solid #D4AF37; color:#D4AF37; background:transparent; font-size:13px; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; cursor:pointer;"
            >
                Cancelar
            </button>
        </div>
    </div>
</x-dynamic-component>
