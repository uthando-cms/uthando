<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Exception;
use Application\Event\MvcListener;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;

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
        
        $eventManager->attach(new MvcListener());
        
        $this->setPhpSettings($event);
        $this->startSession($event);
    }
    
    public function setPhpSettings(MvcEvent $event)
    {
    	$config = $event->getApplication()->getConfig();
    	 
    	if (isset($config['php_settings'])) {
    		foreach ($config['php_settings'] as $key => $value) {
    			ini_set($key, $value);
    		}
    	}
    }
    
    public function startSession(MvcEvent $event)
    {
    	try {
    		$session = $event->getApplication()
    			->getServiceManager()
    			->get('Application\SessionManager');
    		$session->start();
    		 
    		$container = new Container();
    
    		if (!isset($container->init)) {
    			$session->regenerateId(true);
    			$container->init = 1;
    		}
    	} catch (Exception $e) {
    		echo '<pre>';
    		echo $e->getMessage();
    		echo '</pre';
    		exit();
    	}
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfig()
    {
    	return include __DIR__ . '/config/service.config.php';
    }
    
    public function getViewHelperConfig()
    {
        return include __DIR__ . '/config/viewHelper.config.php';
    }
    
    public function getControllerConfig()
    {
        return include __DIR__ . '/config/controller.config.php';
    }

	public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php'
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
