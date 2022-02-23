const mix = require('laravel-mix');

let outputDir = 'resources/assets/dist';

outputDir = './../../../laravel-path/leasing-hoping/latus-project/public/assets/vendor/latusprojects/latus-base-plugin';
let larabergOutputDir = './../../../laravel-path/leasing-hoping/latus-project/public/assets/vendor/van-ons/laraberg';
let bootstrapOutputDir = './../../../laravel-path/leasing-hoping/latus-project/public/assets/vendor/bootstrap/bs5';

mix.setPublicPath(outputDir);

mix.js('resources/assets/js/admin.js', 'admin.js')
    .sass('resources/assets/css/admin.scss', 'admin.css', {
        processUrls: false,
    })
    .copyDirectory('vendor/van-ons/laraberg/public', larabergOutputDir);

if (mix.inProduction()) {
    mix.version();
}