<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoTest\Core\View\Helper
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoTest\Core\View\Helper;


use Interop\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;
use Uthando\Core\View\Helper\Navigation;
use Uthando\Core\View\Helper\Navigation\PluginManager;


class NavigationTest extends TestCase
{
    public function testCanGetPluginManager()
    {
        $container = $this->prophesize(ContainerInterface::class);
        $helper = new Navigation();
        $helper->setServiceLocator($container->reveal());

        $this->assertInstanceOf(PluginManager::class, $helper->getPluginManager());
    }
}
