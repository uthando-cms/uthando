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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Zend\Form\Annotation as Form;
use Zend\Form\Form as ZendForm;

/**
 * This class represents a tag related to a blog post.
 *
 * @package Blog\Entity
 * @ORM\Entity
 * @ORM\Table(name="tags")
 * @Form\Name("tag")
 * @Form\Hydrator("Zend\Hydrator\ArraySerializable")
 */
final class TagEntity
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     * @Form\Exclude()
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Validator({"name":"StringLength", "options":{"min":1, "max":255}})
     * @Form\Attributes({"type":"text"})
     * @Form\Options({"label":"Name:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}})
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="\Blog\Entity\PostEntity", mappedBy="tags")
     */
    private $posts;

    /**
     * @param ZendForm $form
     * @return TagEntity
     * @throws \Exception
     */
    public static function FromFormData(ZendForm $form): TagEntity
    {
        $data = $form->getData();
        $model = new TagEntity($data['name']);
        return $model;
    }

    /**
     * PostEntity constructor.
     *
     * @param string $name
     * @throws \Exception
     */
    public function __construct(string $name)
    {
        $this->id       = Uuid::uuid4();
        $this->posts    = new ArrayCollection();
        $this->name     = $name;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->id->toString();
    }

    /**
     * Adds a post into collection of posts related to this tag.
     *
     * @param PostEntity $post
     */
    public function addPost(PostEntity $post): void
    {
        $this->posts[] = $post;
    }

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy(): array
    {
        $array          = [];
        $array['id']    = $this->id;
        $array['name']  = $this->name;
        $array['posts'] = $this->posts;

        return $array;
    }
}