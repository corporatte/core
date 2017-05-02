<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 01/05/2017
 * Time: 23:26
 */

namespace jjsquady\Contracts;


interface Application
{
    public static function create();

    public static function application(): Application;

    public function register();

    public function singleton($key, $callback);

    public function bind($key, $callback);

    public function make($key);

    public function loadConfig($configName);
}