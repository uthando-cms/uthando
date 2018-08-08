<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   User\Entity
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace User\Entity;


use Core\Entity\AbstractEntity;
use Core\Stdlib\W3cDateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Zend\Form\Annotation as Form;

/**
 * This class represents a blog post-admin.
 *
 * @package User\Entity
 * @ORM\Entity()
 * @ORM\Cache("NONSTRICT_READ_WRITE", region="uthando")
 * @ORM\Table(name="users")
 * @Form\Type("Core\Form\FormBase")
 * @Form\Name("user-form")
 * @property string $email
 * @property string $fullName
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
     * @ORM\Column(type="string", length=128)
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Validator({"name":"EmailAddress", "options":{"allow":255}})
     * @Form\Attributes({"type":"email"})
     * @Form\Options({"label":"Email:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}})
     */
    protected $email;

    /**
     * @ORM\Column(name="full_name", type="string", length=512)
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Validator({"name":"StringLength", "options":{"max":512}})
     * @Form\Attributes({"type":"text"})
     * @Form\Options({"label":"FullName:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}})
     */
    protected $fullName;

    /**
     * @ORM\Column(type="string", length=256)
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Validator({"name":"StringLength", "options":{"max":256}})
     * @Form\Attributes({"type":"password"})
     * @Form\Options({"label":"Password:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}})
     */
    protected $password;

    /**
     * @ORM\Column(type="boolean", options={"default":true})
     * @Form\AllowEmpty()
     * @Form\Filter({"name":"Boolean", "options":{"type":"zero"}})
     * @Form\Type("Zend\Form\Element\Select")
     * @Form\Options({"label":"Status:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}, "value_options":{"0":"Inactive","1":"Active"}})
     */
    protected $status = self::STATUS_INACTIVE;

    /**
     * @ORM\Column(name="date_modified", type="w3cdatetime", length=25)
     * @Form\Exclude()
     */
    protected $dateCreated;

    /**
     * @ORM\Column(name="pwd_reset_token", type="string", length=32)
     * @Form\Exclude()
     */
    protected $pwdResetToken;

    /**
     * @ORM\Column(name="pwd_reset_token_creation_date", type="w3cdatetime", length=25)
     * @Form\Exclude()
     */
    protected $pwdResetTokenCreationDate;

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
}