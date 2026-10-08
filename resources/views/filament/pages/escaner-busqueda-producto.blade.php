{{--
    Contenido del modal del botón "Buscar por código de barras" en el
    listado de Productos. A diferencia del campo BarcodeScannerInput,
    aquí no se rellena un campo: apenas se detecta un código, se llama
    directamente al método Livewire de la página (irABarcode) para que
    decida si redirige a editar el producto existente o a crear uno
    nuevo con ese código precargado.

    Importante: todo el componente de Alpine va INLINE en x-data (no en
    una función global dentro de un <script> aparte). El modal de esta
    acción se inyecta en el DOM vía Livewire cuando se abre, y un
    <script> insertado así nunca se ejecuta en el navegador (es una
    limitación del propio HTML al insertar <script> por innerHTML), así
    que una función global definida ahí quedaría indefinida. El objeto
    inline en x-data no tiene ese problema: Alpine lo evalúa directo
    del atributo, sin depender de que un script se haya ejecutado antes.

    La cámara tampoco se abre sola: hay que tocar "Iniciar cámara",
    porque los navegadores (sobre todo en celular) bloquean
    getUserMedia() si no viene de un toque/clic directo del usuario.
--}}
<div
    x-data="{
        lectorId: 'lector-busqueda-producto',
        mensaje: '',
        mostrandoCamara: false,
        lector: null,
        procesado: false,

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
            this.mostrandoCamara = true;
            this.mensaje = 'Apunta la cámara al código de barras…';

            try {
                await this.cargarLibreria();
            } catch (e) {
                this.mostrandoCamara = false;
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
                        if (this.procesado) return;
                        this.procesado = true;
                        this.mensaje = 'Código detectado: ' + decodedText;
                        this.detener();
                        $wire.call('irABarcode', decodedText);
                    },
                    () => {}
                );
            } catch (e) {
                this.mostrandoCamara = false;
                this.mensaje = 'No se pudo acceder a la cámara: ' + (e && e.message ? e.message : e);
            }
        },

        detener() {
            if (this.lector) {
                const lectorActual = this.lector;
                this.lector = null;
                lectorActual.stop().then(() => lectorActual.clear()).catch(() => {});
            }
        },
    }"
    wire:ignore.self
>
    <div x-show="!mostrandoCamara" style="text-align:center; padding:24px 0;">
        <button
            type="button"
            @click="abrir()"
            style="display:inline-flex; align-items:center; gap:8px; padding:12px 24px; border-radius:9999px; border:1px solid #D4AF37; color:#D4AF37; background:transparent; font-size:14px; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; cursor:pointer;"
        >
            <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7V5a2 2 0 012-2h2M17 3h2a2 2 0 012 2v2M21 17v2a2 2 0 01-2 2h-2M7 21H5a2 2 0 01-2-2v-2M7 12h10" />
            </svg>
            Iniciar cámara
        </button>
    </div>

    <div x-show="mostrandoCamara" x-cloak>
        <div :id="lectorId" style="width:100%; max-width:420px; margin:0 auto; border-radius:12px; overflow:hidden;"></div>
    </div>

    <p x-text="mensaje" style="font-size:13px; margin-top:14px; text-align:center;"></p>
</div>
