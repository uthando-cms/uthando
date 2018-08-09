<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   User\Entity\DTO
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace User\Entity\DTO;


use Core\Entity\AbstractDto;
use User\Entity\UserEntity;
use Zend\Form\Annotation as Form;

/**
 * Class EditUser
 * @package User\Entity\DTO
 * @Form\Type("Core\Form\FormBase")
 * @Form\Name("edit-user-form")
 */
final class EditUser extends AbstractDto
{
    /**
     * @var string
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Validator({"name":"EmailAddress"})
     * @Form\Validator({"name":"NoObjectExists", "options":{
     *     "object_repository":"User\Entity\UserEntity", "fields":"email", "exclude_value":true
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