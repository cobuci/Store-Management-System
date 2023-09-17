const mix = require('laravel-mix');


if (mix.inProduction()) {
    mix.version();
}
