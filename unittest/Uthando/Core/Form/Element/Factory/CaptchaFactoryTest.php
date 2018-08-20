<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoTest\Core\Form\Element\Factory
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoTest\Core\Form\Element\Factory;

use Interop\Container\ContainerInterface;
use Uthando\Core\Form\Element\Captcha;
use Uthando\Core\Form\Element\Factory\CaptchaFactory;
use PHPUnit\Framework\TestCase;
use Zend\ServiceManager\PluginManagerInterface;
use Zend\View\Helper\Url;

class CaptchaFactoryTest extends TestCase
{
    public function testCaptchaElemetIsReturned()
    {
        $options = [
            'uthando' => [
                'captcha' => [],
            ],
        ];
        $container          = $this->prophesize(ContainerInterface::class);
        $viewHelperManager  = $this->prophesize(PluginManagerInterface::class);
        $url                = $this->prophesize(Url::class);

        $container->get('ViewHelperManager')->willReturn($viewHelperManager->reveal());
        $viewHelperManager->get('url')->willReturn($url->reveal());
        $container->get('config')->willReturn($options);

        $factory = new CaptchaFactory();
        $captcha = $factory($container->reveal(), Captcha::class);

        $this->assertInstanceOf(Captcha::class, $captcha);
    }
}
