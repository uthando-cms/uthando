<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.name/)
 *
 * @package   CoreTest
 * @author    Shaun Freeman
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.name)
 * @date      22/07/18
 * @license   see LICENSE
 */

namespace CoreTest;


use Core\Version;
use PHPUnit\Framework\TestCase;

class VersionTest extends TestCase
{
    public function testGetVersion()
    {
        $this->assertTrue(is_string(Version::getVersion()), '"VERSION" should be a string');
    }
}
