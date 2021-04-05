let mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

mix
    .sass('resources/assets/sass/app.scss', 'public/css')
    .options({
        processCssUrls: false,
        postCss: [ tailwindcss('./tailwind.config.js') ],
    })
    .js('resources/assets/js/app.js', 'public/js');
