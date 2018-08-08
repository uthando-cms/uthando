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


use Core\Entity\AbstractEntity;
use Core\Stdlib\W3cDateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Ramsey\Uuid\Uuid;
use User\Entity\UserEntity;
use Zend\Form\Annotation as Form;

/**
 * This class represents a blog post-admin.
 *
 * @package Blog\Entity
 * @ORM\Entity(repositoryClass="Blog\Repository\PostRepository")
 * @ORM\Cache("NONSTRICT_READ_WRITE", region="uthando")
 * @ORM\Table(name="posts")
 * @Form\Type("Blog\Form\PostForm")
 * @Form\Name("post-form")
 * @property int $status
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
final class PostEntity extends AbstractEntity
{
    const STATUS_DRAFT      = false;
    const STATUS_PUBLISHED  = true;

    /**
     * @ORM\Column(type="boolean", options={"default":true})
     * @Form\AllowEmpty()
     * @Form\Filter({"name":"Boolean", "options":{"type":"zero"}})
     * @Form\Type("Zend\Form\Element\Select")
     * @Form\Options({"label":"Status:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}, "value_options":{"0":"Draft","1":"Published"}})
     */
    protected $status = self::STATUS_DRAFT;

    /**
     * @ORM\Column(type="string")
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Validator({"name":"StringLength", "options":{"max":255}})
     * @Form\Attributes({"type":"text"})
     * @Form\Options({"label":"Title:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}})
     */
    protected $title;

    /**
     * @ORM\Column(type="string", unique=true)
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Filter({"name":"Core\Filter\Seo"})
     * @Form\Validator({"name":"StringLength", "options":{"max":255}})
     * @Form\Attributes({"type":"text"})
     * @Form\Options({"label":"Seo:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}})
     */
    protected $seo;

    /**
     * @ORM\Column(type="text")
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Attributes({"type":"textarea"})
     * @Form\Options({"label":"Content:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}})
     */
    protected $content;

    /**
     * @ORM\Column(name="date_created", type="w3cdatetime", length=25)
     * @Form\Exclude()
     */
    protected $dateCreated;

    /**
     * @ORM\Column(name="date_modified", type="w3cdatetime", length=25)
     * @Form\Exclude()
     */
    protected $dateModified;

    /**
     * @ORM\Cache("NONSTRICT_READ_WRITE", region="uthando")
     * @ORM\OneToMany(targetEntity="\Blog\Entity\CommentEntity", mappedBy="post", cascade={"persist"}, fetch="EXTRA_LAZY")
     * @ORM\OrderBy({"dateCreated" = "DESC"})
     * @Form\Exclude()
     */
    protected $comments;

    /**
     * @ORM\Cache("NONSTRICT_READ_WRITE", region="uthando")
     * @ORM\ManyToMany(targetEntity="\Blog\Entity\TagEntity", inversedBy="posts", cascade={"persist", "remove"}, fetch="EXTRA_LAZY")
     * @ORM\JoinTable(name="post_tag",
     *      joinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
     *      )
     * @ORM\OrderBy({"name" = "ASC"})
     * @Form\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Form\Options({"label":"Tags: ", "target_class": "Blog\Entity\TagEntity", "property": "name",
     *     "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}})
     * @Form\Attributes({"multiple" : "multiple"})
     */
    protected $tags;

    /**
     * @Form\AllowEmpty()
     * @Form\Attributes({"type":"text"})
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Options({"label":"New tags:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}})
     * @Form\Validator({"name":"StringLength", "options":{"min":1, "max":255}})
     */
    protected $newTags;

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
     * Update post-admin
     * @param array $data
     */
    public function updateDates(array $data): void
    {
        if ($data['status'] !== $this->status && $data['status'] === self::STATUS_PUBLISHED) {
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
