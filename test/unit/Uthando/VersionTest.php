<?php
/**
 * Uthando CMS (http://www.shaunfreeman.name/)
 *
 * @package   UthandoUnitTest
 * @author    Shaun Freeman
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.name)
 * @date      22/07/18
 * @license   see LICENSE
 */

declare(strict_types=1);

namespace UthandoUnitTest;


use Uthando\Version;
use PHPUnit\Framework\TestCase;

class VersionTest extends TestCase
{
    public function testGetVersion()
    {
        $this->assertTrue(is_string(Version::getVersion()), '"VERSION" should be a string');
    }
}
