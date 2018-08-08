<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Core\Form
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Core\Form;


use Core\Validator\NoObjectExists;
use Zend\Form\Element\Csrf;
use Zend\Form\Form;
use Zend\Hydrator\ClassMethods;

class FormBase extends Form
{
    public function init(): void
    {
        $this->add([
            'name' => 'csrf',
            'type' => Csrf::class
        ]);
    }

    public function noRecordExists($repository, $field, $excludeValue = false): void
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