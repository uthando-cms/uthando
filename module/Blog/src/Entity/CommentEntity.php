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


use Core\Stdlib\W3cDateTime;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Zend\Form\Annotation as Form;

/**
 * This class represents a comment related to a blog post.
 *
 * @ORM\Entity
 * @ORM\Table(name="comments")
 * @Form\Name("comment")
 * @Form\Hydrator("Zend\Hydrator\ArraySerializable")
 */
final class CommentEntity
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
     * @ORM\Column(type="text")
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Attributes({"type":"textarea"})
     * @Form\Options({"label":"Content:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}})
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Validator({"name":"StringLength", "options":{"min":1, "max":255}})
     * @Form\Attributes({"type":"text"})
     * @Form\Options({"label":"Author:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}})
     */
    private $author;

    /**
     * @var W3cDateTime
     *
     * @ORM\Column(name="date_created", type="w3cdatetime", length=25)
     * @Form\Exclude()
     */
    protected $dateCreated;

    /**
     * @ORM\ManyToOne(targetEntity="\Blog\Entity\PostEntity", inversedBy="comments")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    private $post;

    /**
     * PostEntity constructor.
     *
     * @param string $content
     * @param string $author
     * @param PostEntity $post
     * @throws \Exception
     */
    public function __construct(string $content, string $author, PostEntity $post)
    {
        $this->id           = Uuid::uuid4();
        $this->dateCreated  = new W3cDateTime('now');
        $this->content      = $content;
        $this->author       = $author;

        $post->addComment($this);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->id->toString();
    }

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy(): array
    {
        $array                  = [];
        $array['id']            = $this->id;
        $array['content']       = $this->content;
        $array['author']        = $this->author;
        $array['date_created']  = $this->dateCreated;
        $array['post_id']       = $this->post;

        return $array;
    }
}