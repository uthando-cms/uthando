<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

declare(strict_types=1);

namespace Uthando;

use Uthando\Event\AclListener;
use Uthando\Event\ConfigListener;
use Uthando\Event\OnDispatchListener;
use Uthando\Event\OnRouteListener;
use Zend\ModuleManager\ModuleEvent;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\MvcEvent;
use Zend\View\Helper\Navigation\AbstractHelper as NavigationHelper;

class Module
{
    public function init(ModuleManager $moduleManager)
    {
        $events = $moduleManager->getEventManager();
        $events->attach(
            ModuleEvent::EVENT_MERGE_CONFIG,
            [ConfigListener::class, 'onMergeConfig'],
            1
        );
    }

    public function onBootstrap(MvcEvent $event)
    {
        $application        = $event->getApplication();
        $eventManager       = $application->getEventManager();
        $onRouteListener    = new OnRouteListener();
        $onDispatchListener = new OnDispatchListener();

        $onRouteListener->attach($eventManager);
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