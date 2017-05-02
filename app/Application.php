<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 01/05/2017
 * Time: 23:20
 */

namespace jjsquady;


use jjsquady\Environment\Environment;
use jjsquady\Contracts\Application as ApplicationContract;

final class Application implements ApplicationContract
{
    protected static $instance;

    protected $container = [];

    public static function create()
    {
        self::$instance = new self();

        return self::$instance;
    }

    public static function application(): ApplicationContract
    {
        return self::$instance;
    }

    public function register()
    {
        $this->loadEnvironment();

        $this->registerServiceProviders();

    }

    public function singleton($key, $callback)
    {
        if (isset($this->container[$key])) {
            throw new \Exception("A Singleton instance of `$key` exists in the Container.");
        }

        $this->container[$key] = $callback($this);
    }

    public function bind($key, $callback)
    {
        if (isset($this->container[$key])) {
            throw new \Exception("A Singleton instance of `$key` exists in the Container.");
        }

        $this->container[$key] = $callback;
    }

    public function make($key)
    {
        $this->checkForKey($key);

        return ($this->container[$key] instanceof \Closure) ?
            $this->container[$key]($this) :
            $this->container[$key];
    }

    public function loadConfig($configName)
    {
        $path = basepath('config' . DIRECTORY_SEPARATOR . $configName . '.php');
        if (!file_exists($path)) {
            throw new \Exception("Configuration file `$configName.php` not found.");
        }

        return require_once($path);
    }

    public function end()
    {
        $endStatus = false;

        try {
            unset($this->container);
            self::$instance = null;
            $endStatus = true;

        }catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        } finally {
            return $endStatus;
        }
    }

    private function checkForKey($key)
    {
        if (!array_key_exists($key, $this->container)) {
            throw new \Exception("Key `$key` not exists in Container.");
        }
    }

    private function loadEnvironment()
    {
        Environment::load(basepath('.env'));
    }

    private function registerServiceProviders()
    {
        $appConfig = $this->loadConfig('app');

        $providers = $appConfig['providers'];

        foreach ($providers as $provider) {

            app()->singleton($provider, function () use ($provider) {
                return new $provider($this);
            });

            $instance = app()->make($provider);

            if (method_exists($instance, 'boot')) {
                $instance->boot();
            }

            if (method_exists($instance, 'register')) {
                $instance->register();
            }

            if (method_exists($instance, 'provides')) {
                $instance->provides();
            }

            $instance = null;

        }
    }
}