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
        if ($options === null) {
            $options = [];
        }

        if (isset($options['name'])) {
            $name = $options['name'];
        } else {
            // 'Zend\Form\Element' -> 'element'
            $parts = explode('\\', $requestedName);
            $name = strtolower(array_pop($parts));
        }

        if (isset($options['options'])) {
            $options = $options['options'];
        }

        $plugins                = $container->get('ViewHelperManager');
        $options['url_helper']  = $plugins->get('url');
        $options['config']      = $container->get('config')['uthando']['captcha'];

        return new Captcha($name, $options);
    }
}