<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\Event
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Uthando\Event;


use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Session\SessionManager;

class OnRouteListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    public function attach(EventManagerInterface $events, $priority = 1): void
    {
        $this->listeners[] = $events->attach(
            MvcEvent::EVENT_ROUTE,
            [$this, 'onStartSession'],
            100
        );

        /*$this->listeners[] = $events->attach(
            MvcEvent::EVENT_ROUTE,
            [$this, 'setTheme']
        );*/
    }

    public function onStartSession(MvcEvent $mvcEvent): void
    {
        if (!$mvcEvent->getRequest() instanceof Request) return;

        $serviceManager = $mvcEvent->getApplication()
            ->getServiceManager();

        $sessionManager = $serviceManager->get(SessionManager::class);

        if (!$sessionManager->isValid()) $sessionManager->destroy();

        $sessionManager->start();
    }
}