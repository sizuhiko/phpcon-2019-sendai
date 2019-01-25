const mix = require('laravel-mix');

mix
  .js('src/assets/app.js', 'src/public/js')
  .copy('node_modules/@webcomponents', 'src/public/js/@webcomponents')
  .setPublicPath('src/public');
