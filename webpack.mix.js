const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.copyDirectory('node_modules/admin-lte/dist', 'public/assets/')
    .copyDirectory('node_modules/admin-lte/plugins', 'public/plugins/')
    .copyDirectory('node_modules/@mdi/font/css', 'public/plugins/mdi/css/')
    .copyDirectory('node_modules/@mdi/font/fonts', 'public/plugins/mdi/fonts/')
    .copyDirectory('node_modules/bootstrap4-toggle', 'public/plugins/bootstrap4-toggle/')
    .copyDirectory('node_modules/fontawesome-iconpicker/dist', 'public/plugins/fontawesome-iconpicker/')
    .copy('resources/src/js/utility.js', 'public/assets/js/utility.js')
    .copy('resources/src/js/pages/invoice.js', 'public/assets/js/pages/invoice.js')
    .css('resources/src/css/utility.css', 'public/assets/css/utility.css')
    .minify('public/assets/js/utility.js')
    .minify('public/assets/js/pages/invoice.js');
