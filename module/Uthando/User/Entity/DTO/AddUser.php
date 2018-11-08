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
use Uthando\User\Entity\UserEntity;
use Zend\Form\Annotation as Form;

/**
 * Class AddUser
 * @package Uthando\User\Entity\DTO
 * @Form\Type("Uthando\Core\Form\FormBase")
 * @Form\Name("add-user-form")
 */
final class AddUser extends AbstractDto
{
    /**
     * @var string
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Validator({"name":"EmailAddress"})
     * @Form\Validator({"name":"DoctrineNoObjectExists", "options":{
     *     "target_class":"Uthando\User\Entity\UserEntity", "fields":"email",
     *     }})
     * @Form\Type("Email")
     * @Form\Options({"label":"Email:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}})
     */
    public $email;

    /**
     * @var string
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Validator({"name":"StringLength", "options":{"max":512}})
     * @Form\Type("Text")
     * @Form\Options({"label":"Firstname:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}})
     */
    public $firstname;

    /**
     * @var string
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Validator({"name":"StringLength", "options":{"max":512}})
     * @Form\Type("Text")
     * @Form\Options({"label":"Lastname:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}})
     */
    public $lastname;

    /**
     * @var string
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Validator({"name":"StringLength", "options":{"min":8, "max":16}})
     * @Form\Type("Password")
     * @Form\Options({"label":"Password:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}})
     */
    public $password;

    /**
     * @var string
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Name("confirm_password")
     * @Form\Validator({"name":"StringLength", "options":{"min":8, "max":16}})
     * @Form\Validator({"name":"Identical", "options":{"token":"password"}})
     * @Form\Type("Password")
     * @Form\Options({"label":"Confirm password:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}})
     */
    public $confirmPassword;

    /**
     * @var bool
     * @Form\AllowEmpty()
     * @Form\Filter({"name":"Boolean", "options":{"type":"zero"}})
     * @Form\Type("Select")
     * @Form\Options({"label":"Status:", "column-size":"sm-10", "label_attributes":{
     *     "class":"col-sm-2"}, "value_options":{"0":"Inactive","1":"Active"}
     *     })
     */
    public $status = UserEntity::STATUS_INACTIVE;
}