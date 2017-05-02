<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 02/05/2017
 * Time: 00:27
 */

namespace jjsquady\Environment;


use jjsquady\Environment\Contracts\Environment as EnvironmentContract;

final class Environment implements EnvironmentContract
{

    protected static $instance;

    protected static $enviroment = [];

    public static function load($envFile)
    {
        if (! file_exists($envFile)) {
            throw new \Exception("Enviroment file: `$envFile` not found.");
        }

        if (file_exists($envFile)) {
            $envArray = array_filter(explode("\n", trim(file_get_contents($envFile))));

            foreach ($envArray as $pair) {

                $envVars = preg_split("/ ?= ?/", trim($pair));

                if (empty($envVars[0]) || count($envVars) != 2) {
                    throw new \Exception("Failed to set a Enviroment setting. Check your .env file.");
                }

                Environment::putEnv($envVars[0], $envVars[1]);
            }
        }
    }

    public static function all()
    {
        return self::$enviroment;
    }

    public static function putEnv($key, $value, $override = true)
    {
        if (!$override && array_key_exists($key, self::$enviroment)) {
            return false;
        }

        self::$enviroment[$key] = $value;
        return true;
    }

    public static function getEnv($key, $default = null)
    {
        if ($default) {
            if (!array_key_exists($key, self::$enviroment)) {
                self::putEnv($key, $default);
            }
        }

        self::checkIfEnvExists($key);

        return self::$enviroment[$key];
    }

    private function checkIfEnvExists($key)
    {
        if (!array_key_exists($key, self::$enviroment)) {
            throw new \Exception("Enviroment key `$key` not exists.");
        }
    }
}