<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 01/05/2017
 * Time: 23:20
 */

namespace Corporatte\Core;


use Corporatte\Environment\Environment;
use Corporatte\Core\Contracts\Application as ApplicationContract;

/**
 * Class Application
 * @package jjsquady
 */
final class Application implements ApplicationContract
{
    /**
     * @var
     */
    protected static $instance;

    /**
     * @var array
     */
    protected $container = [];

    /**
     * @return Application
     */
    public static function create()
    {
        self::$instance = new self();

        return self::$instance;
    }

    /**
     * @return ApplicationContract
     */
    public static function application(): ApplicationContract
    {
        return self::$instance;
    }

    /**
     *
     */
    public function register()
    {
        $this->loadEnvironment();

        $this->registerServiceProviders();

    }

    /**
     * @param $key
     * @param $callback
     * @throws \Exception
     */
    public function singleton($key, $callback)
    {
        if (isset($this->container[$key])) {
            throw new \Exception("A Singleton instance of `$key` exists in the Container.");
        }

        $this->container[$key] = $callback($this);
    }

    /**
     * @param $key
     * @param $callback
     * @throws \Exception
     */
    public function bind($key, $callback)
    {
        if (isset($this->container[$key])) {
            throw new \Exception("A Singleton instance of `$key` exists in the Container.");
        }

        $this->container[$key] = $callback;
    }

    /**
     * @param $key
     * @param null $params
     * @return mixed
     * @throws \Exception
     */
    public function make($key, $params = null)
    {
        if (! $this->checkForKey($key)) {
            return null;
        }

        if (!is_null($params) && !is_array($params)) {
            throw new \Exception('Argument $params needs an array value.');
        }

        return ($this->container[$key] instanceof \Closure) ?
            $this->container[$key]($this, ...$params) :
            $this->container[$key];
    }

    /**
     * @param $configName
     * @return mixed
     * @throws \Exception
     */
    public function loadConfig($configName)
    {
        $path = basepath('config' . DIRECTORY_SEPARATOR . $configName . '.php');
        if (!file_exists($path)) {
            throw new \Exception("Configuration file `$configName.php` not found.");
        }

        return require_once($path);
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function end()
    {
        $endStatus = false;

        try {
            unset($this->container);
            self::$instance = null;
            $endStatus      = true;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        } finally {
            return $endStatus;
        }
    }

    /**
     * @param $key
     * @return mixed
     */
    private function checkForKey($key)
    {
        return array_key_exists($key, $this->container);
    }

    /**
     *
     */
    private function loadEnvironment()
    {
        Environment::load(basepath('.env'));
    }

    /**
     *
     */
    private function registerServiceProviders()
    {
        $appConfig = $this->loadConfig('app');

        $providers = $appConfig['providers'];

        foreach ($providers as $provider) {

            app()->singleton($provider, function () use ($provider) {
                return new $provider($this);
            });

            $instance = app()->make($provider);

            if (is_null($instance)) {
                throw new \Exception("Cannot get instance of null. Do you forget to register the provider?");
            }

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