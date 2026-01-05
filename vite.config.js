import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    server: {
        host: '0.0.0.0',   // cho phép truy cập từ localhost hoặc Docker
        port: 5173,        // port cố định
        cors: true,        // cho phép truy cập cross-origin
        hmr: {
            protocol: 'ws',  // WebSocket bình thường
            host: 'localhost', // host trình duyệt sẽ connect
            port: 5173,      // port Vite dev server
        },
        allowedHosts: ['localhost'],  // chỉ localhost
    },

    plugins: [
        laravel({
            input: ['resources/js/app.jsx'],
            refresh: true, // bật React Refresh
        }),
        react(),
    ],
});
