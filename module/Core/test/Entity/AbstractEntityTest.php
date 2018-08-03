<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   CoreTest\Entity
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace CoreTest\Entity;

use Core\Entity\AbstractEntity;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class AbstractEntityTest extends TestCase
{
    public function test__get__set()
    {
        $mock = $this->getMockForAbstractClass(AbstractEntity::class);

        $mock->id = 1;
        $this->assertSame(1, $mock->id);

    }

    /**
     * @expectedException \Exception
     */
    public function testInvalid__get()
    {
        $mock = $this->getMockForAbstractClass(AbstractEntity::class);

        $value = $mock->sameUnsetProperty;

    }

    public function testGetArrayCopy()
    {
        $mock = $this->getMockForAbstractClass(AbstractEntity::class);
        $mock->id = 1;

        $this->assertArrayHasKey('id', $mock->getArrayCopy());
    }

    public function test__call()
    {
        $mock = $this->getMockForAbstractClass(AbstractEntity::class);

        $mock->setId(Uuid::uuid4());

        $this->assertInstanceOf(Uuid::class, $mock->getId());

    }

    public function test__toString()
    {
        $mock = $this->getMockForAbstractClass(AbstractEntity::class);
        $mock->id = Uuid::uuid4();

        $this->assertInternalType('string', (string) $mock);
    }
}
