<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Blog\Form
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Blog\Form;


use Blog\Entity\PostEntity;
use Blog\Repository\PostRepository;
use Core\Form\FormBase;
use Core\Validator\NoObjectExists;
use Zend\Form\Form;
use Zend\Form\FormInterface;

/**
 * Class PostForm
 *
 * @package Blog\Form
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
        if ($data['seo'] == '') {
            $data['seo'] = $data['title'];
        }

        return $data;
    }

    /**
     * @param PostRepository $repository
     * @param string $field
     * @param bool $excludeValue
     */
    public function noRecordExists(PostRepository $repository, string $field, bool $excludeValue = false): void
    {
        $validator = new NoObjectExists([
            // object repository to lookup
            'object_repository' => $repository,
            // fields to match
            'fields' => $field,
            'exclude_value' => $excludeValue,
        ]);

        $this->getInputFilter()
            ->get($field)
            ->getValidatorChain()
            ->prependValidator($validator);
    }
}