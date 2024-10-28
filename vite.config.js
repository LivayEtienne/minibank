import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/chart.js',
                'resources/css/connexion.css',
                'resources/css/style.css',
                'resources/css/client.css',
                'resources/js/client.js',
                'resources/css/distributeur.css',
                //'resources/js/distributeur.js',
                'resources/css/transactions_agent.css',
                'resources/js/connexion.js',
                'resources/image/door.jpg'
            ],
            refresh: true,
        }),
    ],
});
