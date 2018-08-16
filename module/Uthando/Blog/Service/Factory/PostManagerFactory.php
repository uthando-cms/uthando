<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Blog\Service\Factory
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Uthando\Blog\Service\Factory;


use Uthando\Blog\Service\PostManager;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

final class PostManagerFactory implements FactoryInterface
{
    /**
     * Create Post Manager service
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return PostManager
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): PostManager
    {
        $entityManager = $container->get(EntityManager::class);

        return new PostManager($entityManager);
    }
}