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

use Blog\Entity\CommentCollection;
use Blog\Entity\PostEntity;
use Blog\Entity\TagCollection;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Zend\Paginator\Adapter\ArrayAdapter;

class PostEntityTest extends TestCase
{
    public function testInitialValues()
    {
        $reflectionPost = new \ReflectionClass(PostEntity::class);
        $id             = $reflectionPost->getProperty('id');
        $title          = $reflectionPost->getProperty('title');
        $seo            = $reflectionPost->getProperty('seo');
        $content        = $reflectionPost->getProperty('content');
        $status         = $reflectionPost->getProperty('status');
        $comments       = $reflectionPost->getProperty('comments');
        $tags           = $reflectionPost->getProperty('tags');
        $dateCreated    = $reflectionPost->getProperty('dateCreated');
        $dateModified   = $reflectionPost->getProperty('dateModified');
        $postEntity     = new PostEntity();

        $id->setAccessible(true);
        $title->setAccessible(true);
        $seo->setAccessible(true);
        $content->setAccessible(true);
        $status->setAccessible(true);
        $comments->setAccessible(true);
        $tags->setAccessible(true);
        $dateCreated->setAccessible(true);
        $dateModified->setAccessible(true);

        $this->assertSame(1, PostEntity::STATUS_PUBLISHED, 'Constant "STATUS_PUBLISHED" should equal 1');
        $this->assertSame(0, PostEntity::STATUS_DRAFT, 'Constant "STATUS_DRAFT" should equal 0.');

        $this->assertNull($id->getValue($postEntity), '"id" should be null by default.');
        $this->assertNull($title->getValue($postEntity), '"title" should be null by default.');
        $this->assertNull($seo->getValue($postEntity), '"seo" should be null by default.');
        $this->assertNull($content->getValue($postEntity), '"content" should be null by default.');
        $this->assertSame(PostEntity::STATUS_DRAFT, $status->getValue($postEntity), '"status" should be "PostEntity::STATUS_DRAFT" by default.');
        $this->assertNull($comments->getValue($postEntity), '"comments" should be null by default.');;
        $this->assertNull($tags->getValue($postEntity), '"tags" should be null by default.');
        $this->assertNull($dateCreated->getValue($postEntity), '"dateCreated" should be null by default.');
        $this->assertNull($dateModified->getValue($postEntity), '"dateCreated" should be null by default.');
    }

    public function testSetGetId()
    {
        $post = new PostEntity();

        $id = $post->setId(Uuid::uuid4());
        $this->assertInstanceOf(PostEntity::class, $id, '"setId" method did not return self.');
        $this->assertInstanceOf(UuidInterface::class, $post->getId(), '"id" was not set correctly');
    }

    public function testSetGetTitle()
    {
        $post   = new PostEntity();
        $title  = $post->setTitle('Title of post.');

        $this->assertInstanceOf(PostEntity::class, $title, '"setTitle" method did not return self.');
        $this->assertSame('Title of post.', $post->getTitle(), '"title" was not set correctly');
    }

    public function testSetGetSeo()
    {
        $post   = new PostEntity();
        $seo  = $post->setSeo('seo-url-test');

        $this->assertInstanceOf(PostEntity::class, $seo, '"setSeo" method did not return self.');
        $this->assertSame('seo-url-test', $post->getSeo(), '"seo" was not set correctly');
    }

    public function testSetGetContent()
    {
        $post   = new PostEntity();
        $content  = $post->setContent('<h1>Content of Post</h1>');

        $this->assertInstanceOf(PostEntity::class, $content, '"setContent" method did not return self.');
        $this->assertSame('<h1>Content of Post</h1>', $post->getContent(), '"content" was not set correctly');
    }

    public function testSetGetStatus()
    {
        $post   = new PostEntity();
        $status  = $post->setStatus(PostEntity::STATUS_PUBLISHED);

        $this->assertInstanceOf(PostEntity::class, $status, '"setStatus" method did not return self.');
        $this->assertSame(1, $post->getStatus(), '"status" was not set correctly');
    }

    public function testSetGetComments()
    {
        $post   = new PostEntity();
        $comments  = $post->setComments(new CommentCollection(new ArrayAdapter()));

        $this->assertInstanceOf(PostEntity::class, $comments, '"setComments" method did not return self.');
        $this->assertInstanceOf(
            CommentCollection::class,
             $post->getComments(),
            '"comments" must be an instance of ' . CommentCollection::class
        );
    }

    public function testSetGetTags()
    {
        $post   = new PostEntity();
        $tags  = $post->setTags(new TagCollection(new ArrayAdapter()));

        $this->assertInstanceOf(PostEntity::class, $tags, '"setTags" method did not return self.');
        $this->assertInstanceOf(
            TagCollection::class,
            $post->getTags(),
            '"tags" must be an instance of ' . TagCollection::class
        );
    }

    public function testSetGetDateCreated()
    {
        $post   = new PostEntity();
        $date  = new \DateTime();
        $date = $date->format('Y-m-d H:i:s');
        $dateCreated  = $post->setDateCreated($date);

        $this->assertInstanceOf(PostEntity::class, $dateCreated, '"setDateCreated" method did not return self.');
        $this->assertSame($date, $post->getDateCreated(), '"dateCreated" was not set correctly');
    }

    public function testSetGetDateModified()
    {
        $post   = new PostEntity();
        $date  = new \DateTime();
        $date = $date->format('Y-m-d H:i:s');
        $dateModified  = $post->setDateModified($date);

        $this->assertInstanceOf(PostEntity::class, $dateModified, '"setDateModified" method did not return self.');
        $this->assertSame($date, $post->getDateModified(), '"dateModified" was not set correctly');
    }
}
