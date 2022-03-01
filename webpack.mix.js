const mix = require('laravel-mix');

let outputDir = 'resources/assets/dist';

if (process.env.hasOwnProperty('npm_config_output')) {
    outputDir = process.env.npm_config_output;
}

let vendorOutputDir = outputDir + '/vendor/latusprojects/latus-base-plugin';
let larabergOutputDir = outputDir + '/vendor/van-ons/laraberg';

mix.setPublicPath(vendorOutputDir);

mix.js('resources/assets/js/admin.js', 'admin.js')
    .sass('resources/assets/css/admin.scss', 'admin.css', {
        processUrls: false,
    })
    .copyDirectory('vendor/van-ons/laraberg/public', larabergOutputDir);

if (mix.inProduction()) {
    mix.version();
}