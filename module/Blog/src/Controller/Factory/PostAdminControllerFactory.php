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
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use Interop\Container\ContainerInterface;
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
        /** @var PostRepository $postRepository */
        $postRepository = $entityManager->getRepository(PostEntity::class);
        $postManager    = $container->get(PostManager::class);
        /** @var AnnotationBuilder $builder */
        $builder        = $container->get(AnnotationBuilder::class);
        $form           = $builder->createForm(PostEntity::class);

        $form->setHydrator(new DoctrineObject($entityManager));

        return new PostAdminController($postRepository, $postManager, $form);
    }
}