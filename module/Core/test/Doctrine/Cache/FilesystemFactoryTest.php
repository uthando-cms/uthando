<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   CoreTest\Doctrine\Cache
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace CoreTest\Doctrine\Cache;

use Doctrine\Common\Cache\FilesystemCache;
use PHPUnit\Framework\TestCase;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\Util\ModuleLoader;

class FilesystemFactoryTest extends TestCase
{
    public function test__invoke()
    {
        $moduleLoader = new ModuleLoader(ArrayUtils::merge(
            include __DIR__ . '/../../../../../config/application.config.php',
            []
        ));

        $class = $moduleLoader->getServiceManager()->get('doctrine.cache.filesystem');

        $this->assertInstanceOf(FilesystemCache::class, $class);
    }
}
