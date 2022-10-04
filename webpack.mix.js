const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
mix.options({
    processCssUrls: false,
});

// Tailwind
mix.sass('resources/css/tailwind.scss', 'public/assets/css').options({
    processCssUrls: false,
    postCss: [tailwindcss('./tailwind.config.js')],
});

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

mix.js('resources/js/app.js', 'public/assets/js')
    .sass('resources/sass/app.scss', 'public/assets/css')
    .sourceMaps();

/**
 * Script
 *
 */ 
mix.copy('resources/js/shortcut.js', 'public/assets/js/shortcut.js');

/**
 * Themes
 * 
 */
mix.copyDirectory('resources/themes/sneat/dist', 'public/assets/themes/sneat');
mix.copyDirectory('resources/themes/sneat/assets/img', 'public/assets/themes/sneat/img');
mix.sass('resources/themes/sneat/assets/css/siaji.scss', 'public/assets/themes/sneat/css/siaji.css').version()
mix.js('resources/themes/sneat/assets/js/main.js', 'public/assets/themes/sneat/js/main.js').version();
mix.js('resources/themes/sneat/assets/js/config.js', 'public/assets/themes/sneat/js/config.js').version();

/**
 * Plugins
 * 
 */
// Lightbox
mix.js('resources/js/plugins/fslightbox/script.js', 'public/assets/plugins/fslightbox/fslightbox.js').version();
// Flatpickr
mix.js('resources/js/plugins/flatpickr/script.js', 'public/assets/plugins/flatpickr/flatpickr.min.js').version();
mix.copy('node_modules/flatpickr/dist/flatpickr.min.css', 'public/assets/plugins/flatpickr/flatpickr.min.css').version();
// Choices Js
mix.copy('node_modules/choices.js/public/assets/scripts/choices.min.js', 'public/assets/plugins/choices.js/choices.min.js').version();
mix.copy('node_modules/choices.js/public/assets/styles/base.min.css', 'public/assets/plugins/choices.js/base.min.css').version();
mix.copy('node_modules/choices.js/public/assets/styles/choices.min.css', 'public/assets/plugins/choices.js/choices.min.css').version();
// Imask
mix.js('resources/js/plugins/imask/script.js', 'public/assets/plugins/imask/imask.js').version();