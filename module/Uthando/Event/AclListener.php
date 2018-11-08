<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\Event
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */
 
declare(strict_types=1);

namespace Uthando\Event;


use Zend\EventManager\Event;
use Zend\View\Renderer\PhpRenderer;

class AclListener
{
    /**
     * @param Event $event
     * @return bool
     */
    public static function accept(Event $event): bool
    {
        $event->stopPropagation();

        /** @var PhpRenderer $view */
        $viewHelper = $event->getTarget();
        $view       = $viewHelper->getView();
        $identity   = $view->identity();
        $params     = $event->getParams();
        $page       = $params['page'];
        $permission = $page->getPermission();

        if (('@' === $permission && !$identity) || ('*' === $permission && $identity)) {
            return false;
        }

        return true;
    }
}