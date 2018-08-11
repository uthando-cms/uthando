<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoTest\Blog\Entity
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoTest\Blog\Entity;

use Uthando\Blog\Entity\CommentEntity;
use Uthando\Blog\Entity\PostEntity;
use Uthando\Blog\Entity\TagEntity;
use Uthando\Core\Stdlib\W3cDateTime;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class PostEntityTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testCancreateEntityWithDefaultValues()
    {
        $post = new PostEntity();
        $this->assertInstanceOf(PostEntity::class, $post);
        $this->assertInstanceOf(Uuid::class, $post->id);
        $this->assertInstanceOf(W3cDateTime::class, $post->dateCreated);
        $this->assertInstanceOf(W3cDateTime::class, $post->dateModified);
        $this->assertInstanceOf(ArrayCollection::class, $post->comments);
        $this->assertInstanceOf(ArrayCollection::class, $post->tags);
    }

    /**
     * @throws \Exception
     */
    public function testCanUpdateDatesOnStatusChange()
    {
        /*$post = new PostEntity();
        $dateCreated = new W3cDateTime('2000/10/12');
        $dateModified = new W3cDateTime('2001/10/12');
        $post->dateCreated = $dateCreated;
        $post->dateModified = $dateModified;

        $post->updateDates(PostEntity::STATUS_PUBLISHED);

        $this->assertNotSame($dateCreated->toString(), $post->dateCreated->toString());
        $this->assertNotSame($dateModified->toString(), $post->dateModified->toString());

        $post->dateCreated = $dateCreated;
        $post->dateModified = $dateModified;
        $post->updateDates(PostEntity::STATUS_DRAFT);

        $this->assertSame($dateCreated->toString(), $post->dateCreated->toString());
        $this->assertNotSame($dateModified->toString(), $post->dateModified->toString());*/
    }

    /**
     * @throws \Exception
     */
    public function testCanGetStatusString()
    {
        $post = new PostEntity();
        $this->assertSame('Draft', $post->status());
    }

    public function testGetCommentsReturnsArrayCollection()
    {
        $post = new PostEntity();
        $this->assertInstanceOf(ArrayCollection::class, $post->getComments());
    }

    public function testGetTagsReturnsArrayCollection()
    {
        $post = new PostEntity();
        $this->assertInstanceOf(ArrayCollection::class, $post->getTags());
    }

    public function testCanAddComments()
    {
        $post = new PostEntity();
        $comment = new CommentEntity();
        $post->addComments([$comment]);
        $this->assertTrue($post->comments->contains($comment));
    }

    public function testCanAddTags()
    {
        $post = new PostEntity();
        $tag = new TagEntity('tag', 'tag');
        $post->addTags([$tag]);
        $this->assertTrue($post->tags->contains($tag));
    }

    public function testCanRemoveTags()
    {
        $post = new PostEntity();
        $tag = new TagEntity('tag', 'tag');
        $post->addTags([$tag]);
        $post->removeTags([$tag]);
        $this->assertTrue($post->tags->isEmpty());
        ;
    }
}
