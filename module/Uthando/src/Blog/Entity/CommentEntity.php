<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\Blog\Entity
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Uthando\Blog\Entity;


use Uthando\Core\Entity\AbstractEntity;
use Uthando\Core\Stdlib\W3cDateTime;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * This class represents a comment related to a blog post-admin.
 *
 * @ORM\Entity
 * @ORM\Cache("NONSTRICT_READ_WRITE", region="uthando")
 * @ORM\Table(name="comments")
 * @property PostEntity $post
 * @property string $content
 * @property string $author
 * @property W3cDateTime $dateCreated
 */
class CommentEntity extends AbstractEntity
{
    /**
     * @ORM\Cache("NONSTRICT_READ_WRITE", region="uthando")
     * @ORM\ManyToOne(targetEntity="Uthando\Blog\Entity\PostEntity", inversedBy="comments")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    protected $post;

    /**
     * @ORM\Column(type="string")
     */
    protected $author;

    /**
     * @ORM\Column(type="text")
     */
    protected $content;

    /**
     * @ORM\Column(name="date_created", type="w3cdatetime", length=25)
     */
    protected $dateCreated;

    /**
     * PostEntity constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $this->id           = Uuid::uuid4();
        $this->dateCreated  = new W3cDateTime('now');
    }
}