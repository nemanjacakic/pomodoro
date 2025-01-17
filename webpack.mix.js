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

mix
  .js("resources/js/app.js", "public/js")
  .copy("node_modules/tinymce/skins", "public/js/skins")
  .sass('resources/sass/app.scss', 'public/css');

  mix
  .js("resources/js/service-worker.js", "public")

  mix
  .copy("resources/audio/", "public/audio")

/* global path */

mix.webpackConfig({
  resolve: {
    alias: {
      "~": path.resolve(__dirname, "resources/js")
    }
  }
});
