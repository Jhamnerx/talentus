import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/cliente.css',
                'resources/css/style.scss',
                'resources/js/app.js',
                'resources/js/cliente.js',
            ],
            refresh: true,
        }),
    ],
});
