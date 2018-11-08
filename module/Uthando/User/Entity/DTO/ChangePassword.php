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
 * Class ChangePassword
 * @package Uthando\User\Entity\DTO
 * @Form\Type("Uthando\Core\Form\FormBase")
 * @Form\Name("change-password-form")
 */
class ChangePassword extends AbstractDto
{
    /**
     * @var string
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Name("old_password")
     * @Form\Validator({"name":"StringLength", "options":{"min":8, "max":16}})
     * @Form\Type("Password")
     * @Form\Options({"label":"Old password:", "column-size":"sm-8", "label_attributes":{"class":"col-sm-4"}})
     */
    public $oldPassword;

    /**
     * @var string
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Name("new_password")
     * @Form\Validator({"name":"StringLength", "options":{"min":8, "max":16}})
     * @Form\Type("Password")
     * @Form\Options({"label":"New password:", "column-size":"sm-8", "label_attributes":{"class":"col-sm-4"}})
     */
    public $newPassword;

    /**
     * @var string
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Name("confirm_new_password")
     * @Form\Validator({"name":"StringLength", "options":{"min":8, "max":16}})
     * @Form\Validator({"name":"Identical", "options":{"token":"new_password"}})
     * @Form\Type("Password")
     * @Form\Options({"label":"Confirm password:", "column-size":"sm-8", "label_attributes":{"class":"col-sm-4"}})
     */
    public $confirmNewPassword;
}