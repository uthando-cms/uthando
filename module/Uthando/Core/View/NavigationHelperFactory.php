<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\Core\View
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Uthando\Core\View;


use Interop\Container\ContainerInterface;
use Uthando\Core\View\Helper\Navigation as NavigationHelper;

final class NavigationHelperFactory extends \Zend\Navigation\View\NavigationHelperFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $helper = new NavigationHelper();
        $helper->setServiceLocator($container);
        return $helper;
    }
}