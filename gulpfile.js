'use strict';
const elixir = require('laravel-elixir');

require('laravel-elixir-vue');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

//A Config to point directories, port, the url of the web server w'ere about to use
var config = {
    paths: {
        js: 'app.js',
        sass: ['*.sass', '*/*.sass','*.scss', '*/*.scss', './node_modules/toastr/build/toastr.min.css']
    }
};
elixir(mix => {
    mix.copy('node_modules/bootstrap-sass/assets/fonts/bootstrap','public/fonts/bootstrap');
});
elixir(mix => {
    mix.sass(config.paths.sass)
        .scripts([
            './node_modules/jquery/dist/jquery.min.js',
            './node_modules/toastr/build/toastr.min.js',
        ], 'public/js/vendors.js')
       .webpack(config.paths.js);
});
