<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Core\Entity
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Core\Entity;


abstract class AbstractDto
{
    /**
     * @return array
     */
    final public function getArrayCopy(): array
    {
        return get_object_vars($this);
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    final public function __call($name, $arguments)
    {
        $var = lcfirst(substr($name, 3));

        if (strncasecmp($name, "get", 3) === 0) {
            return $this->$var;
        }

        if (strncasecmp($name, "set", 3) === 0) {
            $this->$var = $arguments[0];
        }
    }
}