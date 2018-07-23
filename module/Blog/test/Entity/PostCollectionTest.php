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

use Blog\Entity\PostCollection;
use PHPUnit\Framework\TestCase;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;

class PostCollectionTest extends TestCase
{
    public function testInitialValues()
    {
        $postCollection = new PostCollection(new ArrayAdapter());
        $this->assertInstanceOf(Paginator::class, $postCollection);
    }
}
