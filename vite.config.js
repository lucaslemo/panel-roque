import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { viteStaticCopy } from 'vite-plugin-static-copy'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        viteStaticCopy({
            targets: [
                {
                    src: 'resources/assets/favicon',
                    dest: 'assets'
                },
                {
                    src: 'resources/assets/imgs',
                    dest: 'assets'
                },
                {
                    src: 'resources/assets/audios',
                    dest: 'assets'
                },
            ]
        }),
    ],
    server: {
        hmr: {
            host: 'localhost'
        }
    },
    build: {
        chunkSizeWarningLimit: 1024,
    },
});
