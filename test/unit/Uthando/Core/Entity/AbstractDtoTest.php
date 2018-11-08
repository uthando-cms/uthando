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

use Ramsey\Uuid\Uuid;
use Uthando\Core\Entity\AbstractDto;
use PHPUnit\Framework\TestCase;

class AbstractDtoTest extends TestCase
{
    public function testCanAccessProperties()
    {
        $dto = new class extends AbstractDto {
            public $id;
        };

        $dto->setId(Uuid::uuid4());

        $this->assertInstanceOf(Uuid::class, $dto->id);
    }

    public function testArrayCopyReturnsArray()
    {
        $dto = new class extends AbstractDto {
            public $id;
        };

        $dto->setId(Uuid::uuid4());

        $this->assertInternalType('array', $dto->getArrayCopy());
        $this->assertArrayHasKey('id', $dto->getArrayCopy());
    }
}
