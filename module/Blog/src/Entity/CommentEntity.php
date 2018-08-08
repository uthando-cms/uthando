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
use Core\Stdlib\W3cDateTime;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Zend\Form\Annotation as Form;

/**
 * This class represents a comment related to a blog post-admin.
 *
 * @ORM\Entity
 * @ORM\Cache("NONSTRICT_READ_WRITE", region="uthando")
 * @ORM\Table(name="comments")
 * @Form\Attributes({"class":"comments"})
 * @Form\Name("comment-form")
 * @Form\Type("Core\Form\FormBase")
 * @property PostEntity $post-admin
 * @property string $content
 * @property string $author
 * @property W3cDateTime $dateCreated
 */
final class CommentEntity extends AbstractEntity
{
    /**
     * @ORM\Cache("NONSTRICT_READ_WRITE", region="uthando")
     * @ORM\ManyToOne(targetEntity="\Blog\Entity\PostEntity", inversedBy="comments")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     * @Form\Exclude()
     */
    protected $post;

    /**
     * @ORM\Column(type="string")
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Validator({"name":"StringLength", "options":{"max":255}})
     * @Form\Attributes({"type":"string"})
     * @Form\Options({"label":"Author:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}})
     */
    protected $author;

    /**
     *@Form\Attributes({"type":"textarea"})
     * @ORM\Column(type="text")
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Validator({"name":"StringLength", "options":{"max":4096}})
     * @Form\Options({"label":"Content:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}})
     */
    protected $content;

    /**
     * @ORM\Column(name="date_created", type="w3cdatetime", length=25)
     * @Form\Exclude()
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