import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    // AGREGA ESTE BLOQUE SERVER:
    server: {
        host: '0.0.0.0',
        hmr: {
            host: '192.168.1.191', // Tu IP actual
        },
    },
});