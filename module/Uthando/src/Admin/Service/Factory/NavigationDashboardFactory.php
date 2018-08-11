<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\Admin\Service\Factory
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Uthando\Admin\Service\Factory;


use Zend\Navigation\Service\AbstractNavigationFactory;

class NavigationDashboardFactory extends AbstractNavigationFactory
{

    /**
     * @return string
     */
    protected function getName()
    {
        return 'dashboard';
    }
}