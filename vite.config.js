import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/scss/style.scss', 'resources/js/app.js', 'resources/lang/{en.json, nl.json}', 'resources/css/animations.css'],
            refresh: true,
        }),
    ],
});
