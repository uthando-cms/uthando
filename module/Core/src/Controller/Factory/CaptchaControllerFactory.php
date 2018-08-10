<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Core\Controller\Factory
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Core\Controller\Factory;


use Core\Controller\CaptchaController;
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
        $options    = $config['uthando_core']['captcha'];

        return new CaptchaController($options);

    }
}