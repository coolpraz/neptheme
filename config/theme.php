<?php

return [
	/*
	|--------------------------------------------------------------------------
	| Theme Default
	|--------------------------------------------------------------------------
	|
	| If you don't set a theme when using a "Theme" class the default theme
	| will replace automatically.
	|
	*/

	'themeDefault' => 'default',

	/*
	|--------------------------------------------------------------------------
	| Path to lookup theme
	|--------------------------------------------------------------------------
	|
	| The root path contains themes collections.
	|
	*/

	'themePath' => base_path('opt/themes'),

	/*
	|--------------------------------------------------------------------------
	| A pieces of theme collections
	|--------------------------------------------------------------------------
	|
	| Inside a theme path we need to set up directories to
	| keep "layouts", "assets" and "partials".
	|
	*/

	'containerDir' => [
		'layout' 	=> 'layouts',
		'asset'		=> 'assets',
		'partial' 	=> 'partials',
		'widget' 	=> 'widgets',
		'view' 		=> 'views'
	],

	/*
	|--------------------------------------------------------------------------
	| Namespaces
	|--------------------------------------------------------------------------
	|
	| Class namespace.
	|
	*/

	'namespaces' => [
		'widget' => 'App\Widgets'
	],
];