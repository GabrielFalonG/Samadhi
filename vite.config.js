import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        // The outDir should be set to your public directory
        outDir: 'public/build',
    },
    server: {
        host: "0.0.0.0", // Permitir conexiones externas
        port: 5173, // Puerto que usará Vite
        watch: {
            usePolling: true, // Necesario en Docker para detectar cambios en archivos
        },
        hmr: {
            host: "192.168.0.80",
            port: 5173,
        }
    }
});
