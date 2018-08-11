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

use Zend\Mvc\MvcEvent;
use Zend\Session\SessionManager;

class Module
{
    public function onBootstrap(MvcEvent $event)
    {
        $application = $event->getApplication();
        $serviceManager = $application->getServiceManager();

        // The following line instantiates the SessionManager and automatically
        // makes the SessionManager the 'default' one.
        $sessionManager = $serviceManager->get(SessionManager::class);
    }

    /**
     *
     * @return array
     */
    public function getConfig() : array
    {
        $provider = new ConfigProvider();
        return [
            'controllers'       => $provider->getControllerConfig(),
            'doctrine'          => $provider->getDoctrineConfig(),
            'navigation'        => $provider->getNavigationConfig(),
            'router'            => $provider->getRouteConfig(),
            'service_manager'   => $provider->getDependencyConfig(),
            'view_helpers'      => $provider->getViewHelperConfig(),
        ];
    }
}