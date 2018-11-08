<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\Core\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

declare(strict_types=1);

namespace Uthando\Core\Service;

/**
 * Trait ManagerDoctrineFlushTrait
 * @package Uthando\Core\Service
 * @property \Doctrine\ORM\EntityManager entityManager
 */
trait ManagerDoctrineFlushTrait
{
    /**
     * @var array
     */
    protected $tags = [];

    /**
     * Clears the cache
     *
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    protected function flush(): void
    {
        $this->entityManager->flush();
        $this->entityManager->clear();
        $cacheDriver = $this->entityManager->getConfiguration()->getResultCacheImpl();

        foreach ($this->tags as $tag) {
            $cacheDriver->delete($tag);
        }
    }
}