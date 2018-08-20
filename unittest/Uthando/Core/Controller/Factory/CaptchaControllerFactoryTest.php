<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoTest\Core\Controller\Factory
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoTest\Core\Controller\Factory;

use Interop\Container\ContainerInterface;
use Uthando\Core\Controller\CaptchaController;
use Uthando\Core\Controller\Factory\CaptchaControllerFactory;
use PHPUnit\Framework\TestCase;

class CaptchaControllerFactoryTest extends TestCase
{
    public function testFactoryReturnsInstanceOfCaptchaController()
    {
        $factory    = new CaptchaControllerFactory();
        $container  = $this->prophesize(ContainerInterface::class);

        $container->get('config')->willReturn([]);

        $this->assertInstanceOf(
            CaptchaController::class,
            $factory($container->reveal(), CaptchaController::class)
        );
    }
}
