<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\User\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Uthando\User\Service;


use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Uthando\User\Entity\DTO\AddUser;
use Uthando\User\Entity\DTO\EditUser;
use Uthando\User\Entity\UserEntity;

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
     * @param UserEntity $user
     * @param $inputPassword
     * @return bool
     */
    public static function verifyCredential(UserEntity $user, $inputPassword): bool
    {
        $verified = password_verify($inputPassword, $user->password);

        if (true === $verified && password_needs_rehash($user->password, PASSWORD_DEFAULT)) {
            // rehash password.
        }

        return $verified;
    }

    /**
     * Clears the cache
     *
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     */
    private function clearCache()
    {
        $this->entityManager->clear();
        $cacheDriver = $this->entityManager->getConfiguration()->getResultCacheImpl();
        $cacheDriver->delete('user-tags');
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
        $hydrator       = new DoctrineObject($this->entityManager, false);
        $user           = $hydrator->hydrate($dto->getArrayCopy(), $user);

        // Add the entity to entity manager.
        $this->entityManager->persist($user);

        // Apply changes to database.
        $this->entityManager->flush();
        $this->clearCache();
    }

    /**
     * @param UserEntity $user
     * @param EditUser $dto
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateUser(UserEntity $user, EditUser $dto): void
    {
        $hydrator = new DoctrineObject($this->entityManager, false);
        $hydrator->hydrate($dto->getArrayCopy(), $user);

        // Apply changes to database.
        $this->entityManager->flush();
        $this->clearCache();
    }

    /**
     * @param UserEntity $user
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function removeUser(UserEntity $user): void
    {
        $this->entityManager->remove($user);

        $this->entityManager->flush();
        $this->clearCache();
    }
}