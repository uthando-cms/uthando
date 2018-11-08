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
 * Class EditProfile
 * @package Uthando\User\Entity\DTO
 * @Form\Type("Uthando\Core\Form\FormBase")
 * @Form\Name("edit-profile-form")
 */
final class EditProfile extends AbstractDto implements EditUserInterface
{
    /**
     * @var string
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Validator({"name":"EmailAddress"})
     * @Form\Validator({"name":"CoreNoObjectExists", "options":{
     *     "target_class":"Uthando\User\Entity\UserEntity", "fields":"email", "exclude_field":"email", "context_field":"old_email"
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
     * @Form\Name("old_email")
     * @Form\Type("Hidden")
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     */
    public $oldEmail;
}