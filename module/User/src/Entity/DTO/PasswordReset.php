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
use Zend\Form\Annotation as Form;


/**
 * Class PasswordReset
 * @package User\Entity\DTO
 * @Form\Type("Core\Form\FormBase")
 * @Form\Name("password-reset-form")
 */
class PasswordReset
{
    /**
     * @var string
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Validator({"name":"EmailAddress"})
     * @Form\Validator({"name":"DoctrineObjectExists", "options":{
     *     "target_class":"User\Entity\UserEntity", "fields":"email"
     *     }})
     * @Form\Type("Email")
     * @Form\Options({"label":"Email:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}})
     */
    public $email;

    /**
     * @var string
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Type("CoreCaptcha")
     * @Form\Options({"label":"Human check:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}})
     */
    public $captcha;
}