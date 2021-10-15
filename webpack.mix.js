const mix = require('laravel-mix');

let outputDir = 'resources/assets/dist';

outputDir = './../../../laravel-path/latus-project/latus-project/public/assets/vendor/latusprojects/latus-base-plugin'

mix.setPublicPath(outputDir);

mix.js('resources/assets/js/content-tools.js', 'ContentTools/content-tools.js')
    .sass('resources/assets/css/content-tools.scss', 'ContentTools/content-tools.css', {
        // Rewrite CSS urls for app.scss
        processUrls: false,
    })
    .copyDirectory('node_modules/ContentTools/build/images', outputDir + '/ContentTools/images');

if (mix.inProduction()) {
    mix.version();
}