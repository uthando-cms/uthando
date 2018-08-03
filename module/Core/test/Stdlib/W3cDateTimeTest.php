<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   CoreTest\Stdlib
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace CoreTest\Stdlib;

use Core\Stdlib\W3cDateTime;
use PHPUnit\Framework\TestCase;

class W3cDateTimeTest extends TestCase
{

    public function test__toString()
    {
        $date = new W3cDateTime('now');
        $this->assertInternalType('string', (string) $date);
    }

    public function testToString()
    {
        $date = new \DateTime('now');
        $format = $date->format(DATE_W3C);

        $testDate = new W3cDateTime($format);

        $this->assertSame($format, $testDate->toString());
    }
}
