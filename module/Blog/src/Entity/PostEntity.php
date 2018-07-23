<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.name/)
 *
 * @package   Blog\Entity
 * @author    Shaun Freeman
 * @copyright Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.name)
 * @date      19/07/17
 * @license   see LICENSE
 */

namespace Blog\Entity;

class PostEntity
{
    const STATUS_DRAFT      = 0;
    const STATUS_PUBLISHED  = 1;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $seo;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var int
     */
    protected $status = self::STATUS_DRAFT;

    /**
     * @var CommentCollection
     */
    protected $comments;

    /**
     * @var TagCollection
     */
    protected $tags;

    /**
     * @var string
     */
    protected $dateCreated;

    /**
     * @var string
     */
    protected $dateModified;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return PostEntity
     */
    public function setId(int $id): PostEntity
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return PostEntity
     */
    public function setTitle(string $title): PostEntity
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getSeo(): string
    {
        return $this->seo;
    }

    /**
     * @param string $seo
     * @return PostEntity
     */
    public function setSeo(string $seo): PostEntity
    {
        $this->seo = $seo;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return PostEntity
     */
    public function setContent(string $content): PostEntity
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return PostEntity
     */
    public function setStatus(int $status): PostEntity
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return CommentCollection
     */
    public function getComments(): CommentCollection
    {
        return $this->comments;
    }

    /**
     * @param CommentCollection $comments
     * @return PostEntity
     */
    public function setComments(CommentCollection $comments): PostEntity
    {
        $this->comments = $comments;
        return $this;
    }

    /**
     * @return TagCollection
     */
    public function getTags(): TagCollection
    {
        return $this->tags;
    }

    /**
     * @param TagCollection $tags
     * @return PostEntity
     */
    public function setTags(TagCollection $tags): PostEntity
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @return string
     */
    public function getDateCreated(): string
    {
        return $this->dateCreated;
    }

    /**
     * @param string $dateCreated
     * @return PostEntity
     */
    public function setDateCreated(string $dateCreated): PostEntity
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * @return string
     */
    public function getDateModified(): string
    {
        return $this->dateModified;
    }

    /**
     * @param string $dateModified
     * @return PostEntity
     */
    public function setDateModified(string $dateModified): PostEntity
    {
        $this->dateModified = $dateModified;
        return $this;
    }

}
