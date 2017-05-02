<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 01/05/2017
 * Time: 23:20
 */

use Corporatte\Environment\Environment;
use Corporatte\Core\Application;

if (!function_exists('app')) {

    function app()
    {
        return Application::application();
    }
}

if (!function_exists('base_path')) {

    function basepath($path = null)
    {
        $appPath = (app()->make('app_path')) ?? __DIR__ . DIRECTORY_SEPARATOR . "../..";

        if (!is_null($path)) {
            return $appPath . DIRECTORY_SEPARATOR . $path;
        }

        return $appPath . DIRECTORY_SEPARATOR;
    }

}

if (!function_exists('env')) {

    function env($key, $value)
    {
        return Environment::getEnv($key, $value);
    }
}
