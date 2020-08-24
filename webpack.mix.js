let mix = require('laravel-mix');

mix.js('resources/assets/js/app.js', 'public/js');
mix.sass('resources/assets/sass/app.scss', 'public/css');
mix.copyDirectory('resources/assets/images', 'public/images');
mix.browserSync('status.localhost');

if (mix.inProduction()) {
    mix.version();
}