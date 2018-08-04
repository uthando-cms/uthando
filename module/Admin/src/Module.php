<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Admin
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Admin;


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