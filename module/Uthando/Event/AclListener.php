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


use Zend\EventManager\Event;
use Zend\View\Renderer\PhpRenderer;

class AclListener
{
    /**
     * @param Event $event
     * @return bool
     */
    public static function accept(Event $event)
    {
        $event->stopPropagation();

        /*$rbacService = new RbacService();
        $rbac = $rbacService->getRbac();*/

        /** @var PhpRenderer $view */
        $view       = $event->getTarget()->getView();
        $identity   = $view->identity();
        $params     = $event->getParams();
        $page       = $params['page'];
        $permission = $page->getPermission();
        $accepted   = true;

        if ('@' === $permission && !$identity) {
            //$accepted = $rbac->isGranted('member', $permission);
            $accepted = false;
        }

        if ('*' === $permission && $identity) {
            //$accepted = $rbac->isGranted('member', $permission);
            $accepted = false;
        }

        return $accepted;
    }
}