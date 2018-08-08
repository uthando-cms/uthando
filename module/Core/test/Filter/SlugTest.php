<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   CoreTest\Filter
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace CoreTest\Filter;

use Core\Filter\Seo;
use PHPUnit\Framework\TestCase;
use Zend\Filter\StaticFilter;

class SlugTest extends TestCase
{

    public function testFilter()
    {
        $string = 'This Is a Non normalised @ & String';
        $slug   = StaticFilter::execute($string, Seo::class);

        $this->assertSame('this-is-a-non-normalised-and-string', $slug);
    }
}
