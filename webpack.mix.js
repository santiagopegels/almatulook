const mix = require('laravel-mix');
const webpack = require('webpack');
const shoudlAnalyze = process.argv.includes('--analyze')

mix.webpackConfig({
    plugins: [
        new webpack.ContextReplacementPlugin(/moment[\/\\]locale$/, /es-us/),
    ],
    resolve: {
        alias: {
            "@ant-design/icons/lib/dist$": path.resolve(__dirname, "./resources/js/icons.js")
        }
    }
});

mix.babelConfig({
    plugins: ['@babel/plugin-syntax-dynamic-import'],
});


if (shoudlAnalyze) {
    require('laravel-mix-bundle-analyzer');
    mix.bundleAnalyzer({
        analyzerPort: 8918,
    });
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
    })
    .version();


