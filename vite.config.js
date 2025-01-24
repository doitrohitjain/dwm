import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        host: '10.68.181.236', // Allows access from the local network
        port: 5173,      // Change if necessary
        hmr: {
            host: '10.68.181.236', // Replace with your computer's local IP
        },
    },
});
