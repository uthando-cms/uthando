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

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class AbstractEntityTest extends TestCase
{
    /**
     * @var AbstractEntityDummy
     */
    protected $dummy;

    public function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->dummy = new AbstractEntityDummy();
    }

    public function testCanAccessProperties()
    {
        $this->assertInstanceOf(Uuid::class, $this->dummy->id);
    }

    /**
     * @expectedException \Exception
     */
    public function testInvalidGetThrowsException()
    {
        $value = $this->dummy->sameUnsetProperty;

    }

    public function testArrayCopyReturnsArray()
    {
        $this->assertInternalType('array', $this->dummy->getArrayCopy());
    }

    public function testCanCallGetMethods()
    {
        $this->assertInstanceOf(Uuid::class, $this->dummy->getId());

    }

    public function testReturnsStringWhenConvertedToString()
    {
        $this->assertInternalType('string', (string) $this->dummy);
    }
}