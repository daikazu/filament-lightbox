import { defineConfig } from 'vite';


export default defineConfig({
    build: {
        outDir: './resources/dist',
        rollupOptions: {
            input: {
                "filament-lightbox": './resources/js/index.js',
            },
            /*output: {
                entryFileNames: '[name].js',
                chunkFileNames: '[name].js',
                assetFileNames: '[name].[ext]',
            },*/
            output: {
                entryFileNames: '[name].js',
                chunkFileNames: '[name].js',
                assetFileNames: '[name].[ext]',
            },
        }
    },
});
