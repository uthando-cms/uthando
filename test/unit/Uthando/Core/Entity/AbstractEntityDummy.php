<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUnitTest\Core\Entity
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

declare(strict_types=1);

namespace UthandoUnitTest\Core\Entity;


use Uthando\Core\Entity\AbstractEntity;
use Ramsey\Uuid\Uuid;

class AbstractEntityDummy extends AbstractEntity
{
    public function __construct()
    {
        $this->id = Uuid::uuid4();
    }
}