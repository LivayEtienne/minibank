import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/style.css',
                'resources/js/charts.js',
                'resources/css/client.css',
                'resources/js/client.js',
                'resources/css/distributeur.css',
                'resources/js/distributeur.js',
                'resources/css/transactions_agent.css'
            ],
            refresh: true,
        }),
    ],
});
