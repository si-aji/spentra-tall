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
mix.copy('resources/js/siaji.js', 'public/assets/js/siaji.js');
mix.copy('resources/js/format-record.js', 'public/assets/js/format-record.js');
mix.js('resources/js/serviceWorker.js', 'public');

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
// jQuery
mix.js('resources/js/plugins/jquery/jquery.js', 'public/assets/plugins/jquery').version();
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
// Datatable
mix.copy('node_modules/datatables.net-dt/css/jquery.dataTables.css', 'public/assets/plugins/datatable/css');
mix.copy('node_modules/datatables.net-dt/images', 'public/assets/plugins/datatable/images');
mix.copy('node_modules/datatables.net/js/jquery.dataTables.js', 'public/assets/plugins/datatable/datatable.js');
mix.copy('node_modules/datatables.net-responsive/js/dataTables.responsive.js', 'public/assets/plugins/datatable');
mix.copy('node_modules/datatables.net-responsive/js/dataTables.responsive.js', 'public/assets/plugins/datatable');
mix.copy('node_modules/datatables.net-plugins/pagination', 'public/assets/plugins/datatable/plugins/pagination');
mix.copy('resources/js/plugins/datatable/datatable-loadmore.js', 'public/assets/plugins/datatable/plugins/loadmore');
mix.copy('node_modules/jquery-datatables-checkboxes/css/dataTables.checkboxes.css', 'public/assets/plugins/datatable/plugins/checkbox/css');
mix.copy('node_modules/jquery-datatables-checkboxes/js/dataTables.checkboxes.min.js', 'public/assets/plugins/datatable/plugins/checkbox/js');
mix.copy('node_modules/datatables.net-select/js/dataTables.select.min.js', 'public/assets/plugins/datatable/plugins/select');
// mix.js('resources/assets/plugins/datatable/datatable.js', 'public/assets/plugins/datatable');
// Sweetalert2
mix.copy('node_modules/sweetalert2/dist/sweetalert2.min.css', 'public/assets/plugins/sweetalert2/sweetalert2.min.css').version();
mix.copy('node_modules/sweetalert2/dist/sweetalert2.all.min.js', 'public/assets/plugins/sweetalert2/sweetalert2.all.min.js').version();
// Nestable
mix.copy('node_modules/nestablejs/dist/nestable.css', 'public/assets/plugins/nestable/nestable.css').version();
// mix.copy('node_modules/nestablejs/dist/nestable.js', 'public/assets/plugins/nestable/nestable.js').version();
// mix.js('node_modules/nestablejs/src/index.js', 'public/assets/plugins/nestable/nestable.js').version();
mix.js('resources/js/plugins/nestable/script.js', 'public/assets/plugins/nestable/nestable.js').version();
// Moment JS
mix.copy('node_modules/moment/dist/locale', 'public/assets/plugins/moment/locale');
mix.copy('node_modules/moment/min/moment.min.js', 'public/assets/plugins/moment');
// Clipboard
mix.copy('node_modules/clipboard/dist/clipboard.min.js', 'public/assets/plugins/clipboard/').version();