<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Blog\Service\Factory
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Admin\Service\Factory;


use Zend\Navigation\Service\AbstractNavigationFactory;

class NavigationFactory extends AbstractNavigationFactory
{
    protected function getName(): string
    {
        return 'admin';
    }
}