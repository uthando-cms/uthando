<?php
namespace Application\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\SessionManager;
use Zend\Session\Container;


class SessionManagerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        $config = $sm->get('config');
        
        if (isset($config['session'])) {
        	$session = $config['session'];
        
        	$sessionConfig = null;
        	if (isset($session['config'])) {
        		$class = isset($session['config']['class'])  ? $session['config']['class'] : 'Zend\Session\Config\SessionConfig';
        		$options = isset($session['config']['options']) ? $session['config']['options'] : array();
        		$sessionConfig = new $class();
        		$sessionConfig->setOptions($options);
        	}
        
        	$sessionStorage = null;
        	if (isset($session['storage'])) {
        		$class = $session['storage'];
        		$sessionStorage = new $class();
        	}
        
        	$sessionSaveHandler = null;
        	if (isset($session['save_handler'])) {
        		// class should be fetched from service manager since it will require constructor arguments
        		$sessionSaveHandler = $sm->get($session['save_handler']);
        	}
        
        	$sessionManager = new SessionManager($sessionConfig, $sessionStorage, $sessionSaveHandler);
        
        	if (isset($session['validators'])) {
        		$chain = $sessionManager->getValidatorChain();
        		foreach ($session['validators'] as $validator) {
        			
        			$validator = new $validator();
        			$chain->attach('session.validate', array($validator, 'isValid'));
        		}
        	}
        } else {
        	$sessionManager = new SessionManager();
        }
        
        Container::setDefaultManager($sessionManager);
        
        return $sessionManager;
    }
}
