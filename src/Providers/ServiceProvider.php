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

/**
 * Class ServiceProvider
 * @package jjsquady\Providers
 */
abstract class ServiceProvider implements ServiceProviderContract
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * ServiceProvider constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     *
     */
    public function boot()
    {
        // Overrided
    }

    /**
     *
     */
    public function register()
    {
        // Overrided
    }

    /**
     *
     */
    public function provides()
    {
        // Overrided
    }

}