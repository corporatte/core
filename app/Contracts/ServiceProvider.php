<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 01/05/2017
 * Time: 23:50
 */

namespace jjsquady\Contracts;


interface ServiceProvider
{
    public function __construct(Application $app);

    public function boot();

    public function register();

    public function provides();
}