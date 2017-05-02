<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 01/05/2017
 * Time: 23:13
 */

namespace jjsquady\ProcessaAnaliticos;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    public function test_if_application_is_istanciable()
    {
        $this->assertInstanceOf(Application::class, Application::create());
    }

    public function test_if_get_the_application_instance()
    {
        Application::create();
        $this->assertInstanceOf(Application::class, Application::application());
    }

    public function test_if_global_function_app_works()
    {
        Application::create();
        $this->assertInstanceOf(Application::class, app());
    }

}
