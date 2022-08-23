const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/}));

const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/app.js', 'public/js/taskmanager.js')
    .vue()
    .postCss(__dirname + '/Resources/assets/css/app.css', 'public/css/taskmanager.css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
    ])
    .alias({
        '@taskmanager': __dirname + '/Resources/assets/js',
    });

if (mix.inProduction()) {
    mix.version();
}
