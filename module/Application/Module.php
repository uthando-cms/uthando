<?php

namespace Application;

use Exception;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $event)
    {
        $app                 = $event->getApplication();
        $eventManager        = $app->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $sharedEventManager  = $eventManager->getSharedManager();
        $config              = $app->getConfig();
        
        $this->setPhpSettings($config);
    }
    
    public function setPhpSettings($config)
    {
        if (isset($config['php_settings'])) {
            foreach ($config['php_settings'] as $key => $value) {
                ini_set($key, $value);
            }
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getControllerConfig()
    {
        return include __DIR__ . '/config/controller.config.php';
    }

	public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\ClassMapAutoloader' => [
                __DIR__ . '/autoload_classmap.php'
            ],
        ];
    }
}
