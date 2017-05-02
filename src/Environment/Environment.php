<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 02/05/2017
 * Time: 00:27
 */

namespace Corporatte\Core\Environment;


use Corporatte\Core\Environment\Contracts\Environment as EnvironmentContract;

/**
 * Class Environment
 * @package Corporatte\Core\Environment
 */
final class Environment implements EnvironmentContract
{

    /**
     * @var
     */
    protected static $instance;

    /**
     * @var array
     */
    protected static $enviroment = [];

    /**
     * @param $envFile
     * @throws \Exception
     */
    public static function load($envFile)
    {
        if (! file_exists($envFile)) {
            throw new \Exception("Enviroment file: `$envFile` not found.");
        }

        $envArray = array_filter(explode("\n", trim(file_get_contents($envFile))));

        foreach ($envArray as $pair) {

            $envVars = preg_split("/ ?= ?/", trim($pair));

            if (empty($envVars[0]) || count($envVars) != 2) {
                throw new \Exception("Failed to set a Enviroment setting. Check your .env file.");
            }

            Environment::putEnv($envVars[0], $envVars[1]);
        }
    }

    /**
     * @return array
     */
    public static function all()
    {
        return self::$enviroment;
    }

    /**
     * @param $key
     * @param $value
     * @param bool $override
     * @return bool
     */
    public static function putEnv($key, $value, $override = true)
    {
        if (!$override && array_key_exists($key, self::$enviroment)) {
            return false;
        }

        self::$enviroment[$key] = $value;
        return true;
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
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

    /**
     * @param $key
     * @throws \Exception
     */
    private function checkIfEnvExists($key)
    {
        if (!array_key_exists($key, self::$enviroment)) {
            throw new \Exception("Enviroment key `$key` not exists.");
        }
    }
}