let mix = require('laravel-mix');

// mix.js('resources/assets/js/app.js', 'public/js')
//    .sass('resources/assets/sass/app.scss', 'public/css/bootstrap.css')
//    .styles('resources/assets/css/app.css', 'public/css/app.css');

// SDK specific
// mix.js([
//         'resources/assets/js/sdk/Video.js',
//         'resources/assets/js/video.js'
//     ], 'public/public/sdk/video.1.0.min.js')
//     .sass('resources/assets/sass/sdk/video.scss', 'public/public/sdk');

mix.js([
        'resources/assets/js/sdk/Chat.js',
        'resources/assets/js/chat.js'
    ], 'public/public/sdk/chat.1.0.min.js');
