<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\Core\Stdlib
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

declare(strict_types=1);

namespace Uthando\Core\Stdlib;


final class W3cDateTime extends \DateTime
{
    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->format(DATE_W3C);
    }
}