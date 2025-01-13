import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
           input: ['public/style/input.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
   build: {
        outDir: 'public/style'
    },
   server: {
        port: 5174,
      }
});
