<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\Core\Options\Factory
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

declare(strict_types=1);

namespace Uthando\Core\Options\Factory;


use Interop\Container\ContainerInterface;
use Uthando\Core\Options\MailOptions;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class MailOptionsFactory
 *
 * @package Uthando\Core\Options\Factory
 */
class MailOptionsFactory implements FactoryInterface
{
    /**
     * Creates Mail options object
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return MailOptions
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): MailOptions
    {
        $config = $container->get('config');
        $options = (isset($config['uthando']['mail'])) ? $config['uthando']['mail'] : [];

        return new MailOptions($options);
    }
}
