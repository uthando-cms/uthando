<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUnitTest\Core\View\Helper\Navigation
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

declare(strict_types=1);

namespace UthandoUnitTest\Core\View\Helper\Navigation;


use Uthando\Core\View\Helper\Navigation\TwbBundleMenu;
use PHPUnit\Framework\TestCase;

class TwbBundleMenuTest extends TestCase
{
    public function testUlClassDefaultIsSet()
    {
        $menu = new TwbBundleMenu();
        $this->assertSame('nav', $menu->getUlClass());
    }
}
