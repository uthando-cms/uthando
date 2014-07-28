<?php

namespace Application;

use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\ModuleEvent;
use Zend\ModuleManager\ModuleManager;

class Module
{
    public function init(ModuleManager $moduleManager)
    {
        $eventManager = $moduleManager->getEventManager();
        
        $eventManager->attach(ModuleEvent::EVENT_MERGE_CONFIG, [$this, 'setPhpSettings']);
    }
    
    public function onBootstrap(MvcEvent $event)
    {
        $app                    = $event->getApplication();
        $eventManager           = $app->getEventManager();
        $moduleRouteListener    = $app->getServiceManager()
            ->get('ModuleRouteListener');
        
        $moduleRouteListener->attach($eventManager);
        //$eventManager->attach(MvcEvent::EVENT_ROUTE, [$this, 'setPhpSettings']);
    }

    public function setPhpSettings(ModuleEvent $event)
    {
        // we could have different setting for different route.
        // in this case we would set it up in 'onBootstrap' method
        // and attach it to the MvcEvent::EVENT_ROUTE
        $phpSettings = $event->getConfigListener()
            ->getMergedConfig(true)
            ->get('php_settings');
        
        if ($phpSettings) {
            foreach ($phpSettings as $key => $value) {
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
        return [
            'invokables' => [
                'Application\Controller\Index' => 'Application\Controller\IndexController'
            ],
        ];
    }

    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\ClassMapAutoloader' => [
                __DIR__ . '/autoload_classmap.php'
            ]
        ];
    }
}
