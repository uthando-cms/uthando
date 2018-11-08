<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUnitTest\Core\Stdlib
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

declare(strict_types=1);

namespace UthandoUnitTest\Core\Stdlib;

use Uthando\Core\Stdlib\W3cDateTime;
use PHPUnit\Framework\TestCase;

class W3cDateTimeTest extends TestCase
{
    public function testCanCastToStringViaToStringMethod()
    {
        $date = new \DateTime('now');
        $format = $date->format(DATE_W3C);

        $testDate = new W3cDateTime($format);

        $this->assertSame($format, $testDate->toString());
    }
}
