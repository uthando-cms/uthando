<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoTest\Core\Entity
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoTest\Core\Entity;

use Ramsey\Uuid\Uuid;
use Uthando\Core\Entity\AbstractDto;
use PHPUnit\Framework\TestCase;

class AbstractDtoTest extends TestCase
{
    public function testCanAccessProperties()
    {
        $dto = $this->getMockForAbstractClass(AbstractDto::class);
        $dto->setId(Uuid::uuid4());

        $this->assertInstanceOf(Uuid::class, $dto->getId());
    }

    public function testArrayCopyReturnsArray()
    {
        $dto = $this->getMockForAbstractClass(AbstractDto::class);
        $dto->setId(Uuid::uuid4());

        $this->assertInternalType('array', $dto->getArrayCopy());
        $this->assertArrayHasKey('id', $dto->getArrayCopy());
    }
}
