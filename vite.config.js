import {defineConfig} from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel([
            "@css/app.css",
            "@css/bs.css",
            "@js/app.js",
            "@js/chart.js",
            "@js/theme.js",
            "@js/sale_page.js",
            "@js/product_add_page.js",
            "/node_modules/html2canvas/dist/html2canvas.js",
            './node_modules/feather-icons/dist/feather.min.js'
        ]),
    ],
    resolve: {
        alias: {
            "@js": `/resources/js`,
            "@css": `/resources/css`,
        },
    },
});
