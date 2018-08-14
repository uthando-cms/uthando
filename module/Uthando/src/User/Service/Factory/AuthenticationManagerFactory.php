<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\User\Service\Factory
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Uthando\User\Service\Factory;


use Interop\Container\ContainerInterface;
use Uthando\User\Service\AuthenticationManager;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Session\SessionManager;

class AuthenticationManagerFactory implements FactoryInterface
{

    /**
     * Create an auth manager object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return AuthenticationManager
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): AuthenticationManager
    {
        $authenticationService  = $container->get(AuthenticationService::class);
        $sessionManger          = $container->get(SessionManager::class);
        $config                 = $container->get('config')['uthando']['uthando_core']['access_filter'];
        return new AuthenticationManager($authenticationService, $sessionManger, $config);
    }
}