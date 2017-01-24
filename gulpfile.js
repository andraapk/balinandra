var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir.config.sourcemaps = false;
elixir(function(mix) {
		mix.sass('web_v2/balin.scss', 'public/css/balin.css')
		.scripts(['jquery.js', 
				'jquery.simple.timer.js',
				'jquery.validate.min.js',
				'bootstrap.min.js',
				'icheck.min.js',
				'inputmask.js',
				'quantity_control.js',
				'checkout_plugin.js',
				'easyzoom.js',
				'clipboard.min.js',
				'jquery.lazy.min.js',
				'all.js',
				], 'public/js/balin.js')
		.version(['public/css/balin.css',
				'public/js/balin.js'])
		.copy('resources/assets/fonts', 'public/build/fonts/')
		.copy('resources/assets/plugins/', 'public/plugins/')
		.copy('resources/assets/images/', 'public/images/');
});