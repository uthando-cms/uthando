<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\User\Entity\DTO
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

declare(strict_types=1);

namespace Uthando\User\Entity\DTO;


use Uthando\Core\Entity\AbstractDto;
use Zend\Form\Annotation as Form;

/**
 * Class SetPassword
 * @package Uthando\User\Entity\DTO
 * @Form\Type("Uthando\Core\Form\FormBase")
 * @Form\Name("reset-password-form")
 */
class SetPassword extends AbstractDto
{
    /**
     * @var string
     *
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Validator({"name":"StringLength", "options":{"min":8, "max":16}})
     * @Form\Type("Password")
     * @Form\Options({"label":"New password:", "column-size":"sm-8", "label_attributes":{"class":"col-sm-4"}})
     */
    public $password;

    /**
     * @var string
     *
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Name("confirm_password")
     * @Form\Validator({"name":"StringLength", "options":{"min":8, "max":16}})
     * @Form\Validator({"name":"Identical", "options":{"token":"new_password"}})
     * @Form\Type("Password")
     * @Form\Options({"label":"Confirm password:", "column-size":"sm-8", "label_attributes":{"class":"col-sm-4"}})
     */
    public $confirmPassword;

    /**
     * @var string
     *
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Validator({"name":"StringLength", "options":{"min":32, "max":32}})
     * @Form\Type("Hidden")
     */
    public $token;

    /**
     * @var string
     *
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Validator({"name":"EmailAddress"})
     * @Form\Validator({"name":"DoctrineObjectExists", "options":{"target_class":"Uthando\User\Entity\UserEntity", "fields":"email"}})
     * @Form\Type("Hidden")
     */
    public $email;
}