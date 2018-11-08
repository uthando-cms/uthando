<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\User\Controller\Factory
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

declare(strict_types=1);

namespace Uthando\User\Controller\Factory;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Interop\Container\ContainerInterface;
use Uthando\Core\Service\Mail;
use Uthando\User\Controller\UserAdminController;
use Uthando\User\Entity\UserEntity;
use Uthando\User\Service\UserManager;
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
        $mailer             = $container->get(Mail::class);
        $builder            = $container->get(AnnotationBuilder::class);
        $entityRepository   = new EntityRepository($entityManager, new ClassMetadata(UserEntity::class));
        $userManager        = new UserManager($entityManager, $mailer);


        return new UserAdminController($entityRepository, $userManager, $builder);
    }
}