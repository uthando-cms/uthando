<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoTest\Core\View\Helper\Navigation
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoTest\Core\View\Helper\Navigation;


use Interop\Container\ContainerInterface;
use Uthando\Core\View\Helper\Navigation\PluginManager;
use PHPUnit\Framework\TestCase;
use Uthando\Core\View\Helper\Navigation\TwbBundleMenu;
use Zend\ServiceManager\Factory\InvokableFactory;

class PluginManagerTest extends TestCase
{
    public function testAliasesAreSet()
    {
        $container      = $this->prophesize(ContainerInterface::class)->reveal();
        $pluginManager  = new PluginManager($container);
        $reflection     = new \ReflectionClass($pluginManager);

        $aliases = $reflection->getProperty('aliases');
        $aliases->setAccessible(true);

        $aliases = $aliases->getValue($pluginManager);

        $this->assertSame($aliases['twbmenu'], TwbBundleMenu::class);
        $this->assertSame($aliases['twbMenu'], TwbBundleMenu::class);

    }

    public function testFactoriesAreSet()
    {
        $container      = $this->prophesize(ContainerInterface::class)->reveal();
        $pluginManager  = new PluginManager($container);
        $reflection     = new \ReflectionClass($pluginManager);

        $factories = $reflection->getProperty('factories');
        $factories->setAccessible(true);

        $factories = $factories->getValue($pluginManager);

        $this->assertSame($factories[TwbBundleMenu::class], InvokableFactory::class);

    }
}
