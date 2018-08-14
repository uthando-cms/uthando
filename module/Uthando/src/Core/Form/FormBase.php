<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\Core\Form
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Uthando\Core\Form;


use Uthando\Core\Entity\AbstractDto;
use Zend\Form\Element\Csrf;
use Zend\Form\Form;
use Zend\Form\FormInterface;
use Zend\Hydrator\ClassMethods;

/**
 * Class FormBase
 * @package Uthando\Core\Form
 * @method AbstractDto getData($flag = FormInterface::VALUES_NORMALIZED)
 */
class FormBase extends Form
{
    public function __construct($name = null, array $options = [])
    {
        $this->setHydrator(new ClassMethods());
        parent::__construct($name, $options);
    }

    public function init(): void
    {
        $this->add([
            'name' => 'csrf',
            'type' => Csrf::class
        ]);
    }
}