<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   BlogTest\Entity
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace BlogTest\Entity;

use Blog\Entity\PostEntity;
use PHPUnit\Framework\TestCase;

class PostEntityTest extends TestCase
{
    private $testData = [
        'title'     => 'Test Title',
        'seo'       => 'test-title',
        'content'   => 'Test Content',
    ];

    public function testPublish()
    {
        $post = new PostEntity();

    }

    public function testFromFormData()
    {

    }

    public function testCompose()
    {

    }

    public function testGetArrayCopy()
    {

    }

    public function testAddComment()
    {

    }

    public function testRemoveTagAssociation()
    {

    }

    public function test__toString()
    {

    }

    public function testAddTag()
    {

    }

    public function test__construct()
    {

    }

    public function testUpdate()
    {

    }
}
