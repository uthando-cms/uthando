<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUnitTest\Core\Doctrine\Cache
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

declare(strict_types=1);

namespace UthandoUnitTest\Core\Doctrine\Cache;


use Doctrine\Common\Cache\FilesystemCache;
use UthandoTest\Framework\TestCase;

class FilesystemFactoryTest extends TestCase
{
    public function testCanGetFromServiceManager()
    {
        $class = $this->moduleLoader->getServiceManager()->get('doctrine.cache.filesystem');

        $this->assertInstanceOf(FilesystemCache::class, $class);
    }
}
