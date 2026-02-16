import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/admin/scss/app.scss',
                'resources/admin/css/app.css',
                'resources/admin/js/app.js',
                'resources/front/scss/style.scss',
                'resources/front/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
