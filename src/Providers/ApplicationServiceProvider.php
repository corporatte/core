<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 02/05/2017
 * Time: 00:14
 */

namespace Corpotatte\Core\Providers;

use Corporatte\Core\Providers\ServiceProvider;


/**
 * Class ApplicationServiceProvider
 * @package jjsquady\Providers
 */
class ApplicationServiceProvider extends ServiceProvider
{

    /**
     * Register Provider dependencies and others
     */
    public function register()
    {
        $this->loadConfigurations();

        // This is a simple echo when application load OK
        // You can remove it
        //echo "APPLICATION STARTED! (ApplicationServiceProvider::register loaded)";
    }

    /**
     * Loads all file configurations in config folder
     */
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