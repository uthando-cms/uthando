<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\User\Entity
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

declare(strict_types=1);

namespace Uthando\User\Entity;


use Uthando\Core\Entity\AbstractEntity;
use Uthando\Core\Stdlib\W3cDateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Zend\Math\Rand;


/**
 * This class represents a blog post-admin.
 *
 * @package Uthando\User\Entity
 * @ORM\Entity()
 * @ORM\Cache("NONSTRICT_READ_WRITE", region="uthando")
 * @ORM\Table(name="users")
 * @property string $email
 * @property string $firstname
 * @property string $lastname
 * @property string $password
 * @property bool $status
 * @property W3cDateTime $dateCreated
 * @property string $pwdResetToken
 * @property W3cDateTime $pwdResetTokenCreationDate
 * @property ArrayCollection $posts
 */
class UserEntity extends AbstractEntity
{
    const STATUS_INACTIVE   = false;
    const STATUS_ACTIVE     = true;

    /**
     * @ORM\Column(type="string", length=128, unique=true)
     */
    protected $email;

    /**
     * @ORM\Column(name="firstname", type="string", length=512)
     */
    protected $firstname;

    /**
     * @ORM\Column(name="lastname", type="string", length=512)
     */
    protected $lastname;

    /**
     * @ORM\Column(type="string", length=256)
     */
    protected $password;

    /**
     * @ORM\Column(type="boolean", options={"default":true})
     */
    protected $status = self::STATUS_INACTIVE;

    /**
     * @ORM\Column(name="date_created", type="w3cdatetime", length=25)
     */
    protected $dateCreated;

    /**
     * @ORM\Column(name="pwd_reset_token", type="string", length=32, nullable=true, options={"default":NULL})
     */
    protected $pwdResetToken;

    /**
     * @ORM\Column(name="pwd_reset_token_creation_date", type="w3cdatetime", length=25, nullable=true, options={"default":NULL})
     */
    protected $pwdResetTokenCreationDate;

    /**
     * @param UserEntity $user
     * @param string $inputPassword
     * @return bool
     */
    public static function verifyPassword(UserEntity $user, string $inputPassword): bool
    {
        $verified = password_verify($inputPassword, $user->password);
        return $verified;
    }

    /**
     * UserEntity constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->id           = Uuid::uuid4();
        $this->dateCreated  = new W3cDateTime('now');
    }

    /**
     * @return string
     */
    public function status(): string
    {
        return ($this->status) ? 'Active' : 'Inactive';
    }

    /**
     * @return string
     */
    public function toFullName(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function hashPassword(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * @param string $password
     * @return bool
     */
    public function checkPasswordHash(string $password): bool
    {
        if (password_needs_rehash($this->password, PASSWORD_DEFAULT)) {
            $this->hashPassword($password);
            return true;
        }

        return false;
    }

    /**
     * Generate password reset token and return token.
     *
     * @return string
     */
    public function generateResetToken(): string
    {
        $token                              = Rand::getString(32, '0123456789abcdefghijklmnopqrstuvwxyz');
        $this->pwdResetToken                = password_hash($token, PASSWORD_DEFAULT);
        $this->pwdResetTokenCreationDate    = new W3cDateTime('now');

        return $token;
    }

    /**
     * Validate token and check that token was created not too long ago.
     *
     * @param $passwordResetToken
     * @return bool
     */
    public function validatePasswordResetToken($passwordResetToken): bool
    {
        if (!password_verify($passwordResetToken, $this->pwdResetToken)) {
            return false; // mismatch
        }

        $tokenCreationDate  = $this->pwdResetTokenCreationDate;
        $currentDate        = new W3cDateTime('now');

        if (($currentDate->getTimestamp() - $tokenCreationDate->getTimestamp()) > 24*60*60) {
            return false; // expired
        }

        return true;
    }

    /**
     * Reset token and token date.
     */
    public function removeResetToken(): void
    {
        $this->pwdResetToken                = null;
        $this->pwdResetTokenCreationDate    = null;
    }
}