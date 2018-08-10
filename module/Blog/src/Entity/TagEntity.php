<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Blog\Entity
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Blog\Entity;

use Core\Entity\AbstractEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * This class represents a tag related to a blog post-admin.
 *
 * @package Blog\Entity
 * @ORM\Entity
 * @ORM\Cache("NONSTRICT_READ_WRITE", region="uthando")
 * @ORM\Table(name="tags")
 * @property string $name
 * @property ArrayCollection $posts
 */
final class TagEntity extends AbstractEntity
{
    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $seo;

    /**
     * @ORM\Cache("NONSTRICT_READ_WRITE", region="uthando")
     * @ORM\ManyToMany(targetEntity="\Blog\Entity\PostEntity", mappedBy="tags")
     */
    protected $posts;

    /**
     * PostEntity constructor.
     *
     * @param string $name
     * @param string $seo
     * @throws \Exception
     */
    public function __construct(string $name, string $seo)
    {
        $this->id       = Uuid::uuid4();
        $this->name     = $name;
        $this->seo      = $seo;
        $this->posts    = new ArrayCollection();
    }

    /**
     * Adds a post-admin into collection of posts related to this tag.
     *
     * @param PostEntity $post
     */
    public function addPost(PostEntity $post): void
    {
        $this->posts->add($post);
    }

    /**
     * @param PostEntity $post
     */
    public function removePost(PostEntity $post): void
    {
        $this->posts->removeElement($post);
    }
}