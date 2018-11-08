<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUnitTest\Core\Form
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

declare(strict_types=1);

namespace UthandoUnitTest\Core\Form;

use Uthando\Core\Form\FormBase;
use PHPUnit\Framework\TestCase;
use Zend\Form\Element\Csrf;
use Zend\Hydrator\ClassMethods;

class FormBaseTest extends TestCase
{
    public function testClassMethodsHydratorIsSet()
    {
        $form = new FormBase();
        $this->assertInstanceOf(ClassMethods::class, $form->getHydrator());
    }

    public function testCsrfIsSetOnInitialisingObject()
    {
        $form = new FormBase();
        $form->init();

        $this->assertTrue($form->has('csrf'));
        $this->assertInstanceOf(Csrf::class, $form->get('csrf'));
    }
}
