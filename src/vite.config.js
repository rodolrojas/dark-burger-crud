import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import tailwindcss from '@tailwindcss/vite';

const appUrl = process.env.APP_URL ?? 'http://localhost:8080';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.jsx'],
            refresh: true,
        }),
        react(),
        tailwindcss(),
    ],
    server: {
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,
        origin: 'http://localhost:5173',
        cors: {
            origin: [appUrl, 'http://localhost:8080', 'http://127.0.0.1:8080'],
        },
        hmr: {
            host: 'localhost',
            clientPort: 5173,
        },
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
