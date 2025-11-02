import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
        tailwindcss(),
    ],
    server: {
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,
        cors: true,
        allowedHosts: ['fe.takanashataryu.my.id'],
        hmr: {
            host: '127.0.0.1',
            port: 5173,
            protocol: 'ws',
            // If your app is HTTPS, use protocol: 'wss' and also enable https below
        },
        // https: true, // uncomment if your app runs over https to avoid mixed content
    },
});
