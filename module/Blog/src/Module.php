<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.name/)
 *
 * @package   Blog
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.name)
 * @date      19/07/17
 * @license   see LICENSE
 */

namespace Blog;

/**
 * Class Module
 *
 * @package Blog
 */
class Module
{
    /**
     *
     * @return array
     */
    public function getConfig() : array
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
