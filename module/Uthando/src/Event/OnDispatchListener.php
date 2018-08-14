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


use Uthando\User\Service\AuthenticationManager;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;

class OnDispatchListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    /**
     * Attach one or more listeners
     *
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param EventManagerInterface $events
     * @param int $priority
     * @return void
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            MvcEvent::EVENT_DISPATCH,
            [$this, 'accessFilter'],
            100000
        );
    }

    /**
     * @param MvcEvent $event
     * @return bool|Response
     * @throws \Exception
     */
    public function accessFilter(MvcEvent $event)
    {
        if (!$event->getRequest() instanceof Request) {
            return true;
        }

        // Get controller and action to which the HTTP request was dispatched.
        $application    = $event->getApplication();
        $serviceManager = $application->getServiceManager();
        /** @var Request $request */
        $request        = $application->getRequest();
        $match          = $event->getRouteMatch();
        $controllerName = $match->getParam('controller');
        $actionName     = $match->getParam('action');
        /** @var AuthenticationManager $authManager */
        $authManager    = $serviceManager->get(AuthenticationManager::class);

        // Execute the access filter on every controller except AuthController
        // (to avoid infinite redirect).
        if (!$authManager->filterAccess($controllerName, $actionName)) {

            // Remember the URL of the page the user tried to access. We will
            // redirect the user to that URL after successful login.
            $uri = $request->getUri();
            // Make the URL relative (remove scheme, user info, host name and port)
            // to avoid redirecting to other domain by a malicious user.
            $uri->setScheme(null)
                ->setHost(null)
                ->setPort(null)
                ->setUserInfo(null);

            /** @var Response $response */
            $response               = $event->getResponse();
            $session                = $serviceManager->get('UthandoDefault');
            $session->redirectUrl   = $uri->toString();
            $router                 = $event->getRouter();
            $url                    = $router->assemble([], ['name' => 'login']);
            
            //redirect to login route...
            // change with header('location: '.$url); if code below not working
            $response->setStatusCode(302);
            $response->getHeaders()->addHeaderLine('Location', $url);
            $event->stopPropagation();

            return $response;
        }

        return true;
    }
}