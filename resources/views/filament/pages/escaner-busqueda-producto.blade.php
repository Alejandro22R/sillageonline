{{--
    Contenido del modal del botón "Buscar por código de barras" en el
    listado de Productos. A diferencia del campo BarcodeScannerInput,
    aquí no se rellena un campo: apenas se detecta un código, se llama
    directamente al método Livewire de la página (irABarcode) para que
    decida si redirige a editar el producto existente o a crear uno
    nuevo con ese código precargado.
--}}
<div
    x-data="busquedaPorCodigoBarras()"
    x-init="init()"
    wire:ignore.self
>
    <div :id="lectorId" style="width:100%; max-width:420px; margin:0 auto; border-radius:12px; overflow:hidden;"></div>
    <p x-text="mensaje" style="font-size:13px; margin-top:14px; text-align:center;"></p>
</div>

@once
    <script>
        function busquedaPorCodigoBarras() {
            return {
                lectorId: 'lector-busqueda-producto',
                mensaje: 'Apunta la cámara al código de barras…',
                lector: null,
                procesado: false,

                init() {
                    this.$nextTick(() => this.abrir());
                },

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
                                if (this.procesado) return;
                                this.procesado = true;
                                this.mensaje = 'Código detectado: ' + decodedText;
                                this.detener();
                                $wire.call('irABarcode', decodedText);
                            },
                            () => {}
                        );
                    } catch (e) {
                        this.mensaje = 'No se pudo acceder a la cámara. Revisa los permisos del navegador.';
                    }
                },

                detener() {
                    if (this.lector) {
                        const lectorActual = this.lector;
                        this.lector = null;
                        lectorActual.stop().then(() => lectorActual.clear()).catch(() => {});
                    }
                },
            };
        }
    </script>
@endonce
