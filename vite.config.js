import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/charts.js',
                'resources/css/connexion.css',
                'resources/css/style.css',
                'resources/js/connexion.js',
                'resources/assets/door.jpg'
            ],
            refresh: true,
        }),
    ],
});
