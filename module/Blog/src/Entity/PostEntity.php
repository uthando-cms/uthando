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


use Core\Stdlib\W3cDateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Zend\Form\Annotation as Form;
use Zend\Form\Form as ZendForm;

/**
 * This class represents a blog post.
 *
 * @package Blog\Entity
 * @ORM\Entity
 * @ORM\Table(name="posts")
 * @Form\Name("post")
 * @Form\Hydrator("Zend\Hydrator\ArraySerializable")
 */
final class PostEntity
{
    const STATUS_DRAFT      = 0;
    const STATUS_PUBLISHED  = 1;

    /**
     * @var UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     * @Form\Exclude()
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(type="boolean", options={"default":0})
     * @Form\Type("Zend\Form\Element\Select")
     * @Form\Options({"label":"Status:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}, "value_options":{"0":"Draft","1":"Published"}})
     */
    private $status = self::STATUS_DRAFT;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Validator({"name":"StringLength", "options":{"min":1, "max":255}})
     * @Form\Attributes({"type":"text"})
     * @Form\Options({"label":"Title:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}})
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Validator({"name":"StringLength", "options":{"min":1, "max":255}})
     * @Form\Attributes({"type":"text"})
     * @Form\Options({"label":"Seo:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}})
     */
    private $seo;

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
     * @var W3cDateTime
     *
     * @ORM\Column(name="date_created", type="w3cdatetime", length=25)
     * @Form\Exclude()
     */
    private $dateCreated;

    /**
     * @var W3cDateTime
     *
     * @ORM\Column(name="date_modified", type="w3cdatetime", length=25)
     * @Form\Exclude()
     */
    private $dateModified;

    /**
     * @ORM\OneToMany(targetEntity="\Blog\Entity\CommentEntity", mappedBy="posts")
     * @ORM\JoinColumn(name="id", referencedColumnName="post_id")
     */
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity="\Blog\Entity\TagEntity", inversedBy="posts")
     * @ORM\JoinTable(name="post_tag",
     *      joinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
     *      )
     */
    private $tags;

    /**
     * @param ZendForm $form
     * @return PostEntity
     * @throws \Exception
     */
    public static function FromFormData(ZendForm $form): PostEntity
    {
        $data = $form->getData();
        $post = new PostEntity();
        $post->compose($data['title'], $data['seo'], $data['content']);
        return $post;
    }

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
     * @return string
     */
    public function __toString(): string
    {
       return $this->id->toString();
    }

    /**
     * Publish post
     */
    public function publish(): void
    {
        $this->status       = self::STATUS_PUBLISHED;
        $this->dateCreated  = new W3cDateTime('now');
        $this->dateModified = new W3cDateTime('now');
    }

    /**
     * Compose post
     *
     * @param string $title
     * @param string $seo
     * @param string $content
     */
    public function compose(string $title, string $seo, string $content): void
    {
        $this->title    = $title;
        $this->seo      = $seo;
        $this->content  = $content;
    }

    /**
     * Update post
     */
    public function update(): void
    {
        $this->dateModified = new W3cDateTime('now');
    }

    /**
     * Adds a new comment to post.
     *
     * @param $comment
     */
    public function addComment($comment): void
    {
        $this->comments[] = $comment;
    }

    /**
     * Adds a new comment to post.
     *
     * @param $tag
     */
    public function addTag($tag): void
    {
        $this->tags[] = $tag;
    }

    /**
     * Removes association between this post and the given tag.
     *
     * @param $tag
     */
    public function removeTagAssociation($tag): void
    {
        $this->tags->removeElement($tag);
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
        $array['title']         = $this->title;
        $array['seo']           = $this->seo;
        $array['content']       = $this->content;
        $array['status']        = $this->status;
        $array['date_created']  = $this->dateCreated;
        $array['date_modified'] = $this->dateModified;
        $array['comments']      = $this->comments;
        $array['tags']          = $this->tags;

        return $array;
    }
}
