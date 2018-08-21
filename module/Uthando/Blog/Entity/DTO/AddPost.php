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


use Uthando\Blog\Entity\PostEntity;
use Uthando\Core\Entity\AbstractDto;
use Zend\Form\Annotation as Form;

/**
 * Class AddPost
 * @package Uthando\Blog\Entity\DTO
 * @Form\Type("Uthando\Blog\Form\PostForm")
 * @Form\Name("add-post-form")
 */
class AddPost extends AbstractDto implements PostDTOInterface
{
    /**
     * @Form\AllowEmpty()
     * @Form\Filter({"name":"Boolean", "options":{"type":"zero"}})
     * @Form\Type("Select")
     * @Form\Options({"label":"Status:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}, "value_options":{"0":"Draft","1":"Published"}})
     */
    public $status = PostEntity::STATUS_DRAFT;

    /**
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Validator({"name":"StringLength", "options":{"max":255}})
     * @Form\Type("Text")
     * @Form\Options({"label":"Title:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}})
     */
    public $title;

    /**
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Filter({"name":"Seo"})
     * @Form\Validator({"name":"StringLength", "options":{"max":255}})
     * @Form\Validator({"name":"DoctrineNoObjectExists", "options":{
     *     "target_class":"Uthando\Blog\Entity\PostEntity", "fields":"seo",
     *     }})
     * @Form\Type("Text")
     * @Form\Options({"label":"Seo:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}})
     */
    public $seo;

    /**
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Type("Textarea")
     * @Form\Options({"label":"Content:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}})
     */
    public $content;


    /**
     * @Form\AllowEmpty()
     * @Form\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Form\Options({"label":"Tags: ", "target_class": "Uthando\Blog\Entity\TagEntity", "property": "name",
     *     "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}})
     * @Form\Attributes({"multiple" : "multiple"})
     */
    public $tags;

    /**
     * @Form\AllowEmpty()
     * @Form\Name("new_tags")
     * @Form\Type("Text")
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Options({"label":"New tags:", "column-size":"sm-10", "label_attributes":{"class":"col-sm-2"}})
     * @Form\Validator({"name":"StringLength", "options":{"min":1, "max":255}})
     */
    public $newTags;
}