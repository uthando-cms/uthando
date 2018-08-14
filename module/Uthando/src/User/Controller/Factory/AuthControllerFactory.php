<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\User\Controller\Factory
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Uthando\User\Controller\Factory;


use Interop\Container\ContainerInterface;
use Uthando\User\Controller\AuthController;
use Uthando\User\Service\AuthenticationManager;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\ServiceManager\Factory\FactoryInterface;

class AuthControllerFactory implements FactoryInterface
{

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return mixed
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $authenticationManager  = $container->get(AuthenticationManager::class);
        $builder                = $container->get(AnnotationBuilder::class);
        $sessionContainer       = $container->get('UthandoDefault');

        return new AuthController($authenticationManager, $builder, $sessionContainer);
    }
}