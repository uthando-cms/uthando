<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Core\Validator
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Core\Validator;


use Doctrine\ORM\EntityRepository;
use DoctrineModule\Validator\NoObjectExists as DoctrineNoObjectExists;

/**
 * Class NoObjectExists
 * @package Core\Validator
 * @property EntityRepository $objectRepository
 */
class NoObjectExists extends DoctrineNoObjectExists
{
    /**
     * @var bool
     */
    protected $excludeValue = false;

    public function __construct($options = null)
    {
        $this->excludeValue = (bool) $options['exclude_value'] ?? false ;
        parent::__construct($options);
    }

    /**
     * @param $value
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     */
    public function isValid($value)
    {
        $cleanedValue = $this->cleanSearchValue($value);

        $queryBuilder = $this->objectRepository->createQueryBuilder('p');
        $expr = $queryBuilder->expr();
        $and = $expr->andX();

        foreach ($cleanedValue as $key => $value) {
            $and->add($expr->eq('p.'.$key, ':'.$key));

            if ($this->excludeValue) {
                $and->add($expr->not($expr->eq('p.'.$key, ':'.$key)));
            }
        }

        $queryBuilder->where($and)
            ->setParameters($cleanedValue);

        $match = $queryBuilder->getQuery()->getOneOrNullResult();

        if (is_object($match)) {
            $this->error(self::ERROR_OBJECT_FOUND, $value);

            return false;
        }

        return true;
    }
}