<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.name/)
 *
 * @package   Uthando\Blog\Entity
 * @author    Shaun Freeman
 * @copyright Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.name)
 * @date      19/07/17
 * @license   see LICENSE
 */

namespace Uthando\Blog\Entity;


use Uthando\Core\Entity\AbstractEntity;
use Uthando\Core\Stdlib\W3cDateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Ramsey\Uuid\Uuid;
use Uthando\User\Entity\UserEntity;

/**
 * This class represents a blog post-admin.
 *
 * @package Uthando\Blog\Entity
 * @ORM\Entity
 * @ORM\Cache("NONSTRICT_READ_WRITE", region="uthando")
 * @ORM\Table(name="posts")
 * @property bool $status
 * @property string $title
 * @property string $seo
 * @property string $content
 * @property W3cDateTime $dateCreated
 * @property W3cDateTime $dateModified
 * @property ArrayCollection $comments
 * @property ArrayCollection $tags
 * @property string $newTags
 * @property UserEntity $user
 */
class PostEntity extends AbstractEntity
{
    const STATUS_DRAFT      = false;
    const STATUS_PUBLISHED  = true;

    /**
     * @ORM\Column(type="boolean", options={"default":true})
     */
    protected $status = self::STATUS_DRAFT;

    /**
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $seo;

    /**
     * @ORM\Column(type="text")
     */
    protected $content;

    /**
     * @ORM\Column(name="date_created", type="w3cdatetime", length=25)
     */
    protected $dateCreated;

    /**
     * @ORM\Column(name="date_modified", type="w3cdatetime", length=25)
     */
    protected $dateModified;

    /**
     * @ORM\Cache("NONSTRICT_READ_WRITE", region="uthando")
     * @ORM\OneToMany(targetEntity="Uthando\Blog\Entity\CommentEntity", mappedBy="post", cascade={"persist"})
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    protected $comments;

    /**
     * @ORM\Cache("NONSTRICT_READ_WRITE", region="uthando")
     * @ORM\ManyToMany(targetEntity="Uthando\Blog\Entity\TagEntity", inversedBy="posts", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="post_tag",
     *      joinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
     *      )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    protected $tags;

    /**
     * PostEntity constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $this->id           = Uuid::uuid4();
        $this->dateCreated  = new W3cDateTime('now');
        $this->dateModified = new W3cDateTime('now');
        $this->comments     = new ArrayCollection();
        $this->tags         = new ArrayCollection();
    }

    /**
     * Update post dates
     * @param bool $status
     */
    public function updateDates(bool $status): void
    {
        if ($status !== $this->status && $status === self::STATUS_PUBLISHED) {
            $this->dateCreated  = new W3cDateTime('now');
            $this->dateModified = new W3cDateTime('now');
        }  else {
            $this->dateModified = new W3cDateTime('now');
        }
    }

    /**
     * @return string
     */
    public function status(): string
    {
        return ($this->status) ? 'Published' : 'Draft';
    }

    /**
     * @return ArrayCollection|PersistentCollection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param ArrayCollection|array $comments
     */
    public function addComments($comments): void
    {
        foreach ($comments as $comment) {
            $this->comments->add($comment);
        }
    }

    /**
     * @return ArrayCollection|PersistentCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Adds a new comment to post-admin.
     *
     * @param $tags
     */
    public function addTags($tags): void
    {
        /** @var TagEntity $tag */
        foreach ($tags as $tag) {
            $tag->addPost($this);
            $this->tags->add($tag);
        }
    }

    /**
     * Removes association between this post-admin and the given tag.
     *
     * @param $tags
     */
    public function removeTags($tags): void
    {
        /** @var TagEntity $tag */
        foreach ($tags as $tag) {
            $tag->removePost($this);
            $this->tags->removeElement($tag);
        }
    }
}
