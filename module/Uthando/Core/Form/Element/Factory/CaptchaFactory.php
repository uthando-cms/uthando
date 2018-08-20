<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\Core\Form\Element\Factory
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Uthando\Core\Form\Element\Factory;


use Uthando\Core\Form\Element\Captcha;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

final class CaptchaFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $options                = [];
        $parts                  = explode('\\', $requestedName);
        $name                   = strtolower(array_pop($parts));
        $plugins                = $container->get('ViewHelperManager');
        $options['url_helper']  = $plugins->get('url');
        $options['config']      = $container->get('config')['uthando']['captcha'];

        return new Captcha($name, $options);
    }
}