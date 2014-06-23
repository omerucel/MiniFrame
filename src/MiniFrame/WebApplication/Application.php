<?php

namespace MiniFrame\WebApplication;

use MiniFrame\BaseApplication;
use MiniFrame\Di\IDi;

class Application extends BaseApplication
{
    /**
     * @var array
     */
    protected $modules;

    /**
     * @param IDi $dependencyInjection
     */
    public function __construct(IDi $dependencyInjection)
    {
        parent::__construct($dependencyInjection);
        $this->modules = array();
    }

    public function serve()
    {
        /**
         * @var Module $module
         * @var Router $router
         */
        $router = $this->getDi()->get('router');
        $route = $router->getCurrentRoute();
        if ($route == null) {
            $controllerClass = $this->getDi()->getConfigs()->web_application->default_not_found_controller;
            $route = new Route('/default-route', $controllerClass);
        }

        $module = $this->discoverModule($route->getControllerClass());
        $this->getDi()->set('current_module', $module);
        $module->dispatch($route->getControllerClass(), $route->getRequestMethod(), $route->getParams());
    }

    /**
     * Verilen kontrol sınıfının modülünü bulur.
     *
     * @param  string $controllerClass
     * @return Module
     */
    public function discoverModule($controllerClass)
    {
        $packages = explode('\\', $controllerClass);
        array_pop($packages);
        $moduleClass = implode('\\', $packages);

        // Daha önce yüklenmişse ilgili objeyi dön yoksa oluştur.
        $init = false;
        if (!isset($this->modules[$moduleClass])) {
            $this->modules[$moduleClass] = new $moduleClass($this->getDi());
            $init = true;
        }

        /**
         * @var Module $module
         */
        $module = $this->modules[$moduleClass];
        $module->registerErrorHandlers();
        if ($init) {
            $module->init();
        }

        return $module;
    }
}
