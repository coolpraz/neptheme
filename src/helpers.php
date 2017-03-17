<?php

use App\Themes;

if ( ! function_exists('np_theme'))
{
    /**
     * Get the theme instance.
     *
     * @param  string  $themeName
     * @param  string  $layoutName
     * @return \Teepluss\Theme\Theme
     */
    function np_theme($view = null, $data = [], $mergeData = [])
    {
        $theme = app('neptheme.themes');

        if (func_num_args() === 0) {
            return $theme;
        }

        return $theme->render($view, $data, $mergeData);
    }
}