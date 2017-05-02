<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 02/05/2017
 * Time: 00:25
 */

namespace jjsquady\Environment\Contracts;


/**
 * Interface Enviroment
 * @package jjsquady\Enviroment\Contracts
 */
interface Environment
{
    /**
     * @return array
     */
    public static function all();


    /**
     * @param $envFile
     */
    public static function load($envFile);

    /**
     * @param $key
     * @param $value
     * @param bool $override
     * @return bool
     */
    public static function putEnv($key, $value, $override = true);

    /**
     * @param $key
     * @return mixed
     */
    public static function getEnv($key);
}