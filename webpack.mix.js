let mix = require('laravel-mix');

// mix.webpackConfig({
//     resolve: {
//         alias: {
//             va: '~vue2-admin-lte/src',
// }
// }
// });

  // mix.autoload({
  //     jquery: ['$', 'window.jQuery',"jQuery","window.$","jquery","window.jquery"]
  // });
mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');

