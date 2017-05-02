<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 01/05/2017
 * Time: 23:06
 */
use Application\Main;
use jjsquady\Application;

require 'vendor/autoload.php';

$app = Application::create();

$app->register();

Main::init();

return $app->end();
