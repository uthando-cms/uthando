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

use Blog\Entity\CommentEntity;
use PHPUnit\Framework\TestCase;

class CommentEntityTest extends TestCase
{
    public function testInitialValues()
    {
        $reflectionComment  = new \ReflectionClass(CommentEntity::class);
        $id                 = $reflectionComment->getProperty('id');
        $postId             = $reflectionComment->getProperty('postId');
        $content            = $reflectionComment->getProperty('content');
        $author             = $reflectionComment->getProperty('author');
        $dateCreated        = $reflectionComment->getProperty('dateCreated');
        $commentEntity      = new CommentEntity();

        $id->setAccessible(true);
        $postId->setAccessible(true);
        $content->setAccessible(true);
        $author->setAccessible(true);
        $dateCreated->setAccessible(true);

        $this->assertNull($id->getValue($commentEntity), '"id" should be null by default.');
        $this->assertNull($postId->getValue($commentEntity), '"postId" should be null by default.');
        $this->assertNull($content->getValue($commentEntity), '"content" should be null by default.');
        $this->assertNull($author->getValue($commentEntity), '"author" should be null by default.');
        $this->assertNull($dateCreated->getValue($commentEntity), '"dateCreated" should be null by default.');
    }

    public function testSetGetId()
    {
        $comment = new CommentEntity();
        $this->assertNull($comment->getId(), '"id" should be able to return null.');

        $id = $comment->setId(1);
        $this->assertInstanceOf(CommentEntity::class, $id, '"setId" method did not return self.');
        $this->assertSame(1, $comment->getId(), '"id" was not set correctly');
    }

    public function testSetGetPostId()
    {
        $comment = new CommentEntity();

        $postId = $comment->setPostId(1);
        $this->assertInstanceOf(CommentEntity::class, $postId, '"setPostId" method did not return self.');
        $this->assertSame(1, $comment->getPostId(), '"postId" was not set correctly');

    }

    public function testSetGetContent()
    {
        $comment = new CommentEntity();

        $content = $comment->setContent('this is content');
        $this->assertInstanceOf(CommentEntity::class, $content, '"setContent" method did not return self.');
        $this->assertSame('this is content', $comment->getContent(), '"content" was not set correctly');
    }

    public function testSetGetAuthor()
    {
        $comment = new CommentEntity();

        $author = $comment->setAuthor('Joe Blogs');
        $this->assertInstanceOf(CommentEntity::class, $author, '"setAuthor" method did not return self.');
        $this->assertSame('Joe Blogs', $comment->getAuthor(), '"author" was not set correctly');
    }

    public function testSetGetDateCreated()
    {
        $comment = new CommentEntity();
        $date  = new \DateTime();
        $date = $date->format('Y-m-d H:i:s');

        $dateCreated = $comment->setDateCreated($date);
        $this->assertInstanceOf(CommentEntity::class, $dateCreated, '"setDateTime" method did not return self.');
        $this->assertSame($date, $dateCreated->getDateCreated(), '"dateTime" should be a string.');
    }
}
