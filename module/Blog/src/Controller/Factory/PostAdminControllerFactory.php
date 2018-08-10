<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Blog\Controller\Factory
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Blog\Controller\Factory;


use Blog\Controller\PostAdminController;
use Blog\Entity\PostEntity;
use Blog\Repository\PostRepository;
use Blog\Service\PostManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Interop\Container\ContainerInterface;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\ServiceManager\Factory\FactoryInterface;

final class PostAdminControllerFactory implements FactoryInterface
{
    /**
     * Create an post-admin controller
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return PostAdminController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): PostAdminController
    {
        /** @var EntityManager $entityManager */
        $entityManager  = $container->get(EntityManager::class);
        $postRepository = new PostRepository($entityManager, new ClassMetadata(PostEntity::class));
        $postManager    = new PostManager($entityManager);
        $builder        = $container->get(AnnotationBuilder::class);

        return new PostAdminController($postRepository, $postManager, $builder);
    }
}