<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUnitTest\Core\View
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

declare(strict_types=1);

namespace UthandoUnitTest\Core\View;

use Interop\Container\ContainerInterface;
use Uthando\Core\View\Helper\Navigation;
use Uthando\Core\View\NavigationHelperFactory;
use PHPUnit\Framework\TestCase;

class NavigationHelperFactoryTest extends TestCase
{
    public function testWillReturnNavigationHelper()
    {
        $container = $this->prophesize(ContainerInterface::class);
        $factory = new NavigationHelperFactory();
        $helper = $factory($container->reveal(), Navigation::class);

        $this->assertInstanceOf(Navigation::class, $helper);
    }
}
