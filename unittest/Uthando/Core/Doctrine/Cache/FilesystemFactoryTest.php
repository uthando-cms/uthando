<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoTest\Core\Doctrine\Cache
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoTest\Core\Doctrine\Cache;


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
