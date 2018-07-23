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

class CommentEntity
{
    protected $id;

    protected $postId;

    protected $content;

    protected $author;

    protected $dateCreated;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): CommentEntity
    {
        $this->id = $id;
        return $this;
    }

    public function getPostId(): int
    {
        return $this->postId;
    }

    public function setPostId(int $postId): CommentEntity
    {
        $this->postId = $postId;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): CommentEntity
    {
        $this->content = $content;
        return $this;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): CommentEntity
    {
        $this->author = $author;
        return $this;
    }

    public function getDateCreated(): string
    {
        return $this->dateCreated;
    }

    public function setDateCreated(string $dateCreated): CommentEntity
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }
}
