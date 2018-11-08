<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\Blog\Form
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

declare(strict_types=1);

namespace Uthando\Blog\Form;


use Uthando\Blog\Entity\PostEntity;
use Uthando\Core\Form\FormBase;
use Zend\Form\Form;
use Zend\Form\FormInterface;

/**
 * Class PostForm
 *
 * @package Uthando\Blog\Form
 * @method PostEntity getData($flag = FormInterface::VALUES_NORMALIZED)
 */
final class PostForm extends FormBase
{
    /**
     * @param array|\ArrayAccess|\Traversable $data
     * @return Form
     */
    public function setData($data)
    {
        $data = $this->checkSeo($data);
        return parent::setData($data);
    }

    /**
     * Check to see if seo is empty, if it is use title for value.
     * @param array $data
     * @return array
     */
    private function checkSeo($data): array
    {
        if ('' == $data['seo']) {
            $data['seo'] = $data['title'];
        }

        return $data;
    }
}