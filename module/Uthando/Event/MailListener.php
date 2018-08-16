<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\Event
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Uthando\Event;

//use Uthando\Core\Service\Mail;
//use Uthando\Core\Service\MailQueue;
use Uthando\Core\Service\ManagerInterface;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class MailListener
 *
 * @package Uthando\Event
 */
class MailListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    /**
     * @param EventManagerInterface $events
     * @param int $priority
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $sharedEvents = $events->getSharedManager();

        $listeners = [
            ManagerInterface::class,
            AbstractActionController::class
        ];

        foreach ($listeners as $listener) {
            $this->listeners[] = $sharedEvents->attach($listener, 'mail.send', [$this, 'onSendMail']);
            $this->listeners[] = $sharedEvents->attach($listener, 'mail.queue', [$this, 'onQueueMail']);
        }
    }

    /**
     * @param Event $event
     */
    public function onSendMail(Event $event)
    {

    }

    /**
     * @param Event $event
     */
    public function onQueueMail(Event $event)
    {

    }
}
