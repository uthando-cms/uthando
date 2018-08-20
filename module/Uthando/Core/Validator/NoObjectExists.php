<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\Core\Validator
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Uthando\Core\Validator;


use Doctrine\ORM\EntityRepository;
use DoctrineModule\Validator\NoObjectExists as DoctrineNoObjectExists;

/**
 * Class NoObjectExists
 * @package Uthando\Core\Validator
 * @property EntityRepository $objectRepository
 */
final class NoObjectExists extends DoctrineNoObjectExists
{
    /**
     * @var string
     */
    protected $excludeField;

    /**
     * @var string
     */
    protected $contextField;

    public function __construct($options = null)
    {
        $this->excludeField = $options['exclude_field'] ?? null;
        $this->contextField = $options['context_field'] ?? null;

        parent::__construct($options);
    }

    /**
     * @param $value
     * @param null $context
     * @return bool
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function isValid($value, $context = null)
    {
        $cleanedValue = $this->cleanSearchValue($value);

        $queryBuilder = $this->objectRepository->createQueryBuilder('p');
        $expr = $queryBuilder->expr();
        $and = $expr->andX();

        foreach ($cleanedValue as $key => $value) {
            $and->add($expr->eq('p.'.$key, ':'.$key));
        }

        if ($this->excludeField) {
            $excludeValue = $context[$this->contextField] ?? $value;
            $and->add($expr->not($expr->eq('p.'.$this->excludeField, ':exclude')));
            $cleanedValue['exclude'] = $excludeValue;
        }

        $queryBuilder->where($and);

        $queryBuilder->setParameters($cleanedValue);

        $match = $queryBuilder->getQuery()->getOneOrNullResult();

        if (is_object($match)) {
            $this->error(self::ERROR_OBJECT_FOUND, $value);

            return false;
        }

        return true;
    }
}