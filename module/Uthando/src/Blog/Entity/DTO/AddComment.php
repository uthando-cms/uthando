<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\Blog\Entity\DTO
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Uthando\Blog\Entity\DTO;


use Uthando\Core\Entity\AbstractDto;
use Zend\Form\Annotation as Form;

/**
 * Class AddComment
 * @package Uthando\Blog\Entity\DTO
 * @Form\Attributes({"class":"comments"})
 * @Form\Name("comment-form")
 * @Form\Type("Uthando\Core\Form\FormBase")
 * @property string $content
 * @property string $author
 */
class AddComment extends AbstractDto
{
    /**
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Validator({"name":"StringLength", "options":{"max":255}})
     * @Form\Type("Text")
     * @Form\Options({"label":"Author:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}})
     */
    public $author;

    /**
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Type("Textarea")
     * @Form\Validator({"name":"StringLength", "options":{"max":4096}})
     * @Form\Options({"label":"Content:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}})
     */
    public $content;

    /**
     * @Form\Exclude()
     */
    public $parent;

    /**
     * @Form\Exclude()
     */
    public $post;
}