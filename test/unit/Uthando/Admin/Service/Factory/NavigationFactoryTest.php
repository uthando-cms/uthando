<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUnitTest\Admin\Service\Factory
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

declare(strict_types=1);

namespace UthandoUnitTest\Admin\Service\Factory;

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
