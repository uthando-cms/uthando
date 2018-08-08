<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   User\Controller\Factory
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace User\Controller\Factory;


use Interop\Container\ContainerInterface;
use User\Controller\UserController;
use Zend\ServiceManager\Factory\FactoryInterface;

final class UserControllerFactory implements FactoryInterface
{

    /**
     * Create an user controller object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return UserController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): UserController
    {
        return new UserController();
    }
}