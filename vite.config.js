import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import path from "path";


export default defineConfig({

    plugins: [
        laravel([
            '/resources/css/app.css',
            '/resources/css/bs.css',
            '/resources/js/app.js',
            '/resources/js/sale_page.js',
            '/resources/js/product_add_page.js',
            '../node_modules/html2canvas/dist/html2canvas.js',
        ]),

    ], resolve: {
        alias: {
            '@': '/resources/js',

        }
    }
});
