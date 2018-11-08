<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\Core\Controller\Factory
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

declare(strict_types=1);

namespace Uthando\Core\Controller\Factory;


use Uthando\Core\Controller\CaptchaController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class CaptchaControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return CaptchaController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): CaptchaController
    {
        $config     = $container->get('config');
        $options    = $config['uthando']['captcha'] ?? [];

        return new CaptchaController($options);

    }
}