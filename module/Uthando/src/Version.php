<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.name/)
 *
 * @package   Uthando
 * @author    Shaun Freeman
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.name)
 * @date      22/07/18
 * @license   see LICENSE
 */

namespace Uthando;


final class Version
{
    const VERSION = '3.0.0-dev';

    /**
     * returns current version
     *
     * @return string
     */
    public static function getVersion(): string
    {
        return self::VERSION;
    }
}
