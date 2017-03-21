<?php

if ( ! function_exists('np_theme'))
{
    function np_theme($view = null, $data = [], $mergeData = [])
    {
        $theme = app('neptheme.themes');

        if (func_num_args() === 0) {
            return $theme;
        }

        return $theme->render($view, $data, $mergeData);
    }
}

if ( ! function_exists('np_assets'))
{
    function np_assets($assets, $path = null)
    {
        $theme = app('neptheme.themes');

        if ($path) {
            return $theme->setAssetsPath($path)->assets($assets);
        }

        return $theme->assets($assets);
    }
}