<?php 

namespace Coolpraz\NepTheme\Facades;

class Theme extends Facade
{
	/**
	 * Get the registered name of the component.
	 * 
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'neptheme.themes';
	}
}