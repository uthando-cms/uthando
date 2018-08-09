<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Core\Form
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Core\Form;


use Zend\Form\Element\Csrf;
use Zend\Form\Form;
use Zend\Hydrator\ClassMethods;

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