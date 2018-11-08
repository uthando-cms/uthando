<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\Core\Entity
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

declare(strict_types=1);

namespace Uthando\Core\Entity;


abstract class AbstractDto implements DtoInterface
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

        if (0 === strncasecmp($name, "set", 3)) {
            $this->$var = $arguments[0];
        }
    }
}