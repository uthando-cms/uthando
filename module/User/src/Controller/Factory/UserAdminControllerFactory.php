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
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Interop\Container\ContainerInterface;
use User\Controller\UserAdminController;
use User\Entity\UserEntity;
use User\Service\UserManager;
use Zend\Form\Annotation\AnnotationBuilder;
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
        $entityRepository   = new EntityRepository($entityManager, new ClassMetadata(UserEntity::class));
        $userManager        = new UserManager($entityManager);
        $builder            = $container->get(AnnotationBuilder::class);

        return new UserAdminController($entityRepository, $userManager, $builder);
    }
}