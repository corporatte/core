<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 02/05/2017
 * Time: 00:54
 */

namespace jjsquady\Providers;


use jjsquady\Contracts\Application;
use jjsquady\Contracts\ServiceProvider as ServiceProviderContract;

abstract class ServiceProvider implements ServiceProviderContract
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function boot()
    {
        self::boot();
    }

    public function register()
    {
        self::register();
    }

    public function provides()
    {
        self::provides();
    }

}