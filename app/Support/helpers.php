<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 01/05/2017
 * Time: 23:20
 */

use jjsquady\Environment\Environment;
use jjsquady\Application;

if (!function_exists('app')) {

    function app()
    {
        return Application::application();
    }
}

if (!function_exists('base_path')) {

    function basepath($path = null)
    {
        if (!is_null($path)) {
            return __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . $path;
        }

        return __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR;
    }

}

if (!function_exists('env')) {

    function env($key, $value)
    {
        return Environment::getEnv($key, $value);
    }
}
