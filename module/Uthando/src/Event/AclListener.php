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

class AclListener
{
    public function accept(Event $event)
    {
        $event->stopPropagation();

        $accepted = true;

        /*$rbacService = new RbacService();
        $rbac = $rbacService->getRbac();*/

        $params = $event->getParams();
        $page   = $params['page'];

        $permission = $page->getPermission();

        if ($permission) {
            //$accepted = $rbac->isGranted('member', $permission);
        }

        return $accepted;
    }
}