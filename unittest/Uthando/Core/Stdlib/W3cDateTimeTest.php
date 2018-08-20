<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoTest\Core\Stdlib
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoTest\Core\Stdlib;

use Uthando\Core\Stdlib\W3cDateTime;
use PHPUnit\Framework\TestCase;

class W3cDateTimeTest extends TestCase
{

    public function testCanCastDateToString()
    {
        $date = new W3cDateTime('now');
        $this->assertInternalType('string', (string) $date);
    }

    public function testCanCastToStringViaToStringMethod()
    {
        $date = new \DateTime('now');
        $format = $date->format(DATE_W3C);

        $testDate = new W3cDateTime($format);

        $this->assertSame($format, $testDate->toString());
    }
}
