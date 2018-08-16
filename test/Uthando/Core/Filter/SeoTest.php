<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoTest\Core\Filter
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoTest\Core\Filter;

use Uthando\Core\Filter\Seo;
use PHPUnit\Framework\TestCase;
use Zend\Filter\StaticFilter;

class SeoTest extends TestCase
{

    public function testFilter()
    {
        $string = 'This Is a Non normalised @ & String';
        $slug   = StaticFilter::execute($string, Seo::class);

        $this->assertSame('this-is-a-non-normalised-and-string', $slug);
    }
}
