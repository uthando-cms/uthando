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


use Blog\Controller\PostController;
use Blog\Entity\CommentEntity;
use Blog\Entity\PostEntity;
use Blog\Service\PostManager;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

final class PostControllerFactory implements FactoryInterface
{
    /**
     * Create PostController
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return PostController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): PostController
    {
        $entityManager  = $container->get(EntityManager::class);
        $postRepository = $entityManager->getRepository(PostEntity::class);
        $postManager    = $container->get(PostManager::class);
        $builder        = new AnnotationBuilder($entityManager);
        $form           = $builder->createForm(CommentEntity::class);

        $form->setHydrator(new DoctrineObject($entityManager));


        // Instantiate the controller and inject dependencies
        return new PostController($postRepository, $postManager, $form);
    }
}