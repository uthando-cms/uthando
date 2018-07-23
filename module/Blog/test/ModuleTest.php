<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.name/)
 *
 * @package   BlogTest
 * @author    Shaun Freeman
 * @copyright Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.name)
 * @date      25/07/17
 * @license   see LICENSE
 */

namespace BlogTest;

use Blog\Module;
use PHPUnit\Framework\TestCase;

class ModuleTest extends TestCase
{
    public function testGetConfigReturnsArray()
    {
        $module = new Module();
        $this->assertTrue(is_array($module->getConfig()));
    }
}
