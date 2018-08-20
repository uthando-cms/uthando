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
use Uthando\Admin\Service\Factory\NavigationFactory;
use PHPUnit\Framework\TestCase;

class NavigationFactoryTest extends TestCase
{
    public function testAdminIsReturnedAsName()
    {
        $nav    = new NavigationFactory();
        $class  = new ReflectionClass($nav);
        $method = $class->getMethod('getName');

        $method->setAccessible(true);

        $this->assertSame('admin', $method->invoke($nav));
    }
}
