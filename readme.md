TODO

- can use and change(realtime change, permanent change) the theme.
- can render theme.
- can define custom asset path fallback to default assets path.
- can write webpack.mix.js.
- can compile assets.

// check theme exists
	$theme->exists('test')

// for simple from config
	np_theme('anything')

// for dynamic on fly setting theme.
	$theme->setTheme('test1');
	np_theme('index');
	// or
	$theme->render('index');

// for dynamic on fly setting theme and its path.
	$theme->setPath(resource_path())->setTheme('test2');
	np_theme('index');
	// or
	$theme->render('index');

// assets in blade


