import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/style.css',
                'resources/js/chart.js',
                'resources/css/create_compte.css',
                'resources/css/affichage.css',
                'resources/js/chart.js',
                'resources/js/confirmation.js',
                'resources/js/list_client.js',
                'resources/css/connexion.css'
            ],
            refresh: true,
        }),
    ],
});
