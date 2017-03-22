<?php 

namespace Coolpraz\NepTheme;

use Illuminate\View\FileViewFinder;

class Theme
{
	protected $themesPath;
	protected $themesDefault;
	protected $assetsPath;
	protected $publicPath;
	private $beforeDefaultThemeCallback;
	private $beforeDefaultPathCallback;

	public function __construct()
	{
		$this->themesPath = config('theme.themePath');
		$this->themesDefault = config('theme.themeDefault');
		$this->assetsPath = "$this->themesPath/$this->themesDefault/assets";

		$this->publicPath = public_path("np_theme/$this->themesDefault/assets");

		$this->publicAsstesExists();
	}

	public function exists($theme)
	{
		$path = $this->themesPath . '/' . $theme . '/views/';
		return is_dir($path);
	}

	public function publicAsstesExists()
	{
		$fs = new \Symfony\Component\Filesystem\Filesystem();

		if (! $fs->exists($this->publicPath)) {
            $fs->symlink($this->assetsPath, $this->publicPath);
        }
	}

	public function render($view = null, $data = [], $mergeData = [])
	{
		$this->setThemePath($this->getViewPath());

		return view($view, $data, $mergeData);
	}

	public function get()
	{
		return $this->themesDefault;
	}

	public function set($themeName)
	{
		if ($this->beforeDefaultThemeCallback !== null) {
			$callback = $this->beforeDefaultThemeCallback;
			$this->beforeDefaultThemeCallback = null;
			$callback($this);
		}

		if (! $this->exists($themeName)) {
			throw new ThemeNotFoundException("Theme [$themeName] not found");
		}

		$this->themesDefault = $themeName;

		return $this;
	}

	public function getAssetsPath()
	{
		return $this->assetsPath;
	}

	public function setAssetsPath($path = null)
	{
		if (! $path) {
			return $this->assetsPath;
		}

		$this->assetsPath = "$this->themesPath/$this->themesDefault/$path";

		$this->publicAsstesExists();

		return $this;
	}

	public function getAssetsPublicPath()
	{
		return $this->publicPath;
	}

	public function assets($assets)
	{
		$assetPath = ltrim($assets, '/');
		// return default assets path if argument is null
		if (! $assets) {
			return $this->getAssetsPublicPath();
		}
		// return custom assets path provided in argument
		return $this->getAssetsPublicPath() . "/$assetPath";
	}

	public function url($path = null)
	{
		// return default url path if argument is null
		// return custom url path provided in argument
	}

	protected function setThemePath($path)
	{
		$finder = new FileViewFinder(app('files'), [$path]);
		view()->setFinder($finder);
	}

	public function setPath($path)
	{
		if ($this->beforeDefaultPathCallback !== null) {
			$callback = $this->beforeDefaultPathCallback;
			$this->beforeDefaultPathCallback = null;
			$callback($this);
		}
		
		if (! is_dir($path)) {
			throw new ThemeNotFoundException("Theme [$path] not found");
		}

		$this->themesPath = $path;

		return $this;
	}

	public function getPath()
	{
		return $this->themesPath;
	}

	public function getViewPath()
	{
		return "$this->themesPath/$this->themesDefault/views";
	}

	public function beforeDefaultTheme($callback)
	{
		$this->beforeDefaultThemeCallback = $callback;
	}

	public function beforeDefaultPath($callback)
	{
		$this->beforeDefaultPathCallback = $callback;
	}

	public function presist()
	{
		config()->set('theme.themeDefault', $this->themesDefault);
		config()->set('theme.themePath', $this->themesPath);
		$this->assetsPath = "$this->themesPath/$this->themesDefault/assets";

		return $this;
	}

}