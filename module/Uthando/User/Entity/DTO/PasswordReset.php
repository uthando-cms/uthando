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
 * Class PasswordReset
 * @package Uthando\User\Entity\DTO
 * @Form\Type("Uthando\Core\Form\FormBase")
 * @Form\Name("password-reset-form")
 */
class PasswordReset extends AbstractDto
{
    /**
     * @var string
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Validator({"name":"EmailAddress"})
     * @Form\Validator({"name":"DoctrineObjectExists", "options":{
     *     "target_class":"Uthando\User\Entity\UserEntity", "fields":"email"
     *     }})
     * @Form\Type("Email")
     * @Form\Options({"column-size":"sm-12"})
     * @Form\Attributes({"placeholder":"E-mail Address"})
     */
    public $email;

    /**
     * @var string
     * @Form\Type("CoreCaptcha")
     * @Form\Options({"column-size":"sm-12", "help-block":"Enter the letters above as you see them."})
     * @Form\Attributes({"placeholder":"Type letters and number here"})
     */
    public $captcha;
}