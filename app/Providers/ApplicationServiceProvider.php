<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 02/05/2017
 * Time: 00:14
 */

namespace jjsquady\Providers;


class ApplicationServiceProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        $this->loadConfigurations();

        // This is a simple echo when application load OK
        // You can remove it, and return that what you want
        echo "APPLICATION STARTED! (ApplicationServiceProvider::register loaded)";
    }

    public function provides()
    {

    }

    private function loadConfigurations()
    {
        $configFiles = scandir(basepath('config'));

        foreach ($configFiles as $configFile) {
            $configName = pathinfo($configFile);
            if ($configName['extension'] == 'php') {
                $this->app->loadConfig($configName['filename']);
            }
        }
    }

}