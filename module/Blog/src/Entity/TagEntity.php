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
use Zend\Form\Annotation as Form;

/**
 * This class represents a tag related to a blog post.
 *
 * @package Blog\Entity
 * @ORM\Entity
 * @ORM\Cache("NONSTRICT_READ_WRITE", region="uthando")
 * @ORM\Table(name="tags")
 * @Form\Name("tag-form")
 * @Form\Hydrator("Zend\Hydrator\ArraySerializable")
 * @property string $name
 * @property ArrayCollection $posts
 */
class TagEntity extends AbstractEntity
{
    /**
     * @ORM\Column(type="string")
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Validator({"name":"StringLength", "options":{"max":255}})
     * @Form\Attributes({"type":"text"})
     * @Form\Options({"label":"Name:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}})
     */
    protected $name;

    /**
     * @ORM\Column(type="string", unique=true)
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Filter({"name":"Core\Filter\Slug"})
     * @Form\Validator({"name":"StringLength", "options":{"max":255}})
     * @Form\Attributes({"type":"text"})
     * @Form\Options({"label":"Seo:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}})
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
     * Adds a post into collection of posts related to this tag.
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