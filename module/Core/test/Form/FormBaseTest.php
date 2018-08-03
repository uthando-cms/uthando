<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   CoreTest\Form
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace CoreTest\Form;

use Core\Form\FormBase;
use PHPUnit\Framework\TestCase;
use Zend\Form\Element\Csrf;

class FormBaseTest extends TestCase
{

    public function testInit()
    {
        $form = new FormBase();
        $form->init();

        $this->assertTrue($form->has('csrf'));
        $this->assertInstanceOf(Csrf::class, $form->get('csrf'));
    }
}
