<?php 

namespace Coolpraz\NepTheme;

class Themes
{
	protected $themesPath;
	protected $themesDefault;

	public function __construct()
	{
		$this->themesPath = config('themes.themePath');
		$this->themesDefault = config('themes.themeDefault');
	}

	public function render($view = null, $data = [], $mergeData = [])
	{
		$this->setThemePath($this->getPath());

		return view($view, $data, $mergeData);
	}

	public function setThemePath($path)
	{
		$finder = new \Illuminate\View\FileViewFinder(app('files'), [$path]);
		view()->setFinder($finder);
	}

	public function getPath()
	{
		return "$this->themesPath/$this->themesDefault/views";
	}

}