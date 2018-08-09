<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   User\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace User\Service;


use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use User\Entity\DTO\AddUser;
use User\Entity\DTO\EditUser;
use User\Entity\UserEntity;

final class UserManager
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param AddUser $dto
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function addUser(AddUser $dto): void
    {
        $user           = new UserEntity();
        $dto->password  = password_hash($dto->password, PASSWORD_DEFAULT);
        $hydrator       = new DoctrineObject($this->entityManager);
        $user           = $hydrator->hydrate($dto->getArrayCopy(), $user);

        // Add the entity to entity manager.
        $this->entityManager->persist($user);

        // Apply changes to database.
        $this->entityManager->flush();
    }

    public function updateUser(UserEntity $user, EditUser $dto): void
    {
        $hydrator = new DoctrineObject($this->entityManager);
        $hydrator->hydrate($dto->getArrayCopy(), $user);

        // Apply changes to database.
        $this->entityManager->flush();
    }
}