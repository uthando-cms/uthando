<?php
namespace Application\Event;

use Exception;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Http\Request;
use Zend\Mvc\Application as MvcApplication;
use Zend\Mvc\MvcEvent;

class MvcListener implements ListenerAggregateInterface
{
    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();

    /**
     * {@inheritDoc}
     */
    public function attach(EventManagerInterface $events)
    {
		$this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, array($this, 'requireSsl'), -10000);
    }

    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }
    
    public function requireSsl(MvcEvent $event)
    {
    	$config = $event->getApplication()->getConfig();
    	
    	if (false === $config['application']['ssl']) {
    		return;
    	}
    	
        $request = $event->getRequest();
        
        if (!$request instanceof Request) {
        	return;
        }
        
        if ($event->isError() && $event->getError() === MvcApplication::ERROR_ROUTER_NO_MATCH) {
        	// No matched route has been found - don't do anything
        	return;
        }
    
    	$match          = $event->getRouteMatch();
    	$params         = $match->getParams();
    	
    	/**
    	 * If we have a route tht defines 'force-ssl' prefer that instruction above
    	 * anything else and redirect if appropriate
    	 *
    	 * Possible values of 'force-ssl' param are:
    	 *   'ssl'      : Force SSL
    	 *   'http'     : Force Non-SSL
    	 */
    	if (isset($params['force-ssl'])) {
    		$force    = strtolower($params['force-ssl']);
    		$response = $event->getResponse();
    		$uri      = $request->getUri();
    		
    		if ('ssl' === $force && 'http' === $uri->getScheme()) {
    		    $uri->setScheme('https');
    		    return self::redirect($uri, $response);
    		}
    		
    		if ('http' === $force && 'https' === $uri->getScheme()) {
    			$uri->setScheme('http');
    			return self::redirect($uri, $response);
    		}
    	}
    	
    	return;
    }
    
    private function redirect($uri, $response)
    {
        $response->getHeaders()->addHeaderLine('Location', $uri->toString());
        $response->setStatusCode(302);
         
        return $response;
    }
}
