<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Core\View\Helper\Navigation
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Core\View\Helper\Navigation;


use Zend\ServiceManager\Factory\InvokableFactory;

class PluginManager extends \Zend\View\Helper\Navigation\PluginManager
{
    public function __construct($configOrContainerInstance = null, array $v3config = [])
    {
        $this->aliases['twbmenu'] = TwbBundleMenu::class;
        $this->aliases['twbMenu'] = TwbBundleMenu::class;

        $this->factories[TwbBundleMenu::class] = InvokableFactory::class;

        parent::__construct($configOrContainerInstance, $v3config);
    }
}