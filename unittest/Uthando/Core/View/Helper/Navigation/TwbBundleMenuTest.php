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
