let mix = require('laravel-mix');

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css/bootstrap.css')
   .styles('resources/assets/css/app.css', 'public/css/app.css');
