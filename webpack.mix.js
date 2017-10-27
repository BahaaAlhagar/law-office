let mix = require('laravel-mix');

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

mix.js('resources/assets/js/managePeople.js', 'public/js')
	.js('resources/assets/js/manageContracts.js', 'public/js')
	.js('resources/assets/js/manageIssues.js', 'public/js')
	.js('resources/assets/js/manageTodos.js', 'public/js')
	.js('resources/assets/js/personProfile.js', 'public/js')
	.js('resources/assets/js/issueProfile.js', 'public/js')
	.js('resources/assets/js/personFiles.js', 'public/js')
	.js('resources/assets/js/personIssues.js', 'public/js')
	.js('resources/assets/js/listMeetings.js', 'public/js')
	.js('resources/assets/js/listRecords.js', 'public/js')
	.js('resources/assets/js/contractProfile.js', 'public/js')
	.extract(['vue', 'bootstrap', 'toastr', 'dropzone', 'jquery']);
