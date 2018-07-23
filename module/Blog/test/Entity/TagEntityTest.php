<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.name/)
 *
 * @package   BlogTest\Entity
 * @author    Shaun Freeman
 * @copyright Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.name)
 * @date      25/07/17
 * @license   see LICENSE
 */

namespace BlogTest\Entity;

use Blog\Entity\TagEntity;
use PHPUnit\Framework\TestCase;

class TagEntityTest extends TestCase
{
    public function testInitialValues()
    {
        $reflectionTag  = new \ReflectionClass(TagEntity::class);
        $id             = $reflectionTag->getProperty('id');
        $name           = $reflectionTag->getProperty('name');
        $tagEntity      = new TagEntity();

        $id->setAccessible(true);
        $name->setAccessible(true);

        $this->assertNull($id->getValue($tagEntity), '"id" should be null by default.');
        $this->assertNull($id->getValue($tagEntity), '"name" should be null by default.');
    }

    public function testSetGetId()
    {
        $tagEntity = new TagEntity();
        $this->assertNull($tagEntity->getId(), '"id" should be able to return null.');

        $id = $tagEntity->setId(1);
        $this->assertInstanceOf(TagEntity::class, $id, '"setId" method did not return self.');
        $this->assertSame(1, $tagEntity->getId(), '"id" was not set correctly');
    }

    public function testSetGetName()
    {
        $tagEntity = new TagEntity();

        $name = $tagEntity->setName('PHP');
        $this->assertInstanceOf(TagEntity::class, $name, '"setName" method did not return self.');
        $this->assertSame('PHP', $tagEntity->getName(), '"name" was not set correctly');
    }
}
