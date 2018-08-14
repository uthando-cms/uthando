<?php declare(strict_types=1);

/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   ${NAMESPACE}
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Uthando;

use Uthando\Event\AclListener;
use Uthando\Event\OnDispatchListener;
use Uthando\Event\OnRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\View\Helper\Navigation\AbstractHelper as NavigationHelper;

class Module
{
    public function onBootstrap(MvcEvent $event)
    {
        $application    = $event->getApplication();
        $eventManager   = $application->getEventManager();

        $onRouteListener = new OnRouteListener();
        $onRouteListener->attach($eventManager);

        $onDispatchListener = new OnDispatchListener();
        $onDispatchListener->attach($eventManager);

        $eventManager->getSharedManager()
            ->attach(
                NavigationHelper::class,
                'isAllowed',
                [AclListener::class, 'accept']
            );
    }

    /**
     *
     * @return array
     */
    public function getConfig() : array
    {
        $provider = new ConfigProvider();
        return $provider();
    }
}