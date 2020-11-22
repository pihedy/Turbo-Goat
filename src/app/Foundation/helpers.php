<?php declare(strict_types=1);

use Goat\App;

if (!function_exists('goat')) {
    function goat()
    {
        return App::getInstance();
    }
}

if (!function_exists('msg')) {
    function msg(string $key)
    {

    }
}
