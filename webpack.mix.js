const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Compile your JS and Sass/CSS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')   // JS input -> output
   .sass('resources/sass/app.scss', 'public/css') // SASS input -> output
   .version(); // optional: cache busting

// Enable source maps for dev
if (!mix.inProduction()) {
    mix.sourceMaps();
}
