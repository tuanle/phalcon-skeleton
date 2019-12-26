const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 */

// Config
mix.setPublicPath('public');

mix.js('resources/assets/admin/js/app.js', 'public/js/admin')
    .sass('resources/assets/admin/sass/app.scss', 'public/css/admin');
