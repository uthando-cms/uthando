<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoTest\Admin\Service\Factory
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoTest\Admin\Service\Factory;

use ReflectionClass;
use Uthando\Admin\Service\Factory\NavigationDashboardFactory;
use PHPUnit\Framework\TestCase;

class NavigationDashboardFactoryTest extends TestCase
{
    public function testDashboardIsReturnedAsName()
    {
        $nav    = new NavigationDashboardFactory();
        $class  = new ReflectionClass($nav);
        $method = $class->getMethod('getName');

        $method->setAccessible(true);

        $this->assertSame('dashboard', $method->invoke($nav));
    }
}
