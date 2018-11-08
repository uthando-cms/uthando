<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\Blog\Repository
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

declare(strict_types=1);

namespace Uthando\Blog\Repository;


use Uthando\Blog\Entity\PostEntity;
use Uthando\Blog\Entity\TagEntity;
use Doctrine\ORM\EntityRepository;

/**
 * Class PostRepository
 * @package Uthando\Blog\Repository
 * @method PostEntity findOneBy(array $criteria, array $orderBy = null)
 */
class PostRepository extends EntityRepository
{
    /**
     * @param $tag
     * @return mixed
     */
    public function findPostsByTagName($tag)
    {
        $queryBuilder   = $this->createQueryBuilder('p');

        $queryBuilder
            ->join('p.tags', 't')
            ->where('p.status = :status')
            ->andWhere('t.seo = :seo')
            ->orderBy('p.dateCreated', 'DESC')
            ->setParameter('status', PostEntity::STATUS_PUBLISHED)
            ->setParameter('seo', $tag);

        $posts = $queryBuilder
            ->getQuery()
            ->useQueryCache(true)
            ->useResultCache(true, 300, 'post-tags')
            ->getResult();

        return $posts;
    }

    /**
     * Optimised call for tag cloud.
     *
     * @return mixed
     */
    public function fetchTagCount()
    {
        $entityManager  = $this->getEntityManager();
        $queryBuilder   = $entityManager->createQueryBuilder();

        $queryBuilder->select('t.name, t.seo, COUNT(t) AS count')
            ->from(TagEntity::class, 't')
            ->join('t.posts', 'p')
            ->groupBy('t.name, t.seo')
            ->orderBy('t.name', 'ASC')
            ->where('p.status =?1')
            ->setParameter('1', PostEntity::STATUS_PUBLISHED);

        $posts = $queryBuilder
            ->getQuery()
            ->useQueryCache(true)
            ->useResultCache(true, 300, 'post-tags')
            ->getResult();

        return $posts;
    }
}