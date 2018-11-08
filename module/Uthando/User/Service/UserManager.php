<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\User\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

declare(strict_types=1);

namespace Uthando\User\Service;


use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Uthando\Core\Service\Mail;
use Uthando\Core\Service\ManagerDoctrineFlushTrait;
use Uthando\User\Entity\DTO\AddUser;
use Uthando\User\Entity\DTO\ChangePassword;
use Uthando\User\Entity\DTO\EditUserInterface;
use Uthando\User\Entity\DTO\SetPassword;
use Uthando\User\Entity\UserEntity;
use Zend\View\Model\ViewModel;

final class UserManager
{
    use ManagerDoctrineFlushTrait;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var Mail
     */
    protected $mailer;

    public function __construct(EntityManager $entityManager, Mail $mailer)
    {
        $this->entityManager = $entityManager;
        $this->mailer        = $mailer;
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
        $hydrator       = new DoctrineObject($this->entityManager, false);
        $user           = $hydrator->hydrate($dto->getArrayCopy(), $user);

        $user->generatePassword($dto->password);

        // Add the entity to entity manager.
        $this->entityManager->persist($user);

        // Apply changes to database.
        $this->flush();
    }

    /**
     * @param UserEntity $user
     * @param EditUserInterface $dto
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateUser(UserEntity $user, EditUserInterface $dto): void
    {
        $hydrator = new DoctrineObject($this->entityManager, false);
        $hydrator->hydrate($dto->getArrayCopy(), $user);

        // Apply changes to database.
        $this->flush();
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
        $this->flush();
    }

    /**
     * @param UserEntity $user
     * @param ChangePassword $dto
     * @return bool
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function changePassword(UserEntity $user, ChangePassword $dto): bool
    {
        if (!UserEntity::verifyPassword($user, $dto->oldPassword)) {
            return false;
        }

        $user->hashPassword($dto->newPassword);

        // Apply changes to database.
        $this->flush();

        return true;
    }

    /**
     * @param UserEntity $user
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function generatePasswordResetToken(UserEntity $user): void
    {
        $token = $user->generateResetToken();

        // Apply changes to database.
        $this->flush();

        $body = new ViewModel([
            'user'  => $user,
            'token' => $token,
        ]);

        $body->setTemplate('email/reset-password');

        $sender     = $this->mailer->getOption('addresses')['default'];
        $from       = $this->mailer->createAddress($sender['address'], $sender['name']);
        $to         = $this->mailer->createAddress($user->email, $user->toFullName());
        $message    = $this->mailer->compose($body)
            ->setTo($to)
            ->setFrom($from)
            ->setSubject('Reset Password');

        $this->mailer->send($message, 'default');
    }

    /**
     * @param UserEntity $user
     * @param SetPassword $dto
     * @return bool
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function setNewPasswordByToken(UserEntity $user, SetPassword $dto): bool
    {
        if (!$user->validatePasswordResetToken($dto->token)) {
            return false;
        }

        // Set new password for user
        $user->hashPassword($dto->password);
        $user->removeResetToken();
        $this->flush();

        return true;
    }
}