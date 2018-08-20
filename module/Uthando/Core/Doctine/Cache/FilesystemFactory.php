<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\Core\Doctine\Cache
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Uthando\Core\Doctine\Cache;


use Doctrine\Common\Cache\FilesystemCache;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

final class FilesystemFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return FilesystemCache
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $filesystemCache = new FilesystemCache('./data/cache/doctrine');

        return $filesystemCache;
    }
}