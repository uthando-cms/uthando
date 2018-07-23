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

namespace ApplicationTest\Entity;

use Blog\Entity\CommentCollection;
use PHPUnit\Framework\TestCase;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;

class CommentCollectionTest extends TestCase
{
    public function testInitialValues()
    {
        $commentCollection = new CommentCollection(new ArrayAdapter());
        $this->assertInstanceOf(Paginator::class, $commentCollection);
    }
}

