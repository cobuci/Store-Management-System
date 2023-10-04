import {defineConfig} from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel([
            "/resources/css/app.css",
            "/resources/js/app.js",
            "/resources/js/chart.js",
            "/resources/js/theme.js",
            'resources/css/app.css',

            "./node_modules/html2canvas/dist/html2canvas.js",
            "./node_modules/feather-icons/dist/feather.min.js",
        ]),
    ],
    resolve: {
        alias: {
            "@js": `/resources/js`,
            "@css": `/resources/css`,
        },
    },
});
