const mix = require('laravel-mix');
const shoudlAnalyze = process.argv.includes('--analyze')


if (shoudlAnalyze) {
    require('laravel-mix-bundle-analyzer');
    mix.bundleAnalyzer();
}
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
    .sass('resources/sass/app.scss', 'public/css/admin')
    .less('resources/less/app.less', 'public/css/public', {
        lessOptions: {
            javascriptEnabled: true
        }
    });


