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
 * Class Login
 * @package Uthando\User\Entity\DTO
 * @Form\Type("Uthando\Core\Form\FormBase")
 * @Form\Name("login-form")
 */
class Login extends AbstractDto
{
    /**
     * @var string
     * @Form\Attributes({"placeholder":"E-mail Address"})
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Type("Email")
     * @Form\Options({"column-size":"sm-12"})
     * @Form\Validator({"name":"EmailAddress"})
     */
    public $email;
    
    /**
     * @var string
     * @Form\Attributes({"placeholder":"Password"})
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Options({"column-size":"sm-12"})
     * @Form\Type("Password")
     * @Form\Validator({"name":"StringLength", "options":{"min":8, "max":16}})
     */
    public $password;

    /**
     * @var bool
     * @Form\AllowEmpty()
     * @Form\Filter({"name":"Boolean", "options":{"type":"zero"}})
     * @Form\Name("remember_me")
     * @Form\Options({"label":"Remember me", "column-size":"sm-12", "use_hidden_element":true, "checked_value":1, "unchecked_value":0})
     * @Form\Type("Checkbox")
     */
    public $rememberMe;

    /**
     * @var string
     * @Form\AllowEmpty()
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Name("redirect_url")
     * @Form\Type("Hidden")
     * @Form\Validator({"name":"StringLength", "options":{"min":0, "max":2048}})
     */
    public $redirectUrl;
}