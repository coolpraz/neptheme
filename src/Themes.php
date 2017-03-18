<?php 

namespace Coolpraz\NepTheme;

use Illuminate\View\FileViewFinder;

class Themes
{
	protected $themesPath;
	protected $themesDefault;
	protected $assetsPath;

	public function __construct()
	{
		$this->themesPath = config('themes.themePath');
		$this->themesDefault = config('themes.themeDefault');
		$this->assetsPath = "$this->themesPath/$this->themesDefault/assets/";
	}

	public function exists($theme)
	{
		$path = $this->themePath . '/' . $theme . '/views/';
		return is_dir($path);
	}

	public function render($view = null, $data = [], $mergeData = [])
	{
		$this->setThemePath($this->getPath());

		return view($view, $data, $mergeData);
	}

	public function getTheme()
	{
		return $this->themesDefault;
	}

	public function setTheme($themeName = null)
	{
		if ($themeName == null) {
			return $this->themesDefault;
		}

		if (! $this->exists($themeName)) {
			throw new ThemeNotFoundException("Theme [$themeName] not found");
		}

		config()->set('themes.themeDefault', $themeName);

		$this->themesDefault = $themeName;

		return $this;
	}

	public function setAssetsPath($path = null)
	{
		if (! $path) {
			return $this->assetsPath;
		}

		$this->assetsPath = "$this->themesPath/$this->themesDefault/$path/";

		return $this;
	}

	public function getAssetsPath()
	{
		return $this->assetsPath;
	}

	public function assets($assets = null)
	{
		// return default assets path if argument is null
		if (! $assets) {
			return $this->getAssetsPath();
		}
		// return custom assets path provided in argument
		return $this->getAssetsPath() . "$assets";
		
	}

	public function url($path = null)
	{
		// return default url path if argument is null
		// return custom url path provided in argument
	}

	public function setThemePath($path)
	{
		$finder = new FileViewFinder(app('files'), [$path]);
		view()->setFinder($finder);
	}

	public function setPath($path = null)
	{
		if ($path == null) {
			return $this->themesPath;
		}

		if (! $this->exists($path)) {
			throw new ThemeNotFoundException("Theme [$path] not found");
		}

		config()->set('themes.themePath', $path);

		$this->themesDefault = $themeName;

		return $this;
	}

	public function getPath()
	{
		return "$this->themesPath/$this->themesDefault/views";
	}

}