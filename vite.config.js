import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/business-autopsy.css',
                'resources/js/business-autopsy.js',
            ],
            refresh: true,
        }),
    ],
});
