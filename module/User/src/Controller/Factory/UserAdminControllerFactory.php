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


use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use Interop\Container\ContainerInterface;
use User\Controller\UserAdminController;
use User\Entity\UserEntity;
use User\Service\UserManager;
use Zend\Form\Form;
use Zend\ServiceManager\Factory\FactoryInterface;

final class UserAdminControllerFactory implements FactoryInterface
{

    /**
     * Create an user admin controller
     * @param ContainerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return UserAdminController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): UserAdminController
    {
        /** @var EntityManager $entityManager */
        $entityManager      = $container->get(EntityManager::class);
        $entityRepository   = $entityManager->getRepository(UserEntity::class);
        $userManager        = $container->get(UserManager::class);
        $builder            = new AnnotationBuilder($entityManager);

        /** @var Form $form */
        $form = $builder->createForm(UserEntity::class);

        $form->setHydrator(new DoctrineObject($entityManager));

        return new UserAdminController($entityRepository, $userManager, $form);
    }
}