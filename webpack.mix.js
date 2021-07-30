const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .scripts([
        'public/plugins/jquery/jquery.js',
        'public/plugins/bootstrap/js/bootstrap.js',
        'resources/js/adminlte.min.js',
    ], 'public/js/all.min.js')
    .styles(['resources/css/adminlte.min.css', 'resources/css/fontawesome.min.css'], 'public/css/all.min.css')
    .sourceMaps();
