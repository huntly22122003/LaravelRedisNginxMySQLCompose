import { defineConfig, loadEnv } from 'vite';
import fs from 'fs';
import path from 'path';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig(({ mode }) => {
  // load biến môi trường từ file .env
  const env = loadEnv(mode, process.cwd(), '');

  return {
    server: {
      host: '0.0.0.0',
      port: 5173,
      cors: true,
      https: {
        key: fs.readFileSync(path.resolve(__dirname, 'cert/192.168.0.1-key.pem')),
        cert: fs.readFileSync(path.resolve(__dirname, 'cert/192.168.0.1.pem')),
      },
      hmr: {
        protocol: 'wss',
        host: env.VITE_DEV_HOST, // lấy từ .env
        port: 5173,
      },
      allowedHosts: [
        'localhost',
        env.VITE_DEV_HOST,
      ],
    },

    plugins: [
      laravel({
        input: ['resources/js/app.jsx'],
        refresh: true,
      }),
      react(),
    ],

    resolve: {
      alias: {
        '@': '/resources/js',
      },
    },

    build: {
      outDir: 'public/build',
      manifest: true,
      rollupOptions: {
        input: 'resources/js/app.jsx',
      },
    },
  };
});